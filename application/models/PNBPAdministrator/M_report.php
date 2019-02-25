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

	public function getData($noind,$id_periode){
		$sql = "select pk.kelompok,
				pa.nama_aspek,
				((sum(ph.nilai)::numeric/count(pa.nama_aspek)::numeric)/4)*100 nilai 
				from pd.pnbp_pernyataan pp 
				inner join pd.pnbp_aspek pa 
				on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
				on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
				on 1 = 1
				left join pd.pnbp_hasil ph 
				on ph.id_periode::int = prd.id_periode
				and ph.id_pernyataan::int = pp.id_pernyataan
				where ph.noind = '$noind'
				and ph.id_periode = '$id_periode'
				and pa.nama_aspek != 'KEPUASAN KERJA'
				group by pk.id_kelompok,pk.kelompok,pa.nama_aspek
				order by pk.id_kelompok,pa.nama_aspek";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDataKecil1($noind,$id_periode){
		$sql = "select pk.kelompok,
				pa.nama_aspek,
				((sum(ph.nilai)::numeric/count(pa.nama_aspek)::numeric)/4)*(100::numeric/7) nilai 
				from pd.pnbp_pernyataan pp 
				inner join pd.pnbp_aspek pa 
				on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
				on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
				on 1 = 1
				left join pd.pnbp_hasil ph 
				on ph.id_periode::int = prd.id_periode
				and ph.id_pernyataan::int = pp.id_pernyataan
				where ph.noind = '$noind'
				and ph.id_periode = '$id_periode'
				and pa.nama_aspek != 'KEPUASAN KERJA'
				group by pk.id_kelompok,pk.kelompok,pa.nama_aspek
				order by pk.id_kelompok,pa.nama_aspek";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDataKecil2($noind,$id_periode){
		$sql = "select 'KESELURUHAN'as kelompok,
				pa.nama_aspek,
				((sum(ph.nilai)::numeric/count(pa.nama_aspek)::numeric)/4)*(100::numeric/7) nilai 
				from pd.pnbp_pernyataan pp 
				inner join pd.pnbp_aspek pa 
				on pp.id_aspek::int = pa.id_aspek
				inner join pd.pnbp_kelompok pk 
				on pa.id_kelompok::int = pk.id_kelompok
				inner join pd.pnbp_periode prd
				on 1 = 1
				left join pd.pnbp_hasil ph 
				on ph.id_periode::int = prd.id_periode
				and ph.id_pernyataan::int = pp.id_pernyataan
				where ph.noind = '$noind'
				and ph.id_periode = '$id_periode'
				and pa.nama_aspek != 'KEPUASAN KERJA'
				group by pa.nama_aspek
				order by pa.nama_aspek";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getLabel(){
		$sql = "select distinct nama_aspek from pd.pnbp_aspek where nama_aspek != 'KEPUASAN KERJA'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getDemografi($noind,$id_periode){
		$sql = "select 	dem.noind,dem.nama , 
						case when dem.jk = 'L' then 
							'Laki-Laki' 
						else 
							'Perempuan' 
						end jenkel ,
						dem.status_kerja,
						suk.nama_suku,
						usi.usia, 
						mas.masa_kerja ,
						pen.pendidikan ,
						sec.section_name ,
						sec.department_name,
						(select sum(has.nilai)/count(has.nilai) 
						from pd.pnbp_pernyataan pp 
						inner join pd.pnbp_aspek pa 
						on pp.id_aspek::int = pa.id_aspek
						inner join pd.pnbp_kelompok pk 
						on pa.id_kelompok::int = pk.id_kelompok
						inner join pd.pnbp_hasil has
						on has.id_periode = dem.id_periode
						and has.id_pernyataan::int = pp.id_pernyataan
						where has.noind = dem.noind
						and pa.nama_aspek = 'KEPUASAN KERJA' 
						) kepuasan
				from pd.pnbp_demografi dem 
				inner join er.er_employee_all emp 
					on emp.employee_code = dem.noind
				inner join er.er_section sec 
					on sec.section_code = dem.kodesie
				inner join pd.pnbp_usia usi
					on usi.id_usia = dem.usia::int
				inner join pd.pnbp_masa_kerja mas 
					on mas.id_masa_kerja = dem.masa_kerja::int 
				inner join pd.pnbp_pendidikan pen 
					on pen.id_pendidikan = dem.pendidikan_terakhir::int
				inner join pd.pnbp_suku suk 
					on suk.id_suku = dem.suku::int
				where dem.noind = '$noind' 
				and dem.id_periode = '$id_periode'";
	$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>