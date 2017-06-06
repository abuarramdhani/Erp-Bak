<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_rekappembayaranjkn extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve employee details
        function get_employee_data($no_ind)
        {
            $sql = "
                SELECT pr.pr_master_pekerja.noind AS no_induk,
                    pr.pr_master_pekerja.nama AS nama,
                    COALESCE(pr.pr_master_seksi.seksi, '-') AS seksi,
                    COALESCE(pr.pr_master_pekerja.no_kpj, '-') AS no_kpj
                FROM pr.pr_master_pekerja
                LEFT JOIN pr.pr_master_seksi
                    ON pr.pr_master_pekerja.kodesie = pr.pr_master_seksi.kodesie
                WHERE pr.pr_master_pekerja.noind = '$no_ind'
            ";

            $query = $this->db->query($sql);
            return $query->row_array();
        }

        // Retrieve employee JKN payments record
        function get_jkn_year($no_ind, $year)
        {
            
            $sql = "
                WITH tabel_transaksi_karyawan AS (
                    SELECT *
                    FROM pr.pr_transaksi_asuransi
                    WHERE pr.pr_transaksi_asuransi.noind = '$no_ind'
                        AND EXTRACT(YEAR FROM pr.pr_transaksi_asuransi.tanggal) = $year
                )
                SELECT sys.sys_month_names.nama AS bulan,
                    COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.gaji_asuransi, '') AS NUMERIC), 0) AS gaji_pokok,
                    COALESCE(tabel_transaksi_karyawan.trf_jkn_kary, '0') AS tarif_karyawan,
                    COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_kary, '') AS NUMERIC), 0) AS jkn_karyawan,
                    COALESCE(tabel_transaksi_karyawan.trf_jkn_prshn, '0') AS tarif_perusahaan,
                    COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_prshn, '') AS NUMERIC), 0) AS jkn_perusahaan,
                    (COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_kary, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_prshn, '') AS NUMERIC), 0)) AS total_jkn
                FROM sys.sys_month_names
                LEFT JOIN tabel_transaksi_karyawan
                ON sys.sys_month_names.id = EXTRACT(MONTH FROM tabel_transaksi_karyawan.tanggal)
            ";

            $query = $this->db->query($sql);
            return $query->result_array();
        }

        // Retrieve the sum of employee JKN payments record
        function get_sum($no_ind, $year)
        {
            $sql = "
                WITH tabel_transaksi_karyawan AS (
                    SELECT *
                    FROM pr.pr_transaksi_asuransi
                    WHERE pr.pr_transaksi_asuransi.noind = '$no_ind'
                        AND EXTRACT(YEAR FROM pr.pr_transaksi_asuransi.tanggal) = $year
                )
                SELECT 
                    SUM(COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_kary, '') AS NUMERIC), 0)) AS jkn_karyawan,
                    SUM(COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_prshn, '') AS NUMERIC), 0)) AS jkn_perusahaan,
                    SUM(COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_kary, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tabel_transaksi_karyawan.jkn_prshn, '') AS NUMERIC), 0)) AS total_jkn
                FROM sys.sys_month_names
                LEFT JOIN tabel_transaksi_karyawan
                ON sys.sys_month_names.id = EXTRACT(MONTH FROM tabel_transaksi_karyawan.tanggal)
            ";

            $query = $this->db->query($sql);
            return $query->row_array();
        }
    }

?>