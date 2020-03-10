<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_penyerahan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getNomorSPB($tgl) {
        $mysqli = $this->load->database('quick', true);
        $sql ="select distinct no_SPB from quickc01_trackingpengirimanbarang.tpb 
                where quickc01_trackingpengirimanbarang.tpb.status = 'onProcess' 
                and quickc01_trackingpengirimanbarang.tpb.start_date like '$tgl%'";
        $query = $mysqli->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getDataSPB($nomor){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct mtrh.REQUEST_NUMBER
                    ,mtrh.ATTRIBUTE15
                    ,ood.ORGANIZATION_CODE org
                    ,ood.ORGANIZATION_NAME tujuan
                    ,sum(mtrl.QUANTITY_DELIVERED) over (partition by mtrh.REQUEST_NUMBER) qty_transact
                from mtl_txn_request_headers mtrh
                    ,mtl_txn_request_lines mtrl
                    ,org_organization_definitions ood
                where mtrh.HEADER_ID = mtrl.HEADER_ID
                and substr(mtrl.REFERENCE,5) = ood.ORGANIZATION_ID
                and mtrh.REQUEST_NUMBER = '$nomor'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function cariberat($nomor){
        $oracle = $this->load->database('khs_packing', true);
        $sql = "select spt.berat BERAT, spt.nomor_do colly from sp_packing_trx spt where nomor_do = '$nomor'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

}

