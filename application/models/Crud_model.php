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

	public function getAllOrigin(){
        $query=$this->db->query("SELECT * FROM tbl_contacts");
        return $query->result_array();
        //returns from this string in the db, converts it into an array
    }

	public function getOrigin(){ 
	  $this->db->select("id,origin,photo,country");
	  $this->db->from('tbl_origin');    
	  $query = $this->db->get();  
	  return $query->result();   
	 }

	 // Count all record of table "contact_info" in database.
	public function record_count($table_name,$cat_id=false) {
		if($cat_id!=false){
			$this->db->where('cat_id',$cat_id);
			// $query = $this->db->get_where('products', array('cat_id' => $cat_id));
		}
		return $this->db->count_all($table_name);
	}

	 // Count all record of table "contact_info" in database.
	 public function get_total($table_name=false,$cat_id=false) {
		if($cat_id!=false){
			return $this->db
				->where('cat_id', $cat_id)
				// ->where('is_enabled', 1)
				->count_all_results($table_name);
		}else{
			return $this->db->count_all($table_name);
		}	
	}

	public function get_current_page_records($limit, $start,$cat_id=false)
{
	// $this->db->limit($limit, $start);	

	if($cat_id!=false){
		// $this->db->where('cat_id',$cat_id);
		$query = $this->db->get_where('products', array('cat_id' => $cat_id), $limit, $start);
	}else{
		$query = $this->db->get('products', $limit, $start);
	}	
    // $query = $this->db->get("products");
  
    if ($query->num_rows() > 0)
    {
        
		return $query->result_array();
    }  
    return false;
}


public function getFieldName($fieldName,$tableName,$fieldCond,$fieldFind){
    // $this->db->select($fieldName);
    // $this->db->from($tableName);
    // $this->db->where($fieldCond,$fieldFind);
	// return $this->db->get($tableName);
	
	$result = $this->db->query("SELECT ".$fieldName." FROM ".$tableName." WHERE $fieldCond='".$fieldFind."'")->row_array();
    	return $result[$fieldName];
}


}