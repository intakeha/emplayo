<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {

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

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}

	public function index(){
		
		if ($this->ion_auth->logged_in()){
			$data['title']="Company";
			$data['content']="pages/_company";
			$this->load->helper('url');
			$this->load->view('canvas', $data);
			$this->session->unset_userdata('message');
			
		}   else {
			redirect('/');
		}

	}
        
	public function temp($company_id){
		
		if ($this->ion_auth->logged_in()){
                    //get company details using company id
                    $this->load->model('company_model');
                    //get_profile_pics
                    $data['pic_array'] = $this->company_model->get_profile_pics($company_id);
                    $data['company_info'] = $this->company_model->get_company_info($company_id);
                    
                    $data['title']="Company";
                    $data['content']="pages/_company_temp";
                    $this->load->helper('url');
                    $this->load->view('canvas', $data);
                    $this->session->unset_userdata('message');
			
		}   else {
			redirect('/');
		}

	}        
	
}
