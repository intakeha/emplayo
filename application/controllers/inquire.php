<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquire extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');

		// Load MongoDB library instead of native db driver if required
		$this->config->item('use_mongodb', 'ion_auth') ?
		$this->load->library('mongo_db') :
		$this->load->database();
                $this->load->model('inquire_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}
	
	public function index(){
                $this->load->library('ion_auth');
		$data['title']="Work-Life-Play";
		$data['content']="pages/_criteria";
		$this->load->view('canvas', $data);
	}
 
/*       if(($this->input->post('kw')) && ($this->input->post('kw') != ''))    
        {
            $kws = $this->input->post('kw');
            $this->company_model->company_name_search($kws);
            
        }  */        
  
        public function location_search2()
        {
            $searchterm = $this->input->get('searchterm');
            if (!empty($searchterm)){
                
                $search_term = $searchterm;
                $decoded_search_term = urldecode($search_term);
                $result = $this->inquire_model->location_search2($decoded_search_term);
                header('Content-Type: application/json');
                echo $result;
            }

               
        }//end of
        
        public function location_search3($searchterm)
        {
            //$searchterm = $this->input->get('searchterm');
            if (!empty($searchterm)){
                
                $search_term = $searchterm;
                $decoded_search_term = urldecode($search_term);
                $result = $this->inquire_model->location_search3($decoded_search_term);
                header('Content-Type: application/json');
                echo $result;
            }

               
        }//end of           
        
        public function industry_search()
        {
                $searchterm = $this->input->get('searchterm');
                $search_term = $searchterm;
                $decoded_search_term = urldecode($search_term);
                $result = $this->inquire_model->industry_search($decoded_search_term);
                header('Content-Type: application/json');
                echo $result;

               
        }//end of     
        
        public function industry_search2()
        {
                $searchterm = $this->input->get('searchterm');
                $search_term = $searchterm;
                $decoded_search_term = urldecode($search_term);
                $result = $this->inquire_model->industry_search2($decoded_search_term);
                header('Content-Type: application/json');
                echo $result;

               
        }//end of         
        
        public function location_search()
        {
            $searchterm = $this->input->get('searchterm');
            $search_term = $searchterm;
            $decoded_search_term = urldecode($search_term);
            $result = $this->inquire_model->location_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end of location_search          

        public function college_search()
        {
            $searchterm = $this->input->get('searchterm');
            $search_term = $searchterm;
            $decoded_search_term = urldecode($search_term);
            $result = $this->inquire_model->college_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;                  
        }//end of college_search             
    
        public function degree_type_search($search_term)
        {
            if(($search_term) && ($search_term) != '')    
            {
                $decoded_search_term = urldecode($search_term);
                $result = $this->inquire_model->degree_type_search($decoded_search_term);
                echo $result;

            }        
        }//end of degree_type_search                
      
        public function major_search($search_term)
        {
            if(($search_term) && ($search_term) != '')    
            {
                $decoded_search_term = urldecode($search_term);
                $result = $this->inquire_model->major_search($decoded_search_term);
                echo $result;

            }        
        }//end of degree_type_search  
        
        public function company_search($search_term)
        {
            if(($search_term) && ($search_term) != '')    
            {
                $decoded_search_term = urldecode($search_term);
                $result = $this->inquire_model->company_search($decoded_search_term);
                echo $result;

            }        
        }//end of degree_type_search    
        
	public function typetest(){
            $data['degree_array'] = $this->inquire_model->get_degree_type();
            
            
		$this->load->view('pages/typetest',$data);
	}        
        
}//end of controller
