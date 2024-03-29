<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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

	//redirect to login page
	function index()
	{
            redirect('login', 'refresh');
	}
	
	//signup a new user
	function signup()
	{
            if ($this->ion_auth->logged_in()){
                redirect('/', 'refresh');
            }   else {

		//validate form input
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required');

		if ($this->form_validation->run() == true)
		{
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			$additional_data = array();
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($password, $email, $additional_data))
		{
			//success
			$this->session->set_flashdata('message', $this->ion_auth->messages());
                        
                        // ***DO AUTO LOGIN HERE WITH ION_AUTH***
                        $remember = FALSE;

                        if ($this->ion_auth->login($email, $password, $remember))
                        {
                            /*
                            //the login was successful, now save any inquiry/preference data
                            if ($this->session->userdata('save_data') == TRUE)
                            {
                                $this->load->model('home_model');
                                $result = $this->home_model->insert_matches();
                                $result2 = $this->home_model->save_user_inquiry();

                                if ($result && $result2){                     
                                    //if the db write is successful, redirect user to the user home page
                                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                                    redirect('/', 'refresh');
                                    $this->session->unset_userdata('save_data');
                                } else {
                                   // $this->session->set_flashdata('message', $this->home_model->errors);
                                   // redirect('/', 'refresh');
                                   print_r($this->home_model->errors); 
                                }
                            }
                            */
                            //SEND WELCOME EMAIL                           
                            $email_sent = $this->send_welcome_email($email);
                            //END OF WELCOME EMAIL SEND 
                            
                            $this->session->set_userdata('new_user', TRUE);
                            $this->session->set_flashdata('message', $this->ion_auth->messages());
                            redirect('/', 'refresh');                            
                            
                        } 
                        // ***END OF AUTO LOGIN***
		}
		else
		{
			//display the signup form
			//set the flash data error message if there is one
			$this->data['message'] = ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'));

			//$this->_render_page('auth/signup', $this->data);
                        $this->data['title']="Account Sign Up";
                        $this->data['content']="pages/_signup";
                        $this->_render_page('canvas', $this->data);
		}
            }
	}        
        function send_welcome_email($email){
            //LOAD LIBRARIES
            $this->load->config('ion_auth', TRUE);
            $this->load->library('email');        

            //CLEAR OUT ANY VARIABLES FROM A PREVIOUS MESSAGE
            $this->email->clear();

            //LOAD TEMPLATE
            $message = $this->load->view('emails/welcome.tpl.php', '', true);

            //GRAB CONFIG VALUES TO SET 'FROM' INFO
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));

            $subject = 'Welcome To Emplayo!';
            $this->email->to($email); 
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()){
                return TRUE;
            } else {
                return FALSE;
            }
            
        }
	//log the user in
	function login()
	{
            if ($this->ion_auth->logged_in()){
                redirect('/', 'refresh');
            }   else {
                    //validate form input
                    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                    $this->form_validation->set_rules('password', 'Password', 'required');

                    if ($this->form_validation->run() == true)
                    {
                            //check to see if the user is logging in
                            //check for "remember me"
                            $remember = (bool) $this->input->post('remember');

                            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
                            {
                                    //if the login is successful
                                    //redirect them back to the home page
                                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                                    redirect('/', 'refresh');
                            }
                            else
                            {
                                    //if the login was un-successful
                                    //redirect them back to the login page
                                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                                    redirect('login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
                            }
                    }
                    else
                    {
                            //the user is not logging in so display the login page
                            //set the flash data error message if there is one
                            $this->data['message'] = $this->session->flashdata('message');

                            $this->data['email'] = array('name' => 'email',
                                    'id' => 'email',
                                    'type' => 'text',
                                    'value' => $this->form_validation->set_value('email'),
                            );
                            $this->data['password'] = array('name' => 'password',
                                    'id' => 'password',
                                    'type' => 'password',
                            );

                            $this->data['title']="Login";	
                            $this->data['content']="pages/_login";
                            $this->_render_page('canvas', $this->data);                                                     
                    }
            }
	}

	//log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('login', 'refresh');
	}

	//forgot password
	function forgot_password()
	{           
            
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == false)
		{
			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                        $this->data['title']="Forgot Password";
                        $this->data['content']="pages/_forgot";
                        $this->_render_page('canvas', $this->data);                        
		}
		else
		{
			// get identity for that email
			$config_tables = $this->config->item('tables', 'ion_auth');
			$identity = $this->db->where('email', $this->input->post('email'))->limit('1')->get($config_tables['users'])->row();                        //
                        //$identity is an array; the entire row from the user db, with all of the user info
                        if (!empty($identity))                            
                        {
                            //we found a matching email address in our system
                            //run the forgotten password method to email an activation code to the user
                            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

                            if ($forgotten)
                            {
                                    //if there were no errors
                                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                                    redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
                            }
                            else
                            {
                                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                                    redirect("forgot", 'refresh');
                            }
                        }
                         else 
                         {
                             //we did NOT find a matching email address in our system
                             //re-display the form with an error
			     
                            $this->data['message'] = '<p class="errors">There is no user with that email address<br>in our system.</p>';
                            $this->data['title']="Forgot Password";
                            $this->data['content']="pages/_forgot";
                            $this->_render_page('canvas', $this->data);

                         }
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm Password', 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				//$this->_render_page('auth/reset_password', $this->data);
				$this->data['title']="Reset Password";
				$this->data['content']="pages/_reset";
				$this->_render_page('canvas', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error('This form post did not pass our security checks.');

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						// ***DO AUTO LOGIN HERE WITH ION_AUTH***
						$remember = FALSE;

						if ($this->ion_auth->login($user->email, $this->input->post('new'), $remember))
						{
							//if the login is successful, redirect user to the user home page
							$this->session->set_userdata('message', $this->ion_auth->messages());
							redirect('/', 'refresh');
						} 
						// ***END OF AUTO LOGIN***
						//$this->session->set_flashdata('message', $this->ion_auth->messages());
						//$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('user/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("forgot", 'refresh');
		}
	}

	//change password
	function change_password_ajax()
	{
		$this->form_validation->set_rules('old', 'Old password', 'required');
		$this->form_validation->set_rules('new_p', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			//$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                        $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new_p',
				'id'   => 'new_p',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			//$this->_render_page('change', $this->data);
                        //$message = "Please click on the image & crop to create your profile picture."; 
                        $messageToSend = array('success' => '0', 'message'=>$message);
                        $output = json_encode($messageToSend);
                        echo $output;                          
                        
                        
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new_p'));

			if ($change)
			{
				//if the password was successfully changed
				//$this->session->set_flashdata('message', $this->ion_auth->messages());
				//$this->logout();
                                $messageToSend = array('success' => '1', 'message'=>$this->ion_auth->messages());
                                $output = json_encode($messageToSend);
                                echo $output;                                 
                                
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				//redirect('change', 'refresh');
                                $messageToSend = array('success' => '0', 'message'=>$this->ion_auth->errors());
                                $output = json_encode($messageToSend);
                                echo $output;                                  
			}
		}
	}        
        
	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', 'Old password', 'required');
		$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			//render
			$this->_render_page('change', $this->data);
		}
		else
		{
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('change', 'refresh');
			}
		}
	}

	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("forgot", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		$id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error('This form post did not pass our security checks.');
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	//edit a user
	function edit_user($id)
	{
		$this->data['title'] = "Edit User";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		//process the phone number
		if (isset($user->phone) && !empty($user->phone))
		{
			$user->phone = explode('-', $user->phone);
		}

		//validate form input
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone1', 'First Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
		$this->form_validation->set_rules('phone2', 'Second Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
		$this->form_validation->set_rules('phone3', 'Third Part of Phone', 'required|xss_clean|min_length[4]|max_length[4]');
		$this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
		$this->form_validation->set_rules('groups', 'Groups', 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error('This form post did not pass our security checks.');
			}

			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone1') . '-' . $this->input->post('phone2') . '-' . $this->input->post('phone3'),
			);

			//Update the groups user belongs to
			$groupData = $this->input->post('groups');

			if (isset($groupData) && !empty($groupData)) {

				$this->ion_auth->remove_from_group('', $id);

				foreach ($groupData as $grp) {
					$this->ion_auth->add_to_group($grp, $id);
				}

			}

			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

				$data['password'] = $this->input->post('password');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->id, $data);

				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', "User Saved");
				redirect("auth", 'refresh');
			}
		}

		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone1'] = array(
			'name'  => 'phone1',
			'id'    => 'phone1',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone1', $user->phone[0]),
		);
		$this->data['phone2'] = array(
			'name'  => 'phone2',
			'id'    => 'phone2',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone2', $user->phone[1]),
		);
		$this->data['phone3'] = array(
			'name'  => 'phone3',
			'id'    => 'phone3',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone3', $user->phone[2]),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$this->_render_page('auth/edit_user', $this->data);
	}

	// create a new group
	function create_group()
	{
		$this->data['title'] = "Create Group";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		//validate form input
		$this->form_validation->set_rules('group_name', 'Group name', 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			//display the create group form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page('auth/create_group', $this->data);
		}
	}

	//edit a group
	function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = "Edit Group";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		//validate form input
		$this->form_validation->set_rules('group_name', 'Group name', 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('group_description', 'Group Description', 'xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', "Group Saved");
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['group'] = $group;

		$this->data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->_render_page('auth/edit_group', $this->data);
	}


	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

}
