<?php
class Preview_model extends CI_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
    }
       
        function get_categories()
    { 
        $sql = 'SELECT category_id,name FROM ref_category';
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
                FROM company_category bt, company b, ref_category t
                WHERE bt.category_id = t.category_id
                AND (t.category_id IN ('.$categories.'))
                AND b.id = bt.company_id
                GROUP BY b.id';

        $query = $this->db->query($sql);

        foreach ($query->result_array() as $row)
        {
            /*print_r($row['company_name']);
            echo '<br>';*/
        }

    }
    
    
    function insert_survey()
    {
        $user_id = 1;       
        //INSERT Company Type into User Type table
        $company_array = $this->input->post('company_type');

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
            $ranked_comps = array_keys($scores);
            //return $ranked_comps;
            return $scores;

        } else {
            //echo "<br>from the model: there were no results.";
        }
   
    }
    
    function survey_filter2($categories)
    {
        //find companies that match the DO NEXT categories
        $categories = implode(',', $categories);

        $sql = 'SELECT b.*
                FROM company_category bt, company b, ref_category t
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
            
            //return a comma-separated squeried comp ids: tring of the company ids that match
            return $queried_comp_ids;
            
        }
        else //no companies were found
        {
            return FALSE;
        }

    }
    
    function industry_filter($industry)
    {
        //find companies that match the DO NEXT categories
        $categories = implode(',', $industry);

        $sql = 'SELECT b.*
                FROM company_category bt, company b, ref_category t
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
            
            //return a comma-separated squeried comp ids: tring of the company ids that match
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

            return $queried_comp_ids;
            
        }
        else //no companies were found
        {
            return FALSE;
        }
    }
    
    function toggle_filters($company_list,$type_array,$pace_array,$lifecycle_array)
    {            
        //put the values from those arrays into strings so they can be added to the query
        //$imploded_type = implode(" OR ", $type_array);
        $imploded_type = implode(',', $type_array);
        //$imploded_pace = implode(" OR ", $pace_array);
        $imploded_pace = implode(',', $pace_array);
        //$imploded_lifecycle = implode(" OR ", $lifecycle_array);
        $imploded_lifecycle = implode(',', $lifecycle_array);

       /* $sql = 'SELECT id,company_name FROM company where (type_id = '.$imploded_type.')
                    AND (pace_id = '.$imploded_pace.')
                    AND (lifecycle_id = '.$imploded_lifecycle.')
                    AND id IN ('.$company_list.')    ';*/
        
        $sql = 'SELECT id,company_name FROM company where type_id IN ('.$imploded_type.')
                    AND pace_id IN ('.$imploded_pace.')
                    AND lifecycle_id IN ('.$imploded_lifecycle.')
                    AND id IN ('.$company_list.')    ';        
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
            
            return $queried_comp_ids;
            
        }
        else //no companies were found
        {
            return FALSE;
        }
    }    
 
    function benefits_scoring($queried_comp_ids,$user_benefits_array)
    {            

            //get the user submitted benefits ranking
            //$user_benefits_array = $this->input->post('users_benefits');              

            //get all the companies (that meet the previous criteria) and their associated benefits
        if (!empty($queried_comp_ids)){
            $sql2 = 'SELECT company_id,benefits_id FROM company_benefits WHERE company_id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);
        }
        else {
            return FALSE;          
        }
            
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

            return $scores;
    }    

    function prev_job_types($user_work)
    {            
        /*
        user_work[0][company_id]	69
        user_work[0][company_name...	Apple Inc
        user_work[0][end_month]	03
        user_work[0][end_year]	2005
        user_work[0][job_id]	1
        user_work[0][job_type]	Accounting
        user_work[0][start_month]	01
        user_work[0][start_year]	2003
         */        
        //walk through user_work array and pull out the historical job types
        $prev_job_types = array();
        foreach ($user_work as $key=>$value)
        {
            $prev_job_types[$key] = $value['job_type'];        
        }
        
        return $prev_job_types;
    }
    
    function history_scoring($queried_comp_ids,$user_history_cats)
    {            

            //get the user submitted history categories
            //$user_history_cats = $this->input->post('history');   
            
            //get all the companies (that meet the previous criteria) and their associated benefits
            $sql2 = 'SELECT company_id,category_id FROM company_category WHERE company_id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);

            //$user_history_cats = implode(',', $user_history_cats);            
        
            //build an array with a specific format to be used in the upcoming scoring process
            $company_set = array();
            foreach ($query2->result_array() as $row) {
                $company_set[$row['company_id']][]=$row['category_id'];
            }

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
                    
                    if (in_array($category_id, $user_history_cats, true)){
                        ++$score;
                    }
                    
                }
                //added the following line to limit max score to 1
                if ($score >1){$score=1;}
                //end of added line
                $scores[$company_id] = $score;

            }
            
            arsort($scores);

            return $scores;
    }      
   
    
    
    
    function get_company2($ranked_comps)
    { 
        //$this->output->enable_profiler(TRUE);
        if (!empty($ranked_comps)){

               $new_ranked_comps = array();
              foreach ($ranked_comps as $row) {
                  $new_ranked_comps[]=$row['id'];
                  
              }

            $companyid_array = implode(',', $new_ranked_comps);

            //this is to make sure we retrieve the companies in the same order as their scores
            $order_array = 'ORDER BY';
            foreach ($ranked_comps as $item) {
              $order_array .= ' id = ' . $item['id'] . ' DESC,';
            }
            $order_array = trim($order_array, ',');

            $sql = 'SELECT * FROM company WHERE id IN ('.$companyid_array.') '.$order_array.'';
            $query = $this->db->query($sql);

            return $query->result_array();
            
        }


    }    
    
    function get_company3($ranked_comps)
    { 
        //$this->output->enable_profiler(TRUE);
        if (!empty($ranked_comps)){

               $new_ranked_comps = array();
              foreach ($ranked_comps as $row) {
                  $new_ranked_comps[]=$row['id'];
                  
              }

            $companyid_array = implode(',', $new_ranked_comps);

            //this is to make sure we retrieve the companies in the same order as their scores
            $order_array = 'ORDER BY';
            foreach ($ranked_comps as $item) {
              $order_array .= ' id = ' . $item['id'] . ' DESC,';
            }
            $order_array = trim($order_array, ',');

            $sql = 'SELECT * FROM company WHERE id IN ('.$companyid_array.') '.$order_array.' LIMIT 5';
            $query = $this->db->query($sql);

            return $query->result_array();
            
        }


    }      
    
    function merge_arrays(&$companyData,$companyKey, $benefitsArray)
    {
        //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData
        foreach ($benefitsArray as $key=>$value)
        {
            if ($companyData['id'] == $key)
            {
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
                $companyData['history'] = $value;
            }
        }

    } 
    
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
    
    function normalize_benefits(&$sourceCoords,$sourceKey, $isolated_benefits)
    {
    //what about division by zero?

     $min = min($isolated_benefits);
     //$min = 1;   
     $max = max($isolated_benefits);
     if (!(($min >= 0 && $min <= 1)&&($max >= 0 && $max <= 1))){
         //we're already in the range of normalization, between 0 & 1
         if ($max == $min){
             //we don't want to divide by zero...so do something else here
             echo "caught prior to dividing by zero inside of normalize_benefits";
         }else {

            $sourceCoords['benefits'] = ($sourceCoords['benefits']-$min)/($max-$min);  
         }
     }
    }    
    
    function isolate_benefits($details) {
      return $details['benefits'];
    }    
   
    function normalize_history(&$sourceCoords,$sourceKey, $isolated_history)
    {
    //what about division by zero?

     $min = min($isolated_history);
     $max = max($isolated_history);
     if (!(($min >= 0 && $min <= 1)&&($max >= 0 && $max <= 1))){
         //we're already in the range of normalization, between 0 & 1
         if ($max == $min){
             //we don't want to divide by zero...so do something else here
             echo "caught prior to dividing by zero inside of normalize_benefits";
         }else {
            $sourceCoords['history'] = ($sourceCoords['history']-$min)/($max-$min);  
         }
     }
    }         
   
    function isolate_history($details) {
      return $details['history'];
    }    
  
    function aggregate(&$sourceCoords,$sourceKey)
    {
        $aggregate_array = array();
        //$var_count = 2;

        //weights should add up to 1
        $benefits_weight = .4;
        $history_weight = .2;
        $citizenship_weight = .4;
        //$next_weight = .5;

        $aggregate_array['id'] = $sourceCoords['id'];

        $aggregate_array['ag_score'] = 
                ($sourceCoords['benefits']*$benefits_weight 
                + $sourceCoords['history']*$history_weight
                + $sourceCoords['citizenship']*$citizenship_weight
                );  

        $sourceCoords = $aggregate_array;
    }          
    
    
    
    function get_distance_matrix3($ranked_comps,$history_scoring,$corp_citizenship,$pace_array,$lifecycle_array,$history_array)
    {
        //$this->session->set_userdata('some_name', 'some_value');
        //1. Create array of data points
        //
        //user's benefit score is always perfect, so we know it is the triangular
        //number of the highest ranking 15t=>120.
        //user's citizenship score is in the post data.  Company info is in the database.    
        
        //$corp_citizenship = $this->input->post('corp_citizenship');
        //$pace_array = $this->input->post('company_pace');
        //$lifecycle_array = $this->input->post('lifecycle');
        //$history_array = $this->input->post('history');        
        
        //build the one row user coordinates array in order to measure distance from it to the companies
        //the user's coordinates are 'perfect', so the distance from user to company is what matters.
        $user_data = array();
        
        $user_data[0]['id'] = 'user';
        $user_data[0]['citizenship'] = $corp_citizenship;        
        $user_data[0]['benefits'] = 120;//hardcoded based on total max score of benefits  
        //$user_data[0]['history'] = count($history_array);//if a company has all of the user's history categories, then that would be a perfect score
        if (max($history_scoring)>0){
        $user_data[0]['history'] = max($history_scoring);//using the max score of all the companies as the 'ideal'.  this way, as the user adds more history, it won't negatively impact his matches.
        } else {
            $user_data[0]['history'] = 1;
        }

        //get the company citizenship values from the database
        $comp_ids = array_keys($ranked_comps);//company ids, along with benefit scores
        $comp_ids_imploded = implode(',', $comp_ids);
        $sql = 'SELECT id,corp_citizenship_id AS citizenship FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $company_data_array = $query->result_array();            
            
            //walk the array of company citizenship info and merge in the benefits data
            array_walk($company_data_array, array($this, 'merge_arrays'),$ranked_comps);
            
        }
        
        //walk the array of company company data and merge in the history scoring
        //$temp_comp_data = $company_data_array;
        array_walk($company_data_array, array($this, 'merge_arrays_history'),$history_scoring); 

        //create one array that includes the user coordinates along with all the companies
        //we will walk this array to determine distances
        $data = array_merge($user_data,$company_data_array);
        //$user_benefit_score = 120;
        //$user_citizenship = $this->input->post('corp_citizenship');

        //2. Transform data into coordinates
        $data_array = $data;
        //normalize citizenship data (convert to rank 1-5, then normalize)
        //our data should already be in rank 1-5
        
        //$raw_data_array = $data_array;
        file_put_contents('temp_arrays/raw_array.txt', serialize($data_array)); 
        
        foreach ($data_array as &$row)
        {
            $row['citizenship']=($row['citizenship']-1)/(5-1);
        }
        $data_array_copy = $data_array;

        //3. Calculate distance for each variable
        file_put_contents('temp_arrays/coord_array.txt', serialize($data_array));      
        
        array_walk($data_array, array($this,'city_block_distance_benefits'),$data);   
        array_walk($data_array, array($this,'city_block_distance_history'),$data); 
        array_walk($data_array, array($this,'city_block_distance_citizenship'),$data_array_copy);      

        file_put_contents('temp_arrays/dist_array.txt', serialize($data_array));

        //4. Normalize each variable's distance
        //for quantitative data: norm = (d-dmin)/(dmax-dmin)
        //for ordinal data, with rank of 1-5: norm = (r-1)/(R-1)
        
        $isolated_benefits = array_map(array($this,'isolate_benefits'), $data_array);  

        array_walk($data_array, array($this,'normalize_benefits'),$isolated_benefits);   
        
        //now, for history:
        $isolated_history = array_map(array($this,'isolate_history'), $data_array);         
        
        $min_history = min($isolated_history);
        $max_history = max($isolated_history);
        
        if (!(($min_history >= 0 && $min_history <= 1)&&($max_history >= 0 && $max_history <= 1))){
            //check to make sure we aren't already between 0&1
            array_walk($data_array, array($this,'normalize_history'),$isolated_history);          
        }

        //$norm_disp_array = $data_array;
        file_put_contents('temp_arrays/norm_disp_array.txt', serialize($data_array));

        //5. Aggregate the normalized distance matrix
        //assuming each feature variable has the same weight, sum them up then divide
        //by the number of feature variables

        array_walk($data_array, array($this,'aggregate')); 
        
        file_put_contents('temp_arrays/aggregate_array.txt', serialize($data_array));
        
        unset($data_array[0]);

        //$aggregate_array = $data_array;
        //file_put_contents('temp_arrays/aggregate_array.txt', serialize(array_values($data_array)));
        
        //sort the array
        foreach ($data_array as $array) {
            $agscore[] = $array['ag_score'];
        }

        array_multisort($agscore,SORT_NUMERIC,SORT_ASC,$data_array);
        //echo '<pre>sorted:<br>',print_r($data_array,1),'</pre>';         
        
        /* commented out by BLC on 3-26-13
        $dist_data = array();
        $dist_data['ranked_results']   = $data_array;

        return $dist_data;
         * 
        */
        return $data_array;
        
    }//END OF get_distance_matrix FUNCTION
    
    function fit_score($ranked_results)
    {
        foreach ($ranked_results as &$company_row) {
            $company_row['ag_score'] = round(1 - $company_row['ag_score'],3);
            
        }
        $ranked_results_copy = $ranked_results;
        //echo '<pre>fit scored up!:<br>',print_r($ranked_results,1),'</pre>'; 
        file_put_contents('temp_arrays/fit_array.txt', serialize($ranked_results_copy));
        
        return $ranked_results;
    }

    function merge_fit_arrays(&$companyData,$companyKey, $companyFit)
    {
        //when the 'id' of companyData equals the key of benefitsArray, add the 'benefits' key=>value to companyData

        foreach ($companyFit as $value)
        {
            if ($value['id']==$companyData['id'])
            {
            $companyData['fit_score'] = $value['ag_score'];
            }

        }
    }      
    
    
    function merge_company_info($company_info,$company_fit)
    {
        array_walk($company_info, array($this,'merge_fit_arrays'),$company_fit);
        return $company_info;       
    }
    
    function save_user_inquiry()
    {
 
    }
    
    function insert_matches($company_fit)
    {
        //build new array for db insertion
        //
        //$user_id = $this->session->userdata('user_id');
        $user_id = 3;//hard code for now
        
        $new_array = array();
        foreach ($company_fit as $key=>$value) {          
            $new_array[$key]['user_id'] = $user_id;
            $new_array[$key]['company_id'] = $value['id'];
            $new_array[$key]['score'] = ($value['ag_score']*100);
        }   
        
        $query = $this->db->insert_batch('user_matches', $new_array); 
        return $query;        
    }    
    
}

