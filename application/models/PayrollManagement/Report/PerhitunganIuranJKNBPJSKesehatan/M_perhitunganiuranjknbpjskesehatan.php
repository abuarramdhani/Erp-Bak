<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_perhitunganiuranjknbpjskesehatan extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve all employees iuran jkn
        function get_all($year, $month)
        {
            $sql = "
                SELECT tb_pekerja.nama AS nama,
                    tb_perhitungan.gaji_pokok AS gaji_pokok,
                    tb_perhitungan.gaji_asuransi AS gaji_perhitungan,
                    tb_perhitungan.jkn_kary AS iuran_karyawan,
                    tb_perhitungan.jkn_prshn AS iuran_perusahaan,
                    tb_perhitungan.total_iuran AS iuran_total,
                    COALESCE(CAST(NULLIF(tb_perhitungan.i, '') AS INTEGER), 0)
                        + COALESCE(CAST(NULLIF(tb_perhitungan.s, '') AS INTEGER), 0)
                        + COALESCE(CAST(NULLIF(tb_perhitungan.s, '') AS INTEGER), 0) AS jumlah_pisa,
                    tb_perhitungan.kelas_perawatan AS kelas_perawatan
                FROM pr.pr_lap_perhitungan_jkn_bpjs_tmp AS tb_perhitungan
                JOIN pr.pr_master_pekerja AS tb_pekerja
                    ON tb_perhitungan.noind = tb_pekerja.noind
                WHERE EXTRACT(YEAR FROM DATE(tb_perhitungan.tanggal)) = '$year' 
                    AND EXTRACT(MONTH FROM DATE(tb_perhitungan.tanggal)) = '$month' 
            ";

            $query = $this->db->query($sql);
            return $query->result_array();
        }

        // Retrieve the sum of all employees iuran jkn
        function get_sum($year, $month)
        {
            $sql = "
                SELECT SUM(COALESCE(CAST(NULLIF(tb_perhitungan.gaji_asuransi, '') AS NUMERIC), 0)) AS total_gaji_perhitungan,
                    SUM(COALESCE(CAST(NULLIF(tb_perhitungan.jkn_kary, '') AS NUMERIC), 0)) AS total_iuran_karyawan,
                    SUM(COALESCE(CAST(NULLIF(tb_perhitungan.jkn_prshn, '') AS NUMERIC), 0)) AS total_iuran_perusahaan,
                    SUM(COALESCE(CAST(NULLIF(tb_perhitungan.total_iuran, '') AS NUMERIC), 0)) AS total_iuran_total                    
                FROM pr.pr_lap_perhitungan_jkn_bpjs_tmp AS tb_perhitungan
                WHERE EXTRACT(YEAR FROM DATE(tb_perhitungan.tanggal)) = '$year' 
                    AND EXTRACT(MONTH FROM DATE(tb_perhitungan.tanggal)) = '$month' 
            ";

            $query = $this->db->query($sql);
            return $query->row_array();
        }
    }

?>