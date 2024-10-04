<?php
class Model_district extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getDistrict($id=null){
		if($id){
			$sql="SELECT * FROM district d, region r WHERE d.Regionid=r.regionid and d.id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT * FROM district d, region r WHERE d.Regionid=r.regionid";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getDistrictByRegion($id)
	{
		$sql="SELECT * FROM district where Regionid=? order by districtname asc";
		$query =$this->db->query($sql,array($id));
			return $query->result_array();
	}
}