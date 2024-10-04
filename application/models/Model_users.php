<?php
/**
 * 
 */
class Model_users extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getUserData($id=null){
		if($id){
			$sql="SELECT * FROM getuserdata WHERE userid=?";
			$query = $this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT * FROM getuserdata";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data='',$catid=null){
		if($data && $catid){
			$groupid=2;
			$create = $this->db->insert('user',$data);
			$userid= $this->db->insert_id;

			if($catid <3){
				$group_id=1;
			}

			$group_data = array(
				'user_id' => $userid,
				'group_id' =>$group_id
			);

			$group_data = $this->db->insert('user_groups',$group_data);

			return ($create==true && $group_data) ? true : false;
		}
	}

	public function edit ($data=array(),$id=null){

	}

	public function getUserCategory($id=null){
		if($id){
			$slq='SELECT catid, catDescription FROM usercategory where catid=?';
			$query = $this->db->query($sql,array($id));
			return $query->row_array();
		}
		$sql ="SELECT catid, catDescription FROM usercategory";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}