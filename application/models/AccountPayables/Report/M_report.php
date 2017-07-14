<?php
class M_report extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				$this->load->library('encrypt');
        }
		
		public function getInvoiceFaktur($startDate, $endDate, $vendor)
		{
			if($vendor == '') $vendor = '%';
			$oracle = $this->load->database("oracle",true);
			$query = $oracle->query("
				select
				    asa.vendor_name
				    ,aia.invoice_type_lookup_code type_invoice
				    ,to_char(aia.invoice_date,'DD-MON-YYYY') invoice_date
				    ,aia.invoice_num
				    ,to_char(aca.check_date,'DD-MON-YYYY') payment_date
				    ,aia.invoice_amount-aia.total_tax_amount dpp
				    ,aia.total_tax_amount ppn
				    ,aia.invoice_amount total
				from
				    ap_invoices_all aia
				    ,ap_invoice_payments_all aipa
				    ,ap_checks_all aca
				    ,ap_suppliers asa
				    ,ap_payment_schedules_all apsa
				    ,ap_terms_tl att
				where
				    1=1
				    and invoice_date BETWEEN TO_DATE('$startDate','DD-MM-YYYY') AND TO_DATE('$endDate','DD-MM-YYYY')
				    and aipa.check_id = aca.check_id
				    and aia.vendor_id = asa.vendor_id(+)
				    and aia.invoice_id = aipa.invoice_id
				    and aia.invoice_id = apsa.invoice_id(+)
				    and aca.status_lookup_code != 'VOIDED'
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
				    and aia.attribute3 is NULL
			");
			return $query->result_array();
		}
}
?>