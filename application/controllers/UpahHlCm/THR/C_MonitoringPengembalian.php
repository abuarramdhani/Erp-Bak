<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_MonitoringPengembalian extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_thr');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Monitoring Pengembalian THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Monitoring Pengembalian THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_thr->getPengembalianTHR();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_indexmonitoringpengembalian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pengembalian(){
		$user_id = $this->session->userid;
		$user = $this->session->user;
		$id = $this->input->get('id');

		$data['Title']			=	'Monitoring Pengembalian THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Monitoring Pengembalian THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_thr->getPengembalianTHRByIdTHR($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_prosesmonitoringpengembalian',$data);
		$this->load->view('V_Footer',$data);
	}

	public function simpan(){
		print_r($_POST);
		$data = array(
			'id_thr' 		=> $this->input->post('txtHLCMPengembalianTHRIDTHR'),
			'tgl_kembali' 	=> $this->input->post('txtHLCMPengembalianTHRTanggal'),
			'note' 			=> $this->input->post('txtHLCMPengembalianTHRCatatan'),
			'input_by' 		=> $this->session->user
		);

		$this->M_thr->insertPengembalianTHR($data);

		redirect(base_url('HitungHlcm/THR/MonitoringPengembalian'));
	}

}
?>