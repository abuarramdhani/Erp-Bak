<?php
class M_monitoringinvoice extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

	public function getInvNumber($po_numberInv){
		$oracle = $this->load->database('oracle',TRUE);
		$query = $oracle->query("SELECT DISTINCT
                pol.po_line_id line_id,
                pol.line_num line_num,
                rsh.receipt_num no_lppb, 
                rsh.shipment_num shipment,
                rt.transaction_type status, 
                rsh.creation_date transaction,
                DECODE (rt.source_document_code,
                        'PO', pov.vendor_name,
                        'RMA', NULL,
                        org.NAME
                       ) vendor_name,
                poh.segment1 no_po,
                pol.unit_price unit_price,
                rt.currency_code currency,
                plla.quantity_received received,
                plla.quantity_rejected rejected, 
                pol.item_description description,
                msib.SEGMENT1 item_id,
                plla.quantity_billed quantity_billed
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                rcv_transactions rt,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                ap_terms apt,
                po_line_locations_all plla,
                mtl_system_items_b msib
                -- po_distributions_all pd
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND org.organization_id(+) = rsl.from_organization_id
            AND apt.term_id = poh.terms_id
            AND poh.po_header_id = pol.po_header_id
            AND pov.vendor_id(+) = rt.vendor_id
            AND poh.po_header_id(+) = rt.po_header_id
            AND pol.po_line_id(+) = rt.po_line_id
            AND org.LANGUAGE(+) = USERENV ('LANG')
            AND pol.po_line_id = plla.po_line_id
            -- AND plla.line_location_id = pd.line_location_id
            AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                          FROM RCV_TRANSACTIONS RTS
                          WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                          and rts.po_line_id = pol.PO_LINE_ID
                          AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE')
                          )
            -- AND plla.quantity_billed = 0
            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
            AND poh.segment1 = '$po_numberInv'
        ORDER BY pol.line_num
            ");
		return $query->result_array();
	}

    public function statusPo($po_numberInv){
        $oracle = $this->load->database('oracle',TRUE);
        $sql = $oracle->query("SELECT rt.transaction_type,  plla.quantity_billed
                FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                rcv_transactions rt,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                ap_terms apt,
                po_line_locations_all plla,
                mtl_system_items_b msib
                WHERE rsh.shipment_header_id = rsl.shipment_header_id
                    AND rsh.shipment_header_id = rt.shipment_header_id
                    AND org.organization_id(+) = rsl.from_organization_id
                    AND apt.term_id = poh.terms_id
                    AND poh.po_header_id = pol.po_header_id
                    AND pov.vendor_id(+) = rt.vendor_id
                    AND poh.po_header_id(+) = rt.po_header_id
                    AND pol.po_line_id(+) = rt.po_line_id
                    AND org.LANGUAGE(+) = USERENV ('LANG')
                    AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                          FROM RCV_TRANSACTIONS RTS
                          WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                          and rts.po_line_id = pol.PO_LINE_ID
                          AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE')
                          )
                    and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                    AND pol.po_line_id = plla.po_line_id
                    AND poh.segment1 = '$po_numberInv'
                    ");
        return $sql->result_array();
    }

    public function getInvoiceById($id)
    {
        $oracle = $this->load->database('erp',true);
        $query = "SELECT * FROM ap.ap_invoice_purchase_order aipo, ap.ap_monitoring_invoice ami WHERE aipo.invoice_id = ami.invoice_id and ami.invoice_id = $id ";
        // print_r($query);exit();
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

     public function getInvoiceByPoId($id)
    {
        $oracle = $this->load->database('erp',true);
        $query = "SELECT * FROM ap.ap_invoice_purchase_order aipo, ap.ap_monitoring_invoice ami WHERE aipo.invoice_id = ami.invoice_id AND aipo.invoice_id = $id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function savePoNumber($po_number,$lppb_number, $shipment_number,$received_date,$item_description,$item_code,  $qty_receipt, $qty_reject, $currency, $unit_price, $qty_invoice,$inv_id){
        $oracle = $this->load->database('erp',true);
        $query = "INSERT INTO ap.ap_invoice_purchase_order
                    (po_number, lppb_number, shipment_number,
                    received_date,item_description,item_code,qty_receipt, qty_reject, currency, unit_price, qty_invoice,invoice_id)
                    VALUES 
                    ('$po_number','$lppb_number', '$shipment_number', '$received_date', '$item_description', '$item_code','$qty_receipt', '$qty_reject', '$currency', '$unit_price', '$qty_invoice', $inv_id)";
        $oracle->query($query);
    }

    public function savePoNumber2($invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendor_number,$vendor_name){
        $oracle = $this->load->database('erp',true);
        $query = "INSERT INTO ap.ap_monitoring_invoice
                    (invoice_number, invoice_date, invoice_amount,
                    tax_invoice_number, vendor_number, vendor_name)
                    VALUES 
                    ('$invoice_number','$invoice_date','$invoice_amount', '$tax_invoice_number','$vendor_number','$vendor_name')";
        $oracle->query($query);

        $query = "SELECT lastval()";
        $lastId = $oracle->query($query);
        return $lastId->result_array();
    }

    public function getVendorName(){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT *
                  FROM po_vendors pov";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
 
    }

    public function namavendor($vendor_number){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT pov.vendor_name
                  FROM po_vendors pov
                  WHERE pov.vendor_id = '$vendor_number'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
 
    }


    public function showInvoice(){
        $oracle = $this->load->database('erp', true);
        $query = "SELECT ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason,
                         aipo.po_number po_number, 
                         ami.invoice_id invoice_id,
                         aipo.lppb_number lppb_number,
                         aipo.invoice_po_id invoice_po_id
                FROM ap.ap_monitoring_invoice ami
                JOIN ap.ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE purchasing_batch_number is NULL";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function getUnitPrice($invoice_id){
        $oracle = $this->load->database('erp',true);
        $query = "SELECT unit_price , qty_invoice 
                  FROM ap.ap_invoice_purchase_order
                    WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function deleteInvoice($invoice_id){
        $oracle = $this->load->database('erp',true);
        $query1 = "DELETE 
                    FROM ap.ap_invoice_purchase_order
                    WHERE invoice_id = '$invoice_id' ";
        $runQuery1 = $oracle->query($query1);

        $query2 = "DELETE 
                    FROM ap.ap_monitoring_invoice
                    WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
    }

    public function showEditList1($invoice_id){
        $oracle = $this->load->database('erp',true);
        $query = "SELECT invoice_id invoice_id, 
                    po_number po_number,
                    lppb_number lppb_number,
                    shipment_number shipment_number,
                    received_date received_date,
                    item_description item_description,
                    qty_invoice qty_invoice,
                    qty_reject qty_reject,
                    currency currency,
                    unit_price
                  FROM ap.ap_invoice_purchase_order aipo
                
                  WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function showEditList2($invoice_id){
        $oracle = $this->load->database('erp', true);
        $query = "SELECT invoice_id invoice_id,
                         invoice_number invoice_number, 
                         invoice_date invoice_date, 
                         tax_invoice_number tax_invoice_number,
                         invoice_amount invoice_amount
                FROM ap.ap_monitoring_invoice
                WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function saveEditInvoice1($invoice_id,$po_number,$lppb_number,$shipment_number,$received_date,$item_description,$qty_receipt,$qty_reject,$currency,$unit_price,$qty_invoice){
        $oracle = $this->load->database('erp',true);
        $query = "UPDATE ap.ap_invoice_purchase_order 
        SET po_number = '$po_number',
            lppb_number = '$lppb_number',
            shipment_number = '$shipment_number',
            received_date = '$received_date',
            item_description = '$item_description',
            qty_receipt = '$qty_receipt',
            qty_reject = '$qty_reject',
            currency = '$currency',
            unit_price = '$unit_price',
            qty_invoice = '$qty_invoice'
        WHERE invoice_id = '$invoice_id' ";
        $runQuery = $oracle->query($query);

        
    }

    public function saveEditInvoice2($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendor_name,$vendor_number)
    {
       $oracle = $this->load->database('erp',true);
       $query2 = "UPDATE ap.ap_monitoring_invoice 
                  SET invoice_number = '$invoice_number', 
                    invoice_date = '$invoice_date',
                    invoice_amount = '$invoice_amount',
                    tax_invoice_number = '$tax_invoice_number',
                    vendor_name = '$vendor_name', 
                    vendor_number = '$vendor_number'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
    }

    public function saveBatchNumberById($id, $num, $date){
        $oracle = $this->load->database('erp',true);
        $query = "UPDATE ap.ap_monitoring_invoice
                    SET purchasing_batch_number = '$num',
                    last_status_purchasing_date = '$date'
                    WHERE invoice_id = '$id'";
        $oracle->query($query);
    }

    public function checkNumBatchExist()
    {
        $oracle = $this->load->database('erp',true);
        $sql = "SELECT max(purchasing_batch_number) batch_num
                  FROM ap.ap_monitoring_invoice LIMIT 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function showListSubmitted(){
        $oracle = $this->load->database('erp',true);
        $sql = "SELECT purchasing_batch_number batch_num, last_status_purchasing_date submited_date
                FROM ap.ap_monitoring_invoice
                WHERE purchasing_batch_number is not null
                GROUP BY batch_num, submited_date 
                ORDER BY batch_num";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getJmlInvPerBatch($batch){
        $oracle = $this->load->database('erp',true);
        $sql = "SELECT purchasing_batch_number FROM ap.ap_monitoring_invoice WHERE purchasing_batch_number = $batch";
        $query = $oracle->query($sql);
        return $query->num_rows();
    }

    public function showDetailPerBatch($batch){
        $oracle = $this->load->database('erp',true);
        $sql = "SELECT invoice_id invoice_id,
                         invoice_number invoice_number, 
                         invoice_date invoice_date, 
                         tax_invoice_number tax_invoice_number,
                         invoice_amount invoice_amount, 
                         last_purchasing_invoice_status status, 
                         reason reason
                FROM ap.ap_monitoring_invoice WHERE purchasing_batch_number = $batch";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function showInvoiceInDetail($invoice_id){
        $oracle = $this->load->database('erp', true);
        $query = "SELECT invoice_id invoice_id,
                         vendor_name vendor_name,
                         invoice_number invoice_number, 
                         invoice_date invoice_date, 
                         tax_invoice_number tax_invoice_number,
                         invoice_amount invoice_amount, 
                         last_purchasing_invoice_status status, 
                         reason reason
                FROM ap.ap_monitoring_invoice
                WHERE invoice_id = '$invoice_id'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function showInvoiceInDetail2($invoice_id){
        $oracle = $this->load->database('erp', true);
        $query = "SELECT invoice_id invoice_id,
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
                FROM ap.ap_invoice_purchase_order 
                WHERE invoice_id = '$invoice_id'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function getNamaVendor($vendor_id){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT vendor_name , vendor_id
                FROM po_vendors pov 
                WHERE vendor_id = '$vendor_id'";
        $runQuery = $oracle->query($sql);
        return $runQuery->result_array();
    }

    public function checkInvoiceDate($uw){
        $erp = $this->load->database('erp',true);
        $sql = "SELECT invoice_date
                FROM ap.ap_monitoring_invoice
                WHERE invoice_date = '$uw' limit 1";
        $runQuery = $erp->query($sql);
        return $runQuery->result_array();
    }

    public function checkInvoiceDatecount($uw){
        $erp = $this->load->database('erp',true);
        $sql = "SELECT invoice_date
                FROM ap.ap_monitoring_invoice
                WHERE invoice_date = '$uw'";
        $runQuery = $erp->query($sql);
        return $runQuery->result_array();
    }

     public function checkListSubmitted($po_number,$lppb_number)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = $oracle->query("SELECT DISTINCT
                pol.po_line_id line_id,
                pol.line_num line_num,
                rsh.receipt_num no_lppb, 
                rsh.shipment_num shipment,
                rt.transaction_type status_lppb, 
                rsh.creation_date transaction,
                DECODE (rt.source_document_code,
                        'PO', pov.vendor_name,
                        'RMA', NULL,
                        org.NAME
                       ) vendor_name,
                poh.segment1 no_po,
                pol.unit_price unit_price,
                rt.currency_code currency,
                plla.quantity_received received,
                plla.quantity_rejected rejected, 
                pol.item_description description,
                msib.SEGMENT1 item_code,
                plla.quantity_billed quantity_billed
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                rcv_transactions rt,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                ap_terms apt,
                po_line_locations_all plla,
                mtl_system_items_b msib
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND org.organization_id(+) = rsl.from_organization_id
            AND apt.term_id = poh.terms_id
            AND poh.po_header_id = pol.po_header_id
            AND pov.vendor_id(+) = rt.vendor_id
            AND poh.po_header_id(+) = rt.po_header_id
            AND pol.po_line_id(+) = rt.po_line_id
            AND org.LANGUAGE(+) = USERENV ('LANG')
            AND pol.po_line_id = plla.po_line_id
            AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                          FROM RCV_TRANSACTIONS RTS
                          WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                          and rts.po_line_id = pol.PO_LINE_ID
                          AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE')
                          )
            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
            AND poh.segment1 = $po_number
            and rsh.receipt_num = $lppb_number");
        return $query->result_array();
    }

     public function checkStatus($po_number,$lppb,$item_id,$qty_reject,$qty_receipt,$unit_price)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT DISTINCT
                pol.po_line_id line_id,
                pol.line_num line_num,
                rsh.receipt_num no_lppb, 
                rsh.shipment_num shipment,
                rt.transaction_type status_lppb, 
                rsh.creation_date transaction,
                DECODE (rt.source_document_code,
                        'PO', pov.vendor_name,
                        'RMA', NULL,
                        org.NAME
                       ) vendor_name,
                poh.segment1 no_po,
                pol.unit_price unit_price,
                rt.currency_code currency,
                plla.quantity_received received,
                plla.quantity_rejected rejected, 
                pol.item_description description,
                msib.SEGMENT1 item_code,
                plla.quantity_billed quantity_billed
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                rcv_transactions rt,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                ap_terms apt,
                po_line_locations_all plla,
                mtl_system_items_b msib
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND org.organization_id(+) = rsl.from_organization_id
            AND apt.term_id = poh.terms_id
            AND poh.po_header_id = pol.po_header_id
            AND pov.vendor_id(+) = rt.vendor_id
            AND poh.po_header_id(+) = rt.po_header_id
            AND pol.po_line_id(+) = rt.po_line_id
            AND org.LANGUAGE(+) = USERENV ('LANG')
            AND pol.po_line_id = plla.po_line_id
            AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                          FROM RCV_TRANSACTIONS RTS
                          WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                          and rts.po_line_id = pol.PO_LINE_ID
                          AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE')
                          )
            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
            AND poh.segment1 = $po_number
            and rsh.receipt_num = $lppb
            and msib.SEGMENT1 = '$item_id'
            and plla.quantity_rejected = '$qty_reject'
            and  plla.quantity_received = '$qty_receipt'
            and pol.unit_price = '$unit_price'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function exportExcelMonitoringInvoice($dateFrom,$dateTo){
        $oracle = $this->load->database('erp', true);
        $query = "SELECT ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason,
                         aipo.po_number po_number, 
                         ami.invoice_id invoice_id,
                         aipo.lppb_number lppb_number,
                         ami.vendor_name vendor_name,
                         aipo.currency currency,
                         ami.last_status_finance_date last_status_finance_date,
                         ami.last_status_purchasing_date last_status_purchasing_date,
                         aipo.received_date received_date,
                         ami.reason reason
                FROM ap.ap_monitoring_invoice ami
                JOIN ap.ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.invoice_date BETWEEN TO_DATE('$dateFrom','dd/mm/yyyy') AND TO_DATE('$dateTo','dd/mm/yyyy')";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function podetails($po_number,$lppb_number){
       $oracle = $this->load->database('oracle',TRUE);
        $query = $oracle->query("SELECT DISTINCT
                poh.segment1||'-'||pol.line_num||'-'||rsh.receipt_num||'-'||rt.transaction_type as po_detail
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                rcv_transactions rt,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                ap_terms apt,
                po_line_locations_all plla,
                mtl_system_items_b msib
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND org.organization_id(+) = rsl.from_organization_id
            AND apt.term_id = poh.terms_id
            AND poh.po_header_id = pol.po_header_id
            AND pov.vendor_id(+) = rt.vendor_id
            AND poh.po_header_id(+) = rt.po_header_id
            AND pol.po_line_id(+) = rt.po_line_id
            AND org.LANGUAGE(+) = USERENV ('LANG')
            AND pol.po_line_id = plla.po_line_id
            AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                          FROM RCV_TRANSACTIONS RTS
                          WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                          and rts.po_line_id = pol.PO_LINE_ID
                          AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE')
                          )
            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
            AND poh.segment1 = $po_number
            and rsh.receipt_num = $lppb_number");
        return $query->result_array();
    }
}