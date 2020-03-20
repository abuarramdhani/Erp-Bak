<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_presensipekerja extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

	public function getAbsenDefault(){
		$sql = "(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, b.nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatatim a
				INNER JOIN hrd_khs.TPribadi b
				ON b.noind=a.noind 
				WHERE b.keluar = '0' and date_part('month',tanggal) = date_part('month',now() - interval '1 month') 
				AND date_part('year',tanggal) = date_part('year',now() - interval '1 month') AND left(a.noind,1) = 'R' )
				UNION 
				(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, b.nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatapresensi a
				INNER JOIN hrd_khs.TPribadi b 
				ON b.noind=a.noind 
				WHERE b.keluar = '0' and date_part('month',tanggal) =  date_part('month',now() - interval '1 month')  
				AND date_part('year',tanggal) = date_part('year',now() - interval '1 month') AND left(a.noind,1) = 'R' )
				ORDER BY  kodesie,noind,tanggal, kd_ket";
		return $this->personalia->query($sql)->result_array();
	}

	public function cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai){
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
	        If($ist_selesai >= $keluar && $ist_selesai >= $masuk){
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
	    }

		// echo $jam_ijin."<br>";
		return $jam_ijin;
	}

	public function getProporsionalTIK($noind,$tanggal){
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
		// return $nilai;
	}

	public function getAbsenByParams($awal,$akhir,$pkjoff = FALSE,$pkjoff_awal = FALSE,$pkjoff_akhir = FALSE){
		if ($pkjoff == "On") {
			$off = " b.tglkeluar between '$pkjoff_awal' and '$pkjoff_akhir' ";
		} else {
			$off = " b.keluar = '0' ";
		}
		$sql = "(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, trim(b.nama) as nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatatim a
				INNER JOIN hrd_khs.TPribadi b
				ON b.noind=a.noind 
				WHERE $off and tanggal between '$awal' and '$akhir' AND left(a.noind,1) = 'R' )
				UNION 
				(SELECT a.tanggal, a.noind, a.kodesie, trim(a.kd_ket) as kd_ket, b.nama, 
						to_char(a.tanggal,'yyyymmdd') as index_tanggal  
				FROM \"Presensi\".tdatapresensi a
				INNER JOIN hrd_khs.TPribadi b 
				ON b.noind=a.noind 
				WHERE $off and tanggal between '$awal' and '$akhir' AND left(a.noind,1) = 'R' )
				ORDER BY  kodesie,noind,tanggal, kd_ket";
		return $this->personalia->query($sql)->result_array();
	}

	public function getLemburByParams($awal,$akhir,$pkjoff = FALSE,$pkjoff_awal = FALSE,$pkjoff_akhir = FALSE){
		if ($pkjoff == "On") {
			$off = " b.tglkeluar between '$pkjoff_awal' and '$pkjoff_akhir' ";
		} else {
			$off = " b.keluar = '0' ";
		}
		$sql = "(SELECT a.tanggal, a.noind, a.kodesie, trim(b.nama) as nama, sum(c.total_lembur ) total_lembur ,to_char(a.tanggal,'yyyymmdd') as index_tanggal 
				 FROM \"Presensi\".TLembur a
				   INNER JOIN hrd_khs.TPribadi b ON b.Noind = a.noind 
				   INNER JOIN \"Presensi\".TDataPresensi c ON a.noind = c.noind 
				     AND a.tanggal = c.tanggal 
				WHERE $off and a.tanggal between '$awal' and '$akhir' 
				  AND left(a.noind, 1) = 'R'
				 GROUP BY a.tanggal, a.noind, a.kodesie, b.nama ) 
				ORDER BY a.kodesie, a.noind, a.tanggal";
		return $this->personalia->query($sql)->result_array();
	}

	public function getSusulan($kd_ket,$noind,$tanggal){
		$sql = "select * from \"Presensi\".tsusulan 
                where noind = '$noind' and tanggal = '$tanggal'
                and ket like '%$kd_ket%'";
        return $this->personalia->query($sql)->result_array();
	}

	public function getTanggalDefault(){
		$sql= "select to_char(dates.dates,'yyyymmdd') as index_tanggal , date_part('day', dates.dates) as hari, 
					date_part('month', dates.dates) as bulan,date_part('year', dates.dates) as tahun, dates.dates::date as tanggal
				from generate_series(now() - interval '2 month', now(), '1 day') as dates
				where date_part('month',dates.dates) = date_part('month',now() - interval '1 month') ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getTanggalByParams($awal,$akhir){
		$sql= "select to_char(dates.dates,'yyyymmdd') as index_tanggal , date_part('day', dates.dates) as hari, 
					date_part('month', dates.dates) as bulan,date_part('year', dates.dates) as tahun, dates.dates::date as tanggal
				from generate_series('$awal'::date, '$akhir'::date, '1 day') as dates ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getWaktuAbsen($noind,$awal,$akhir){
		$sql = "select tanggal::date as tanggal,waktu, b.nama
				from \"Presensi\".tprs_shift a 
				inner join hrd_khs.tpribadi b 
				on a.noind = b.noind 
				where a.noind = '$noind'
				and tanggal between '$awal' and '$akhir'
				order by tanggal, waktu";
		return $this->personalia->query($sql)->result_array();
	}

	public function getInisial($noind,$tanggal){
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

	public function getRekapPresensi($awal,$akhir){
		$sql = "select 	a.noind, a.jml_gp as gp_gaji,a.lokasi_kerja as lokasi, el.location_name, a.jml_um as um_gaji, a.jml_lbr as lembur_gaji,  a.ump as ump_gaji,
						coalesce(b.gp,0) as gp_tambahan, coalesce(b.um,0) as um_tambahan, coalesce(b.lembur,0) as lembur_tambahan, 
						coalesce(c.gp,0) as gp_potongan, coalesce(c.um,0) as um_potongan, coalesce(c.lembur,0) as lembur_potongan,
						d.pekerjaan,
						e.nama
				from hlcm.hlcm_proses a
				left join (
						select noind, tgl_awal_periode, tgl_akhir_periode, sum(gp) as gp,sum(um) as um,sum(lembur) as lembur
						from hlcm.hlcm_tambahan
						group by noind,tgl_awal_periode,tgl_akhir_periode
					) b 
					on a.noind = b.noind 
					and a.tgl_awal_periode = b.tgl_awal_periode
					and a.tgl_akhir_periode = b.tgl_akhir_periode
				left join (
						select noind, tgl_awal_periode, tgl_akhir_periode, sum(gp) as gp,sum(um) as um,sum(lembur) as lembur
						from hlcm.hlcm_potongan
						group by noind,tgl_awal_periode,tgl_akhir_periode
					) c 
					on a.noind = c.noind 
					and a.tgl_awal_periode = c.tgl_awal_periode 
					and a.tgl_akhir_periode = c.tgl_akhir_periode
				left join hlcm.hlcm_datagaji d 
					on a.kode_pekerjaan = d.kode_pekerjaan 
					and a.lokasi_kerja = d.lokasi_kerja
				left join hlcm.hlcm_datapekerja e 
					on a.noind = e.noind
				left join er.er_location el 
					on el.er_location_id=a.lokasi_kerja::int
				where a.tgl_awal_periode = '$awal'
					and a.tgl_akhir_periode = '$akhir'
				order by a.noind";
		return $this->erp->query($sql)->result_array();
	}

	public function insertArsip($data){
		$this->erp->insert('hlcm.hlcm_presensi',$data);
		return;
	}

	public function getArsipPresensi(){
		$sql = "select 	a.tgl_awal_periode,
						a.tgl_akhir_periode,
						a.asal,
						a.keterangan,
						concat(a.created_by,' - ', b.employee_name) as created_by,
						to_char(a.created_date,'yyyy-mm-dd HH24:MI:ss') as created_date,
						a.id_presensi 
				from hlcm.hlcm_presensi a 
				left join er.er_employee_all b 
				on a.created_by = b.employee_code
				order by a.created_date desc";
		return $this->erp->query($sql)->result_array();
	}

	public function getArsipPresensiDetail($id){
		$sql = "select * from hlcm.hlcm_presensi where id_presensi = $id";
		return $this->erp->query($sql)->row();
	}
} 

?>