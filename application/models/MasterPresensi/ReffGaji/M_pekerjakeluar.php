<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_pekerjakeluar extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', TRUE);
		$this->oracle = $this->load->database('oracle', TRUE); 
	}

	public function getPekerja($kode,$nomor){
		$sql = "select noind, right(noind,4) as nomor, nama from hrd_khs.tpribadi where left(noind,1) like '$kode' and (noind like upper('%$nomor%') or nama like upper('%$nomor%')) ";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPekerjaKeluar($periode,$noind){
		$prd = str_replace(" - ", "' and '", $periode);
		// echo "<pre>";print_r($_POST);exit();
		$sql = "select * ,
				case when length(concat(split_part(nama,' ',1),' ',split_part(nama,' ',2),' ',left(split_part(nama,' ',3),1))) > 30 then
					concat(split_part(nama,' ',1),' ',left(split_part(nama,' ',2),1),' ',left(split_part(nama,' ',3),1))
				else
					concat(split_part(nama,' ',1),' ',split_part(nama,' ',2),' ',left(split_part(nama,' ',3),1))
				end nama,
				nama as nama_lengkap,
				tglkeluar::date as tglkeluar,
				diangkat::date as diangkat,
				ang_upamk as upamk,
				(select seksi from hrd_khs.tseksi sek where sek.kodesie = pri.kodesie) as seksi,
				(select lokasi_kerja from hrd_khs.tlokasi_kerja tlok where tlok.ID_ = pri.lokasi_kerja) as lokasi_kerja,
				(select id_ from hrd_khs.tlokasi_kerja tlok where tlok.ID_ = pri.lokasi_kerja) as id_lokasi_kerja
				from hrd_khs.tpribadi pri
				where keluar = '1'
				and tglkeluar between '$prd'
				$noind
				order by noind";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function cekProsesGaji($noind,$tgl_keluar){
		$sql = "select case when tanggal_akhir < '$tgl_keluar'::timestamp then
					cast(concat(to_char(tanggal_akhir,'yyyy-mm'),'-01') as date)
				else
					cast(concat(to_char(tanggal_awal,'yyyy-mm'),'-01') as date)
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$tgl_keluar'::timestamp,'yyyymm')
				and os = '0'";
		$result = $this->personalia->query($sql)->result_array();
		return $result['0']['tanggal'];
	}

	public function cekProsesGaji2($noind,$tgl_keluar){
		$sql = "select case when tanggal_akhir < '$tgl_keluar'::timestamp then
					(tanggal_akhir + interval '1 day')::date
				else
					tanggal_awal::date
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$tgl_keluar'::timestamp,'yyyymm')
				and os = '0'";
		$result = $this->personalia->query($sql)->result_array();
		return $result['0']['tanggal'];
	}

	public function cekProsesGaji3($noind,$tgl_keluar){
		$sql = "select cast(concat(to_char('$tgl_keluar'::date,'yyyy-mm'),'-01') as date) as tanggal";
		$result = $this->personalia->query($sql)->result_array();
		return $result['0']['tanggal'];
	}

	public function cek_libur($tanggal){
		$sql = "select * from \"Dinas_Luar\".tlibur where tanggal = '$tanggal'";
		$result = $this->personalia->query($sql);
		return $result->num_rows();
	}

	public function cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai){
		$jam_ijin = 0;
		// if ($keluar >= $ist_mulai && $masuk >= $ist_mulai) {
		// 	if ($ist_selesai <= $keluar && $ist_selesai <= $masuk) {
		// 		$lama_ijin = $masuk - $keluar;
		// 		$jam_ijin = $lama_ijin;
		// 	}else if($keluar >= $ist_selesai && $masuk >= $ist_selesai){
		// 		$jam_ijin = $masuk - $keluar;
		// 	}else if($masuk >= $ist_selesai){
		// 		$jam_ijin = $masuk - $ist_selesai;
		// 	}
		// }else if($keluar <= $ist_mulai && $masuk >= $ist_mulai){
		// 	if ($ist_selesai >= $keluar && $ist_selesai >= $masuk) {
		// 		if ($keluar <= $break_mulai && $keluar <= $break_selesai) {
		// 			$setelah_break = $masuk - $break_selesai;
		// 			$sebelum_break = $break_mulai - $keluar;
		// 			$jam_ijin = $setelah_break + $sebelum_break;
		// 		}else if($keluar > $break_mulai && $masuk > $ist_mulai){
		// 			$jam_ijin = $ist_mulai - $break_selesai;
		// 		}else{
		// 			$jam_ijin = $ist_mulai - $keluar;
		// 			if ($jam_ijin <= 30) {
		// 				$jam_ijin = 0;
		// 			}
		// 		}
		// 	}else if($keluar <= $ist_selesai && $masuk > $ist_selesai){
		// 		if ($keluar <= $break_mulai) {
		// 			$sebelum_break = $break_mulai - $keluar;
		// 			$setelah_break = $ist_mulai - $break_selesai;
		// 			$setelah_ist = $masuk - $ist_selesai;
		// 			if ($sebelum_break < 0) {
		// 				$sebelum_break = 0;
		// 			}
		// 			if ($setelah_break < 0) {
		// 				$setelah_break = 0;
		// 			}
		// 			if ($setelah_ist < 0) {
		// 				$setelah_ist = 0;
		// 			}
		// 			$jam_ijin = $sebelum_break + $setelah_break + $setelah_ist;
		// 		}else if( $keluar >= $break_selesai){
		// 			$sebelum_ist = $ist_mulai - $keluar;
		// 			$setelah_ist = $masuk - $ist_selesai;
		// 			$jam_ijin = $sebelum_ist + $setelah_ist;
		// 		}else if($keluar >= $break_mulai && $keluar <= $break_selesai){
		// 			$sebelum_ist = $ist_mulai - $break_selesai;
		// 			$setelah_ist = $masuk - $ist_selesai;
		// 			$jam_ijin = $sebelum_ist + $setelah_ist;
		// 		}
		// 	}
		// }else{
		// 	if ($keluar >= $break_mulai && $masuk >= $break_mulai) {
		// 		if ($break_selesai >= $keluar && $break_selesai >= $masuk) {
		// 			$jam_ijin = 0;
		// 		}else if($keluar >= $break_selesai && $masuk >= $break_selesai){
		// 			$jam_ijin = $masuk - $keluar;
		// 		}else{
		// 			$jam_ijin = $masuk - $break_selesai;
		// 		}
		// 	}else if($keluar <= $break_mulai && $masuk >= $break_mulai){
		// 		if ($break_selesai >= $keluar && $break_selesai >= $masuk) {
		// 			$jam_ijin = $break_mulai - $keluar;
		// 		}else{
		// 			$sebelum_break = $break_mulai - $keluar;
		// 			$setelah_break = $masuk - $break_selesai;
		// 			$jam_ijin = $setelah_break + $sebelum_break;
		// 		}
		// 	}else{
		// 		$jam_ijin = $masuk - $keluar;
		// 	}
		// }
		// if ($jam_ijin > 0 && $jam_ijin < 60) {
		// 	$jam_ijin = $jam_ijin/60;
		// }else if($jam_ijin >= 60){
		// 	$jam_ijin = $jam_ijin/60;
		// }

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
	    }else if($jam_ijin < 0){
	    	$jam_ijin = 0;
	    }

		// echo $jam_ijin."<br>";
		return $jam_ijin;
	}

	public function cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai){
		$hasil = false;
		if ($keluar < $ist_mulai && $keluar < $ist_selesai) {
			if($masuk <= $ist_selesai) {
				$hit = $ist_selesai - $keluar;
				if ($hit <= 1800) {
					$hasil = true;
				}else{
					$hasil = false;
				}
			}
		}

		return $hasil;
	}

	public function set_Ip($noind,$awal,$akhir){
		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal >= '$awal' AND tdp.tanggal <= '$akhir'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
				(a.tanggal <= '$akhir')
				Union
				SELECT a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		$nilai = $result1['0']['jml'];
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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 60){
				$nilai = $nilai;
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function set_Ik($noind,$awal,$akhir){
		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal >= '$awal' AND tdp.tanggal <= '$akhir'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
				(a.tanggal <= '$akhir')
				Union
				SELECT a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		$nilai = $result1['0']['jml'];
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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= 1;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}
		// echo $result1['0']['jml']."<br>".$nilai;exit();
		return $nilai;
	}

	public function hitung_if($noind,$awal,$akhir,$chk_khusus,$khusus,$hitung_cutoff){
		$sql = "select case when tanggal_akhir >= '$akhir'::timestamp then
					'awal'
				else
					'akhir'
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$akhir'::timestamp,'yyyymm')
				and os = '0'";

		$result = $this->personalia->query($sql)->result_array();
		$pilih = $result['0']['tanggal'];
		// echo $pilih;exit();
		if ($pilih == "awal") {
			$sql = "select noind,
						case when to_char(a.masukkerja ,'yyyy-mm') = to_char(a.tglkeluar ,'yyyy-mm') then 
							(
								select count(distinct tanggal)
								from \"Presensi\".tdatapresensi b
								where b.noind = a.noind
								and b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar
								and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID' )
							)
						else
							case when '$chk_khusus' = 'khusus' then
								case when '$khusus' = 'sebelum' then
									case when $hitung_cutoff > 0 then
										(
											select count(distinct tanggal)
											from \"Presensi\".tdatapresensi b
											where b.noind = a.noind
											and b.tanggal between '$awal'::date AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
											and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID')
										) -
										(
											select count(*)
											from generate_series('$awal',to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day',interval '1 day') as dt
											left join \"Dinas_Luar\".tlibur tl 
											on tl.tanggal = dt.dt
											where tl.tanggal is null 
											and extract(isodow from dt.dt) != 7
										)
									else
	 									(
	 										select count(distinct tanggal)
	 										from \"Presensi\".tdatapresensi b
	 										where b.noind = a.noind
	 										and b.tanggal between '$awal'::date AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
	 										and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID')
	 									)
	 								end
								else
									(
										select count(distinct tanggal)
										from \"Presensi\".tdatapresensi b
										where b.noind = a.noind
										and b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar
										and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID' )
									) 
								end
							else
								(
									select count(distinct tanggal)
									from \"Presensi\".tdatapresensi b
									where b.noind = a.noind
									and b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar
									and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID')
								)  +
								(select count(tanggal) as jml from
								(
									SELECT c.tanggal from \"Presensi\".TDataPresensi c
									WHERE c.noind = a.noind
									AND c.tanggal between '$awal'::date AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
									AND c.kd_ket in ('PKJ','PDL','PDB','PLB','PID' )
									) as DERIVEDTBL
								)
							end
						end as total
					from hrd_khs.tpribadi a
					where a.noind = '$noind'";
					// echo $sql."<br>";exit();
			$result1 = $this->personalia->query($sql)->result_array();

			$sqlmasukkerja = "select noind,nama,to_char(masukkerja ,'yyyy-mm') as masukkerja,to_char(tglkeluar ,'yyyy-mm') as tglkeluar,keluar 
								from hrd_khs.tpribadi t 
								where noind = '$noind' ";
			$result_masukkerja = $this->personalia->query($sqlmasukkerja)->result_array();
			$masukkerja = $result_masukkerja['0']['masukkerja'];
			$keluarkerja = $result_masukkerja['0']['tglkeluar'];

			if($chk_khusus !== "khusus" or $masukkerja == $keluarkerja){	
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
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$akhir'::date,'yyyy-mm-01')::date - interval '1 day')
						UNION
						SELECT a.tanggal, a.noind,
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
								FROM \"Presensi\".TDataPresensi a INNER JOIN
								\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
								WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";			
			}else{
				if ($chk_khusus == "khusus" && $khusus == "sebelum") {
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
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$akhir'::date,'yyyy-mm-01')::date - interval '1 day')
						UNION
						SELECT a.tanggal, a.noind,
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
								FROM \"Presensi\".TDataPresensi a INNER JOIN
								\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
								WHERE (a.tanggal >= '$awal'::date) AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$akhir'::date,'yyyy-mm-01')::date - interval '1 day')
						ORDER BY tanggal";
				}else{
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
						WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir'::date)
						UNION
						SELECT a.tanggal, a.noind,
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
								FROM \"Presensi\".TDataPresensi a INNER JOIN
								\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
								WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir'::date)
						ORDER BY tanggal";
				}
			}
			$result2 = $this->personalia->query($sql)->result_array();
			$nilai = $result1['0']['total'];
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
				// echo "ijine:".$ijin."<br>";
				if ($ijin <= 0) {
					$nilai = $nilai;
				}else if($ijin > 0 && $ijin <= 30){
					$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
					if ($cek_denda == false) {
						if($lanjut == false) {
							$nilai -= $ijin;
						}
					}
				}else{
					if($lanjut == false){
						$nilai -= $ijin;
					}
				}

				$simpan_tgl = $tik['tanggal'];
			}
			// echo $nilai;exit();
		}else{
			$sql = "select noind,
							(
								select count(distinct tanggal)
								from \"Presensi\".tdatapresensi b
								where b.noind = a.noind
								and b.tanggal between '$awal'::date and a.tglkeluar
								and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID')
							) as total
					from hrd_khs.tpribadi a
					where a.noind = '$noind'";
					// echo $sql."<br>";exit();
			$result1 = $this->personalia->query($sql)->result_array();



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
					WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
					UNION
					SELECT a.tanggal, a.noind,
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
							FROM \"Presensi\".TDataPresensi a INNER JOIN
							\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
							WHERE (a.tanggal >= '$akhir') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
					ORDER BY tanggal";
			$result2 = $this->personalia->query($sql)->result_array();
			$nilai = $result1['0']['total'];
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
				if ($ijin <= 0) {
					$nilai = $nilai;
				}else if($ijin > 0 && $ijin <= 30){
					$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
					if ($cek_denda == false) {
						if($lanjut == false) {
							$nilai -= $ijin;
						}
					}
				}else{
					if($lanjut == false){
						$nilai -= $ijin;
					}
				}

				$simpan_tgl = $tik['tanggal'];
			}
		}

		return $nilai;
	}

	public function hitung_if_tdk_cutoff($noind,$awal,$akhir,$chk_khusus,$khusus,$hitung_cutoff){
		$sql = "select case when tanggal_akhir >= '$akhir'::timestamp then
					'awal'
				else
					'akhir'
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$akhir'::timestamp,'yyyymm')
				and os = '0'";
		$result = $this->personalia->query($sql)->result_array();
		$pilih = $result['0']['tanggal'];
		// echo $pilih;exit();
		if ($pilih == "awal") {
			$sql = "select noind,
						case when to_char(a.masukkerja ,'yyyy-mm') = to_char(a.tglkeluar ,'yyyy-mm') then 
							(
								select count(distinct tanggal)
								from \"Presensi\".tdatapresensi b
								where b.noind = a.noind
								and b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar
								and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID')
							) 
						else
							case when '$chk_khusus' = 'khusus' then
								case when '$khusus' = 'sebelum' then
									case when $hitung_cutoff > 0 then
										(
											select count(distinct tanggal)
											from \"Presensi\".tdatapresensi b
											where b.noind = a.noind
											and b.tanggal between '$awal'::date AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
											and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID' )
										) -
										(
											select count(*)
											from generate_series('$awal',to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day',interval '1 day') as dt
											left join \"Dinas_Luar\".tlibur tl 
											on tl.tanggal = dt.dt
											where tl.tanggal is null 
											and extract(isodow from dt.dt) != 7
										)
									else
	 									(
	 										select count(distinct tanggal)
	 										from \"Presensi\".tdatapresensi b
	 										where b.noind = a.noind
	 										and b.tanggal between '$awal'::date AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
	 										and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID' )
	 									)
	 								end
								else
									(
										select count(distinct tanggal)
										from \"Presensi\".tdatapresensi b
										where b.noind = a.noind
										and b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar
										and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID' )
									)
								end
							else
								(
									select count(distinct tanggal)
									from \"Presensi\".tdatapresensi b
									where b.noind = a.noind
									and b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar
									and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID' )
								)  -
								(select count(tanggal) as jml from
									(
										SELECT c.tanggal from \"Presensi\".TDataPresensi c
										WHERE c.noind = a.noind
										AND c.tanggal between '$awal'::date AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
										AND c.kd_ket not in ('PKJ','PDL','PDB','PLB','PID','PSP','CB')
									) as DERIVEDTBL
								) - 
								(select count(tanggal) as jml from
									(
										SELECT c.tanggal from \"Presensi\".tdatatim c
										WHERE c.noind = a.noind
										AND c.tanggal between '$awal'::date AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
										AND c.kd_ket = 'TM'
									) as DERIVEDTBL
								)
							end
						end as total
					from hrd_khs.tpribadi a
					where a.noind = '$noind'";
			// echo "<pre>".$sql;exit();
			$result1 = $this->personalia->query($sql)->result_array();

			$sqlmasukkerja = "select noind,nama,to_char(masukkerja ,'yyyy-mm') as masukkerja,to_char(tglkeluar ,'yyyy-mm') as tglkeluar,keluar 
								from hrd_khs.tpribadi t 
								where noind = '$noind' ";
			$result_masukkerja = $this->personalia->query($sqlmasukkerja)->result_array();
			$masukkerja = $result_masukkerja['0']['masukkerja'];
			$keluarkerja = $result_masukkerja['0']['tglkeluar'];

			if($chk_khusus !== "khusus" or $masukkerja == $keluarkerja){
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
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir'::date)
						UNION
						SELECT a.tanggal, a.noind,
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
								FROM \"Presensi\".TDataPresensi a INNER JOIN
								\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
								WHERE (a.tanggal >= '$awal'::date) AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";
			}else{
				if ($chk_khusus == "khusus" && $khusus == "sebelum") {
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
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$akhir'::date,'yyyy-mm-01')::date - interval '1 day')
						UNION
						SELECT a.tanggal, a.noind,
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
								FROM \"Presensi\".TDataPresensi a INNER JOIN
								\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
								WHERE (a.tanggal >= '$awal'::date) AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$akhir'::date,'yyyy-mm-01')::date - interval '1 day')
						ORDER BY tanggal";
				}else{
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
						WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir'::date)
						UNION
						SELECT a.tanggal, a.noind,
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
								FROM \"Presensi\".TDataPresensi a INNER JOIN
								\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
								WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";
				}
			}
					
			$result2 = $this->personalia->query($sql)->result_array();
			$nilai = $result1['0']['total'];
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
				// echo $ijin."<br>";
				if ($ijin <= 0) {
					$nilai = $nilai;
				}else if($ijin > 0 && $ijin <= 30){
					$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
					if ($cek_denda == false) {
						if($lanjut == false) {
							$nilai -= $ijin;
						}
					}
				}else{
					if($lanjut == false){
						$nilai -= $ijin;
					}
				}

				$simpan_tgl = $tik['tanggal'];
			}
			 // echo $akhir;exit();
		}else{
			$sql = "select noind,
						case when to_char(a.masukkerja ,'yyyy-mm') = to_char(a.tglkeluar ,'yyyy-mm') then
							case when (select t.tanggal_akhir from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') > a.tglkeluar then 
								(
									select count(distinct tanggal)
									from \"Presensi\".tdatapresensi b
									where b.noind = a.noind
									and b.tanggal between '$awal'::date and a.tglkeluar
									and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID')
								) -
								(
									select count(*)
									from \"Presensi\".tshiftpekerja b
									where b.noind = a.noind
									and b.tanggal between '$awal'::date and a.tglkeluar
								) -
								(
									select count(*)
									from (
										select date_.*
										from generate_series(
											a.tglkeluar,
											to_char(a.tglkeluar,'YYYY-MM-01')::date + interval '1 month' - interval '1 day',
											interval '1 day'
										) as date_
									) as dates
									left join \"Dinas_Luar\".tlibur libur 
									on libur.tanggal = dates.date_
									where libur.tanggal is null
									and (extract(isodow from dates.date_) <> '7')	
								)
							else
								(
									select count(distinct tanggal)
									from \"Presensi\".tdatapresensi b
									where b.noind = a.noind
									and b.tanggal between '$awal'::date and a.tglkeluar
									and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID')
								)
							end 
						else
							(
								select count(distinct tanggal)
								from \"Presensi\".tdatapresensi b
								where b.noind = a.noind
								and b.tanggal between '$awal'::date and a.tglkeluar
								and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID' )
							) -
							(
								select count(*)
								from \"Presensi\".tshiftpekerja b
								where b.noind = a.noind
								and b.tanggal between '$awal'::date and a.tglkeluar
							) -
							(
								select count(*)
								from (
									select date_.*
									from generate_series(
										a.tglkeluar,
										to_char(a.tglkeluar,'YYYY-MM-01')::date + interval '1 month' - interval '1 day',
										interval '1 day'
									) as date_
								) as dates
								left join \"Dinas_Luar\".tlibur libur 
								on libur.tanggal = dates.date_
								where libur.tanggal is null
								and (extract(isodow from dates.date_) <> '7')	
							)
						end as total
					from hrd_khs.tpribadi a
					where a.noind = '$noind'";
					// echo "<pre>".$sql."<br>";exit();
			$result1 = $this->personalia->query($sql)->result_array();

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
					WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
					UNION
					SELECT a.tanggal, a.noind,
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
							FROM \"Presensi\".TDataPresensi a INNER JOIN
							\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
							WHERE (a.tanggal >= '$awal') AND (a.kd_ket ='PSP') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
					ORDER BY tanggal";

			$result2 = $this->personalia->query($sql)->result_array();
			$nilai = $result1['0']['total'];
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
				// echo $ijin."<br>";
				if ($ijin <= 0) {
					$nilai = $nilai;
				}else if($ijin > 0 && $ijin <= 30){
					$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
					if ($cek_denda == false) {
						if($lanjut == false) {
							$nilai -= $ijin;
						}
					}
				}else{
					if($lanjut == false){
						$nilai -= $ijin;
					}
				}

				$simpan_tgl = $tik['tanggal'];
			}
		}
		// echo $nilai;exit();
		return $nilai;
	}

	public function getKomUmPuasa($noind,$awal,$akhir,$tgl_puasa){
		$tglpuasa = explode(' - ', $tgl_puasa);
		$tglawal = $tglpuasa['0'];
		$tglakhir = $tglpuasa['1'];
		$sql = "select min(dates1) awal, max(dates1) akhir
				from generate_series('$awal','$akhir',interval '1 day') as dates1
				inner join generate_series('$tglawal','$tglakhir',interval '1 day') as dates2
				on dates1.dates1 = dates2.dates2";
		$result = $this->personalia->query($sql)->result_array();

		$tgl_um_awal = $result['0']['awal'];
		$tgl_um_akhir = $result['0']['akhir'];
		if (empty($tgl_um_awal) || empty($tgl_um_akhir)) {
			return 0;
		}
		$sql1 = "	select count(*) as jml
				from \"Presensi\".tdatapresensi pres
				inner join \"Presensi\".tshiftpekerja shift
				on pres.noind = shift.noind
				and pres.tanggal = shift.tanggal
				where pres.noind = '$noind'
				and (pres.kd_ket = 'PKJ'
				or pres.kd_ket = 'PID'
				or pres.kd_ket = 'PLB')
				and pres.tanggal >= '$tgl_um_awal'
				and pres.tanggal <= '$tgl_um_akhir'
				and (shift.kd_shift = '1'
				or shift.kd_shift = '10'
				or shift.kd_shift = '13'
				or shift.kd_shift = '14'
				or shift.kd_shift = '15'
				or shift.kd_shift = '17'
				or shift.kd_shift = '4'
				or shift.kd_shift = '5'
				or shift.kd_shift = '7'
				or shift.kd_shift = '8'
				or shift.kd_shift = '9')";

  		$sql2 = "select count(*) as jml
				from \"Presensi\".tdatapresensi pres
				inner join \"Presensi\".tshiftpekerja shift
				on pres.noind = shift.noind
				and pres.tanggal = shift.tanggal
				inner join \"Presensi\".tlembur lbr
				on pres.noind = lbr.noind
				and pres.tanggal = lbr.tanggal
				where lbr.jml_lembur >= 180
				and lbr.kd_lembur = '003'
				and pres.noind = '$noind'
				and (pres.kd_ket = 'PLB')
				and pres.tanggal >= '$tgl_um_awal'
				and pres.tanggal <= '$tgl_um_akhir'
				and (shift.kd_shift <> '1'
				and shift.kd_shift <> '10'
				and shift.kd_shift <> '13'
				and shift.kd_shift <> '14'
				and shift.kd_shift <> '15'
				and shift.kd_shift <> '17'
				and shift.kd_shift <> '4'
				and shift.kd_shift <> '5'
				and shift.kd_shift <> '7'
				and shift.kd_shift <> '8'
				and shift.kd_shift <> '9')";

  		$sql3 = "select count(*) as jml
				from \"Presensi\".tlembur lbr
				where lbr.jml_lembur >= 180
				and lbr.kd_lembur = '004'
				and lbr.jam_klr <= '17:30:00'
				and lbr.noind = '$noind'
				and lbr.tanggal >= '$tgl_um_awal'
				and lbr.tanggal <= '$tgl_um_akhir'";

  		$sql4 = "select count(*) as jml
				from \"Presensi\".tdatapresensi pres
				inner join \"Presensi\".tshiftpekerja shift
				on pres.noind = shift.noind
				and pres.tanggal = shift.tanggal
				inner join \"Presensi\".tlembur lbr
				on pres.noind = lbr.noind
				and pres.tanggal = lbr.tanggal
				where lbr.kd_lembur = '003'
				and pres.noind = '$noind'
				and (pres.kd_ket = 'PLB')
				and pres.tanggal >= '$tgl_um_awal'
				and pres.tanggal <= '$tgl_um_akhir'
				and shift.kd_shift = '1'
				and lbr.jam_msk >= '04:20:00'
				and lbr.jam_msk <= '04:30:00'
				and lbr.jam_klr <= '06:20:00'";

		$result1 = $this->personalia->query($sql1)->result_array();
		$result2 = $this->personalia->query($sql2)->result_array();
		$result3 = $this->personalia->query($sql3)->result_array();
		$result4 = $this->personalia->query($sql4)->result_array();
		return ($result1['0']['jml'] + $result2['0']['jml'] + $result3['0']['jml'] + $result4['0']['jml']);
	}

	public function hitung_lembur($noind,$awal,$akhir){
		$sql ="	select coalesce(SUM(total_Lembur), 0) AS jml
				FROM \"Presensi\".TDataPresensi
				WHERE (
				(tanggal >= '$awal'
				AND tanggal <= '$akhir')
				OR  tanggal in (
					SELECT tanggal
					FROM \"Presensi\".tSusulan
					WHERE noind = '$noind'
					AND ket LIKE '%LEMBUR%'
					AND stat = '0'
					AND tanggal >= '2019-01-01' )
				)
				AND noind = '$noind'
				and total_Lembur is not null ";
		$result = $this->personalia->query($sql)->result_array();

		return $result['0']['jml'];
	}

	public function hitung_ims($noind,$awal,$akhir){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a
				  INNER JOIN \"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				    AND a.noind = b.noind
				WHERE a.tanggal >= '$awal' AND a.tanggal <= '$akhir'
				  AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID')
				  AND (a.noind = '$noind')
				  AND (b.kd_shift = '2' OR b.kd_shift = '11')";
		$result1 = $this->personalia->query($sql)->result_array();
		$hasil = 0;

		$sql = "select a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (b.kd_shift = '2' OR b.kd_shift = '11') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				UNION
				SELECT a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (b.kd_shift = '2' OR b.kd_shift = '11') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();

		$nilai = $result1['0']['jml'];
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
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= 1;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function hitung_imm($noind,$awal,$akhir){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a
				  INNER JOIN \"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				    AND a.noind = b.noind
				WHERE a.tanggal >= '$awal' AND a.tanggal <= '$akhir'
				  AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID')
				  AND (a.noind = '$noind')
				  AND (b.kd_shift = '3' OR b.kd_shift = '12') ";
		$result1 = $this->personalia->query($sql)->result_array();
		$hasil = 0;

		$sql = "select a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (b.kd_shift = '3' OR b.kd_shift = '12') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				UNION
				SELECT a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (b.kd_shift = '3' OR b.kd_shift = '12') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();

		$nilai = $result1['0']['jml'];
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
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= 1;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function set_ipt($noind,$awal,$akhir){
		$sql = "select tglberlaku as tgl FROM hrd_khs.tmutasi
				 WHERE noind = '$noind'
				 AND tglberlaku >= '$awal'
				 AND tglberlaku <= '$akhir'
				 AND lokasibr = '02'
				 ORDER BY tglberlaku desc
				 LIMIT 1";
		$result0 = $this->personalia->query($sql)->result_array();
		if (!empty($result0)) {
			$awal = $result0['0']['tgl'];
		}

		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal >= '$awal' AND tdp.tanggal <= '$akhir'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
				(a.tanggal <= '$akhir')
				Union
				SELECT a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		$nilai = $result1['0']['jml'];
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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 60){
				$nilai = $nilai;
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function hitung_um_cabang($noind,$awal,$akhir){
		$um_cabang = 0;

		$sql = "select * 
				from hrd_khs.tpribadi a 
				where a.noind = '$noind' 
				and ( 
					a.lokasi_kerja not in ('01','02','03','04') 
					or 
					( 
					select count(*) 
						from hrd_khs.tmutasi b 
						Where a.noind = b.noind 
						and b.tglberlaku between '$awal' and now()
						and ( 
							b.lokasilm not in ('01','02','03','04') 
							or 
							b.lokasibr not in ('01','02','03','04') 
						) 
					) > 0 
				) ";
		$result = $this->personalia->query($sql)->result_array();
		if (!empty($result)) {
			$sql = "select noind ,lokasilm, lokasibr, 
						case when lokasilm in ('01','02','03','04') then 
							tglberlaku::date 
						else 
							'$awal'::date 
						end as mulai, 
						case when lokasibr in ('01','02','03','04') then  
							(tglberlaku - interval '1 day')::date
						else 
							'$akhir'::date 
						end as selesai 
					from hrd_khs.tmutasi 
					where tglberlaku between '$awal' and now()
					and (lokasilm not in ('01','02','03','04') or lokasibr not in ('01','02','03','04')) 
					and noind = '$noind'";
			$result2 = $this->personalia->query($sql)->result_array();
			if (!empty($result2)) {
				foreach ($result2 as $key) {
					$awal = $key['mulai'];
					$akhir = $key['selesai'];

					$sql = "select round((
						     count(tsp.tanggal)
						     -
						     (case
						     when (extract(month from ('$akhir')::date)+1)=extract(month from ('$akhir')::date) then
						         case
						         when (30-(('$akhir'::date - '$awal'::date)+1))>=0 then
						             (30-(('$akhir'::date - '$awal'::date)+1))
						         else
						             0
						         end
						     else
						         0
						     end)
						     -
						          sum(
						         coalesce((
						             select sum(
						                 case
						                 when tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0') or tdt1.point='1' then
						                     1
						                 when tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0') then
						                     case
						                     when tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second') then
						                         case
						                         when tdt1.masuk::time between tsp.jam_msk::time and (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                          when tdt1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second') then
						                         case
						                         when tdt1.masuk::time >= (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                     end
						                 end)
						             from \"Presensi\".tdatatim tdt1
						             where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal
						         ),0)
						     )
						     -
						          sum(
						         coalesce(
						             (select sum(
						                 case
						                 when (tdp1.kd_ket in ('PSK','PRM','PKK','PIP','PCZ')  or (tdp1.kd_ket!='CB' and tdp1.kd_ket like 'C%')) or (tdp1.kd_ket='PDL' and (tdp1.masuk='0' or tdp1.masuk='' )) then
						                     1
						                 when tdp1.kd_ket = rtrim('PSP') then
						                     case
						                     when tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_selesai::time - interval '1 second') then
						                         case
						                         when tdp1.masuk::time between tsp.jam_msk::time and (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                         when tdp1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second') then
						                         case
						                         when tdp1.masuk::time >= (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                     end
						                 end)
						             from \"Presensi\".tdatapresensi tdp1
						             where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
						         ),0)
						     )
						 )::decimal,2) as um
						 from hrd_khs.tpribadi tp
						 left join \"Presensi\".tshiftpekerja tsp on tsp.noind=tp.noind
						 where  tp.noind='$noind' and tsp.tanggal between '$awal' and '$akhir'
						 group by tp.noind, tp.nama, tp.noind_baru, tp.kodesie, tp.lokasi_kerja, tp.tglkeluar, tp.masukkerja, tp.diangkat
						 order by tp.noind ";

			 	$result3 = $this->personalia->query($sql)->result_array();
			 	if (!empty($result3)) {
			 		$um_cabang += $result3['0']['um'];
			 	}
				}
			}else{
				$sql = "select round((
						     count(tsp.tanggal)
						     -
						     (case
						     when (extract(month from ('$akhir')::date)+1)=extract(month from ('$akhir')::date) then
						         case
						         when (30-(('$akhir'::date - '$awal'::date)+1))>=0 then
						             (30-(('$akhir'::date - '$awal'::date)+1))
						         else
						             0
						         end
						     else
						         0
						     end)
						     -
						          sum(
						         coalesce((
						             select sum(
						                 case
						                 when tdt1.kd_ket='TM' or (tdt1.kd_ket='' and tdt1.masuk='0') or tdt1.point='1' then
						                     1
						                 when tdt1.kd_ket='TIK' or (tdt1.kd_ket='' and tdt1.masuk!='0') then
						                     case
						                     when tdt1.keluar::time between tsp.jam_msk::time and (tsp.ist_mulai::time - interval '1 second') then
						                         case
						                         when tdt1.masuk::time between tsp.jam_msk::time and (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                                              when tdt1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second') then
						                         case
						                         when tdt1.masuk::time >= (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                     end
						                 end)
						             from \"Presensi\".tdatatim tdt1
						             where tdt1.noind=tsp.noind and tdt1.tanggal=tsp.tanggal
						         ),0)
						     )
						     -
						          sum(
						         coalesce(
						             (select sum(
						                 case
						                 when (tdp1.kd_ket in ('PSK','PRM','PKK','PIP','PCZ')  or (tdp1.kd_ket!='CB' and tdp1.kd_ket like 'C%')) or (tdp1.kd_ket='PDL' and (tdp1.masuk='0' or tdp1.masuk='' )) then
						                     1
						                 when tdp1.kd_ket = rtrim('PSP') then
						                     case
						                     when tdp1.keluar::time between tsp.jam_msk::time and (tsp.ist_selesai::time - interval '1 second') then
						                         case
						                         when tdp1.masuk::time between tsp.jam_msk::time and (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                                              when tdp1.keluar::time between tsp.ist_selesai::time and (tsp.jam_plg::time - interval '1 second') then
						                         case
						                         when tdp1.masuk::time >= (tsp.ist_selesai::time - interval '1 second') then
						                             0
						                         else
						                             1
						                         end
						                     end
						                 end)
						             from \"Presensi\".tdatapresensi tdp1
						             where tdp1.noind=tsp.noind and tdp1.tanggal=tsp.tanggal
						         ),0)
						     )
						 )::decimal,2) as um
						 from hrd_khs.tpribadi tp
						 left join \"Presensi\".tshiftpekerja tsp on tsp.noind=tp.noind
						 where  tp.noind='$noind' and tsp.tanggal between '$awal' and '$akhir'
						 group by tp.noind, tp.nama, tp.noind_baru, tp.kodesie, tp.lokasi_kerja, tp.tglkeluar, tp.masukkerja, tp.diangkat
						 order by tp.noind ";

			 	$result3 = $this->personalia->query($sql)->result_array();
			 	if (!empty($result3)) {
			 		$um_cabang += $result3['0']['um'];
			 	}
			}
		}

			

 	return $um_cabang;
	}

	public function hitung_Ubt($noind,$awal,$akhir){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				AND a.noind = b.noind
				WHERE a.tanggal >= '$awal' AND a.tanggal <= '$akhir'
				AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID' or a.kd_ket = 'PDL' or a.kd_ket = 'PDB')
				AND a.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();
		$nilai = $result1['0']['jml'];

		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				AND a.noind = b.noind
				WHERE a.tanggal >= '$awal' AND a.tanggal <= '$akhir'
				AND (a.kd_ket = 'PDL' or a.kd_ket = 'PDB') AND a.masuk = '0' and a.keluar = '0'
				AND a.noind = '$noind'";
		$result2 = $this->personalia->query($sql)->result_array();
		$nilai -= $result2['0']['jml'];

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
				(a.tanggal <= '$akhir')
				Union
				SELECT a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";
		$result3 = $this->personalia->query($sql)->result_array();

		$ijin = 0;
		$simpan_tgl = "";
		$sp = false ;
		$a = 0;
		foreach ($result3 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$a = 0;

				if ($ijin > 60 && $ijin <= 180 && $sp == false) {
					$nilai -= 0.5;
				}else if($ijin > 180 && $sp == false){
					$nilai -= 1;
				}
			}

			$sp = false;

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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($tik['kd_ket'] == 'PSP'){
				$nilai = $nilai;
				$sp = true;
			}else{
				$a += $ijin;
			}

			$simpan_tgl = $tik['tanggal'];
		}

		if ($ijin > 60 && $ijin <= 180 && $sp == false) {
			$nilai -= 0.5;
		}else if($ijin > 180 && $sp == false){
			$nilai -= 1;
		}

		$sql = "select *,extract(dow from tdp.tanggal) + 1 as hari from \"Presensi\".Tlembur as tl,\"Presensi\".Tdatapresensi as tdp
				where tdp.kd_ket = 'HL'
				 and tdp.tanggal >='$awal'
				 and tdp.tanggal <= '$akhir'
				 and tl.tanggal  = tdp.tanggal
				 and tdp.noind = '$noind'
				 and tdp.noind = tl.noind
				 order by tdp.tanggal";

		$result4 = $this->personalia->query($sql)->result_array();
		if (!empty($result4)) {
			foreach ($result4 as $lmr) {
				$masuk = strtotime($lmr['masuk']);
				$keluar = strtotime($lmr['keluar']);
				$jam_lembur = $lmr['jml_lembur'];

				$sql = "select kd_shift from \"Presensi\".TShiftPekerja where
						date_part('month',tanggal) = date_part('month','".$lmr['tanggal']."'::date)
						and noind = '$noind' group by kd_shift ";
				$resshift = $this->personalia->query($sql)->result_array();
				if ($resshift['0']['kd_shift'] !== "3") {
					if ($lmr['hari'] == "Jumat" || $lmr['hari'] == "Sabtu") {
						if($jam_lembur <= 180 ){
							$nilai = $nilai;
						}else if($jam_lembur <= 300 && $jam_lembur > 180){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur <= 240) {
							$nilai = $nilai;
						}else if($jam_lembur <= 360 && $jam_lembur > 240){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}

				}else{
					if ($lmr['hari'] == "Minggu" || $lmr['hari'] == "Jumat") {
						if($jam_lembur <= 180 ){
							$nilai = $nilai;
						}else if($jam_lembur <= 300 && $jam_lembur > 180){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur <= 240) {
							$nilai = $nilai;
						}else if($jam_lembur <= 360 && $jam_lembur > 240){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}
				}
			}
		}


		return $nilai;
	}

	public function hitung_Upamk($noind,$awal,$akhir){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				AND a.noind = b.noind
				WHERE a.tanggal >= '$awal' AND a.tanggal <= '$akhir'
				AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID' or a.kd_ket = 'PDL' or a.kd_ket = 'PDB')
				AND a.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();
		$nilai = $result1['0']['jml'];
		// echo $result1['0']['jml']."<br>";
		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
				(a.tanggal <= '$akhir')
				Union
				SELECT a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";
		$result3 = $this->personalia->query($sql)->result_array();

		$ijin = 0;
		$simpan_tgl = "";
		$sp = false ;
		$a = 0;

		foreach ($result3 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$a = 0;
			}

			$sp = false;

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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($tik['kd_ket'] == 'PSP'){
				$nilai -= number_format(($ijin / ($tik['jam_kerja'] * 60 )), 2);
				// echo "<br>".($ijin / ($tik['jam_kerja'] * 60 ));print_r($tik);echo "<br>".$nilai;
				$sp = true;
			}else{
				$nilai -= number_format(($ijin / ($tik['jam_kerja'] * 60 )), 2);
				// echo "<br>".($ijin / ($tik['jam_kerja'] * 60 ));print_r($tik);echo "<br>".$nilai;
				$a += $ijin;
			}

			$simpan_tgl = $tik['tanggal'];
		}
		// echo $nilai."<br>";
		$sql = "select *,extract(dow from tdp.tanggal) + 1 as hari from \"Presensi\".Tlembur as tl,\"Presensi\".Tdatapresensi as tdp
				where tdp.kd_ket = 'HL'
				 and tdp.tanggal >='$awal'
				 and tdp.tanggal <= '$akhir'
				 and tl.tanggal  = tdp.tanggal
				 and tdp.noind = '$noind'
				 and tdp.noind = tl.noind
				 order by tdp.tanggal";

		$result4 = $this->personalia->query($sql)->result_array();
		if (!empty($result4)) {
			foreach ($result4 as $lmr) {
				$masuk = strtotime($lmr['masuk']);
				$keluar = strtotime($lmr['keluar']);
				$jam_lembur = $lmr['jml_lembur'];

				$sql = "select kd_shift from \"Presensi\".TShiftPekerja where
						date_part('month',tanggal) = date_part('month','".$lmr['tanggal']."'::date)
						and noind = '$noind' group by kd_shift ";
				$resshift = $this->personalia->query($sql)->result_array();
				if ($resshift['0']['kd_shift'] !== "3") {
					if ($lmr['hari'] == "Jumat" || $lmr['hari'] == "Sabtu") {
						if($jam_lembur < 360 ){
							$nilai += ($jam_lembur / 360);
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur < 420) {
							$nilai += $jam_lembur/420;
						}else{
							$nilai += 1;
						}
					}

				}else{
					if ($lmr['hari'] == "Minggu" || $lmr['hari'] == "Jumat") {
						if($jam_lembur < 360 ){
							$nilai += ($jam_lembur / 360);
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur < 420) {
							$nilai += $jam_lembur/420;
						}else{
							$nilai += 1;
						}
					}
				}
			}
		}
			// echo $nilai;exit();

		return $nilai;
	}

	public function hitung_tambahan($noind,$akhir){
		$sql = "select count(*) as jml from \"Presensi\".tsusulan
				where ket in ('CT','SK')
				and stat = '0' and noind = '$noind'
				AND tanggal >= '2019-01-01'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select (
						t.jml_cuti - 
						(select count(*)
						from \"Presensi\".tdatapresensi t2 
						where t2.noind = t.noind 
						and t2.tanggal between t.tgl_boleh_ambil and '$akhir'
						and trim(t2.kd_ket) in ('CT','CB'))
					) as jml 
				from \"Presensi\".tdatacuti t
				where periode = extract(year from '$akhir'::date)::varchar
				and noind = '$noind' and tgl_boleh_ambil <= '$akhir'::timestamp";
		$result2 = $this->personalia->query($sql)->result_array();

		$nilai = 0;
		if (!empty($result1)) {
			$nilai += $result1['0']['jml'];
		}

		if (!empty($result2)) {
			$nilai += $result2['0']['jml'];
		}

		return $nilai;
	}

	public function getPesangon($noind){
		$nilai = 0;
		$sql = "select jml_cuti
				from hrd_khs.t_pesangon
				where noinduk = '$noind'";
		$result = $this->personalia->query($sql)->row();
		if(!empty($result)){
			$nilai = $result->jml_cuti;
		}

		return $nilai;
	}

	public function get_sisa_cuti($noind,$akhir){
		$nilai = 0;
		$sql = "select (
						t.jml_cuti - 
						(select count(*)
						from \"Presensi\".tdatapresensi t2 
						where t2.noind = t.noind 
						and t2.tanggal between t.tgl_boleh_ambil and '$akhir'
						and trim(t2.kd_ket) in ('CT','CB'))
					) as jml 
				from \"Presensi\".tdatacuti t
				where periode = extract(year from '$akhir'::date)::varchar
				and noind = '$noind' and tgl_boleh_ambil <= '$akhir'::timestamp";
		$result2 = $this->personalia->query($sql)->result_array();
		if (!empty($result2)) {
			$nilai += $result2['0']['jml'];
		}
		return $nilai;
	}

	public function get_sk_susulan($noind){
		$nilai = 0;
		$sql = "select count(*) as jml from \"Presensi\".tsusulan
				where ket in ('SK')
				and stat = '0' and noind = '$noind'
				AND tanggal >= '2019-01-01'";
		$result1 = $this->personalia->query($sql)->result_array();
		if (!empty($result1)) {
			$nilai += $result1['0']['jml'];
		}
		return $nilai;
	}

	public function get_cuti_susulan($noind){
		$nilai = 0;
		$sql = "select count(*) as jml from \"Presensi\".tsusulan
				where ket in ('CT')
				and stat = '0' and noind = '$noind'
				AND tanggal >= '2019-01-01'";
		$result1 = $this->personalia->query($sql)->result_array();
		if (!empty($result1)) {
			$nilai += $result1['0']['jml'];
		}
		return $nilai;
	}

	public function get_akhir_bulan($tanggal){
		$sql = "select cast(to_char('$tanggal'::date + interval '1 month', 'yyyy-mm-01')::date - interval '1 day' as date) as tgl ";
		return $this->personalia->query($sql)->row()->tgl;
	}

	public function hitung_pot_if($noind,$awal,$akhir){
		$sql = "select count(tanggal) as jml from
				(SELECT tanggal FROM \"Presensi\".TDataTIM
				WHERE noind = '$noind'
				AND tanggal >= '$awal'
				AND tanggal <= '$akhir'
				AND (kd_ket = 'TM')
				UNION
				SELECT tanggal FROM \"Presensi\".TDataPresensi
				WHERE noind = '$noind'
				AND tanggal >= '$awal'
				AND tanggal <= '$akhir'
				AND (((kd_ket = 'PSK' or kd_ket = 'PRM') and (noind like 'K%' or noind like 'P%' or noind like 'F%' or noind like 'Q%')) or kd_ket = 'PIP'))
				DERIVEDTBL ";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
				(a.tanggal <= '$akhir')
				Union
				SELECT a.tanggal, a.noind,
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
				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
				ORDER BY tanggal";

		$result2 = 	$this->personalia->query($sql)->result_array();

		$nilai = $result1['0']['jml'];
		// echo $nilai;
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
			// if ($ijin <= 0) {
			// 	$nilai = $nilai;
			// }else if($ijin > 0 && $ijin <= 30){
			// 	$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
			// 	if ($cek_denda == false) {
			// 		if($lanjut == false) {
			// 			$nilai += 1;
			// 		}
			// 	}
			// }else{
			// 	if($lanjut == false){
			// 		$nilai += 1;
			// 	}
			// }
			$nilai += $ijin;

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function get_pot_seragam($noind,$potongan){
		$sql = "select case when tglkeluar < (diangkat + interval '6 month') and trim(sebabklr) in ('MENGUNDURKAN DIRI','PELANGGARAN PERATURAN') then
					'$potongan'
				else
					'0'
				end as nom
				from hrd_khs.tpribadi
				where noind = '$noind'";
		return $this->personalia->query($sql)->row()->nom;
	}

	public function get_tpribadi($noind){
		$sql = "select noind,nama,a.kodesie,b.lokasi_kerja,
				case when (SELECT count(*) FROM hrd_khs.tbpjskes c WHERE c.noind = a.noind and angg_jkn = '1') > 0 then
					'YA'
				else
					'TIDAK'
				end as bpjs ,c.*
				from hrd_khs.tpribadi a
				left join hrd_khs.tlokasi_kerja b
					on a.lokasi_kerja = b.id_
				left join hrd_khs.tseksi c
					on a.kodesie = c.kodesie
				where noind = '$noind'";
		return $this->personalia->query($sql)->row();
	}

	public function hitung_tik($noind,$awal,$akhir,$chk_khusus,$khusus,$hitung_cutoff){
		$sql = "select case when tanggal_akhir >= '$akhir'::timestamp then
					'awal'
				else
					'akhir'
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$akhir'::timestamp,'yyyymm')
				and os = '0'";
		$result = $this->personalia->query($sql)->result_array();
		$pilih = $result['0']['tanggal'];
		if ($pilih == "awal") {
			$nilai = 0;
			$sqlmasukkerja = "select noind,nama,to_char(masukkerja ,'yyyy-mm') as masukkerja,to_char(tglkeluar ,'yyyy-mm') as tglkeluar,keluar 
								from hrd_khs.tpribadi t 
								where noind = '$noind' ";
			$result_masukkerja = $this->personalia->query($sqlmasukkerja)->result_array();
			$masukkerja = $result_masukkerja['0']['masukkerja'];
			$keluarkerja = $result_masukkerja['0']['tglkeluar'];

			if ($masukkerja == $keluarkerja) {
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
						WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";

				$result2 = 	$this->personalia->query($sql)->result_array();
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
			}else{	
				if($hitung_cutoff == 0){
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
							WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
							ORDER BY tanggal";

					$result2 = 	$this->personalia->query($sql)->result_array();
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
				}else{
					if($chk_khusus !== "khusus" or ($chk_khusus == "khusus" && $khusus == "sesudah")){
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
								WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
								ORDER BY tanggal";

						$result2 = 	$this->personalia->query($sql)->result_array();
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
					}
					if($chk_khusus !== "khusus" or ($chk_khusus == "khusus" && $khusus == "sebelum")){
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
								WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$akhir'::date,'yyyy-mm-01')::date - interval '1 day')
								ORDER BY tanggal";

						$result3 = 	$this->personalia->query($sql)->result_array();
						$simpan_tgl = "";
						$lanjut = false;
						foreach ($result3 as $tik) {
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
					}
				}
			}
		}else{
			$sqlmasukkerja = "select noind,nama,to_char(masukkerja ,'yyyy-mm') as masukkerja1,masukkerja,to_char(tglkeluar ,'yyyy-mm') as tglkeluar1,tglkeluar,keluar,
									(select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') as cutoff
								from hrd_khs.tpribadi a 
								where noind = '$noind' ";
			$result_masukkerja = $this->personalia->query($sqlmasukkerja)->result_array();
			$masukkerja = $result_masukkerja['0']['masukkerja'];
			$masukkerja1 = $result_masukkerja['0']['masukkerja'];
			$keluarkerja = $result_masukkerja['0']['tglkeluar'];
			$keluarkerja1 = $result_masukkerja['0']['tglkeluar1'];
			$cutoff = $result_masukkerja['0']['cutoff'];

			if($masukkerja1 == $keluarkerja1){
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
						WHERE (a.tanggal >= '$cutoff') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$keluarkerja')
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
			}else{
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
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
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
			}
		}

		return $nilai;
	}

	public function hitung_tik_tdk_cutoff($noind,$awal,$akhir,$chk_khusus,$khusus,$hitung_cutoff){
		$sql = "select case when tanggal_akhir >= '$akhir'::timestamp then
					'awal'
				else
					'akhir'
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$akhir'::timestamp,'yyyymm')
				and os = '0'";
		$result = $this->personalia->query($sql)->result_array();
		$pilih = $result['0']['tanggal'];
		// echo $pilih;exit();
		if ($pilih == "awal") {
			$nilai = 0;
			$sqlmasukkerja = "select noind,nama,to_char(masukkerja ,'yyyy-mm') as masukkerja,to_char(tglkeluar ,'yyyy-mm') as tglkeluar,keluar 
								from hrd_khs.tpribadi t 
								where noind = '$noind' ";
			$result_masukkerja = $this->personalia->query($sqlmasukkerja)->result_array();
			$masukkerja = $result_masukkerja['0']['masukkerja'];
			$keluarkerja = $result_masukkerja['0']['tglkeluar'];

			if ($masukkerja == $keluarkerja) {
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
						WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";

				$result2 = 	$this->personalia->query($sql)->result_array();
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
			}else{	
				if($chk_khusus !== "khusus" or ($chk_khusus == "khusus" && $khusus == "sesudah")){
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
							WHERE (a.tanggal >= to_char('$akhir'::date,'yyyy-mm-01')::date) AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
							ORDER BY tanggal";
					$result2 = 	$this->personalia->query($sql)->result_array();
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
				}

				if($chk_khusus !== "khusus" or ($chk_khusus == "khusus" && $khusus == "sebelum")){
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
							WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= to_char('$akhir'::date,'yyyy-mm-01')::date - interval '1 day')
							ORDER BY tanggal";

					$result3 = 	$this->personalia->query($sql)->result_array();
					$simpan_tgl = "";
					$lanjut = false;
					foreach ($result3 as $tik) {
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
				}
			}
			
		}else{
			$sqlmasukkerja = "select noind,nama,to_char(masukkerja ,'yyyy-mm') as masukkerja1,masukkerja,to_char(tglkeluar ,'yyyy-mm') as tglkeluar1,tglkeluar,keluar,
									(select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') as cutoff
								from hrd_khs.tpribadi a 
								where noind = '$noind' ";
			$result_masukkerja = $this->personalia->query($sqlmasukkerja)->result_array();
			$masukkerja = $result_masukkerja['0']['masukkerja'];
			$masukkerja1 = $result_masukkerja['0']['masukkerja'];
			$keluarkerja = $result_masukkerja['0']['tglkeluar'];
			$keluarkerja1 = $result_masukkerja['0']['tglkeluar1'];
			$cutoff = $result_masukkerja['0']['cutoff'];
			
			if($masukkerja1 == $keluarkerja1){
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
						WHERE (a.tanggal >= '$cutoff') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$keluarkerja')
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
			}else{
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
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";

				$result2 = 	$this->personalia->query($sql)->result_array();
				// echo "<pre>";print_r($result2);echo "</pre>";
				$nilai = 0;
				// echo "Satu :: ".$nilai;exit();
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
			}
		}

		return $nilai;
	}

	public function hitung_tik_diangkat($noind,$awal,$akhir){
 
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
 				WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir') 
 				ORDER BY tanggal";
 
 		$result2 = 	$this->personalia->query($sql)->result_array();

 		$nilai = 0;
 		$simpan_tgl = "";
 		$lanjut = false;
 		if(!empty($result2)){

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
	 			if($ijin <= 0){
	 				$nilai = $nilai;
	 			}elseif($ijin > 0 && $ijin <= 30){
	 				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
	 				if ($cek_denda == false) {
	 					$nilai += $ijin;
	 				}
	 			}else{
	 				$nilai += $ijin;
	 			}
	 
	 			$simpan_tgl = $tik['tanggal'];
	 		}
	 		return $nilai;
 		}else{
 			return 0;
 		}
	}

	public function hitung_tm($noind,$awal,$akhir,$chk_khusus,$khusus,$hitung_cutoff){
		$sql = "select case when tanggal_akhir >= '$akhir'::timestamp then
					'awal'
				else
					'akhir'
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$akhir'::timestamp,'yyyymm')
				and os = '0'";
		// echo "<pre>".$sql;
		$result = $this->personalia->query($sql)->result_array();
		$pilih = $result['0']['tanggal'];
		// echo $pilih;exit();
		if ($pilih == "awal") {
			$sql = "select noind,
							case when to_char(a.masukkerja ,'yyyy-mm') = to_char(a.tglkeluar ,'yyyy-mm') then 
								(
									30 -
									(extract(day from a.tglkeluar) - extract(day from a.masukkerja)) +
									(select count(tanggal) as jml from
										(
											SELECT b.tanggal FROM \"Presensi\".TDataTIM b
											WHERE b.noind = a.noind
											AND b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar 
											AND (b.kd_ket = 'TM')
											UNION
											SELECT c.tanggal from \"Presensi\".TDataPresensi c
											WHERE c.noind = a.noind
											AND c.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar 
											AND (
													(
														(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
														and (
															c.noind like 'K%'
															or c.noind like 'P%'
															or c.noind like 'F%'
															or c.noind like 'Q%'
														)
													)
													or c.kd_ket = 'PIP'
												)
										) as DERIVEDTBL
									)
								)
							else
								case when '$chk_khusus' = 'khusus' then
									case when '$khusus' = 'sebelum' then 
										case when $hitung_cutoff > 0 then
											(
												30 +
												(select count(tanggal) as jml from
													(
														SELECT b.tanggal FROM \"Presensi\".TDataTIM b
														WHERE b.noind = a.noind
														AND b.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
														AND (b.kd_ket = 'TM')
														UNION
														SELECT c.tanggal from \"Presensi\".TDataPresensi c
														WHERE c.noind = a.noind
														AND c.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
														AND (
																(
																	(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
																	and (
																		c.noind like 'K%'
																		or c.noind like 'P%'
																		or c.noind like 'F%'
																		or c.noind like 'Q%'
																	)
																)
																or c.kd_ket = 'PIP'
															)
													) as DERIVEDTBL
												)
											)
										else
	 										30 -
	 										(
	 											select count(distinct tanggal)
	 											from \"Presensi\".tdatapresensi b
	 											where b.noind = a.noind
	 											and b.tanggal between '$awal'::date and to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
	 											and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID','PSK', 'PSP', 'CT', 'CB', 'CBA', 'CD', 'CH', 'CIK', 'CIM', 'CK', 'CM', 'CPA', 'CPP', 'CS', 'PCZ', 'PRM', 'PKK' )
	 										) -
	 										(
	 											select count(*)
	 											from generate_series('$awal',to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day',interval '1 day') as dates
	 											left join \"Presensi\".tshiftpekerja d on dates.dates = d.tanggal
	 											and a.noind = d.noind
	 											where d.tanggal is null
	 										)
	 									end
									else
										(
											30 -
											(extract(day from a.tglkeluar) - 1) +
											(select count(tanggal) as jml from
												(
													SELECT b.tanggal FROM \"Presensi\".TDataTIM b
													WHERE b.noind = a.noind
													AND b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
													AND (b.kd_ket = 'TM')
													UNION
													SELECT c.tanggal from \"Presensi\".TDataPresensi c
													WHERE c.noind = a.noind
													AND c.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
													AND (
															(
																(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
																and (
																	c.noind like 'K%'
																	or c.noind like 'P%'
																	or c.noind like 'F%'
																	or c.noind like 'Q%'
																)
															)
															or c.kd_ket = 'PIP'
														)
												) as DERIVEDTBL
											)
										)
									end
								else
									case when $hitung_cutoff > 0 then 
										(30 -
										(extract(day from a.tglkeluar) - 1) +
										(select count(tanggal) as jml from
										(
											SELECT b.tanggal FROM \"Presensi\".TDataTIM b
											WHERE b.noind = a.noind
											AND b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
											AND (b.kd_ket = 'TM')
											UNION
											SELECT c.tanggal from \"Presensi\".TDataPresensi c
											WHERE c.noind = a.noind
											AND c.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
											AND (
													(
														(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
														and (
															c.noind like 'K%'
															or c.noind like 'P%'
															or c.noind like 'F%'
															or c.noind like 'Q%'
														)
													)
													or c.kd_ket = 'PIP'
												)
											) as DERIVEDTBL
										) +
										(select count(tanggal) as jml from
										(
											SELECT b.tanggal FROM \"Presensi\".TDataTIM b
											WHERE b.noind = a.noind
											AND b.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
											AND (b.kd_ket = 'TM')
											UNION
											SELECT c.tanggal from \"Presensi\".TDataPresensi c
											WHERE c.noind = a.noind
											AND c.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
											AND (
													(
														(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
														and (
															c.noind like 'K%'
															or c.noind like 'P%'
															or c.noind like 'F%'
															or c.noind like 'Q%'
														)
													)
													or c.kd_ket = 'PIP'
												)
											) as DERIVEDTBL
										)
										) 
									else
										(
											30 -
											(extract(day from a.tglkeluar) - 1) +
											(select count(tanggal) as jml from
												(
													SELECT b.tanggal FROM \"Presensi\".TDataTIM b
													WHERE b.noind = a.noind
													AND b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
													AND (b.kd_ket = 'TM')
													UNION
													SELECT c.tanggal from \"Presensi\".TDataPresensi c
													WHERE c.noind = a.noind
													AND c.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
													AND (
															(
																(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
																and (
																	c.noind like 'K%'
																	or c.noind like 'P%'
																	or c.noind like 'F%'
																	or c.noind like 'Q%'
																)
															)
															or c.kd_ket = 'PIP'
														)
												) as DERIVEDTBL
											) - 
											(
	 											select count(distinct tanggal)
	 											from \"Presensi\".tdatapresensi b
	 											where b.noind = a.noind
	 											and b.tanggal between '$awal'::date and to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
	 											and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID','PSK', 'PSP', 'CT', 'CB', 'CBA', 'CD', 'CH', 'CIK', 'CIM', 'CK', 'CM', 'CPA', 'CPP', 'CS', 'PCZ', 'PRM', 'PKK' )
	 										) -
	 										(
	 											select count(*)
	 											from generate_series('$awal',to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day',interval '1 day') as dates
	 											left join \"Presensi\".tshiftpekerja d on dates.dates = d.tanggal
	 											and a.noind = d.noind
	 											where d.tanggal is null
	 										)
										)
									end
								end
							end as total
					from hrd_khs.tpribadi a
					where noind = '$noind'";
		}else{
			$sql = "select noind,
					case when to_char(a.masukkerja ,'yyyy-mm') = to_char(a.tglkeluar ,'yyyy-mm') then
						case when (select t.tanggal_akhir from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') >= a.masukkerja then 
							(
								30 - 
								(
									select count(distinct tanggal)
									from \"Presensi\".tdatapresensi b
									where b.noind = a.noind
									and b.tanggal between (select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') and a.tglkeluar
									and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID','PSK', 'PSP', 'CT', 'CB', 'CBA', 'CD', 'CH', 'CIK', 'CIM', 'CK', 'CM', 'CPA', 'CPP', 'CS', 'PCZ', 'PRM', 'PKK' )
								) -
								(
									select count(*)
									from generate_series((select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0'),a.tglkeluar - interval '1 day',interval '1 day') as dates
									left join \"Presensi\".tshiftpekerja d on dates.dates = d.tanggal
									and a.noind = d.noind
									where d.tanggal is null
								)
							)
						else 
							(
								30 -
								(extract (day from a.tglkeluar) - extract (day from a.masukkerja)) +
								(
									select count(tanggal) as jml from
									(
										SELECT b.tanggal FROM \"Presensi\".TDataTIM b
										WHERE b.noind = a.noind
										AND b.tanggal between (select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') AND a.tglkeluar
										AND (b.kd_ket = 'TM')
										UNION
										SELECT c.tanggal from \"Presensi\".TDataPresensi c
										WHERE c.noind = a.noind
										AND c.tanggal between (select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') AND a.tglkeluar
										AND (
												(
													(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
													and (
														c.noind like 'K%'
														or c.noind like 'P%'
														or c.noind like 'F%'
														or c.noind like 'Q%'
													)
												)
												or c.kd_ket = 'PIP'
											)
									) as DERIVEDTBL
								)								
							)
						end 
					else
						(
							30 -
							(
								select count(distinct tanggal)
								from \"Presensi\".tdatapresensi b
								where b.noind = a.noind
								and b.tanggal between '$awal'::date and a.tglkeluar
								and trim(b.kd_ket) in ('PKJ','PDL','PDB','PLB','PID','PSK', 'PSP', 'CT', 'CB', 'CBA', 'CD', 'CH', 'CIK', 'CIM', 'CK', 'CM', 'CPA', 'CPP', 'CS', 'PCZ', 'PRM', 'PKK' )
							)-
							(
								select count(*)
								from generate_series('$awal',a.tglkeluar - interval '1 day',interval '1 day') as dates
								left join \"Presensi\".tshiftpekerja d on dates.dates = d.tanggal
								and a.noind = d.noind
								where d.tanggal is null
							)
						)
					end as total
					from hrd_khs.tpribadi a
					where noind = '$noind' ";
		}
		// echo "<pre>".$sql;exit();
		$result1 = $this->personalia->query($sql)->result_array();

		return $result1['0']['total'];
	}

	public function hitung_tm_tdk_cutoff($noind,$awal,$akhir,$chk_khusus,$khusus,$hitung_cutoff){
		$sql = "select case when tanggal_akhir >= '$akhir'::timestamp then
					'awal'
				else
					'akhir'
				end as tanggal
				from \"Presensi\".tcutoff
				where periode = to_char('$akhir'::timestamp,'yyyymm')
				and os = '0'";
		// echo "<pre>".$sql;
		$result = $this->personalia->query($sql)->result_array();
		$pilih = $result['0']['tanggal'];
		// echo $pilih;exit();
		if ($pilih == "awal") {
			$sql = "select noind,
							case when to_char(a.masukkerja ,'yyyy-mm') = to_char(a.tglkeluar ,'yyyy-mm') then 
								(
									30 -
									(extract(day from a.tglkeluar) - extract(day from a.masukkerja)) +
									(select count(tanggal) as jml from
										(
											SELECT b.tanggal FROM \"Presensi\".TDataTIM b
											WHERE b.noind = a.noind
											AND b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar 
											AND (b.kd_ket = 'TM')
											UNION
											SELECT c.tanggal from \"Presensi\".TDataPresensi c
											WHERE c.noind = a.noind
											AND c.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date and a.tglkeluar 
											AND (
													(
														(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
														and (
															c.noind like 'K%'
															or c.noind like 'P%'
															or c.noind like 'F%'
															or c.noind like 'Q%'
														)
													)
													or c.kd_ket = 'PIP'
												)
										) as DERIVEDTBL
									)
								)
							else
								case when '$chk_khusus' = 'khusus' then
									case when '$khusus' = 'sebelum' then 
											(
												30  +
												(select count(tanggal) as jml from
													(
														SELECT b.tanggal FROM \"Presensi\".TDataTIM b
														WHERE b.noind = a.noind
														AND b.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
														AND (b.kd_ket = 'TM')
														UNION
														SELECT c.tanggal from \"Presensi\".TDataPresensi c
														WHERE c.noind = a.noind
														AND c.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
														AND (
																(
																	(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
																	and (
																		c.noind like 'K%'
																		or c.noind like 'P%'
																		or c.noind like 'F%'
																		or c.noind like 'Q%'
																	)
																)
																or c.kd_ket = 'PIP'
															)
													) as DERIVEDTBL
												)
											)
									else
										(
											30 -
											(extract(day from a.tglkeluar) - 1) +
											(select count(tanggal) as jml from
												(
													SELECT b.tanggal FROM \"Presensi\".TDataTIM b
													WHERE b.noind = a.noind
													AND b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
													AND (b.kd_ket = 'TM')
													UNION
													SELECT c.tanggal from \"Presensi\".TDataPresensi c
													WHERE c.noind = a.noind
													AND c.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
													AND (
															(
																(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
																and (
																	c.noind like 'K%'
																	or c.noind like 'P%'
																	or c.noind like 'F%'
																	or c.noind like 'Q%'
																)
															)
															or c.kd_ket = 'PIP'
														)
												) as DERIVEDTBL
											)
										)
									end
								else 
									(
										30 -
										(extract(day from a.tglkeluar) - 1) +
										(select count(tanggal) as jml from
										(
											SELECT b.tanggal FROM \"Presensi\".TDataTIM b
											WHERE b.noind = a.noind
											AND b.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
											AND (b.kd_ket = 'TM')
											UNION
											SELECT c.tanggal from \"Presensi\".TDataPresensi c
											WHERE c.noind = a.noind
											AND c.tanggal between to_char(a.tglkeluar,'yyyy-mm-01')::date AND a.tglkeluar
											AND (
													(
														(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
														and (
															c.noind like 'K%'
															or c.noind like 'P%'
															or c.noind like 'F%'
															or c.noind like 'Q%'
														)
													)
													or c.kd_ket = 'PIP'
												)
											) as DERIVEDTBL
										) +
										(select count(tanggal) as jml from
										(
											SELECT b.tanggal FROM \"Presensi\".TDataTIM b
											WHERE b.noind = a.noind
											AND b.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
											AND (b.kd_ket = 'TM')
											UNION
											SELECT c.tanggal from \"Presensi\".TDataPresensi c
											WHERE c.noind = a.noind
											AND c.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date - interval '1 day'
											AND (
													(
														(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
														and (
															c.noind like 'K%'
															or c.noind like 'P%'
															or c.noind like 'F%'
															or c.noind like 'Q%'
														)
													)
													or c.kd_ket = 'PIP'
												)
											) as DERIVEDTBL
										)
									)
								end
							end as total
					from hrd_khs.tpribadi a
					where noind = '$noind'";
		}else{
			$sql = "select noind,
					case when to_char(a.masukkerja ,'yyyy-mm') = to_char(a.tglkeluar ,'yyyy-mm') then
						case when (select t.tanggal_akhir from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') >= a.masukkerja then 
							(
								30 + 
								(30 - extract(day from a.tglkeluar::date - interval '1 day')) +
								(
									select count(tanggal) as jml from
									(
										SELECT b.tanggal FROM \"Presensi\".TDataTIM b
										WHERE b.noind = a.noind
										AND b.tanggal between (select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') AND a.tglkeluar
										AND (b.kd_ket = 'TM')
										UNION
										SELECT c.tanggal from \"Presensi\".TDataPresensi c
										WHERE c.noind = a.noind
										AND c.tanggal between (select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') AND a.tglkeluar
										AND (
												(
													(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
													and (
														c.noind like 'K%'
														or c.noind like 'P%'
														or c.noind like 'F%'
														or c.noind like 'Q%'
													)
												)
												or c.kd_ket = 'PIP'
											)
									) as DERIVEDTBL
								)
							)
						else 
							(
								30 -
								(extract (day from a.tglkeluar) - extract (day from a.masukkerja)) +
								(
									select count(tanggal) as jml from
									(
										SELECT b.tanggal FROM \"Presensi\".TDataTIM b
										WHERE b.noind = a.noind
										AND b.tanggal between (select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') AND a.tglkeluar
										AND (b.kd_ket = 'TM')
										UNION
										SELECT c.tanggal from \"Presensi\".TDataPresensi c
										WHERE c.noind = a.noind
										AND c.tanggal between (select t.tanggal_akhir + interval '1 day' from \"Presensi\".tcutoff t where to_char(a.tglkeluar,'yyyymm') = t.periode and os ='0') AND a.tglkeluar
										AND (
												(
													(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
													and (
														c.noind like 'K%'
														or c.noind like 'P%'
														or c.noind like 'F%'
														or c.noind like 'Q%'
													)
												)
												or c.kd_ket = 'PIP'
											)
									) as DERIVEDTBL
								)								
							)
						end 
					else
						(
							30 +
							(30 - extract(day from a.tglkeluar::date - interval '1 day')) +
							(select count(tanggal) as jml from
								(
									SELECT b.tanggal FROM \"Presensi\".TDataTIM b
									WHERE b.noind = a.noind
									AND b.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date + interval '1 month' - interval '1 day'
									AND (b.kd_ket = 'TM')
									UNION
									SELECT c.tanggal from \"Presensi\".TDataPresensi c
									WHERE c.noind = a.noind
									AND c.tanggal between '$awal' AND to_char(a.tglkeluar,'yyyy-mm-01')::date + interval '1 month' - interval '1 day'
									AND (
											(
												(c.kd_ket = 'PSK' or c.kd_ket = 'PRM')
												and (
													c.noind like 'K%'
													or c.noind like 'P%'
													or c.noind like 'F%'
													or c.noind like 'Q%'
												)
											)
											or c.kd_ket = 'PIP'
										)
									) as DERIVEDTBL
								)
						) 
					end as total
					from hrd_khs.tpribadi a
					where noind = '$noind' ";
		}
		// echo "<pre>".$sql;exit();
		$result1 = $this->personalia->query($sql)->result_array();

		return $result1['0']['total'];
	}

	public function hitung_tm_diangkat($noind,$awal,$akhir){
		$sql = "select count(tanggal) as jml from 
 				(SELECT tanggal FROM \"Presensi\".TDataTIM 
 				WHERE noind = '$noind' 
 				AND tanggal >= '$awal' 
 				AND tanggal <= '$akhir' 
 				AND (kd_ket = 'TM') 
 				UNION 
 				SELECT tanggal FROM \"Presensi\".TDataPresensi 
 				WHERE noind = '$noind' 
 				AND tanggal >= '$awal' 
 				AND tanggal <= '$akhir' 
 				AND (((kd_ket = 'PSK' or kd_ket = 'PRM') and (noind like 'K%' or noind like 'P%' or noind like 'F%' or noind like 'Q%')) or kd_ket = 'PIP')) 
 				DERIVEDTBL ";
 		$result1 = $this->personalia->query($sql)->row();
 		if(!empty($result1) and isset($result1->jml)){
 			return $result1->jml;
 		}else{
 			return 0;
 		}	
 		
	}

	public function cek_cutoff_custom($noind,$tgl_keluar){
		$sql = "select noind
				from \"Presensi\".tcutoff_custom_terproses tcs
				inner join \"Presensi\".tcutoff tc 
				 	on to_char(tc.tanggal_awal,'yyyymm') = to_char(tcs.tanggal_proses,'yyyymm')
				 	and to_char(tc.tanggal_akhir,'yyyymm') = tc.periode
				 	and tc.os = '0'
				where tcs.noind = '$noind'
				and tcs.terakhir = '1'
				and '$tgl_keluar'  between tc.tanggal_awal and tc.tanggal_akhir	
				union				
				select noind 
				from \"Presensi\".tcutoff_custom_susulan tcs2 
				inner join \"Presensi\".tcutoff tc2 
				on to_char(tc2.tanggal_awal,'yyyymm') = to_char(tcs2.created_timestamp,'yyyymm')
				 	and to_char(tc2.tanggal_akhir,'yyyymm') = tc2.periode
				 	and tc2.os = '0'
				where tcs2.noind ='$noind'
				and '$tgl_keluar' between tc2.tanggal_awal and tc2.tanggal_akhir	";
		return $this->personalia->query($sql)->num_rows();
	}

	public function cek_cutoff_custom_hitung($noind,$tgl_keluar){
 		$sql = "select *
 				from \"Presensi\".tcutoff_custom_memo tcm
 				inner join \"Presensi\".tcutoff_custom_memo_detail tcmd 
 				on tcm.id_memo = tcmd.id_memo
 				inner join \"Presensi\".tcutoff tc 
 				on to_char(tc.tanggal_awal,'yyyymm') = to_char(tcm.periode,'yyyymm')
 				and to_char(tc.tanggal_akhir,'yyyymm') = tc.periode
 				and tc.os = '0'
 				where tcmd.noind = '$noind'
 				and tcm.status = '1'
 				and '$tgl_keluar' between tc.tanggal_awal and tc.tanggal_akhir";
 		return $this->personalia->query($sql)->num_rows();
 	}

	public function getPribadi($noind){
		$sql = "select * from hrd_khs.tpribadi a left join hrd_khs.tseksi b on a.kodesie = b.kodesie where noind = '$noind'";
		return $this->personalia->query($sql)->row();
	}

	public function getDetailPresensi($noind){
		$sql = "select tbl.tanggal,
		ts.shift,
		tdp.kd_ket as ket_dp,
		tdp.total_lembur,
		tdp.masuk as masuk_dp,
		tdp.keluar as keluar_dp,
		tdt.kd_ket as ket_dt,
		tdt.point as point,
		tdt.keluar as keluar_dt,
		tdt.masuk as masuk_dt
		from
		(
		select tgl as tanggal
		from generate_series((select to_char((tglkeluar - interval '1 month'),'yyyy-mm-01')::date as tanggal from hrd_khs.tpribadi e where e.noind = '$noind'),
		(select to_char((tglkeluar + interval '1 month'),'yyyy-mm-01')::date - interval '1 day' as tanggal from hrd_khs.tpribadi e where e.noind = '$noind'),
		interval '1 day') as tgl
		) as tbl
		left join \"Presensi\".tshiftpekerja tsp
		on tbl.tanggal = tsp.tanggal
		and tsp.noind = '$noind'
		left join \"Presensi\".tdatapresensi tdp
		on tbl.tanggal = tdp.tanggal
		and tdp.noind = '$noind'
		left join \"Presensi\".tdatatim tdt
		on tbl.tanggal = tdt.tanggal
		and tdt.noind = '$noind'
		left join \"Presensi\".tshift ts
		on tsp.kd_shift = ts.kd_shift
		order by 1";
		return $this->personalia->query($sql)->result_array();
	}

	public function get_bpjs_tk($noind){
		$sql = "select case when b.angg_jkn is not null then
						'TIDAK'
					else
						case when a.masukkerja >= concat(extract(year from a.tglkeluar),'-',extract(month from a.tglkeluar),'-','01')::date then
							'TIDAK'
						else
							'YA'
						end
					end as bpjstk
				from hrd_khs.tpribadi a
				left join \"Presensi\".treffgaji b
				on a.noind = b.noind
				and extract(month from a.tglkeluar) = extract(month from b.tanggal)
				and extract(year from a.tglkeluar) = extract(year from b.tanggal)
				where a.noind = '$noind' ";
		return $this->personalia->query($sql)->row()->bpjstk;
	}

	public function get_bpjs_kn($noind){
		$sql = "select case when b.angg_jkn is not null then
						'YA'
					else
						case when extract(day from a.tglkeluar) <= 15 then
							case when a.masukkerja >= concat(extract(year from a.tglkeluar),'-',extract(month from a.tglkeluar) - 1,'-','16')::date then
								'TIDAK'
							else
								'YA'
							end
						else
							case when a.masukkerja >= concat(extract(year from a.tglkeluar),'-',extract(month from a.tglkeluar),'-','16')::date then
								'TIDAK'
							else
								'YA'
							end
						end
					end as bpjskn
				from hrd_khs.tpribadi a
				left join \"Presensi\".treffgaji b
				on a.noind = b.noind
				and extract(month from a.tglkeluar) = extract(month from b.tanggal)
				and extract(year from a.tglkeluar) = extract(year from b.tanggal)
				where a.noind = '$noind'";
		return $this->personalia->query($sql)->row()->bpjskn;
	}

	public function get_bpjs($noind){
		$sql = "select noind,nama,
				 case when bpjs_kes = '1' and tglberlaku_kes <= current_date then
				 	case when masukkerja >= concat(extract(year from tglkeluar),'-',extract(month from tglkeluar),'-','16')::date then
						'TIDAK'
					else
						'YA'
					end
				 else
				 	'Tidak'
				 end as jkn,
				 case when bpjs_jht = '1' and tglberlaku_jht <= current_date then
				 	case when masukkerja >= concat(extract(year from tglkeluar),'-',extract(month from tglkeluar),'-','01')::date then
						'TIDAK'
					else
						case when (select count(*) from \"Presensi\".treffgaji tr where tp.noind = tr.noind and to_char(tp.tglkeluar,'YYYY-MM') = to_Char(tr.tanggal,'YYYY-MM')) > 0 then
							'TIDAK'
						else 
							'YA'
						end
					end
				 else
				 	'Tidak'
				 end as jht,
				 case when bpjs_ket = '1' and tglberlaku_ket <= current_date then
				 	case when masukkerja >= concat(extract(year from tglkeluar),'-',extract(month from tglkeluar),'-','01')::date then
						'TIDAK'
					else
						case when (select count(*) from \"Presensi\".treffgaji tr where tp.noind = tr.noind and to_char(tp.tglkeluar,'YYYY-MM') = to_Char(tr.tanggal,'YYYY-MM')) > 0 then
							'TIDAK'
						else 
							'YA'
						end
					end
				 else
				 	'Tidak'
				 end as jp
				 from hrd_khs.tpribadi tp
				 where noind = '$noind'";
		return $this->personalia->query($sql)->row();
	}

	public function delete_reffgajikeluar($noind){
		$sql = "delete from \"Presensi\".treffgaji_keluar where noind = '$noind'";
		$this->personalia->query($sql);
	}

	public function insert_reffgajikeluar($data){
		$this->personalia->insert("\"Presensi\".treffgaji_keluar",$data);
	}

	public function potongan($noind){
		$sql = "select coalesce((select sum(nominal_potongan) as potongan
				from \"Presensi\".tpotongan a
				left join \"Presensi\".tpotongan_detail b
				on a.potongan_id = b.potongan_id
				left join \"Presensi\".tjenis_potongan c
				on a.jenis_potongan_id = c.jenis_potongan_id
				where a.noind = '$noind'
				and b.status = 1
				group by a.noind),0) as potongan";
		return $this->personalia->query($sql)->row()->potongan;
	}

	public function jumlah_jkn($noind){
		$sql = "select noind,nama,
				 case when bpjs_kes = '1' and tglberlaku_kes <= current_date then
				 	case when masukkerja >= concat(extract(year from tglkeluar),'-',extract(month from tglkeluar),'-','16')::date then
						0
					else
						1 + (
							select count(*)
							from hrd_khs.tbpjs_tambahan
							where noind = '$noind'
							and status = '1'
						)
					end
				 else
				 	0
				 end as jkn
				 from hrd_khs.tpribadi tp
				 where noind = '$noind'";
		return $this->personalia->query($sql)->row()->jkn;
	}

	public function jumlah_jht($noind){
		$sql = "select noind,nama,
				 case when bpjs_ket = '1' and tglberlaku_jht <= current_date then
				 	case when masukkerja >= concat(extract(year from tglkeluar),'-',extract(month from tglkeluar),'-','01')::date then
						0
					else
						case when (select count(*) from \"Presensi\".treffgaji tr where tp.noind = tr.noind and to_char(tp.tglkeluar,'YYYY-MM') = to_Char(tr.tanggal,'YYYY-MM')) > 0 then
							0
						else 
							1
						end
					end
				 else
				 	0
				 end as jht
				 from hrd_khs.tpribadi tp
				 where noind = '$noind'";
		return $this->personalia->query($sql)->row()->jht;
	}

	public function jumlah_jp($noind){
		$sql = "select noind,nama,
				 case when bpjs_jht = '1' and tglberlaku_ket <= current_date then
				 	case when masukkerja >= concat(extract(year from tglkeluar),'-',extract(month from tglkeluar),'-','01')::date then
						0
					else
						case when (select count(*) from \"Presensi\".treffgaji tr where tp.noind = tr.noind and to_char(tp.tglkeluar,'YYYY-MM') = to_Char(tr.tanggal,'YYYY-MM')) > 0 then
							0
						else 
							1
						end
					end
				 else
				 	0
				 end as jp
				 from hrd_khs.tpribadi tp
				 where noind = '$noind'";
		return $this->personalia->query($sql)->row()->jp;
	}

	public function cek_noind_berubah($noind){
		$sql = "select * 
				from hrd_khs.tpribadi pri 
				where pri.noind = '$noind'
				and pri.sebabklr like '%NO INDUK BERUBAH%'";
		$result = $this->personalia->query($sql)->result_array();
		return count($result);
	}


	public function get_kom_susulan($noind,$akhir){
		$sql = "select distinct tanggal , 
                 ( 
                     select gp_sebelum 
                     from \"Presensi\".tsusulan_keterangan b 
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0' 
                     order by b.create_date 
                     Limit 1 
                 ) as gp,  ( 
                     select if_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as if_,   ( 
                     select ip_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as ip_,   ( 
                     select ik_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as ik_,   ( 
                     select ubt_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as ubt,   ( 
                     select upamk_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as upamk,   ( 
                     select ipt_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as ipt,   ( 
                     select imm_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as imm,   ( 
                     select ims_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as ims,   ( 
                     select umc_sebelum 
                     from \"Presensi\".tsusulan_keterangan b  
                     Where a.noind = b.noind And a.tanggal = b.tanggal and b.status = '0'  
                     order by b.create_date  
                     Limit 1  
                 ) as umc   from \"Presensi\".tsusulan a  
         where a.noind = '$noind'  
         and (a.ket like '%TUKAR SHIFT%' or a.ket like '%PRES. MANUAL%')  
         and a.stat = '0'  
         and date_part('year', a.tanggal) = date_part('year', '$akhir'::date) ";
        return $this->personalia->query($sql)->result_array();
	}

	public function if_susulan($noind,$tanggal){
		$sql = "select count(a.tanggal) as jml 
				FROM \"Presensi\".TDataPresensi a INNER JOIN 
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal 
				AND a.noind = b.noind 
				WHERE a.tanggal = '$tanggal'
				AND (a.kd_ket = 'PKJ' or (a.kd_ket = 'PDL') or (a.kd_ket = 'PDB') or a.kd_ket = 'PLB' or a.kd_ket = 'PID') 
				AND a.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

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
					UNION
					SELECT a.tanggal, a.noind,
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
							FROM \"Presensi\".TDataPresensi a INNER JOIN
							\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
							WHERE (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal = '$tanggal')
					ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
			
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
			// echo "ijine:".$ijin."<br>";
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= $ijin;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= $ijin;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function htm_susulan($noind,$tanggal){
		$sql = "select count(tanggal) as jml from 
        (SELECT tanggal FROM \"Presensi\".TDataTIM 
        WHERE noind = '$noind' 
        AND tanggal = '$tanggal'
        AND (kd_ket = 'TM') 
        UNION 
        SELECT tanggal FROM \"Presensi\".TDataPresensi 
        WHERE noind = '$noind' 
        AND tanggal = '$tanggal' 
        AND (((kd_ket = 'PSK' or kd_ket = 'PRM') and (noind like 'K%' or noind like 'P%' or noind like 'F%' or noind like 'Q%')) or kd_ket = 'PIP')) 
        DERIVEDTBL ";
        $result1 = 	$this->personalia->query($sql)->result_array();

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
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
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
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai += $ijin;
					}
				}
			}else{
				if($lanjut == false){
					$nilai += $ijin;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function ipt_susulan($noind,$tanggal){
		$sql = " select * 
				 from hrd_khs.tpribadi a 
				 where a.noind = '$noind' 
				 and ( 
				     a.lokasi_kerja = '02' 
				     or 
				     ( 
				         select count(*) 
				         from hrd_khs.tmutasi b 
				         Where a.noind = b.noind 
				         and b.tglberlaku between '$tanggal' and now() 
				         and ( 
				                 b.lokasilm = '02' 
				                 or 
				                 b.lokasibr = '02' 
				             ) 
				      ) > 0 
				     ) ";
		$result = $this->personalia->query($sql)->result_array();
		if (!empty($result)) {
			$sql = "select noind ,lokasilm, lokasibr,
						 case when lokasilm != '02' then
						     tglberlaku 
						 else 
						     '$tanggal'
						 end as mulai, 
						 case when lokasibr != '02' then  
						     case when '$tanggal' > tglberlaku - interval '1 day' then
						         tglberlaku -Interval  '1 day' 
						     Else 
						         '$tanggal' 
						     end
						 else 
						      '$tanggal' 
						 end as selesai 
					from hrd_khs.tmutasi 
					where tglberlaku between '$tanggal' and now() 
					and (lokasilm ='02' or lokasibr = '02') 
					and noind = '$noind' ";
			$result_2 = $this->personalia->query($sql)->row();
			if (!empty($result_2)) {
				foreach ($result_2 as $key) {
					$awal = $key->mulai;
					$akhir = $key->selesai;

					$sql = "select count(tdp.tanggal) as jml
							FROM \"Presensi\".TDataPresensi tdp INNER JOIN
							(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
							WHERE tdp.tanggal >= '$awal' AND tdp.tanggal <= '$akhir'
							AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
							AND tdp.noind = '$noind'";
					$result1 = $this->personalia->query($sql)->result_array();

					$sql = "select a.tanggal, a.noind,
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
							FROM \"Presensi\".TDataPresensi a INNER JOIN
							\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
							WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
							(a.tanggal <= '$akhir')
							Union
							SELECT a.tanggal, a.noind,
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
							WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
							ORDER BY tanggal";
					$result2 = $this->personalia->query($sql)->result_array();
					if(!empty($result1)){
						$nilai = $result1['0']['total'];
					}else{
						$nilai = 0;
					}
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

						$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
						if ($ijin <= 0) {
							$nilai = $nilai;
						}else if($ijin > 0 && $ijin <= 60){
							$nilai = $nilai;
						}else{
							if($lanjut == false){
								$nilai -= 1;
							}
						}

						$simpan_tgl = $tik['tanggal'];
					}

				}
			}else{
				$awal = $tanggal;
				$akhir = $tanggal;

				$sql = "select count(tdp.tanggal) as jml
						FROM \"Presensi\".TDataPresensi tdp INNER JOIN
						(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
						WHERE tdp.tanggal >= '$awal' AND tdp.tanggal <= '$akhir'
						AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
						AND tdp.noind = '$noind'";
				$result1 = $this->personalia->query($sql)->result_array();

				$sql = "select a.tanggal, a.noind,
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
						FROM \"Presensi\".TDataPresensi a INNER JOIN
						\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
						(a.tanggal <= '$akhir')
						Union
						SELECT a.tanggal, a.noind,
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
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";
				$result2 = $this->personalia->query($sql)->result_array();
				if(!empty($result1)){
					$nilai = $result1['0']['total'];
				}else{
					$nilai = 0;
				}
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

					$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
					if ($ijin <= 0) {
						$nilai = $nilai;
					}else if($ijin > 0 && $ijin <= 60){
						$nilai = $nilai;
					}else{
						if($lanjut == false){
							$nilai -= 1;
						}
					}

					$simpan_tgl = $tik['tanggal'];
				}
			}

			return $nilai;
		}else{
			return 0;
		}
	}

	public function um_cabang_susulan($noind,$tanggal){
		$nilai = 0;
		$sql = " select * 
		         from hrd_khs.tpribadi a 
		         where a.noind = '$noind' 
		         and ( 
		             a.lokasi_kerja not in ('01','02','03','04')
		             or 
		             ( 
		                 select count(*) 
		                 from hrd_khs.tmutasi b 
		                 Where a.noind = b.noind 
		                 and b.tglberlaku between '$tanggal' and now()
		                 and ( 
		                         b.lokasilm not in ('01','02','03','04') 
		                         or 
		                         b.lokasibr not in ('01','02','03','04') 
		                     ) 
		              ) > 0 
		             ) ";
		$result = $this->personalia->query($sql)->result_array();
		if (!empty($result)) {
			$sql = "select noind ,lokasilm, lokasibr, 
			         case when lokasilm in ('01','02','03','04') then 
			             tglberlaku 
			         else 
			             '$tanggal' 
			         end as mulai, 
			         case when lokasibr in ('01','02','03','04') then  
			              tglberlaku - interval '1 day'
			         else 
			              '$tanggal' 
			         end as selesai 
			        from hrd_khs.tmutasi 
			        where tglberlaku between '$tanggal' and now()
			        and (lokasilm not in ('01','02','03','04') or lokasibr not in ('01','02','03','04')) 
			        and noind = '$noind' ";
			$result_2 = $this->personalia->query($sql)->row();    
			if (!empty($result_2)) {
				foreach ($result_2 as $key) {
					$awal = $key->mulai;
					$akhir = $key->selesai;

					$sql = "select 
				                   round( 
				                   ( count( tsp.tanggal ) 
				                   - 
				                   (  
				                       case  
				                       when ( extract( month from( '$akhir' )::date )+ 1 )= extract( month from( '$akhir' )::date )  
				                           then  
				                               case  
				                               when( 30 -(( '$akhir'::date - '$awal'::date )+ 1 ))>= 0  
				                                   then 
				                                   ( 30 -(( '$akhir'::date - '$awal'::date )+ 1 ))  
				                               else  
				                                   0  
				                               end  
				                       else  
				                           0  
				                       end  
				                   ) 
				                   -  
				                   sum(  
				                       coalesce( 
				                           (  
				                               select  
				                                   sum(  
				                                       case  
				                                           when tdt1.kd_ket = 'TM'  
				                                               or( tdt1.kd_ket = '' and tdt1.masuk = '0' )  
				                                               or tdt1.point = '1'  
				                                       then  
				                                               1  
				                                           when tdt1.kd_ket = 'TIK'  
				                                           or( tdt1.kd_ket = '' and tdt1.masuk != '0' )  
				                                           then  
				                                               case  
				                                               when tdt1.keluar::time between tsp.jam_msk::time and '12:00:00'::time  
				                                               then  
				                                                   case  
				                                                   when tdt1.masuk::time between tsp.jam_msk::time and '12:00:00'::time  
				                                               then  
				                                                       0  
				                                                   else  
				                                                       1  
				                                                   end  
				                                               else  
				                                               0  
				                                               end  
				                                           end  
				                                   )  
				                           from \"Presensi\".tdatatim tdt1  
				                               where tdt1.noind = tsp.noind  
				                               and tdt1.tanggal = tsp.tanggal  
				                           ) 
				                       , 0  
				                       ) 
				                   ) 
				                   +  
				                   sum(  
				                       coalesce( 
				                       (  
				                               select  
				                                   sum(  
				                                       case  
				                                           when tdp1.kd_ket = 'PLB'  
				                                           then  
				                                               case  
				                                                   when extract( dow from tsp.tanggal::date )= '7'  
				                                                   then  
				                                                       case when tdp1.keluar::time > '18:00:00'::time  
				                                                   then  
				                                                           2  
				                                                       else  
				                                                           case  
				                                                               when tdp1.keluar::time > '11:45:00'::time  
				                                                               then  
				                                                                   1  
				                                                               else  
				                                                                   0  
				                                                               end  
				                                                   end  
				                                                   else  
				                                                       case  
				                                                           when tdp1.keluar::time > '18:00:00'::time  
				                                                           then  
				                                                               case  
				                                                               when 
				                                                                   (  
				                                                                       select count(*)  
				                                                                       from \"Presensi\".tprs_shift tps  
				                                                                   where tps.noind = tsp.noind  
				                                                                       and tps.tanggal = tsp.tanggal  
				                                                                       )% 2 = 0  
				                                                               then 
				                                                                   (  
				                                                                       select  
				                                                                           sum(  
				                                                                               case  
				                                                                                   when '18:00:00'::time  
				                                                                                   between tbl2.awal and tbl2.akhir::time  
				                                                                               then  
				                                                                                       1  
				                                                                                   else  
				                                                                                       0  
				                                                                                   end  
				                                                                           ) as jml  
				                                                                       from(  
				                                                                           select 
				                                                                               (  
				                                                                                   select  
				                                                                                   max( tps2.waktu::time )  
				                                                                                   from \"Presensi\".tprs_shift as tps2  
				                                                                                   where tps2.noind = tsp.noind  
				                                                                                   and tps2.tanggal = tsp.tanggal  
				                                                                                   and tps2.waktu < tbl.waktu  
				                                                                               ) as awal,  
				                                                                               tbl.waktu as akhir  
				                                                                           from(  
				                                                                               select waktu,  
				                                                                               row_number() over( order by waktu::time ) as numrow  
				                                                                           from \"Presensi\".tprs_shift as tps  
				                                                                               where tps.noind = tsp.noind  
				                                                                               and tps.tanggal = tsp.tanggal  
				                                                                               order by tps.waktu::time  
				                                                                           ) as tbl  
				                                                                           where numrow % 2 = 0  
				                                                                           ) as tbl2  
				                                                                       )  
				                                                               else  
				                                                                   0  
				                                                           end  
				                                                       else  
				                                                           0  
				                                                       end  
				                                               end  
				                                           else  
				                                               0  
				                                           end  
				                                   )  
				                               from \"Presensi\".tdatapresensi tdp1  
				                           where tdp1.noind = tsp.noind  
				                               and tdp1.tanggal = tsp.tanggal  
				                               ) 
				                       , 0 ) 
				                   ) 
				                   -  
				                   sum(  
				                       coalesce( 
				                           (  
				                               select  
				                               sum(  
				                                       case  
				                                           when( tdp1.kd_ket in( 'PSK', 'PRM', 'PKK', 'PIP', 'PCZ' ) or( tdp1.kd_ket != 'CB' and tdp1.kd_ket like 'C%' ))  
				                                           or( tdp1.kd_ket = 'PDL' and( tdp1.masuk = '0' or tdp1.masuk = '' ))  
				                                           then  
				                                               1  
				                                           when tdp1.kd_ket = rtrim( 'PDL' )  
				                                           and( tdp1.masuk != rtrim( '0' )  
				                                           or tdp1.masuk != rtrim( '' ))  
				                                           then  
				                                           case  
				                                                   when tdp1.keluar::time between tsp.jam_msk::time and '12:00:00'::time  
				                                                   then  
				                                                       case  
				                                                           when tdp1.masuk::time between tsp.jam_msk::time and '12:00:00'::time  
				                                                           then  
				                                                               0  
				                                                           else  
				                                                               1  
				                                                           end  
				                                               else  
				                                                   0  
				                                                   end  
				                                           when tdp1.kd_ket = rtrim( 'PSP' )  
				                                           then  
				                                               case  
				                                                   when tdp1.keluar::time between tsp.jam_msk::time and( tsp.ist_selesai::time - interval '1 second' )  
				                                                   then  
				                                                       case  
				                                                           when tdp1.masuk::time between tsp.jam_msk::time and( tsp.ist_selesai::time - interval '1 second' )  
				                                                       then  
				                                                               0  
				                                                           else  
				                                                               1  
				                                                           end  
				                                                   when tdp1.keluar::time between tsp.ist_selesai::time and( tsp.jam_plg::time - interval '1 second' )  
				                                                   then  
				                                                       case  
				                                                           when tdp1.masuk::time >=( tsp.ist_selesai::time - interval '1 second' )  
				                                                           then  
				                                                           0  
				                                                           else  
				                                                               1  
				                                                           end  
				                                                   end  
				                                           end  
				                                   )  
				                               from \"Presensi\".tdatapresensi tdp1  
				                               where tdp1.noind = tsp.noind  
				                               and tdp1.tanggal = tsp.tanggal  
				                           ) 
				                       , 0  
				                       ) 
				                       ) 
				                   )::decimal 
				                   , 2  
				                   ) as um 
		                 from 
		                   \"Presensi\".tshiftpekerja tsp 
		                 where 
		                   tsp.noind = '$noind' 
		                   and tsp.tanggal between '$awal' and '$akhir' ";
                   $result1 = $this->personalia->query($sql)->row();
                   if(!empty($result1)){
                   		$nilai += $result1->um;
                   }
				}
			}else{
				$awal = $tanggal;
				$akhir = $tanggal;

				$sql = "select 
				                   round( 
				                   ( count( tsp.tanggal ) 
				                   - 
				                   (  
				                       case  
				                       when ( extract( month from( '$akhir' )::date )+ 1 )= extract( month from( '$akhir' )::date )  
				                           then  
				                               case  
				                               when( 30 -(( '$akhir'::date - '$awal'::date )+ 1 ))>= 0  
				                                   then 
				                                   ( 30 -(( '$akhir'::date - '$awal'::date )+ 1 ))  
				                               else  
				                                   0  
				                               end  
				                       else  
				                           0  
				                       end  
				                   ) 
				                   -  
				                   sum(  
				                       coalesce( 
				                           (  
				                               select  
				                                   sum(  
				                                       case  
				                                           when tdt1.kd_ket = 'TM'  
				                                               or( tdt1.kd_ket = '' and tdt1.masuk = '0' )  
				                                               or tdt1.point = '1'  
				                                       then  
				                                               1  
				                                           when tdt1.kd_ket = 'TIK'  
				                                           or( tdt1.kd_ket = '' and tdt1.masuk != '0' )  
				                                           then  
				                                               case  
				                                               when tdt1.keluar::time between tsp.jam_msk::time and '12:00:00'::time  
				                                               then  
				                                                   case  
				                                                   when tdt1.masuk::time between tsp.jam_msk::time and '12:00:00'::time  
				                                               then  
				                                                       0  
				                                                   else  
				                                                       1  
				                                                   end  
				                                               else  
				                                               0  
				                                               end  
				                                           end  
				                                   )  
				                           from \"Presensi\".tdatatim tdt1  
				                               where tdt1.noind = tsp.noind  
				                               and tdt1.tanggal = tsp.tanggal  
				                           ) 
				                       , 0  
				                       ) 
				                   ) 
				                   +  
				                   sum(  
				                       coalesce( 
				                       (  
				                               select  
				                                   sum(  
				                                       case  
				                                           when tdp1.kd_ket = 'PLB'  
				                                           then  
				                                               case  
				                                                   when extract( dow from tsp.tanggal::date )= '7'  
				                                                   then  
				                                                       case when tdp1.keluar::time > '18:00:00'::time  
				                                                   then  
				                                                           2  
				                                                       else  
				                                                           case  
				                                                               when tdp1.keluar::time > '11:45:00'::time  
				                                                               then  
				                                                                   1  
				                                                               else  
				                                                                   0  
				                                                               end  
				                                                   end  
				                                                   else  
				                                                       case  
				                                                           when tdp1.keluar::time > '18:00:00'::time  
				                                                           then  
				                                                               case  
				                                                               when 
				                                                                   (  
				                                                                       select count(*)  
				                                                                       from \"Presensi\".tprs_shift tps  
				                                                                   where tps.noind = tsp.noind  
				                                                                       and tps.tanggal = tsp.tanggal  
				                                                                       )% 2 = 0  
				                                                               then 
				                                                                   (  
				                                                                       select  
				                                                                           sum(  
				                                                                               case  
				                                                                                   when '18:00:00'::time  
				                                                                                   between tbl2.awal and tbl2.akhir::time  
				                                                                               then  
				                                                                                       1  
				                                                                                   else  
				                                                                                       0  
				                                                                                   end  
				                                                                           ) as jml  
				                                                                       from(  
				                                                                           select 
				                                                                               (  
				                                                                                   select  
				                                                                                   max( tps2.waktu::time )  
				                                                                                   from \"Presensi\".tprs_shift as tps2  
				                                                                                   where tps2.noind = tsp.noind  
				                                                                                   and tps2.tanggal = tsp.tanggal  
				                                                                                   and tps2.waktu < tbl.waktu  
				                                                                               ) as awal,  
				                                                                               tbl.waktu as akhir  
				                                                                           from(  
				                                                                               select waktu,  
				                                                                               row_number() over( order by waktu::time ) as numrow  
				                                                                           from \"Presensi\".tprs_shift as tps  
				                                                                               where tps.noind = tsp.noind  
				                                                                               and tps.tanggal = tsp.tanggal  
				                                                                               order by tps.waktu::time  
				                                                                           ) as tbl  
				                                                                           where numrow % 2 = 0  
				                                                                           ) as tbl2  
				                                                                       )  
				                                                               else  
				                                                                   0  
				                                                           end  
				                                                       else  
				                                                           0  
				                                                       end  
				                                               end  
				                                           else  
				                                               0  
				                                           end  
				                                   )  
				                               from \"Presensi\".tdatapresensi tdp1  
				                           where tdp1.noind = tsp.noind  
				                               and tdp1.tanggal = tsp.tanggal  
				                               ) 
				                       , 0 ) 
				                   ) 
				                   -  
				                   sum(  
				                       coalesce( 
				                           (  
				                               select  
				                               sum(  
				                                       case  
				                                           when( tdp1.kd_ket in( 'PSK', 'PRM', 'PKK', 'PIP', 'PCZ' ) or( tdp1.kd_ket != 'CB' and tdp1.kd_ket like 'C%' ))  
				                                           or( tdp1.kd_ket = 'PDL' and( tdp1.masuk = '0' or tdp1.masuk = '' ))  
				                                           then  
				                                               1  
				                                           when tdp1.kd_ket = rtrim( 'PDL' )  
				                                           and( tdp1.masuk != rtrim( '0' )  
				                                           or tdp1.masuk != rtrim( '' ))  
				                                           then  
				                                           case  
				                                                   when tdp1.keluar::time between tsp.jam_msk::time and '12:00:00'::time  
				                                                   then  
				                                                       case  
				                                                           when tdp1.masuk::time between tsp.jam_msk::time and '12:00:00'::time  
				                                                           then  
				                                                               0  
				                                                           else  
				                                                               1  
				                                                           end  
				                                               else  
				                                                   0  
				                                                   end  
				                                           when tdp1.kd_ket = rtrim( 'PSP' )  
				                                           then  
				                                               case  
				                                                   when tdp1.keluar::time between tsp.jam_msk::time and( tsp.ist_selesai::time - interval '1 second' )  
				                                                   then  
				                                                       case  
				                                                           when tdp1.masuk::time between tsp.jam_msk::time and( tsp.ist_selesai::time - interval '1 second' )  
				                                                       then  
				                                                               0  
				                                                           else  
				                                                               1  
				                                                           end  
				                                                   when tdp1.keluar::time between tsp.ist_selesai::time and( tsp.jam_plg::time - interval '1 second' )  
				                                                   then  
				                                                       case  
				                                                           when tdp1.masuk::time >=( tsp.ist_selesai::time - interval '1 second' )  
				                                                           then  
				                                                           0  
				                                                           else  
				                                                               1  
				                                                           end  
				                                                   end  
				                                           end  
				                                   )  
				                               from \"Presensi\".tdatapresensi tdp1  
				                               where tdp1.noind = tsp.noind  
				                               and tdp1.tanggal = tsp.tanggal  
				                           ) 
				                       , 0  
				                       ) 
				                       ) 
				                   )::decimal 
				                   , 2  
				                   ) as um 
		                 from 
		                   \"Presensi\".tshiftpekerja tsp 
		                 where 
		                   tsp.noind = '$noind' 
		                   and tsp.tanggal between '$awal' and '$akhir' ";
                   $result1 = $this->personalia->query($sql)->row();
                   if(!empty($result1)){
                   		$nilai += $result1->um;
                   }
			}

			return $nilai;
		}else{
			return 0;
		}
	}

	public function ip_susulan($noind,$tanggal){
		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal = '$tanggal'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') 
				Union
				SELECT a.tanggal, a.noind,
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
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 60){
				$nilai = $nilai;
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function upamk_susulan($noind,$tanggal){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				AND a.noind = b.noind
				WHERE a.tanggal = '$tanggal'
				AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID' or a.kd_ket = 'PDL' or a.kd_ket = 'PDB')
				AND a.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
		// echo $result1['0']['jml']."<br>";
		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind')
				Union
				SELECT a.tanggal, a.noind,
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
		$result3 = $this->personalia->query($sql)->result_array();

		$ijin = 0;
		$simpan_tgl = "";
		$sp = false ;
		$a = 0;

		foreach ($result3 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$a = 0;
			}

			$sp = false;

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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($tik['kd_ket'] == 'PSP'){
				$nilai -= number_format(($ijin / ($tik['jam_kerja'] * 60 )), 2);
				// echo "<br>".($ijin / ($tik['jam_kerja'] * 60 ));print_r($tik);echo "<br>".$nilai;
				$sp = true;
			}else{
				$nilai -= number_format(($ijin / ($tik['jam_kerja'] * 60 )), 2);
				// echo "<br>".($ijin / ($tik['jam_kerja'] * 60 ));print_r($tik);echo "<br>".$nilai;
				$a += $ijin;
			}

			$simpan_tgl = $tik['tanggal'];
		}
		// echo $nilai."<br>";
		$sql = "select *,extract(dow from tdp.tanggal) + 1 as hari from \"Presensi\".Tlembur as tl,\"Presensi\".Tdatapresensi as tdp
				where tdp.kd_ket = 'HL'
				 and tdp.tanggal ='$tanggal'
				 and tl.tanggal  = tdp.tanggal
				 and tdp.noind = '$noind'
				 and tdp.noind = tl.noind
				 order by tdp.tanggal";

		$result4 = $this->personalia->query($sql)->result_array();
		if (!empty($result4)) {
			foreach ($result4 as $lmr) {
				$masuk = strtotime($lmr['masuk']);
				$keluar = strtotime($lmr['keluar']);
				$jam_lembur = $lmr['jml_lembur'];

				$sql = "select kd_shift from \"Presensi\".TShiftPekerja where
						date_part('month',tanggal) = date_part('month','".$lmr['tanggal']."'::date)
						and noind = '$noind' group by kd_shift ";
				$resshift = $this->personalia->query($sql)->result_array();
				if ($resshift['0']['kd_shift'] !== "3") {
					if ($lmr['hari'] == "Jumat" || $lmr['hari'] == "Sabtu") {
						if($jam_lembur < 360 ){
							$nilai += ($jam_lembur / 360);
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur < 420) {
							$nilai += $jam_lembur/420;
						}else{
							$nilai += 1;
						}
					}

				}else{
					if ($lmr['hari'] == "Minggu" || $lmr['hari'] == "Jumat") {
						if($jam_lembur < 360 ){
							$nilai += ($jam_lembur / 360);
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur < 420) {
							$nilai += $jam_lembur/420;
						}else{
							$nilai += 1;
						}
					}
				}
			}
		}
			// echo $nilai;exit();

		return $nilai;
	}

	public function ubt_susulan($noind,$tanggal){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				AND a.noind = b.noind
				WHERE a.tanggal = '$tanggal'
				AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID' or a.kd_ket = 'PDL' or a.kd_ket = 'PDB')
				AND a.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}

		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				AND a.noind = b.noind
				WHERE a.tanggal = '$tanggal'
				AND (a.kd_ket = 'PDL' or a.kd_ket = 'PDB') AND a.masuk = '0' and a.keluar = '0'
				AND a.noind = '$noind'";
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result2)){
			$nilai -= $result2['0']['jml'];
		}else{
			$nilai = $nilai;
		}
			
		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind')
				Union
				SELECT a.tanggal, a.noind,
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
		$result3 = $this->personalia->query($sql)->result_array();

		$ijin = 0;
		$simpan_tgl = "";
		$sp = false ;
		$a = 0;
		foreach ($result3 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$a = 0;

				if ($ijin > 60 && $ijin <= 180 && $sp == false) {
					$nilai -= 0.5;
				}else if($ijin > 180 && $sp == false){
					$nilai -= 1;
				}
			}

			$sp = false;

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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($tik['kd_ket'] == 'PSP'){
				$nilai = $nilai;
				$sp = true;
			}else{
				$a += $ijin;
			}

			$simpan_tgl = $tik['tanggal'];
		}

		if ($ijin > 60 && $ijin <= 180 && $sp == false) {
			$nilai -= 0.5;
		}else if($ijin > 180 && $sp == false){
			$nilai -= 1;
		}

		$sql = "select *,extract(dow from tdp.tanggal) + 1 as hari from \"Presensi\".Tlembur as tl,\"Presensi\".Tdatapresensi as tdp
				where tdp.kd_ket = 'HL'
				 and tdp.tanggal ='$tanggal'
				 and tl.tanggal  = tdp.tanggal
				 and tdp.noind = '$noind'
				 and tdp.noind = tl.noind
				 order by tdp.tanggal";

		$result4 = $this->personalia->query($sql)->result_array();
		if (!empty($result4)) {
			foreach ($result4 as $lmr) {
				$masuk = strtotime($lmr['masuk']);
				$keluar = strtotime($lmr['keluar']);
				$jam_lembur = $lmr['jml_lembur'];

				$sql = "select kd_shift from \"Presensi\".TShiftPekerja where
						date_part('month',tanggal) = date_part('month','".$lmr['tanggal']."'::date)
						and noind = '$noind' group by kd_shift ";
				$resshift = $this->personalia->query($sql)->result_array();
				if ($resshift['0']['kd_shift'] !== "3") {
					if ($lmr['hari'] == "Jumat" || $lmr['hari'] == "Sabtu") {
						if($jam_lembur <= 180 ){
							$nilai = $nilai;
						}else if($jam_lembur <= 300 && $jam_lembur > 180){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur <= 240) {
							$nilai = $nilai;
						}else if($jam_lembur <= 360 && $jam_lembur > 240){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}

				}else{
					if ($lmr['hari'] == "Minggu" || $lmr['hari'] == "Jumat") {
						if($jam_lembur <= 180 ){
							$nilai = $nilai;
						}else if($jam_lembur <= 300 && $jam_lembur > 180){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}else{
						if ($jam_lembur <= 240) {
							$nilai = $nilai;
						}else if($jam_lembur <= 360 && $jam_lembur > 240){
							$nilai += 0.5;
						}else{
							$nilai += 1;
						}
					}
				}
			}
		}


		return $nilai;
	}

	public function ik_susulan($noind,$tanggal){
		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal = '$tanggal'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind')
				Union
				SELECT a.tanggal, a.noind,
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
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= 1;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}
		// echo $result1['0']['jml']."<br>".$nilai;exit();
		return $nilai;
	}

	public function iph_susulan($noind,$tanggal){
		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal = '$tanggal'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind')
				Union
				SELECT a.tanggal, a.noind,
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
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
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

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			$ijin = round($ijin,2);
			$nilai -= $ijin;

			$simpan_tgl = $tik['tanggal'];
		}
		// echo $result1['0']['jml']."<br>".$nilai;exit();
		return $nilai;
	}
	
	public function imm_susulan($noind,$tanggal){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a
				  INNER JOIN \"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				    AND a.noind = b.noind
				WHERE a.tanggal = '$tanggal'
				  AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID')
				  AND (a.noind = '$noind')
				  AND (b.kd_shift = '3' OR b.kd_shift = '12') ";
		$result1 = $this->personalia->query($sql)->result_array();
		$hasil = 0;

		$sql = "select a.tanggal, a.noind,
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
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'TIK') AND (b.kd_shift = '3' OR b.kd_shift = '12') AND (a.noind = '$noind') 
				UNION
				SELECT a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (b.kd_shift = '3' OR b.kd_shift = '12') AND (a.noind = '$noind') 
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();

		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
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
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= 1;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}
	
	public function ims_susulan($noind,$tanggal){
		$sql = "select count(a.tanggal) as jml
				FROM \"Presensi\".TDataPresensi a
				  INNER JOIN \"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal
				    AND a.noind = b.noind
				WHERE a.tanggal = '$tanggal'
				  AND (a.kd_ket = 'PKJ' or a.kd_ket = 'PLB' or a.kd_ket = 'PID')
				  AND (a.noind = '$noind')
				  AND (b.kd_shift = '2' OR b.kd_shift = '11')";
		$result1 = $this->personalia->query($sql)->result_array();
		$hasil = 0;

		$sql = "select a.tanggal, a.noind,
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
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'TIK') AND (b.kd_shift = '2' OR b.kd_shift = '11') AND (a.noind = '$noind') 
				UNION
				SELECT a.tanggal, a.noind,
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
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (b.kd_shift = '2' OR b.kd_shift = '11') AND (a.noind = '$noind') 
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();

		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
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
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= 1;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	public function get_uang_dl($noind,$tanggal_awal,$tanggal_akhir){ 
		$tgl_awal = strtoupper(date('d-M-Y', strtotime($tanggal_awal))); 
		$tgl_akhir = strtoupper(date('d-M-Y', strtotime($tanggal_akhir)));  

		$sql = "SELECT no_induk, num, nama, supplier, name, city, sum(total_um_mggu) UM_MGGU, sum(total_umdl) UMDL, status, org_id
			  FROM (SELECT
			--AIA.INVOICE_ID
			                 case
			                    when aps.vendor_name <> 'KHS Employee' then assa.vendor_site_code || ' ' || substr(aps.vendor_name, 5) 
			                    else assa.vendor_site_code || ' ' || assa.address_line1
			                 END no_induk,
			                 case
			                    when aps.vendor_name <> 'KHS Employee' then substr(aps.vendor_name, 5) 
			                    else assa.address_line1
			                 END num,
			                 aps.vendor_name supplier,
			--                 aps.VENDOR_ID,
			--      (select string_agg( hl.city)
			--        from ap_suppliers aps, hz_party_sites hps, hz_locations hl
			--        where  hl.location_id(+) = hps.LOCATION_ID
			--        and hps.party_id = aps.party_id 
			--        and rownum = 1) cabang,
			                 hou.name name,
			                 hl.city,
			                 assa.vendor_site_code nama,
			                 0 total_um_mggu, SUM (aila.amount * nvl(aia.exchange_rate,1)) total_umdl,
			                 DECODE (SUBSTR (UPPER(assa.vendor_site_code), 0, 1),
			                          'B', 'STAFF',
			                         'D', 'STAFF',
			                         'G', 'STAFF',
			                         'J', 'STAFF',
			--                         'L', 'STAFF',
			--                         'Z', 'STAFF',
			                         'Q', 'STAFF',
			                         'N', 'STAFF',
			                         'T', 'STAFF',
			                         'C','CABANG',
			                         'P','OS',
			                         'K','OS',
			                         'F','PKL',
			                         'A','NON STAFF',
			                         'H','NON STAFF',
			                         'F','NON STAFF',
			                         'E','NON STAFF',
			                         'R','NON STAFF',
			                         'LAIN'
			--                         'NON STAFF'
			                        ) status,
			                 aila.org_id
			            FROM ap_invoice_lines_all aila,
			                 ap_invoices_all aia,
			                 ap_supplier_sites_all assa,
			                 gl_code_combinations gcc,
			                 ap_suppliers aps
			                 ,hr_all_organization_units hou
			                 ,hz_party_sites hps
			                 ,hz_locations hl
			           WHERE aila.invoice_id = aia.invoice_id(+)
			             and hl.location_id(+) = hps.LOCATION_ID
			             and hps.party_id = aps.party_id
			             and hps.PARTY_SITE_ID = assa.PARTY_SITE_ID
			             AND assa.vendor_id = aps.vendor_id
			             AND assa.vendor_site_id = aia.vendor_site_id
			             AND aila.default_dist_ccid = gcc.code_combination_id
			             AND gcc.segment3 IN (521107, 512107, 514107)
			             AND SUBSTR (assa.vendor_site_code, 0, 1) NOT IN ('N', 'K')
			             AND aila.amount != 0
			             AND (assa.vendor_id = 2 or aps.vendor_name like 'KHS_%')
			             AND DECODE (SUBSTR (UPPER(assa.vendor_site_code), 0, 1),
			                          'B', 'STAFF',
			                         'D', 'STAFF',
			                         'G', 'STAFF',
			                         'J', 'STAFF',
			--                         'L', 'STAFF',
			--                         'Z', 'STAFF',
			                         'Q', 'STAFF',
			                         'N', 'STAFF',
			                         'T', 'STAFF',
			                         'C','CABANG',
			                         'P','OS',
			                         'K','OS',
			                         'F','PKL',
			                         'A','NON STAFF',
			                         'H','NON STAFF',
			                         'F','NON STAFF',
			                         'E','NON STAFF',
			                         'R','NON STAFF',
			                         'LAIN'
			--                         'NON STAFF'
			                        ) in ('STAFF','NON STAFF','OS','CABANG') 
			             AND aia.gl_date >= '$tgl_awal' 
						 AND aia.gl_date <= '$tgl_akhir' 
			             AND aila.org_id = 82
			             AND assa.vendor_site_code = '$noind' 
			             AND aila.org_id = hou.organization_id
			        GROUP BY assa.vendor_site_code, assa.address_line1, aila.org_id,assa.address_line1,
			                 assa.vendor_site_code, aps.vendor_name,hou.name
			                 ,hl.city
			--                 ,aps.VENDOR_ID
			--order by no_induk
			        UNION ALL
			        SELECT
			--AIA.INVOICE_ID
			--                 assa.vendor_site_code || ' ' || assa.address_line1 no_induk,
			                 case
			                    when aps.vendor_name <> 'KHS Employee' then assa.vendor_site_code || ' ' || substr(aps.vendor_name, 5) 
			                    else assa.vendor_site_code || ' ' || assa.address_line1
			                 END no_induk,
			                 case
			                    when aps.vendor_name <> 'KHS Employee' then substr(aps.vendor_name, 5) 
			                    else assa.address_line1
			                 END num,                 
			--                 assa.address_line1 num,
			                 aps.vendor_name supplier,
			--                 aps.VENDOR_ID,
			--      (select string_agg( hl.city)
			--        from ap_suppliers aps, hz_party_sites hps, hz_locations hl
			--        where  hl.location_id(+) = hps.LOCATION_ID
			--        and hps.party_id = aps.party_id 
			----        and rownum = 1
			--        ) cabang,
			                 hou.name name,
			                 hl.city CITY,
			                 assa.vendor_site_code nama,
			                 SUM (aila.amount) total_um_mggu, 0 total_umdl,
			                 DECODE (SUBSTR (UPPER(assa.vendor_site_code), 0, 1),
			                          'B', 'STAFF',
			                         'D', 'STAFF',
			                         'G', 'STAFF',
			                         'J', 'STAFF',
			--                         'L', 'STAFF',
			--                         'Z', 'STAFF',
			                         'Q', 'STAFF',
			                         'N', 'STAFF',
			                         'T', 'STAFF',
			                         'C','CABANG',
			                         'P','OS',
			                         'K','OS',
			                         'F','PKL',
			                         'A','NON STAFF',
			                         'H','NON STAFF',
			                         'F','NON STAFF',
			                         'E','NON STAFF',
			                         'R','NON STAFF',
			                         'LAIN'
			--                         'NON STAFF'
			                        ) status,
			                 aila.org_id
			            FROM ap_invoice_lines_all aila,
			                 ap_invoices_all aia,
			                 ap_supplier_sites_all assa,
			                 gl_code_combinations gcc,
			                 ap_suppliers aps
			                 ,hr_all_organization_units hou
			                 ,hz_party_sites hps
			                 ,hz_locations hl
			           WHERE aila.invoice_id = aia.invoice_id(+)
			             and hl.location_id(+) = hps.LOCATION_ID
			             and hps.party_id = aps.party_id(+)
			             and hps.PARTY_SITE_ID = assa.PARTY_SITE_ID
			             AND assa.vendor_id = aps.vendor_id
			             AND assa.vendor_site_id = aia.vendor_site_id
			             AND aila.default_dist_ccid = gcc.code_combination_id
			             AND gcc.segment3 IN (521103)
			             AND SUBSTR (assa.vendor_site_code, 0, 1) NOT IN ('N', 'K')
			             AND aila.amount != 0
			             AND (assa.vendor_id = 2 or aps.vendor_name like 'KHS_%')
			             AND DECODE (SUBSTR (UPPER(assa.vendor_site_code), 0, 1),
			                          'B', 'STAFF',
			                         'D', 'STAFF',
			                         'G', 'STAFF',
			                         'J', 'STAFF',
			--                         'L', 'STAFF',
			--                         'Z', 'STAFF',
			                         'Q', 'STAFF',
			                         'N', 'STAFF',
			                         'T', 'STAFF',
			                         'C','CABANG',
			                         'P','OS',
			                         'K','OS',
			                         'F','PKL',
			                         'A','NON STAFF',
			                         'H','NON STAFF',
			                         'F','NON STAFF',
			                         'E','NON STAFF',
			                         'R','NON STAFF',
			                         'LAIN'
			--                         'NON STAFF'
			                        ) in ('STAFF','NON STAFF','OS','CABANG') 
			             AND aia.gl_date >= '$tgl_awal' 
						 AND aia.gl_date <= '$tgl_akhir' 
			             AND aila.org_id = 82 
			             AND assa.vendor_site_code = '$noind' 
			             AND aila.org_id = hou.organization_id          
			             -- KARENA ADA GAJI STAFF YANG MUNCUL
			             -- SEHARUSNYA GAJI TIDAK IKUT MUNCUL
			             AND aps.vendor_name not like '%GAJI%'
			        GROUP BY assa.vendor_site_code, assa.address_line1, aila.org_id,assa.address_line1,
			                 assa.vendor_site_code, aps.vendor_name
			                 ,hou.name
			                 ,hl.city
			--                 ,aps.VENDOR_ID
			        UNION ALL 
			        SELECT           case
			                 when aps.vendor_name <> 'KHS Employee' then aila.attribute7 || ' ' || substr(aila.attribute8,5)
			                 else null
			                 END no_induk,
			                 case
			                    when aps.vendor_name <> 'KHS Employee' then SUBSTR(aila.attribute8,5)
			                    else null
			                 END num,
			                 aila.attribute8 supplier,
			                 hou.name name,
			                 hl.city,
			                 aila.attribute7 nama, 
			                 SUM (aila.amount * nvl(aia.exchange_rate,1)) total_um_mggu ,0 total_umdl,
			                 DECODE (SUBSTR (UPPER(aila.attribute7), 0, 1),
			                         'B', 'STAFF',
			                         'D', 'STAFF',
			                         'G', 'STAFF',
			                         'J', 'STAFF',
			                         'Q', 'STAFF',
			                         'N', 'STAFF',
			                         'T', 'STAFF',
			                         'C', 'CABANG',
			                         'P', 'OS',
			                         'K', 'OS',
			                         'F', 'PKL',
			                         'A', 'NON STAFF',
			                         'H', 'NON STAFF',
			                         'F', 'NON STAFF',
			                         'E', 'NON STAFF',
			                         'R', 'NON STAFF',
			                         'LAIN'
			                        ) status,
			                  aila.org_id
			            from ap_invoice_lines_all aila
			                 , ap_invoices_all aia
			                 , ap_supplier_sites_all assa
			                 , ap_suppliers aps
			                 , hr_all_organization_units hou
			                 , hz_party_sites hps
			                 , hz_locations hl
			                 , gl_code_combinations gcc
			                 where aila.INVOICE_ID = aia.invoice_id(+) 
			--                 and aila.attribute6 = 'B0730'
			                 and aila.attribute8 like 'KHS%'
			                 and aps.vendor_name <> 'KHS Employee'
			                 and aila.attribute7 = assa.VENDOR_SITE_CODE
			                 and assa.vendor_id(+) = aps.vendor_id
			                 AND aila.org_id = hou.organization_id
			                 and assa.PARTY_SITE_ID = hps.PARTY_SITE_ID
			                 and hps.location_id = hl.location_id(+)
			                 AND aila.default_dist_ccid = gcc.code_combination_id
			                 AND DECODE (SUBSTR (UPPER(aila.attribute7), 0, 1),
			                         'B', 'STAFF',
			                         'D', 'STAFF',
			                         'G', 'STAFF',
			                         'J', 'STAFF',
			                         'Q', 'STAFF',
			                         'N', 'STAFF',
			                         'T', 'STAFF',
			                         'C', 'CABANG',
			                         'P', 'OS',
			                         'K', 'OS',
			                         'F', 'PKL',
			                         'A', 'NON STAFF',
			                         'H', 'NON STAFF',
			                         'F', 'NON STAFF',
			                         'E', 'NON STAFF',
			                         'R', 'NON STAFF',
			                         'LAIN'
			                        ) in ('STAFF','NON STAFF','OS','CABANG') 
			             AND aia.gl_date >= '$tgl_awal' 
						 AND aia.gl_date <= '$tgl_akhir' 
			             AND aila.org_id = 82
			             AND assa.vendor_site_code = '$noind' 
			             GROUP BY assa.vendor_site_code, assa.address_line1, aila.org_id,assa.address_line1,
			                 assa.vendor_site_code, aps.vendor_name,hou.name,
			                 hl.city, aila.attribute7, aila.attribute8, aia.gl_date, assa.VENDOR_ID, assa.vendor_site_id
			                 )
			GROUP BY no_induk, status, org_id,num,nama,supplier,name,city
			ORDER BY no_induk";
		$result = $this->oracle->query($sql)->row(); 
 
		if (!empty($result) and !empty($result->UMDL)) { 
			return $result->UMDL; 
		}else{ 
			return 0; 
		} 
 
	} 

	public function jumlah_duka($noind,$tgl_awal,$tgl_akhir){
		$sql = "select hpd.noind,count(*) as jumlah
				from hr.hr_lelayu hl 
				inner join hr.hr_pekerja_dipotong hpd 
				on hl.lelayu_id = hpd.lelayu_id
				where hl.tgl_lelayu >= '$tgl_awal'
				and hpd.noind = '$noind'
				group by hpd.noind";
				// echo $sql;exit();
		$result = $this->db->query($sql)->row();
		if(!empty($result)){
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function nominal_duka($noind,$tgl_awal,$tgl_akhir){		
		$sql = "select hpd.noind,sum(hpd.nominal) as total
				from hr.hr_lelayu hl 
				inner join hr.hr_pekerja_dipotong hpd 
				on hl.lelayu_id = hpd.lelayu_id
				where hl.tgl_lelayu >= '$tgl_awal'
				and hpd.noind = '$noind'
				group by hpd.noind";
		$result = $this->db->query($sql)->row();
		if(!empty($result)){
			return $result->total;
		}else{
			return 0;
		}
	}

	public function get_komponen_pekerja_khusus($noind){
		$sql = "select *
				from \"Presensi\".t_komponen_gaji_reffgaji
				where noind = '$noind'";
		$result = $this->personalia->query($sql)->row();
		return $result;
	}

	public function getListPekerjaKeluar(){
		$sql = "select *
				from \"Presensi\".treffgaji_keluar
				order by tanggal_keluar desc";
		$result = $this->personalia->query($sql)->result_array();
		return $result;
	}

	public function getListPekerjaKeluarByNoind($noind){
		$sql = "select *
				from \"Presensi\".treffgaji_keluar
				where noind = '$noind'
				order by tanggal_keluar desc";
		$result = $this->personalia->query($sql)->row();
		return $result;
	}

	public function updateGajipekerjaKeluarByNoind($data,$noind){
		$this->personalia->where('noind',$noind);
		$this->personalia->update('"Presensi".treffgaji_keluar',$data);
	}

	public function getPekerjaKeluarByPeriodeKodeInduk($awal,$akhir,$kode){
		$sql = "select a.*,b.seksi
				from \"Presensi\".treffgaji_keluar a
				left join hrd_khs.tseksi b 
				on a.kodesie = b.kodesie
				where left(a.noind,1) in ($kode)
				and a.tanggal_keluar between '$awal' and '$akhir'
				order by a.noind";
		return $this->personalia->query($sql)->result_array();
	}
}
?>
