<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Input extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
			$this->load->library('form_validation');
			$this->load->library('csvimport');
	        //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('PerhitunganLoadingODM/M_PerhitunganLoadingODM');
			$this->load->model('PerhitunganLoadingODM/M_input');
			  
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
			$data['Input']  = $this->M_input->getDataInput();

			$this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PerhitunganLoadingODM/MainMenu/Input/V_Input',$data);
			$this->load->view('V_Footer',$data);
			// echo '<pre>';
			// print_r($data);
			// exit;

		}
		
		function ItemCode()
		{
			$id = $this->input->get('orgcode');
			$orgcode= $this->M_input->bacaorgid($id);
		   $term = $this->input->get('term',true);
		   $term = strtoupper($term);
		   $data = $this->M_input->selectItemCode($orgcode[0]['ORGANIZATION_CODE'], $term);
		   echo json_encode($data);
		}
		function OrgCode()
		{
		   $term = $this->input->get('term',TRUE);
		   $term = strtoupper($term);
		   $data = $this->M_input->selectOrgCode($term);
		   echo json_encode($data);
		}
		
	public function saveData(){
		$item_id = $this->input->post('txt_item_id');
		$Periode = $this->input->post('txt_periodebulan');
		$Periode2 = date('y-M', strtotime($Periode));
		$Periode3 = explode('-', $Periode2);
		$year = $Periode3[0];
		$month = $Periode3[1];
		$Periode4 = implode('-', [$month, $year]);
		// echo"<pre>"; print_r($Periode4);exit;
		$needs =$this->input->post('txt_needs');
		$orgid = $this->input->post('txt_org_code');

		$data = array(
			'ITEM_ID' => $item_id,
			'PERIOD' => $Periode4,
			'NEEDS' => $needs,
			'ORG_ID'=> $orgid
		);
		$cekcek= $this->M_input->cekData($item_id, $Periode4, $orgid);
		if (count($cekcek)>0){
			$this->M_input->updateData($item_id, $Periode4, $needs, $orgid);
		}else{
			$this->M_input->saveData($data);
		}
		
		$this->session->set_flashdata('response',"Saved");
		redirect(base_url('PerhitunganLoadingODM/Input'));
	}

	public function viewimport(){
		$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerhitunganLoadingODM/MainMenu/Input/V_importcsv');
		$this->load->view('V_Footer');
	}

	public function import(){
			$this->checkSession();
			$user_id = $this->session->userid;
			//$data['user'] = $usr;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['data_input']  = array();
			
			$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
			foreach($file_data as $row) {
				$data['data_input'][] = array( 'ORG_CODE'  => $row["ORGANIZATION_CODE"],
									'ITEM_CODE' => $row["ITEM_CODE"],
									'PERIOD'  => $row["PERIOD"],
									'NEEDS'   => $row["NEEDS"]
						);
					}
			// echo "<pre>";
			// print_r($itemcode);
			// exit();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PerhitunganLoadingODM/MainMenu/Input/V_tabel',$data['data_input']);
			$this->load->view('V_Footer',$data);
		}
		// public function saveDatacsv(){
		// 	$item_id = $this->input->post('itemid');
		// 	$Periode = $this->input->post('period');
		// 	$needs =$this->input->post('needs');
	
		// 	$data = array(
		// 		'ITEM_ID' => $item_id,
		// 		'PERIOD' => $Periode,
		// 		'NEEDS' => $needs
		// 	);
		// 	$cekcek= $this->M_input->cekData($item_id, $Periode);
		// 	// echo '<pre>';
		// 	// echo count($cekcek);
		// 	// exit();
		// 	if (count($cekcek)>0){
		// 		$this->M_input->updateData($item_id, $Periode, $needs);
		// 	}else{
		// 	$this->M_input->saveData($data);}
		// 	redirect(base_url('PerhitunganLoadingODM/Input'));
		// }
		public function saveDatacsv(){
			$item_code[] = $this->input->post('itemcode[]');
			$period[] = $this->input->post('period[]');
			$needs[] = $this->input->post('needs[]');
			$orgcode[] = $this->input->post('orgcode[]');
			$semua  = array();
			for ($i=0; $i < sizeof($item_code) ; $i++) {
				foreach ($item_code[$i] as $it) {
					$ini[] = $this->M_input->getitemid2($it);
				}		
				foreach ($period[$i] as $pr) {
					$per[] = $pr;
				}
				foreach ($needs[$i] as $ne) {
					$need[] = $ne;
					
				}
				foreach ($orgcode[$i] as $orgcode2) {
					$orgcode3 = $orgcode2;
					
					$inilagi[] = $this->M_input->getorgid($orgcode3);
					
				}
				foreach ($inilagi as $og) {
					$ogid[] = $og[0];
					}
				for ($c=0; $c < sizeof($per) ; $c++) { 
					$data = array(
						'ITEM_ID' => $ini[$c][0]['ITEM_ID'],
						'PERIOD' => $per[$c],
						'NEEDS' => $need[$c],
						'ORG_ID' => $ogid[$c]['ORGANIZATION_ID']
					); 
				$semua[] = $data;	
				}
			}
			foreach ($semua as $k) {
				$cekcek= $this->M_input->cekDataPerubahan($k['ITEM_ID'], $k['PERIOD']);
				if (count($cekcek)>0){
					$this->M_input->updatePerubahan($k['ITEM_ID'], $k['PERIOD'], $k['NEEDS'], $k['ORG_ID']);
				}else{
					$this->M_input->savePerubahan($semua);}
			}
			redirect('PerhitunganLoadingODM/Input');
		}

		public function exportCSV(){ 
			$filename = 'LayoutCSV_'.date('d-m-Y').'.csv'; 
			header("Content-Description: File Transfer"); 
			header("Content-Disposition: attachment; filename=$filename"); 
			header("Content-Type: application/csv; ");	 
			// get data 
			// $usersData = $this->M_input->getDataCsv();
			// file creation 
			$file = fopen('php://output', 'w');
			$header = array("ORGANIZATION_CODE","ITEM_CODE","PERIOD","NEEDS"); 
			fputcsv($file, $header);
			exit; 
		}
}