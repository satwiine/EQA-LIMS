<?php
class Model_site extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getsite($id=null){
		if($id){
			$sql="SELECT * FROM site WHERE sitecode=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

			$sql="SELECT * FROM site";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function addNewSiteTester($data){
		if($data){
			$insert = $this->db->insert('sitetester',$data);
			return ($insert==true) ? true : false;
		}
	}


	public function getOpensitecode(){
		$sql="SELECT * FROM `_opensitecodes` LIMIT 0,1";
		$query =$this->db->query($sql);
		return $query->row_array();
	}
}