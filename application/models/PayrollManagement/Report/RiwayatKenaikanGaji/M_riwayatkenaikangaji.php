<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_riwayatkenaikangaji extends CI_Model
{

    public $table = 'pr.pr_riwayat_gaji';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($year,$month)
    {
        $sql = "SELECT a.noind AS no_induk, 
            pr.pr_master_pekerja.nama AS nama, 
            b.tgl_berlaku AS tgl_berubah, 
            a.gaji_pokok AS gaji_lama, 
            b.gaji_pokok AS gaji_baru, 
            COALESCE(CAST(NULLIF(b.gaji_pokok, '') AS NUMERIC), 0) - COALESCE(CAST(NULLIF(a.gaji_pokok, '') AS NUMERIC), 0) AS selisih 
        FROM pr.pr_riwayat_gaji AS a 
        JOIN pr.pr_riwayat_gaji AS b 
            ON a.noind = b.noind 
        JOIN pr.pr_master_pekerja 
            ON a.noind = pr.pr_master_pekerja.noind 
        WHERE a.tgl_tberlaku = b.tgl_berlaku 
            AND EXTRACT(YEAR FROM b.tgl_berlaku)=$year 
            AND EXTRACT(MONTH FROM b.tgl_berlaku)=$month";

        $query = $this->db->query($sql);
    	return $query->result_array();
    }
}