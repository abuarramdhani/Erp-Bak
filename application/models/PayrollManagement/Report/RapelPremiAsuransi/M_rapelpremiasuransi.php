<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_rapelpremiasuransi extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve all employees insurances fee
        function get_all($year)
        {
            $sql = "
                SELECT tb_asuransi.noind AS no_induk,
                    tb_pekerja.no_kpj AS no_kpj,
                    tb_pekerja.nama AS nama,
                    COALESCE(CAST(NULLIF(tb_asuransi.jht_kary, '') AS NUMERIC), 0) AS jht,
                    COALESCE(CAST(NULLIF(tb_asuransi.jkk, '') AS NUMERIC), 0) AS jkk,
                    COALESCE(CAST(NULLIF(tb_asuransi.jkm, '') AS NUMERIC), 0) AS jkm,
                    COALESCE(CAST(NULLIF(tb_asuransi.jkn_kary, '') AS NUMERIC), 0) AS jkn,
                    COALESCE(CAST(NULLIF(tb_asuransi.jht_kary, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tb_asuransi.jkk, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tb_asuransi.jkm, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tb_asuransi.jkn_kary, '') AS NUMERIC), 0) AS total
                FROM pr.pr_transaksi_asuransi AS tb_asuransi
                JOIN pr.pr_master_pekerja AS tb_pekerja
                    ON tb_asuransi.noind = tb_pekerja.noind
                WHERE EXTRACT(YEAR FROM tb_asuransi.tanggal) = $year
            ";

            $query = $this->db->query($sql);
            return $query->result_array();
        }

        // Retrieve the sum of all employees insurances fee
        function get_sum($year)
        {
            $sql = "
                SELECT SUM(COALESCE(CAST(NULLIF(tb_asuransi.jht_kary, '') AS NUMERIC), 0)) AS total_jht,
                    SUM(COALESCE(CAST(NULLIF(tb_asuransi.jkk, '') AS NUMERIC), 0)) AS total_jkk,
                    SUM(COALESCE(CAST(NULLIF(tb_asuransi.jkm, '') AS NUMERIC), 0)) AS total_jkm,
                    SUM(COALESCE(CAST(NULLIF(tb_asuransi.jkn_kary, '') AS NUMERIC), 0)) AS total_jkn,
                    SUM(COALESCE(CAST(NULLIF(tb_asuransi.jht_kary, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tb_asuransi.jkk, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tb_asuransi.jkm, '') AS NUMERIC), 0)
                        + COALESCE(CAST(NULLIF(tb_asuransi.jkn_kary, '') AS NUMERIC), 0)) AS grand_total
                FROM pr.pr_transaksi_asuransi AS tb_asuransi
                WHERE EXTRACT(YEAR FROM tb_asuransi.tanggal) = $year
            ";

            $query = $this->db->query($sql);
            return $query->row_array();
        }
    }

?>