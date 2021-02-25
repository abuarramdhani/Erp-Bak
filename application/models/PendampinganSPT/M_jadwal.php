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
            ->select('row_number() OVER () AS no, status_pekerja, nomor_induk, nama, seksi, lokasi_kerja, nomor_pendaftaran, jadwal, lokasi')
            ->from('ap.ap_spt')
            ->get()
            ->result_array();
    }

    public function updateTableColumn()
    {
        $this->db
            ->query(
                "ALTER TABLE ap.ap_spt ALTER COLUMN nomor_pendaftaran TYPE character(10)"
            );
    }

    public function selectRegisteredNumber($year)
    {
        return $this->db
            ->query(
                "SELECT
                    id,
                    nomor_pendaftaran
                FROM
                    ap.ap_spt
                WHERE
                    EXTRACT(YEAR FROM tanggal_daftar) = $year
                ORDER BY
                    id"
            )
            ->result();
    }

    public function createSeq2021RegisterNumber()
    {
        $this->db->query("CREATE SEQUENCE ap.ap_spt_2021_register_number_seq MINVALUE 1 NO MAXVALUE NO CYCLE");
    }

    public function update_batch($data)
    {
        $this->db->update_batch('ap.ap_spt', $data, 'id');
    }
}