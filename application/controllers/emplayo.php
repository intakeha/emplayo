<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emplayo extends CI_Controller {

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
			$data['title']="Home";
			$data['content']="pages/_profile";
			$this->load->view('canvas', $data);
			$this->session->unset_userdata('message');
			
		}   else {
			$data['title']="Home";
			$data['content']="pages/_home";
			$this->load->view('canvas', $data);
		}

	}
	
}
