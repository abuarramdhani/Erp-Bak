<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_branchitem extends CI_Controller {

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
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('BarangCabang/M_branchitem');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function checkSession()
	{
		if($this->session->is_logged){		
		}else{
			redirect();
		}
	}

	//------------------------show the dashboard-----------------------------
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
		$this->load->view('BarangCabang/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function InputBarang($id=null)
	{
		if($id!=null){
			$data['cek'] = $this->M_branchitem->cekcekan($id);
		}else{
			$data['cek'] = 0;
		}

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$lokasi=$this->input->post("cabang");
		$data['organisasi'] = $this->M_branchitem->IO($lokasi);
		$data['regen'] = $this->regen();

		$fppb = $data['regen'];
		$data['tampil'] = $this->M_branchitem->TampilTabelPemindahan($fppb);

		$lokasi=$this->input->post("cabang");
		$organisasi=$this->input->post("organisasi");
		$data['barang'] = $this->M_branchitem->Barang($organisasi);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Pemindahan/V_InputBarang');
		$this->load->view('V_Footer',$data);
	}

	public function EditPemindahan($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['edit'] = $this->M_branchitem->getPemindahanEdit($id);
		$data['no_fppb'] = $data['edit'][0]['no_fppb'];
		$organisasi = $data['edit'][0]['organisasi'];
		$data['id_ku'] = $id;
		$data['barang'] = $this->M_branchitem->Barang($organisasi);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Pemindahan/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function EditPenanganan($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['edit'] = $this->M_branchitem->getPenangananEdit($id);
		$data['no_fppbb'] = $data['edit'][0]['no_fppbb'];
		$data['id_ku'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Penanganan/V_Edit');
		$this->load->view('V_Footer',$data);
	}

	public function DeletePemindahanLine($id)
	{
		$data= $this->M_branchitem->DeletePemindahanLine($id);
		redirect(base_url('BranchItem/PemindahanBarang/Input/'.$no));
	}

	public function DeletePenangananLine($id)
	{
		$data= $this->M_branchitem->DeletePenangananLine($id);
		redirect(base_url('BranchItem/PenangananBarang/Input/'
			// .$no
		));
	}

	public function Viewpemindahan()
	{
		$tanggalan1=$this->input->post("tanggalan1");
		$tanggalan2=$this->input->post("tanggalan2");
		$organisasi = $this->input->post("organisasi");
		$gudang_asal = $this->input->post("gudang_asal");
		$gudang_tujuan = $this->input->post("gudang_tujuan");

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard'; 
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['organisasi'] = $this->M_branchitem->ORG_ALL();
		$data['gdgasal'] = $this->M_branchitem->subInvView($organisasi);

		$data['LoadViewPemindahan'] = $this->M_branchitem->getPemindahanView($tanggalan1,$tanggalan2,$organisasi,$gudang_asal,$gudang_tujuan);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Pemindahan/V_View');
		$this->load->view('V_Footer',$data);
	}

	public function searchTanggalPemindahan()
	{
		$tanggalan1=$this->input->post('tanggalan1');
		$tanggalan2=$this->input->post('tanggalan2');
		$organisasi = $this->input->post("organisasi");
		$gudang_asal = $this->input->post("gudang_asal");
		$gudang_tujuan = $this->input->post("gudang_tujuan");

		$data['tanggalan1'] = $tanggalan1 ;
		$data['tanggalan2'] = $tanggalan2 ;
		$data['organisasi'] = $organisasi;
		$data['gudang_asal'] = $gudang_asal;
		$data['gudang_tujuan'] = $gudang_tujuan;

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard'; 
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['organisasi'] = $this->M_branchitem->ORG_ALL();
		$data['gdgasal'] = $this->M_branchitem->subInvView($organisasi);

		$data['LoadViewPemindahan'] = $this->M_branchitem->getPemindahanView($tanggalan1,$tanggalan2,$organisasi,$gudang_asal,$gudang_tujuan);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Pemindahan/V_View', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Viewdetailpemindahan($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['DetailPemindahan'] = $this->M_branchitem->getDetailPemindahan($id);

		// $data['gudang_tujuan'] = $gudang_tujuan;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Pemindahan/V_ViewDetail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputPenanganan($id=null)
	{
		if($id!=null){
			$data['cek'] = $this->M_branchitem->cekFPPBB($id);
		}else{
			$data['cek'] = 0;
		}

		$cabang = $this->input->post['cabang'];

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['organisasi'] = $this->M_branchitem->ORG();

		$data['fppb'] = $this->M_branchitem->getFPPBCabang($cabang);

		if($id!=null){
			$data['regenPenanganan'] = $id;
		}else{
			$data['regenPenanganan'] = $this->regenPenanganan();
		}

	
		$data['tampil'] = $this->M_branchitem->TampilTabelPenanganan($data['regenPenanganan']);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Penanganan/V_Input');
		$this->load->view('V_Footer',$data);
	}

	public function AddPenanganan($data2 = false)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['cabang'] = $data2['cabang'];
		$data['no_fppbb'] = $this->input->post("no_fppbb");
		$data['fppb'] = $this->M_branchitem->getFPPBCabang($data['cabang']);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Penanganan/V_AddInput');
		$this->load->view('V_Footer',$data);
	}

	public function Viewpenanganan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$tanggalan1=$this->input->post('tanggalan1');
		$tanggalan2=$this->input->post('tanggalan2');
		$organisasi = $this->input->post("organisasi");
		$cabang = $this->input->post("cabang");

		$data['tanggalan1'] = $tanggalan1 ;
		$data['tanggalan2'] = $tanggalan2 ;
		$data['cabang'] = $cabang;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['organisasi'] = $this->M_branchitem->ORG();
		$data['gdgasal'] = $this->M_branchitem->subInvView($organisasi);

		$data['PenangananHeader'] = $this->M_branchitem->PenangananHeader($tanggalan1,$tanggalan2,$cabang);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Penanganan/V_View');
		$this->load->view('V_Footer',$data);
	}

	public function SearchPenanganan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$tanggalan1=$this->input->post('tanggalan1');
		$tanggalan2=$this->input->post('tanggalan2');
		$cabang = $this->input->post("cabang");

		$data['tanggalan1'] = $tanggalan1 ;
		$data['tanggalan2'] = $tanggalan2 ;
		$data['cabang'] = $cabang;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['organisasi'] = $this->M_branchitem->ORG();

		$data['PenangananHeader'] = $this->M_branchitem->PenangananHeader($tanggalan1,$tanggalan2,$cabang);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Penanganan/V_View');
		$this->load->view('V_Footer',$data);
	}

	public function ViewDetailPenanganan($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['HeaderPenanganan'] = $this->M_branchitem->HeaderPenanganan($id);
		$data['data_penanganan'] = $this->M_branchitem->getDetailPenanganan($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangCabang/Penanganan/V_viewdetail', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getOrg()
	{
		$cb = $this->input->post('cabang');
		$data = $this->M_branchitem->IO($cb);
		echo '<option></option>';
		foreach ($data as $organisasi) {
			echo '<option>'. $organisasi['ORGANIZATION_CODE'] .'</option>';
		}
	}

	public function getOrgAll()
	{
		$data = $this->M_branchitem->ORG_ALL();
		echo '<option></option>';
		foreach ($data as $organisasi) {
			echo '<option>'. $organisasi['ORGANIZATION_CODE'] .'</option>';
		}
	}

	public function getCode()
	{
		$organisasi = $this->input->post('organisasi');
		$data = $this->M_branchitem->Barang($organisasi);
		echo $data[0]['SEGMENT1'];
	}

	public function getDesk()
	{
		$kode = $this->input->post('kode');
		$data = $this->M_branchitem->Deskripsi($kode);
		echo $data[0]['DESCRIPTION'];
	}

	public function get_val_penanganan()
	{
		$kode = $this->input->post('no_fppb');
		$data = $this->M_branchitem->NoFppbAll($kode);

		echo json_encode($data);
	}

	public function get_preview(){
		$no_fppb = $this->input->post('no_fppb');
		$no_fppbb = $this->input->post('fppbb');
		$barang = $this->input->post('kode_bar');
		
		$data = $this->M_branchitem->getUsulan($no_fppb,$no_fppbb,$barang);
		echo json_encode($data);
	}

	public function getGudang()
	{
		$cb = $this->input->post('cabang');
		$organisasi = $this->input->post('organisasi');
		$data = $this->M_branchitem->subInv($cb,$organisasi);
		echo '<option></option>';
		foreach ($data as $gudang) {
			echo '<option>'. $gudang['SECONDARY_INVENTORY_NAME'] .'</option>';
		}
	}

	public function getGudangView()
	{
		$organisasi = $this->input->post('organisasi');
		$data = $this->M_branchitem->subInvView($organisasi);
		echo '<option></option>';
		foreach ($data as $gudang) {
			echo '<option>'. $gudang['SECONDARY_INVENTORY_NAME'] .'</option>';
		}
	}

	public function regen()
	{
		$back = 1;

		check:
		$depan = "B";
		$tengah = date('ymd');
		$nomor_urut = $depan.$tengah.str_pad($back, 2, "0", STR_PAD_LEFT);
		$check = $this->M_branchitem->cekNomor($nomor_urut);
		if (!empty($check)) {
		$back++;
		GOTO check;
		}
		return $nomor_urut;		
	}

	public function regenPenanganan()
	{
		$back = 1;

		check:
		$depan = "PP";
		$tengah = date('ymd');
		$nomor_urut = $depan.$tengah.str_pad($back, 2, "0", STR_PAD_LEFT);
		$check = $this->M_branchitem->cekFPPBB($nomor_urut);
		if (!empty($check)) {
		$back++;
		GOTO check;
		}
		return $nomor_urut;		
	}

	public function insertPemindahanHeader()
	{
		$no=$this->input->post("no_fppb");
		$tanggal=$this->input->post("tanggal");
		$cabang=$this->input->post("cabang");
		$organisasi=$this->input->post("organisasi");
		$asal=$this->input->post("gudang_asal");
		$tujuan=$this->input->post("gudang_tujuan");
		
		$data = $this->M_branchitem->InsertPemindahanHeader($no,$tanggal,$cabang,$organisasi,$asal,$tujuan);
	}

	public function FlaggingPemindahanHeader()
	{
		$no=$this->input->post("no_fppb");
		
		$data = $this->M_branchitem->FlaggingPemindahanHeader($no);
		redirect(base_url('BranchItem/PemindahanBarang/Input'));
	}

	public function FlaggingPenangananHeader()
	{
		$no=$this->input->post("no_fppb");
		
		$fppbb = $this->input->post("no_fppbb");
		$tanggal = $this->input->post("textDate");
		$cabang = $this->input->post("cabang");
		
		$data2['no_fppbb'] = $fppbb;
		$data2['cabang'] = $cabang;

		$cek =  $this->M_branchitem->cekFPPBB($fppbb);

		if(empty($cek)){
			$data = $this->M_branchitem->InsertPenangananHeader($fppbb,$tanggal,$cabang);
		}

		$data = $this->M_branchitem->FlaggingPenangananHeader($fppbb);
		
		$this->AddPenanganan($data2);
	}

	public function UpdatePemindahanLine($id)
	{	
		$id			= $this->input->post("textId");
		$no 		= $this->input->post("no_fppb");
		$gambar 	= $this->M_branchitem->gambar($id);


		$isGambar 	= $_FILES['upload_form']['name'];
		if(!empty($isGambar)){
			if (!empty($gambar)) {
				unlink('./assets/upload/BranchItem/'.$gambar[0]['gambar']);
			};
		        $config['upload_path']          = './assets/upload/BranchItem/';
                $config['allowed_types']        = 'jpg|png|jpeg';
                $config['file_name']        	= $no.'.'.substr($_FILES['upload_form']['type'], 6);

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('upload_form'))
                {
                        $error = array('error' 		=> $this->upload->display_errors());

                        // print_r($error) ;
                        // exit();
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                }
                $jumlah		= $this->input->post("jumlah");
				$gambar		= $config['file_name'];
				$kategori	= $this->input->post("kategori_masalah");
				$detail		= $this->input->post("detail_masalah");
				$deskripsi	= $this->input->post("deskripsi_barang");
				$kode		= $this->input->post("kode_barang");
				
				$data 		= $this->M_branchitem->UpdatePemindahanLine($no,$kode,$jumlah,$gambar,$kategori,$detail,$deskripsi,$id);
            }else{

                $jumlah		= $this->input->post("jumlah");
				$kategori	= $this->input->post("kategori_masalah");
				$detail		= $this->input->post("detail_masalah");
				$deskripsi	= $this->input->post("deskripsi_barang");
				$kode		= $this->input->post("kode_barang");


			$data 		= $this->M_branchitem->UpdatePemindahanLineWithoutPict($no,$kode,$jumlah,$kategori,$detail,$deskripsi,$id);
           }
		
		redirect(base_url('BranchItem/PemindahanBarang/Input/'.$no));
	}

	public function UpdatePenangananLine($id)
	{	
		$id			= $this->input->post("id");
		$no 		= $this->input->post("no_fppb");
		$usulan 	= $this->input->post("usulan_kacab");
		$nono 		= $this->input->post("no_fppbb");
		$preview 	= $this->input->post("preview");
		$kode		= $this->input->post("kode_barang");
		// exit();
		$data 		= $this->M_branchitem->UpdatePenangananLine($id,$no,$usulan,$nono,$preview,$kode);
		
		redirect(base_url('BranchItem/PenangananBarang/Input/'.$nono));
	}

	public function insertPemindahanLine()
	{
		$no = $this->input->post('no_fppb');
		$config['upload_path']          = './assets/upload/BranchItem/';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $name = $_FILES['upload_form']['name'];
      	$config['file_name'] = $name;

        $this->load->library('upload', $config);

         	if ( ! $this->upload->do_upload('upload_form'))
         	{
               $error = array('error' => $this->upload->display_errors());
               print_r($error) ;
               exit();
         	}
          	else
          	{
         	    $data = array('upload_data' => $this->upload->data());
        	}

		$kode=$this->input->post("code"); 
		$jumlah=$this->input->post("jumlah");
		$gambar= $this->input->post("upload_form");
		$kategori=$this->input->post("kategori_masalah"); 
		$detail=$this->input->post("detail_masalah"); 
		$deskripsi=$this->input->post("deskripsi");
	
		$data = $this->M_branchitem->InsertPemindahanLine($no,$kode,$jumlah,$name,$kategori,$detail,$deskripsi);
		redirect(base_url('BranchItem/PemindahanBarang/Input/'.$no));
	}

	public function insertPenangananHeader()
	{
		$no=$this->input->post("no_fppbb");
		$tanggal=$this->input->post("textDate");
		$cabang=$this->input->post("cabang");
		
		$data2['no_fppbb'] = $no;
		$data2['cabang'] = $cabang;

		$data = $this->M_branchitem->InsertPenangananHeader($no,$tanggal,$cabang);
		$this->AddPenanganan($data2);
	}

	public function insertPenangananLine()
	{
		$fppb=$this->input->post("no_fppb");
		$preview=$this->input->post("preview");
		$usulan=$this->input->post("usulan_kacab");
		$fppbb=$this->input->post("no_fppbb");
		$kode=$this->input->post("kode_barang");
		
		$data2['no_fppbb'] = $fppbb;
		$data = $this->M_branchitem->InsertPenangananLine($fppb,$usulan,$fppbb,$preview,$kode);

		echo json_encode($data2);
	}
}