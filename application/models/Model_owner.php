<?php
/**
 * 
 */
class Model_owner extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function getOwner($id =null){
		if($id){
			$sql="SELECT id, name FROM ownership where id=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		else{
			$sql = "SELECT id, name FROM ownership order by name ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
			}
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('ownership', $data);
			return ($insert == true) ? true : false;
		}
	}
	

	public function fetchOwner(){
		
			$sql ="id,name from ownership";
			$query=$this->db->query($sql);
			return $query->result_array();
		
	}


	
}