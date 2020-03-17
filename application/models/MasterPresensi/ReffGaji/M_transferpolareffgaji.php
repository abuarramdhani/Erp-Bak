<?php 
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 * 
 */
class M_transferpolareffgaji extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getPola($awal,$akhir){
		$sql = "select * from (
				SELECT LEFT(a.noind, 1), a.tanggal::date as tanggal, a.noind, b.kodesie, trim(kd_ket) as kd_ket, nama, trim(inisial) as inisial 
				 FROM \"Presensi\".tdatatim a 
				   INNER JOIN hrd_khs.TPribadi b ON b.noind=a.noind 
				   INNER JOIN \"Presensi\".tshiftpekerja c ON a.noind = c.noind 
				     AND a.tanggal = c.tanggal 
				   INNER JOIN \"Presensi\".tshift d ON c.kd_shift = d.kd_shift 
				WHERE a.tanggal >= '$awal' 
				  and a.tanggal <= '$akhir' 
				  AND (a.noind like 'A%' or a.noind like 'H%' or a.noind like 'E%' 
				       or a.noind like 'K%' or a.noind like 'P%') 
				UNION 
				SELECT LEFT(a.noind, 1),a.tanggal::date as tanggal, a.noind, b.kodesie, trim(kd_ket) as kd_ket, nama, trim(inisial) as inisial  
				 FROM \"Presensi\".tdatapresensi a 
				   INNER JOIN hrd_khs.TPribadi b ON b.noind=a.noind 
				   INNER JOIN \"Presensi\".tshiftpekerja c ON a.noind = c.noind 
				     AND a.tanggal = c.tanggal 
				   INNER JOIN \"Presensi\".tshift d ON c.kd_shift = d.kd_shift 
				WHERE a.tanggal >= '$awal' 
				  and a.tanggal <= '$akhir' 
				  AND (a.noind like 'A%' or a.noind like 'H%' 
				       or a.noind like 'E%' 
				       or a.noind like 'K%' or a.noind like 'P%' )) tbl 
				ORDER BY LEFT(noind, 1), kodesie, noind, tanggal, kd_ket ";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCountNumber($awal,$akhir){
		$sql = "select count(distinct noind) as jumlah from (
				SELECT LEFT(a.noind, 1), a.tanggal::date as tanggal, a.noind, b.kodesie, trim(kd_ket) as kd_ket, nama, trim(inisial) as inisial 
				 FROM \"Presensi\".tdatatim a 
				   INNER JOIN hrd_khs.TPribadi b ON b.noind=a.noind 
				   INNER JOIN \"Presensi\".tshiftpekerja c ON a.noind = c.noind 
				     AND a.tanggal = c.tanggal 
				   INNER JOIN \"Presensi\".tshift d ON c.kd_shift = d.kd_shift 
				WHERE a.tanggal >= '$awal' 
				  and a.tanggal <= '$akhir' 
				  AND (a.noind like 'A%' or a.noind like 'H%' or a.noind like 'E%' 
				       or a.noind like 'K%' or a.noind like 'P%') 
				UNION 
				SELECT LEFT(a.noind, 1),a.tanggal::date as tanggal, a.noind, b.kodesie, trim(kd_ket) as kd_ket, nama, trim(inisial) as inisial  
				 FROM \"Presensi\".tdatapresensi a 
				   INNER JOIN hrd_khs.TPribadi b ON b.noind=a.noind 
				   INNER JOIN \"Presensi\".tshiftpekerja c ON a.noind = c.noind 
				     AND a.tanggal = c.tanggal 
				   INNER JOIN \"Presensi\".tshift d ON c.kd_shift = d.kd_shift 
				WHERE a.tanggal >= '$awal' 
				  and a.tanggal <= '$akhir' 
				  AND (a.noind like 'A%' or a.noind like 'H%' 
				       or a.noind like 'E%' 
				       or a.noind like 'K%' or a.noind like 'P%' )) tbl ";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return '0';
		}
	}

	public function getLokasi($noind){
		$sql = "select tlokasi.lokasi_kerja 
				from hrd_khs.tpribadi tpribadi 
				inner join hrd_khs.tlokasi_kerja tlokasi
                on tpribadi.lokasi_kerja = tlokasi.id_ 
                where noind = '$noind'";
        $result = $this->personalia->query($sql)->row();
        if (!empty($result)) {
        	return $result->lokasi_kerja;
        }else{
        	return "-";
        }
	}

	public function cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai){
		$jam_ijin = 0;
		// echo $jam_ijin;
		// echo $keluar;exit();
		if ($keluar >= $ist_mulai && $masuk >= $ist_mulai) {
			if ($ist_selesai <= $keluar && $ist_selesai <= $masuk) {
				$lama_ijin = $masuk - $keluar;
				// $lama_ist = $ist_selesai - $ist_mulai;
				// $jam_ijin = $lama_ijin - $lama_ist;
				$jam_ijin = $lama_ijin;
				// 	echo "hai";
				// echo $jam_ijin;
				// exit();
			}else if($keluar >= $ist_selesai && $masuk >= $ist_selesai){
				$jam_ijin = $masuk - $keluar;
			}else if($masuk >= $ist_selesai){
				$jam_ijin = $masuk - $ist_selesai;
			}
		}else if($keluar <= $ist_mulai && $masuk >= $ist_mulai){
			if ($ist_selesai >= $keluar && $ist_selesai >= $masuk) {
				if ($keluar <= $break_mulai && $keluar <= $break_selesai) {
					$setelah_break = $masuk - $break_selesai;
					$sebelum_break = $break_mulai - $keluar;
					$jam_ijin = $setelah_break + $sebelum_break;
				}else if($keluar > $break_mulai && $masuk > $ist_mulai){
					$jam_ijin = $ist_mulai - $break_selesai;
				}else{
					$jam_ijin = $ist_mulai - $keluar;
					if ($jam_ijin <= 30) {
						$jam_ijin = 0;
					}
				}
			}else if($keluar <= $ist_selesai && $masuk > $ist_selesai){
				if ($keluar <= $break_mulai) {
					$sebelum_break = $break_mulai - $keluar;
					$setelah_break = $ist_mulai - $break_selesai;
					$setelah_ist = $masuk - $ist_selesai;
					if ($sebelum_break < 0) {
						$sebelum_break = 0;
					}
					if ($setelah_break < 0) {
						$setelah_break = 0;
					}
					if ($setelah_ist < 0) {
						$setelah_ist = 0;
					}
					$jam_ijin = $sebelum_break + $setelah_break + $setelah_ist;
				}else if( $keluar >= $break_selesai){
					$sebelum_ist = $ist_mulai - $keluar;
					$setelah_ist = $masuk - $ist_selesai;
					$jam_ijin = $sebelum_ist + $setelah_ist;
				}else if($keluar >= $break_mulai && $keluar <= $break_selesai){
					$sebelum_ist = $ist_mulai - $break_selesai;
					$setelah_ist = $masuk - $ist_selesai;
					$jam_ijin = $sebelum_ist + $setelah_ist;
				}
			}
		}else{
			if ($keluar >= $break_mulai && $masuk >= $break_mulai) {
				if ($break_selesai >= $keluar && $break_selesai >= $masuk) {
					$jam_ijin = 0;
				}else if($keluar >= $break_selesai && $masuk >= $break_selesai){
					$jam_ijin = $masuk - $keluar;
				}else{
					$jam_ijin = $masuk - $break_selesai;
				}
			}else if($keluar <= $break_mulai && $masuk >= $break_mulai){
				if ($break_selesai >= $keluar && $break_selesai >= $masuk) {
					$jam_ijin = $break_mulai - $keluar;
				}else{
					$sebelum_break = $break_mulai - $keluar;
					$setelah_break = $masuk - $break_selesai;
					$jam_ijin = $setelah_break + $sebelum_break;
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

	public function hitung_tik($noind,$tanggal){
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
				WHERE a.tanggal = '$tanggal' AND a.kd_ket = 'TIK' AND a.noind = '$noind' 
				ORDER BY tanggal";

		$result2 = 	$this->personalia->query($sql)->result_array();

		$nilai = 0;
		$simpan_tgl = "";
		foreach ($result2 as $tik) {
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

		return $nilai;
	}

	public function insertProgres($user,$jumlah){
		$sql = "delete from \"Presensi\".progress_transfer_reffgaji where user_ = '$user' and menu = 'transferpolareffgaji'";
		$this->personalia->query($sql);

		$sql ="insert into \"Presensi\".progress_transfer_reffgaji(user_,progress,total,menu)
				select '$user',0,$jumlah,'transferpolareffgaji'";
		$this->personalia->query($sql);
	}

	public function updateProgres($user,$progres){
		$sql = "update \"Presensi\".progress_transfer_reffgaji set progress = $progres where user_ = '$user' and menu = 'transferpolareffgaji' ";
		$this->personalia->query($sql);
	}

	public function getProgres($user){
		$sql = "select * from \"Presensi\".progress_transfer_reffgaji where user_ = '$user' and menu = 'transferpolareffgaji'";
		return $this->personalia->query($sql)->row();
	}

	public function deleteProgres($user){
		$sql = "delete from \"Presensi\".progress_transfer_reffgaji where user_ = '$user' and menu = 'transferpolareffgaji'";
		$this->personalia->query($sql);
	}

	public function hitungIk($noind,$tanggal){
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
	
} ?>