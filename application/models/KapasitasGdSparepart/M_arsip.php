<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_arsip extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataSPB() {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct
                to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as mulai_pelayanan, 
                to_char(selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as selesai_pelayanan,waktu_pelayanan,
                to_char(mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as mulai_pengeluaran, 
                to_char(selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as selesai_pengeluaran, waktu_pengeluaran,
                to_char(mulai_packing, 'DD/MM/YYYY HH24:MI:SS') as mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY HH24:MI:SS') as selesai_packing, waktu_packing,
                urgent, pic_pelayan, pic_pengeluaran, pic_packing, bon, cancel
                from khs_tampung_spb
                where selesai_packing is not null 
                or (bon = 'BON' AND selesai_pelayanan is not null)
                or (bon = 'LANGSUNG' AND selesai_pengeluaran is not null)
                or cancel is not null
                order by urgent, tgl_dibuat asc";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    
    public function getDataSPB2($sch) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct
                to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as mulai_pelayanan, 
                to_char(selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as selesai_pelayanan,waktu_pelayanan,
                to_char(mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as mulai_pengeluaran, 
                to_char(selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as selesai_pengeluaran, waktu_pengeluaran,
                to_char(mulai_packing, 'DD/MM/YYYY HH24:MI:SS') as mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY HH24:MI:SS') as selesai_packing, waktu_packing,
                urgent, pic_pelayan, pic_pengeluaran, pic_packing, bon, cancel
                from khs_tampung_spb
                where jenis_dokumen like '%$sch%'
                or no_dokumen like '%$sch%'
                or pic_pelayan like '%$sch%'
                or pic_pengeluaran like '%$sch%'
                or pic_packing like '%$sch%'
                order by urgent, tgl_dibuat asc";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    
    public function getDataSPB3($tgl1, $tgl2) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct
                to_char(jam_input, 'DD/MM/YYYY HH24:MI:SS') as jam_input, 
                tgl_dibuat,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                to_char(mulai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as mulai_pelayanan, 
                to_char(selesai_pelayanan, 'DD/MM/YYYY HH24:MI:SS') as selesai_pelayanan,waktu_pelayanan,
                to_char(mulai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as mulai_pengeluaran, 
                to_char(selesai_pengeluaran, 'DD/MM/YYYY HH24:MI:SS') as selesai_pengeluaran, waktu_pengeluaran,
                to_char(mulai_packing, 'DD/MM/YYYY HH24:MI:SS') as mulai_packing, 
                to_char(selesai_packing, 'DD/MM/YYYY HH24:MI:SS') as selesai_packing, waktu_packing,
                urgent, pic_pelayan, pic_pengeluaran, pic_packing, bon, cancel
                from khs_tampung_spb
                where trunc (selesai_packing) BETWEEN TO_DATE('$tgl1', 'DD/MM/YYYY') AND TO_DATE('$tgl2', 'DD/MM/YYYY')
                order by selesai_packing asc";
        // echo "<pre>";print_r($sql);exit();
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataSPB($noSPB) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT 'SPB' jenis_dokumen, mtrh.request_number no_dokumen,
                        msib.segment1 item, msib.description item_desc, mtrl.quantity,
                        to_char(mtrh.creation_date, 'DD/MM/YYYY HH24:MI:SS') mtrl
                FROM mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl,
                        mtl_system_items_b msib
                --                hr_organization_units_v hou
                WHERE mtrh.header_id = mtrl.header_id
                    AND mtrh.organization_id = mtrl.organization_id
                    AND msib.inventory_item_id = mtrl.inventory_item_id
                --            AND hou.organization_id = mtrh.attribute1
                    AND msib.organization_id = 81
                    AND NOT EXISTS (
                    SELECT mtrh1.request_number
                        FROM mtl_txn_request_headers mtrh1, wsh_delivery_details wdd1
                    WHERE mtrh1.request_number = TO_CHAR (wdd1.batch_id)
                        AND mtrh1.request_number = mtrh.request_number)
                    AND mtrh.request_number = '$noSPB'
                UNION ALL
                SELECT DISTINCT 'DOSP' jenis_dokumen, mtrh.request_number no_dokumen,
                                msib.segment1 item, msib.description item_desc, mtrl.quantity,
                                to_char(mtrh.creation_date, 'DD/MM/YYYY HH24:MI:SS') mtrl
                            FROM mtl_txn_request_headers mtrh,
                                mtl_txn_request_lines mtrl,
                                wsh_delivery_details wdd,
                                mtl_system_items_b msib
                        WHERE mtrh.request_number = TO_CHAR (wdd.batch_id)
                            AND mtrh.header_id = mtrl.header_id
                            AND mtrh.organization_id = mtrl.organization_id
                            AND msib.inventory_item_id = mtrl.inventory_item_id
                            AND msib.organization_id = 81
                            AND mtrh.request_number = '$noSPB'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    
    public function cekColy($noSPB) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT kcds.request_number, kcds.colly_number, kcds.berat
                FROM khs_colly_dospb_sp kcds
                WHERE kcds.request_number = '$noSPB'
                ORDER BY TO_NUMBER (SUBSTR (kcds.colly_number, 10))";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function saveColly2($nospb, $nocolly, $berat){
        $oracle = $this->load->database('oracle', true);
        $sql = "update khs_colly_dospb_sp kcds
                set kcds.berat = '$berat'
                WHERE kcds.request_number = '$nospb'
                and kcds.colly_number = '$nocolly'";
        $query = $oracle->query($sql);
    }
    

}

