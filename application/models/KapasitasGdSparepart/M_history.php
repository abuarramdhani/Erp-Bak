<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_history extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataSPB($query) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct tgl_dibuat, jam_input as jam,
                to_char(jam_input, 'DD/MM/YYYY') as jam_input,
                to_char(jam_input, 'DDMMYYYY') as tgl_input,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                waktu_pelayanan, waktu_pengeluaran, waktu_packing
                from khs_tampung_spb
                where cancel is null
                $query
                order by jam desc";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getDataMasuk() {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct jam_input, tgl_dibuat, selesai_packing as tanggal,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as mulai_pelayanan, 
                to_char(selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as selesai_pelayanan,waktu_pelayanan,
                to_char(mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as mulai_pengeluaran, 
                to_char(selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as selesai_pengeluaran, waktu_pengeluaran,
                to_char(mulai_packing, 'DD/MM/YYYY HH24:MI:SS') as mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY HH24:MI:SS') as selesai_packing, waktu_packing,
                urgent, pic_pelayan, pic_pengeluaran, pic_packing, bon, cancel
                from khs_tampung_spb
                where cancel is null
                order by jam_input asc";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    

}

