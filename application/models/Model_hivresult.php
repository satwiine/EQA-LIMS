<?php
class Model_hivresult extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getHivResult($id=null){
		if($id){
			$sql="SELECT * FROM hivdtsresults WHERE sampleid=?";
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}

			$sql="SELECT * FROM hivdtsresults";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function saveResult($data){
		if($data){
			$insert = $this->db->insert_batch('hivdtsresults',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function getResultComment($id){
		if($id){
			$sql='SELECT panelid,comment FROM sample_comment WHERE sampleid=?';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}
	}

	public function getDtsResultBySample($sampleid){
		if($sampleid){
			$sql='SELECT sr.panelid,sr.testcatid, sr.result, tr.Name FROM hivdtsresults sr, testresult tr where tr.id=sr.result and sr.sampleid=? ORDER BY sr.panelid ASC';
			$query =$this->db->query($sql,array($sampleid));
			return $query->result_array();
		}
	}
	public function getCompareResultBySampleId($sampleid){
		$sql="select v.sampleid,v.rpanel,
				max(if(testcatid=1,v.result,'')) as 'screening',
				max(if(testcatid=1,v.pres,'')) as 'panscreening',
				max(if(testcatid=1,v.resdesc,'')) as 'yr_screening_desc',
				max(if(testcatid=2,v.result,'')) as 'confirmatory',
				max(if(testcatid=2,v.pres,'')) as 'panconf',
				max(if(testcatid=2,v.resdesc,'')) as 'yr_conf_desc',
				max(if(testcatid=3,v.result,'')) as 'Tiebreaker',
				max(if(testcatid=3,v.pres,'')) as 'pantb',
				max(if(testcatid=3,v.resdesc,'')) as 'yr_tb_desc',
				max(if(testcatid=4,v.result,'')) as 'finalResult',
				max(if(testcatid=4,v.pres,'')) as 'panfr',
				max(if(testcatid=4,v.expres,'')) as 'yrfr'
				from 
				(	
					SELECT hr.sampleid, hr.panelid as rpanel, hr.testcatid, hr.result, tr.Name as resdesc, pr.panelid as prpanel, pr.categoryid, pr.result as pres,tr.name as expres FROM panelresults pr, hivdtssamples hs, hivdtsresults hr, testresult tr where hr.sampleid=hs.sampleid and pr.panelid=hr.panelid and pr.cycleid=hs.cycleid and hs.sampleid=hr.sampleid and pr.schemeid=1  and pr.categoryid=hr.testcatid and tr.id=hr.result and hs.sampleid in('".$sampleid."')
					union 
					select hr.sampleid,hr.panelid as rpanel, hr.testcatid, hr.result, tr.name as resdesc,'' as prpanel, '' as categoryid,'' as pres, '' as expres from 
					hivdtssamples hs, hivdtsresults hr, testresult tr 
					where hr.sampleid=hs.sampleid and hr.testcatid=3  and hs.sampleid=hr.sampleid  and tr.id=hr.result and hs.sampleid in('".$sampleid."')
				
				) 	as v group by v.sampleid,v.rpanel";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function updateActedOnBy($sampleid){
		if($sampleid){
			$sql="UPDATE `hivdtsresults` SET `acted_on_by`='".$_SESSION['id']."' WHERE sampleid=?";
			$query =$this->db->query($sql,array($sampleid));
			return ($query==true) ? true : false;
		}
	}

	public function RemoveresultBySample($sampleid){
		if($sampleid){
			$sql="delete from hivdtsresults WHERE sampleid=?";
			$query =$this->db->query($sql,array($sampleid));
			return ($query==true) ? true : false;
		}
	}

	public function cleanupDeletedResults(){
		$sql='delete from _dropped_hivdts_results where arch_id in(SELECT arch_id FROM _dropped_hivdts_results dhr, hivdtsresults hr where hr.sampleid=dhr.sampleid and hr.panelid=dhr.panelid and hr.testcatid=dhr.testcatid and hr.result=dhr.result)';
		$query =$this->db->query($sql);
		return ($query==true) ? true : false;
	}

	public function getApprovedResults(){ // note all recieved data is required in this output - whether approved or not
		$sql='SELECT hs.sampleid, te.TesterName,hs.testercode,dc.Name as quarter,h.name as hub,s.Sitename,d.DistrictName,s.division,s.location,hs.dod,hs.dtst,hs.DateRxAtUVRI,hs.status as outcome,hs.Printed, de.departmentname,h.Name as hub FROM hivdtssamples hs, dtscycles dc, site s, hubs h, district d, tester te, department de where hs.cycleid=dc.id and hs.site=s.sitecode and s.hubcode=h.id and s.Districtid=d.id and hs.testercode=te.tcode and hs.dept=de.id and hs.cycleid in(select dtscycles.id from dtscycles where dtscycles.isActive=1)';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function getResultsWithComments(){
		$sql='SELECT * FROM v_approved_samples_with_comments';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	///updating results

	public function UpdateHIVResult($data){
		if($data){
			//check whether the line result is in
			$line_in=$this->checkresultLine($data['sampleid'],$data['panelid'],$data['testcatid']);

			if($line_in==1){
				//record in update or delete
				if($data['result']!=''){ //update
					$dat = array(
					        'panelid' 		=> 	$data['panelid'],
					        'testcatid'		=>	$data['testcatid'],
					        'result'		=>	$data['result'],
					        'acted_on_by' 	=> 	$_SESSION['id']
					);

					$this->db->where('sampleid', $data['sampleid']);
					$this->db->where('testcatid', $data['testcatid']);
					$this->db->where('panelid', $data['panelid']);
					$this->db->update('hivdtsresults', $dat);
				}
				else{	//delete
					if($data['result']==''){
						$this->db->where('sampleid', $data['sampleid']);
						$this->db->where('testcatid', $data['testcatid']);
						$this->db->where('panelid', $data['panelid']);
						$this->db->delete('hivdtsresults');
					}
				}
			}
			else {
				if($data['result']!='' and $data['testcatid']!=''){ //insert new record
					$dat = array(
							'sampleid'		=>	$data['sampleid'],
					        'panelid' 		=> 	$data['panelid'],
					        'testcatid'		=>	$data['testcatid'],
					        'result'		=>	$data['result'],
					        'acted_on_by' 	=> 	$_SESSION['id']
					);

						$this->db->set($dat);
						$this->db->insert('hivdtsresults');
				}
			}
		}
	}

	public function checkresultLine($sampleid,$panelid,$testcatid){
		if($sampleid && $testcatid && $panelid){
		
		$this->db->select('*');
		$this->db->from('hivdtsresults');
		$this->db->where('sampleid',$sampleid);
		$this->db->where('testcatid',$testcatid);
		$this->db->where('panelid',$panelid);

		return $this->db->count_all_results();

		}
	}
}