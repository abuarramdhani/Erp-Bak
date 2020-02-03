<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_daftar extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
    }

    public function selectUserInformation($id)
    {
        return $this->personalia
            ->select('tpribadi.noind, tpribadi.nama, tpribadi.npwp, tseksi.seksi, tnoind.fs_ket')            
            ->where('tpribadi.noind', $id)
            ->from('hrd_khs.tpribadi')
            ->join('hrd_khs.tseksi', 'tseksi.kodesie = tpribadi.kodesie')
            ->join('hrd_khs.tnoind', 'tnoind.fs_noind = tpribadi.kode_status_kerja')
            ->get()
            ->result_array();
    }

    public function selectRegisteredUser($id)
    {
        return $this->db
            ->select('nomor_pendaftaran')
            ->where('nomor_induk', $id)
            ->get('ap.ap_spt')
            ->result_array();
    }

    public function insertRegisteredUser($data)
    {
        $this->db->insert('ap.ap_spt', $data);

        $last_id       = $this->db->insert_id();
        $unique_number = sprintf('%03d', $last_id);
        $data['lokasi_kerja'] === 'PUSAT' ?
            $registered_number = "PST-$unique_number" :
            $registered_number = "TKS-$unique_number";

        $this->db
            ->set('nomor_pendaftaran', $registered_number)
            ->where('id', $last_id)
            ->update('ap.ap_spt');

        return [
            'status'            => 'Success',
            'registered_number' => $registered_number
        ];
    }

}