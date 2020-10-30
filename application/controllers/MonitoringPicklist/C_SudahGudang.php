<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SudahGudang extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringPicklist/M_pickgudang');

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

		$data['Title'] = 'Sudah Approve Gudang';
		$data['Menu'] = 'Sudah Approve Gudang';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/GUDANG/V_SudahGudang');
		$this->load->view('V_Footer',$data);
	}

	function searchData(){
		$subinv 	= $this->input->post('subinv');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');
		$dept		= $this->input->post('dept');

		if (!empty($dept)) {
			$department = "and bd.DEPARTMENT_CLASS_CODE = '$dept'";
		}else {
			$department = '';
		}

		$getdata = $this->M_pickgudang->getdataSudah($subinv, $tanggal1, $tanggal2, $department);
		foreach ($getdata as $key => $get) {
			$cek = $this->M_pickgudang->cekdeliver($get['PICKLIST']);
			$getdata[$key]['DELIVER'] = $cek[0]['DELIVER'];
		}
		$data['data'] = $getdata;
		
		$this->load->view('MonitoringPicklist/GUDANG/V_TblSudahGudang', $data);
	}

	function recallData(){
		$nojob 	= $this->input->post('nojob');
		$picklist 	= $this->input->post('picklist');
		// echo "<pre>";print_r($picklist);exit();
		$this->M_pickgudang->recallData($nojob, $picklist);
	}


}