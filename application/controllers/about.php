<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

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
		$data['title']="About";
		$data['content']="pages/_about";
		$this->load->view('canvas', $data);
	}
	
	public function testimonials(){
		$data['title']="Testimonials";
		$data['content']="pages/_testimonials";
		$this->load->view('canvas', $data);
	}

	public function ambassadors(){
		$data['title']="Ambassadors";
		$data['content']="pages/_ambassadors";
		$this->load->view('canvas', $data);
	}

	public function employers(){
		$data['title']="Employers";
		$data['content']="pages/_employers";
		$this->load->view('canvas', $data);
	}

	public function pricing(){
		$data['title']="Pricing";
		$data['content']="pages/_pricing";
		$this->load->view('canvas', $data);
	}

	public function contact(){
		$data['title']="Contact";
		$data['content']="pages/_contact";
		$this->load->view('canvas', $data);
	}

	public function terms(){
		$data['title']="Terms";
		$data['content']="pages/_terms";
		$this->load->view('canvas', $data);
	}

	public function privacy(){
		$data['title']="Privacy";
		$data['content']="pages/_privacy";
		$this->load->view('canvas', $data);
	}
}
