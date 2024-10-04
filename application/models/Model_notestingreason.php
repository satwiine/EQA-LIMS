<?php
class Model_notestingreason extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get tester data
	public function getReason($id=null){
		if($id){
			$sql="SELECT id,reason FROM notestingreasons where id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT id,reason FROM notestingreasons ORDER BY reason ASC";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	
}