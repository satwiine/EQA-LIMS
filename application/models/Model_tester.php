<?php
class Model_tester extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	//get proposed tester
	public function getProposedTester(){
		$sql="SELECT st.id,st.testername,ti.name as cadre, s.sitename, de.departmentname,st.contact,date_format(st.suggestedDate,'%D-%M-%Y') as suggestedDate FROM v_suggestedTesters st, site s, title ti, department de where st.title=ti.id and st.dept=de.id and s.sitecode=st.facility";
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	// get tester data
	public function getTester($id=null){
		if($id){
			$sql="SELECT t.tcode,t.TesterName,ti.name as Title,d.id as Dept,s.sitename,di.districtname,l.LevelName,o.name as owner,h.name as Hub,dm.deliverymode,r.RegionName,s.sitecode, s.location,s.division,t.contacts,t.status FROM tester t, title ti, department d,site s, sitetester st,district di, facilitylevel l,ownership o,hubs h,deliverymode dm,region r where ti.id=t.title and d.id=st.dept and st.testercode=t.tcode and st.sitecode =s.sitecode and di.id=s.districtid and l.id=s.levelid and o.id=s.ownershipid and h.id=s.hubcode and dm.id=s.delimode and di.regionid=r.regionid and t.tcode=?";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		elseif($_SESSION['usercat']==11 || $_SESSION['usercat']==12 || $_SESSION['usercat']==15){
			$sql='SELECT t.tcode,t.TesterName,ti.name as title,tc.CategoryName,t.status FROM tester t, title ti, titlecategory tc WHERE t.title=ti.id and ti.titleCategory=tc.categoryId and t.status=1 and t.tcode in ( SELECT sitetester.testercode FROM `sitetester` WHERE sitetester.sitecode in (Select site.sitecode from site where site.Districtid in (SELECT stakeholderaligning.coverage from stakeholderaligning where stakeholderaligning.userid=?)))';
			$query =$this->db->query($sql,$_SESSION['id']);
			return $query->result_array();
		}
		$sql="SELECT t.tcode,t.TesterName,ti.name as Title,d.id as Dept,d.departmentname as department,s.sitename,di.districtname,l.LevelName,o.name as owner,h.name as Hub,dm.deliverymode,r.RegionName,s.sitecode, s.location,s.division,t.contacts,t.status FROM tester t, title ti, department d,site s, sitetester st,district di, facilitylevel l,ownership o,hubs h,deliverymode dm,region r where ti.id=t.title and d.id=st.dept and st.testercode=t.tcode and st.sitecode =s.sitecode and di.id=s.districtid and l.id=s.levelid and o.id=s.ownershipid and h.id=s.hubcode and dm.id=s.delimode and di.regionid=r.regionid";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	public function getTesterDetail($testercode){
		$sql= "SELECT t.tcode,t.TesterName,ti.name as Title,d.id as Dept,s.sitename,di.districtname,l.LevelName,o.name as owner,h.name as Hub,dm.deliverymode,r.RegionName,s.sitecode, s.location,s.division,t.contacts,t.status FROM tester t, title ti, department d,site s, sitetester st,district di, facilitylevel l,ownership o,hubs h,deliverymode dm,region r where t.tcode =? and ti.id=t.title and d.id=st.dept and st.testercode=t.tcode and st.sitecode =s.sitecode and di.id=s.districtid and l.id=s.levelid and o.id=s.ownershipid and h.id=s.hubcode and dm.id=s.delimode and di.regionid=r.regionid";
		$query =$this->db->query($sql,array($testercode));
			return $query->row_array();
	}

	public function getTesterSummaryByCadre(){
		$sql='SELECT tc.CategoryName,count(te.tcode) as testers FROM titlecategory tc, title ti, tester te where tc.categoryId=ti.titleCategory and ti.id=te.title and te.status=1 GROUP by tc.CategoryName order by tc.CategoryName asc';
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function getOpencode(){
		$sql="SELECT * FROM _opencodes LIMIT 0,1";
		$query =$this->db->query($sql);
		return $query->row_array();
	}

	public function getProposedTesterDetail($id){
		$sql="select * from dts.stakeholdernewtester where id =?";
		$query =$this->db->query($sql,array($id));
		return $query->row_array();
	}

	public function updateEffectedTester($id){
		$sql="update dts.stakeholdernewtester set effected=1 where id =?";
		$query =$this->db->query($sql,array($id));
		return true;
	}
	public function addNewTester($data){
		if($data){
			$insert = $this->db->insert('tester',$data);
			return ($insert==true) ? true : false;
		}

	}

	public function cleanupOpenCode(){
		$sql='delete FROM `_opencodes` WHERE _opencodes.tcode in (select tester.tcode from tester)';
		$query=$this->db->query($sql);
		return ($query ==true) ? true : false;
	}
	
	public function sanitizeOpenCode(){
		$sql='DELETE FROM `_opencodes` WHERE testercode in(SELECT tcode from tester)';
		$query=$this->db->query($sql);
		return ($query ==true) ? true : false;
	}

	public function delOpenCode($id){
		$sql = 'delete from _opencodes where testercode =?';
		$query=$this->db->query($sql,array($id));
		return ($query ==true) ? true : false;
	}

	public function updateTester($id,$data){
		if($data && $id) {
			$this->db->where('tcode', $id);
			$update = $this->db->update('tester', $data);
			return ($update == true) ? true : false;
		}
	}

	public function deactivateTester($id,$data){
		If($id && $data){
			$this->db->where('tcode', $id);
			$update = $this->db->update('tester', $data);
			return ($update == true) ? true : false;
		}
	}

	public function reactivateTester($id,$data){
		If($id && $data){
			$this->db->where('tcode', $id);
			$update = $this->db->update('tester', $data);
			return ($update == true) ? true : false;
		}
	}

	public function updateSiteTeste($id,$data){
		If($id && $data){
			$this->db->where('testercode', $id);
			$update = $this->db->update('sitetester', $data);
			return ($update == true) ? true : false;
		}
	}
}