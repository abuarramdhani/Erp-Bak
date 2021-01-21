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
		$data['view'] = 'Seksi';
		$noind = $this->session->user;
		$cari = $this->M_settingdata->cekemail($noind); // cek user login sudah terdaftar / belum
        $data['ket'] = !empty($cari) ? 'ada' : 'tidak';
        $data['data'] = $this->M_settingdata->dataEmail("where username not in ('Tim Kode Barang','Akuntansi','Pembelian','PIEA')");
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PendaftaranMasterItem/V_SettingEmail', $data);
		$this->load->view('V_Footer',$data);
    }
    // modal tambah email / pendaftaran email baru di c_settingemail folder tim kode barang
	public function saveemail(){
		$cek	= $this->M_settingdata->dataEmail('');
		$id		= !empty($cek) ? $cek[0]['ID_EMAIL'] + 1 : 1;
		$noind 	= $this->session->user;
		$user   = $this->input->post('email');
		$ket    = $this->input->post('ket');
		$this->M_settingdata->saveEmail($id, $noind, $user);
	}
	
    public function deleteemail(){
        $id = $this->input->post('id');
        $ket = $this->input->post('ket');
		$this->M_settingdata->deleteEmail($id);
		
		// tujuan berdasarkan ket/ resp. yang dibuka user login
        if ($ket == 'Seksi') { // resp. pendaftaran master item
            $tujuan = 'PendaftaranMasterItem/SettingEmail';
        }elseif ($ket == 'TimKodeBarang') { // resp. master item tim kode barang
            $tujuan = 'MasterItemTimKode/SettingEmail';
        }elseif ($ket == 'Akuntansi') { // resp. master item akuntansi
            $tujuan = 'MasterItemAkuntansi/SettingEmail';
        }elseif ($ket == 'Pembelian') { // resp. master item pembelian
            $tujuan = 'MasterItemPembelian/SettingEmail';
        }elseif ($ket == 'piea') { // resp. master item piea
            $tujuan = 'MasterItemPIEA/SettingData';
        }
        echo $tujuan;
    }
	

}