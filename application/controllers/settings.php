<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

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
                $this->load->model('home_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}

	public function index(){
		
		if ($this->ion_auth->logged_in()){
                        //get the user's data
                        $user_id = $this->session->userdata('user_id');
			
			//create variables for change password form
			$user = $this->ion_auth->user()->row();

			$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '.{'.$data['min_password_length'].',}',
				//'pattern' => '^.{'.$data['min_password_length'].'}.*$',
				'title' => $data['min_password_length'].' characters minimum',
			);
			$data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '.{'.$data['min_password_length'].',}',
				'title' => $data['min_password_length'].' characters minimum',
			);
			$data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);
			$data['message'] = "";

			// Render the settings page
			$data['title']="Settings";
			$data['content']="pages/_settings";
			$this->load->view('canvas', $data);
			$this->session->unset_userdata('message');
			
		}   else {
			$data['title']="Home";
			$data['content']="pages/_home";
			$this->load->view('canvas', $data);
		}

	}
	
	function change_password(){
		$this->form_validation->set_rules('old', 'Old password', 'required');
		$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$arr = array ('success'=>0, 'message'=>$this->data['message']);
			echo json_encode($arr);
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$arr = array ('success'=>1, 'message'=>$this->ion_auth->messages());
				echo json_encode($arr);
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				$arr = array ('success'=>0, 'message'=>$this->ion_auth->errors());
				echo json_encode($arr);
			}
		};
	}
		
}
