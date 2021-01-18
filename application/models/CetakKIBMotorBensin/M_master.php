<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', true);
    }

    public function getItem($range_, $tipe)
    {
      $range =  explode(' - ', $range_);
      return $this->oracle->query("SELECT * FROM khs_kib_motor_bensin
                                   WHERE TO_CHAR(created_date, 'YYYY-MM-DD') between '{$range[0]}' and '{$range[1]}'
                                   AND TYPE = '$tipe'")->result_array();
    }

    public function getType($value='')
    {
      return $this->oracle->query('SELECT DISTINCT type FROM khs_kib_motor_bensin')->result_array();
    }

    // start server side on model
    public function selectMaster($data)
    {
      if (empty($data['tipe'])) {
        $tipe = '';
      }else {
        $tipe = "AND type = '{$data['tipe']}'";
      }
      $range =  explode(' - ', $data['range_date']);
      $explode = strtoupper($data['search']['value']);
        $res = $this->oracle
            ->query(
                "SELECT sub1_.*
                FROM
                    (
                    SELECT
                            sub2_.*,
                            ROW_NUMBER () OVER (ORDER BY CREATED_DATE) as pagination
                        FROM
                            (
                              SELECT * FROM khs_kib_motor_bensin
                              WHERE
                              (
                                 palet LIKE '%{$explode}%'
                                 OR kode_barang LIKE '%{$explode}%'
                                 OR deskripsi LIKE '%{$explode}%'
                                 OR type LIKE '%{$explode}%'
                                 OR serial LIKE '%{$explode}%'
                              )
                              AND TO_CHAR(created_date, 'YYYY-MM-DD') between '{$range[0]}' and '$range[1]'
                              $tipe
                            ) sub2_
                    ) sub1_
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();

        return $res;
    }

    public function countAll($data)
    {
      if (empty($data['tipe'])) {
        $tipe = '';
      }else {
        $tipe = "AND type = '{$data['tipe']}'";
      }
      $range =  explode(' - ', $data['range_date']);
      $explode = strtoupper($data['search']['value']);
        return $this->oracle
            ->query(
                "SELECT
                    COUNT(*) AS \"count\"
                FROM
                (
                  SELECT serial FROM khs_kib_motor_bensin
                  WHERE TO_CHAR(created_date, 'YYYY-MM-DD') between '{$range[0]}' and '$range[1]'
                  $tipe
                ) his_proto"
            )->row_array();
    }

    public function countFiltered($data)
    {
        if (empty($data['tipe'])) {
          $tipe = '';
        }else {
          $tipe = "AND type = '{$data['tipe']}'";
        }
        $range =  explode(' - ', $data['range_date']);
        $explode = strtoupper($data['search']['value']);
        return $this->oracle->query("SELECT
                    COUNT(*) AS \"count\"
                FROM
                (
                  SELECT * FROM khs_kib_motor_bensin
                  WHERE
                  (
                     palet LIKE '%{$explode}%'
                     OR kode_barang LIKE '%{$explode}%'
                     OR deskripsi LIKE '%{$explode}%'
                     OR type LIKE '%{$explode}%'
                     OR serial LIKE '%{$explode}%'
                  )
                  AND TO_CHAR(created_date, 'YYYY-MM-DD') between '{$range[0]}' and '$range[1]'
                  $tipe
                )")->row_array();
    }

    // end server side model


}
