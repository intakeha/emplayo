<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ask extends CI_Controller {
	
	public function index(){
		$data['title']="Work-Life-Play";
		$data['content']="_criteria";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
}
