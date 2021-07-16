<?php defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('max_execution_time', '1000');
ini_set('max_input_time', '-1');
ini_set('memory_limit', '4000M');
class C_RevisiPerItem extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		 $this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        $this->load->library('ciqrcode');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('RevisiMasterItem/M_revisimasteritem');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
	}

	public function checkSession()
		{
			if($this->session->is_logged){
				}else{
					redirect();
				}

		}

	public function index() {
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['valueupdate'] = $this->M_revisimasteritem->showUpdatedData();
		// echo "tes";exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RevisiMasterItem/V_RevisiPerItem',$data);
		$this->load->view('V_Footer',$data);
	}

	public function listCode() {
        $term = strtoupper($this->input->post('term'));
		$data = $this->M_revisimasteritem->listCode($term);
        echo json_encode($data);
    }

	public function getDescription(){
		$item_code = $this->input->post('params');
		$data = $this->M_revisimasteritem->getDescription($item_code);
		// echo print_r($data);
		echo json_encode($data);
	}

	public function insertData() {
		$this->M_revisimasteritem->deleteKIT();
		$no = $this->input->post('no');
		$item = $this->input->post('item_code');
		$desc = $this->input->post('item_desc');
		$action_type_id = 3;
		$action_type_name = 'UPDATE VALUE';
		$org_id = 81;
		$inventory_item_status_code = 'Active';
		$trx_type = 3;

		foreach ($no as $key => $l) {
			$arrayItem = [
				'item_code' => $item[$key],
				'item_desc' => $desc[$key],
				'action_type_id' => $action_type_id,
				'action_type_name' => $action_type_name,
				'org_id' => $org_id,
				'inventory_item_status_code' => $inventory_item_status_code,
				'trx_type' => $trx_type
			];
			$this->M_revisimasteritem->insertData($arrayItem);
		}
		$this->M_revisimasteritem->runUpdate();
		redirect(base_url("RevisiMasterItem/UpdatePerItem"));
	}
	
}