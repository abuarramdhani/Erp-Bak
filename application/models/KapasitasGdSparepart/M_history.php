<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_history extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDataSPB($query) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct no_dokumen, tgl_dibuat, jam_input as jam,
                to_char(jam_input, 'DD/MM/YYYY') as jam_input,
                to_char(jam_input, 'YYYYMMDD') as tgl_input,
                selesai_pelayanan, selesai_pengeluaran, selesai_packing,
                to_char(selesai_pelayanan, 'DD/MM/YYYY') as selesai_pelayanan2,
                to_char(selesai_pengeluaran, 'DD/MM/YYYY') as selesai_pengeluaran2,
                to_char(selesai_packing, 'DD/MM/YYYY') as selesai_packing2,
                to_char(selesai_pelayanan, 'YYYYMMDD') as tgl_pelayanan,
                to_char(selesai_pengeluaran, 'YYYYMMDD') as tgl_pengeluaran,
                to_char(selesai_packing, 'YYYYMMDD') as tgl_packing,
                jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                waktu_pelayanan, waktu_pengeluaran, waktu_packing,
                pic_pelayan, pic_pengeluaran, pic_packing
                from khs_tampung_spb
                where cancel is null
                $query
                order by jam desc";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPlyn($date1) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jumlah_item, 
                        SUM (mtrl.quantity_detailed) jumlah_pcs,
                        TO_CHAR (kts.mulai_pelayanan, 'DD/MM/YYYY') tgl_mulai,
                        TO_CHAR (kts.mulai_pelayanan, 'HH24:MI:SS') jam_mulai,
                        TO_CHAR (kts.selesai_pelayanan, 'DD/MM/YYYY') tgl_selesai,
                        TO_CHAR (kts.selesai_pelayanan, 'HH24:MI:SS') jam_selesai,
                        kts.waktu_pelayanan, kts.pic_pelayan, kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.line_status <> 6
                    AND kts.mulai_pelayanan IS NOT NULL
                    AND kts.selesai_pelayanan IS NOT NULL
                    AND TRUNC(kts.selesai_pelayanan) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date1','DD/MM/YYYY')
                GROUP BY kts.tgl_dibuat,
                        kts.jenis_dokumen,
                        kts.no_dokumen,
                        TO_CHAR (kts.mulai_pelayanan, 'DD/MM/YYYY'),
                        TO_CHAR (kts.mulai_pelayanan, 'HH24:MI:SS'),
                        TO_CHAR (kts.selesai_pelayanan, 'DD/MM/YYYY'),
                        TO_CHAR (kts.selesai_pelayanan, 'HH24:MI:SS'),
                        kts.waktu_pelayanan,
                        kts.pic_pelayan,
                        kts.urgent,
                        kts.bon,
                        kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPglr($date1) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jumlah_item, 
                        SUM (mtrl.quantity_detailed) jumlah_pcs,
                        TO_CHAR (kts.mulai_pengeluaran, 'DD/MM/YYYY') tgl_mulai,
                        TO_CHAR (kts.mulai_pengeluaran, 'HH24:MI:SS') jam_mulai,
                        TO_CHAR (kts.selesai_pengeluaran, 'DD/MM/YYYY') tgl_selesai,
                        TO_CHAR (kts.selesai_pengeluaran, 'HH24:MI:SS') jam_selesai,
                        kts.waktu_pengeluaran, kts.pic_pengeluaran, kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    AND mtrl.line_status <> 6
                    AND kts.mulai_pengeluaran IS NOT NULL
                    AND kts.selesai_pengeluaran IS NOT NULL
                    AND (kts.bon IS NULL OR kts.bon != 'BON')
                    AND TRUNC(kts.selesai_pengeluaran) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date1','DD/MM/YYYY')
                GROUP BY kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        TO_CHAR (kts.mulai_pengeluaran, 'DD/MM/YYYY'),
                        TO_CHAR (kts.mulai_pengeluaran, 'HH24:MI:SS'),
                        TO_CHAR (kts.selesai_pengeluaran, 'DD/MM/YYYY'),
                        TO_CHAR (kts.selesai_pengeluaran, 'HH24:MI:SS'), 
                        kts.waktu_pengeluaran, kts.pic_pengeluaran, kts.urgent, kts.bon, kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function dataPck($date1) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT  kts.jam_input, kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        COUNT (mtrl.inventory_item_id) jumlah_item, 
                        SUM (mtrl.quantity_detailed) jumlah_pcs,
                        TO_CHAR (kts.mulai_packing, 'DD/MM/YYYY') tgl_mulai,
                        TO_CHAR (kts.mulai_packing, 'HH24:MI:SS') jam_mulai,
                        TO_CHAR (kts.selesai_packing, 'DD/MM/YYYY') tgl_selesai,
                        TO_CHAR (kts.selesai_packing, 'HH24:MI:SS') jam_selesai,
                        kts.waktu_packing, kts.pic_packing, kts.urgent keterangan, kts.bon
                FROM khs_tampung_spb kts,
                        mtl_txn_request_headers mtrh,
                        mtl_txn_request_lines mtrl
                WHERE kts.CANCEL IS NULL
                    AND kts.no_dokumen = mtrh.request_number
                    AND mtrh.header_id = mtrl.header_id
                    --AND mtrl.quantity_delivered is not null
                --     AND kts.mulai_packing IS NOT NULL
                    AND kts.selesai_packing IS NOT NULL
                    AND (kts.bon IS NULL OR kts.bon = 'BEST')
                    AND TRUNC(kts.selesai_packing) BETWEEN to_date('$date1','DD/MM/YYYY') AND to_date('$date1','DD/MM/YYYY')
                GROUP BY kts.tgl_dibuat, kts.jenis_dokumen, kts.no_dokumen,
                        TO_CHAR (kts.mulai_packing, 'DD/MM/YYYY'),
                        TO_CHAR (kts.mulai_packing, 'HH24:MI:SS'),
                        TO_CHAR (kts.selesai_packing, 'DD/MM/YYYY'),
                        TO_CHAR (kts.selesai_packing, 'HH24:MI:SS'), kts.waktu_packing,
                        kts.pic_packing, kts.urgent, kts.bon, kts.jam_input
                ORDER BY kts.urgent, kts.tgl_dibuat, kts.no_dokumen";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function cekPacking(){
        $oracle = $this->load->database('khs_packing', true);
        // $sql = "select * from sp_packing_trx";
        $sql = "SELECT nomor_do, count(nomor_do) jumlah
        FROM sp_packing_trx
        group by nomor_do";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getItemDOSPB() {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT bb.jam_input, bb.no_dokumen, bb.jenis_dokumen, bb.jumlah_item, bb.jumlah_pcs, bb.waktu_pelayanan, bb.waktu_pengeluaran, 
                        bb.waktu_packing,
                        (CASE
                            WHEN cek > 1
                            THEN 'SAP'
                            ELSE bb.jenis_item
                        END) FINAL
                FROM (SELECT aa.*,
                                COUNT (aa.jenis_item) OVER (PARTITION BY aa.no_dokumen) cek
                        FROM (SELECT DISTINCT kts.*,
                                                (CASE
                                                    WHEN msib.segment1 LIKE 'IAO%'
                                                    OR msib.segment1 LIKE 'IAP%'
                                                        THEN 'VBELT'
                                                    WHEN msib.segment1 LIKE 'IAA%'
                                                    OR msib.segment1 LIKE 'IAB%'
                                                        THEN 'DIESEL'
                                                    ELSE 'SAP'
                                                END
                                                ) jenis_item
                                            FROM khs_tampung_spb kts,
                                                mtl_txn_request_headers mtrh,
                                                mtl_txn_request_lines mtrl,
                                                mtl_system_items_b msib
                                        WHERE kts.no_dokumen = mtrh.request_number
                                            AND mtrh.header_id = mtrl.header_id
                                            AND msib.inventory_item_id = mtrl.inventory_item_id
                                            AND msib.organization_id = mtrl.organization_id
                --                                     AND kts.no_dokumen IN (3491432, 3491929, 3752313,3853066) --VBELT, CAMPURAN, DIESEL, SAP
                                                            ) aa) bb
                ORDER BY 1";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function getPIC(){
        $oracle = $this->load->database('oracle', true);
        $sql = "select * from khs_tabel_user order by pic";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    

}

