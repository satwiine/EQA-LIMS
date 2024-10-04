<?php
/**
 * 
 */
class Model_reporting extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->wdb = $this->load->database('Warehouse', true);
	}


	function getDistributionData($region=null, $district=null,$facility=null,$level=null,$cadre=null,$startperiod=null,$endperiod=null){
		
		$sql="SELECT * FROM `distribution_data_store` where 1 ";

		if($region !=''){$sql.' and facilityregion="'.$region.'"';}
		if($district!=''){$sql.' and facilitydistrict="'.$district.'"';}
		if($facility !=''){$sql.' and sitename="'.$facility.'"';}
		if($level!=''){$sql.' and facilitylevel="'.$level.'"';}
		if($cadre!=''){$sql.' and cadre="'.$cadre.'"';}
		if($startperiod!='' && $endperiod!=''){$sql. ' and cycleid between '.$startperiod.' and '.$endperiod;}elseif ($startperiod!=''){$sql.' and cycleid='.$startperiod;} {
			// code...
		}

		$query			= $this->wdb->query($sql);
		$result 		= $query->result_array();
		return $result;
	}


	public function getDistinctRegions(){
		$sql='SELECT distinct facilityregion FROM `distribution_data_store`  order by facilityregion asc';
		$query			= $this->wdb->query($sql);
		$result 		= $query->result_array();
		return $result;
	}


	public function getDistinctDistricts(){
		$sql='SELECT distinct facilitydistrict FROM `distribution_data_store`  order by facilitydistrict asc';
		$query			= $this->wdb->query($sql);
		$result 		= $query->result_array();
		return $result;
	}
		
		
	public function getDistinctSites(){
		$sql='SELECT distinct sitename FROM `distribution_data_store`  order by sitename asc';
		$query			= $this->wdb->query($sql);
		$result 		= $query->result_array();
		return $result;
	}


	public function getDistinctLevels(){
		$sql='SELECT distinct facilitylevel FROM `distribution_data_store` order by facilitylevel asc';
		$query			= $this->wdb->query($sql);
		$result 		= $query->result_array();
		return $result;
	}
	
	

	public function getDistinctCadres(){
		$sql='SELECT DISTINCT cadre FROM `distribution_data_store` ORDER BY `cadre` ASC';
		$query			= $this->wdb->query($sql);
		$result 		= $query->result_array();
		return $result;
	}

	

	public function getDistinctCycles(){
		$sql='SELECT DISTINCTROW cycleid,cyclename FROM `distribution_data_store` order by cyclename asc';
		$query			= $this->wdb->query($sql);
		$result 		= $query->result_array();
		return $result;
	}
}