<?php
/**
 * 
 */
class Model_distributions extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getDistribution($id=null){
		if($id){
			$sql='SELECT tcode,cycle,site,dept,distributionDate FROM distributions where cycle=?';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
		}
		elseif($_SESSION['usercat']==11 || $_SESSION['usercat']==12 || $_SESSION['usercat']==15 ){
			$sql='select * from distributions where site in(select sitecode from site where site.Districtid in(SELECT stakeholderaligning.coverage from stakeholderaligning where stakeholderaligning.userid=?)) and cycle in(select dtscycles.id from dtscycles where dtscycles.isActive=1)';
			$query =$this->db->query($sql,array($_SESSION['id']));
			return $query->result_array();
		}

		else {
			$sql='select * from distributions where  cycle in(select dtscycles.id from dtscycles where dtscycles.isActive=1)';
			$query =$this->db->query($sql);
			return $query->result_array();
		}


	}

	public function getDispatchedByCycle($id =null){
		if(!$id){
			$id= $this->getActiveCycle();
		}
		
			$sql= 'SELECT r.regionname, COUNT(tcode) as dispatched FROM distributions d, region r, district di, site s WHERE s.sitecode = d.site AND di.id = s.districtid AND di.regionid = r.regionid AND d.cycle =? GROUP BY r.regionname';
			$query =$this->db->query($sql,array($id));
			return $query->result_array();
	}

	public function getReturnsByRegionCycle($id=null){
		if(!$id){
			$id= $this->getActiveCycle();
		}
		$sql='SELECT r.regionname, COUNT(sa.testercode) as reg_Returns FROM hivdtssamples sa, region r, district di, site s WHERE s.sitecode = sa.site AND di.id = s.districtid AND di.regionid = r.regionid AND sa.cycleid =? GROUP BY r.regionname';
		$query =$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function getOnTimeReturnsByRegionCycle($id=null){
		if(!$id){
			$id= $this->getActiveCycle();
		}

		$sql='SELECT r.regionname, COUNT( sa.testercode ) as reg_goodTAT FROM hivdtssamples sa, region r, district di, site s WHERE s.sitecode = sa.site AND di.id = s.districtid AND di.regionid = r.regionid AND sa.cycleid =? and DATEDIFF(sa.DateRxAtUVRI , sa.dod ) <=30 GROUP BY r.regionname';
		$query =$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function getOffTimeReturnsByRegionCycle($id=null){
		if(!$id){
			$id= $this->getActiveCycle();
		}

		$sql='SELECT r.regionname, COUNT( sa.testercode ) as reg_badTAT FROM hivdtssamples sa, region r, district di, site s WHERE s.sitecode = sa.site AND di.id = s.districtid AND di.regionid = r.regionid AND sa.cycleid =? and DATEDIFF(sa.DateRxAtUVRI , sa.dod ) >=31 GROUP BY r.regionname';
		$query =$this->db->query($sql,array($id));
		return $query->result_array();
	}
	private function getActiveCycle(){
		$sql='SELECT * FROM dtscycles WHERE isactive=1';
		$query =$this->db->query($sql);
		$result=$query->row_array();
		return $result['id'];
	}

	public function getDODByCycleSite($site,$id=null){
		if(!$id){
			$id=$this->getActiveCycle();
			$sql='SELECT distributiondate FROM `distributions` WHERE site=? and cycle=? LIMIT 0,1';
		}
		else{
			$sql='SELECT distributiondate FROM `distributions` WHERE site=? and cycle=? LIMIT 0,1';
		}
		$query =$this->db->query($sql,array($site,$id));
		$result=$query->row_array();
		return $result;
	}

	public function getRecDoDByCycleSite($site,$id=null){
		if(!$id){
			$id=$this->Model_cycle->getRecencyActiveCycle();
			$sql= "SELECT dod FROM `recencyDistribution` where sitecode=? and cycleid=? LIMIT 0,1";
		}
		else {
			$sql= "SELECT dod FROM `recencyDistribution` where sitecode=? and cycleid=? LIMIT 0,1";
		}
		$query =$this->db->query($sql,array($site,$id));
		$result=$query->row_array();
		return $result;
	}
	public function listDistribution(){
		$sql='SELECT d.cycle,dc.Name,s.sitecode,s.Sitename,di.DistrictName,dm.DeliveryMode,count(d.tcode) as panels FROM distributions d, dtscycles dc, site s, district di, deliverymode dm where d.cycle=dc.id and d.site=s.sitecode and di.id=s.Districtid and s.delimode=dm.id and dc.isActive=1 GROUP by d.cycle,d.site';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function distributionDetailByFacilityCycle($cycle,$site){
		$sql='SELECT DISTINCTROW t.tcode,t.TesterName, ti.name as `title`, tc.CategoryName,de.departmentname, s.Sitename FROM distributions d, tester t, site s, titlecategory tc, title ti , department de where d.tcode=t.tcode and d.site=s.sitecode and tc.categoryId=ti.titleCategory and t.title=ti.id and de.id=d.dept and d.cycle=? and d.site=?';
		$query =$this->db->query($sql,array($cycle,$site));
		$result=$query->result_array();
		return $result;
	}
}