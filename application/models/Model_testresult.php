<?php
class Model_testresult extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get tester data
	public function testResult($id=null){
		if($id){
			$sql="SELECT * FROM testresult WHERE id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="select id, name, description, section, scheme FROM testresult";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getHivSyphTestResult(){
		$sql="select id, name, description, section, scheme FROM testresult where scheme=1";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getHivSyphTestResult_scr_section(){
		$sql="select id, name, description, section, scheme FROM testresult where scheme=1 and section=1";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getHivSyphTestResult_fr_section(){
		$sql="select id, name, description, section, scheme FROM testresult where scheme=1 and section=2";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getRecencyTestResult(){
		$sql="select id, name, description, section, scheme FROM testresult where scheme=5";
			$query =$this->db->query($sql);
			return $query->result_array();
	}
	
	//get the hiv expected results by cycleid
	public function populateResultsForEntryByCycle($id){
		$sql='SELECT pr.panelid,pr.categoryid, pr.result,tr.Name FROM panelresults pr, testresult tr  where tr.id=pr.result and pr.schemeid=1 and pr.cycleid=?';
		$query =$this->db->query($sql,array($id));
	}
}