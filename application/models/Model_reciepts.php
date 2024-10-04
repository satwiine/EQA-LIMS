<?php
/**
 * 
 */
class Model_reciepts extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}


	public function getRecieptData($id=null){
		if($id) {
			$sql = "SELECT `id`,  DATE_FORMAT(`recieptdate`,'%e %M %Y') as recieptdate,  `recievedFrom`, `description` FROM `reciepts` where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT `id`, DATE_FORMAT(`recieptdate`,'%e %M %Y') as recieptdate, `recievedFrom`, `description` FROM `reciepts`";
		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
	
	public function countRecieptLines($id){
		if($id){
			$sql="SELECT `recieptid`, `itemid`, `quantity`, `store` FROM `recieptdetail` WHERE recieptid=?";
			$query =$this->db->query($sql,array($id));
			return $query->num_rows();
		}
	}

	public function createReciept($data){

		$insert = $this->db->insert('reciepts',$data);
		$reciept_id =$this->db->insert_id();

		
		return $reciept_id;
	}

	public function addLineItem($data){
		$insert = $this->db->insert('recieptdetail',$data);
	}

	public function addExpiringData($data){
		$insert_query=$this->db->insert_string('recieptexpirytracker',$data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$this->db->query($insert_query);

		//cleanup the items without expiry dates
		$sql="delete from recieptexpirytracker where expirydate='0000-00-00'";
		$this->db->query($sql);
	}


}