<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring_Seksi extends CI_Controller {
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
		$this->load->model('MonitoringKomponen/MainMenu/M_monitoring_seksi');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
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
		$this->load->view('MonitoringKomponen/MainMenu/V_Monitoring_Seksi', $data);
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
		 $sub_sour	= $this->input->post('subinv_from',true);
		 $loc_sour	= $this->input->post('locator_from',true);
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
					$order = "min((case when (select (select flv.DESCRIPTION from FND_LOOKUP_Values flv where flv.LOOKUP_TYPE = 'ITEM_TYPE' and flv.LOOKUP_CODE = msib_type.ITEM_TYPE) ITEM_TYPE 
							  from mtl_system_items_b msib_type where msib_type.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID and msib_type.ORGANIZATION_ID = msib.ORGANIZATION_ID) like 'KHS%Buy%' then 'Suplier'
							  when ((select msib2.SEGMENT1 from mtl_system_items_b msib2 where msib2.SEGMENT1 like (select 'JAC'||substr(msib3.SEGMENT1,1,(LENGTH(msib3.SEGMENT1))-2)||'%' from mtl_system_items_b msib3 where msib3.SEGMENT1 = msib.SEGMENT1 AND msib3.ORGANIZATION_ID = 102 AND ROWNUM = 1 ) and rownum = 1)) is not null then 'Subkon'
							  else
							  (NVL((select fm.ATTRIBUTE2 || fm.ATTRIBUTE3 from FM_MATL_DTL fm 
							  where fm.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
							  and rownum =1),(NVL((select mil.SEGMENT1 from mtl_item_locations mil
							  where mil.INVENTORY_LOCATION_ID = (select bor.COMPLETION_LOCATOR_ID 
														   from bom_operational_routings bor 
														   where bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
														   and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
														   and rownum = 1)),(select bor.COMPLETION_SUBINVENTORY 
							  from bom_operational_routings bor 
							  where bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
							  and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
							  and rownum = 1)))))end)), msib.SEGMENT1 asc";
					break;
				case 2:
					$order = "min((case when (select (select flv.DESCRIPTION from FND_LOOKUP_Values flv where flv.LOOKUP_TYPE = 'ITEM_TYPE' and flv.LOOKUP_CODE = msib_type.ITEM_TYPE) ITEM_TYPE 
							  from mtl_system_items_b msib_type where msib_type.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID and msib_type.ORGANIZATION_ID = msib.ORGANIZATION_ID) like 'KHS%Buy%' then 'Suplier'
							  when ((select msib2.SEGMENT1 from mtl_system_items_b msib2 where msib2.SEGMENT1 like (select 'JAC'||substr(msib3.SEGMENT1,1,(LENGTH(msib3.SEGMENT1))-2)||'%' from mtl_system_items_b msib3 where msib3.SEGMENT1 = msib.SEGMENT1 AND msib3.ORGANIZATION_ID = 102 AND ROWNUM = 1 ) and rownum = 1)) is not null then 'Subkon'
							  else
							  (NVL((select fm.ATTRIBUTE2 || fm.ATTRIBUTE3 from FM_MATL_DTL fm 
							  where fm.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
							  and rownum =1),(NVL((select mil.SEGMENT1 from mtl_item_locations mil
							  where mil.INVENTORY_LOCATION_ID = (select bor.COMPLETION_LOCATOR_ID 
														   from bom_operational_routings bor 
														   where bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
														   and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
														   and rownum = 1)),(select bor.COMPLETION_SUBINVENTORY 
							  from bom_operational_routings bor 
							  where bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
							  and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
							  and rownum = 1)))))end)),(sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY), msib.SEGMENT1 asc";
					break;
				default:
					$order = "bor.COMPLETION_SUBINVENTORY,msib.SEGMENT1";
					break;
			}
		
		switch($lap){
			case 1:
				$lap = "and having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) < 0";
				break;
			case 2:
				$lap = "and having (sum(moqd.PRIMARY_TRANSACTION_QUANTITY) - msib.MAX_MINMAX_QUANTITY) > 0";
				break;
			default:
				$lap = "";
				break;
		}
		
		$data = $this->M_monitoring_seksi->tableView($tgl,$inv_from,$q_loc_sour,$inv_to,$q_loc_des,$comp,$order,$lap);
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
}