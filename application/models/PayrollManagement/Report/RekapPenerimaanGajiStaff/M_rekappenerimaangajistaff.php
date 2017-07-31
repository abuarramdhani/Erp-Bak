<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_rekappenerimaangajistaff extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve salaries by department
        function get_salaries_paid_to_some_bank_on_some_period($bank, $year, $month)
        {
            $sql = "
                WITH tabel_pembayaran_penggajian AS (
                    SELECT *
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year
                        AND EXTRACT(MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                        AND pr.pr_transaksi_pembayaran_penggajian.kd_bank = '$bank'
                ), tabel_rekening AS (
                    SELECT *
                    FROM pr.pr_riwayat_rekening_pekerja
                    WHERE pr.pr_riwayat_rekening_pekerja.tgl_tberlaku > DATE(CONCAT('$year','-','$month','-','01')) 
                        AND pr.pr_riwayat_rekening_pekerja.tgl_berlaku <= DATE(CONCAT('$year','-','$month','-','01'))
                        AND pr.pr_riwayat_rekening_pekerja.kd_bank = '$bank'
                )
                SELECT
                    pr.pr_master_pekerja.noind AS no_induk,
                    pr.pr_master_pekerja.nama AS nama,
                    tabel_rekening.no_rekening AS no_rekening,
                    tabel_rekening.nama_pemilik_rekening AS nama_pemilik_rekening,
                    tabel_pembayaran_penggajian.subtotal3 AS thp
                FROM pr.pr_master_pekerja
                JOIN tabel_pembayaran_penggajian
                    ON pr.pr_master_pekerja.noind = tabel_pembayaran_penggajian.noind
                JOIN tabel_rekening
                    ON pr.pr_master_pekerja.noind = tabel_rekening.noind
            ";

            $query = $this->db->query($sql);

            return $query->result_array();
        }

            function get_sum_of_salaries_and_transfer_fees($bank, $year, $month)
        {
            $sql = "
                WITH tabel_pembayaran_penggajian AS (
                    SELECT *,
                        COALESCE(CAST(NULLIF(pr.pr_transaksi_pembayaran_penggajian.subtotal3, '') AS NUMERIC), 0) AS thp,
                        COALESCE(CAST(NULLIF(pr.pr_transaksi_pembayaran_penggajian.btransfer, '') AS NUMERIC), 0) AS pot_transfer
                    FROM pr.pr_transaksi_pembayaran_penggajian
                    WHERE EXTRACT(YEAR FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $year
                        AND EXTRACT(MONTH FROM pr.pr_transaksi_pembayaran_penggajian.tanggal) = $month
                        AND pr.pr_transaksi_pembayaran_penggajian.kd_bank = '$bank'
                ), tabel_rekening AS (
                    SELECT *
                    FROM pr.pr_riwayat_rekening_pekerja
                    WHERE pr.pr_riwayat_rekening_pekerja.tgl_tberlaku > DATE(CONCAT('$year','-','$month','-','01')) 
                        AND pr.pr_riwayat_rekening_pekerja.tgl_berlaku <= DATE(CONCAT('$year','-','$month','-','01'))
                        AND pr.pr_riwayat_rekening_pekerja.kd_bank = '$bank'
                )
                SELECT SUM(tabel_pembayaran_penggajian.thp) AS total_thp,
                    COUNT(tabel_pembayaran_penggajian.pot_transfer) AS cacah,
                    AVG(tabel_pembayaran_penggajian.pot_transfer) AS pot_transfer,
                    SUM(tabel_pembayaran_penggajian.pot_transfer) AS total_pot_transfer,
                    SUM(tabel_pembayaran_penggajian.thp) - SUM(tabel_pembayaran_penggajian.pot_transfer) AS total_nett
                FROM pr.pr_master_pekerja
                JOIN tabel_pembayaran_penggajian
                    ON pr.pr_master_pekerja.noind = tabel_pembayaran_penggajian.noind
                JOIN tabel_rekening
                    ON pr.pr_master_pekerja.noind = tabel_rekening.noind
            ";

            $query = $this->db->query($sql);

            return $query->row_array();
        }
    }

?>