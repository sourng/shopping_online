<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model
{
	
    function __construct(){
        // Call the Model constructor
        parent::__construct();        
    }   

    public function get_setting(){
		$query = $this->db->get('settings');
		return $query->result();
	}

	public function get_langs($field_lable,$lang){
		
		$result = $this->db->query("SELECT ".$lang." FROM langs where lang_name_lable='".$field_lable."'")->row_array();
    	return $result[$lang];
	}

	function get_by_sql($sql, $option=false){
		$query	= $this->db->query($sql);
		
		if($option == 'trace')
			print_r($this->db->queries);		
			
		if(!empty($query))
		{
			$results = array();
			if ( $query->num_rows() > 0 )
				$results = $query->result_array();
			return $results;	
		}
	}

	public function create_category_query($data){
		$this->db->insert('categories',$data);
		return $insert_id = $this->db->insert_id();
	}

	public function get_category_query(){
		$query = $this->db->get('hotels');
		return $query->result();
	}

	public function search($search){
		$limit = 10; $offset = 0;
		$search = str_replace(' ', '%20', trim($search));
		$query = $this->db->like('h_name', trim($search), 'both')->get('hotels');
		return $query->result();
	}

	public function delete_category_query($id){
		$this->db->where('cate_id',$id);
		return  $this->db->delete('categories');
	}

	public function get_category_by_query($id){
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('cate_id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_category_query($id,$data){
		$this->db->where('cate_id',$id);
		return  $this->db->update('categories',$data);
	}

	function getAllOrigin(){
        $query=$this->db->query("SELECT * FROM tbl_contacts");
        return $query->result_array();
        //returns from this string in the db, converts it into an array
    }

  	function getOrigin(){ 
	  $this->db->select("id,origin,photo,country");
	  $this->db->from('tbl_origin');    
	  $query = $this->db->get();  
	  return $query->result();   
	 }


}