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

		$noSPB1 = $this->input->post('noSpb1');
		$noSPB2 = $this->input->post('noSpb2');
		$noSPB3 = $this->input->post('noSpb3');
		$noSPB4 = $this->input->post('noSpb4');
		$noSPB5 = $this->input->post('noSpb5');
		$noSPB6 = $this->input->post('noSpb6');
		$noSPB7 = $this->input->post('noSpb7');
		$noSPB8 = $this->input->post('noSpb8');
		$noSPB9 = $this->input->post('noSpb9');
		$noSPB10 = $this->input->post('noSpb10');
		$btn1 	= $this->input->post('btn1');
		$btn2 	= $this->input->post('btn2');
		$btn3 	= $this->input->post('btn3');
		$btn4 	= $this->input->post('btn4');
		$btn5 	= $this->input->post('btn5');
		$btn6 	= $this->input->post('btn6');
		$btn7 	= $this->input->post('btn7');
		$btn8 	= $this->input->post('btn8');
		$btn9 	= $this->input->post('btn9');
		$btn10 	= $this->input->post('btn10');
		// $pic 	= $this->input->post('pic');
		$noSPB 	= array(
				'0' => $noSPB1, '1' => $noSPB2, '2' => $noSPB3,	'3' => $noSPB4,	'4' => $noSPB5,
				'5' => $noSPB6,	'6' => $noSPB7,	'7' => $noSPB8,	'8' => $noSPB9,	'9' => $noSPB10);
		$valBtn = array(
				'0' => $btn1, '1' => $btn2, '2' => $btn3, '3' => $btn4,	'4' => $btn5,
				'5' => $btn6, '6' => $btn7, '7' => $btn8, '8' => $btn9,	'9' => $btn10);
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
					$urgent = 'Urgent';
				}
				$jml_pcs 	= 0;
				for ($a=0; $a < count($dataSPB); $a++) { 
					$jml_pcs += $dataSPB[$a]['QUANTITY'];
				}
				$cek = $this->M_input->cekData($noSPB[$i]);
				if (empty($cek)) {
					$save= $this->M_input->saveDataSPB($jam, $jenis, $nodoc, $jml_item, $jml_pcs, $urgent, $tgl_dibuat);	
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


}