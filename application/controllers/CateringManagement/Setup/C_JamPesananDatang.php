<?php 
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_JamPesananDatang extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Setup/M_jampesanandatang');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Jam Pesan Dan Datang Katering';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jam Pesanan Datang';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Shift'] = $this->M_jampesanandatang->getShift();
		
		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() !== FALSE){
			$shift = $this->input->post('txtShiftPesan');
			$data['ShiftNow'] = $this->M_jampesanandatang->getShiftByKd($shift);
			$data['JamPesananDatang'] = $this->M_jampesanandatang->getJamPesananDatang($shift);
		}
		// echo "<pre>";print_r($data['JamPesananDatang']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/JamPesananDatang/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Jam Pesan Dan Datang Katering';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jam Pesanan Datang';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Shift'] = $this->M_jampesanandatang->getShift();

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === FALSE){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/JamPesananDatang/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			// echo "<pre>";;print_r($_POST);exit();

			$arrData = array(
				'fs_kd_shift' => $this->input->post('txtShiftPesananDatang'),
   				'fs_hari' => $this->input->post('txtHariPesananDatang'),
				'fs_jam_pesan' => $this->input->post('txtJamPesan'),
				'fs_jam_datang' => $this->input->post('txtJamDatang')
			);

			$cek = $this->M_jampesanandatang->getJamPesananDatangByShiftHari($arrData['fs_kd_shift'],$arrData['fs_hari']);

			if (empty($cek)) {
				$this->M_jampesanandatang->insertJamPesananDatang($arrData);
				redirect(site_url('CateringManagement/JamPesananDatang'));
			}else{
				$data['alert'] = $cek;
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CateringManagement/Setup/JamPesananDatang/V_create.php',$data);
				$this->load->view('V_Footer',$data);
			}
		}
		
	}

	public function Edit($hr,$sft){
		$hari = str_replace(array('-','_','~'), array('+','/','='), $hr);
		$hari = $this->encrypt->decode($hari);
		$shift = str_replace(array('-','_','~'), array('+','/','='), $sft);
		$shift = $this->encrypt->decode($shift);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Jam Pesan Dan Datang Katering';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jam Pesanan Datang';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Shift'] = $this->M_jampesanandatang->getShift();
		$data['JamPesananDatang'] = $this->M_jampesanandatang->getJamPesananDatangByShiftHari($shift,$hari);
		$data['linkdata'] = $hr."/".$sft;

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === FALSE){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/JamPesananDatang/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			

			$arrData = array(
				'fs_jam_pesan' => $this->input->post('txtJamPesan'),
				'fs_jam_datang' => $this->input->post('txtJamDatang')
			);

			$arrWhere = array(
				'fs_hari' => $hari, 
				'fs_kd_shift' => $shift
			);
			// echo "<pre>";print_r($arrData);print_r($arrWhere);print_r($_POST);exit();

			$this->M_jampesanandatang->updateJamPesananDatang($arrData,$arrWhere);
			redirect(site_url('CateringManagement/JamPesananDatang'));
			
		}
	}

	public function Delete($hr,$sft){
		$hari = str_replace(array('-','_','~'), array('+','/','='), $hr);
		$hari = $this->encrypt->decode($hari);
		$shift = str_replace(array('-','_','~'), array('+','/','='), $sft);
		$shift = $this->encrypt->decode($shift);

		$arrWhere = array(
			'fs_hari' => $hari, 
			'fs_kd_shift' => $shift
		);

		$this->M_jampesanandatang->deleteJamPesananDatang($arrWhere);
		redirect(site_url('CateringManagement/JamPesananDatang'));
	}
}
?>