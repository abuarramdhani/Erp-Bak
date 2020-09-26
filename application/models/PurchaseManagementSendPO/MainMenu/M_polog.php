<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_polog extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }
    public function getDataPO()
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
        ,CEIL(24*(sysdate-kppl.SEND_DATE_1)) selisih_waktu
        ,kppl.DELIVERY_STATUS_1
        ,kppl.SEND_DATE_2
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
        and (kppl.DELETE_FLAG is null or kppl.DELETE_FLAG <> 'Y')";

        return $this->oracle->query($sql)->result_array();
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
        ,CEIL(24*(sysdate-kppl.SEND_DATE_1)) selisih_waktu
        ,kppl.DELIVERY_STATUS_1
        ,kppl.SEND_DATE_2
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
        and kppl.VENDOR_CONFIRM_DATE is null
        AND ppf.NATIONAL_IDENTIFIER = '$BuyerNIK'";

        return $this->oracle->query($sql)->result_array();
    }

    public function update1($noPO, $status)
    {
        $sql = "UPDATE khs_psup_po_logbook SET DELIVERY_STATUS_1 = '$status', SEND_DATE_1 = SYSDATE WHERE PHA_SEGMENT_1 = '$noPO'";
        return $this->oracle->query($sql);
    }

    public function update2($noPO, $status)
    {
        $sql = "UPDATE khs_psup_po_logbook SET DELIVERY_STATUS_2 = '$status', SEND_DATE_2 = SYSDATE WHERE PHA_SEGMENT_1 = '$noPO'";
        return $this->oracle->query($sql);
    }

    public function cekDeliveryStatus($noPO)
    {
        $sql = "SELECT delivery_status_1 FROM khs_psup_po_logbook WHERE PHA_SEGMENT_1 = '$noPO'";
        return $this->oracle->query($sql)->row()->DELIVERY_STATUS_1;
    }

    public function updateDelete($noPO)
    {
        $sql = "UPDATE khs_psup_po_logbook SET DELETE_FLAG = 'Y' WHERE PHA_SEGMENT_1 = '$noPO'";
        return $this->oracle->query($sql);
    }

    public function updateVendorData($noPO, $date, $dis_method, $con_method, $pic, $attachment_flag, $lampiran)
    {
        $query = "UPDATE khs_psup_po_logbook SET VENDOR_CONFIRM_DATE = TO_DATE('$date', 'MM/DD/YYYY'), DISTRIBUTION_METHOD = '$dis_method', VENDOR_CONFIRM_METHOD = '$con_method', VENDOR_CONFIRM_PIC = '$pic', ATTACHMENT_FLAG = '$attachment_flag', ATTACHMENT = '$lampiran' WHERE PHA_SEGMENT_1 = '$noPO'";
        $this->oracle->query($query);
    }
}