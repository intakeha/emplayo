<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
                $this->load->model('survey_model');

	}    
    
    public function load(){
        //get list of categories from database
        $this->load->model('survey_model');
        $data['categories'] = $this->survey_model->get_categories();
        $data['message'] = '';
        $this->load->view("survey/load",$data);
        //$this->load->view("survey/newload",$data);
    }

    public function user_tester(){
        //get list of categories from database
        $this->load->model('survey_model');
        $data['categories'] = $this->survey_model->get_categories();
        $data['message'] = '';
        $this->load->view("survey/user_tester",$data);
        //$this->load->view("survey/newload",$data);
    }   
    
    public function user_tester2(){
        //get list of categories from database
        $this->load->model('survey_model');
        $data['categories'] = $this->survey_model->get_categories();
        $data['message'] = '';
        $this->load->view("survey/user_tester2",$data);
        //$this->load->view("survey/newload",$data);
    }     
    
    public function user_tester3(){
        //get list of categories from database
        $this->load->model('survey_model');
        $data['categories'] = $this->survey_model->get_categories();
        $data['message'] = '';
        $this->load->view("survey/user_tester3",$data);
        //$this->load->view("survey/newload",$data);
    }         
    
        public function submit2(){
            //validation required?
            //find all the companies that match the submitted 'tags'
            $categories = $this->input->post('category');
            $history = $this->input->post('history');
            /*
            echo '<pre>';
            print_r($categories);
            echo '</pre>';
            */
            
            $this->load->model('survey_model');
            $data['category_tags'] = $this->survey_model->match_tags($categories);
            
            $this->load->view("survey/newresults",$data);
        }
    
    public function submit(){
        $this->load->library("form_validation");
        $this->form_validation->set_rules('company_type[]', 'Company Type', 'required');
        $this->form_validation->set_rules('users_benefits[][]', 'Benefits', 'required');
        
        if ($this->form_validation->run() == FALSE){
            //reload the form
            $data['message'] = '';
            $this->load->view("survey/load",$data);
            
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

                $this->load->model('survey_model');

                //get initial list of companies that match basic criteria
                //$data['company_list'] = $this->survey_model->survey_filter();
                //$categories = $this->input->post('category');
                $data['company_list'] = $this->survey_model->survey_filter2($categories);
                if (!empty($data['company_list']))
                {
                    //send this list of companies to the next filter to reduce based on type
                    $data['company_list'] = $this->survey_model->toggle_filters($data['company_list']);
                    
                    //TODO: Need to put a conditional statement on each of these steps....
                    
                    //using initial list of companies, rank them based on their benefits
                    $benefit_scoring = $this->survey_model->benefits_scoring($data['company_list']);
                    $history_scoring = $this->survey_model->history_scoring($data['company_list']);
                    
                    //based on these benefits scores, go grab the citizenship scores, and find
                    //nearest neighbor, in ranked order

                    //$data['ranked_results'] = $this->survey_model->get_distance_matrix3($benefit_scoring,$history_scoring);
                    $data = $this->survey_model->get_distance_matrix3($benefit_scoring,$history_scoring);
                    //echo '<pre>coord in the controller:<br>',print_r($data['coord_data'],1),'</pre>';
                    

                    //translate the distance info into 'fit' scores, based on 100% being perfect
                    $data['company_fit'] = $this->survey_model->fit_score($data['ranked_results']);
                    $company_fit = $data['company_fit'];
                    
                    //write the fit data to the session in case the user decides to sign up, so we can save it
                    $this->session->set_userdata('company_fit',$company_fit);
                    
                    //set a flag so we know to save this user's data if they sign up
                    $this->session->set_userdata('save_data',TRUE);       
                    
                    //now that we have the ranked companies, let's go get their info, so we can display it 
                    //to the user
                    $data['company_info'] = $this->survey_model->get_company2($data['ranked_results']);
                    $data['full_company_info'] = $this->survey_model->merge_company_info($data['company_info'],$data['company_fit']);
                    
                    $data['result_msg'] = 'Success!';
                    $this->load->view("survey/results",$data);    
                } 
                 else {
                    //result set is empty
                    $data['result_msg'] = 'there were no results!';
                    $this->load->view("survey/results",$data);
                 }
                
            }
        }
    } //end of submit()
    
    public function insert_matches(){
        //echo "i'm saving you data!";
        //$result = $this->survey_model->save_user_inquiry();
        
        $company_fit = $this->session->userdata('company_fit');

        if (!empty($company_fit)){
            $result = $this->survey_model->insert_matches($company_fit);
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
    
    public function jsform(){
        $this->load->view("survey/jsform");
    }
    
	public function match(){
            echo "I'm in the match function!";
	}     
    
    public function email(){
        echo "I'm in the email function!<br>";
        
        
        $this->load->config('ion_auth', TRUE);
        $email = 'hipnoddic@mac.com';
        $subject = 'Welcome To Emplayo!';
        $this->load->library('email');
        $this->email->clear();
        
        $message = $this->load->view('emails/welcome.tpl.php', '', true);
        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));

        $this->email->to($email); 

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();

        echo $this->email->print_debugger();        
        
        
    }           
    
//SELECT2 TEST CODE BELOW
           
        
        public function industry_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->survey_model->industry_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;           
        }//end     
   
        public function location_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->survey_model->location_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end         
 
        public function college_name_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->survey_model->college_name_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end           
     
        public function college_degree_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->survey_model->college_degree_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end          
        
        public function college_major_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->survey_model->college_major_search($decoded_search_term);
            header('Content-Type: application/json');  
            echo $result;     
        }//end          
        
         public function company_name_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->survey_model->company_name_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end   
        
         public function job_type_search()
        {
            $decoded_search_term = urldecode($this->input->get('searchterm'));
            $result = $this->survey_model->job_type_search($decoded_search_term);
            header('Content-Type: application/json');
            echo $result;     
        }//end          
        
        
        
	public function select2test(){
            //$data['degree_array'] = $this->inquire_model->get_degree_type();
            $data = null;
            
		$this->load->view('survey/select2_test.php',$data);
	}  
        
        public function select2_post(){
            if($this->input->post('submit')){
                print_r($this->input->post());
            }
        }
            
        
        
}
