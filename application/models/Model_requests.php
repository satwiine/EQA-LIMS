<?php
/**
 * 
 */
class Model_requests extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}


	public function getRequestData($id=null){
		if($id) {
			$sql = "SELECT vr.requestid,DATE_FORMAT(vr.requestdate,'%e %M %Y') as requestdate ,vr.requester,concat(u.fname,' ',u.lname) as approver,rs.description as requestStatus,vr.comment,r.requestedby,r.approver as toapprove,r.requestStatus as status FROM requests r, v_requesters vr, user u, ref_status rs WHERE vr.requestid=r.requestid and r.approver =u.userid and rs.id=vr.requestStatus and vr.requestid = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT vr.requestid,DATE_FORMAT(vr.requestdate,'%e %M %Y') as requestdate,vr.requester,concat(u.fname,' ',u.lname) as approver,rs.description as requestStatus,vr.comment,r.requestedby,r.approver as toapprove,r.requestStatus as status FROM requests r, v_requesters vr, user u, ref_status rs WHERE vr.requestid=r.requestid and r.approver =u.userid and rs.id=vr.requestStatus";
		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
	
	public function getRequestDetail($requestid){
		if($requestid){
			$sql='SELECT rd.requestid,i.itemDescription,rd.requestedquantity FROM requestdetail rd, item i WHERE rd.itemid=i.itemid and rd.requestid=?';
			$query = $this->db->query($sql, array($requestid));
			return $query->result_array();
		}
	}

	public function create($data){

		$insert = $this->db->insert('requests',$data);
		$request_id =$this->db->insert_id();

		
		return $request_id;
	}

	public function addLineRequest($data){
		$insert = $this->db->insert('requestdetail',$data);
	}

	public function addExpiringData($data){
		$insert_query=$this->db->insert_string('recieptexpirytracker',$data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$this->db->query($insert_query);

		//cleanup the items without expiry dates
		$sql="delete from recieptexpirytracker where expirydate='0000-00-00'";
		$this->db->query($sql);
	}


	public function getApprovers(){
		$sql ="SELECT * FROM `v_approver` where userid<>".$_SESSION['id'];
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getRequester(){
		$sql ="SELECT * FROM `v_approver` where userid=".$_SESSION['id'];
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getRequests(){
		$sql="SELECT vr.requestid,vr.requestdate,vr.requester,concat(u.fname,' ',u.lname) as approver,vr.requestStatus,vr.comment FROM requests r, v_requesters vr, user u WHERE vr.requestid=r.requestid and r.approver =u.userid";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function countRequestLines($id){
		if($id){
			$sql="SELECT * FROM `requestdetail` WHERE requestid=?";
			$query =$this->db->query($sql,array($id));
			return $query->num_rows();
		}
	}
}