<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
    class Import extends CI_Model {
 
        public function __construct()
        {
            $this->load->database();
        }
        
        public function importData($data) {
  
            $res = $this->db->insert_batch('distributions',$data);
            if($res){
                return TRUE;
            }else{
                return FALSE;
            }
      
        }


        public function updateBatch($data){
            foreach($data as $d):
                $this->db->where('sitecode', $data['old_sitecode']);
                $this->db->where('testercode',$data['testercode']);
                $d=array('sitecode' =>$data['new_sitecode'],'testercode'=>$data['testercode'],'dept'=>$data['dept'],'status'=>1,'acted_on_by'=>$_SESSION['id'] );

                $this->db->update('sitetester',$d);
            endforeach;
        }
    }
?>