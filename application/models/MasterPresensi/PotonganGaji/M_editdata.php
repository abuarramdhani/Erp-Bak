<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_editdata extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', TRUE);
    }

    function searchPekerja($term) {
        return $this->personalia->select('upper(trim(noind)) as noind, upper(trim(nama)) as nama')->where('keluar', false)->like('lower(noind)', $term, 'after')->order_by('noind')->get('hrd_khs.tpribadi')->result_array();
    }

    function searchJenisPotongan($term) {
        return $this->personalia->like('lower(jenis_potongan)', $term, 'after')->order_by('jenis_potongan_id')->get('Presensi.tjenis_potongan')->result_array();
    }

    function getPekerjaList() {
        return $this->personalia->select('upper(trim(noind)) as noind, upper(trim(nama)) as nama')->where('keluar', false)->order_by('noind')->get('hrd_khs.tpribadi')->result_array();
    }

    function getJenisPotonganList() {
        return $this->personalia->order_by('jenis_potongan_id')->get('Presensi.tjenis_potongan')->result_array();
    }

    public function getPotongan($id) {
        return $this
                ->personalia
                ->select('Presensi.tpotongan.*, upper(trim(hrd_khs.tpribadi.nama)) as nama, Presensi.tjenis_potongan.*')
                ->join('hrd_khs.tpribadi', 'hrd_khs.tpribadi.noind = Presensi.tpotongan.noind', 'left')
                ->join('Presensi.tjenis_potongan', 'Presensi.tjenis_potongan.jenis_potongan_id = Presensi.tpotongan.jenis_potongan_id', 'left')
                ->where('potongan_id', $id)
                ->get('Presensi.tpotongan')
                ->row();
    }

    public function getPotonganDetail($id) {
        return $this
                ->personalia
                ->join('Presensi.tstatus_potongan', 'Presensi.tstatus_potongan.status_potongan_id = Presensi.tpotongan_detail.status', 'left')
                ->where('potongan_id', $id)
                ->order_by('periode_potongan')
                ->get('Presensi.tpotongan_detail')
                ->result_array();
    }

    public function updateData($potonganId, $dataPotongan, $dataPotonganDetail) {
        $updatePotonganResponse = $this->personalia->where('potongan_id', $potonganId)->update('Presensi.tpotongan', $dataPotongan);
        $updatePotonganDetailResponse = $this->personalia->where('potongan_id', $potonganId)->delete('Presensi.tpotongan_detail');
        foreach($dataPotonganDetail as $row) { if(!$this->personalia->insert('Presensi.tpotongan_detail', $row)) { $updatePotonganDetailResponse = false; break; } }
        return $updatePotonganResponse == $updatePotonganDetailResponse;
    }
}