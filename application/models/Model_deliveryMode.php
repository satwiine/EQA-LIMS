<?php
class Model_deliveryMode extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get tester data
	public function getDeliverymode($id=null){
		if($id){
			$sql="SELECT * FROM deliverymode WHERE id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT id,deliverymode FROM deliverymode";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('deliverymode', $data);
			return ($insert == true) ? true : false;
		}
	}
	

	public function fetchdeliverymode(){
		
			$sql ="id,deliverymode from deliverymode order by deliverymode asc";
			$query=$this->db->query($sql);
			return $query->result_array();
		
	}
}