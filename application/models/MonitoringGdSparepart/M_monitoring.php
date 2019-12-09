<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function tampilsemua($date, $date2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="
                SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION, 
                UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT, 
                STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN, ACTION 
                from KHS_MONITORING_GD_SP 
                where creation_date BETWEEN TO_DATE( '$date', 'DD/MM/YYYY' ) AND TO_DATE( '$date2', 'DD/MM/YYYY' ) 
                order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    
    public function getSearch($no_document, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $item) {
        $oracle = $this->load->database('oracle', true);
        $no_document == null? $nodoku = '' : $nodoku = "and no_document = '$no_document'";
        $pic == null ? $pic2 = '' : $pic2 = "and pic like '%$pic%'";
        $item == null ? $item2 = '' : $item2 = "and ITEM = '$item'";
        $jenis_dokumen == null ? $dokudoku = '' : $dokudoku= "and jenis_dokumen = '$jenis_dokumen'";
        if ($tglAkhir != null && $tglAwal != null) {
            $tanggal = "and creation_date BETWEEN TO_DATE( '$tglAwal', 'DD/MM/YYYY' ) AND TO_DATE( '$tglAkhir', 'DD/MM/YYYY' )";
        } else {
            $tanggal = '';
        }
        $sql ="
                SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                        UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                        STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN, ACTION
                from KHS_MONITORING_GD_SP
                WHERE CREATION_DATE IS NOT NULL
                $dokudoku $nodoku $tanggal $pic2 $item2
                order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getExport($jenis_dokumen, $tglAwal, $tglAkhir) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN 
        from KHS_MONITORING_GD_SP
        WHERE jenis_dokumen = '$jenis_dokumen'
        AND creation_date BETWEEN TO_DATE( '$tglAwal', 'DD/MM/YYYY' ) AND TO_DATE( '$tglAkhir', 'DD/MM/YYYY' )
        order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

        public function dataUpdate($item, $query, $doc)
    {
        $oracle = $this->load->database('oracle', true);
        $sql="UPDATE KHS_MONITORING_GD_SP $query WHERE ITEM = '$item' and NO_DOCUMENT = '$doc'";
        $query = $oracle->query($sql);
        $query2 = $oracle->query('commit');
			echo $sql;
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

    public function tampilbody($no_document) {
        $oracle = $this->load->database('oracle', true);
        $sql ="
                SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                        UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                        STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN, ACTION 
                from KHS_MONITORING_GD_SP
                where NO_DOCUMENT = '$no_document'
                order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
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

}

