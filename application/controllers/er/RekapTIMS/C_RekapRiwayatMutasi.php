<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_RekapRiwayatMutasi extends CI_Controller 
{
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('General');

		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_rekapriwayatmutasi');
		  
		if($this->session->userdata('logged_in')!=TRUE) 
		{
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			// $this->session->set_userdata('Responsibility', 'some_value');
		}

		$this->checkSession();
    }
	
	public function checkSession()
	{
		if($this->session->is_logged)
		{
		}
		else
		{
			redirect();
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;
		
		$data['Title'] 		= 'Rekap Riwayat Mutasi Pekerja';
		$data['Menu'] 		= 'Riwayat Mutasi Pekerja';
		$data['SubMenuOne'] = 'Riwayat Mutasi Pekerja';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('radioJenisPencarian', 'Jenis Pencarian', 'required');	

		if($this->form_validation->run() === FALSE)
		{
			$data['Header'] 	=	'Rekap Riwayat Mutasi Pekerja - Quick ERP';
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('er/RekapTIMS/RekapRiwayatMutasi/V_index',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$jenisPencarian 		=	$this->input->post('radioJenisPencarian', TRUE);
			$parameterCari 			=	"where ";

			/*
			*	noind 		=>	Pencarian dengan nomor induk
			*	seksi		=>	Pencarian dengan seksi
			*	lokasikerja	=>	Pencarian dengan lokasi kerja
			*/
			if($jenisPencarian=='noind')
			{
				$nomorInduk			=	$this->input->post('cmbNoind', TRUE);

				$riwayatNomorInduk	=	$this->M_rekapriwayatmutasi->ambilRiwayatPekerja($nomorInduk);

				$parameterNomorInduk	=	"(";

				for($i = 0; $i < count($riwayatNomorInduk); $i++)
				{
					$parameterNomorInduk	.=	"'".$riwayatNomorInduk[$i]['noind']."'";
					if($i < (count($riwayatNomorInduk)-1))
					{
						$parameterNomorInduk	.=	", ";
					}
				}

				$parameterNomorInduk 	.=	")";

				$parameterCari 		.=	"trim(tmutasi.noind) in $parameterNomorInduk";
			}
			elseif($jenisPencarian=='seksi')
			{
				$departemenLama 	=	$this->input->post('cmbDepartemenLama', TRUE);
				$departemenBaru 	=	$this->input->post('cmbDepartemenBaru', TRUE);

				$bidangLama 		=	$this->input->post('cmbBidangLama', TRUE);
				$unitLama 			=	$this->input->post('cmbUnitLama', TRUE);
				$seksiLama 			=	$this->input->post('cmbSeksiLama', TRUE);

				$bidangLama 		=	substr($bidangLama, -2);
				$unitLama 			=	substr($unitLama, -2);
				$seksiLama 			=	substr($seksiLama, -2);

				if($bidangLama == '00')
				{
					$bidangLama 	=	'';
				}

				if($unitLama == '00')
				{
					$unitLama 		=	'';
				}

				if($seksiLama == '00')
				{
					$seksiLama 		=	'';
				}

				$kodesieLama 		=	$departemenLama.$bidangLama.$unitLama.$seksiLama;

				$bidangBaru 		=	$this->input->post('cmbBidangBaru', TRUE);
				$unitBaru 			=	$this->input->post('cmbUnitBaru', TRUE);
				$seksiBaru 			=	$this->input->post('cmbSeksiBaru', TRUE);

				$bidangBaru 		=	substr($bidangBaru, -2);
				$unitBaru 			=	substr($unitBaru, -2);
				$seksiBaru 			=	substr($seksiBaru, -2);

				if($bidangBaru == '00')
				{
					$bidangBaru 	=	'';
				}

				if($unitBaru == '00')
				{
					$unitBaru 		=	'';
				}

				if($seksiBaru == '00')
				{
					$seksiBaru 		=	'';
				}

				$kodesieBaru 		=	$departemenBaru.$bidangBaru.$unitBaru.$seksiBaru;

				if(!(empty($departemenLama)) AND empty($departemenBaru))
				{
					$parameterCari 	.=	"trim(tmutasi.kodesielm) like '$kodesieLama%'";
				}
				elseif((empty($departemenLama)) AND !(empty($departemenBaru)))
				{
					$parameterCari 	.=	"trim(tmutasi.kodesiebr) like '$kodesieBaru%'";
				}
				elseif(!(empty($departemenLama)) AND !(empty($departemenBaru)))
				{
					$parameterCari 	.=	"	trim(tmutasi.kodesielm) like '$kodesieLama%' 
											and 	trim(tmutasi.kodesiebr) like '$kodesieBaru%'";
				}
			}
			elseif($jenisPencarian=='lokasikerja')
			{
				$lokasiKerjaLama 	=	$this->input->post('cmbLokasiKerjaLama', TRUE);
				$lokasiKerjaBaru	=	$this->input->post('cmbLokasiKerjaBaru', TRUE);

				if(!(empty($lokasiKerjaLama)) AND empty($lokasiKerjaBaru))
				{
					$parameterCari 	.=	"trim(tmutasi.lokasilm)='$lokasiKerjaLama'";
				}
				elseif((empty($lokasiKerjaLama)) AND !(empty($lokasiKerjaBaru)))
				{
					$parameterCari 	.=	"trim(tmutasi.lokasibr)='$lokasiKerjaBaru'";
				}
				elseif(!(empty($lokasiKerjaLama)) AND !(empty($lokasiKerjaBaru)))
				{
					$parameterCari 	.=	"	trim(tmutasi.lokasilm)='$lokasiKerjaLama'
											and 	trim(tmutasi.lokasibr)='$lokasiKerjaBaru'";
				}
			}

			$rekapRiwayatMutasi 			=	$this->M_rekapriwayatmutasi->ambilRiwayatMutasi($parameterCari);

			$data['Header']					=	"Rekap Riwayat Mutasi Pekerja - Quick ERP";
			$data['rekapRiwayatMutasi']		=	$rekapRiwayatMutasi;

			// echo $parameterCari;
			// echo '<pre>';
			// print_r($rekapRiwayatMutasi);
			// echo '</pre>';
			// exit();

			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('er/RekapTIMS/RekapRiwayatMutasi/V_index',$data);
			$this->load->view('V_Footer',$data);
		}
		
	}

	//	Javascript Functions
	//	{
			public function daftarPekerja()
			{
				$keyword 	=	strtoupper($this->input->get('term'));

				$daftarPekerja 	=	$this->M_rekapriwayatmutasi->ambilDaftarPekerja($keyword);
				echo json_encode($daftarPekerja);
			}
			
			public function daftarLokasiKerja()
			{
				$keyword 	=	strtoupper($this->input->get('term'));

				$daftarLokasiKerja 	=	$this->M_rekapriwayatmutasi->ambilDaftarLokasiKerja($keyword);
				echo json_encode($daftarLokasiKerja);
			}

			public function daftarDepartemen()
			{
				$resultDepartemen = 	$this->M_rekapriwayatmutasi->ambilDepartemen();
				echo json_encode($resultDepartemen);
			}

			public function daftarBidang()
			{
				$departemen 	=	$this->input->get('departemen');

				$resultBidang 	=	$this->M_rekapriwayatmutasi->ambilBidang($departemen);
				echo json_encode($resultBidang);
			}

			public function daftarUnit()
			{
				$bidang 		=	$this->input->get('bidang');

				$resultUnit		=	$this->M_rekapriwayatmutasi->ambilUnit($bidang);
				echo json_encode($resultUnit);
			}

			public function daftarSeksi()
			{
				$unit 			=	$this->input->get('unit');

				$resultSeksi	=	$this->M_rekapriwayatmutasi->ambilSeksi($unit);
				echo json_encode($resultSeksi);
			}			
	//	}
}
