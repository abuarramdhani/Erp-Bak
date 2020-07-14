<?php 
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_DetailUrutanJdwl extends CI_Controller
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
		$this->load->model('CateringManagement/Setup/M_detailurutanjdwl');

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

		$data['Title'] = 'Setup Detail Urutan Jadwal';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Detail Urutan Jadwal';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['DetailUrutanJdwl'] = $this->M_detailurutanjdwl->getDetailUrutanJdwl();
		

		// echo "<pre>";print_r($data['DetailUrutanJdwl']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/DetailUrutanJdwl/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Detail Urutan Jadwal';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Detail Urutan Jadwal';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['urutan'] = $this->M_detailurutanjdwl->getCountkatering();

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === FALSE){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/DetailUrutanJdwl/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$s1 = "";
			$s2 = "";
			$s3 = "";

			if (isset($_POST['txtShift1'])) {
				$s1 = $this->input->post('txtShift1');
			}else{
				$s1 = "0";
			}
			if (isset($_POST['txtShift2'])) {
				$s2 = $this->input->post('txtShift2');
			}else{
				$s2 = "0";
			}
			if (isset($_POST['txtShift3'])) {
				$s3 = $this->input->post('txtShift3');
			}else{
				$s3 = "0";
			}

			$arrData = array(
				'fs_hari' => $this->input->post('txtHariUrutanJdwl'), 
				'fn_urutan_jadwal' => $this->input->post('txtUrutanJdwl'), 
				'fs_tujuan_shift1' => $s1, 
				'fs_tujuan_shift2' => $s2, 
				'fs_tujuan_shift3' => $s3, 
			);

			$cek = $this->M_detailurutanjdwl->getDetailUrutanJdwlByHariUrutan($arrData['fs_hari'],$arrData['fn_urutan_jadwal']);

			if (empty($cek)) {
				$this->M_detailurutanjdwl->insertDetailUrutanJdwl($arrData);
				redirect(site_url('CateringManagement/DetailUrutanJdwl'));
			}else{
				$data['isi'] = $cek;
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CateringManagement/Setup/DetailUrutanJdwl/V_create.php',$data);
				$this->load->view('V_Footer',$data);
			}
		}
		
	}

	public function Edit($hr,$urt){
		$hari = str_replace(array('-','_','~'), array('+','/','='), $hr);
		$hari = $this->encrypt->decode($hari);
		$urutan = str_replace(array('-','_','~'), array('+','/','='), $urt);
		$urutan = $this->encrypt->decode($urutan);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Detail Urutan Jadwal';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Detail Urutan Jadwal';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['DetailUrutanJdwl'] = $this->M_detailurutanjdwl->getDetailUrutanJdwlByHariUrutan($hari,$urutan);
		$data['linkdata'] = $hr."/".$urt;

		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === FALSE){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/DetailUrutanJdwl/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{

			// print_r($_POST);exit();
			$s1 = "";
			$s2 = "";
			$s3 = "";

			if (isset($_POST['txtShift1'])) {
				$s1 = $this->input->post('txtShift1');
			}else{
				$s1 = "0";
			}
			if (isset($_POST['txtShift2'])) {
				$s2 = $this->input->post('txtShift2');
			}else{
				$s2 = "0";
			}
			if (isset($_POST['txtShift3'])) {
				$s3 = $this->input->post('txtShift3');
			}else{
				$s3 = "0";
			}

			$arrData = array( 
				'fs_tujuan_shift1' => $s1, 
				'fs_tujuan_shift2' => $s2, 
				'fs_tujuan_shift3' => $s3
			);

			$arrWhere = array(
				'fs_hari' => $hari, 
				'fn_urutan_jadwal' => $urutan
			);

			$this->M_detailurutanjdwl->updateDetailUrutanjdwl($arrData,$arrWhere);
			redirect(site_url('CateringManagement/DetailUrutanJdwl'));
			
		}
	}

	public function Delete($hr,$urt){
		$hari = str_replace(array('-','_','~'), array('+','/','='), $hr);
		$hari = $this->encrypt->decode($hari);
		$urutan = str_replace(array('-','_','~'), array('+','/','='), $urt);
		$urutan = $this->encrypt->decode($urutan);

		$arrWhere = array(
			'fs_hari' => $hari, 
			'fn_urutan_jadwal' => $urutan
		);

		$this->M_detailurutanjdwl->deleteDetailUrutanjdwl($arrWhere);
		redirect(site_url('CateringManagement/DetailUrutanJdwl'));
	}
}
?>