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
						,aba.batch_name batch_number
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
						,ap_batches_all aba
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
						and aba.batch_id(+) = aia.batch_id
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
				select 
					asa.vendor_name
					,aia.invoice_type_lookup_code type_invoice
					,aba.batch_name batch_number
					,to_char(aia.invoice_date,'DD-MON-YYYY') invoice_date
					,aia.invoice_num
					,to_char(aca.check_date,'DD-MON-YYYY') payment_date
					,aia.invoice_amount-aia.total_tax_amount dpp
					,aia.total_tax_amount ppn
					,aia.invoice_amount total
					,aia.attribute5
					,aia.attribute3
					,nvl (pha.clm_document_number, pha.segment1) po_number
					,to_char(receipt.receipt_num) receipt_num
					,to_char(receipt.receipt_date) receipt_date
					,to_char(aia.gl_date,'DD-MON-YYYY') gl_date
					,kfw.month
				from
					ap_invoices_all aia
					,ap_batches_all aba
					,ap_invoice_payments_all aipa
					,ap_checks_all aca
					,ap_suppliers asa
					,ap_payment_schedules_all apsa
					,ap_terms_tl att
					,po_headers_all pha
					,khs_faktur_web kfw
					,( select invoice_id
							,rtrim(xmlagg(xmlelement(e, receipt_num, ',') order by receipt_num ).extract('//text()').getclobval(), ',') receipt_num
							,rtrim(xmlagg(xmlelement(e, receipt_date, ',') order by receipt_num ).extract('//text()').getclobval(), ',') receipt_date
					from ( select invoice_id, receipt_num, receipt_date
								from (select aia.invoice_id
											,rsh.receipt_num
											,to_char(rt.transaction_date,'DD-MON-YYYY') receipt_date
										from ap_invoice_lines_all aila
											,ap_invoices_all aia
											,ap_suppliers asa
											,rcv_shipment_headers rsh
											,rcv_transactions rt
									where aia.invoice_id = aila.invoice_id
										and aia.vendor_id = asa.vendor_id(+)
										and rt.shipment_line_id = aila.rcv_shipment_line_id
										and rsh.shipment_header_id(+) = rt.shipment_header_id
										and rt.transaction_type = 'DELIVER'
										and aia.invoice_date between to_date('$startDate','DD-MM-YYYY') and to_date('$endDate','DD-MM-YYYY')
										and asa.vendor_name like '$vendor'
									group by aia.invoice_id, rsh.receipt_num, rt.transaction_date)
								group by invoice_id, receipt_num, receipt_date  )
					group by invoice_id
					) receipt
				where
					1=1
					and aia.invoice_date between to_date('$startDate','DD-MM-YYYY') and to_date('$endDate','DD-MM-YYYY')
					and aipa.check_id = aca.check_id(+)
					and aia.vendor_id = asa.vendor_id(+)
					and aia.invoice_id = aipa.invoice_id(+)
					and aia.invoice_id = apsa.invoice_id(+)
					and aia.INVOICE_ID =  kfw.INVOICE_ID(+)
					and aba.batch_id(+) = aia.batch_id
					and aca.status_lookup_code(+) != 'VOIDED'
					and aia.terms_id = att.term_id
					and att.enabled_flag = 'Y'
					and aia.org_id = 82
					and aia.invoice_id in (select aipa2.invoice_id 
						from ap_invoice_lines_all aipa2 
						where aipa2.line_type_lookup_code = 'TAX'
						and (aipa2.discarded_flag != 'Y' or aipa2.discarded_flag is null)
						and aipa2.line_source != 'IMPORTED')
					and aia.cancelled_date is null
					and asa.vendor_name like '$vendor'
					and aia.invoice_num like '%'
					and aia.attribute15 like '%'
					and aia.quick_po_header_id = pha.po_header_id(+)
					and aia.invoice_id = receipt.invoice_id(+)
					$attribute
				order by aia.invoice_date
				");
			};
			return $query->result_array();
		}

		public function getDetailInvoiceVendor()
		{
			$oracle = $this->load->database("oracle",true);
			$query = $oracle->query("SELECT DISTINCT pv.VENDOR_NAME FROM  PO_VENDORS pv");
			return $query->result_array();
		}

		public function getDetailInvoice($vendorName, $tglAwal, $tglAkhir)
		{
			$oracle = $this->load->database("oracle",true);
			$query = $oracle->query("
				SELECT 
					ai.invoice_num
					, alc1.displayed_field line_type
					, asa.vendor_name
					, ail.description
					, ail.quantity_invoiced
					, ail.unit_price
					, ail.amount
					, asa.vat_registration_num NPWP
					, to_char(ac.check_date,'DD-MON-YYYY') payment_date
					, ipmv.payment_method_name payment_method
				FROM
					ap_invoices_all ai
					, ap_suppliers asa
					, ap_invoice_lines_all ail
					, ap_invoice_payments_all aip
					, ap_checks_all ac
					, ap_lookup_codes alc1
					, iby_payment_methods_vl ipmv
				WHERE
					ac.check_id = aip.check_id 
					AND ai.invoice_id = aip.invoice_id
					AND ai.invoice_id = ail.invoice_id
					AND ai.vendor_id = asa.vendor_id
					AND alc1.lookup_type(+) = 'INVOICE LINE TYPE'
					AND alc1.lookup_code(+) = ail.line_type_lookup_code
					AND TO_DATE(ac.check_date,'DD-MM-YYYY') between TO_DATE('$tglAwal','DD-MM-YYYY') AND TO_DATE('$tglAkhir','DD-MM-YYYY')
					AND asa.vendor_name = '$vendorName'
					AND ac.STATUS_LOOKUP_CODE <> 'VOIDED'
					AND ipmv.payment_method_code = ac.payment_method_code
				order by 1
			");
			return $query->result_array();
		}

		public function getNPWP($vendorName)
		{
			$oracle = $this->load->database("oracle",true);
			$query = $oracle->query("
				SELECT 
					asa.vendor_name,
					asa.vat_registration_num NPWP
				FROM
					ap_suppliers asa
				WHERE
					asa.vendor_name = '$vendorName'
			");
			return $query->result_array();
		}
}
?>