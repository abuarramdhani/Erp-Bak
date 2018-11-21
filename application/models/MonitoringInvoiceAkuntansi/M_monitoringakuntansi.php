<?php
class M_monitoringakuntansi extends CI_Model {

	public function __construct()
	{
		 $this->load->database();
		$this->load->library('encrypt');
	}

	public function unprocessedInvoice($batchNumber)
	{
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT ami.invoice_id invoice_id,
				    ami.vendor_name vendor_name,
				    ami.invoice_number invoice_number,
				    ami.invoice_date invoice_date,
				    ami.tax_invoice_number tax_invoice_number,
				    ami.invoice_amount invoice_amount,
				    ami.last_status_purchasing_date last_status_purchasing_date,
				    ami.last_status_finance_date last_status_finance_date,
				    ami.finance_batch_number finance_batch_number,
				    ami.LAST_FINANCE_INVOICE_STATUS LAST_FINANCE_INVOICE_STATUS,
				    ami.reason reason,
				    poh.attribute2 PPN,
				    aaipo.po_number po_number,
				    aaipo.po_detail po_detail
				FROM khs_ap_monitoring_invoice ami,
				(select aipo.invoice_id, aipo.po_number, replace((rtrim (xmlagg (xmlelement (e, to_char(aipo.po_number || '-' || aipo.line_number || '-' || aipo.lppb_number) || '@')).extract ('//text()'), '@')), '@', '<br>') po_detail
				                                from khs_ap_invoice_purchase_order aipo
				                                group by aipo.invoice_id , aipo.po_number) aaipo
				                                ,po_headers_all poh
				WHERE aaipo.invoice_id = ami.invoice_id 
				AND last_finance_invoice_status = 1
				AND finance_batch_number = $batchNumber
				and poh.SEGMENT1 = aaipo.po_number
				ORDER BY vendor_name";
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
                qty_receipt qty_receipt,
                qty_reject qty_reject,
                currency currency,
                unit_price unit_price,
                qty_invoice qty_invoice,
                ami.finance_batch_number  finance_batch_number
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE aipo.invoice_id = $invoice_id
                AND ami.last_purchasing_invoice_status = 2
                and ami.finance_batch_number = $batch_num";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
	}

	public function saveProses($proses,$finance_date,$id)
	{
		$erp_db = $this->load->database('oracle',true);
		$sql = "UPDATE khs_ap_monitoring_invoice
				SET last_finance_invoice_status = $proses,
				last_status_finance_date = to_date('$finance_date', 'DD/MM/YYYY HH24:MI:SS')
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
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,finance_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),'$finance_status')";
        $run = $oracle->query($sql);
    }

	public function processedInvoice()
	{
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT distinct ami.invoice_id invoice_id,
				ami.vendor_name vendor_name,
				ami.invoice_number invoice_number,
				ami.invoice_date invoice_date,
				ami.tax_invoice_number tax_invoice_number,
				ami.invoice_amount invoice_amount,
				ami.last_status_purchasing_date last_status_purchasing_date,
				ami.last_status_finance_date last_status_finance_date,
				ami.finance_batch_number finance_batch_number,
                poh.attribute2 ppn
				FROM khs_ap_monitoring_invoice ami,
                khs_ap_invoice_purchase_order aipo,
                po_headers_all poh
				WHERE last_finance_invoice_status = 2
                AND ami.invoice_id = aipo.invoice_id
                AND aipo.po_number = poh.segment1
				ORDER BY last_status_finance_date";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function DetailProcess($invoice_id)
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
                qty_receipt qty_receipt,
                qty_reject qty_reject,
                currency currency,
                unit_price unit_price,
                qty_invoice qty_invoice
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE aipo.invoice_id = $invoice_id
                AND last_finance_invoice_status = 2";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
	}

	public function showFinanceNumber(){
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT finance_batch_number finance_batch_number, last_status_purchasing_date submited_date
                FROM khs_ap_monitoring_invoice
                WHERE last_finance_invoice_status = 1
                GROUP BY finance_batch_number, last_status_purchasing_date 
                ORDER BY submited_date";
		$run = $erp_db->query($sql);
		return $run->result_array();
	}

	public function jumlahFinanceBatch($batch){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT finance_batch_number FROM khs_ap_monitoring_invoice WHERE finance_batch_number = $batch
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
}