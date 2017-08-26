<?php
class M_transaksi extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function getNoind($q){
			$personalia = $this->load->database("personalia",true);
			$sql = "select noind,nama from hrd_khs.tpribadi where keluar='0' and noind like '%$q%'";
			$query = $personalia->query($sql);
			return $query->result_array();
		}
		
		public function getItem($q){
			$sql = "select * from tr.tr_master_item where item_id like '%$q%' or item_name like '%$q%'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function checkStokItem($id){
			$sql = "select tmi.item_id,tmi.item_name,
					(
						tmi.item_qty 
						- (select coalesce(sum(tlt.item_qty), 0) from tr.tr_log_transaction tlt where tlt.item_id=tmi.item_id)
						- (select coalesce(sum(ttl.item_qty), 0) from tr.tr_transaction_list ttl where ttl.item_id=tmi.item_id and ttl.status='0')
					) stok 
					from tr.tr_master_item tmi where tmi.item_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function listOutITem(){
			$sql = "select *,
					((
						(select tmi.item_qty from tr.tr_master_item tmi where tmi.item_id=tlt.item_id)
						- (select coalesce(sum(ttl.item_qty), 0) from tr.tr_transaction_list ttl where ttl.item_id=tlt.item_id and ttl.status='0')
					) - tlt.item_qty) sisa_stok from tr.tr_log_transaction tlt";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function deleteLog($item_id=FALSE){
			if($item_id === FALSE){
				$sql = "delete from tr.tr_log_transaction";
			}else{
				$sql = "delete from tr.tr_log_transaction where item_id='$item_id'";
			}	
			$query = $this->db->query($sql);
			return ;
		}
		
		public function checkLog($id){
			$sql = "select * from tr.tr_log_transaction where item_id='$id'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function saveLog($id,$name){
			$sql = "insert into tr.tr_log_transaction values ('$id','$name','1')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function updateLog($id){
			$sql = "update tr.tr_log_transaction set item_qty=item_qty+1 where item_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
}