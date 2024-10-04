<?php
class Model_syphresult extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getSyphResult($id=null){
		if($id){
			$sql="SELECT * FROM syphresults WHERE sampleid=?";
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}

			$sql="SELECT * FROM syphresults";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function saveResult($data){
		if($data){
			$insert = $this->db->insert_batch('syphresults',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function getComparedSyphResult($sampleid){
		$sql="select v.sampleid,v.rpanel,v.resdesc,
				max(if(testcatid=4,v.result,'')) as 'finalResult',
				max(if(testcatid=4,v.pres,'')) as 'panfr',
				max(if(testcatid=4,v.expres,'')) as 'yrfr'
				from 
				(
					SELECT hr.sampleid, hr.panelid as rpanel, hr.testcatid, hr.result, tr.Name as resdesc, pr.panelid as prpanel, pr.categoryid, pr.result as pres,tr.name as expres FROM panelresults pr, syphsamples hs, syphresults hr, testresult tr where hr.sampleid=hs.sampleid and pr.panelid=hr.panelid and pr.cycleid=hs.cycleid and hs.sampleid=hr.sampleid and pr.schemeid=2 and pr.categoryid=hr.testcatid and tr.id=hr.result and hs.sampleid=?
				) 	as v group by v.sampleid,v.rpanel";
			$query =$this->db->query($sql,array($sampleid));
			return $query->result_array();
	}
	public function getsypResultsWithComments(){
		$sql='SELECT * FROM v_syph_sample_detail_with_comments';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
}