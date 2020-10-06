 <?php defined('BASEPATH') ;
class C_Simulasi extends CI_Controller
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
			$this->load->model('Inventory/M_simulasi');
			$this->load->model('Inventory/M_moveorder','M_MoveOrder');
			  
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

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Inventory/MainMenu/MoveOrder/V_Simulasi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function searchdata(){
		// echo "<pre>";print_r($_FILES);exit();
		require_once APPPATH.'third_party/Excel/PHPExcel.php';
    	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
		$file_data  = array();
		$file  = $_FILES['file_simulasi']['tmp_name'];
		$load = PHPExcel_IOFactory::load($file);
		$sheets = $load->getActiveSheet()->toArray(null,true,true,true);
		// echo "<pre>";print_r($sheets);exit();

		$getdata = array();
		$cek = count($sheets[1]);
		if ($cek == 1) {
			$i = 0;
			foreach ($sheets as $key => $val) {
				if ($key != 1) {
					$pisah = explode(",", $val['A']);
					$getdata[$i]['kode'] = $pisah[0];
					$getdata[$i]['desc'] = $pisah[1];
					$getdata[$i]['qty'] = $pisah[2];
					$i++;
				}
			}
		}else {
			$i = 0;
			foreach ($sheets as $key => $val) {
				if ($key != 1) {
					$getdata[$i]['kode'] = $val['A'];
					$getdata[$i]['desc'] = $val['B'];
					$getdata[$i]['qty'] = $val['C'];
					$i++;
				}
			}
		}

		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($getdata as $key => $get) {
			if (!in_array($get['kode'], $array_sudah)) {
				array_push($array_sudah, $get['kode']);
				$getBody = $this->M_simulasi->getData($get['kode'], $get['qty']);
				$datanya = $this->sorting_item_merah($getBody);
				$array_terkelompok[$get['kode']]['header'] = $get; 
				$array_terkelompok[$get['kode']]['body'] = $datanya; 
			}
		}

		$data['data'] = $array_terkelompok;
		$data['file'] = $_FILES['file_simulasi']['name'];
		// echo "<pre>";print_r($array_terkelompok);exit();
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Simulasi Kebutuhan Komponen';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Inventory/MainMenu/MoveOrder/V_ResultSimulasi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function sorting_item_merah($getBody){
		$datanya = array();
		foreach ($getBody as $key => $get) {
			if ($get['REQUIRED_QUANTITY'] > $get['ATT'] || $get['REQUIRED_QUANTITY'] > $get['KURANG']) {
				array_push($datanya, $getBody[$key]);
			}
		}
		foreach ($getBody as $key => $get) {
			if ($get['REQUIRED_QUANTITY'] > $get['ATT'] || $get['REQUIRED_QUANTITY'] > $get['KURANG']) {
			}else {
				array_push($datanya, $getBody[$key]);
			}
		}
		return $datanya;
	}

	public function downloadtemplate(){
		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
			->setLastModifiedBy('Quick')
			->setTitle("Simulasi Kebutuhan Komponen")
			->setSubject("CV. KHS")
			->setDescription("Simulasi Kebutuhan Komponen")
			->setKeywords("IMO");

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Kode_Item");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "Nama_Item");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "QTY");

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Simulasi Kebutuhan Komponen");
		$excel->setActiveSheetIndex(0);
		$excel = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="simulasi_kebutuhan_komponen.csv"');
		$excel->save('php://output');
	}

	
}