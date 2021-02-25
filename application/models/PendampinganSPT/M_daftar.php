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
            ->select("EXTRACT(YEAR FROM AGE('2021/01/01'::DATE, tpribadi.tgllahir)) AS umur", false)
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
            ->where('extract(year from tanggal_daftar) = ', 2021)
            ->get('ap.ap_spt')
            ->result_array();
    }

    public function insertRegisteredUser($data)
    {
        $this->db->insert('ap.ap_spt', $data);
    }

    public function selectNextRegisterNumberSeq()
    {
        return $this->db
            ->query(
                "SELECT
                    NEXTVAL('ap.ap_spt_2021_register_number_seq') id"
            )
            ->row()
            ->id;
    }

}