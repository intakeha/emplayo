<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preview extends CI_Controller {
	
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
                $this->load->model('survey_model');                

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}
	/*
	public function index(){
		$data['title']="Preview Results";
		$data['content']="pages/_preview";
		$this->load->view('canvas', $data);
	}*/

    public function index(){
        
        $this->load->library("form_validation");
        $this->form_validation->set_rules('company_type[]', 'Company Type', 'required');
        $this->form_validation->set_rules('users_benefits[][]', 'Benefits', 'required');
        
        if ($this->form_validation->run() == FALSE){
            //reload the form
            $data['message'] = '';
            $data['title']="Preview Results";
            $data['content']="pages/_preview";
            $this->load->view('canvas', $data);
            
        } else {//data is good...process it.
            
            if($this->input->post('mysubmit')){
                //let's save all the submitted data to the session so we can get it later if the user decides to sign up
                $categories = $this->input->post('category');
                $company_pace = $this->input->post('company_pace');
                $corp_citizenship = $this->input->post('corp_citizenship');
                $history = $this->input->post('history');
                $lifecycle = $this->input->post('lifecycle');
                $users_benefits = $this->input->post('users_benefits');

                $this->session->set_userdata('category',$categories);
                $this->session->set_userdata('company_pace',$company_pace);
                $this->session->set_userdata('corp_citizenship',$corp_citizenship);
                $this->session->set_userdata('history',$history);
                $this->session->set_userdata('lifecycle',$lifecycle);
                $this->session->set_userdata('users_benefits',$users_benefits);

                $this->load->model('preview_model');

                //get initial list of companies that match basic criteria
                $data['company_list'] = $this->preview_model->survey_filter2($categories);
                if (!empty($data['company_list']))
                {
                    //send this list of companies to the next filter to reduce based on type
                    $data['company_list'] = $this->preview_model->toggle_filters($data['company_list']);
                    
                    //TODO: Need to put a conditional statement on each of these steps....
                    
                    //using initial list of companies, rank them based on their benefits
                    $benefit_scoring = $this->preview_model->benefits_scoring($data['company_list']);
                    $history_scoring = $this->preview_model->history_scoring($data['company_list']);
                    
                    //based on these benefits scores, go grab the citizenship scores, and find
                    //nearest neighbor, in ranked order

                    //$data['ranked_results'] = $this->preview_model->get_distance_matrix3($benefit_scoring,$history_scoring);
                    $data = $this->preview_model->get_distance_matrix3($benefit_scoring,$history_scoring);

                    //translate the distance info into 'fit' scores, based on 100% being perfect
                    $data['company_fit'] = $this->preview_model->fit_score($data['ranked_results']);
                    $company_fit = $data['company_fit'];
                    $data['company_count'] = count($data['ranked_results']);
                    $data['image_path'] = "assets/images/company_logos/";
                    
                    //write the fit data to the session in case the user decides to sign up, so we can save it
                    $this->session->set_userdata('company_fit',$company_fit);
                    
                    //set a flag so we know to save this user's data if they sign up
                    $this->session->set_userdata('save_data',TRUE);       
                    
                    //now that we have the ranked companies, let's go get their info, so we can display it 
                    //to the user
                    //$data['company_info'] = $this->preview_model->get_company2($data['ranked_results']);
                    
                    //using get_company3 to only return 5 compamies.  get_company2 returns the full list...
                    $data['company_info'] = $this->preview_model->get_company3($data['ranked_results']);
                    $data['full_company_info'] = $this->preview_model->merge_company_info($data['company_info'],$data['company_fit']);
                    
                    //$data['result_msg'] = 'Success!';
                    //$this->load->view("survey/results",$data); 
                    $data['title']="Preview Results";
                    $data['content']="pages/_preview";
                    $this->load->view('canvas', $data);                    
                    
                } 
                 else {
                    //result set is empty
                    //$data['result_msg'] = 'there were no results!';
                    //$this->load->view("survey/results",$data);
                     echo "there were no results!";
                 }
                
            }
        }
    } //end of submit()
    
    public function insert_matches(){
        //echo "i'm saving you data!";
        //$result = $this->preview_model->save_user_inquiry();
        
        $company_fit = $this->session->userdata('company_fit');

        if (!empty($company_fit)){
            $result = $this->preview_model->insert_matches($company_fit);
            if ($result){
                echo "success!";
            }
            else {
                echo "failure :-(";
            }
        }
        else {
            //return error
       
        }
        
    }        
    
        
}
