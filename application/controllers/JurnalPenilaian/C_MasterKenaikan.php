<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterKenaikan extends CI_Controller 
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
		$this->load->model('JurnalPenilaian/M_kenaikan');
		$this->load->model('JurnalPenilaian/M_unitgroup');		
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
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
		$data['SubMenuOne'] = 'Kenaikan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['daftarGolonganKerja'] 		=	$this->M_kenaikan->ambilGolonganKerja();
		$data['tabelJumlahGolongan'] 		= 	$this->M_unitgroup->ambilJumlahGolongan();
		$data['jumlahGolongan'] 			= 	$data['tabelJumlahGolongan'][0]['jumlah_golongan'];
		$data['tabelKenaikan']				=	$this->M_kenaikan->ambilKenaikan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterData/Kenaikan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function modification()
	{
		$this->checkSession();
		$userid 	=	$this->session->userid;

		$daftarGolonganKerja 		=	$this->M_kenaikan->ambilGolonganKerja();
		$tabelJumlahGolongan 		= 	$this->M_unitgroup->ambilJumlahGolongan();
		$jumlahGolongan 			= 	$tabelJumlahGolongan[0]['jumlah_golongan'];		

		$kenaikan 	=	$this->input->post('txtKenaikan', TRUE);

		for ($a = 0; $a < $jumlahGolongan; $a++) 
		{ 
			for ($b = 0; $b < count($daftarGolonganKerja); $b++) 
			{ 
				$kenaikan[$a][$b] 	=	str_replace(array('Rp','.'), '', $kenaikan[$a][$b]);
				if(empty($kenaikan[$a][$b]))
				{
					$kenaikan[$a][$b]	=	0;
				}
			}
		}

		for ($p = 0; $p < $jumlahGolongan; $p++) 
		{ 
			for ($q = 0; $q < count($daftarGolonganKerja); $q++) 
			{ 
				$updateKenaikan 	=	array(
										'nominal_kenaikan'		=>	$kenaikan[$p][$q],
										'last_action_timestamp'	=>	date('Y-m-d H:i:s'),
										'creation_timestamp'	=>	date('Y-m-d H:i:s')
									);
				$this->M_kenaikan->updateKenaikan($updateKenaikan, ($p+1), ($daftarGolonganKerja[$q]['golkerja']));
			}
		}

		redirect('PenilaianKinerja/MasterKenaikan');
	}

}