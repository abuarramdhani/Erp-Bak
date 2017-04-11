<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class M_penghasilanbawahptkp extends CI_Model
    {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        // Retrieve employees with salaries under PTKP for some year
        function get_all( $year )
        {
            $sql = "SELECT pr.pr_master_pekerja.noind AS no_induk, pr.pr_master_pekerja.npwp AS npwp, pr.pr_master_pekerja.nama AS nama 
                FROM pr.pr_master_pekerja
                JOIN pr.pr_transaksi_hitung_pajak
                ON pr.pr_master_pekerja.noind = pr.pr_transaksi_hitung_pajak.noind
                WHERE EXTRACT(YEAR FROM pr.pr_transaksi_hitung_pajak.tanggal) = $year AND CAST(pr.pr_transaksi_hitung_pajak.pkp_setahun AS FLOAT) <= 0";

/*			$sql = "SELECT pr.pr_master_pekerja.noind AS no_induk, pr.pr_master_pekerja.npwp AS npwp, pr.pr_master_pekerja.nama AS nama 
                FROM pr.pr_master_pekerja LIMIT 200";*/
            
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

?>