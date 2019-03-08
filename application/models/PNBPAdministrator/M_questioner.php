<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_questioner extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);

	}

	public function getWorker($noind){
		$sql = "select 	tpri.noind,
						tpri.nama,
						tpri.kodesie,
						left(tpri.jenkel,1) jenkel,
						extract(year from age(tpri.tgllahir)) umur,
						extract(year from age(tpri.masukkerja)) masa_kerja,
						case when tsek.seksi = '-' then
							tsek.unit
						else
							tsek.seksi
						end seksi,
						tsek.dept,
						tpri.jabatan nama_jabatan		
				from hrd_khs.tpribadi tpri
				left join hrd_khs.tseksi tsek
				on tsek.kodesie = tpri.kodesie
				where tpri.noind = '$noind';";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getSuku(){
		$sql = "select * from pd.pnbp_suku";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPendidikan(){
		$sql = "select * from pd.pnbp_pendidikan";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertDemografi($data){
		$this->db->insert('pd.pnbp_demografi',$data);
		return;
	}

	public function updateDemografi($data,$noind,$id_periode){
		$this->db->where('id_periode',$id_periode);
		$this->db->where('noind',$noind);
		$this->db->update('pd.pnbp_demografi',$data);
		return ;
	}

	public function getPeriodePengisian(){
		$sql = "select id_periode 
				from pd.pnbp_periode 
				where current_date between periode_awal and periode_akhir";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function checkDemografi($noind,$id_periode){
		$sql = "select * 
				from pd.pnbp_demografi 
				where noind = '$noind' 
				and id_periode = '$id_periode'";
		$result = $this->db->query($sql);
		return $result->num_rows();
	}

	public function getQuestioner($id){
		$sql = "select pp.*,ppr.* 
				from pd.pnbp_pernyataan pp
				inner join pd.pnbp_aspek pa 
				on pa.id_aspek = pp.id_aspek::int
				inner join pd.pnbp_kelompok pk
				on pk.id_kelompok = pa.id_kelompok::int
				left join pd.pnbp_urutan_questioner pu 
				on pu.id_pernyataan::int = pp.id_pernyataan
				left join pd.pnbp_periode ppr 
				on current_date between ppr.periode_awal and ppr.periode_akhir
				where pp.set_active = '1'
				and pk.id_kelompok = $id
				order by pk.id_kelompok,
				pu.id_pernyataan";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getKelompokAktif($id){
		$sql = "select distinct pk.id_kelompok ,pk.kelompok
				from pd.pnbp_pernyataan pp
				inner join pd.pnbp_aspek pa 
				on pa.id_aspek = pp.id_aspek::int
				inner join pd.pnbp_kelompok pk
				on pk.id_kelompok = pa.id_kelompok::int
				where pp.set_active = '1'
				and pk.id_kelompok = $id
				order by pk.id_kelompok";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getKelompokNext($id){
		$sql = "select distinct pk.id_kelompok ,pk.kelompok
				from pd.pnbp_pernyataan pp
				inner join pd.pnbp_aspek pa 
				on pa.id_aspek = pp.id_aspek::int
				inner join pd.pnbp_kelompok pk
				on pk.id_kelompok = pa.id_kelompok::int
				where pp.set_active = '1'
				and pk.id_kelompok > $id
				order by pk.id_kelompok
				limit 1";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getHasil($id_pernyataan,$id_periode,$noind){
		$sql = "select * 
				from pd.pnbp_hasil_sementara
				where noind = '$noind'
				and id_pernyataan = '$id_pernyataan'
				and id_periode = '$id_periode'
				";
		$result = $this->db->query($sql);
		return $result->num_rows();
	}

	public function insertHasil($data){
		$this->db->insert('pd.pnbp_hasil_sementara',$data);
		return ;
	}

	public function updateHasil($data,$id_pernyataan,$id_periode,$noind){
		$this->db->where('id_periode',$id_periode);
		$this->db->where('id_pernyataan',$id_pernyataan);
		$this->db->where('noind',$noind);
		$this->db->update('pd.pnbp_hasil_sementara',$data);
		return ;
	}

	public function gethasilPeriodeIni($noind){
		$sql = "select *
				from pd.pnbp_hasil ph
				inner join pd.pnbp_periode pp
				on ph.id_periode::int = pp.id_periode
				where current_date between pp.periode_awal and pp.periode_akhir
				and ph.noind = '$noind'";
		$result = $this->db->query($sql);
		return $result->num_rows();
	}

	public function getHasilSementara($noind){
		$sql = "select phs.noind,phs.id_pernyataan,phs.pilihan,phs.id_periode,phs.created_date,phs.nilai 
				from pd.pnbp_hasil_sementara phs
				where phs.created_date > (select max(pdem.created_date) 
				from pd.pnbp_demografi pdem
				where pdem.noind = phs.noind)
				and phs.noind = '$noind'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPerbandinganHasil($noind,$id_pernyataan,$id_periode){
		$sql = "select * from pd.pnbp_hasil
				where noind = '$noind'
				and id_pernyataan = '$id_pernyataan'
				and id_periode = '$id_periode'";
		$result = $this->db->query($sql);
		return $result->num_rows();
	}

	public function saveHasil($data){
		$this->db->insert('pd.pnbp_hasil',$data);
		return ;
	}

	public function deleteHasil($noind,$id_pernyataan,$id_periode){
		$sql = "delete from pd.pnbp_hasil_sementara
				where noind = '$noind'
				and id_pernyataan = '$id_pernyataan'
				and id_periode = '$id_periode'";
		$this->db->query($sql);
	}

	public function getPekerja($noind){
		$sql = "select * 
				from er.er_employee_all 
				where 
				(
				employee_code like upper('$noind%') 
				or employee_name like upper('%$noind%')
				)
				and resign = '0'
				and employee_code not in
				(
				select distinct ph.noind
				from pd.pnbp_hasil ph
				inner join pd.pnbp_periode pp
				on ph.id_periode::int = pp.id_periode
				where current_date between pp.periode_awal and pp.periode_akhir
				)";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getLastIDDemografi(){
		$sql = "select max(id_demografi) akhir
				from pd.pnbp_demografi";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDept(){
		$sql = "select distinct left(section_code,1)::int kd_dept,department_name dept
				from er.er_section 
				where left(section_code,1) != '-'
				order by left(section_code,1)::int";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getSection($kd_dept,$sec_name){
		$sql = "select 	section_code,
						section_name,
						unit_name
				from er.er_section
				where right(section_code,2) = '00'
				and left(section_name,1) != '-'
				and left(section_code,1) = '$kd_dept'
				and (	
						section_name like upper('%$sec_name%') 
						or unit_name like upper('%$sec_name%')
					)
				order by section_code::int";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getStatusKerja($text){
		$sql = "select distinct rtrim(jabatan) jabatan 
				from hrd_khs.tpribadi  
				where rtrim(jabatan) not in ('','-')
				and jabatan like upper('%$text%');";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function updateDemografiStatusIsi($noind){
		$sql = "update pd.pnbp_demografi set status_isi = '1'
				where noind = '$noind' 
				and id_periode::int = (
					select id_periode 
					from pd.pnbp_periode where current_date between periode_awal and periode_akhir
				)";
		$this->db->query($sql);
		return ;

	}
}
?>