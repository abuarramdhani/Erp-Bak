<?php
class M_kasiepembelian extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

  public function checkLoginInKasiePembelian($employee_code)
    {
        $oracle = $this->load->database('erp_db',true);
        $query = "select eea.employee_code, es.unit_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

	public function showListSubmittedForChecking($login){
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT distinct batch_number batch_number, to_date(last_status_purchasing_date) submited_date,
                last_purchasing_invoice_status, last_finance_invoice_status
                FROM khs_ap_monitoring_invoice 
                WHERE (last_purchasing_invoice_status = 1
                OR last_purchasing_invoice_status = 2)
                AND LAST_FINANCE_INVOICE_STATUS=0
                $login
                ORDER BY submited_date";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function getJmlInvPerBatch($batch){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT batch_number FROM khs_ap_monitoring_invoice WHERE batch_number = '$batch'";
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
                         --aipo.po_number po_number,
                         poh.attribute2 ppn,
                         aiac2.action_date action_date,
                         ami.batch_number batch_number,
                         ami.last_purchasing_invoice_status last_purchasing_invoice_status,
                         ami.info info,
                         ami.invoice_category invoice_category,
                         ami.nominal_dpp nominal_dpp,
                         ami.jenis_jasa jenis_jasa
                FROM khs_ap_monitoring_invoice ami,
                     khs_ap_invoice_purchase_order aipo,
                     po_headers_all poh,
                     (select distinct min(action_date) over (partition by invoice_id) action_date, invoice_id from khs_ap_invoice_action_detail aiac) aiac2
                WHERE batch_number = '$batchNumber'
                and ami.invoice_id = aipo.invoice_id
                and poh.segment1 = aipo.po_number
                and aiac2.invoice_id = ami.invoice_id
                ORDER BY vendor_name, invoice_number";
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

    public function approvedbykasiepurchasing($id,$status,$last_status_purchasing_date){
    	$erp_db = $this->load->database('oracle',true);
    	$sql = "UPDATE khs_ap_monitoring_invoice
    			SET last_purchasing_invoice_status = '$status',
                last_status_purchasing_date = to_date('$last_status_purchasing_date', 'DD/MM/YYYY HH24:MI:SS')
                WHERE invoice_id = $id";
    	$run = $erp_db->query($sql);
        // oci_commit($erp_db);
    }

    public function rejectbykasiepurchasing($id,$status,$last_status_purchasing_date,$reason){
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE khs_ap_monitoring_invoice
                SET last_purchasing_invoice_status = '$status',
                last_status_purchasing_date = to_date('$last_status_purchasing_date', 'DD/MM/YYYY HH24:MI:SS'),
                reason = '$reason'
                WHERE invoice_id = $id";
        $run = $erp_db->query($sql);
        // oci_commit($erp_db);
    }

    public function inputstatuspurchasing($invoice_id,$action_date,$purchasing_status)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),'$purchasing_status')";
        $run = $oracle->query($sql);
    }

    public function btnSubmitToFinance($id,$finance_status,$finance_date){
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE khs_ap_monitoring_invoice
                set last_finance_invoice_status = '$finance_status',
                last_status_finance_date = to_date('$finance_date', 'DD/MM/YYYY HH24:MI:SS')
                WHERE invoice_id = $id
                and last_purchasing_invoice_status = 2";
        $run = $erp_db->query($sql);
        // oci_commit($erp_db);
    }

    public function insertstatusfinance($invoice_id,$action_date,$finance_status)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status,finance_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),'2','$finance_status')";
        $run = $oracle->query($sql);
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
        $sql = "SELECT ami.invoice_number invoice_number,
                ami.invoice_date invoice_date,
                ami.invoice_amount invoice_amount,
                ami.tax_invoice_number tax_invoice_number,
                ami.vendor_name vendor_name,
                aipo.po_number po_number,
                aipo.lppb_number lppb_number,
                aipo.shipment_number shipment_number,
                aipo.received_date received_date,
                aipo.item_description item_description,
                aipo.item_code item_code,
                aipo.qty_receipt qty_receipt,
                aipo.qty_reject qty_reject,
                aipo.currency currency,
                aipo.unit_price unit_price,
                aipo.qty_invoice qty_invoice,
                ami.invoice_id invoice_id,
                ami.batch_number batch_number,
                ami.info info,
                ami.invoice_category invoice_category,
                ami.nominal_dpp nominal_dpp,
                ami.jenis_jasa jenis_jasa
                FROM khs_ap_monitoring_invoice ami
                ,khs_ap_invoice_purchase_order aipo
                WHERE ami.invoice_id = aipo.invoice_id
                AND ami.invoice_id = $invoice_id";
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

    public function showFinishBatch($login){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT DISTINCT a.batch_number, 
                                a.finance_batch_number, 
                                a.last_purchasing_invoice_status, 
                                a.last_finance_invoice_status,
                                (SELECT DISTINCT to_date(d.action_date)
                                            FROM khs_ap_invoice_action_detail d
                                           WHERE d.invoice_id = a.invoice_id
                                             AND d.finance_status = 1
                                             AND d.purchasing_status = 2 AND rownum = 1) submited_date,
                                (SELECT COUNT (*)
                                   FROM khs_ap_monitoring_invoice b
                                  WHERE b.batch_number = a.batch_number)jml_invoice
                FROM khs_ap_monitoring_invoice a
                WHERE a.batch_number IS NOT NULL
                AND (a.last_finance_invoice_status = 1 and a.last_purchasing_invoice_status = 2)
                $login
                ORDER BY submited_date";
        $run = $erp_db->query($sql);
        return $run->result_array();
    }

    public function finish_detail($batchNumber){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct ami.invoice_id invoice_id,
                         ami.vendor_name vendor_name,
                         ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         poh.attribute2 ppn,
                         ami.last_status_purchasing_date last_status_purchasing_date,
                         ami.batch_number batch_number,
                         ami.info info,
                         ami.invoice_category invoice_category,
                         ami.nominal_dpp nominal_dpp,
                         ami.jenis_jasa jenis_jasa
                FROM khs_ap_monitoring_invoice ami,
                     khs_ap_invoice_purchase_order aipo,
                     po_headers_all poh
                WHERE ami.batch_number = '$batchNumber'
                and ami.invoice_id = aipo.invoice_id
                and poh.segment1 = aipo.po_number
                ORDER BY vendor_name, invoice_number";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function finish_detail_invoice($invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
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
                item_code item_code,
                qty_receipt qty_receipt,
                qty_reject qty_reject,
                currency currency,
                unit_price unit_price,
                qty_invoice qty_invoice,
                info info,
                invoice_category,
                nominal_dpp,
                jenis_jasa
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE aipo.invoice_id = $invoice_id";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function checkApprove($invoice_id){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT last_purchasing_invoice_status 
                FROM khs_ap_monitoring_invoice
                WHERE invoice_id = $invoice_id";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function getLastStatusActionDetail($invoice_id){
        $oracle = $this->load->database('oracle',true);
        $sql="SELECT action_date, purchasing_status, action_id
                    FROM khs_ap_invoice_action_detail a
                    WHERE a.ACTION_ID = (SELECT MAX(ACTION_ID) FROM khs_ap_invoice_action_detail b WHERE INVOICE_ID = '$invoice_id')";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

     public function detailBatch($batch_number){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct (SELECT COUNT (last_purchasing_invoice_status)
                      FROM khs_ap_monitoring_invoice b
                     WHERE b.last_purchasing_invoice_status = 2
                       AND b.batch_number = '$batch_number') approve,
                   (SELECT COUNT (last_purchasing_invoice_status)
                      FROM khs_ap_monitoring_invoice c
                     WHERE c.last_purchasing_invoice_status = 3
                       AND c.batch_number = '$batch_number') reject,
                   (SELECT COUNT (last_purchasing_invoice_status)
                      FROM khs_ap_monitoring_invoice d
                     WHERE d.last_purchasing_invoice_status = 1
                       AND d.batch_number = '$batch_number') submit
              FROM khs_ap_monitoring_invoice a";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function editInvoiceKasiePurc($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$info,$nominal_dpp,$invoice_category,$jenis_jasa){
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET invoice_number = '$invoice_number', 
                    invoice_date = '$invoice_date',
                    invoice_amount = '$invoice_amount',
                    tax_invoice_number = '$tax_invoice_number',
                    info = '$info',
                    nominal_dpp = '$nominal_dpp',
                    invoice_category = '$invoice_category',
                    jenis_jasa = '$jenis_jasa'
                 WHERE invoice_id = $invoice_id ";
        $runQuery2 = $oracle->query($query2);
        // oci_commit($oracle);
    }

    public function submitUlang($invoice_id,$date){
      $erp_db = $this->load->database('oracle',true);
      $sql = "UPDATE khs_ap_monitoring_invoice
          SET last_purchasing_invoice_status = '1',
                last_status_purchasing_date = to_date('$date', 'DD/MM/YYYY HH24:MI:SS')
                WHERE invoice_id = '$invoice_id'";
      $run = $erp_db->query($sql);

    }

    public function insertSubmitUlang($invoice_id,$date)
    {
      $erp_db = $this->load->database('oracle',true);
      $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status,finance_status)
                VALUES('$invoice_id', to_date('$date', 'DD/MM/YYYY HH24:MI:SS'),'1','0')";
      $run = $erp_db->query($sql);
    }

    public function submitUlangKasieGudang($batch_number,$date){
      $erp_db = $this->load->database('oracle',true);
      $sql = "UPDATE khs_ap_monitoring_invoice
          SET last_purchasing_invoice_status = '1',
                last_status_purchasing_date = to_date('$date', 'DD/MM/YYYY HH24:MI:SS'),
                last_finance_invoice_status = '0'
                WHERE batch_number = '$batch_number'";
      $run = $erp_db->query($sql);
        // oci_commit($erp_db);
    }

    public function ambilID($batch_number){
      $erp_db = $this->load->database('oracle',true);
      $sql = "SELECT invoice_id FROM khs_ap_monitoring_invoice WHERE batch_number = '$batch_number' ";
      $run = $erp_db->query($sql);
      return $run->result_array();
    }

    public function simpanID($id, $date)
    {
      $erp_db = $this->load->database('oracle',true);
      $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status,finance_status)
                VALUES('$id', to_date('$date', 'DD/MM/YYYY HH24:MI:SS'),'1','0')";
      $run = $erp_db->query($sql);
    }

}