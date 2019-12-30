 <?php defined('BASEPATH') ;
class C_Export extends CI_Controller
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
			$this->load->model('Inventory/M_exportmo','M_exportmo');
			  
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
		$data['dept'] = $this->M_exportmo->getDept();
		$data['shift'] = $this->M_exportmo->getShift(FALSE);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Inventory/MainMenu/MoveOrder/V_ExportMO',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getShift(){
		$date = $this->input->post('date');
		// $date = date('Y/m/d',strtotime($date));
		$date2 = explode('/', $date);
		$datenew = $date ? $date2[2].'/'.$date2[1].'/'.$date2[0] : '';
		$data = $this->M_exportmo->getShift($datenew);
		echo json_encode($data);
	}

	public function search(){
		$dateAwl = $this->input->post('date1');
		$dateAkh = $this->input->post('date2');
		$dept = $this->input->post('dept');
		$date1 = explode('/', $dateAwl);
		$datenew1 = $dateAwl ? $date1[1].'/'.$date1[0].'/'.$date1[2] : '';
        $date1 = strtoupper(date('d-M-y', strtotime($datenew1)));
        
		$date2 = explode('/', $dateAkh);
		$datenew2 = $dateAkh ? $date2[1].'/'.$date2[0].'/'.$date2[2] : '';
		$date2 = strtoupper(date('d-M-y', strtotime($datenew2)));

		$data['data'] = $this->M_exportmo->search($date1, $date2,$dept);
		$data['export'] = $this->M_exportmo->getDetail($date1, $date2,$dept);
		
		// echo "<pre>";
		// print_r($dateAkh);
		// echo "<br>";
		// print_r($dept);
		// echo "<br>";
		// print_r($date2);		
		// echo "<br>";
		// print_r($dataGET);		
		// exit();
		
		// $array_sudah = array();
		// $array_terkelompok = array();
		// foreach ($dataGET as $key => $value) {
		// 	if (in_array($value['WIP_ENTITY_NAME'], $array_sudah)) {
		// 		// echo "sudah ada";print_r($value['WIP_ENTITY_NAME']);echo"<br>";
		// 	}else{
		// 		// echo "memasukan ";print_r($value['WIP_ENTITY_NAME']);echo "<br>";
		// 		array_push($array_sudah, $value['WIP_ENTITY_NAME']);
		// 		if ($dept == 'SUBKT') {
		// 			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";
		// 			$getBody = $this->M_exportmo->getBody($value['WIP_ENTITY_NAME'],$atr,$dept);
		// 		}else {
		// 			// EDIT LUTFI
		// 			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') atr";	
		// 			$getBody = $this->M_exportmo->getBody($value['WIP_ENTITY_NAME'],$atr,$dept);	
		// 		}
		// 		$array_terkelompok[$value['WIP_ENTITY_NAME']]['header'] = $value; 
		// 		$array_terkelompok[$value['WIP_ENTITY_NAME']]['body'] = $getBody; 
		// 	}

		// }

		// // echo "<pre>";
		// // // print_r($array_sudah);
		// // print_r($array_terkelompok);
		// // exit();

		// foreach ($array_terkelompok as $key => $value) {
		// 	// echo "<pre>";
		// 	// print_r($value);
		// 	// exit();
		//  	$checkPicklist = $this->M_exportmo->checkPicklist($key);
		//  	if ($checkPicklist) {
		// 		$array_terkelompok[$key]['header']['KET'] = 1 ;
		//  	}else{
		// 		$array_terkelompok[$key]['header']['KET'] = 0 ;
		//  	}
		//  }


		// $data['requirement'] = $array_terkelompok;
		// echo "<pre>";
		// print_r($data['requirement']);
		// exit();

		$this->load->view('Inventory/MainMenu/MoveOrder/V_TblExport',$data);
	}

	
}