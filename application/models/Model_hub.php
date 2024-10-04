<?php
class Model_hub extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get tester data
	public function getHub($id=null){
		if($id){
			$sql="SELECT * FROM hubs WHERE id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT id,name FROM hubs";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('hubs', $data);
			return ($insert == true) ? true : false;
		}
	}
	

	public function fetchHub(){
		
			$sql ="id,name from hubs order by name asc";
			$query=$this->db->query($sql);
			return $query->result_array();
		
	}
}