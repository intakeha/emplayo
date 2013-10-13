<?php
class Public_company_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
        
        $this->messages = array();
        $this->errors = array();
    }

    public function get_public_company_info($id)
    {
        //using the company_id ($id), need to get and return the following:
        //from COMPANY: company_name, company_url, company_logo, type_id, pace_id, lifecycle_id
        //corp_citizenship_id
        //from BENEFITS: benefits_id[]
        //from CATEGORY: category_id[]

        $query = $this->db->get_where('company', array('id' => $id));
        $company_array = array();
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $company_array['company_name'] = $row->company_name;
              $company_array['company_url'] = $row->company_url;
              $company_array['jobs_url'] = $row->jobs_url;
              $company_array['facebook_url'] = $row->facebook_url;
              $company_array['twitter_url'] = $row->twitter_url;
              $company_array['company_logo'] = $row->company_logo;
              $company_array['creative_logo'] = $row->creative_logo;
              $company_array['type_id'] = $row->type_id;
              $company_array['pace_id'] = $row->pace_id;
              $company_array['lifecycle_id'] = $row->lifecycle_id;
              $company_array['corp_citizenship_id'] = $row->corp_citizenship_id;
              
           }
           return $company_array;
        } else {
            return false;
        }        
    }
    
    function get_quotes($company_id)
    {
        //get the quotes from the database
        $query = $this->db->get_where('company_quotes', array('company_id' => $company_id)); 
        if ($query)
        {
            $quote_array = array();
            //build the array to be sent to the view
            foreach ($query->result_array() as $key=>$value)
            {
               $quote_array[$key]['tile_shape'] = $value['tile_shape'];
               $quote_array[$key]['quote'] = $value['quote'];
            }

            //shuffle the array values to get a random distribution each time
            //this could be removed if we want the same order every time.
            //shuffle($quote_array);
            return $quote_array;
        }
        else
        {
            return FALSE;
        }

    }  //end of get_quotes     
    
    
    function get_profile_pics($company_id)
    {
        //get the profile pics from the database
        $query = $this->db->get_where('company_profile_pics', array('company_id' => $company_id)); 
        if ($query)
        {
            $pic_array = array();
            //build the array to be sent to the view
            foreach ($query->result_array() as $key=>$value)
            {
               $pic_array[$key]['pic_shape'] = $value['pic_shape'];
               $pic_array[$key]['file_name'] = $value['file_name'];
            }

            //shuffle the array values to get a random distribution each time
            //this could be removed if we want the same order every time.
            //shuffle($pic_array);
            
            //randomizing could randomly put all the small pics next to each other...
            //so, distribute the pictures to spread the types/shapes out
            //
            //4/30/13: THERE WAS AN ISSUE WITH THIS FUNCTION SKIPPING IMAGES.  COMMENTING OUT FOR NOW...
            //$distributed_array = $this->distribute_pics($pic_array);
            $distributed_array = NULL;
            
            if (!empty($distributed_array)){       
                return $distributed_array; 
            }
            else
            {
                return $pic_array;
            }
            
        }
        else
        {
            return FALSE;
        }

    }  //end of get_profile_pics        
  
function array_interlace ($a, $b)
{
    $c = array();
    
    $shorty = (count($a) > count($b)) ? $b : $a;
    $biggy = (count($a) > count($b)) ? $a : $b;
    
    $slen = count($shorty);
    $blen = count($biggy);

    for ($i = 0; $i < $slen; ++$i){
        $c[$i * 2] = $a[$i];
        $c[$i * 2 + 1] = $b[$i];
    }
    
    for ($i = $slen; $i < $blen; ++$i)
    {
        $c[] = $biggy[$i];
    }
    
    return $c;
}        
    
    //function for setting errors in the model and returning them to the controller
    public function set_error($error)
    {
        $this->errors[] = $error;

        return $error;
    }    
}

