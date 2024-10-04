<?php
class Model_title extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getTitleCategory($id=null){
		if($id){
			$sql="SELECT * FROM titlecategory WHERE categoryId=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

			$sql="SELECT * FROM titlecategory";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getTitle($id = null){
		if($id){
			$sql='SELECT t.id,t.name,tc.CategoryName FROM title t, titlecategory tc WHERE tc.categoryId=t.titleCategory and t.id=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

			$sql="SELECT t.id,t.name,tc.CategoryName FROM title t, titlecategory tc WHERE tc.categoryId=t.titleCategory order by t.name asc";
			$query =$this->db->query($sql);
			return $query->result_array();

	}

	public function saveTitle($data){
		if($data){
			$insert = $this->db->insert('title',$data);
			return($insert ==true )? true : false;
		}
	}
}