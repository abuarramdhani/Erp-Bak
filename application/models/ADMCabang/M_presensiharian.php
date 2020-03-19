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

	public function ambilNamaPekerjaByNoind($noind)
	{
		$sql = "select nama from hrd_khs.tpribadi where noind = '$noind'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	public function getSeksiByKodesie($kd){
		$sql = "select kodesie,seksi from hrd_khs.tseksi where kodesie = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPekerjaByKodesie($kd){
		$noind = $this->session->user;
		if ($noind == 'B0380') { // ada di ticket
			 $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
				where (left(a.kodesie,7) = left('$kd',7) or a.noind in ('J1171','J7004','L8001'))
				and a.keluar = false
				order by a.kodesie,a.noind;";
		}elseif ($noind == 'B0370') { //ada di ticket
			 $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
				where (left(a.kodesie,7) = left('$kd',7) or a.noind in ('D1535','P0426'))
				and a.keluar = false
				order by a.kodesie,a.noind;";
		}elseif ($noind == 'H7726') { //Order #972784 (PENAMBAHAN AKSES BUKA PRESENSI DI PROGRAM ERP)
	    	 $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
	    		where left(a.kodesie,5) = left('$kd',5)
	    		and a.keluar = false
				order by a.kodesie,a.noind;";
		}elseif ($noind == 'B0717') { //Order ##954281 (PERMOHONAN HAK AKSES DI PROGRAM ERP)
	    	 $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
	    		where left(a.kodesie,7) in (select left(kodesie,7) from hrd_khs.trefjabatan where noind = 'B0717')
	    		and a.keluar = false
				order by a.kodesie,a.noind;";
	    }elseif ($noind == 'J1378') { //Order #112817 (Pembuatan Login ERP)
	    	 $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
	    		where left(a.kodesie,5) in ('10101','10102')
	    		and a.keluar = false
				order by a.kodesie,a.noind;";
	    }elseif ($noind == 'J1338') { //Order #456799 (Pembuatan Login ERP)
	    	 $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
	    		where left(a.kodesie,3) in ('302','324','325')
	    		and a.keluar = false
				order by a.kodesie,a.noind;";
	    }elseif ($noind == 'H8455') { //Order #574033 dapat mengakses Presensi Harian gudang PPB dan Produksi & Expedisi Pusat
	    	 $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
	    		where left(a.kodesie,7) in ('3070103','3070201','3070301')
	    		and a.keluar = false
				order by a.kodesie,a.noind;";
	    }else{
			    if('306030'==substr($kd,0,6)) //ada diticket
			    {
			    $sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
						where left(a.kodesie,6) = left('$kd',6)
						and a.keluar = false
						order by a.kodesie,a.noind;";
			    }
			    else
			    {
				$sql = "select a.noind,a.nama, b.seksi
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
						where left(a.kodesie,7) = left('$kd',7)
						and a.keluar = false
						order by a.kodesie,a.noind;";
			    }
		}

		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPresensiByNoind($noind,$tgl){
		if($noind=='L8001')
		{
			$sql = "select waktu
				from \"Presensi\".tprs_shift2 tp
				where tp.noind = '$noind'
				and tp.tanggal = '$tgl'
				order by tp.waktu";
		}
		else
		{
			$sql = "select waktu
				from \"FrontPresensi\".tpresensi tp
				where tp.noind = '$noind'
				and tp.tanggal = '$tgl'
				order by tp.waktu";
		}
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPresensiArrayNoind($noind,$tgl){
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select tp.noind,tp.tanggal,tp.waktu
				from \"FrontPresensi\".tpresensi tp
				where tp.noind in ($noind)
				and tp.tanggal between '$tgl1' and '$tgl2'
				order by tp.noind,tp.tanggal,tp.waktu";
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

	public function getTIMArrayNoind($noind,$tgl){
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select noind,tanggal,point
				from \"Presensi\".tdatatim
				where noind in ($noind)
				and tanggal between '$tgl1' and '$tgl2'
				order by noind,tanggal";
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

	public function getKeteranganArrayNoind($noind,$tgl){
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select tp.noind,tp.tanggal,tk.keterangan
				from (
					select noind,tanggal,kd_ket
					from \"Presensi\".tdatapresensi
					where noind in ($noind)
					and tanggal between '$tgl1' and '$tgl2'
					and kd_ket != 'PKJ'
					union
					select noind,tanggal,kd_ket
					from \"Presensi\".tdatatim
					where noind in ($noind)
					and tanggal between '$tgl1' and '$tgl2'
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
									where tsp.noind = '$noind'
									and tsp.tanggal between '$tgl1' and '$tgl2'
										)
				) as shift
				order by shift.tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getShiftArrayNoind($noind,$tgl){
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select * from
				(
					select tsp.noind,tsp.tanggal,
					to_char(tsp.tanggal,'dd/mm/yyyy') tgl,
					ts.shift
					from \"Presensi\".tshiftpekerja tsp
					inner join \"Presensi\".tshift ts
						on ts.kd_shift = tsp.kd_shift
					where tsp.noind in ($noind)
					and tsp.tanggal between '$tgl1' and '$tgl2'
				) as shift
				order by shift.noind,shift.tanggal";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}


}
?>
