<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_presensibulanan extends Ci_Model
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
	    }elseif ($noind == 'J1378') { //Order #112817 (Pembuatan Login ERP)
	    	 $sql = "select a.noind,a.nama, b.seksi 
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b on a.kodesie=b.kodesie
	    		where left(a.kodesie,5) in ('10101','10102')
	    		and a.keluar = false
				order by a.kodesie,a.noind;";    
	    }    else{
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
		$sql = "select 	case when kd_ket in ('PKJ','PLB') then
							case when 	(
											select count(*) 
											from \"Presensi\".tdatapresensi
											where noind = '$noind' 
											and tanggal = '$tgl' 
											and kd_ket not in ('PKJ','PLB')
										) > 0 then
								(	select kd_ket
									from \"Presensi\".tdatapresensi
									where noind = '$noind' 
									and tanggal = '$tgl' 
									and kd_ket not in ('PKJ','PLB') limit 1 
								)
							else
							'/'
							end
						else 
							kd_ket
						end
				from \"Presensi\".tdatapresensi tp
				inner join \"Presensi\".tshiftpekerja ts
				on ts.noind = tp.noind and ts.tanggal = tp.tanggal
				where tp.noind = '$noind' 
				and tp.tanggal = '$tgl'
				union
				select kd_ket
				from \"Presensi\".tdatatim tt
				inner join \"Presensi\".tshiftpekerja ts
				on ts.noind = tt.noind and ts.tanggal = tt.tanggal
				where tt.noind = '$noind' 
				and tt.tanggal = '$tgl'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getTanggal($tgl){
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "select cast(dates as date) tanggal,to_char(dates,'dd') tgl, to_char(dates,'monthyyyy') bulan
				from generate_series('$tgl1','$tgl2',interval '1 days') as dates";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
}
?>