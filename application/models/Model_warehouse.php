<?php
class Model_warehouse extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getWarehouse(){
		$sql="SELECT id,name,status FROM warehouse ORDER by name asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function fetchWarehouse(){
		$sql="SELECT id,name,status FROM warehouse ORDER by name asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function createWarehouse($data){
		if($data){
			$insert = $this->db->insert('warehouse',$data);
			return ($insert==true) ? true : false;
		}
	}

	// get Warehouse data
	public function getWarehouseData($id=null){
		if($id){
			$sql="SELECT `id`, `name`, `status` FROM `warehouse` WHERE `id`=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT `id`, `name`, `status` FROM `warehouse` ORDER by name asc";
			$query =$this->db->query($sql);
			return $query->result_array();
	}


	public function update($data,$id){
		if($data && $id){
			$this->db->where('id',$id);
			$update = $this->db->update('warehouse',$data);
			return ($update ==true) ? true : false;
		}
	}

	public function removeWarehouse($id){
		if($id){
			$this->db->where('id',$id);
			$delete =$this->db->delete('warehouse');
			return ($delete ==true) ? true : false;
		}
	}
}