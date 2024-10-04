<?php
/**
 * 
 */
class Model_items extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getActiveItems(){
		$sql="SELECT itemid, itemCategory, itemDescription, attribute_value_id, itemExpires, ItemGroup, availability,quantity FROM item WHERE availability=?";
		$query=$this->db->query($sql,array(1));
		return $query->result_array();
	}

	public function getItemData($id = null){
		if($id){
			$sql ="SELECT i.itemid, i.itemCategory, i.itemDescription, i.attribute_value_id, i.itemExpires, i.ItemGroup,i.quantity,v.qty,(i.quantity-v.qty) as available_to_request FROM item i, v_requests_pending_issue v WHERE i.itemid = v.itemid and i.itemid=?";
			$query=$this->db->query($sql,array($id));
			return $query->row_array();
		}
	}

	public function getItems($id =null){
		if($id){
			$sql="SELECT itemid,itemDescription,itemCatDescription,itemExpires,ItemGroup,value_name,quantity FROM v_items where itemid=?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		else{
			$sql = "SELECT itemid,itemDescription,itemCatDescription,itemExpires,ItemGroup,value_name,quantity FROM v_items order by itemcatdescription,itemDescription ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
			}
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('item', $data);
			return ($insert == true) ? true : false;
		}
	}
	

	public function fetchItems(){
		
			$sql ="select i.itemid,i.itemCategory, i.itemDescription, i.attribute_value_id, i.itemExpires, i.ItemGroup, i.availability,av.parent_id ,av.id,av.value_name, a.attribute_name from item i, attribute_value av, attributes a where i.attribute_value_id=av.id and av.parent_id=a.id";
			$query=$this->db->query($sql);
			return $query->result_array();
		
	}


	public function fetchAtributeValuesByItemId($id){
		if($id){
			$sql='SELECT * FROM `attribute_value` WHERE `parent_id` in (select parent_id from view_item_detail where itemid=?)';
			$query=$this->db->query($sql,array($id));
			return $query->result_array();
		}
	}
}