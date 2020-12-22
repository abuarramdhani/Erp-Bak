<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_index extends CI_Model {
	
	function __construct() {
		$this->load->database();
	}

	function getZonaKHSAll(){
		$sql = "select a.id_zona,a.nama_seksi,a.lokasi, 
				case when (
					select count(*)
					from cvd.cvd_zona_khs_detail b
					where a.id_zona = b.id_zona
				) > 0 then 'Ya' else 'Tidak' end as isolasi,
				c.tgl_awal_isolasi,c.tgl_akhir_isolasi,c.kasus,a.koordinat,
				a.last_tgl_akhir_isolasi
			from cvd.cvd_zona_khs a
			left join cvd.cvd_zona_khs_detail c 
			on a.id_zona = c.id_zona
			where current_date between c.tgl_awal_isolasi and c.tgl_akhir_isolasi
			or (
				c.kasus is null 
				and a.last_tgl_akhir_isolasi >= current_date - interval '2 day'
			)
			order by a.id_zona,c.tgl_awal_isolasi,c.tgl_akhir_isolasi desc";
		return $this->db->query($sql)->result_array();
	}

}
?>