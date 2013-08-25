<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

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
            
            //We could make this generic by having the calling file pass in error values (using flashdata)
            //Or we could make a different function for different types of errors with hardcoded text...
            //For now, keeping it sort of generic:
            
		$data['title']="Error";
                $data['heading']="This is an error!";
                $data['message']="I'm a really sucky error...";
		$data['content']="pages/_error";
		$this->load->view('canvas', $data);
	}
	
}
