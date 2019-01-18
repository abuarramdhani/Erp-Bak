<?php
class M_SPLSeksi extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->spl = $this->load->database('spl_db',true);
		$this->prs = $this->load->database('personalia', true);
	}

	public function show_noind(){
		$query = $this->spl->get('hrd_khs.tnoind');
		return $query->result_array();
	}
	
	public function show_lokasi(){
		$query = $this->spl->get('hrd_khs.tlokasi_kerja');
		return $query->result_array();
	}

	public function show_jenis_lembur(){
		$query = $this->spl->get('splseksi.tjenislembur');
		return $query->result_array();
	}

	public function show_pekerja($filter, $filter2){
		$sql = "select noind, nama, kodesie from hrd_khs.tpribadi 
			where (nama like '%$filter%' or noind like '%$filter%') and noind like '$filter2%' order by nama";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_akses_seksi($filter){
		$this->spl->where('noind', $filter);
		$query = $this->spl->get('takses_seksi');
		return $query->result_array();
	}

	public function show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie){
		$x = 0;
		foreach($akses_sie as $as){
			if($x == 0){
				$akses = "b.kodesie like '$as%'";
			}else{
				$akses .= " or b.kodesie like '$as%'";
			}
			$x++;
		}

		$sql = "select a.*, b.nama, d.kodesie, d.seksi, d.unit, d.dept, e.nama_lembur, c.Deskripsi
			from splseksi.tspl a
			inner join hrd_khs.tpribadi b ON a.noind = b.noind 
			inner join splseksi.tjenislembur e ON a.kd_lembur = e.kd_lembur 
			inner join splseksi.tstatus_spl c ON a.status = c.id_status 
			inner join hrd_khs.tseksi d ON b.kodesie = d.kodesie 
			where a.status like '%$status%' and a.tgl_lembur between '$dari' AND '$sampai' 
					and a.perbantuan='N' and ($akses) and b.noind like '$noind%' and b.lokasi_kerja like '%$lokasi%'
			order by a.tgl_lembur, d.seksi, a.kd_lembur, b.nama, a.jam_mulai_lembur, a.Jam_Akhir_Lembur";
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

	public function show_rekap($dari, $sampai, $noind, $akses_sie){
		$x = 0;
		foreach($akses_sie as $as){
			if($x == 0){
				$akses = "tlb.kodesie like '$as%'";
			}else{
				$akses .= " or tlb.kodesie like '$as%'";
			}
			$x++;
		}

		$sql = "select tlb.tanggal, tlb.noind, tpr.nama, tlb.jam_msk, tlb.jam_klr, tlb.jml_lembur, jns.nama_lembur, tdp.total_lembur 
			from presensi.tlembur tlb 
			left join presensi.tdatapresensi tdp on tlb.noind=tdp.noind and tlb.tanggal=tdp.tanggal 
			left join hrd_khs.tpribadi tpr on tlb.noind = tpr.noind 
			left join presensi.tjenislembur jns on tlb.kd_lembur=jns.kd_lembur 
			where tlb.noind like '$noind%' and tlb.tanggal between '$dari' and '$sampai' and ($akses)
			order by tlb.noind, tlb.tanggal";
		$query = $this->spl->query($sql);
		return $query->result_array();
	}
	
}