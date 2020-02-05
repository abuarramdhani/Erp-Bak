<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jadwal extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function selectAllUserSchedule()
    {
        return $this->db
            ->select('row_number() OVER () AS no, status_pekerja, nama, seksi, lokasi_kerja, nomor_pendaftaran, jadwal, lokasi')
            ->from('ap.ap_spt')
            ->get()
            ->result_array();
    }

}