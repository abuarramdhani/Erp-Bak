<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
* 
*/
class M_cetakhasil extends Ci_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',true);
	}

	public function getperiodeAssessment(){
		$sql = "select distinct periode from pk.pk_assessment";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getAssessment($periode){
		$sql = "select 	pass.noind,
						pass.nama,
						pass.nama_unit unit,
						pass.nama_seksi seksi,
						coalesce(pass.total_nilai, 0) skor,
						pass.gol_kerja,
						pass.gol_nilai,
						case when pass.lokasi_kerja = '02' then
							(coalesce(pken.nominal_kenaikan, 0) - (select tuksono::int from pk.pk_penyesuaian))
						when pass.lokasi_kerja = '03' then
							(coalesce(pken.nominal_kenaikan, 0) - (select mlati::int from pk.pk_penyesuaian))
						else
							coalesce(pken.nominal_kenaikan, 0)
						end nominal_kenaikan,
						coalesce(pgap.gp::int, 0) gp_lama,
						coalesce(case when pass.lokasi_kerja = '02' then
							((coalesce(pken.nominal_kenaikan, 0) - (select tuksono::int from pk.pk_penyesuaian))+pgap.gp::int)
						when pass.lokasi_kerja = '03' then
							((coalesce(pken.nominal_kenaikan, 0) - (select mlati::int from pk.pk_penyesuaian))+pgap.gp::int)
						else
							(coalesce(pken.nominal_kenaikan, 0)+pgap.gp::int)
						end, 0) gp_baru
				from pk.pk_assessment pass
				left join pk.pk_kenaikan pken
					on pass.id_kenaikan = pken.id_kenaikan
				left join pk.pk_gapok pgap
					on extract(year from pass.periode_akhir)::varchar = pgap.tahun::varchar
					and pass.noind = pgap.noind
				where pass.periode = '$periode'
				order by kodesie;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPekerjaan($noind){
		// $sql = "select pekerjaan 
		// 		from hrd_khs.tpribadi tpri
		// 		inner join hrd_khs.tpekerjaan tpkj
		// 		on tpri.kd_pkj = tpkj.kdpekerjaan
		// 		where tpri.noind = '$noind'";
		$sql = "select sec.job_name pekerjaan 
				from er.er_employee_all emp
				left join er.er_section sec 
				on sec.section_code = emp.section_code
				where emp.employee_code = '$noind'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertHasil($data){
		$this->db->insert('pk.pk_hasil',$data);
	}

	public function getHasil($no,$tgl){
		$sql = "select * 
		from pk.pk_hasil 
		where no_skdu = '$no' and tgl_skdu = '$tgl'
		order by unit,seksi,gol_kerja,pekerjaan,noind";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function checkHasil($periode,$noind){
		$sql = "select * from pk.pk_hasil where periode = '$periode' and noind = '$noind'";
		$result = $this->db->query($sql);
		return $result->num_rows();
	}

	public function updateHasil($data,$where){
		$this->db->where($where);
		$this->db->update('pk.pk_hasil',$data);
	}

	public function getTahun($no,$tgl){
		$sql = "select distinct (left(split_part(periode,'-',2),4)::int +1)::text tahun, tgl_skdu
		from pk.pk_hasil 
		where no_skdu = '$no' and tgl_skdu = '$tgl'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>