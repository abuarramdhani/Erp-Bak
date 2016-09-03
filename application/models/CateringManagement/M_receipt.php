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
			where a.receipt_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		//create
		public function AddReceipt($no,$date,$place,$from,$signer,$orderdesc,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment){
			$sql = "
			insert into cm.cm_receipt
			(receipt_no,receipt_date,receipt_place,receipt_from,receipt_signer,order_description,order_start_date,order_end_date,order_qty,order_price,fine,pph,payment)values
			('$no','$date','$place','$from','$signer','$orderdesc','$startdate','$enddate','$orderqty','$orderprice','$fine','$pph','$payment')";
			$query = $this->db->query($sql);
			return;
		}
		
}
?>