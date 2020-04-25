<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tracking extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataSPB() {
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
                urgent, pic_pelayan, pic_pengeluaran, pic_packing, bon
                from khs_tampung_spb
                where selesai_packing is null
                and cancel is null
                order by urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function savePending($jenis, $nospb){
        $oracle = $this->load->database('oracle', true);
        $sql = "update khs_tampung_spb set BON = 'PENDING' where no_dokumen = '$nospb' and jenis_dokumen = '$jenis'";
        $query = $oracle->query($sql);
        $query2 = $oracle->query('commit');
    }

    public function deletePending($jenis, $nospb){
        $oracle = $this->load->database('oracle', true);
        $sql = "update khs_tampung_spb set BON = '' where no_dokumen = '$nospb' and jenis_dokumen = '$jenis'";
        $query = $oracle->query($sql);
        $query2 = $oracle->query('commit');
    }

    public function getEkspedisi($nospb){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT mtrh.request_number, mtrh.attribute15 ekspedisi,
                        CASE
                        WHEN mtrl.REFERENCE IS NULL
                            THEN (SELECT DISTINCT houv3.town_or_city
                                            FROM mtl_txn_request_lines mtrl1,
                                                    mtl_txn_request_headers mtrh1,
                                                    hr_organization_units_v houv3
                                            WHERE mtrh1.header_id = mtrl1.header_id
                                                AND mtrh1.request_number = mtrh.request_number
                                                AND houv3.organization_id = SUBSTR (TRIM (LTRIM (mtrl1.REFERENCE, '    ')), 6)
                                                AND mtrl1.REFERENCE IS NOT NULL)
                        ELSE houv2.town_or_city
                        END kota_kirim
                FROM mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        hr_organization_units_v houv2
                WHERE mtrh.header_id = mtrl.header_id
                    AND houv2.organization_id(+) = SUBSTR (TRIM (LTRIM (mtrl.REFERENCE, '    ')), 6)
                    AND mtrh.request_number = '$nospb'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

}

