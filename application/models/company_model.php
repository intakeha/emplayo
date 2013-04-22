<?php
class Company_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
        
        $this->messages = array();
        $this->errors = array();
    }
    /**
    * Get Company List
    * This function simply gets a list of all companies in the company table
    *
    * @param void
    * @return array
    **/ 
    function get_company_list()
    {
        $query = $this->db->query("SELECT id,company_name,company_url,update_time FROM company");       
        return $query;
    }
    
    function count_seed_completion($query){
        $new_array = array();
        $logo_count_needed = 2;
        $url_count_needed = 4;
        $core_data_count_needed = 6;
        $profile_pics_count_needed = 8;
        $quotes_count_needed = 4;
        $completion_base = 5;//total number of areas we're counting
        
        
        
        foreach ($query->result() as $key=>$value) {
            $logo_count = 0;
            $logo_done = FALSE;
            $url_count = 0;
            $url_done = FALSE;
            $core_data_count = 0;
            $core_data_done = FALSE;
            $profile_pics_count = 0;
            $profile_pics_done = FALSE;
            $quotes_count = 0;
            $quotes_done = FALSE;
            $completion_count = 0;
            
            $new_array[$key]['id'] = $value->id;
            $new_array[$key]['company_name'] = $value->company_name;
            //Count URLs
            if (!empty($value->company_url)){
                $url_count++;              
            }            
            if (!empty($value->jobs_url)){
                $url_count++;              
            }
            if (!empty($value->facebook_url)){
                $url_count++;              
            }            
            if (!empty($value->twitter_url)){
                $url_count++;              
            }
            $new_array[$key]['url_count'] = $url_count;
            if ($url_count == $url_count_needed){
                $url_done = TRUE;
                $completion_count++;
            }
            
            $new_array[$key]['url_done'] = $url_done;
            
            //Count Logos
            if (!empty($value->company_logo)){
                $logo_count++;              
            }              
            if (!empty($value->creative_logo)){
                $logo_count++;              
            }            
            $new_array[$key]['logo_count'] = $logo_count; 
            if ($logo_count == $logo_count_needed){
                $logo_done = TRUE;
                $completion_count++;
            }
            $new_array[$key]['logo_done'] = $logo_done;        
            $new_array[$key]['update_time'] = $value->update_time;
            
            
            //Count Core Data
            if (!empty($value->type_id)){
                $core_data_count++;              
            }            
            if (!empty($value->pace_id)){
                $core_data_count++;              
            }              
            if (!empty($value->lifecycle_id)){
                $core_data_count++;              
            } 
            if (!empty($value->corp_citizenship_id)){
                $core_data_count++;              
            }             
            
            
            //Count Benefits
            $this->db->select('benefits_id');
            $this->db->where('company_id', $value->id);
            $this->db->from('company_benefits');
            $benefits_count = $this->db->count_all_results();
            //echo "<br>benefits count for $value->id: ". $benefits_count;
            if ($benefits_count>0){
                $core_data_count++;
            }

            //Count Category/Industry
            $this->db->select('category_id');
            $this->db->where('company_id', $value->id);
            $this->db->from('company_category');
            $category_count = $this->db->count_all_results();
            //echo "<br>benefits count for $value->id: ". $benefits_count;
            if ($category_count>0){
                $core_data_count++;
            }            
 
            $new_array[$key]['core_data_count'] = $core_data_count; 
            if ($core_data_count == $core_data_count_needed){
                $core_data_done = TRUE;
                $completion_count++;
            }
            $new_array[$key]['core_data_done'] = $core_data_done;              
            
             //Count Profile Pics
            $this->db->select('file_name');
            $this->db->where('company_id', $value->id);
            $this->db->from('company_profile_pics');
            $profile_pics_count = $this->db->count_all_results();           
            //echo "<br>profile pic count for $value->id: ". $profile_pics_count;        
 
            $new_array[$key]['profile_pics_count'] = $profile_pics_count; 
            if ($profile_pics_count >= $profile_pics_count_needed){
                $profile_pics_done = TRUE;
                $completion_count++;
            }
            $new_array[$key]['profile_pics_done'] = $profile_pics_done;             
            
             //Count Quotes
            $this->db->select('quote');
            $this->db->where('company_id', $value->id);
            $this->db->from('company_quotes');
            $quotes_count = $this->db->count_all_results();           
            //echo "<br>quotes count for $value->id: ". $quotes_count;       
            
            $new_array[$key]['quotes_count'] = $quotes_count; 
            if ($quotes_count >= $quotes_count_needed){
                $quotes_done = TRUE;
                $completion_count++;
            }
            $new_array[$key]['quotes_done'] = $quotes_done;    
            
            //Completion Score
            $completion_score = ($completion_count/$completion_base)*100;
            settype($completion_score, "integer");
            //$new_array[$key]['completion_score'] = settype($completion_score, "integer");
            $new_array[$key]['completion_score'] = $completion_score;
            
        }
        /*
        echo '<pre>';
        print_r($new_array);
        echo '</pre>';
       */ 
       
        return $new_array;
    }
    
    /**
    * Build Company Table
    * Builds a table of companies using the Codeigniter Table class
    *
    * @param int $limit, int $offset
    * @return array
    **/     
    function build_company_table($limit = 5,$offset = 0,$completion_array)
    {   
        //get the company data from the db
        $this->db->select('id, company_name, company_url, jobs_url, facebook_url,
            twitter_url, company_logo, creative_logo, type_id, pace_id, lifecycle_id, 
            corp_citizenship_id, update_time');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('company');
  
        $new_array = $this->count_seed_completion($query);
        
        //count the total number of rows (to be used for pagination)
        $num_rows = $this->db->count_all('company');
        
        //this is a default 'styling' template from the Codeigniter folks.  Can be changed to whatever...
        $tmpl = array (
                        'table_open'          => '<table border="1" cellpadding="4" cellspacing="1" class="mytable">',

                        'heading_row_start'   => '<tr class="table_heading">',
                        'heading_row_end'     => '</tr>',
                        'heading_cell_start'  => '<th>',
                        'heading_cell_end'    => '</th>',

                        'row_start'           => '<tr>',
                        'row_end'             => '</tr>',
                        'cell_start'          => '<td>',
                        'cell_end'            => '</td>',

                        'row_alt_start'       => '<tr>',
                        'row_alt_end'         => '</tr>',
                        'cell_alt_start'      => '<td>',
                        'cell_alt_end'        => '</td>',

                        'table_close'         => '</table>'
                      );

        //Apply the template to the table
        $this->table->set_template($tmpl);
        
        //set empty fields in the table to a default value
        $this->table->set_empty("&nbsp;");
        $this->table->set_caption('Companies');
        
        //Give names to each heading.  Default is the db field name
        $this->table->set_heading('Name', 'Areas','% Complete', 'Last Updated', 'Actions'); 

        
        //define each table row exactly how we want it
        /*
        foreach ($query->result() as $row) {
            //echo $row->company_name;
            $id_link = '<a href="/admin/company/update_step_1/'.$row->id.'">'.$row->id.'</a>';
            $delete_link = '<a href="/admin/company/delete/'.$row->id.'">Delete</a>';
            $edit_link = '<a href="/admin/company/update_step_1/'.$row->id.'">Edit</a>';
            $view_link = '<a href="/admin/company/view/'.$row->id.'">View</a>';
            $profile_link = '<a href="/admin/company/profile_view/'.$row->id.'">Profile</a>';
            $quotes_link = '<a href="/admin/company/quotes_view/'.$row->id.'">Quotes</a>';
            $actions_link = $view_link.'  &nbsp; '.$edit_link.'  &nbsp; '.$delete_link.'  &nbsp; '.$profile_link.'  &nbsp; '.$quotes_link;
            $this->table->add_row($row->company_name, '' ,'' ,$row->update_time,$actions_link); 
        }
        */
        foreach ($new_array as $row) {
            
            if($row['url_done'] == TRUE){
                $url_class = "url_1";
            }else {
                $url_class = "url_0";
            }
            
            if($row['logo_done'] == TRUE){
                $logo_class = "logo_1";
            }else {
                $logo_class = "logo_0";
            } 
            
            if($row['core_data_done'] == TRUE){
                $core_data_class = "core_data_1";
            }else {
                $core_data_class = "core_data_0";
            }              
            
            if($row['profile_pics_done'] == TRUE){
                $profile_pic_class = "profile_pics_1";
            }else {
                $profile_pic_class = "profile_pics_0";
            }
            
            if($row['quotes_done'] == TRUE){
                $quotes_class = "quotes_1";
            }else {
                $quotes_class = "quotes_0";
            }            
            
            $icon_field = "<img class='$url_class'/>
                <img class='$logo_class'/>
                <img class='$core_data_class'/>
                <img class='$profile_pic_class'/>
                <img class='$quotes_class'/>";
            $id_link = '<a href="/admin/company/update_step_1/'.$row['id'].'">'.$row['id'].'</a>';
            $delete_link = '<a href="/admin/company/delete/'.$row['id'].'">Delete</a>';
            $edit_link = '<a href="/admin/company/update_step_1/'.$row['id'].'">Edit</a>';
            $view_link = '<a href="/admin/company/view/'.$row['id'].'">View</a>';
            $profile_link = '<a href="/admin/company/profile_view/'.$row['id'].'">Profile</a>';
            $quotes_link = '<a href="/admin/company/quotes_view/'.$row['id'].'">Quotes</a>';
            $completion = "{$row['completion_score']}%";
            $actions_link = $view_link.'  &nbsp; '.$edit_link.'  &nbsp; '.$delete_link.'  &nbsp; '.$profile_link.'  &nbsp; '.$quotes_link;

            if (in_array($row['completion_score'], $completion_array, true)){
                $this->table->add_row($row['company_name'], $icon_field ,$completion ,$row['update_time'],$actions_link); 
            }
        }
        
        //generate the table code
        $table = $this->table->generate();

        //send an array of variables back to the controller
        return array('num_rows' => $num_rows, 'table' => $table);
    }
 
    /**
    * Get Categories
    * Fetches category reference data.
    *
    * @param void
    * @return array
    **/      
    function get_categories()
    { 
        $this->db->select('id, name');
        $query = $this->db->get('ref_category');        

      //transformation  
        $newarray = array();
        foreach($query->result_array() as $row)
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
    
    /**
    * Get Types
    * Fetches company type reference data.
    *
    * @param void
    * @return array
    **/          
    function get_types()
    { 
        $query = $this->db->get('ref_type');
        
      //build our array  
        $type_array = array();
        foreach($query->result_array() as $key=>$row)
        {
            $type_array[$key]['id'] = $row['id'];
            $type_array[$key]['type'] = $row['type'];
        }
        return $type_array;
    }     
    
    /**
    * Get Pace
    * Fetches company pace reference data.
    *
    * @param void
    * @return array
    **/          
    function get_pace()
    { 
        $query = $this->db->get('ref_pace');
        
      //build our array    
        $pace_array = array();
        foreach($query->result_array() as $key=>$row)
        {
            $type_array[$key]['id'] = $row['id'];
            $type_array[$key]['pace'] = $row['pace'];
        }
        return $pace_array;
    }
  
    /**
    * Get Ref(erence)
    * Fetches generic reference data.  Can be used for type, pace, etc
    *
    * @param void
    * @return array
    **/          
    function get_ref($ref)
    { 
        $table_name = 'ref_'.$ref;
        $query = $this->db->get($table_name);
        
      //build our array    
        $new_array = array();
        foreach($query->result_array() as $key=>$row)
        {
            $new_array[$key]['id'] = $row['id'];
            $new_array[$key][$ref] = $row[$ref];
        }
        return $new_array;
    } 
  
    /**
    * Company Exists
    * Checks to see if a company exists, based on exact name match.
    * This is not perfect, but pretty good.  Search while typing in
    * the UI also helps prevent duplicate entries.
    *
    **/          
    function company_exists($name)
    {
        $query = $this->db->get_where('company', array('company_name' => $name));
        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }     
    }
    
    /**
    * Company Name Search
    * AJAX code to check to see if a company name exists, based on
    * each letter sent on keyup in the browser
    *
    **/          
    function company_name_search($kws)
    {
        //Need to format this data into an array and pass it back to the controller->view...
        //should not echo from the model...
        //http://www.invlessons.com/live-search-using-jquery-ajax/
        
        $this->db->select('company_name, id');
        $this->db->like('company_name', $kws, 'after');
        $this->db->limit('10');
        $query = $this->db->get('company');
        $count = $query->num_rows();
  
        $i = 0;
        if($count > 0)
        {      
            echo "<ul>";
            foreach($query->result_array() as $row)
            {
                echo '<a href="update_step_1/'.$row['id'].'">'.$row['company_name'].'</a><br>';
              $i++;
              if($i == 5) break;
            }
            echo "</ul>";
            if($count >= 5)
            {
              echo "<div id='view_more'><a href='#'>View more results</a></div>";
              //Need to code this to display the full list...
            }            
        }
        else
        {
        echo "<div id='no_result'>No result found !</div>";
        }          
    }    
 
    /**
    * Create Company
    * Checks to see if a company exists.
    *
    **/        
    function create_company($post)
    { //NEED TO ESCAPE THE USER INPUT!!!

        //build array based on (dirty) user input
        //will be escaped by using active record insert below
        //and/or query bindings...
        $company_array = array(
            'company_name' => $post['company_name'],
            'company_url' => $post['company_url'],
            'jobs_url' => $post['jobs_url'],
            'facebook_url' => $post['facebook_url'],
            'twitter_url' => $post['twitter_url'],
            'company_logo' => $post['company_logo'],
            'creative_logo' => $post['creative_logo'],
            'type_id' => $post['company_type'],
            'pace_id' => $post['company_pace'],
            'lifecycle_id' => $post['company_lifecycle'],
            'corp_citizenship_id' => $post['corp_citizenship'],
            'update_time' => date('Y-m-d H:i:s') 
        );   
        
        //Check to make sure company does not alrady exist
        if ($this->company_exists($post['company_name']))
        {
            $this->set_error('Company Name already exists');
            return FALSE;
        }
        else 
        {
            //START A TRANSACTION, SO ALL INSERTS MUST SUCCEED OR EVERYTHING IS ROLLED BACK
            $this->db->trans_start();

                //INSERT COMPANY DATA (escaped using Active Records)
                $this->db->insert('company', $company_array);

                //grab the id of this inserted record to use later...
                $company_id = $this->db->insert_id();

                //BUILD PROPERLY FORMATTED ARRAY FOR BENEFITS INSERT
                $new_benefits_array = array();
                foreach ($post['benefits'] as $key=>$value)
                {
                    $new_benefits_array[$key]['company_id'] = $company_id;
                    $new_benefits_array[$key]['benefits_id'] = $value;
                } 
                //INSERT BENEFITS DATA (escaped using Active Records)
                $this->db->insert_batch('company_benefits', $new_benefits_array);

                //BUILD PROPERLY FORMATTED ARRAY FOR CATEGORY INSERT
                $new_category_array = array();
                foreach ($post['category'] as $key=>$value)
                {
                    $new_category_array[$key]['company_id'] = $company_id;
                    $new_category_array[$key]['category_id'] = $value;
                }           
                //INSERT CATEGORY DATA (escaped using Active Records)
                $this->db->insert_batch('company_category', $new_category_array);

            //COMMIT ALL OF THE UPDATES
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                $this->set_error('Unable to create new company record');
                return FALSE;
            }
            else 
            {
                return TRUE;
            }
        }
    }//end of create_company
    
    function update_company($post,$id)
    {
        //NEED TO ESCAPE THE USER INPUT!!!

        //NEED TO FINALIZE HOW TO DEAL WITH 'UPDATED' IMAGE FILES:
        //In the view, the user should be able to see the image file, and possibly edit it, 
        //using Chon's Woorus code.  If they make changes, we update.  If not, no need to...
        //If we upload a new file, or change it, then we need to delete the old one.
        //http://stackoverflow.com/questions/5454044/deleting-files-using-codeigniter
            
        //this user input is dirty.  we will use active records to escape the data and make
        // it safe for db insertion.
        $company_array = array(
            'company_name' => $post['company_name'],
            'company_url' => $post['company_url'],
            'jobs_url' => $post['jobs_url'],
            'facebook_url' => $post['facebook_url'],
            'twitter_url' => $post['twitter_url'],            
            'company_logo' => $post['company_logo'],
            'creative_logo' => $post['creative_logo'],
            'type_id' => $post['company_type'],
            'pace_id' => $post['company_pace'],
            'lifecycle_id' => $post['company_lifecycle'],
            'corp_citizenship_id' => $post['corp_citizenship'],
            'update_time' => date('Y-m-d H:i:s') 
        );   
        
        // check to ensure the company exists prior to trying to update it
        if (!$this->company_exists($post['company_name']))
        {
            $this->set_error('Company does not exist');
            return FALSE;
        }
        else 
        {
            //BEGIN A TRANSACTION, SO ALL UPDATES MUST SUCCEED OR EVERYTHING IS ROLLED BACK:
            $this->db->trans_start();

            //UPDATE COMPANY DATA
            $this->db->where('id', $id);
            $this->db->update('company', $company_array);

            //BUILD PROPERLY FORMATTED ARRAY FOR BENEFITS INSERT
            foreach ($post['benefits'] as $key=>$value)
            {
                $insert_ben_array[] = '('.$id.','.$value.')';
            }                        
            $imploded_ins_benefits = implode(',', $insert_ben_array);     
            
            // array to be used for deleting old benefit selections
            // same data as array above, but using a different format
            // 
            $new_benefits = $post['benefits'];
            $imploded_new_benefits = implode(',',$new_benefits);
            
            //UPDATE BENEFITS DATA
            //
            //based on http://stackoverflow.com/questions/548541/insert-ignore-vs-insert-on-duplicate-key-update
            //http://stackoverflow.com/questions/9384974/update-tag-mapping-table-in-mysql
            //http://stackoverflow.com/questions/9334766/updating-in-a-many-to-many-relationship
            //http://stackoverflow.com/questions/8637691/best-practice-for-many-to-many-data-mapping
            //
            //first delete all the rows that are not in the new set
            //$sql = "DELETE FROM company_benefits WHERE company_id = ? AND benefits_id NOT IN (?)"; 
            //$this->db->query($sql, array($id, $imploded_new_benefits));
            
            //then insert all the new benefits that are not in the db for this company
            //manually escaping these inputs since we cannot use active records or query binding on the sql statements
            //either method causes the addition of an extra pair of enclosing quotes which causes a sql syntax error.
            $imploded_ins_benefits = $this->db->escape_str($imploded_ins_benefits);
            $imploded_new_benefits = $this->db->escape_str($imploded_new_benefits);
            
            $sql_del_ben = "DELETE FROM company_benefits WHERE company_id = $id AND benefits_id NOT IN ($imploded_new_benefits)";
            $sql_ins_ben = "INSERT INTO company_benefits (company_id,benefits_id) VALUES $imploded_ins_benefits ON DUPLICATE KEY UPDATE company_id=company_id";

            //execute the queries
            $this->db->query($sql_del_ben);
            $this->db->query($sql_ins_ben); 

            
            //BUILD PROPERLY FORMATTED ARRAY FOR CATEGORY UPDATE  
            foreach ($post['category'] as $key=>$value)
            {
                $insert_cat_array[] = '('.$id.','.$value.')';
            }                        
            $imploded_ins_category = implode(',', $insert_cat_array);   
            
            // array to be used for deleting old category selections
            // same data as array above, but using a different format
            $new_categories = $post['category'];
            $imploded_new_categories = implode(',',$new_categories);  
    
            //manually escape the data
            $imploded_ins_category = $this->db->escape_str($imploded_ins_category);
            $imploded_new_categories = $this->db->escape_str($imploded_new_categories);            
            
            //first delete all the rows that are not in the new set
            $sql_del_cat = "DELETE FROM company_category WHERE company_id = $id AND category_id NOT IN ($imploded_new_categories)";
            $sql_ins_cat = "INSERT INTO company_category (company_id,category_id) VALUES $imploded_ins_category ON DUPLICATE KEY UPDATE company_id=company_id";

            //execute the queries
            $this->db->query($sql_del_cat);
            $this->db->query($sql_ins_cat); 

            //COMMIT ALL OF THE UPDATES
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->set_error('Unable to update company record');
                return FALSE;
            }
            else 
            {
                return TRUE;
            }
            
        }
        
    }//end of update_company
 
    function update_company_flexible($post,$id)
    {
        //NEED TO ESCAPE THE USER INPUT!!!

        //NEED TO FINALIZE HOW TO DEAL WITH 'UPDATED' IMAGE FILES:
        //In the view, the user should be able to see the image file, and possibly edit it, 
        //using Chon's Woorus code.  If they make changes, we update.  If not, no need to...
        //If we upload a new file, or change it, then we need to delete the old one.
        //http://stackoverflow.com/questions/5454044/deleting-files-using-codeigniter
            
        //this user input is dirty.  we will use active records to escape the data and make
        // it safe for db insertion.
        $company_array = array(
            'company_name' => $post['company_name'],
            'company_url' => $post['company_url'],
            'jobs_url' => $post['jobs_url'],
            'facebook_url' => $post['facebook_url'],
            'twitter_url' => $post['twitter_url'],            
            'company_logo' => $post['company_logo'],
            'creative_logo' => $post['creative_logo'],
            'type_id' => $post['company_type'],
            'pace_id' => $post['company_pace'],
            'lifecycle_id' => $post['company_lifecycle'],
            'corp_citizenship_id' => $post['corp_citizenship'],
            'update_time' => date('Y-m-d H:i:s') 
        );   
        
        // check to ensure the company exists prior to trying to update it
        if (!$this->company_exists($post['company_name']))
        {
            $this->set_error('Company does not exist');
            return FALSE;
        }
        else 
        {
            //BEGIN A TRANSACTION, SO ALL UPDATES MUST SUCCEED OR EVERYTHING IS ROLLED BACK:
            $this->db->trans_start();

            //UPDATE COMPANY DATA
            $this->db->where('id', $id);
            $this->db->update('company', $company_array);

            //BUILD PROPERLY FORMATTED ARRAY FOR BENEFITS INSERT
            if ($post['benefits']) 
                {
                foreach ($post['benefits'] as $key=>$value)
                {
                    $insert_ben_array[] = '('.$id.','.$value.')';
                }                        
                $imploded_ins_benefits = implode(',', $insert_ben_array);     

                // array to be used for deleting old benefit selections
                // same data as array above, but using a different format
                // 
                $new_benefits = $post['benefits'];
                $imploded_new_benefits = implode(',',$new_benefits);

                //UPDATE BENEFITS DATA
                //
                //based on http://stackoverflow.com/questions/548541/insert-ignore-vs-insert-on-duplicate-key-update
                //http://stackoverflow.com/questions/9384974/update-tag-mapping-table-in-mysql
                //http://stackoverflow.com/questions/9334766/updating-in-a-many-to-many-relationship
                //http://stackoverflow.com/questions/8637691/best-practice-for-many-to-many-data-mapping
                //
                //first delete all the rows that are not in the new set
                //$sql = "DELETE FROM company_benefits WHERE company_id = ? AND benefits_id NOT IN (?)"; 
                //$this->db->query($sql, array($id, $imploded_new_benefits));

                //then insert all the new benefits that are not in the db for this company
                //manually escaping these inputs since we cannot use active records or query binding on the sql statements
                //either method causes the addition of an extra pair of enclosing quotes which causes a sql syntax error.
                $imploded_ins_benefits = $this->db->escape_str($imploded_ins_benefits);
                $imploded_new_benefits = $this->db->escape_str($imploded_new_benefits);

                $sql_del_ben = "DELETE FROM company_benefits WHERE company_id = $id AND benefits_id NOT IN ($imploded_new_benefits)";
                $sql_ins_ben = "INSERT INTO company_benefits (company_id,benefits_id) VALUES $imploded_ins_benefits ON DUPLICATE KEY UPDATE company_id=company_id";

                //execute the queries
                $this->db->query($sql_del_ben);
                $this->db->query($sql_ins_ben); 
            }
            
            //BUILD PROPERLY FORMATTED ARRAY FOR CATEGORY UPDATE  
            if ($post['category'])
            {
                foreach ($post['category'] as $key=>$value)
                {
                    $insert_cat_array[] = '('.$id.','.$value.')';
                }                        
                $imploded_ins_category = implode(',', $insert_cat_array);   

                // array to be used for deleting old category selections
                // same data as array above, but using a different format
                $new_categories = $post['category'];
                $imploded_new_categories = implode(',',$new_categories);  

                //manually escape the data
                $imploded_ins_category = $this->db->escape_str($imploded_ins_category);
                $imploded_new_categories = $this->db->escape_str($imploded_new_categories);            

                //first delete all the rows that are not in the new set
                $sql_del_cat = "DELETE FROM company_category WHERE company_id = $id AND category_id NOT IN ($imploded_new_categories)";
                $sql_ins_cat = "INSERT INTO company_category (company_id,category_id) VALUES $imploded_ins_category ON DUPLICATE KEY UPDATE company_id=company_id";

                //execute the queries
                $this->db->query($sql_del_cat);
                $this->db->query($sql_ins_cat); 
            }
            //COMMIT ALL OF THE UPDATES
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE)
            {
                $this->set_error('Unable to update company record');
                return FALSE;
            }
            else 
            {
                return TRUE;
            }
            
        }
        
    }//end of update_company    
    
    /**
    * Company Exists
    * Checks to see if a company exists, based on exact name match.
    * This is not perfect, but pretty good.  Search while typing in
    * the UI also helps prevent duplicate entries.
    *
    **/          
    function delete_company($company_id)
    {
        
        $this->db->where('id', $company_id);
        $this->db->delete('company');        
        
         return (bool)($this->db->affected_rows() > 0);
        /*
            //BEGIN A TRANSACTION, SO ALL UPDATES MUST SUCCEED OR EVERYTHING IS ROLLED BACK:
            $this->db->trans_start();   
            
            //DELETE THE FOLLOWING INFO:
            //

            //COMMIT ALL OF THE UPDATES
            $this->db->trans_complete();            
            
            if ($this->db->trans_status() === FALSE)
            {
                //$this->set_error('Unable to update company record');
                return FALSE;
            }
            else 
            {
                return TRUE;
            }       
            */
    }    
    
    public function get_company_info($id)
    {
        //using the company_id ($id), need to get and return the following:
        //from COMPANY: company_name, company_url, company_logo, type_id, pace_id, lifecycle_id
        //corp_citizenship_id
        //from BENEFITS: benefits_id[]
        //from CATEGORY: category_id[]

        $query = $this->db->get_where('company', array('id' => $id));
        $company_array = array();
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $company_array['company_name'] = $row->company_name;
              $company_array['company_url'] = $row->company_url;
              $company_array['jobs_url'] = $row->jobs_url;
              $company_array['facebook_url'] = $row->facebook_url;
              $company_array['twitter_url'] = $row->twitter_url;
              $company_array['company_logo'] = $row->company_logo;
              $company_array['creative_logo'] = $row->creative_logo;
              $company_array['type_id'] = $row->type_id;
              $company_array['pace_id'] = $row->pace_id;
              $company_array['lifecycle_id'] = $row->lifecycle_id;
              $company_array['corp_citizenship_id'] = $row->corp_citizenship_id;
              
           }
           return $company_array;
        }        
    }
    
    public function get_benefits_info($id)
    {
        //using the company_id ($id), need to get and return the following:
        //from COMPANY_BENEFIT: benefits_id[]

        $query = $this->db->get_where('company_benefits', array('company_id' => $id));
        
        //format the results
        $benefits_array = array();
        if ($query->num_rows() > 0)
        {  
            foreach($query->result_array() as $outer_key => $array)
            { 
                $benefits_array[] = $array['benefits_id']; 
            } 
           return $benefits_array;
        }        
    }   
    
    public function get_categories_info($id)
    {
        //using the company_id ($id), need to get and return the following:
        //from COMPANY_CATEGORY: category_id[]

        $query = $this->db->get_where('company_category', array('company_id' => $id));
        
        //format the results
        $category_array = array();
        if ($query->num_rows() > 0)
        {  
            foreach($query->result_array() as $outer_key => $array)
            { 
                $category_array[] = $array['category_id']; 
            } 
           return $category_array;
        }        
    }     

    function insert_profile_pics($company_id,$pic_shape,$cropped_image_name)
    {
        $data = array(
           'company_id' => $company_id,
           'pic_shape' => $pic_shape,
           'file_name' => $cropped_image_name
        );
        $query = $this->db->insert('company_profile_pics', $data);       
        return $query;
    }   
    
    function delete_profile_pics($pics_to_delete,$company_id)
    {
        $this->db->where('company_id', $company_id);
        $this->db->where_in('file_name', $pics_to_delete);
        $query = $this->db->delete('company_profile_pics');
        return $query;
       
    }      

    function get_profile_pics($company_id)
    {
        //get the profile pics from the database
        $query = $this->db->get_where('company_profile_pics', array('company_id' => $company_id)); 
        if ($query)
        {
            $pic_array = array();
            //build the array to be sent to the view
            foreach ($query->result_array() as $key=>$value)
            {
               $pic_array[$key]['pic_shape'] = $value['pic_shape'];
               $pic_array[$key]['file_name'] = $value['file_name'];
            }

            //shuffle the array values to get a random distribution each time
            //this could be removed if we want the same order every time.
            //shuffle($pic_array);
            
            //randomizing could randomly put all the small pics next to each other...
            //so, distribute the pictures to spread the types/shapes out
            $distributed_array = $this->distribute_pics($pic_array);
            
            if (!empty($distributed_array)){       
                return $distributed_array; 
            }
            else
            {
                return $pic_array;
            }
            
        }
        else
        {
            return FALSE;
        }

    }  //end of get_profile_pics       
    
    function view_profile_pics($company_id)//for admin panel
    {
        //get the profile pics from the database
        $query = $this->db->get_where('company_profile_pics', array('company_id' => $company_id)); 
        if ($query)
        {
            $pic_array = array();
            //build the array to be sent to the view
            foreach ($query->result_array() as $key=>$value)
            {
               $pic_array[$key]['pic_shape'] = $value['pic_shape'];
               $pic_array[$key]['file_name'] = $value['file_name'];
            }

            //shuffle the array values to get a random distribution each time
            //this could be removed if we want the same order every time.
            //shuffle($pic_array);
            
            //randomizing could randomly put all the small pics next to each other...
            //so, distribute the pictures to spread the types/shapes out
            //$distributed_array = $this->distribute_pics($pic_array);
            return $pic_array;
            
        }
        else
        {
            return FALSE;
        }

    }  //end of get_profile_pics       
    
    public function distribute_pics($pic_array)
    {
        //This funtion distributes the values in the pic_array to try and 
        //minimize pics of the same shape/size from being right next to each
        //other.  It is not very elegant, but it gets the job done.
        
            $count = count($pic_array);
            $i = 0; 
            $j=0;
            $prev_shape = 0;
            $leftovers = array();
            $new_array = array();
            
            while ($i < $count)
            {      
                if (!empty($leftovers))
                {
                    $leftovers_count = count($leftovers);                   
                    $leftovers_copy = $leftovers;
                    $leftovers = array();
                    foreach ($leftovers_copy as $row=>$item)
                    {
                        if (($item['pic_shape'] != $prev_shape) OR (count($leftovers_copy)==1))
                        {
                            $new_array[$row]['pic_shape']= $item['pic_shape'];
                            $new_array[$row]['file_name'] = $item['file_name'];
                            $i++;
                            $prev_shape = $item['pic_shape'];                           
                        }
                        else {
                            $leftovers[$row]['pic_shape']= $item['pic_shape'];
                            $leftovers[$row]['file_name'] = $item['file_name'];
                            $j++;
                        }
                        if ($i >$count){
                            break 2;                           
                        }
                        if ($j>$leftovers_count){
                            //add the remaining values to the new_array
                            foreach ($leftovers as $key=>$value)
                            {
                                $new_array[$row]['pic_shape']= $item['pic_shape'];
                                $new_array[$row]['file_name'] = $item['file_name'];                                
                            }
                            break 2;
                        }
                            
                    }
                }
                
                if (empty($leftovers) && ($i<$count))
                {
                    foreach ($pic_array as $row=>$item)
                    {
                        if ($item['pic_shape'] != $prev_shape)
                        {
                            $new_array[$row]['pic_shape']= $item['pic_shape'];
                            $new_array[$row]['file_name'] = $item['file_name'];
                            $i++;
                            $prev_shape = $item['pic_shape'];
                        }
                        else {
                            $leftovers[$row]['pic_shape']= $item['pic_shape'];
                            $leftovers[$row]['file_name'] = $item['file_name'];
                        }
                        if ($i > $count){
                            break 2;                           
                            }                        
                    }
                }
            } 
            return $new_array;
        
    }//end of distribute_pics
    
    public function insert_quote($company_id,$quote,$tile_shape)
    {
        $data = array(
           'company_id' => $company_id,
           'tile_shape' => $tile_shape,
           'quote' => $quote
        );
        $query = $this->db->insert('company_quotes', $data);       
        return $query;        
    }
    
    function delete_quotes($quotes_to_delete,$company_id)
    {
        $this->db->where('company_id', $company_id);
        $this->db->where_in('id', $quotes_to_delete);
        $query = $this->db->delete('company_quotes');
        return $query;
       
    }     

    function get_quotes($company_id)
    {
        //get the quotes from the database
        $query = $this->db->get_where('company_quotes', array('company_id' => $company_id)); 
        if ($query)
        {
            $quote_array = array();
            //build the array to be sent to the view
            foreach ($query->result_array() as $key=>$value)
            {
               $quote_array[$key]['tile_shape'] = $value['tile_shape'];
               $quote_array[$key]['quote'] = $value['quote'];
            }

            //shuffle the array values to get a random distribution each time
            //this could be removed if we want the same order every time.
            //shuffle($quote_array);
            return $quote_array;
        }
        else
        {
            return FALSE;
        }

    }  //end of get_quotes   
    
    function view_quotes($company_id)
    {
        //get the quotes from the database
        $query = $this->db->get_where('company_quotes', array('company_id' => $company_id)); 
        if ($query)
        {
            $quote_array = array();
            //build the array to be sent to the view
            foreach ($query->result_array() as $key=>$value)
            {
               $quote_array[$key]['id'] = $value['id'];
               $quote_array[$key]['tile_shape'] = $value['tile_shape'];
               $quote_array[$key]['quote'] = $value['quote'];
            }

            return $quote_array;
        }
        else
        {
            return FALSE;
        }

    }  //end of get_quotes     

function array_interlace ($a, $b)
{
    $c = array();
    
    $shorty = (count($a) > count($b)) ? $b : $a;
    $biggy = (count($a) > count($b)) ? $a : $b;
    
    $slen = count($shorty);
    $blen = count($biggy);

    for ($i = 0; $i < $slen; ++$i){
        $c[$i * 2] = $a[$i];
        $c[$i * 2 + 1] = $b[$i];
    }
    
    for ($i = $slen; $i < $blen; ++$i)
    {
        $c[] = $biggy[$i];
    }
    
    return $c;
}    
    
    //function for setting errors in the model and returning them to the controller
    public function set_error($error)
    {
        $this->errors[] = $error;

        return $error;
    }    
}

