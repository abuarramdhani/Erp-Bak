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
        ,kcpl.CF_ADMIN_PO employee
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
        ,kppl.VENDOR_CONFIRM_NOTE
        ,kppl.ATTACHMENT
        from
        khs_psup_po_logbook kppl
        ,fnd_user fu
        ,per_people_f ppf
        ,po_headers_all pha
        ,khs.khs_cetak_po_landscape kcpl
        where
        kppl.PRINT_BY = fu.USER_ID
        and pha.SEGMENT1 = kppl.PHA_SEGMENT_1
        and pha.AGENT_ID = ppf.PERSON_ID
        and (kppl.DELETE_FLAG is null or kppl.DELETE_FLAG <> 'Y')
        and fu.USER_NAME like '%PSUP%'
        and kppl.REQUEST_ID = kcpl.REQUEST_ID
        and kppl.PHA_SEGMENT_1 = kcpl.SEGMENT1
        and kcpl.NOMORQ = 1
        ORDER BY PRINT_DATE desc";

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

    public function updateVendorData($noPO, $date, $con_method, $pic, $note, $lampiran)
    {
        $query = "UPDATE khs_psup_po_logbook SET VENDOR_CONFIRM_DATE = TO_DATE('$date', 'MM/DD/YYYY'), VENDOR_CONFIRM_METHOD = '$con_method', VENDOR_CONFIRM_PIC = '$pic', VENDOR_CONFIRM_NOTE = '$note', ATTACHMENT = '$lampiran' WHERE PHA_SEGMENT_1 = '$noPO'";
        $this->oracle->query($query);
    }
}