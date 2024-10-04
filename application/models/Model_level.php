<?php
/**
 * 
 */
class Model_level extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function getLevel($id =null){
		if($id){
			$sql="SELECT id, LevelName FROM facilitylevel where id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		else{
			$sql = "SELECT id, LevelName FROM facilitylevel order by LevelName ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
			}
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('facilitylevel', $data);
			return ($insert == true) ? true : false;
		}
	}
	

	public function fetchFacilityLevel(){
		
			$sql ="id,levelname from facilitylevel";
			$query=$this->db->query($sql);
			return $query->result_array();
		
	}


	
}