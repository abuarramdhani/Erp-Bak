<?php
class M_SPLSeksi extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->spl = $this->load->database('spl_db',true);
		$this->prs = $this->load->database('personalia', true);
	}
	
	public function show_lokasi(){
		$query = $this->spl->get('hrd_khs.tlokasi_kerja');
		return $query->result_array();
	}

	public function show_jenis_lembur(){
		$query = $this->spl->get('splseksi.tjenislembur');
		return $query->result_array();
	}

	public function show_pekerja($filter){
		$sql = "select noind, nama, kodesie from hrd_khs.tpribadi where nama like '%$filter%' or noind like '%$filter%' order by nama";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_akses_seksi($filter){
		$this->db->where('noind', $filter);
		$query = $this->spl->get('takses_seksi');
		return $query->result_array();
	}

	public function show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie){
		$aksesa = "a.kodesie like '-%'";
		$aksesb = "a.sieperbantuan like '-%'";
		foreach($akses_sie as $as){
			$aksesa .= "or a.kodesie like '$as%'";
			$aksesb .= "or a.sieperbantuan like '$as%'";
		}

		$sql = "select ab.ID_SPL, ab.status, ab.user_, ab.ID_SPL, ab.Tgl_Lembur, ab.Noind, ab.Nama, e.Nama_Lembur, 
				ab.Kodesie, d.Seksi, d.Unit, ab.Jam_Mulai_lembur, ab.Jam_Akhir_Lembur, ab.Break, 
				ab.Istirahat, c.Deskripsi, ab.Pekerjaan, ab.tgl_berlaku, ab.target, ab.realisasi, 
				ab.alasan_lembur, ab.status as kd_status, ab.perbantuan, ab.sieperbantuan, ab.urut_lembur 
			from (select d.*,a.kodesie,a.nama from splseksi.tspl d 
				inner join hrd_khs.tpribadi a ON a.Noind = d.Noind 
				where d.Status like '%$status%' and d.tgl_lembur between '$dari' AND '$sampai' 
					and d.perbantuan='N' and ($aksesa) and a.noind like '$noind%' and a.lokasi_kerja like '%$lokasi%' 
				Union 
				select a.*,d.kodesie,d.nama from splseksi.tspl a 
				inner join hrd_khs.tpribadi d ON a.Noind = d.Noind 
				where a.Status like '%$status%' and a.tgl_lembur between '$dari' AND '$sampai' 
					and a.perbantuan='Y' and ($aksesb) and a.noind like '$noind%' and d.lokasi_kerja like '%$lokasi%') ab 
			inner join hrd_khs.tpribadi b ON ab.Noind = b.Noind 
			inner join splseksi.tjenislembur e ON ab.Kd_Lembur = e.Kd_Lembur 
			inner join splseksi.tstatus_spl c ON ab.Status = c.ID_Status 
			inner join hrd_khs.tseksi d ON ab.Kodesie = d.Kodesie 
			order by ab.Tgl_Lembur desc, d.seksi, ab.kd_lembur, ab.Nama, ab.jam_mulai_lembur, ab.Jam_Akhir_Lembur";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_current_shift($tanggal, $noind){
		$sql = "select *from \"Presensi\".tshiftpekerja where noind='$noind' and tanggal='$tanggal'";
		$query = $this->prs->query($sql);
		return $query->result_array();
	} 

	public function show_current_spl($tanggal, $noind, $lembur, $idspl){
		if($idspl == ""){
			$sql = "select *from splseksi.tspl where Noind='$noind' and Tgl_Lembur='$tanggal' and Kd_Lembur='$lembur'";
		}else{
			$sql = "select *,b.nama from splseksi.tspl a inner join hrd_khs.tpribadi b on a.noind=b.noind where id_spl='$idspl'";
		}
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_maxid($table, $col){
		$query = $this->spl->query("select max($col)+1 as id from $table");
		return $query->row();
	}

	public function save_log($data){
		$this->spl->insert('splseksi.tlog',$data);
		return;
	}

	public function save_spl($data){
		$this->spl->insert('splseksi.tspl',$data);
		return;
	}

	public function save_splr($data){
		$this->spl->insert('splseksi.tspl_riwayat',$data);
		return;
	}

	public function drop_spl($filter){
		$this->spl->where('ID_SPL', $filter);
		$this->spl->delete('splseksi.tspl');

		$this->spl->where('ID_SPL', $filter);
		$this->spl->delete('splseksi.tspl_riwayat');
		return;
	}

	public function update_spl($data, $filter){
		$this->spl->where('ID_SPL', $filter);
		$this->spl->update('splseksi.tspl', $data);
		return;
	}
	
}