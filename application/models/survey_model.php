<?php
class Survey_model extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
    }
       
    function insert_survey()
    {
        $user_id = 1;       
        //INSERT Company Type into User Type table
        $company_array = $this->input->post('company_type');
        //print_r($company_array);
        
        foreach($company_array as $comptype)
        {           
            $data = array(
                'user_id' => $user_id ,
                'type_id' => $comptype ,
            );
            $this->db->insert('user_type', $data);  
            //$this->db->query("INSERT INTO user_type (user_id,type_id) VALUES ('$user_id','$comptype')");
        }
        //END Insert Company Type
        //INSERT Benefits
        $user_benefits_array = $this->input->post('users_benefits');
        foreach($user_benefits_array as $benefits_id=>$user_ranking)
        {
            /*
            echo "benefits_id: $benefits_id <br>";
            echo "user_ranking: $user_ranking[rank] <br>";
            echo "<br><br>";
            */
            $rank = (int) $user_ranking['rank'];
            
            $data = array(
                'user_id' => $user_id ,
                'benefits_id' => $benefits_id ,
                'rank' => $rank
            );
            $this->db->insert('user_benefits', $data);  
        }               
    }
    
    function match_survey()
    {            
        //build arrays of user submitted info from post data
        $type_array = $this->input->post('company_type');
        $pace_array = $this->input->post('company_pace');
        $lifecycle_array = $this->input->post('lifecycle');
        $corp_citizenship = $this->input->post('corp_citizenship');

        //put the values from those arrays into strings so they can be added to the query
        $imploded_type = implode(" OR ", $type_array);
        $imploded_pace = implode(" OR ", $pace_array);
        $imploded_lifecycle = implode(" OR ", $lifecycle_array);

        $sql = 'SELECT id,company_name FROM company where (type_id = '.$imploded_type.')
                    AND (pace_id = '.$imploded_pace.')
                    AND (lifecycle_id = '.$imploded_lifecycle.')
                    AND (corp_citizenship_id = '.$corp_citizenship.')';
        //run the query
        $query = $this->db->query($sql);
        //return $query->result();        
        if ($query->num_rows() > 0)
        {
            //build array of company ids that came from the last query...so we can use them in the upcoming query
            foreach ($query->result_array() as $row) {
                //$companyid_array[]=$row;
                $companyid_array[]=$row['id'];
            }
            $queried_comp_ids = implode(',', $companyid_array);
            
            //get the user submitted benefits ranking
            $user_benefits_array = $this->input->post('users_benefits');   

            //$this->output->enable_profiler(TRUE);
            
            //get all the companies (that meet the previous criteria) and their associated benefits
            $sql2 = 'SELECT company_id,benefits_id FROM company_benefits WHERE company_id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);
            
            //build an array with a specific format to be used in the upcoming scoring process
            $company_set = array();
            foreach ($query2->result_array() as $row) {
                $company_set[$row['company_id']][]=$row['benefits_id'];
            }
            /*
            echo "<br><br>here is company_set:<br>";
            echo "<pre>";
            print_r($company_set);
            echo "</pre>";
            */
            
            $scores = array();
            // For every company, we will assign it a score based on what benefits it has
            // and how the user ranked that benefit.  Higher ranks are more valuable, so the highest
            // total score wins.
            foreach($company_set as $company_id => $array_row)
            {
                $score = 0;
                foreach ($array_row as $key=>$benefit_id)
                {
                    //this line grabs the user's ranking for the benefit_id that this particular company has
                    //and assigns it to the score variable.  this will be added to the scores matrix
                    //and a tally will be kept for each company.
                    $score += $user_benefits_array[$benefit_id]['rank'];
                }
                $scores[$company_id] = $score;

            }
            
            arsort($scores);
            //print_r($scores);
            //reset($scores);
            //$first_key = key($scores);
            //echo "Best score is company id: ".$first_key;
            //Array ( [1] => 88 [3] => 67 [4] => 65 )
            $ranked_comps = array_keys($scores);
            return $ranked_comps;

        } else {
            //echo "<br>from the model: there were no results.";
        }
   
    }
    
    function get_company($ranked_comps)
    { 
        //$this->output->enable_profiler(TRUE);
        if (!empty($ranked_comps)){
            $companyid_array = implode(',', $ranked_comps);
            //this is to make sure we retrieve the companies in the same order as their scores
            $order_array = 'ORDER BY';
            foreach ($ranked_comps as $item) {
              $order_array .= ' id = ' . $item . ' DESC,';
            }
            $order_array = trim($order_array, ',');

            $sql = 'SELECT * FROM company WHERE id IN ('.$companyid_array.') '.$order_array.'';
            $query = $this->db->query($sql);
            return $query->result_array();
        }


    }
    
    function get_distance_matrix($ranked_comps)
    {
        //1. Create array of data points
        //
        //user's benefit score is always perfect, so we know it is the triangular
        //number of the highest ranking 15t=>120.
        //user's citizenship score is in the post data.  Company info is in the database.
        
        $user_benefit_score = 120;
        $user_citizenship = $this->input->post('corp_citizenship');
        //$data_array = array("id"=>"user","benefits"=>120,"citizenship"=>$user_citizenship);
        //array_push($data_array, "4", "45","1");
        $data = array(
            array("id"=>'user', "benefits"=>120, "citizenship"=>1),
            array("id"=>4, "benefits"=>53, "citizenship"=>3),
            array("id"=>3, "benefits"=>45, "citizenship"=>2),
        );        
        
        
        echo "<pre>";
        echo "<br> raw data:<br>";
        print_r($data);
        echo "</pre>";
        //$data_array
       
        
        /*
        foreach ($ranked_comps as $row) {
            //$companyid_array[]=$row;
            $companyid_array[]=$row['id'];
        }        
        */
        
        //2. Transform data into coordinates
        $data_array = $data;
        //normalize citizenship data
        foreach ($data_array as &$row)
        {
            $row['citizenship']=($row['citizenship']-1)/(5-1);
        }
        echo "<pre>";
        echo "<br> normalized data:<br>";
        print_r($data_array);
        echo "</pre>";        

        /*
        function testFunction(&$item,$key,$prefix)
        {
            echo $prefix;
            
        }    
         * 
         */    
        
        //3. Calculate distance for each variable
        /**
         * Calculates eucilean distances for an array dataset
         *
         * @param array $sourceCoords In format array(x, y)
         * @param array $sourceKey Associated array key
         * @param array $data 
         * @return array Of distances to the rest of the data set
         */
        function euclideanDistance(&$sourceCoords, $sourceKey, $data)
        {   
            //echo "HIIII!!!";
            $distances = array();
            list ($x1, $y1) = $sourceCoords;
            foreach ($data as $destinationKey => $destinationCoords) {
                // Same point, ignore
                if ($sourceKey == $destinationKey) {
                    continue;
                }
                list ($x2, $y2) = $destinationCoords;
                $distances[$destinationKey] = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2));
                //echo "<br>x1: $x1<br>";
            }
            asort($distances);
            $sourceCoords = $distances;
        }   
        
        function city_block_distance(&$sourceCoords,$sourceKey)
        {
            //=+ABS($A19-D$16)
            //list($x1, $y1) = $sourceCoords;
            //echo "x: $x1";
                    echo "<pre>";
        echo "<br> source coords data:<br>";
        print_r($sourceCoords);
        echo "</pre>"; 
            echo $sourceCoords['id'];
        $distances = array();
        //echo "sourcekey: ".$sourceKey;
            
        
        }
        
        
        
        array_walk($data_array, 'city_block_distance',$data);   
        //array_walk($data_array, 'testFunction', 'hey');
        

        
        echo "<pre>";
        echo "<br> distance data:<br>";
        print_r($data_array);
        echo "</pre>"; 
        

        
        
        //4. Normalize each variable's distance
        
        
        //5. Aggregate the normalized distance matrix
        
        
        
     
        
        
        
    }
    
        
}