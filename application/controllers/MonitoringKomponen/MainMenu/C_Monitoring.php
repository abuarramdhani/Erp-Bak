<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('MonitoringKomponen/MainMenu/M_monitoring');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('excel');
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	public function Index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'MonitoringKomponen/Monitoring/CheckKomponen';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringKomponen/MainMenu/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getSubinventory(){
		$c	= strtoupper($this->input->get('term'));
		$getSubinventory = $this->M_monitoring->getSubinventory($c);
		echo json_encode($getSubinventory);
	}
	
	public function getLocator(){
		$si	= strtoupper($this->input->get('subin'));
		$c	= strtoupper($this->input->get('term'));
		$getLocator = $this->M_monitoring->getLocator($c,$si);
		echo json_encode($getLocator);
	}
	
	public function getKomponen(){
		$c	= strtoupper($this->input->get('term'));
		$getKomponen = $this->M_monitoring->getKomponen($c);
		echo json_encode($getKomponen);
	}
	
	public function getNamaKomponen(){
		$cd = $this->input->post('kode');
		$getKomponen = $this->M_monitoring->getKomponen($cd);
		foreach($getKomponen as $gc){
			$desc =  $gc['DESCRIPTION'];
		}
		echo $desc;
	}
	
	public function tableView(){
		
		 $tgl 		= $this->input->post('date',true);
		 $sub_sour	= 'INT-UPL';
		 $loc_sour	= '29';
		 $sub_des	= $this->input->post('subinv_to',true);
		 $loc_des	= $this->input->post('locator_to',true);
		 $cd_kom	= $this->input->post('kode',true);
		 $sort		= $this->input->post('sort',true);
		 $lap		= $this->input->post('report',true);
		 
		 if(empty($sub_sour)){
			 $inv_from = "";
		 }else{
			 $inv_from = "and bor.COMPLETION_SUBINVENTORY='$sub_sour'";
		 }
		 
		 if(empty($loc_sour)){
			 $q_loc_sour = "";
		 }else{
			 $q_loc_sour = "and mil.INVENTORY_LOCATION_ID='$loc_sour'";
		 }
		 
		 if(empty($sub_des)){
			 $inv_to = "";
		 }else{
			 $inv_to = "and bor.ATTRIBUTE1='$sub_des'";
		 }
		 
		 if(empty($loc_des)){
			 $q_loc_des = "";
		 }else{
			 $q_loc_des = "and bor.COMPLETION_LOCATOR_ID='$loc_des'";
		 }
		 
		 if(empty($cd_kom)){
			 $comp = "";
		 }else{
			 $comp = "and msib.SEGMENT1='$cd_kom'";
		 }
		 
		 switch ($sort) {
				case 1:
					$order = "mil.INVENTORY_LOCATION_ID, msib.SEGMENT1 asc";
					break;
				case 2:
					$order = "mil.INVENTORY_LOCATION_ID,(sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY), msib.SEGMENT1 asc";
					break;
				default:
					$order = "bor.COMPLETION_SUBINVENTORY,msib.SEGMENT1";
					break;
			}
		
		switch($lap){
			case 1:
				$lap = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) < 0";
				$qty = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) < 0";
				break;
			case 2:
				$lap = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0";
				$qty = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0";
				break;
			case 3:
				$lap = "";
				$qty = "and msib.MAX_MINMAX_QUANTITY is not null";
				break;
			case 4:
				$lap = "";
				$qty = "and msib.MAX_MINMAX_QUANTITY is null";
				break;
			default:
				$lap = "";
				$qty = "";
				break;
		}
		
		$data = $this->M_monitoring->tableView($tgl,$inv_from,$q_loc_sour,$inv_to,$q_loc_des,$comp,$order,$lap,$qty);
		$output = array();
		$a=1;
		$i=0;
		
		foreach($data as $k => $value) {
			$output[] = array_values($value);
			$id = $output[$i][0];
			$kode = $output[$i][1];
			$nama = $output[$i][2];
			$act = "<a class='btn btn-xs bg-maroon btn-sm' title='View Data'  href='".site_url()."assets/upload/$id' target='blank'><i class='fa fa-search'></i></a>	
					<a class='btn btn-xs bg-navy btn-sm' title='Download Data'  href='".site_url()."C_Component/download/$id'><i class='fa fa-download'></i></a>
					<a class='btn btn-xs bg-purple btn-sm' title='Edit' href='".site_url()."C_Component/ediitdata/tampil/$id'><i class='fa fa-edit'></i></a>
					<a class='btn btn-xs bg-red btn-sm' title='Delete' href='".site_url()."C_Component/insert/delete/$id' onclick='return confirm()'><i class='fa fa-trash'></i></a>
			";
			array_unshift($output[$i], "$a");
			array_push($output[$i], "$act");
				$a++;
			$i++;
		}
		echo json_encode(array('data' => $output));
	}
	
	public function check(){
	 	 $tgl 		= $this->input->post('date',true);
		 $sub_sour	= $this->input->post('txsAsalKomp',true);
		 $loc_sour	= $this->input->post('txsAsalLocator',true);
		 $sub_des	= $this->input->post('txsTujuanSub',true);
		 $loc_des	= $this->input->post('txsTujuanLocator',true);
		 $cd_kom	= $this->input->post('txsKodeKomp',true);
		 $sort		= $this->input->post('txsSort',true);
		 $lap		= $this->input->post('txsJenisLaporan',true);
		 
		  if(empty($sub_sour)){
			 $inv_from = "";
		 }else{
			 $inv_from = "and bor.COMPLETION_SUBINVENTORY='$sub_sour'";
		 }
		 
		 if(empty($loc_sour)){
			 $q_loc_sour = "";
		 }else{
			 $q_loc_sour = "and mil.INVENTORY_LOCATION_ID='$loc_sour'";
		 }
		 
		 if(empty($sub_des)){
			 $inv_to = "";
		 }else{
			 $inv_to = "and bor.ATTRIBUTE1='$sub_des'";
		 }
		 
		 if(empty($loc_des)){
			 $q_loc_des = "";
		 }else{
			 $q_loc_des = "and bor.COMPLETION_LOCATOR_ID='$loc_des'";
		 }
		 
		 if(empty($cd_kom)){
			 $comp = "";
		 }else{
			 $comp = "and msib.SEGMENT1='$cd_kom'";
		 }
		 
		 switch ($sort) {
				case 1:
					$order = "mil.INVENTORY_LOCATION_ID, msib.SEGMENT1 asc";
					break;
				case 2:
					$order = "mil.INVENTORY_LOCATION_ID,(sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY), msib.SEGMENT1 asc";
					break;
				default:
					$order = "bor.COMPLETION_SUBINVENTORY,msib.SEGMENT1";
					break;
			}
		
		switch($lap){
			case 1:
				$record = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) < 0";
				$group = ",mil.INVENTORY_LOCATION_ID";
				$qty = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) < 0";
				break;
			case 2:
				$record = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0";
				$group = ",mil.INVENTORY_LOCATION_ID";
				$qty = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0";
				break;
			case 3:
				$record = "";
				$group = "";
				$qty = "and msib.MAX_MINMAX_QUANTITY is not null";
				break;
			case 4:
				$record = "";
				$qty = "and msib.MAX_MINMAX_QUANTITY is null";
				break;
			default:
				$record = "";
				$group = "";
				$qty = "";
				break;
		}
		
		$data = $this->M_monitoring->tableView($tgl,$inv_from,$q_loc_sour,$inv_to,$q_loc_des,$comp,$order,$record,$qty,$group);
		// echo $data;
		$data['data'] = $data;
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'MonitoringKomponen/Monitoring/check';
		$data['export_xls'] = site_url('MonitoringKomponen/Monitoring/export_xls?ss='.$sub_sour.'&ls='.$loc_sour.'&sd='.$sub_des.'&ld='.$loc_des.'&cd='.$cd_kom.'&s='.$sort.'&l='.$lap.'');
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringKomponen/MainMenu/V_View', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function export_xls(){
		 $tgl 		= date('Y-m-d');
		 $sub_sour	= $this->input->get('ss',true);
		 $loc_sour	= $this->input->get('ls',true);
		 $sub_des	= $this->input->get('sd',true);
		 $loc_des	= $this->input->get('ld',true);
		 $cd_kom	= $this->input->get('cd',true);
		 $sort		= $this->input->get('s',true);
		 $lap		= $this->input->get('l',true);
		 
		  if(empty($sub_sour)){
			 $inv_from = "";
		 }else{
			 $inv_from = "and bor.COMPLETION_SUBINVENTORY='$sub_sour'";
		 }
		 
		 if(empty($loc_sour)){
			 $q_loc_sour = "";
		 }else{
			 $q_loc_sour = "and mil.INVENTORY_LOCATION_ID='$loc_sour'";
		 }
		 
		 if(empty($sub_des)){
			 $inv_to = "";
		 }else{
			 $inv_to = "and bor.ATTRIBUTE1='$sub_des'";
		 }
		 
		 if(empty($loc_des)){
			 $q_loc_des = "";
		 }else{
			 $q_loc_des = "and bor.COMPLETION_LOCATOR_ID='$loc_des'";
		 }
		 
		 if(empty($cd_kom)){
			 $comp = "";
		 }else{
			 $comp = "and msib.SEGMENT1='$cd_kom'";
		 }
		 
		 switch ($sort) {
				case 1:
					$order = "mil.INVENTORY_LOCATION_ID, msib.SEGMENT1 asc";
					break;
				case 2:
					$order = "mil.INVENTORY_LOCATION_ID,(sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY), msib.SEGMENT1 asc";
					break;
				default:
					$order = "bor.COMPLETION_SUBINVENTORY,msib.SEGMENT1";
					break;
			}
		
		switch($lap){
			case 1:
				$record = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) < 0";
				$group = ",mil.INVENTORY_LOCATION_ID";
				$r_jns = "1. Komp. yang melebihi max. simpan gudang.";
				$qty = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) < 0";
				break;
			case 2:
				$record = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0";
				$group = ",mil.INVENTORY_LOCATION_ID";
				$r_jns = "2. Komp. yang masih bisa disimpan gudang.";
				$qty = "having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0";
				break;
			case 3:
				$record = "";
				$group = "";
				$r_jns = "3. Komp. yang sudah ada qty max.";
				$qty = "and msib.MAX_MINMAX_QUANTITY is not null";
				break;
			case 4:
				$record = "";
				$qty = "and msib.MAX_MINMAX_QUANTITY is null";
				break;
			default:
				$record = "";
				$group = "";
				$r_jns = "4. Komp. yang belum sudah ada qty max.";
				$qty = "";
				break;
		}
		
		$data = $this->M_monitoring->tableView($tgl,$inv_from,$q_loc_sour,$inv_to,$q_loc_des,$comp,$order,$record,$qty,$group);
		// echo $data;
		$data['data'] = $data;
		$data['r_jns'] = $r_jns;
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringKomponen/Report/V_Excel_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}
}