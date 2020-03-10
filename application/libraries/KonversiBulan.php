<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KonversiBulan
{

  function __construct()
  {
    $this->CI = &get_instance();
    date_default_timezone_set('Asia/Jakarta');
  }

  public function KonversiBulanKeAngka($tanggal)
  {
		$tanggal 	=	str_replace
					(
						array
						(
              'Januari',
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
							'Oktober',
							'November',
							'Desember'
						),
						array
						(
							'01',
							'02',
							'03',
							'04',
							'05',
							'06',
							'07',
							'08',
							'09',
							'10',
							'11',
							'12'
						),
						$tanggal);
		return $tanggal;
  }

  public function KonversiAngkaKeBulan($tanggal)
  {
		$tanggal 	=	str_replace
					(
						array
						(
              '01',
							'02',
							'03',
							'04',
							'05',
							'06',
							'07',
							'08',
							'09',
							'10',
							'11',
							'12'
						),
						array
						(
              'Januari',
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
							'Oktober',
							'November',
							'Desember'
						),
						$tanggal);
		return $tanggal;
  }

  public function KonversiBulanInggrisKeAngka($tanggal)
  {
		$tanggal 	=	str_replace
					(
						array
						(
              'January',
							'February',
							'March',
							'April',
							'May',
							'June',
							'July',
							'August',
							'September',
							'October',
							'November',
							'December'
						),
						array
						(
              '01',
							'02',
							'03',
							'04',
							'05',
							'06',
							'07',
							'08',
							'09',
							'10',
							'11',
							'12'
						),
						$tanggal);
		return $tanggal;
  }

  public function KonversiKeBulanIndonesia($tanggal)
  {
		$tanggal 	=	str_replace
					(
						array
						(
              'January',
							'February',
							'March',
							'April',
							'May',
							'June',
							'July',
							'August',
							'September',
							'October',
							'November',
							'December'
						),
						array
						(
              'Januari',
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
							'Oktober',
							'November',
							'Desember'
						),
						$tanggal);
		return $tanggal;
  }

  public function KonversiKeBulanInggris($tanggal)
  {
		$tanggal 	=	str_replace
					(
						array
						(
              'Januari',
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
							'Oktober',
							'November',
							'Desember'
						),
						array
						(
              'January',
							'February',
							'March',
							'April',
							'May',
							'June',
							'July',
							'August',
							'September',
							'October',
							'November',
							'December'
						),
						$tanggal);
		return $tanggal;
  }

  public function getBulanDepan($tanggal)
  {
		$tanggal 	=	str_replace
					(
						array
						(
              'Januari',
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
							'Oktober',
							'November',
							'Desember'
						),
						array
						(
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
							'Oktober',
							'November',
							'Desember',
              'Januari'
						),
						$tanggal);
		return $tanggal;
  }

  public function dataBulanDepanDariInggris($bulan)
  {
		$bulan 	=	str_replace
					(
						array
						(
              '',
              'January',
							'February',
							'March',
							'April',
							'May',
							'June',
							'July',
							'August',
							'September',
							'October',
							'November',
							'December'
						),
						array
						(
              '',
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
              'Oktober',
              'November',
              'Desember',
              'Januari'
						),
						$bulan);
		return $bulan;
  }

  public function convert_Hari_Indonesia($nama_hari, $upper = false)
  {
	/**
	* Fungsi ini digunakan untuk konvert hari en ke in
	* @param $nama_hari String
	* @param $upper Int 0/1 default 0/false
	* @version 1.0
	*/
  	$nama_hari = strtoupper($nama_hari);
  	$hari_en = array(
  			'MONDAY',
  			'TUESDAY',
  			'WEDNESDAY',
  			'THURSDAY',
  			'FRIDAY',
  			'SATURDAY',
  			'SUNDAY',
  		);
  	$hari_in = array(
  			'SENIN',
  			'SELASA',
  			'RABU',
  			'KAMIS',
  			'JUMAT',
  			'SABTU',
  			'MINGGU',
  		);
  	$hari = str_replace($hari_en, $hari_in, $nama_hari);
  	if ($upper == false) {
  		return strtolower($hari);
  	}else{
  		return $hari;
  	}
  }

  public function convertke_Hari_Indonesia($nama_hari)
  {
	/**
	* Fungsi ini digunakan untuk konvert hari en ke in
	* @param $nama_hari String
	* @param $upper Int 0/1 default 0/false
	* @version 1.0
	*/
  	$nama_hari = str_replace( array(
  			'Mon',
  			'Tue',
  			'Wed',
  			'Thu',
  			'Fri',
  			'Sat',
  			'Sun',
  		),
  	     array(
  			'Senin',
  			'Selasa',
  			'Rabu',
  			'Kamis',
  			'Jumat',
  			'Sabtu',
  			'Minggu',
  		), $nama_hari);
  	return $nama_hari;
  }
}
