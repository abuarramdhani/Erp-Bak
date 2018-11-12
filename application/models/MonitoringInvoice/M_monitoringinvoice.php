<?php
class M_monitoringinvoice extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

	public function getInvNumber($po_numberInv){
		$oracle = $this->load->database("oracle",TRUE);
		$query = $oracle->query("SELECT DISTINCT 
                pol.po_line_id line_id, 
                pol.line_num line_num,
                poh.segment1 no_po, 
                pov.vendor_name vendor_name,
                pol.unit_price unit_price,
                pll.quantity_rejected rejected,
                pol.item_description description,
                pll.quantity_billed quantity_billed, 
                rsh.receipt_num no_lppb,
                poh.currency_code currency, 
                rsh.shipment_num shipment,
                rt.transaction_type status,
                 rt.quantity qty_receipt,
                rsh.creation_date TRANSACTION, 
                msib.segment1 item_id,
                pol.quantity quantity
           FROM rcv_shipment_headers rsh,
                rcv_shipment_lines rsl,
                po_vendors pov,
                rcv_transactions rt,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                mtl_system_items_b msib
          WHERE rsh.shipment_header_id = rsl.shipment_header_id
            AND rsh.shipment_header_id = rt.shipment_header_id
            AND org.organization_id(+) = rsl.from_organization_id
            AND rsl.shipment_line_id = rt.shipment_line_id
            AND pov.vendor_id = rt.vendor_id
            AND poh.po_header_id = rt.po_header_id
            AND pol.po_line_id = rt.po_line_id
            AND rt.transaction_id =
                   (SELECT MAX (rts.transaction_id)
                      FROM rcv_transactions rts
                     WHERE rt.shipment_header_id = rts.shipment_header_id
                       AND rts.po_line_id = pol.po_line_id
                       AND rts.transaction_type IN
                              ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE','TRANSFER'))
            AND msib.inventory_item_id = pol.item_id
            AND msib.organization_id = 81
            AND poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND poh.segment1 = '$po_numberInv'
UNION ALL
SELECT DISTINCT pol.po_line_id line_id, 
                pol.line_num line_num,
                poh.segment1 no_po, 
                pov.vendor_name vendor_name,
                pol.unit_price unit_price, 
                pll.quantity_rejected rejected,
                pol.item_description description,
                pll.quantity_billed quantity_billed, 
                NULL no_lppb,
                poh.currency_code currency, 
                NULL shipment, 
                NULL status,
                NULL qty_receipt,
                NULL TRANSACTION, 
                msib.segment1 item_id,
                pol.quantity quantity
           FROM po_vendors pov,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                mtl_system_items_b msib
          WHERE poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND msib.inventory_item_id = pol.item_id
            AND msib.organization_id = 81
            AND poh.segment1 = '$po_numberInv'
            AND pol.po_line_id NOT IN (
                   SELECT rt.po_line_id
                     FROM rcv_transactions rt
                    WHERE pol.po_line_id = rt.po_line_id)");
		return $query->result_array();
	}


    public function getInvoiceById($id)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT * FROM khs_ap_invoice_purchase_order aipo, khs_ap_monitoring_invoice ami WHERE aipo.invoice_id = ami.invoice_id and aipo.invoice_id = $id ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function savePoNumber($line_number,$po_number,$lppb_number, $shipment_number,$received_date,$item_description,$item_code,  $qty_receipt, $qty_reject, $currency, $unit_price, $qty_invoice,$inv_id){
            if ($received_date == '' || $received_date == '  ' || $received_date == NULL || !$received_date) {
                $received_date = 'NULL';
            }else{
                $received_date = "'".$received_date."'";
            }

            if ($qty_receipt == '' || $qty_receipt == '  ' || $qty_receipt == NULL || !$qty_receipt) {
                $qty_receipt = 0;
            } else {
                $qty_receipt = $qty_receipt;
            }

            if ($lppb_number == '' || $lppb_number == '  ' || $lppb_number == NULL || !$lppb_number) {
                $lppb_number = 0;
            } else {
                $lppb_number = $lppb_number;
            }
            
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_ap_invoice_purchase_order
                    (line_number,po_number, lppb_number, shipment_number,
                    received_date,item_description,item_code,qty_receipt, qty_reject, currency, unit_price, qty_invoice,invoice_id)
                    VALUES 
                    ('$line_number','$po_number',$lppb_number, '$shipment_number', $received_date, '$item_description', '$item_code',$qty_receipt, $qty_reject, '$currency', '$unit_price', '$qty_invoice', $inv_id) ";
        $oracle->query($query);
    }

    public function savePoNumber2($invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendor_number,$vendor_name){
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_ap_monitoring_invoice
                    (invoice_number, invoice_date, invoice_amount,tax_invoice_number, vendor_number, vendor_name)
                    VALUES 
                    ('$invoice_number','$invoice_date','$invoice_amount', '$tax_invoice_number','$vendor_number','$vendor_name')";
        $oracle->query($query);

        if ($vendor_name) {
            $qvendorname = "vendor_name = '$vendor_name'";
        } else {
            $qvendorname = "vendor_name is null";
        }

        if ($invoice_number) {
            $qinvoicenum = "invoice_number = '$invoice_number'";
        } else {
            $qinvoicenum = "invoice_number is null";
        }

        $query2 = "SELECT invoice_id 
                    from khs_ap_monitoring_invoice 
                    where $qinvoicenum 
                        and $qvendorname";
        $lastId = $oracle->query($query2);
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
        $query = "SELECT pov.vendor_name,pov.vendor_id
                  FROM po_vendors pov
                  WHERE pov.vendor_id = '$vendor_number'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
 
    }


    public function showInvoice(){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason,
                         ami.invoice_id invoice_id,
                         ami.purchasing_batch_number purchasing_batch_number,
                         aaipo.po_detail po_detail,
                         aaipo.po_number
                FROM khs_ap_monitoring_invoice ami,
                 (select aipo.invoice_id, aipo.po_number, replace((rtrim (xmlagg (xmlelement (e, to_char(aipo.po_number || '-' || aipo.line_number || '-' || aipo.lppb_number) || '@')).extract ('//text()'), '@')), '@', '<br>') po_detail
                from khs_ap_invoice_purchase_order aipo
                group by aipo.invoice_id , aipo.po_number) aaipo
                where aaipo.invoice_id = ami.invoice_id
                and ami.purchasing_batch_number is null
                order by ami.invoice_id
                ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function getUnitPrice($invoice_id){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT unit_price , qty_invoice 
                  FROM khs_ap_invoice_purchase_order
                    WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function deleteInvoice($invoice_id){
        $oracle = $this->load->database('oracle',true);
        $query1 = "DELETE 
                    FROM khs_ap_invoice_purchase_order
                    WHERE invoice_id = '$invoice_id' ";
        $runQuery1 = $oracle->query($query1);

        $query2 = "DELETE 
                    FROM khs_ap_monitoring_invoice
                    WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
    }

    public function showEditList1($invoice_id){
        $oracle = $this->load->database('oracle',true);
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
                  FROM khs_ap_invoice_purchase_order aipo
                
                  WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function showEditList2($invoice_id){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT invoice_id invoice_id,
                         invoice_number invoice_number, 
                         invoice_date invoice_date, 
                         tax_invoice_number tax_invoice_number,
                         invoice_amount invoice_amount,
                         vendor_name vendor_name
                FROM khs_ap_monitoring_invoice
                WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function saveEditInvoice1($invoice_id,$po_number,$lppb_number,$shipment_number,$received_date,$item_description,$qty_receipt,$qty_reject,$currency,$unit_price,$qty_invoice){
        if ($received_date == '' || $received_date == '  ' || $received_date == NULL || !$received_date) {
                $received_date = 'NULL';
            }else{
                $received_date = "".$received_date."";
            }

            if ($qty_receipt == '' || $qty_receipt == '  ' || $qty_receipt == NULL || !$qty_receipt) {
                $qty_receipt = 0;
            } else {
                $qty_receipt = $qty_receipt;
            }

            if ($lppb_number == '' || $lppb_number == '  ' || $lppb_number == NULL || !$lppb_number) {
                $lppb_number = 0;
            } else {
                $lppb_number = $lppb_number;
            }

        $oracle = $this->load->database('oracle',true);
        $query = "UPDATE khs_ap_invoice_purchase_order 
        SET po_number = '$po_number',
            lppb_number = $lppb_number,
            shipment_number = '$shipment_number',
            received_date = '$received_date',
            item_description = '$item_description',
            qty_receipt = $qty_receipt,
            qty_reject = $qty_reject,
            currency = '$currency',
            unit_price = '$unit_price',
            qty_invoice = '$qty_invoice'
        WHERE invoice_id = $invoice_id ";
        $runQuery = $oracle->query($query);

        
    }

    public function saveEditInvoice2($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendor_name,$vendor_number)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET invoice_number = '$invoice_number', 
                    invoice_date = '$invoice_date',
                    invoice_amount = '$invoice_amount',
                    tax_invoice_number = '$tax_invoice_number',
                    vendor_name = '$vendor_name', 
                    vendor_number = '$vendor_number'
                 WHERE invoice_id = $invoice_id ";
        $runQuery2 = $oracle->query($query2);
    }

    public function saveBatchNumberById($id, $num, $date){
        $oracle = $this->load->database('oracle',true);
        $query = "UPDATE khs_ap_monitoring_invoice
                    SET purchasing_batch_number = '$num',
                    last_status_purchasing_date = to_date('$date', 'DD/MM/YYYY HH24:MI:SS')
                    WHERE invoice_id = $id";
        $oracle->query($query);
    }

    public function checkNumBatchExist()
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT max(purchasing_batch_number) batch_num
                  FROM khs_ap_monitoring_invoice 
                  WHERE ROWNUM >= 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function showListSubmitted(){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct purchasing_batch_number batch_num, last_status_purchasing_date submited_date, last_purchasing_invoice_status last_purchasing_invoice_status
                FROM khs_ap_monitoring_invoice
                WHERE purchasing_batch_number is not null
                ORDER BY batch_num";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getJmlInvPerBatch($batch){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT  purchasing_batch_number FROM khs_ap_monitoring_invoice WHERE purchasing_batch_number = $batch";
        $query = $oracle->query($sql);
        return $query->num_rows();
    }

     public function batch_number($batch){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT  purchasing_batch_number FROM khs_ap_monitoring_invoice WHERE purchasing_batch_number = $batch";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function showDetailPerBatch($batch){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct invoice_id invoice_id,
                         invoice_number invoice_number, 
                         invoice_date invoice_date, 
                         tax_invoice_number tax_invoice_number,
                         invoice_amount invoice_amount, 
                         last_purchasing_invoice_status status, 
                         reason reason,
                         purchasing_batch_number batch_num
                FROM khs_ap_monitoring_invoice WHERE purchasing_batch_number = $batch";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function showInvoiceInDetail($invoice_id){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT distinct invoice_id invoice_id,
                         vendor_name vendor_name,
                         invoice_number invoice_number, 
                         invoice_date invoice_date, 
                         tax_invoice_number tax_invoice_number,
                         invoice_amount invoice_amount, 
                         last_purchasing_invoice_status status, 
                         reason reason
                FROM khs_ap_monitoring_invoice
                WHERE invoice_id = '$invoice_id'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function showInvoiceInDetail2($invoice_id){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT distinct invoice_id invoice_id,
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
                FROM khs_ap_invoice_purchase_order 
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
    $erp_db = $this->load->database('oracle',true); 
    $sql = "SELECT invoice_date FROM
            khs_ap_monitoring_invoice WHERE invoice_date = to_date('$uw',
            'DD/MM/YYYY') AND ROWNUM = 1"; 
            $runQuery = $erp_db->query($sql); 
    return $runQuery->result_array(); 
    }

    public function checkInvoiceDatecount($uw){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT invoice_date
                FROM khs_ap_monitoring_invoice
                WHERE invoice_date = to_date('$uw', 'DD/MM/YYYY')";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }


     public function checkStatus($po_number,$line_num)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT distinct
                            rt.transaction_type status
                            from rcv_shipment_headers rsh
                            ,rcv_shipment_lines rsl
                            ,PO_VENDORS POV
                            ,RCV_TRANSACTIONS RT
                            ,HR_ALL_ORGANIZATION_UNITS_TL ORG
                            ,PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                            ,PO_LINE_LOCATIONS_ALL PLL
                            ,MTL_SYSTEM_ITEMS_B msib
                        where rsh.shipment_header_id = rsl.shipment_header_id 
                        and RSH.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID
                        AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                        AND rsl.shipment_line_id = rt.shipment_line_id
                        AND POV.VENDOR_ID = RT.VENDOR_ID
                        AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                        AND POL.PO_LINE_ID = RT.PO_LINE_ID
                        AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                                                  FROM RCV_TRANSACTIONS RTS
                                                  WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                                                  and rts.po_line_id = pol.PO_LINE_ID
                                                  AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE','TRANSFER'))
                        and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                        and msib.ORGANIZATION_ID = 81
                        and poh.po_header_id(+) = pol.po_header_id
                        AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                        AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                        and poh.segment1 = $po_number 
                        and pol.line_num = $line_num
                        union
                        SELECT distinct 
                                    NULL status
                        FROM PO_VENDORS POV
                            ,PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                            ,PO_LINE_LOCATIONS_ALL PLL
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and poh.segment1 = '$po_number' 
                            and pol.line_num = $line_num";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function exportExcelMonitoringInvoice($batch_num){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT distinct ami.invoice_number invoice_number, 
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
                         ami.reason reason,
                         ami.purchasing_batch_number batch_num,
                         aipo.line_number line_number
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.purchasing_batch_number = '$batch_num'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
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

    public function savePoNumberNew($line_number,$po_number,$lppb_number, $shipment_number,$received_date,$item_description,$item_code,  $qty_receipt, $qty_reject, $currency, $unit_price, $qty_invoice,$id){
        if ($received_date == '' || $received_date == '  ' || $received_date == NULL || !$received_date) {
                $received_date = 'NULL';
            }else{
                $received_date = "".$received_date."";
            }

            if ($qty_receipt == '' || $qty_receipt == '  ' || $qty_receipt == NULL || !$qty_receipt) {
                $qty_receipt = 0;
            } else {
                $qty_receipt = $qty_receipt;
            }

            if ($lppb_number == '' || $lppb_number == '  ' || $lppb_number == NULL || !$lppb_number) {
                $lppb_number = 0;
            } else {
                $lppb_number = $lppb_number;
            }

        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_ap_invoice_purchase_order
                    (line_number,po_number, lppb_number, shipment_number,
                    received_date,item_description,item_code,qty_receipt, qty_reject, currency, unit_price, qty_invoice,invoice_id)
                    VALUES 
                    ($line_number,'$po_number',$lppb_number, '$shipment_number', '$received_date', '$item_description', '$item_code',$qty_receipt, $qty_reject, '$currency', '$unit_price', '$qty_invoice',$id)";
        $oracle->query($query);
    }

    public function saveInvoiveAmount($invoice_amount,$invoice_id)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET invoice_amount = '$invoice_amount'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
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

    public function tax_invoice_number($invoice_id,$tax_invoice_number)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET tax_invoice_number = '$tax_invoice_number'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
    }


    public function cekpo_number($po_number,$line_number){
        $oracle = $this->load->database("oracle",TRUE);
        $query = $oracle->query("SELECT distinct
                                    pol.po_line_id line_id,
                                    pol.line_num line_num,
                                    poh.SEGMENT1 no_po,
                                    pov.VENDOR_NAME vendor_name,
                                    pol.unit_price unit_price,
                                    pll.quantity_rejected rejected, 
                                    pol.item_description description,
                                    pll.quantity_billed quantity_billed,
                                    rsh.receipt_num no_lppb,
                                    poh.CURRENCY_CODE currency, 
                                    rsh.shipment_num shipment,
                                    rt.transaction_type status, 
                                    rt.quantity qty_receipt,
                                    rsh.creation_date transaction,
                                    msib.SEGMENT1 item_id,
                                    pol.QUANTITY quantity
                            from rcv_shipment_headers rsh
                            ,rcv_shipment_lines rsl
                            ,PO_VENDORS POV
                            ,RCV_TRANSACTIONS RT
                            ,HR_ALL_ORGANIZATION_UNITS_TL ORG
                            ,PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                            ,PO_LINE_LOCATIONS_ALL PLL
                            ,MTL_SYSTEM_ITEMS_B msib
                            ,khs_ap_monitoring_invoice ami
                            ,khs_ap_invoice_purchase_order aipo
                        where rsh.shipment_header_id = rsl.shipment_header_id 
                        and RSH.SHIPMENT_HEADER_ID = RT.SHIPMENT_HEADER_ID
                        AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                        AND rsl.shipment_line_id = rt.shipment_line_id
                        AND POV.VENDOR_ID = RT.VENDOR_ID
                        AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                        AND POL.PO_LINE_ID = RT.PO_LINE_ID
                        AND RT.TRANSACTION_ID = (SELECT MAX(RTS.TRANSACTION_ID)
                                                  FROM RCV_TRANSACTIONS RTS
                                                  WHERE RT.SHIPMENT_HEADER_ID = RTS.SHIPMENT_HEADER_ID
                                                  and rts.po_line_id = pol.PO_LINE_ID
                                                  AND RTS.TRANSACTION_TYPE IN ('REJECT','DELIVER','ACCEPT','RECEIVE','TRANSFER'))
                        and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                        and msib.ORGANIZATION_ID = 81
                        and poh.po_header_id(+) = pol.po_header_id
                        AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                        AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                        AND aipo.invoice_id = ami.invoice_id
                        AND aipo.line_number(+) = pol.LINE_NUM
                        and aipo.line_number not in ($line_number)
                        and poh.segment1 = '$po_number'
                        union all
                        SELECT distinct 
                                    pol.po_line_id line_id,
                                    pol.line_num line_num,
                                    poh.SEGMENT1 no_po,
                                    pov.VENDOR_NAME vendor_name,
                                    pol.unit_price unit_price,
                                    pll.quantity_rejected rejected, 
                                    pol.item_description description,
                                    pll.quantity_billed quantity_billed,
                                    NULL no_lppb,
                                    poh.CURRENCY_CODE currency, 
                                    NULL shipment,
                                    NULL status, 
                                    NULL qty_receipt,
                                    NULL transaction,
                                    msib.segment1 item_id,
                                    pol.QUANTITY quantity
                        FROM PO_VENDORS POV
                            ,HR_ALL_ORGANIZATION_UNITS_TL ORG
                            ,PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                            ,PO_LINE_LOCATIONS_ALL PLL
                            ,MTL_SYSTEM_ITEMS_B msib
                            ,khs_ap_monitoring_invoice ami
                            ,khs_ap_invoice_purchase_order aipo
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                            and msib.ORGANIZATION_ID = 81
                            AND aipo.invoice_id = ami.invoice_id
                            AND aipo.line_number(+) = pol.LINE_NUM
                            and aipo.line_number not in ($line_number)
                            and poh.segment1 = '$po_number'
                            AND pol.po_line_id NOT IN (
                               SELECT rt.po_line_id
                                 FROM rcv_transactions rt
                                WHERE pol.po_line_id = rt.po_line_id)");
        return $query->result_array();
    }

    public function invoicereject()
    {
        $oracle = $this->load->database("oracle",TRUE);
        $query = "SELECT  distinct  ami.invoice_number invoice_number,
                            ami.invoice_date invoice_date,
                            ami.tax_invoice_number tax_invoice_number,
                            ami.invoice_amount invoice_amount,
                            ami.reason reason,
                            ami.last_purchasing_invoice_status last_purchasing_invoice_status,
                            aipo.invoice_id invoice_id,
                            ami.last_status_purchasing_date last_status_purchasing_date,
                            ami.purchasing_batch_number purchasing_batch_number
                            FROM khs_ap_invoice_purchase_order aipo, khs_ap_monitoring_invoice ami 
                            WHERE aipo.invoice_id = ami.invoice_id 
                            and last_purchasing_invoice_status = 3";
        $run = $oracle->query($query);
        return $run->result_array();
    }
}