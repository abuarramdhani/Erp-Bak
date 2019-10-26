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


}

 ?>
