<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 *
 */
class C_Input extends CI_Controller
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
		$this->load->model('ManagementAdmin/M_input');

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
		$data['Menu'] = 'Manual';
		$data['SubMenuOne'] = 'Input';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementAdmin/Manual/V_input',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Simpan(){
		print_r($_POST);

		$pekerja = $this->input->post('selectPekerjaProses');
		$Pekerjaan = $this->input->post('selectPekerjaanProses');
		$Jml = $this->input->post('txtJumlahDocument');
		$target = $this->input->post('txtTargetTotal');
		$tglStart = $this->input->post('txtTanggalMulai');
		$wktStart = $this->input->post('txtWaktuMulai');
		$tglEnd = $this->input->post('txtTanggalSelesai');
		$wktEnd = $this->input->post('txtWaktuSelesai');

		$arrdata =  array(
			'id_pekerja' => $pekerja ,
			'pekerjaan' => $Pekerjaan ,
			'jml_dokument' => $Jml ,
			'total_target' => $target ,
			'start_time' => $tglStart." ".$wktStart ,
			'end_time' => $tglEnd." ".$wktEnd ,
			'created_by' => $this->session->user
		);

		$this->M_input->insertData($arrdata);
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Save Data Pekerja ID='.$pekerja;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('ManagementAdmin/Input'));
	}
}
?>
