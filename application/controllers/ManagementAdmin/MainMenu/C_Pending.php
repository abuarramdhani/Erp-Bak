<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 *
 */
class C_Pending extends CI_Controller
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
		$this->load->model('ManagementAdmin/M_pending');

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
		$data['Menu'] = 'Laporan';
		$data['SubMenuOne'] = 'Pending';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['table'] = $this->M_pending->getDataPending();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementAdmin/Laporan/V_pending',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$alasan = $this->input->post('txtAlasan');
		$id = $this->input->post('txtId');
		$this->M_pending->insertAlasan($alasan,$id);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Pending_Submit Alasan ID='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('ManagementAdmin/Pending'));
	}
}
?>
