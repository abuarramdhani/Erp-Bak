<?php
class M_monitoringakuntansi extends CI_Model {

	public function __construct()
	{
		 $this->load->database();
		$this->load->library('encrypt');
	}

  public function checkLoginInAkuntansi($employee_code)
    {
        $oracle = $this->load->database('erp_db',true);
        $query = "select eea.employee_code, es.unit_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }


    function get_ora_blob_value($value)
    {
        $size = $value->size();
        $result = $value->read($size);
        return ($result)?$result:NULL;
    }

	public function unprocessedInvoice($batchNumber)
	{
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT  ami.invoice_id, ami.vendor_name vendor_name,
                ami.invoice_number invoice_number,
                ami.invoice_date invoice_date,
                ami.tax_invoice_number tax_invoice_number,
                ami.invoice_amount invoice_amount,
                ami.last_status_purchasing_date last_status_purchasing_date,
                ami.last_status_finance_date last_status_finance_date,
                ami.finance_batch_number finance_batch_number,
                ami.last_finance_invoice_status last_finance_invoice_status,
                ami.reason reason, 
                ami.info info,
                ami.invoice_category invoice_category,
                ami.nominal_dpp nominal_dpp,
                ami.batch_number batch_number,
                ami.jenis_jasa jenis_jasa,
                ami.source SOURCE
            FROM khs_ap_monitoring_invoice ami
            WHERE ami.last_finance_invoice_status = 1 
            AND ami.batch_number= '$batchNumber'
            ORDER BY ami.last_admin_date DESC
           ";
		   $run = $erp_db->query($sql);
    return $run->result_array();
	}

	public function poAmount($id)
	{
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT unit_price unit_price,
				qty_invoice qty_invoice
				FROM khs_ap_invoice_purchase_order
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

	public function DetailUnprocess($batch_num,$invoice_id)
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
                ami.finance_batch_number  finance_batch_number,
                ami.info info,
                ami.invoice_category invoice_category,
                ami.nominal_dpp nominal_dpp,
                ami.batch_number batch_number,
                ami.jenis_jasa jenis_jasa,
                ami.source source
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.batch_number = '$batch_num'
                AND ami.last_purchasing_invoice_status = 2
                and ami.invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
	}

	public function saveProses($proses,$finance_date,$reason,$id)
	{
		$erp_db = $this->load->database('oracle',true);
		$sql = "UPDATE khs_ap_monitoring_invoice
				SET last_finance_invoice_status = $proses,
				last_status_finance_date = to_date('$finance_date', 'DD/MM/YYYY HH24:MI:SS'),
        reason = '$reason'
				WHERE invoice_id = $id";
		$erp_db->query($sql);
		// oci_commit($erp_db);
	}

	public function saveProses2($id,$finance_status,$action_date)
	{
		$erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE khs_ap_invoice_action_detail
				SET finance_status = $finance_status,
				action_date = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS')
				WHERE action_id = $id";
        $erp_db->query($sql);
        // oci_commit($erp_db);
	}

    public function insertproses($invoice_id,$action_date,$finance_status)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status,finance_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),'2','$finance_status')";
        $run = $oracle->query($sql);
    }

	public function processedInvoice($batchNumber)
	{
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT distinct ami.invoice_id invoice_id,
                         ami.vendor_name vendor_name,
                         ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         poh.attribute2 ppn,
                         to_date(ami.last_status_purchasing_date) last_status_purchasing_date,
                         ami.purchasing_batch_number purchasing_batch_number,
                         to_date(ami.last_status_finance_date) last_status_finance_date,
                         finance_batch_number finance_batch_number,
                         ami.info info,
                         ami.invoice_category invoice_category,
                         ami.nominal_dpp nominal_dpp,
                         ami.batch_number batch_number,
                         ami.jenis_jasa jenis_jasa,
                         ami.source source
                FROM khs_ap_monitoring_invoice ami,
                     khs_ap_invoice_purchase_order aipo,
                     po_headers_all poh
                WHERE ami.batch_number = '$batchNumber'
                and ami.invoice_id = aipo.invoice_id
                and poh.segment1 = aipo.po_number
                and last_finance_invoice_status = 2
                ORDER BY vendor_name, invoice_number";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function DetailProcess($invoice_id)
	{
		$erp_db = $this->load->database('oracle',true);
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
                ami.purchasing_batch_number purchasing_batch_number,
                ami.info info,
                ami.finance_batch_number finance_batch_number,
                ami.invoice_category invoice_category,
                ami.nominal_dpp nominal_dpp,
                ami.batch_number batch_number,
                ami.jenis_jasa jenis_jasa
                FROM khs_ap_monitoring_invoice ami
                ,khs_ap_invoice_purchase_order aipo
                WHERE ami.invoice_id = aipo.invoice_id
                AND ami.invoice_id = $invoice_id";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
	}

	public function showFinanceNumber($login){
		$erp_db = $this->load->database('oracle',true);
        $sql = "SELECT batch_number batch_number, to_date(last_status_finance_date) submited_date, source
        FROM khs_ap_monitoring_invoice
        WHERE last_finance_invoice_status = 1
        $login
        GROUP BY batch_number, to_date(last_status_finance_date), source
        ORDER BY submited_date";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function jumlahFinanceBatch($batch){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT batch_number FROM khs_ap_monitoring_invoice WHERE batch_number = $batch
        and last_purchasing_invoice_status = 2";
        $run = $erp_db->query($sql);
        return $run->num_rows();
    }

    public function reason_finance($invoice_id,$reason)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET reason = '$reason'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
        // oci_commit($oracle);
    }

    public function podetails($po_number,$lppb_number,$line_number){
       
       $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT * FROM(SELECT distinct
                            pol.line_num line_num,
                            poh.SEGMENT1 no_po,
                            rsh.receipt_num no_lppb,
                            rt.transaction_type status
                            from rcv_shipment_headers rsh
                            ,rcv_shipment_lines rsl
                            ,RCV_TRANSACTIONS RT
                            ,PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                        where rsh.shipment_header_id = rsl.shipment_header_id 
                        and RSH.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID
                        AND rsl.shipment_line_id = rt.shipment_line_id
                        AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                        AND POL.PO_LINE_ID = RT.PO_LINE_ID
                        AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                                                  FROM RCV_TRANSACTIONS RTS
                                                  WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                                                  and rts.po_line_id = pol.PO_LINE_ID
                                                  AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE','TRANSFER'))
                        and poh.po_header_id(+) = pol.po_header_id
                        union
                        SELECT distinct 
                                    pol.line_num line_num,
                                    poh.SEGMENT1 no_po,
                                    NULL no_lppb,
                                    NULL status
                        FROM PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                        WHERE poh.po_header_id(+) = pol.po_header_id)
                WHERE no_po = '$po_number'
                and line_num = $line_number
                and no_lppb = '$lppb_number' ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function showFinishBatch($login){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT DISTINCT a.purchasing_batch_number, 
                                a.batch_number, 
                                a.last_purchasing_invoice_status, 
                                a.last_finance_invoice_status,
                                a.source,
                                (SELECT MAX(to_date(d.action_date))
                                            FROM khs_ap_invoice_action_detail d
                                           WHERE d.invoice_id = a.invoice_id
                                             AND d.finance_status = 2
                                             AND d.purchasing_status = 2) submited_date,
                                (SELECT COUNT (*)
                                   FROM khs_ap_monitoring_invoice b
                                  WHERE b.batch_number = a.batch_number
                                  AND last_finance_invoice_status = 2)jml_invoice
                FROM khs_ap_monitoring_invoice a
                WHERE last_finance_invoice_status = 2
                $login
                ORDER BY submited_date";
        $run = $erp_db->query($sql);
        return $run->result_array();
    }

    public function detailBatch($batch_number){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT COUNT (last_finance_invoice_status) approve
                      FROM khs_ap_monitoring_invoice b
                     WHERE b.last_finance_invoice_status = 2
                       AND b.batch_number = '$batch_number'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function jumlahInvoice($batch_number){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT COUNT (last_finance_invoice_status) jumlah_invoice
                      FROM khs_ap_monitoring_invoice b
                     WHERE b.batch_number = '$batch_number'
                     AND last_finance_invoice_status = 1";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function checkPPN($po_numberInv){
        $oracle = $this->load->database("oracle",TRUE);
        $query = "SELECT distinct poh.attribute2 ppn
                            from PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                            ,PO_LINE_LOCATIONS_ALL PLL
                        where poh.po_header_id(+) = pol.po_header_id
                        AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                        AND POH.SEGMENT1 = '$po_numberInv' ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function po_numberr($invoice_id){
        $oracle = $this->load->database("oracle",TRUE);
        $query = "SELECT DISTINCT aipo.po_number, aipo.invoice_id, poh.attribute2 ppn
                  FROM khs_ap_invoice_purchase_order aipo, po_headers_all poh
                  WHERE invoice_id = '$invoice_id'
                  AND aipo.po_number = poh.segment1 ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
}