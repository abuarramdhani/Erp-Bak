<?php Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');
/**
* 
*/
class C_Lpalaju extends CI_Controller
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
		$this->load->model('AbsenAtasan/M_absenatasan');
		$this->load->model('SystemIntegration/M_submit');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AbsenPekerjaLaju/M_pekerjalaju');
		date_default_timezone_set('Asia/Jakarta');

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

		$data  = $this->general->loadHeaderandSidemenu('Absen Pekerja Laju', 'List Absensi pekerja Laju', 'List Absensi pekerja Laju', '', '');

		$employee = $this->session->employee;
		$nama = trim($employee);
		$noind = trim($this->session->user);
		$data['listData'] = $this->M_absenatasan->getList($noind,$nama);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenPekerjaLaju/ListAbsensiPekerjalaju/V_List_Lapl',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detail($id){
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dataEmployee'] = $this->M_absenatasan->getListAbsenById($id);

		$noinduk = $data['dataEmployee'][0]['noind'];

		$data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// echo "<pre>";print_r($data['dataEmployee']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenPekerjaLaju/ListAbsensiPekerjalaju/V_Approval_Lapl',$data);
		$this->load->view('V_Footer',$data);
	}
}