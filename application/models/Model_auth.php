<?php
/**
 * 
 */
class Model_auth extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function check_username($username){
		if($username){
			$sql='SELECT * FROM user WHERE username=?';
			$query =$this->db->query($sql,array($username));
			$result = $query->num_rows();
			return($result==1) ? true : false;
		}
		return false;
	}

	/*
	Method to login , verifys username and password match what is in the database
	*/

	public function login($username,$password){
		if($username && $password){
			$hash_password=sha1(md5($password));
			$sql='SELECT u.userid,u.username,u.userpass,u.fname,u.lname, u.email,u.usercategory,uc.user_cat_name,ucg.user_cat_group_name from user u, usercategory uc, usercategorygroup ucg where ucg.user_cat_group_id=uc.user_cat_group_id and u.usercategory=uc.user_cat_id and u.username=? and u.userpass=?';
			$query =$this->db->query($sql,array($username,$hash_password));
			
			if($query->num_rows()==1){
				$result = $query->row_array();
				return $result;
			}
			else
			{
				return false;
			}
		}
	}
}