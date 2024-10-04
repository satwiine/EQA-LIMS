<?php
class Model_cd4 extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getCD4ControlResults(){
		$sql='SELECT cr.sampleid,cr.testid,tp.testname,cr.robust_mean,cr.robust_sd FROM cd4controlresults cr, cd4testpanel tp WHERE tp.testid=cr.testid';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function getCD4Distributions($id=null){
		if($id){
			$sql='SELECT `distributionid`, `trialumber`, `issuedate`, `closingdate` FROM `cd4distribution` WHERE distributionid=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		$sql='SELECT `distributionid`, `trialumber`, `issuedate`, `closingdate` FROM `cd4distribution`';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	public function getCD4Samples($id=null){
		if($id){
			$sql='SELECT cs.sampleid,cs.trialumber,cd.issuedate,cd.closingdate FROM cd4samples cs, cd4distribution cd WHERE cs.trialumber=cd.trialumber and cd.sampleid=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		$sql='SELECT cs.sampleid,cs.trialumber,cd.issuedate,cd.closingdate FROM cd4samples cs, cd4distribution cd WHERE cs.trialumber=cd.trialumber';
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	public function getFacility($id=null){
		if($id){
			$sql="SELECT cs.cd4id,cs.sitecode,s.Sitename,fl.LevelName,d.DistrictName FROM cd4dts_sites cs, site s, facilitylevel fl, district d where s.sitecode=cs.sitecode and fl.id=s.levelid and d.id=s.Districtid and cs.cd4id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		$sql="SELECT cs.cd4id,cs.sitecode,s.Sitename,fl.LevelName,d.DistrictName FROM cd4dts_sites cs, site s, facilitylevel fl, district d where s.sitecode=cs.sitecode and fl.id=s.levelid and d.id=s.Districtid";
		$query =$this->db->query($sql);
		return $query->result_array();
	}
	// get tester data
	public function getTests($id=null){
		if($id){
			$sql="SELECT testid, testname, category FROM cd4TestPanel WHERE testid=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT testid, testname, category FROM cd4TestPanel";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getMachines($id=null){
		if($id){
			$sql="SELECT `id`, `description` FROM `cd4machine` WHERE id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}

		$sql="SELECT `id`, `description` FROM `cd4machine`";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getSites($id=null){
		if($id){
			$sql="SELECT c.cd4id,c.sitecode,s.Sitename,fl.LevelName,o.name as owner,h.Name as delimode,s.division,s.location, d.DistrictName,r.RegionName,r.incharge FROM cd4dts_sites c, site s, district d, region r , facilitylevel fl, ownership o, hubs h  WHERE s.sitecode=c.sitecode and d.id=s.Districtid and r.regionid=d.Regionid and fl.id=s.levelid and o.id=s.ownershipid and h.id=s.hubcode and c.cd4id=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		$sql= "SELECT c.cd4id,c.sitecode,s.Sitename,fl.LevelName,o.name as owner,h.Name as delimode,s.division,s.location, d.DistrictName,r.RegionName,r.incharge FROM cd4dts_sites c, site s, district d, region r , facilitylevel fl, ownership o, hubs h  WHERE s.sitecode=c.sitecode and d.id=s.Districtid and r.regionid=d.Regionid and fl.id=s.levelid and o.id=s.ownershipid and h.id=s.hubcode";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getActiveCycle(){
			$sql="SELECT dc.id,dc.name,dc.quater,dc.cycleyear,dc.calendardesc,dc.isActive,c.Description,dc.description as quartername FROM dtscycles dc, copyears c WHERE c.id=dc.copid and dc.isActive=1";
			$query =$this->db->query($sql);
			return $query->row_array();
	}

	public function getRecencyActiveCycle(){
		$sql='SELECT `batchnum`, `cycleyear`, `isactive` FROM `recency_cycle` WHERE `isactive`=1';
		$query =$this->db->query($sql);
			return $query->row_array();
	}

	public function getRecencyCycle($id=null){
		if($id){
			$sql='SELECT `batchnum`, `cycleyear`, `isactive` FROM `recency_cycle` WHERE `batchnum`=?';
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
			$sql='SELECT `batchnum`, `cycleyear`, `isactive` FROM `recency_cycle` order by batchnum asc';
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	
}