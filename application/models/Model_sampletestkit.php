<?php
class Model_sampletestkit extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getSampleTestkit($id=null){
		if($id){
			$sql="SELECT * FROM sampletestkit WHERE sampleid=?";
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}

			$sql="SELECT * FROM sampletestkit";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function saveSampleKit($data){
		if($data){
			$insert = $this->db->insert_batch('hivdtssampletestkit',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function UpdateKit($skit,$ckit,$tkit){
		//check if kit detail are in
		//screening kit
		if($skit['sampleid']!=''){
			$line_in=$this->checkKitLine($skit['sampleid'],$skit['testcatid']);
			//if the line is in - Update the result and acted on_by
				if($line_in==1){
					if($skit['testname']!=''){
						$data = array(
						        'testname' 		=> 	$skit['testname'],
						        'lotno'			=>	$skit['lotno'],
						        'expdt'			=>	$skit['expdt'],
						        'acted_on_by' 	=> 	$skit['acted_on_by']
						);

						$this->db->where('sampleid', $skit['sampleid']);
						$this->db->where('testcatid', $skit['testcatid']);
						$this->db->update('hivdtssampletestkit', $data);
					}
					else {
						//delete from the db this line
						$this->db->where('sampleid', $skit['sampleid']);
						$this->db->where('testcatid', $skit['testcatid']);
						$this->db->delete('hivdtssampletestkit');
					}
				}
				else{
					//not in DB insert
					if($skit['testname']!=''){
						$data = array(
									'sampleid'		=>	$skit['sampleid'],
									'testcatid'		=>	$skit['testcatid'],
							        'testname' 		=> 	$skit['testname'],
							        'lotno'			=>	$skit['lotno'],
							        'expdt'			=>	$skit['expdt'],
							        'acted_on_by' 	=> 	$skit['acted_on_by']
							);
						$this->db->set($data);
						$this->db->insert('hivdtssampletestkit');
					}
				}
			
		}
		
		//confirmatory kit
		if($ckit['sampleid']!=''){
			$line_in=$this->checkKitLine($ckit['sampleid'],$ckit['testcatid']);
			//if the line is in - Update the result and acted on_by
				if($line_in==1){
					if($ckit['testname']!=''){
						$data = array(
						        'testname' 		=> 	$ckit['testname'],
						        'lotno'			=>	$ckit['lotno'],
						        'expdt'			=>	$ckit['expdt'],
						        'acted_on_by' 	=> 	$ckit['acted_on_by']
						);

						$this->db->where('sampleid', $ckit['sampleid']);
						$this->db->where('testcatid', $ckit['testcatid']);
						$this->db->update('hivdtssampletestkit', $data);
					}
					else {
						//delete from the db this line
						$this->db->where('sampleid', $ckit['sampleid']);
						$this->db->where('testcatid', $ckit['testcatid']);
						$this->db->delete('hivdtssampletestkit');
					}
				}
				else{
					//not in DB insert
					if($ckit['testname']!=''){
						$data = array(
									'sampleid'		=>	$ckit['sampleid'],
									'testcatid'		=>	$ckit['testcatid'],
							        'testname' 		=> 	$ckit['testname'],
							        'lotno'			=>	$ckit['lotno'],
							        'expdt'			=>	$ckit['expdt'],
							        'acted_on_by' 	=> 	$ckit['acted_on_by']
							);
						$this->db->set($data);
						$this->db->insert('hivdtssampletestkit');
					}
				}
			
		}
		//tie breaker kit
		if($tkit['sampleid']!=''){
			$line_in=$this->checkKitLine($tkit['sampleid'],$tkit['testcatid']);
			//if the line is in - Update the result and acted on_by
				if($line_in==1){
					if($tkit['testname']!=''){
						$data = array(
						        'testname' 		=> 	$tkit['testname'],
						        'lotno'			=>	$tkit['lotno'],
						        'expdt'			=>	$tkit['expdt'],
						        'acted_on_by' 	=> 	$tkit['acted_on_by']
						);

						$this->db->where('sampleid', $tkit['sampleid']);
						$this->db->where('testcatid', $tkit['testcatid']);
						$this->db->update('hivdtssampletestkit', $data);
					}
					else {
						//delete from the db this line
						$this->db->where('sampleid', $tkit['sampleid']);
						$this->db->where('testcatid', $tkit['testcatid']);
						$this->db->delete('hivdtssampletestkit');
					}
				}
				else{
					//not in DB insert
					if($tkit['testname']!=''){
							$data = array(
									'sampleid'		=>	$tkit['sampleid'],
									'testcatid'		=>	$tkit['testcatid'],
							        'testname' 		=> 	$tkit['testname'],
							        'lotno'			=>	$tkit['lotno'],
							        'expdt'			=>	$tkit['expdt'],
							        'acted_on_by' 	=> 	$tkit['acted_on_by']
							);
						$this->db->set($data);
						$this->db->insert('hivdtssampletestkit');
					}
				}
			
		}

	}

	private function checkKitLine($sampleid,$testcat){
		if($sampleid && $testcat){
		
		$this->db->select('*');
		$this->db->from('hivdtssampletestkit');
		$this->db->where('sampleid',$sampleid);
		$this->db->where('testcatid',$testcat);

		return $this->db->count_all_results();

		}
	}
}