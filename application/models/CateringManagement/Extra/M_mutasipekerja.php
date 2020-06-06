<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_mutasipekerja extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getMutasiPekerja(){
    	$sql = "select 
    			a.noind,
    			b.nama,
				concat(c.dept,' / ',c.bidang,' / ',c.unit,' / ',c.seksi) as seksi_lama, 
				concat(c.dept, '/ ',d.bidang,' / ',d.unit,' / ',d.seksi) as seksi_baru, 
				b.tempat_makan
				from hrd_khs.tmutasi a 
				inner join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				inner join hrd_khs.tseksi c 
				on a.kodesielm = c.kodesie 
				inner join hrd_khs.tseksi d 
				on a.kodesiebr = d.kodesie 
				Where a.tglberlaku >= current_date - Interval '3 month' 
				order by 5 desc";
    	return $this->personalia->query($sql)->result_array();
    }

    public function get3MonthBefore(){
    	$sql = "select (current_date - Interval '3 month')::date as tanggal";
    	return $this->personalia->query($sql)->row()->tanggal;
    }
} ?>