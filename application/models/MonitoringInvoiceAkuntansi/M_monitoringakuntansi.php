<?php
class M_monitoringakuntansi extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->library('encrypt');
    }
    //---------------------untuk koneksi local, aktifkan ini ------------------------------------//
    // public function checkLoginInAkuntansi($employee_code)
    //  {
    //      $oracle = $this->load->database();
    //      $sql = "select eea.employee_code, es.unit_name
    //                  from er.er_employee_all eea, er.er_section es
    //                  where eea.section_code = es.section_code
    //                  and eea.employee_code = '$employee_code' ";
    //      $runQuery = $this->db->query($sql);
    //      return $runQuery->result_array();
    //  }
    //-------------------untuk diupload ke PROD aktifkan ini -----------------------------------//

    public function checkLoginInAkuntansi($employee_code)
    {
        $oracle = $this->load->database('erp_db', true);
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
        return ($result) ? $result : NULL;
    }

    //---------------------------------------------------tambahan menu start from here-----------------------//

    public function getStatusSatu()
    {
        $oracle = $this->load->database('oracle', TRUE);
        $sql = " SELECT ami.invoice_id, ami.vendor_name vendor_name,
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.purc_action_bermasalah purc_date,
                ami.akt_finished_date,
                ami.source SOURCE,
                ami.source_bermasalah,
                ami.no_induk_buyer,
                ami.status_inv_bermasalah,
                ami.feedback_buyer,
                ami.buyer_action_bermasalah,
                ami.status_berkas_buyer,
                ami.status_berkas_purc,
                ami.purc_action_bermasalah,
                ami.feedback_purchasing,
                ami.RESTATUS_BERKAS_AKT,
                ami.RESTATUS_BERKAS_PURC,
                ami.returned_date_akt,
                ami.returned_date_purc,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'Y'
                    and adi.invoice_id = ami.invoice_id) jmlh_y,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'N'
                    and adi.invoice_id = ami.invoice_id) jmlh_n
            FROM khs_ap_monitoring_invoice ami
           WHERE ami.kategori_inv_bermasalah IS NOT NULL 
           and ami.status_inv_bermasalah NOT IN (0,5)
           and ami.returned_flag IS NULL
        ORDER BY ami.last_admin_date DESC";
        $run = $oracle->query($sql);
        return $run->num_rows();
    }

    public function getStatusEnam()
    {
        $oracle = $this->load->database('oracle', TRUE);
        $sql = "SELECT ami.invoice_id, ami.vendor_name vendor_name,
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.purc_action_bermasalah purc_date,
                ami.akt_finished_date,
                ami.source SOURCE,
                ami.source_bermasalah,
                ami.no_induk_buyer,
                ami.status_inv_bermasalah,
                ami.feedback_buyer,
                ami.buyer_action_bermasalah,
                ami.status_berkas_buyer,
                ami.status_berkas_purc,
                ami.purc_action_bermasalah,
                ami.feedback_purchasing,
                ami.RESTATUS_BERKAS_AKT,
                ami.RESTATUS_BERKAS_PURC,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.returned_flag,
                ami.note_return_akt,
                ami.note_return_purc,
                ami.kelengkapan_doc_inv_returned,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'Y'
                    and adi.invoice_id = ami.invoice_id) jmlh_y,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'N'
                    and adi.invoice_id = ami.invoice_id) jmlh_n
            FROM khs_ap_monitoring_invoice ami
           WHERE ami.kategori_inv_bermasalah IS NOT NULL 
           and ami.returned_flag = 'Y'
           and ami.status_inv_bermasalah NOT IN (5)
        ORDER BY ami.last_admin_date DESC";
        $run = $oracle->query($sql);
        return $run->num_rows();
    }

    public function saveReconfirmInvBermasalah($invoice_id, $action_date, $status_berkas)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE 
                SET 
                AKT_RESTATUS_DATE = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                RESTATUS_BERKAS_AKT = '$status_berkas',
                SOURCE_BERMASALAH = 'AKUNTANSI'
                WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function getReturnedData($invoice_id)
    {
        $oracle = $this->load->database('oracle', TRUE);
        $sql = "SELECT NOTE_RETURN_AKT, KELENGKAPAN_DOC_INV_RETURNED FROM KHS_AP_MONITORING_INVOICE WHERE INVOICE_ID = '$invoice_id'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function ReupdateTabelBerkas($waktu_berkas, $doc_id, $hasil, $invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE KHS_AP_DOKUMEN_INV
                SET REDATE_CONFIRMATION_AKT = '$waktu_berkas',
                RESTATUS_DOCUMENT_AKT = '$hasil'
                WHERE DOCUMENT_ID = '$doc_id' AND INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function getDokumenRekonfirmasi($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT 
                    DOCUMENT_ID, 
                    INVOICE_ID, 
                    DOCUMENT_NAME, 
                    RESTATUS_DOCUMENT_PURC, 
                    REDATE_CONFIRMATION_PURC, 
                    RESTATUS_DOCUMENT_AKT, 
                    REDATE_CONFIRMATION_AKT,
                    CREATION_DATE 
                FROM KHS_AP_DOKUMEN_INV
                WHERE INVOICE_ID = $invoice_id";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function getHasilKonfirmasi($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT 
                    DOCUMENT_ID, 
                    INVOICE_ID, 
                    DOCUMENT_NAME, 
                    STATUS_DOCUMENT_PURC, 
                    DATE_CONFIRMATION_PURC, 
                    CREATION_DATE 
                FROM KHS_AP_DOKUMEN_INV
                WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function EndInvoiceBermasalah($invoice_id, $end_date)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE khs_ap_monitoring_invoice SET 
                status_inv_bermasalah = '5',
                source_bermasalah = 'AKUNTANSI',
                akt_finished_date = to_date('$end_date', 'DD/MM/YYYY HH24:MI:SS')
            WHERE invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function UpdatePoNumber2($invoice_id, $invoice_number, $invoice_date, $amount, $tax_invoice_number, $vendor_name, $vendor_number, $last_admin_date, $note_admin, $invoice_category, $source_login, $top)

    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE khs_ap_monitoring_invoice SET 
                invoice_number = '$invoice_number',
                invoice_date = '$invoice_date',
                invoice_amount = '$amount',
                tax_invoice_number = '$tax_invoice_number',
                vendor_name = '$vendor_name',
                vendor_number = '$vendor_number',
                last_admin_date = to_date('$last_admin_date', 'DD/MM/YYYY HH24:MI:SS'),
                info = '$note_admin',
                invoice_category = '$invoice_category',
                source = '$source_login',
                term_of_payment = '$top'
            WHERE invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function UpdatePoNumber($po_number, $invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE khs_ap_invoice_purchase_order SET 
            po_number = '$po_number'
            WHERE invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function UpdatePoNumber3($invoice_id, $action_date)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE khs_ap_invoice_action_detail 
            SET action_date = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS')
            WHERE invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }


    public function editInvData($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT aipo.invoice_id invoice_id, 
                invoice_number invoice_number,
                invoice_date invoice_date,
                invoice_amount invoice_amount,
                tax_invoice_number tax_invoice_number,
                vendor_name vendor_name,
                vendor_number vendor_id,
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
                ami.nominal_ppn,
                ami.invoice_category invoice_category,
                ami.nominal_dpp nominal_dpp,
                ami.term_of_payment,
                ami.batch_number batch_number,
                ami.jenis_jasa jenis_jasa,
                ami.source source,
                ami.KATEGORI_INV_BERMASALAH,
                ami.KELENGKAPAN_DOC_INV_BERMASALAH,
                ami.KETERANGAN_INV_BERMASALAH
--                poh.attribute2 ppn
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
--                JOIN po_headers_all poh ON aipo.po_number = poh.segment1
                WHERE ami.invoice_id = '$invoice_id'";

        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function resetInvoiceBermasalah($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE khs_ap_monitoring_invoice 
                SET 
                    KATEGORI_INV_BERMASALAH = '',
                    KELENGKAPAN_DOC_INV_BERMASALAH = '',
                    KETERANGAN_INV_BERMASALAH = '' ,
                    FEEDBACK_PURCHASING = '',
                    AKT_ACTION_BERMASALAH = '',
                    PURC_ACTION_BERMASALAH = '',
                    STATUS_BERKAS_PURC = '',
                    STATUS_BERKAS_BUYER = '',
                    BUYER_ACTION_BERMASALAH = '',
                    FEEDBACK_BUYER = '',
                    STATUS_INV_BERMASALAH = '',
                    NO_INDUK_BUYER = '',
                    SOURCE_BERMASALAH = '',
                    RESTATUS_BERKAS_PURC = '',
                    RESTATUS_BERKAS_AKT = '',
                    AKT_FINISHED_DATE = '',
                    AKT_RESTATUS_DATE = '',
                    PURC_RESTATUS_DATE = '',
                    PURC_FINISHED_DATE = '',
                    BUYER_FINISHED_DATE = '',
                    RETURNED_DATE_AKT = '',
                    RETURNED_DATE_PURC = '',
                    RETURNED_FLAG = '',
                    NOTE_BUYER = '',
                    NOTE_RETURN_AKT = '',
                    NOTE_RETURN_PURC = '',
                    KELENGKAPAN_DOC_INV_RETURNED = ''
                    WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        $sql2 = "DELETE FROM KHS_AP_DOKUMEN_INV WHERE INVOICE_ID = '$invoice_id'";
        $runQuery2 = $erp_db->query($sql2);
        $sql3 = "UPDATE KHS_AP_MONITORING_INVOICE SET RESET_DATE = sysdate WHERE INVOICE_ID = '$invoice_id'";
        $runQuery2 = $erp_db->query($sql2);
    }


    public function tarikDataPo($nomor_po)
    {
        $oracle = $this->load->database("oracle", TRUE);
        $query = $oracle->query(

            "SELECT pha.segment1 no_po, att.NAME payment_terms, pv.vendor_name,
                 pv.vendor_id, pha.attribute2 ppn, ppf.full_name buyer,
                 po_headers_sv3.get_po_status (pha.po_header_id) status,
                 CASE
                    WHEN UPPER
                           (po_headers_sv3.get_po_status (pha.po_header_id)
                           ) LIKE '%CANCELLED%'
                       THEN 'N'
                    ELSE 'Y'
                 END flag,
                 pha.ATTRIBUTE1
            FROM po_headers_all pha,
                 ap_terms_tl att,
                 po_vendors pv,
                 per_people_f ppf
           WHERE pha.terms_id = att.term_id
             AND pha.agent_id = ppf.person_id
             AND pha.vendor_id = pv.vendor_id
             AND pha.SEGMENT1 = '$nomor_po'
             and (ppf.effective_end_date >= sysdate or ppf.effective_end_date is null)"
        );
        return $query->result_array();
    }

    // SELECT DISTINCT  pha.SEGMENT1 NO_PO
    //                     ,att.NAME PAYMENT_TERMS
    //                     ,pv.VENDOR_NAME
    //                     ,pv.VENDOR_ID
    //                     ,pha.attribute2 PPN
    //                     from
    //                     po_headers_all pha
    //                     ,ap_terms_tl att
    //                     ,po_vendors pv
    //                     where
    //                     pha.TERMS_ID = att.TERM_ID
    //                     and pha.VENDOR_ID = pv.VENDOR_ID
    //                     and pha.SEGMENT1 = $nomor_po

    public function getInvNumber($invNumber)
    {
        $oracle = $this->load->database("oracle", TRUE);
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
            AND poh.segment1 = '$invNumber'
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
            AND poh.segment1 = '$invNumber'
            AND pol.po_line_id NOT IN (
                   SELECT rt.po_line_id
                     FROM rcv_transactions rt
                    WHERE pol.po_line_id = rt.po_line_id)");
        return $query->result_array();
    }

    public function getIdVendor($nama_vendor)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT vendor_id FROM po_vendors WHERE VENDOR_NAME LIKE '%$nama_vendor%'";
        $ini = $oracle->query($query);
        return $ini->result_array();
    }

    public function savePoNumber($po_number, $inv_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_ap_invoice_purchase_order
                    (po_number,invoice_id)
                    VALUES 
                    ('$po_number', $inv_id)";
        $oracle->query($query);
    }

    public function savePoNumber2($invoice_number, $invoice_date, $invoice_amount, $tax_invoice_number, $vendor_number, $vendor_name, $last_admin_date, $info, $invoice_category, $source_login, $top, $jenis_dokumen)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_ap_monitoring_invoice
                    (invoice_number, invoice_date, invoice_amount,tax_invoice_number, vendor_name, vendor_number, last_admin_date, info,invoice_category,source,last_finance_invoice_status,term_of_payment,jenis_dokumen)
                    VALUES 
                    ('$invoice_number','$invoice_date','$invoice_amount', '$tax_invoice_number','$vendor_number','$vendor_name',to_date('$last_admin_date', 'DD/MM/YYYY HH24:MI:SS'), '$info','$invoice_category','$source_login','2','$top','$jenis_dokumen')";
        $oracle->query($query);
        $query2 = "SELECT max(invoice_id) invoice_id
                    from khs_ap_monitoring_invoice";
        $lastId = $oracle->query($query2);
        return $lastId->result_array();
    }
    public function savePoNumber3($invoice_id, $action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_ap_invoice_action_detail (invoice_id, action_date)
                VALUES ($invoice_id,to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query);
        $query2 = "SELECT MAX(invoice_id) invoice_id
                    from khs_ap_monitoring_invoice ";
        $last_id = $oracle->query($query2);
        return $last_id->result_array();
    }

    public function saveTableDokumen($invoice_id, $dokumen, $action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_ap_dokumen_inv (invoice_id, document_name, creation_date)
                VALUES ($invoice_id,'$dokumen', to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'))";
        $oracle->query($query);
    }

    public function checkBatchNumbercount($batch_number)
    { //kepake
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT batch_number batch_number
                FROM khs_ap_monitoring_invoice
                WHERE batch_number LIKE '$batch_number%'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }
    public function saveBatchNumberById($id, $batch_number, $date, $status)
    { //this function is for saving finance's invoice batches
        $oracle = $this->load->database('oracle', true);
        $query = "UPDATE khs_ap_monitoring_invoice
                    SET batch_number = '$batch_number',
                    last_status_finance_date = to_date('$date', 'DD/MM/YYYY HH24:MI:SS'),
                    last_finance_invoice_status = '$status'
                    WHERE invoice_id = $id";
        $oracle->query($query);
        // oci_commit($oracle);
    }
    public function saveBatchNumberById2($invoice_id, $action_date, $status) //this function is for saving finance's invoice batches
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,finance_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), '$status')";
        $run = $oracle->query($sql);
        // echo "<pre>"; echo $sql;
    }

    public function saveInvBermasalah2($invoice_number, $invoice_date, $amount, $vendor_name, $vendor_number, $last_admin_date, $invoice_category, $source_login, $jenis_jasa, $top, $kategori, $dokumen, $keterangan, $action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "INSERT INTO khs_ap_monitoring_invoice
                    (invoice_number, 
                    invoice_date, 
                    invoice_amount,
                    vendor_number, 
                    vendor_name, 
                    last_admin_date,
                    invoice_category,
                    source,
                    jenis_jasa,
                    last_finance_invoice_status,
                    term_of_payment,
                    kategori_inv_bermasalah,
                    kelengkapan_doc_inv_bermasalah,
                    keterangan_inv_bermasalah,
                    akt_action_bermasalah,
                    source_bermasalah,
                    status_inv_bermasalah
                    )
                    VALUES 
                    ('$invoice_number',
                    '$invoice_date',
                    '$amount',
                    '$vendor_number',
                    '$vendor_name',
                    to_date('$last_admin_date', 'DD/MM/YYYY HH24:MI:SS'),
                    '$invoice_category',
                    '$source_login',
                    '$jenis_jasa',
                    '2',
                    '$top',
                    '$kategori',
                    '$dokumen',
                    '$keterangan',
                     to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                    'AKUNTANSI',
                    '1')";
        $oracle->query($query);
        $query2 = "SELECT max(invoice_id) invoice_id
                    from khs_ap_monitoring_invoice";
        $lastId = $oracle->query($query2);
        return $lastId->result_array();
    }

    public function getVendorName()
    {
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT VENDOR_NAME, VENDOR_ID
                  FROM po_vendors pov";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }


    public function getNamaVendor($id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = "SELECT vendor_name
                  FROM po_vendors where vendor_id = '$id'";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function finishAktNew()
    {
        $oracle = $this->load->database('oracle', true);
        $query = " SELECT distinct ami.invoice_id invoice_id,
                         ami.term_of_payment top,
--                         CASE WHEN ami.vendor_name > 0 THEN pov.vendor_name
--                         ELSE pov.vendor_name
--                         END vendor_name,
                         ami.vendor_name vendor_name,
                         ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         aipo.po_number,
                         CASE WHEN aipo.po_number = 0 THEN 'N'
                         else poh.attribute2
                         end ppn,
                         ami.nominal_ppn,
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
--                     PO_VENDORS pov
                WHERE ami.invoice_id = aipo.invoice_id
                and (poh.segment1 = aipo.po_number or aipo.po_number = 0)
--                AND pov.VENDOR_NAME = ami.vendor_name
                AND ami.SOURCE = 'AKUNTANSI'
--                and ami.invoice_id = '17600'
                ORDER BY vendor_name, invoice_number";

        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function detailInvoiceAkt($batchNumber)
    {
        $erp_db = $this->load->database('oracle', true);
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

    public function invBermasalah($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
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
                ami.source source,
                ami.term_of_payment,
                ami.KATEGORI_INV_BERMASALAH,
                ami.KELENGKAPAN_DOC_INV_BERMASALAH,
                ami.KETERANGAN_INV_BERMASALAH,
                ami.RESTATUS_BERKAS_AKT,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.status_inv_bermasalah status_ib
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.last_finance_invoice_status = 2
                AND ami.invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function invBermasalahChecking($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
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
                ami.source source,
                ami.term_of_payment,
                ami.KATEGORI_INV_BERMASALAH,
                ami.KELENGKAPAN_DOC_INV_BERMASALAH,
                ami.KETERANGAN_INV_BERMASALAH,
                ami.RESTATUS_BERKAS_AKT,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.status_inv_bermasalah status_ib
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.last_finance_invoice_status = 2
                and ami.KATEGORI_INV_BERMASALAH IS NULL
                AND ami.invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function invBermasalahSuperEdit($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
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
                ami.source source,
                ami.term_of_payment,
                ami.KATEGORI_INV_BERMASALAH,
                ami.KELENGKAPAN_DOC_INV_BERMASALAH,
                ami.KETERANGAN_INV_BERMASALAH,
                ami.RESTATUS_BERKAS_AKT,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.status_inv_bermasalah status_ib
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.last_finance_invoice_status = 2
                AND ami.status_inv_bermasalah = 1
                AND ami.SOURCE = 'AKUNTANSI'
                AND ami.invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function invBermasalahFinish($invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
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
                ami.source source,
                ami.KATEGORI_INV_BERMASALAH,
                ami.KELENGKAPAN_DOC_INV_BERMASALAH,
                ami.KETERANGAN_INV_BERMASALAH,
                ami.feedback_purchasing,
                ami.returned_date_akt,
                ami.returned_date_purc
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.kategori_inv_bermasalah is not null
                and ami.status_inv_bermasalah = '5'
                and ami.invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function saveInvBermasalah($imp_kategori, $imp_dokumen, $keterangan, $invoice_id, $action_date)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE 
                SET KATEGORI_INV_BERMASALAH = '$imp_kategori', 
                    KELENGKAPAN_DOC_INV_BERMASALAH = '$imp_dokumen', 
                    KETERANGAN_INV_BERMASALAH = '$keterangan',
                    AKT_ACTION_BERMASALAH = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                    SOURCE_BERMASALAH = 'AKUNTANSI',
                    STATUS_INV_BERMASALAH = '1'
                WHERE INVOICE_ID = '$invoice_id'";
        // echo "<pre>"; echo $sql;
        $runQuery = $erp_db->query($sql);
    }

    public function listInvBermasalah()
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT ami.invoice_id, ami.vendor_name vendor_name,
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.purc_action_bermasalah purc_date,
                ami.akt_finished_date,
                ami.source SOURCE,
                ami.source_bermasalah,
                ami.no_induk_buyer,
                ami.status_inv_bermasalah,
                ami.feedback_buyer,
                ami.buyer_action_bermasalah,
                ami.status_berkas_buyer,
                ami.status_berkas_purc,
                ami.purc_action_bermasalah,
                ami.feedback_purchasing,
                ami.RESTATUS_BERKAS_AKT,
                ami.RESTATUS_BERKAS_PURC,
                ami.returned_date_akt,
                ami.returned_date_purc,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'Y'
                    and adi.invoice_id = ami.invoice_id) jmlh_y,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'N'
                    and adi.invoice_id = ami.invoice_id) jmlh_n
            FROM khs_ap_monitoring_invoice ami
           WHERE ami.kategori_inv_bermasalah IS NOT NULL 
           and ami.status_inv_bermasalah NOT IN (0,5)
           and ami.returned_flag IS NULL
        ORDER BY ami.akt_action_bermasalah DESC";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function listInvReturned()
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT ami.invoice_id, ami.vendor_name vendor_name,
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.purc_action_bermasalah purc_date,
                ami.akt_finished_date,
                ami.source SOURCE,
                ami.source_bermasalah,
                ami.no_induk_buyer,
                ami.status_inv_bermasalah,
                ami.feedback_buyer,
                ami.buyer_action_bermasalah,
                ami.status_berkas_buyer,
                ami.status_berkas_purc,
                ami.purc_action_bermasalah,
                ami.feedback_purchasing,
                ami.RESTATUS_BERKAS_AKT,
                ami.RESTATUS_BERKAS_PURC,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.returned_flag,
                ami.note_return_akt,
                ami.note_return_purc,
                ami.kelengkapan_doc_inv_returned,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'Y'
                    and adi.invoice_id = ami.invoice_id) jmlh_y,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'N'
                    and adi.invoice_id = ami.invoice_id) jmlh_n
            FROM khs_ap_monitoring_invoice ami
           WHERE ami.kategori_inv_bermasalah IS NOT NULL 
           and ami.returned_flag = 'Y'
           and ami.status_inv_bermasalah NOT IN (5)
        ORDER BY ami.akt_action_bermasalah DESC";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function finishInvBermasalah()
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT ami.invoice_id, ami.vendor_name vendor_name,
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.source SOURCE,
                ami.source_bermasalah,
                ami.akt_finished_date,
                ami.no_induk_buyer,
                ami.status_inv_bermasalah,
                ami.feedback_buyer,
                ami.buyer_action_bermasalah,
                ami.status_berkas_buyer,
                ami.status_berkas_purc,
                ami.purc_action_bermasalah,
                ami.feedback_purchasing,
                ami.returned_date_akt,
                ami.returned_date_purc,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'Y'
                    and adi.invoice_id = ami.invoice_id) jmlh_y,
                (SELECT COUNT (adi.status_document_purc) hasil_n
                   FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami2
                     ON ami2.invoice_id = adi.invoice_id
                  WHERE status_document_purc = 'N'
                    and adi.invoice_id = ami.invoice_id) jmlh_n
            FROM khs_ap_monitoring_invoice ami
           WHERE ami.kategori_inv_bermasalah IS NOT NULL 
           AND ami.status_inv_bermasalah = '5'
        ORDER BY ami.akt_action_bermasalah DESC";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    //----------------------------------------------------tambahan menu invoice khusus akuntansi-----------------------------------//


    public function unprocessedInvoice($batchNumber)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT  ami.invoice_id, ami.vendor_name vendor_name,
                ami.invoice_number invoice_number, 
                rsh.receipt_num,
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
            FROM khs_ap_monitoring_invoice ami, rcv_shipment_headers rsh
            WHERE ami.last_finance_invoice_status = 1 
            AND ami.batch_number=  '$batchNumber'
            AND ami.INVOICE_ID = rsh.ATTRIBUTE2(+)
            ORDER BY ami.vendor_name, ami.last_admin_date DESC";
        $run = $erp_db->query($sql);
        return $run->result_array();
    }


    public function poAmount($id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT unit_price unit_price,
				qty_invoice qty_invoice
				FROM khs_ap_invoice_purchase_order
				WHERE invoice_id = $id";
        $run = $erp_db->query($sql);
        return $run->result_array();
    }

    public function namaVendor($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT vendor_name 
				FROM po_vendors
				WHERE vendor_id = $id";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function DetailUnprocess($batch_num, $invoice_id)
    {
        $erp_db = $this->load->database('oracle', true);
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
        // echo $sql;
        //    exit();
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function saveProsesTerimaAkuntansi($finance_date, $id)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE khs_ap_monitoring_invoice
				SET last_finance_invoice_status = 2,
				last_status_finance_date = to_date('$finance_date', 'DD/MM/YYYY HH24:MI:SS')
				WHERE invoice_id = $id";
        // echo "<pre>"; echo $sql;
        $runQuery = $erp_db->query($sql);
        // oci_commit($erp_db);
    }

    public function saveProsesTolakAkuntansi($finance_date, $id, $reason)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "UPDATE khs_ap_monitoring_invoice
                SET last_finance_invoice_status = 3,
                last_status_finance_date = to_date('$finance_date', 'DD/MM/YYYY HH24:MI:SS'),
                reason = '$reason'
                WHERE invoice_id = $id";
        $runQuery = $erp_db->query($sql);
        // oci_commit($erp_db);
    }

    public function insertprosesAkuntansiTerima($invoice_id, $action_date)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status,finance_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),'2','2')";
        $runQuery = $erp_db->query($sql);
    }

    public function insertprosesAkuntansiTolak($invoice_id, $action_date)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "INSERT INTO khs_ap_invoice_action_detail (invoice_id,action_date,purchasing_status,finance_status)
                VALUES($invoice_id, to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),'2','3')";
        // echo "<pre>";  echo $sql;
        // exit();

        $run = $oracle->query($sql);
    }

    public function processedInvoice($batchNumber)
    {
        $erp_db = $this->load->database('oracle', true);
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
        $erp_db = $this->load->database('oracle', true);
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

    public function showFinanceNumber($login)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT batch_number batch_number, to_date(last_status_finance_date) submited_date, source
        FROM khs_ap_monitoring_invoice
        WHERE last_finance_invoice_status = 1
        $login
        GROUP BY batch_number, to_date(last_status_finance_date), source
        ORDER BY submited_date";
        $run = $erp_db->query($sql);
        return $run->result_array();
    }

    public function jumlahFinanceBatch($batch)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT batch_number FROM khs_ap_monitoring_invoice WHERE batch_number = $batch
        and last_purchasing_invoice_status = 2";
        $run = $erp_db->query($sql);
        return $run->num_rows();
    }

    public function reason_finance($invoice_id, $reason)
    {
        $oracle = $this->load->database('oracle', true);
        $query2 = "UPDATE khs_ap_monitoring_invoice 
                  SET reason = '$reason'
                 WHERE invoice_id = '$invoice_id' ";
        $runQuery2 = $oracle->query($query2);
        // oci_commit($oracle);
    }

    public function podetails($po_number, $lppb_number, $line_number)
    {

        $oracle = $this->load->database('oracle', TRUE);
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

    public function showFinishBatch($login)
    {
        $erp_db = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT 
                a.purchasing_batch_number, 
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
                    ORDER BY submited_date desc";
        // echo "<pre>";print_r($sql);exit();
        $run = $erp_db->query($sql);
        return $run->result_array();
    }

    public function detailBatch($batch_number)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT COUNT (last_finance_invoice_status) approve
                      FROM khs_ap_monitoring_invoice b
                     WHERE b.last_finance_invoice_status = 2
                       AND b.batch_number = '$batch_number'";
        // echo "<pre>";print_r($sql);exit();
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function jumlahInvoice($batch_number)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT COUNT (last_finance_invoice_status) jumlah_invoice
                      FROM khs_ap_monitoring_invoice b
                     WHERE b.batch_number = '$batch_number'
                     AND last_finance_invoice_status = 1";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function checkPPN($po_numberInv)
    {
        $oracle = $this->load->database("oracle", TRUE);
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

    public function po_numberr($invoice_id)
    {
        $oracle = $this->load->database("oracle", TRUE);
        $query = "SELECT DISTINCT aipo.po_number, aipo.invoice_id, poh.attribute2 ppn
                  FROM khs_ap_invoice_purchase_order aipo, po_headers_all poh
                  WHERE invoice_id = '$invoice_id'
                  AND aipo.po_number = poh.segment1 ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function getUpdatePONumber($invoice_id, $nomor_po, $vendor_id, $vendor_name, $top)
    {
        $oracle = $this->load->database("oracle", TRUE);
        $query = "update khs_ap_monitoring_invoice
                            set vendor_number = '$vendor_id', 
                            vendor_name = '$vendor_name', 
                            term_of_payment = '$top' 
                            where invoice_id = '$invoice_id'";
        $runQuery = $oracle->query($query);
        $query2 = "update khs_ap_invoice_purchase_order set po_number = '$nomor_po' where invoice_id = '$invoice_id'";
        $runQuery2 = $oracle->query($query2);
    }

    public function returning($invoice_id, $action_date, $note, $imp_dokumen)
    {
        $oracle = $this->load->database("oracle", TRUE);
        $query = "update khs_ap_monitoring_invoice
                            set 
                            returned_flag = 'Y',
                            returned_date_akt = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                            source_bermasalah = 'AKUNTANSI',
                            note_return_akt = '$note',
                            kelengkapan_doc_inv_returned = '$imp_dokumen'
                            where invoice_id = '$invoice_id'";
        $runQuery = $oracle->query($query);
    }

    public function getInvoice($invoice_number)
    {
        $oracle = $this->load->database("oracle", TRUE);
        $query = $oracle->query("select
            ami.INVOICE_ID
            ,ami.INVOICE_NUMBER
            ,aipo.PO_NUMBER
            ,aipo.LINE_NUMBER
            ,aipo.QTY_INVOICE
            from
            khs_ap_monitoring_invoice ami
            ,khs_ap_invoice_purchase_order aipo
            where
            ami.INVOICE_ID = aipo.INVOICE_ID
            and ami.INVOICE_NUMBER = '$invoice_number'");

        return $query->result_array();
    }

    public function receiptNexval()
    {
        $oracle = $this->load->database("oracle", TRUE);
        $query = $oracle->query("SELECT rcv_interface_groups_s.NEXTVAL FROM DUAL");

        return $query->result_array();
    }

    public function receipt_po_invoice($invoice_id, $p_group_id)
    {
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $sql = "BEGIN khs_receipt_po_invoice (:invoice_id, :p_group_id); END;";

        $message = '';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':invoice_id', $invoice_id, 100);
        oci_bind_by_name($stmt, ':p_group_id', $p_group_id, 100);
        oci_execute($stmt);
    }

    public function run_fnd_receiving($p_group_id)
    {
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $sql = "BEGIN APPS.KHS_RUN_FND_RECEIVING (:tetap,:p_group_id); END;";

        $tetap = '5182';
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':p_group_id', $p_group_id, 100);
        oci_bind_by_name($stmt, ':tetap', $tetap, 100);
        oci_execute($stmt);
    }
}
