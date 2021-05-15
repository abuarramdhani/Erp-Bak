<?php
class M_laporanPenjualanTraktor extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    // query mengambil data tanggal
    public function getHeader()
    {
        $query = $this->oracle->query("SELECT DISTINCT tanggal, to_char(to_date(bulan, 'MM'), 'Month') bulan
                                        FROM khs_lpb_hari kl
                                        WHERE request_id = (SELECT MAX (request_id) FROM khs_lpb_hari)
                                        ORDER BY 1
                                        ");
        return $query->result_array();
    }

    // query mengambil data laporan penjualan per hari
    public function getDaily()
    {
        $query = $this->oracle->query("SELECT DISTINCT
                                            urutan, cabang,
                                            sum(satu) over (partition by cabang) satu,
                                            sum(dua) over (partition by cabang) dua,
                                            sum(tiga) over (partition by cabang) tiga,
                                            sum(empat) over (partition by cabang) empat,
                                            sum(lima) over (partition by cabang) lima,
                                            sum(enam) over (partition by cabang) enam,
                                            sum(tujuh) over (partition by cabang) tujuh,
                                            sum(delapan) over (partition by cabang) delapan,
                                            sum(sembilan) over (partition by cabang) sembilan,
                                            sum(sepuluh) over (partition by cabang) sepuluh,
                                            (select distinct
                                                sum(klt.quantity) over (partition by cabang) total
                                            from
                                                khs_lpb_type klt
                                            where
                                                klt.request_id = (select max(request_id) from khs_lpb_type)
                                                and klt.status = 'TOTAL'
                                                and klt.cabang = tab.cabang) total
                                        FROM
                                        (SELECT
                                            urutan, cabang,
                                            (select quantity from dual where lines = 1) satu,
                                            (select quantity from dual where lines = 2) dua,
                                            (select quantity from dual where lines = 3) tiga,
                                            (select quantity from dual where lines = 4) empat,
                                            (select quantity from dual where lines = 5) lima,
                                            (select quantity from dual where lines = 6) enam,
                                            (select quantity from dual where lines = 7) tujuh,
                                            (select quantity from dual where lines = 8) delapan,
                                            (select quantity from dual where lines = 9) sembilan,
                                            (select quantity from dual where lines = 10) sepuluh
                                        FROM
                                        (SELECT klt.urutan, klt.tanggal, klt.bulan, klt.tahun, klt.cabang, klt.quantity,
                                            ROWNUM - (10 * (urutan - 1)) lines
                                        FROM (SELECT   CASE
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
                                                        END urutan,
                                                        kl.*
                                                    FROM khs_lpb_hari kl
                                                WHERE request_id = (SELECT MAX (request_id)
                                                                        FROM khs_lpb_hari)
                                                ORDER BY 1, tanggal) klt))tab
                                        order by 1");
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
        $query = $this->oracle->query("SELECT count(*) AS JUMLAH_HARI from
                                            (SELECT to_date('01/' || to_char(SYSDATE, 'mm/yyyy'),'dd/mm/yyyy') + level - 1 TANGGAL,
                                                to_char(to_date('01/' || to_char(to_date(SYSDATE, 'DD/MM/YYYY'), 'mm/yyyy'),'dd/mm/yyyy') + level - 1, 'fmday') hari
                                        FROM DUAL
                                        CONNECT BY LEVEL < TO_NUMBER(TO_CHAR(to_date(SYSDATE, 'DD/MM/YYYY'), 'DD')))
                                        WHERE hari != 'sunday'
                                        ");
        return $query->row_array();
    }
}