<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function tampilsemua() {
        $oracle = $this->load->database('oracle', true);
        $sql ="
                SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                        UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                        STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN 
                from KHS_MONITORING_GD_SP
                order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    
    public function getSearch($no_document, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $item) {
        $oracle = $this->load->database('oracle', true);
        $no_document == null? $nodoku = '' : $nodoku = "and no_document = '$no_document'";
        $pic == null ? $pic2 = '' : $pic2 = "and pic = '$pic'";
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
                        STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN 
                from KHS_MONITORING_GD_SP
                WHERE CREATION_DATE IS NOT NULL
                $dokudoku $nodoku $tanggal $pic2 $item2
                order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
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

    public function getBodyTanggal($no_document, $tglAwal, $tglAkhir) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN 
        from KHS_MONITORING_GD_SP
        WHERE no_document = '$no_document'
        AND creation_date BETWEEN TO_DATE( '$tglAwal', 'DD/MM/YYYY' ) AND TO_DATE( '$tglAkhir', 'DD/MM/YYYY' )
        order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getBodyPIC($no_document, $pic) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN 
        from KHS_MONITORING_GD_SP
        WHERE no_document = '$no_document'
        AND pic = '$pic'
        order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataUpdate($item, $jml_ok, $jml_not_ok, $keterangan)
    {
        $oracle = $this->load->database('oracle', true);
        $sql="UPDATE KHS_MONITORING_GD_SP set JML_OK = '$jml_ok', JML_NOT_OK = '$jml_not_ok', KETERANGAN ='$keterangan' where ITEM ='$item'";
        $query = $oracle->query($sql);
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
        $sql = "select distinct * from khs_kib kk 
        where kk.INVENTORY_TRANS_FLAG = 'Y'
        AND kk.KIBCODE = '$no_document'";
          $query = $oracle->query($sql);
          return $query->result_array();
          
    }

    public function tampilbody($no_document) {
        $oracle = $this->load->database('oracle', true);
        $sql ="
                SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                        UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                        STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN 
                from KHS_MONITORING_GD_SP
                where NO_DOCUMENT = '$no_document'
                order by CREATION_DATE DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    

}

