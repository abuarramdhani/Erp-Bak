<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_index extends CI_Model {
	
	function __construct() {
		$this->load->database();
	}

	function getZonaKHSAll(){
		$sql = "select id_zona,nama_seksi,lokasi, 
					case when isolasi = '1' then 'Ya' else 'Tidak' end as isolasi,
					tgl_awal_isolasi,tgl_akhir_isolasi,kasus,created_by,created_timestamp,koordinat,
					last_tgl_akhir_isolasi
			from cvd.cvd_zona_khs
			order by isolasi desc";
		return $this->db->query($sql)->result_array();
	}

}
?>