<?php
class M_monitoringinvoice extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

	public function getInvNumber($po_numberInv){
		$oracle = $this->load->database("oracle",TRUE);
		$query = $oracle->query("SELECT *
                    FROM (SELECT distinct
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
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                            and msib.ORGANIZATION_ID = 81
                            and pol.po_line_id not in (
                                        SELECT 
                                                 pol.PO_LINE_ID
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
                                            AND rsl.shipment_line_id = rt.shipment_line_id
                                            AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                                            AND POV.VENDOR_ID = RT.VENDOR_ID
                                            AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                                            AND POL.PO_LINE_ID = RT.PO_LINE_ID
                                            AND org.LANGUAGE(+) = USERENV ('LANG')
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
                                        )
                        )
                    WHERE no_po = '$po_numberInv'
                    order by line_num");
		return $query->result_array();
	}

    public function statusPo($po_numberInv){
        $oracle = $this->load->database('oracle',TRUE);
        $sql = $oracle->query("SELECT *
                    FROM (SELECT distinct pol.line_num line_num,
                                    pll.quantity_billed quantity_billed, 
                                    rt.transaction_type transaction_type,
                                    poh.segment1 no_po
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
                        union all
                        SELECT distinct pol.line_num line_num,
                                    pll.quantity_billed quantity_billed,
                                    NULL transaction_type,
                                    poh.segment1 no_po
                        FROM PO_VENDORS POV
                            ,HR_ALL_ORGANIZATION_UNITS_TL ORG
                            ,PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                            ,PO_LINE_LOCATIONS_ALL PLL
                            ,MTL_SYSTEM_ITEMS_B msib
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and pol.po_line_id not in (
                                        SELECT 
                                                 pol.PO_LINE_ID
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
                                            AND rsl.shipment_line_id = rt.shipment_line_id
                                            AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                                            AND POV.VENDOR_ID = RT.VENDOR_ID
                                            AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                                            AND POL.PO_LINE_ID = RT.PO_LINE_ID
                                            AND org.LANGUAGE(+) = USERENV ('LANG')
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
                                        )
                        )
                    WHERE no_po = '$po_numberInv'
                    order by line_num ");
        return $sql->result_array();
    }

    public function getInvoiceById($id)
    {
        $oracle = $this->load->database('erp_db',true);
        $query = "SELECT * FROM ap.ap_invoice_purchase_order aipo, ap.ap_monitoring_invoice ami WHERE aipo.invoice_id = ami.invoice_id and aipo.invoice_id = $id ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

     public function getInvoiceByPoId($id)
    {
        $oracle = $this->load->database('erp_db',true);
        $query = "SELECT * FROM ap.ap_invoice_purchase_order aipo, ap.ap_monitoring_invoice ami WHERE aipo.invoice_id = ami.invoice_id AND aipo.invoice_id = $id";
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
            
        $oracle = $this->load->database('erp_db',true);
        $query = "INSERT INTO ap.ap_invoice_purchase_order
                    (line_number,po_number, lppb_number, shipment_number,
                    received_date,item_description,item_code,qty_receipt, qty_reject, currency, unit_price, qty_invoice,invoice_id)
                    VALUES 
                    ('$line_number','$po_number','$lppb_number', '$shipment_number', $received_date, '$item_description', '$item_code',$qty_receipt, $qty_reject, '$currency', '$unit_price', '$qty_invoice', $inv_id)";
        $oracle->query($query);
    }

    public function savePoNumber2($invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendor_number,$vendor_name){
        $oracle = $this->load->database('erp_db',true);
        $query = "INSERT INTO ap.ap_monitoring_invoice
                    (invoice_number, invoice_date, invoice_amount,tax_invoice_number, vendor_number, vendor_name)
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
        $oracle = $this->load->database('erp_db', true);
        $query = "SELECT distinct ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason,
                         ami.invoice_id invoice_id,
                         aaipo.po_number po_number,
                         ami.purchasing_batch_number purchasing_batch_number,
                         (SELECT string_agg(concat(aipo.po_number,'-',aipo.lppb_number,'- ',aipo.line_number),'<br>') FROM ap.ap_invoice_purchase_order aipo where ami.invoice_id = aipo.invoice_id) AS po_detail
                            FROM ap.ap_monitoring_invoice ami,
                        (select aipo.* from ap.ap_invoice_purchase_order aipo) aaipo
                        where aaipo.invoice_id = ami.invoice_id
                        and ami.purchasing_batch_number is null
                order by ami.invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function getUnitPrice($invoice_id){
        $oracle = $this->load->database('erp_db',true);
        $query = "SELECT unit_price , qty_invoice 
                  FROM ap.ap_invoice_purchase_order
                    WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function deleteInvoice($invoice_id){
        $oracle = $this->load->database('erp_db',true);
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
        $oracle = $this->load->database('erp_db',true);
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
        $oracle = $this->load->database('erp_db', true);
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

        $oracle = $this->load->database('erp_db',true);
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
       $oracle = $this->load->database('erp_db',true);
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
        $oracle = $this->load->database('erp_db',true);
        $query = "UPDATE ap.ap_monitoring_invoice
                    SET purchasing_batch_number = '$num',
                    last_status_purchasing_date = '$date'
                    WHERE invoice_id = '$id'";
        $oracle->query($query);
    }

    public function checkNumBatchExist()
    {
        $oracle = $this->load->database('erp_db',true);
        $sql = "SELECT max(purchasing_batch_number) batch_num
                  FROM ap.ap_monitoring_invoice LIMIT 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function showListSubmitted(){
        $oracle = $this->load->database('erp_db',true);
        $sql = "SELECT purchasing_batch_number batch_num, last_status_purchasing_date submited_date, last_purchasing_invoice_status last_purchasing_invoice_status
                FROM ap.ap_monitoring_invoice
                WHERE purchasing_batch_number is not null
                GROUP BY batch_num, submited_date , last_purchasing_invoice_status
                ORDER BY batch_num";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getJmlInvPerBatch($batch){
        $oracle = $this->load->database('erp_db',true);
        $sql = "SELECT purchasing_batch_number FROM ap.ap_monitoring_invoice WHERE purchasing_batch_number = $batch";
        $query = $oracle->query($sql);
        return $query->num_rows();
    }

    public function showDetailPerBatch($batch){
        $oracle = $this->load->database('erp_db',true);
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
        $oracle = $this->load->database('erp_db', true);
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
        $oracle = $this->load->database('erp_db', true);
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
        $erp_db = $this->load->database('erp_db',true);
        $sql = "SELECT invoice_date
                FROM ap.ap_monitoring_invoice
                WHERE invoice_date = '$uw' limit 1";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function checkInvoiceDatecount($uw){
        $erp_db = $this->load->database('erp_db',true);
        $sql = "SELECT invoice_date
                FROM ap.ap_monitoring_invoice
                WHERE invoice_date = '$uw'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

     public function checkListSubmitted($po_number,$lppb_number)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = $oracle->query("SELECT *
                    FROM (SELECT distinct
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
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                            and msib.ORGANIZATION_ID = 81
                            and pol.po_line_id not in (
                                        SELECT 
                                                 pol.PO_LINE_ID
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
                                            AND rsl.shipment_line_id = rt.shipment_line_id
                                            AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                                            AND POV.VENDOR_ID = RT.VENDOR_ID
                                            AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                                            AND POL.PO_LINE_ID = RT.PO_LINE_ID
                                            AND org.LANGUAGE(+) = USERENV ('LANG')
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
                                        )
                        )
                    WHERE no_po = $po_number
                    and no_lppb = $lppb_number");
        return $query->result_array();
    }

     public function checkStatus($po_number,$line_num)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT *
                    FROM (SELECT distinct
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
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                            and msib.ORGANIZATION_ID = 81
                            and pol.po_line_id not in (
                                        SELECT 
                                                 pol.PO_LINE_ID
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
                                            AND rsl.shipment_line_id = rt.shipment_line_id
                                            AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                                            AND POV.VENDOR_ID = RT.VENDOR_ID
                                            AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                                            AND POL.PO_LINE_ID = RT.PO_LINE_ID
                                            AND org.LANGUAGE(+) = USERENV ('LANG')
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
                                        )
                        )
                        WHERE no_po = $po_number
                        and line_num = $line_num";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function exportExcelMonitoringInvoice($dateFrom,$dateTo){
        $oracle = $this->load->database('erp_db', true);
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

    public function podetails($po_number,$lppb_number,$line_number){
        //echo '--'.$lppb_number.'--';exit;
        if ($lppb_number=='' || $lppb_number==' ') {
            $lppb_number = "'%'";
        }
        if ($line_number=='' || $line_number==' ') {
            $line_number = 0;
        }
       $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT status
                    FROM (SELECT distinct
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
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                            and msib.ORGANIZATION_ID = 81
                            and pol.po_line_id not in (
                                        SELECT 
                                                 pol.PO_LINE_ID
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
                                            AND rsl.shipment_line_id = rt.shipment_line_id
                                            AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                                            AND POV.VENDOR_ID = RT.VENDOR_ID
                                            AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                                            AND POL.PO_LINE_ID = RT.PO_LINE_ID
                                            AND org.LANGUAGE(+) = USERENV ('LANG')
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
                                        )
                        )
                    WHERE no_po = $po_number
                    and no_lppb like $lppb_number
                    and line_num = $line_number";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function savePoNumberNew($line_number,$po_number,$lppb_number, $shipment_number,$received_date,$item_description,$item_code,  $qty_receipt, $qty_reject, $currency, $unit_price, $qty_invoice,$id){
        $oracle = $this->load->database('erp_db',true);
        $query = "INSERT INTO ap.ap_invoice_purchase_order
                    (line_number,po_number, lppb_number, shipment_number,
                    received_date,item_description,item_code,qty_receipt, qty_reject, currency, unit_price, qty_invoice,invoice_id)
                    VALUES 
                    ('$line_number','$po_number','$lppb_number', '$shipment_number', '$received_date', '$item_description', '$item_code','$qty_receipt', '$qty_reject', '$currency', '$unit_price', '$qty_invoice',$id)";
        $oracle->query($query);
    }

    public function saveInvoiveAmount($invoice_amount,$invoice_id)
    {
       $oracle = $this->load->database('erp_db',true);
       $query2 = "UPDATE ap.ap_monitoring_invoice 
                  SET invoice_amount = '$invoice_amount'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
    }

    public function checkPPN($po_numberInv){
        $oracle = $this->load->database("oracle",TRUE);
        $query = "SELECT ppn
                    FROM (SELECT distinct
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
                                    pol.QUANTITY quantity,
                                    poh.attribute2 ppn
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
                                    pol.QUANTITY quantity,
                                    poh.attribute2 ppn
                        FROM PO_VENDORS POV
                            ,HR_ALL_ORGANIZATION_UNITS_TL ORG
                            ,PO_HEADERS_ALL POH
                            ,PO_LINES_ALL POL
                            ,PO_LINE_LOCATIONS_ALL PLL
                            ,MTL_SYSTEM_ITEMS_B msib
                        WHERE poh.po_header_id(+) = pol.po_header_id
                            AND POV.VENDOR_ID (+) = poh.VENDOR_ID
                            AND POL.PO_LINE_ID (+) = PLL.PO_LINE_ID
                            and msib.INVENTORY_ITEM_ID = pol.ITEM_ID
                            and msib.ORGANIZATION_ID = 81
                            and pol.po_line_id not in (
                                        SELECT 
                                                 pol.PO_LINE_ID
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
                                            AND rsl.shipment_line_id = rt.shipment_line_id
                                            AND ORG.ORGANIZATION_ID (+) = RSL.FROM_ORGANIZATION_ID
                                            AND POV.VENDOR_ID = RT.VENDOR_ID
                                            AND POH.PO_HEADER_ID = RT.PO_HEADER_ID
                                            AND POL.PO_LINE_ID = RT.PO_LINE_ID
                                            AND org.LANGUAGE(+) = USERENV ('LANG')
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
                                        )
                        )
                    WHERE no_po = $po_numberInv";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function tax_invoice_number($invoice_id,$tax_invoice_number)
    {
       $oracle = $this->load->database('erp_db',true);
       $query2 = "UPDATE ap.ap_monitoring_invoice 
                  SET tax_invoice_number = '$tax_invoice_number'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
    }
}