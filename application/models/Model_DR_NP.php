<?php
class Model_DR_NP extends CI_Model
{

		public $id; 
		public $trandate; 
		public $sample_id; 
		public $vtype; 
		
		///mutation properties (atype and sampleid are shared from above)
		  public $category;
		  public $mutation_text;
		  public $mutation_string;

		///drug mutation properties(sampleid and category will be shared)
		  public $drugcode;
		  public $drugname;
		  public $score;
		  public $level;
		  public $mut_text;
		  public $mut_string;
	function __construct()
	{
		parent::__construct();
	}


	//get samples with no results
	public function samplePendingResult(){
		$sql='SELECT id,eligiblesampleid,patientArtNumber,sex,birthdate,facilityName,date_format(dateCollected,"%D-%c-%Y") as dateCollected, drLabSampleId,date_format(endpointrxdate,"%D-%c-%Y") as endpointrxdate,datediff(CURRENT_DATE(),endpointrxdate) as days FROM v_dr_samples_with_no_results order by endpointrxdate desc';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function resultsPendingUpload(){
		$sql='SELECT id,eligibleSampleid,drLabSampleId,vlsampleid, patientArtNumber, sex, date_format(birthdate,"%D-%c-%Y") as birthdate, facilityName,datediff(CURRENT_DATE,endpointrxdate) as days FROM nationaldr_db.samples WHERE drLabSampleId in(SELECT sample_id from nationaldr_db.sample_base) and result_sent =0';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function unamplifiedSamples(){
		$sql='SELECT id,eligibleSampleid,drLabSampleId,vlsampleid, patientArtNumber, sex, date_format(birthdate,"%D-%c-%Y") as birthdate, facilityName,datediff(CURRENT_DATE,endpointrxdate) as days FROM nationaldr_db.samples where amplified=0 and result_sent=0';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
///i am using a different data
	public function addSampleBaseData($data){
		$sql="insert into nationaldr_db.sample_base(trandate, sample_id, vtype)values('".$data['trandate']."','".$data['sample_id']."','".$data['vtype']."')";
		$insert = $this->db->query($sql);
		//$reciept_id =$this->db->insert_id();
		
		
		return ($insert ==true) ? true : false;
	}


	public function addMutationData($sampleid,$atype,$gene,$muttype,$mutstr){
	    	$sql="INSERT INTO nationaldr_db.mutations(eligibleSampleid, atype, category, mutation_text, mutation_string) 
	    	VALUES ('".$sampleid."','".$atype."','".$gene."','".$muttype."','".$mutstr."')";
	    	$insert = $this->db->query($sql);
		
			return ($insert ==true) ? true : false;
	}

	public function addDrugmutationData($sampleid,$dcode,$dname,$category,$score,$rlevel,$rtext){
	    	$sql="INSERT ignore INTO nationaldr_db.drugmutations(sample_id, drugcode, drugname, category, score, resistancelevel, resistancetext) 
	    	VALUES ('".$sampleid."','".$dcode."','".$dname."','".$category."','".$score."','".$rlevel."','".$rtext."')";
	    		$insert = $this->db->query($sql);
	    	$insert = $this->db->query($sql);

		 return ($insert ==true) ? true : false;
	}

	public function updateDrugnames($sampleid,$drugcode,$dname){
		
			$sql="UPDATE nationaldr_db.drugmutations SET drugname='".$dname."' where sample_id='".$sampleid."' and drugcode='".$drugcode."'";
			$update = $this->db->query($sql);
			return ($update ==true) ? true : false;
	}

	public function addCommentsData($sampleid,$category,$comment,$grp){
			$sql="INSERT INTO nationaldr_db.comments(sample_id, category, comment,grp) VALUES ('".$sampleid."','".$category."','".$comment."','".$grp."')";
				 $insert = $this->db->query($sql);
		 return ($insert ==true) ? true : false;
	}
	public function addGroupMutationData($sampleid,$gene,$muttype,$mutstr){
	    	$sql="INSERT INTO nationaldr_db.groupmutations(sample_id, gene, mutationtype, mutation_string) VALUES ('".$sampleid."','".$gene."','".$muttype."','".$mutstr."')";
	    		$insert = $this->db->query($sql);
				 return ($insert ==true) ? true : false;
	}

	public function getSampleProfile($sampleid){
		$sql='SELECT * FROM nationaldr_db.v_sample_profile where eligiblesampleid=?';
			$query =$this->db->query($sql,array($sampleid));
			return $query->row_array();
	}

	public function getUnAmplifiedSampleProfile($sampleid){
		$sql='SELECT eligibleSampleId, testDate,drLabSampleId, releaseDate,"false" as amplified,  "" as rtSubType FROM nationaldr_db.samples where eligibleSampleId=?';
		$query =$this->db->query($sql,array($sampleid));
		return $query->row_array();
	}

	public function getSamplePolymorphism($sampleid){
		$sql="select max(if(v.category='NNRTI',v.mutation_string,'')) as nnrti, 
			max(if(v.category='NRTI',v.mutation_string,'')) as nrti, 
			max(if(v.category='PI',v.mutation_string,'')) as pi,
			max(if(v.category='Other',v.mutation_string,'')) as Other, 
			max(if(v.category='Major',v.mutation_string,'')) as Major, 
			max(if(v.category='IN',v.mutation_string,'')) as INST,
			max(if(v.category='Accessory',v.mutation_string,'')) as Accessory from (SELECT gm.sample_id as 
			eligiblesampleid,gm.mutationtype as category,GROUP_CONCAT(gm.mutation_string) as mutation_string 
			FROM nationaldr_db.groupmutations gm  where 
			gm.sample_id in(SELECT `drlabsampleid` FROM nationaldr_db.samples where 
			eligibleSampleid='".$sampleid."') group by gm.sample_id,gm.mutationtype) as v group by v.eligiblesampleid";
			$query =$this->db->query($sql,array($sampleid) );
			return $query->row_array();
	}

	public function getSampleDr($sampleid){
		$sql='SELECT * FROM nationaldr_db.drugmutations WHERE sample_id in(select drlabsampleid from nationaldr_db.samples where eligiblesampleid="'.$sampleid.'")';
		$query =$this->db->query($sql,array($sampleid));
		return $query->result_array();
	}

	public function getSammpleComment($sampleid){
		$sql='SELECT * FROM nationaldr_db.comments WHERE sample_id in(select drlabsampleid from nationaldr_db.samples where eligiblesampleid="'.$sampleid.'")';
		$query =$this->db->query($sql,array($sampleid));
		return $query->result_array();
	}


	///batch insertions
		//mutations table
	public function addBatchMutations($data){
		return $this->db->insert_batch('nationaldr_db.mutations', $data)? true : false;

	}
		//drugmutations table
	public function addBatchDrugMutations($data){
		return $this->db->insert_batch('nationaldr_db.drugmutations', $data)? true : false;
	}


	public function addBatchGroupMutations($data){
		return $this->db->insert_batch('nationaldr_db.groupmutations', $data)? true : false;
	}


	public function addBatchComment($data){
		return $this->db->insert_batch('nationaldr_db.comments', $data)? true : false;
	}


	public function updateSampleRecieved($sampleid){
		$sql='UPDATE nationaldr_db.samples SET result_sent=1,result_send_date=CURRENT_DATE  WHERE eligibleSampleid="'.$sampleid.'"';
		$update = $this->db->query($sql);
			return ($update ==true) ? true : false;

	}

	public function createSampleError($data){
		$sql="Insert into nationaldr_db.FailedResults values('".$data."')";
		$inser = $this->db->query($sql);
			return ($insert ==true) ? true : false;

	}

	
}