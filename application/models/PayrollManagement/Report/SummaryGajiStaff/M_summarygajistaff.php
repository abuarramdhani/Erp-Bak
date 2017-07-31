<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_summarygajistaff extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve salaries by department
        function get_salaries_by_dept($year, $month)
        {
            $sql = "
                WITH tabel_pembayaran_penggajian AS (
                    SELECT *
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year
                        AND EXTRACT(MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                ), tabel_per_department AS (
                    SELECT pr.pr_master_pekerja.nama as nama,
                        CASE
                            WHEN pr.pr_master_pekerja.kodesie LIKE '1%' THEN 'KEUANGAN'
                            WHEN pr.pr_master_pekerja.kodesie LIKE '2%' THEN 'PEMASARAN'
                            WHEN pr.pr_master_pekerja.kodesie LIKE '3%' THEN 'PRODUKSI'
                            WHEN pr.pr_master_pekerja.kodesie LIKE '4%' THEN 'PERSONALIA'
                        END AS department,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.gaji_pokok, '') AS NUMERIC), 0) AS gaji_pokok,
                        CAST(COALESCE(NULLIF(tabel_pembayaran_penggajian.t_if, ''),
                            NULLIF(tabel_pembayaran_penggajian.t_ikr, ''), '0') AS NUMERIC) AS i_f,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ikmhl, '') AS NUMERIC), 0) AS i_kmhl,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ip, '') AS NUMERIC), 0) AS i_p,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ik, '') AS NUMERIC), 0) AS i_k,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ims, '') AS NUMERIC), 0) AS i_ms,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_imm, '') AS NUMERIC), 0) AS i_mm,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_lembur, '') AS NUMERIC), 0) AS lembur,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ubt, '') AS NUMERIC), 0) AS ubt,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_upamk, '') AS NUMERIC), 0) AS upamk,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_bln_lalu, '') AS NUMERIC), 0) AS klaim_bln_lalu,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_pengangkatan, '') AS NUMERIC), 0) AS klaim_pengangkatan,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.konpensasi_lembur, '') AS NUMERIC), 0) AS konpensasi_lembur,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_htm, '') AS NUMERIC), 0) AS pot_htm,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_sakit_berkepanjangan, '') AS NUMERIC), 0) AS pot_sakit_lama,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal_dibayarkan, '') AS NUMERIC), 0) AS subtotal_dibayarkan,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_sdh_byr, '') AS NUMERIC), 0) AS klaim_sdh_byr,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pajak, '') AS NUMERIC), 0) AS tamb_subs_pajak,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal1, '') AS NUMERIC), 0) AS subtotal1,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_sdh_byr, '') AS NUMERIC), 0) AS pot_klaim_sdh_byr,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pajak, '') AS NUMERIC), 0) AS pot_subs_pajak,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal2, '') AS NUMERIC), 0) AS subtotal2,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_jht, '') AS NUMERIC), 0) AS pot_jht,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_jkn, '') AS NUMERIC), 0) AS pot_jkn,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_kop, '') AS NUMERIC), 0) AS pot_kop,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.putang, '') AS NUMERIC), 0) AS pot_utang,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pduka, '') AS NUMERIC), 0) AS pot_duka,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pspsi, '') AS NUMERIC), 0) AS pot_spsi,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_pensiun, '') AS NUMERIC), 0) AS pot_pensiun,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.btransfer, '') AS NUMERIC), 0) AS pot_transfer,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal3, '') AS NUMERIC), 0) AS thp
                    FROM pr.pr_master_pekerja
                    LEFT JOIN tabel_pembayaran_penggajian
                        ON pr.pr_master_pekerja.noind = tabel_pembayaran_penggajian.noind
                )
                SELECT CASE
                        WHEN tabel_per_department.department = 'KEUANGAN' THEN 1
                        WHEN tabel_per_department.department = 'PEMASARAN' THEN 2
                        WHEN tabel_per_department.department = 'PRODUKSI' THEN 3
                        WHEN tabel_per_department.department = 'PERSONALIA' THEN 4
                    END AS kode,
                    tabel_per_department.department, 
                    SUM(tabel_per_department.gaji_pokok) AS gaji_pokok,
                    SUM(tabel_per_department.i_f) AS i_f,
                    SUM(tabel_per_department.i_kmhl) AS i_kmhl,
                    SUM(tabel_per_department.i_p) AS i_p,
                    SUM(tabel_per_department.i_k) AS i_k,
                    SUM(tabel_per_department.i_ms) AS i_ms,
                    SUM(tabel_per_department.i_mm) AS i_mm,
                    SUM(tabel_per_department.lembur) AS lembur,
                    SUM(tabel_per_department.ubt) AS ubt,
                    SUM(tabel_per_department.upamk) AS upamk,
                    SUM(tabel_per_department.klaim_bln_lalu) AS klaim_bln_lalu,
                    SUM(tabel_per_department.klaim_pengangkatan) AS klaim_pengangkatan,
                    SUM(tabel_per_department.konpensasi_lembur) AS konpensasi_lembur,
                    SUM(tabel_per_department.pot_htm) AS pot_htm,
                    SUM(tabel_per_department.pot_sakit_lama) AS pot_sakit_lama,
                    SUM(tabel_per_department.subtotal_dibayarkan) AS subtotal_dibayarkan,
                    SUM(tabel_per_department.klaim_sdh_byr) AS klaim_sdh_byr,
                    SUM(tabel_per_department.tamb_subs_pajak) AS tamb_subs_pajak,
                    SUM(tabel_per_department.subtotal1) AS subtotal1,
                    SUM(tabel_per_department.pot_klaim_sdh_byr) AS pot_klaim_sdh_byr,
                    SUM(tabel_per_department.pot_subs_pajak) AS pot_subs_pajak,
                    SUM(tabel_per_department.subtotal2) AS subtotal2,
                    SUM(tabel_per_department.pot_jht) AS pot_jht,
                    SUM(tabel_per_department.pot_jkn) AS pot_jkn,
                    SUM(tabel_per_department.pot_kop) AS pot_kop,
                    SUM(tabel_per_department.pot_utang) AS pot_utang,
                    SUM(tabel_per_department.pot_duka) AS pot_duka,
                    SUM(tabel_per_department.pot_spsi) AS pot_spsi,
                    SUM(tabel_per_department.pot_pensiun) AS pot_pensiun,
                    SUM(tabel_per_department.pot_transfer) AS pot_transfer,
                    SUM(tabel_per_department.thp) AS thp
                FROM tabel_per_department
                GROUP BY tabel_per_department.department
                ORDER BY kode
            ";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        // Retrieve sum of every salary component
        function get_total($year, $month)
        {
            $sql = "
                WITH tabel_pembayaran_penggajian AS (
                    SELECT *
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year
                        AND EXTRACT(MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                ), tabel_per_department AS (
                    SELECT pr.pr_master_pekerja.nama as nama,
                        CASE
                            WHEN pr.pr_master_pekerja.kodesie LIKE '1%' THEN 'KEUANGAN'
                            WHEN pr.pr_master_pekerja.kodesie LIKE '2%' THEN 'PEMASARAN'
                            WHEN pr.pr_master_pekerja.kodesie LIKE '3%' THEN 'PRODUKSI'
                            WHEN pr.pr_master_pekerja.kodesie LIKE '4%' THEN 'PERSONALIA'
                        END AS department,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.gaji_pokok, '') AS NUMERIC), 0) AS gaji_pokok,
                        CAST(COALESCE(NULLIF(tabel_pembayaran_penggajian.t_if, ''),
                            NULLIF(tabel_pembayaran_penggajian.t_ikr, ''), '0') AS NUMERIC) AS i_f,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ikmhl, '') AS NUMERIC), 0) AS i_kmhl,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ip, '') AS NUMERIC), 0) AS i_p,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ik, '') AS NUMERIC), 0) AS i_k,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ims, '') AS NUMERIC), 0) AS i_ms,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_imm, '') AS NUMERIC), 0) AS i_mm,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_lembur, '') AS NUMERIC), 0) AS lembur,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_ubt, '') AS NUMERIC), 0) AS ubt,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.t_upamk, '') AS NUMERIC), 0) AS upamk,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_bln_lalu, '') AS NUMERIC), 0) AS klaim_bln_lalu,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_pengangkatan, '') AS NUMERIC), 0) AS klaim_pengangkatan,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.konpensasi_lembur, '') AS NUMERIC), 0) AS konpensasi_lembur,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_htm, '') AS NUMERIC), 0) AS pot_htm,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_sakit_berkepanjangan, '') AS NUMERIC), 0) AS pot_sakit_lama,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal_dibayarkan, '') AS NUMERIC), 0) AS subtotal_dibayarkan,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_sdh_byr, '') AS NUMERIC), 0) AS klaim_sdh_byr,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pajak, '') AS NUMERIC), 0) AS tamb_subs_pajak,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal1, '') AS NUMERIC), 0) AS subtotal1,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.klaim_sdh_byr, '') AS NUMERIC), 0) AS pot_klaim_sdh_byr,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pajak, '') AS NUMERIC), 0) AS pot_subs_pajak,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal2, '') AS NUMERIC), 0) AS subtotal2,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_jht, '') AS NUMERIC), 0) AS pot_jht,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_jkn, '') AS NUMERIC), 0) AS pot_jkn,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_kop, '') AS NUMERIC), 0) AS pot_kop,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.putang, '') AS NUMERIC), 0) AS pot_utang,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pduka, '') AS NUMERIC), 0) AS pot_duka,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pspsi, '') AS NUMERIC), 0) AS pot_spsi,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.pot_pensiun, '') AS NUMERIC), 0) AS pot_pensiun,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.btransfer, '') AS NUMERIC), 0) AS pot_transfer,
                        COALESCE(CAST(NULLIF(tabel_pembayaran_penggajian.subtotal3, '') AS NUMERIC), 0) AS thp
                    FROM pr.pr_master_pekerja
                    LEFT JOIN tabel_pembayaran_penggajian
                        ON pr.pr_master_pekerja.noind = tabel_pembayaran_penggajian.noind
                )
                SELECT SUM(tabel_per_department.gaji_pokok) AS gaji_pokok,
                    SUM(tabel_per_department.i_f) AS i_f,
                    SUM(tabel_per_department.i_kmhl) AS i_kmhl,
                    SUM(tabel_per_department.i_p) AS i_p,
                    SUM(tabel_per_department.i_k) AS i_k,
                    SUM(tabel_per_department.i_ms) AS i_ms,
                    SUM(tabel_per_department.i_mm) AS i_mm,
                    SUM(tabel_per_department.lembur) AS lembur,
                    SUM(tabel_per_department.ubt) AS ubt,
                    SUM(tabel_per_department.upamk) AS upamk,
                    SUM(tabel_per_department.klaim_bln_lalu) AS klaim_bln_lalu,
                    SUM(tabel_per_department.klaim_pengangkatan) AS klaim_pengangkatan,
                    SUM(tabel_per_department.konpensasi_lembur) AS konpensasi_lembur,
                    SUM(tabel_per_department.pot_htm) AS pot_htm,
                    SUM(tabel_per_department.pot_sakit_lama) AS pot_sakit_lama,
                    SUM(tabel_per_department.subtotal_dibayarkan) AS subtotal_dibayarkan,
                    SUM(tabel_per_department.klaim_sdh_byr) AS klaim_sdh_byr,
                    SUM(tabel_per_department.tamb_subs_pajak) AS tamb_subs_pajak,
                    SUM(tabel_per_department.subtotal1) AS subtotal1,
                    SUM(tabel_per_department.pot_klaim_sdh_byr) AS pot_klaim_sdh_byr,
                    SUM(tabel_per_department.pot_subs_pajak) AS pot_subs_pajak,
                    SUM(tabel_per_department.subtotal2) AS subtotal2,
                    SUM(tabel_per_department.pot_jht) AS pot_jht,
                    SUM(tabel_per_department.pot_jkn) AS pot_jkn,
                    SUM(tabel_per_department.pot_kop) AS pot_kop,
                    SUM(tabel_per_department.pot_utang) AS pot_utang,
                    SUM(tabel_per_department.pot_duka) AS pot_duka,
                    SUM(tabel_per_department.pot_spsi) AS pot_spsi,
                    SUM(tabel_per_department.pot_pensiun) AS pot_pensiun,
                    SUM(tabel_per_department.pot_transfer) AS pot_transfer,
                    SUM(tabel_per_department.thp) AS thp
                FROM tabel_per_department
            ";

            $query = $this->db->query($sql);

            return $query->row_array();
        }
    }

?>