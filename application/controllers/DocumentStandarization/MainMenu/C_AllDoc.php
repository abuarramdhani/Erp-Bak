<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_AllDoc extends CI_Controller
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
		$this->load->library('upload');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->load->library('upload');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();

		define('direktoriUpload', './assets/upload/PengembanganSistem/StandarisasiDokumen/');
	}
	
	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}
	/* LIST DATA */
	public function index()
	{
		// $user = $this->session->username;

		// $user_id = $this->session->userid;

		// // echo '<pre>';
		// // print_r($this->session);
		// // echo '</pre>';
		// // echo strlen($this->session->user);
		// // exit();

		// $data['Title'] = 'All Document';
		// $data['Menu'] = 'Upload Dokumen';
		// $data['SubMenuOne'] = 'All Document';
		// $data['SubMenuTwo'] = '';

		// $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		// $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		// $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $user_now  						= $this->session->user;

		// $data['AllDocument'] 				= $this->M_general->ambilSemuaDokumen();
		// $data['jumlahNotifikasiBaru']		= $this->M_general->ambilJumlahNotifikasiBaru($user_now);
		// $data['ambilNotifikasiBaru'] 		= $this->M_general->ambilSemuaNotifikasiBaru($user_now);


		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		// $this->load->view('DocumentStandarization/AllDoc/V_index_2', $data);
		// $this->load->view('V_Footer',$data);

		$this->BP();
	}	

	public function BP()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'All Document';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'All Document';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['listBP'] 		= 	$this->M_general->ambilDaftarBP();
		$data['jumlahBP'] 		= 	$this->M_general->ambilJumlahBP()[0]['jumlah_business_process'];


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/AllDoc/V_List_BP', $data);
		$this->load->view('V_Footer',$data);		
	}

	public function CD($BP)
	{
		$BP 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $BP);
		$BP 	= $this->encrypt->decode($BP);

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'All Document';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'All Document';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['listCD'] 		= 	$this->M_general->ambilDaftarCD($BP);
		$data['jumlahCD'] 		= 	$this->M_general->ambilJumlahCD($BP)[0]['jumlah_context_diagram'];

		$data['namaBP'] 		= 	$this->M_general->ambilLinkBP($BP)[0]['nama_business_process'];
		$data['idBP'] 			= 	$this->M_general->ambilLinkBP($BP)[0]['id_business_process'];
		$data['nomorBP'] 		= 	$this->M_general->ambilLinkBP($BP)[0]['nomor_kontrol'].' - '.$this->M_general->ambilLinkBP($BP)[0]['nomor_revisi'];


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/AllDoc/V_List_CD', $data);
		$this->load->view('V_Footer',$data);
	}

	public function SOP($CD, $BP)
	{
		$BP 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $BP);
		$BP 	= $this->encrypt->decode($BP);

		$CD 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $CD);
		$CD 	= $this->encrypt->decode($CD);

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'All Document';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'All Document';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['listSOP'] 		= 	$this->M_general->ambilDaftarSOP($CD, $BP);
		$data['jumlahSOP'] 		= 	$this->M_general->ambilJumlahSOP($CD, $BP)[0]['jumlah_standard_operating_procedure'];

		$data['namaBP'] 		= 	$this->M_general->ambilLinkBP($BP)[0]['nama_business_process'];
		$data['idBP'] 			= 	$this->M_general->ambilLinkBP($BP)[0]['id_business_process'];
		$data['nomorBP'] 		= 	$this->M_general->ambilLinkBP($BP)[0]['nomor_kontrol'].' - '.$this->M_general->ambilLinkBP($BP)[0]['nomor_revisi'];

		$data['namaCD'] 		= 	$this->M_general->ambilLinkCD($CD)[0]['nama_context_diagram'];
		$data['idCD'] 			= 	$this->M_general->ambilLinkCD($CD)[0]['id_context_diagram'];
		$data['nomorCD'] 		= 	$this->M_general->ambilLinkCD($CD)[0]['nomor_kontrol'].' - '.$this->M_general->ambilLinkCD($CD)[0]['nomor_revisi'];


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/AllDoc/V_List_SOP', $data);
		$this->load->view('V_Footer',$data);
	}

	public function WI_COP($SOP, $CD, $BP)
	{
		$BP 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $BP);
		$BP 	= $this->encrypt->decode($BP);

		$CD 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $CD);
		$CD 	= $this->encrypt->decode($CD);

		$SOP 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $SOP);
		$SOP 	= $this->encrypt->decode($SOP);

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'All Document';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'All Document';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['listWIRooted'] 		= 	$this->M_general->ambilDaftarWIRooted($SOP, $CD, $BP);
		$data['jumlahWIRooted'] 	= 	$this->M_general->ambilJumlahWIRooted($SOP, $CD, $BP)[0]['jumlah_work_instruction_berinduk'];
		$data['listCOPRooted'] 		= 	$this->M_general->ambilDaftarCOPRooted($SOP, $CD, $BP);
		$data['jumlahCOPRooted'] 	= 	$this->M_general->ambilJumlahCOPRooted($SOP, $CD, $BP)[0]['jumlah_code_of_practice_berinduk'];

		$data['fungsi'] 			= 	$this->M_general->ambilFungsi($CD);

		$data['jumlahWIUnrooted'] 	= 	$this->M_general->ambilJumlahWIUnrooted($data['fungsi'])[0]['jumlah_work_instruction_tidak_berinduk'];
		$data['jumlahCOPUnrooted'] 	= 	$this->M_general->ambilJumlahCOPUnrooted($data['fungsi'])[0]['jumlah_code_of_practice_tidak_berinduk'];

		$data['namaBP'] 		= 	$this->M_general->ambilLinkBP($BP)[0]['nama_business_process'];
		$data['idBP'] 			= 	$this->M_general->ambilLinkBP($BP)[0]['id_business_process'];
		$data['nomorBP'] 		= 	$this->M_general->ambilLinkBP($BP)[0]['nomor_kontrol'].' - '.$this->M_general->ambilLinkBP($BP)[0]['nomor_revisi'];

		$data['namaCD'] 		= 	$this->M_general->ambilLinkCD($CD)[0]['nama_context_diagram'];
		$data['idCD'] 			= 	$this->M_general->ambilLinkCD($CD)[0]['id_context_diagram'];
		$data['nomorCD'] 		= 	$this->M_general->ambilLinkCD($CD)[0]['nomor_kontrol'].' - '.$this->M_general->ambilLinkCD($CD)[0]['nomor_revisi'];

		$data['namaSOP'] 		= 	$this->M_general->ambilLinkSOP($SOP)[0]['nama_standard_operating_procedure'];
		$data['idSOP'] 			= 	$this->M_general->ambilLinkSOP($SOP)[0]['id_standard_operating_procedure'];
		$data['nomorSOP'] 		= 	$this->M_general->ambilLinkSOP($SOP)[0]['nomor_kontrol'].' - '.$this->M_general->ambilLinkSOP($SOP)[0]['nomor_revisi'];


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/AllDoc/V_List_WI_COP', $data);
		$this->load->view('V_Footer',$data);		
	}

	public function WI_COP_NoRoot($fungsi)
	{
		$fungsi 	= str_replace(array('-', '_', '~'), array('+', '/', '='), $fungsi);
		$fungsi 	= $this->encrypt->decode($fungsi);

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'All Document';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'All Document';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] 			= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] 	= $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] 	= $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['jumlahWIUnrooted'] 	= 	$this->M_general->ambilJumlahWIUnrooted($fungsi)[0]['jumlah_work_instruction_tidak_berinduk'];
		$data['jumlahCOPUnrooted'] 	= 	$this->M_general->ambilJumlahCOPUnrooted($fungsi)[0]['jumlah_code_of_practice_tidak_berinduk'];

		$data['listWIUnrooted'] 	= 	$this->M_general->ambilDaftarWIUnrooted($fungsi);
		$data['listCOPUnrooted'] 	= 	$this->M_general->ambilDaftarCOPUnrooted($fungsi);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/AllDoc/V_List_WI_COP_Unrooted', $data);
		$this->load->view('V_Footer',$data);		
	}
}