<?php
class Model_hivdtssamples extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	
	public function listSecondEntrySamples(){
		$sql='select * from v_second_entry_records';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function listHivDtsSamples($id=null){
		if($id){
			$sql='select * from v_list_hivdtssamples where sampleid=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql='select * from v_list_hivdtssamples';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function showEntries(){
		$sql='SELECT u.userid,u.fname,u.lname, count(*) as entered FROM hivdtssamples h, user u where u.userid = h.enteredby and date(h.date_entered)=CURRENT_DATE() group by u.userid order by u.username asc';
		$query =$this->db->query($sql);
		return $query->result_array();

	}

	public function getSampleDetail($id){
		$sql= 'SELECT sa.sampleid,sa.testercode,te.TesterName,si.Sitename,dc.Name as cycle,dc.quater as qtr,de.departmentname,date_format(sa.dod,"%d-%m-%Y") as dod, date_format(sa.dsr,"%d-%m-%Y") as dsr,sa.rxBy,date_format(sa.dtsr,"%d-%m-%Y") as dtsr,date_format(sa.dtst,"%d-%m-%Y") as dtst,sa.sqty,date_format(sa.DateRxAtUVRI,"%d-%m-%Y") as DateRxAtUVRI, sa.testerdate,sa.tel,sa.supervdate,sa.supervisorname,sa.title,tit.name as titledescription,sa.formserial,o.name as owner, si.location,si.division,di.DistrictName,r.RegionName as region, si.sitecode,de.id as dept,dc.id as cycleid,sa.dod as dodi,fl.levelname,te.contacts,dc.description,sa.score,sa.status,sa.dept,sa.dsr as dsri,sa.dtsr as dtsri,sa.dtst as dtsti, dm.DeliveryMode,sa.DateRxAtUVRI as uvridate,dc.panel_label,sa.approvaldate,sa.approvedby, hu.name as hub FROM hivdtssamples sa, tester te, site si, dtscycles dc, department de, ownership o, district di, region r, facilitylevel fl, deliverymode dm, title tit, hubs hu WHERE sa.testercode=te.tcode and sa.site=si.sitecode and sa.cycleid=dc.id and sa.dept=de.id and o.id=si.ownershipid and di.id=si.Districtid and r.regionid=di.regionid and fl.id=si.levelid and dm.id=si.delimode and tit.id=sa.title and hu.id=si.hubcode and sa.sampleid=?';
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function getReasonForNotTesting($id){
		$sql='SELECT sampleid,schemeid,notestingreasonid FROM `panelnottestedreason` where sampleid=?';
		$query =$this->db->query($sql,array($id));
		return $query->result_array();
	}
	public function getHivSampleTestkit($id){
		$sql='SELECT sk.testcatid,te.name as testname,sk.lotno,date_format(sk.expdt,"%d-%m-%Y") as expdt,sk.expdt as expirydate,sk.testname as testid FROM hivdtssampletestkit sk, testname te where sk.testname=te.id and sk.sampleid=?';
		$query =$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function saveDtsNoTesting($data){
		if($data){
			$insert = $this->db->insert_batch('hivdtsnotestingreason',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function getHivExpectedResult($sampleid){
		if($sampleid){
			$sql='SELECT pr.panelid,pr.categoryid,pr.result,tr.Name as displayresult FROM panelresults pr, testresult tr WHERE pr.schemeid=1 and pr.result=tr.id and pr.cycleid in(select cycleid from hivdtssamples where sampleid=?)';
			$query =$this->db->query($sql,array($sampleid));
			return $query->result_array();
		}
	}

	public function approveHivDtsRecord($sampleid,$by,$score,$status){
		//$mydate=
		$sql='update hivdtssamples set qc=1,approved=1, approvedby='.$by.', approvaldate=CURRENT_DATE(),score="'.$score.'", status="'.$status.'" where sampleid="'.$sampleid.'"';
		return $this->db->query($sql);
	}

	
	public function getSampleToDispatch(){
		$sql='SELECT * FROM v_dispatch order by hub,districtname,sitename ASC';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function getSampleToReDispatch(){
		$sql='SELECT * FROM v_re_dispatch order by hub,districtname,sitename ASC';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function getRecSampleToDispatch(){
		$sql='SELECT * FROM v_rec_dispatch order by hub,districtname,sitename ASC';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	public function getHivOtherComments($id){
		$sql='SELECT c.description,oc.commentid FROM  commentcategory c, othercomments oc WHERE oc.commentid=c.cid and oc.schemeid=1 and oc.sampleid=?';
		$query =$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function getReturnsByCycle($id =null){
		if(!$id){
			$id= $this->getActiveCycle();
		}
			$sql='SELECT * FROM v_hivdtssample_details where cycleid=?';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		
	}

	public function getPassedReturnsByCycle($id =null){
		if(!$id){
			$id= $this->getActiveCycle();
		}
			$sql='SELECT * FROM v_hivdtssample_details where cycleid=? and status="PASS"';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();	
	}

	public function getFailedReturnsByCycle($id =null){
		if(!$id){
			$id= $this->getActiveCycle();
		}
			$sql='SELECT * FROM v_hivdtssample_details where cycleid=? and status="FAIL"';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();	
	}

	public function getUngradedReturnsByCycle($id =null){
		if(!$id){
			$id= $this->getActiveCycle();
		}
			$sql='SELECT * FROM v_hivdtssample_details where cycleid=? and status="Un-Graded"';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();	
	}

	public function getGoodTATReturnsByCycle($id =null){
		if(!$id){
			$id= $this->getActiveCycle();
		}
			$sql='SELECT * FROM v_hivdtssample_details where cycleid=? and status="Un-Graded"';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();	
	}


	private function getActiveCycle(){
		$sql='SELECT * FROM dtscycles WHERE isactive=1';
		$query =$this->db->query($sql);
		$result=$query->row_array();
		return $result['id'];
	}

	public function recallApproval($id){
		$sql='UPDATE hivdtssamples SET qc=0,approved=0,approvaldate=NULL,score=NULL,status=NULL,PrintDate = NULL, approvedby=NULL WHERE sampleid = ?';
		$query=$this->db->query($sql,array($id));
		return ($query ==true) ? true : false;
	}

	public function removeHIVCommentBySampleid($id){
		$sql='DELETE FROM othercomments where schemeid=1 and sampleid=?';
		$query=$this->db->query($sql,array($id));
		return ($query ==true) ? true : false;
	}

	public function getTesterDetailBySampleId($id){
		$sql='SELECT t.tcode,t.TesterName,t.contacts,ti.name as title FROM tester t, title ti WHERE t.tcode in(select testercode from hivdtssamples where sampleid=?) and t.title=ti.id';
		$query=$this->db->query($sql,array($id));
		return $result=$query->row_array();
	}

	public function isFormUnique($tcode,$formserial,$cycle=null){
		if(!$cycle){
			$cycle=$this->getActiveCycle();
		}
		$this->db->select('*');
		$this->db->from('hivdtssamples');
		$this->db->where('testercode',$tcode);
		$this->db->where('formserial',$formserial);
		$this->db->where('cycleid',$cycle);

		return $this->db->count_all_results();
	}

	public function getApproverBySampleId($sampleid){
		$sql='select * from _approver where uid in(SELECT ApprovedBy FROM hivdtssamples WHERE sampleid=?)';
		$query=$this->db->query($sql,array($sampleid));
		return $query->result_array();
	}
	public function release_entry(){
		$sql='Update hivdtssamples set destat=3 where destat=1';
		$query=$this->db->query($sql);
		return ($query ==true) ? true : false;
	}

	public function markSamplePrinted($sampleid){
		$sql='update `hivdtssamples` set Printed=1, PrintDate=CURRENT_DATE() WHERE sampleid=?';
		//update syphilis
		$sqls='update `syphsamples` set Printed=1, PrintDate=CURRENT_DATE() WHERE sampleid=?';
		$query=$this->db->query($sql,array($sampleid));
		$querys=$this->db->query($sqls,array($sampleid));
		return ($query ==true) ? true : false;
	}

}