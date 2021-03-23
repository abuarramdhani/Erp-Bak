<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dpb extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function getWaitingListApprove($user)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM khs_dpb_sp_headers WHERE APPROVAL_FLAG is null AND APPROVE_TO_1 = '$user'");

        return $query->result_array();
    }

    public function getAllWaitingListApprove()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM khs_dpb_sp_headers WHERE APPROVAL_FLAG is null");

        return $query->result_array();
    }

    public function getApprovedList($user)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM khs_dpb_sp_headers WHERE APPROVAL_FLAG = 'Y' AND APPROVE_TO_1 = '$user'");

        return $query->result_array();
    }

    public function getRejectedList($user)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM khs_dpb_sp_headers WHERE APPROVAL_FLAG = 'N' AND APPROVE_TO_1 = '$user'");

        return $query->result_array();
    }

    public function getAllApprovedList()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM khs_dpb_sp_headers WHERE APPROVAL_FLAG = 'Y'");

        return $query->result_array();
    }

    public function getAllRejectedList()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM khs_dpb_sp_headers WHERE APPROVAL_FLAG = 'N'");

        return $query->result_array();
    }

    public function getDetail($reqNumber)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM khs_dpb_sp_details WHERE REQUEST_NUMBER = '$reqNumber'");

        return $query->result_array();
    }

    public function updateStatus($reqNumber, $status)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("UPDATE khs_tampung_spb kts set kts.APPROVAL_FLAG = '$status' where kts.NO_DOKUMEN = '$reqNumber'");
    }

    public function getMonitoringList()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        kts.NO_DOKUMEN
        ,kts.JENIS_DOKUMEN
        ,kts.TIPE
        ,mtrh.ATTRIBUTE15 EKSPEDISI
        ,kts.MULAI_PELAYANAN
        ,kts.SELESAI_PELAYANAN
        ,kts.WAKTU_PELAYANAN
        ,kts.MULAI_PACKING
        ,kts.SELESAI_PACKING
        ,kts.WAKTU_PACKING
        from
        khs_tampung_spb kts
        ,mtl_txn_request_headers mtrh
        where
        kts.NO_DOKUMEN = mtrh.REQUEST_NUMBER
        and kts.APPROVE_TO_1 is not null");

        return $query->result_array();
    }

    function checkDPB($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        mtrh.REQUEST_NUMBER
        from
        mtl_txn_request_headers mtrh
        ,khs_tampung_spb kts
        where
        mtrh.REQUEST_NUMBER = kts.NO_DOKUMEN(+)
        and kts.NO_DOKUMEN is null
        and mtrh.REQUEST_NUMBER = '$noDPB'");

        return $query->result_array();
    }

    public function listBarang($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        msib.segment1 segment1 ,
        msib.DESCRIPTION ,
        tbl1.req_qty
        --,NVL(SUM(moqd.transaction_quantity),0) QTY_ONHAND
    ,
        ( NVL ( (
        SELECT
            SUM( moqd.transaction_quantity )
        FROM
            mtl_onhand_quantities_detail moqd
        WHERE
            moqd.inventory_item_id = msib.inventory_item_id
            AND moqd.SUBINVENTORY_CODE = 'SP-YSP' ) ,
        0 ) - (
        SELECT
            NVL( SUM( mr.RESERVATION_QUANTITY ),
            0 )
        FROM
            MTL_RESERVATIONS MR ,
            mtl_system_items_b msib2
        WHERE
            MR.inventory_item_id = msib2.INVENTORY_ITEM_ID
            AND MR.organization_id = msib2.organization_id
            AND msib2.segment1 = msib.segment1
            AND mr.subinventory_code = 'SP-YSP' ) - (
        SELECT
            NVL( SUM( mmtt.transaction_quantity ),
            0 )
        FROM
            MTL_MATERIAL_TRANSACTIONS_TEMP mmtt ,
            mtl_system_items_b msib3
        WHERE
            msib3.inventory_item_id = mmtt.inventory_item_id
            AND msib3.organization_id = mmtt.organization_id
            AND msib3.segment1 = msib.segment1
            AND mmtt.subinventory_code = 'SP-YSP' ) ) QTY_ATR ,
        ( NVL ( (
        SELECT
            SUM( moqd.transaction_quantity )
        FROM
            mtl_onhand_quantities_detail moqd
        WHERE
            moqd.inventory_item_id = msib.inventory_item_id
            AND moqd.SUBINVENTORY_CODE = 'SP-YSP' ) ,
        0 ) - (
        SELECT
            NVL( SUM( mr.RESERVATION_QUANTITY ),
            0 )
        FROM
            MTL_RESERVATIONS MR ,
            mtl_system_items_b msib2
        WHERE
            MR.inventory_item_id = msib2.INVENTORY_ITEM_ID
            AND MR.organization_id = msib2.organization_id
            AND msib2.segment1 = msib.segment1
            AND mr.subinventory_code = 'SP-YSP' ) - (
        SELECT
            NVL( SUM( mmtt.transaction_quantity ),
            0 )
        FROM
            MTL_MATERIAL_TRANSACTIONS_TEMP mmtt ,
            mtl_system_items_b msib3
        WHERE
            msib3.inventory_item_id = mmtt.inventory_item_id
            AND msib3.organization_id = mmtt.organization_id
            AND msib3.segment1 = msib.segment1
            AND mmtt.subinventory_code = 'SP-YSP' ) ) - tbl1.req_qty ATR_sisa ,
        tbl1.LINE_ID
    FROM
        mtl_system_items_b msib ,
        (
        SELECT
            mtrl.INVENTORY_ITEM_ID ,
            mtrl.QUANTITY req_qty ,
            mtrl.LINE_ID
        FROM
            mtl_txn_request_headers mtrh ,
            mtl_txn_request_lines mtrl
        WHERE
            mtrh.HEADER_ID = mtrl.HEADER_ID
            AND mtrh.ORGANIZATION_ID = 225
            AND mtrh.REQUEST_NUMBER IN ( '$noDPB' )
            --(select * from param) --('3916224', '3916226') --(SELECT * FROM param)
            --group by mtrl.INVENTORY_ITEM_ID
    ) tbl1
    WHERE
        msib.INVENTORY_ITEM_ID = tbl1.INVENTORY_ITEM_ID
    GROUP BY
        msib.inventory_item_id ,
        msib.segment1 ,
        tbl1.req_qty ,
        msib.DESCRIPTION ,
        tbl1.LINE_ID");

        return $query->result_array();
    }

    public function cekStok($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT APPS.KHS_CEK_ATR_DOSPB2('$noDPB', 225, 'SP-YSP') hasil from dual");

        return $query->result_array();
    }

    public function cekStatusLine($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT APPS.KHS_CEK_LINE_STATUS_DOSPB('$noDPB', 225, 'SP-YSP') hasil_line from dual");

        return $query->result_array();
    }

    public function createDPB($noDPB, $jenis, $creator, $forward, $keterangan, $almat, $eks)
    {
        // return print_r("createDPB call");
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("CALL APPS.KHS_ALLOCATE_DOSPB_SP('$noDPB', 225, 'SP-YSP', '$jenis', '$creator', '$forward','$keterangan','$almat','$eks')");
    }

    public function createDPBRequest($reqNumber, $lineId, $allocateQty, $creator)
    {
        // return print_r("createDPB");
        $oracle = $this->load->database('oracle', true);
        $oracle->query("INSERT INTO
            KHS_MO_ALLOCATE_TEMP KMAT ( KMAT.REQUEST_NUMBER ,
            KMAT.LINE_ID ,
            KMAT.ALLOCATE_QUANTITY ,
            KMAT.CREATED_BY )
        VALUES ( '$reqNumber' ,
        $lineId ,
        $allocateQty ,
        '$creator' )
        ");
    }


    public function getAlamat($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT CASE
        WHEN REGEXP_LIKE ('$noDPB', '^[[:digit:]]+$')
            THEN CASE
                WHEN (SELECT DISTINCT wdd.batch_id
                    FROM wsh_delivery_details wdd
                    WHERE wdd.batch_id = '$noDPB') IS NOT NULL THEN -- parameter
                (SELECT DISTINCT  hp.PARTY_NAME 
                        ||', '
                        || hl.address1
                        || ', '
                        || hl.city
                        || ', '
                        || hl.province city
                    FROM wsh_delivery_details wdd, hz_locations hl, HZ_CUST_ACCOUNTS hca ,HZ_PARTIES hp
                    WHERE wdd.ship_to_location_id = hl.location_id
                    AND wdd.CUSTOMER_ID = hca.CUST_ACCOUNT_ID
                    AND hca.PARTY_ID = hp.PARTY_ID
                    AND wdd.batch_id = '$noDPB') -- parameter
                ELSE 
                    null
                END
        ELSE 
            null
        END alamat_so,     
        (SELECT mtrh.attribute4
                FROM mtl_txn_request_headers mtrh
                WHERE mtrh.request_number = '$noDPB')  alamat_kirim,
            h1.description,
            h1.tgl_kirim,
            h1.so,
            h1.ekspedisi,
            h1.opk
        FROM 
        (
            select mtrh.description, mtrh.attribute15 ekspedisi,
                    mtrh.attribute6 tgl_kirim, mtrh.attribute7 so,
                    mtrh.attribute8 opk, mtrh.request_number
            from mtl_txn_request_headers mtrh
            where request_number = '$noDPB'
        ) h1");

        return $query->result_array();
    }

    public function reSubmitDPB($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->query("UPDATE khs_tampung_spb kts SET kts.APPROVAL_FLAG = null where kts.NO_DOKUMEN = '$noDPB'");
    }
    public function updateEkspedisi($req, $eks)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->query("update
        mtl_txn_request_headers mtrh
        set
        mtrh.ATTRIBUTE15 = '$eks' -- ekspedisi
        where
        mtrh.REQUEST_NUMBER = '$req' -- no_do/spb");
    }
}
