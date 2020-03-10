<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_pekerjakhusus extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getPekerjaKhususAll(){
		$sql = "select tkgr.*,tkgf.*,tp.nama
				from \"Presensi\".t_komponen_gaji_reffgaji tkgr
				inner join \"Presensi\".t_komponen_gaji_formula tkgf
				on tkgr.formula_id = tkgf.formula_id
				inner join hrd_khs.tpribadi tp
				on tp.noind = tkgr.noind
				order by tkgr.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerjaKhususByNoind($noind,$noind_baru){
		$sql = "select tkgr.*,tkgf.*,tp.nama
				from \"Presensi\".t_komponen_gaji_reffgaji tkgr
				inner join \"Presensi\".t_komponen_gaji_formula tkgf
				on tkgr.formula_id = tkgf.formula_id
				inner join hrd_khs.tpribadi tp
				on tp.noind = tkgr.noind
				where tkgr.noind = '$noind'
				and tkgr.noind_baru = '$noind_baru'
				order by tkgr.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getFormulaAll(){
		$sql = "select *
				from \"Presensi\".t_komponen_gaji_formula";
		return $this->personalia->query($sql)->result_array();
	}

	public function getEmployeeByParams($key){
		$sql = "select tp.noind,tp.nama from hrd_khs.tpribadi tp
				left join \"Presensi\".t_komponen_gaji_reffgaji tkgr 
				on tkgr.noind = tp.noind and tkgr.noind_baru = tp.noind_baru
				where (tp.noind like upper('%$key%') or tp.nama like upper('%$key%')) 
				and tp.keluar='0'
				and tkgr.noind is null";
		return $this->personalia->query($sql)->result_array();
	}

	public function savePekerjaKhusus($data){
		$this->personalia->insert("\"Presensi\".t_komponen_gaji_reffgaji",$data);
	}

	public function getNoindBaru($noind){
		$sql = "select noind_baru from hrd_khs.tpribadi where noind = '$noind'";
		return $this->personalia->query($sql)->row()->noind_baru;
	}

	public function deletePekerjaKhusus($noind,$noind_baru){
		$sql = "delete from \"Presensi\".t_komponen_gaji_reffgaji where noind = '$noind' and noind_baru = '$noind_baru'";
		$this->personalia->query($sql);
	}

	public function updatePekerjaKhusus($noind,$noind_baru,$data){
		$this->personalia->where('noind',$noind);
		$this->personalia->where('noind_baru',$noind_baru);
		$this->personalia->update("\"Presensi\".t_komponen_gaji_reffgaji",$data);
	}

}

?>