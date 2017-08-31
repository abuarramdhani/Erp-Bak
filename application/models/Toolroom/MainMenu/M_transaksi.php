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
						- (select coalesce(sum(ttl.item_qty), 0) from tr.tr_transaction_list ttl where ttl.item_id=tmi.item_id and ttl.status='0')
					) stok 
					from tr.tr_master_item tmi where tmi.item_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function listOutITem($user){
			$sql = "select *,
					((
						(select tmi.item_qty from tr.tr_master_item tmi where tmi.item_id=tlt.item_id)
						- (select coalesce(sum(ttl.item_qty), 0) from tr.tr_transaction_list ttl where ttl.item_id=tlt.item_id and ttl.status='0')
					) - tlt.item_qty) sisa_stok from tr.tr_log_transaction tlt where tlt.transaction_id='0' and tlt.user_id='$user' order by tlt.item_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function listOutITemUpdate($user,$id){
			$sql = "select ttl.transaction_list_id,ttl.transaction_id,ttl.item_id,tmi.item_name,tmi.item_qty,sum(ttl.item_qty) item_dipakai,(tmi.item_qty-
												(select coalesce(sum(ttl2.item_qty),0) from tr.tr_transaction_list ttl2 where ttl2.status='0' and ttl2.item_id=ttl.item_id)-
												(select coalesce(sum(tlt2.item_qty),0) from tr.tr_log_transaction tlt2 where tlt2.item_id=ttl.item_id and tlt2.user_id='$user')
											) sisa_stok
					from tr.tr_transaction_list ttl
					join tr.tr_master_item tmi on tmi.item_id=ttl.item_id
					where ttl.transaction_id='$id'
					group by ttl.item_id,tmi.item_name,tmi.item_qty,ttl.transaction_id,ttl.transaction_list_id
					union
					select NULL AS \"transaction_list_id\",tlt.transaction_id,tlt.item_id,tlt.item_name,tmi.item_qty,tlt.item_qty,(tmi.item_qty-
												(select coalesce(sum(ttl2.item_qty),0) from tr.tr_transaction_list ttl2 where ttl2.status='0' and ttl2.item_id=tlt.item_id)-
												(select coalesce(sum(tlt2.item_qty),0) from tr.tr_log_transaction tlt2 where tlt2.item_id=tlt.item_id and tlt2.user_id='$user')
											) sisa_stok 
					from tr.tr_log_transaction tlt
					join tr.tr_master_item tmi on tmi.item_id=tlt.item_id
					where tlt.transaction_id='$id' and tlt.user_id='$user'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function deleteLog($item_id=FALSE,$id_trs,$user){
			if($item_id === FALSE){
				$sql = "delete from tr.tr_log_transaction where  and transaction_id='$id_trs' and user_id='$user'";
			}else{
				$sql = "delete from tr.tr_log_transaction where item_id='$item_id'  and transaction_id='$id_trs' and user_id='$user'";
			}	
			$query = $this->db->query($sql);
			return ;
		}
		
		public function deleteList($id,$id_trs,$user){
			$sql = "delete from tr.tr_transaction_list where transaction_id='$id_trs' and item_id='$id'";
			$query = $this->db->query($sql);
			return ;
		}
		
		public function deleteLogAll($id_trs,$user){
			$sql = "delete from tr.tr_log_transaction where  transaction_id='$id_trs' and user_id='$user'";
			$query = $this->db->query($sql);
			return ;
		}
		
		
		public function checkLog($id,$user,$type){
			$sql = "select * from tr.tr_log_transaction where item_id='$id' and user_id='$user' and transaction_id='$type'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function saveLog($id,$name,$user,$type){
			$sql = "insert into tr.tr_log_transaction values ('$id','$name','1','$type','$user')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function updateLog($id,$user,$type){
			$sql = "update tr.tr_log_transaction set item_qty=item_qty+1 where item_id='$id' and user_id='$user' and transaction_id='$type'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function getName($id){
			$personalia = $this->load->database('personalia',true);
			$sql = "select nama from hrd_khs.tpribadi where noind='$id' and keluar='0'";
			$query = $personalia->query($sql);
			return $query->row();
		}
		
		public function insertLending($noind,$user,$date,$shift,$name,$toolman){
			$sql = "insert into tr.tr_transaction (noind,creation_date,created_by,shift,name,toolman) values ('$noind','$date','$user','$shift','$name','$toolman')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,$item_out,$id_transaction){
			$sql = "insert into tr.tr_transaction_list (transaction_id,item_id,item_qty,status,date_lend) values ('$id_transaction','$item_id','$item_out','0','$date')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function ListOutGroupTransaction(){
			$sql = "select * from tr.tr_transaction tt 
					where 
					(select count(ttl.status) from tr.tr_transaction_list ttl where ttl.status='0' and ttl.transaction_id=tt.id_transaction)!='0'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function ListOutTransaction($id=FALSE,$date=FALSE){
			$user_id = $this->session->userid;
			if($id === FALSE && $date === FALSE){
				$sql = "select ttl.transaction_id,ttl.item_id,tmi.item_name,tmi.item_qty,(tmi.item_qty-
							(select sum(ttl2.item_qty) from tr.tr_transaction_list ttl2 where ttl2.status='0' and ttl2.item_id=ttl.item_id)
						) item_sisa,sum(ttl.item_qty) item_dipakai,ttl.status 
						from tr.tr_transaction_list ttl
						join tr.tr_master_item tmi on tmi.item_id=ttl.item_id
						where date_trunc('day', date_lend)=current_date and ttl.status='0'
						group by ttl.transaction_id,ttl.item_id,ttl.item_qty,ttl.status,tmi.item_qty,tmi.item_name";
			}else{
				$sql = "select ttl.transaction_id,ttl.item_id,tmi.item_name,tmi.item_qty,sum(ttl.item_qty) item_dipakai,(tmi.item_qty-
												(select coalesce(sum(ttl2.item_qty),0) from tr.tr_transaction_list ttl2 where ttl2.status='0' and ttl2.item_id=ttl.item_id)-
												(select coalesce(sum(tlt2.item_qty),0) from tr.tr_log_transaction tlt2 where tlt2.item_id=ttl.item_id and tlt2.user_id='$user_id')
											) item_sisa
					from tr.tr_transaction_list ttl
					join tr.tr_master_item tmi on tmi.item_id=ttl.item_id
					where ttl.transaction_id='$id'
					group by ttl.item_id,tmi.item_name,tmi.item_qty,ttl.transaction_id";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function addItemLending($id,$date){
			$sql = "update tr.tr_transaction_list set status='1' , date_return='$date'
					where date_trunc('day', date_lend)=current_date 
					and item_id='$id' 
					and transaction_list_id=(select max(transaction_list_id) from tr.tr_transaction_list where date_trunc('day', date_lend)=current_date and item_id='$id' and status='0')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function removeGroupTransaction($id,$date){
			$sql = "delete from tr.tr_transaction where id_transaction='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function removeTransactionList($id,$date){
			$sql = "delete from tr.tr_transaction_list where transaction_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function getNoindTransaction($id){
			$sql = "select * from tr.tr_transaction where id_transaction='$id'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function updateLending($noind,$user,$date,$id,$shift){
			$sql = "update tr.tr_transaction set noind='$noind' , last_update_date='$date',last_updated_by='$user',shift='$shift' where id_transaction='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function getShift($id){
			$sql = "select * from tr.tr_transaction where id_transaction='$id'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function getToolman($user){
			$sql = "select employee_name from sys.vi_sys_user_data where user_name='$user'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
}