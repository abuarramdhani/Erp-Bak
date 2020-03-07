<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_AssetCabangMkt extends CI_Controller{
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
		$this->load->model('AssetCabangMkt/M_assetcabangmarketing');
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
		$this->load->view('AssetCabangMkt/V_index',$data);
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

		$cabang = $this->M_assetcabangmarketing->getKodeCabang();

		$data['cbg'] = $cabang;


		$data['oracle'] = $this->M_assetcabangmarketing->getDataOracle();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Oracle/V_pre-TableList', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getFilter()
	{
		$id_branch2 = $this->input->post('id_branch');
		// $nama_branch = $this->M_assetcabangmarketing->cariNamaCabang($id_branch2);
		// $th = $nama_branch[0]['kc'];
		// echo "pre";print_r($nama_branch);exit();
		$data['oracle'] = $this->M_assetcabangmarketing->getDataOracleFilter($id_branch2);
		$this->load->view('AssetCabangMkt/Oracle/V_hasilFilter', $data);
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

		$data['draft'] = $this->M_assetcabangmarketing->getDraft();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Non-Oracle/V_draftMkt',$data);
		$this->load->view('V_Footer',$data);

	}

	public function approved()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['approved'] = $this->M_assetcabangmarketing->getApproved();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Non-Oracle/V_approvedMkt',$data);
		$this->load->view('V_Footer',$data);

	}

	public function rejected()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['rejected'] = $this->M_assetcabangmarketing->getRejected();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Non-Oracle/V_rejectedMkt',$data);
		$this->load->view('V_Footer',$data);

	}

	public function download($judul){
   		$file = "assets/upload/AssetCabang/KepalaCabang/$judul";
   		force_download($file,NULL);
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

		$jenis_asset = $this->M_assetcabangmarketing->getDataJenisAsset();
		$kategori_asset = $this->M_assetcabangmarketing->getKategoriAsset();
		$perolehan_asset = $this->M_assetcabangmarketing->getPerolehanAsset();
		$seksi_pemakai = $this->M_assetcabangmarketing->getSeksiPemakai();
		$cabang = $this->M_assetcabangmarketing->getKodeCabang();
		$hasilDraft = $this->M_assetcabangmarketing->getHasilDraft($id);
		$rencanaKebutuhan = $this->M_assetcabangmarketing->getRencanaKebutuhan($id);

		$data['ja'] = $jenis_asset;
		$data['ka'] = $kategori_asset;
		$data['pa'] = $perolehan_asset;
		$data['sp'] = $seksi_pemakai;
		$data['header'] = $hasilDraft;
		$data['cabang'] = $cabang;
		$data['line'] = $rencanaKebutuhan;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Non-Oracle/V_detailProposalMkt',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ApproveReject($id)
	{
		
		$calon_batch = $this->input->post('judulProposalNm');
		$batch_number = str_replace('.pdf', ' ', $calon_batch);
		$status = $this->input->post('btnApproveAC');
		$user = $this->session->user;
		if ($status == '4' ) {
		$judulFile = $_FILES['txfPdfAC']['name'];
		$updateMarketing = $this->M_assetcabangmarketing->UpdateApprove($id,$batch_number,$status,$judulFile,$user);

		$config['upload_path']          = './assets/upload/AssetCabang/Marketing';
		$config['allowed_types']        = 'pdf|jpg|png|JPG|PNG';
				
		$this->load->library('upload', $config);
		 
				if ( ! $this->upload->do_upload('txfPdfAC')){
					$error = array('error' => $this->upload->display_errors());
					print_r(array('error' => 'dokumen tidak berhasil diunggah' ));
					
				}else{
					$data = array('upload_data' => $this->upload->data());
					redirect('AssetCabangMarketing/Draft');
				}

		}else if ($status == '5') {

		$updateMarketing2 = $this->M_assetcabangmarketing->UpdateReject($id,$batch_number,$status,$user);
		
		}

	}

	public function finish()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['finished'] = $this->M_assetcabangmarketing->getFinished();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Non-Oracle/V_finishedMkt',$data);
		$this->load->view('V_Footer',$data);

	}

	public function setup()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['finished'] = $this->M_assetcabangmarketing->getFinished();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Setup/V_setupUmum',$data);
		$this->load->view('V_Footer',$data);

	}

	public function superuser()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$superuser = $this->M_assetcabangmarketing->getDataAllSU();
		$cabang = $this->M_assetcabangmarketing->getKodeCabang();

		$data['cbg'] = $cabang;
		$data['ss'] = $superuser;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Setup/V_superUser',$data);
		$this->load->view('V_Footer',$data);

	}

	public function showOption_1()
	{
		$data['ja'] = $this->M_assetcabangmarketing->getDataJenisAsset();
		$this->load->view('AssetCabangMkt/Setup/V_jenisAsset',$data);
	}

	public function showOption_2()
	{
		$data['ka'] = $this->M_assetcabangmarketing->getKategoriAsset();
		$this->load->view('AssetCabangMkt/Setup/V_kategoriAsset',$data);
	}

	public function showOption_3()
	{
		$data['pa'] = $this->M_assetcabangmarketing->getPerolehanAsset();
		$this->load->view('AssetCabangMkt/Setup/V_perolehanAsset',$data);
	}

	public function showOption_4()
	{
		$data['sp'] = $this->M_assetcabangmarketing->getSeksiPemakai();
		$this->load->view('AssetCabangMkt/Setup/V_seksiPemakai',$data);
	}

	public function saveSetupJA()
	{
		$cc = $this->input->post('jenis_asset');
		$this->M_assetcabangmarketing->saveJA($cc);
	}

	public function saveSetupKA()
	{
		$cc = $this->input->post('kategori_asset');
		$this->M_assetcabangmarketing->saveKA($cc);
	}

	public function saveSetupPA()
	{
		$cc = $this->input->post('perolehan_asset');
		$this->M_assetcabangmarketing->savePA($cc);
	}
	public function saveSetupSP()
	{
		$cc = $this->input->post('seksi_pemakai');
		$this->M_assetcabangmarketing->saveSP($cc);
	}

	public function deleteJA()
	{
		$id = $this->input->post('id');
		$this->M_assetcabangmarketing->deleteJA($id);
	}

	public function deleteKA()
	{
		$id = $this->input->post('id');
		$this->M_assetcabangmarketing->deleteKA($id);
	}


	public function deletePA()
	{
		$id = $this->input->post('id');
		$this->M_assetcabangmarketing->deletePA($id);
	}


	public function deleteSP()
	{
		$id = $this->input->post('id');
		$this->M_assetcabangmarketing->deleteSP($id);
	}

	public function getDataJA()
	{
		$id = $this->input->post('id');
		$dataJA = $this->M_assetcabangmarketing->getDataJA($id);
		$data['ja'] = $dataJA;
		$this->load->view('AssetCabangMkt/Setup/V_editJA', $data);
	}

	public function getDataKA()
	{
		$id = $this->input->post('id');
		$dataKA = $this->M_assetcabangmarketing->getDataKA($id);
		$data['ka'] = $dataKA;
		$this->load->view('AssetCabangMkt/Setup/V_editKA', $data);
	}

	public function getDataPA()
	{
		$id = $this->input->post('id');
		$dataPA = $this->M_assetcabangmarketing->getDataPA($id);
		$data['pa'] = $dataPA;
		$this->load->view('AssetCabangMkt/Setup/V_editPA', $data);
	}

	public function getDataSP()
	{
		$id = $this->input->post('id');
		$dataSP = $this->M_assetcabangmarketing->getDataSP($id);
		$data['sp'] = $dataSP;
		$this->load->view('AssetCabangMkt/Setup/V_editSP', $data);
	}

	public function cariUser()
	{
		$nomor_induk = $this->input->post('nomor_induk');
		$filter = $this->M_assetcabangmarketing->filterUser($nomor_induk);

		if ($filter == '0') {
		$filterUser = $this->M_assetcabangmarketing->cekSource($nomor_induk);
		echo json_encode($filterUser);
		}else if ($filter !== '0') {
		echo json_encode('0');
		}

	}

		public function cariUserKacab()
	{
		$nomor_induk = $this->input->post('nomor_induk');
		$filter = $this->M_assetcabangmarketing->filterUserKacab($nomor_induk);

		if ($filter == '0') {
		$filterUser = $this->M_assetcabangmarketing->cekSource($nomor_induk);
		echo json_encode($filterUser);
		}else if ($filter !== '0') {
		echo json_encode('0');
		}

	}

	public function saveUser()
	{
		$nomor_induk = $this->input->post('nomor_induk');
		$nama_pekerja = $this->input->post('nama_pekerja');
		$section_name = $this->input->post('section_name');
		$kode_cabang = $this->input->post('kode_cabang');

		$saveUser = $this->M_assetcabangmarketing->saveUser($nomor_induk,$nama_pekerja,$section_name,$kode_cabang);
	}

	public function saveKacab()
	{
		$nomor_induk = $this->input->post('nomor_induk');
		$nama_pekerja = $this->input->post('nama_pekerja');
		$section_name = $this->input->post('section_name');
		$kode_cabang = $this->input->post('kode_cabang');
		$status = $this->input->post('status');

		$saveUser = $this->M_assetcabangmarketing->saveKacab($nomor_induk,$nama_pekerja,$section_name,$kode_cabang,$status);
	}

	public function updateSetupJA()
	{
		$id = $this->input->post('id');
		$input = $this->input->post('jenis_asset_baru');
		$updateJA = $this->M_assetcabangmarketing->updateJA($id,$input);
	}

	public function updateSetupKA()
	{
		$id = $this->input->post('id');
		$input = $this->input->post('kategori_asset_baru');
		$updateJA = $this->M_assetcabangmarketing->updateKA($id,$input);
	}

	public function updateSetupPA()
	{
		$id = $this->input->post('id');
		$input = $this->input->post('perolehan_asset_baru');
		$updateJA = $this->M_assetcabangmarketing->updatePA($id,$input);
	}

	public function updateSetupSP()
	{
		$id = $this->input->post('id');
		$input = $this->input->post('seksi_pemakai_baru');
		$updateJA = $this->M_assetcabangmarketing->updateSP($id,$input);
	}

	public function deleteSuperUser()
	{
		$id = $this->input->post('id');
		$deleteSu = $this->M_assetcabangmarketing->deleteSU($id);
	}

		public function deleteKacab()
	{
		$id = $this->input->post('id');
		$deleteKcb = $this->M_assetcabangmarketing->deleteKcb($id);
	}

	public function openModalSU()
	{
		$id = $this->input->post('id');
		$ambil_data = $this->M_assetcabangmarketing->ambilDataSU($id);
		$cabang = $this->M_assetcabangmarketing->getKodeCabang();

		$data['cbg'] = $cabang;
		$data['su'] = $ambil_data;

		return $this->load->view('AssetCabangMkt/Setup/V_editSU', $data);
	}

	public function openModalKacab()
	{
		$id = $this->input->post('id');
		$ambil_data = $this->M_assetcabangmarketing->ambilDataKcb($id);
		$cabang = $this->M_assetcabangmarketing->getKodeCabang();

		$data['cbg'] = $cabang;
		$data['su'] = $ambil_data;

		return $this->load->view('AssetCabangMkt/Setup/V_editKacab', $data);
	}

	public function saveEditSU()
	{
		$id = $this->input->post('id');
		$ganti = $this->input->post('ganti');
		$update = $this->M_assetcabangmarketing->updateCabang($id,$ganti);
	}

	public function saveEditKacab()
	{
		$id = $this->input->post('id');
		$ganti = $this->input->post('ganti');
		$update = $this->M_assetcabangmarketing->updateKacab($id,$ganti);
	}


	public function setupKacab()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kacab = $this->M_assetcabangmarketing->getDataKacab();
		$cabang = $this->M_assetcabangmarketing->getKodeCabang();

		$data['cbg'] = $cabang;
		$data['ss'] = $kacab;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangMkt/Setup/V_setupKacab',$data);
		$this->load->view('V_Footer',$data);
	}

}
?>
