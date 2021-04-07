<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SettingData extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MiscellaneousMng/M_settingdata');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Klasifikasi Alasan';
		$data['Menu'] = 'Setting Data';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_SettingData', $data);
		$this->load->view('V_Footer',$data);
    }
    
    public function getdataAlasan(){
        $data['data'] = $this->M_settingdata->getAlasan('');
		$this->load->view('MiscellaneousMng/V_TblAlasan', $data);
    }

    public function saveAlasan(){
        $cek = $this->M_settingdata->getAlasan('order by id desc');
        $data['id'] = !empty($cek) ? $cek[0]['id'] + 1 : 1;
        $data['alasan'] = $this->input->post('alasan');
        $this->M_settingdata->saveAlasan($data);
    }

    public function delAlasan(){
        $id = $this->input->post('id');
        $this->M_settingdata->delAlasan($id);
    }
}