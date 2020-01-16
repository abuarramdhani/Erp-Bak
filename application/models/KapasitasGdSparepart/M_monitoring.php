<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataSPB($query) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat, 
                to_char(jam_input, 'DD/MM/YYYY') as tgl_input, 
                to_char(jam_input, 'HH24:MI:SS') as jam_input2,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as mulai_pelayanan, 
                to_char(mulai_pelayanan, 'DD/MM/YYYY') as tgl_mulai_pelayanan, 
                to_char(mulai_pelayanan, 'HH24:MI:SS') as jam_mulai_pelayanan, 
                to_char(selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as selesai_pelayanan,waktu_pelayanan,
                to_char(selesai_pelayanan, 'DD/MM/YYYY') as tgl_selesai_pelayanan,
                to_char(selesai_pelayanan, 'HH24:MI:SS') as jam_selesai_pelayanan,
                to_char(mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as mulai_pengeluaran, 
                to_char(mulai_pengeluaran, 'DD/MM/YYYY') as tgl_mulai_pengeluaran, 
                to_char(mulai_pengeluaran, 'HH24:MI:SS') as jam_mulai_pengeluaran, 
                to_char(selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as selesai_pengeluaran, waktu_pengeluaran,
                to_char(selesai_pengeluaran, 'DD/MM/YYYY') as tgl_selesai_pengeluaran, 
                to_char(selesai_pengeluaran, 'HH24:MI:SS') as jam_selesai_pengeluaran, 
                to_char(mulai_packing, 'DD/MM/YYYY HH24:MI:SS') as mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY HH24:MI:SS') as selesai_packing, waktu_packing,
                to_char(mulai_packing, 'DD/MM/YYYY') as tgl_mulai_packing, 
                to_char(mulai_packing, 'HH24:MI:SS') as jam_mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY') as tgl_selesai_packing,
                to_char(selesai_packing, 'HH24:MI:SS') as jam_selesai_packing,
                urgent, pic_pelayan, pic_pengeluaran, pic_packing
                from khs_tampung_spb
                $query
                and cancel is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataKurang($querykrg){
        $oracle = $this->load->database('oracle', true);
        $sql="select to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat, 
                to_char(jam_input, 'DD/MM/YYYY') as tgl_input, 
                to_char(jam_input, 'HH24:MI:SS') as jam_input2,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs, selesai_pengeluaran,
                selesai_pelayanan, selesai_packing, urgent, pic_pelayan, pic_pengeluaran, pic_packing
                from khs_tampung_spb
                $querykrg
                and cancel is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getjmlGd($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT distinct no_document FROM KHS_MONITORING_GD_SP WHERE TO_CHAR(CREATION_DATE,'DD/MM/YYYY') between '$date' and '$date'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getjmlGd2($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT distinct no_document 
                FROM KHS_MONITORING_GD_SP
                where TO_CHAR(CREATION_DATE,'DD/MM/YYYY') between '$date' and '$date'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getcancel($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT * 
                FROM khs_tampung_spb
                where TO_CHAR(cancel,'DD/MM/YYYY') between '$date' and '$date'
                and cancel is not null";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getcancel2($date) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT * 
                FROM khs_tampung_spb
                where TO_CHAR(cancel,'DD/MM/YYYY') between '$date' and '$date'
                and cancel is not null";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getTransact($nospb) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT mtrh.request_number no_spb, msib.segment1 item, msib.description, mmt.transaction_quantity, mmt.transaction_uom, mmt.SUBINVENTORY_CODE
                FROM mtl_txn_request_headers mtrh,
                    mtl_txn_request_lines mtrl,
                    mtl_system_items_b msib,
                    mtl_material_transactions mmt
                WHERE mtrh.request_number = '$nospb'
                    AND mtrl.header_id = mtrh.header_id
                    AND mtrl.inventory_item_id = msib.inventory_item_id
                    AND mtrl.organization_id = msib.organization_id
                    AND mmt.move_order_line_id = mtrl.line_id
                    AND mmt.inventory_item_id = mtrl.inventory_item_id
                    AND mmt.SUBINVENTORY_CODE like 'KLR%'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

}

