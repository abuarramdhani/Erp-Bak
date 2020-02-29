<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 *
 */
class C_Proses extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManagementAdmin/M_proses');

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
		$user_id 	= $this->session->userid;
		$user 		= $this->session->user;
		$res_id 	= $this->session->responsibility_id;
		if ($res_id == '2580') {
			$this->session->management_admin_res_id = $res_id;
		}elseif ($res_id == '2579') {
			$this->session->management_admin_res_id = $res_id;
		}

		$ma_res_id = $this->session->management_admin_res_id;
		// print_r($_SESSION);exit();



		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if ($ma_res_id == '2580') {
			$data['table_proses'] 	= $this->M_proses->getDataproses($user);
			$data['table_selesai'] 	= $this->M_proses->getDataselesai($user);
			$data['Title'] 			= 'Management Admin User';
			$data['Menu'] 			= 'Proses';
			$data['SubMenuOne'] 	= '';
			$data['SubMenuTwo'] 	= '';
			$data['delete']			= '0';
		}else{
			$data['table_proses'] 	= $this->M_proses->getDataproses();
			$data['table_selesai'] 	= $this->M_proses->getDataselesai();
			$data['Title'] 			= 'Management Admin';
			$data['Menu'] 			= 'Proses';
			$data['SubMenuOne'] 	= '';
			$data['SubMenuTwo'] 	= '';
			$data['delete']			= '1';
		}


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementAdmin/Proses/V_proses',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateData(){
		$arrData = array(
			'id_pekerja' => $this->input->post('selectPekerjaProses'),
			'pekerjaan' => $this->input->post('selectPekerjaanProses'),
			'jml_dokument' => $this->input->post('txtJumlahDocument'),
			'total_target' => $this->input->post('txtTargetTotal'),
			'created_by' => $this->session->user
		);

		$this->M_proses->insertPelaksanaan($arrData);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Proses_Create Data ID_PKJ='.$this->input->post('selectPekerjaProses');
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('ManagementAdmin/Proses'));
	}

	public function CariPekerja(){
		$noind = $this->input->get('term');
		$noind = strtoupper($noind);
		$data = $this->M_proses->getPekerja($noind);
		echo json_encode($data);
	}

	public function CariPekerjaan(){
		$nama = $this->input->get('term');
		$nama = strtolower($nama);
		$data = $this->M_proses->getPekerjaan($nama);
		echo json_encode($data);
	}

	public function Selesai(){
		$data = $this->input->post('checkSelesai');
		// print_r($data);exit();
		foreach ($data as $key) {
			$this->M_proses->updateDataSelesai($key);
			$this->M_proses->insertPending($key);
		}
		redirect(site_url('ManagementAdmin/Proses'));
	}

	public function Delete($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$decrypted_String = $this->encrypt->decode($decrypted_String);
		$this->M_proses->deleteData($decrypted_String);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Proses_Delete Data ID='.$decrypted_String;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('ManagementAdmin/Proses'));
	}
}

?>
