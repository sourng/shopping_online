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

// Manage Vehicle =========================================================
	// To Block Vehicles
	public function get_blocked_vehicle_query($id){
    // $vSQL =    "vhs.id AS id,ori.origin AS origin,
				// dest.origin AS destination,vh.vehicle_name AS vehicle_name,
				// vhs.local_price AS local_price,vhs.foreigner_price AS foreigner_price,
				// dpt.departure_time AS departure_time,vhs.`status` AS `status`
				// FROM
				// tbl_vehicle_schedule AS vhs
				// INNER JOIN tbl_origin AS ori ON (ori.id = vhs.origin)
				// INNER JOIN tbl_origin AS dest ON (dest.id = vhs.destination)
				// INNER JOIN tbl_vehicle AS vh ON (vh.v_id = vhs.v_id)
				// INNER JOIN tbl_departure_time AS dpt ON (dpt.id = vhs.departure_time)
				// WHERE
				// 	vhs.id = $id
				// AND vhs.`status` = 1";
		// $vSQL="SELECT * FROM tbl_vehicle WHERE v_id=$id";
    // $this->db->select("SELECT * FROM tbl_vehicle WHERE v_id=$id");		
	$this->db->select('*');
	$this->db->from('tbl_vehicle');
	$this->db->where('v_id',$id);
	$query = $this->db->get();
	return $query->result();
	}
public function update_blocked_vehicle_query($id,$data){
		$this->db->where('v_id',$id);
		return  $this->db->update('tbl_vehicle',$data);
	}

// Active Vehicle--------------------------
	public function get_active_vehicle_query($id){
		$this->db->select('*');
		$this->db->from('tbl_vehicle');
		$this->db->where('v_id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_active_vehicle_query($id,$data){
		$this->db->where('v_id',$id);
		return  $this->db->update('tbl_vehicle',$data);
	}


	// End Vehicle ==================================================================

//============== Manage Schedules ====================================

//To blocked Schedule
	public function get_blocked_schedule_query($id){
    $vSQL =    "vhs.id AS id,ori.origin AS origin,
				dest.origin AS destination,vh.vehicle_name AS vehicle_name,
				vhs.local_price AS local_price,vhs.foreigner_price AS foreigner_price,
				dpt.departure_time AS departure_time,vhs.`status` AS `status`
				FROM
				tbl_vehicle_schedule AS vhs
				INNER JOIN tbl_origin AS ori ON (ori.id = vhs.origin)
				INNER JOIN tbl_origin AS dest ON (dest.id = vhs.destination)
				INNER JOIN tbl_vehicle AS vh ON (vh.v_id = vhs.v_id)
				INNER JOIN tbl_departure_time AS dpt ON (dpt.id = vhs.departure_time)
				WHERE
					vhs.id = $id
				AND vhs.`status` = 1";
    $this->db->select($vSQL);		
	// $this->db->select('*');
	// $this->db->from('tbl_vehicle_schedule');
	// $this->db->where('id',$id);
	$query = $this->db->get();
	return $query->result();
	}

	public function update_blocked_schedule_query($id,$data){
		$this->db->where('id',$id);
		return  $this->db->update('tbl_vehicle_schedule',$data);
	}




//To Activate Schedule
	public function get_active_schedule_query($id){
		$this->db->select('*');
		$this->db->from('tbl_vehicle_schedule');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_active_schedule_query($id,$data){
		$this->db->where('id',$id);
		return  $this->db->update('tbl_vehicle_schedule',$data);
	}	

	public function getView($id){
    	$vSQL = " vs.id AS id, ori.origin AS origin, ori1.origin AS destination,
              vh.vehicle_name AS vehicle_name,dpt.departure_time AS departure_time,
              vs.travel_duration AS travel_duration, vs.local_price AS local_price,
              vs.foreigner_price AS foreigner_price, vs.`status` AS `status`
              FROM
              tbl_vehicle_schedule AS vs 
              JOIN tbl_origin AS ori ON (ori.id = vs.origin)
              JOIN tbl_origin AS ori1 ON (ori1.id = vs.destination)
              JOIN tbl_vehicle AS vh ON (vh.v_id = vs.v_id)
              JOIN tbl_departure_time AS dpt ON (dpt.id = vs.departure_time)
              WHERE vs.id=$id AND vs.status=1";
	    $this->db->select($vSQL);
	    $query = $this->db->get();
		return $query->result();
	}

	public function getBlock($id){
    $vSQL = " vs.id AS id, ori.origin AS origin, ori1.origin AS destination,
              vh.vehicle_name AS vehicle_name,dpt.departure_time AS departure_time,
              vs.travel_duration AS travel_duration, vs.local_price AS local_price,
              vs.foreigner_price AS foreigner_price, vs.`status` AS `status`
              FROM
              tbl_vehicle_schedule AS vs 
              JOIN tbl_origin AS ori ON (ori.id = vs.origin)
              JOIN tbl_origin AS ori1 ON (ori1.id = vs.destination)
              JOIN tbl_vehicle AS vh ON (vh.v_id = vs.v_id)
              JOIN tbl_departure_time AS dpt ON (dpt.id = vs.departure_time)
              WHERE vs.id=$id AND vs.status=0";
	  $this->db->select($vSQL);
	  $query = $this->db->get();
		return $query->result();
	}

//============== End Manage Schedules ====================================


}