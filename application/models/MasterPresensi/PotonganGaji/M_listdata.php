<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_listdata extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', TRUE);
    }

    public function getList() {
        $potonganList = $this
                    ->personalia
                    ->select('Presensi.tpotongan.*, upper(trim(hrd_khs.tpribadi.nama)) as nama, Presensi.tjenis_potongan.*')
                    ->join('hrd_khs.tpribadi', 'hrd_khs.tpribadi.noind = Presensi.tpotongan.noind', 'left')
                    ->join('Presensi.tjenis_potongan', 'Presensi.tjenis_potongan.jenis_potongan_id = Presensi.tpotongan.jenis_potongan_id', 'left')
                    ->order_by('potongan_id')
                    ->get('Presensi.tpotongan')
                    ->result_array();
        $count = 0;
        $result = array();
        foreach($potonganList as $potongan) {
            $potonganDetailList = $this
                        ->personalia
                        ->where('potongan_id', $potongan['potongan_id'])
                        ->order_by('potongan_id')
                        ->get('Presensi.tpotongan_detail')
                        ->result_array();
            if(empty($potonganDetailList)) { continue; }
            $sudahBayar = 0;
            $kurangBayar = 0;
            foreach($potonganDetailList as $potonganDetail) {
                if($potonganDetail['status'] == 1) { $kurangBayar += $potonganDetail['nominal_potongan']; }
                if($potonganDetail['status'] == 2) { $sudahBayar += $potonganDetail['nominal_potongan']; }
            }
            $potongan['sudah_bayar'] = $sudahBayar;
            $potongan['kurang_bayar'] = $kurangBayar;
            $potongan['awal_periode'] = date('M Y', strtotime($potonganDetailList[0]['periode_potongan']));
            $potongan['akhir_periode'] = date('M Y', strtotime($potonganDetailList[count($potonganDetailList) - 1]['periode_potongan']));
            $result[$count++] = $potongan;
        }
        return $result;
    }

    public function deleteData($id) {
        return array(
            'success' => empty($id) ? false : $this->personalia->where('potongan_id', $id)->delete('Presensi.tpotongan') == $this->personalia->where('potongan_id', $id)->delete('Presensi.tpotongan_detail')
        );
    }
}