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
        msib.segment1
        ,msib.DESCRIPTION
        ,tbl1.req_qty
        ,(NVL(SUM(moqd.transaction_quantity),0) -    (
            SELECT
            NVL(SUM(mr.RESERVATION_QUANTITY),0)                                          
            FROM
            MTL_RESERVATIONS MR
            ,mtl_system_items_b msib2
            WHERE 
            MR.inventory_item_id = msib2.INVENTORY_ITEM_ID
            and MR.organization_id = msib2.organization_id
            and msib2.segment1 = msib.segment1
            and mr.subinventory_code = moqd.subinventory_code
            )
            -
            (
            select
            NVL(SUM(mmtt.transaction_quantity),0)
            from
            MTL_MATERIAL_TRANSACTIONS_TEMP mmtt
            ,mtl_system_items_b msib3
            where
            msib3.inventory_item_id = mmtt.inventory_item_id
            and msib3.organization_id = mmtt.organization_id
            and msib3.segment1 = msib.segment1
            and mmtt.subinventory_code = moqd.subinventory_code    
            )
        ) QTY_ATR
        ,(NVL(SUM(moqd.transaction_quantity),0) -    (
            SELECT
            NVL(SUM(mr.RESERVATION_QUANTITY),0)                                          
            FROM
            MTL_RESERVATIONS MR
            ,mtl_system_items_b msib2
            WHERE 
            MR.inventory_item_id = msib2.INVENTORY_ITEM_ID
            and MR.organization_id = msib2.organization_id
            and msib2.segment1 = msib.segment1
            and mr.subinventory_code = moqd.subinventory_code
            )
            -
            (
            select
            NVL(SUM(mmtt.transaction_quantity),0)
            from
            MTL_MATERIAL_TRANSACTIONS_TEMP mmtt
            ,mtl_system_items_b msib3
            where
            msib3.inventory_item_id = mmtt.inventory_item_id
            and msib3.organization_id = mmtt.organization_id
            and msib3.segment1 = msib.segment1
            and mmtt.subinventory_code = moqd.subinventory_code    
            )
        )
        - tbl1.req_qty ATR_sisa
        from
        mtl_onhand_quantities_detail moqd
        ,mtl_system_items_b msib
        ,(select 
        mtrl.INVENTORY_ITEM_ID
        ,sum(mtrl.QUANTITY) req_qty
        from
        mtl_txn_request_headers mtrh
        ,mtl_txn_request_lines mtrl
        where
        mtrh.HEADER_ID = mtrl.HEADER_ID
        and mtrh.ORGANIZATION_ID = 225
        and mtrh.REQUEST_NUMBER = '$noDPB' -- parameter
        group by mtrl.INVENTORY_ITEM_ID) tbl1
        where
        msib.inventory_item_id = moqd.inventory_item_id
        and msib.organization_id = moqd.organization_id
        and msib.INVENTORY_ITEM_ID = tbl1.INVENTORY_ITEM_ID
        and moqd.subinventory_code = 'SP-YSP'
        group by
        moqd.subinventory_code
        ,msib.segment1
        ,tbl1.req_qty
        ,msib.DESCRIPTION");

        return $query->result_array();
    }

    public function cekStok($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT APPS.KHS_CEK_ATR_DOSPB2('$noDPB', 225, 'SP-YSP') hasil from dual");

        return $query->result_array();
    }

    public function createDPB($noDPB, $jenis, $creator, $forward, $keterangan)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("CALL APPS.KHS_ALLOCATE_DOSPB_SP('$noDPB', 225, 'SP-YSP', '$jenis', '$creator', '$forward','$keterangan')");
    }


    public function getAlamat($noDPB)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        case when REGEXP_LIKE('$noDPB', '^[[:digit:]]+$') then
            case when (select distinct wdd.BATCH_ID from wsh_delivery_details wdd where wdd.BATCH_ID= '$noDPB') is not null then -- parameter
                (select distinct
                hl.address1 || ', ' || hl.city || ', ' || hl.province city
                from
                wsh_delivery_details wdd
                ,hz_locations hl
                where
                wdd.SHIP_TO_LOCATION_ID = hl.LOCATION_ID
                and wdd.BATCH_ID = '$noDPB')  -- parameter
            else
                (select
                mtrh.ATTRIBUTE4
                from
                mtl_txn_request_headers mtrh
                where
                mtrh.REQUEST_NUMBER = '$noDPB')  -- parameter
            end    
        else        
        (select
                mtrh.ATTRIBUTE4
                from
                mtl_txn_request_headers mtrh
                where
                mtrh.REQUEST_NUMBER = '$noDPB')  -- parameter
        end ALAMAT    
        from DUAL");

        return $query->result_array();
    }
}
