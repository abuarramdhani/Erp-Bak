<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_JurnalPenilaianEvaluator extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('encryption');
		$this->load->library('General');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('JurnalPenilaian/M_assessment');
		$this->load->model('JurnalPenilaian/M_kenaikan');
		  
		if($this->session->userdata('logged_in')!=TRUE) 
		{
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index($periode){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Jurnal Penilaian';
		$data['SubMenuOne'] = 'Jurnal Penilaian';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $idUnitGroup	=	$this->M_assessment->ambilDataUnitGroupBerdasarKodesie();

		// $data['evaluasiSeksi']		=	$this->M_assessment->ambilDataEvaluasiSeksi($idUnitGroup);
		// $data['daftarAspek']		=	$this->M_assessment->ambilAspekPenilaian();

		// echo '<pre>';
		// print_r($data['evaluasiSeksi']);
		// echo '</pre>';
		// exit();

		$data['periode']				=	$periode;

		// $data['daftarUnitGroup']		=	$this->M_assessment->ambilDaftarUnitGroup();
		$data['daftarGolonganKerja'] 	=	$this->M_kenaikan->ambilGolonganKerja();
		$data['evaluasiSeksi']			=	$this->M_assessment->ambilDataEvaluasiSeksi($periode);
		$data['daftarAspek']			=	$this->M_assessment->ambilAspekPenilaian();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/PenilaianEvaluator/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update()
	{
		$daftarAspek 				=	$this->M_assessment->ambilAspekPenilaian();
		$nilaiTIM					=	$this->M_assessment->ambilNilaiTIM();
		$nilaiSP 					=	$this->M_assessment->ambilNilaiSP();
		$tabelKategoriNilai			=	$this->M_assessment->ambilKategoriNilai();
		$tabelSKPengurangPrestasi	=	$this->M_assessment->ambilSKPengurangPrestasi();
		$tabelSKPengurangKemauan	=	$this->M_assessment->ambilSKPengurangKemauan();
		$tabelKenaikan 				=	$this->M_kenaikan->ambilKenaikan();
		$periode 					=	$this->input->post('txtPeriode');
		$tabelEvaluasiSeksi 		=	$this->M_assessment->ambilDataEvaluasiSeksi($periode);

		$idEvaluasiSeksi 		=	$this->input->post('txtIDEvaluasiSeksi');

		// echo '<pre>';
		// print_r($idEvaluasiSeksi);
		// echo '</pre>';
		// exit();
		
		$indeksIDEvaluasiSeksi	=	array_keys($idEvaluasiSeksi);

		$total 					= 	array();

		// $cobaNilai				=	$this->input->post('txttotalTIM');

		for ($i = 0; $i < count($daftarAspek); $i++) 
		{
			$total[strtoupper($daftarAspek[$i]['singkatan'])] 	=	$this->input->post('txttotal'.strtoupper($daftarAspek[$i]['singkatan']));
		}

		$total['hariSK']			=	$this->input->post('txttotalHariSK');
		$total['bulanSK']			=	$this->input->post('txttotalBulanSK');

		for ($k = 0; $k < count($indeksIDEvaluasiSeksi); $k++) 
		{ 
			$indeks 	=	$indeksIDEvaluasiSeksi[$k];
			$idEvaluasiSeksi[$indeks] 		=	$this->encryption->decrypt(str_replace(array('-', '_', '~'), array('+', '/', '='), $idEvaluasiSeksi[$indeks]));
			for ($m=0; $m < count($daftarAspek); $m++) 
			{ 
				$total[strtoupper($daftarAspek[$m]['singkatan'])][$indeks]	=	filter_var($total[strtoupper($daftarAspek[$m]['singkatan'])][$indeks], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			}
		}

		for ($indeks2 = 0; $indeks2 < count($indeksIDEvaluasiSeksi); $indeks2++) 
		{ 
			$j 	=	$indeksIDEvaluasiSeksi[$indeks2];
			for ($p=0; $p < count($daftarAspek); $p++) 
			{ 
				if(strtoupper($daftarAspek[$p]['singkatan'])!='SP' && strtoupper($daftarAspek[$p]['singkatan'])!='TIM' && strtoupper($daftarAspek[$p]['singkatan'])!='PK' && strtoupper($daftarAspek[$p]['singkatan'])!='KK')
				{
					$input 	=	array(
									't_'.$daftarAspek[$p]['singkatan']	=>	$total[strtoupper($daftarAspek[$p]['singkatan'])][$j],
									'n_'.$daftarAspek[$p]['singkatan']	=>	($total[strtoupper($daftarAspek[$p]['singkatan'])][$j]*$daftarAspek[$p]['bobot'])							
								);
					$this->M_assessment->updateNilaiEvaluasi($input, $idEvaluasiSeksi[$j]);	
				}
				if(strtoupper($daftarAspek[$p]['singkatan'])=='SP')
				{
					$totalSP 	= 	$total[strtoupper($daftarAspek[$p]['singkatan'])][$j];

					$konversinilaiSP 	=	0;
					for ($q = 0; $q < count($nilaiSP) ; $q++)
					{ 
						if($q==0)
						{
							if ($totalSP==$nilaiSP[$q]['sp_num']) 
							{
								$konversinilaiSP 	=	$nilaiSP[$q]['nilai'];
							}
						}
						elseif($q<=(count($nilaiSP)-2))
						{
							if ($totalSP==$nilaiSP[$q]['sp_num'])
							{
								$konversinilaiSP 	=	$nilaiSP[$q]['nilai'];
							}
						}
						elseif($q<(count($nilaiSP)))
						{
							if ($totalSP>=$nilaiSP[$q]['sp_num']) 
							{
								$konversinilaiSP 	=	$nilaiSP[$q]['nilai'];
							}
						}
					}
					$input 	=	array(
									't_'.$daftarAspek[$p]['singkatan']			=>	$total[strtoupper($daftarAspek[$p]['singkatan'])][$j],
									'n_'.$daftarAspek[$p]['singkatan']			=>	($konversinilaiSP*$daftarAspek[$p]['bobot']),
									'n_'.$daftarAspek[$p]['singkatan'].'_asli'	=>	($konversinilaiSP),
								);
					$this->M_assessment->updateNilaiEvaluasi($input, $idEvaluasiSeksi[$j]);								
				}
				if (strtoupper($daftarAspek[$p]['singkatan'])=='PK') 
				{
					$jumlahHariSK 		=	$total['hariSK'][$j];
					$nilaiTotal 	=	($total[strtoupper($daftarAspek[$p]['singkatan'])][$j]);
					$pengurang 		=	0;
					for ($s=0; $s < count($tabelSKPengurangPrestasi); $s++) 
					{
						if($nilaiTotal!=0)
						{
							if($jumlahHariSK>=$tabelSKPengurangPrestasi[$s]['batas_bawah'] && $jumlahHariSK<=$tabelSKPengurangPrestasi[$s]['batas_atas'])
							{
								$pengurang 		=	$tabelSKPengurangPrestasi[$s]['pengurang'];
								$nilaiTotal 	=	$nilaiTotal - $tabelSKPengurangPrestasi[$s]['pengurang'];
							}
						}
						else
						{
							$nilaiTotal	=	0;
						}
					}

					$input 	=	array(
									't_'.$daftarAspek[$p]['singkatan']				=>	($total[strtoupper($daftarAspek[$p]['singkatan'])][$j]),
									'n_'.$daftarAspek[$p]['singkatan']				=>	$nilaiTotal*$daftarAspek[$p]['bobot'],
									't_'.$daftarAspek[$p]['singkatan'].'_hasil' 	=>	$nilaiTotal,
									't_'.$daftarAspek[$p]['singkatan'].'_pengurang' =>	$pengurang,
									'n_'.$daftarAspek[$p]['singkatan'].'_pengurang' =>	$pengurang*$daftarAspek[$p]['bobot']
								);
					$this->M_assessment->updateNilaiEvaluasi($input, $idEvaluasiSeksi[$j]);	
				}
				if (strtoupper($daftarAspek[$p]['singkatan'])=='KK') 
				{
					$jumlahBulanSK 	=	$total['bulanSK'][$j];
					$nilaiTotal 	=	($total[strtoupper($daftarAspek[$p]['singkatan'])][$j]);
					$pengurang 		=	0;
					for ($t=0; $t < count($tabelSKPengurangKemauan); $t++) 
					{ 
						if($nilaiTotal!=0)
						{
							if($jumlahBulanSK>=$tabelSKPengurangKemauan[$t]['bulan_batas_bawah'] && $jumlahBulanSK<=$tabelSKPengurangKemauan[$t]['bulan_batas_atas'])
							{
								$pengurang 		=	$tabelSKPengurangKemauan[$t]['pengurang'];
								$nilaiTotal 	=	$nilaiTotal - $tabelSKPengurangKemauan[$t]['pengurang'];
							}
						}
						else
						{
							$nilaiTotal	=	0;
						}
					}
					$input 	=	array(
									't_'.$daftarAspek[$p]['singkatan']				=>	($total[strtoupper($daftarAspek[$p]['singkatan'])][$j]),
									'n_'.$daftarAspek[$p]['singkatan']				=>	$nilaiTotal*$daftarAspek[$p]['bobot'],
									't_'.$daftarAspek[$p]['singkatan'].'_hasil' 	=>	$nilaiTotal,
									't_'.$daftarAspek[$p]['singkatan'].'_pengurang' =>	$pengurang,
									'n_'.$daftarAspek[$p]['singkatan'].'_pengurang' =>	$pengurang*$daftarAspek[$p]['bobot']
								);
					$this->M_assessment->updateNilaiEvaluasi($input, $idEvaluasiSeksi[$j]);						
				}
				if(strtoupper($daftarAspek[$p]['singkatan'])=='TIM')
				{
					$totalTIM 	= 	$total[strtoupper($daftarAspek[$p]['singkatan'])][$j];

					$konversiNilaiTIM 	=	0;
					for ($q=0; $q < count($nilaiTIM) ; $q++)
					{ 
						if($q==0)
						{
							if($totalTIM>=$nilaiTIM[$q]['bts_bwh'] && $totalTIM<$nilaiTIM[$q]['bts_ats'])
							{
								$konversiNilaiTIM 	=	$nilaiTIM[$q]['nilai'];
							}
						}
						elseif($q<=(count($nilaiTIM)-2))
						{
							if($totalTIM>=$nilaiTIM[$q]['bts_bwh'] && $totalTIM<$nilaiTIM[$q]['bts_ats'])
							{
								$konversiNilaiTIM 	=	$nilaiTIM[$q]['nilai'];
							}
						}
						elseif($q<(count($nilaiTIM)))
						{
							if ($totalTIM>=$nilaiTIM[$q]['bts_bwh']) 
							{
								$konversiNilaiTIM 	=	$nilaiTIM[$q]['nilai'];
							}
						}
					}
					$input 	=	array(
									't_'.$daftarAspek[$p]['singkatan']			=>	$total[strtoupper($daftarAspek[$p]['singkatan'])][$j],
									'n_'.$daftarAspek[$p]['singkatan']			=>	($konversiNilaiTIM*$daftarAspek[$p]['bobot']),
									'n_'.$daftarAspek[$p]['singkatan'].'_asli'	=>	($konversiNilaiTIM)
								);
					$this->M_assessment->updateNilaiEvaluasi($input, $idEvaluasiSeksi[$j]);						
				}
			}
			$dataEvaluasi 	=	array(
										'assignee'	=>	$this->session->user
								);
			$this->M_assessment->updateNilaiEvaluasi($dataEvaluasi, $idEvaluasiSeksi[$j]);

			$dataEvaluasiIndividual 	=	$this->M_assessment->ambilDataEvaluasiSeksiIndividual($idEvaluasiSeksi[$j]);
			
			$nilaiTotal		=	0;
			$kategoriNilai 	= 	$tabelKategoriNilai[(count($tabelKategoriNilai)-1)]['kategori'];
			$golonganNilai 	=	$tabelKategoriNilai[(count($tabelKategoriNilai)-1)]['gol_nilai'];
			for ($t=0; $t < count($daftarAspek); $t++) 
			{
				/*
				if(strtoupper($daftarAspek[$t]['singkatan'])=='PK' OR strtoupper($daftarAspek[$t]['singkatan'])=='KK')
				{
					$kolomNilaiKonversi 	=	't_'.$daftarAspek[$t]['singkatan'].'_hasil';
				}
				else
				{
				*/
					$kolomNilaiKonversi 	=	'n_'.$daftarAspek[$t]['singkatan'];
				/*
				}
				*/
				$nilaiTotal	+=	$dataEvaluasiIndividual[0][$kolomNilaiKonversi];
			}

			// echo $nilaiTotal.'<br/>';
			for($x = 0; $x < count($tabelKategoriNilai); $x++)
			{
				// echo 'Kategori Nilai : '.($x+1).'<br/>';
				// echo 'Rentang Nilai : '.$tabelKategoriNilai[$x]['bts_bwh'].'-'.$tabelKategoriNilai[$x]['bts_ats'].'<br/>';
				if($nilaiTotal>=$tabelKategoriNilai[$x]['bts_bwh'] && $nilaiTotal<=$tabelKategoriNilai[$x]['bts_ats'])
				{
					$kategoriNilai 	= 	$tabelKategoriNilai[$x]['kategori'];
					$golonganNilai 	=	$tabelKategoriNilai[$x]['gol_nilai'];
					// echo 'Masuk Golongan Nilai : '.'YA'.'<br/>'.'<br/>';
				}
				// echo 'Masuk Golongan Nilai : '.'TIDAK'.'<br/>'.'<br/>';

			}

			$tabelGolonganPekerjaan 		= 	$this->M_assessment->ambilGolonganPekerjaanPekerja($idEvaluasiSeksi[$j]);
			$golonganPekerjaan 				=	$tabelGolonganPekerjaan[0]['gol_kerja'];

			$idKenaikan 					=	0;

			for($z=0; $z < count($tabelKenaikan); $z++)
			{
				if
				(
					$golonganNilai==$tabelKenaikan[$z]['gol_nilai']
					&& $golonganPekerjaan==$tabelKenaikan[$z]['gol_kerja']
				)
				{
					$idKenaikan 		=	$tabelKenaikan[$z]['id_kenaikan'];
				}
			}

			$dataEvaluasi 	=	array(
									'total_nilai'			=>	$nilaiTotal,
									'kat_nilai'				=>	$kategoriNilai,
									'gol_nilai'				=>	$golonganNilai,
									'id_kenaikan' 			=>	$idKenaikan,
									'last_action_timestamp'	=> 	$this->general->ambilWaktuEksekusi()
								);
			$this->M_assessment->updateNilaiEvaluasi($dataEvaluasi, $idEvaluasiSeksi[$j]);

			
		}

		// exit();
		$redirectRoute		=	'PenilaianKinerja/JurnalPenilaianPersonalia';

		redirect($redirectRoute);
	}
}
