<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterUnitGroupDistribution extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('General');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('JurnalPenilaian/M_unitgroup');
		$this->load->model('JurnalPenilaian/M_rangenilai');
		$this->load->model('JurnalPenilaian/M_kenaikan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}

		date_default_timezone_set('Asia/Jakarta');
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function checkSession()
	{
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		

		$data['Menu'] = 'Master Distribution';
		$data['SubMenuOne'] = 'Master Distribution';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabelJumlahGolongan'] 		= 	$this->M_unitgroup->ambilJumlahGolongan();

		$data['idJumlahGolongan'] 			= 	$data['tabelJumlahGolongan'][0]['id_jumlah_golongan'];
		$data['jumlahGolongan'] 			= 	$data['tabelJumlahGolongan'][0]['jumlah_golongan'];
		$data['daftarGolonganKerja'] 		=	$this->M_kenaikan->ambilGolonganKerja();

		// $data['daftarUnitGroup']			= 	$this->M_unitgroup->ambilNamaUnitGroup();

		$data['daftarDistribusiPekerja']	=	$this->M_unitgroup->ambilDistribusiPekerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterDistribution/V_Index',$data);
		$this->load->view('V_Footer',$data);	
	}

	public function jumlahGolongan_modification()
	{
		$jumlahGolonganLama 		=	filter_var($this->input->post('txtJumlahGolonganLama'), FILTER_SANITIZE_NUMBER_INT);
		$jumlahGolonganBaru 		= 	filter_var($this->input->post('txtJumlahGolonganBaru'), FILTER_SANITIZE_NUMBER_INT);
		$idJumlahGolongan 			= 	$this->input->post('txtIDJumlahGolongan');
		$golonganKerja 				=	$this->M_kenaikan->ambilGolonganKerja();

		if($jumlahGolonganLama=='0')
		{
			// Jika jumlah golongan sebelumnya adalah '0', maka CREATE.

			$jumlahGolongan 	= 	array(
										'num'					=>	$jumlahGolonganBaru,
										'creation_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
										'last_action_timestamp'	=> 	$this->general->ambilWaktuEksekusi()
									);
			$this->M_unitgroup->setJumlahGolongan($jumlahGolongan, $idJumlahGolongan);

			// Buat golongan nilai
			for($x = 1; $x <= $jumlahGolonganBaru; $x++)
			{
				$inputRangeNilai 	=	array(
											'bts_bwh'				=>	0,
											'bts_ats'				=>	0,
											'kategori'				=>	'-',
											'gol_nilai'				=>	$x,
											'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
											'creation_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
										);
				$this->M_rangenilai->createRangeNilai($inputRangeNilai);

				foreach ($golonganKerja as $golkerja) 
				{
					$inputKenaikan 		=	array(
												'gol_kerja'				=>	$golkerja['golkerja'],
												'gol_nilai' 			=>	$x,
												'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
												'creation_timestamp'	=>	$this->general->ambilWaktuEksekusi()
											);
					$this->M_kenaikan->inputKenaikan($inputKenaikan);
				}
			}
		}
		else
		{
			// Jika jumlah golongan sebelumnya bukan '0', maka UPDATE.

			$jumlahGolongan 	= 	array(
										'num'					=>	$jumlahGolonganBaru,
										'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi()
									);
			$this->M_unitgroup->setJumlahGolongan($jumlahGolongan, $idJumlahGolongan);

			if($jumlahGolonganBaru<$jumlahGolonganLama)
			{
				$dataDeleted 		=	$this->M_rangenilai->ambilDataGolonganNilaiDeleted($jumlahGolonganBaru);
				foreach ($dataDeleted as $deleted) 
				{
					$dataHistory 	=	array(
											'id_range_nilai'		=>	$deleted['id_range_nilai'],
											'gol_nilai'				=>	$deleted['gol_nilai'],
											'bts_bwh'				=>	$deleted['bts_bwh'],
											'bts_ats'				=>	$deleted['bts_ats'],
											'kategori'				=>	$deleted['kategori'],
											'last_action_timestamp'	=>	$deleted['last_action_timestamp'],
											'creation_timestamp'	=>	$deleted['creation_timestamp'],
											'deletion_timestamp'	=>	$this->general->ambilWaktuEksekusi()
										);
					$this->M_rangenilai->inputDataRangeNilaiDeletedkeHistory($dataHistory);
				}

				$this->M_rangenilai->deleteRangeNilaiUnused($jumlahGolonganBaru);

				$dataDeleted 		=	$this->M_kenaikan->ambilKenaikanDeleted($jumlahGolonganBaru);
				foreach ($dataDeleted as $deleted) 
				{
					$dataHistory 	=	array(
											'id_kenaikan'			=>	$deleted['id_kenaikan'],
											'gol_kerja'				=>	$deleted['gol_kerja'],
											'gol_nilai'				=> 	$deleted['gol_nilai'],
											'nominal_kenaikan'		=>	$deleted['nominal_kenaikan'],
											'last_action_timestamp'	=>	$deleted['last_action_timestamp'],
											'creation_timestamp'	=>	$deleted['creation_timestamp'],
											'deletion_timestamp'	=>	$this->general->ambilWaktuEksekusi()
										);
					$this->M_kenaikan->inputKenaikanDeletedkeHistory($dataHistory);
					$this->M_kenaikan->hapusKenaikan($deleted['gol_nilai']);
				}
			}
			elseif($jumlahGolonganBaru>$jumlahGolonganLama)
			{
				for ($y = $jumlahGolonganLama; $y < $jumlahGolonganBaru; $y++) 
				{ 
					$inputRangeNilai 	=	array(
												'bts_bwh'				=>	0,
												'bts_ats'				=>	0,
												'kategori'				=>	'-',
												'gol_nilai'				=>	($y+1),
												'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
												'creation_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
											);
					$this->M_rangenilai->createRangeNilai($inputRangeNilai);

					foreach ($golonganKerja as $golkerja) 
					{
						$inputKenaikan 		=	array(
													'gol_kerja'				=>	$golkerja['golkerja'],
													'gol_nilai' 			=>	($y+1),
													'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
													'creation_timestamp'	=>	$this->general->ambilWaktuEksekusi()
												);
						$this->M_kenaikan->inputKenaikan($inputKenaikan);
					}					
				}
			}
		}

		redirect('PenilaianKinerja/MasterUnitGroupDistribution');

	}

	public function jumlahGolongan_delete()
	{
		$jumlahGolonganLama 		=	filter_var($this->input->post('txtJumlahGolonganLama'), FILTER_SANITIZE_NUMBER_INT);
		$idJumlahGolongan 			= 	$this->input->post('txtIDJumlahGolongan');

		$dataDeleted 				=	$this->M_unitgroup->ambilDataJumlahGolonganDeleted($idJumlahGolongan);
		foreach ($dataDeleted as $deleted) 
		{
			$dataHistory 			=	array(
											'num'					=>	$deleted['num'],
											'id'					=>	$deleted['id'],
											'last_action_timestamp'	=>	$deleted['last_action_timestamp'],
											'creation_timestamp'	=>	$deleted['creation_timestamp'],
											'deletion_timestamp'	=>	$this->general->ambilWaktuEksekusi()
										);
			$this->M_unitgroup->inputDataJumlahGolonganDeletedkeHistory($dataHistory);
		}
		$this->M_unitgroup->hapusJumlahGolongan($idJumlahGolongan);

		$dataBaru 	=	array(
							'num'					=>	0,
							'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
							'creation_timestamp'	=>	$this->general->ambilWaktuEksekusi()
						);

		$this->M_unitgroup->buatJumlahGolonganBaru($dataBaru);

		// Backup data golongan nilai yang akan di-delete
		$dataDeleted 	=	$this->M_rangenilai->ambilDataGolonganNilaiDeleted();
		foreach ($dataDeleted as $deleted) 
		{
			$dataHistory 	=	array(
									'id_range_nilai'		=>	$deleted['id_range_nilai'],
									'gol_nilai'				=>	$deleted['gol_nilai'],
									'bts_bwh'				=>	$deleted['bts_bwh'],
									'bts_ats'				=>	$deleted['bts_ats'],
									'kategori'				=>	$deleted['kategori'],
									'last_action_timestamp'	=>	$deleted['last_action_timestamp'],
									'creation_timestamp'	=>	$deleted['creation_timestamp'],
									'deletion_timestamp'	=>	$this->general->ambilWaktuEksekusi()
								);
			$this->M_rangenilai->inputDataRangeNilaiDeletedkeHistory($dataHistory);
		}
		$this->M_rangenilai->deleteRangeNilaiUnused();

		$dataDeleted 	=	$this->M_kenaikan->ambilKenaikanDeleted();
		foreach ($dataDeleted as $deleted) 
		{
			$dataHistory 	=	array(
									'id_kenaikan'			=>	$deleted['id_kenaikan'],
									'gol_kerja'				=>	$deleted['gol_kerja'],
									'gol_nilai'				=> 	$deleted['gol_nilai'],
									'nominal_kenaikan'		=>	$deleted['nominal_kenaikan'],
									'last_action_timestamp'	=>	$deleted['last_action_timestamp'],										
									'creation_timestamp'	=>	$deleted['creation_timestamp'],
									'deletion_timestamp'	=>	$this->general->ambilWaktuEksekusi()
								);
			$this->M_kenaikan->inputKenaikanDeletedkeHistory($dataHistory);
		}
		$this->M_kenaikan->hapusSemuaKenaikan();

		redirect('PenilaianKinerja/MasterUnitGroupDistribution');
	}

	public function distribusi_unitGroupEdit($golKerja)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Master Distribution';
		$data['Menu'] = 'Master Distribution';
		$data['SubMenuOne'] = 'Master Distribution';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$golKerjaDecoded 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $golKerja);
		$golKerjaDecoded 	= $this->encrypt->decode($golKerjaDecoded);

		$data['id']				=	$golKerja;

		$data['tabelJumlahGolongan'] 	= 	$this->M_unitgroup->ambilJumlahGolongan();		

		// $data['daftarUnitGroup']	= 	$this->M_unitgroup->ambilNamaUnitGroup($golKerjaDecoded);
		$data['golKerja']			=	$golKerjaDecoded;
		$data['jumlahGolongan'] 	= 	$data['tabelJumlahGolongan'][0]['jumlah_golongan'];


		$this->form_validation->set_rules('txtJumlahPekerja[]', 'Jumlah Pekerja', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$data['daftarDistribusiPekerja']	=	$this->M_unitgroup->ambilDistribusiPekerja($golKerjaDecoded);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('JurnalPenilaian/MasterDistribution/V_Distribusi_UnitGroup',$data);
			$this->load->view('V_Footer',$data);	
		}
		else
		{
			$jumlahPekerja 		=	$this->input->post('txtJumlahPekerja');

			// echo '<pre>';
			// print_r($jumlahPekerja);
			// echo '</pre>';

			$cekDataDistribusi	=	$this->M_unitgroup->cekDataDistribusi($golKerjaDecoded);

			if($cekDataDistribusi==0)
			{
				// Insert
				for ($m=0; $m < count($jumlahPekerja); $m++) 
				{ 
					$dataDistribusiPekerja	=	array(
													'gol_kerja'				=>	$golKerjaDecoded,
													'gol_num'				=>	($m+1),
													'worker_count'			=>	$jumlahPekerja[$m],
													'last_action_timestamp'	=> 	$this->general->ambilWaktuEksekusi(),
													'creation_timestamp'	=>	$this->general->ambilWaktuEksekusi()
												);
					// echo '<pre>';
					// print_r($dataDistribusiPekerja);
					// echo '</pre>';
					$this->M_unitgroup->tambahDataDistribusiPekerja($dataDistribusiPekerja);
				}
			}
			elseif($cekDataDistribusi>0)
			{
				// Update
				for($m = 0; $m < count($jumlahPekerja); $m++)
				{
					$i 	=	$m+1;
					$dataDistribusiPekerja 	=	array(
													'worker_count'			=>	$jumlahPekerja[$m],
													'last_action_timestamp'	=>	$this->general->ambilWaktuEksekusi()
												);
					// echo '<pre>';
					// print_r($dataDistribusiPekerja);
					// echo '</pre>';
					$this->M_unitgroup->updateDataDistribusiPekerja($dataDistribusiPekerja, $golKerjaDecoded, ($i));
				}
			}

			// exit();
			redirect('PenilaianKinerja/MasterUnitGroupDistribution');
		}
	}
}