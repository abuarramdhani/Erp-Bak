<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    
    public function getSearch($no_document, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="
                SELECT NO_DOCUMENT, JENIS_DOKUMEN, ITEM, DESCRIPTION,
                        UOM, QTY, CREATION_DATE, to_char(CREATION_DATE, 'hh24:mi:ss') as JAM_INPUT,
                        STATUS, JML_OK, JML_NOT_OK, PIC, KETERANGAN 
                from KHS_MONITORING_GD_SP
                WHERE jenis_dokumen = '$jenis_dokumen'
                or NO_DOCUMENT = '$no_document'
                or creation_date BETWEEN TO_DATE( '$tglAwal', 'DD/MM/YYYY' ) AND TO_DATE( '$tglAkhir', 'DD/MM/YYYY' )
                or pic = '$pic'
                or ITEM = '$item'
                order by NO_DOCUMENT";
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
        $sql = "select *
        from mtl_material_transactions mmt
        where mmt.SHIPMENT_NUMBER = '$no_document'
          and mmt.TRANSACTION_TYPE_ID in (21,12)";
          $query = $oracle->query($sql);
          return $query->result_array();
          

    }

}

