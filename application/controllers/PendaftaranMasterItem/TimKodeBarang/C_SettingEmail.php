<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SettingEmail extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PendaftaranMasterItem/M_settingdata');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Setting Email';
		$data['Menu'] = 'Setting Email';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['view'] = 'TimKodeBarang';
        $data['data'] = $this->M_settingdata->dataEmail("where username = 'Tim Kode Barang'");
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PendaftaranMasterItem/V_SettingEmail', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function tambahemail(){
		$data['ket'] = $this->input->post('ket');
		$this->load->view('PendaftaranMasterItem/V_ModalTambahEmail', $data);
	}
    
	public function saveemail(){
		$user   = $this->input->post('email[]');
		$ket    = $this->input->post('ket');

		// tujuan redirect berdasarkan ket/ resp. yang dibuka user login
        if ($ket == 'TimKodeBarang') { // resp. master item tim kode barang
			$username = 'Tim Kode Barang';
            $tujuan = 'MasterItemTimKode/SettingEmail';
        }elseif ($ket == 'Akuntansi') { // resp. master item akuntansi
			$username = 'Akuntansi';
            $tujuan = 'MasterItemAkuntansi/SettingEmail';
        }elseif ($ket == 'Pembelian') { // resp master item pembelian
			$username = 'Pembelian';
            $tujuan = 'MasterItemPembelian/SettingEmail';
        }elseif ($ket == 'piea') { // resp. master item piea
			$username = 'PIEA';
            $tujuan = 'MasterItemPIEA/SettingData';
		}
		
		for ($i=0; $i < count($user) ; $i++) { 
			$cekemail = $this->M_settingdata->cekemail2($username,$user[$i]);
			if (empty($cekemail)) {
				$cekid	= $this->M_settingdata->dataEmail('');
				$id		= !empty($cekid) ? $cekid[0]['ID_EMAIL'] + 1 : 1;
				$this->M_settingdata->saveEmail($id, $username, $user[$i]);
			}
		}
        redirect(base_url($tujuan));
	}
	

}