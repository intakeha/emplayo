<?php
class Survey_model extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
    }
       
        function get_categories()
    { 

        $sql = 'SELECT category_id,name FROM category';
        $query = $this->db->query($sql);
        
      //transformation  
        $newarray = array();
        foreach($query->result_array() as $mainkey=>$row)
        {
            foreach ($row as $key=>$value)
            {              
                if ($key=='category_id')
                {
                    $cat_key = $value;
                    $newarray[$cat_key]=$value;
                } else {
                    $newarray[$cat_key]=$value;
                }
            }
        }
       //transformation end 
        return $newarray;
    }

        function match_tags($categories)
    { 
        $categories = implode(',', $categories);

        $sql = 'SELECT b.*
                FROM category_map bt, company b, category t
                WHERE bt.category_id = t.category_id
                AND (t.category_id IN ('.$categories.'))
                AND b.id = bt.company_id
                GROUP BY b.id';
            
        //$sql = 'SELECT name FROM category WHERE category_id IN ('.$categories.')';
        $query = $this->db->query($sql);

        foreach ($query->result_array() as $row)
        {
            print_r($row['company_name']);
            echo '<br>';
        }

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
                    //KEY POINT: The benefit that is most desired has the highest rank value. For example,
                    // if there are 10 options, the user's most desired benefit has a rank of 10.  The least
                    // desired has a rank of 1.
                   
                    $score += $user_benefits_array[$benefit_id]['rank'];
                }
                $scores[$company_id] = $score;

            }
            
            arsort($scores);
            echo "scores: <br>";
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
    
    function survey_filter()
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
            echo "queried comp ids: <br>";
            print_r($queried_comp_ids);
            
            return $queried_comp_ids;
            
        }
        else //no companies were found
        {
            return FALSE;
        }
    }
    
    function survey_filter2($categories)
    {
        //find companies that match the DO NEXT categories
        $categories = implode(',', $categories);

        $sql = 'SELECT b.*
                FROM category_map bt, company b, category t
                WHERE bt.category_id = t.category_id
                AND (t.category_id IN ('.$categories.'))
                AND b.id = bt.company_id
                GROUP BY b.id';

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
            //build array of company ids that came from the last query...so we can use them in the upcoming query
            foreach ($query->result_array() as $row) {
                //$companyid_array[]=$row;
                $companyid_array[]=$row['id'];
            }
            $queried_comp_ids = implode(',', $companyid_array);
            
            echo "queried comp ids based on CATEGORY: <br>";
            print_r($queried_comp_ids);
            echo '<br>';
            
            //return a comma-separated string of the company ids that match
            return $queried_comp_ids;
            
        }
        else //no companies were found
        {
            return FALSE;
        }

    }
    
    function survey_filter3($company_list)
    {            
        //build arrays of user submitted info from post data
        $type_array = $this->input->post('company_type');

        //put the values from those arrays into strings so they can be added to the query
        $imploded_type = implode(",", $type_array);
        echo "these are the passed company types:<br>";
        echo $imploded_type;
        echo "<br>";
        
        echo "this is the passed company list:<br>";
        echo $company_list;
        echo "<br>";        

        $sql = 'SELECT id,company_name FROM company WHERE type_id IN ('.$imploded_type.')
                AND id IN ('.$company_list.')';
        ////TODO: this query cannot handle the case where there is only one choice passed.  
        //must be a problem with the comma?

        //run the query
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0)
        {
            //build array of company ids that came from the last query...so we can use them in the upcoming query
            foreach ($query->result_array() as $row) {
                //$companyid_array[]=$row;
                $companyid_array[]=$row['id'];
            }
            $queried_comp_ids = implode(',', $companyid_array);
            echo "queried comp ids based on TYPE: <br>";
            print_r($queried_comp_ids);
            echo '<br>';
            
            return $queried_comp_ids;
            
        }
        else //no companies were found
        {
            return FALSE;
        }
    }
    
    function toggle_filters($company_list)
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
                    AND id IN ('.$company_list.')    ';
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
            echo "queried comp ids: <br>";
            print_r($queried_comp_ids);
            
            return $queried_comp_ids;
            
        }
        else //no companies were found
        {
            return FALSE;
        }
    }    
 
    function benefits_scoring($queried_comp_ids)
    {            

            //get the user submitted benefits ranking
            $user_benefits_array = $this->input->post('users_benefits');   

            echo "<br><br>user benefits array: <br>";
            echo "<pre>";
            print_r($user_benefits_array);
            echo "</pre>";              
            
            //$this->output->enable_profiler(TRUE);
            
            //get all the companies (that meet the previous criteria) and their associated benefits
            $sql2 = 'SELECT company_id,benefits_id FROM company_benefits WHERE company_id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);
            
            //build an array with a specific format to be used in the upcoming scoring process
            $company_set = array();
            foreach ($query2->result_array() as $row) {
                $company_set[$row['company_id']][]=$row['benefits_id'];
            }
            
            echo "<br><br>benefits array pre-scoring: <br>";
            echo "<pre>";
            print_r($company_set);
            echo "</pre>";                      
            
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
                    //KEY POINT: The benefit that is most desired has the highest rank value. For example,
                    // if there are 10 options, the user's most desired benefit has a rank of 10.  The least
                    // desired has a rank of 1.
                   
                    $score += $user_benefits_array[$benefit_id]['rank'];
                }
                $scores[$company_id] = $score;

            }
            
            arsort($scores);
            echo "<br><br>benefits scores: <br>";
            echo "<pre>";
            print_r($scores);
            echo "</pre>";
            
            return $scores;
    }    

    function history_scoring($queried_comp_ids)
    {            

            //get the user submitted history categories
            $user_history_cats = $this->input->post('history');   

            echo "<br><br>user history cats: <br>";
            echo "<pre>";
            print_r($user_history_cats);
            echo "</pre>";          
            
            //$this->output->enable_profiler(TRUE);
            
            //get all the companies (that meet the previous criteria) and their associated benefits
            $sql2 = 'SELECT company_id,category_id FROM category_map WHERE company_id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);

            //$user_history_cats = implode(',', $user_history_cats);            
        
            //build an array with a specific format to be used in the upcoming scoring process
            $company_set = array();
            foreach ($query2->result_array() as $row) {
                $company_set[$row['company_id']][]=$row['category_id'];
            }
            
            echo "<br><br>history category array pre-scoring: <br>";
            echo "<pre>";
            print_r($company_set);
            echo "</pre>";   
            
            
            $scores = array();
            // For every company, we will assign it a score based on how many
            // of the user's category choices it has.  Each category is worth 1 point.
            
            foreach($company_set as $company_id => $array_row)
            {   
                $score = 0;
                foreach ($array_row as $key=>$category_id)
                {
                    //we walk through the array that contains each company's categories
                    //then, we search for each category in the user's choices.  if we find
                    //a match, we give the company a point. and so on...
                    
                    echo "<br>category_id: ".$category_id;
                    
                    if (in_array($category_id, $user_history_cats, true)){
                        ++$score;
                    }
                    
                }
                $scores[$company_id] = $score;

            }
            
            arsort($scores);
            echo "<br>history category scoring: <br>";
            print_r($scores);
            return $scores;
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
    
    function get_company2($ranked_comps)
    { 
        //$this->output->enable_profiler(TRUE);
        if (!empty($ranked_comps)){
              //$ranked_comps = array('4'=>'63','3'=>'45','1'=>'40');
                          echo "ranked_comps (before):<br>";
              echo '<pre>';
               print_r($ranked_comps);
               echo '<br><br>';
            
              //$ranked_comps = array_keys($ranked_comps);
               $new_ranked_comps = array();
              foreach ($ranked_comps as $row) {
                  echo "row id: ".$row['id'];
                  echo "<br>";
                  $new_ranked_comps[]=$row['id'];
                  
              }
              echo "ranked_comps (after):<br>";
              echo '<pre>';
               print_r($new_ranked_comps);
               echo '</pre>';
            
            $companyid_array = implode(',', $new_ranked_comps);
            echo "company id array:<br>";
            print_r($companyid_array);  
            
            //this is to make sure we retrieve the companies in the same order as their scores
            $order_array = 'ORDER BY';
            foreach ($ranked_comps as $item) {
              $order_array .= ' id = ' . $item['id'] . ' DESC,';
            }
            $order_array = trim($order_array, ',');

            $sql = 'SELECT * FROM company WHERE id IN ('.$companyid_array.') '.$order_array.'';
            $query = $this->db->query($sql);
            echo '<pre>';
            echo "result array:<br>";
            print_r($query->result_array());
            echo '</pre>';
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
        $pace_array = $this->input->post('company_pace');
        $lifecycle_array = $this->input->post('lifecycle');
        
        //build the one row user coordinates array in order to measure distance from it to the companies
        //the user's coordinates are 'perfect', so the distance from user to company is what matters.
        $user_data = array();
        
        $user_data[0]['id'] = 'user';
        $user_data[0]['citizenship'] = $corp_citizenship;        
        $user_data[0]['benefits'] = 120;//hardcoded based on total max score of benefits  
        
        //get the company citizenship values from the database
        $comp_ids = array_keys($ranked_comps);//company ids, along with benefit scores
        $comp_ids_imploded = implode(',', $comp_ids);
        $sql = 'SELECT id,corp_citizenship_id AS citizenship FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $company_data_array = $query->result_array();
        echo "<pre>";
        echo "<br> company_data_array right BEFORE merging with ranked_comps:<br>";
        print_r($company_data_array);
        echo "</pre>";             
            
            //walk the array of company citizenship info and merge in the benefits data
            array_walk($company_data_array, 'merge_arrays',$ranked_comps);
        }
        echo "<pre>";
        echo "<br> company_data_array right after merging with ranked_comps:<br>";
        print_r($company_data_array);
        echo "</pre>";         
        
        
        //create one array that includes the user coordinates along with all the companies
        //we will walk this array to determine distances
        $data = array_merge($user_data,$company_data_array);
        //$user_benefit_score = 120;
        //$user_citizenship = $this->input->post('corp_citizenship');

        //2. Transform data into coordinates
        $data_array = $data;
        //normalize citizenship data (convert to rank 1-5, then normalize)
        //our data should already be in rank 1-5
        echo "<pre>";
        echo "<br> raw data:<br>";
        print_r($data_array);
        echo "</pre>";          
        
        foreach ($data_array as &$row)
        {
            $row['citizenship']=($row['citizenship']-1)/(5-1);
        }
        $data_array_copy = $data_array;

        //3. Calculate distance for each variable

        function city_block_distance_benefits(&$sourceCoords,$sourceKey, $data)
        {        
            $user_benefit_score = $data[0]['benefits'];
            $sourceCoords['benefits'] = abs($sourceCoords['benefits']-$user_benefit_score);
        }        
        
        function city_block_distance_citizenship(&$sourceCoords,$sourceKey, $data_array_copy)
        {
            $user_citizenship_score = $data_array_copy[0]['citizenship'];   
            $sourceCoords['citizenship'] = abs($sourceCoords['citizenship']-$user_citizenship_score);   
        }         

        echo "<pre>";
        echo "<br> raw data2:<br>";
        print_r($data_array);
        echo "</pre>";         
        
        
        array_walk($data_array, 'city_block_distance_benefits',$data);   
        array_walk($data_array, 'city_block_distance_citizenship',$data_array_copy);      

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
         //$min = 1;
         $max = max($isolated_benefits);

           
        $sourceCoords['benefits'] = ($sourceCoords['benefits']-$min)/($max-$min);   
        }         
        
        function isolate_benefits($details) {
          return $details['benefits'];
        }
        $isolated_benefits = array_map('isolate_benefits', $data_array);  

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
        
        unset($data_array[0]);
        
        echo "<pre>";
        echo "<br> aggregate data without user:<br>";
        print_r($data_array);
        echo "</pre>";
        
        //sort the array
        foreach ($data_array as $array) {
            $agscore[] = $array['ag_score'];
        }

        array_multisort($agscore,SORT_NUMERIC,SORT_DESC,$data_array);
        echo '<pre>sorted:<br>',print_r($data_array,1),'</pre>';
        
        
        return $data_array;
     
        
        
        
    }
    
    function get_distance_matrix2($ranked_comps)
    {
        
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
        
        function merge_arrays_pace(&$companyData,$companyKey, $paceArray)
        {
            //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData
            foreach ($paceArray as $row)
            {
                if ($companyData['id'] == $row['id'])
                {
                    //echo "<br>the key:$key, matches the id: ".$companyData['id'];
                    $companyData['pace'] = $row['pace'];
                }
            }

        } 
        
        function merge_arrays_lifecycle(&$companyData,$companyKey, $lifecycleArray)
        {
            //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData
            foreach ($lifecycleArray as $row)
            {
                if ($companyData['id'] == $row['id'])
                {
                    //echo "<br>the key:$key, matches the id: ".$companyData['id'];
                    $companyData['lifecycle'] = $row['lifecycle'];
                }
            }

        }         
        
        $corp_citizenship = $this->input->post('corp_citizenship');
        $user_pace = $this->input->post('company_pace');
        $user_lifecycle = $this->input->post('lifecycle');
        
        //build the one row user coordinates array in order to measure distance from it to the companies
        //the user's coordinates are 'perfect', so the distance from user to company is what matters.
        $user_data = array();
        
        $user_data[0]['id'] = 'user';
        $user_data[0]['citizenship'] = $corp_citizenship;
        $user_data[0]['pace'] = $user_pace;
        $user_data[0]['lifecycle'] = $user_lifecycle;
        $user_data[0]['benefits'] = 120;//hardcoded based on total max score of benefits
        
        
        //get the company citizenship values from the database
        $comp_ids = array_keys($ranked_comps);//company ids, along with benefit scores
        $comp_ids_imploded = implode(',', $comp_ids);
        
        //Get citizenship company data and merge it into array
        $sql = 'SELECT id,corp_citizenship_id AS citizenship FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $company_data_array = $query->result_array();
            //walk the array of company citizenship info and merge in the benefits data
            array_walk($company_data_array, 'merge_arrays',$ranked_comps);
        }
        //End of Get Citizenship data
        echo "<pre>";
        echo "<br> company_data_array right after merging with ranked_comps:<br>";
        print_r($company_data_array);
        echo "</pre>"; 
        
        //Get pace company data and merge it into array
        $sql = 'SELECT id,pace_id AS pace FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $pace_array = $query->result_array();
            //walk the array of company citizenship info and merge in the benefits data
            array_walk($company_data_array, 'merge_arrays_pace',$pace_array);
        }
        //End of get pace data        
        
        //Get lifecycle company data and merge it into array
        $sql = 'SELECT id,lifecycle_id AS lifecycle FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $lifecycle_array = $query->result_array();
            //walk the array of company citizenship info and merge in the benefits data
            array_walk($company_data_array, 'merge_arrays_lifecycle',$lifecycle_array);
        }
        //End of get lifecycle data  
        
        
                echo "<pre>";
        echo "<br>ranked_comps:<br>";
        print_r($ranked_comps);
        echo "</pre>"; 
                     echo "<pre>";
        echo "<br>pace array:<br>";
        print_r($pace_array);
        echo "</pre>"; 
        
        echo "<pre>";
        echo "<br> company_data_array right after merging with pace:<br>";
        print_r($company_data_array);
        echo "</pre>";        
 
        echo "<pre>";
        echo "<br> company_data_array right after merging with lifecycle:<br>";
        print_r($company_data_array);
        echo "</pre>";          
        
        
        //create one array that includes the user coordinates along with all the companies
        //we will walk this array to determine distances
        $data = array_merge($user_data,$company_data_array);
        //$user_benefit_score = 120;
        //$user_citizenship = $this->input->post('corp_citizenship');

        //2. Transform data into coordinates
        $data_array = $data;
        //normalize citizenship data (convert to rank 1-5, then normalize)
        //our data should already be in rank 1-5
        echo "<pre>";
        echo "<br> raw data:<br>";
        print_r($data_array);
        echo "</pre>";          
        
        foreach ($data_array as &$row)
        {
            //ordinal-> x=(r-1)/(R-1), where r=rank, R= max rank
            $row['citizenship']=($row['citizenship']-1)/(5-1);
            $row['pace']=($row['pace']-1)/(3-1);
            $row['lifecycle']=($row['lifecycle']-1)/(4-1);
        }
        $data_array_copy = $data_array;

        //3. Calculate distance for each variable
/*
        function city_block_distance_benefits(&$sourceCoords,$sourceKey, $data)
        {        
            $user_benefit_score = $data[0]['benefits'];
            $sourceCoords['benefits'] = abs($sourceCoords['benefits']-$user_benefit_score);
        }        
        
        function city_block_distance_citizenship(&$sourceCoords,$sourceKey, $data_array_copy)
        {
            $user_citizenship_score = $data_array_copy[0]['citizenship'];   
            $sourceCoords['citizenship'] = abs($sourceCoords['citizenship']-$user_citizenship_score);   
        }      
        
        function city_block_distance_pace(&$sourceCoords,$sourceKey, $data_array_copy)
        {
            $user_pace_score = $data_array_copy[0]['pace'];   
            $sourceCoords['pace'] = abs($sourceCoords['pace']-$user_pace_score);   
        }   
        
        function city_block_distance_lifecycle(&$sourceCoords,$sourceKey, $data_array_copy)
        {
            $user_lifecycle_score = $data_array_copy[0]['lifecycle'];   
            $sourceCoords['lifecycle'] = abs($sourceCoords['lifecycle']-$user_lifecycle_score);   
        }           

        echo "<pre>";
        echo "<br> raw data2:<br>";
        print_r($data_array);
        echo "</pre>";         
        
        
        array_walk($data_array, 'city_block_distance_benefits',$data);   
        array_walk($data_array, 'city_block_distance_citizenship',$data_array_copy);
        array_walk($data_array, 'city_block_distance_pace',$data_array_copy);        
        array_walk($data_array, 'city_block_distance_lifecycle',$data_array_copy);
        
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
            $benefits_weight = 1;
            $citizenship_weight = 1;
            $pace_weight = 1;
            $lifecycle_weight = 1;
            $aggregate_array['id'] = $sourceCoords['id'];
            $aggregate_array['ag_score'] = ($sourceCoords['benefits']*$benefits_weight 
                                            + $sourceCoords['citizenship']*$citizenship_weight
                                            + $sourceCoords['pace']*$pace_weight
                                            + $sourceCoords['lifecycle']*$lifecycle_weight
                                            )/($benefits_weight+$citizenship_weight);
            $sourceCoords = $aggregate_array;
        }         
        
        array_walk($data_array, 'aggregate',$data); 
        
        echo "<pre>";
        echo "<br> aggregate data:<br>";
        print_r($data_array);
        echo "</pre>";  
        
        unset($data_array[0]);
        
        echo "<pre>";
        echo "<br> aggregate data without user:<br>";
        print_r($data_array);
        echo "</pre>";
        
        //sort the array
        foreach ($data_array as $array) {
            $agscore[] = $array['ag_score'];
        }

        array_multisort($agscore,SORT_NUMERIC,SORT_DESC,$data_array);
        echo '<pre>sorted:<br>',print_r($data_array,1),'</pre>';
        
        
        return $data_array;
     
        
        
       */ 
    }    
    
    function get_distance_matrix3($ranked_comps,$history_scoring)
    {
        
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

        function merge_arrays_history(&$companyData,$companyKey, $historyArray)
        {
            //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData
            foreach ($historyArray as $key=>$value)
            {
                if ($companyData['id'] == $key)
                {
                    //echo "<br>the key:$key, matches the id: ".$companyData['id'];
                    $companyData['history'] = $value;
                }
            }

        }         
        
        $corp_citizenship = $this->input->post('corp_citizenship');
        $pace_array = $this->input->post('company_pace');
        $lifecycle_array = $this->input->post('lifecycle');
        $history_array = $this->input->post('history');        
        
        //build the one row user coordinates array in order to measure distance from it to the companies
        //the user's coordinates are 'perfect', so the distance from user to company is what matters.
        $user_data = array();
        
        $user_data[0]['id'] = 'user';
        $user_data[0]['citizenship'] = $corp_citizenship;        
        $user_data[0]['benefits'] = 120;//hardcoded based on total max score of benefits  
        $user_data[0]['history'] = count($history_array);//if a company has all of the user's history categories, then that would be a perfect score
        
        //get the company citizenship values from the database
        $comp_ids = array_keys($ranked_comps);//company ids, along with benefit scores
        $comp_ids_imploded = implode(',', $comp_ids);
        $sql = 'SELECT id,corp_citizenship_id AS citizenship FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $company_data_array = $query->result_array();
        echo "<pre>";
        echo "<br> company_data_array right BEFORE merging with ranked_comps:<br>";
        print_r($company_data_array);
        echo "</pre>";             
            
            //walk the array of company citizenship info and merge in the benefits data
            array_walk($company_data_array, 'merge_arrays',$ranked_comps);
        }
        echo "<pre>";
        echo "<br> company_data_array right after merging with ranked_comps:<br>";
        print_r($company_data_array);
        echo "</pre>";         
       
        //walk the array of company company data and merge in the history scoring
        //$temp_comp_data = $company_data_array;
        array_walk($company_data_array, 'merge_arrays_history',$history_scoring); 

        echo "<pre>";
        echo "<br> company_data_array right after merging with history:<br>";
        print_r($company_data_array);
        echo "</pre>";         
        
        
        //create one array that includes the user coordinates along with all the companies
        //we will walk this array to determine distances
        $data = array_merge($user_data,$company_data_array);
        //$user_benefit_score = 120;
        //$user_citizenship = $this->input->post('corp_citizenship');

        //2. Transform data into coordinates
        $data_array = $data;
        //normalize citizenship data (convert to rank 1-5, then normalize)
        //our data should already be in rank 1-5
        echo "<pre>";
        echo "<br> raw data:<br>";
        print_r($data_array);
        echo "</pre>";          
        
        foreach ($data_array as &$row)
        {
            $row['citizenship']=($row['citizenship']-1)/(5-1);
        }
        $data_array_copy = $data_array;

        //3. Calculate distance for each variable

        function city_block_distance_benefits(&$sourceCoords,$sourceKey, $data)
        {        
            $user_benefit_score = $data[0]['benefits'];
            $sourceCoords['benefits'] = abs($sourceCoords['benefits']-$user_benefit_score);
        }        
 
        function city_block_distance_history(&$sourceCoords,$sourceKey, $data)
        {        
            $user_history_score = $data[0]['history'];
            $sourceCoords['history'] = abs($sourceCoords['history']-$user_history_score);
        }          
        
        function city_block_distance_citizenship(&$sourceCoords,$sourceKey, $data_array_copy)
        {
            $user_citizenship_score = $data_array_copy[0]['citizenship'];   
            $sourceCoords['citizenship'] = abs($sourceCoords['citizenship']-$user_citizenship_score);   
        }         

        echo "<pre>";
        echo "<br> raw data2:<br>";
        print_r($data_array);
        echo "</pre>";         
        
        
        array_walk($data_array, 'city_block_distance_benefits',$data);   
        array_walk($data_array, 'city_block_distance_history',$data); 
        array_walk($data_array, 'city_block_distance_citizenship',$data_array_copy);      

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
         //$min = 1;   
         $max = max($isolated_benefits);

           
        $sourceCoords['benefits'] = ($sourceCoords['benefits']-$min)/($max-$min);   
        }         
        
        function isolate_benefits($details) {
          return $details['benefits'];
        }
        $isolated_benefits = array_map('isolate_benefits', $data_array);  

        array_walk($data_array, 'normalize_benefits',$isolated_benefits);   
        
        //now, for history:
        function normalize_history(&$sourceCoords,$sourceKey, $isolated_history)
        {
        //what about division by zero?
            
         $min = min($isolated_history);
         $max = max($isolated_history);

         echo "<br>history: ".$sourceCoords['history'];
         echo "<br>min: ".$min;
         echo "<br>max: ".$max;
         
        $sourceCoords['history'] = ($sourceCoords['history']-$min)/($max-$min);   
        }         
        
        function isolate_history($details) {
          return $details['history'];
        }
        $isolated_history = array_map('isolate_history', $data_array);  

        echo "<pre>";
        echo "<br> isolated history:<br>";
        print_r($isolated_history);
        echo "</pre>";         
        
        $min_history = min($isolated_history);
        $max_history = max($isolated_history);
        
        if (!(($min_history >= 0 && $min_history <= 1)&&($max_history >= 0 && $max_history <= 1))){
            //check to make sure we aren't already between 0&1
            array_walk($data_array, 'normalize_history',$isolated_history);          
        }
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
            //weights should add up to 1
            $benefits_weight = .4;
            $history_weight = .2;
            $citizenship_weight = .4;
            
            $aggregate_array['id'] = $sourceCoords['id'];
            $aggregate_array['ag_score'] = ($sourceCoords['benefits']*$benefits_weight 
                    + $sourceCoords['history']*$history_weight
                    + $sourceCoords['citizenship']*$citizenship_weight)/($benefits_weight+$history_weight+$citizenship_weight);
            $sourceCoords = $aggregate_array;
        }         
        
        array_walk($data_array, 'aggregate',$data); 
        
        echo "<pre>";
        echo "<br> aggregate data:<br>";
        print_r($data_array);
        echo "</pre>";  
        
        unset($data_array[0]);
        
        echo "<pre>";
        echo "<br> aggregate data without user:<br>";
        print_r($data_array);
        echo "</pre>";
        
        //sort the array
        foreach ($data_array as $array) {
            $agscore[] = $array['ag_score'];
        }

        array_multisort($agscore,SORT_NUMERIC,SORT_ASC,$data_array);
        echo '<pre>sorted:<br>',print_r($data_array,1),'</pre>';
        
        
        return $data_array;
     
        
        
        
    }
    
    function fit_score($ranked_results)
    {
        foreach ($ranked_results as &$company_row) {
            $company_row['ag_score'] = round(1 - $company_row['ag_score'],3);
            
        }
        echo '<pre>fit scored up!:<br>',print_r($ranked_results,1),'</pre>'; 
        return $ranked_results;
    }

    
    function merge_company_info($company_info,$company_fit)
    {
        
        function xmerge_fit_arrays(&$companyData,$companyKey, $companyFit)
        {
            //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData
           
            foreach ($companyFit as $fitrow)
            {
                echo "<br>company_fit id: ".$fitrow['ag_score'];
                foreach($companyData as $datarow)
                {
                    if ($datarow['id'] == $fitrow['id'])
                    {
                        echo "HEY!!";
                        //$datarow['fit_score'] = $fitrow['ag_score'];
                    }
                }
                
            }
            
            
        }
          function merge_fit_arrays(&$companyData,$companyKey, $companyFit)
        {
            //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData
           
            foreach ($companyFit as $value)
            {
                if ($value['id']==$companyData['id'])
                {
                $companyData['fit_score'] = $value['ag_score'];
                echo "<br>company_fit score: ".$companyData['fit_score'];
                }
                
            }
            

                echo "<br>company data name: ".$companyData['company_name'];

                
                       
            
        }      
        
        array_walk($company_info, 'merge_fit_arrays',$company_fit);

        echo '<pre>fit scored up!:<br>',print_r($company_info,1),'</pre>'; 
        return $company_info;
        
              
    }
    
}

