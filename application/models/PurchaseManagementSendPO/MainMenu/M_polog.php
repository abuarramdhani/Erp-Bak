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
    public function getAllPO()
    {
        return $this->oracle->query(
            "SELECT LOGBOOK_ID, PHA_SEGMENT_1, REVISION_NUM, ATTACHMENT FROM khs_psup_po_logbook WHERE ATTACHMENT IS NOT NULL ORDER BY LOGBOOK_ID DESC"
        )->result_array();
    }

    public function updatePOAttachmentName($id, $attachment)
    {
        $this->oracle->query("UPDATE
            khs_psup_po_logbook
        SET
            attachment = '$attachment'
        WHERE
            LOGBOOK_ID = $id
        ");
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

    public function getDataByPoNumb($noPO, $po_rev)
    {
        $sql = "SELECT
        kppl.LOGBOOK_ID ,
        kppl.PRINT_DATE input_date ,
        kcpl.CF_ADMIN_PO employee ,
        kppl.PHA_SEGMENT_1 po_number ,
        kppl.VENDOR_NAME vendor_name ,
        kppl.BUYER buyer_name ,
        ppf.NATIONAL_IDENTIFIER buyer_nik ,
        kppl.REVISION_NUM po_revision ,
        kppl.ATTACHMENT_FLAG ,
        kppl.PRINT_DATE po_print_date ,
        kppl.DISTRIBUTION_METHOD ,
        kppl.PURCHASING_APPROVE_DATE ,
        kppl.MANAGEMENT_APPROVE_DATE ,
        kppl.SEND_DATE_1 ,
        CEIL( 24 *( SYSDATE-kppl.SEND_DATE_1 )) selisih_waktu_1 ,
        kppl.DELIVERY_STATUS_1 ,
        kppl.SEND_DATE_2 ,
        CEIL( 24 *( SYSDATE-kppl.SEND_DATE_2 )) selisih_waktu_2 ,
        kppl.DELIVERY_STATUS_2 ,
        kppl.VENDOR_CONFIRM_DATE ,
        kppl.VENDOR_CONFIRM_METHOD ,
        kppl.VENDOR_CONFIRM_PIC ,
        kppl.VENDOR_CONFIRM_NOTE ,
        kppl.ATTACHMENT
    FROM
        khs_psup_po_logbook kppl ,
        fnd_user fu ,
        per_people_f ppf ,
        po_headers_all pha ,
        khs.khs_cetak_po_landscape kcpl
    WHERE
        kppl.PRINT_BY = fu.USER_ID
        AND pha.SEGMENT1 = kppl.PHA_SEGMENT_1
        AND pha.AGENT_ID = ppf.PERSON_ID
        AND ( kppl.DELETE_FLAG IS NULL
        OR kppl.DELETE_FLAG <> 'Y' )
        AND fu.USER_NAME LIKE '%PSUP%'
        AND kppl.REQUEST_ID = kcpl.REQUEST_ID
        AND kppl.PHA_SEGMENT_1 = kcpl.SEGMENT1
        AND kcpl.NOMORQ = 1
        AND PHA_SEGMENT_1 = '$noPO'
        AND kppl.REVISION_NUM = '$po_rev'
    ORDER BY
        PRINT_DATE DESC";

        return $this->oracle->query($sql);
    }

    public function update1($noPO, $po_rev, $status)
    {
        $sql = "UPDATE khs_psup_po_logbook SET DELIVERY_STATUS_1 = '$status', SEND_DATE_1 = SYSDATE WHERE PHA_SEGMENT_1 = '$noPO' AND REVISION_NUM = '$po_rev'";
        return $this->oracle->query($sql);
    }

    public function update2($noPO, $po_rev, $status)
    {
        $sql = "UPDATE khs_psup_po_logbook SET DELIVERY_STATUS_2 = '$status', SEND_DATE_2 = SYSDATE WHERE PHA_SEGMENT_1 = '$noPO' AND REVISION_NUM = '$po_rev'";
        return $this->oracle->query($sql);
    }

    public function updateVendorData($noPO, $po_rev, $date, $con_method, $pic, $note, $lampiran)
    {
        $query = "UPDATE khs_psup_po_logbook SET VENDOR_CONFIRM_DATE = TO_DATE('$date', 'DD/MM/YYYY'), VENDOR_CONFIRM_METHOD = '$con_method', VENDOR_CONFIRM_PIC = '$pic', VENDOR_CONFIRM_NOTE = '$note', ATTACHMENT = '$lampiran' WHERE PHA_SEGMENT_1 = '$noPO' AND REVISION_NUM = '$po_rev'";
        $this->oracle->query($query);
    }

    public function updateVendorData2($noPO, $po_rev, $date, $dis_method, $send_date_1, $send_date_2, $con_method, $pic, $note, $attachment_flag, $lampiran)
    {
        $query = "UPDATE khs_psup_po_logbook SET VENDOR_CONFIRM_DATE = TO_DATE('$date', 'DD/MM/YYYY'), DISTRIBUTION_METHOD = '$dis_method', SEND_DATE_1 = TO_DATE('$send_date_1', 'DD/MM/YYYY'), SEND_DATE_2 = TO_DATE('$send_date_2', 'DD/MM/YYYY'), VENDOR_CONFIRM_METHOD = '$con_method', VENDOR_CONFIRM_PIC = '$pic', VENDOR_CONFIRM_NOTE = '$note', ATTACHMENT_FLAG = '$attachment_flag', ATTACHMENT = '$lampiran' WHERE PHA_SEGMENT_1 = '$noPO' AND REVISION_NUM = '$po_rev'";
        $this->oracle->query($query);
    }

    public function updateVendorDisMetEmail($noPO, $po_rev, $date, $dis_method, $con_method, $pic, $note, $attachment_flag, $lampiran)
    {
        $query = "UPDATE khs_psup_po_logbook SET VENDOR_CONFIRM_DATE = TO_DATE('$date', 'DD/MM/YYYY'), DISTRIBUTION_METHOD = '$dis_method', VENDOR_CONFIRM_METHOD = '$con_method', VENDOR_CONFIRM_PIC = '$pic', VENDOR_CONFIRM_NOTE = '$note', ATTACHMENT_FLAG = '$attachment_flag', ATTACHMENT = '$lampiran' WHERE PHA_SEGMENT_1 = '$noPO' AND REVISION_NUM = '$po_rev'";
        $this->oracle->query($query);
    }

    public function updateVendorDisMetNone($noPO, $po_rev, $dis_method)
    {
        $query = "UPDATE khs_psup_po_logbook SET DISTRIBUTION_METHOD = '$dis_method' WHERE PHA_SEGMENT_1 = '$noPO' AND REVISION_NUM = '$po_rev'";
        $this->oracle->query($query);
    }
}