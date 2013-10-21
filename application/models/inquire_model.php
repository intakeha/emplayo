<?php
class Inquire_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
        
        $this->messages = array();
        $this->errors = array();
    }

    function location_search($search_term)
    {
        $this->db->select('id, display_city, region');
	$this->db->like("concat(`display_city`,', ',`region`)", $search_term, 'after');
	$this->db->limit('5');
        $this->db->order_by("display_city", "asc");
        $query = $this->db->get('ref_city');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['value'] = $item['display_city'].', '.$item['region'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }      
    } 
 
    function industry_search($search_term)
    {
        $this->db->select('id, name');
        $this->db->like('name', $search_term, 'both');
        $this->db->limit('5');
        $query = $this->db->get('ref_category');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['value'] = $item['name'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }        
    }  
    
    function college_search($search_term)
    {

        $this->db->select('id, college');
        $this->db->like('college', $search_term, 'after');
        $this->db->limit('5');
        $this->db->order_by("college", "asc");
        $query = $this->db->get('ref_college');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['value'] = $item['college'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }      
    }  
    
    function degree_type_search($search_term)
    {

        $this->db->select('id, degree_type, degree_type_short');
        $this->db->like('degree_type', $search_term, 'both');
        $this->db->limit('5');
        $query = $this->db->get('ref_degree_type');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['value'] = $item['degree_type'];
                $result_array[$row]['short'] = $item['degree_type_short'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }        
    } 
    
    function get_degree_type()
    {

        $this->db->select('id, degree_type, degree_type_short');
        $query = $this->db->get('ref_degree_type');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['degree'] = $item['degree_type'];
                $result_array[$row]['short'] = $item['degree_type_short'];
            }
            //$output = json_encode($result_array);    
            return $result_array;            
        }        
    }      
    
    function major_search($search_term)
    {
        $this->db->select('id, major');
        $this->db->like('major', $search_term, 'both');
        $this->db->limit('5');
        $query = $this->db->get('ref_major');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['value'] = $item['major'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }        
    }       
 
    function company_search($search_term)
    {
        $this->db->select('id, company_name');
        $this->db->like('company_name', $search_term, 'after');
        $this->db->limit('5');
        $query = $this->db->get('company');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['value'] = $item['company_name'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }        
    }
    
    function jobtype_search($search_term)
    {

        $this->db->select('id, name');
        $this->db->like('name', $search_term, 'after');
        $this->db->limit('5');
        $query = $this->db->get('ref_job_type');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['value'] = $item['name'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }        
    } 
    
    //function for setting errors in the model and returning them to the controller
    public function set_error($error)
    {
        $this->errors[] = $error;

        return $error;
    }    
    
/*
 * NEW SELECT2 FUNCTIONS - UNCOMMENT THESE WHEN READY TO REMOVE THE OLD TYPEAHEAD STUFF.  BE SURE
 * TO COMMENT THOSE OUT OR REMOVE THEM TO AVOID CONFLICTS AND CONFUSION    

    function industry_search($search_term)
    {

        $this->db->select('id, name');
        $this->db->like('name', $search_term, 'both');//both, after, before
        $this->db->limit('100');
        $this->db->order_by("name", "asc");
        $query = $this->db->get('ref_category');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['text'] = $item['name'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }        
    }
    
    function location_search($search_term)
    {

        $this->db->select('id, display_city, region');
        $this->db->like('display_city', $search_term, 'after');
        $this->db->limit('30');
        $this->db->order_by("display_city", "asc");
        $query = $this->db->get('ref_city');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['text'] = $item['display_city'].', '.$item['region'];
                //$result_array[$row]['region'] = $item['region'];
                //$result_array[$row]['value'] = $item['display_city'];
            }
            $output = json_encode($result_array);    
            return $output;            
        }        
    }     

    function college_name_search($search_term)
    {
        $this->db->select('id, college');
        $this->db->like('college', $search_term, 'both');//both, after, before
        $this->db->limit('30');
        $this->db->order_by("college", "asc");
        $query = $this->db->get('ref_college');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['text'] = $item['college'];
            }
            $output = json_encode($result_array);    
            return $output;            
        } 
    }      

    function college_degree_search($search_term)
    {
        $this->db->select('id, degree_type');
        $this->db->like('degree_type', $search_term, 'both');//both, after, before
        $this->db->limit('30');
        $this->db->order_by("degree_type", "asc");
        $query = $this->db->get('ref_degree_type');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['text'] = $item['degree_type'];
            }
            $output = json_encode($result_array);    
            return $output;            
        } 
    }       
 
    function college_major_search($search_term)
    {
        $this->db->select('id, major');
        $this->db->like('major', $search_term, 'both');//both, after, before
        $this->db->limit('200');
        $this->db->order_by("major", "asc");
        $query = $this->db->get('ref_major');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['text'] = $item['major'];
            }
            $output = json_encode($result_array);    
            return $output;            
        } 
    }      
    
    
    
    function company_name_search($search_term)
    {
        $this->db->select('id, company_name');
        $this->db->like('company_name', $search_term, 'both');//both, after, before
        $this->db->limit('30');
        $this->db->order_by("company_name", "asc");
        $query = $this->db->get('company');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['text'] = $item['company_name'];
            }
            $output = json_encode($result_array);    
            return $output;            
        } 
    }      
    
    function job_type_search($search_term)
    {
        $this->db->select('id, name');
        $this->db->like('name', $search_term, 'both');//both, after, before
        $this->db->limit('35');
        $this->db->order_by("name", "asc");
        $query = $this->db->get('ref_job_type');
        $count = $query->num_rows();        

        if($query)
        {      
            $result_array = array();
            foreach($query->result_array() as $row=>$item)
            {
                $result_array[$row]['id'] = $item['id'];
                $result_array[$row]['text'] = $item['name'];
            }
            $output = json_encode($result_array);    
            return $output;            
        } 
    }           
    
    
    
*/    
    
}//end of model

