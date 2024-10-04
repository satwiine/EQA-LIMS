<?php
class Model_facility extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getFacilityRaw($id){
		//$sql='SELECT  sitecode, Sitename, Districtid, levelid, ownershipid, hubcode, delimode, division, location FROM site ';
		$this->db->where('sitecode',$id);
		$this->db->select('sitecode, Sitename, Districtid, levelid, ownershipid, hubcode, delimode, division, location');
		$this->db->from('site');
		$query = $this->db->get();
		return $query->row_array();

	}
	// get facility data
	public function getFacility($id=null){
		if($id){
			$sql="SELECT s.sitecode,s.Sitename,d.DistrictName,r.RegionName,fl.LevelName as level,o.name as owner,s.facstatus,s.location, s.division, h.name as hub, DATE_FORMAT(s.RegistrationDate,'%d-%M-%Y') as RegistrationDate FROM site s, district d, region r, facilitylevel fl, ownership o, hubs h WHERE s.Districtid=d.id and d.Regionid=r.regionid and s.ownershipid=o.id and fl.id=s.levelid and h.id=s.hubcode and s.sitecode=? order by s.Sitename,d.DistrictName";
			$query =$this->db->query($sql,array($id));
			return $query->row_array();
		}
		elseif($_SESSION['usercat']==11 || $_SESSION['usercat']==12 || $_SESSION['usercat']==15 ){ //dlfp, clfp,dho,add cho
			$sql='SELECT s.sitecode,s.Sitename,d.DistrictName,r.RegionName,fl.LevelName as level,o.name as owner,s.facstatus,s.location, s.division, h.name as hub , DATE_FORMAT(s.RegistrationDate,"%d-%M-%Y") as RegistrationDate FROM site s, district d, region r, facilitylevel fl, ownership o, hubs h WHERE s.Districtid=d.id and d.Regionid=r.regionid and s.ownershipid=o.id and fl.id=s.levelid and h.id=s.hubcode and s.Districtid  in(SELECT stakeholderaligning.coverage from stakeholderaligning where stakeholderaligning.userid=?) order by  d.DistrictName, s.Sitename asc';
			$query =$this->db->query($sql,array($_SESSION['id']));
			return $query->result_array();
		}
		elseif($_SESSION['usercat']==13){ //hub cordinator
			$sql='SELECT s.sitecode,s.Sitename,d.DistrictName,r.RegionName,fl.LevelName as level,o.name as owner,s.facstatus,s.location, s.division, h.name as hub , DATE_FORMAT(s.RegistrationDate,"%d-%M-%Y") as RegistrationDate FROM site s, district d, region r, facilitylevel fl, ownership o, hubs h WHERE s.Districtid=d.id and d.Regionid=r.regionid and s.ownershipid=o.id and fl.id=s.levelid and s.hubcode  in(SELECT stakeholderaligning.coverage from stakeholderaligning where stakeholderaligning.userid=?) order by  d.DistrictName, s.Sitename asc';
			$query =$this->db->query($sql,array($_SESSION['id']));
			return $query->result_array();
		}
		elseif($_SESSION['usercat']==14){ //ip
			$sql='SELECT s.sitecode,s.Sitename,d.DistrictName,r.RegionName,fl.LevelName as level,o.name as owner,s.facstatus,s.location, s.division, h.name as hub , DATE_FORMAT(s.RegistrationDate,"%d-%M-%Y") as RegistrationDate FROM site s, district d, region r, facilitylevel fl, ownership o, hubs h WHERE s.Districtid=d.id and d.Regionid=r.regionid and s.ownershipid=o.id and fl.id=s.levelid and h.id=s.hubcode and s.sitecode  in(SELECT sitecode  FROM sitepartner WHERE userid = ?)';
			$query =$this->db->query($sql,array($_SESSION['id']));
			return $query->result_array();

		}
		$sql="SELECT s.sitecode,s.Sitename,d.DistrictName,r.RegionName,fl.LevelName as level,o.name as owner,s.facstatus,s.location, s.division, h.name as hub, DATE_FORMAT(s.RegistrationDate,'%d-%M-%Y') as RegistrationDate  FROM site s, district d, region r, facilitylevel fl, ownership o, hubs h WHERE s.Districtid=d.id and d.Regionid=r.regionid and s.ownershipid=o.id and h.id=s.hubcode and fl.id=s.levelid order by  s.Sitename asc";
			$query =$this->db->query($sql);
			return $query->result_array();
	}

	// public function countElementValue($id){
	// 	if($id){
	// 		$sql="SELECT `id`, `value_name`, `parent_id` FROM `attribute_value` WHERE `parent_id`=?";
	// 		$query =$this->db->query($sql,array($id));
	// 		return $query->num_rows();
	// 	}
	// }

	// public function getElementValueData($id=null){
	// 	if($id){
	// 		$sql="SELECT `id`, `value_name`, `parent_id` FROM `attribute_value` WHERE `parent_id`=?";
	// 		$query =$this->db->query($sql,array($id));
	// 		return $query->result_array();
	// 	}
	// }

	// public function createValue($data){
	// 	if($data){
	// 		$insert = $this->db->insert('attribute_value',$data);
	// 		return ($insert ==true) ? true : false;
	// 	}
	// }

	public function create($data){
		if($data){
			$insert = $this->db->insert('site',$data);
			return ($insert==true) ? true : false;
		}
	}

	public function update($data,$id){
		if($data && $id){
			$this->db->where('id',$id);
			$update = $this->db->update('site',$data);
			return ($update ==true) ? true : false;
		}
	}


	public function getFacilityByLevel(){
		if($_SESSION['usercat']==11 || $_SESSION['usercat']==12 || $_SESSION['usercat']==15){
			$sql='SELECT fl.LevelName,count(s.sitecode) as sites FROM site s, facilitylevel fl where fl.id=s.levelid and s.Districtid in(select stakeholderaligning.coverage from stakeholderaligning where stakeholderaligning.userid=?) GROUP by fl.LevelName order by fl.id asc';
			$query =$this->db->query($sql,$_SESSION['id']);
			return $query->result_array();
		}
		elseif($_SESSION['usercat']==13){
			//create 
			//get facility list for hub coordinator
		}
		else
		{
		$sql='SELECT fl.LevelName,count(s.sitecode) as sites FROM site s, facilitylevel fl where fl.id=s.levelid GROUP by fl.LevelName order by fl.id asc';
		$query =$this->db->query($sql);
		return $query->result_array();
		}
	}

	public function delOpenSiteCode($id){
		$sql = 'delete from _opensitecodes where sitecode =?';
		$query=$this->db->query($sql,array($id));
		return ($query ==true) ? true : false;
	}

	public function updateFacility($id,$data){
		if($data && $id) {
			$this->db->where('sitecode', $id);
			$update = $this->db->update('site', $data);
			return ($update == true) ? true : false;
		}
	}

	public function deactivatefacility($id,$data){
		If($id && $data){
			$this->db->where('sitecode', $id);
			$update = $this->db->update('site', $data);
			return ($update == true) ? true : false;
		}
	}

	public function reactivateFacility($id,$data){
		If($id && $data){
			$this->db->where('sitecode', $id);
			$update = $this->db->update('site', $data);
			return ($update == true) ? true : false;
		}
	}
}