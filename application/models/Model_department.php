<?php
class Model_department extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get tester data
	public function getDepartment($id=null){
		if($id){
			$sql="SELECT * FROM department WHERE id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT id,departmentname FROM department";
			$query =$this->db->query($sql);
			return $query->result_array();
	}
}