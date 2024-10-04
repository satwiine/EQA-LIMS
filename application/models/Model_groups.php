<?php
/**
 * 
 */
class Model_groups extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getGroupData($groupId=null){
		if($groupId){
			$sql="SELECT * FROM groups WHERE id=?";
			$query = $this->db->query($sql,array($groupId));
			return $query->row_array();
		}

		$slq="SELECT * FROM groups WHERE id !=?";
		$query = $this->db->query($sql,array($groupId));
		return $query->result_array();
	}


	public function create($data=''){
		$create = $this->db->insert('groups',$data);
		return ($create ==true) ? true : false;
	}

	public function edit($data,$id){
		$this->db->where('id',$id);
		$update=$this->db->update('groups',$data);
		return ($update==true) ? true : false;
	}


	public function delete($id){
		$this->db->where('id',$id);
		$delete = $this->db->delete('groups');
		return ($delete==true) ? true : false;
	}


	public function existInUserGroup($id){
		$sql = "SELECT * FROM user_groups WHERE group_id=?";
		$query = $this->db->query($sql,array($id));
		return ($query->num_rows()==1)? true : false;
	}

	public function getUserGroupByUserId($user_id){
		$sql = "SELECT * FROM user_groups
		INNER JOIN groups on groups.id= user_groups.group_id
		where user_groups.user_id=?";

		$query= $this->db->query($sql,array($user_id));
		$result =$query->row_array();

		return $result;
	}
}