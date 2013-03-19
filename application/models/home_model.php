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

    
    function save_user_inquiry()
    {
        //$user_id = $this->session->userdata('user_id');
        $user_id = 2;

        /*01-mu*/$user_type = $this->input->post('user_type');
        /*02-mu*/$user_pace = $this->session->userdata('user_pace');   
        /*03-mu*/$user_lifecycle = $this->session->userdata('user_lifecycle');        
        /*04-rk*/$user_benefits = $this->session->userdata('user_benefits');
        /*05-sg*/$user_corp_citizenship = $this->session->userdata('user_citizenship');
        /*06-sg*/$user_travel = $this->session->userdata('user_travel');
        /*07-sg*/$user_responsibilities = $this->session->userdata('user_responsibilities');
        /*08-rk*/$user_promotion = $this->session->userdata('user_promotion');
        /*09-sg*/$user_environment = $this->session->userdata('user_environment');
        /*10-rk*/$user_recognition = $this->session->userdata('user_recognition');
        /*11-rk*/$user_tasks = $this->session->userdata('user_tasks');
        /*12-sg*/$user_communication = $this->session->userdata('user_communication');
        /*13-rk*/$user_resource = $this->session->userdata('user_resource');
        /*14-sg*/$user_supervisor = $this->session->userdata('user_supervisor');
        /*15-sg*/$user_leadership = $this->session->userdata('user_leadership');
        /*16-mu*/$user_traits = $this->session->userdata('user_traits');
        /*17-sg*/$user_motivation = $this->session->userdata('user_motivation');
        
        
        $user_next = $this->session->userdata('category');//??
        $user_history = $this->session->userdata('history');  //??
        
        
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
        
        //9. ENVIRONMENT (radio)
        $environment_array = $this->build_array_radio($user_environment, 'environment', $user_id);
        $this->db->insert('user_environment', $environment_array); 
 
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
        
        //17. MOTIVATION (radio)
        $motivation_array = $this->build_array_radio($user_motivation, 'motivation', $user_id);
        $this->db->insert('user_motivation', $motivation_array);         
        
/*      
        //19. DO NEXT
        $next_array = array();
        foreach ($user_next as $key=>$value)
        {
            $next_array[$key]['user_id'] = $user_id;
            $next_array[$key]['category_id'] = $value;
        }           
        $this->db->insert_batch('user_next', $next_array);        
 */
        //COMMIT ALL OF THE UPDATES      
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            $this->set_error('Unable to save user data');
            return FALSE;
        }
        else 
        {
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
 
    //function for setting errors in the model and returning them to the controller
    public function set_error($error)
    {
        $this->errors[] = $error;

        return $error;
    }    
    
}//end of model

