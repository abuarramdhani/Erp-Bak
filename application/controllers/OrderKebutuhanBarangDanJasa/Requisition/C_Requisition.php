<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Requisition extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('upload');		
          //load the login model
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
        	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
         }
        if($this->session->is_logged == FALSE){
            redirect();
        }
    }
    
    public function index()
	{   
		$user_id = $this->session->userid;
		
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

	public function searchItem()
	{
		$string = $_GET['q'];
		$data = $this->M_requisition->getItem(strtoupper($string));
		echo json_encode($data);
	}

    public function Input()
    {   
		// print_r($this->session);exit;
		$user_id = $this->session->userid;

		$noind = $this->session->user;

		
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Baru';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['pengorder'] = $this->M_requisition->getPersonId($noind);
		
		if ($this->session->responsibility_id == 2683) { //set admin atau bukan
			$data['requester'] = $this->M_requisition->getRequsterAdmin($noind);
		} else {
			$data['requester'] = $data['pengorder'];
		}
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_Input2',$data);
        $this->load->view('V_Footer',$data);
	}

	public function createOrder()
	{
		$noind = $this->session->user;

		$creator = $this->input->post('txtOKBOrderCreatorId');
		$requster = $this->input->post('txtOKBOrderRequesterId');
		$itemCode = $this->input->post('slcOKBinputCode[]');
		$description = $this->input->post('txtOKBinputDescription[]');
		$quantity = $this->input->post('txtOKBinputQty[]');
		$uom = $this->input->post('slcOKBuom[]');
		$nbd = $this->input->post('txtOKBnbd[]');
		$orderReason = $this->input->post('txtOKBinputReason[]');
		$orderNote = $this->input->post('txtOKBinputNote[]');
		$destination = $this->input->post('hdnDestinationOKB[]');
		$organization = $this->input->post('hdnOrganizationOKB[]');
		$location = $this->input->post('hdnLocationOKB[]');
		$subinventory = $this->input->post('hdnSubinventoyOKB[]');
		$urgentFlag = $this->input->post('hdnUrgentFlagOKB[]');
		$urgentReason = $this->input->post('txtOKBinputUrgentReason[]');
		$statusOrder = $this->input->post('txtOKBHdnStatusOrder');

		if ($subinventory == '') {
			$subinventory = null;
		}
		if ($urgentReason == '') {
			$urgentReason = null;
		}

		
		for ($i=0; $i < count($itemCode); $i++) { 
			$line = array(
							'CREATE_BY' => $creator, 
							'INVENTORY_ITEM_ID' => $itemCode[$i], 
							'QUANTITY' => $quantity[$i], 
							'UOM' => $uom[$i], 
							'ORDER_PURPOSE' => $orderReason[$i], 
							'NOTE_TO_PENGELOLA' => $orderNote[$i], 
							'ORDER_STATUS_ID' => 2, 
							'URGENT_FLAG' => $urgentFlag[$i], 
							'URGENT_REASON' => $urgentReason[$i], 
							'DESTINATION_TYPE_CODE' => $destination[$i], 
							'DESTINATION_ORGANIZATION_ID' => $organization[$i], 
							'DELIVER_TO_LOCATION_ID' => $location[$i], 
							'DESTINATION_SUBINVENTORY' => $subinventory[$i], 
							'ITEM_DESCRIPTION' => $description[$i], 
							'REQUESTER' => $requster, 
							'IS_SUSULAN' => $statusOrder, 
						);

			$order_id = $this->M_requisition->saveLine($line, date("Y-m-d", strtotime($nbd[$i])));

			if($urgentFlag[$i] == 'Y'){

				$setApprover = $this->M_requisition->setApproverItemUrgent($creator, $itemCode[$i]);
			}else {
							
				$setApprover = $this->M_requisition->setApproverItem($creator, $itemCode[$i]);
			}

			foreach ($setApprover as $key => $set) {
							
				$approver = array(
									'ORDER_ID' => $order_id[0]['ORDER_ID'],
									'APPROVER_ID' => $set['APPROVER'],
									'APPROVER_TYPE' => $set['APPROVER_LEVEL'],
								);
							
							
				$this->M_requisition->ApproveOrder($approver);
			}

			if ($creator != $requster) {
				if($urgentFlag[$i] == 'Y'){

					$setApproverRequester = $this->M_requisition->setApproverItemUrgent($requster, $itemCode[$i]);
				}else {
								
					$setApproverRequester = $this->M_requisition->setApproverItem($requster, $itemCode[$i]);
				}

				foreach ($setApproverRequester as $key => $set) {
							
					$approverRequester = array(
												'ORDER_ID' => $order_id[0]['ORDER_ID'],
												'APPROVER_ID' => $set['APPROVER'],
												'APPROVER_TYPE' => $set['APPROVER_LEVEL'],
											);
								
								
					$this->M_requisition->ApproveOrder($approverRequester);
				}
			}

			// upload files
			$x = $i + 1;
			$number_of_files = sizeof($_FILES['fileOKBAttachment'.$x]['tmp_name']);

			$files = $_FILES['fileOKBAttachment'.$x];

   			$config = array(
				   				'upload_path' => './assets/upload/Okebaja/',
								'allowed_types' => 'jpg|jpeg|png|zip|rar|doc|docx|xls|xlsx|pdf',
								'overwrite' => false,         
    			);

			$path = ('./assets/upload/Okebaja/');
			// print_r($files);exit;

			for ($j=0; $j < $number_of_files; $j++) { 
				$_FILES['fileOKBAttachment'.$x]['name']		= $files['name'][$j];
				$_FILES['fileOKBAttachment'.$x]['type']		= $files['type'][$j];
				$_FILES['fileOKBAttachment'.$x]['tmp_name']	= $files['tmp_name'][$j];
				$_FILES['fileOKBAttachment'.$x]['error']		= $files['error'][$j];
				$_FILES['fileOKBAttachment'.$x]['size']		= $files['size'][$j];
			}

			$this->upload->initialize($config);
				
			$this->upload->do_upload('fileOKBAttachment'.$x);

			$media	= $this->upload->data();
			$inputFileName 	= './assets/upload/Okebaja/'.$media['file_name'];
			if(is_file($inputFileName)){
				// echo('ada');
				chmod($inputFileName, 0777); ## this should change the permissions
			}else {
				// echo('nothing');
			}
			// $replaceFileName = str_replace(' ','_',$files['name'][$j]);
			$upload = array(
								'ORDER_ID' => $order_id[0]['ORDER_ID'],
								'ADDRESS' => $inputFileName,
								'ACTIVE_FLAG' => 'Y'
							);
			$this->M_requisition->uploadFiles($upload);
		}

		redirect('OrderKebutuhanBarangDanJasa/Requisition/Input', 'refresh');
	}

	public function listData()
	{
		$user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'List Order';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['pengorder'] = $this->M_requisition->getPengorder($noind);
		$data['listOrder'] = $this->M_requisition->getListDataOrder($noind);

		// echo '<pre>';
		// print_r($data['listOrder']);exit;
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_Listdata',$data);
        $this->load->view('V_Footer',$data);
	}

	public function getDestination()
	{
		$itemkode = $_POST['itemkode'];

		$data = $this->M_requisition->getDestination($itemkode);

		echo json_encode($data);
	}

	public function getOrganization()
	{
		$itemkode = $_POST['itemkode'];

		$data = $this->M_requisition->getOrganization($itemkode);

		echo json_encode($data);
	}

	public function getLocation()
	{
		$data = $this->M_requisition->getLocation();

		echo json_encode($data);
	}

	public function getSubinventory()
	{
		$organization = $_POST['organization'];

		$data = $this->M_requisition->getSubinventory($organization);

		echo json_encode($data);
	}
	
	public function getHistoryOrder() {
		$order_id = $this->input->post('orderid');
		$data	  = $this->M_requisition->getHistoryOrder($order_id);

		echo json_encode($data);
	}

	public function SetupApprover()
	{
		// print_r($this->session);exit;
		$user_id = $this->session->userid;

		$noind = $this->session->user;
		
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Setup Approver';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['pengorder'] = $this->M_requisition->getPersonId($noind);
		$person_id = $data['pengorder'][0]['PERSON_ID'];
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		if ($this->session->responsibility_id == 2683) {
			$data['activeRequestor'] = $this->M_requisition->getRequestor($person_id);

			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_SetupRequestor',$data);
		}else {
			$levelUnit = "AND oah.APPROVER_LEVEL = '5'";
			$levelDepartment = "AND oah.APPROVER_LEVEL = '8'";
	
			$data['approverUnit'] = $this->M_requisition->getApprover($person_id,$levelUnit);
			$data['approverDepartment'] = $this->M_requisition->getApprover($person_id,$levelDepartment);
			
			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_SetupApprover',$data);
		}
        $this->load->view('V_Footer',$data);
	}

	public function searchAtasan()
	{
		$string = $_GET['q'];
		$data = $this->M_requisition->getAtasan(strtoupper($string));

		echo json_encode($data);
	}

	public function setAtasan()
	{
		$noind = $this->session->user;
		$pengorder = $this->M_requisition->getPersonId($noind);

		// print_r($pengorder);exit;

		$unit = $this->input->post('slcAtasanUnitOKB');
		$department = $this->input->post('slcAtasanDepartmentOKB');

		$atasanUnit = array(
							'PERSON_ID' => $pengorder[0]['PERSON_ID'],
							'APPROVER_LEVEL' => 5,
							'APPROVER' => $unit,
						 );
		$this->M_requisition->setAtasan($atasanUnit);

		$atasanDepartment = array(
							'PERSON_ID' => $pengorder[0]['PERSON_ID'],
							'APPROVER_LEVEL' => 8,
							'APPROVER' => $department,
						);
		$this->M_requisition->setAtasan($atasanDepartment);
		
		$atasanDireksi = array(
							'PERSON_ID' => $pengorder[0]['PERSON_ID'],
							'APPROVER_LEVEL' => 9,
							'APPROVER' => 6355,
						);
		$this->M_requisition->setAtasan($atasanDireksi);

		redirect('OrderKebutuhanBarangDanJasa/Requisition/SetupApprover', 'refresh');
		
	}
	public function SetupUser()
	{
		$user_id = $this->session->userid;

		$noind = $this->session->user;
			
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Setup User';
		$data['SubMenuTwo'] = '';
			
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
		$data['pengorder'] = $this->M_requisition->getPersonId($noind);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_SetupUser',$data);
        $this->load->view('V_Footer',$data);
	}

	public function setUser()
	{
		$kasie = $this->input->post('slcAtasanOKB[]');
		$unit1 = $this->input->post('slcAtasanUnit1OKB[]');
		$unit2 = $this->input->post('slcAtasanUnit2OKB[]');
		$department = $this->input->post('slcAtasanDepartmentOKB[]');

		for ($i=0; $i < count($kasie); $i++) { 
			$atasanUnit = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 5,
				'APPROVER' => $unit1[$i],
			 );
			$this->M_requisition->setAtasan($atasanUnit);
			if ($unit2[$i] != '') {
				$atasanUnit2 = array(
					'PERSON_ID' => $kasie[$i],
					'APPROVER_LEVEL' => 5,
					'APPROVER' => $unit2[$i],
				 );
				$this->M_requisition->setAtasan($atasanUnit2);
			}

			$atasanPengelola = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 7,
			);
			$this->M_requisition->setAtasan($atasanPengelola);

			$atasanDepartment = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 8,
				'APPROVER' => $department[$i],
			);
			$this->M_requisition->setAtasan($atasanDepartment);

			$atasanUrgent = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 9,
				'APPROVER' => $department[$i],
			);
			$this->M_requisition->setAtasan($atasanUrgent);

			$atasanDireksi = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 10,
				'APPROVER' => 6355,
			);
			$this->M_requisition->setAtasan($atasanDireksi);
		}
		redirect('OrderKebutuhanBarangDanJasa/Requisition/SetupUser', 'refresh');
	}

	public function SetActiveApprover()
	{
		$approver = $_POST['approver'];
		$person_id = $_POST['person_id'];
		
		$this->M_requisition->setDeactiveApprover($approver,$person_id);
		$this->M_requisition->setActiveApprover($approver,$person_id);

		echo 1;
	}

	public function SetRequestor()
	{
		$person_id = $_POST['person_id'];
		$requestor = $_POST['requestor'];

		$this->M_requisition->removeRequestor($person_id);
		$data = array(
						'PERSON_ID' => $person_id,
						'APPROVER_LEVEL' => '3',
						'APPROVER' => $requestor,
					 );
		$this->M_requisition->setRequestor($data);

		echo 1;
	}
}