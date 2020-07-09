<?php
class C_Ownership extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/MainMenu/M_ownership');
				$this->load->model('CustomerRelationship/MainMenu/M_customer');
				$this->load->model('CustomerRelationship/Setting/M_buyingtype');
				$this->load->model('EmployeeRecruitment/MainMenu/M_employee');
				$this->load->model('InventoryManagement/MainMenu/M_item');
				$this->load->model('SystemAdministration/MainMenu/M_user');
				$this->load->library('encrypt');
				//$this->load->helper('url');
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
				$data['Ownership'] = $this->M_ownership->getOwnership();
				$data['title'] = 'Ownership';

				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Ownership/V_index', $data);
				//$this->load->view('templates/footer');
		}
		
		public function CustomerSearch($id = FALSE)
		{		$id = str_replace("~", " ", $id);
		
				$data['Customer'] = $this->M_customer->getCustomer($id);
				$data['title'] = 'Customer';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Search/V_search_customer', $data);
		}
		
		public function EmployeeSearch($id = FALSE)
		{		$id = str_replace("~", " ", $id);
		
				$data['Employee'] = $this->M_employee->getEmployee($id);
				$data['title'] = 'Employee';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Search/V_search_employee', $data);
		}
		
		public function ItemSearch($id = FALSE)
		{		
				$id = str_replace("~", " ", $id);
		
				$data['Item'] = $this->M_item->getItem($id);
				$data['title'] = 'Item';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Search/V_search_item', $data);
		}
		
		public function searchBuyingType($id = FALSE)
		{		
				$id = str_replace("~", " ", $id);
		
				$data['BuyingType'] = $this->M_buyingtype->getBuyingTypeName($id);
				$data['title'] = 'Buying Type';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/Search/V_search_buying_type', $data);
		}
		
		public function Create($id)
		{			
				$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['Customer'] = $this->M_customer->getCustomer();
				$data['Employee'] = $this->M_employee->getEmployee();
				$data['Item'] = $this->M_item->getItem();
				$data['Unit'] = $this->M_item->getItemHarvester();
				$data['BuyingType'] = $this->M_buyingtype->getBuyingTypeName();
				$data['Goverment'] = $this->M_ownership->getGoverment();

				$this->form_validation->set_rules('slcUnit', 'Body Number', 'required');
				//$this->form_validation->set_rules('txtEngineNumber', 'Engine Number', 'required');
				
				$data['title'] = 'New Customer Ownership';
				$data['id'] = $id;
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = "Customer";
						$data['SubMenuOne'] = '';
						//$this->load->view('templates/header', $data);
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Ownership/V_create', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');	
				}
				else
				{	
						$data = array(
							'no_body' => $this->input->post('txtBodyNumber'),
							'no_engine' => $this->input->post('txtEngineNumber'),
							'customer_id' => $plaintext_string,
							'employee_id' => $this->input->post('slcEmployee'),
							'item_id' => $this->input->post('slcUnit'),
							'buying_type_id' => $this->input->post('slcBuyingType'),
							'ownership_date' => $this->input->post('txtOwnershipDate'),
							'creation_date' => $this->input->post('hdnDate'),
							'created_by' => $this->input->post('hdnUser'),
							'warranty_expired_date' => $this->input->post('txtWarrantyExpiredDate'),
							'goverment_project' => $this->input->post('slcGov')
						);
						
						if($data['ownership_date'] == '')
						{	$data['ownership_date'] = NULL; }
						if($data['employee_id'] == '')
						{	$data['employee_id'] = NULL; }
						if($data['warranty_expired_date'] == '')
						{	$data['warranty_expired_date'] = NULL; }
					
						$this->M_ownership->setOwnership($data);
						redirect('CustomerRelationship/Customer/Details/'.$id);
				}
		}
		
		public function Update($id/*id ownership produk*/)
		{		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$customer_id = $this->encrypt->encode($this->input->post('hdnCustomerId'));
				$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);
				
				$data['Ownership'] = $this->M_ownership->getOwnershipId($plaintext_string);
				$data['Goverment'] = $this->M_ownership->getGoverment();
				$data['Employee'] = $this->M_employee->getEmployee();
				$data['Item'] = $this->M_item->getItem();
				$data['Unit'] = $this->M_item->getItemHarvester();
				$data['BuyingType'] = $this->M_buyingtype->getBuyingTypeName();

				$data['title'] = 'Update Ownership Customer';
				$data['id'] = $id;
				
				$this->form_validation->set_rules('slcUnit', 'Body Number', 'required');
				
				if ($this->form_validation->run() === FALSE)
				{
					$data['Menu'] = "Customer";
						$data['SubMenuOne'] = '';
					//$this->load->view('templates/header', $data);
					$this->load->view('V_Header',$data);
					$this->load->view('V_Sidemenu',$data);
					$this->load->view('CustomerRelationship/MainMenu/Ownership/V_update', $data);
					$this->load->view('V_Footer',$data);
					//$this->load->view('templates/footer');
				}
				else
				{	
						$data = array(
							'no_body' 			=> $this->input->post('txtBodyNumber'),
							'no_engine' 		=> $this->input->post('txtEngineNumber'),
							'customer_id' 		=> $this->input->post('hdnCustomerId'),
							'employee_id' 		=> $this->input->post('slcEmployee'),
							'item_id' 			=> $this->input->post('slcUnit'),
							'buying_type_id' 	=> $this->input->post('slcBuyingType'),
							'ownership_date' 	=> $this->input->post('txtOwnershipDate'),
							'last_update_date' 	=> $this->input->post('hdnDate'),
							'last_updated_by' 	=> $this->input->post('hdnUser'),
							'warranty_expired_date' => $this->input->post('txtWarrantyExpiredDate'),
							'goverment_project' => $this->input->post('slcGov')
						);
						
						if($data['ownership_date'] == '')
						{	$data['ownership_date'] = NULL; }
						if($data['employee_id'] == '')
						{	$data['employee_id'] = NULL; }
						if($data['warranty_expired_date'] == '')
						{	$data['warranty_expired_date'] = NULL; }

						$this->M_ownership->postUpdate($data, $plaintext_string);
						redirect('CustomerRelationship/Customer/Details/'.$customer_id);
				}		
						
		}
		
		public function ChangeOwnership($id/*id ownership produk*/)
		{		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$customer_id = $this->encrypt->encode($this->input->post('hdnFromCustomerId'));
				$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);
				
				$data['Ownership'] = $this->M_ownership->getOwnershipId($plaintext_string);
				$data['title'] = 'Change Ownership';
				$data['id'] = $id;
				
				$this->form_validation->set_rules('txtOwnershipChangeDate', 'Ownership Change Date', 'required');
				$this->form_validation->set_rules('txtOwnerName', 'To Customer Name', 'required');
				
				if ($this->form_validation->run() === FALSE)
				{
					$data['Menu'] = "Customer";
						$data['SubMenuOne'] = '';
					//$this->load->view('templates/header', $data);
					$this->load->view('V_Header',$data);
					$this->load->view('V_Sidemenu',$data);
					$this->load->view('CustomerRelationship/MainMenu/Ownership/V_change_ownership', $data);
					$this->load->view('V_Footer',$data);
					//$this->load->view('templates/footer');
				}
				else
				{	
						$data1 = array(
									/* 'no_body' => $this->input->post('txtBodyNumber'),
									'no_engine' => $this->input->post('txtEngineNumber'),
									'customer_id' => $this->input->post('hdnCustomerId'),
									'employee_id' => $this->input->post('hdnEmployeeId'),
									'item_id' => $this->input->post('hdnItemId'),
									'ownership_date' => $this->input->post('txtOwnershipDate'), */
									'ownership_change_date' => $this->input->post('txtOwnershipChangeDate'),
									'last_update_date' => $this->input->post('hdnDate'),
									'last_updated_by' => $this->input->post('hdnUser')
						);
						
						$data2 = array(
							'no_body' => $this->input->post('hdnNoBody'),
							'no_engine' => $this->input->post('hdnNoEngine'),
							'customer_id' => $this->input->post('hdnOwnerId'),
							'employee_id' => $this->input->post('hdnEmployeeId'),
							'item_id' => $this->input->post('hdnItemId'),
							'buying_type_id' => $this->input->post('hdnBuyingTypeId'),
							'ownership_date' => $this->input->post('txtOwnershipChangeDate'),
							'creation_date' => $this->input->post('hdnDate'),
							'created_by' => $this->input->post('hdnUser'),
							'warranty_expired_date' => $this->input->post('hdnWarranty')
						);
						
						if($data1['ownership_change_date'] == '')
						{	$data1['ownership_change_date'] = NULL; }

						if($data2['ownership_date'] == '')
						{	$data2['ownership_date'] = NULL; }
						if($data2['employee_id'] == '')
						{	$data2['employee_id'] = NULL; }
						if($data2['warranty_expired_date'] == '')
						{	$data2['warranty_expired_date'] = NULL; }
						
						$this->M_ownership->postUpdate($data1, $plaintext_string);
						//redirect('CustomerRelationship/Customer/'.$customer_id);
						$this->M_ownership->setOwnership($data2);
						redirect('CustomerRelationship/Customer/Details/'.$customer_id);
				}		
						
		}
}