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
        $sql = "select a.noind as no_induk, pr.pr_master_pekerja.nama as nama, b.tgl_berlaku as tgl_berubah, a.gaji_pokok as gaji_lama, b.gaji_pokok as gaji_baru, cast(b.gaji_pokok as integer) - cast(a.gaji_pokok as integer) as selisih from pr.pr_riwayat_gaji as a join pr.pr_riwayat_gaji as b on a.noind = b.noind join pr.pr_master_pekerja on a.noind = pr.pr_master_pekerja.noind where a.tgl_tberlaku = b.tgl_berlaku and extract(year from b.tgl_berlaku)=$year and extract(month from b.tgl_berlaku)=$month";
        $query = $this->db->query($sql);
    	return $query->result_array();
    }
}