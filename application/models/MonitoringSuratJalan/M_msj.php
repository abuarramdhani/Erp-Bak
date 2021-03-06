<?php
class M_msj extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getMaster()
    {
        $response = $this->oracle->query("SELECT ksi.* FROM khs_sj_internal ksi ORDER BY ksi.NO_SURATJALAN DESC")->result_array();
        return $response;
    }

    public function generateNoSJ()
    {
      $response = $this->oracle->query("SELECT 'SJ'
                         ||to_char(sysdate,'RR')
                         ||to_char(sysdate,'MM')
                         ||lpad(khs_suratjalan_fpb.nextval, 5, '0') no_sj
                  from dual")->result_array();
      return $response;
    }

    public function get($i)
    {
        // $s = $this->personalia->select('seksi')
        //                     ->join('hrd_khs.tseksi', 'hrd_khs.tseksi.kodesie = hrd_khs.tpribadi.kodesie', 'left')
        //                     ->where('noind', $this->session->user)
        //                     ->get('hrd_khs.tpribadi')
        //                     ->row();

        $response = $this->oracle->query("SELECT DISTINCT kki.doc_number,
                CASE
                   WHEN kki.TYPE = 1
                      THEN 'MO'
                   ELSE kki.user_tujuan
                END user_tujuan,
                CASE
                   WHEN kki.TYPE = 1
                      THEN 'MO'
                   ELSE kki.seksi_tujuan
                END seksi_tujuan,
                kki.tujuan,
                CASE
                   WHEN kki.TYPE = 1
                      THEN 'MO'
                   ELSE kki.seksi_kirim
                END seksi_kirim, kki.status,
                CASE
                   WHEN kki.TYPE = 1
                      THEN 'MO'
                   ELSE kki.created_by
                END created_by,
                TO_CHAR (kki.creation_date,
                         'DD-MON-YYYY HH24:MI:SS'
                        ) creation_date,
                CASE
                   WHEN kki.status = 1
                      THEN 'Dipersiapkan Seksi Pengirim'
                   WHEN kki.status = 2
                      THEN 'Diterima Gudang Pengeluaran'
                   WHEN kki.status = 3
                      THEN 'Surat Jalan Telah Dibuat'
                   WHEN kki.status = 4
                      THEN 'Dikirim ke Lokasi Tujuan'
                   WHEN kki.status = 5
                      THEN 'Diterima Gudang Penerimaan'
                   WHEN kki.status = 6
                      THEN 'Diterima Seksi Tujuan'
                END status2
           FROM khs_kirim_internal kki
          WHERE kki.status = '$i'
            AND (   (kki.TYPE = 3 AND kki.flag_approve_aset = 'Y')
                 OR (kki.TYPE <> 3)
                )
       ORDER BY kki.doc_number DESC")->result_array();

        return $response;
    }

    public function Detail($d)
    {
        $sql = "SELECT kki.*,
         CASE
            WHEN kki.status = 1
               THEN 'Dipersiapkan Seksi Pengirim'
            WHEN kki.status = 2
               THEN 'Diterima Gudang Pengeluaran'
            WHEN kki.status = 3
               THEN 'Surat Jalan Telah Dibuat'
            WHEN kki.status = 4
               THEN 'Dikirim ke Lokasi Tujuan'
            WHEN kki.status = 5
               THEN 'Diterima Gudang Penerimaan'
            WHEN kki.status = 6
               THEN 'Diterima Seksi Tujuan'
         END status2
         -- (SELECT ksi.no_suratjalan
         --    FROM khs_sj_internal ksi
         --   WHERE ksi.no_fpb = kki.doc_number) no_surat_jalan
      FROM khs_kirim_internal kki
      WHERE kki.doc_number = '$d'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function Detail_SJ($v)
    {
        $response = $this->oracle->select('NO_FPB')
                               ->where('NO_SURATJALAN', $v)
                               ->order_by('NO_FPB', 'DESC')
                               ->get('KHS_SJ_INTERNAL')
                               ->result_array();
        return $response;
    }

    public function Update2($d)
    {
        $user_login = $this->session->user;
        $this->oracle->query("UPDATE
            KHS_KIRIM_INTERNAL
        SET
            STATUS = '2',
            RECEIVE_DATE = SYSDATE,
            RECEIVED_BY = '$user_login'
        WHERE
            DOC_NUMBER = '$d'
      ");
    }

    public function lastDocumentNumber($value)
    {
        $query = $this->oracle->query("SELECT MAX(SUBSTR(sj.NO_SURATJALAN, -3)) no_sj
                                       FROM  KHS_SJ_INTERNAL sj
                                       WHERE sj.NO_SURATJALAN LIKE '$value%'")->result_array();
        return $query;
    }

    public function UpdateAndInsert($d)
    {
        $user_login = $this->session->user;

        $this->oracle->query("UPDATE
                                  KHS_KIRIM_INTERNAL
                              SET STATUS = '3'
                              WHERE DOC_NUMBER = '$d[nodoc]'
                            ");

       $this->oracle->query("INSERT INTO KHS_SJ_INTERNAL(NO_SURATJALAN
                         ,NO_INDUK
                         ,NAMA_SUPIR
                         ,PLAT_NUMBER
                         ,NO_FPB
                         ,CREATION_DATE
                         ,CREATED_BY
                         ,FLAG_CETAK
                         ,FLAG_CHECK
                         ,DARI
                         ,TUJUAN
                         ,JENIS_KENDARAAN
                       )
        VALUES ('$d[no_sj]'
                ,'$d[sopir_ind]'
                ,'$d[sopir_name]'
                ,'$d[plat]'
                ,'$d[nodoc]'
                , SYSDATE
                ,'$user_login'
                ,'N'
                ,'N'
                ,'$d[dari]'
                ,'$d[ke]'
                ,'$d[jn]')
        ");
    }

    public function Employee($data)
    {
        $sql = "SELECT
                employee_code,
                trim(employee_name) employee_name
              from
                er.er_employee_all
              where
                resign = '0'
                and (employee_code like '%$data%'
                or employee_name like '%$data%')
              order by
                1";
        $response = $this->db->query($sql)->result_array();
        return $response;
    }

    public function getSj()
    {
        $response = $this->oracle->distinct()
                        ->select('NO_SURATJALAN, NAMA_SUPIR, PLAT_NUMBER, JENIS_KENDARAAN, DARI, TUJUAN, PRINT_DATE')
                        ->order_by('NO_SURATJALAN', 'desc')
                        ->get('KHS_SJ_INTERNAL')
                        ->result_array();
        return $response;
    }

    public function getSjRow($doc)
    {
        $response = $this->oracle->distinct()
                        ->select('NO_SURATJALAN, PRINT_DATE')
                        ->where('NO_SURATJALAN', $doc)
                        ->order_by('NO_SURATJALAN', 'desc')
                        ->get('KHS_SJ_INTERNAL')
                        ->result_array();
        return $response;
    }

    public function getEdit($sj)
    {
        $response = $this->oracle->distinct()
                                 ->select('NO_INDUK, NAMA_SUPIR, PLAT_NUMBER')
                                 ->where('NO_SURATJALAN', $sj)
                                 ->get('KHS_SJ_INTERNAL')
                                 ->result_array();
        return $response;
    }

    public function updateSJ($data, $sj)
    {
        $this->oracle->where('NO_SURATJALAN', $sj)
                   ->update('KHS_SJ_INTERNAL', $data);

        // $this->oracle->delete('KHS_SJ_INTERNAL', ['NO_SURATJALAN' => $sj]);

        return 1;
    }


    public function getFPB($sj)
    {
        $response = $this->oracle->select('NO_FPB')
                             ->where('NO_SURATJALAN', $sj)
                             ->order_by('NO_FPB', 'asc')
                             ->get('KHS_SJ_INTERNAL')
                             ->result_array();
       // echo "<pre>";
       // print_r($response);die;

        function custom($value)
        {
          if (!empty($value)) {
            foreach ($value as $key => $v) {
                $a[] = $v['ITEM_TYPE'];
            }
            return implode(" / ", $a);
          }
        }

        if (!empty($response)) {
            foreach ($response as $key => $fpb) {
                $responses = $this->oracle->distinct()
                                    ->select('DOC_NUMBER, ITEM_TYPE, KETERANGAN')
                                    ->where('DOC_NUMBER', $fpb['NO_FPB'])
                                    ->order_by('DOC_NUMBER', 'asc')
                                    ->get('KHS_KIRIM_INTERNAL')
                                    ->result_array();
                if (!empty($responses)) {
                  $data['DOC_CUSTOM'] = $responses[0]['DOC_NUMBER'];
                  $data['KETERANGAN'] = $responses[0]['KETERANGAN'];
                  $data['ITEM_CUSTOM'] = custom($responses);
                  $done[] = $data;
                }
            }

            $final['Header'] = $this->oracle->distinct()
                               ->select('NO_SURATJALAN, PLAT_NUMBER, to_char(PRINT_DATE,\'DD-MON-YYYY HH24:MI:SS\') PRINT_DATE, FLAG_CETAK, NAMA_SUPIR, DARI, TUJUAN, JENIS_KENDARAAN')
                               ->where('NO_SURATJALAN', $sj)
                               ->get('KHS_SJ_INTERNAL')
                               ->result_array();

            $final['Item']   = !empty($done) ? $done : [];

            return $final;
        }
    }

    public function updatePrintDate($d)
    {
      $this->oracle->query("UPDATE
          KHS_SJ_INTERNAL
      SET PRINT_DATE = SYSDATE
      WHERE NO_SURATJALAN = '$d'
    ");
    }

    public function updateCetak($d)
    {
      $this->oracle->query("UPDATE
            KHS_SJ_INTERNAL
        SET FLAG_CETAK = 'Y'
        WHERE NO_SURATJALAN = '$d'
      ");

        $response = $this->oracle->select('NO_FPB')
                               ->where('NO_SURATJALAN', $d)
                               ->get('KHS_SJ_INTERNAL')
                               ->result_array();

        foreach ($response as $key => $d) {
            $this->oracle->query("UPDATE
              KHS_KIRIM_INTERNAL
          SET STATUS = '4'
          WHERE DOC_NUMBER = '$d[NO_FPB]'
          AND STATUS = '3'
        ");
        }
    }

    public function selectSJ($data)
    {
      $explode = strtoupper($data['search']['value']);
        $res = $this->oracle
            ->query(
                "SELECT kdav.*
                FROM
                    (
                    SELECT
                            skdav.*,
                            ROW_NUMBER () OVER (ORDER BY NO_SURATJALAN DESC) as pagination
                        FROM
                            (
                              SELECT ksi.*
                              FROM
                                  (SELECT DISTINCT NO_SURATJALAN, NAMA_SUPIR, PLAT_NUMBER, JENIS_KENDARAAN, DARI, TUJUAN, PRINT_DATE
                                          FROM KHS_SJ_INTERNAL
                                          ORDER BY NO_SURATJALAN DESC) ksi
                              WHERE
                                    (
                                      NO_SURATJALAN LIKE '%{$explode}%'
                                      OR NAMA_SUPIR LIKE '%{$explode}%'
                                      OR PLAT_NUMBER LIKE '%{$explode}%'
                                      OR DARI LIKE '%{$explode}%'
                                      OR TUJUAN LIKE '%{$explode}%'
                                    )
                            ) skdav

                    ) kdav
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();

        return $res;
    }

    public function countAllSJ()
    {
        return $this->oracle
            ->query(
                "SELECT
                    COUNT(*) AS \"count\"
                FROM
                (SELECT DISTINCT NO_SURATJALAN, NAMA_SUPIR, PLAT_NUMBER, JENIS_KENDARAAN, DARI, TUJUAN, PRINT_DATE
                        FROM KHS_SJ_INTERNAL
                        ORDER BY NO_SURATJALAN) ksi"
            )->row_array();
    }

    public function countFilteredSJ($data)
    {
        $explode = strtoupper($data['search']['value']);

        return $this->oracle->query(
            "SELECT
                    COUNT(*) AS \"count\"
                FROM
                (SELECT DISTINCT NO_SURATJALAN, NAMA_SUPIR, PLAT_NUMBER, JENIS_KENDARAAN, DARI, TUJUAN, PRINT_DATE
                        FROM KHS_SJ_INTERNAL
                        ORDER BY NO_SURATJALAN DESC) ksi
                        WHERE
                         (
                           NO_SURATJALAN LIKE '%{$explode}%'
                           OR NAMA_SUPIR LIKE '%{$explode}%'
                           OR PLAT_NUMBER LIKE '%{$explode}%'
                           OR DARI LIKE '%{$explode}%'
                           OR TUJUAN LIKE '%{$explode}%'
                         )"
        )->row_array();
    }

}
