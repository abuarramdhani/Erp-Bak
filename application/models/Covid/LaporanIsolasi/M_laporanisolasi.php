<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class M_laporanisolasi extends CI_Model {
	
	function __construct() {
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
		$this->erp = $this->load->database('erp_db', true);
	}

	function getPekerjaAll(){
		$sql = "select a.cvd_pekerja_id,
					a.noind,
					b.employee_name as nama,
					c.section_name as seksi, 
					c.department_name as dept,
					a.tgl_interaksi, 
					a.kasus, 
					a.keterangan,
					e.keputusan,
					e.tgl_keputusan,
					e.created_by
				from cvd.cvd_pekerja a
				inner join er.er_employee_all b 
				on a.noind = b.employee_code
				inner join er.er_section c 
				on b.section_code = c.section_code
				inner join cvd.cvd_wawancara d 
				on a.cvd_pekerja_id = d.cvd_pekerja_id
				inner join cvd.cvd_keputusan e 
				on d.wawancara_id = e.wawancara_id
				order by e.tgl_keputusan desc";
		return $this->erp->query($sql)->result_array();
	}
}
?>