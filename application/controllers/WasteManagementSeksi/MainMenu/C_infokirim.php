<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class C_infokirim extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WasteManagementSeksi/MainMenu/M_info');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Info Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Info Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_info->getSeksi();
		$data['limbah'] = $this->M_info->getLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagementSeksi/InfoKirimLimbah/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Grafik(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Info Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Info Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_info->getSeksi();
		$data['limbah'] = $this->M_info->getLimbah();

		$data['periode'] = $this->input->post('txtPeriodeInfo');
		$data['kategori'] = $this->input->post('txtPilihKat');
		$data['text'] = $this->input->post('txtHiddenValue');
		if (isset($_POST['txtValueSek'])) {
			$data['value'] = $this->input->post('txtValueSek');
		}else{
			$data['value'] = $this->input->post('txtValueLim');
		}

		// print_r($_POST);
		// echo $data['value'].$data['text'].$data['kategori'];
		// exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagementSeksi/InfoKirimLimbah/V_grafik',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Chart(){

		$periode = $this->input->post('txtPeriodeInfo');
		$periode = explode(" - ", $periode);

		if (isset($_POST['txtValueSek'])) {
			$seksi = $this->input->post('txtValueSek');
			$data['chart'] = $this->M_info->chartLimbah($seksi,$periode);
		}else if(isset($_POST['txtValueLim'])){
			$limbah = $this->input->post('txtValueLim');
			$data['chart'] = $this->M_info->chartSeksi($limbah,$periode);
		}

		echo json_encode($data);
		
	}

}
?>