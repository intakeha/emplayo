<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquire extends CI_Controller {
	
	public function index(){
            $this->load->library('ion_auth');
		$data['title']="Work-Life-Play";
		$data['content']="pages/_criteria";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
}
