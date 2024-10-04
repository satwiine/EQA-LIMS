<?php
class Model_commentcategory extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getCommentCategory($id=null){ // all categories for both Recency and DTS
		if($id){
			$sql='SELECT cid,description FROM `commentcategory` WHERE cid=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		else {
			$sql='SELECT cid,description FROM commentcategory';
			$query =$this->db->query($sql);
			return $query->result_array();
		}
	}
 
	public function getHIVDTSCommentCategory(){
		$sql='SELECT cid,description FROM commentcategory where applicableto in(0,1)'; 
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function getHIVRecencyCommentCategory(){
		$sql='SELECT cid,description FROM commentcategory where applicableto in(0,3)';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	public function getCommentsBySchemeSampleid($id){
		//$sql='SELECT oc.sampleid,cc.description FROM othercomments oc, commentcategory cc';

		$this->db->select('*');
		$this->db->from('othercomments');
		$this->db->where('othercomments.sampleid',$id);
		$this->db->join('commentcategory', 'commentcategory.cid = othercomments.commentid');
		$query = $this->db->get();
		return $query->result_array();
	}
}

