<?php
class M_trackingInvoice extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

    public function getVendorName($source){
        $db = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT VENDOR_NAME
                    FROM KHS_AP_MONITORING_INVOICE
                    $source";
        $run = $db->query($query);
        return $run->result_array();
    }

    function get_ora_blob_value($value)
    {
        $size = $value->size();
        $result = $value->read($size);
        return ($result)?$result:NULL;
    }

    public function searchMonitoringInvoice($parameter_invoice){
     
        $db = $this->load->database('oracle',true);
        $query = "SELECT xx.*,
                 CASE
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='0' AND xx.LAST_FINANCE_INVOICE_STATUS ='0' THEN 'Input by Admin Purcashing'
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='1' AND xx.LAST_FINANCE_INVOICE_STATUS ='0' THEN 'Submit For Checking to Kasie Purchasing'
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='2' AND xx.LAST_FINANCE_INVOICE_STATUS ='0' THEN 'Approved By Kasie Purchasing'
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='3' AND xx.LAST_FINANCE_INVOICE_STATUS ='0' THEN 'Rejected By Kasie Purchasing'
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='2' AND xx.LAST_FINANCE_INVOICE_STATUS ='1' THEN 'Submit to Akuntansi'
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='2' AND xx.LAST_FINANCE_INVOICE_STATUS ='2' THEN 'Received by Akuntansi'
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='2' AND xx.LAST_FINANCE_INVOICE_STATUS ='3' THEN 'Rejected by Akuntansi'
                 WHEN xx.LAST_PURCHASING_INVOICE_STATUS='0' AND xx.LAST_FINANCE_INVOICE_STATUS = '2' THEN 'Input by Akuntansi'
                 ELSE 'Unknown'
                 END AS status
                 FROM(SELECT ami.vendor_name vendor_name, 
                         ami.invoice_number invoice_number,
                         ami.invoice_date invoice_date,
                         (SELECT max (khs.action_date) FROM KHS_AP_INVOICE_ACTION_DETAIL khs  WHERE khs.invoice_id = ami.invoice_id ) action_date,
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         aaipo.po_detail po_detail,
                         ami.invoice_id invoice_id,
                         ami.LAST_PURCHASING_INVOICE_STATUS,
                         ami.LAST_FINANCE_INVOICE_STATUS,
                         COALESCE((SELECT CASE payment_status_flag
                         WHEN 'Y' THEN 'Paid'
                         WHEN 'N' THEN 'Non Paid'
                         ELSE 'Inprocess Vouching'
                         END
                         FROM  ap_invoices_all aia  WHERE aia.INVOICE_NUM=ami.INVOICE_NUMBER AND aia.VENDOR_ID=ami.VENDOR_NUMBER ),'Blank') AS status_payment,
                         ami.source source
                         ,ami.jenis_dokumen jenis_dokumen
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
                                       '
                                '
                                      ) po_detail
                              FROM (SELECT DISTINCT invoice_id, po_number, line_number,
                                                    lppb_number
                                               FROM khs_ap_invoice_purchase_order) aipo
                    GROUP BY aipo.invoice_id) aaipo
                    WHERE aaipo.invoice_id = ami.invoice_id (+)
                    $parameter_invoice
                )  xx";
        
        // return $query;exit(); 
        // echo "<pre>";
        // print_r($query);
        // exit();           
        $run = $db->query($query);
        $arr = $run->result_array();
        foreach ($arr as $key => $value) {
          $arr[$key]['PO_DETAIL'] = $this->get_ora_blob_value($arr[$key]['PO_DETAIL']);
        }
        return $arr;
    }

    public function checkStatusLPPB($po_number,$line_num)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT DISTINCT rt.transaction_type status
                           FROM rcv_shipment_headers rsh,
                                rcv_shipment_lines rsl,
                                po_vendors pov,
                                rcv_transactions rt,
                                po_headers_all poh,
                                po_lines_all pol,
                                po_line_locations_all pll
                          WHERE rsh.shipment_header_id = rsl.shipment_header_id
                            AND rsh.shipment_header_id = rt.shipment_header_id
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
                                              ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE',
                                               'TRANSFER'))
                            AND pov.vendor_id(+) = poh.vendor_id
                            AND pol.po_line_id(+) = pll.po_line_id
                            AND poh.segment1 = '$po_number'
                            AND pol.line_num = $line_num
                UNION
                SELECT DISTINCT NULL status
                           FROM po_vendors pov,
                                po_headers_all poh,
                                po_lines_all pol,
                                po_line_locations_all pll
                          WHERE poh.po_header_id(+) = pol.po_header_id
                            AND pov.vendor_id(+) = poh.vendor_id
                            AND pol.po_line_id(+) = pll.po_line_id
                            AND poh.segment1 = '$po_number'
                            AND pol.line_num = '$line_num'";

        // echo "<pre>";
        // print_r($query);
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function checkStatusLPPB2($po_number)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT DISTINCT rt.transaction_type status
                           FROM rcv_shipment_headers rsh,
                                rcv_shipment_lines rsl,
                                po_vendors pov,
                                rcv_transactions rt,
                                po_headers_all poh,
                                po_lines_all pol,
                                po_line_locations_all pll
                          WHERE rsh.shipment_header_id = rsl.shipment_header_id
                            AND rsh.shipment_header_id = rt.shipment_header_id
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
                                              ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE',
                                               'TRANSFER'))
                            AND pov.vendor_id(+) = poh.vendor_id
                            AND pol.po_line_id(+) = pll.po_line_id
                            AND poh.segment1 = '$po_number'
                UNION
                SELECT DISTINCT NULL status
                           FROM po_vendors pov,
                                po_headers_all poh,
                                po_lines_all pol,
                                po_line_locations_all pll
                          WHERE poh.po_header_id(+) = pol.po_header_id
                            AND pov.vendor_id(+) = poh.vendor_id
                            AND pol.po_line_id(+) = pll.po_line_id
                            AND poh.segment1 = '$po_number'";

        // echo "<pre>";
        // print_r($query);
        // exit();
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function detailInvoice($invoice_id)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $query = "SELECT DISTINCT ami.invoice_id invoice_id, ami.invoice_number invoice_number,
                ami.invoice_date invoice_date,
                ami.tax_invoice_number tax_invoice_number,
                ami.invoice_amount invoice_amount,
                ami.last_purchasing_invoice_status status, ami.reason reason,
                ami.purchasing_batch_number batch_num,
                aipo.po_number po_number, poh.attribute2 ppn,
                ami.vendor_name vendor_name,
                ami.last_finance_invoice_status last_finance_invoice_status,
                aipo.lppb_number, aipo.shipment_number, aipo.received_date,
                aipo.item_code, aipo.item_description, aipo.qty_receipt,
                aipo.qty_reject, aipo.currency, aipo.unit_price,
                aipo.qty_invoice,
                ami.invoice_category,
                ami.info,
                ami.nominal_dpp,
                ami.source
           FROM khs_ap_monitoring_invoice ami,
                khs_ap_invoice_purchase_order aipo,
                po_headers_all poh
          WHERE ami.invoice_id = '$invoice_id'
            AND ami.invoice_id = aipo.invoice_id
            AND poh.segment1 = aipo.po_number";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function detailHistoryInvoice($invoice_id)
    {
        $oracle = $this->load->database('oracle',TRUE);
          $query = "SELECT ACTION_DATE, CASE
                WHEN PURCHASING_STATUS='0' AND FINANCE_STATUS ='0' THEN 'Input by Admin Purcashing'
                WHEN PURCHASING_STATUS='1' AND FINANCE_STATUS ='0' THEN 'Submit For Checking to Kasie Purchasing'
                WHEN PURCHASING_STATUS='2' AND FINANCE_STATUS ='0' THEN 'Approved By Kasie Purchasing'
                WHEN PURCHASING_STATUS='3' AND FINANCE_STATUS ='0' THEN 'Rejected By Kasie Purchasing'
                WHEN PURCHASING_STATUS='2' AND FINANCE_STATUS ='1' THEN 'Submit to Akuntansi'
                WHEN PURCHASING_STATUS='2' AND FINANCE_STATUS ='2' THEN 'Received by Akuntansi'
                WHEN PURCHASING_STATUS='2' AND FINANCE_STATUS ='3' THEN 'Rejected by Akuntansi'
                WHEN PURCHASING_STATUS='0' AND FINANCE_STATUS ='2' THEN 'Input by Akuntansi'
                ELSE 'Unknown'
                END AS status
                FROM khs.KHS_AP_INVOICE_ACTION_DETAIL WHERE INVOICE_ID='$invoice_id' ORDER BY ACTION_DATE DESC";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

     public function checkSourceLogin($employee_code)
    {
        // $oracle = $this->load->database();
        // $query = "select eea.employee_code, es.unit_name
        //             from er.er_employee_all eea, er.er_section es
        //             where eea.section_code = es.section_code
        //             and eea.employee_code = '$employee_code' ";
        // $runQuery = $this->db->query($query);
        // return $runQuery->result_array();
        $oracle = $this->load->database('erp_db',true);
        $query = "select eea.employee_code, es.unit_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }


}