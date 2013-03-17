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
    
    function save_user_inquiry()
    {
        $users_benefits = $this->session->userdata('users_benefits');
        $category = $this->session->userdata('category');
        $company_pace = $this->session->userdata('company_pace');
        $corp_citizenship = $this->session->userdata('corp_citizenship');
        $lifecycle = $this->session->userdata('lifecycle');
        $history = $this->session->userdata('history');
        
        
        //USER BENEFITS
        foreach($users_benefits as $benefits_id=>$user_ranking)
        {
            $rank = (int) $user_ranking['rank'];
            
            $data = array(
                'user_id' => $user_id ,
                'benefits_id' => $benefits_id ,
                'rank' => $rank
            );
            $this->db->insert('user_benefits', $data);  
        }      
        
        
        if ($query)
        {      
            $this->session->unset_userdata('category');
            $this->session->unset_userdata('company_pace');
            $this->session->unset_userdata('corp_citizenship');
            $this->session->unset_userdata('history');
            $this->session->unset_userdata('lifecycle');
            $this->session->unset_userdata('users_benefits');   
        }
        
    }      
    
}//end of model

