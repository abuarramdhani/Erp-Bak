<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_report extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPeriode(){
		$sql = "select * from pd.pnbp_periode order by periode_awal desc";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPekerjaHasHasil($noind,$id_periode){
		$sql = "select * 
				from er.er_employee_all 
				where employee_code in	(
											select distinct noind 
											from pd.pnbp_hasil
											where id_periode = '$id_periode'
										)
				and (upper(employee_code) like upper('$noind%') or upper(employee_name) like upper('%$noind%'))";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getLabel(){
		$sql = "select distinct nama_aspek from pd.pnbp_aspek where nama_aspek != 'KEPUASAN KERJA'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getData($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan){
		$sql = "select * from (
				select case when pk.kelompok = 'Sebagai pekerja, saya' then 
					'1 - Penilaian Diri'
				else 
					'2 - Penilaian terhadap Lingkungan' end kelompok,
				pa.nama_aspek,
				((sum(ph.nilai)::numeric/count(pa.nama_aspek)::numeric)/4)*100 nilai 
				from pd.pnbp_pernyataan pp 
				inner join pd.pnbp_aspek pa 
				on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
				on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
				on 1 = 1
				inner join pd.pnbp_hasil ph 
				on ph.id_periode::int = prd.id_periode
				and ph.id_pernyataan::int = pp.id_pernyataan
				inner join pd.pnbp_demografi pdem 
				on pdem.id_periode::int = prd.id_periode and pdem.noind = ph.noind
				where pa.nama_aspek != 'KEPUASAN KERJA' 
				$periode
				$sec
				$masa
				$jk
				$usia
				$suku
				$status
				$pendidikan
				group by pk.id_kelompok,pk.kelompok,pa.nama_aspek
				union
				select '3 - Internalisasi Keseluruhan' kelompok,
				pa.nama_aspek,
				((sum(ph.nilai)::numeric/count(pa.nama_aspek)::numeric)/4)*100 nilai 
				from pd.pnbp_pernyataan pp 
				inner join pd.pnbp_aspek pa 
				on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
				on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
				on 1 = 1
				inner join pd.pnbp_hasil ph 
				on ph.id_periode::int = prd.id_periode
				and ph.id_pernyataan::int = pp.id_pernyataan
				inner join pd.pnbp_demografi pdem 
				on pdem.id_periode::int = prd.id_periode and pdem.noind = ph.noind
				where pa.nama_aspek != 'KEPUASAN KERJA' 
				$periode
				$sec
				$masa
				$jk
				$usia
				$suku
				$status
				$pendidikan
				group by pa.nama_aspek
				) as tbl order by tbl.kelompok, tbl.nama_aspek";
		$result = $this->db->query($sql);
		return $result->result_array();
	}


	public function getKepuasan($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan){
		$sql = "select 
				pa.nama_aspek,
				round(sum(ph.nilai)::numeric/count(pa.nama_aspek)::numeric,2) rata,
				round(((sum(ph.nilai)::numeric/count(pa.nama_aspek)::numeric)/4)*100,2) persen,
				(
				select count(*)
				from pd.pnbp_demografi pdem
				where pdem.status_isi = '1' 
				$periode
				$dept
				$sec
				$masa
				$jk
				$usia
				$suku
				$status
				$pendidikan
				) peserta
				from pd.pnbp_pernyataan pp 
				inner join pd.pnbp_aspek pa 
				on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
				on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
				on 1 = 1
				inner join pd.pnbp_hasil ph 
				on ph.id_periode::int = prd.id_periode
				and ph.id_pernyataan::int = pp.id_pernyataan
				inner join pd.pnbp_demografi pdem 
				on pdem.id_periode::int = prd.id_periode and pdem.noind = ph.noind
				where pa.nama_aspek = 'KEPUASAN KERJA' 
				$periode
				$dept
				$sec
				$masa
				$jk
				$usia
				$suku
				$status
				$pendidikan
				group by pa.nama_aspek";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPeriodeR($txt){
		$sql = "select 'Periode' as label, * from pd.pnbp_periode where id_periode = $txt";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDeptR($txt){
		$sql = "select distinct department_name, 'Departemen' as label from er.er_section where left(section_code,1) = '$txt'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getSecR($txt){
		$sql = "select 'Seksi/Unit' as label, unit_name,section_name from er.er_section where section_code = '$txt'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getMasaR($txt){
		$sql = "select 'Masa Kerja' as label, * from pd.pnbp_masa_kerja wher id_masa_kerja = $txt";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getJkR($txt){
		$sql = "select 'Jenis Kelamin' as label, case when '$txt' = 'L' then 'Laki-Laki' else 'Perempuan' end jenkel";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getUsiaR($txt){
		$sql = "select 'Usia' as label, * from pd.pnbp_usia where id_usia = $txt";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getSukuR($txt){
		$sql = "select 'Suku' as label, * from pd.pnbp_suku where id_suku = $txt";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getStatusR($txt){
		$sql = "select 'Status Kerja' as label, '$txt' as status_jabatan";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPendidikanR($txt){
		$sql = "select 'Pendidikan' as label, * from pd.pnbp_pendidikan where id_pendidikan = $txt";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPeserta($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan){
		$sql = "select 	pdem.id_demografi,
						pdem.noind,
						pdem.nama,
						pdem.status_kerja,
						pdem.jk,
						pdem.created_date,
						pdem.id_periode,
						pu.usia,
						pmk.masa_kerja,
						concat(ps.nama_suku,' - ',ps.asal) suku,
						pndk.pendidikan,
						es.department_name,
						es.section_name seksi,
						es.unit_name unit
				from pd.pnbp_demografi pdem
				inner join pd.pnbp_usia pu
					on pdem.usia::int = pu.id_usia
				inner join pd.pnbp_masa_kerja pmk
					on pdem.masa_kerja::int = pmk.id_masa_kerja
				inner join pd.pnbp_suku ps
					on pdem.suku::int = ps.id_suku
				inner join pd.pnbp_pendidikan pndk
					on pdem.pendidikan_terakhir::int = pndk.id_pendidikan
				inner join er.er_section es 
					on pdem.kodesie = es.section_code
				where pdem.status_isi = '1' 
				$periode
				$dept
				$sec
				$masa
				$jk
				$usia
				$suku
				$status
				$pendidikan
				order by pdem.id_demografi ";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getNilaiPeserta($noind,$id_periode){
		$sql = "select 	puq.no_urut,
						pk.kelompok,
						pa.nama_aspek,
						pp.pernyataan,
						ph.pilihan,
						ph.nilai
				from pd.pnbp_pernyataan pp
				inner join pd.pnbp_aspek pa 
					on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
					on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
					on 1 = 1
				inner join pd.pnbp_urutan_questioner puq 
					on puq.id_pernyataan::int = pp.id_pernyataan
				inner join pd.pnbp_hasil ph
					on pp.id_pernyataan = ph.id_pernyataan
				where ph.noind = '$noind'
				and ph.id_periode = '$id_periode'
				order by pk.id_kelompok,
						puq.no_urut::int";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getAkumulasiPeserta($noind,$id_periode){
		$sql = "select 	pk.kelompok,
						pa.nama_aspek,
						sum(ph.nilai) nilai
				from pd.pnbp_pernyataan pp
				inner join pd.pnbp_aspek pa 
					on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
					on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
					on 1 = 1
				inner join pd.pnbp_urutan_questioner puq 
					on puq.id_pernyataan::int = pp.id_pernyataan
				inner join pd.pnbp_hasil ph
					on pp.id_pernyataan = ph.id_pernyataan
				where ph.noind = '$noind'
				and ph.id_periode = '$id_periode'
				group by pk.id_kelompok,pk.kelompok,pa.nama_aspek
				order by pk.id_kelompok,pa.nama_aspek";
		$result = $this->db->query($sql);
		return $result->result_array();		
	}

	public function getPernyataan($id_periode){
		$sql = "select 	puq.no_urut,
						pk.kelompok,
						pa.nama_aspek,
						pp.pernyataan
				from pd.pnbp_pernyataan pp
				inner join pd.pnbp_aspek pa 
					on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
					on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
					on 1 = 1
				inner join pd.pnbp_urutan_questioner puq 
					on puq.id_pernyataan::int = pp.id_pernyataan
				where puq.id_periode = '$id_periode'
				order by pk.id_kelompok,
						puq.no_urut::int";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getAspek($id_periode){
		$sql = "select 	pk.kelompok,
						pa.nama_aspek
				from pd.pnbp_pernyataan pp
				inner join pd.pnbp_aspek pa 
					on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
					on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
					on 1 = 1
				inner join pd.pnbp_urutan_questioner puq 
					on puq.id_pernyataan::int = pp.id_pernyataan
				where puq.id_periode = '$id_periode'
				group by pk.id_kelompok,pk.kelompok,pa.nama_aspek
				order by pk.id_kelompok,pa.nama_aspek";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>