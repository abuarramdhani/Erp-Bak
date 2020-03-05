<?php
class M_kasiepembelian extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}
//---------------------------aktifkan PROD------------------------------------------------//
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

//-----------------------koneksi lokal---------------------------------------------//
// 
  // public function checkLoginInKasiePembelian($employee_code)
  //   {
  //       $oracle = $this->load->database();
  //       $query = "select eea.employee_code, es.unit_name
  //                   from er.er_employee_all eea, er.er_section es
  //                   where eea.section_code = es.section_code
  //                   and eea.employee_code = '$employee_code' ";
  //       $runQuery = $this->db->query($query);
  //       return $runQuery->result_array();
  //   }

     public function po_numberr($invoice_id){
        $oracle = $this->load->database("oracle",TRUE);
        $query = "SELECT DISTINCT aipo.po_number, aipo.invoice_id, poh.attribute2 ppn
                  FROM khs_ap_invoice_purchase_order aipo, po_headers_all poh
                  WHERE invoice_id = '$invoice_id'
                  AND aipo.po_number = poh.segment1 ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
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

       public function returnToAkuntansi($invoice_id, $action_date, $note)
      {
        $erp_db = $this->load->database('oracle',true);
        $sql = "update khs_ap_monitoring_invoice set 
                    returned_date_purc = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                    source_bermasalah = 'PURCHASING',
                    note_return_purc = '$note' 
                    where invoice_id = '$invoice_id'";
        $run = $erp_db->query($sql);
      }

      public function returnToAkuntansiBuyer($invoice_id, $action_date, $note)
      {
        $erp_db = $this->load->database('oracle',true);
        $sql = "update khs_ap_monitoring_invoice set 
                    returned_date_buyer = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                    source_bermasalah = 'BUYER',
                    note_return_buyer = '$note' 
                    where invoice_id = '$invoice_id'";
        $run = $erp_db->query($sql);
      }

      public function getDokumenBermasalah($invoice_id)
      {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT 
                    adi.DOCUMENT_ID, 
                    adi.INVOICE_ID, 
                    adi.DOCUMENT_NAME, 
                    adi.STATUS_DOCUMENT_PURC, 
                    adi.STATUS_DOCUMENT_BUYER, 
                    adi.DATE_CONFIRMATION_PURC, 
                    adi.DATE_CONFIRMATION_BUYER, 
                    adi.CREATION_DATE,
                    ami.restatus_berkas_purc
                FROM KHS_AP_DOKUMEN_INV adi, khs_ap_monitoring_invoice ami
                WHERE adi.INVOICE_ID = ami.invoice_id       
                and adi.INVOICE_ID = $invoice_id";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
      }

      public function getDokumenRekonfirmasi($invoice_id)
      {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT 
                    DOCUMENT_ID, 
                    INVOICE_ID, 
                    DOCUMENT_NAME, 
                    STATUS_DOCUMENT_BUYER, 
                    DATE_CONFIRMATION_BUYER,
                    RESTATUS_DOCUMENT_PURC, 
                    REDATE_CONFIRMATION_PURC, 
                    CREATION_DATE 
                FROM KHS_AP_DOKUMEN_INV
                WHERE INVOICE_ID = $invoice_id";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
      }

    public function finishInvBermasalah()
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.source_bermasalah,
                ami.FEEDBACK_PURCHASING,
                ami.PURC_ACTION_BERMASALAH,
                ami.FEEDBACK_BUYER,
                ami.BUYER_ACTION_BERMASALAH,
                ami.NO_INDUK_BUYER,
                ami.STATUS_BERKAS_PURC,
                ami.STATUS_BERKAS_BUYER,
                mib.NAMA_BUYER,
                        (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'Y'
                             and adi.invoice_id = ami.invoice_id) jmlh_y,
                         (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'N'
                             and adi.invoice_id = ami.invoice_id) jmlh_n
                FROM khs_ap_monitoring_invoice ami
                LEFT JOIN khs_ap_mon_inv_buyer mib ON mib.NO_INDUK = ami.NO_INDUK_BUYER
                WHERE kategori_inv_bermasalah IS NOT NULL 
                AND STATUS_INV_BERMASALAH = '5'
                ORDER BY ami.akt_action_bermasalah DESC";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

     public function finishInvBermasalahBuyer($user)
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.source_bermasalah,
                ami.FEEDBACK_PURCHASING,
                ami.PURC_ACTION_BERMASALAH,
                ami.FEEDBACK_BUYER,
                ami.BUYER_ACTION_BERMASALAH,
                ami.NO_INDUK_BUYER,
                ami.STATUS_BERKAS_PURC,
                ami.STATUS_BERKAS_BUYER,
                mib.NAMA_BUYER,
                        (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'Y'
                             and adi.invoice_id = ami.invoice_id) jmlh_y,
                         (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'N'
                             and adi.invoice_id = ami.invoice_id) jmlh_n
                FROM khs_ap_monitoring_invoice ami
                LEFT JOIN khs_ap_mon_inv_buyer mib ON mib.NO_INDUK = ami.NO_INDUK_BUYER
                WHERE kategori_inv_bermasalah IS NOT NULL 
                AND STATUS_INV_BERMASALAH = '5'
                AND NO_INDUK_BUYER = '$user'
                ORDER BY ami.akt_action_bermasalah DESC";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function getBuyer()
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT NO_INDUK, NAMA_BUYER FROM khs_ap_mon_inv_buyer";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function getStatusPurc($invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT STATUS_BERKAS_PURC, NOTE_BUYER FROM KHS_AP_MONITORING_INVOICE WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function getPoandBuyer($invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT DISTINCT po_number FROM khs_ap_invoice_purchase_order WHERE invoice_id = $invoice_id";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function cariBuyerDefault($po_number)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT DISTINCT  
                         pha.SEGMENT1 NO_PO
                        ,ppf.full_name buyer 
                        ,po_headers_sv3.get_po_status(pha.po_header_id) status
                    FROM
                        po_headers_all pha
                        ,ap_terms_tl att
                        ,po_vendors pv
                        ,per_people_f ppf
                    WHERE
                        pha.TERMS_ID = att.TERM_ID
                        AND pha.agent_id = ppf.person_id
                        and pha.VENDOR_ID = pv.VENDOR_ID
                        AND pha.SEGMENT1 = $po_number";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function isiNote($invoice_id,$note)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "INSERT INTO KHS_AP_DOKUMEN_INV (INVOICE_ID, NOTE_BUYER, CREATION_DATE) VALUES ($invoice_id, '$note', sysdate)";
        $runQuery = $erp_db->query($sql);
    }

    public function ForwardToBuyer($invoice_id,$no_induk,$note)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE SET NO_INDUK_BUYER = '$no_induk', STATUS_INV_BERMASALAH = 3, NOTE_BUYER = '$note'
                WHERE invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function listInvBermasalah()
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "  SELECT  ami.invoice_id, ami.vendor_name vendor_name,
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
                ami.source_bermasalah,
                ami.FEEDBACK_PURCHASING,
                ami.PURC_ACTION_BERMASALAH,
                ami.FEEDBACK_BUYER,
                ami.BUYER_ACTION_BERMASALAH,
                ami.NO_INDUK_BUYER,
                ami.STATUS_BERKAS_PURC,
                ami.STATUS_BERKAS_BUYER,
                mib.NAMA_BUYER,
                ami.status_inv_bermasalah,
                ami.returned_flag,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.note_buyer,
                ami.note_return_akt,
                ami.note_return_purc,
                ami.kelengkapan_doc_inv_returned,
                ami.note_return_buyer,
                ami.returned_date_buyer,
                        (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'Y'
                             and adi.invoice_id = ami.invoice_id) jmlh_y,
                         (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'N'
                             and adi.invoice_id = ami.invoice_id) jmlh_n
                FROM khs_ap_monitoring_invoice ami
                LEFT JOIN khs_ap_mon_inv_buyer mib ON mib.NO_INDUK = ami.NO_INDUK_BUYER
                WHERE STATUS_INV_BERMASALAH NOT IN (0,3,5)
                ORDER BY ami.akt_action_bermasalah DESC";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function listInvBermasalahBuyer($user)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT  ami.invoice_id, 
                ami.vendor_name vendor_name,
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
                ami.FEEDBACK_PURCHASING,
                ami.PURC_ACTION_BERMASALAH,
                ami.FEEDBACK_BUYER,
                ami.BUYER_ACTION_BERMASALAH,
                ami.STATUS_BERKAS_PURC,
                ami.STATUS_BERKAS_BUYER,
                ami.NO_INDUK_BUYER,
                ami.SOURCE_BERMASALAH,
                ami.NOTE_BUYER,
                mib.NAMA_BUYER,
                ami.returned_flag,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.note_buyer,
                ami.note_return_akt,
                ami.note_return_purc,
                ami.kelengkapan_doc_inv_returned,
                ami.note_return_buyer,
                ami.returned_date_buyer
                    FROM khs_ap_monitoring_invoice ami
                    LEFT JOIN khs_ap_mon_inv_buyer mib ON mib.NO_INDUK = ami.NO_INDUK_BUYER
                    WHERE kategori_inv_bermasalah IS NOT NULL 
                    AND ami.NO_INDUK_BUYER = '$user'
                    AND STATUS_INV_BERMASALAH not in (5)
                    ORDER BY ami.akt_action_bermasalah DESC";       
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

     public function listInvBermasalahBuyerSistem()
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT  ami.invoice_id, 
                ami.vendor_name vendor_name,
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
                ami.FEEDBACK_PURCHASING,
                ami.PURC_ACTION_BERMASALAH,
                ami.FEEDBACK_BUYER,
                ami.BUYER_ACTION_BERMASALAH,
                ami.STATUS_BERKAS_PURC,
                ami.STATUS_BERKAS_BUYER,
                ami.NO_INDUK_BUYER,
                ami.SOURCE_BERMASALAH,
                mib.NAMA_BUYER
                    FROM khs_ap_monitoring_invoice ami
                    LEFT JOIN khs_ap_mon_inv_buyer mib ON mib.NO_INDUK = ami.NO_INDUK_BUYER
                    WHERE STATUS_INV_BERMASALAH IN (3)
                    ORDER BY ami.akt_action_bermasalah DESC";       
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }


     public function invBermasalah($invoice_id)
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
                ami.source source,
                ami.KATEGORI_INV_BERMASALAH,
                ami.KELENGKAPAN_DOC_INV_BERMASALAH,
                ami.KETERANGAN_INV_BERMASALAH,
                ami.FEEDBACK_PURCHASING
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.invoice_id = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function invBermasalahBuyer($invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = " SELECT aipo.invoice_id invoice_id, 
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
                ami.FEEDBACK_PURCHASING,
                ami.NO_INDUK_BUYER,
                ami.STATUS_BERKAS_PURC,
                ami.FEEDBACK_PURCHASING
                FROM khs_ap_monitoring_invoice ami
                JOIN khs_ap_invoice_purchase_order aipo ON ami.invoice_id = aipo.invoice_id
                WHERE ami.invoice_id = '$invoice_id'";

        // echo"<pre>";echo $sql;exit();
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function getFeedback($invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT FEEDBACK_PURCHASING, STATUS_BERKAS_PURC, RESTATUS_BERKAS_PURC, NOTE_BUYER from KHS_AP_MONITORING_INVOICE WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function getFeedbackBuyer($invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "SELECT FEEDBACK_BUYER, STATUS_BERKAS_BUYER from KHS_AP_MONITORING_INVOICE WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
        return $runQuery->result_array();
    }

    public function kirimFeedback($invoice_id,$feedback,$action_date)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE SET PURC_FINISHED_DATE = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), FEEDBACK_PURCHASING = '$feedback', STATUS_INV_BERMASALAH = '4' WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

     public function kirimFeedbackBuyer($invoice_id,$feedback,$action_date)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE SET BUYER_FINISHED_DATE = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'), FEEDBACK_BUYER = '$feedback', STATUS_INV_BERMASALAH = '4' WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }    

        public function saveInvBermasalah($invoice_id,$action_date,$status_berkas)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE 
                SET 
                PURC_ACTION_BERMASALAH = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                STATUS_BERKAS_PURC = '$status_berkas',
                STATUS_INV_BERMASALAH = '2',
                SOURCE_BERMASALAH = 'PURCHASING'
                WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function saveReconfirmInvBermasalah($invoice_id,$action_date,$status_berkas)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE 
                SET 
                PURC_RESTATUS_DATE = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                RESTATUS_BERKAS_PURC = '$status_berkas',
                SOURCE_BERMASALAH = 'PURCHASING'
                WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function saveInvBermasalahBuyer($invoice_id,$action_date,$status_berkas)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_MONITORING_INVOICE 
                SET 
                BUYER_ACTION_BERMASALAH = to_date('$action_date', 'DD/MM/YYYY HH24:MI:SS'),
                STATUS_BERKAS_BUYER = '$status_berkas',
                SOURCE_BERMASALAH = 'BUYER'
                WHERE INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function updateTabelBerkas($waktu_berkas,$doc_id,$hasil,$invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_DOKUMEN_INV
                SET DATE_CONFIRMATION_PURC = '$waktu_berkas',
                STATUS_DOCUMENT_PURC = '$hasil'
                WHERE DOCUMENT_ID = '$doc_id' AND INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

    public function ReupdateTabelBerkas($waktu_berkas,$doc_id,$hasil,$invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_DOKUMEN_INV
                SET REDATE_CONFIRMATION_PURC = '$waktu_berkas',
                RESTATUS_DOCUMENT_PURC = '$hasil'
                WHERE DOCUMENT_ID = '$doc_id' AND INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }

      public function updateTabelBerkasBuyer($waktu_berkas,$doc_id,$hasil,$invoice_id)
    {
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE KHS_AP_DOKUMEN_INV
                SET DATE_CONFIRMATION_BUYER = '$waktu_berkas',
                STATUS_DOCUMENT_BUYER = '$hasil'
                WHERE DOCUMENT_ID = '$doc_id' AND INVOICE_ID = '$invoice_id'";
        $runQuery = $erp_db->query($sql);
    }


	public function showListSubmittedForChecking($login){
		$erp_db = $this->load->database('oracle',true);
		$sql = "SELECT distinct batch_number batch_number, MAX (to_date(last_admin_date)) submited_date,
                last_finance_invoice_status, source
                FROM khs_ap_monitoring_invoice 
                WHERE (last_purchasing_invoice_status = 1 OR last_purchasing_invoice_status = 2)
                AND LAST_FINANCE_INVOICE_STATUS=0
                $login
                GROUP BY batch_number, last_finance_invoice_status, source
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

  function get_ora_blob_value($value)
      {
          $size = $value->size();
          $result = $value->read($size);
          return ($result)?$result:NULL;
      }

    public function showDetailPerBatch($batchNumber){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT ami.invoice_id invoice_id,
                         ami.vendor_name vendor_name,
                         ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason, 
                         ami.last_finance_invoice_status finance_status,
                         aiac2.action_date action_date,
                         ami.batch_number batch_number,
                         ami.last_purchasing_invoice_status last_purchasing_invoice_status,
                         ami.info info,
                         ami.invoice_category invoice_category,
                         ami.nominal_dpp nominal_dpp,
                         ami.jenis_jasa jenis_jasa,
                         aaipo.po_detail po_detail
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
                      GROUP BY aipo.invoice_id) aaipo,
                      (select distinct min(action_date) over (partition by invoice_id) action_date, invoice_id 
                      from khs_ap_invoice_action_detail aiac) aiac2
               WHERE aaipo.invoice_id = ami.invoice_id
                 AND ami.batch_number = '$batchNumber'
                 and aiac2.invoice_id = ami.invoice_id
            ORDER BY vendor_name, invoice_number";
        $query = $oracle->query($sql);
        $arr = $query->result_array();
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

    public function approvedbykasiepurchasing($id,$status,$last_status_purchasing_date){
    	$erp_db = $this->load->database('oracle',true);
    	$sql = "UPDATE khs_ap_monitoring_invoice
    			SET last_purchasing_invoice_status = '$status',
                last_status_purchasing_date = to_date('$last_status_purchasing_date', 'DD/MM/YYYY HH24:MI:SS')
                WHERE invoice_id = $id";
    	$run = $erp_db->query($sql);
    }

    public function rejectbykasiepurchasing($id,$status,$last_status_purchasing_date,$reason){
        $erp_db = $this->load->database('oracle',true);
        $sql = "UPDATE khs_ap_monitoring_invoice
                SET last_purchasing_invoice_status = '$status',
                last_status_purchasing_date = to_date('$last_status_purchasing_date', 'DD/MM/YYYY HH24:MI:SS'),
                reason = '$reason'
                WHERE invoice_id = $id";
        $run = $erp_db->query($sql);
    }

    public function approveInvoice($id,$status,$last_status_purchasing_date){
      $erp_db = $this->load->database('oracle',true);
      $sql = "UPDATE khs_ap_monitoring_invoice
          SET last_purchasing_invoice_status = '$status',
                last_status_purchasing_date = to_date('$last_status_purchasing_date', 'DD/MM/YYYY HH24:MI:SS'),
                reason = ''
                WHERE invoice_id = $id";
      $run = $erp_db->query($sql);
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

    public function getStatusSatu()
    {
        $oracle = $this->load->database('oracle',TRUE);
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
                ami.kategori_inv_bermasalah,
                ami.kelengkapan_doc_inv_bermasalah,
                ami.keterangan_inv_bermasalah,
                ami.akt_action_bermasalah akt_date,
                ami.source_bermasalah,
                ami.FEEDBACK_PURCHASING,
                ami.PURC_ACTION_BERMASALAH,
                ami.FEEDBACK_BUYER,
                ami.BUYER_ACTION_BERMASALAH,
                ami.NO_INDUK_BUYER,
                ami.STATUS_BERKAS_PURC,
                ami.STATUS_BERKAS_BUYER,
                mib.NAMA_BUYER,
                ami.status_inv_bermasalah,
                ami.returned_flag,
                ami.returned_date_akt,
                ami.returned_date_purc,
                ami.note_buyer,
                ami.note_return_akt,
                ami.note_return_purc,
                ami.kelengkapan_doc_inv_returned,
                        (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'Y'
                             and adi.invoice_id = ami.invoice_id) jmlh_y,
                         (SELECT COUNT (adi.status_document_buyer) hasil_n
                            FROM khs_ap_dokumen_inv adi LEFT JOIN khs_ap_monitoring_invoice ami3
                              ON ami3.invoice_id = adi.invoice_id
                           WHERE status_document_buyer = 'N'
                             and adi.invoice_id = ami.invoice_id) jmlh_n
                FROM khs_ap_monitoring_invoice ami
                LEFT JOIN khs_ap_mon_inv_buyer mib ON mib.NO_INDUK = ami.NO_INDUK_BUYER
                WHERE STATUS_INV_BERMASALAH NOT IN (0,3,5)
                ORDER BY ami.last_admin_date DESC";
        $run = $oracle->query($sql);
        return $run->num_rows();
    }

    public function getStatusBuyer($user)
    {
        $oracle = $this->load->database('oracle',TRUE);
        $sql = "SELECT COUNT(INVOICE_ID) SATU FROM khs_ap_monitoring_invoice WHERE STATUS_INV_BERMASALAH = 3 AND NO_INDUK_BUYER = '$user'";
        $run = $oracle->query($sql);
        return $run->result_array();
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
        $sql = "SELECT to_char(tabel.submited_date, 'MONTH'),
                tabel.batch_number,
                tabel.finance_batch_number,
                tabel.last_purchasing_invoice_status,
                tabel.last_finance_invoice_status,
                tabel.SOURCE,
                tabel.submited_date,
                tabel.jml_invoice
                FROM 
                (SELECT DISTINCT a.batch_number, 
                                a.finance_batch_number, 
                                a.last_purchasing_invoice_status, 
                                a.last_finance_invoice_status,
                                a.source,
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
                AND a.last_finance_invoice_status = 1
                AND (a.last_purchasing_invoice_status = 2 OR a.last_purchasing_invoice_status = 3)
                $login) tabel
                WHERE 
                to_char(tabel.submited_date, 'MONTH')=to_char(sysdate, 'MONTH')";
                
                $run = $erp_db->query($sql);
                return $run->result_array();

                // -------untuk menampilkan seluruh data -----
                // $sql = "SELECT DISTINCT a.batch_number, 
                //                         a.finance_batch_number, 
                //                         a.last_purchasing_invoice_status, 
                //                         a.last_finance_invoice_status,
                //                         a.source,
                //                         (SELECT DISTINCT to_date(d.action_date)
                //                                     FROM khs_ap_invoice_action_detail d
                //                                    WHERE d.invoice_id = a.invoice_id
                //                                      AND d.finance_status = 1
                //                                      AND d.purchasing_status = 2 AND rownum = 1) submited_date,
                //                         (SELECT COUNT (*)
                //                            FROM khs_ap_monitoring_invoice b
                //                           WHERE b.batch_number = a.batch_number)jml_invoice
                //         FROM khs_ap_monitoring_invoice a
                //         WHERE a.batch_number IS NOT NULL
                //         AND a.last_finance_invoice_status = 2
                //         AND (a.last_purchasing_invoice_status = 2 OR a.last_purchasing_invoice_status = 3)
                //         $login
                //         ORDER BY submited_date desc";
        
    }

    public function finish_detail($batchNumber){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT ami.invoice_id invoice_id,
                         ami.vendor_name vendor_name,
                         ami.invoice_number invoice_number, 
                         ami.invoice_date invoice_date, 
                         ami.tax_invoice_number tax_invoice_number,
                         ami.invoice_amount invoice_amount, 
                         ami.last_purchasing_invoice_status status, 
                         ami.reason reason, 
                         ami.last_finance_invoice_status finance_status,
                         aiac2.action_date action_date,
                         ami.batch_number batch_number,
                         ami.last_purchasing_invoice_status last_purchasing_invoice_status,
                         ami.info info,
                         ami.invoice_category invoice_category,
                         ami.nominal_dpp nominal_dpp,
                         ami.jenis_jasa jenis_jasa,
                         aaipo.po_detail po_detail,
                         ami.last_status_purchasing_date last_status_purchasing_date
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
                      GROUP BY aipo.invoice_id) aaipo,
                      (select distinct min(action_date) over (partition by invoice_id) action_date, invoice_id 
                      from khs_ap_invoice_action_detail aiac) aiac2
               WHERE aaipo.invoice_id = ami.invoice_id
                 AND ami.batch_number = '$batchNumber'
                 and aiac2.invoice_id = ami.invoice_id
            ORDER BY vendor_name, invoice_number";
        $query = $oracle->query($sql);
        $arr = $query->result_array();
        foreach ($arr as $key => $value) {
          $arr[$key]['PO_DETAIL'] = $this->get_ora_blob_value($arr[$key]['PO_DETAIL']);
        }
       
        return $arr;
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
        $sql = "SELECT last_purchasing_invoice_status, last_finance_invoice_status
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

    public function showInv($invoice_id)
    {
          $erp_db = $this->load->database('oracle',true);
          $sql = "SELECT NOTE_RETURN_PURC,INVOICE_ID FROM khs_ap_monitoring_invoice WHERE invoice_id = '$invoice_id' ";
          $run = $erp_db->query($sql);
          return $run->result_array();
    }

     public function showInvBuyer($invoice_id)
    {
          $erp_db = $this->load->database('oracle',true);
          $sql = "SELECT NOTE_RETURN_BUYER,INVOICE_ID FROM khs_ap_monitoring_invoice WHERE invoice_id = '$invoice_id' ";
          $run = $erp_db->query($sql);
          return $run->result_array();
    }

}