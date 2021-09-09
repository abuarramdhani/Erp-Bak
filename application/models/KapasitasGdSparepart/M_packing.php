<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_packing extends CI_Model
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
                         tgl_dibuat, TO_CHAR (mulai_packing, 'HH24:MI:SS') AS mulai_packing,
                         TO_CHAR (mulai_packing, 'YYYY-MM-DD HH24:MI:SS') AS jam_packing,
                         pic_packing, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         selesai_packing, urgent, waktu_packing, bon, tipe,
                         NVL (keterangan, '-') keterangan,
                         (SELECT DISTINCT mtrh.attribute15
                                     FROM mtl_txn_request_headers mtrh
                                    WHERE mtrh.request_number = no_dokumen) ekspedisi
                    FROM khs_tampung_spb kts
                   WHERE kts.selesai_pelayanan IS NOT NULL
                     AND kts.selesai_packing IS NULL
                     AND kts.CANCEL IS NULL
                     AND kts.tipe IS NOT NULL
                     AND NOT EXISTS (
                            SELECT DISTINCT kdds.status
                                       FROM khs_detail_dospb_sp kdds
                                      WHERE kdds.request_number = kts.no_dokumen
                                        AND kdds.allocated_quantity <> 0
                                        AND kdds.status IN ('A', 'V'))
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


    public function dataPacking($date)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   TO_CHAR (jam_input, 'DD/MM/YYYY HH24:MI:SS') AS jam_input,
                         tgl_dibuat, jenis_dokumen, no_dokumen, jumlah_item, jumlah_pcs,
                         TO_CHAR (mulai_packing, 'DD/MM/YYYY HH24:MI:SS') AS mulai_packing,
                         TO_CHAR (mulai_packing, 'HH24:MI:SS') AS jam_mulai,
                         TO_CHAR (selesai_packing, 'HH24:MI:SS') AS jam_selesai,
                         TO_CHAR (selesai_packing, 'DD/MM/YYYY HH24:MI:SS') AS selesai_packing,
                         waktu_packing, urgent, pic_packing, bon, tipe
                    FROM khs_tampung_spb
                   WHERE TO_CHAR (selesai_packing, 'DD/MM/YYYY') BETWEEN '$date' AND '$date'
                     AND CANCEL IS NULL
                ORDER BY TO_DATE (jam_input, 'DD/MM/YYYY HH24:MI:SS')";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


    public function SavePacking($date, $jenis, $nospb, $pic)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_tampung_spb
                   SET mulai_packing = TO_TIMESTAMP ('$date', 'DD-MM-YYYY HH24:MI:SS'),
                       pic_packing = '$pic'
                 WHERE jenis_dokumen = '$jenis' AND no_dokumen = '$nospb'";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');             
        // echo $sql; 
    }


    public function SelesaiPacking($date, $jenis, $nospb, $wkt, $pic)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_tampung_spb
                   SET selesai_packing = TO_TIMESTAMP ('$date', 'DD-MM-YYYY HH24:MI:SS'),
                       waktu_packing = '$wkt',
                       pic_packing = '$pic'
                 WHERE jenis_dokumen = '$jenis' AND no_dokumen = '$nospb'";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');             
        // echo $sql; 
    }


    public function saveWaktu($jenis, $nospb, $query)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_tampung_spb $query
                 WHERE jenis_dokumen = '$jenis' AND no_dokumen = '$nospb'";
        $query = $oracle->query($sql);       
        $query2 = $oracle->query('commit');            
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


    public function waktuPacking($nospb, $jenis, $waktu)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_tampung_spb
                   SET waktu_packing = '$waktu'
                 WHERE no_dokumen = '$nospb' AND jenis_dokumen = '$jenis'";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');          
    }


    public function insertColly($nospb, $jml_colly, $kardus_kecil, $kardus_sdg, $kardus_bsr, $karung)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "INSERT INTO khs_sp_packaging
                            (no_dokumen, jml_colly, kardus_kecil, kardus_sedang,
                             kardus_besar, karung)
                     VALUES ('$nospb', '$jml_colly', '$kardus_kecil', '$kardus_sdg',
                             '$kardus_bsr', '$karung')";
        $query = $oracle->query($sql);      
        $query2 = $oracle->query('commit');   
    }


    public function insertBerat($nospb, $jenis, $berat, $no)
    {
        $mysqli = $this->load->database('khs_packing', true);
        $sql = "INSERT INTO sp_packing_trx
                            (nomor_do, kode_packing, berat, ATTRIBUTE)
                     VALUES ('$nospb', '$jenis', '$berat', '$no')";
        $query = $mysqli->query($sql);
        // echo $sql;
    }


    public function updateBerat($nospb, $jenis, $berat, $no)
    {
        $mysqli = $this->load->database('khs_packing', true);
        $sql = "UPDATE sp_packing_trx
                   SET kode_packing = '$jenis',
                       berat = '$berat'
                 WHERE nomor_do = '$nospb' AND ATTRIBUTE = '$no'";
        $query = $mysqli->query($sql);
        // echo $sql;
    }


    public function cekPacking($nospb)
    {
        $oracle = $this->load->database('khs_packing', true);
        $sql = "SELECT *
                  FROM sp_packing_trx
                 WHERE nomor_do = '$nospb'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function cekBeratPacking($nospb, $no){
        $oracle = $this->load->database('khs_packing', true);
        $sql = "SELECT *
                FROM sp_packing_trx
                WHERE nomor_do = '$nospb'
                and attribute = '$no'
                order by attribute";
        $query = $oracle->query($sql);
        return $query->result_array();
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
                    -- and noind in ('T0005','T0015')
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


    public function getDataPacking($nospb)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   msib.segment1 item, msib.description, kcds.*
                    FROM khs_colly_dospb_sp kcds, mtl_system_items_b msib
                   WHERE kcds.request_number = '$nospb'
                     AND msib.inventory_item_id = kcds.item_id
                     AND msib.organization_id = 81
                ORDER BY kcds.colly_number, msib.description";
        $query = $oracle->query($sql);

        // echo "<pre>";
        // print_r($sql);
        // die();
        return $query->result_array();
    }


    public function getTotalColly($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT ROW_NUMBER () OVER (ORDER BY kcds.colly_number) row_num,
                                TO_NUMBER (SUBSTR (kcds.colly_number, 10)) num,
                                kcds.colly_number, COUNT (kcds.item_id) ttl_item, kcds.berat,
                                kcds.AUTO,
                                CASE
                                   WHEN EXISTS (
                                          SELECT *
                                            FROM khs_colly_dospb_sp kcds2
                                           WHERE kcds2.colly_number = kcds.colly_number
                                             AND kcds2.verif_flag = 'N')
                                      THEN 'btn-danger'
                                   ELSE 'btn-success'
                                END verif
                           FROM khs_colly_dospb_sp kcds
                          WHERE kcds.request_number = '$id'
                       GROUP BY kcds.colly_number, kcds.berat, kcds.AUTO
                       ORDER BY TO_NUMBER (SUBSTR (kcds.colly_number, 10))";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function cekItem($item,$colly)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT msib.segment1, msib.description, kcds.*
                  FROM khs_colly_dospb_sp kcds, mtl_system_items_b msib
                 WHERE msib.inventory_item_id = kcds.item_id
                   AND msib.organization_id = 81
                   AND msib.segment1 = '$item'
                   AND kcds.colly_number = '$colly'
                   AND kcds.verif_qty < kcds.quantity
                   AND ROWNUM = 1";
        $query = $oracle->query($sql);
        // $query = $oracle->query($sql)->num_rows();

        // if ($query >= 1) {
        //     return TRUE;
        // }
        // else {
        //     return FALSE;
        // }
        return $query->result_array();
    }


    public function updateQtyVerif($qty,$colly,$item)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_colly_dospb_sp kcds
                   SET kcds.verif_flag = 'Y',
                       kcds.verif_qty = $qty
                 WHERE kcds.colly_number = '$colly'
                   AND kcds.item_id =
                          (SELECT msib.inventory_item_id
                             FROM mtl_system_items_b msib
                            WHERE msib.organization_id = 81
                              AND msib.segment1 = '$item')
                   AND kcds.quantity <= $qty
                   AND kcds.quantity >= $qty
                   AND kcds.verif_flag <> 'Y'
                   AND ROWNUM = 1";
        $query = $oracle->query($sql);
        // echo $sql;
    }


    public function cekColly($colly)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT kcds.colly_number, kcds.verif_flag
                           FROM khs_colly_dospb_sp kcds
                          WHERE kcds.colly_number = '$colly'
                            AND NOT EXISTS (
                                   SELECT *
                                     FROM khs_colly_dospb_sp kcds2
                                    WHERE kcds2.colly_number = '$colly'
                                      AND kcds2.verif_qty <> kcds2.quantity)";
        $query = $oracle->query($sql)->num_rows();

        if ($query == 1) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }


    public function updateBeratColly($berat,$colly)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_colly_dospb_sp kcds
                   SET kcds.berat = $berat
                 WHERE kcds.colly_number = '$colly'";
        $query = $oracle->query($sql);
    }


    public function updateJenisColly($jenis,$colly)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_colly_dospb_sp kcds
                   SET kcds.jenis = '$jenis'
                 WHERE kcds.colly_number = '$colly'";
        $query = $oracle->query($sql);
    }


    // public function headfootPL($colly)
    // {
    //     $oracle = $this->load->database('oracle', true);
    //     $sql = "SELECT kqhds.*
    //               FROM khs_qweb_heafoot_dospb_sp1 kqhds,
    //                    (SELECT DISTINCT kcds.request_number, kcds.colly_number
    //                                FROM khs_colly_dospb_sp kcds) kcds2
    //              WHERE kqhds.request_number = kcds2.request_number
    //                AND kcds2.colly_number = '$colly'";
    //     $query = $oracle->query($sql);
    //     return $query->result_array();
    // }


    public function cekTransact($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT kcds.request_number
                           FROM khs_colly_dospb_sp kcds
                          WHERE kcds.request_number = '$id'
                            AND NOT EXISTS (
                                   SELECT kcds.*
                                     FROM khs_colly_dospb_sp kcds
                                    WHERE kcds.request_number = '$id'
                                      AND (   kcds.verif_qty <> kcds.quantity
                                           OR kcds.verif_flag = 'N'
                                          ))";
        $query = $oracle->query($sql)->num_rows();

        if ($query == 1) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }


    public function getAPIdata($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT kdd.header_id, kdd.request_number, kdd.organization_id, kdd.delivery_type
                           FROM khs_detail_dospb_sp kdd
                          WHERE kdd.request_number = '$id'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function transactDOSP($id,$org)
    {
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $oracle = $this->load->database('oracle', true);
        // $sql = "BEGIN APPS.KHS_DOSPB_SP_TRANSACT (:P_REQNUM, :P_ORG, 5177); END;";
        $sql = "BEGIN APPS.KHS_RUN_TRANSACT_DOSPB_SP (:P_REQNUM, :P_ORG, 5177); END;";

        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':P_REQNUM',$id,100);
        oci_bind_by_name($stmt,':P_ORG',$org,100);
        
        oci_execute($stmt);
    }


    public function closeLine($id,$user)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE mtl_txn_request_lines mtrl
                   SET mtrl.line_status = 5
                 WHERE mtrl.header_id = $id
                   AND mtrl.line_status IN (3, 7)
                   AND mtrl.quantity_delivered <> 0
                   AND mtrl.quantity_delivered IS NOT NULL";

        $sql2 = "UPDATE khs_detail_dospb_sp kdd
                   SET kdd.transact_flag = 'Y',
                       kdd.transact_user = '$user'
                 WHERE kdd.header_id = $id";

        $query = $oracle->query($sql);
        $query2 = $oracle->query($sql2);
        // echo $sql;
    }


    public function autoInterorg($id)
    {
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $oracle = $this->load->database('oracle', true);
        $sql = "BEGIN APPS.KHS_INTERORG_SPB ('SPB', :P_REQNUM, NULL, NULL); END;";

        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt,':P_REQNUM',$id,100);
        
        oci_execute($stmt);
    }
}