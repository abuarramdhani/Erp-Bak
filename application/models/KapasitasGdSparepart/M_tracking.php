<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tracking extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataSPB() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT DISTINCT TO_CHAR (kts.jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                        kts.tgl_dibuat,
                        TO_CHAR (kts.jam_input, 'DD/MM/YYYY') AS tgl_input,
                        TO_CHAR (kts.jam_input, 'HH24:MI:SS') AS jam_input2,
                        jenis_dokumen, kts.no_dokumen, kts.jumlah_item,
                        kts.jumlah_pcs,
                        TO_CHAR (kts.mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') AS mulai_pelayanan,
                        TO_CHAR (kts.mulai_pelayanan, 'DD/MM/YYYY') AS tgl_mulai_pelayanan,
                        TO_CHAR (kts.mulai_pelayanan, 'HH24:MI:SS') AS jam_mulai_pelayanan,
                        TO_CHAR (kts.selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') AS selesai_pelayanan,
                        kts.waktu_pelayanan,
                        TO_CHAR (kts.selesai_pelayanan, 'DD/MM/YYYY') AS tgl_selesai_pelayanan,
                        TO_CHAR (kts.selesai_pelayanan, 'HH24:MI:SS') AS jam_selesai_pelayanan,
                        TO_CHAR (kts.mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') AS mulai_pengeluaran,
                        TO_CHAR (kts.mulai_pengeluaran, 'DD/MM/YYYY') AS tgl_mulai_pengeluaran,
                        TO_CHAR (kts.mulai_pengeluaran, 'HH24:MI:SS') AS jam_mulai_pengeluaran,
                        TO_CHAR (kts.selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') AS selesai_pengeluaran,
                        kts.waktu_pengeluaran,
                        TO_CHAR (kts.selesai_pengeluaran, 'DD/MM/YYYY') AS tgl_selesai_pengeluaran,
                        TO_CHAR (kts.selesai_pengeluaran, 'HH24:MI:SS') AS jam_selesai_pengeluaran,
                        TO_CHAR (kts.mulai_packing, 'DD/MM/YYYY HH24:MI:SS') AS mulai_packing,
                        TO_CHAR (kts.selesai_packing, 'DD/MM/YYYY HH24:MI:SS') AS selesai_packing,
                        waktu_packing,
                        TO_CHAR (kts.mulai_packing, 'DD/MM/YYYY') AS tgl_mulai_packing,
                        TO_CHAR (kts.mulai_packing, 'HH24:MI:SS') AS jam_mulai_packing,
                        TO_CHAR (kts.selesai_packing, 'DD/MM/YYYY') AS tgl_selesai_packing,
                        TO_CHAR (kts.selesai_packing, 'HH24:MI:SS') AS jam_selesai_packing,
                        kts.urgent, kts.pic_pelayan, kts.pic_pengeluaran,
                        kts.pic_packing, kts.bon, mtrh.attribute15 ekspedisi,
                        CASE
                        WHEN mtrl.REFERENCE IS NULL
                            THEN (SELECT DISTINCT houv3.town_or_city
                                            FROM mtl_txn_request_lines mtrl1,
                                                    mtl_txn_request_headers mtrh1,
                                                    hr_organization_units_v houv3
                                            WHERE mtrh1.header_id = mtrl1.header_id
                                                AND mtrh1.request_number = mtrh.request_number
                                                AND TO_CHAR (houv3.organization_id) = SUBSTR (TRIM (LTRIM (mtrl1.REFERENCE, ' ')), 6)
                                                AND mtrl1.REFERENCE IS NOT NULL)
                        ELSE NVL(houv2.town_or_city, houv2.location_code)
                        END kota_kirim
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        hr_organization_units_v houv2
                WHERE kts.selesai_packing IS NULL
                    AND CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                --     AND kts.no_dokumen IN (3717021, 4073844)
                    AND mtrh.header_id = mtrl.header_id
                    AND TO_CHAR (houv2.organization_id(+)) = SUBSTR (TRIM (LTRIM (mtrl.REFERENCE, ' ')), 6)
                ORDER BY kts.urgent, kts.tgl_dibuat";
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
                                                AND houv3.organization_id = SUBSTR (TRIM (LTRIM (mtrl1.REFERENCE, ' ')), 6)
                                                AND mtrl1.REFERENCE IS NOT NULL)
                        ELSE houv2.town_or_city
                        END kota_kirim
                FROM mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        hr_organization_units_v houv2
                WHERE mtrh.header_id = mtrl.header_id
                    AND TO_CHAR(houv2.organization_id(+)) = SUBSTR (TRIM (LTRIM (mtrl.REFERENCE, ' ')), 6)
                    AND mtrh.request_number = '$nospb'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

}

