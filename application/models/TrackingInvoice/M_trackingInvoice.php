<?php
class M_trackingInvoice extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

    public function getVendorName(){
        $db = $this->load->database('oracle',true);
        $query = "SELECT DISTINCT VENDOR_NAME
                    FROM KHS_AP_MONITORING_INVOICE";
        $run = $db->query($query);
        return $run->result_array();
    }

    public function searchMonitoringInvoice($parameter_invoice){
        $db = $this->load->database('oracle',true);
        $query = "SELECT ami.vendor_name vendor_name, ami.invoice_number invoice_number,
                         ami.invoice_date invoice_date,
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, aaipo.po_detail po_detail,
                         ami.invoice_id invoice_id
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
                                                   ).EXTRACT ('//text()'),
                                            '@'
                                           )
                                       ),
                                       '@',
                                       '<br>'
                                      ) po_detail
                              FROM (SELECT DISTINCT invoice_id, po_number, line_number,
                                                    lppb_number
                                               FROM khs_ap_invoice_purchase_order) aipo
                          GROUP BY aipo.invoice_id) aaipo
                   WHERE aaipo.invoice_id = ami.invoice_id
                   $parameter_invoice
                ORDER BY ami.last_admin_date";
        $run = $db->query($query);
        return $run->result_array();
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
                aipo.qty_invoice
           FROM khs_ap_monitoring_invoice ami,
                khs_ap_invoice_purchase_order aipo,
                po_headers_all poh
          WHERE ami.invoice_id = '$invoice_id'
            AND ami.invoice_id = aipo.invoice_id
            AND poh.segment1 = aipo.po_number";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

}