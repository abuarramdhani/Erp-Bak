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

	public function show_spl_byid($id){
		$sql = "select 	a.tgl_lembur,
						a.jam_mulai_lembur,
						a.Jam_Akhir_Lembur,
						a.Kd_Lembur,
						a.Pekerjaan,
						a.Break,
						a.Istirahat,
						b.Noind,
						b.nama,
						d.kodesie,
						d.seksi,
						d.unit,
						d.dept,
						e.nama_lembur,
						a.alasan_lembur,
						a.target,
						a.realisasi
				from splseksi.tspl a
				inner join hrd_khs.tpribadi b
					ON a.noind = b.noind
				inner join splseksi.tjenislembur e
					ON a.kd_lembur = e.kd_lembur
				inner join hrd_khs.tseksi d
					ON b.kodesie = d.kodesie
				where a.ID_SPL in ($id)
				order by 	a.tgl_lembur,
							a.jam_mulai_lembur,
							a.Jam_Akhir_Lembur,
							a.Kd_Lembur,
							a.Pekerjaan,
							a.Break,
							a.Istirahat,
							b.nama
				";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_spl_byid_2($id){
		$sql = "select 	a.user_,
						a.tgl_lembur,
						a.jam_mulai_lembur,
						a.Jam_Akhir_Lembur,
						a.Kd_Lembur,
						a.Pekerjaan,
						a.Break,
						a.Istirahat,
						b.Noind,
						b.nama,
						d.kodesie,
						d.seksi,
						d.unit,
						d.dept,
						e.nama_lembur,
						a.alasan_lembur,
						a.target,
						a.realisasi
				from splseksi.tspl a
				inner join hrd_khs.tpribadi b
					ON a.noind = b.noind
				inner join splseksi.tjenislembur e
					ON a.kd_lembur = e.kd_lembur
				inner join hrd_khs.tseksi d
					ON b.kodesie = d.kodesie
				where a.ID_SPL in ($id)
				order by 	a.user_,
							a.tgl_lembur,
							a.jam_mulai_lembur,
							a.Jam_Akhir_Lembur,
							a.Kd_Lembur,
							a.Pekerjaan,
							a.Break,
							a.Istirahat,
							b.nama
				";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_email_addres($sie){
		$user = $this->session->user; //untuk trial
		$sql = "select eea.employee_code, eea.internal_mail, sugm.user_group_menu_name
			from er.er_employee_all eea
			inner join sys.sys_user su on eea.employee_id=su.employee_id
			inner join sys.sys_user_application sua on su.user_id = sua.user_id
			inner join sys.sys_user_group_menu sugm on sua.user_group_menu_id = sugm.user_group_menu_id
			where eea.resign='0' and eea.section_code like '$sie%' and lower(sugm.user_group_menu_name) like '%lembur%asska%' ";
				// and su.user_name='$user'"; //untuk trial
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

	public function getEmailAddress($noind){
		$sql = "select ea.internal_mail as mail
				from er.er_employee_all ea
				where employee_code = '$noind'";
		$query = $this->db->query($sql);
		return $query->row()->mail;
	}

	public function getFingerName($jari){
		$sql = "select jari from fp_distribusi.tb_jari where id_finger = '$jari'";
		$query = $this->spl->query($sql);
		return $query->row()->jari;
	}

	public function getName($noind){
		return $this->prs->query("SELECT nama FROM hrd_khs.tpribadi WHERE noind='$noind' limit 1")->row()->nama;
	}

	public function insertMailCronjob($data)
	{
		$this->spl->insert('splseksi.t_kirim_email', $data);
	}
}
