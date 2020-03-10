<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_AssetCabangKcb extends CI_Controller{
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
		$this->load->model('AssetCabangKcb/M_assetcabangkacab');
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
		$this->load->view('AssetCabangKcb/V_Index',$data);
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

		$user = $this->session->user;
		$cabang = $this->M_assetcabangkacab->cariNamaCabang($user);
		$kode = $cabang[0]['kc'];
		$nama_cabang = $cabang[0]['nama_cabang'];
		$capital = strtoupper($kode);

		// echo $capital;exit();

		$data['oracle'] = $this->M_assetcabangkacab->getDataOracle($capital);
		$data['cabang'] = $nama_cabang;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangKcb/Oracle/V_tableList', $data);
		$this->load->view('V_Footer',$data);
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

		$user = $this->session->user;
		$cabang = $this->M_assetcabangkacab->cariNamaCabang($user);
		$kode = $cabang[0]['kode_cabang'];
		$capital = strtoupper($kode);

		// echo $capital;exit();

		$data['draft'] = $this->M_assetcabangkacab->getDraft($capital);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangKcb/Non-Oracle/V_draftKcb',$data);
		$this->load->view('V_Footer',$data);

	}


	public function downloadMkt($judul){
   		$file = "assets/upload/AssetCabang/Marketing/$judul";
   		force_download($file,NULL);
	}

	public function downloadKacab($judul)
	{
   		$file = "assets/upload/AssetCabang/KepalaCabang/$judul";
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

		$jenis_asset = $this->M_assetcabangkacab->getDataJenisAsset();
		$kategori_asset = $this->M_assetcabangkacab->getKategoriAsset();
		$perolehan_asset = $this->M_assetcabangkacab->getPerolehanAsset();
		$seksi_pemakai = $this->M_assetcabangkacab->getSeksiPemakai();
		$cabang = $this->M_assetcabangkacab->getKodeCabang();
		$hasilDraft = $this->M_assetcabangkacab->getHasilDraft($id);
		$rencanaKebutuhan = $this->M_assetcabangkacab->getRencanaKebutuhan($id);

		$data['ja'] = $jenis_asset;
		$data['ka'] = $kategori_asset;
		$data['pa'] = $perolehan_asset;
		$data['sp'] = $seksi_pemakai;
		$data['header'] = $hasilDraft;
		$data['cabang'] = $cabang;
		$data['line'] = $rencanaKebutuhan;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangKcb/Non-Oracle/V_detailProposalKcb',$data);
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

		$user = $this->session->user;
		$cabang = $this->M_assetcabangkacab->cariNamaCabang($user);
		$kode = $cabang[0]['kode_cabang'];
		$capital = strtoupper($kode);

		$data['approved'] = $this->M_assetcabangkacab->getApproved($capital);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangKcb/Non-Oracle/V_approvedKcb',$data);
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

		$jenis_asset = $this->M_assetcabangkacab->getDataJenisAsset();
		$kategori_asset = $this->M_assetcabangkacab->getKategoriAsset();
		$perolehan_asset = $this->M_assetcabangkacab->getPerolehanAsset();
		$seksi_pemakai = $this->M_assetcabangkacab->getSeksiPemakai();
		$cabang = $this->M_assetcabangkacab->getKodeCabang();
		$hasilDraft = $this->M_assetcabangkacab->getHasilDraft($id);
		$rencanaKebutuhan = $this->M_assetcabangkacab->getRencanaKebutuhan($id);

		$data['ja'] = $jenis_asset;
		$data['ka'] = $kategori_asset;
		$data['pa'] = $perolehan_asset;
		$data['sp'] = $seksi_pemakai;
		$data['header'] = $hasilDraft;
		$data['cabang'] = $cabang;
		$data['line'] = $rencanaKebutuhan;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangKcb/Non-Oracle/V_KonfirmasiProposalKcb',$data);
		$this->load->view('V_Footer',$data);
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

		$user = $this->session->user;
		$cabang = $this->M_assetcabangkacab->cariNamaCabang($user);
		$kode = $cabang[0]['kode_cabang'];
		$capital = strtoupper($kode);

		$data['finished'] = $this->M_assetcabangkacab->getFinished($capital);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangKcb/Non-Oracle/V_finishedKcb',$data);
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

		$user = $this->session->user;
		$cabang = $this->M_assetcabangkacab->cariNamaCabang($user);
		$kode = $cabang[0]['kode_cabang'];
		$capital = strtoupper($kode);

		$data['rejected'] = $this->M_assetcabangkacab->getRejected($capital);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangKcb/Non-Oracle/V_rejectedKcb',$data);
		$this->load->view('V_Footer',$data);

	}

	public function submitProposal()
	{

		$usr = $this->session->user;
		$kacab = $this->M_assetcabangkacab->nama_kacab($usr);
		$nama_kacab = $kacab[0]['nama_kacab'];
		$id_proposal = $this->input->post('id');
		//update tabel proposal
		$update = $this->M_assetcabangkacab->approveKacab($usr,$id_proposal);
		//update log activity
		$batch_number = $this->input->post('batch_number');
		$log_kacab = $this->M_assetcabangkacab->logKacab($usr,$id_proposal,$batch_number);
		//judul
		$judulProposal = $this->input->post('judul_proposal');
		$now = date('d/m/Y H:i:s');

		$data['kategori_asset'] = $this->input->post('kategori_asset');
		$data['jenis_asset'] = $this->input->post('jenis_asset');
		$data['perolehan_asset'] = $this->input->post('perolehan_asset');
		$data['pemakai'] = $this->input->post('seksi_pemakai');
		$data['alasan'] = $this->input->post('alasan');
		$data['kodebarang'] = $this->input->post('kode_barang');
		$data['namaasset'] = $this->input->post('nama_asset');
		$data['spesifikasi_asset'] = $this->input->post('spesifikasi_asset');
		$data['jumlah'] = $this->input->post('jumlah');
		$data['umur_teknis'] = $this->input->post('umur_teknis');
		$data['code'] = array($batch_number);
		$data['tanggal'] = array($now);
		$data['kacab'] = array($nama_kacab);

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('utf-8',[214, 330],0,'',10,10,10,10,10,10,'P');
		$filename = $judulProposal;

		$head = $this->load->view('AssetCabangKcb/Non-Oracle/V_Header', $data, TRUE);
		$line = $this->load->view('AssetCabangKcb/Non-Oracle/V_Pdf', $data, TRUE);
		$foot = $this->load->view('AssetCabangKcb/Non-Oracle/V_Footer', $data, TRUE);

		$pdf->SetHTMLHeader($head);
		$pdf->SetHTMLFooter($foot);
		$pdf->WriteHTML($line, 2);
		// $pdf->Output($filename, 'I');
		$pdf->Output('./assets/upload/AssetCabang/KepalaCabang/'.$filename, 'F'); //I
	}

	public function rejectProposal()
	{
		$id = $this->input->post('id');
		$batch_number = $this->input->post('batch_number');
		$status = $this->input->post('status');
		$feedback = $this->input->post('feedback');
		$usr = $this->sesion->user;

		$update = $this->M_assetcabangkacab->rejectKacab($usr,$id,$status,$feedback);
		$log_kacab = $this->M_assetcabangkacab->logRejectKacab($usr,$id,$batch_number,$status);
	}

	public function OpenMdlReject()
	{
		$id_proposal = $this->input->post('proposal_id');
		$data['mdl'] = $this->M_assetcabangkacab->getDataMdlReject($id_proposal);

		$this->load->view('AssetCabangKcb/Non-Oracle/V_mdlRejected',$data);
	}

	

}
?>
