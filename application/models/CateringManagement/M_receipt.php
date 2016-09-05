<?php
class M_receipt extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//select
		public function GetReceipt(){
			$sql = "
			select *,
				case when a.receipt_date
				is NULL then null 	
				else to_char(a.receipt_date, 'DD MONTH YYYY')
				end as receipt_date,
				case when a.order_start_date
				is NULL then null 	
				else to_char(a.order_start_date, 'DD/MM/YYYY')
				end as order_start_date,
				case when a.order_end_date
				is NULL then null 	
				else to_char(a.order_end_date, 'DD/MM/YYYY')
				end as order_end_date
				
			from cm.cm_receipt a
			left join cm.cm_type b on a.order_type_id = b.type_id
			left join cm.cm_catering c on a.catering_id = c.catering_id
			order by a.receipt_date";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//select
		public function GetReceiptDetails($id){
			$sql = "
			select *,
				case when a.receipt_date
				is NULL then null 	
				else to_char(a.receipt_date, 'DD MONTH YYYY')
				end as receipt_date,
				case when a.receipt_date
				is NULL then null 	
				else to_char(a.receipt_date, 'DD.MM.YYYY')
				end as short_receipt_date,
				case when a.order_start_date
				is NULL then null 	
				else to_char(a.order_start_date, 'DD/MM/YYYY')
				end as order_start_date,
				case when a.order_end_date
				is NULL then null 	
				else to_char(a.order_end_date, 'DD/MM/YYYY')
				end as order_end_date
				
			from cm.cm_receipt a
			left join cm.cm_type b on a.order_type_id = b.type_id
			left join cm.cm_catering c on a.catering_id = c.catering_id
			where a.receipt_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//select
		public function GetReceiptForEdit($id){
			$sql = "
			select *
			from cm.cm_receipt a
			left join cm.cm_type b on a.order_type_id = b.type_id
			left join cm.cm_catering c on a.catering_id = c.catering_id
			where a.receipt_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//select
		public function GetOrderType(){
			$sql = "select * from cm.cm_type order by type_description";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//select
		public function GetCatering(){
			$sql = "select * from cm.cm_catering order by catering_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//create
		public function AddReceipt($no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment){
			$sql = "
			insert into cm.cm_receipt
			(receipt_no,receipt_date,receipt_place,receipt_from,receipt_signer,order_start_date,order_end_date,order_qty,order_price,fine,pph,payment,order_type_id,catering_id)values
			('$no','$date','$place','$from','$signer','$startdate','$enddate','$orderqty','$orderprice','$fine','$pph','$payment','$ordertype','$catering')";
			$query = $this->db->query($sql);
			return;
		}
		
		//create
		public function UpdateReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment){
			$sql = "
			update cm.cm_receipt set 
				receipt_no='$no',
				receipt_date='$date',
				receipt_place='$place',
				receipt_from='$from',
				receipt_signer='$signer',
				order_start_date='$startdate',
				order_end_date='$enddate',
				order_qty='$orderqty',
				order_price='$orderprice',
				fine='$fine',
				pph='$pph',
				payment='$payment',
				order_type_id='$ordertype',
				catering_id='$catering'
			where receipt_id='$id'
			";
			$query = $this->db->query($sql);
			return;
		}
		
		//create
		public function DeleteReceipt($id){
			$sql = "delete from cm.cm_receipt where receipt_id='$id'
			";
			$query = $this->db->query($sql);
			return;
		}
		
}
?>