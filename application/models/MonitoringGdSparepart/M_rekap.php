<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_rekap extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getdata() {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct to_date(creation_date, 'DD-MON-YYYY') creation_date 
                from khs_monitoring_gd_sp 
                where no_document != '-'
                order by creation_date desc";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getMasuk($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select *
                from khs_monitoring_gd_sp 
                where creation_date like to_date('$date','DD/MM/YYYY')
                and no_document != '-'
                order by no_document";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getpcs($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select sum(qty) pcs
                from khs_monitoring_gd_sp 
                where creation_date like to_date('$date','DD/MM/YYYY')
                and no_document != '-'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getitem($no) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select no_document, jenis_dokumen, item 
                from khs_monitoring_gd_sp 
                where no_document = '$no'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
        
    public function getKet($no_document){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct rt.*
                from rcv_shipment_headers rsh, rcv_shipment_lines rsl, mtl_material_transactions mmt, rcv_transactions rt
                where mmt.SHIPMENT_NUMBER = rsh.SHIPMENT_NUM
                and rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
                and rsh.RECEIPT_NUM is not null
                and rt.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
                and rt.SHIPMENT_LINE_ID = rsl.SHIPMENT_LINE_ID 
                and rt.ORGANIZATION_ID = 225
                ---- paramter IO dan KIB
                and mmt.SHIPMENT_NUMBER = '$no_document'
                and rt.TRANSACTION_TYPE = 'RECEIVE'
                and mmt.TRANSACTION_TYPE_ID in (21,12)";
          $query = $oracle->query($sql);
          return $query->result_array();     
    }
    
    public function getKetLPPB($no_document){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct rt.*
                from rcv_shipment_headers rsh, rcv_shipment_lines rsl, mtl_material_transactions mmt, rcv_transactions rt
                where mmt.SHIPMENT_NUMBER = rsh.SHIPMENT_NUM
                and rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
                and rsh.RECEIPT_NUM is not null
                and rt.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
                and rt.SHIPMENT_LINE_ID = rsl.SHIPMENT_LINE_ID 
                and rt.ORGANIZATION_ID = 225
                ---- parameter untuk LPPB
                and rsh.RECEIPT_NUM = '$no_document'
                and rt.TRANSACTION_TYPE = 'DELIVER'";
          $query = $oracle->query($sql);
          return $query->result_array();
          
    }

    public function getKetKIB($no_document){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct kk.*, wdj.QUANTITY_COMPLETED from 
        khs_kib kk,
        wip_discrete_jobs wdj         
        where kk.ORDER_ID = wdj.WIP_ENTITY_ID  
        and kk.PRIMARY_ITEM_ID = wdj.PRIMARY_ITEM_ID  
        and kk.INVENTORY_TRANS_FLAG = 'Y'     
        and kk.KIBCODE = '$no_document'";
          $query = $oracle->query($sql);
          return $query->result_array();
          
    }

    public function getKetMO($no_document){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT mtrh.request_number no_do_spb, msib.segment1 item, msib.description,
                        (mmt.transaction_quantity * -1) transaction_quantity,
                        mtrl.quantity_delivered, mtrl.from_subinventory_code,
                        mtrl.to_subinventory_code, mtrh.creation_date, mmt.transaction_date
                FROM mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib,
                        mtl_material_transactions mmt
                WHERE mtrh.request_number = '$no_document'
                    AND mtrl.header_id = mtrh.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                    AND mmt.move_order_line_id = mtrl.line_id
                    AND mmt.inventory_item_id = mtrl.inventory_item_id
                    AND mmt.transaction_quantity LIKE '-%'";
          $query = $oracle->query($sql);
          return $query->result_array();
    }

    public function gdAsalIO($no_document) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select mmt.SHIPMENT_NUMBER  no_interorg
                        ,msib.SEGMENT1       
                        ,mmt.SUBINVENTORY_CODE gudang_asal
                from mtl_material_transactions mmt
                    ,mtl_system_items_b msib
                    ,(select mmt2.TRANSACTION_QUANTITY qty_receipt
                            ,mmt2.ORGANIZATION_ID org
                            ,mmt2.SHIPMENT_NUMBER shipment_num
                            ,mmt2.INVENTORY_ITEM_ID item_id
                            ,mmt2.TRANSACTION_TYPE_ID type_id
                        from mtl_material_transactions mmt2
                    where mmt2.TRANSACTION_TYPE_ID = 12 -- Intransit Receipt
                        ) mmt2
                where msib.INVENTORY_ITEM_ID = mmt.INVENTORY_ITEM_ID
                and msib.ORGANIZATION_ID = mmt.ORGANIZATION_ID
                and mmt.SHIPMENT_NUMBER = '$no_document'
                and mmt.TRANSACTION_TYPE_ID = 21 -- Intransit Shipment
                --
                and mmt2.ORG(+) = mmt.TRANSFER_ORGANIZATION_ID
                and mmt2.SHIPMENT_NUM(+) = mmt.SHIPMENT_NUMBER
                and mmt2.ITEM_ID(+) = mmt.INVENTORY_ITEM_ID
                and mmt.ORGANIZATION_ID in (102,225) -- YSP";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function gdAsalKIB($no_document) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select kk.KIBCODE no_interorg
                        ,msib.SEGMENT1 item
                        ,mmt.SUBINVENTORY_CODE
                from khs_kib kk
                    ,mtl_system_items_b msib 
                    ,wip_discrete_jobs wdj
                    --
                    ,mtl_material_transactions mmt   
                where kk.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
                    and kk.ORGANIZATION_ID = msib.ORGANIZATION_ID
                    and kk.ORDER_ID = wdj.WIP_ENTITY_ID 
                    and kk.PRIMARY_ITEM_ID = wdj.PRIMARY_ITEM_ID 
                    --
                    and wdj.WIP_ENTITY_ID = mmt.TRANSACTION_SOURCE_ID
                    and wdj.PRIMARY_ITEM_ID = mmt.INVENTORY_ITEM_ID
                    and kk.KIBCODE = '$no_document'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getKetFPB($no_document){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT doc_number no_interorg, item_code item, description, quantity qty, uom, seksi_kirim, status
                FROM KHS_KIRIM_INTERNAL 
                WHERE DOC_NUMBER = '$no_document'";
          $query = $oracle->query($sql);
          return $query->result_array();
    }
    public function getDataSPBSPI($atr) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
                FROM KHS_SPBSPI ks
                WHERE ks.SPBSPI_NUM = '$atr'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function cariKIB($atr) {
        $oracle = $this->load->database('oracle', true);
        $sql = "
                select kk.KIBCODE no_interorg
                        ,msib.SEGMENT1 item
                        ,msib.DESCRIPTION
                        ,msib.PRIMARY_UOM_CODE uom
                        ,wdj.QUANTITY_COMPLETED qty
                        ,kk.QTY_KIB qbt
                        ,kk.VERIFY_DATE creation_date
                from khs_kib kk
                    ,mtl_system_items_b msib 
                    ,wip_discrete_jobs wdj   
                where kk.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
                    and kk.ORGANIZATION_ID = msib.ORGANIZATION_ID
                    and kk.ORDER_ID = wdj.WIP_ENTITY_ID 
                    and kk.PRIMARY_ITEM_ID = wdj.PRIMARY_ITEM_ID 
                    and kk.KIBCODE = '$atr'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

}

