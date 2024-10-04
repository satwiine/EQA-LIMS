<?php
class Model_dashboard extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	///this model generates data for using with dshaboards

	//get response by Facility Level - all is by a quarter
	public function getResponseByFacilityLevel($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}

		$sql="select v.levelname, max(if(action='distributed' ,v.sites,0)) as 'distributed',max(if(action='returned' ,v.sites,0)) as 'Returns',	max(if(action='goodtat' ,v.sites,0)) as 'GoodTAT',
				max(if(action='badtat' ,v.sites,0))as 'badtat'from (

				(SELECT fl.LevelName,count(d.site) as sites,'distributed' as action  FROM distributions d, site s, facilitylevel fl WHERE d.cycle = ".$quarter." and d.site=s.sitecode and s.levelid=fl.id GROUP by fl.LevelName order by fl.LevelName,action)
				union
				(SELECT fl.LevelName,count(hd.site) as sites,'Returned' as action FROM hivdtssamples hd, site s, facilitylevel fl WHERE hd.cycleid = ".$quarter." and hd.site=s.sitecode and s.levelid=fl.id GROUP by fl.LevelName order by fl.LevelName,action)
				union
				(SELECT fl.LevelName,count(hd.site) as sites,'goodtat' as action FROM hivdtssamples hd, site s, facilitylevel fl WHERE hd.cycleid = ".$quarter." and hd.site=s.sitecode and s.levelid=fl.id and datediff(hd.DateRxAtUVRI,hd.dod)<=30 GROUP by fl.LevelName order by fl.LevelName,action)
				union
				(SELECT fl.LevelName,count(hd.site) as sites,'badtat' as action FROM hivdtssamples hd, site s, facilitylevel fl WHERE hd.cycleid = ".$quarter." and hd.site=s.sitecode and s.levelid=fl.id and datediff(hd.DateRxAtUVRI,hd.dod)>=31 GROUP by fl.LevelName order by fl.LevelName,action)) as v group by v.levelname";

		$query =$this->db->query($sql);
		return $query->result_array();
	}


	public function getQuarterlyPerformance(){
		$sql="select v.quarter,
			max(if(v.action='dispatched',freqs,0)) as 'dispatch',
			max(if(v.action='returned',freqs,0)) as 'return',
			max(if(v.action='passed',freqs,0)) as 'passes',
			max(if(v.action='failed',freqs,0)) as 'fail',
			max(if(v.action='un-graded',freqs,0)) as 'ungraded',
			max(if(v.action='unprocessed',freqs,0)) as 'unprocessed',
			max(if(v.action='goodtat',freqs,0)) as 'goodtat',
			max(if(v.action='badtat',freqs,0)) as 'badta'
			from (SELECT region,district,quarter,cycle,action,sum(freqs) as freqs FROM `v_dashboard1` group by cycle,action)  as v group by v.cycle order by v.cycle desc limit 4";
		$query =$this->db->query($sql);
		return $query->result_array();
	}

	public function RegionalGraphByCycle($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}

		$sql="select v.region,
				max(if(v.action='dispatched',freqs,0)) as 'dispatch',
				max(if(v.action='returned',freqs,0)) as 'return',
				max(if(v.action='passed',freqs,0)) as 'passes',
				max(if(v.action='failed',freqs,0)) as 'fail',
				max(if(v.action='un-graded',freqs,0)) as 'ungraded',
				max(if(v.action='unprocessed',freqs,0)) as 'unprocessed',
				max(if(v.action='goodtat',freqs,0)) as 'goodtat',
				max(if(v.action='badtat',freqs,0)) as 'badta'
				from (SELECT region,quarter,cycle,action,sum(freqs) as freqs FROM `v_dashboard1` group by region,cycle,action)  as v where v.cycle=".$quarter." group by v.cycle,v.region order by v.cycle desc";
		$query =$this->db->query($sql);
		return $query->result_array();	
	}

	public function FacilityLevelGraphByCycle($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}

		$sql="select v.levelname,
			max(if(v.action='dispatch',freqs,0)) as 'dispatch',
			max(if(v.action='response',freqs,0)) as 'return',
			max(if(v.action='passes',freqs,0)) as 'passes',
			max(if(v.action='fail',freqs,0)) as 'fail',
			max(if(v.action='un-graded',freqs,0)) as 'ungraded',
			max(if(v.action='good tat',freqs,0)) as 'goodtat',
			max(if(v.action='bad tat',freqs,0)) as 'badtat'
			from(SELECT levelname,cycleid,description,action,sum(freqs) as freqs FROM `v_dashboard2` group by LevelName,cycleid,action) as v where v.cycleid=".$quarter." group by v.cycleid,v.levelname order by levelname asc";
		$query =$this->db->query($sql);
		return $query->result_array();	
	}

	public function getQuarter($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}

		$sql="SELECT Name as quarter FROM `dtscycles`  where id=".$quarter;
		$query =$this->db->query($sql);
		$result=$query->row_array();
		return $result['quarter'];
	}

	public function getResponseRate($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}

		$dis_sql="select count(*) as disptched from distributions where cycle=".$quarter;
		$query =$this->db->query($dis_sql);
		$result=$query->row_array();

		$ret_sql= "select count(*) as returned from hivdtssamples where cycleid=".$quarter;
		$rets=$this->db->query($ret_sql);
		$returns=$rets->row_array();

		return round(($returns['returned']/$result['disptched'])*100);
	}

	public function getRegionalPerformanceByQuarter($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}

		$reg_sql="select v.region,
			max(if(v.action='dispatched',freqs,0)) as 'dispatch',
			max(if(v.action='returned',freqs,0)) as 'return',
			max(if(v.action='passed',freqs,0)) as 'passes',
			max(if(v.action='failed',freqs,0)) as 'fail',
			max(if(v.action='un-graded',freqs,0)) as 'ungraded',
			max(if(v.action='unprocessed',freqs,0)) as 'unprocessed',
			max(if(v.action='goodtat',freqs,0)) as 'goodtat',
			max(if(v.action='badtat',freqs,0)) as 'badta'
			from (SELECT region,quarter,cycle,action,sum(freqs) as freqs FROM `v_dashboard1` group by region,cycle,action)  as v where v.cycle=".$quarter." group by v.cycle,v.region order by v.cycle desc";
		$query =$this->db->query($reg_sql);
		return $result=$query->result_array();
	}

	public function getFacilityLevelPerformanceByQuarter($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}
		$facl="select v.action, max(if(v.levelname='Health Centre II' ,freqs,0)) as 'HCII', max(if(v.levelname='Health Centre III' ,freqs,0)) as 'HCIII', max(if(v.levelname='Private Clinic' ,freqs,0)) as 'Private_Clinic', max(if(v.levelname='Health Centre IV' ,freqs,0)) as 'HCIV', max(if(v.levelname='General Hospital' ,freqs,0)) as 'General_Hospital', max(if(v.levelname='Stand-Alone Laboratory' ,freqs,0)) as 'Laboratory', max(if(v.levelname='Regional Referral Hospital' ,freqs,0)) as 'RRH', max(if(v.levelname='Specialized ART Clinic' ,freqs,0)) as 'ARTClinic', max(if(v.levelname='National Referral Hospital' ,freqs,0)) as 'NRH' from (SELECT levelname,quater,cycleid,action,sum(freqs) as freqs FROM `v_dashboard2` group by levelname,cycleid,action) as v where v.cycleid=".$quarter." and v.action not like '%tat%' group by v.cycleid,v.action order by v.cycleid desc;";
		$query =$this->db->query($facl);
		return $result=$query->result_array();
	}

	function getDelimodePerformanceByQuarter($quarter=null){

		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}
		$sql="select v.delimode, max(if(v.action='dispatch',freqs,0)) as 'dispatch', max(if(v.action='response',freqs,0)) as 'return', max(if(v.action='passes',freqs,0)) as 'passes', max(if(v.action='fail',freqs,0)) as 'fail', max(if(v.action='ungraded',freqs,0)) as 'ungraded', max(if(v.action='unprocessed',freqs,0)) as 'unprocessed', max(if(v.action='good tat',freqs,0)) as 'goodtat', max(if(v.action='bad tat',freqs,0)) as 'badtat' from (SELECT vd.DeliveryMode as delimode,vd.action,vd.cycleid,dc.description,sum(vd.freqs) as freqs FROM v_dashboard3 vd, dtscycles dc where vd.cycleid=dc.id GROUP by vd.deliverymode, vd.cycleid, vd.action) as v where v.cycleid=".$quarter." group by v.cycleid,v.delimode order by v.cycleid desc";
		$query =$this->db->query($sql);
		return $result=$query->result_array();
	}

	public function getOwnerPerformanceByQuarter($quarter=null){
		if(!$quarter){
			$quarter=$this->getActiveCycle();
		}
		$sql="select v.Owner, max(if(v.action='dispatch',freqs,0)) as 'dispatch', max(if(v.action='response',freqs,0)) as 'return', max(if(v.action='passes',freqs,0)) as 'passes', max(if(v.action='fail',freqs,0)) as 'fail', max(if(v.action='ungraded',freqs,0)) as 'ungraded', max(if(v.action='good tat',freqs,0)) as 'goodtat', max(if(v.action='bad tat',freqs,0)) as 'badtat' from (SELECT vd.DeliMode as owner,vd.action,vd.cycleid,dc.description,sum(vd.freqs) as freqs FROM v_dashboard4 vd, dtscycles dc where vd.cycleid=dc.id GROUP by vd.delimode, vd.cycleid, vd.action) as v where v.cycleid=".$quarter." group by v.cycleid,v.owner order by v.cycleid desc;";
		$query =$this->db->query($sql);
		return $result=$query->result_array();
	}
	private function getActiveCycle(){
		$sql='SELECT * FROM dtscycles WHERE isactive=1';
		$query =$this->db->query($sql);
		$result=$query->row_array();
		return $result['id'];
	}
}