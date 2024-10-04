<?php
/**
 * 
 */
class Model_category extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function fetchCategory($id=null){
		if($id){
			$sql="SELECT ic.itemCatId, ic.ItemCatDescription,s.status_description,s.status_id FROM itemcategory ic, `status` s where s.status_id=ic.status and ic.itemCatId=?";
			$query=$this->db->query($sql,array($id));
			return $query->row_array();
		}

			$sql="SELECT ic.itemCatId,ic.ItemCatDescription,s.status_description,s.status_id FROM itemcategory ic, `status` s where s.status_id=ic.status";
			$query=$this->db->query($sql);
			return $query->result_array();
	}

	public function getActiveCategroy()
	{
		$sql = "SELECT ic.itemCatId, ic.ItemCatDescription,s.status_description,s.status_id FROM itemcategory ic, `status` s where s.status_id=ic.status and ic.status= ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function createItemCategory($data){
		if($data){
			$insert = $this->db->insert('itemcategory',$data);
			return($insert ==true )? true : false;
		}
	}


	public function updateCategory($data, $id)
	{
		if($data && $id) {
			$this->db->where('itemCatId', $id);
			$update = $this->db->update('itemcategory', $data);
			return ($update == true) ? true : false;
		}
	}

	public function removeCategory($id){
		if($id) {
			$this->db->where('itemCatId', $id);
			$delete = $this->db->delete('itemcategory');
			return ($delete == true) ? true : false;
		}
	}
}