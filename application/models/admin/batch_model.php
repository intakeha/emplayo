<?php
class Batch_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();            
        $this->load->database();
        
        $this->messages = array();
        $this->errors = array();
    }
    
    function update_slugs()
    {
	$this->db->select('id, company_name');
	$query = $this->db->get('company_all');
	foreach ($query->result() as $row)
	{
		$company_slug = url_title(strtolower(convert_accented_characters($row->company_name)));
		$this->db->set('company_slug', $company_slug); 
		$this->db->where('id', $row->id);
		$this->db->update('company_all'); 
		//echo $row->id."|".$row->company_name."|".$company_slug."<br>";
	}
	$this->session->set_flashdata('message', 'Company slugs updated!');
    }
    
}//end of class