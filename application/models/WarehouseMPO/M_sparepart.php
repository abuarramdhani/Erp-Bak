<?php
class M_sparepart extends CI_Model {

  var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->oracle = $this->load->database('oracle_dev', true);
    }

    public function allSpare() //header
    {
      $sql = "SELECT DISTINCT 
                    mtrh.request_number no_spb, 
                    mtrh.creation_date tgl_spb,
                    NVL(mtrh.attribute15, kpt.EXPEDITION_CODE) ekspedisi,
                    kms.tgl_mulai,
                    (SELECT MAX (SUBSTR (kpt.packing_code, -2, 2))
                        FROM khs_packinglist_transactions kpt
                       WHERE kpt.mo_number = mtrh.request_number) jml_colly,
                     TO_CHAR(kms.tgl_mulai,'HH24:MI:SS') jam_mulai
                    ,TO_CHAR(kms.tgl_selesai,'HH24:MI:SS') jam_selesai
                    ,kms.tgl_selesai - kms.tgl_mulai lama
               FROM mtl_txn_request_headers mtrh,
                    mtl_txn_request_lines mtrl,
                    mtl_system_items_b msib,
                    khs_packinglist_transactions kpt,
                    khs_mon_spb kms
              WHERE mtrh.header_id = mtrl.header_id
                AND mtrh.organization_id = 225
                AND mtrh.request_number = kpt.mo_number
                AND kms.no_spb(+) = mtrh.request_number
                AND mtrl.inventory_item_id = msib.inventory_item_id
                AND msib.organization_id = mtrh.organization_id
           ORDER BY 1";

       $query = $this->oracle->query($sql);
       return $query->result_array();
    }

    public function lineSpare() //line
    {
      $sql = "SELECT DISTINCT 
                     mtrh.request_number no_spb
                    ,mtrh.creation_date tgl_spb
                    ,NVL(mtrh.attribute15, kpt.EXPEDITION_CODE) ekspedisi
                    ,mtrl.line_number,msib.segment1 item_code
                    ,msib.description
                    ,mtrl.quantity qty_diminta
                    ,NVL (mtrl.quantity_delivered, 0) qty_dikirim
                    ,mtrl.uom_code uom
                    ,(SELECT MAX (SUBSTR (kpt.packing_code, -2, 2))
                        FROM khs_packinglist_transactions kpt
                       WHERE kpt.mo_number = mtrh.request_number) jml_colly
                    ,TO_CHAR(kms.tgl_mulai,'HH24:MI:SS') jam_mulai
                    ,TO_CHAR(kms.tgl_selesai,'HH24:MI:SS') jam_selesai
                    ,kms.tgl_selesai - kms.tgl_mulai lama
                FROM mtl_txn_request_headers mtrh,
                     mtl_txn_request_lines mtrl,
                     mtl_system_items_b msib,
                     khs_packinglist_transactions kpt,
                     khs_mon_spb kms
               WHERE mtrh.header_id = mtrl.header_id
                 AND mtrh.organization_id = 225
                 AND mtrh.request_number = kpt.mo_number
                 AND kms.no_spb(+) = mtrh.request_number
                 AND mtrl.inventory_item_id = msib.inventory_item_id
                 AND msib.organization_id = mtrh.organization_id
            ORDER BY 1";

       $query = $this->oracle->query($sql);
       return $query->result_array();
    }

    public function filterSpare($tanggalSPBSawal,$tanggalSPBSakhir,$tanggalKirimAwal,$tanggalKirimAkhir,$noSPB)
    {
      if ($tanggalSPBSawal==FALSE && $tanggalSPBSakhir==FALSE) {
          $tanggal_spb = "";
      }else{
          $tanggal_spb = "AND TO_CHAR(mtrh.creation_date,'MM/DD/YYYY') between '$tanggalSPBSawal' and '$tanggalSPBSakhir'";
      }

      if ($tanggalKirimAwal==FALSE && $tanggalKirimAkhir==FALSE) {
          $tanggal_kirim = "";
      }else{
        $tanggal_kirim = "AND TO_CHAR(kms.tgl_mulai,'MM/DD/YYYY') between '$tanggalKirimAwal' and '$tanggalKirimAkhir'";
      }

      if ($noSPB==FALSE) {
          $no_SPB = "";
      }else{
          $no_SPB = "AND mtrh.request_number LIKE '%$noSPB%'";
      }

      $sql = "SELECT DISTINCT mtrh.request_number no_spb, 
                    mtrh.creation_date tgl_spb,
                    NVL(mtrh.attribute15, kpt.EXPEDITION_CODE) ekspedisi,
                    kms.tgl_mulai,
                    (SELECT MAX (SUBSTR (kpt.packing_code, -2, 2))
                        FROM khs_packinglist_transactions kpt
                       WHERE kpt.mo_number = mtrh.request_number) jml_colly,
                     TO_CHAR(kms.tgl_mulai,'HH24:MI:SS') jam_mulai
                    ,TO_CHAR(kms.tgl_selesai,'HH24:MI:SS') jam_selesai
                    ,kms.tgl_selesai - kms.tgl_mulai lama
           FROM mtl_txn_request_headers mtrh,
                mtl_txn_request_lines mtrl,
                mtl_system_items_b msib,
                khs_packinglist_transactions kpt,
                khs_mon_spb kms
          WHERE mtrh.header_id = mtrl.header_id
            --AND mtrh.organization_id = 225
            AND mtrh.request_number = kpt.mo_number
            AND kms.no_spb(+) = mtrh.request_number
            AND mtrl.inventory_item_id = msib.inventory_item_id
            AND msib.organization_id = mtrh.organization_id
            $tanggal_spb --
            $tanggal_kirim --
            $no_SPB --
       ORDER BY 1";

       $query = $this->oracle->query($sql);
       return $query->result_array();
    }
}
?>