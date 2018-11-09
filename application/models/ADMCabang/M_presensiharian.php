<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_presensiharian extends Ci_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',true);
	}

	public function getSeksiByKodesie($kd){
		$sql = "select kodesie,seksi from hrd_khs.tseksi where kodesie = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPekerjaByKodesie($kd){
		$sql = "select noind,nama 
				from hrd_khs.tpribadi 
				where left(kodesie,7) = left('$kd',7) 
				and keluar = false
				order by noind;";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPresensiByNoind($noind,$tgl){
		$sql = "select waktu
				from \"FrontPresensi\".tpresensi tp
				where tp.noind = '$noind' 
				and tp.tanggal = '$tgl'
				order by tp.waktu";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getTIMByNoind($noind,$tgl){
		$sql = "select sum(point) point
				from \"Presensi\".tdatatim 
				where noind = '$noind' 
				and tanggal = '$tgl'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getKeteranganByNoind($noind,$tgl){
		$sql = "select tk.keterangan
				from (
					select kd_ket
					from \"Presensi\".tdatapresensi 
					where noind = '$noind' 
					and tanggal = '$tgl'
					and kd_ket != 'PKJ'
					union
					select kd_ket
					from \"Presensi\".tdatatim 
					where noind = '$noind' 
					and tanggal = '$tgl'
				) as tp 
				inner join \"Presensi\".tketerangan tk on tp.kd_ket = tk.kd_ket";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getShiftByNoind($noind,$tgl){
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select * from
				(
					select tsp.tanggal,
					to_char(tsp.tanggal,'dd/mm/yyyy') tgl,
					ts.shift 
					from \"Presensi\".tshiftpekerja tsp
					inner join \"Presensi\".tshift ts 
						on ts.kd_shift = tsp.kd_shift
					where tsp.noind = '$noind' 
					and tsp.tanggal between '$tgl1' and '$tgl2'
					union
					select cast(dates as date) , to_char(dates,'dd/mm/yyyy') tgl, null
					from generate_series('$tgl1','$tgl2',interval '1 days') as dates
					where dates not in(
									select tsp.tanggal
									from \"Presensi\".tshiftpekerja tsp
									where tsp.noind = 'F2228' 
									and tsp.tanggal between '$tgl1' and '$tgl2'
										)
				) as shift
				order by shift.tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
}
?>