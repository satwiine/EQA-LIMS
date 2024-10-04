<?php
class Model_testname extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get tester data
	public function getHIVTests($id=null){
		if($id){
			$sql="SELECT * FROM testname WHERE id=? and scheme=1";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT `id`, `name` FROM `testname` WHERE `scheme`=1 or scheme=0";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getRecencyTests($id=null){
		if($id){
			$sql="SELECT * FROM testname WHERE id=? and scheme=5";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT `id`, `name` FROM `testname` WHERE `scheme`=5 or scheme=0";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getSyphilisTests($id=null){
		if($id){
			$sql="SELECT * FROM testname WHERE id=? and scheme=3";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT `id`, `name` FROM `testname` WHERE `scheme`=3 or scheme=0";
			$query =$this->db->query($sql);
			return $query->result_array();
	}
}