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
                    AND (lifecycle_id = '.$imploded_lifecycle.')';
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
            print_r($scores);
            //reset($scores);
            //$first_key = key($scores);
            //echo "Best score is company id: ".$first_key;
            //Array ( [1] => 88 [3] => 67 [4] => 65 )
            $ranked_comps = array_keys($scores);
            //return $ranked_comps;
            return $scores;

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
        
        echo "<pre>";
        echo "<br> passed data:<br>";
        print_r($ranked_comps);
        echo "</pre>";        
        //1. Create array of data points
        //
        //user's benefit score is always perfect, so we know it is the triangular
        //number of the highest ranking 15t=>120.
        //user's citizenship score is in the post data.  Company info is in the database.
        
        function merge_arrays(&$companyData,$companyKey, $benefitsArray)
        {
            //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData
            foreach ($benefitsArray as $key=>$value)
            {
                if ($companyData['id'] == $key)
                {
                    //echo "<br>the key:$key, matches the id: ".$companyData['id'];
                    $companyData['benefits'] = $value;
                }
            }

        }          
        
        
        $corp_citizenship = $this->input->post('corp_citizenship');
        
        $user_data = array();
        
        $user_data[0]['id'] = 'user';
        $user_data[0]['benefits'] = 120;//hardcoded based on total max score of benefits
        $user_data[0]['citizenship'] = $corp_citizenship;  
        
        echo "<pre>";
        echo "<br> user  data array:<br>";
        print_r($user_data);
        echo "</pre>";        
        
        $comp_ids = array_keys($ranked_comps);
        
        
        $comp_ids_imploded = implode(',', $comp_ids);
        $sql = 'SELECT id,corp_citizenship_id AS citizenship FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $company_data_array = $query->result_array();
            array_walk($company_data_array, 'merge_arrays',$ranked_comps);
            
        echo "<pre>";
        echo "<br> company data array:<br>";
        print_r($company_data_array);
        echo "</pre>";   
            
            foreach ($query->result_array() as $row) 
            {
            //echo "<br>corp citizenship: ".$row['corp_citizenship_id'];
            }
            
        }
        
        $data = array_merge($user_data,$company_data_array);
        echo "<pre>";
        echo "<br> merge result:<br>";
        print_r($data);
        echo "</pre>";        
       
        
        
        /*
        $i=1;
        foreach ($ranked_comps as $key => $value) {
            
            $newdata[$i]['id'] =$key;
            $newdata[$i]['benefits'] =$value;
            $newdata[$i]['citizenship'] = 1;//need to get this value from DB...as well as other 16 questions
            $i++;
            
            
        }
        
        echo "<pre>";
        echo "<br> new data array:<br>";
        print_r($newdata);
        echo "</pre>";        
        */
        
        $user_benefit_score = 120;
        $user_citizenship = $this->input->post('corp_citizenship');
        //$data_array = array("id"=>"user","benefits"=>120,"citizenship"=>$user_citizenship);
        //array_push($data_array, "4", "45","1");
        /*$data = array(
            array("id"=>'user', "benefits"=>120, "citizenship"=>5),
            array("id"=>4, "benefits"=>63, "citizenship"=>1),
            array("id"=>3, "benefits"=>45, "citizenship"=>1),
            array("id"=>1, "benefits"=>90, "citizenship"=>1),
        );    */    
        

        
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
        //normalize citizenship data (convert to rank 1-5, then normalize)
        //our data should already be in rank 1-5
        foreach ($data_array as &$row)
        {
            $row['citizenship']=($row['citizenship']-1)/(5-1);
        }
        $data_array_copy = $data_array;
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
        /*
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
        
        function city_block_distance0(&$sourceCoords,$sourceKey, $data)
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
        echo "<br>sourcekey: ".$sourceKey;
        
        
        
        foreach ($data as $destKey => $destCoords) {
            // Same point, ignore
            $user_benefit_score = 0;
            if ($sourceCoords['id'] == 'user') {
                echo "<br>im in the user loop, the user benefit is:".$sourceCoords['benefits'];
                $user_benefit_score = $sourceCoords['benefits'];
                //continue;
            }
            //list ($x2, $y2) = $destinationCoords;
            //$distances[$destinationKey] = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2));
            echo "<br> inside foreach, destkey = " . $destKey;
            echo "<br> inside foreach, destcoord[id] = " . $destCoords['id'];
            $distances[$destCoords['id']] = abs($destCoords['benefits']-$user_benefit_score);
            
            //$testing = 250-$user_benefit_score;
            //echo "testing: ".$testing;
            
        }
        $sourceCoords = $distances;
            
        
        }
        */
        function city_block_distance_benefits(&$sourceCoords,$sourceKey, $data)
        {
            //=+ABS($A19-D$16)
            //list($x1, $y1) = $sourceCoords;
            //echo "x: $x1";
        //echo "<pre>";
        //echo "<br> source coords data:<br>";
        //print_r($sourceCoords);
        //echo "</pre>"; 
            //echo $sourceCoords['id'];
        //$distances = array();
        //echo "<br>sourcekey: ".$sourceKey;
        
        $user_benefit_score = $data[0]['benefits'];
        //echo "<br> data 0 id: ".$data[0]['id'];
        //echo "<br> the user benefit from data array is: ".$user_benefit_score;
        //echo "<br> data X id: ".$data[]['id'];
        
        //$distances[$sourceCoords['id']] = abs($sourceCoords['benefits']-$user_benefit_score);
        //$sourceCoords = $distances;
        
        $sourceCoords['benefits'] = abs($sourceCoords['benefits']-$user_benefit_score);
        
        
        }        
        
        function city_block_distance_citizenship(&$sourceCoords,$sourceKey, $data_array_copy)
        {
        $user_citizenship_score = $data_array_copy[0]['citizenship'];   
        $sourceCoords['citizenship'] = abs($sourceCoords['citizenship']-$user_citizenship_score);   
        }         
        
        array_walk($data_array, 'city_block_distance_benefits',$data);   
        array_walk($data_array, 'city_block_distance_citizenship',$data_array_copy);      
        //array_walk($data_array, 'testFunction', 'hey');
        

        
        echo "<pre>";
        echo "<br> distance data:<br>";
        print_r($data_array);
        echo "</pre>"; 
        
        
        //4. Normalize each variable's distance
        //for quantitative data: norm = (d-dmin)/(dmax-dmin)
        //for ordinal data, with rank of 1-5: norm = (r-1)/(R-1)
        
        function normalize_benefits(&$sourceCoords,$sourceKey, $isolated_benefits)
        {
        //what about division by zero?
            
         $min = min($isolated_benefits);
         $max = max($isolated_benefits);

           
        $sourceCoords['benefits'] = ($sourceCoords['benefits']-$min)/($max-$min);   
        }         
        
        function isolate_benefits($details) {
          return $details['benefits'];
        }
        $isolated_benefits = array_map('isolate_benefits', $data_array);  
        
        echo "<pre>";
        echo "<br> isolated benefits:<br>";
        print_r($isolated_benefits);
        echo "</pre>";        
        
        array_walk($data_array, 'normalize_benefits',$isolated_benefits);   

        echo "<pre>";
        echo "<br> normalized disparate data:<br>";
        print_r($data_array);
        echo "</pre>";         
        
        
        
        
        //5. Aggregate the normalized distance matrix
        //assuming each feature variable has the same weight, sum them up then divide
        //by the number of feature variables
        function aggregate(&$sourceCoords,$sourceKey, $data_array_copy)
        {
            $aggregate_array = array();
            $var_count = 2;
            $benefits_weight = 2;
            $citizenship_weight = 1;
            $aggregate_array['id'] = $sourceCoords['id'];
            $aggregate_array['ag_score'] = ($sourceCoords['benefits']*$benefits_weight 
                    + $sourceCoords['citizenship']*$citizenship_weight)/($benefits_weight+$citizenship_weight);
            $sourceCoords = $aggregate_array;
        }         
        
        array_walk($data_array, 'aggregate',$data); 
        
        echo "<pre>";
        echo "<br> aggregate data:<br>";
        print_r($data_array);
        echo "</pre>";          
     
        
        
        
    }
    
        
}