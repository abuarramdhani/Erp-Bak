<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_AssetCabangAkt extends CI_Controller{
	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper(array('form', 'url'));
        $this->load->helper(array('url','download')); 
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('AssetCabangAkt/M_assetcabangakuntansi');
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
		$this->load->view('AssetCabangAkt/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function laporanAssetDataOracle()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$cabang = $this->M_assetcabangakuntansi->getKodeCabang();
		$data['cbg'] = $cabang;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangAkt/Oracle/V_pre-TableList', $data);
		$this->load->view('V_Footer',$data);

	}

	public function getFilter()
	{
		$id_branch2 = $this->input->post('id_branch');
		$data['oracle'] = $this->M_assetcabangakuntansi->getDataOracleFilter($id_branch2);
		$this->load->view('AssetCabangAkt/Oracle/V_hasilFilter', $data);
	}


	public function draft()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['draft'] = $this->M_assetcabangakuntansi->getDraft();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangAkt/Non-Oracle/V_draftAkt',$data);
		$this->load->view('V_Footer',$data);

	}


	public function downloadMkt($judul){
   		$file = "assets/upload/AssetCabang/Marketing/$judul";
   		force_download($file,NULL);
	}

	public function Detail($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenis_asset = $this->M_assetcabangakuntansi->getDataJenisAsset();
		$kategori_asset = $this->M_assetcabangakuntansi->getKategoriAsset();
		$perolehan_asset = $this->M_assetcabangakuntansi->getPerolehanAsset();
		$seksi_pemakai = $this->M_assetcabangakuntansi->getSeksiPemakai();
		$cabang = $this->M_assetcabangakuntansi->getKodeCabang();
		$hasilDraft = $this->M_assetcabangakuntansi->getHasilDraft($id);
		$rencanaKebutuhan = $this->M_assetcabangakuntansi->getRencanaKebutuhan($id);

		$data['ja'] = $jenis_asset;
		$data['ka'] = $kategori_asset;
		$data['pa'] = $perolehan_asset;
		$data['sp'] = $seksi_pemakai;
		$data['header'] = $hasilDraft;
		$data['cabang'] = $cabang;
		$data['line'] = $rencanaKebutuhan;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangAkt/Non-Oracle/V_detailProposalAkt',$data);
		$this->load->view('V_Footer',$data);
	}

	public function updateAkt()
	{
		// echo "<pre>";print_r($_POST);exit();
		$id = $this->input->post('id_proposal');
		$batch_number = $this->input->post('batch_number');
		$status = $this->input->post('status');
		$user = $this->session->user;

		$updateAkuntansi = $this->M_assetcabangakuntansi->updateAkuntansi($id,$batch_number,$status,$user);
	}

	public function received()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['approved'] = $this->M_assetcabangakuntansi->getApproved();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangAkt/Non-Oracle/V_receivedAkt',$data);
		$this->load->view('V_Footer',$data);

	}

	public function Konfirmasi($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$jenis_asset = $this->M_assetcabangakuntansi->getDataJenisAsset();
		$kategori_asset = $this->M_assetcabangakuntansi->getKategoriAsset();
		$perolehan_asset = $this->M_assetcabangakuntansi->getPerolehanAsset();
		$seksi_pemakai = $this->M_assetcabangakuntansi->getSeksiPemakai();
		$cabang = $this->M_assetcabangakuntansi->getKodeCabang();
		$hasilDraft = $this->M_assetcabangakuntansi->getHasilDraft($id);
		$rencanaKebutuhan = $this->M_assetcabangakuntansi->getRencanaKebutuhan($id);

		$data['ja'] = $jenis_asset;
		$data['ka'] = $kategori_asset;
		$data['pa'] = $perolehan_asset;
		$data['sp'] = $seksi_pemakai;
		$data['header'] = $hasilDraft;
		$data['cabang'] = $cabang;
		$data['line'] = $rencanaKebutuhan;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangAkt/Non-Oracle/V_KonfirmasiProposalAkt',$data);
		$this->load->view('V_Footer',$data);
	}

	public function done()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['finished'] = $this->M_assetcabangakuntansi->getFinished();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangAkt/Non-Oracle/V_finishedAkt',$data);
		$this->load->view('V_Footer',$data);
	}


}
?>
