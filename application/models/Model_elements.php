<?php
class Model_elements extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get Element data
	public function getElementData($id=null){
		if($id){
			$sql="SELECT `id`, `attribute_name`, `isactive` FROM `attributes` WHERE `id`=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT `id`, `attribute_name`, `isactive` FROM `attributes`";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function countElementValue($id){
		if($id){
			$sql="SELECT `id`, `value_name`, `parent_id` FROM `attribute_value` WHERE `parent_id`=?";
			$query =$this->db->query($sql,array($id));
			return $query->num_rows();
		}
	}

	public function getElementValueData($id=null){
		if($id){
			$sql="SELECT `id`, `value_name`, `parent_id` FROM `attribute_value` WHERE `parent_id`=?";
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}
	}

	public function createValue($data){
		if($data){
			$insert = $this->db->insert('attribute_value',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function createElement($data){
		if($data){
			$insert = $this->db->insert('attributes',$data);
			return ($insert==true) ? true : false;
		}
	}

	public function update($data,$id){
		if($data && $id){
			$this->db->where('id',$id);
			$update = $this->db->update('attributes',$data);
			return ($update ==true) ? true : false;
		}
	}

	public function removeElement($id){
		if($id){
			$this->db->where('id',$id);
			$delete =$this->db->delete('attributes');
			return ($delete ==true) ? true : false;
		}
	}
}