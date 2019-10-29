<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_TrackingPengirimanBarang extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('TrackingPengirimanBarang/M_trackingpengirimanbarang');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		date_default_timezone_set('Asia/Jakarta');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function sortingcenter()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$select_status_nol = $this->M_trackingpengirimanbarang->onSorting();
		$data['nol'] = $select_status_nol;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingPengirimanBarang/V_sortingcenter',$data);
		$this->load->view('V_Footer',$data);
	}

	public function OpenDetailSorting()
	{
		$no_spb = $this->input->post('no_spb');
		$cariSPBOracle = $this->M_trackingpengirimanbarang->getSPBDetail($no_spb);
		$data['spb'] = $cariSPBOracle;

		if (!empty($data['spb'])) {
			return $this->load->view('TrackingPengirimanBarang/V_mdlSPB', $data);
			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#MdlTPBNol').modal('hide')</script>";
			}

		
	}
	
	public function onprocess()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$select_status_satu = $this->M_trackingpengirimanbarang->onProcess();
		$data['satu'] = $select_status_satu;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingPengirimanBarang/V_onprocess',$data);
		$this->load->view('V_Footer',$data);
	}

	public function delivered()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$select_status_dua = $this->M_trackingpengirimanbarang->onFinish();
		$data['dua'] = $select_status_dua;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingPengirimanBarang/V_delivered',$data);
		$this->load->view('V_Footer',$data);
	}
	

	public function setting()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getKendaraan = $this->M_trackingpengirimanbarang->getKendaraan();
		$getDataforTabel = $this->M_trackingpengirimanbarang->getTPBLogin();
		$data['vehicle'] = $getKendaraan;
		$data['tabel'] = $getDataforTabel;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingPengirimanBarang/V_setting',$data);
		$this->load->view('V_Footer',$data);
	
	}

	public function saveSetupSetting()
	{
		$id_pekerja = $this->input->post('id_pekerja');
		$nama_pekerja = $this->input->post('nama_pekerja');
		$kendaraan = $this->input->post('kendaraan');
		$nomer_kendaraan = $this->input->post('nomer_kendaraan');
		$slcKendaraan = $this->input->post('slcKendaraan');//id

		if ($id_pekerja == NULL && $nama_pekerja == NULL && $slcKendaraan == NULL) {

		$tambahOptionKendaraan = $this->M_trackingpengirimanbarang->tambahOptionJK($kendaraan,$nomer_kendaraan);

		} else{
			
		if ($slcKendaraan == NULL) {
		$insertSetup = $this->M_trackingpengirimanbarang->insertDataSetup($id_pekerja,$nama_pekerja,$kendaraan,$nomer_kendaraan);
		$tambahOptionKendaraan = $this->M_trackingpengirimanbarang->tambahOptionJK($kendaraan,$nomer_kendaraan);
		}else {
		$kendaraanArr = $this->M_trackingpengirimanbarang->selectNoJK($slcKendaraan);
		$nomer_jk = $kendaraanArr[0]['nomor_kendaraan'];
		$kendaraan_jk = $kendaraanArr[0]['kendaraan'];
		$insertSetup = $this->M_trackingpengirimanbarang->insertDataSetup($id_pekerja,$nama_pekerja,$kendaraan_jk,$nomer_jk);
		}

		}

		

	}

	public function deleteLogin()
	{
		$id_login = $this->input->post('id_login');
		$deleteUser = $this->M_trackingpengirimanbarang->deleteUser($id_login);
	}

	public function updateLogin()
	{
		$id_login = $this->input->post('id_login');
		$getDataforUpdate = $this->M_trackingpengirimanbarang->getData($id_login);
		$getKendaraan2 = $this->M_trackingpengirimanbarang->getKendaraan();

		$data['update'] = $getDataforUpdate;
		$data['vehicle'] = $getKendaraan2;


		return $this->load->view('TrackingPengirimanBarang/V_mdlLogin',$data);
	}

	public function funUpdateLogin()
	{
		$id_login = strtoupper($this->input->post('id_login'));
		$nama_pekerja = strtoupper($this->input->post('nama_pekerja'));
		$kendaraan = strtoupper($this->input->post('kendaraan'));
		$username = strtoupper($this->input->post('username'));
		$kendaraanArr2 = $this->M_trackingpengirimanbarang->selectNoJK($kendaraan);
		$no_kendaraan = $kendaraanArr2[0]['nomor_kendaraan'];
		$nama_kendaraan = $kendaraanArr2[0]['kendaraan'];

		$funUpdateLogin = $this->M_trackingpengirimanbarang->updateData($id_login,$nama_pekerja,$nama_kendaraan,$no_kendaraan,$username);
	}

	public function deleteSPB()
	{
		$no_spb = $this->input->post('no_spb');
		$deleteSPB = $this->M_trackingpengirimanbarang->delSPB($no_spb);
	}


}
?>