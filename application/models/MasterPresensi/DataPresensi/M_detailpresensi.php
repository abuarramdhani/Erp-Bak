<?php 
Defined('BASEPATH') or exit("No DIrect Script Access Allowed");

/**
 * 
 */
class M_detailpresensi extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', true);
	}

	function getLokasiKerja()
	{
		$sql = "select id_ as kode_lokasi,lokasi_kerja as nama_lokasi
			from hrd_khs.tlokasi_kerja
			order by id_";
		return $this->personalia->query($sql)->result_array();
	}
	
	function getKodeInduk()
	{
		$sql = "select fs_noind as noind,fs_ket as ket
			from hrd_khs.tnoind
			order by fs_noind";
		return $this->personalia->query($sql)->result_array();
	}

	function getTanggalDefault(){
		$sql= "select to_char(dates.dates,'yyyymmdd') as index_tanggal , date_part('day', dates.dates) as hari, 
					date_part('month', dates.dates) as bulan,date_part('year', dates.dates) as tahun, dates.dates::date as tanggal
				from generate_series(now() - interval '2 month', now(), '1 day') as dates
				where date_part('month',dates.dates) = date_part('month',now() - interval '1 month') ";
		return $this->personalia->query($sql)->result_array();
	}

	function cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai){
		$jam_ijin = 0;
		
		if($ist_mulai < $break_mulai ){
	        $aa = $break_mulai;
	        $bb = $break_selesai;
	        $break_mulai = $ist_mulai;
	        $break_selesai = $ist_selesai;
	        $ist_mulai = $aa;
	        $ist_selesai = $bb;
	    }

	    if($keluar >= $ist_mulai && $masuk >= $ist_mulai){
	        if($ist_selesai >= $keluar && $ist_selesai >= $masuk){
	            $lama_izin = $masuk - $keluar;
	            $lama_istirahat = $ist_selesai - $ist_mulai;
	            $jam_ijin = $lama_izin - $lama_istirahat;          
	        }elseif($keluar >= $ist_selesai && $masuk >= $ist_selesai){
	            $jam_ijin = $masuk - $keluar;
	        }else{
	            $jam_ijin = $masuk - $ist_selesai;
	        }
	    }elseif($keluar <= $ist_mulai && $masuk >= $ist_mulai){
	        if($ist_selesai >= $keluar && $ist_selesai >= $masuk){
	            if($keluar <= $break_mulai && $keluar <= $break_selesai){
	                $sebelum_break = $break_mulai - $keluar;
	                $setelah_break = $ist_mulai - $break_selesai;
	                $jam_ijin = $sebelum_break + $setelah_break;              
	            }elseif($keluar > $break_mulai && $keluar <= $break_selesai){
	                $jam_ijin = $ist_mulai - $break_selesai;
	            }else{
	                $jam_ijin = $ist_mulai - $keluar;
	                if($jam_ijin <= 30){
	                    $jam_ijin = 0;
	                }else{
	                    $jam_ijin = $jam_ijin;
	                }                
	            }        
	        }elseif($keluar <= $ist_selesai && $masuk > $ist_selesai){
	            if($keluar <= $break_mulai){
	                $sebelum_break = $break_mulai - $keluar;
	                $sebelum_istirahat = $ist_mulai - $break_selesai;
	                $setelah_istirahat = $masuk - $ist_selesai;
	                if($sebelum_break < 0){
	                    $sebelum_break = 0;
	                }
	                if($sebelum_istirahat < 0){
	                    $sebelum_istirahat = 0;
	                }
	                if($setelah_istirahat < 0){
	                    $setelah_istirahat = 0;
	                }
	                $jam_ijin = $sebelum_break + $sebelum_istirahat + $setelah_istirahat;
	            }elseif($keluar > $break_mulai && $keluar >= $break_selesai){
	                $sebelum_istirahat = $ist_mulai - $keluar;
	                $setelah_istirahat = $masuk - $ist_selesai;
	                $jam_ijin = $sebelum_istirahat + $setelah_istirahat;
	            }elseif($keluar >= $break_mulai && $keluar <= $break_selesai){
	                $sebelum_istirahat = $ist_mulai - $break_selesai;
	                $setelah_istirahat = $masuk - $ist_selesai;
	                $jam_ijin = $sebelum_istirahat + $setelah_istirahat;
	            }
	        }
	    }else{
	        if($keluar >= $break_mulai && $masuk >= $break_mulai){
	            if($break_selesai >= $keluar && $break_selesai >= $masuk){
	                $jam_ijin = 0;
	            }elseif($keluar >= $break_selesai && $masuk >= $break_selesai){
	                $jam_ijin = $masuk - $keluar;
	            }else{
	                $jam_ijin = $masuk - $break_selesai;
	            }            
	        }elseif($keluar <= $break_mulai && $masuk >= $break_mulai){
	            if($break_selesai >= $keluar && $break_selesai >= $masuk){
	                $jam_ijin = $break_mulai - $keluar;
	            }else{
	                $sebelum_break = $break_mulai - $keluar;
	                $setelah_break = $masuk - $break_selesai;
	                $jam_ijin = $sebelum_break + $setelah_break;                
	            }
	        }else{
	            $jam_ijin = $masuk - $keluar;
	        }        
	    }

	    if ($jam_ijin > 0 && $jam_ijin < 60) {
	        $jam_ijin = $jam_ijin/60;
	    }else if($jam_ijin >= 60){
	        $jam_ijin = $jam_ijin/60;
	    }else if($jam_ijin < 0){
	    	$jam_ijin = 0;
	    }
	    
		return $jam_ijin;
	}

	function getProporsionalTIK($noind,$tanggal){
		$sql = "SELECT a.tanggal, a.noind,
						concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
						case when a.masuk::time < a.keluar::time then
							concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
						else
							concat(a.tanggal::date,' ',a.masuk)::timestamp
						end as masuk,
						a.kd_ket,
						b.jam_kerja,
						case when b.jam_msk::time > b.ist_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
						end as ist_mulai,
						case when b.jam_msk::time > b.ist_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
						end as ist_selesai,
						case when b.jam_msk::time > b.break_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_mulai)::timestamp
						end as break_mulai,
						case when b.jam_msk::time > b.break_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_selesai)::timestamp
						end as break_selesai
				FROM \"Presensi\".TDataTIM a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind')
				ORDER BY tanggal";

		$result2 = 	$this->personalia->query($sql)->result_array();
		$nilai = 0;
		$simpan_tgl = "";
		$lanjut = false;
		foreach ($result2 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$lanjut = false;
			}
			$keluar = strtotime($tik['keluar']);
			$masuk = strtotime($tik['masuk']);
			$ist_mulai = strtotime($tik['ist_mulai']);
			$ist_selesai = strtotime($tik['ist_selesai']);
			$break_mulai = strtotime($tik['break_mulai']);
			$break_selesai = strtotime($tik['break_selesai']);
			if ($ist_mulai < $break_mulai) {
				$simpan_ist_mulai = $ist_mulai;
				$simpan_ist_selesai = $ist_selesai;
				$ist_mulai = $break_mulai;
				$ist_selesai = $break_selesai;
				$break_mulai = $simpan_ist_mulai;
				$break_selesai = $simpan_ist_selesai;
			}

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai) / ($tik['jam_kerja'] * 60);
			
			$ijin = number_format($ijin, 2);
			$nilai += $ijin;
			
			$simpan_tgl = $tik['tanggal'];
		}
			
		return (1 - $nilai);
	}

	function getAbsenByParams($kode_induk,$lokasi_kerja,$periode,$pekerja_keluar,$periode_pekerja_keluar,$kodesie){
		$prd = explode(" - ", $periode);
		$awal = $prd[0];
		$akhir = $prd[1];

		$prd_pk = explode(" - ", $periode_pekerja_keluar);
		$awal_pk = $prd_pk[0];
		$akhir_pk = $prd_pk[1];

		if ($pekerja_keluar == 'true') {
			$status = " b.keluar = '1' and b.tglkeluar between '$awal_pk' and '$akhir_pk' ";
			
		}else{
			$status = " b.keluar = '0' and b.masukkerja <= '$akhir' ";
		}

		if (!empty(trim($kode_induk)) && trim($kode_induk) != "0") {
			$noind = " AND left(a.noind,1) = '$kode_induk' ";
		}else{
			$noind = "";
		}

		if (!empty(trim($lokasi_kerja)) && trim($lokasi_kerja) != "0") {
			$lokasi = " AND b.lokasi_kerja = '$lokasi_kerja' ";
		}else{
			$lokasi = "";
		}

		if (!empty($kodesie) && $kodesie != "0") {
			$kdsie = " and b.kodesie like '$kodesie%'";
		}else{
			$kdsie = "";
		}

		$sql = "(SELECT a.tanggal, a.noind, b.kodesie, trim(a.kd_ket) as kd_ket, trim(b.nama) as nama, c.unit,c.seksi,
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatatim a
				INNER JOIN hrd_khs.TPribadi b
				ON b.noind=a.noind 
				left join hrd_khs.tseksi c 
				on b.kodesie = c.kodesie
				WHERE $status and tanggal between '$awal' and '$akhir' $noind $lokasi $kdsie
				)
				UNION 
				(SELECT a.tanggal, a.noind, b.kodesie, trim(a.kd_ket) as kd_ket, b.nama, c.unit,c.seksi,
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatapresensi a
				INNER JOIN hrd_khs.TPribadi b 
				ON b.noind=a.noind 
				left join hrd_khs.tseksi c 
				on b.kodesie = c.kodesie
				WHERE $status and tanggal between '$awal' and '$akhir' $noind $lokasi $kdsie
				)
				ORDER BY  kodesie,noind,tanggal, kd_ket";
				// echo "<pre>".$sql;exit();
		return $this->personalia->query($sql)->result_array();
	}

	public function getLemburByParams($kode_induk,$lokasi_kerja,$periode,$pekerja_keluar,$periode_pekerja_keluar,$kodesie){
		$prd = explode(" - ", $periode);
		$awal = $prd[0];
		$akhir = $prd[1];

		$prd_pk = explode(" - ", $periode_pekerja_keluar);
		$awal_pk = $prd_pk[0];
		$akhir_pk = $prd_pk[1];

		if ($pekerja_keluar == 'true') {
			$status = " b.keluar = '1' and b.tglkeluar between '$awal_pk' and '$akhir_pk' ";
			
		}else{
			$status = " b.keluar = '0' and b.masukkerja <= '$akhir' ";
		}

		if (!empty(trim($kode_induk)) && trim($kode_induk) != "0") {
			$noind = " AND left(a.noind,1) = '$kode_induk' ";
		}else{
			$noind = "";
		}

		if (!empty(trim($lokasi_kerja)) && trim($lokasi_kerja) != "0") {
			$lokasi = " AND b.lokasi_kerja = '$lokasi_kerja' ";
		}else{
			$lokasi = "";
		}

		if (!empty($kodesie) && $kodesie != "0") {
			$kdsie = " and b.kodesie like '$kodesie%'";
		}else{
			$kdsie = "";
		}
		$sql = "(SELECT a.tanggal, a.noind, b.kodesie, trim(b.nama) as nama, sum(a.total_lembur ) total_lembur ,to_char(a.tanggal,'yyyymmdd') as index_tanggal ,c.unit,c.seksi
				FROM \"Presensi\".TDataPresensi a
				INNER JOIN hrd_khs.TPribadi b ON b.Noind = a.noind 
				left join hrd_khs.tseksi c on b.kodesie = c.kodesie
				WHERE $status and a.tanggal between '$awal' and '$akhir' $noind $lokasi $kdsie
				and a.total_lembur > 0
				GROUP BY a.tanggal, a.noind, b.kodesie, b.nama,c.unit,c.seksi ) 
				ORDER BY b.kodesie, a.noind, a.tanggal";

		return $this->personalia->query($sql)->result_array();
	}

	function getSusulan($kd_ket,$noind,$tanggal){
		$sql = "select * from \"Presensi\".tsusulan 
                where noind = '$noind' and tanggal = '$tanggal'
                and ket like '%$kd_ket%'";
        return $this->personalia->query($sql)->result_array();
	}

	function getTanggalByParams($periode){
		$prd = explode(" - ", $periode);
		$awal = $prd[0];
		$akhir = $prd[1];
		$sql= "select to_char(dates.dates,'yyyymmdd') as index_tanggal , date_part('day', dates.dates) as hari, 
					date_part('month', dates.dates) as bulan,date_part('year', dates.dates) as tahun, dates.dates::date as tanggal
				from generate_series('$awal'::date, '$akhir'::date, '1 day') as dates ";
		return $this->personalia->query($sql)->result_array();
	}

	function getInisial($noind,$tanggal){
		$sql = "select trim(b.inisial) as inisial 
				from \"Presensi\".tshiftpekerja a 
				inner join \"Presensi\".tshift b 
				on a.kd_shift = b.kd_shift
				where noind = '$noind'
				and tanggal = '$tanggal'";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->inisial;
		}else{
			return "<span style='color: red'>S?</span>";
		}
		
	}

	function getWaktuAbsen($noind,$awal,$akhir){
		$sql = "select tanggal::date as tanggal,waktu, b.nama
				from \"Presensi\".tprs_shift a 
				inner join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				where a.noind = '$noind'
				and tanggal between '$awal' and '$akhir'
				order by tanggal, waktu";
		return $this->personalia->query($sql)->result_array();
	}

	function getKodesie($key,$kodesie,$tingkat)
	{
		$panjang = strlen($kodesie);
		$where_kodesie = " and left(kodesie,$panjang) = '$kodesie' ";

		switch ($tingkat) {
			case '1':
				$where_kodesie = "";
				$where_key = " and (dept like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, dept as nama";
				$tambahan = " union select '0' as kode, 'Semua Departemen' as nama";
				break;
			case '3':
				$where_key = " and (bidang like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(bidang) = '-' then 'Hanya tingkat Departemen' else bidang end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Bidang' as nama";
				break;
			case '5':
				$where_key = " and (unit like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(unit) = '-' then 'Hanya tingkat Bidang' else unit end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Unit' as nama";
				break;
			case '7':
				$where_key = " and (seksi like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(seksi) = '-' then 'Hanya tingkat Unit' else seksi end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Seksi' as nama";
				break;
			case '9':
				$where_key = " and (pekerjaan like '%$key%' or kodesie like '$key%') ";
				$select = " left(kodesie,$tingkat) as kode, 
					case when trim(pekerjaan) = '-' then 'Hanya tingkat Seksi' else pekerjaan end as nama";
				$tambahan = " union select '$kodesie' as kode, 'Semua Pekerjaan' as nama";
				break;
			default:
				$where_kodesie = "";
				$where_key = "";
				$select = " kodesie as kode, dept as nama";
				break;
		}
		$sql = "select distinct $select
			from hrd_khs.tseksi
			where kodesie != '-'
			$where_kodesie
			$where_key
			$tambahan
			order by 1";
		return $this->personalia->query($sql)->result_array();
	}
}
?>