<?php
class C_Customer extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/MainMenu/M_customer');
                $this->load->model('CustomerRelationship/MainMenu/M_customergroup');
				$this->load->model('CustomerRelationship/MainMenu/M_customercontacts');
				$this->load->model('CustomerRelationship/MainMenu/M_customerdriver');
				$this->load->model('CustomerRelationship/MainMenu/M_ownership');
				$this->load->model('CustomerRelationship/MainMenu/M_customerrelation');
				$this->load->model('CustomerRelationship/Setting/M_customercategory');
				$this->load->model('CustomerRelationship/Setting/M_customeradditional');
				$this->load->model('SystemAdministration/MainMenu/M_province');
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
		{		$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

				$data['Customer'] = $this->M_customer->getCustomer();
				$data['title'] = 'Customer';
				$data['Menu'] = 'Customer';
				$data['SubMenuOne'] = '';
				
				$data['categories']=$this->M_customercategory->getAllCategory();
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/MainMenu/Customer/V_index', $data);
				$this->load->view('V_Footer',$data);
		}

		public function AjaxSearching()
		{
				$name = $this->input->get('name');
				$village = $this->input->get('village');
				$city = $this->input->get('city');
				$category = $this->input->get('category');
				//$data['Customer'] = $this->M_customer->getFilteredCustomer($nama,$village,$city,$category);
				$data['Customer'] = $this->M_customer->getCustomerSearch($name,$village,$city,$category);
				$this->load->view('CustomerRelationship/MainMenu/Customer/V_ajax_cari',$data);
		}

		public function Details($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$jenis = 'INTEGER';
				$data['Customer'] = $this->M_customer->getCustomer($plaintext_string,$jenis);
				$data['CustomerRelation'] = $this->M_customerrelation->getCustomerRelation($plaintext_string);
				$data['CustomerAdditional'] = $this->M_customeradditional->getCustomerAdditional($plaintext_string);
				$data['CustomerContact'] = $this->M_customercontacts->getCustomerContacts($plaintext_string);
				$data['CustomerSite'] = $this->M_customer->getCustomerSite($plaintext_string);
				$data['CustomerDriver'] = $this->M_customerdriver->getCustomerDriver($plaintext_string);
				$data['Ownership'] = $this->M_ownership->getOwnership($plaintext_string);
				$data['AdditionalInfo'] = $this->M_customeradditional->getAdditionalInfo($plaintext_string);

				$data['title'] = 'Customer';
				$data['Menu'] = 'Customer';
				$data['SubMenuOne'] = '';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/MainMenu/Customer/V_details', $data);
				$this->load->view('V_Footer',$data);
		}

		public function Update($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$jenis = 'INTEGER';
				$data['Customer'] = $this->M_customer->getCustomer($plaintext_string,$jenis);
				$data['CustomerCategory'] = $this->M_customercategory->getCustomerCategory();
				$data['CustomerGroup'] = $this->M_customergroup->getCustomerGroup();
				$Cust = $this->M_customer->getCustomer($plaintext_string,$jenis);
				foreach($Cust as $st){
					$pr_id = $st['province_id'];
					$rg_id = $st['city_regency_id'];
					$ds_id = $st['district_id'];
					$vi_id = $st['village_id'];
				}
				if($pr_id == null){ $pr_id = "0";}
				if($rg_id == null){ $rg_id = "0";}
				if($ds_id == null){ $ds_id = "0";}
				if($vi_id == null){ $vi_id = "0";}
				//$data['Province'] = $this->M_province->getProvince();
				$data['Province'] = $this->M_province->getAllProvinceArea();
				$data['Regency'] = $this->M_province->getAllRegencyArea($pr_id);
				$data['District'] = $this->M_province->getAllDistrictArea($rg_id);
				//$data['ds_id'] = $ds_id;
				$data['Village'] = $this->M_province->getAllVillageArea($ds_id);

				$data['title'] = 'Update Customer';
				$data['Menu'] = 'Customer';
				$data['SubMenuOne'] = '';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/MainMenu/Customer/V_update', $data);
				$this->load->view('V_Footer',$data);
		}
		
		public function PostUpdateToDb()
		{		


				$this->form_validation->set_rules('txtCustomerName', 'Customer', 'required');
				$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');

				$id = $this->input->post('hdnCustomerId');

				$data['title'] = 'Update Customer';

				$data=array(
					'customer_name'				=> strtoupper($this->input->post('txtCustomerName')),
					'id_number'					=> $this->input->post('txtIdNumber'),
					'address' 					=> $this->input->post('txtAddress'),
					'province_id' 				=> strtoupper($this->input->post('txtProvince')),
					'city_regency_id' 			=> $this->input->post('txtCityRegency'),
					'village_id' 				=> $this->input->post('txtVillage'),
					'district_id' 				=> $this->input->post('txtDistrict'),
					'rt' 						=> $this->input->post('txtRt'),
					'rw' 						=> $this->input->post('txtRw'),
					//'customer_status_id' 		=> $this->input->post('hdnCustomerStatusId'),
					'customer_group_id' 		=> $this->input->post('slcCustGroup'),
					//'customer_category_id' 		=> $this->input->post('slcCustCategory'),
					'start_date'				=> $this->input->post('txtStartDate'),
					'end_date'					=> $this->input->post('txtEndDate'),
					'last_update_date'			=> $this->input->post('hdnDate'),
					'last_updated_by'			=> $this->input->post('hdnUser')
					);

					if($data['end_date'] == '')
					{	$data['end_date'] = NULL; }
					if($data['customer_group_id'] == '')
					{	$data['customer_group_id'] = NULL; }

				$this->M_customer->postUpdate($data, $id);
				$encrypted_string = $this->encrypt->encode($id);
				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
				
				redirect('CustomerRelationship/Customer/Details/'.$encrypted_string);
		}

        public function Create()
		{
				$this->form_validation->set_rules('txtCustomerName', 'Customer', 'required');
				//$this->form_validation->set_rules('txtCustomerCategory', 'Customer Category', 'required');
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['title'] = 'New Customer';
				$data['Province'] = $this->M_province->getAllProvinceArea();
				$data['CustomerCategory'] = $this->M_customercategory->getCustomerCategory();
				$data['CustomerGroup'] = $this->M_customergroup->getCustomerGroup();
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_create', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							'customer_name'				=> strtoupper($this->input->post('txtCustomerName')),
							'id_number'					=> $this->input->post('txtIdNumber'),
							'address' 					=> strtoupper($this->input->post('txtAddress')),
							'province_id' 				=> $this->input->post('txtProvince'),
							'city_regency_id' 			=> $this->input->post('txtCityRegency'),
							'village_id' 				=> $this->input->post('txtVillage'),
							'district_id' 				=> $this->input->post('txtDistrict'),
							'rt' 						=> $this->input->post('txtRt'),
							'rw' 						=> $this->input->post('txtRw'),
							//'customer_status_id' 		=> $this->input->post('hdnCustomerStatusId'),
							'customer_group_id' 		=> $this->input->post('slcCustGroup'),
							//'customer_category_id' 		=> $this->input->post('slcCustCategory'),
							'start_date'				=> $this->input->post('txtStartDate'),
							'end_date'					=> $this->input->post('txtEndDate'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);


						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }
						if($data['customer_group_id'] == '')
						{	$data['customer_group_id'] = NULL; }

						$this->M_customer->setCustomer($data);

						$service_id = $this->M_customer->getCustomerId();
						$id = $service_id[0]['customer_id'];
						
						$data2 = array(
							'customer_id'				=> $id,
							'category_id' 				=> $this->input->post('slcCustCategory'),
							'start_date'				=> $this->input->post('txtStartDate'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser'),
							//'active_status'				=> $this->input->post('hdnActiveStatus'),
							'owner_id'					=> NULL,
							'description'				=> NULL
						);
						
						
						if($data2['category_id'] == '')
						{	$data2['category_id'] = NULL; }
						
						$this->M_customerrelation->setCustomerRelation($data2);

						$encrypted_string = $this->encrypt->encode($id);
						$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

						redirect('CustomerRelationship/Customer/Details/'.$encrypted_string);
						//print_r($id);
				}
		}

		public function CreateContact($id)
		{
				$this->form_validation->set_rules('txtData', 'Data', 'required');
				//$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);

				$data['title'] = 'New Contact';
				$data['id'] = $id;

				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_create_contacts', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							'name'					=> strtoupper($this->input->post('txtContactName')),
							'data'					=> $this->input->post('txtData'),
							'type' 					=> $this->input->post('txtType'),
							'connector_id' 			=> $plaintext_string,
							'table' 				=> 'cr.cr_customers',
							'creation_date' 		=> $this->input->post('hdnDate'),
							'created_by' 			=> $this->input->post('hdnUser')
						);

						/*if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }
						if($data['customer_status_id'] == '')
						{	$data['customer_status_id'] = NULL; }
						if($data['customer_group_id'] == '')
						{	$data['customer_group_id'] = NULL; }
						*/
						$this->M_customercontacts->setCustomerContacts($data);
						redirect('CustomerRelationship/Customer/Details/'.$id);
				}
		}

		public function UpdateContact($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$customer_id = $this->encrypt->encode($this->input->post('hdnConnectorId'));
				$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);

				$data['CustomerContact'] = $this->M_customercontacts->getCustomerContactsId($plaintext_string);
				$data['title'] = 'Update Contact';
				$data['id'] = $id;

				$this->form_validation->set_rules('txtData', 'Data', 'required');

				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';

						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_update_contacts', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							'name'					=> strtoupper($this->input->post('txtContactName')),
							'data'					=> $this->input->post('txtData'),
							'type' 					=> $this->input->post('txtType'),
							//'connector_id' 			=> $customer_id,
							'table' 				=> 'cr.cr_customers',
							'last_update_date' 		=> $this->input->post('hdnDate'),
							'last_updated_by' 		=> $this->input->post('hdnUser')
						);
						/*
						$encrypted_string = $this->encrypt->encode($data['customer_id']);
						$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
*/
						$this->M_customercontacts->postUpdate($data, $plaintext_string);

						//$this->load->view('V_Header',$data);

						redirect('CustomerRelationship/Customer/Details/'.$customer_id);
				}

		}

		public function DeleteContacts($id_contact,$id_cust)
		{		$id_contact = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_contact);
				$id_contact = $this->encrypt->decode($id_contact);

				$this->M_customercontacts->deleteContacts($id_contact);
				redirect('CustomerRelationship/Customer/'.$id_cust);
		}

		public function CreateSite($id)
		{		

				$this->form_validation->set_rules('txtSiteName', 'Site Name', 'required');
				//$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);

				$data['title'] = 'New Site';
				$data['id'] = $id;
				$data['Province'] = $this->M_province->getAllProvinceArea();
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_create_site', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							'site_name'					=> strtoupper($this->input->post('txtSiteName')),
							'customer_id'				=> $plaintext_string,
							'address' 					=> $this->input->post('txtAddress'),
							'province_id' 				=> $this->input->post('txtProvince'),
							'city_regency_id' 			=> $this->input->post('txtCityRegency'),
							'village_id' 				=> $this->input->post('txtVillage'),
							'district_id' 				=> $this->input->post('txtDistrict'),
							'rt' 						=> $this->input->post('txtRt'),
							'rw' 						=> $this->input->post('txtRw'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);

						$this->M_customer->setCustomerSite($data);
						redirect('CustomerRelationship/Customer/Details/'.$id);
				}
		}

		public function UpdateSite($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				
				$data['CustomerSite'] = $this->M_customer->getCustomerSiteDetails($plaintext_string);
				$data['title'] = 'Update Site';
				$data['id'] = $id;
				
				$site = $this->M_customer->getCustomerSiteDetails($plaintext_string);
				foreach($site as $st){
					$pr_id = $st['province_id'];
					$rg_id = $st['city_regency_id'];
					$ds_id = $st['district_id'];
					$vi_id = $st['village_id'];
				}

				//$pr_id = "33";
				$data['Province'] = $this->M_province->getAllProvinceArea();
				$data['Regency'] = $this->M_province->getAllRegencyArea($pr_id);
				$data['District'] = $this->M_province->getAllDistrictArea($rg_id);
				//$data['ds_id'] = $ds_id;
				$data['Village'] = $this->M_province->getAllVillageArea($ds_id);

				$this->form_validation->set_rules('txtSiteName', 'Site Name', 'required');

				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/Customer/V_update_site', $data);
						$this->load->view('V_Footer',$data);
				}
				else
				{
						$data = array(
							'site_name'					=> strtoupper($this->input->post('txtSiteName')),
							'customer_id'				=> $this->input->post('hdnCustomerSiteId'),
							'address' 					=> $this->input->post('txtAddress'),
							'province_id' 				=> $this->input->post('txtProvince'),
							'city_regency_id' 			=> $this->input->post('txtCityRegency'),
							'village_id' 				=> $this->input->post('txtVillage'),
							'district_id' 				=> $this->input->post('txtDistrict'),
							'rt' 						=> $this->input->post('txtRt'),
							'rw' 						=> $this->input->post('txtRw'),
							'last_update_date' 			=> $this->input->post('hdnDate'),
							'last_updated_by' 			=> $this->input->post('hdnUser')
						);

						$encrypted_string = $this->encrypt->encode($data['customer_id']);
						$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

						$this->M_customer->postUpdateSite($data, $plaintext_string);
						$this->load->view('V_Header',$data);
						redirect('CustomerRelationship/Customer/Details/'.$encrypted_string);
				}

		}

		public function CreateRelation($id)
		{
			$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
			$plaintext_string = $this->encrypt->decode($plaintext_string);

			$user_id = $this->session->userid;
				
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
			$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');
			//$category['category'] = $this->M_customerrelation->getAllCategory();
			$data['CustomerOwner']= $this->M_customer->getCustomerOwner();
			$data['categories']= $this->M_customercategory->getAllCategory($plaintext_string);
			//$data['Owner'] = $this->M_customer->getCustomerOwner();
			$data['title'] = 'New Category';
			$data['id'] = $id;

				if ($this->form_validation->run() === FALSE)
				{
						//
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_create_relation', $data);
						$this->load->view('V_Footer',$data);

						//$this->form_validation->set_rules('customer_category', 'Customer Category', 'required');
				}
				else
				{
						$data = array(
							'category_id'				=> $this->input->post('txtCategory'),
							'customer_id'				=> $plaintext_string,
							'owner_id' 					=> $this->input->post('slcCustOwner'),
							'start_date' 				=> $this->input->post('txtStartDate'),
							'end_date' 					=> $this->input->post('txtEndDate'),
							'description' 				=> $this->input->post('txtDescription'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);

						if($data['description'] == '')
						{	$data['description'] = NULL; }
						if($data['owner_id'] == '')
						{	$data['owner_id'] = NULL; }
						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }

						$this->M_customerrelation->setCustomerRelation($data);
						redirect('CustomerRelationship/Customer/Details/'.$id);
				}
		}

		public function CustomerSearch($id = FALSE)
		{		$id = str_replace("~", " ", $id);

				$data['Customer'] = $this->M_customer->getCustomer($id);
				$data['title'] = 'Customer';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/MainMenu/Customer/V_search_customer', $data);
		}

		public function UpdateRelation($id)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['CustomerRelation'] = $this->M_customerrelation->getCustomerRelationId($plaintext_string);
				$data['categories']=$this->M_customercategory->getAllCategory($data['CustomerRelation'][0]['customer_id'],$plaintext_string);
				$data['CustomerOwner']= $this->M_customer->getCustomerOwner();
				$data['title'] = 'Update Category';
				$data['id'] = $id;

				$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');

				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_update_relation', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							'category_id'				=> $this->input->post('txtCategory'),
							'customer_id'				=> $this->input->post('hdnCustRelationId'),
							'owner_id' 					=> $this->input->post('slcCustOwner'),
							'start_date' 				=> $this->input->post('txtStartDate'),
							'description' 				=> $this->input->post('txtDescription'),
							'last_update_date' 			=> $this->input->post('hdnDate'),
							'last_updated_by' 			=> $this->input->post('hdnUser'),
							'end_date' 					=> $this->input->post('txtEndDate')
						);

						if($data['description'] == '')
						{	$data['description'] = NULL; }
						if($data['owner_id'] == '')
						{	$data['owner_id'] = NULL; }
						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }

						$encrypted_string = $this->encrypt->encode($data['customer_id']);
						$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

						$this->M_customerrelation->postUpdate($data, $plaintext_string);
						$this->load->view('V_Header',$data);
						redirect('CustomerRelationship/Customer/Details/'.$encrypted_string);
				}

		}

		public function CreateAdditionalInfo($id)
		{
			$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
			$plaintext_string = $this->encrypt->decode($plaintext_string);
			
			$user_id = $this->session->userid;
				
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$this->form_validation->set_rules('slcCustAdditional', 'Start Date', 'required');
			$data['Additional']= $this->M_customeradditional->getCustomerAdditionalFiltered($plaintext_string);
			
			$data['title'] = 'New Additional Information';
			$data['id'] = $id;

				if ($this->form_validation->run() === FALSE)
				{
						//
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_create_additional', $data);
						$this->load->view('V_Footer',$data);
				}
				else
				{
						$data = array(
							'customer_id'				=> $plaintext_string,
							'additional_id' 			=> $this->input->post('slcCustAdditional'),
							'start_date' 				=> $this->input->post('txtStartDate'),
							'end_date' 					=> $this->input->post('txtEndDate'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);

						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }

						$encrypted_string = $this->encrypt->encode($data['customer_id']);
						$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

						$this->M_customeradditional->setAdditionalInfo($data);
						redirect('CustomerRelationship/Customer/Details/'.$id);
				}
		}

		public function UpdateAdditionalInfo($id)
		{
			$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
			$plaintext_string = $this->encrypt->decode($plaintext_string);
			
			$user_id = $this->session->userid;
				
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$data['AdditionalInfo'] = $this->M_customeradditional->getAdditionalInfoId($plaintext_string);
			
			$data['Additional']= $this->M_customeradditional->getCustomerAdditionalFiltered($data['AdditionalInfo'][0]['customer_id'],$plaintext_string);
			
			$data['title'] = 'Update Additional Information';
			$data['id'] = $id;

			$this->form_validation->set_rules('txtStartDate', 'Start Date', 'required');

				if ($this->form_validation->run() === FALSE)
				{
						//
						$data['Menu'] = 'Customer';
						$data['SubMenuOne'] = '';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/Customer/V_update_additional', $data);
						$this->load->view('V_Footer',$data);
				}
				else
				{
						$data = array(
							'customer_id'				=> $this->input->post('hdnCustomerId'),
							'additional_id' 			=> $this->input->post('slcCustAdditional'),
							'start_date' 				=> $this->input->post('txtStartDate'),
							'end_date' 					=> $this->input->post('txtEndDate'),
							'last_update_date' 			=> $this->input->post('hdnDate'),
							'last_updated_by' 			=> $this->input->post('hdnUser')
						);

						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }

						$encrypted_string = $this->encrypt->encode($data['customer_id']);
						$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

						$this->M_customeradditional->postUpdateInfo($data, $plaintext_string);
						$this->load->view('V_Header',$data);
						redirect('CustomerRelationship/Customer/Details/'.$encrypted_string);
				}
		}
}
