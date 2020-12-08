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

    public function cekPacking($nospb){
        $oracle = $this->load->database('khs_packing', true);
        // $sql = "select * from sp_packing_trx";
        $sql = "select sum(pck.jumlah) total
                from
                (SELECT count(spt.nomor_do) jumlah
                        FROM sp_packing_trx spt
                WHERE spt.nomor_do in ($nospb)
                        group by spt.nomor_do) pck";
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
        $sql = "select * from khs_tabel_user 
                where pic not in ('ALIF', 'ARI', 'DINAR', 'EKO', 'RIZAL', 'SYAMSUL', 'WAHYU')
                order by pic";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdatamasuk(){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TRUNC (kts.jam_input) tgl_input,
                        SUM (kts.jumlah_item) sum_jumlah_item,
                        SUM (kts.jumlah_pcs) sum_jumlah_pcs,
                        COUNT (kts.no_dokumen) jumlah_lembar
                FROM khs_tampung_spb kts
                WHERE kts.cancel IS NULL
                GROUP BY TRUNC (kts.jam_input)
                ORDER BY TRUNC (kts.jam_input) desc";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdatapelayanan(){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TRUNC (kts.selesai_pelayanan) tgl_selesai_pelayanan,
                        SUM (    TRIM (SUBSTR (kts.waktu_pelayanan,
                                            1,
                                            INSTR (kts.waktu_pelayanan, ':') - 1
                                            )
                                    )
                            * 3600
                            +   TRIM (SUBSTR (kts.waktu_pelayanan,
                                            INSTR (kts.waktu_pelayanan, ':', 1, 1) + 1,
                                                INSTR (kts.waktu_pelayanan, ':', 1, 2)
                                            - INSTR (kts.waktu_pelayanan, ':', 1, 1)
                                            - 1
                                            )
                                    )
                            * 60
                            + TRIM (SUBSTR (kts.waktu_pelayanan,
                                            INSTR (kts.waktu_pelayanan, ':', 1, 2) + 1,
                                            LENGTH (kts.waktu_pelayanan)
                                            - INSTR (kts.waktu_pelayanan, ':', 1, 2)
                                            )
                                    )
                            ) detik,
                            SUM (kts.jumlah_item) sum_jumlah_item,
                            COUNT (kts.no_dokumen) jumlah_lembar
                FROM khs_tampung_spb kts
                WHERE kts.cancel IS NULL
                AND kts.SELESAI_PELAYANAN IS NOT NULL
                GROUP BY TRUNC (kts.selesai_pelayanan)
                ORDER BY TRUNC (kts.selesai_pelayanan) desc";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdatapengeluaran(){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TRUNC (kts.selesai_pengeluaran) tgl_selesai_pengeluaran,
                        SUM (    TRIM (SUBSTR (kts.waktu_pengeluaran,
                                            1,
                                            INSTR (kts.waktu_pengeluaran, ':') - 1
                                            )
                                    )
                            * 3600
                            +   TRIM (SUBSTR (kts.waktu_pengeluaran,
                                            INSTR (kts.waktu_pengeluaran, ':', 1, 1) + 1,
                                                INSTR (kts.waktu_pengeluaran, ':', 1, 2)
                                            - INSTR (kts.waktu_pengeluaran, ':', 1, 1)
                                            - 1
                                            )
                                    )
                            * 60
                            + TRIM (SUBSTR (kts.waktu_pengeluaran,
                                            INSTR (kts.waktu_pengeluaran, ':', 1, 2) + 1,
                                            LENGTH (kts.waktu_pengeluaran)
                                            - INSTR (kts.waktu_pengeluaran, ':', 1, 2)
                                            )
                                    )
                            ) detik,
                            SUM (kts.jumlah_item) sum_jumlah_item,
                            COUNT (kts.no_dokumen) jumlah_lembar
                FROM khs_tampung_spb kts
                WHERE kts.cancel IS NULL
                AND kts.selesai_pengeluaran IS NOT NULL
                GROUP BY TRUNC (kts.selesai_pengeluaran)
                ORDER BY TRUNC (kts.selesai_pengeluaran) desc";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdatapacking(){
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TRUNC (kts.selesai_packing) tgl_selesai_packing,
                        SUM (    TRIM (SUBSTR (kts.waktu_packing,
                                            1,
                                            INSTR (kts.waktu_packing, ':') - 1
                                            )
                                    )
                            * 3600
                            +   TRIM (SUBSTR (kts.waktu_packing,
                                            INSTR (kts.waktu_packing, ':', 1, 1) + 1,
                                                INSTR (kts.waktu_packing, ':', 1, 2)
                                            - INSTR (kts.waktu_packing, ':', 1, 1)
                                            - 1
                                            )
                                    )
                            * 60
                            + TRIM (SUBSTR (kts.waktu_packing,
                                            INSTR (kts.waktu_packing, ':', 1, 2) + 1,
                                            LENGTH (kts.waktu_packing)
                                            - INSTR (kts.waktu_packing, ':', 1, 2)
                                            )
                                    )
                            ) detik,
                            SUM (kts.jumlah_item) sum_jumlah_item,
                            SUM (kts.jumlah_pcs) sum_jumlah_pcs,
                            COUNT (kts.no_dokumen) jumlah_lembar
                FROM khs_tampung_spb kts
                WHERE kts.cancel IS NULL
                AND kts.selesai_packing IS NOT NULL
                GROUP BY TRUNC (kts.selesai_packing)
                ORDER BY TRUNC (kts.selesai_packing) desc";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    

}

