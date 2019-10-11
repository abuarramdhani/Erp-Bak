<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_detaildata extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', TRUE);
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
}