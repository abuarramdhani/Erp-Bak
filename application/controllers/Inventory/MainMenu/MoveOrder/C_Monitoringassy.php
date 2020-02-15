<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoringassy extends CI_Controller
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
		$this->load->model('Inventory/M_monitoringassy','M_monitoringassy');


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

		$data['Title'] = 'Monitoring Assy';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Inventory/MainMenu/MoveOrder/V_FilterMon');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}

	public function sugestion()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringassy->selectassy($term);
		echo json_encode($data);
	}

		public function sugestiondept()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringassy->selectdept($term);
		echo json_encode($data);
	}

	public function Searchmonitoringassy(){

		$dept = $this->input->post('dept');
		$assy = $this->input->post('assy');
		// echo "<pre>";print_r($dept);print_r($assy);exit();

		$departement = NULL;
		$kodeassy = NULL;

		if ($dept != '') {
			$departement = "and bd.DEPARTMENT_CLASS_CODE = '$dept'";
		}
		if ($assy !='') {
			$kodeassy = "and msib.SEGMENT1 = '$assy'";
		}

		// echo "<pre>";print_r($departement);print_r($assy);exit();

		$monitoringassy = $this->M_monitoringassy->dataassy($departement, $kodeassy);

		// echo "<pre>";print_r($monitoringassy);exit();

		$data['monitoringassy'] = $monitoringassy;
		$this->load->view('Inventory/MainMenu/MoveOrder/V_Monitoringassy', $data);

	}


}