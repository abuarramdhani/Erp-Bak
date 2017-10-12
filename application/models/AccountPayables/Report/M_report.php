<?php
class M_report extends CI_Model {

		public function __construct()
		{
				$this->load->database();
				$this->load->library('encrypt');
		}
		
		public function getInvoiceFaktur($startDate, $endDate, $vendor, $status, $user)
		{
			if($vendor == '') $vendor = '%';
			if($status == 1){
				$attribute = '';
			} else if($status == 2){
				$attribute = 'and aia.attribute3 is NOT NULL ';
			} else if($status == 3){
				$attribute = 'and aia.attribute3 is NULL ';
			}
			$oracle = $this->load->database("oracle",true);

			if ($user == 'B0541' OR $user == 'B0727') {
				$query = $oracle->query("
					select distinct
						asa.vendor_name
						,aia.invoice_type_lookup_code type_invoice
						,to_char(aia.invoice_date,'DD-MON-YYYY') invoice_date
						,aia.invoice_num
						,to_char(aca.check_date,'DD-MON-YYYY') payment_date
						,aia.invoice_amount-aia.total_tax_amount dpp
						,aia.total_tax_amount ppn
						,aia.invoice_amount total
						,aia.attribute5
						,aia.attribute3
						,poh.segment1 po_num
						,papf_buyer.full_name buyer

					from
						ap_invoices_all aia
						,ap_invoice_lines_all aila
						,ap_invoice_payments_all aipa
						,ap_checks_all aca
						,ap_suppliers asa
						,ap_payment_schedules_all apsa
						,ap_terms_tl att
						,po_headers_all poh
						,(SELECT DISTINCT PERSON_ID,FULL_NAME FROM per_all_people_f) papf_buyer
					where
						1=1
						and aia.invoice_date BETWEEN TO_DATE('$startDate','DD-MM-YYYY') AND TO_DATE('$endDate','DD-MM-YYYY')
						and aipa.check_id = aca.check_id
						and aia.vendor_id = asa.vendor_id(+)
						and aia.invoice_id = aipa.invoice_id
						and aia.invoice_id = apsa.invoice_id(+)
						and aca.status_lookup_code != 'VOIDED'
						and aia.invoice_id = aila.invoice_id
						and aila.po_header_id = poh.po_header_id
						and poh.agent_id = papf_buyer.person_id
						and aia.terms_id = att.term_id
						and att.enabled_flag = 'Y'
						and aia.org_id = 82
						and aia.invoice_id in (select aipa2.invoice_id 
							from ap_invoice_lines_all aipa2 
							where aipa2.LINE_TYPE_LOOKUP_CODE = 'TAX'
							AND (aipa2.DISCARDED_FLAG != 'Y' or aipa2.DISCARDED_FLAG is null)
							AND aipa2.LINE_SOURCE != 'IMPORTED')
						and aia.cancelled_date is NULL
						AND asa.vendor_name LIKE '$vendor'
						AND aia.invoice_num LIKE '%'
						AND aia.attribute15 LIKE '%'
						$attribute
				");
			}else{
				$query = $oracle->query("
					select distinct
						asa.vendor_name
						,aia.invoice_type_lookup_code type_invoice
						,to_char(aia.invoice_date,'DD-MON-YYYY') invoice_date
						,aia.invoice_num
						,to_char(aca.check_date,'DD-MON-YYYY') payment_date
						,aia.invoice_amount-aia.total_tax_amount dpp
						,aia.total_tax_amount ppn
						,aia.invoice_amount total
						,aia.attribute5
						,aia.attribute3
						,rsh.receipt_num lppb
						,poh.segment1 po_num
						,aca.currency_code currency
					from
						ap_invoices_all aia
						,ap_invoice_lines_all aila
						,ap_invoice_payments_all aipa
						,ap_checks_all aca
						,ap_suppliers asa
						,ap_payment_schedules_all apsa
						,po_headers_all poh
						,rcv_shipment_headers rsh
						,rcv_transactions rt
					where
						1=1
						and aia.invoice_date BETWEEN TO_DATE('$startDate','DD-MM-YYYY') AND TO_DATE('$endDate','DD-MM-YYYY')
						and aipa.check_id = aca.check_id
						and aia.vendor_id = asa.vendor_id(+)
						and aia.invoice_id = aipa.invoice_id
						and aia.invoice_id = apsa.invoice_id(+)
						and aca.status_lookup_code != 'VOIDED'
						and aia.invoice_id = aila.invoice_id
						and aila.po_header_id = poh.po_header_id
						and aila.RCV_TRANSACTION_ID = rt.TRANSACTION_ID
						and rsh.shipment_header_id = rt.shipment_header_id
						and aia.org_id = 82
						and aia.invoice_id in (select aipa2.invoice_id 
							from ap_invoice_lines_all aipa2 
							where aipa2.LINE_TYPE_LOOKUP_CODE = 'TAX'
							AND (aipa2.DISCARDED_FLAG != 'Y' or aipa2.DISCARDED_FLAG is null)
							AND aipa2.LINE_SOURCE != 'IMPORTED')
						and aia.cancelled_date is NULL
						AND asa.vendor_name LIKE '$vendor'
						AND aia.invoice_num LIKE '%'
						AND aia.attribute15 LIKE '%'
						$attribute
				");
			};
			return $query->result_array();
		}
}
?>