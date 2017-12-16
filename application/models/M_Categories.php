<?php 
class M_Categories extends CI_Model{
	
	public function __construct()
	{
		$this->load->database();
	}
	/**
	 * Returns the record by one field
	 *
	 */
	function get_by_sql($sql, $option=false)
	{
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
	
	
}



