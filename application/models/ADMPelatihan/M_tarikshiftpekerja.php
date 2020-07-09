<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_tarikshiftpekerja extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',true);
	}

	public function getData($periode1,$periode2,$hubungan,$kdsie = FALSE){
		if (isset($kdsie) and !empty($kdsie)) {
			$kd = " and b.kodesie like '$kdsie%'";
		}else{
			$kd = '';
		}

		$sql= "SELECT distinct a.noind, a.kodesie,  trim(b.nama) as nama,trim(d.seksi)as seksi
				FROM  \"Presensi\".tshiftpekerja a
				INNER JOIN hrd_khs.TPribadi b ON b.noind=a.noind 
				inner join  \"Presensi\".tshift c on a.kd_shift=c.kd_shift
				inner join hrd_khs.tseksi d on d.kodesie=b.kodesie
				WHERE b.keluar='0'and ( a.tanggal between '$periode1' and '$periode2' )AND left(a.noind,1) in ($hubungan) $kd
				ORDER BY  a.kodesie,a.noind ";
				


			
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function getDataDetail($noind,$tanggal){
		$sql= "SELECT a.tanggal, a.noind, a.kodesie, c.inisial,
					to_char(a.tanggal,'yyyymmdd') as index_tanggal
				FROM  \"Presensi\".tshiftpekerja a 
				inner join  \"Presensi\".tshift c on a.kd_shift=c.kd_shift
				WHERE a.tanggal = '$tanggal' and a.noind = '$noind'
				ORDER BY  noind";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}


	public function statusKerja()
	{
		$sql = "SELECT * FROM hrd_khs.tnoind ORDER BY fs_noind";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}
	public function getTanggalByParams($awal,$akhir)
	{
		$sql= "select to_char(dates.dates,'yyyymmdd') as index_tanggal , date_part('day', dates.dates) as hari, 
					date_part('month', dates.dates) as bulan,date_part('year', dates.dates) as tahun, dates.dates::date as tanggal
				from generate_series('$awal'::date, '$akhir'::date, '1 day') as dates ";
		return $this->personalia->query($sql)->result_array();
	}

}
?>
