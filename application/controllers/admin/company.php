<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Main controller for all company CRUD functions

class Company extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));        
        $this->load->database();
        $this->load->helper('image_functions_helper');
        
        $this->load->model('company_model');
        
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin())
        {
                redirect('/login', 'refresh');
        }        
    }
    
    //Listing - displays a list of the companies in the database
    public function listing()
    {
        //load table library for table generation
        $this->load->library('table');
        
        //this indicates the segment of the URI to look at for the offset paramater
        $uri_segment = 4;
        
        //params sent to the db lookup
        $offset = $this->uri->segment($uri_segment);
        $limit = 10;
  
        
        $display_filter = $this->input->post('filter');
        
        if (!empty($display_filter)){
            $this->session->set_userdata('display_filter',$display_filter);
        }
        
        $display_filter_from_session = $this->session->userdata('display_filter');
        
        switch ($display_filter_from_session) {
            case 1:
                //echo "case 1";
                $completion_array = array(0);
                //print_r($completion_array);
                break;
            case 2:
                //echo "case 2";
                $completion_array = array(100);
                //print_r($completion_array);
                break;
            default:
                //echo "case default";
                $completion_array = array(0,20,40,60,80,100);
                //print_r($completion_array);
                break;
        }        

        $id = $this->input->post('search_id');

        if (!empty($display_filter)){
            $this->session->set_userdata('display_filter',$display_filter);
        }        
        
        
        //grabbing the table data and format from the model
        $table_data = $this->company_model->build_company_table($limit,$offset,$completion_array,$id);
        $data['table'] = $table_data['table'];
        $data['num_rows'] = $table_data['num_rows'];
        
        //load pagination library
        $this->load->library('pagination');
        
        //pagination config parameters
        $config['base_url'] = '/admin/company/listing';
        //$config['use_page_numbers'] = TRUE;
        //$config['first_url'] = '1';

        $config['total_rows'] = $data['num_rows'];
        $config['per_page'] = $limit;         
        $config['uri_segment'] = $uri_segment;

        //initialize the pagination library with our config
        $this->pagination->initialize($config); 
        
        //build the pagination display
        $data['pagination'] = $this->pagination->create_links();

        //load the view
        //$this->load->view("admin/company/listing",$data);  
      
	if ($this->ion_auth->logged_in()){
		$data['title']="Company Listings";
		$data['content']="admin/company/_listing";
		$this->load->view('canvas', $data);
		$this->session->unset_userdata('message');
		
	}   else {
		$data['title']="Home";
		$data['content']="pages/_home";
		$this->load->view('canvas', $data);
	}
             
    }
    
    //Create a new company record
    public function create_step_1()
    {
        //Grab the data to be used to populate the form by default
        $data['category_array'] = $this->company_model->get_categories();
        $data['type_array'] = $this->company_model->get_ref('type');
        $data['pace_array'] = $this->company_model->get_ref('pace');
        $data['lifecycle_array'] = $this->company_model->get_ref('lifecycle');
        $data['corp_citizenship_array'] = $this->company_model->get_ref('corp_citizenship');
        $data['benefits_array'] = $this->company_model->get_ref('benefits');
        
        //validate the form (except for the file upload)
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('company_url', 'Company URL', 'required|prep_url');
        $this->form_validation->set_rules('jobs_url', 'Jobs URL', 'required|prep_url');
        $this->form_validation->set_rules('facebook_url', 'Facebook URL', 'prep_url');
        $this->form_validation->set_rules('twitter_url', 'Twitter URL', 'prep_url');
        $this->form_validation->set_rules('company_type', 'Company Type', 'required');
        $this->form_validation->set_rules('company_pace', 'Company Pace', 'required');
        $this->form_validation->set_rules('company_lifecycle', 'Company Lifecycle', 'required');
        $this->form_validation->set_rules('corp_citizenship', 'Corporate Citizenship', 'required');
        $this->form_validation->set_rules('benefits', 'Benefits', 'required');
        $this->form_validation->set_rules('category[]', 'Category', 'required');            

        if ($this->form_validation->run() == true)
        {
            //validation is good.  setup the data to pass to the session
            $step_1_post = array();
            $step_1_post['company_name'] = $this->input->post('company_name');
            $step_1_post['company_url'] = $this->input->post('company_url');
            $step_1_post['jobs_url'] = $this->input->post('jobs_url');
            $step_1_post['facebook_url'] = $this->input->post('facebook_url');
            $step_1_post['twitter_url'] = $this->input->post('twitter_url');
            $step_1_post['company_type'] = $this->input->post('company_type');
            $step_1_post['company_pace'] = $this->input->post('company_pace');
            $step_1_post['company_lifecycle'] = $this->input->post('company_lifecycle');
            $step_1_post['corp_citizenship'] = $this->input->post('corp_citizenship');
            $step_1_post['benefits'] = $this->input->post('benefits');
            $step_1_post['category'] = $this->input->post('category');
 
            //save the data to the session
            $this->session->set_userdata($step_1_post);//should confirm that this is actually set...
            
            //pass the user to step 2 of the process..
            redirect('admin/company/create_step_2', 'refresh');

        }  
        else //form validation errors.  re-load the form
        {
            $data['message'] = $this->session->flashdata('message');

            //load the view
            $this->load->view("admin/company/create_step_1",$data);          
        }        
    }      
    

    function create_step_2()
    {

        $this->load->view("admin/company/create_step_2");     

    }      

    function create_save()
    {
        //grab the data from the session, then send to the model to insert
        $post_data = array();
        $post_data['company_name'] = $this->session->userdata('company_name');
        $post_data['company_url'] = $this->session->userdata('company_url');
        $post_data['jobs_url'] = $this->session->userdata('jobs_url');
        $post_data['facebook_url'] = $this->session->userdata('facebook_url');
        $post_data['twitter_url'] = $this->session->userdata('twitter_url');
        $post_data['company_type'] = $this->session->userdata('company_type');
        $post_data['company_pace'] = $this->session->userdata('company_pace');
        $post_data['company_lifecycle'] = $this->session->userdata('company_lifecycle');
        $post_data['corp_citizenship'] = $this->session->userdata('corp_citizenship');
        $post_data['benefits'] = $this->session->userdata('benefits');
        $post_data['category'] = $this->session->userdata('category');
        $post_data['company_logo'] = $this->session->userdata('company_logo');
        $post_data['creative_logo'] = $this->session->userdata('creative_logo');

        //commit all session data to the database
        if ($this->company_model->create_company($post_data))
        {
            //success
            //move the image files from temp to the working directory
            $original_path = './'.COMPANY_LOGO_TEMP_PATH;
            $destination_path = './'.COMPANY_LOGO_PATH;
            $original_logo = $original_path.$post_data['company_logo'];
            $original_creative = $original_path.$post_data['creative_logo'];
            $destination_logo = $destination_path.$post_data['company_logo'];
            $destination_creative = $destination_path.$post_data['creative_logo'];            
            
            
            rename($original_logo,$destination_logo);
            rename($original_creative,$destination_creative);
        
            //clear the session data
            $this->session->unset_userdata($post_data);


            //update the message
            $message =  "Record successfully inserted.";
            $this->session->set_flashdata('message', $message);

            //load the view                
           redirect('admin/company/listing', 'refresh');                     
        } 
        else
        {
            //there were errors
            $data['errors'] = $this->company_model->errors;

            //load the view
            $this->load->view("admin/company/create_step_1",$data); 
        }      
    }     
    
    //Delete a company from the database and all linked tables
    public function delete($company_id)
    {
        $data['company_info'] = $this->company_model->get_company_info($company_id);
        $data['company_id'] = $company_id;
        
        if ($this->input->post())
            //If the form has been posted...
        {
            if ($this->input->post('delete')=='1')
            {
                //Attempt to delete the company
                $result = $this->company_model->delete_company($company_id);
                
                if ($result)
                {
                    //successfully deleted from database
                    //now delete images from filesystem:
                    $image_path = './'.COMPANY_LOGO_PATH;
                    $company_logo_path = $image_path.$data['company_info']['company_logo'];
                    $creative_logo_path = $image_path.$data['company_info']['creative_logo'];
                    if (file_exists($creative_logo_path)){
                        unlink($creative_logo_path);
                    }
                    if (file_exists($company_logo_path)){
                        unlink($company_logo_path);
                    }                    
 
                    //successfully deleted files
                    $message =  $data['company_info']['company_name']." company information deleted";
                    $this->session->set_flashdata('message', $message);
                    //echo "success";
                    redirect('admin/company/listing', 'refresh');                         
                  
                   
                }
                else
                {
                    //there was an error
                    $message =  "There was an error while attempting to delete the following company: ".$data['company_info']['company_name']." from the database.";
                    $this->session->set_flashdata('message', $message);
                    //echo "db error";
                    redirect('admin/company/listing', 'refresh');                       
                }
            }
            else
            {
                $message =  "No delete performed.  Action cancelled.";
                $this->session->set_flashdata('message', $message);                
                redirect('admin/company/listing', 'refresh');
            }
            
        }
        else//the form has not been posted
        {
            //redisplay the view
            $this->load->view("admin/company/delete",$data);
        }  
    }    

    //Update an existing company record
    public function update($id)
    {
        //Grab the data to be used to populate the form
        $data['company_id'] = $id;
        $data['category_array'] = $this->company_model->get_categories();
        $data['type_array'] = $this->company_model->get_ref('type');
        $data['pace_array'] = $this->company_model->get_ref('pace');
        $data['lifecycle_array'] = $this->company_model->get_ref('lifecycle');
        $data['corp_citizenship_array'] = $this->company_model->get_ref('corp_citizenship');
        $data['benefits_array'] = $this->company_model->get_ref('benefits');
        
        if (isset($id)){
            //get the data for the specified company id
            $data['company_info'] = '';
            $data['company_info'] = $this->company_model->get_company_info($id);
            $data['benefits_info'] = $this->company_model->get_benefits_info($id);
            $data['categories_info'] = $this->company_model->get_categories_info($id);
 
        }
        
        
        //validate the form (except for the file upload)
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('company_url', 'Company URL', 'required|prep_url');
        $this->form_validation->set_rules('jobs_url', 'Jobs URL', 'required|prep_url');
        $this->form_validation->set_rules('facebook_url', 'Facebook URL', 'prep_url');
        $this->form_validation->set_rules('twitter_url', 'Twitter URL', 'prep_url');        
        $this->form_validation->set_rules('company_type', 'Company Type', 'required');
        $this->form_validation->set_rules('company_pace', 'Company Pace', 'required');
        $this->form_validation->set_rules('company_lifecycle', 'Company Lifecycle', 'required');
        $this->form_validation->set_rules('corp_citizenship', 'Corporate Citizenship', 'required');
        $this->form_validation->set_rules('benefits', 'Benefits', 'required');
        $this->form_validation->set_rules('category[]', 'Category', 'required');            

        if ($this->form_validation->run() == true)
        {   
            //validation is good.  setup the data to pass to the model
            $post = $this->input->post();

            //setup the file upload config values
            $config['upload_path'] = './'.COMPANY_LOGO_PATH;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '100';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';
            $config['remove_spaces']  = 'TRUE';
            //$config['max_filename']  = 20;
            $config['file_name']  = strtolower($post['company_name'].'_'.substr(md5($post['company_name']),10));

            //load the upload library
            $this->load->library('upload', $config);            
            
            if ($this->upload->do_upload())
            {
                $upload_data = array('upload_data' => $this->upload->data());
                
                //if everything looks good, insert the data into the db
                if ($this->company_model->update_company($post,$upload_data,$id))
                {
                    //success
                    $message =  "Record successfully updated.";
                    $this->session->set_flashdata('message', $message);
                    //load the view
                   redirect($this->uri->uri_string(), 'refresh');
                } 
                else
                {
                    //there were errors
                    $data['errors'] = $this->company_model->errors;

                    //load the view
                    $this->load->view("admin/company/update",$data); 
                }                
            }
            else //there was an error with the file upload
            {
                $upload_error = array('error' => $this->upload->display_errors());
                $data['message'] = $this->session->flashdata('message');
                $data['upload_error'] = $upload_error;

                //load the view
                $this->load->view("admin/company/update",$data);                   
            }
        }  
        else //form validation errors.  re-load the form
        {
            $data['message'] = $this->session->flashdata('message');

            //load the view
            $this->load->view("admin/company/update",$data); 
        }        
    }        
 
    //Update an existing company record
    public function overview($id)
    {
        //Grab the data to be used to populate the form
        $data['company_id'] = $id;
        $data['category_array'] = $this->company_model->get_categories();
        $data['type_array'] = $this->company_model->get_ref('type');
        $data['pace_array'] = $this->company_model->get_ref('pace');
        $data['lifecycle_array'] = $this->company_model->get_ref('lifecycle');
        $data['corp_citizenship_array'] = $this->company_model->get_ref('corp_citizenship');
        $data['benefits_array'] = $this->company_model->get_ref('benefits');
        
        if (isset($id)){
            //get the data for the specified company id
            $data['company_info'] = '';
            $data['company_info'] = $this->company_model->get_company_info($id);
            $data['benefits_info'] = $this->company_model->get_benefits_info($id);
            $data['categories_info'] = $this->company_model->get_categories_info($id);
        }
	
	//load the view
	if ($this->ion_auth->logged_in()){
		$data['title']="Company Listings";
		$data['content']="admin/company/_overview";
		$this->load->view('canvas', $data);
		$this->session->unset_userdata('message');
	}   else {
		$data['title']="Home";
		$data['content']="pages/_home";
		$this->load->view('canvas', $data);
	}
               
    }//view  
    
    //Update an existing company record
    public function update_step_1($id)
    {
        //Grab the data to be used to populate the form
        $data['company_id'] = $id;
        $data['category_array'] = $this->company_model->get_categories();
        $data['type_array'] = $this->company_model->get_ref('type');
        $data['pace_array'] = $this->company_model->get_ref('pace');
        $data['lifecycle_array'] = $this->company_model->get_ref('lifecycle');
        $data['corp_citizenship_array'] = $this->company_model->get_ref('corp_citizenship');
        $data['benefits_array'] = $this->company_model->get_ref('benefits');
        
        if (isset($id)){
            //get the data for the specified company id
            $data['company_info'] = '';
            $data['company_info'] = $this->company_model->get_company_info($id);
            $data['benefits_info'] = $this->company_model->get_benefits_info($id);
            $data['categories_info'] = $this->company_model->get_categories_info($id);
        }
        //validate the form (except for the file upload)
        $this->form_validation->set_rules('company_name', 'Company Name');
        $this->form_validation->set_rules('company_url', 'Company URL', 'prep_url');
        $this->form_validation->set_rules('jobs_url', 'Jobs URL', 'prep_url');
        $this->form_validation->set_rules('facebook_url', 'Facebook URL', 'prep_url');
        $this->form_validation->set_rules('twitter_url', 'Twitter URL', 'prep_url');        
        $this->form_validation->set_rules('company_type', 'Company Type');
        $this->form_validation->set_rules('company_pace', 'Company Pace');
        $this->form_validation->set_rules('company_lifecycle', 'Company Lifecycle');
        $this->form_validation->set_rules('corp_citizenship', 'Corporate Citizenship');
        $this->form_validation->set_rules('benefits', 'Benefits');
        $this->form_validation->set_rules('category[]', 'Category'); 
        
        /*
        $this->form_validation->set_rules('company_name', 'Company Name', 'required');
        $this->form_validation->set_rules('company_url', 'Company URL', 'required|prep_url');
        $this->form_validation->set_rules('jobs_url', 'Jobs URL', 'required|prep_url');
        $this->form_validation->set_rules('facebook_url', 'Facebook URL', 'prep_url');
        $this->form_validation->set_rules('twitter_url', 'Twitter URL', 'prep_url');        
        $this->form_validation->set_rules('company_type', 'Company Type', 'required');
        $this->form_validation->set_rules('company_pace', 'Company Pace', 'required');
        $this->form_validation->set_rules('company_lifecycle', 'Company Lifecycle', 'required');
        $this->form_validation->set_rules('corp_citizenship', 'Corporate Citizenship', 'required');
        $this->form_validation->set_rules('benefits', 'Benefits', 'required');
        $this->form_validation->set_rules('category[]', 'Category', 'required'); 
        */

        if ($this->form_validation->run() == true)
        {   
            //validation is good.  setup the data to pass to the session
            $step_1_post = array();
            $step_1_post['company_name'] = $this->input->post('company_name');
            $step_1_post['company_url'] = $this->input->post('company_url');
            $step_1_post['jobs_url'] = $this->input->post('jobs_url');
            $step_1_post['facebook_url'] = $this->input->post('facebook_url');
            $step_1_post['twitter_url'] = $this->input->post('twitter_url');            
            $step_1_post['company_type'] = $this->input->post('company_type');
            $step_1_post['company_pace'] = $this->input->post('company_pace');
            $step_1_post['company_lifecycle'] = $this->input->post('company_lifecycle');
            $step_1_post['corp_citizenship'] = $this->input->post('corp_citizenship');
            $step_1_post['benefits'] = $this->input->post('benefits');
            $step_1_post['category'] = $this->input->post('category');
 
            //save the data to the session
            $this->session->set_userdata($step_1_post);//should confirm that this is actually set...
            
            //pass the user to step 2 of the process..
            redirect('admin/company/update_step_2/'.$id, 'refresh');
        }  
        else //form validation errors.  re-load the form
        {
            $data['message'] = $this->session->flashdata('message');

            //load the view
            $this->load->view("admin/company/update_step_1",$data); 
        }        
    }//update_step_1
    
    function update_step_2($id)
    {
        $company_info = $this->company_model->get_company_info($id);
        $data['company_logo'] =  $company_info['company_logo'];
        $data['creative_logo'] =  $company_info['creative_logo'];
        $data['company_id'] = $id;
        
        $this->load->view("admin/company/update_step_2",$data);     

    }         
    //Update Save function will commit all changes
    //(should consider adding cancel functionality in case a user wants to abort the process
    //...would include a cancel button in the view.  In the controller we would need
    //to clear the files from the temp folder and also clear out the session.
    //granularity would be useful, as in: cancel just the photo change, or cancel the entire change?
    function update_save($id)
    {
     
        //grab the data from the session, then send to the model to insert
        $post_data = array();
        $post_data['company_name'] = $this->session->userdata('company_name');
        $post_data['company_url'] = $this->session->userdata('company_url');
        $post_data['jobs_url'] = $this->session->userdata('jobs_url');
        $post_data['facebook_url'] = $this->session->userdata('facebook_url');
        $post_data['twitter_url'] = $this->session->userdata('twitter_url');        
        $post_data['company_type'] = $this->session->userdata('company_type');
        $post_data['company_pace'] = $this->session->userdata('company_pace');
        $post_data['company_lifecycle'] = $this->session->userdata('company_lifecycle');
        $post_data['corp_citizenship'] = $this->session->userdata('corp_citizenship');
        $post_data['benefits'] = $this->session->userdata('benefits');
        $post_data['category'] = $this->session->userdata('category');
        $post_data['company_logo'] = $this->session->userdata('company_logo');
        $post_data['creative_logo'] = $this->session->userdata('creative_logo');   
        $new_company_logo = '';
        $new_creative_logo = '';
        
        
        //the user may not have changed the logos..if not, assign the current value to the array
        if (empty($post_data['company_logo'])){
            //echo "1";
            $company_info = $this->company_model->get_company_info($id);
            $post_data['company_logo'] =  $company_info['company_logo'];
            $new_company_logo = FALSE;     
        } else {
            $new_company_logo = TRUE;
            }
        
        if (empty($post_data['creative_logo'])){
            //echo "2";
            $company_info = $this->company_model->get_company_info($id);
            $post_data['creative_logo'] =  $company_info['creative_logo']; 
            $new_creative_logo = FALSE;
        } else {
            $new_creative_logo = TRUE;
            }    

        //commit all session data to the database
       // if ($this->company_model->update_company($post_data,$id))
        if ($this->company_model->update_company_flexible($post_data,$id))        
        { //success
                //move the image files from temp to the working directory
                $original_path = './'.COMPANY_LOGO_TEMP_PATH;
                $destination_path = './'.COMPANY_LOGO_PATH;            
            
            if ($new_company_logo){               
                $original_logo = $original_path.$post_data['company_logo'];
                $destination_logo = $destination_path.$post_data['company_logo'];           
                rename($original_logo,$destination_logo);
            }
            
            if ($new_creative_logo){
                $original_creative = $original_path.$post_data['creative_logo'];
                $destination_creative = $destination_path.$post_data['creative_logo'];            
                rename($original_creative,$destination_creative);
            }            
        
            //clear the session data
            $this->session->unset_userdata($post_data);


            //update the message
            $message =  "Company successfully updated.";
            $this->session->set_flashdata('message', $message);

            //load the view                
            //echo "successful update";
           redirect('admin/company/listing', 'refresh');                     
        } 
        else
        {
            //there were errors
            $data['errors'] = $this->company_model->errors;

            //load the view
            $this->load->view("admin/company/update_step_1",$data); 
        }      
        
    }//update_save     
        
    
    public function company_name_search()
    {
        
        if(($this->input->post('kw')) && ($this->input->post('kw') != ''))    
        {
            $kws = $this->input->post('kw');
            $this->company_model->company_name_search($kws);
            
        }        
    }//end of company_name_search      

    function logo_upload()
    {    
        
        //setup the file upload config values
        $config['upload_path'] = './'.COMPANY_LOGO_TEMP_PATH;
        //$config['upload_path'] = './uploads/images/company_logos/temp/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']	= '1024';
        //$config['max_width']  = '2024';
        //$config['max_height']  = '2024';
        $config['remove_spaces']  = 'TRUE';
        //$config['file_name']  = strtolower($name.'_'.substr(md5($name),10));
        $config['encrypt_name']  = 'TRUE';
        $config['max_filename']  = 15;
        
        $max_dimension = "500";		// Max width allowed for the large image
        $min_dimension = "250";        
        
        //get the value for the last temp file that was uploaded (if this is beyond the first upload)
        //we can use this to clean up any abandoned files
        $last_temp_file = $this->input->post('last_temp_file');
        $full_temp_path = $config['upload_path'].$last_temp_file;
       
       // echo "<br>base: ".base_url();
       // echo "<br>site: ".site_url();
       // echo "<br>current: ".current_url();
        //echo $config['upload_path'];
        //var_dump(is_dir(COMPANY_LOGO_TEMP_PATH));
        
        if ($last_temp_file){
            unlink($full_temp_path);
        }

        //load the upload library
        $this->load->library('upload', $config);            
        //attempt to upload the file
        if ($this->upload->do_upload())      
        {
            $upload_data = array('upload_data' => $this->upload->data());
            $pic_name = $upload_data['upload_data']['file_name'];  
            
            $temp_image_location = $config['upload_path'].$pic_name;            
            
            //get height, width & scale if too big
            $width = getWidth($temp_image_location);
            $height = getHeight($temp_image_location);			

            //find out which dimension is larger (we need both min and max)
            //this only works because the picture is a square
            if ($width > $height){
                    $max_dimension_num = $width;
                    $min_dimension_num = $height;
            }else
            {
                    $max_dimension_num = $height;
                    $min_dimension_num = $width;
            }

            //error if image is too small
            if ($min_dimension_num < $min_dimension){
                    $error_message = "Please use a larger image that is at least $min_dimension px in both width and height.";
                    $this->sendToJS(0, $error_message);                    
                    
            }

            /*
            //test file conversion to .jpg
            $large_image_location = convertImage($large_image_location);
            chmod($large_image_location, 0777);*/

            //Scale the image if it is greater than the max dimension
            if ($max_dimension_num > $max_dimension){
                    $scale = $max_dimension/$max_dimension_num;
                    $uploaded = resizeImage_lossless($temp_image_location,$width,$height,$scale);
                    //squarify was causing problems with 250x250 images...need to review the math here and 
                    // probably put a conditional in front of this...
                    $square_image = squarify_lossless($uploaded,$max_dimension);
            }else{
                    $scale = 1;
                    $uploaded = resizeImage_lossless($temp_image_location,$width,$height,$scale);
                    $square_image = squarify_lossless($uploaded,$max_dimension);
            } 
            $new_pic_name = basename($uploaded);

            //set data array of picture location & print to JavaSrcipt

            //$new_file_name  = substr($file_name, 0, strrpos($file_name, '.')).".jpg";
            //$this->sendToJS(1, $new_file_name);

            //sendToJS(1, $file_name);            

            //upload was successful.  grab some data, then return a success message

            $messageToSend = array('success' => '1', 'message'=>$new_pic_name, 'last_temp_file'=>$last_temp_file);
            $output = json_encode($messageToSend);
            echo $output; 

        }
        else //there was an error with the file upload
        {
            $ci_upload_error = $this->upload->display_errors();
            if ($ci_upload_error){
                $message = $ci_upload_error;
            } else {
                $message = 'There was an error with the upload.  Please try again.';
            }
            //
            $messageToSend = array('success' => '0', 'message'=> $message,);
            $output = json_encode($messageToSend);
            echo $output;  
        }            
    } 
    
    function tile_upload()
    {    
        //setup the file upload config values
        $config['upload_path'] = './'.PROFILE_PIC_TEMP_PATH;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']	= '1024';
        $config['remove_spaces']  = 'TRUE';
        $config['encrypt_name']  = 'TRUE';
        $config['max_filename']  = 15;     
        $max_dimension = "600";		// They can upload a larger image.  This is the max size we will scale it down to.
        $min_dimension = "390";         // They must upload an image at least this big in both dimensions.
        
        //get the value for the last temp file that was uploaded (if this is beyond the first upload)
        //we can use this to clean up any abandoned files
        $last_temp_file = $this->input->post('last_temp_file');
        $full_temp_path = $config['upload_path'].$last_temp_file;

        if ($last_temp_file){
            unlink($full_temp_path);
        }

        //load the upload library
        $this->load->library('upload', $config);            

        //attempt to upload the file
        if ($this->upload->do_upload())      
        {
            $upload_data = array('upload_data' => $this->upload->data());
            $pic_name = $upload_data['upload_data']['file_name'];  
            
            $temp_image_location = $config['upload_path'].$pic_name;            
            
            //get height, width & scale if too big
            $width = getWidth($temp_image_location);
            $height = getHeight($temp_image_location);			

            //find out which dimension is larger (we need both min and max)
            //this only works because the picture is a square
            if ($width > $height){
                    $max_dimension_num = $width;
                    $min_dimension_num = $height;
            }else
            {
                    $max_dimension_num = $height;
                    $min_dimension_num = $width;
            }

            //error if image is too small
            if ($min_dimension_num < $min_dimension){
                    $error_message = "Please use a larger image that is at least $min_dimension px in both width and height.";
                    $this->sendToJS(0, $error_message);                    
                    
            }

            //Scale the image if it is greater than the max dimension
            if ($max_dimension_num > $max_dimension){
                    $scale = $max_dimension/$max_dimension_num;
                    if (($scale*$min_dimension_num)<$min_dimension){
                        $error_message = "This image does not meet our dimension requirements of $min_dimension pixels tall and wide.  Please use a different image.";
                        $this->sendToJS(0, $error_message);                     
                    } else {
                        $uploaded = resizeImage($temp_image_location,$width,$height,$scale);
                        //$square_image = squarify($uploaded,$max_dimension);
                    }
            }else{
                    $scale = 1;
                    $uploaded = resizeImage($temp_image_location,$width,$height,$scale);
                    //$square_image = squarify($uploaded,$max_dimension);
            } 
            $new_pic_name = basename($uploaded);    

            //upload was successful.  grab some data, then return a success message

            $messageToSend = array('success' => '1', 'message'=>$new_pic_name, 'last_temp_file'=>$last_temp_file);
            $output = json_encode($messageToSend);
            echo $output; 

        }
        else //there was an error with the file upload
        {
            $ci_upload_error = $this->upload->display_errors();
            if ($ci_upload_error){
                $message = $ci_upload_error;
            } else {
                $message = 'There was an error with the upload.  Please try again.';
            }
            //
            $messageToSend = array('success' => '0', 'message'=> $message);
            $output = json_encode($messageToSend);
            echo $output;  
        }            
    }//end of tile_upload     

    function sendToJS($successFlag, $message){

        $messageToSend = array('success' => $successFlag, 'message'=>$message);
        $output = json_encode($messageToSend);
        die($output);
    }    
    
    //The Crop function is called via AJAX
    public function crop()
    {
        //$this->load->helper('image_functions_helper');
        
        $profile_width = "250";		// Width of profile picture
        $profile_height = "250";	// Height of profile picture       
        
        $x1 = $this->input->post('x1');
        $y1 = $this->input->post('y1');
        $x2 = $this->input->post('x2');
        $y2 = $this->input->post('y2');
        $w = $this->input->post('w');
        $h = $this->input->post('h');   
        $picture_name_input= $this->input->post('cropFile');
        $pic_db_field= $this->input->post('pic_db_field');

        
        //if coordinates are empty or not numeric, send error message to JS
        if ($x1 === NULL || $y1 === NULL || $x2 === NULL || $y2 === NULL || $w === NULL || $h === NULL || $picture_name_input === NULL || $pic_db_field === NULL
                || !is_numeric($x1) || !is_numeric($y1) || !is_numeric($x2) || !is_numeric($y2) || !is_numeric($w) || !is_numeric($h))
        {          
            $message = "Please click on the image & crop to create your profile picture."; 
            $messageToSend = array('success' => '0', 'message'=>$message);
            $output = json_encode($messageToSend);
            echo $output;              
        }
        else
        {
        
            $original_location = './'.COMPANY_LOGO_TEMP_PATH.$picture_name_input;
            $profile_path = './'.COMPANY_LOGO_PATH;
            $profile_image_location = $profile_path."/".$picture_name_input;

            $scale = $profile_width/$w;
            $cropped = '';
             $cropped = resizeThumbnailImage_jpgout($original_location, $original_location,$w,$h,$x1,$y1,$scale);
              //$cropped = resizeThumbnailImage($original_location, $original_location,$w,$h,$x1,$y1,$scale);
                       
            //the resizeThumbnailImage function will resize the image and save it into the $profile_path

            if (!empty($cropped)){
                //delete the temp file
                //unlink($original_location);//removed this...will commit all deletes and moves in the final step

                //save the image name to the session
                //$this->session->set_userdata($pic_db_field,$picture_name_input);
                
                //added the following to get the actual file name from the resize function.
                //that way, if the filename is changed there, we have it to use here, 
                //instead of relying on the old info passed by the client.
                
                $file_name  = substr($cropped,(strrpos($cropped, '/')+1));
                //echo "filename: $file_name";
                $this->session->set_userdata($pic_db_field,$file_name);

                //success
                $messageToSend = array('success' => '1', 'message'=>'Photo successfully processed.');
                $output = json_encode($messageToSend);
                echo $output;              

            }
            else
            {
                //There was an error with the DB insert
                $messageToSend = array('success' => '0', 'message'=>'There was an error processing the photo.');
                $output = json_encode($messageToSend);
                echo $output;  
            }  
        }
    } 
    
     //The Crop function is called via AJAX
    public function crop_png()
    {
        //$this->load->helper('image_functions_helper');
        
        $profile_width = "250";		// Width of profile picture
        $profile_height = "250";	// Height of profile picture       
        
        $x1 = $this->input->post('x1');
        $y1 = $this->input->post('y1');
        $x2 = $this->input->post('x2');
        $y2 = $this->input->post('y2');
        $w = $this->input->post('w');
        $h = $this->input->post('h');   
        $picture_name_input= $this->input->post('cropFile');
        $pic_db_field= $this->input->post('pic_db_field');

        
        //if coordinates are empty or not numeric, send error message to JS
        if ($x1 === NULL || $y1 === NULL || $x2 === NULL || $y2 === NULL || $w === NULL || $h === NULL || $picture_name_input === NULL || $pic_db_field === NULL
                || !is_numeric($x1) || !is_numeric($y1) || !is_numeric($x2) || !is_numeric($y2) || !is_numeric($w) || !is_numeric($h))
        {          
            $message = "Please click on the image & crop to create your profile picture."; 
            $messageToSend = array('success' => '0', 'message'=>$message);
            $output = json_encode($messageToSend);
            echo $output;              
        }
        else
        {
        
            $original_location = './'.COMPANY_LOGO_TEMP_PATH.$picture_name_input;
            $profile_path = './'.COMPANY_LOGO_PATH;
            $profile_image_location = $profile_path."/".$picture_name_input;

            $scale = $profile_width/$w;
            $cropped = '';
             //$cropped = resizeThumbnailImage_jpgout($original_location, $original_location,$w,$h,$x1,$y1,$scale);
             $cropped = resizeThumbnailImage($original_location, $original_location,$w,$h,$x1,$y1,$scale);
                       
            //the resizeThumbnailImage function will resize the image and save it into the $profile_path

            if (!empty($cropped)){
                //delete the temp file
                //unlink($original_location);//removed this...will commit all deletes and moves in the final step

                //save the image name to the session
                //$this->session->set_userdata($pic_db_field,$picture_name_input);
                
                //added the following to get the actual file name from the resize function.
                //that way, if the filename is changed there, we have it to use here, 
                //instead of relying on the old info passed by the client.
                
                $file_name  = substr($cropped,(strrpos($cropped, '/')+1));
                //echo "filename: $file_name";
                $this->session->set_userdata($pic_db_field,$file_name);

                //success
                $messageToSend = array('success' => '1', 'message'=>'Photo successfully processed.');
                $output = json_encode($messageToSend);
                echo $output;              

            }
            else
            {
                //There was an error with the DB insert
                $messageToSend = array('success' => '0', 'message'=>'There was an error processing the photo.');
                $output = json_encode($messageToSend);
                echo $output;  
            }  
        }
    }     
    
     //The Crop function is called via AJAX
    public function tile_crop()
    {
        //$this->load->helper('image_functions_helper');
        
        $pic_shape = $this->input->post('pic_shape');
        
        switch ($pic_shape) {
            case 1://small
                $profile_width = "190";
                $profile_height = "190";
                break;
            case 2://wide
                $profile_width = "390";
                $profile_height = "190";
                break;
            case 3://tall
                $profile_width = "190";
                $profile_height = "390";
                break;
            case 4://large
                $profile_width = "390";
                $profile_height = "390";
                break;            
        }             
        
        $x1 = $this->input->post('x1');
        $y1 = $this->input->post('y1');
        $x2 = $this->input->post('x2');
        $y2 = $this->input->post('y2');
        $w = $this->input->post('w');
        $h = $this->input->post('h');   
        $picture_name_input= $this->input->post('cropFile');
        $pic_db_field= $this->input->post('pic_db_field');
        $company_id= $this->input->post('company_id');

        
        //if coordinates are empty or not numeric, send error message to JS
        if ($x1 === NULL || $y1 === NULL || $x2 === NULL || $y2 === NULL || $w === NULL || $h === NULL || $picture_name_input === NULL || $pic_db_field === NULL
                || !is_numeric($x1) || !is_numeric($y1) || !is_numeric($x2) || !is_numeric($y2) || !is_numeric($w) || !is_numeric($h))
        {          
            $message = "Please click on the image & crop to create your profile picture."; 
            $messageToSend = array('success' => '0', 'message'=>$message);
            $output = json_encode($messageToSend);
            echo $output;              
        }
        else
        {
        
            $original_location = './'.PROFILE_PIC_TEMP_PATH.$picture_name_input;
            $cropped_image_name = '';
            //$cropped_image_name = 't_'.$picture_name_input;
            $cropped_image_name  = substr($picture_name_input, 0, strrpos($picture_name_input, '.'))."_c".$pic_shape.".jpg";
            $cropped_image_location = './'.PROFILE_PIC_TEMP_PATH.$cropped_image_name;
            
            //$profile_path = "./assets/images/company_tiles";
            //$profile_image_location = $profile_path."/".$picture_name_input;

            $scale = $profile_width/$w;
            $cropped = '';
            //$cropped = resizeThumbnailImage($profile_image_location, $original_location,$w,$h,$x1,$y1,$scale);
            $cropped = resizeThumbnailImage($cropped_image_location, $original_location,$w,$h,$x1,$y1,$scale);
            //the resizeThumbnailImage function will resize the image and save it into the $profile_path

            if (!empty($cropped)){
                //delete the temp file
                //unlink($original_location);//removed this...will commit all deletes and moves in the final step

                //save the image name to the session
                $this->session->set_userdata($pic_db_field,$picture_name_input);
                
                
                if ($this->tile_save($company_id,$pic_shape,$picture_name_input,$cropped_image_name))
                {
                    //success
                    $messageToSend = array('success' => '1', 'message'=>'Photo successfully processed.', 'pic_name'=>$picture_name_input);
                    $output = json_encode($messageToSend);
                    echo $output;   
                } else 
                {
                    $messageToSend = array('success' => '0', 'message'=>'There was an error saving the photo');
                    $output = json_encode($messageToSend);
                    echo $output;                       
                }
               
            }
            else
            {
                //There was an error with the DB insert
                $messageToSend = array('success' => '0', 'message'=>'There was an error processing the photo.');
                $output = json_encode($messageToSend);
                echo $output;  
            }  
        }
    }//end of tile_crop  
    
    function tile_save($company_id,$pic_shape,$picture_name_input,$cropped_image_name){
        
        //save the image info to the db
        $result = $this->company_model->insert_profile_pics($company_id,$pic_shape,$cropped_image_name);
        
        //move the files from temp to the proper path
            $original_path = './'.PROFILE_PIC_TEMP_PATH;
            $destination_path = './'.PROFILE_PIC_PATH;
            $original_pic = $original_path.$picture_name_input;
            $original_crop = $original_path.$cropped_image_name;
            $destination_pic = $destination_path.$picture_name_input;
            $destination_crop = $destination_path.$cropped_image_name;                 
        
        if ($result){
            $move_pic = rename($original_pic,$destination_pic);
            $move_crop = rename($original_crop,$destination_crop);  
            
            if ($move_pic && $move_crop){
                return TRUE;
            } else {
                return FALSE;
            }
        }
        else {
            return FALSE;
        }
    }


    function validateCoordinates($number){

	if($number == NULL || strlen($number) == 0)
	{
		//$error_message = "Please click on the image & crop to create your tile.";
		//sendToJS(0, $error_message);
            return FALSE;
	
	}elseif (!preg_match('/^[0-9 ]+$/', $number)){
		
		//$error_message = "Please click on the image & crop to create your tile.";
		//sendToJS(0, $error_message);
            return FALSE;
	
	}else
	{
		return $number;
	}

}

    function profile_edit($id)
    {
        $company_info = $this->company_model->get_company_info($id);
        $data['company_logo'] =  $company_info['company_logo'];
        $data['creative_logo'] =  $company_info['creative_logo'];
        $data['company_id'] = $id;
        $data['company_info'] = $company_info;
        
        $this->load->view("admin/company/profile_edit",$data);     

    }  
    
    function profile_view($id)
    {
        $this->form_validation->set_rules('pics_to_delete', 'A selected picture to delete', 'required');            

        if ($this->form_validation->run() == true)
        {   
            $pics_to_delete = $this->input->post('pics_to_delete');
            if ($this->company_model->delete_profile_pics($pics_to_delete,$id))
            {
                //update the message
                $message =  "Profile Pictures successfully deleted.";
                $this->session->set_flashdata('message', $message);

                //load the view                
                redirect('admin/company/profile_view/'.$id, 'refresh');
            }
            else
            {
                 //update the message
                $message =  "There was an error with your request";
                $this->session->set_flashdata('message', $message);

                //load the view                
                redirect('admin/company/quotes_view/'.$id, 'refresh');
            }
        }   
        else
        {
            $company_info = $this->company_model->get_company_info($id);
            $profile_pics = $this->company_model->view_profile_pics($id);
            $data['company_logo'] =  $company_info['company_logo'];
            $data['creative_logo'] =  $company_info['creative_logo'];
            $data['company_id'] = $id;
            $data['company_info'] = $company_info;
            $data['profile_pics'] = $profile_pics;

            $this->load->view("admin/company/profile_view",$data); 
        }
    }      

    function quotes_view($id)
    {
        $this->form_validation->set_rules('quotes_to_delete', 'A selected quote to delete', 'required');            

        if ($this->form_validation->run() == true)
        {   
            $quotes_to_delete = $this->input->post('quotes_to_delete');
            if ($this->company_model->delete_quotes($quotes_to_delete,$id))
            {
                //update the message
                $message =  "Quotes successfully deleted.";
                $this->session->set_flashdata('message', $message);

                //load the view                
                redirect('admin/company/quotes_view/'.$id, 'refresh');
            }
            else
            {
                 //update the message
                $message =  "There was an error with your request";
                $this->session->set_flashdata('message', $message);

                //load the view                
                redirect('admin/company/quotes_view/'.$id, 'refresh');
            }
        }   
        else
        {
            $company_info = $this->company_model->get_company_info($id);
            $data['quotes'] = $this->company_model->view_quotes($id);
            $data['company_logo'] =  $company_info['company_logo'];
            $data['company_id'] = $id;
            $data['company_info'] = $company_info;

            $this->load->view("admin/company/quotes_view",$data);             
        }
    }       
    
    function enter_quotes($id)
    {
        $this->form_validation->set_rules('quote', 'Quote', 'required|max_length[200]');            

        if ($this->form_validation->run() == true)
        {   
            //validation is good.  setup the data to pass to the model

            $quote = $this->input->post('quote');
            $quote_length = strlen($quote);
            $tile_shape = NULL;

            $small = 50;
            $medium = 100;
            $large = 150;
            $xlarge = 200;

            if (($quote_length > 0) && ($quote_length <= $small))
            {
                $tile_shape = 1; 
            }
            elseif (($quote_length > $small) && ($quote_length <= $medium))
            {
                $tile_shape = 2;
            }
            elseif (($quote_length > $medium) && ($quote_length <= $large))
            {
                $tile_shape = 3;
            }                
            elseif (($quote_length > $large) && ($quote_length <= $xlarge))
            {
                $tile_shape = 4;
            }
            else
            {
                $tile_shape = 4;
            }

            if ($this->company_model->insert_quote($id,$quote,$tile_shape))
            {
                //update the message
                $message =  "Quote successfully inserted.";
                $this->session->set_flashdata('message', $message);

                //load the view                
                redirect('admin/company/enter_quotes/'.$id, 'refresh');        
            }

        }
        else
        {
            $company_info = $this->company_model->get_company_info($id);
            $data['company_id'] = $id;
            $data['company_info'] = $company_info;

            $this->load->view("admin/company/enter_quotes",$data); 
        }

    }

    

}//end of class
