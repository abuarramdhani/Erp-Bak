<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_penguranganpuasa extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function getPekerjaKHSIslam(){
		$sql = "select tp.noind,tp.nama,tp.kodesie, ts.seksi
				from hrd_khs.tpribadi tp
				inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie
				where upper(trim(agama)) = 'ISLAM' 
				and keluar = '0' 
				order by noind";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPuasaPekerja($noind,$tgl1,$tgl2){
		$sql = "select cast(fd_tanggal as date) tanggal,
						fs_noind noind,
						fs_tempat_makan tmp_makan,
						fb_status status,
						(select count(*)
							from \"Catering\".tpuasa 
							where fs_noind = '$noind' 
							and fd_tanggal 
							between '$tgl1' and '$tgl2'
						) banyak
				from \"Catering\".tpuasa 
				where fs_noind = '$noind' 
				and fd_tanggal 
				between '$tgl1' and '$tgl2'  
				order by fd_tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPekerjaHKSIslamByNoind($noind){
		$sql = "select tp.noind,tp.nama,tp.kodesie, ts.seksi
				from hrd_khs.tpribadi tp
				inner join hrd_khs.tseksi ts on tp.kodesie = ts.kodesie
				where upper(trim(agama)) = 'ISLAM' 
				and keluar = '0' 
				and noind = '$noind'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function updatePuasaByTanggalNoind($tgl,$noind,$status){
		$sql = "update \"Catering\".tpuasa set fb_status = '$status' where fd_tanggal between '".$tgl['0']."' and '".$tgl['1']."' and fs_noind = '$noind'";
		$this->personalia->query($sql);
	}

	public function deletePuasaByTanggalNoind($tgl,$noind){
		$sql = "delete from \"Catering\".tpuasa where fd_tanggal between '".$tgl['0']."' and '".$tgl['1']."' and fs_noind = '$noind'";
		$this->personalia->query($sql);
	}
}
?>