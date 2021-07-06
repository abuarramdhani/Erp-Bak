 <?php defined('BASEPATH') ;
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

	public function hiahia($param1, $param2)
	{
		echo $param1, $param2;
	}

	public function listCode() {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_revisimasteritem->listCode($term));
    }

	public function insertData() {
		$arrayItem = [
			'item' => $this->input->post('item'),
			'desc' => $this->input->post('desc'),
			'action_type_id' => 3,
			'action_type_name' => 'UPDATE VALUE',
			'org_id' => 81,
			'inventory_item_status_code' => 'Active',
			'trx_type' => 3
		];
		$item = $this->input->post('item');
		$desc = $this->input->post('desc');
		$action_type_id 	= 3;
		$action_type_name = 'UPDATE VALUE';
		$org_id = 81;
		$inventory_item_status_code = 'Active';
		$trx_type = 3;
		$this->M_revisimasteritem->insertDataUpdate($arrayItem);
	}
	
}