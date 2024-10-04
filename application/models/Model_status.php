<?php
class Model_status extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function getStatus(){
		$sql="SELECT status_id,status_description from status order by status_description ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}