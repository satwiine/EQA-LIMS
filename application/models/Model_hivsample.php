<?php
class Model_hivsample extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// get district data
	public function getHivSample($id=null){
		if($id){
			$sql="SELECT * FROM `samples` WHERE sampleid=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

			$sql="SELECT * FROM samples";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function saveSample($data){
		if($data){
			$insert = $this->db->insert('hivdtssamples',$data);
			return ($insert ==true) ? true : false;
		}
	}

	public function getApproverBySampleId($id){
		if($id){
			$sql='SELECT * FROM `_approver` WHERE uid in(select approvedby from hivdtssamples where sampleid=?)';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
	}

	public function updateSamples($data){
		if($data){
			//check if record exists
			$record=$this->checkSampleExists($data['sampleid']);

			if($record==1){
				//$sample_update=$this->db->replace('hivdtssamples', $data);
				$this->db->where('sampleid',$data['sampleid']);
				$this->db->update('hivdtssamples', $data);
			}
			else {
				return 'Record Does not Exist';
			}
		}
	}


	private function checkSampleExists($id){
		//$sql=''
		$query = $this->db->get_where('hivdtssamples', array('sampleid' => $id));
		return $query->num_rows();
	}
	
}