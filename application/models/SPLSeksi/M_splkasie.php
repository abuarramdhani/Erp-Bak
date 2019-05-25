<?php
class M_splkasie extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->spl = $this->load->database('spl_db',true);
		$this->prs = $this->load->database('personalia', true);
	}

	public function show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie, $kodesie){
		$x = 0;
		if(!empty($akses_sie)){
			foreach($akses_sie as $as){
				if($x == 0){
					$akses = "b.kodesie like '$as%'";
				}else{
					$akses .= " or b.kodesie like '$as%'";
				}
				$x++;
			}
			$akses = "and ($akses)";
		}else{
			$akses = "";
		}

		if(!empty($dari) || !empty($sampai)){
			$periode = "and a.tgl_lembur between '$dari' AND '$sampai'";
		}else{
			$periode = "";
		}

		$sql = "select a.*, b.nama, d.kodesie, d.seksi, d.unit, d.dept, e.nama_lembur, c.Deskripsi
			from splseksi.tspl a
			inner join hrd_khs.tpribadi b ON a.noind = b.noind 
			inner join splseksi.tjenislembur e ON a.kd_lembur = e.kd_lembur 
			inner join splseksi.tstatus_spl c ON a.status = c.id_status 
			inner join hrd_khs.tseksi d ON b.kodesie = d.kodesie 
			where a.status like '%$status%' $periode
				and a.perbantuan='N' and d.kodesie like '$kodesie%' $akses
				and b.noind like '$noind%' and b.lokasi_kerja like '%$lokasi%'
			order by a.tgl_lembur, d.seksi, a.kd_lembur, b.nama, a.jam_mulai_lembur, a.Jam_Akhir_Lembur";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_email_addres($sie){
		$sql = "select eea.employee_code, eea.internal_mail, sugm.user_group_menu_name 
			from er.er_employee_all eea
			inner join sys.sys_user su on eea.employee_id=su.employee_id
			inner join sys.sys_user_application sua on su.user_id = sua.user_id
			inner join sys.sys_user_group_menu sugm on sua.user_group_menu_id = sugm.user_group_menu_id
			where eea.resign='0' and eea.section_code like '$sie%' and lower(sugm.user_group_menu_name) like '%lembur%asska%' 
				and su.user_name='J1255'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_finger_user($fill){
		$this->spl->where($fill);
		$query = $this->spl->get('splseksi.tfinger_php');
		return $query->row();
	}

	public function show_finger_activation($filter){
		$this->spl->where($filter);
		$query = $this->spl->get('splseksi.tcode_fingerprint');
		return $query->row();
	}

}