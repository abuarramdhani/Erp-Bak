<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');


class C_Index extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->helper('file');

			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->model('M_Index');
			$this->load->model('AbsenAtasan/M_absenatasan');
			$this->load->model('SystemIntegration/M_submit');
			$this->load->model('SystemAdministration/MainMenu/M_user');
		}

		public function checkSession()
		{
			if($this->session->is_logged){
			} else {
				redirect('index');
			}
		}

		function index(){
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenAtasan/V_Index',$data);
		$this->load->view('V_Footer',$data);
		}

		public function listData(){
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$employee = $this->session->employee;
		$nama = trim($employee);
		// print_r($approver);exit();
		$data['listData'] = $this->M_absenatasan->getList($nama);

		// $data['jenisAbsen'] = $this->M_absenatasan->getJenisAbsen();

		// echo "<pre>";
		// print_r($data['listData']);exit();

		// $data['listData'] = $this->M_absenatasan->getList();
		
		// $info = array();
		// foreach ($listData as $key => $data) {
		// $noinduk = $data['noind'];
		// $employeeInfo = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// $section_code = $employeeInfo['section_code'];
		// $unitInfo = $this->M_absenatasan->getFieldUnitInfo($section_code);
		// array_push($employeeInfo, $unitInfo);
		// array_push($info, $employeeInfo);
		// }

		// $noinduk = $data['listData'][0]['noind'];

		// echo "<pre>";
		// print_r($noinduk);exit();

		// $data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// echo "<pre>";
		// print_r($data['employeeInfo']);exit();

		// $section_code = $data['employeeInfo'][0]['section_code'];
		// $data['bidangUnit'] = $this->M_absenatasan->getFieldUnitInfo($section_code);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenAtasan/V_List',$data);
		$this->load->view('V_Footer',$data);
		}

		public function getAtasan(){

			// $atasan2 = $this->M_submit->getAtasan('F2335',2);
			// print_r(json_encode($atasan2));	exit();

			$noinduk = $this->input->post('noinduk');
			$getKodeJabatan = $this->M_submit->getKodeJabatan($noinduk);

			if($noinduk != null){
					if (($getKodeJabatan >= 13) && ($getKodeJabatan != 19) && ($getKodeJabatan != 16)) {
					$atasan1 = $this->M_submit->getAtasan($noinduk, 1);
					$atasan2 = $this->M_submit->getAtasan($noinduk, 2);
					$data['atasan1'] = $atasan1;
					$data['atasan2'] = $atasan2;
				}else{
					$atasan2 = $this->M_submit->getAtasan($noinduk, 2);
					$data['atasan2'] = $atasan2;
				}


				$data['status'] = true;
				$data['result']	= "Berhasil";
			}
			else{
				$data['status'] = false;
				$data['result']	= "Gagal";
			}
				print_r(json_encode($data));
			
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

		// echo "<pre>";
		// print_r($data['dataEmployee']);exit();

		$noinduk = $data['dataEmployee'][0]['noind'];

		// echo "<pre>";	
		// print_r($noinduk);exit();

		$data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// echo "<pre>";
		// print_r($data['employeeInfo']);exit();

		$section_code = $data['employeeInfo'][0]['section_code'];
		$data['bidangUnit'] = $this->M_absenatasan->getFieldUnitInfo($section_code);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenAtasan/V_Approval',$data);
		$this->load->view('V_Footer',$data);
		}

	}
	
?>		