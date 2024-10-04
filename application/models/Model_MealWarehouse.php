<?php
	/*
		model that manages the dashboard data updates
	*/
	class Model_MealWarehouse extends CI_Model 
	{

		public function insertPreliminaryData(){
			$cycles=$this->getCycleInDistribution();

			foreach ($cycles as $c):
				$data=$this->insertDynamicData($c['cycle']);
				//insertStaticData($c);
				if($data){ echo 'YES';}else {echo 'No';}
			endforeach;
		}

		private function getCycleInDistribution(){
			$sql="SELECT distinct cycle FROM distributions";
			$query =$this->db->query($sql);
			return $query->result_array();
		}

		private function insertDynamicData($c){
			$sql="select DISTINCTROW regionname as description,'Region' as category from v_distributions union SELECT distinctrow levelname as description, 'Level' as category FROM `v_distributions` union SELECT distinctrow deliverymode as description, 'Delivery Mode' as category FROM `v_distributions` union SELECT distinctrow owner as description, 'Owner' as category FROM `v_distributions` union SELECT `departmentname` as description, 'Department' as category FROM `department` WHERE id in(2,54,69,74) union select 'Other Departments' as description,'Department' as category union SELECT 'Medical Lab Personnel' as description,'Cadre' as category union SELECT 'Nurses & Midwives' as description,'Cadre' as category union SELECT 'Doctors & Clinical Officers' as description,'Cadre' as category union SELECT 'Lay Testers' as description,'Cadre' as category union SELECT 'PEPFAR' as description, 'affiliation' as category union SELECT 'NON-PEPFAR ' as description, 'affiliation' as category";
			$query =$this->db->query($sql);
			$output= $query->result_array();

			foreach($output as $o):
				$sql="INSERT IGNORE INTO _MealWarehouse (description,category,cycleid) VALUES('".$o['description']."','".$o['category']."',".$c.");";
				$query =$this->db->query($sql);
			endforeach;
		}


		///update the table _mealWarehouse
		public function getDispatched(){
			$sql="
				select regionname as description,'Region' as category,cycleid,count(tcode) as dispatched from v_distributions where cycleid=35 group by regionname,cycleid 
				UNION
				select levelname as description ,'Level' as category,cycleid,count(tcode) as dispatched from v_distributions where cycleid=35 group by levelname,cycleid
				union 
				SELECT deliverymode as description, 'Delivery Mode' as category,cycleid,count(tcode) as dispatched FROM `v_distributions` where cycleid=35 group by deliverymode,cycleid
				union 
				SELECT  owner as description, 'Owner' as category,cycleid,count(tcode) as dispatched FROM `v_distributions` where cycleid=35 group by owner,cycleid
				union
				SELECT departmentname as description, 'departmentname' as category,cycleid,count(tcode) as dispatched  FROM `v_distributions` WHERE departmentname='MAIN LAB' GROUP BY departmentname,cycleid
				union 
				SELECT departmentname as description, 'departmentname' as category,cycleid,count(tcode) as dispatched  FROM `v_distributions` WHERE departmentname='PMTCT' GROUP BY departmentname,cycleid
				UNION
				SELECT departmentname as description, 'departmentname' as category,cycleid,count(tcode) as dispatched  FROM `v_distributions` WHERE departmentname='OPD' GROUP BY departmentname,cycleid
				UNION
				SELECT departmentname as description, 'departmentname' as category,cycleid,count(tcode) as dispatched  FROM `v_distributions` WHERE departmentname = 'ANC/MATERNITY' GROUP BY departmentname,cycleid
				union 
				SELECT 'Others' as description, 'departmentname' as category,cycleid,count(tcode) as dispatched  FROM `v_distributions` WHERE departmentname not in ('ANC/MATERNITY','OPD','PMTCT', 'MAIN LAB') GROUP BY cycleid
				union
				SELECT 'Medical Lab Personnel' as description,'Cadre' as category,cycleid,count(d.tcode) as dispatched FROM v_distributions d, tester t, title ti, titlecategory tc WHERE d.tcode=t.tcode and t.title=ti.id and ti.titleCategory=tc.categoryId and d.cycleid=35 and tc.categoryId  in(1,2) group by d.cycleid
				union 
				SELECT tc.CategoryName as description,'Cadre' as category,cycleid,count(d.tcode) as dispatched FROM v_distributions d, tester t, title ti, titlecategory tc WHERE d.tcode=t.tcode and t.title=ti.id and ti.titleCategory=tc.categoryId and d.cycleid=35 and tc.categoryId not in(1,2) group by tc.CategoryName,d.cycleid";
				$query =$this->db->query($sql);
				$data = $query->result_array();

				$this->UpdateMealWarehouse('dispatched',$data);

		}

		//redo this method use scripts saved on desktop
		private function UpdateMealWarehouse($column,$data){
			foreach($data as $d):
				$h=$d['dispatched'];

				// $sql= "UPDATE update _MealWarehouse set $column=$h where description=$d['description'] and category=$d['category'] and cycleid=$d['cycleid'];";
				// $query =$this->db->query($sql);
			endforeach;
		}
	
	}