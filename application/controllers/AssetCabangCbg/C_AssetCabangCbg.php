<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_AssetCabangCbg extends CI_Controller{
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
		$this->load->model('AssetCabangCbg/M_assetcabangcabang');
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
		$this->load->view('AssetCabangCbg/V_index',$data);
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
		$cabang = $this->M_assetcabangcabang->cariNamaCabang($user);
		$kode = $cabang[0]['kc'];
		$nama_cabang = $cabang[0]['nama_cabang'];
		$capital = strtoupper($kode);

		$data['oracle'] = $this->M_assetcabangcabang->getDataOracle($capital);
		$data['cabang'] = $nama_cabang;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Oracle/V_tableList',$data);
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
		$cabang = $this->M_assetcabangcabang->cariCabang($user);
		$kode = $cabang[0]['kode_cabang'];

		// echo $kode;exit();
		$data['draft'] = $this->M_assetcabangcabang->getDraft($kode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Non-Oracle/V_draftCbg',$data);
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
		$cabang = $this->M_assetcabangcabang->cariCabang($user);
		$kode = $cabang[0]['kode_cabang'];
		$data['approved'] = $this->M_assetcabangcabang->getApproved($kode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Non-Oracle/V_approvedCbg',$data);
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
		$cabang = $this->M_assetcabangcabang->cariCabang($user);
		$kode = $cabang[0]['kode_cabang'];
		$data['rejected'] = $this->M_assetcabangcabang->getRejected($kode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Non-Oracle/V_rejectedCbg',$data);
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
		$cabang = $this->M_assetcabangcabang->cariCabang($user);
		$kode = $cabang[0]['kode_cabang'];
		$data['finished'] = $this->M_assetcabangcabang->getFinished($kode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Non-Oracle/V_finishedCbg',$data);
		$this->load->view('V_Footer',$data);

	}

	public function NewProposal()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$usr = $this->session->user;

		$jenis_asset = $this->M_assetcabangcabang->getDataJenisAsset();
		$kategori_asset = $this->M_assetcabangcabang->getKategoriAsset();
		$perolehan_asset = $this->M_assetcabangcabang->getPerolehanAsset();
		$seksi_pemakai = $this->M_assetcabangcabang->getSeksiPemakai();
		$dataPemakai = $this->M_assetcabangcabang->cekSource($usr);
		$cabang = $this->M_assetcabangcabang->getCabang();

		$data['ja'] = $jenis_asset;
		$data['ka'] = $kategori_asset;
		$data['pa'] = $perolehan_asset;
		$data['sp'] = $seksi_pemakai;
		$data['cbg'] = $cabang;
		$data['spo'] = $dataPemakai;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Non-Oracle/V_newProposalCbg',$data);
		$this->load->view('V_Footer',$data);


	}
	public function open_modal_upload()
	{
		$data['id'] = $this->input->post('proposal_id');
		return $this->load->view('AssetCabangCbg/Non-Oracle/V_upload', $data);
	}

	public function upload_berkas($id)
	{
		// echo "<pre>";print_r($_FILES);exit();
		$judulFile = $_FILES['txfBerkasAC']['name'];
		$judulFile2 = str_replace(' ', '_', $judulFile);

		$saveBerkas = $this->M_assetcabangcabang->savePictCabang($judulFile2,$id);

		$config['upload_path']          = './assets/upload/AssetCabang/AdminCabang/Berkas';
		$config['allowed_types']        = '*';
		
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('txfBerkasAC')){
			$error = array('error' => $this->upload->display_errors());
			echo "File gagal diupload, harap ulangi atau hubungi ICT Marfin!";
		}else{
			$data = array('upload_data' => $this->upload->data());
			redirect('AssetCabang/Draft');
			// echo "<script language=\"javascript\">alert('test');</script>";
		}
	}

	public function generatePdf()
	{

		// echo "<pre>";print_r($_POST);exit();
		$data['kategori_asset'] = $this->input->post('slcKategoriAst');
		$data['jenis_asset'] = $this->input->post('slcJenisAst');
		$data['perolehan_asset'] = $this->input->post('slcPerolehanAst');
		$data['pemakai'] = $this->input->post('slcPemakai');
		// echo $data['pemakai'];exit();
		// $bc = $this->input->post('slcAsalCabang');
		$usr = $this->session->user;
		$cabang = $this->M_assetcabangcabang->cariCabang($usr);
		$bc = $cabang[0]['kode_cabang'];
		$plain = $this->M_assetcabangcabang->getBranchesCounted($bc);
		$counted = $plain + 1;

		if ($counted < '10') {
		$new_counted = $bc.'-00000'.$counted; 
		}else if ($counted >= '10' && $counted < '100') {
		$new_counted = $bc.'-0000'.$counted; 	
		}else if ($counted >= '100' && $counted < '1000') {
		$new_counted = $bc.'-000'.$counted;	
		}else if ($counted >= '1000' && $counted < '10000') {
		$new_counted = $bc.'-00'.$counted;		
		}else if ($counted >= '10000' && $counted < '100000') {
		$new_counted = $bc.'-0'.$counted;
		}else if ($counted >= '100000' && $counted < '1000000') {
		$new_counted = $bc.'-'.$counted;
		}else {
		$new_counted = '';
		}	

		$data['code'] = array($new_counted);
		$data['alasan'] = $this->input->post('txaAlasan');
		$data['kodebarang'] = $this->input->post('txtKodeBarangAC');
		$data['namaasset'] = $this->input->post('slcNamaAsset');
		$data['spesifikasi_asset'] = $this->input->post('txtSpesifikasiAssetAC');
		$data['jumlah'] = $this->input->post('txtJumlahAC');
		$data['umur_teknis'] = $this->input->post('txtUmurTeknisAC');


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('utf-8',[214, 330],0,'',10,10,10,10,10,10,'P');
		$filename = 'Draft Proposal Pengadaan Asset.pdf';

		$head = $this->load->view('AssetCabangCbg/Non-Oracle/V_Header', $data, TRUE);
		$line = $this->load->view('AssetCabangCbg/Non-Oracle/V_Pdf', $data, TRUE);
		$foot = $this->load->view('AssetCabangCbg/Non-Oracle/V_Footer', $data, TRUE);

		$pdf->SetHTMLHeader($head);
		$pdf->SetHTMLFooter($foot);
		$pdf->WriteHTML($line, 2);
		$pdf->Output($filename, 'I');
    	// $pdf->Output('./assets/upload/AssetCabang/'.$filename, 'F'); //I
	}

	public function generatePdfEdit($id)
	{

		// echo "<pre>";print_r($_POST);exit();
		$data['kategori_asset'] = $this->input->post('slcKategoriAst');
		$data['jenis_asset'] = $this->input->post('slcJenisAst');
		$data['perolehan_asset'] = $this->input->post('slcPerolehanAst');
		$data['pemakai'] = $this->input->post('slcPemakai');
		// echo $data['pemakai'];exit();
		// $bc = $this->input->post('slcAsalCabang');
		$usr = $this->session->user;
		$cabang = $this->M_assetcabangcabang->cariCabang($usr);
		$bc = $cabang[0]['kode_cabang'];
		$plain = $this->M_assetcabangcabang->getBranchesCounted($bc);
		$counted = $plain + 1;

		if ($counted < '10') {
		$new_counted = $bc.'-00000'.$counted; 
		}else if ($counted >= '10' && $counted < '100') {
		$new_counted = $bc.'-0000'.$counted; 	
		}else if ($counted >= '100' && $counted < '1000') {
		$new_counted = $bc.'-000'.$counted;	
		}else if ($counted >= '1000' && $counted < '10000') {
		$new_counted = $bc.'-00'.$counted;		
		}else if ($counted >= '10000' && $counted < '100000') {
		$new_counted = $bc.'-0'.$counted;
		}else if ($counted >= '100000' && $counted < '1000000') {
		$new_counted = $bc.'-'.$counted;
		}else {
		$new_counted = '';
		}	

		$data['code'] = array($this->input->post('batch_number_name'));
		$data['alasan'] = $this->input->post('txaAlasan');
		$data['kodebarang'] = $this->input->post('txtKodeBarangAC');
		$data['namaasset'] = $this->input->post('slcNamaAsset');
		$data['spesifikasi_asset'] = $this->input->post('txtSpesifikasiAssetAC');
		$data['jumlah'] = $this->input->post('txtJumlahAC');
		$data['umur_teknis'] = $this->input->post('txtUmurTeknisAC');


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('utf-8',[214, 330],0,'',10,10,10,10,10,10,'P');
		$filename = 'Edit PPA '.$id.'.pdf';

		$head = $this->load->view('AssetCabangCbg/Non-Oracle/V_Header', $data, TRUE);
		$line = $this->load->view('AssetCabangCbg/Non-Oracle/V_Pdf', $data, TRUE);
		$foot = $this->load->view('AssetCabangCbg/Non-Oracle/V_Footer', $data, TRUE);

		$pdf->SetHTMLHeader($head);
		$pdf->SetHTMLFooter($foot);
		$pdf->WriteHTML($line, 2);
		$pdf->Output($filename, 'I');
    	// $pdf->Output('./assets/upload/AssetCabang/'.$filename, 'F'); //I
	}


	public function submitProposal()
	{
		$kategori_asset = $this->input->post('kategori_asset');
		$jenis_asset = NULL; //diisi oleh marketing
		$perolehan_asset = $this->input->post('perolehan_asset');
		$seksi_pemakai = $this->input->post('seksi_pemakai');
		$alasan = $this->input->post('alasan');
		$usr = $this->session->user;
		$cabang = $this->M_assetcabangcabang->cariCabang($usr);
		$bc = $cabang[0]['kode_cabang'];
		//array bellow
		$kode_barang = $this->input->post('kode_barang');
		$nama_asset = $this->input->post('nama_asset');
		$spesifikasi_asset = $this->input->post('spesifikasi_asset');
		$jumlah = $this->input->post('jumlah');
		$umur_teknis = $this->input->post('umur_teknis');

		$saveHeader = $this->M_assetcabangcabang->saveProposalCabang($kategori_asset,$jenis_asset,$perolehan_asset,$seksi_pemakai,$alasan,$usr);
		$id_header = $saveHeader[0]['id_proposal'];
		$date = strtoupper(date('dMY'));

		$plain = $this->M_assetcabangcabang->getBranchesCounted($bc);
		$counted = $plain + 1;

		if ($counted < '10') {
		$new_counted = $bc.'-00000'.$counted; 
		}else if ($counted >= '10' && $counted < '100') {
		$new_counted = $bc.'-0000'.$counted; 	
		}else if ($counted >= '100' && $counted < '1000') {
		$new_counted = $bc.'-000'.$counted;	
		}else if ($counted >= '1000' && $counted < '10000') {
		$new_counted = $bc.'-00'.$counted;		
		}else if ($counted >= '10000' && $counted < '100000') {
		$new_counted = $bc.'-0'.$counted;
		}else if ($counted >= '100000' && $counted < '1000000') {
		$new_counted = $bc.'-'.$counted;
		}else {
		$new_counted = '';
		}	
		
		$judulFile = $new_counted.".pdf";
		$updateBatchandJudul = $this->M_assetcabangcabang->updateBatch($id_header,$new_counted,$judulFile,$bc,$usr);
		foreach ($kode_barang as $key => $value) {
		$saveLines = $this->M_assetcabangcabang->saveLineProposal($value,$nama_asset[$key], $spesifikasi_asset[$key], $jumlah[$key], $umur_teknis[$key],$id_header);
		}

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
		$data['code'] = array($new_counted);


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('utf-8',[214, 330],0,'',10,10,10,10,10,10,'P');
		$filename = $new_counted.".pdf";

		$head = $this->load->view('AssetCabangCbg/Non-Oracle/V_Header', $data, TRUE);
		$line = $this->load->view('AssetCabangCbg/Non-Oracle/V_Pdf', $data, TRUE);
		$foot = $this->load->view('AssetCabangCbg/Non-Oracle/V_Footer', $data, TRUE);

		$pdf->SetHTMLHeader($head);
		$pdf->SetHTMLFooter($foot);
		$pdf->WriteHTML($line, 2);
		// $pdf->Output($filename, 'I');
		$pdf->Output('./assets/upload/AssetCabang/AdminCabang/'.$filename, 'F'); //I

	}

	public function deleteDraft()
	{
		$id_proposal = $this->input->post('id_proposal');
		$deleteProposal = $this->M_assetcabangcabang->delete($id_proposal);
	}

	public function cariNamaAsset()
	{
		$supply = $this->input->GET('term');
		$supplier = strtoupper($supply);
		$query = $this->M_assetcabangcabang->cariKodeBarang($supplier);
		echo json_encode($query);
	}

	public function cariKodeBarang()
	{
		$param = $this->input->post('code_bar');
		$cariNamaAsset = $this->M_assetcabangcabang->getNamaAsset($param);
		echo json_encode($cariNamaAsset);
	}

	public function downloadMkt($judul){
   		$file = "assets/upload/AssetCabang/Marketing/$judul";
   		force_download($file,NULL);
	}

	public function download($judul){
   		$file = "assets/upload/AssetCabang/AdminCabang/$judul";
   		force_download($file,NULL);
	}

	public function checkbyKacab()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user = $this->session->user;
		$cabang = $this->M_assetcabangcabang->cariCabang($user);
		$kode = $cabang[0]['kode_cabang'];

		// echo $kode;exit();
		$data['draft'] = $this->M_assetcabangcabang->getCheckKacab($kode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Non-Oracle/V_checkedbyKacab',$data);
		$this->load->view('V_Footer',$data);
	}

	public function editForward($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$usr = $this->session->user;

		$jenis_asset = $this->M_assetcabangcabang->getDataJenisAsset();
		$kategori_asset = $this->M_assetcabangcabang->getKategoriAsset();
		$perolehan_asset = $this->M_assetcabangcabang->getPerolehanAsset();
		$seksi_pemakai = $this->M_assetcabangcabang->getSeksiPemakai();
		$cabang = $this->M_assetcabangcabang->getKodeCabang();
		$hasilDraft = $this->M_assetcabangcabang->getHasilDraft($id);
		$rencanaKebutuhan = $this->M_assetcabangcabang->getRencanaKebutuhan($id);
		$dataPemakai = $this->M_assetcabangcabang->cekSource($usr);

		$data['spo'] = $dataPemakai;
		$data['ja'] = $jenis_asset;
		$data['ka'] = $kategori_asset;
		$data['pa'] = $perolehan_asset;
		$data['sp'] = $seksi_pemakai;
		$data['header'] = $hasilDraft;
		$data['cabang'] = $cabang;
		$data['line'] = $rencanaKebutuhan;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AssetCabangCbg/Non-Oracle/V_editProposal',$data);
		$this->load->view('V_Footer',$data);
	}

	public function submitEditProposal()

	{
	// echo "<pre>";print_r($_POST);exit();
		$id_proposal = $this->input->post('id_proposal');
		$batch_number = $this->input->post('batch_number');
		$kategori_asset = $this->input->post('kategori_asset');
		$jenis_asset = NULL; //diisi oleh marketing
		$perolehan_asset = $this->input->post('perolehan_asset');
		$seksi_pemakai = $this->input->post('seksi_pemakai');
		$alasan = $this->input->post('alasan');
		$usr = $this->session->user;
		$cabang = $this->M_assetcabangcabang->cariCabang($usr);
		$bc = $cabang[0]['kode_cabang'];
		//array bellow
		$kode_barang = $this->input->post('kode_barang');
		$nama_asset = $this->input->post('nama_asset');
		$spesifikasi_asset = $this->input->post('spesifikasi_asset');
		$jumlah = $this->input->post('jumlah');
		$umur_teknis = $this->input->post('umur_teknis');

		$saveHeader = $this->M_assetcabangcabang->updateProposalCabang($kategori_asset,$jenis_asset,$perolehan_asset,$seksi_pemakai,$alasan,$usr,$id_proposal);
		$id_header = $saveHeader[0]['id_proposal'];
		$date = strtoupper(date('dMY'));

		$judulFile = $batch_number.".pdf";
		$resetLine = $this->M_assetcabangcabang->resetLine($id_proposal);
		$logActivity = $this->M_assetcabangcabang->logActivity($id_proposal,$usr,$batch_number);
		foreach ($kode_barang as $key => $value) {
		$saveLines = $this->M_assetcabangcabang->saveLineProposal($value,$nama_asset[$key], $spesifikasi_asset[$key], $jumlah[$key], $umur_teknis[$key],$id_proposal);
		}

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
		$data['code'] = array($new_counted);


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		
		$pdf = new mPDF('utf-8',[214, 330],0,'',10,10,10,10,10,10,'P');
		$filename = $batch_number.".pdf";

		$head = $this->load->view('AssetCabangCbg/Non-Oracle/V_Header', $data, TRUE);
		$line = $this->load->view('AssetCabangCbg/Non-Oracle/V_Pdf', $data, TRUE);
		$foot = $this->load->view('AssetCabangCbg/Non-Oracle/V_Footer', $data, TRUE);

		$pdf->SetHTMLHeader($head);
		$pdf->SetHTMLFooter($foot);
		$pdf->WriteHTML($line, 2);
		$pdf->Output('./assets/upload/AssetCabang/AdminCabang/'.$filename, 'F'); //I

	}
}
?>
