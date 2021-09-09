<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_penyerahan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getNomorSPB($tgl) {
        $mysqli = $this->load->database('quick', true);
        $sql ="select distinct no_SPB from quickc01_trackingpengirimanbarang.tpb
                where quickc01_trackingpengirimanbarang.tpb.status = 'onProcess'
                and quickc01_trackingpengirimanbarang.tpb.start_date like '$tgl%'";
        $query = $mysqli->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getDataSPB($nomor){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct mtrh.REQUEST_NUMBER
                    ,mtrh.ATTRIBUTE15
                    ,ood.ORGANIZATION_CODE org
                    ,ood.ORGANIZATION_NAME tujuan
                    ,sum(mtrl.QUANTITY_DELIVERED) over (partition by mtrh.REQUEST_NUMBER) qty_transact
                from mtl_txn_request_headers mtrh
                    ,mtl_txn_request_lines mtrl
                    ,org_organization_definitions ood
                where mtrh.HEADER_ID = mtrl.HEADER_ID
                and substr(mtrl.REFERENCE,5) = ood.ORGANIZATION_ID
                and mtrh.REQUEST_NUMBER = '$nomor'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function cariberat($nomor){
        $oracle = $this->load->database('khs_packing', true);
        $sql = "select spt.berat BERAT, spt.nomor_do colly from sp_packing_trx spt where nomor_do = '$nomor'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getEkspedisi($term)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT mtrh.attribute15 ekspedisi
                           FROM mtl_txn_request_headers mtrh
                          WHERE mtrh.attribute15 IS NOT NULL
                            AND mtrh.attribute15 like '%$term%'
                       ORDER BY 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }



    public function getSiapManifest($ekspedisi)
    {
        $oracle = $this->load->database('oracle', true);
        $user = $this->session->userdata('user');
        $sql = "SELECT   kts.no_dokumen request_number, kts.jumlah_item, kts.jumlah_pcs,
                         mtrh.attribute15 ekspedisi, COUNT (ttl.colly_number) ttl_colly,
                         NVL (SUM (ttl.berat), 0) ttl_berat, kts.pic_packing, kts.keterangan
                    FROM khs_tampung_spb kts,
                         mtl_txn_request_headers mtrh,
                         (SELECT DISTINCT kcds.request_number, kcds.colly_number, kcds.berat
                                     FROM khs_colly_dospb_sp kcds) ttl
                   WHERE kts.no_dokumen = mtrh.request_number
                     AND ttl.request_number = kts.no_dokumen
                     AND kts.selesai_packing IS NOT NULL
                     AND kts.tipe IS NOT NULL
                     AND mtrh.attribute15 = '$ekspedisi'
                     AND kts.no_dokumen NOT IN (SELECT DISTINCT kms.request_number
                                                           FROM khs_manifest_sp kms)
                GROUP BY mtrh.attribute15,
                         kts.jumlah_item,
                         kts.jumlah_pcs,
                         kts.no_dokumen,
                         kts.pic_packing,
                         kts.keterangan
                ORDER BY 1";
        $query = $oracle->query($sql);
        return $query->result_array();
    }



    // public function dataManifest()
    // {
    //     $oracle = $this->load->database('oracle', true);
    //     $user = $this->session->userdata('user');
    //     $sql = "SELECT DISTINCT kms.manifest_number, kms.request_number, SUM (cl.berat) berat,
    //                             COUNT (cl.colly_number) ttl_colly,
    //                             (SELECT mtrh.attribute15
    //                                FROM mtl_txn_request_headers mtrh
    //                               WHERE mtrh.request_number = kms.request_number) ekspedisi
    //                        FROM khs_manifest_sp kms,
    //                             (SELECT DISTINCT kcds.request_number, kcds.colly_number,
    //                                              kcds.berat
    //                                         FROM khs_colly_dospb_sp kcds) cl
    //                       WHERE kms.flag = 'N'
    //                         AND kms.created_by = '$user'
    //                         AND kms.request_number = cl.request_number
    //                    GROUP BY kms.manifest_number, kms.request_number";
    //     $query = $oracle->query($sql);
    //     return $query->result_array();
    // }


    public function dataSudahManifest()
    {
        $oracle = $this->load->database('oracle', true);
        $user = $this->session->userdata('user');
        $sql = "SELECT DISTINCT kms.manifest_number,
                                (SELECT mtrh.attribute15
                                   FROM mtl_txn_request_headers mtrh
                                  WHERE mtrh.request_number = kms.request_number) ekspedisi,
                                  SUBSTR(kms.creation_date, 1, 10) creation_date, kms.created_by
                           FROM khs_manifest_sp kms,
                                (SELECT DISTINCT kcds.request_number, kcds.colly_number,
                                                 kcds.berat
                                            FROM khs_colly_dospb_sp kcds) cl
                          WHERE kms.request_number = cl.request_number
                          ORDER BY kms.manifest_number DESC";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function cekSiapManifest($no_spb,$ekspedisi)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT mtrh.*
                  FROM mtl_txn_request_headers mtrh
                 WHERE mtrh.request_number = '$no_spb'
                   AND mtrh.attribute15 = '$ekspedisi'
                   AND EXISTS (
                          SELECT *
                            FROM mtl_txn_request_headers mtrh2, mtl_txn_request_lines mtrl2
                           WHERE mtrh2.header_id = mtrl2.header_id
                             AND mtrl2.line_status NOT IN (3, 7)
                             AND mtrh2.request_number = mtrh.request_number)";
        $query = $oracle->query($sql)->num_rows();

        if ($query >= 1) {
            return TRUE;
        }
        else {
            return FALSE;
        }
        // return $query->result_array();
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


    public function cekSudahManifest($no_spb)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
                  FROM khs_manifest_sp kms
                 WHERE kms.request_number = '$no_spb'";
        $query = $oracle->query($sql)->num_rows();

        if ($query >= 1) {
            return FALSE;
        }
        else {
            return TRUE;
        }
        // return $query->result_array();
    }


    public function generateManifestNum()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT    'MNF'
                       || TO_CHAR (SYSDATE, 'YYYYMM')
                       || LPAD (khsseq_manifest.NEXTVAL, '4', 0) manifest_number
                  FROM DUAL";
        $query = $oracle->query($sql)->result_array();

        return $query[0]['MANIFEST_NUMBER'];
    }

    public function getData($no_man)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
                  FROM khs_manifest_sp kms
                 WHERE kms.manifest_number = '$no_man'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getDataCetak($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT   kms.manifest_number, kms.request_number, kqhds.tipe, kms.ekspedisi,
                         kms.created_by pic_penyerahan, kqhds.jumlah_colly,
                         NVL (SUM (aa.berat), 0) ttl_berat, kqhds.nama_kirim, kqhds.lain, kqhds.alamat_kirim, kqhds.kota_kirim
                    FROM khs_manifest_sp kms,
                         (SELECT DISTINCT kcds.request_number, kcds.colly_number, kcds.berat
                                     FROM khs_colly_dospb_sp kcds) aa,
                         khs_qweb_heafoot_dospb_sp1 kqhds
                   WHERE kms.request_number = aa.request_number(+)
                     AND kqhds.request_number = kms.request_number
                     AND kms.manifest_number = '$id'
                GROUP BY kms.manifest_number,
                         kms.request_number,
                         kms.created_by,
                         kms.ekspedisi,
                         kqhds.nama_kirim,
                         kqhds.alamat_kirim,
                         kqhds.kota_kirim,
                         kqhds.lain,
                         kqhds.tipe,
                         kqhds.jumlah_colly
                ORDER BY NVL (kqhds.lain, kqhds.alamat_kirim)";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function getNamaEkspedisi()
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT ke.ekspedisi, pov.vendor_name
                  FROM khs_ekspedisi ke, po_vendors pov
                 WHERE ke.vendor_id = pov.vendor_id";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    // ======
    public function getAPIdata($id)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT DISTINCT kdd.header_id, kdd.request_number, kdd.organization_id, kdd.delivery_type
                           FROM khs_detail_dospb_sp kdd
                          WHERE kdd.request_number = '$id'";
        $query = $oracle->query($sql);
        return $query->row_array();
    }

    public function transactDOSP($id,$org)
    {
        $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // $sql = "BEGIN APPS.KHS_DOSPB_SP_TRANSACT (:P_REQNUM, :P_ORG, 5177); END;";
        $sql = "BEGIN APPS.KHS_RUN_TRANSACT_DOSPB_SP ('$id', $org, 5177); END;";

        $stmt = oci_parse($conn,$sql);

        oci_execute($stmt);

        return 200;
    }

    public function savePenyerahan($rn, $no, $eks)
    {
      $oracle = $this->load->database('oracle', true);
      foreach ($rn as $key => $value) {
        $data_api = $this->getAPIdata($value);
        if (!empty($data_api['ORGANIZATION_ID'])) {
          $res_transact = $this->transactDOSP($value, $data_api['ORGANIZATION_ID']);
          if ($res_transact == 200) {
            $no_indk = $this->session->userdata('user');
            $oracle->query("INSERT INTO khs_manifest_sp (MANIFEST_NUMBER, EKSPEDISI, REQUEST_NUMBER, CREATION_DATE, CREATED_BY)
                            VALUES ('$no', '$eks', '$value', SYSDATE, '$no_indk')");
          }else {
            return [
              'status' => 500,
              'message' => "terjadi kesalahan saat melakukan transact di requst number $value"
            ];
          }
        }else {
          return [
            'status' => 500,
            'message' => "ORGANIZATION_ID is empty on requst number $value"
          ];
        }
      }
      return [
        'status' => 200
      ];
    }

    public function cekudatransactblm($rn)
    {
      $oracle = $this->load->database('oracle', true);
      foreach ($rn as $key => $value) {
        $cek = $oracle->query("SELECT request_number FROM khs_manifest_sp where request_number = '$value'")->row_array();
        if (!empty($cek['REQUEST_NUMBER'])) {
          return [
            'status' => 407,
            'message' => "REQUEST_NUMBER $value telah di Transact sebelumnya!"
          ];
        }
      }
      return [
        'status' => 200
      ];
    }


}
