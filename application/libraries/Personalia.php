<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
class personalia
{

	function __construct()
	{
		$this->CI = &get_instance();
		date_default_timezone_set('Asia/Jakarta');
		
		// Model Aplikasi Personalia -----start-----
			$this->CI->load->model('DocumentStandarization/MainMenu/M_general');
			$this->CI->load->model('MasterPekerja/Surat/Promosi/M_Promosi');

		// Model Aplikasi Personalia -------end-----

	}

	public function tembusan($kd_jabatan, $kodesie, $lokasi_kerja)
	{
		$kd_jabatan 	=	$kd_jabatan;
		$kodesie 		=	$kodesie;
		$lokasi_kerja 	=	$lokasi_kerja;

		$jumlahTembus 	=	0;
		$tembusan 		=	array();
		for ($tingkat=1; $tingkat < strlen($kodesie); $tingkat++) 
		{
			$kodeTingkatan 	=	substr($kodesie, 0, $tingkat);
			// echo $kodeTingkatan.'<br/>';
			for ($panjangKarakter=strlen($kodeTingkatan); $panjangKarakter < 9; $panjangKarakter++) 
			{ 
				$kodeTingkatan 	.= 	'0';
			}

			// echo $kodeTingkatan.'<br/>';

			for ($kd_jabatan_i = 1; $kd_jabatan_i < 14; $kd_jabatan_i++)
			{
				$ambilTembusan 		=	$this->CI->M_Promosi->ambilTembusan($kodeTingkatan, $kd_jabatan_i, $kd_jabatan, $lokasi_kerja);
				foreach ($ambilTembusan as $nembus) 
				{
					$tembusan[$tingkat-1]	=	$nembus['jabatan'].' '.$nembus['lingkup'].' '.$nembus['lokasi'];
					$jumlahTembus++;
				}
			}
			
				
			$tingkat++;
		}

		return $tembusan;
	}

	public function tembusanDuaPihak($kd_jabatan_1, $kodesie_1, $lokasi_kerja_1, $kd_jabatan_2, $kodesie_2, $lokasi_kerja_2)
	{
		$kd_jabatan_1 	=	$kd_jabatan_1;
		$kodesie_1 		=	$kodesie_1;
		$lokasi_kerja_1	=	$lokasi_kerja_1;

		$kd_jabatan_2 	=	$kd_jabatan_2;
		$kodesie_2 		=	$kodesie_2;
		$lokasi_kerja_2	=	$lokasi_kerja_2;
		// echo $kd_jabatan_1.'/'.$kodesie_1.'/'.$lokasi_kerja_1.'+++';
		// echo $kd_jabatan_2.'/'.$kodesie_2.'/'.$lokasi_kerja_2.'+++<br/>';


		$jumlahTembus 	=	0;
		$jumlahTembus2 	=	0;
		$indeks_1		=	0;
		$indeks_2		=	0;
		$tembusan 		=	array();
		$ambilTembusan1	=	array();
		$ambilTembusan2	=	array();

		

		for ($tingkat=1; $tingkat < strlen($kodesie_1); $tingkat++) 
		{
			$kodeTingkatan_1 	=	substr($kodesie_1, 0, $tingkat);
			$kodeTingkatan_2 	=	substr($kodesie_2, 0, $tingkat);

			// echo '1='.$kodeTingkatan_1.'<br/>';
			for ($panjangKarakter=strlen($kodeTingkatan_1); $panjangKarakter < 9; $panjangKarakter++) 
			{ 
				$kodeTingkatan_1 	.= 	'0';
				$kodeTingkatan_2 	.= 	'0';
			}



			$kd_jabatan_i_2 = 1;
			for ($kd_jabatan_i_1 = 1; $kd_jabatan_i_1 < 14; $kd_jabatan_i_1++)
			{
				$ambilTembusan1 		=	$this->CI->M_Promosi->ambilTembusan($kodeTingkatan_1, $kd_jabatan_i_1, $kd_jabatan_1, $lokasi_kerja_1);
				$ambilTembusan2 		=	$this->CI->M_Promosi->ambilTembusan($kodeTingkatan_2, $kd_jabatan_i_2, $kd_jabatan_2, $lokasi_kerja_2);
				// echo "<pre>";
				// print_r($ambilTembusan1);
				// echo '1='.$kodeTingkatan_1.'<|='.$kd_jabatan_1.'<br>';
				// echo '2='.$kodeTingkatan_2.'<|='.$kd_jabatan_2;
				for ($i = 0; $i < 14; $i++) 
				{ 
					if(isset($ambilTembusan1[$i]))
					{
						$tembusan[$jumlahTembus]	=	$ambilTembusan1[$i]['jabatan'].' '.$ambilTembusan1[$i]['lingkup'].' '.$ambilTembusan1[$i]['lokasi'];
						// echo $tembusan[$jumlahTembus];

						// echo "<br/>";
						$jumlahTembus++;
					}

					if(isset($ambilTembusan2[$i]))
					{
						$tembusan[$jumlahTembus]	=	$ambilTembusan2[$i]['jabatan'].' '.$ambilTembusan2[$i]['lingkup'].' '.$ambilTembusan2[$i]['lokasi'];
						// echo 't='.$tembusan[$jumlahTembus];
						$jumlahTembus++;
					}
				}

				$kd_jabatan_i_2++;
			}
			$tingkat++;
		}
		// echo "<pre>";
		// print_r($tembusan);
		$tembusan = array_unique($tembusan);
		$key = array_search('KEPALA SEKSI MADYA GENERAL AFFAIR ', $tembusan);
		// echo 'key = '.$key;
		if ($key) {
    		unset($tembusan[$key]);
    		// echo "betulanjy";
			}else{
				// echo "salahwoi";
			}
		return $tembusan;
	}

	public function konversitanggalIndonesia($tanggal)
	{
		$kirim 	=	date('d F Y', strtotime($tanggal));

		$kirim 	=	str_replace
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
						$kirim);
		return $kirim;
	}
}