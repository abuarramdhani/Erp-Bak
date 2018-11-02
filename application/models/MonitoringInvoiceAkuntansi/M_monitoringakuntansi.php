<?php
class M_monitoringakuntansi extends CI_Model {

	public function __construct()
	{
		 $this->load->database();
		$this->load->library('encrypt');
	}

	public function unprocessedInvoice()
	{
		$erp_db = $this->load->database('erp_db',true);
		$sql = "SELECT invoice_id invoice_id,
				vendor_name vendor_name,
				invoice_number invoice_number,
				invoice_date invoice_date,
				tax_invoice_number tax_invoice_number,
				invoice_amount invoice_amount,
				last_status_purchasing_date last_status_purchasing_date,
				last_status_finance_date last_status_finance_date
				FROM ap.ap_monitoring_invoice
				WHERE last_finance_invoice_status = 1";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function poAmount($id)
	{
		$erp_db = $this->load->database('erp_db',true);
		$sql = "SELECT unit_price unit_price,
				qty_invoice qty_invoice
				FROM ap.ap_invoice_purchase_order
				WHERE invoice_id = $id";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function namaVendor($id)
	{
		$oracle = $this->load->database('oracle',true);
		$sql = "SELECT vendor_name 
				FROM po_vendors
				WHERE vendor_id = $id";
		$run = $oracle->query($sql);
		return $run->result_array();
	}

	public function DetailUnprocess($invoice_id)
	{
		$erp_db = $this->load->database('erp_db',true);
        $sql = "SELECT aipo.invoice_id invoice_id, 
        		invoice_number invoice_number,
                invoice_date invoice_date,
                invoice_amount invoice_amount,
                tax_invoice_number tax_invoice_number,
                vendor_name vendor_name,
                po_number po_number,
                lppb_number lppb_number,
                shipment_number shipment_number,
                received_date received_date,
                item_description item_description,
                qty_receipt qty_receipt,
                qty_reject qty_reject,
                currency currency,
                unit_price unit_price,
                qty_invoice qty_invoice
                FROM ap.ap_monitoring_invoice ami
                JOIN ap.ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE aipo.invoice_id = $invoice_id
                AND last_finance_invoice_status = 1";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
	}

	public function saveProses($proses,$finance_date,$id)
	{
		$erp_db = $this->load->database('erp_db',true);
		$sql = "UPDATE ap.ap_monitoring_invoice
				SET last_finance_invoice_status = '$proses',
				last_status_finance_date = '$finance_date'
				WHERE invoice_id = $id";
		$erp_db->query($sql);
	}

	public function saveProses2($id,$finance_status,$action_date)
	{
		$erp_db = $this->load->database('erp_db',true);
        $sql = "UPDATE ap.ap_invoice_action_detail
				SET finance_status = '$finance_status',
				action_date = '$action_date'
				WHERE action_id = $id";
        $erp_db->query($sql);
	}

	public function processedInvoice()
	{
		$erp_db = $this->load->database('erp_db',true);
		$sql = "SELECT invoice_id invoice_id,
				vendor_name vendor_name,
				invoice_number invoice_number,
				invoice_date invoice_date,
				tax_invoice_number tax_invoice_number,
				invoice_amount invoice_amount,
				last_status_purchasing_date last_status_purchasing_date,
				last_status_finance_date last_status_finance_date
				FROM ap.ap_monitoring_invoice
				WHERE last_finance_invoice_status = 2";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function DetailProcess($invoice_id)
	{
		$erp_db = $this->load->database('erp_db',true);
        $sql = "SELECT aipo.invoice_id invoice_id, 
        		invoice_number invoice_number,
                invoice_date invoice_date,
                invoice_amount invoice_amount,
                tax_invoice_number tax_invoice_number,
                vendor_name vendor_name,
                po_number po_number,
                lppb_number lppb_number,
                shipment_number shipment_number,
                received_date received_date,
                item_description item_description,
                qty_receipt qty_receipt,
                qty_reject qty_reject,
                currency currency,
                unit_price unit_price,
                qty_invoice qty_invoice
                FROM ap.ap_monitoring_invoice ami
                JOIN ap.ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE aipo.invoice_id = '$invoice_id'
                AND last_finance_invoice_status = 2";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
	}
}