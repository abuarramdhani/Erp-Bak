<?php
class M_monitoringinvoice extends CI_Model {
  public function __construct()
  {
    $this->load->database();
    $this->load->library('encrypt');
  }
    public function checkSourceLogin($employee_code)
    {
        $oracle = $this->load->database('erp_db',true);
        $query = "select eea.employee_code, es.unit_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
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
                    ('$line_number','$po_number',$lppb_number, '$shipment_number', $received_date, '$item_description', '$item_code',$qty_receipt, $qty_reject, '$currency', '$unit_price', '$qty_invoice', $inv_id)";
        $oracle->query($query);
        
    }
    public function savePoNumber2($invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendor_number,$vendor_name,$last_admin_date,$info,$invoice_category,$nominal_dpp,$source_login,$jenis_jasa){
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_ap_monitoring_invoice
                    (invoice_number, invoice_date, invoice_amount,tax_invoice_number, vendor_number, vendor_name, last_admin_date, info,invoice_category,nominal_dpp,source,jenis_jasa)
                    VALUES 
                    ('$invoice_number','$invoice_date','$invoice_amount', '$tax_invoice_number','$vendor_number','$vendor_name',to_date('$last_admin_date', 'DD/MM/YYYY HH24:MI:SS'), '$info','$invoice_category','$nominal_dpp','$source_login','$jenis_jasa')";
        $oracle->query($query);
        $query2 = "SELECT max(invoice_id) invoice_id
                    from khs_ap_monitoring_invoice";
        $lastId = $oracle->query($query2);
        return $lastId->result_array();
    }
    public function savePoNumber3($invoice_id,$action_date)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "INSERT INTO khs_ap_invoice_action_detail (invoice_id, action_date)
                VALUES ($invoice_id,to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query);
        $query2 = "SELECT MAX(invoice_id) invoice_id
                    from khs_ap_monitoring_invoice ";
        $last_id = $oracle->query($query2);
        return $last_id->result_array();
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
    function get_ora_blob_value($value)
    {
        $size = $value->size();
        $result = $value->read($size);
        return ($result)?$result:NULL;
    }
    public function showInvoice($source){
      // $this->db->cache_on();
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT   ami.invoice_number invoice_number, ami.invoice_date invoice_date,
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount,
                         ami.last_purchasing_invoice_status status, ami.reason reason,
                         ami.invoice_id invoice_id,
                         aaipo.po_detail po_detail,
                         ami.last_admin_date last_admin_date, ami.vendor_name vendor_name,
                         ami.info info,
                         ami.invoice_category invoice_category,
                         ami.jenis_jasa jenis_jasa,
                         ami.source source
                FROM khs_ap_monitoring_invoice ami,
                     (SELECT   aipo.invoice_id,
                               REPLACE
                                  ((RTRIM
                                       (XMLAGG (XMLELEMENT (e,
                                                               TO_CHAR
                                                                      (   aipo.po_number
                                                                       || '-'
                                                                       || aipo.line_number
                                                                       || '-'
                                                                       || aipo.lppb_number
                                                                      )
                                                            || '@'
                                                           )
                                               ).EXTRACT ('//text()').getclobval(),
                                        '@'
                                       )
                                   ),
                                   '@',
                                   '<br>'
                                  ) po_detail
                          FROM (SELECT DISTINCT invoice_id, po_number, line_number, lppb_number
                                                      FROM khs_ap_invoice_purchase_order) aipo
                      GROUP BY aipo.invoice_id) aaipo
               WHERE aaipo.invoice_id = ami.invoice_id
                 AND ami.batch_number IS NULL
                 $source
            ORDER BY ami.last_admin_date DESC
                ";
        $runQuery = $oracle->query($query);
        $arr = $runQuery->result_array();
        foreach ($arr as $key => $value) {
          $arr[$key]['PO_DETAIL'] = $this->get_ora_blob_value($arr[$key]['PO_DETAIL']);
        }
       
        return $arr;
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
        // oci_commit($oracle);
    }
    public function showEditList1($invoice_id){
        $oracle = $this->load->database('oracle',true);
        $query = "SELECT invoice_id invoice_id, 
                    po_number po_number,
                    lppb_number lppb_number,
                    shipment_number shipment_number,
                    received_date received_date,
                    item_description item_description,
                    item_code item_code,
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
                         vendor_name vendor_name,
                         info info,
                         nominal_dpp,
                         invoice_category,
                         jenis_jasa
                FROM khs_ap_monitoring_invoice
                WHERE invoice_id = $invoice_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
    public function saveEditInvoice1($invoice_po_id,$po_number,$lppb_number,$shipment_number,$received_date,$item_description,$item_code,$qty_receipt,$qty_reject,$currency,$unit_price,$qty_invoice){
        if ($received_date == '' || $received_date == '  ' || $received_date == NULL || !$received_date) {
                $received_date = NULL;
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
            item_code = '$item_code',
            qty_receipt = $qty_receipt,
            qty_reject = $qty_reject,
            currency = '$currency',
            unit_price = '$unit_price',
            qty_invoice = '$qty_invoice'
        WHERE invoice_po_id = $invoice_po_id ";
        $runQuery = $oracle->query($query);
        //oci_commit($oracle);
        
    }
    public function saveEditInvoice2($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$info,$nominal_dpp,$invoice_category,$jenis_jasa)
    {
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
    public function saveEditInvoice3($invoice_id,$action_date)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $run = $oracle->query($sql);
    }
    public function saveBatchNumberById($id, $batch_number, $date, $status){
        $oracle = $this->load->database('oracle',true);
        $query = "UPDATE khs_ap_monitoring_invoice
                    SET batch_number = '$batch_number',
                    last_status_purchasing_date = to_date('$date', 'DD/MM/YYYY HH24:MI:SS'),
                    last_purchasing_invoice_status = '$status'
                    WHERE invoice_id = $id";
        $oracle->query($query);
        // oci_commit($oracle);
    }
     public function saveBatchNumberById2($invoice_id,$action_date,$status)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), '$status')";
        $run = $oracle->query($sql);
    }
    public function checkNumBatchExist()
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT batch_number batch_number
                  FROM khs_ap_monitoring_invoice 
                  WHERE ROWNUM = 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    public function checkBatchNumbercount($batch_number){
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT batch_number batch_number
                FROM khs_ap_monitoring_invoice
                WHERE batch_number LIKE '$batch_number%'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }
    public function showListSubmitted($source){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct 
                batch_number batch_number, 
                to_date(last_status_purchasing_date) submited_date, 
                last_purchasing_invoice_status last_purchasing_invoice_status, 
                last_finance_invoice_status last_finance_invoice_status, 
                source
                FROM khs_ap_monitoring_invoice
                WHERE batch_number is not null
                and (last_purchasing_invoice_status = 1 OR last_purchasing_invoice_status = 2
                and last_finance_invoice_status = 2)
                $source
                ORDER BY submited_date DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    public function getJmlInvPerBatch($batch){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT  batch_number FROM khs_ap_monitoring_invoice WHERE batch_number = '$batch'";
        $query = $oracle->query($sql);
        return $query->num_rows();
    }
     public function batch_number($batch){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT  batch_number FROM khs_ap_monitoring_invoice WHERE batch_number = '$batch'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    public function showDetailPerBatch($batch){
        // $this->db->cache_on();
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct ami.invoice_id invoice_id,
                         ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason,
                         ami.batch_number batch_number,
                         poh.attribute2 ppn,
                         ami.vendor_name vendor_name,
                         ami.last_finance_invoice_status last_finance_invoice_status,
                         ami.info info,
                         ami.nominal_dpp nominal_dpp,
                         ami.invoice_category invoice_category,
                         ami.jenis_jasa jenis_jasa,
                         ami.source source
                FROM khs_ap_monitoring_invoice ami,
                     khs_ap_invoice_purchase_order aipo,
                     po_headers_all poh
                WHERE batch_number = '$batch'
                and ami.invoice_id = aipo.invoice_id
                and poh.segment1 = aipo.po_number";
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
                         reason reason,
                         info info,
                         nominal_dpp,
                         invoice_category,
                         jenis_jasa
                FROM khs_ap_monitoring_invoice
                WHERE invoice_id = '$invoice_id'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
    public function showInvoiceInDetail2($invoice_id){
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT invoice_id invoice_id,
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
        // $this->db->cache_on(); 
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
                         to_date(ami.last_status_purchasing_date) last_status_purchasing_date,
                         aipo.received_date received_date,
                         ami.reason reason,
                         ami.batch_number batch_num,
                         aipo.line_number line_number,
                         poh.attribute2 ppn,
                         apt.NAME terms_of_payment,
                         (aipo.qty_receipt * aipo.unit_price) po_amount,
                         ami.finance_batch_number finance_batch_number
                FROM khs_ap_monitoring_invoice ami,
                     khs_ap_invoice_purchase_order aipo,
                     po_headers_all poh,
                     ap_terms apt
                WHERE ami.batch_number = '$batch_num'
                AND ami.invoice_id = aipo.invoice_id
                and poh.segment1 = aipo.po_number
                and apt.term_id = poh.terms_id";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }
    public function podetails($po_number,$lppb_number,$line_number){
       // $this->db->cache_on();
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
                $received_date = NULL;
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
        // oci_commit($oracle);
    }
    public function saveInvoiveAmount($invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendor_name,$invoice_category,$nominal_dpp,$info,$id)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET invoice_number = '$invoice_number', 
                    invoice_date = '$invoice_date',
                    invoice_amount = '$invoice_amount',
                    tax_invoice_number = '$tax_invoice_number',
                    vendor_name = '$vendor_name',
                    invoice_category = '$invoice_category',
                    nominal_dpp = '$nominal_dpp',
                    info = '$info'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
        // oci_commit($oracle);
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
        // oci_commit($oracle);
    }
    public function cekpo_number($po_number,$line_number){
        // $this->db->cache_on();
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
   public function invoicereject($source_login)
    {   
        // $this->db->cache_on();
        $oracle = $this->load->database("oracle",TRUE);
        $query = "SELECT   ami.invoice_number invoice_number, ami.invoice_date invoice_date,
                     ami.tax_invoice_number tax_invoice_number,
                     ami.invoice_amount invoice_amount, ami.reason reason,
                     ami.last_purchasing_invoice_status last_purchasing_invoice_status,
                     ami.invoice_id invoice_id,
                     TO_DATE (ami.last_status_purchasing_date)
                                                              last_status_purchasing_date,
                     ami.batch_number batch_number,
                     ami.last_finance_invoice_status last_finance_invoice_status,
                     aaipo.po_detail po_detail, ami.vendor_name vendor_name,
                     ami.info info,
                     ami.source source,
                     (SELECT MAX(action_date)
                                               FROM khs_ap_invoice_action_detail aiac
                                              WHERE ((purchasing_status = 3 and finance_status = 0)
                                                 OR (purchasing_status = 2 and finance_status = 3))
                                                AND aiac.invoice_id = ami.invoice_id) reject_date
                FROM khs_ap_monitoring_invoice ami,
                     (SELECT   aipo.invoice_id,
                               REPLACE
                                  ((RTRIM
                                       (XMLAGG (XMLELEMENT (e,
                                                               TO_CHAR
                                                                      (   aipo.po_number
                                                                       || '-'
                                                                       || aipo.line_number
                                                                       || '-'
                                                                       || aipo.lppb_number
                                                                      )
                                                            || '@'
                                                           )
                                               ).EXTRACT ('//text()').getclobval(),
                                        '@'
                                       )
                                   ),
                                   '@',
                                   '<br>'
                                  ) po_detail
                          FROM (SELECT DISTINCT invoice_id, po_number, line_number, lppb_number
                                                      FROM khs_ap_invoice_purchase_order) aipo
                      GROUP BY aipo.invoice_id) aaipo
               WHERE aaipo.invoice_id = ami.invoice_id
                 AND (last_purchasing_invoice_status = 3
                      OR last_finance_invoice_status = 3
                     )
                     $source_login
            ORDER BY last_status_purchasing_date";
        $run = $oracle->query($query);
        $arr = $run->result_array();
        foreach ($arr as $key => $value) {
          $arr[$key]['PO_DETAIL'] = $this->get_ora_blob_value($arr[$key]['PO_DETAIL']);
        }
       
        return $arr;
    }
    public function deletePOLine($invoice_po_id){
        $oracle = $this->load->database('oracle',true);
        $query1 = "DELETE 
                    FROM khs_ap_invoice_purchase_order
                    WHERE invoice_po_id = '$invoice_po_id' ";
        $runQuery1 = $oracle->query($query1);      
        oci_commit($oracle);
    }
    public function saveReject($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$last_purchasing_invoice_status,$info,$invoice_category,$nominal_dpp,$jenis_jasa)
    {
       $oracle = $this->load->database('oracle',true);
       $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET invoice_number = '$invoice_number',
                    invoice_date = '$invoice_date',
                    invoice_amount = '$invoice_amount',
                    tax_invoice_number = '$tax_invoice_number',
                    last_purchasing_invoice_status = '$last_purchasing_invoice_status',
                    last_finance_invoice_status = 0,
                    batch_number = null,
                    finance_batch_number = null,
                    last_status_purchasing_date = null,
                    last_status_finance_date = null,
                    reason = null,
                    info = '$info',
                    invoice_category = '$invoice_category',
                    nominal_dpp = '$nominal_dpp',
                    jenis_jasa = '$jenis_jasa'
                 WHERE invoice_id = $invoice_id ";
        $runQuery2 = $oracle->query($query2);
        // oci_commit($oracle);
    }
    public function SusulFakturPajak()
    {
       $oracle = $this->load->database("oracle",TRUE);
        $query = "SELECT ";
        $run = $oracle->query($query);
        $arr = $run->result_array();
    }
}