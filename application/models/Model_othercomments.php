<?php
class Model_othercomments extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function insertComment($data){
		if($data){
			$insert = $this->db->insert_batch('othercomments',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function insertRecencyComment($data){
		if($data){
			$insert = $this->db->insert_batch('recencycomments',$data);
			return ($insert ==true) ? true : false;
		}
	}
	public function readOtherCommentsBySampleid($sampleid){
		if($sampleid){
			$sql='SELECT oc.sampleid,oc.schemeid,c.description,oc.commentid FROM  othercomments oc, commentcategory c where c.cid=oc.commentid and oc.sampleid=?';
			$query =$this->db->query($sql,array($sampleid));
			return $query->result_array();
		}
	}
}