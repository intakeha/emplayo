<?php
class Home_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
        
        $this->messages = array();
        $this->errors = array();
    }

    function get_matches($user_id)
    { 
        //$this->db->select('company_id, score');
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $this->db->from('user_matches');
        $this->db->join('company', 'company.id = user_matches.company_id');
        $this->db->order_by("score", "desc");
        
        $query = $this->db->get(); 
        
        $new_array = array();
        foreach ($query->result_array() as $key=>$value)
        {
            $new_array[$key]['company_id'] = $value['company_id'];
            $new_array[$key]['company_name'] = $value['company_name'];
            $new_array[$key]['score'] = round($value['score']);
            $new_array[$key]['company_logo'] = $value['company_logo'];
            $new_array[$key]['creative_logo'] = $value['creative_logo']; 
        }
        
        return $new_array;

    }//end of get_matches()    
    
    function insert_matches()
    {
        $company_fit = $this->session->userdata('company_fit');
        $user_id = $this->session->userdata('user_id');
        
        //build new array for db insertion
        
        $new_array = array();
        foreach ($company_fit as $key=>$value) {          
            $new_array[$key]['user_id'] = $user_id;
            $new_array[$key]['company_id'] = $value['id'];
            $new_array[$key]['score'] = ($value['ag_score']*100);
        }   
        
        $query = $this->db->insert_batch('user_matches', $new_array); 
        
        if ($query)
        {
            //insert was successful.  clear out session vars and return info
            $this->session->unset_userdata('company_fit');

            return $query;           
        }

    } //end of insert_matches()
    
    function build_array_checkbox($original_array, $keyword, $user_id){
        $array = array();
        foreach ($original_array as $key=>$value)
        {
            $array[$key]['user_id'] = $user_id;
            $array[$key]["{$keyword}_id"] = $value;
        }   
        return $array; 
    }

    function build_array_radio($value, $keyword, $user_id){
        $array = array(
                       'user_id' => $user_id ,
                       "{$keyword}_id" => $value
                    );  
       return $array;                                  
    }
    
    function build_array_rank($original_array, $keyword, $user_id){
        $array = array();
        $i=0;        
        foreach($original_array as $item_id=>$user_ranking)
        {
            $array[$i]['user_id'] = $user_id;
            $array[$i]["{$keyword}_id"] = $item_id;
            $array[$i]['rank'] = $user_ranking['rank'];
            $i++;
        }
        return $array;
    }

    function build_array_education($original_array, $keyword, $user_id){
        $array = array();
        foreach ($original_array as $key=>$value)
        {
            $array[$key]['user_id'] = $user_id;
            if (!empty ($value['school_id'])){
                $array[$key]['college_id'] = $value['school_id'];
                $array[$key]['college_name'] = NULL;
            } else {
                $array[$key]['college_id'] = NULL;
                $array[$key]['college_name'] = $value['school_id'];                
            }
            $array[$key]['start_date'] = $value['start_year'].'-'.$value['start_month'].'-01';
            $array[$key]['end_date'] = $value['end_year'].'-'.$value['end_month'].'-01';
            $array[$key]['degree_id'] = $value['degree_id'];
            $array[$key]['major_id'] = $value['field_id'];           
        }   
        return $array; 
    }
    
    function build_array_work($original_array, $keyword, $user_id){
        $array = array();
        foreach ($original_array as $key=>$value)
        {
            $array[$key]['user_id'] = $user_id;
            
            if (!empty ($value['company_id'])){
                $array[$key]['company_id'] = $value['company_id'];
                $array[$key]['company_name'] = NULL;
            } else {
                $array[$key]['company_id'] = NULL;
                $array[$key]['company_name'] = $value['company_id'];                
            }
            
            $array[$key]['start_date'] = $value['start_year'].'-'.$value['start_month'].'-01';
            if (isset($value['current'])){
                if ($value['current'] == 0){
                    $array[$key]['end_date'] = $value['end_year'].'-'.$value['end_month'].'-01';
                }else {
                    $array[$key]['end_date'] = NULL;
                }
                $array[$key]['current'] = $value['current'];
            }else {
                $array[$key]['end_date'] = $value['end_year'].'-'.$value['end_month'].'-01';
                $array[$key]['current'] = 0;
            }
            
            if (!empty ($value['job_id'])){
                $array[$key]['job_type_id'] = $value['job_id'];
                $array[$key]['job_type_name'] = NULL;
            } else {
                $array[$key]['job_type_id'] = NULL;
                $array[$key]['job_type_name'] = $value['job_id'];                
            }            
  
            $array[$key]['rating'] = $value['rating'];
        }   
        return $array; 
    }    
    
    function save_user_inquiry()
    {
        $user_id = $this->session->userdata('user_id');
        //$user_id = 2;

        /*01-mu*/$user_type = $this->session->userdata('user_type');
        /*02-mu*/$user_pace = $this->session->userdata('user_pace');   
        /*03-mu*/$user_lifecycle = $this->session->userdata('user_lifecycle');        
        /*04-rk*/$user_benefits = $this->session->userdata('user_benefits');
        /*05-sg*/$user_corp_citizenship = $this->session->userdata('user_citizenship');
        /*06-sg*/$user_travel = $this->session->userdata('user_travel');
        /*07-sg*/$user_responsibilities = $this->session->userdata('user_responsibilities');
        /*08-rk*/$user_promotion = $this->session->userdata('user_promotion');
        /*09-mu*/$user_environment = $this->session->userdata('user_environment');
        /*10-rk*/$user_recognition = $this->session->userdata('user_recognition');
        /*11-rk*/$user_tasks = $this->session->userdata('user_tasks');
        /*12-sg*/$user_communication = $this->session->userdata('user_communication');
        /*13-rk*/$user_resource = $this->session->userdata('user_resource');
        /*14-sg*/$user_supervisor = $this->session->userdata('user_supervisor');
        /*15-sg*/$user_leadership = $this->session->userdata('user_leadership');
        /*16-mu*/$user_traits = $this->session->userdata('user_traits');
        /*17-sg*/$user_motivation = $this->session->userdata('user_motivation');        
        /*18-ar*/$user_education = $this->session->userdata('user_education');
        /*18-ar*/$user_work = $this->session->userdata('user_work');
        /*19-mu*/$user_location = $this->session->userdata('user_location');
        /*20-mu*/$user_category = $this->session->userdata('user_industry');       
        
        //$user_next = $this->session->userdata('category');//??
        //$user_history = $this->session->userdata('history');  //??
        
        
        //START A TRANSACTION, SO ALL INSERTS MUST SUCCEED OR EVERYTHING IS ROLLED BACK
        $this->db->trans_start();        

        //1. (COMPANY) TYPE (checkbox)  
        $type_array = $this->build_array_checkbox($user_type, 'type', $user_id);
        $this->db->insert_batch('user_type', $type_array); 
 
        //2. PACE (checkbox)
        $pace_array = $this->build_array_checkbox($user_pace, 'pace', $user_id);
        $this->db->insert_batch('user_pace', $pace_array); 
      
        //3. LIFECYCLE (checkbox) 
        $lifecycle_array = $this->build_array_checkbox($user_lifecycle, 'lifecycle', $user_id);        
        $this->db->insert_batch('user_lifecycle', $lifecycle_array);         
                  
        //4. BENEFITS (rank)
        $benefits_array = $this->build_array_rank($user_benefits, 'benefits', $user_id);
        $this->db->insert_batch('user_benefits', $benefits_array);        
  
        //5. CORPORATE CITIZENSHIP (radio)
        $corp_citizenship_array = $this->build_array_radio($user_corp_citizenship, 'corp_citizenship', $user_id);
        $this->db->insert('user_corp_citizenship', $corp_citizenship_array);
        
        //6. TRAVEL (radio)
        $travel_array = $this->build_array_radio($user_travel, 'travel', $user_id);
        $this->db->insert('user_travel', $travel_array);  
        
        //7. RESPONSIBILITIES (radio)
        $responsibilities_array = $this->build_array_radio($user_responsibilities, 'responsibilities', $user_id);
        $this->db->insert('user_responsibilities', $responsibilities_array);                
  
        //8. PROMOTION (rank)
        $promotion_array = $this->build_array_rank($user_promotion, 'promotion', $user_id);
        $this->db->insert_batch('user_promotion', $promotion_array);         
        
        //9. ENVIRONMENT (checkbox)
        $environment_array = $this->build_array_checkbox($user_environment, 'environment', $user_id);
        $this->db->insert_batch('user_environment', $environment_array); 
 
        //10. RECOGNITION (rank)
        $recognition_array = $this->build_array_rank($user_recognition, 'recognition', $user_id);
        $this->db->insert_batch('user_recognition', $recognition_array);  
        
        //10. TASKS (rank)
        $tasks_array = $this->build_array_rank($user_tasks, 'tasks', $user_id);
        $this->db->insert_batch('user_tasks', $tasks_array);            
        
        //12. COMMUNICATION (radio)
        $communication_array = $this->build_array_radio($user_communication, 'communication', $user_id);
        $this->db->insert('user_communication', $communication_array);   
 
        //13. RESOURCE (rank)
        $resource_array = $this->build_array_rank($user_resource, 'resource', $user_id);
        $this->db->insert_batch('user_resource', $resource_array);             
        
        //14. SUPERVISOR (radio)
        $supervisor_array = $this->build_array_radio($user_supervisor, 'supervisor', $user_id);
        $this->db->insert('user_supervisor', $supervisor_array); 
        
        //15. LEADERSHIP (radio)
        $leadership_array = $this->build_array_radio($user_leadership, 'leadership', $user_id);
        $this->db->insert('user_leadership', $leadership_array); 
        
        //16. TRAITS (checkbox)
        $traits_array = $this->build_array_checkbox($user_traits, 'traits', $user_id);
        $this->db->insert_batch('user_traits', $traits_array);         
        
        //17. MOTIVATION (radio)
        $motivation_array = $this->build_array_radio($user_motivation, 'motivation', $user_id);
        $this->db->insert('user_motivation', $motivation_array);         

        //18a. USER_EDUCATION (checkbox)
        if (!empty($user_education)){
            $education_array = $this->build_array_education($user_education, 'education', $user_id);
            $this->db->insert_batch('user_education', $education_array);   
        }
        
        //18b. USER_WORK (checkbox)
        if (!empty($user_work)){
            $work_array = $this->build_array_work($user_work, 'work', $user_id);
            $this->db->insert_batch('user_work', $work_array);        
        }
        //19. LOCATION/CITY (checkbox)
        $location_array = $this->build_array_checkbox($user_location, 'location', $user_id);
        $this->db->insert_batch('user_location', $location_array);        
        
        //20. INDUSTRY/CATEGORY (checkbox)
        $category_array = $this->build_array_checkbox($user_category, 'category', $user_id);
        $this->db->insert_batch('user_category', $category_array);
  
        //INSERT USER'S COMPANY MATCHES
        $company_fit = $this->session->userdata('company_fit');
        //build new array for db insertion
        $comp_ins_array = array();
        foreach ($company_fit as $key=>$value) {          
            $comp_ins_array[$key]['user_id'] = $user_id;
            $comp_ins_array[$key]['company_id'] = $value['id'];
            $comp_ins_array[$key]['score'] = ($value['ag_score']*100);
        }   
        $this->db->insert_batch('user_matches', $comp_ins_array);   
        
        // *** END OF COMPANY MATCHES ***         
        // 
        //Update user_survey_taken to track when the user completed the survey
        $survey_taken_array = array('user_id' => $user_id);
        $this->db->set('utc_date', 'UTC_TIMESTAMP()', FALSE);        
        $this->db->insert('user_survey_taken', $survey_taken_array);        
        
        //COMMIT ALL OF THE UPDATES      
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->set_error('Unable to save user data');
            return FALSE;
        }
        else 
        {
            //CLEAR OUT THE SESSION VARIABLES
            /*01-mu*/$this->session->unset_userdata('user_type');
            /*02-mu*/$this->session->unset_userdata('user_pace');   
            /*03-mu*/$this->session->unset_userdata('user_lifecycle');        
            /*04-rk*/$this->session->unset_userdata('user_benefits');
            /*05-sg*/$this->session->unset_userdata('user_citizenship');
            /*06-sg*/$this->session->unset_userdata('user_travel');
            /*07-sg*/$this->session->unset_userdata('user_responsibilities');
            /*08-rk*/$this->session->unset_userdata('user_promotion');
            /*09-mu*/$this->session->unset_userdata('user_environment');
            /*10-rk*/$this->session->unset_userdata('user_recognition');
            /*11-rk*/$this->session->unset_userdata('user_tasks');
            /*12-sg*/$this->session->unset_userdata('user_communication');
            /*13-rk*/$this->session->unset_userdata('user_resource');
            /*14-sg*/$this->session->unset_userdata('user_supervisor');
            /*15-sg*/$this->session->unset_userdata('user_leadership');
            /*16-mu*/$this->session->unset_userdata('user_traits');
            /*17-sg*/$this->session->unset_userdata('user_motivation'); 
            /*18-ar*/$this->session->unset_userdata('user_education');
            /*18-ar*/$this->session->unset_userdata('user_work');
            /*19-sg*/$this->session->unset_userdata('user_location');
            /*20-sg*/$this->session->unset_userdata('user_industry');
         
            
            return TRUE;
        }    
        
        
        /*
        if ($query)
        {      
            $this->session->unset_userdata('category');
            $this->session->unset_userdata('company_pace');
            $this->session->unset_userdata('corp_citizenship');
            $this->session->unset_userdata('history');
            $this->session->unset_userdata('lifecycle');
            $this->session->unset_userdata('users_benefits');   
        }
        */
    }      
 
    function update_user_inquiry()
    {
        $user_id = $this->session->userdata('user_id');
        //$user_id = 2;

        /*01-mu*/$user_type = $this->session->userdata('user_type');
        /*02-mu*/$user_pace = $this->session->userdata('user_pace');   
        /*03-mu*/$user_lifecycle = $this->session->userdata('user_lifecycle');        
        /*04-rk*/$user_benefits = $this->session->userdata('user_benefits');
        /*05-sg*/$user_corp_citizenship = $this->session->userdata('user_citizenship');
        /*06-sg*/$user_travel = $this->session->userdata('user_travel');
        /*07-sg*/$user_responsibilities = $this->session->userdata('user_responsibilities');
        /*08-rk*/$user_promotion = $this->session->userdata('user_promotion');
        /*09-mu*/$user_environment = $this->session->userdata('user_environment');
        /*10-rk*/$user_recognition = $this->session->userdata('user_recognition');
        /*11-rk*/$user_tasks = $this->session->userdata('user_tasks');
        /*12-sg*/$user_communication = $this->session->userdata('user_communication');
        /*13-rk*/$user_resource = $this->session->userdata('user_resource');
        /*14-sg*/$user_supervisor = $this->session->userdata('user_supervisor');
        /*15-sg*/$user_leadership = $this->session->userdata('user_leadership');
        /*16-mu*/$user_traits = $this->session->userdata('user_traits');
        /*17-sg*/$user_motivation = $this->session->userdata('user_motivation');        
        /*18-ar*/$user_education = $this->session->userdata('user_education');
        /*18-ar*/$user_work = $this->session->userdata('user_work');
        /*19-mu*/$user_location = $this->session->userdata('user_location');
        /*20-mu*/$user_category = $this->session->userdata('user_industry');       
        
        //$user_next = $this->session->userdata('category');//??
        //$user_history = $this->session->userdata('history');  //??
        
        
        //START A TRANSACTION, SO ALL INSERTS MUST SUCCEED OR EVERYTHING IS ROLLED BACK
        $this->db->trans_start();        

        //1. (COMPANY) TYPE (checkbox)  
        $type_array = $this->build_array_checkbox($user_type, 'type', $user_id);
        $this->db->delete('user_type', array('user_id' => $user_id));
        $this->db->insert_batch('user_type', $type_array); 
 
        //2. PACE (checkbox)
        $pace_array = $this->build_array_checkbox($user_pace, 'pace', $user_id);
        $this->db->delete('user_pace', array('user_id' => $user_id));
        $this->db->insert_batch('user_pace', $pace_array); 
      
        //3. LIFECYCLE (checkbox) 
        $lifecycle_array = $this->build_array_checkbox($user_lifecycle, 'lifecycle', $user_id);     
        $this->db->delete('user_lifecycle', array('user_id' => $user_id));
        $this->db->insert_batch('user_lifecycle', $lifecycle_array);         
                  
        //4. BENEFITS (rank)
        $benefits_array = $this->build_array_rank($user_benefits, 'benefits', $user_id);
        $this->db->delete('user_benefits', array('user_id' => $user_id));
        $this->db->insert_batch('user_benefits', $benefits_array);        
  
        //5. CORPORATE CITIZENSHIP (radio)
        $corp_citizenship_array = $this->build_array_radio($user_corp_citizenship, 'corp_citizenship', $user_id);
        $this->db->delete('user_corp_citizenship', array('user_id' => $user_id));
        $this->db->insert('user_corp_citizenship', $corp_citizenship_array);
        
        //6. TRAVEL (radio)
        $travel_array = $this->build_array_radio($user_travel, 'travel', $user_id);
        $this->db->delete('user_travel', array('user_id' => $user_id));
        $this->db->insert('user_travel', $travel_array);  
        
        //7. RESPONSIBILITIES (radio)
        $responsibilities_array = $this->build_array_radio($user_responsibilities, 'responsibilities', $user_id);
        $this->db->delete('user_responsibilities', array('user_id' => $user_id));
        $this->db->insert('user_responsibilities', $responsibilities_array);                
  
        //8. PROMOTION (rank)
        $promotion_array = $this->build_array_rank($user_promotion, 'promotion', $user_id);
        $this->db->delete('user_promotion', array('user_id' => $user_id));
        $this->db->insert_batch('user_promotion', $promotion_array);         
        
        //9. ENVIRONMENT (checkbox)
        $environment_array = $this->build_array_checkbox($user_environment, 'environment', $user_id);
        $this->db->delete('user_environment', array('user_id' => $user_id));
        $this->db->insert_batch('user_environment', $environment_array); 
 
        //10. RECOGNITION (rank)
        $recognition_array = $this->build_array_rank($user_recognition, 'recognition', $user_id);
        $this->db->delete('user_recognition', array('user_id' => $user_id));
        $this->db->insert_batch('user_recognition', $recognition_array);  
        
        //10. TASKS (rank)
        $tasks_array = $this->build_array_rank($user_tasks, 'tasks', $user_id);
        $this->db->delete('user_tasks', array('user_id' => $user_id));
        $this->db->insert_batch('user_tasks', $tasks_array);            
        
        //12. COMMUNICATION (radio)
        $communication_array = $this->build_array_radio($user_communication, 'communication', $user_id);
        $this->db->delete('user_communication', array('user_id' => $user_id));
        $this->db->insert('user_communication', $communication_array);   
 
        //13. RESOURCE (rank)
        $resource_array = $this->build_array_rank($user_resource, 'resource', $user_id);
        $this->db->delete('user_resource', array('user_id' => $user_id));
        $this->db->insert_batch('user_resource', $resource_array);             
        
        //14. SUPERVISOR (radio)
        $supervisor_array = $this->build_array_radio($user_supervisor, 'supervisor', $user_id);
        $this->db->delete('user_supervisor', array('user_id' => $user_id));
        $this->db->insert('user_supervisor', $supervisor_array); 
        
        //15. LEADERSHIP (radio)
        $leadership_array = $this->build_array_radio($user_leadership, 'leadership', $user_id);
        $this->db->delete('user_leadership', array('user_id' => $user_id));
        $this->db->insert('user_leadership', $leadership_array); 
        
        //16. TRAITS (checkbox)
        $traits_array = $this->build_array_checkbox($user_traits, 'traits', $user_id);
        $this->db->delete('user_traits', array('user_id' => $user_id));
        $this->db->insert_batch('user_traits', $traits_array);         
        
        //17. MOTIVATION (radio)
        $motivation_array = $this->build_array_radio($user_motivation, 'motivation', $user_id);
        $this->db->delete('user_motivation', array('user_id' => $user_id));
        $this->db->insert('user_motivation', $motivation_array);         

        //18a. USER_EDUCATION (checkbox)
        //Even if they didn't add any education info, delete whatever might have already been there
        $this->db->delete('user_education', array('user_id' => $user_id));
        if (!empty($user_education)){
            $education_array = $this->build_array_education($user_education, 'education', $user_id);
            $this->db->insert_batch('user_education', $education_array);   
        }
        
        //18b. USER_WORK (checkbox)
        //Even if they didn't add any work info, delete whatever might have already been there
        $this->db->delete('user_work', array('user_id' => $user_id));
        if (!empty($user_work)){
            $work_array = $this->build_array_work($user_work, 'work', $user_id);
            $this->db->insert_batch('user_work', $work_array);        
        }
        //19. LOCATION/CITY (checkbox)
        $location_array = $this->build_array_checkbox($user_location, 'location', $user_id);
        $this->db->delete('user_location', array('user_id' => $user_id));
        $this->db->insert_batch('user_location', $location_array);        
        
        //20. INDUSTRY/CATEGORY (checkbox)
        $category_array = $this->build_array_checkbox($user_category, 'category', $user_id);
        $this->db->delete('user_category', array('user_id' => $user_id));
        $this->db->insert_batch('user_category', $category_array);
  
        
        // *** UPDATE COMPANY MATCHES ***
        //DELETE USER'S COMPANY MATCHES
        $this->db->where('user_id', $user_id);
        $this->db->delete('user_matches');
        
        //INSERT USER'S COMPANY MATCHES
        $company_fit = $this->session->userdata('company_fit');
        //build new array for db insertion
        $comp_ins_array = array();
        foreach ($company_fit as $key=>$value) {          
            $comp_ins_array[$key]['user_id'] = $user_id;
            $comp_ins_array[$key]['company_id'] = $value['id'];
            $comp_ins_array[$key]['score'] = ($value['ag_score']*100);
        }   
        $this->db->insert_batch('user_matches', $comp_ins_array);   
        
        // *** END OF COMPANY MATCHES ***        

        //Update user_survey_taken to track when the user completed the survey
        //Save date/time as UTC, so it is timezone independent
        //convert it on retrieval

        $survey_taken_array = array('user_id' => $user_id);
        $this->db->set('utc_date', 'UTC_TIMESTAMP()', FALSE);
        $this->db->insert('user_survey_taken', $survey_taken_array);         
        
        //COMMIT ALL OF THE UPDATES      
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->set_error('Unable to save user data');
            return FALSE;
        }
        else 
        {
            //CLEAR OUT THE SESSION VARIABLES
            /*01-mu*/$this->session->unset_userdata('user_type');
            /*02-mu*/$this->session->unset_userdata('user_pace');   
            /*03-mu*/$this->session->unset_userdata('user_lifecycle');        
            /*04-rk*/$this->session->unset_userdata('user_benefits');
            /*05-sg*/$this->session->unset_userdata('user_citizenship');
            /*06-sg*/$this->session->unset_userdata('user_travel');
            /*07-sg*/$this->session->unset_userdata('user_responsibilities');
            /*08-rk*/$this->session->unset_userdata('user_promotion');
            /*09-mu*/$this->session->unset_userdata('user_environment');
            /*10-rk*/$this->session->unset_userdata('user_recognition');
            /*11-rk*/$this->session->unset_userdata('user_tasks');
            /*12-sg*/$this->session->unset_userdata('user_communication');
            /*13-rk*/$this->session->unset_userdata('user_resource');
            /*14-sg*/$this->session->unset_userdata('user_supervisor');
            /*15-sg*/$this->session->unset_userdata('user_leadership');
            /*16-mu*/$this->session->unset_userdata('user_traits');
            /*17-sg*/$this->session->unset_userdata('user_motivation'); 
            /*18-ar*/$this->session->unset_userdata('user_education');
            /*18-ar*/$this->session->unset_userdata('user_work');
            /*19-sg*/$this->session->unset_userdata('user_location');
            /*20-sg*/$this->session->unset_userdata('user_industry');
                     $this->session->unset_userdata('company_fit');
         
            return TRUE;
        }    

    } 
    
    public function discard_session_prefs(){
            //CLEAR OUT THE SESSION VARIABLES
            /*01-mu*/$this->session->unset_userdata('user_type');
            /*02-mu*/$this->session->unset_userdata('user_pace');   
            /*03-mu*/$this->session->unset_userdata('user_lifecycle');        
            /*04-rk*/$this->session->unset_userdata('user_benefits');
            /*05-sg*/$this->session->unset_userdata('user_citizenship');
            /*06-sg*/$this->session->unset_userdata('user_travel');
            /*07-sg*/$this->session->unset_userdata('user_responsibilities');
            /*08-rk*/$this->session->unset_userdata('user_promotion');
            /*09-mu*/$this->session->unset_userdata('user_environment');
            /*10-rk*/$this->session->unset_userdata('user_recognition');
            /*11-rk*/$this->session->unset_userdata('user_tasks');
            /*12-sg*/$this->session->unset_userdata('user_communication');
            /*13-rk*/$this->session->unset_userdata('user_resource');
            /*14-sg*/$this->session->unset_userdata('user_supervisor');
            /*15-sg*/$this->session->unset_userdata('user_leadership');
            /*16-mu*/$this->session->unset_userdata('user_traits');
            /*17-sg*/$this->session->unset_userdata('user_motivation'); 
            /*18-ar*/$this->session->unset_userdata('user_education');
            /*18-ar*/$this->session->unset_userdata('user_work');
            /*19-sg*/$this->session->unset_userdata('user_location');
            /*20-sg*/$this->session->unset_userdata('user_industry');
                     $this->session->unset_userdata('company_fit'); 

    }
    
    public function user_survey_taken($user_id){
        //Determine if a user has taken the survey before.
        //If so, return how many times, and the date of the last time
        
        $this->db->order_by("utc_date", "desc");
        $query = $this->db->get_where('user_survey_taken', array('user_id' => $user_id));
        
        if ($query->num_rows() > 0)
        {
            $row = $query->row();//get the first row...most recent date
            $last_update_date =  $row->utc_date;    
            
            //convert date to PST for now...
            //these functions rely on codeigniter Date helper...loaded in the controller
            $unix_timestamp = mysql_to_unix($last_update_date);
            $timezone = 'UM8';//Pacific
            $daylight_saving = TRUE;
            $local_date =  gmt_to_local($unix_timestamp, $timezone, $daylight_saving);
            $last_update_date = date("F j, Y, g:i a",$local_date); // format: March 10, 2001, 5:16 pm          
            //$last_update_date = unix_to_human($local_date, TRUE, 'us');
            
            return $last_update_date;
        }   
        else
        {
            //no results
            return FALSE;
        }
         
        
//echo $this->db->count_all_results();        
        
        
        
    }
    
    
    
    //function for setting errors in the model and returning them to the controller
    public function set_error($error)
    {
        $this->errors[] = $error;

        return $error;
    }    
    
    
    
    
}//end of model

