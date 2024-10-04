<?php
class Model_samples extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function createApiSample($data){
		if($data){
			$insert = $this->db->insert('api_sample_base',$data);
			return ($insert==true) ? true : false;
		}
	}

	public function accessionSample($data){
		if($data){
			$insert= $this->db->insert('api_sample_result',$data);
			return ($insert==true) ? true : false;
		}
	}

	public function getResultsPendingPushing(){
		$sql='SELECT ar.sampleid,ar.labno,ab.specimenuuid,ab.name_of_collection_point,ab.surname,ab.gender,ab.age,ab.nationality,ab.disease_code,ar.outcome FROM api_sample_result ar, api_sample_base ab WHERE ab.sampleid=ar.sampleid and ar.outcome <>"" and ab.resultsent <>1';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	public function getClaimedSamples(){
		$sql='SELECT sampleid, specimenuuid, specimen_no, surname, fname, gender, age, disease_code, nationality, type_of_sample_collection_point, name_of_collection_point, sample_type, request_date, collection_date, district,datediff(date_result_sent,endpointrxdate) as days FROM api_sample_base where resultsent=0 and processed=0';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	
	public function getSampleDetail($id){
		$sql='SELECT sampleid, specimenuuid, specimen_no, surname, fname, gender, age, disease_code, nationality, type_of_sample_collection_point, name_of_collection_point, sample_type, request_date, collection_date, district,datediff(date_result_sent,endpointrxdate) as days FROM api_sample_base where sampleid='.$id;
		$query =$this->db->query($sql);
		return $query->row_array();
	}

	public function getResultToSend($id){
		$sql='SELECT ar.sampleid,ar.labno,ar.outcome,ar.testdate,ar.testedby,ar.approvedby,ab.specimenuuid,ab.specimen_no,ab.disease_code,ar.ct_value,ar.platform_range,ar.testing_platform,ar.test_method FROM  api_sample_base ab, api_sample_result ar WHERE ar.sampleid=ab.sampleid and ab.specimenuuid="'.$id.'"';
		$query =$this->db->query($sql);
		return $query->row_array();
	}

	public function updateApiSampleBaseResultSent($id){
		$sql= 'update api_sample_base set resultsent=1, date_result_sent=CURRENT_DATE() where specimenuuid="'.$id.'"';
		$upd=$this->db->query($sql);
		return ($upd==true) ? true : false;
	}
}