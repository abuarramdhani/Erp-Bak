<?php defined('BASEPATH') or die('No direct script access allowed');
class C_AuditObject extends CI_Controller
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
		$getData = $this->M_settingaccount->getData(null);
		foreach ($getData as $key => $value) {
			$getData[$key]['staff'] = $this->M_settingaccount->getDetail($value['id']);
			$getData[$key]['auditor'] = $this->M_settingaccount->getDetailAuditor($value['id']);
		}
		$data['data_audit'] = $getData;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('InternalAudit/MainMenu/V_Style',$data);
		$this->load->view('InternalAudit/MainMenu/SettingAccount/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ShowFormAddAccount()
	{
		$data['user_erp'] = $this->M_settingaccount->getUserErp(null);
		$data['jenis'] = 'setting_account';
		$this->load->view('InternalAudit/V_Temp',$data);
	}

	public function ShowFormEditAccount()
	{
		$id = $this->input->post('id');
		$getData = $this->M_settingaccount->getData($id);
		$getData[0]['staff'] = $this->M_settingaccount->getDetail($id);
		$getData[0]['auditor'] = $this->M_settingaccount->getDetailAuditor($id);
		$data['user_erp'] = $this->M_settingaccount->getUserErp(null);
		$data['data_audit'] = $getData;
		$data['jenis'] = 'edit_account';
		$data['id_audit'] = $id;
		$this->load->view('InternalAudit/V_Temp',$data);
	}

	public function SaveAuditProject()
	{
		$name = $this->input->post('txtAuditProject');
		$pic = $this->input->post('slcPicAuditProject');
		$staff =$this->input->post('slcStaffAuditProject');
		$auditor =$this->input->post('slcAuditorAuditProject');

		$data1 = array('audit_object'=> $name, 'pic' => $pic);
		$getId = $this->M_settingaccount->SaveAuditProject($data1);

		foreach ($staff as $key => $value) {
			$data2 = array('audit_object_id' => $getId, 'staff_id' => $value);
			$this->M_settingaccount->SaveStaff($data2);
		}

		foreach ($auditor as $key => $value) {
			$data3 = array('audit_object_id' => $getId, 'auditor_id' => $value);
			$this->M_settingaccount->SaveAuditor($data3);
		}

		redirect(base_url('InternalAudit/SettingAccount/AuditObject'));
	}

	public function SaveEditAuditProject()
	{
		$name = $this->input->post('txtAuditProject');
		$pic = $this->input->post('slcPicAuditProject');
		$staff =$this->input->post('slcStaffAuditProject');
		$auditor =$this->input->post('slcAuditorAuditProject');
		$id_audit =$this->input->post('id_audit');
		$array_exist = array();
		$array_exist2 = array();

		$data1 = array('audit_object'=> $name, 'pic' => $pic);
		$update = $this->M_settingaccount->SaveEditAuditProject($id_audit,$data1);

		foreach ($staff as $key => $value) {
			$test_exist = $this->M_settingaccount->cek_exist($id_audit,$value);
			if (!$test_exist) {
				$data2 = array('audit_object_id' => $id_audit, 'staff_id' => $value);
				$id_exist = $this->M_settingaccount->SaveStaff($data2);
			}else{
				$id_exist = $test_exist[0]['id'];
			}
			array_push($array_exist,$id_exist);
		}
		$id_exist_gabung = implode("','",$array_exist);
		$this->M_settingaccount->deleteYangGakExist($id_audit,$id_exist_gabung);

		foreach ($auditor as $key2 => $value2) {
			$test_exist2 = $this->M_settingaccount->cek_exist_auditor($id_audit,$value2);
			if (!$test_exist2) {
				$data3 = array('audit_object_id' => $id_audit, 'auditor_id' => $value2);
				$id_exist2 = $this->M_settingaccount->SaveAuditor($data3);
			}else{
				$id_exist2 = $test_exist2[0]['id'];
			}
			array_push($array_exist2,$id_exist2);
		}
		$id_exist_gabung2 = implode("','",$array_exist2);
		$this->M_settingaccount->deleteAuditorYangGakExist($id_audit,$id_exist_gabung2);

		redirect(base_url('InternalAudit/SettingAccount/AuditObject'));
	}

	public function DeleteAudit()
	{
		$id = $this->input->post('id_audit');
		$this->M_settingaccount->DeleteAudit($id);
		redirect(base_url('InternalAudit/SettingAccount/AuditObject'));
	}



}