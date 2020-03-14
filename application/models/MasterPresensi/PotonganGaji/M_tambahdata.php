<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tambahdata extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', TRUE);
    }

    function searchPekerja($term) {
        return $this->personalia->select('upper(trim(noind)) as noind, upper(trim(nama)) as nama')->where("(keluar = '0' or (keluar = '1' and tglkeluar >= current_date - interval '2 month')) and (lower(noind) like lower('".$term."%') or lower(trim(nama)) like lower('%".$term."%'))")->order_by('noind')->get('hrd_khs.tpribadi')->result_array();
    }

    function searchJenisPotongan($term) {
        return $this->personalia->like('lower(jenis_potongan)', $term, 'after')->order_by('jenis_potongan_id')->get('Presensi.tjenis_potongan')->result_array();
    }

    function getPekerjaList() {
        return $this->personalia->select('upper(trim(noind)) as noind, upper(trim(nama)) as nama')->where("keluar = '0' or (keluar = '1' and tglkeluar >= current_date - interval '2 month')")->order_by('noind')->get('hrd_khs.tpribadi')->result_array();
    }

    function getJenisPotonganList() {
        return $this->personalia->order_by('jenis_potongan_id')->get('Presensi.tjenis_potongan')->result_array();
    }

    function savePotongan($data) {
        return array(
            'success' => $this->personalia->insert('Presensi.tpotongan', $data),
            'potonganId' => $this->personalia->query("select currval('\"Presensi\".tpotongan_potongan_id_seq') as potongan_id")->row()->potongan_id
        );
    }

    function saveDetailPotongan($data) {
        $this->personalia->insert('Presensi.tpotongan_detail', $data);
    }
}