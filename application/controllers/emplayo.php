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
	
	public function preview(){
		$data['title']="Preview Results";
		$data['content']="_preview";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
	public function companyJobs(){
		$data['title']="Job Postings";
		$data['content']="_companyJobs";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
}
