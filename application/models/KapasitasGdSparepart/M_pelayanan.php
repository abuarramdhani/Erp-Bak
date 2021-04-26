<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pelayanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }


    public function tampilhariini()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         TO_CHAR (mulai_pelayanan, 'YYYY-MM-DD HH24:MI:SS') AS jam_pelayanan,
                         tgl_dibuat,
                         TO_CHAR (mulai_pelayanan, 'HH24:MI:SS') AS mulai_pelayanan,
                         pic_pelayan, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_pelayanan, urgent, waktu_pelayanan, bon
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NULL
                     AND CANCEL IS NULL
                     AND (bon != 'PENDING' OR bon IS NULL)
                ORDER BY urgent, tgl_dibuat";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataNormal()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         TO_CHAR (mulai_pelayanan, 'YYYY-MM-DD HH24:MI:SS') AS jam_pelayanan,
                         tgl_dibuat,
                         TO_CHAR (mulai_pelayanan, 'HH24:MI:SS') AS mulai_pelayanan,
                         pic_pelayan, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_pelayanan, urgent, waktu_pelayanan, bon, tipe
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NULL
                     AND CANCEL IS NULL
                     AND tipe = 'NORMAL'
                     AND approval_flag = 'Y'
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataUrgent()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         TO_CHAR (mulai_pelayanan, 'YYYY-MM-DD HH24:MI:SS') AS jam_pelayanan,
                         tgl_dibuat,
                         TO_CHAR (mulai_pelayanan, 'HH24:MI:SS') AS mulai_pelayanan,
                         pic_pelayan, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_pelayanan, urgent, waktu_pelayanan, bon, tipe
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NULL
                     AND CANCEL IS NULL
                     AND tipe = 'URGENT'
                     AND approval_flag = 'Y'
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataEceran()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         TO_CHAR (mulai_pelayanan, 'YYYY-MM-DD HH24:MI:SS') AS jam_pelayanan,
                         tgl_dibuat,
                         TO_CHAR (mulai_pelayanan, 'HH24:MI:SS') AS mulai_pelayanan,
                         pic_pelayan, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_pelayanan, urgent, waktu_pelayanan, bon, tipe
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NULL
                     AND CANCEL IS NULL
                     AND tipe = 'ECERAN'
                     AND approval_flag = 'Y'
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataBest()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         TO_CHAR (mulai_pelayanan, 'YYYY-MM-DD HH24:MI:SS') AS jam_pelayanan,
                         tgl_dibuat,
                         TO_CHAR (mulai_pelayanan, 'HH24:MI:SS') AS mulai_pelayanan,
                         pic_pelayan, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_pelayanan, urgent, waktu_pelayanan, bon, tipe
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NULL
                     AND CANCEL IS NULL
                     AND tipe = 'BEST AGRO'
                     AND approval_flag = 'Y'
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataEcom()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         TO_CHAR (mulai_pelayanan, 'YYYY-MM-DD HH24:MI:SS') AS jam_pelayanan,
                         tgl_dibuat,
                         TO_CHAR (mulai_pelayanan, 'HH24:MI:SS') AS mulai_pelayanan,
                         pic_pelayan, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_pelayanan, urgent, waktu_pelayanan, bon, tipe
                    FROM khs_tampung_spb
                   WHERE selesai_pelayanan IS NULL
                     AND CANCEL IS NULL
                     AND tipe = 'E-COMMERCE'
                     AND approval_flag = 'Y'
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataCetak()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   *
                    FROM khs_tampung_spb
                   WHERE CANCEL IS NULL
                     AND mulai_pelayanan IS NOT NULL
                     AND no_dokumen IN (SELECT DISTINCT kcds.request_number
                                                   FROM khs_colly_dospb_sp kcds)
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataPelayanan($date)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MM:SS') AS jam_input,
                       tgl_dibuat, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                       TO_CHAR (mulai_pelayanan,'DD/MM/YYYY HH24:MI:SS') AS mulai_pelayanan,
                       TO_CHAR (mulai_pelayanan, 'HH24:MI:SS') AS jam_mulai,
                       TO_CHAR (selesai_pelayanan, 'HH24:MI:SS') AS jam_selesai,
                       TO_CHAR (selesai_pelayanan,'DD/MM/YYYY HH24:MI:SS') AS selesai_pelayanan,
                       waktu_pelayanan, urgent, pic_pelayan, bon, tipe
                  FROM khs_tampung_spb
                 WHERE TO_CHAR (selesai_pelayanan, 'DD/MM/YYYY') BETWEEN '$date' AND '$date'
                   AND CANCEL IS NULL
              ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataDetail($doc)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT msib.segment1, msib.description, mtrh.request_number, mtrl.*
                  FROM mtl_txn_request_headers mtrh,
                       mtl_txn_request_lines mtrl,
                       mtl_system_items_b msib
                 WHERE mtrh.header_id = mtrl.header_id
                   AND mtrl.inventory_item_id = msib.inventory_item_id
                   AND msib.organization_id = mtrl.organization_id
                   AND mtrh.request_number = '$doc'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


    public function SavePelayanan($date, $jenis, $nospb, $pic)
    {
        $oracle = $this->load->database('oracle', true);
        $sql="UPDATE khs_tampung_spb
                 SET mulai_pelayanan = TO_TIMESTAMP ('$date', 'DD-MM-YYYY HH24:MI:SS'),
                     pic_pelayan = '$pic'
               WHERE jenis_dokumen = '$jenis' AND no_dokumen = '$nospb'";
        $query = $oracle->query($sql);         
        $query2 = $oracle->query('commit');          
        echo $sql; 
    }


    public function SavePelayanan2($user, $pic, $nospb)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_detail_dospb_sp aa
                   SET aa.assign_date = SYSDATE,
                       aa.assigner_id = '$user',
                       aa.assignee_id = '$pic'
                 WHERE aa.request_number = '$nospb'";
        $query = $oracle->query($sql);         
        $query2 = $oracle->query('commit');          
        echo $sql; 
    }


    public function SelesaiPelayanan($date, $jenis, $nospb, $wkt, $pic)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_tampung_spb
                   SET selesai_pelayanan = TO_TIMESTAMP ('$date', 'DD-MM-YYYY HH24:MI:SS'),
                       waktu_pelayanan = '$wkt',
                       pic_pelayan = '$pic'
                 WHERE jenis_dokumen = '$jenis' AND no_dokumen = '$nospb'";
        $query = $oracle->query($sql);            
        $query2 = $oracle->query('commit');       
        echo $sql; 
    }


    public function getStatus($noSPB)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT mtrh.request_number no_do_spb, msib.segment1 item, msib.description,
                       mtrl.uom_code, mmtt.transaction_quantity qty_allocate,
                       (SELECT DECODE (wdd.released_status,
                                       'B', 'Backordered',
                                       'C', 'Shipped',
                                       'D', 'Cancelled',
                                       'N', 'Not Ready for Release',
                                       'R', 'Ready to Release',
                                       'S', 'Released to Warehouse',
                                       'X', 'Not Applicable',
                                       'Y', 'Staged'
                                      )
                          FROM wsh_delivery_details wdd
                         WHERE mtrh.request_number = TO_CHAR (wdd.batch_id) AND ROWNUM = 1)
                                                                              status_shipment,
                       mmtt.creation_date tgl_allocate, mp.organization_code,
                       (SELECT ooha.order_number
                          FROM wsh_delivery_details wdd, oe_order_headers_all ooha
                         WHERE mtrh.request_number = TO_CHAR (wdd.batch_id)
                           AND wdd.source_header_id = ooha.header_id
                           AND ROWNUM = 1) ket
                  FROM mtl_txn_request_headers mtrh,
                       mtl_txn_request_lines mtrl,
                       mtl_system_items_b msib,
                       mtl_material_transactions_temp mmtt,
                       mtl_parameters mp
                 WHERE mtrh.header_id = mtrl.header_id
                   AND mtrl.inventory_item_id = msib.inventory_item_id
                   AND mtrl.organization_id = msib.organization_id
                   AND mmtt.move_order_line_id = mtrl.line_id
                   AND mmtt.organization_id = mp.organization_id
                   AND mtrh.request_number = '$noSPB'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


    public function cekMulai($nospb, $jenis)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
                  FROM khs_tampung_spb
                 WHERE no_dokumen = '$nospb' AND jenis_dokumen = '$jenis'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function WaktuPelayanan($jenis, $nospb, $slsh)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_tampung_spb
                   SET waktu_pelayanan = '$slsh'
                 WHERE jenis_dokumen = '$jenis' AND no_dokumen = '$nospb'";
        $query = $oracle->query($sql);            
        $query2 = $oracle->query('commit');       
    }


    public function getPIC($term)
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
                    and (kodesie like '3070101%' or kodesie like '3070301%')
                    and left(noind, 1) not in ('B','D','J')
                    --and noind in ('T0005','T0015')
                    and (noind like '%$term%' or nama like '%$term%')
                order by
                    1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getPIC2()
    {
        $oracle = $this->load->database('personalia', true);
        $sql = "select
                    noind,
                    trim(nama) nama,
                    kodesie
                from
                    hrd_khs.tpribadi
                where
                    left(noind, 1) not in ('B','D','J')
                order by
                    1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    // CETAK PDF PL

    public function headfootPL($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT kqhds.*
                  FROM khs_qweb_heafoot_dospb_sp1 kqhds
                 WHERE kqhds.request_number = '$id'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function bodyPL($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   *
                  FROM (SELECT aa.*, TO_NUMBER (SUBSTR (aa.colly_number, 10)) num
                          FROM khs_qweb_bodycolly_dospb_sp1 aa
                         WHERE aa.request_number = '$id'
                        UNION
                        SELECT aa.header_id, aa.request_number, aa.colly_number, 'TOTAL',
                               NULL, NULL, NULL,
                               (SELECT SUM (bb.berat)
                                  FROM khs_qweb_bodycolly_dospb_sp1 bb
                                 WHERE bb.request_number = aa.request_number
                                   AND bb.colly_number = aa.colly_number),
                               NULL, TO_NUMBER (SUBSTR (aa.colly_number, 10)) num
                          FROM khs_qweb_bodycolly_dospb_sp1 aa
                         WHERE aa.request_number = '$id') x
              ORDER BY x.num, x.description NULLS LAST";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getTotalColly($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT ROWNUM, aa.*
                  FROM (SELECT DISTINCT TO_NUMBER (SUBSTR (kcds.colly_number, 10)) num,
                                        kcds.colly_number, COUNT (kcds.item_id) ttl_item,
                                        kcds.berat
                                   FROM khs_colly_dospb_sp kcds
                                  WHERE kcds.request_number = '$id'
                               GROUP BY TO_NUMBER (SUBSTR (kcds.colly_number, 10)),
                                        kcds.colly_number,
                                        kcds.berat
                               ORDER BY 1) aa";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getTotalBerat($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT SUM (NVL (msib.unit_weight, 0) * kcds.quantity) ttl, NVL (msib.weight_uom_code, 'KG') weight_uom_code
                           FROM khs_colly_dospb_sp kcds, mtl_system_items_b msib
                          WHERE kcds.request_number = '$id'
                            AND msib.organization_id = 81
                            AND msib.inventory_item_id = kcds.item_id
                       GROUP BY NVL (msib.weight_uom_code, 'KG')";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    

    public function getAll($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
                  FROM khs_tampung_spb
                 WHERE no_dokumen = '$id'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
}