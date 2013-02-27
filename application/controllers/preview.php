<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preview extends CI_Controller {

	public function index(){
		$data['title']="Preview Results";
		$data['content']="pages/_preview";
		$this->load->helper('url');
		$this->load->view('canvas', $data);
	}
	
}
