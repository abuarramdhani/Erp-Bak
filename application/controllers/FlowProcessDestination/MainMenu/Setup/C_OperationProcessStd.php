<?php defined('BASEPATH') or die('No direct script access allowed');
class C_OperationProcessStd extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('FlowProcessDestination/M_setupoprprostd');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
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
			$data['OprProcessOpr'] = $this->M_setupoprprostd->getOprProcess();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FlowProcessDestination/MainMenu/Setup/V_OperationProStd',$data);
			$this->load->view('V_Footer',$data);

		}

	public function AddOPS()
	{
		$data['kososng'] = 'kossong';
		$this->load->view('FlowProcessDestination/MainMenu/Setup/V_AddOPS',$data);
	}

	public function HomeOPS()
	{
		$data['OprProcessOpr'] = $this->M_setupoprprostd->getOprProcess();
		$this->load->view('FlowProcessDestination/MainMenu/Setup/V_HomeOPS',$data);
	}

	public function SaveNewOPS()
	{
		$user_id = $this->session->userid;
		$ops = $this->input->post('ops');
		$ops_d = $this->input->post('ops_d');
		$ops_g = $this->input->post('ops_g');
		// $eda = $this->input->post('eda');
		$date_now = date('m-d-Y H:i:s');
		$sda = date('m-d-Y');

		$data = array('operation_process_std' => $ops,
					'operation_process_std_desc' => $ops_d,
					'operation_group' => $ops_g,
					'start_date_active' => $sda,
					'creation_date' => $date_now,
					'created_by' => $user_id );
		$this->M_setupoprprostd->SaveNewOPS($data);
		$this->HomeOPS();
	}

	public function deleteOPS()
	{
		$ops_id = $this->input->post('ops_id');
		$ops_arr = explode(',', $ops_id);
		foreach ($ops_arr as $key => $value) {
			$this->M_setupoprprostd->deleteOPS($value);
		}
		$this->HomeOPS();
	}

	public function editOPS()
	{
		$ops_id = $this->input->post('ops_id');
		$data['ops_id'] =$ops_id;
		$data['ops'] = $this->M_setupoprprostd->getDataOPSById($ops_id);
		$this->load->view('FlowProcessDestination/MainMenu/Setup/V_EditOPS',$data);
	}

	public function SaveEditOPS()
	{
		$user_id = $this->session->userid;
		$ops_id = $this->input->post('ops_id');
		$ops = $this->input->post('ops');
		$ops_d = $this->input->post('ops_d');
		$ops_g = $this->input->post('ops_g');
		$eda = $this->input->post('eda');
		$date_now = date('m-d-Y H:i:s');
		$sda = $this->input->post('eda');

		$data = array('operation_process_std' => $ops,
					'operation_process_std_desc' => $ops_d,
					'operation_group' => $ops_g,
					'end_date_active' => ($eda) ?: null,
					'update_date' => $date_now,
					'updated_by' => $user_id );
		$this->M_setupoprprostd->SaveEditOPS($ops_id,$data);
		$this->HomeOPS();
	}

}