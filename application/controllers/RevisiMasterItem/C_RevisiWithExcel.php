 <?php defined('BASEPATH') ;
class C_RevisiWithExcel extends CI_Controller
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
		// echo "<pre>";print_r($data['valueupdate']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RevisiMasterItem/V_RevisiWithExcel',$data);
		$this->load->view('V_Footer',$data);
	}

	public function searchdata() {
		$this->M_revisimasteritem->deleteKIT();
		// echo "<pre>";print_r($_FILES);exit();
		require_once APPPATH.'third_party/Excel/PHPExcel.php';
    	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
		$file_data  = array();
		$file  = $_FILES['file_master_item']['tmp_name'];
		$load = PHPExcel_IOFactory::load($file);
		$sheets = $load->getActiveSheet()->toArray(null,true,true,true);

		foreach ($sheets as $key => $val) {
			if ($key!=1) {
				$arrayItem = [
					'item' => $val['A'],
					'desc' => $val['B'],
					'action_type_id' => 3,
					'action_type_name' => 'UPDATE VALUE',
					'org_id' => 81,
					'inventory_item_status_code' => 'Active',
					'trx_type' => 3
				];
				$this->M_revisimasteritem->insertDataUpdate($arrayItem);
			}
		}
		$this->M_revisimasteritem->runUpdate();
		redirect('RevisiMasterItem/UpdateItem');
	}

	public function downloadtemplate(){
		// echo 'check';
		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
			->setLastModifiedBy('Quick')
			->setTitle("Revisi Master Items")
			->setSubject("CV. KHS")
			->setDescription("Revisi Master Items")
			->setKeywords("IMO");

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Item");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "Description");

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Revisi Master Items");
		$excel->setActiveSheetIndex(0);
		$excel = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="rev-description-mst.csv"');
		$excel->save('php://output');
	}

	//perITem
	public function perItem() {
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
        echo json_encode($this->M_revisimasteritem->listCode($term));
    }

	public function insertData() {
		$this->M_revisimasteritem->deleteKIT();
		$this->M_revisimasteritem->insertData($arrayItem);
	}

	
}