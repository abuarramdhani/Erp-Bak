<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_pologbook extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }
    public function getDataPObyNik($BuyerNIK)
    {
        $sql = "select
        kppl.LOGBOOK_ID
        ,kppl.PRINT_DATE input_date
        ,fu.USER_NAME employee
        ,kppl.PHA_SEGMENT_1 po_number
        ,kppl.VENDOR_NAME vendor_name
        ,kppl.BUYER buyer_name
        ,ppf.NATIONAL_IDENTIFIER buyer_nik
        ,kppl.REVISION_NUM po_revision
        ,kppl.ATTACHMENT_FLAG
        ,kppl.PRINT_DATE po_print_date
        ,kppl.DISTRIBUTION_METHOD
        ,kppl.PURCHASING_APPROVE_DATE
        ,kppl.MANAGEMENT_APPROVE_DATE
        ,kppl.SEND_DATE_1
        ,CEIL(24*(sysdate-kppl.SEND_DATE_1)) selisih_waktu_1
        ,kppl.DELIVERY_STATUS_1
        ,kppl.SEND_DATE_2
        ,CEIL(24*(sysdate-kppl.SEND_DATE_2)) selisih_waktu_2
        ,kppl.DELIVERY_STATUS_2
        ,kppl.VENDOR_CONFIRM_DATE
        ,kppl.VENDOR_CONFIRM_METHOD
        ,kppl.VENDOR_CONFIRM_PIC
        ,kppl.ATTACHMENT
        from
        khs_psup_po_logbook kppl
        ,fnd_user fu
        ,per_people_f ppf
        ,po_headers_all pha
        where
        kppl.PRINT_BY = fu.USER_ID
        and pha.SEGMENT1 = kppl.PHA_SEGMENT_1
        and pha.AGENT_ID = ppf.PERSON_ID
        and (kppl.DELETE_FLAG is null or kppl.DELETE_FLAG <> 'Y')
        AND ppf.NATIONAL_IDENTIFIER = '$BuyerNIK'";

        return $this->oracle->query($sql)->result_array();
    }
    public function updateVendorData($noPO, $date, $dis_method, $con_method, $pic, $attachment_flag, $lampiran)
    {
        $query = "UPDATE khs_psup_po_logbook SET VENDOR_CONFIRM_DATE = TO_DATE('$date', 'MM/DD/YYYY'), DISTRIBUTION_METHOD = '$dis_method', VENDOR_CONFIRM_METHOD = '$con_method', VENDOR_CONFIRM_PIC = '$pic', ATTACHMENT_FLAG = '$attachment_flag', ATTACHMENT = '$lampiran' WHERE PHA_SEGMENT_1 = '$noPO'";
        $this->oracle->query($query);
    }
    public function updateVendorData2($noPO, $dis_method, $attachment_flag)
    {
        $query = "UPDATE khs_psup_po_logbook SET DISTRIBUTION_METHOD = '$dis_method', ATTACHMENT_FLAG = '$attachment_flag' WHERE PHA_SEGMENT_1 = '$noPO'";
        $this->oracle->query($query);
    }
    public function get_data_byid($noPO)
    {
        $query = "SELECT CEIL(24*(sysdate-khs_psup_po_logbook.SEND_DATE_2)) selisih_waktu_2, VENDOR_CONFIRM_DATE FROM khs_psup_po_logbook WHERE PHA_SEGMENT_1 = '$noPO'";
        return $this->oracle->query($query)->row_array();
    }
}