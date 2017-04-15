<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_potongandanapensiun extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve all employees pension funds
        function get_all($year, $month)
        {
            $sql = "
                WITH tabel_penggajian AS (
                    SELECT *
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year 
                        AND EXTRACT (MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                ), tabel_rekening AS (
                    SELECT *
                    FROM pr.pr_riwayat_rekening_pekerja
                    WHERE pr.pr_riwayat_rekening_pekerja.tgl_tberlaku > DATE(CONCAT('$year','-','$month','-','01')) 
                        AND pr.pr_riwayat_rekening_pekerja.tgl_berlaku <= DATE(CONCAT('$year','-','$month','-','01'))
                )
                SELECT pr.pr_master_pekerja.noind AS no_induk,
                    pr.pr_master_pekerja.nama AS nama,
                    COALESCE(pr.pr_master_seksi.seksi, '-') AS seksi,
                    COALESCE(tabel_rekening.no_rekening, '') AS norek,
                    COALESCE(CAST(NULLIF(tabel_penggajian.pot_pensiun, '') AS NUMERIC), 0) AS jumlah
                FROM pr.pr_master_pekerja
                LEFT JOIN pr.pr_master_seksi
                    ON pr.pr_master_pekerja.kodesie = pr.pr_master_seksi.kodesie
                LEFT JOIN tabel_rekening
                    ON pr.pr_master_pekerja.noind = tabel_rekening.noind
                LEFT JOIN tabel_penggajian
                    ON pr.pr_master_pekerja.noind = tabel_penggajian.noind
                ORDER BY jumlah DESC
            ";

            $query = $this->db->query($sql);
            return $query->result_array();
        }

        // Retrieve the sum of all employees pension funds
        function get_sum($year, $month)
        {
            $sql = "
                WITH tabel_penggajian AS (
                    SELECT *
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year 
                        AND EXTRACT (MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                ), tabel_rekening AS (
                    SELECT *
                    FROM pr.pr_riwayat_rekening_pekerja
                    WHERE pr.pr_riwayat_rekening_pekerja.tgl_tberlaku > DATE(CONCAT('$year','-','$month','-','01')) 
                        AND pr.pr_riwayat_rekening_pekerja.tgl_berlaku <= DATE(CONCAT('$year','-','$month','-','01'))
                )
                SELECT SUM(COALESCE(CAST(NULLIF(tabel_penggajian.pot_pensiun, '') AS NUMERIC), 0)) AS total
                FROM pr.pr_master_pekerja
                LEFT JOIN pr.pr_master_seksi
                    ON pr.pr_master_pekerja.kodesie = pr.pr_master_seksi.kodesie
                LEFT JOIN tabel_rekening
                    ON pr.pr_master_pekerja.noind = tabel_rekening.noind
                LEFT JOIN tabel_penggajian
                    ON pr.pr_master_pekerja.noind = tabel_penggajian.noind
            ";

            $query = $this->db->query($sql);
            return $query->row('total');
        }
    }

?>