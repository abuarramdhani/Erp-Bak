<?php defined('BASEPATH') or die('No direct Script access allowed');
class C_SettingUser extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('InternalAudit/M_settingaccount');

		if ($this->session->userdata('logged_in') != TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}

	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$getUser = $this->M_settingaccount->getUserErp(null);
		$data['user'] = $getUser;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InternalAudit/MainMenu/V_Style',$data);
		$this->load->view('InternalAudit/MainMenu/SettingAccount/V_IndexUser',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Detail($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$getUserAccount = $this->M_settingaccount->getUserData($id);
					if ($getUserAccount[0]['status_auditor'] == '1') {
						$status_auditor = 'Kasie';
					}elseif ($getUserAccount[0]['status_auditor'] == '2' ) {
						$status_auditor = 'Admin';
					}else{
						$status_auditor = '--';
					}
		$user = array(
						'name' => $getUserAccount[0]['employee_name'],
						'user_id' => $id,
						'status_auditor' => $status_auditor,
						'status_auditor_id' => $getUserAccount[0]['status_auditor'],
						'section' => $getUserAccount[0]['section_name'],
						'no_voip' => $getUserAccount[0]['no_voip'],
						'no_induk' => $getUserAccount[0]['no_induk'],
						'no_mygroup' => $getUserAccount[0]['no_mygroup'],
						'email' => $getUserAccount[0]['email_internal'],
						'initial' => $getUserAccount[0]['initial']);
		$data['user'] = $user;
		$data['set'] = '1';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InternalAudit/MainMenu/V_Style',$data);
		$this->load->view('InternalAudit/MainMenu/SettingAccount/V_DetailUser',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Edit($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$getUserAccount = $this->M_settingaccount->getUserData($id);
		if ($getUserAccount[0]['status_auditor'] == '1') {
						$status_auditor = 'Kasie';
					}elseif ($getUserAccount[0]['status_auditor'] == '2' ) {
						$status_auditor = 'Admin';
					}else{
						$status_auditor = '--';
					}
		$user = array('name' => $getUserAccount[0]['employee_name'],
						'user_id' => $id,
						'status_auditor' => $status_auditor,
						'status_auditor_id' => $getUserAccount[0]['status_auditor'],
						'section' => $getUserAccount[0]['section_name'],
						'no_voip' => $getUserAccount[0]['no_voip'],
						'no_induk' => $getUserAccount[0]['no_induk'],
						'no_mygroup' => $getUserAccount[0]['no_mygroup'],
						'email' => $getUserAccount[0]['email_internal'],
						'initial' => $getUserAccount[0]['initial']);
		$data['user'] = $user;
		$data['set'] = '2';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InternalAudit/MainMenu/V_Style',$data);
		$this->load->view('InternalAudit/MainMenu/SettingAccount/V_DetailUser',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getUserData()
	{
		$user_id = $this->input->post('user_id');
		$getUserAccount = $this->M_settingaccount->getUserData($user_id);
		$user = array('name' => $getUserAccount[0]['employee_name'],
						'section' => $getUserAccount[0]['section_name'],
						'no_voip' => $getUserAccount[0]['no_voip'],
						'no_induk' => $getUserAccount[0]['no_induk'],
						'no_mygroup' => $getUserAccount[0]['no_mygroup'],
						'email' => $getUserAccount[0]['email_internal'],
						'initial' => $getUserAccount[0]['initial']);
		$data['user'] = $user;
		$data['jenis'] = 'view_user';
		$this->load->view('InternalAudit/V_Temp',$data);
	}

	public function UpdateUser()
	{
		$user_id = $this->input->post('user_id');
		$no_voip = $this->input->post('no_voip');
		$no_mygroup = $this->input->post('no_mygroup');
		$email = $this->input->post('email');
		$initial = $this->input->post('initial');
		$status_auditor = $this->input->post('status_auditor');

		$checkUser = $this->M_settingaccount->getUserAccount($user_id);
		if ($checkUser > 0) {
			$dataUpdate = array(
			'no_voip' => $no_voip,
			'no_mygroup' => $no_mygroup,
			'email_internal' => $email,
			'status_auditor' => $status_auditor,
			'initial' => $initial);
		$this->M_settingaccount->updateUserAccount($user_id,$dataUpdate);
		}else{
			$dataUpdate = array(
			'user_id' => $user_id,
			'no_voip' => $no_voip,
			'no_mygroup' => $no_mygroup,
			'email_internal' => $email,
			'status_auditor' => $status_auditor,
			'initial' => $initial);
		$this->M_settingaccount->insertUserAccount($dataUpdate);
		}

		redirect(base_url('InternalAudit/SettingAccount/User/Detail/'.$user_id));
	}
}