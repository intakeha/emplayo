<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emplayo extends CI_Controller {

	public function index(){
		$data['title']="Home";
		$data['content']="_home";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}

}
