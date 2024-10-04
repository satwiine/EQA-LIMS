<?php
class Model_panelcomment extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getPanelComment($id=null){
		if($id){
			$sql="SELECT * FROM sample_comment WHERE sampleid=?";
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}

			$sql="SELECT * FROM sample_comment";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function saveComment($data){
		if($data){
			$insert = $this->db->insert_batch('sample_comment',$data);
			return ($insert ==true) ? true : false;
		}
	}
}