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

        public function industry_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->inquire_model->industry_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;           
        }//end     
   
        public function location_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->inquire_model->location_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end         
 
        public function college_name_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->inquire_model->college_name_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end           
     
        public function college_degree_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->inquire_model->college_degree_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end          
        
        public function college_major_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->inquire_model->college_major_search($decoded_search_term);
            header('Content-Type: application/json');  
            echo $result;     
        }//end          
        
         public function company_name_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->inquire_model->company_name_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end   
        
         public function job_type_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->inquire_model->job_type_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end  
        
        
}//end of controller
