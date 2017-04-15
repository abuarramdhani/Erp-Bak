<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_potonganspsi extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve all employees SPSI fees
        function get_all($year, $month)
        {
            $sql = "
                WITH tabel_penggajian AS (
                    SELECT *
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year 
                        AND EXTRACT (MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                )
                SELECT pr.pr_master_pekerja.noind AS no_induk,
                    pr.pr_master_pekerja.nama AS nama,
                    COALESCE(pr.pr_master_seksi.seksi, '-') AS seksi,
                    COALESCE(CAST(NULLIF(tabel_penggajian.pspsi, '') AS NUMERIC), 0) AS jumlah
                FROM pr.pr_master_pekerja
                LEFT JOIN pr.pr_master_seksi
                    ON pr.pr_master_pekerja.kodesie = pr.pr_master_seksi.kodesie
                LEFT JOIN tabel_penggajian
                    ON pr.pr_master_pekerja.noind = tabel_penggajian.noind
                ORDER BY jumlah DESC
            ";

            $query = $this->db->query($sql);
            return $query->result_array();
        }

        // Retrieve the sum of all employees SPSI fees
        function get_sum($year, $month)
        {
            $sql = "
                WITH tabel_penggajian AS (
                    SELECT *
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year 
                        AND EXTRACT (MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                )
                SELECT SUM(COALESCE(CAST(NULLIF(tabel_penggajian.pspsi, '') AS NUMERIC), 0)) AS total
                FROM pr.pr_master_pekerja
                LEFT JOIN pr.pr_master_seksi
                    ON pr.pr_master_pekerja.kodesie = pr.pr_master_seksi.kodesie
                LEFT JOIN tabel_penggajian
                    ON pr.pr_master_pekerja.noind = tabel_penggajian.noind
            ";

            $query = $this->db->query($sql);
            return $query->row('total');
        }
    }

?>