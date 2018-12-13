<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class C_RekapDataPresensiTIM extends CI_Controller 
	{
		public function __construct()
	    {
	        parent::__construct();
			  
	        $this->load->library('General');

			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('er/RekapTIMS/M_rekapdatapresensitim');
			  
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
			if(!($this->session->is_logged))
			{
				redirect();
			}
		}

		public function index()
		{
			$data 	=	$this->general->loadHeaderandSidemenu('Rekap Data Presensi-TIM - Quick ERP', 'Rekap Data Presensi - TIM');

			$this->form_validation->set_rules('txtTanggalRekap', 'Tanggal Rekap', 'required');

			if($this->form_validation->run() === FALSE)
			{
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('er/RekapTIMS/RekapDataPresensiTIM/V_index',$data);
				$this->load->view('V_Footer',$data);
			}
			else
			{
				$tanggal_rekap 			=	$this->input->post('txtTanggalRekap');
				$keterangan_presensi 	=	$this->input->post('cmbKeteranganPresensi');
				$noind 					=	$this->input->post('cmbPekerja');
				$susulan 				=	$this->input->post('checkSusulanDataPresensi');

				$parameter_susulan = "";
				if (!empty($susulan)) {
					$parameter_susulan = $susulan;
				}
				$data['tanggal_rekap'] 	=	$tanggal_rekap;

				$tanggal_rekap 	=	explode(' - ', $tanggal_rekap);
				$tanggal_awal 	=	$tanggal_rekap[0];
				$tanggal_akhir 	=	$tanggal_rekap[1];

				$parameter_keterangan 	=	"";
				$total_keterangan 		=	count($keterangan_presensi);
				$indeks_keterangan 		=	0;
				if ( !(empty($keterangan_presensi)) )
				{
					foreach ($keterangan_presensi as $ket)
					{
						$parameter_keterangan 	.= 	"'".$ket."'";
						if ( $indeks_keterangan < ($total_keterangan-1) )
						{
							$parameter_keterangan 	.=	", ";
						}
						$indeks_keterangan++;
					}
				}

				$parameter_noind 		=	"";
				$total_noind 			=	count($noind);
				$indeks_noind 			=	0;
				if ( !(empty($noind)) )
				{
					foreach ($noind as $nomor_induk)
					{
						$parameter_noind 	.= 	"'".$nomor_induk."'";
						if ( $indeks_noind < ($total_noind-1) )
						{
							$parameter_noind 	.=	", ";
						}
						$indeks_noind++;
					}
				}
				
				$data['rekap_data_presensi_tim'] 	=	$this->M_rekapdatapresensitim->rekap_data_presensi_tim($tanggal_awal, $tanggal_akhir, $parameter_keterangan, $parameter_noind,$parameter_susulan);

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('er/RekapTIMS/RekapDataPresensiTIM/V_index',$data);
				$this->load->view('V_Footer',$data);
			}
		}

		//	Javascript Function
		//	{
				public function daftar_keterangan_presensi()
				{
					$keyword 	=	strtoupper($this->input->get('term'));
					$daftar_keterangan_presensi 	=	$this->M_rekapdatapresensitim->daftar_keterangan_presensi($keyword);
					echo json_encode($daftar_keterangan_presensi);
				}

				public function pekerja()
				{
					$keyword 	=	strtoupper($this->input->get('term'));
					$pekerja 	=	$this->M_rekapdatapresensitim->pekerja($keyword);
					echo json_encode($pekerja);
				}
		//	}
	}
