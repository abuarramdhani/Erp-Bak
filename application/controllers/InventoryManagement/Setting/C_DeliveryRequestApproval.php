<?php
class C_DeliveryRequestApproval extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			$this->load->model('CustomerRelationship/Setting/M_buyingtype');
			$this->load->model('InventoryManagement/Setting/M_deliveryrequestapproval');
			$this->load->model('InventoryManagement/MainMenu/M_deliveryrequest');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper('url');
			$this->checkSession();
			
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
			$data['Approval'] = $this->M_deliveryrequestapproval->getApprover();
			$data['Title'] = 'Delivery Request Approver';
			$data['Menu'] = 'Setting';//menu title
			$data['SubMenuOne'] = 'Delivery Request';
			$data['SubMenuTwo'] = 'Delivery Request Approval';
			
			$user_id = $this->session->userid;
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			//$this->load->view('templates/header', $data);
			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('InventoryManagement/Setting/DeliveryRequestApproval/V_index', $data);
			$this->load->view('V_Footer',$data);
			//$this->load->view('templates/footer');
	}
	
	public function Create()
	{		
			$this->form_validation->set_rules('slcApprover', 'approver', 'required');
			
			$user_id = $this->session->userid;
			
			$data['Title'] = 'Delivery Request Approver Create';
			$data['Menu'] = 'Setting';//menu title
			$data['SubMenuOne'] = 'Delivery Request';
			$data['SubMenuTwo'] = 'Delivery Request Approval';
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
						
			$data['Branch'] = $this->M_deliveryrequestapproval->getOrganizationUnit();
			
			if ($this->form_validation->run() === FALSE)
			{
					//$this->load->view('templates/header', $data);
					
					$this->load->view('V_Header',$data);
					$this->load->view('V_Sidemenu',$data);
					$this->load->view('InventoryManagement/Setting/DeliveryRequestApproval/V_create', $data);
					$this->load->view('V_Footer',$data);
					//$this->load->view('templates/footer');

			}
			else
			{	//$branch = 	$this->input->post('slcBranch');
				// sort($branch);
				// $cabang = implode(",",$branch);
				
				$employee = $this->M_deliveryrequest->getPeople(intval($this->input->post('slcApprover')));
				$employee_number = $employee[0]['NATIONAL_IDENTIFIER'];
				$employee_name = $employee[0]['FULL_NAME'];
				// print_r($cabang);
					$data = array(
						'EMPLOYEE_ID' 				=> $this->input->post('slcApprover'),
						'EMPLOYEE_NUMBER' 			=> $employee_number,
						'EMPLOYEE_NAME' 			=> $employee_name,
						'ACTIVE_FLAG' 				=> $this->input->post('slcActive'),
						// 'ORG_ID'					=> $cabang,
						'CREATION_DATE'				=> date("d-M-Y H:i:s"),
						'CREATED_BY' 				=> $this->input->post('hdnUser')
					);
					
					
					$this->M_deliveryrequestapproval->setApprover($data);
					redirect('InventoryManagement/DeliveryRequestApproval/');
			}
	}
		
	public function Update($id)
	{	$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['Title'] = 'Delivery Request Approver Update';
		$data['Menu'] = 'Setting';//menu title
		$data['SubMenuOne'] = 'Delivery Request';
		$data['SubMenuTwo'] = 'Delivery Request Approval';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['Branch'] = $this->M_deliveryrequestapproval->getOrganizationUnit();
		$data['Approver'] = $this->M_deliveryrequestapproval->getApprover($plaintext_string);
		
		$data['id'] = $id;
		
		$this->form_validation->set_rules('slcApprover', 'menuname', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('InventoryManagement/Setting/DeliveryRequestApproval/V_update',$data);
				$this->load->view('V_Footer',$data);

		}
		else
		{		
				$employee = $this->M_deliveryrequest->getPeople(intval($this->input->post('slcApprover')));
				$employee_number = $employee[0]['NATIONAL_IDENTIFIER'];
				$employee_name = $employee[0]['FULL_NAME'];
				// print_r($cabang);
					$data = array(
						'EMPLOYEE_ID' 				=> $this->input->post('slcApprover'),
						'EMPLOYEE_NUMBER' 			=> $employee_number,
						'EMPLOYEE_NAME' 			=> $employee_name,
						'ACTIVE_FLAG' 				=> $this->input->post('slcActive'),
						// 'ORG_ID'					=> $cabang,
						'LAST_UPDATE_DATE'			=> date("d-M-Y H:i:s"),
						'LAST_UPDATED_BY' 			=> $this->input->post('hdnUser')
					);
					
					
					$this->M_deliveryrequestapproval->updateApprover($data,$plaintext_string);
					redirect('InventoryManagement/DeliveryRequestApproval/');
		}
	
	}
		
}