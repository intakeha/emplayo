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
        $sql = 'SELECT id,name FROM ref_category';
        $query = $this->db->query($sql);
        
      //transformation  
        $newarray = array();
        foreach($query->result_array() as $mainkey=>$row)
        {
            foreach ($row as $key=>$value)
            {              
                if ($key=='id')
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
                WHERE bt.category_id = t.id
                AND (t.id IN ('.$categories.'))
                AND b.id = bt.company_id
                GROUP BY b.id';

        $query = $this->db->query($sql);

        foreach ($query->result_array() as $row)
        {
            /*print_r($row['company_name']);
            echo '<br>';*/
        }

    }
    
    function validate_education_array($education_array)
    {
     //walk through each value...and if each value is not empty, copy it to a new array
     //after we walk through the entire array, then count its size.  if greater than zero, 
     //then this is a valid array with info
        
        $counter = 0;
        foreach ($education_array as $key=>$value)
        {
            if ((!empty ($value['school_id'])) OR (!empty ($value['school_name']))){
                $counter++;
            }  
        }
        if ($counter > 0)
        {
            //at least one of the school IDs or names was not empty
            //so, the array contains valid data
            //this should be extended to actually validate the data values, types, etc.
            return TRUE;
        }
        else
        {
            return FALSE;
        }
        
    }
    
    function validate_work_array($work_array)
    {
     //walk through each value...and if each value is not empty, copy it to a new array
     //after we walk through the entire array, then count its size.  if greater than zero, 
     //then this is a valid array with info
        
        $counter = 0;
        foreach ($work_array as $key=>$value)
        {
            if ((!empty ($value['company_id'])) OR (!empty ($value['company_name']))){
                $counter++;
            }
        }
        if ($counter > 0)
        {
            //at least one of the school IDs or names was not empty
            //so, the array contains valid data
            //this should be extended to actually validate the data values, types, etc.
            return TRUE;
        }
        else
        {
            return FALSE;
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
                WHERE bt.category_id = t.id
                AND (t.id IN ('.$categories.'))
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
                WHERE bt.category_id = t.id
                AND (t.id IN ('.$categories.'))
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
 
    function industry_filter_dummy($industry)
    {
        //find companies that match the DO NEXT categories
        $categories = implode(',', $industry);

        $sql = 'SELECT id FROM company';
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
    
    function toggle_filters_dummy($company_list,$type_array,$pace_array,$lifecycle_array)
    {
        $sql = 'SELECT id,company_name FROM company';        
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

    function prev_job_ids($user_work)
    {            
        //walk through user_work array and pull out the historical job types
        $prev_job_ids = array();
        foreach ($user_work as $key=>$value)
        {
            //6-30-13: was previously using job_type, but it should be job_id...
            $prev_job_ids[$key] = $value['job_id'];
        }
        
        return $prev_job_ids;
    }
    
    function history_scoring($queried_comp_ids,$user_history_cats)
    {            
            //get all the companies (that meet the previous criteria) and their associated benefits
            $sql2 = 'SELECT company_id,category_id FROM company_category WHERE company_id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);            
        
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
   
    function type_scoring($queried_comp_ids,$user_type)
    {            
            //get all the companies (that meet the previous criteria) and their associated benefits
            $sql2 = 'SELECT id,type_id FROM company WHERE id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);

            //build an array with a specific format to be used in the upcoming scoring process
            $company_set = array();
            foreach ($query2->result_array() as $row) {
                $company_set[$row['id']][]=$row['type_id'];
            }

            $scores = array();
            // For every company, we will assign it a score based on how many
            // of the user's choices it has.  Each match is worth 1 point.
            
            foreach($company_set as $company_id => $array_row)
            {   
                $score = 0;
                foreach ($array_row as $key=>$type_id)
                {
                    //we walk through the array that contains each company's type(s)
                    //then, we search for each type in the user's choices.  if we find
                    //a match, we give the company a point. and so on...
                    
                    if (in_array($type_id, $user_type, true)){
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
    

    function industry_scoring($queried_comp_ids,$user_industry_cats)
    {            
            //get all the companies
            $sql2 = 'SELECT company_id,category_id FROM company_category WHERE company_id IN ('.$queried_comp_ids.')';
            $query2 = $this->db->query($sql2);
            
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
                    
                    if (in_array($category_id, $user_industry_cats, true)){
                        ++$score;
                    }                    
                }
                //added the following line to limit max score to 1
                //if ($score >1){$score=1;}
                //end of added line
                $scores[$company_id] = $score;
                
            }            
            arsort($scores);
            return $scores;
    }        
    
    function get_company2($ranked_comps)
    { 
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
    
    function get_company3($ranked_comps, $limit = 5)
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

            $sql = 'SELECT * FROM company WHERE id IN ('.$companyid_array.') '.$order_array.' LIMIT '.$limit.'';
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
    
    function merge_arrays_pace(&$companyData,$companyKey, $paceArray)
    {
        foreach ($paceArray as $key=>$row)
        {
            if ($companyData['id'] == $row['id'])
            {
                $companyData['pace'] = $row['pace'];
            }
        }
    }  
    
    function merge_arrays_lifecycle(&$companyData,$companyKey, $lifecycleArray)
    {
        foreach ($lifecycleArray as $key=>$row)
        {
            if ($companyData['id'] == $row['id'])
            {
                $companyData['lifecycle'] = $row['lifecycle'];
            }
        }
    }      

    function merge_arrays_type(&$companyData,$companyKey, $typeArray)
    {
        foreach ($typeArray as $key=>$value)
        {
            if ($companyData['id'] == $key)
            {
                $companyData['type'] = $value;
            }
        }
    }       
    
    function merge_arrays_industry(&$companyData,$companyKey, $industryArray)
    {
        foreach ($industryArray as $key=>$value)
        {
            if ($companyData['id'] == $key)
            {
                $companyData['industry'] = $value;
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

    function city_block_distance_type(&$sourceCoords,$sourceKey, $data_array_copy)
    {
        $user_type_score = $data_array_copy[0]['type'];   
        $sourceCoords['type'] = abs($sourceCoords['type']-$user_type_score);   
    }       

    function city_block_distance_industry(&$sourceCoords,$sourceKey, $data)
    {        
        $user_industry_score = $data[0]['industry'];
        $sourceCoords['industry'] = abs($sourceCoords['industry']-$user_industry_score);
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
    
    function normalize_industry(&$sourceCoords,$sourceKey, $isolated_industry)
    {
    //what about division by zero?

     $min = min($isolated_industry);
     //$min = 1;   
     $max = max($isolated_industry);
     if (!(($min >= 0 && $min <= 1)&&($max >= 0 && $max <= 1))){
         //we're already in the range of normalization, between 0 & 1
         if ($max == $min){
             //we don't want to divide by zero...so do something else here
             echo "caught prior to dividing by zero inside of normalize_industry";
         }else {

            $sourceCoords['industry'] = ($sourceCoords['industry']-$min)/($max-$min);  
         }
     }
    }     
    
    function isolate_benefits($details) {
      return $details['benefits'];
    }    

    function isolate_industry($details) {
      return $details['industry'];
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
 
    function aggregate2(&$sourceCoords,$sourceKey)
    {
        $aggregate_array = array();
        //weights should add up to 1
        $benefits_weight = .2;
        $citizenship_weight = .1;
        $pace_weight = .1;
        $lifecycle_weight = .1;
        $type_weight = .2;
        $industry_weight = .3;

        $aggregate_array['id'] = $sourceCoords['id'];

        $aggregate_array['ag_score'] = 
                ($sourceCoords['benefits']*$benefits_weight
                + $sourceCoords['citizenship']*$citizenship_weight
                + $sourceCoords['pace']*$pace_weight
                + $sourceCoords['lifecycle']*$lifecycle_weight
                + $sourceCoords['type']*$type_weight
                + $sourceCoords['type']*$industry_weight
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
        if (!is_dir("temp_arrays")) {
          // dir doesn't exist, make it
          mkdir("temp_arrays");
        }              
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

    function get_distance_matrix4($benefit_scoring,$corp_citizenship,$pace_array,$lifecycle_array,$user_industry,$user_type,$type_scoring,$industry_scoring)
    {

        /*
         * 1. CREATE ARRAY OF DATA POINTS
         * user's benefit score is always perfect, so we know it is the triangular
         * number of the highest ranking 15t=>120.
         * build the one row user coordinates array in order to measure distance from it to the companies
         * the user's coordinates are 'perfect', so the distance from user to company is what matters.
         */
            $user_avg_pace = $this->calculate_average($pace_array);
            $user_avg_lifecycle = $this->calculate_average($lifecycle_array);
            $user_max_industry_score = count($user_industry);
            
            $user_data = array();       
            $user_data[0]['id'] = 'user';
            $user_data[0]['citizenship'] = $corp_citizenship;        
            $user_data[0]['benefits'] = 120;//hardcoded based on total max score of benefits  
            $user_data[0]['pace'] = $user_avg_pace;
            $user_data[0]['lifecycle'] = $user_avg_lifecycle;
            $user_data[0]['type'] = 1;//hardcoded based on max score of type
            $user_data[0]['industry'] = $user_max_industry_score;

            //Merge the company citizenship values with the benefits scoring array
            //a. BENEFITS + 
            //b. CITIZENSHIP
            $company_data_array = $this->citizenship_merge($benefit_scoring);
            //c. PACE
            $company_data_array = $this->pace_merge($benefit_scoring,$company_data_array);
            //d. LIFECYCLE
            $company_data_array = $this->lifecycle_merge($benefit_scoring,$company_data_array);
            //e. TYPE
            $company_data_array = $this->type_merge($type_scoring,$company_data_array);
            //f. INDUSTRY
            $company_data_array = $this->industry_merge($industry_scoring,$company_data_array);
            
            //MERGE USER DATA
            $data = array_merge($user_data,$company_data_array);

            //writing to temp arrays for troubleshooting and diagnostics.
            $this->write_temp_arrays('raw_array',$data);
        
        /*
         * 2. TRANSFORM DATA INTO COORDINATES
         */
            $data_array = $data;//make a copy of the $data array
            //normalize citizenship data (convert to rank 1-max, then normalize)    
            foreach ($data_array as &$row)
            {
                $row['citizenship']=($row['citizenship']-1)/(5-1);//5 is max citizenship value in db
                $row['pace']=($row['pace']-1)/(3-1);//3 is max pace value in db
                $row['lifecycle']=($row['lifecycle']-1)/(5-1);//5 is max lifecycle "value" in db
                //type is constrained to a range of 0-1. already normalized
                //treat industry like benefits...skip this
            }
            $this->write_temp_arrays('coord_array',$data_array);

            $data_array_copy = $data_array;//make a copy of the $data_array
            $data_array_copy2 = $data_array;//make a copy of the $data_array for pace operations
            $data_array_copy3 = $data_array;//make a copy of the $data_array for lifecycle operations
            $data_array_copy4 = $data_array;//make a copy of the $data_array for type operations
            $data_array_copy5 = $data_array;//make a copy of the $data_array for industry operations
        
        /*
         * 3. Calculate distance for each variable
         */
            array_walk($data_array, array($this,'city_block_distance_benefits'),$data);   
            array_walk($data_array, array($this,'city_block_distance_citizenship'),$data_array_copy);
            array_walk($data_array, array($this,'city_block_distance_pace'),$data_array_copy2);
            array_walk($data_array, array($this,'city_block_distance_lifecycle'),$data_array_copy3);
            array_walk($data_array, array($this,'city_block_distance_type'),$data_array_copy4);
            array_walk($data_array, array($this,'city_block_distance_industry'),$data_array_copy5);

            $this->write_temp_arrays('dist_array',$data_array);

        /*
         * 4. Normalize each variable's distance (scale of 0-1)
         * for quantitative data: norm = (d-dmin)/(dmax-dmin)
         * for ordinal data, with rank of 1-5: norm = (r-1)/(R-1)
         */
            //BENEFITS
            $isolated_benefits = array_map(array($this,'isolate_benefits'), $data_array);  
            array_walk($data_array, array($this,'normalize_benefits'),$isolated_benefits);   
            //CITIZENSHIP - already normalized (0-1)
            //PACE - already normalized (0-1)
            //LIFECYCLE - already normalized (0-1)
            //TYPE - already normalized (0-1)
            //INDUSTRY
            $isolated_industry = array_map(array($this,'isolate_industry'), $data_array);
            array_walk($data_array, array($this,'normalize_industry'),$isolated_industry);

            $this->write_temp_arrays('norm_disp_array',$data_array);

            
        /*
         * 5. Aggregate the normalized distance matrix
         */    
            //BENEFITS
            //CITIZENSHIP 
            //PACE
            //LIFECYCLE
            //TYPE
            //INDUSTRY

            array_walk($data_array, array($this,'aggregate2')); 

            $this->write_temp_arrays('aggregate_array',$data_array);

            unset($data_array[0]);

            //sort the array
            foreach ($data_array as $array) {
                $agscore[] = $array['ag_score'];
            }

            array_multisort($agscore,SORT_NUMERIC,SORT_ASC,$data_array);
            

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
    
    function write_temp_arrays($name,$array){
        if (!is_dir("temp_arrays")) {
          mkdir("temp_arrays");
        }              
        file_put_contents('temp_arrays/'.$name.'.txt', serialize($array));         
    }
    
    function citizenship_merge($benefit_scoring){
        //get the company citizenship values from the database
        $comp_ids = array_keys($benefit_scoring);//company ids, along with benefit scores
        $comp_ids_imploded = implode(',', $comp_ids);
        $sql = 'SELECT id,corp_citizenship_id AS citizenship FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $company_data_array = $query->result_array();            
            //echo '<pre>citizenship array before merge:<br>',print_r($company_data_array,1),'</pre>';
            //walk the array of company citizenship info and merge in the benefits data
            array_walk($company_data_array, array($this, 'merge_arrays'),$benefit_scoring);
            
            return $company_data_array;

        } else {
            return FALSE;
        }    
    } 
    
    function pace_merge($benefit_scoring,$full_company_array){
        //get the company pace values from the database
        $comp_ids = array_keys($benefit_scoring);//company ids, along with benefit scores
        $comp_ids_imploded = implode(',', $comp_ids);
        $sql = 'SELECT id,pace_id AS pace FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $pace_array = $query->result_array();            
            //walk the array of pace info and merge in the benefits data
            array_walk($full_company_array, array($this, 'merge_arrays_pace'),$pace_array);
            //echo '<pre>company data after pace merge:<br>',print_r($full_company_array,1),'</pre>';
            return $full_company_array;

        } else {
            return FALSE;
        }    
    }  
    
    function lifecycle_merge($benefit_scoring,$full_company_array){
        //get the company lifecycle values from the database
        $comp_ids = array_keys($benefit_scoring);//company ids, along with benefit scores
        $comp_ids_imploded = implode(',', $comp_ids);
        $sql = 'SELECT id,lifecycle_id AS lifecycle FROM company where id IN ('.$comp_ids_imploded.')';
        //run the query
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            $lifecycle_array = $query->result_array();    
            //echo '<pre>lifecycle_array:<br>',print_r($lifecycle_array,1),'</pre>';
            //walk the array of lifecycle info and merge in the full data array
            array_walk($full_company_array, array($this, 'merge_arrays_lifecycle'),$lifecycle_array);
            //echo '<pre>company data after pace merge:<br>',print_r($full_company_array,1),'</pre>';
            return $full_company_array;

        } else {
            return FALSE;
        }    
    }       
    
    function type_merge($type_scoring,$full_company_array){

            array_walk($full_company_array, array($this, 'merge_arrays_type'),$type_scoring);
            //echo '<pre>company data after pace merge:<br>',print_r($full_company_array,1),'</pre>';
            return $full_company_array;

    }      
 
    function industry_merge($industry_scoring,$full_company_array){

            array_walk($full_company_array, array($this, 'merge_arrays_industry'),$industry_scoring);
            //echo '<pre>company data after pace merge:<br>',print_r($full_company_array,1),'</pre>';
            return $full_company_array;

    }       
    
    
    function calculate_average($arr) {
        $count = count($arr); //total numbers in array
        $total = 0;
        foreach ($arr as $value) {
            $total = $total + $value; // total value of array numbers
        }
        $average = ($total/$count); // get average value
        return $average;
    }    
    
}

