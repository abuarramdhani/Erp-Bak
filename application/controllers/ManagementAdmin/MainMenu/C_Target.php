<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 *
 */
class C_Target extends CI_Controller
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
		$this->load->model('ManagementAdmin/M_target');

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

		$data['Title'] = 'Management Admin';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Target';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['table'] = $this->M_target->getTarget();
		$data['kode'] = $this->M_target->getKode();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementAdmin/Master/V_target',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$arrData = array(
			'target_waktu' => $this->input->post('target'),
			'pekerjaan' => $this->input->post('pekerjaan'),
			'created_by' => $this->session->user,
			'no_urut' => $this->input->post('urut')
		);

		$this->M_target->insertTarget($arrData);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Target_Create Data Kode='.$this->input->post('urut');
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('ManagementAdmin/Target'));
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_target->deleteTarget($plaintext_string);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Target_Delete Target ID='.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('ManagementAdmin/Target'));
	}

	public function Update(){
		$id = $this->input->post('id');
		$arrData = array(
			'target_waktu' => $this->input->post('target'),
			'pekerjaan' => $this->input->post('pekerjaan')
		);

		$this->M_target->updateTarget($id,$arrData);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Target_Update Target ID='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('ManagementAdmin/Target'));
	}
}
?>
