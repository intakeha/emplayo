<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emplayo extends CI_Controller {

	public function index(){
		$data['title']="Home";
		$data['content']="_home";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
	public function criteria(){
		$data['title']="Work-Life-Play";
		$data['content']="_criteria";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
}
