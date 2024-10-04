<?php
class Model_syphsample extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getsyphSample($id=null){
		if($id){
			$sql="SELECT * FROM syphsamples WHERE sampleid=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

			$sql="SELECT * FROM syphsamples";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function saveSample($data){
		if($data){
			$insert = $this->db->insert('syphsamples',$data);
			return ($insert ==true) ? true : false;
		}
	}


	public function listSyphilisSamples($id=null){
		if($id){
			$sql='select * from v_syph_sample_detail where sampleid=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql='select * from v_syph_sample_detail';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	public function getSyphilisTestkit($id){
		if($id){
			$sql='SELECT kitName, LotNo, expiryDate,score,Result FROM syphsamples WHERE `sampleid`=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
	}

	public function getSyphilisResult($id){
		if($id){
			$sql='SELECT sr.panelid,sr.testcatid,sr.result,tr.Name FROM syphresults sr, testresult tr where tr.id=sr.result and sr.sampleid=? ORDER BY `panelid` ASC';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}
	}

	public function saveSyphNoTesting($data){
		if($data){
			$insert = $this->db->insert_batch('syphilisnotestingreason',$data);
			return ($insert ==true) ? true : false;
		}
	}
	
	public function savePanelNotTested($data){
		if($data){
			$insert = $this->db->insert_batch('panelnottestedreason',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function getSyphExpectedResult($sampleid){
		if($sampleid){
			$sql='SELECT pr.panelid,pr.categoryid,pr.result,tr.Name as displayresult FROM panelresults pr, testresult tr WHERE pr.schemeid=2 and pr.result=tr.id and pr.cycleid in(select cycleid from syphsamples where sampleid=?)';
			$query =$this->db->query($sql,array($sampleid));
			return $query->result_array();
		}
	}

	public function approveSyphilisRecord($sampleid,$by,$score,$status){
		$sql='update syphsamples set qc=1, qcstaff='.$by.', qcdate=CURRENT_DATE(),score="'.$score.'", result="'.$status.'" where sampleid="'.$sampleid.'"';
		return $this->db->query($sql);
	}

	public function recallApproval($id){
		$sql='UPDATE syphsamples SET qc=0,qcdate=NULL,score=NULL,result=NULL,PrintDate = NULL, qcstaff=NULL WHERE sampleid = ?';
		$query=$this->db->query($sql,array($id));
		return ($query ==true) ? true : false;
	}

	public function removeSYPHCommentBySampleid($id){
		$sql='DELETE FROM othercomments where schemeid=2 and sampleid=?';
		$query=$this->db->query($sql,array($id));
		return ($query ==true) ? true : false;
	}

	public function updateSyphSampleWithKitInfo($sampleid,$kitname,$lot=null,$expirydate=null){
		$sql='update syphsamples set kitName="'.$kitname.'", LotNo="'.$lot.'", expiryDate="'.$expirydate.'", kitinfoappended=1 where sampleid="'.$sampleid.'"';
		$query=$this->db->query($sql);
		//return $sql;
		return ($query ==true) ? true : false;
	}


	public function updateSamples($data){
		if($data){
			//check if record exists
			$record=$this->checkSampleExists($data['sampleid']);

			if($record==1){
				//$sample_update=$this->db->replace('hivdtssamples', $data);
				$this->db->where('sampleid',$data['sampleid']);
				$this->db->update('syphsamples', $data);
			}
			else {
				return 'Record Does not Exist';
			}
		}
	}


	private function checkSampleExists($id){
		//$sql=''
		$query = $this->db->get_where('syphsamples', array('sampleid' => $id));
		return $query->num_rows();
	}

	public function UpdateSyphResult($data){
		if($data){

			//check for parent record
			$issyphIn=$this->isSyphilisRecordIn($data['sampleid']);
			if($issyphIn==0){
				//insert parent record
				$rec_insert=$this->getSyphDetailFromHiv($data['sampleid']);
			}
			//check whether the line result is in
			$line_in=$this->checkresultLines($data['sampleid'],$data['panelid'],$data['testcatid']);

			if($line_in==1){
				//record in update or delete
				if($data['result']!=''){ //update
					$dat = array(
					        'panelid' 		=> 	$data['panelid'],
					        'testcatid'		=>	$data['testcatid'],
					        'result'		=>	$data['result']
					        
					);

					$this->db->where('sampleid', $data['sampleid']);
					$this->db->where('testcatid', $data['testcatid']);
					$this->db->where('panelid', $data['panelid']);
					$this->db->update('syphresults', $dat);
				}
				else{	//delete
					if($data['result']==''){
						$this->db->where('sampleid', $data['sampleid']);
						$this->db->where('testcatid', $data['testcatid']);
						$this->db->where('panelid', $data['panelid']);
						$this->db->delete('syphresults');
					}
				}
			}
			else {
				if($data['result']!='' and $data['testcatid']!=''){ //insert new record
					$dat = array(
							'sampleid'		=>	$data['sampleid'],
					        'panelid' 		=> 	$data['panelid'],
					        'testcatid'		=>	$data['testcatid'],
					        'result'		=>	$data['result']
					        
					);

						$this->db->set($dat);
						$this->db->insert('syphresults');
				}
			}
		}
	}
/*
	private function updateSyphResults($data){
		if($data){
			//check the line in the db
			$line_is_in=$this->checkresultLines($data['sampleid'],$data['panelid'],$data['testcatid']);

			if($line_is_in==1){
				//record in Update DB
				if($data['result']!=''){
					$dat=array(
						'panelid' 		=> 	$data['panelid'],
				        'testcatid'		=>	$data['testcatid'],
				        'result'		=>	$data['result']
					);

					$this->db->where('sampleid', $data['sampleid']);
					$this->db->where('testcatid', $data['testcatid']);
					$this->db->where('panelid', $data['panelid']);
					$this->db->update('syphresults', $dat);
				}
			}
			else {
				//delete
					$this->db->where('sampleid', $data['sampleid']);
					$this->db->where('testcatid', $data['testcatid']);
					$this->db->where('panelid', $data['panelid']);
					$this->db->delete('syphresults');
			}
		}
		else {
			if($data['result']!='' && $data['testcatid']!='' ){ //insert new record
					$dat = array(
							'sampleid'		=>	$data['sampleid'],
					        'panelid' 		=> 	$data['panelid'],
					        'testcatid'		=>	$data['testcatid'],
					        'result'		=>	$data['result']
					);

						$this->db->set($dat);
						$this->db->insert('syphresults');
				}
		}
	}
*/
	public function checkresultLines($sampleid,$panelid,$testcatid){
		if($sampleid && $testcatid && $panelid){
		
		$this->db->select('*');
		$this->db->from('syphresults');
		$this->db->where('sampleid',$sampleid);
		$this->db->where('testcatid',$testcatid);
		$this->db->where('panelid',$panelid);

		return $this->db->count_all_results();

		}
	}

	private function getSyphDetailFromHiv($sampleid){
		$sql='INSERT INTO `syphsamples`(`sampleid`, `testercode`, `site`, `cycleid`, `dept`, `dod`, `dsr`, `rxBy`, `dtsr`, `dtst`, `sqty`, `DateRxAtUVRI`, `testerdate`, `Supervisor`,  `enteredby`, `date_entered`, `printed`, `printDate`, `Qc`, `qcstaff`, `qcDate`, `formSerial`) select `sampleid`, `testercode`, `site`, `cycleid`, `dept`, `dod`, `dsr`, `rxBy`, `dtsr`, `dtst`, `sqty`, `DateRxAtUVRI`, `testerdate`, `Supervisorname`, `enteredby`, `date_entered`, `printed`, `printDate`, `Qc`, `approvedby`, `approvaldate`, `formSerial` from hivdtssamples where sampleid=?';
		$query=$this->db->query($sql,array($sampleid));
		return ($query ==true) ? true : false;
	}

	private function isSyphilisRecordIn($sampleid){
		//$sql='select * from syphsamples where sampleid=?';
		$this->db->select('*');
		$this->db->from('syphsamples');
		$this->db->where('sampleid',$sampleid);
		return $this->db->count_all_results();
	}
}