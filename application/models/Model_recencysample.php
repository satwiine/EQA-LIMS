<?php
class Model_recencysample extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getRecencySample($id=null){
		if($id){
			$sql="SELECT * FROM `hivrecencysamples` WHERE sampleid=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

			$sql="SELECT * FROM hivrecencysamples";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function saveRecencySample($data){
		if($data){
			$insert = $this->db->insert('hivrecencysamples',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function saveRecencyResult($data){
		if($data){
			$insert = $this->db->insert_batch('hivrecencyresult',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function saveRecencyNoTesting($data){
		if($data){
			$insert = $this->db->insert_batch('hivrecencynotestingreason',$data);
			return ($insert ==true) ? true : false;
		}
	}

	///get distribution date from the cycle
	public function getDispatchDateByCycle($batch){
		if($batch){
			$sql='SELECT dispatchdate FROM `recency_cycle` WHERE batchnum=?';
			$query =$this->db->query($sql,array($batch));
			return $query->row_array();
		}
	}

	public function isFormUnique($formserial,$cycle){
		
		$this->db->select('*');
		$this->db->from('hivrecencysamples');
		$this->db->where('formSerial',$formserial);
		$this->db->where('cycleid',$cycle);

		return $this->db->count_all_results();
	}

	public function getSamplesList(){
		$sql='SELECT * FROM v_recency_samples';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function getSampleInfo($id){
		$sql='SELECT sa.sampleid,sa.testercode,te.testername,fa.sitename,fa.levelid as level, fl.levelname, de.departmentname as department,te.contacts as contact ,ti.name as title,sa.dod,sa.dsr,DATE_FORMAT(sa.dtsr,"%D-%b-%Y") as dtsr,DATE_FORMAT(sa.dtst,"%D-%b-%Y")as dtst,sa.cycleid,sa.sqty,sa.rxby,fa.division,fa.location,di.districtname,re.regionname,tn.name as kit,sa.lotnum,sa.expirydate ,sa.testerdate,sa.printdate,sa.approvaldate,sa.approvedby,sa.supervdate,sa.supervisorname,sa.tel,sa.score,sa.status,sa.formserial,sa.qc, sa.site,sa.dept,sa.daterxatuvri,sa.kitid FROM hivrecencysamples sa, tester te, site fa , department de, title ti,testname tn, district di, region re, facilitylevel fl where fa.sitecode=sa.site and sa.testercode = te.tcode and sa.dept=de.id and ti.id=te.title and tn.id=sa.kitid and fa.Districtid=di.id and di.Regionid=re.regionid and fl.id=fa.levelid and sa.sampleid=? group by te.tcode';
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function getResultBySampleId($id){
			$sql= 'SELECT * FROM `hivrecencyresult` WHERE sampleid=?';
			$qry = $this->db->query($sql,array($id));
			return $qry->result_array();
		}

	public function viewSampleResult($id){ ///returns an array
			$res = $this->getSampleResult($id);
			//try to assign the expected final results in this array

			//$ex_res=$this->getExpectedFinalResSampleid($id);
			
			//return $res;
			//exit;
			$d=array();
			$d['pt1']='FAIL';$d['pt2']='FAIL';$d['pt3']='FAIL';$d['pt4']='FAIL';
			$d['pt1_ex_fr']='';$d['pt2_ex_fr']='';$d['pt3_ex_fr']='';$d['pt4_ex_fr']='';
			$out=0;
			foreach($res as $r):
				// if($r['panelid']==10){ ///Long Term Control
				// 	if($r['control_ln']=='LT' && $r['verif_ln']=='LT' && $r['LT_ln']=='LT'){
				// 		if($r['expected_FR_ln'] !='' && $r['expected_FR_ln']==$r['FR_ln']){
				// 			$out+=1;
				// 			$d['ltcRes']='PASS';
				// 			//$d['yr_ltc_fr']=$r['FR_ln'];
				// 			$d['ex_ltc_fr']=$r['expected_FR_ln'];
				// 		}
				// 		else{
				// 			$d['ltcRes']='FAIL';
				// 			//$d['yr_ltc_fr']=$r['FR_ln'];
				// 			$d['ex_ltc_fr']=$r['expected_FR_ln'];
				// 		}
				// 	}
				// }
				// if($r['panelid']==20){ ///Recent Control
				// 	if($r['control_ln']=='LT' && $r['verif_ln']=='LT' && $r['LT_ln']==''){
				// 		if($r['expected_FR_ln'] !='' && $r['expected_FR_ln']==$r['FR_ln']){
				// 			$out+=1;
				// 			$d['RcRes']='PASS';
				// 			//$d['yr_rcRes_fr']=$r['FR_ln'];
				// 			$d['ex_rcRes_fr']=$r['expected_FR_ln'];
				// 		}
				// 		else
				// 		{
				// 			$d['RcRes']='FAIL';
				// 			//$d['yr_rcRes_fr']=$r['FR_ln'];
				// 			$d['ex_rcRes_fr']=$r['expected_FR_ln'];
				// 		}
				// 	}
				// }
				// if($r['panelid']==30){ ///Negative Control
				// 	if($r['control_ln']!=''){
				// 		if($r['control_ln']=='LT' && $r['verif_ln']=='' && $r['LT_ln']==''){
				// 			if($r['expected_FR_ln'] !='' && $r['expected_FR_ln']==$r['FR_ln']){
				// 				$out+=1;
				// 				$d['NcRes']='PASS';
				// 				$d['yr_ncRes_fr']=$r['FR_ln'];
				// 				$d['ex_ncRes_fr']=$r['expected_FR_ln'];
				// 			}
				// 			else
				// 			{
				// 				$d['NcRes']='FAIL';
				// 				//$d['yr_ncRes_fr']=$r['FR_ln'];
				// 				$d['ex_ncRes_fr']=$r['expected_FR_ln'];
				// 			}
				// 		}
				// 	}
				// }

				///PT Panels
				if($r['panelid']>30){
					//assign expected_RF_ln the default expected value
					if($r['panelid']==40){$d['pt1_ex_fr']=$r['Final_Interpretation'];}
					if($r['panelid']==50){$d['pt2_ex_fr']=$r['Final_Interpretation'];}
					if($r['panelid']==60){$d['pt3_ex_fr']=$r['Final_Interpretation'];}
					if($r['panelid']==70){$d['pt4_ex_fr']=$r['Final_Interpretation'];}
					if($r['expected_control_ln'] == $r['control_ln'] && $r['control_ln']!='')
					{
						if($r['expected_verif_ln']==$r['verif_ln'] )
						{
							if($r['expected_LT_ln']==$r['LT_ln'])
							{
								if($r['expected_FR_ln']==$r['FR_ln'] && $r['FR_ln']!='')
								{
									$out+=1;
									if($r['panelid']==40){
										$d['pt1']='PASS';	
									}
									if($r['panelid']==50){
										$d['pt2']='PASS';
									}
									if($r['panelid']==60){
										$d['pt3']='PASS';
									}
									if($r['panelid']==70){
										$d['pt4']='PASS';	
									}
								}
								else{
									if($r['panelid']==40 && $r['FR_ln']==''){$d['pt1_ex_fr']='';}
									if($r['panelid']==50 && $r['FR_ln']==''){$d['pt2_ex_fr']='';}
									if($r['panelid']==60 && $r['FR_ln']==''){$d['pt3_ex_fr']='';}
									if($r['panelid']==70 && $r['FR_ln']==''){$d['pt4_ex_fr']='';}
								}
							}
						}
						 
					}
				}
			endforeach;
			
			$d['score']=($out/4)*100;
			return $d;
		}

		public function getExpectedFinalResSampleid($id){
		$sql="SELECT r.panelid,r.catid,h.Description FROM testresult h, recencypanelresult r WHERE r.result=h.id and r.catid=400 and r.cycleid in (select cycleid from hivrecencysamples where sampleid=?) order by r.panelid,r.catid asc";
		$qry = $this->db->query($sql,array($id));
		$data=$qry->result_array();
		return $data;
	}

	public function getSampleResult($id){
		$sql="select h.sampleid,h.cycleid,h.panelid,
				max(case when h.catid=100 then h.expected else '' end) 
				as expected_control_ln, 
				max(case when h.catid=100 then h.yours else '' end) 
				as control_ln, 
				max(case when h.catid=200 then h.expected else '' end) 
				as expected_verif_ln, 
				max(case when h.catid=200 then h.yours else '' end) 
				as verif_ln,
				max(case when h.catid=300 then h.expected else '' end) 
				as expected_LT_ln, 
				max(case when h.catid=300 then h.yours else '' end) 
				as LT_ln,
				max(case when h.catid=400 then h.expected else '' end) 
				as expected_FR_ln, 
				max(case when h.catid=400 then h.yours else '' end) 
				as FR_ln,
				max(case when h.catid=400 then h.yourresdesc else '' end) 
				as Final_Interpretation,
				max(case when h.catid=400 then h.expectedres else '' end) 
				as Final_expected
				from 
				(
				select * from(select y.sampleid,y.cycleid,y.panelid,y.catid,y.expectedres,y.yours,y.expected, trr.description as yourresdesc from (
					select v.sampleid,v.cycleid,v.panelid,v.catid,tr.description as expectedres,v.yours, v.expected from(
        			select v_rec_panel_result_by_cycle.cycleid,v_rec_panel_result_by_cycle.panelid,v_rec_panel_result_by_cycle.catid,v_rec_panel_result_by_cycle.result as expected,v_rec_result_by_cycle.sampleid,v_rec_result_by_cycle.result as yours from v_rec_panel_result_by_cycle left join v_rec_result_by_cycle on v_rec_panel_result_by_cycle.cycleid = v_rec_result_by_cycle.cycleid and v_rec_panel_result_by_cycle.panelid = v_rec_result_by_cycle.panelid and v_rec_panel_result_by_cycle.catid = v_rec_result_by_cycle.catid and v_rec_result_by_cycle.sampleid=?
				) as v,testresult tr where tr.id=v.expected) as y, testresult trr where trr.id=y.yours)as x, testresult tesres where tesres.id=x.expected) as h group by h.panelid
				";
		$qry = $this->db->query($sql,array($id));
		return $qry->result_array();
	}

	public function UpdateQc(){
		$b=date('Y-m-d'); $r=0;
		$cc=explode(",", $this->input->post('chk'));

		$ungrade_com=array(2,3,6,9,10,13);
		$grade = count(array_intersect($cc, $ungrade_com));

		if($grade>0){
			$fscore="N/A";
			$fstatus="Un-Graded";
		} else{
			$fscore=$this->input->post('score');
			$fstatus=$this->input->post('status');
		}
		
		$sql= 'UPDATE hivrecencysamples set qc=1,approved =1,approvedby='.$this->input->post('app').',approvaldate="'.$b.'",score ="'.$fscore.'" ,status= "'.$fstatus.'" where sampleid = "'.$this->input->post('sample').'"';
		
		$qry = $this->db->query($sql);
		$this->addComments($this->input->post('sample'),$cc);
		return $sql;	

	}

	private function saveComment($s,$v){

		$sl="Insert into othercomments (sampleid,schemeid,commentid)
			  VALUES(".$s.",5,".$v.")"; //note 5 is scheme id for recency
			$qry = $this->db->query($sl) ; 
	}

	public function addComments($sample,$comChunks){
		if(count($comChunks)>0){
			$c=count($comChunks)-1;
			for($i=0;$i< $c;$i++){
				if($comChunks[$i]!=''){
					$this->saveComment($sample,$comChunks[$i]);
				}	
			}
		}
	}

	public function approveRecencyRecord($sampleid,$by,$score,$status){
		$sql='update hivrecencysamples set qc=1, approved=1, approvedby='.$by.', approvaldate=CURRENT_DATE(),score="'.$score.'", status="'.$status.'" where sampleid="'.$sampleid.'"';
		return $this->db->query($sql);
	}

	public function getPrintSampleInfo($id){
		$sql= 'SELECT s.sampleid, s.testercode, st.sitename, s.cycleid, de.departmentname AS department, DATE_FORMAT( s.dod,  "%d-%b-%Y" ) AS dod, DATE_FORMAT( s.dsr,  "%d-%b-%Y" ) AS dsr, DATE_FORMAT( s.dtsr,  "%d-%b-%Y" ) AS recondate, DATE_FORMAT( s.dtst,  "%d-%b-%Y" ) AS testingdate, DATE_FORMAT( s.daterxatuvri,  "%d-%b-%Y" ) AS daterxatuvri, s.score, s.status,h.name as hub,dm.deliverymode,o.name as owner,st.location as location,st.division as division,di.districtname as district,r.regionname as region,s.supervisorname,s.supervdate,t.testername,t.contacts,s.tel,tn.name as testkit,s.lotnum,s.expirydate,ap.names as approver,ap.signature,s.approvaldate FROM  `hivrecencysamples` s, site st, department de, hubs h, deliverymode dm, ownership o,district di,region r, tester t,testname tn,_approver ap 
		WHERE de.id = s.dept 
		AND st.sitecode = s.site
		and h.id=st.hubcode
		and dm.id=st.delimode
		and o.id=st.ownershipid
		and di.id=st.districtid 
		and r.regionid=di.regionid
		and t.tcode=s.testercode
		and tn.id=s.kitid
		and ap.uid=s.approvedby
		AND s.approved =1
		AND (s.printed =0 or s.printed is null)
		and s.sampleid=? 
		group by s.testercode';

		$qry = $this->db->query($sql,array($id));
		$data=$qry->result_array();
		return $data;
	}

	public function getRecencySampleComments($id){
		$sql="SELECT c.description FROM recencycomments sc, commentcategory c WHERE sc.sampleid='".$id."' and sc.schemeid=5 and sc.commentid=c.cid";
		$qry = $this->db->query($sql);
			return $qry->result_array();
	}

	public function getExpectedFinalResBySampleid($id){
		$sql='SELECT r.panelid,r.catid,h.Description FROM testresult h, recencypanelresult r WHERE r.result=h.id and r.catid=400 and r.cycleid in (select cycleid from hivrecencysamples where sampleid="'.$id.'") and h.scheme=5 order by r.panelid,r.catid asc';
		$qry = $this->db->query($sql);
		$data=$qry->result_array();
		return $data;
	}


	
}