<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetak extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }


    public function siapCetak()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         tgl_dibuat, TO_CHAR (mulai_packing, 'HH24:MI:SS') AS mulai_packing,
                         TO_CHAR (mulai_packing, 'YYYY-MM-DD HH24:MI:SS') AS jam_packing,
                         pic_packing, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_packing, urgent, waktu_packing, bon, tipe
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NOT NULL
                     AND selesai_packing IS NOT NULL
                     AND CANCEL IS NULL
                     AND tipe IS NOT NULL
                     AND no_dokumen NOT IN (SELECT DISTINCT request_number
                                                       FROM khs_cetak_do
                                                      WHERE request_number IS NOT NULL)
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


     public function sudahCetak()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         tgl_dibuat, TO_CHAR (mulai_packing, 'HH24:MI:SS') AS mulai_packing,
                         TO_CHAR (mulai_packing, 'YYYY-MM-DD HH24:MI:SS') AS jam_packing,
                         pic_packing, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_packing, urgent, waktu_packing, bon, tipe
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NOT NULL
                     AND selesai_packing IS NOT NULL
                     AND CANCEL IS NULL
                     AND tipe IS NOT NULL
                     AND no_dokumen IN (
                            SELECT DISTINCT request_number
                                       FROM khs_cetak_do
                                      WHERE request_number IS NOT NULL
                                        AND TRUNC (creation_date) = TRUNC (SYSDATE))
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


    // CETAK PDF PL

    public function headfootSurat($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT kqhds.*
                  FROM khs_qweb_heafoot_dospb_sp1 kqhds
                 WHERE kqhds.request_number = '$id'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function bodySurat($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   msib.segment1, msib.description,
                         kdds.required_quantity qty_requested,
                         NVL (TO_CHAR (mtrl.quantity_delivered), '--') qty_delivered, mtrl.*
                    FROM mtl_txn_request_headers mtrh,
                         mtl_txn_request_lines mtrl,
                         mtl_system_items_b msib,
                         khs_detail_dospb_sp kdds
                   WHERE mtrh.header_id = mtrl.header_id
                     AND mtrl.inventory_item_id = msib.inventory_item_id
                     AND msib.organization_id = mtrl.organization_id
                     AND mtrh.header_id = kdds.header_id
                     AND mtrl.line_id = kdds.line_id
                     AND mtrl.line_status IN (5,6)
                     AND mtrh.request_number = '$id'
                ORDER BY mtrl.line_number";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getTotalColly($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   ttl.colly_number, NVL (SUM (ttl.berat), 0) berat,
                         'C' || SUBSTR (ttl.colly_number, 10) cnum
                    FROM (SELECT DISTINCT kcds.request_number, kcds.colly_number, kcds.berat
                                     FROM khs_colly_dospb_sp kcds
                                    WHERE kcds.request_number = '$id') ttl
                GROUP BY ttl.colly_number
                ORDER BY TO_NUMBER (SUBSTR (ttl.colly_number, 10))";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getTotalBerat($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   ttl.request_number, NVL (SUM (ttl.berat), 0) ttl_berat
                    FROM (SELECT DISTINCT kcds.request_number, kcds.colly_number,
                                          kcds.berat
                                     FROM khs_colly_dospb_sp kcds
                                    WHERE kcds.request_number = '$id') ttl
                GROUP BY ttl.request_number";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getPIC()
    {
        $oracle = $this->load->database('personalia', true);
        $sql = "select
                    noind,
                    trim(nama) nama,
                    kodesie
                from
                    hrd_khs.tpribadi
                where
                    keluar = '0'
                order by
                    1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function insertCetak($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "INSERT INTO khs_cetak_do
                            (request_number, creation_date)
                     VALUES ('$id', SYSDATE)";
        $query = $oracle->query($sql);
        return $query;
    }

    public function getDOfromSPB($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT 'DO : ' || TO_CHAR (wdd.batch_id) batch_id
                  FROM khscreatemofromsotab kcmf,
                       (SELECT kdds.request_number, kdds.line_id, kdds.transact_flag
                          FROM khs_detail_dospb_sp kdds
                         WHERE kdds.request_number = '$id'
                           AND kdds.delivery_type = 'SPB'
                           AND kdds.transact_flag = 'Y'
                        UNION ALL
                        SELECT kdd.request_number, kdd.line_id, kdd.transact_flag
                          FROM khs_detail_dospb kdd
                         WHERE kdd.request_number = '$id'
                           AND kdd.delivery_type = 'SPB'
                           AND kdd.transact_flag = 'Y') xx,
                       mtl_txn_request_headers mtrh,
                       wsh_delivery_details wdd
                 WHERE kcmf.nomor_spb = '$id'
                   AND xx.request_number = kcmf.nomor_spb
                   AND xx.request_number = mtrh.request_number
                   AND kcmf.nomor_do = wdd.batch_id
                   AND kcmf.delivery_detail_id = wdd.delivery_detail_id
                   AND kcmf.mtrl_line_id = xx.line_id
                   AND wdd.batch_id IS NOT NULL
                   AND wdd.released_status <> 'B'
                UNION
                SELECT 'DO : ' || TO_CHAR (wdd.batch_id) batch_id
                  FROM khs_mo_from_so_header_tab kmfs,
                       (SELECT kdds.request_number, kdds.line_id, kdds.inventory_item_id,
                               kdds.transact_flag
                          FROM khs_detail_dospb_sp kdds
                         WHERE kdds.request_number = '$id'
                           AND kdds.delivery_type = 'SPB'
                           AND kdds.transact_flag = 'Y'
                        UNION ALL
                        SELECT kdd.request_number, kdd.line_id, kdd.inventory_item_id,
                               kdd.transact_flag
                          FROM khs_detail_dospb kdd
                         WHERE kdd.request_number = '$id'
                           AND kdd.delivery_type = 'SPB'
                           AND kdd.transact_flag = 'Y') xx,
                       mtl_system_items_b msib,
                       mtl_txn_request_headers mtrh,
                       wsh_delivery_details wdd
                 WHERE kmfs.mtrh_request_number = '$id'
                   AND xx.request_number = kmfs.mtrh_request_number
                   AND xx.request_number = mtrh.request_number
                   AND xx.inventory_item_id = msib.inventory_item_id
                   AND kmfs.oola_assembly_item = msib.segment1
                   AND msib.organization_id = 81
                   AND wdd.source_header_number = kmfs.ooha_order_number
                   AND wdd.inventory_item_id = xx.inventory_item_id
                   AND wdd.batch_id IS NOT NULL
                   AND wdd.released_status <> 'B'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
}