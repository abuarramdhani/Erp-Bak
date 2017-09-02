<?php
class M_report extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
				$this->load->helper('url');
				$this->load->library('session');
        }
		
		public function SearchTransaction($shift,$str_dt,$str_end){
			$sql = "select ttl.transaction_id,ttl.transaction_list_id,ttl.item_id,(ttl.item_qty) qty_dipakai,tmi.item_name,tmi.item_qty,tmi.item_qty_min,tmi.item_desc,tt.shift,tt.noind,tt.created_by,tt.creation_date,tmi.item_desc from tr.tr_transaction_list ttl 
					left join tr.tr_master_item tmi on ttl.item_id=tmi.item_id
					left join tr.tr_transaction tt on ttl.transaction_id=tt.id_transaction 
					where tt.shift='$shift' and date_trunc('day', tt.creation_date)>='$str_dt' and date_trunc('day', tt.creation_date)<='$str_end'
					order by ttl.transaction_id asc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function SearchStok($shift,$str_dt,$str_end){
			$sql = "select ttl.transaction_id,ttl.transaction_list_id,ttl.item_id,tmi.item_name,tmi.item_qty,(tmi.item_qty - sum((ttl.item_qty))) stok_akh,tmi.item_desc
					from tr.tr_transaction_list ttl 
					left join tr.tr_master_item tmi on ttl.item_id=tmi.item_id
					left join tr.tr_transaction tt on ttl.transaction_id=tt.id_transaction 
					where tt.shift='$shift' and date_trunc('day', tt.creation_date)>='$str_dt' and date_trunc('day', tt.creation_date)<='$str_end'
					group by ttl.transaction_id,ttl.transaction_list_id,ttl.item_id,tmi.item_name,tmi.item_qty,tmi.item_desc
					order by ttl.transaction_id asc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		
}