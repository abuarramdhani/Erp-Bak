<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jamsostekperubahandatapekerja extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($year,$month)
    {
        $sql = "
            SELECT tb_perubahan.noind AS no_induk,
                tb_perubahan.no_kpj AS no_kpj,
                tb_pekerja.nama AS nama,
                tb_perubahan.gaji_pokok AS gaji_sesudah,
                tb_perubahan.gaji_sblm AS gaji_sebelum,
                tb_perubahan.selisih AS selisih
            FROM pr.pr_lap_jamsostek_perubahan_gaji AS tb_perubahan
            JOIN pr.pr_master_pekerja AS tb_pekerja
                ON tb_perubahan.noind = tb_pekerja.noind
            WHERE EXTRACT(YEAR FROM tb_perubahan.tanggal)=$year 
                AND EXTRACT(MONTH FROM tb_perubahan.tanggal)=$month
        ";

        $query = $this->db->query($sql);
    	return $query->result_array();
    }

    // get the sum of all salaries risen
    function get_sum($year,$month)
    {
        $sql = "
            SELECT SUM(COALESCE(CAST(NULLIF(tb_perubahan.selisih, '') AS NUMERIC), 0)) AS total_selisih
            FROM pr.pr_lap_jamsostek_perubahan_gaji AS tb_perubahan
            WHERE EXTRACT(YEAR FROM tb_perubahan.tanggal)=$year 
                AND EXTRACT(MONTH FROM tb_perubahan.tanggal)=$month
        ";

        $query = $this->db->query($sql);
        return $query->row('total_selisih');
    }
}