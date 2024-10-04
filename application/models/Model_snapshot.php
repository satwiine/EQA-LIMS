<?php
class Model_snapshot extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getSnapshotData($cycle=null){
		if($cycle){
			$sql='SELECT `testercode`, `testername`, `testercontact`, `cadre`, `cadrecategory`, `sitecode`, `sitename`, `facilitylevel`, `facilityowner`,`departmentname`,`facilitydistrict`, `facilityregion`,`cycleid`,`cycleyear`, `cycledescription`, `cyclename`, `dod`, `dsr`, `rxby`,`dtsr`, `dtst`,`daterxatuvri`, `formserial`,`approvedby`, `approvaldate`, `score`, `status`, `supervisorname`, `delimode`,"" as `comment` FROM EQAPT_Data_Warehouse.HIV_response_data_store where cycleid=? and sampleid not in(select sampleid from EQAPT_Data_Warehouse.hiv_comment_data_store)
				union 
				SELECT `testercode`, `testername`, `testercontact`, `cadre`, `cadrecategory`, `sitecode`, `sitename`, `facilitylevel`, `facilityowner`,`departmentname`,`facilitydistrict`, `facilityregion`,`cycleid`,`cycleyear`, `cycledescription`, `cyclename`, `dod`, `dsr`, `rxby`,`dtsr`, `dtst`,`daterxatuvri`, `formserial`,`approvedby`, `approvaldate`, `score`, `status`, `supervisorname`, `delimode`, "" as `comment` FROM EQAPT_Data_Warehouse.HIV_response_data_store hr, EQAPT_Data_Warehouse.hiv_comment_data_store cds  where hr.cycleid=? and hr.sampleid = cds.sampleid';
			$query =$this->db->query($sql,array($cycle));
		}
		else{
			$sql='SELECT `testercode`, `testername`, `testercontact`, `cadre`, `cadrecategory`, `sitecode`, `sitename`, `facilitylevel`, `facilityowner`,`departmentname`,`facilitydistrict`, `facilityregion`,`cycleid`,`cycleyear`, `cycledescription`, `cyclename`, `dod`, `dsr`, `rxby`,`dtsr`, `dtst`,`daterxatuvri`, `formserial`,`approvedby`, `approvaldate`, `score`, `status`, `supervisorname`, `delimode`,"" as `comment` FROM EQAPT_Data_Warehouse.HIV_response_data_store  where sampleid not in (select sampleid from  EQAPT_Data_Warehouse.hiv_comment_data_store)
				union 
				SELECT `testercode`, `testername`, `testercontact`, `cadre`, `cadrecategory`, `sitecode`, `sitename`, `facilitylevel`, `facilityowner`,`departmentname`,`facilitydistrict`, `facilityregion`,`cycleid`,`cycleyear`, `cycledescription`, `cyclename`, `dod`, `dsr`, `rxby`,`dtsr`, `dtst`,`daterxatuvri`, `formserial`,`approvedby`, `approvaldate`, `score`, `status`, `supervisorname`, `delimode`, cds.comment FROM EQAPT_Data_Warehouse.HIV_response_data_store hr, EQAPT_Data_Warehouse.hiv_comment_data_store cds where cds.sampleid=hr.sampleid';
			$query =$this->db->query($sql);
		}
		return $query->result_array();
	}

	public function getHivResultSnapshotData($cycle=null){
		if($cycle){
			$sql='SELECT hr.testercode, hr.testername, hr.testercontact, hr.cadre, hr.cadrecategory, hr.sitecode, hr.sitename, hr.facilitylevel, hr.facilityowner, hr.departmentname, hr.facilitydistrict, hr.facilityregion,hr.cycleid, hr.cycleyear, hr.cycledescription, hr.cyclename, hr.dod, hr.dsr, hr.rxby,hr.dtsr, hr.dtst, hr.daterxatuvri, hr.formserial, hr.approvedby, hr.approvaldate, hr.score, hr.status, hr.supervisorname, hr.delimode, hres.panelid,hres.Screening, hres.Confirmatory, hres.Tiebreaker, hres.Finalresult,"" as comment FROM EQAPT_Data_Warehouse.HIV_response_data_store hr, EQAPT_Data_Warehouse.HIV_Resullts_Data_Store hres where hres.sampleid=hr.sampleid and hr.cycleid=? and hr.sampleid not in(select sampleid from hiv_comment_data_store)
				union
				SELECT hr.testercode, hr.testername, hr.testercontact, hr.cadre, hr.cadrecategory, hr.sitecode, hr.sitename, hr.facilitylevel, hr.facilityowner, hr.departmentname, hr.facilitydistrict, hr.facilityregion,hr.cycleid, hr.cycleyear, hr.cycledescription, hr.cyclename, hr.dod, hr.dsr, hr.rxby,hr.dtsr, hr.dtst, hr.daterxatuvri, hr.formserial, hr.approvedby, hr.approvaldate, hr.score, hr.status, hr.supervisorname, hr.delimode, hres.panelid,hres.Screening, hres.Confirmatory, hres.Tiebreaker, hres.Finalresult,cds.comment FROM EQAPT_Data_Warehouse.HIV_response_data_store hr, EQAPT_Data_Warehouse.HIV_Resullts_Data_Store hres, EQAPT_Data_Warehouse.hiv_comment_data_store cds  where hres.sampleid=hr.sampleid and hr.cycleid=? and cds.sampleid=hres.sampleid';
			$query =$this->db->query($sql,array($cycle));
		}
		else {
			$sql='SELECT hr.testercode, hr.testername, hr.testercontact, hr.cadre, hr.cadrecategory, hr.sitecode, hr.sitename, hr.facilitylevel, hr.facilityowner, hr.departmentname, hr.facilitydistrict, hr.facilityregion,hr.cycleid, hr.cycleyear, hr.cycledescription, hr.cyclename, hr.dod, hr.dsr, hr.rxby,hr.dtsr, hr.dtst, hr.daterxatuvri, hr.formserial, hr.approvedby, hr.approvaldate, hr.score, hr.status, hr.supervisorname, hr.delimode, hres.panelid,hres.Screening, hres.Confirmatory, hres.Tiebreaker, hres.Finalresult, "" as `comment` FROM EQAPT_Data_Warehouse.HIV_response_data_store hr, EQAPT_Data_Warehouse.HIV_Resullts_Data_Store hres where hres.sampleid=hr.sampleid and hr.sampleid not in(select sampleid from EQAPT_Data_Warehouse.hiv_comment_data_store)
				union 
				SELECT hr.testercode, hr.testername, hr.testercontact, hr.cadre, hr.cadrecategory, hr.sitecode, hr.sitename, hr.facilitylevel, hr.facilityowner, hr.departmentname, hr.facilitydistrict, hr.facilityregion,hr.cycleid, hr.cycleyear, hr.cycledescription, hr.cyclename, hr.dod, hr.dsr, hr.rxby,hr.dtsr, hr.dtst, hr.daterxatuvri, hr.formserial, hr.approvedby, hr.approvaldate, hr.score, hr.status, hr.supervisorname, hr.delimode, hres.panelid,hres.Screening, hres.Confirmatory, hres.Tiebreaker, hres.Finalresult, cds.comment FROM EQAPT_Data_Warehouse.HIV_response_data_store hr, EQAPT_Data_Warehouse.HIV_Resullts_Data_Store hres, EQAPT_Data_Warehouse.hiv_comment_data_store cds where hres.sampleid=hr.sampleid and hr.sampleid and hr.sampleid=cds.sampleid';
			$query =$this->db->query($sql);
		}

		return $query->result_array();
	}
}

