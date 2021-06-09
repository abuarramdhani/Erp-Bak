<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function getItem($no_po, $surat_jalan, $segment1, $receipt_date)
    {
      // $range =  explode(' - ', $range_);
      return $this->oracle->query("SELECT rse.receipt_date,
                                          rse.type,
                                          rse.palet,
                                          rse.serial_number,
                                          rse.front_code,
                                          deh.kode_sebelum,
                                          deh.type_sebelum,
                                          deh.kode_setelah,
                                          deh.type_setelah,
                                          deh.produk,
                                          deh.warna_kib
                                   FROM KHS_RECEIPT_SERIAL_ENGINE rse
                                   LEFT JOIN khs_daftar_engine_honda deh ON deh.KODE_SEBELUM = rse.SEGMENT1
                                   WHERE TO_CHAR(rse.receipt_date, 'YYYY-MM-DD') = '$receipt_date'
                                   AND rse.po_number = '$no_po'
                                   AND rse.shipment_number = '$surat_jalan'
                                   AND rse.segment1 = '$segment1'
                                   -- and rownum<=20
                                   --ORDER BY rse.serial_number asc
                                   ORDER BY CAST (rse.palet AS INTEGER)")->result_array();
    }

    public function updateSerial($data)
    {
      $sj_convert =  str_replace("__","/", $data['surat_jalan']);
      $cek = $this->oracle->query("SELECT serial_number FROM KHS_RECEIPT_SERIAL_ENGINE
                                   WHERE TO_CHAR(receipt_date, 'YYYY-MM-DD') = '{$data['receipt_date']}'
                                   AND po_number = '{$data['no_po']}'
                                   AND shipment_number = '$sj_convert'
                                   AND segment1 = '{$data['segment1']}'
                                   AND serial_number = '{$data['serial_baru']}'")->row_array();

      if (!empty($cek['SERIAL_NUMBER'])) {
        return 2;
      }else {
        $this->oracle->query("UPDATE KHS_RECEIPT_SERIAL_ENGINE SET serial_number = '{$data['serial_baru']}'
                              WHERE TO_CHAR(receipt_date, 'YYYY-MM-DD') = '{$data['receipt_date']}'
                              AND po_number = '{$data['no_po']}'
                              AND shipment_number = '$sj_convert'
                              AND segment1 = '{$data['segment1']}'
                              AND serial_number = '{$data['serial_lama']}'");
        if ($this->oracle->affected_rows() == 1) {
          return 1;
        }else {
          return 0;
        }
      }

    }

    public function getPO($range_date)
    {
      $range =  explode(' - ', $range_date);
      return $this->oracle->query("SELECT DISTINCT po_number, shipment_number
                                   FROM KHS_RECEIPT_SERIAL_ENGINE
                                   WHERE TO_CHAR(receipt_date, 'YYYY-MM-DD') BETWEEN '{$range[0]}' AND '$range[1]'")->result_array();
    }

    public function getEngine($no_po, $surat_jalan)
    {
      return $this->oracle->query("SELECT DISTINCT rse.segment1, rse.type, TO_CHAR(receipt_date, 'YYYY-MM-DD') receipt_date, rse.description, deh.produk, deh.warna_kib
                                   FROM KHS_RECEIPT_SERIAL_ENGINE rse
                                   LEFT JOIN khs_daftar_engine_honda deh ON deh.kode_sebelum = rse.segment1
                                   WHERE rse.po_number = '$no_po'
                                   AND rse.shipment_number = '$surat_jalan'")->result_array();
    }

    public function getSerial($no_po, $surat_jalan, $segment1, $receipt_date)
    {
      return $this->oracle->query("SELECT rse.serial_number
                                   FROM KHS_RECEIPT_SERIAL_ENGINE rse
                                   WHERE rse.po_number = '$no_po'
                                   AND TO_CHAR(rse.receipt_date, 'YYYY-MM-DD') = '$receipt_date'
                                   AND rse.shipment_number = '$surat_jalan'
                                   AND rse.SEGMENT1 = '$segment1'
                                   ORDER BY rse.serial_number asc")->result_array();
    }

    public function getNoLppb($no_po, $surat_jalan)
    {
      return $this->oracle->query("SELECT DISTINCT rsh.RECEIPT_NUM no_lppb
                                  from rcv_shipment_lines rsl
                                      ,rcv_shipment_headers rsh
                                      ,po_headers_all pha
                                  where pha.SEGMENT1 = '$no_po'
                                    and rsh.SHIPMENT_NUM = nvl('$surat_jalan',rsh.SHIPMENT_NUM)
                                    and rsl.PO_HEADER_ID = pha.PO_HEADER_ID
                                    and rsl.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID
                                    and rsh.CREATION_DATE IN (select rsh.CREATION_DATE
                                                               from rcv_shipment_headers rsh
                                                                   ,rcv_shipment_lines rsl
                                                              where rsh.SHIPMENT_HEADER_ID = rsl.SHIPMENT_HEADER_ID
                                                                and rsl.PO_HEADER_ID = pha.PO_HEADER_ID)")->row_array();
    }

    // // start server side on model
    // public function selectMaster($data)
    // {
    //   if (empty($data['tipe'])) {
    //     $tipe = '';
    //   }else {
    //     $tipe = "AND type = '{$data['tipe']}'";
    //   }
    //   $range =  explode(' - ', $data['range_date']);
    //   $explode = strtoupper($data['search']['value']);
    //     $res = $this->oracle
    //         ->query(
    //             "SELECT sub1_.*
    //             FROM
    //                 (
    //                 SELECT
    //                         sub2_.*,
    //                         ROW_NUMBER () OVER (ORDER BY CREATED_DATE) as pagination
    //                     FROM
    //                         (
    //                           SELECT kmb.*, deh.kode_sebelum, deh.type_sebelum, deh.kode_setelah, deh.type_setelah, deh.produk, deh.warna_kib
    //                           FROM khs_kib_motor_bensin kmb
    //                           LEFT JOIN khs_daftar_engine_honda deh ON deh.KODE_SEBELUM = kmb.KODE_BARANG
    //                           WHERE
    //                           (
    //                              kmb.palet LIKE '%{$explode}%'
    //                              OR kmb.kode_barang LIKE '%{$explode}%'
    //                              OR kmb.deskripsi LIKE '%{$explode}%'
    //                              OR kmb.type LIKE '%{$explode}%'
    //                              OR serial LIKE '%{$explode}%'
    //                           )
    //                           AND TO_CHAR(created_date, 'YYYY-MM-DD') between '{$range[0]}' and '$range[1]'
    //                           $tipe
    //                         ) sub2_
    //                 ) sub1_
    //             WHERE
    //                 pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
    //         )->result_array();
    //
    //     return $res;
    // }
    //
    // public function countAll($data)
    // {
    //   if (empty($data['tipe'])) {
    //     $tipe = '';
    //   }else {
    //     $tipe = "AND type = '{$data['tipe']}'";
    //   }
    //   $range =  explode(' - ', $data['range_date']);
    //   $explode = strtoupper($data['search']['value']);
    //     return $this->oracle
    //         ->query(
    //             "SELECT
    //                 COUNT(*) AS \"count\"
    //             FROM
    //             (
    //               SELECT serial FROM khs_kib_motor_bensin
    //               WHERE TO_CHAR(created_date, 'YYYY-MM-DD') between '{$range[0]}' and '$range[1]'
    //               $tipe
    //             ) his_proto"
    //         )->row_array();
    // }
    //
    // public function countFiltered($data)
    // {
    //     if (empty($data['tipe'])) {
    //       $tipe = '';
    //     }else {
    //       $tipe = "AND type = '{$data['tipe']}'";
    //     }
    //     $range =  explode(' - ', $data['range_date']);
    //     $explode = strtoupper($data['search']['value']);
    //     return $this->oracle->query("SELECT
    //                 COUNT(*) AS \"count\"
    //             FROM
    //             (
    //               SELECT * FROM khs_kib_motor_bensin
    //               WHERE
    //               (
    //                  palet LIKE '%{$explode}%'
    //                  OR kode_barang LIKE '%{$explode}%'
    //                  OR deskripsi LIKE '%{$explode}%'
    //                  OR type LIKE '%{$explode}%'
    //                  OR serial LIKE '%{$explode}%'
    //               )
    //               AND TO_CHAR(created_date, 'YYYY-MM-DD') between '{$range[0]}' and '$range[1]'
    //               $tipe
    //             )")->row_array();
    // }

    // end server side model


}
