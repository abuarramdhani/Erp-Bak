<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterPengurangNilai extends CI_Controller 
{
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
		$this->load->model('JurnalPenilaian/M_pengurangnilai');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Pengurang Nilai';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabelSKPengurangPrestasi']	=	$this->M_pengurangnilai->ambilSKPengurangPrestasi();
		$data['tabelSKPengurangKemauan']	=	$this->M_pengurangnilai->ambilSKPengurangKemauan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/PengurangNilai/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SK_modification()
	{
		$idSKPrestasi 	=	$this->input->post('txtIDSKPrestasi');
		$idSKKemauan	=	$this->input->post('txtIDSKKemauan');

		if(!(empty($idSKPrestasi)))
		{
			$prestasiBatasBawah 	=	$this->input->post('txtBatasBawahJumlahSKPrestasi');
			$prestasiBatasAtas 		=	$this->input->post('txtBatasAtasJumlahSKPrestasi');
			$prestasiPengurang 		=	$this->input->post('txtPengurangSKPrestasi');
			for ($i=0; $i < count($idSKPrestasi) ; $i++) 
			{
				if($idSKPrestasi[$i]=='-')
				{
					// Create
					$waktuEksekusi 	=	$this->general->ambilWaktuEksekusi();
					$input 			=	array(
											'batas_bawah'			=>	$prestasiBatasBawah[$i],
											'batas_atas'			=>	$prestasiBatasAtas[$i],
											'pengurang'				=>	$prestasiPengurang[$i],
											'last_action_timestamp'	=>	$waktuEksekusi,
											'creation_timestamp'	=>	$waktuEksekusi
										);
					$this->M_pengurangnilai->inputSKPengurangPrestasi($input);
				}
				else
				{
					// Update
					$idSKPrestasi[$i]	=	$this->encryption->decrypt(str_replace(array('-', '_', '~'), array('+', '/', '='), $idSKPrestasi[$i]));

					$waktuEksekusi 	=	$this->general->ambilWaktuEksekusi();
					$update 			=	array(
											'batas_bawah'			=>	$prestasiBatasBawah[$i],
											'batas_atas'			=>	$prestasiBatasAtas[$i],
											'pengurang'				=>	$prestasiPengurang[$i],
											'last_action_timestamp'	=>	$waktuEksekusi,
										);
					$this->M_pengurangnilai->updateSKPengurangPrestasi($update, $idSKPrestasi[$i]);					
				}
			}
		}
		elseif(!(empty($idSKKemauan)))
		{
			$kemauanBatasBawah 	=	$this->input->post('txtBatasBawahJumlahSKKemauan');
			$kemauanBatasAtas 		=	$this->input->post('txtBatasAtasJumlahSKKemauan');
			$kemauanPengurang 		=	$this->input->post('txtPengurangSKKemauan');
			for ($i=0; $i < count($idSKKemauan) ; $i++) 
			{
				if($idSKKemauan[$i]=='-')
				{
					// Create
					$waktuEksekusi 	=	$this->general->ambilWaktuEksekusi();
					$input 			=	array(
											'bulan_batas_bawah'		=>	$kemauanBatasBawah[$i],
											'bulan_batas_atas'		=>	$kemauanBatasAtas[$i],
											'pengurang'				=>	$kemauanPengurang[$i],
											'last_action_timestamp'	=>	$waktuEksekusi,
											'creation_timestamp'	=>	$waktuEksekusi
										);
					$this->M_pengurangnilai->inputSKPengurangKemauan($input);
				}
				else
				{
					// Update
					$idSKKemauan[$i]	=	$this->encryption->decrypt(str_replace(array('-', '_', '~'), array('+', '/', '='), $idSKKemauan[$i]));

					$waktuEksekusi 	=	$this->general->ambilWaktuEksekusi();
					$update 			=	array(
											'bulan_batas_bawah'		=>	$kemauanBatasBawah[$i],
											'bulan_batas_atas'		=>	$kemauanBatasAtas[$i],
											'pengurang'				=>	$kemauanPengurang[$i],
											'last_action_timestamp'	=>	$waktuEksekusi,
										);
					$this->M_pengurangnilai->updateSKPengurangKemauan($update, $idSKKemauan[$i]);					
				}
			}
		}
		redirect('PenilaianKinerja/MasterPengurangNilai');
	}

	public function SKPrestasi_delete()
	{
		$idSKPrestasi 	=	$this->encryption->decrypt(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('txtIDSKPrestasiDelete')));
		$this->M_pengurangnilai->deleteSKPrestasi($idSKPrestasi);
		redirect('PenilaianKinerja/MasterPengurangNilai');
	}

	public function SKKemauan_delete()
	{
		$idSKPrestasi 	=	$this->encryption->decrypt(str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->post('txtIDSKPrestasiDelete')));
		$this->M_pengurangnilai->deleteSKPrestasi($idSKPrestasi);
		redirect('PenilaianKinerja/MasterPengurangNilai');
	}

}