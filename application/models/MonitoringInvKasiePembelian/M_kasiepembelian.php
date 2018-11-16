<?php
class M_kasiepembelian extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

	public function showListSubmittedForChecking(){
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT distinct purchasing_batch_number batch_num, last_status_purchasing_date submited_date,
                        last_purchasing_invoice_status, last_finance_invoice_status
                FROM khs_ap_monitoring_invoice
                WHERE purchasing_batch_number is not null
                ORDER BY submited_date";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function getJmlInvPerBatch($batch){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT purchasing_batch_number FROM khs_ap_monitoring_invoice WHERE purchasing_batch_number = $batch";
        $run = $erp_db->query($sql);
        return $run->num_rows();
    }

    public function showDetailPerBatch($batchNumber){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct ami.invoice_id invoice_id,
                         ami.vendor_name vendor_name,
                         ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason, 
                         ami.last_finance_invoice_status finance_status,
                         aipo.po_number po_number,
                         poh.attribute2 ppn
                FROM khs_ap_monitoring_invoice ami,
                     khs_ap_invoice_purchase_order aipo,
                     po_headers_all poh
                WHERE purchasing_batch_number = $batchNumber
                and ami.invoice_id = aipo.invoice_id
                and poh.segment1 = aipo.po_number";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getUnitPrice($invoice_id){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT unit_price , qty_invoice 
                  FROM khs_ap_invoice_purchase_order
                    WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function inputActionAndReason($id,$status,$reason){
    	$erp_db = $this->load->database('oracle',true);
    	$sql = "UPDATE khs_ap_monitoring_invoice
    			SET last_purchasing_invoice_status = $status, 
                reason = '$reason' WHERE invoice_id = $id";
    	$run = $erp_db->query($sql);
        oci_commit($erp_db);
    }

    public function inputActionAndReason2($status,$action_date){
    	$erp_db = $this->load->database('oracle',true);
    	$sql = "INSERT INTO khs_ap_invoice_action_detail (purchasing_status,action_date)
    			VALUES ($status,to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
    	$run = $erp_db->query($sql);
        oci_commit($erp_db);
    }

    public function btnSubmitToPurchasing($id,$finance_status,$finance_date,$finance_batch_number){
    	$erp_db = $this->load->database('oracle',true);
    	$sql = "UPDATE khs_ap_monitoring_invoice
                set last_finance_invoice_status = $finance_status,
                last_status_finance_date = to_date('$finance_date', 'DD/MM/YYYY HH24:MI:SS'),
                finance_batch_number = '$finance_batch_number'
    			WHERE invoice_id = $id
                and last_purchasing_invoice_status = 2";
    	$run = $erp_db->query($sql);
        oci_commit($erp_db);
    }

    public function checkFinanceNumber()
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT max(finance_batch_number) finance_batch_number
                  FROM khs_ap_monitoring_invoice 
                  WHERE ROWNUM >= 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function submitToActionDetail($status,$action_date,$purchasing_status){
        $erp_db = $this->load->database('oracle',true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (finance_status,action_date,purchasing_status)
                VALUES ($status,to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),'$purchasing_status')";
        $run = $erp_db->query($sql);
        oci_commit($erp_db);
    }

    public function getSubmitToFinance($id){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT last_purchasing_invoice_status status_finance 
                  FROM  khs_ap_monitoring_invoice
                  WHERE invoice_id = $id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function invoiceDetail($invoice_id){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT invoice_number invoice_number,
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
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.invoice_id = $invoice_id";
        $runQuery = $oracle->query($sql);
        return $runQuery->result_array();
    }

    public function getNamaVendor($id)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $sql = "SELECT * 
                FROM po_vendors pov
                WHERE vendor_id = $id";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function checkExist($id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT last_purchasing_invoice_status purchasing_status
                  FROM  khs_ap_monitoring_invoice
                  WHERE invoice_id = $id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

}