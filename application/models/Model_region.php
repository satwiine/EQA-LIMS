<?php
class Model_region extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getRegion($id=null){
		if($id){
			$sql="SELECT * FROM   region r where r.regionid=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT * FROM   region r";
			$query =$this->db->query($sql);
			return $query->result_array();
	}
}