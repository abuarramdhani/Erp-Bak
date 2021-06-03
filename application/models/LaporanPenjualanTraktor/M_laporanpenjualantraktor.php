<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_laporanpenjualantraktor extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    // query mengambil data tanggal
    public function getHeader()
    {
        $query = $this->oracle->query("SELECT   ROWNUM urutan, tab.*
        FROM (SELECT DISTINCT CASE
                                 WHEN TO_NUMBER (bulan) =
                                        EXTRACT
                                           (MONTH FROM khs_lpb_range_date (NULL,
                                                                           2)
                                           )
                                    THEN TO_CHAR (tanggal)
                                 ELSE '-'
                              END tanggal,
                              CASE
                                 WHEN TO_NUMBER (bulan) =
                                        EXTRACT
                                           (MONTH FROM khs_lpb_range_date (NULL,
                                                                           2)
                                           )
                                    THEN TO_CHAR (TO_DATE (bulan, 'MM'), 'Month')
                                 ELSE '-'
                              END bulan,
                              tahun, TO_NUMBER (bulan), TO_NUMBER (tanggal)
                         FROM khs_lpb_hari kl
                        WHERE request_id = (SELECT MAX (request_id)
                                              FROM khs_lpb_hari)
                     ORDER BY 4, 5) tab
    ORDER BY 5, 6");
        return $query->result_array();
    }

    // query mengambil data laporan penjualan per hari
    public function getDaily()
    {
        $query = $this->oracle->query("WITH data_header AS
        (SELECT   ROWNUM urutan, tab.*
            FROM (SELECT DISTINCT CASE
                                     WHEN TO_NUMBER (bulan) =
                                            EXTRACT
                                               (MONTH FROM khs_lpb_range_date (NULL,
                                                                               2)
                                               )
                                        THEN TO_CHAR (tanggal)
                                     ELSE '-'
                                  END tanggal,
                                  CASE
                                     WHEN TO_NUMBER (bulan) =
                                            EXTRACT
                                               (MONTH FROM khs_lpb_range_date (NULL,
                                                                               2)
                                               )
                                        THEN TO_CHAR (TO_DATE (bulan, 'MM'), 'Month')
                                     ELSE '-'
                                  END bulan,
                                  tahun, TO_NUMBER (bulan), TO_NUMBER (tanggal)
                             FROM khs_lpb_hari kl
                            WHERE request_id = (SELECT MAX (request_id)
                                                  FROM khs_lpb_hari)
                         ORDER BY 4, 5) tab
        ORDER BY 5, 6)
        SELECT DISTINCT urutan, cabang,
                        case when (select tanggal from data_header where urutan = 1) = '-' then
                             '-' else to_char(SUM (satu) OVER (PARTITION BY cabang))
                        end satu,
                        case when (select tanggal from data_header where urutan = 2) = '-' then
                            '-' else to_char(SUM (dua) OVER (PARTITION BY cabang))
                        end dua,
                        case when (select tanggal from data_header where urutan = 3) = '-' then
                            '-' else to_char(SUM (tiga) OVER (PARTITION BY cabang))
                        end tiga,
                        case when (select tanggal from data_header where urutan = 4) = '-' then
                            '-' else to_char(SUM (empat) OVER (PARTITION BY cabang))
                        end empat,
                        case when (select tanggal from data_header where urutan = 5) = '-' then
                            '-' else to_char(SUM (lima) OVER (PARTITION BY cabang))
                        end lima,
                        case when (select tanggal from data_header where urutan = 6) = '-' then
                            '-' else to_char(SUM (enam) OVER (PARTITION BY cabang))
                        end enam,
                        case when (select tanggal from data_header where urutan = 7) = '-' then
                            '-' else to_char(SUM (tujuh) OVER (PARTITION BY cabang))
                        end tujuh,
                        case when (select tanggal from data_header where urutan = 8) = '-' then
                            '-' else to_char(SUM (delapan) OVER (PARTITION BY cabang))
                        end delapan,
                        case when (select tanggal from data_header where urutan = 9) = '-' then
                            '-' else to_char(SUM (sembilan) OVER (PARTITION BY cabang))
                        end sembilan,
                        case when (select tanggal from data_header where urutan = 10) = '-' then
                            '-' else to_char(SUM (sepuluh) OVER (PARTITION BY cabang))
                        end sepuluh,
                        (SELECT DISTINCT SUM (klt.quantity) OVER (PARTITION BY cabang) total
                                    FROM khs_lpb_type klt
                                   WHERE klt.request_id =(SELECT MAX (request_id) FROM khs_lpb_type)
                                     AND klt.status = 'TOTAL' AND klt.cabang = tab.cabang) total
                   FROM (SELECT urutan, cabang, (SELECT quantity FROM DUAL WHERE lines = 1) satu,
                                (SELECT quantity FROM DUAL WHERE lines = 2) dua, 
                                (SELECT quantity FROM DUAL WHERE lines = 3) tiga,
                                (SELECT quantity FROM DUAL WHERE lines = 4) empat, 
                                (SELECT quantity FROM DUAL WHERE lines = 5) lima,
                                (SELECT quantity FROM DUAL WHERE lines = 6) enam, 
                                (SELECT quantity FROM DUAL WHERE lines = 7) tujuh,
                                (SELECT quantity FROM DUAL WHERE lines = 8) delapan,
                                (SELECT quantity FROM DUAL WHERE lines = 9) sembilan,
                                (SELECT quantity FROM DUAL WHERE lines = 10) sepuluh
                           FROM (SELECT klt.urutan, klt.tanggal, klt.bulan, klt.tahun,
                                        klt.cabang, klt.quantity, ROWNUM - (10 * (urutan - 1)) lines
                                   FROM (SELECT   CASE
                                                     WHEN cabang = 'MKS' THEN 1
                                                     WHEN cabang = 'GJK' THEN 2
                                                     WHEN cabang = 'YGY' THEN 3
                                                     WHEN cabang = 'JKT' THEN 4
                                                     WHEN cabang = 'TJK' THEN 5
                                                     WHEN cabang = 'MDN' THEN 6
                                                     WHEN cabang = 'PLU' THEN 7
                                                     WHEN cabang = 'PKU' THEN 8
                                                     WHEN cabang = 'PNK' THEN 9
                                                     WHEN cabang = 'BJM' THEN 10
                                                     WHEN cabang = 'EKSPOR' THEN 11
                                                  END urutan, kl.*,
                                                  to_number(tanggal), to_number(bulan)
                                             FROM khs_lpb_hari kl
                                            WHERE request_id = (SELECT MAX (request_id)FROM khs_lpb_hari)
                                         ORDER BY 1, 9, 8) klt)) tab ORDER BY 1");
        return $query->result_array();
    }

    // query mengambil data laporan penjualan per tipe
    public function getType($status)
    {
        $query = $this->oracle->query("SELECT tab.*,
                                            (AAH0 + AAB0 + AAG0 + AAE0 + AAC0 + ACA0 + ACC0 + AAK0 + AAL0 + AAN0 + ADA0 + ADB0 + ADC0 + ADD0) TOTAL
                                        FROM
                                        (SELECT DISTINCT
                                            URUTAN_CABANG, CABANG,
                                            sum(AAH0) over (partition by cabang) AAH0,
                                            sum(AAB0) over (partition by cabang) AAB0,
                                            sum(AAG0) over (partition by cabang) AAG0,
                                            sum(AAE0) over (partition by cabang) AAE0,
                                            sum(AAC0) over (partition by cabang) AAC0,
                                            sum(ACA0) over (partition by cabang) ACA0,
                                            sum(ACC0) over (partition by cabang) ACC0,
                                            sum(AAK0) over (partition by cabang) AAK0,
                                            sum(AAL0) over (partition by cabang) AAL0,
                                            sum(AAN0) over (partition by cabang) AAN0,
                                            sum(ADA0) over (partition by cabang) ADA0,
                                            sum(ADB0) over (partition by cabang) ADB0,
                                            sum(ADC0) over (partition by cabang) ADC0,
                                            sum(ADD0) over (partition by cabang) ADD0
                                        FROM
                                        (SELECT
                                            URUTAN_CABANG, CABANG,
                                            (select quantity from dual where item = 'AAH0') AAH0,
                                            (select quantity from dual where item = 'AAB0') AAB0,
                                            (select quantity from dual where item = 'AAG0') AAG0,
                                            (select quantity from dual where item = 'AAE0') AAE0,
                                            (select quantity from dual where item = 'AAC0') AAC0,
                                            (select quantity from dual where item = 'ACA0') ACA0,
                                            (select quantity from dual where item = 'ACC0') ACC0,
                                            (select quantity from dual where item = 'AAK0') AAK0,
                                            (select quantity from dual where item = 'AAL0') AAL0,
                                            (select quantity from dual where item = 'AAN0') AAN0,
                                            (select quantity from dual where item = 'ADA0') ADA0,
                                            (select quantity from dual where item = 'ADB0') ADB0,
                                            (select quantity from dual where item = 'ADC0') ADC0,
                                            (select quantity from dual where item = 'ADD0') ADD0
                                        FROM
                                        (SELECT   cabang, item, quantity,
                                                CASE
                                                    WHEN item = 'AAH0'
                                                    THEN 1
                                                    WHEN item = 'AAB0'
                                                    THEN 2
                                                    WHEN item = 'AAG0'
                                                    THEN 3
                                                    WHEN item = 'AAE0'
                                                    THEN 4
                                                    WHEN item = 'AAC0'
                                                    THEN 5
                                                    WHEN item = 'ACA0'
                                                    THEN 6
                                                    WHEN item = 'ACC0'
                                                    THEN 7
                                                    WHEN item = 'AAK0'
                                                    THEN 8
                                                    WHEN item = 'AAL0'
                                                    THEN 9
                                                    WHEN item = 'AAN0'
                                                    THEN 10
                                                    WHEN item = 'ADA0'
                                                    THEN 11
                                                    WHEN item = 'ADB0'
                                                    THEN 12
                                                    WHEN item = 'ADC0'
                                                    THEN 13
                                                    WHEN item = 'ADD0'
                                                    THEN 14
                                                END urutan_item,
                                                CASE
                                                    WHEN cabang = 'MKS'
                                                    THEN 1
                                                    WHEN cabang = 'GJK'
                                                    THEN 2
                                                    WHEN cabang = 'YGY'
                                                    THEN 3
                                                    WHEN cabang = 'JKT'
                                                    THEN 4
                                                    WHEN cabang = 'TJK'
                                                    THEN 5
                                                    WHEN cabang = 'MDN'
                                                    THEN 6
                                                    WHEN cabang = 'PLU'
                                                    THEN 7
                                                    WHEN cabang = 'PKU'
                                                    THEN 8
                                                    WHEN cabang = 'PNK'
                                                    THEN 9
                                                    WHEN cabang = 'BJM'
                                                    THEN 10
                                                    WHEN cabang = 'EKSPOR'
                                                    THEN 11
                                                END urutan_cabang
                                            FROM khs_lpb_type
                                        WHERE request_id = (SELECT MAX (request_id)
                                                                FROM khs_lpb_type) AND status = '$status' --'TOTAL'
                                        ORDER BY 5, 4))) tab
                                        ORDER BY 1");
        return $query->result_array();
    }

    // query menghitung jumlah hari dari tanggal pertama bulan ini sampai tanggal sekarang
    public function getCalcDate()
    {
        $query = $this->oracle->query("SELECT COUNT (*)
                                            - (SELECT COUNT (*)
                                                    FROM khs_lpb_skip_date
                                                WHERE EXTRACT (MONTH FROM skip_date) = EXTRACT (MONTH FROM khs_lpb_range_date (NULL, 2))) JUMLAH_HARI
                                        FROM (SELECT       TO_DATE ('01/' || TO_CHAR (khs_lpb_range_date(null, 2), 'mm/yyyy'),
                                                                    'dd/mm/yyyy'
                                                                    )
                                                        + LEVEL
                                                        - 1 tanggal,
                                                        TO_CHAR (  TO_DATE ('01/' || TO_CHAR (khs_lpb_range_date(null, 2), 'mm/yyyy'),
                                                                            'dd/mm/yyyy'
                                                                            )
                                                                    + LEVEL
                                                                    - 1,
                                                                    'fmday'
                                                                ) hari
                                                    FROM DUAL
                                                CONNECT BY LEVEL <= TO_NUMBER (TO_CHAR (khs_lpb_range_date(null, 2), 'DD')))
                                        WHERE hari != 'sunday'
                                        GROUP BY 1
                                        ");
        return $query->row_array();
    }

    //query meengitung jumlah hari kerja bulan ini
    public function getCountDayWorkMonth()
    {
        $query = $this->oracle->query("SELECT COUNT (*)
                                            - (SELECT COUNT (*)
                                                    FROM khs_lpb_skip_date
                                                WHERE EXTRACT (MONTH FROM skip_date) = EXTRACT (MONTH FROM khs_lpb_range_date(null, 2))) JUMLAH_HARI
                                        FROM (SELECT       TO_DATE ('01/' || TO_CHAR (khs_lpb_range_date(null, 2), 'mm/yyyy'),
                                                                    'dd/mm/yyyy'
                                                                    )
                                                        + LEVEL
                                                        - 1 tanggal,
                                                        TO_CHAR (  TO_DATE ('01/' || TO_CHAR (khs_lpb_range_date(null, 2), 'mm/yyyy'),
                                                                            'dd/mm/yyyy'
                                                                            )
                                                                    + LEVEL
                                                                    - 1,
                                                                    'fmday'
                                                                ) hari
                                                    FROM DUAL
                                                CONNECT BY LEVEL <= TO_NUMBER (TO_CHAR (LAST_DAY (khs_lpb_range_date(null, 2)), 'DD')))
                                        WHERE hari != 'sunday'
                                        GROUP BY 1");
        return $query->row_array();
    }

    //query mengambil data tanggal libur bulan ini
    public function getSkipDate($date)
    {
        $query = $this->oracle->query("SELECT DATE_ID,
                                            TO_CHAR(SKIP_DATE, 'dd') AS TANGGAL,
                                            NOTES
                                        FROM KHS_LPB_SKIP_DATE
                                        WHERE TO_CHAR(SKIP_DATE, 'mm-yyyy') = '$date'
                                        ORDER BY TANGGAL");
        return $query->result_array();
    }

    //query menambahkan data tanggal libur ke database
    public function insertDate($date, $notes)
    {
        $this->oracle->query("INSERT INTO KHS_LPB_SKIP_DATE VALUES('',TO_DATE('$date','DD-MM-YYYY'),'$notes')");
    }

    //query mengahpus tanggal
    public function deleteDate($id)
    {
        $this->oracle->query("DELETE FROM KHS_LPB_SKIP_DATE WHERE DATE_ID = '$id'");
    }
}