<?php
class Model_cycle extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get tester data
	public function getCycle($id=null){
		if($id){
			$sql="SELECT dc.id,dc.name,dc.quater,dc.cycleyear,dc.calendardesc,dc.isActive,c.Description,dc.description as quartername, dc.startdate, dc.enddate FROM dtscycles dc, copyears c WHERE c.id=dc.copid and dc.id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT dc.id,dc.name,dc.quater,dc.cycleyear,dc.calendardesc,dc.isActive,c.Description,dc.description as quartername FROM dtscycles dc, copyears c WHERE c.id=dc.copid";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getActiveCycle(){
			$sql="SELECT dc.id,dc.name,dc.quater,dc.cycleyear,dc.calendardesc,dc.isActive,c.Description,dc.description as quartername FROM dtscycles dc, copyears c WHERE c.id=dc.copid and dc.isActive=1";
			$query =$this->db->query($sql);
			return $query->row_array();
	}

	public function getRecencyActiveCycle(){
		$sql='SELECT `batchnum`, `cycleyear`, `isactive` FROM `recency_cycle` WHERE `isactive`=1';
		$query =$this->db->query($sql);
			return $query->row_array();
	}

	public function getRecencyCycle($id=null){
		if($id){
			$sql='SELECT `batchnum`, `cycleyear`, `isactive` FROM `recency_cycle` WHERE `batchnum`=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
			$sql='SELECT `batchnum`, `cycleyear`, `isactive` FROM `recency_cycle` order by batchnum asc';
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getCopYears($id=null)	{
		if($id){
			$sql="SELECT id,Description FROM `copyears` where id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		else {
			$sql="SELECT id,Description FROM `copyears` where id<>7 order by Description asc";
			$query =$this->db->query($sql);
			return $query->result_array();
		}
	}

	public function addLineResult($data){
		if($data){
			$insert = $this->db->insert('panelresults',$data);
			return ($insert==true) ? true : false;
		}
	}

	public function create($data){
		if($data){
			$insert = $this->db->insert('dtscycles',$data);
			return ($insert==true) ? true : false;
		}
	}

	public function getCycleExpectedResults($id){
		$sql='select * from v_expected_results where cycleid=? order by panelid asc';
		$query =$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function getCycleSummary($id){
		$targeted 		= $this->getTargetedByCycle($id);
		$passed 		= $this->getPassedByCycle($id);
		$failed 		= $this->getFailedByCycle($id);
		$response 		= $this->getResponsiveByCycle($id);
		$ungraded 		= $this->getUngradedByCycle($id);
		$pending 		= $this->getPendingByCycle($id);

		$data['targeted'] 		= number_format($targeted['targets']);
		$data['passed']			= number_format($passed['passed']);
		$data['failed']			= number_format($failed['failed']);
		$data['ungraded']		= number_format($ungraded['ungraded']);
		$data['pending']		= number_format($pending['pending']);
		$data['responded']		= number_format($response['labs']);
		
		return $data;
	}

	private function getTargetedByCycle($id){
		$sql="SELECT count(*) as targets FROM distributions WHERE cycle = ?";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}
	private function getTargetedLabsByCycle($id){
		$sql="SELECT count(*) as labs FROM distributions WHERE cycle = ? and dept in(54,57)";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}

	private function getTargetedNonLabsByCycle($id){
		$sql="SELECT count(*) as nonlabs FROM distributions WHERE cycle = ? and dept not in(54,57)";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}
	
	private function getResponsiveByCycle($id){	
		$sql="SELECT count(*) as labs FROM hivdtssamples WHERE cycleid = ?";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}

	private function getPassedByCycle($id){	
		$sql="SELECT count(*) as passed FROM hivdtssamples WHERE cycleid = ? and status='PASS'";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}
	
	private function getFailedByCycle($id){	
		$sql="SELECT count(*) as failed FROM hivdtssamples WHERE cycleid = ? and status='FAIL'";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}
	private function getUngradedByCycle($id){	
		$sql="SELECT count(*) as ungraded FROM hivdtssamples WHERE cycleid = ? and status='Un-Graded'";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}

	private function getPendingByCycle($id){	
		$sql="SELECT count(*) as pending FROM hivdtssamples WHERE cycleid = ? and status is null";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}



}