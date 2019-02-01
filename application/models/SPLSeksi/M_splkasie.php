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
		foreach($akses_sie as $as){
			if($x == 0){
				$akses = "b.kodesie like '$as%'";
			}else{
				$akses .= " or b.kodesie like '$as%'";
			}
			$x++;
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
				and a.perbantuan='N' and ($akses) and d.kodesie like '$kodesie%' 
				and b.noind like '$noind%' and b.lokasi_kerja like '%$lokasi%'
			order by a.tgl_lembur, d.seksi, a.kd_lembur, b.nama, a.jam_mulai_lembur, a.Jam_Akhir_Lembur";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function save_confirm($data){
		$this->spl->insert('splseksi.tapp_confirm',$data);
		return;
	}

	public function drop_confirm($filter){
		$this->spl->where('username', $filter);
		$this->spl->delete('splseksi.tapp_confirm');
		return;
	}

	public function show_confirm($filter){
		$this->spl->where($filter);
		$query = $this->spl->get('splseksi.tapp_confirm');
		return $query->row();
	}

	public function show_email_addres($filter){
		$this->db->where('employee_code', $filter);
		$query = $this->db->get('er.er_employee_all');
		return $query->row();
	}

}