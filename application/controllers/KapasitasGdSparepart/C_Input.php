<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_input');

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

		$data['Title'] = 'Input Kapasitas Gudang';
		$data['Menu'] = 'Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noSPB = $this->input->post('no_spb');
		$valBtn = $this->input->post('btn_urgent');
		$btnBon = $this->input->post('btn_bon');
		$btnlangsung = $this->input->post('btn_langsung');
		$btnbesc = $this->input->post('btn_besc');
		// echo "<pre>"; print_r($valBtn);exit();
		for ($i=0; $i < count($noSPB); $i++) { 
			if ($noSPB[$i] == '') {
			
			}else{
				$dataSPB 	= $this->M_input->dataSPB($noSPB[$i]);
				$jam 		= gmdate("d/m/Y H:i:s", time()+60*60*7);
				$tgl_dibuat = $dataSPB[0]['MTRL'];
				$jenis 		= $dataSPB[0]['JENIS_DOKUMEN'];
				$nodoc 		= $dataSPB[0]['NO_DOKUMEN'];
				$jml_item 	= count($dataSPB);
				if ($valBtn[$i] == 'Urgent') {
					$urgent = '';
				}elseif ($valBtn[$i] == 'Batal') {
					$urgent = 'URGENT';
				}
				if ($btnBon[$i] == 'Bon' && $btnlangsung[$i] == 'Batal' && $btnbesc[$i] == 'Besc') {
					$bon = 'LANGSUNG';
				}elseif ($btnBon[$i] == 'Batal' && $btnlangsung[$i] == 'Langsung' && $btnbesc[$i] == 'Besc') {
					$bon = 'BON';
				}elseif ($btnbesc[$i] == 'Batal' && $btnBon[$i] == 'Bon' && $btnlangsung[$i] == 'Langsung') {
					$bon = 'BESC';
				}else {
					$bon = '';
				}
				$jml_pcs 	= 0;
				for ($a=0; $a < count($dataSPB); $a++) { 
					$jml_pcs += $dataSPB[$a]['QUANTITY'];
				}
				$cek = $this->M_input->cekData($noSPB[$i]);
				if (empty($cek)) {
					$save= $this->M_input->saveDataSPB($jam, $jenis, $nodoc, $jml_item, $jml_pcs, $urgent, $tgl_dibuat, $bon);	
				}else{
					
				}
			}
		}

		$date = date('d/m/Y');
		$data['value'] = $this->M_input->getData($date);
		for ($v=0; $v < count($data['value']); $v++) { 
			if ($data['value'][$v]['JENIS_DOKUMEN'] == '') {
				$this->M_input->hapusData();
			}else{

			}
			// if ($data['value'][$v]['TGL_DIBUAT'] == '') {
			// 	$cari = $this->M_input->dataSPB($data['value'][$v]['NO_DOKUMEN']);
			// 	$tgl = $cari[0]['MTRL'];

			// 	$update = $this->M_input->update($tgl, $data['value'][$v]['NO_DOKUMEN']);
			// }
		}
		
		// echo "<pre>"; print_r($data['value']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Input');
		$this->load->view('V_Footer',$data);
	}

	function cancelSPB(){
		$jenis = $this->input->post('jenis');
		$nodoc = $this->input->post('nodoc');
		$date  = gmdate('d/m/Y h:i:s', time()+60*60*7);
		// echo "<pre>"; print_r($date);exit();
		$cancel = $this->M_input->cancelSPB($jenis, $nodoc, $date);
	}


}