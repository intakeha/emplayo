<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function index(){
		$data['title']="Job Postings";
		$data['content']="pages/_companyJobs";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
}
