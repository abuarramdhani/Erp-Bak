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
		
		public function admin_check(){
			$sql = "select * from wh.wh_user_admin";
			$query = $this->db->query($sql);
			$data = $query->result_array();

			$so = array();
			foreach ($data as $values) {
				$so[] = $values['no_induk'];
			}
			return $so;
		}

		public function getItem($q){
			$sql = "select * from wh.wh_master_item where item_id like '%$q%' or item_name like '%$q%'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function getItemConsumable($q){
			$sql = "select * from wh.wh_master_item_consumable where item_code like '%$q%' or item_name like '%$q%'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function checkStokItem($id){
			$sql = "select tmi.item_id,tmi.item_name,
					(
						tmi.item_qty 
						- (select coalesce(sum(ttl.item_qty)-sum(ttl.item_qty_return), 0) from wh.wh_transaction_list ttl where ttl.item_id=tmi.item_id and ttl.status='0')
					) stok 
					from wh.wh_master_item tmi where tmi.item_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function checkStokItemConsumable($id){
			$sql = "select tmi.item_code, tmi.item_name, tmi.consumable_id,
					(
						tmi.item_qty 
						- (select coalesce(sum(ttl.item_qty)-sum(ttl.item_qty_return), 0) from wh.wh_transaction_list ttl where ttl.item_id=tmi.item_code and ttl.status='0')
					) stok 
					from wh.wh_master_item_consumable tmi where tmi.item_code = '$id' ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function listOutITem($user){
			$sql = "select *,
					((
						(select tmi.item_qty from wh.wh_master_item tmi where tmi.item_id=tlt.item_id)
						- (select coalesce(sum(ttl.item_qty), 0) from wh.wh_transaction_list ttl where ttl.item_id=tlt.item_id and ttl.status='0')
					) - 0) sisa_stok from wh.wh_log_transaction tlt where tlt.transaction_id='0' and tlt.user_id='$user' order by tlt.item_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function listOutITemUpdate($user,$id){
			$sql = "select ttl.transaction_list_id,ttl.transaction_id,ttl.item_id,tmi.item_name,tmi.item_qty,sum(ttl.item_qty) item_dipakai,(tmi.item_qty-
												(select coalesce(sum(ttl2.item_qty),0) from wh.wh_transaction_list ttl2 where ttl2.status='0' and ttl2.item_id=ttl.item_id)-
												(select coalesce(sum(tlt2.item_qty),0) from wh.wh_log_transaction tlt2 where tlt2.item_id=ttl.item_id and tlt2.user_id='$user')
											) sisa_stok
					from wh.wh_transaction_list ttl
					join wh.wh_master_item tmi on tmi.item_id=ttl.item_id
					where ttl.transaction_id='$id'
					group by ttl.item_id,tmi.item_name,tmi.item_qty,ttl.transaction_id,ttl.transaction_list_id
					union
					select NULL AS \"transaction_list_id\",tlt.transaction_id,tlt.item_id,tlt.item_name,tmi.item_qty,tlt.item_qty,(tmi.item_qty-
												(select coalesce(sum(ttl2.item_qty),0) from wh.wh_transaction_list ttl2 where ttl2.status='0' and ttl2.item_id=tlt.item_id)-
												(select coalesce(sum(tlt2.item_qty),0) from wh.wh_log_transaction tlt2 where tlt2.item_id=tlt.item_id and tlt2.user_id='$user')
											) sisa_stok 
					from wh.wh_log_transaction tlt
					join wh.wh_master_item tmi on tmi.item_id=tlt.item_id
					where tlt.transaction_id='$id' and tlt.user_id='$user'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function listOutITemConsumable($user){
			$sql = "select *,
					((
						(select tmi.item_qty from wh.wh_master_item_consumable tmi where tmi.item_code=tlt.item_code)
						- (select coalesce(sum(ttl.item_qty), 0) from wh.wh_transaction_list ttl where ttl.item_id=tlt.item_code and ttl.status='0')
					) - tlt.item_qty) sisa_stok from wh.wh_log_transaction_consumable tlt where tlt.transaction_id='0' and tlt.user_id='$user' order by tlt.item_code";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function listOutITemUpdateConsumable($user,$id){
			$sql = "select ttl.transaction_list_id,ttl.transaction_id,ttl.item_code,tmi.item_name,tmi.item_qty,sum(ttl.item_qty) item_dipakai,(tmi.item_qty-
												(select coalesce(sum(ttl2.item_qty),0) from wh.wh_transaction_list ttl2 where ttl2.status='0' and ttl2.item_id=ttl.item_code)-
												(select coalesce(sum(tlt2.item_qty),0) from wh.wh_log_transaction_consumable tlt2 where tlt2.item_code=ttl.item_code and tlt2.user_id='$user')
											) sisa_stok
					from wh.wh_transaction_list ttl
					join wh.wh_master_item tmi on tmi.item_code=ttl.item_code
					where ttl.transaction_id='$id'
					group by ttl.item_id,tmi.item_name,tmi.item_qty,ttl.transaction_id,ttl.transaction_list_id
					union
					select NULL AS \"transaction_list_id\",tlt.transaction_id,tlt.item_code,tlt.item_name,tmi.item_qty,tlt.item_qty,(tmi.item_qty-
												(select coalesce(sum(ttl2.item_qty),0) from wh.wh_transaction_list ttl2 where ttl2.status='0' and ttl2.item_code=tlt.item_code)-
												(select coalesce(sum(tlt2.item_qty),0) from wh.wh_log_transaction tlt2 where tlt2.item_code=tlt.item_code and tlt2.user_id='$user')
											) sisa_stok 
					from wh.wh_log_transaction_consumable tlt
					join wh.wh_master_item_consumable tmi on tmi.item_code=tlt.item_code
					where tlt.transaction_id='$id' and tlt.user_id='$user'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function deleteLog($item_id=FALSE,$id_trs,$user){
			if($item_id === FALSE){
				$sql = "delete from wh.wh_log_transaction where  and transaction_id='$id_trs' and user_id='$user'";
			}else{
				$sql = "delete from wh.wh_log_transaction where item_id='$item_id'  and transaction_id='$id_trs' and user_id='$user'";
			}	
			$query = $this->db->query($sql);
			return ;
		}
		
		public function deleteList($id,$id_trs,$user){
			$sql = "delete from wh.wh_transaction_list where transaction_id='$id_trs' and item_id='$id'";
			$query = $this->db->query($sql);
			return ;
		}
		
		public function deleteLogAll($id_trs,$user){
			$sql = "delete from wh.wh_log_transaction where  transaction_id='$id_trs' and user_id='$user'";
			$query = $this->db->query($sql);
			return ;
		}

		public function checkLog($id,$user,$type){
			$sql = "select * from wh.wh_log_transaction where item_id='$id' and user_id='$user' and transaction_id='$type'";
			$query = $this->db->query($sql);
			return $query->row();
		}

		public function deleteLogConsumable($item_id=FALSE,$id_trs,$user){
			if($item_id === FALSE){
				$sql = "delete from wh.wh_log_transaction_consumable where  and transaction_id='$id_trs' and user_id='$user'";
			}else{
				$sql = "delete from wh.wh_log_transaction_consumable where item_code='$item_id'  and transaction_id='$id_trs' and user_id='$user'";
			}	
			$query = $this->db->query($sql);
			return ;
		}
		
		public function deleteListConsumable($id,$id_trs,$user){
			$sql = "delete from wh.wh_log_transaction_consumable where transaction_id='$id_trs' and item_id='$id'";
			$query = $this->db->query($sql);
			return ;
		}
		
		public function deleteLogAllConsumable($id_trs,$user){
			$sql = "delete from wh.wh_log_transaction_consumable where  transaction_id='$id_trs' and user_id='$user'";
			$query = $this->db->query($sql);
			return ;
		}
		
		
		public function checkLogConsumable($id,$user,$type){
			$sql = "select * from wh.wh_log_transaction_consumable where item_id='$id' and user_id='$user' and transaction_id='$type'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function saveLog($id,$name,$user,$type){
			$sql = "insert into wh.wh_log_transaction values ('$id','$name','1','$type','$user')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function updateLog($id,$user,$type){
			$sql = "update wh.wh_log_transaction set item_qty=item_qty+1 where item_id='$id' and user_id='$user' and transaction_id='$type'";
			$query = $this->db->query($sql);
			return;
		}

		public function saveLogConsumable($id,$name,$user,$type){
			$sql = "insert into wh.wh_log_transaction_consumable values ('$id','$name','1','$type','$user')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function updateLogConsumable($id,$user,$type){
			$sql = "update wh.wh_log_transaction_consumable set item_qty=item_qty+1 where item_id='$id' and user_id='$user' and transaction_id='$type'";
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
			$sql = "insert into wh.wh_transaction (noind,creation_date,created_by,shift,name,toolman,usable) values ('$noind','$date','$user','$shift','$name','$toolman','Y')";
			$query = $this->db->query($sql);
			return;
		}

		public function insertLendingConsumable($noind,$user,$date,$shift,$name,$toolman){
			$sql = "insert into wh.wh_transaction (noind,creation_date,created_by,shift,name,toolman) values ('$noind','$date','$user','$shift','$name','$toolman')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,$item_out,$id_transaction){
			$sql = "insert into wh.wh_transaction_list (transaction_id,item_id,item_qty,status,date_lend,item_awl,item_akh,item_qty_return) values ('$id_transaction','$item_id','$item_out','0','$date','$item_out','$sisa_stok','0')";
			$query = $this->db->query($sql);
			return;
		}
		
		public function ListOutGroupTransaction(){
			// $sql = "select * from wh.wh_transaction tt , wh.wh_transaction_list tl
			// 		where tl.transaction_id = tt.id_transaction and 
			// 		(select count(ttl.status) from wh.wh_transaction_list ttl where ttl.status='0' and ttl.transaction_id=tt.id_transaction)!='0' and usable = 'Y'";
			$sql = "select wt.noind noind,wt.id_transaction , wt.\"name\", wt.shift, wt.toolman, wt.creation_date, tl.item_id, tl.item_qty, item_qty_return
				from wh.wh_transaction_list tl, wh.wh_master_item mi, wh.wh_transaction wt 
				where tl.item_id = mi.item_id
				and tl.transaction_id = wt.id_transaction
				and wt.usable = 'Y'
				and tl.item_qty is not null	
				and tl.status = '0'";

			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function ListOutGroupTransactionConsumable(){
			$sql = "select * from wh.wh_transaction tt , wh.wh_transaction_list tl
					where tl.transaction_id = tt.id_transaction and 
					(select count(ttl.status) from wh.wh_transaction_list ttl where ttl.status='0' and ttl.transaction_id=tt.id_transaction)!='0' and usable = 'N'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function ListOutTransactionPengembalian($id=FALSE){
			$user_id = $this->session->userid;
			if($id === FALSE || $id===''){
				$sql = "select ttl.item_id,tmi.item_name,max(ttl.item_awl) item_qty,sum(ttl.item_qty) item_dipakai,min(ttl.item_akh) item_sisa,sum(ttl.item_qty_return) item_qty_return ,ttl.status
						from wh.wh_transaction_list ttl
						join wh.wh_master_item tmi on tmi.item_id=ttl.item_id
						where /* date_trunc('day', ttl.date_lend)=current_date and */ ttl.status='0'
						group by ttl.item_id,tmi.item_name,ttl.status
						order by ttl.item_id";
			}else{
				$sql = "select ttl.transaction_id,ttl.item_id,tmi.item_name,(ttl.item_awl) item_qty,(ttl.item_qty) item_dipakai,(ttl.item_akh) item_sisa,ttl.item_qty_return,ttl.status
					from wh.wh_transaction_list ttl
					join wh.wh_master_item tmi on tmi.item_id=ttl.item_id
					where ttl.transaction_id='$id' and status='0'
					order by ttl.item_id";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function ListOutTransactionDetail($id=FALSE){
			if($id === FALSE || $id===''){
				$sql = "	CASE WHEN tl.date_lend is null THEN tl.date_return else tl.date_lend END tgl_transaksi, select  tl.transaction_list_id, wt.id_transaction ,mi.item_id , mi.item_name ,mi.item_qty, COALESCE(tl.item_qty, 0 ) qty_pinjam, tl.item_qty_return qty_kembali, tl.item_awl awal,COALESCE(mi.item_qty - sum(tl.item_qty) + sum(tl.item_qty_return),0) item_sisa 
				from wh.wh_transaction_list tl, wh.wh_master_item mi, wh.wh_transaction wt 
				where tl.item_id = mi.item_id
				and tl.transaction_id = wt.id_transaction
				and wt.usable = 'Y'
				and tl.status = '0'
				group by tl.date_lend,tl.date_return,tl.transaction_list_id,wt.id_transaction ,mi.item_id , mi.item_name ,mi.item_qty,tl.item_qty,tl.item_qty_return,tl.item_awl
				order by tl.transaction_list_id desc;";
			}else{
				$sql = "	select CASE WHEN tl.date_lend is null THEN tl.date_return else tl.date_lend END tgl_transaksi, tl.transaction_list_id, wt.id_transaction ,mi.item_id , mi.item_name ,mi.item_qty, COALESCE(tl.item_qty, 0 ) qty_pinjam, tl.item_qty_return qty_kembali, tl.item_awl awal,COALESCE(mi.item_qty - sum(tl.item_qty) + sum(tl.item_qty_return),0) item_sisa 
				from wh.wh_transaction_list tl, wh.wh_master_item mi, wh.wh_transaction wt 
				where tl.item_id = mi.item_id
				and tl.transaction_id = wt.id_transaction
				and wt.usable = 'Y'
				and tl.transaction_id = '$id'
				and tl.status = '0'
				group by tl.date_lend,tl.date_return,tl.transaction_list_id,wt.id_transaction ,mi.item_id , mi.item_name ,mi.item_qty,tl.item_qty,tl.item_qty_return,tl.item_awl
				order by tl.transaction_list_id desc;";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function ListOutTransaction($id=FALSE){
			$user_id = $this->session->userid;
			if($id === FALSE || $id===''){
				$sql = "select
						ttl.item_id,
						tmi.item_name,
						sum(ttl.item_qty) item_qty,
						sum(ttl.item_qty) - sum(ttl.item_qty_return) item_dipakai,
						 tmi.item_qty-( select max(ttl.item_qty_return) from wh.wh_transaction_list ttl) item_sisa,
						sum(ttl.item_qty_return) item_qty_return ,
						ttl.status
					from
						wh.wh_transaction_list ttl
					join wh.wh_master_item tmi on
						tmi.item_id = ttl.item_id
					where
						/* date_trunc('day', ttl.date_lend)=current_date and */
						ttl.status = '0'
					group by
						ttl.item_id,
						tmi.item_name,
						ttl.status,
						tmi.item_qty
					order by
						ttl.item_id";
			}else{
				$sql = "
				select  tl.transaction_list_id, CASE WHEN tl.date_lend is null THEN tl.date_return else tl.date_lend END tgl_transaksi,tl.transaction_list_id, wt.id_transaction ,mi.item_id , mi.item_name ,mi.item_qty, COALESCE(tl.item_qty, 0 ) qty_pinjam, tl.item_qty_return qty_kembali, tl.item_awl awal 
			from wh.wh_transaction_list tl, wh.wh_master_item mi, wh.wh_transaction wt 
			where tl.item_id = mi.item_id
			and tl.transaction_id = wt.id_transaction
			and wt.usable = 'Y'
			and wt.noind = '$id'
			and tl.status = '0'
			order by tl.transaction_list_id desc;";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function ListOutTransactionConsumable($id=FALSE){
			$user_id = $this->session->userid;
			if($id === FALSE || $id===''){
				$sql = "select ttl.item_id,tmi.item_name,max(ttl.item_awl) item_qty,sum(ttl.item_qty) item_dipakai,min(ttl.item_akh) item_sisa,sum(ttl.item_qty_return) item_qty_return ,ttl.status
						from wh.wh_transaction_list ttl
						join wh.wh_master_item_consumable tmi on tmi.item_code=ttl.item_id
						where /* date_trunc('day', ttl.date_lend)=current_date and */ ttl.status='0'
						group by ttl.item_id,tmi.item_name,ttl.status
						order by ttl.item_id";
			}else{
				$sql = "select ttl.transaction_id,ttl.item_id,tmi.item_name,(ttl.item_awl) item_dipakai,(ttl.item_qty) item_sisa,(ttl.item_akh) item_sisa,ttl.item_qty_return,ttl.status
					from wh.wh_transaction_list ttl
					join wh.wh_master_item_consumable tmi on tmi.item_code=ttl.item_id
					where ttl.transaction_id='$id' and status='0'
					order by ttl.item_id";
			}
			
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function addItemLending($id,$trans=FALSE,$date,$datenow,$all,$txtQtyKembali){
			if($trans == FALSE){
				$sql = "update wh.wh_transaction_list set status = (CASE
						WHEN item_qty_return=item_qty-1 THEN '1' else status
						END),date_return='$datenow',item_qty_return=(CASE
						WHEN item_qty_return<item_qty THEN item_qty_return+$txtQtyKembali else item_qty_return
						END) where $all item_id='$id' and status='0' and transaction_list_id=(select min(transaction_list_id) from wh.wh_transaction_list where $all item_id='$id' and status='0')";
			}else{
				$sql = "update  wh.wh_transaction_list set status = (CASE
						WHEN item_qty_return=item_qty-1 THEN '1' else status
						END),date_return='$datenow',item_qty_return=(CASE
						WHEN item_qty_return<item_qty THEN item_qty_return+$txtQtyKembali else item_qty_return
						END)  where date_trunc('second', date_lend)='$date' 
						and item_id='$id' and transaction_id='$trans'";
			}


			$query = $this->db->query($sql);
			return;
		}
		
		public function removeGroupTransaction($id,$date){
			$sql = "delete from wh.wh_transaction where id_transaction='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function removeTransactionList($id,$date){
			$sql = "delete from wh.wh_transaction_list where transaction_id='$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function getNoindTransaction($id){
			$sql = "select * from wh.wh_transaction where id_transaction='$id'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function updateLending($noind,$user,$date,$id,$shift){
			$sql = "update wh.wh_transaction set noind='$noind' , last_update_date='$date',last_updated_by='$user',shift='$shift' where id_transaction='$id'";
			$query = $this->db->query($sql);
			return;
		}

		public function updateLendingList($id,$item_out){
			$sql = "update wh.wh_transaction_list set item_qty = '$item_out' where transaction_id = '$id'";
			$query = $this->db->query($sql);
			return;
		}
		
		public function getShift($id){
			$sql = "select * from wh.wh_transaction where id_transaction='$id'";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		public function getToolman($user){
			$sql = "select employee_name from sys.vi_sys_user_data where user_name='$user'";
			$query = $this->db->query($sql);
			return $query->row();
		}

		public function getTransId($induk){
			$sql = "SELECT id_transaction FROM wh.wh_transaction WHERE noind = '$induk'";
			$data = $this->db->query($sql);
			return $data->result_array();
		}

		public function getItemTransactionList($trans,$item_id){
			$sql = "SELECT * FROM wh.wh_transaction_list WHERE transaction_id = '".$trans."' AND item_id = '".$item_id."' ORDER BY transaction_list_id DESC";
			$data = $this->db->query($sql);

			return $data->result_array();
		}

		public function insertTransactionList($data){
			return $this->db->insert('wh.wh_transaction_list',$data);
		}

		public function getUsableStock(){
			$sql = "select mi.item_id item_id , mi.item_name item_name ,mi.item_desc ,mi.item_qty total,
				COALESCE(sum(tl.item_qty)-sum(tl.item_qty_return),0) total_dipinjam , COALESCE(mi.item_qty - sum(tl.item_qty) + sum(tl.item_qty_return),0) sisa 
				from wh.wh_transaction_list tl right join wh.wh_master_item mi on tl.item_id = mi.item_id
				group by mi.item_id,tl.item_id,mi.item_qty,mi.item_desc,mi.item_name";
			$data =  $this->db->query($sql);
			return $data->result_array();
		}
		
		public function getReportUsable($pinjam,$user=FALSE){
			$extra = "";
			$sql = "";

			if($pinjam != 'PINJAM'){
				$extra ="order by tl.transaction_id, tl.date_lend asc";
			}else{
				$extra = "and tl.item_qty is not null
						  order by tl.transaction_id, tl.date_return asc";
			}

			
			if($user === FALSE){
				$sql = "
				SELECT tl.status_kembali, tl.status, CASE WHEN tl.date_lend is null THEN tl.date_return else tl.date_lend END tgl_transaksi,wt.creation_date creation_date, mi.item_name,mi.merk,mi.item_qty,wt.shift,wt.toolman,wt.noind, wt.\"name\", mi.item_id , mi.item_desc ,COALESCE(tl.item_qty, 0 )  qty_pinjam, tl.item_qty_return qty_kembali 
			from wh.wh_transaction_list tl, wh.wh_master_item mi, wh.wh_transaction wt 
			where tl.item_id = mi.item_id
			and tl.transaction_id = wt.id_transaction
			and wt.usable = 'Y'

			$extra



			";	
			}else{
				$sql = "
				SELECT tl.status_kembali, tl.status, CASE WHEN tl.date_lend is null THEN tl.date_return else tl.date_lend END tgl_transaksi,wt.creation_date creation_date, mi.item_name,mi.merk,mi.item_qty,wt.shift,wt.toolman,wt.noind, wt.\"name\", mi.item_id , mi.item_desc ,COALESCE(tl.item_qty, 0 )  qty_pinjam, tl.item_qty_return qty_kembali 
			from wh.wh_transaction_list tl, wh.wh_master_item mi, wh.wh_transaction wt 
			where tl.item_id = mi.item_id
			and tl.transaction_id = wt.id_transaction
			and wt.usable = 'Y'
			and wt.noind = '$user'

			$extra

			";	
			}			

			$data =  $this->db->query($sql);
			return $data->result_array();
		}

		public function getReportConsumable($user=FALSE){

			$sql = "";
				

			if($user === FALSE){
				$sql = "SELECT CASE WHEN tl.date_lend is null THEN tl.date_return else tl.date_lend END tgl_transaksi, tl.item_akh, mi.item_name,mi.merk,mi.item_qty,wt.shift,wt.toolman,wt.noind, wt.\"name\", mi.item_code , mi.item_desc ,COALESCE(tl.item_qty, 0 )  qty_pinjam, tl.item_qty_return qty_kembali 
			from wh.wh_transaction_list tl, wh.wh_master_item_consumable mi, wh.wh_transaction wt 
			where tl.item_id = mi.item_code
			and tl.transaction_id = wt.id_transaction
			and wt.usable = 'N'

			
				";	
			}else{
				$sql = "SELECT CASE WHEN tl.date_lend is null THEN tl.date_return else tl.date_lend END tgl_transaksi, tl.item_akh, mi.item_name,mi.merk,mi.item_qty,wt.shift,wt.toolman,wt.noind, wt.\"name\", mi.item_code , mi.item_desc ,COALESCE(tl.item_qty, 0 )  qty_pinjam, tl.item_qty_return qty_kembali 
			from wh.wh_transaction_list tl, wh.wh_master_item_consumable mi, wh.wh_transaction wt 
			where tl.item_id = mi.item_code
			and tl.transaction_id = wt.id_transaction
			and wt.usable = 'N'
			and wt.noind = '$user'
			";	
			}			


			$data =  $this->db->query($sql);
			return $data->result_array();
		}

		

		public function updateStatus($id,$barcode){
			$this->db->set('status','1');
			$this->db->where('item_id',$barcode);
			$this->db->where('transaction_id',$id);
			return $this->db->update('wh.wh_transaction_list');
		}	

		public function updateStatusKembali($id){
			$this->db->set('status_kembali','1');
			$this->db->where('transaction_list_id',$id);
			return $this->db->update('wh.wh_transaction_list');
		}		

		
}