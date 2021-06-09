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


    public function dataManifest()
    {
        $oracle = $this->load->database('oracle', true);
        $user = $this->session->userdata('user');
        $sql = "SELECT DISTINCT kms.manifest_number, kms.request_number, SUM (cl.berat) berat,
                                COUNT (cl.colly_number) ttl_colly,
                                (SELECT mtrh.attribute15
                                   FROM mtl_txn_request_headers mtrh
                                  WHERE mtrh.request_number = kms.request_number) ekspedisi
                           FROM khs_manifest_sp kms,
                                (SELECT DISTINCT kcds.request_number, kcds.colly_number,
                                                 kcds.berat
                                            FROM khs_colly_dospb_sp kcds) cl
                          WHERE kms.flag = 'N'
                            AND kms.created_by = '$user'
                            AND kms.request_number = cl.request_number
                       GROUP BY kms.manifest_number, kms.request_number";
        $query = $oracle->query($sql);
        return $query->result_array();
    }


    public function dataSudahManifest()
    {
        $oracle = $this->load->database('oracle', true);
        $user = $this->session->userdata('user');
        $sql = "SELECT DISTINCT kms.manifest_number,
                                (SELECT mtrh.attribute15
                                   FROM mtl_txn_request_headers mtrh
                                  WHERE mtrh.request_number = kms.request_number) ekspedisi,
                                kms.creation_date, kms.created_by
                           FROM khs_manifest_sp kms,
                                (SELECT DISTINCT kcds.request_number, kcds.colly_number,
                                                 kcds.berat
                                            FROM khs_colly_dospb_sp kcds) cl
                          WHERE kms.flag = 'Y'
                            AND kms.request_number = cl.request_number";
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


    public function insertManifest($no_spb,$user,$ekspedisi)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "INSERT INTO khs_manifest_sp (request_number, scan_date, created_by, ekspedisi)
                VALUES ('$no_spb', SYSDATE, '$user', '$ekspedisi')";
        $query = $oracle->query($sql);
        // echo $sql;
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


    public function cekBeforeGenerate($user,$ekspedisi)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
                  FROM khs_manifest_sp kms
                 WHERE kms.flag = 'N'
                   AND kms.created_by = '$user'
                   AND kms.ekspedisi = '$ekspedisi'
                   AND kms.manifest_number IS NULL";
        $query = $oracle->query($sql)->num_rows();

        if ($query >= 1) {
            return TRUE;
        }
        else {
            return FALSE;
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


    public function updateManifest($no,$user)
    {
        $oracle = $this->load->database('oracle', true);
        $sql = "UPDATE khs_manifest_sp kms
                   SET kms.manifest_number = '$no',
                       kms.flag = 'Y',
                       kms.creation_date = SYSDATE
                 WHERE kms.flag = 'N'
                   AND kms.created_by = '$user'
                   AND kms.manifest_number is null";
        $query = $oracle->query($sql);
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
                         NVL (SUM (aa.berat), 0) ttl_berat, kqhds.nama_kirim, kqhds.lain
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
                         kqhds.lain,
                         kqhds.tipe,
                         kqhds.jumlah_colly
                ORDER BY kms.request_number";
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
}

