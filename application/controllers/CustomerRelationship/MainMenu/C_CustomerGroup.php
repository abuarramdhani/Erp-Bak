<?php
class C_CustomerGroup extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/MainMenu/M_customergroup');
				$this->load->model('SystemAdministration/MainMenu/M_province');
				$this->load->model('CustomerRelationship/MainMenu/M_customer');
				$this->load->model('SystemAdministration/MainMenu/M_user');
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
		{		$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

				$data['CustomerGroup'] = $this->M_customergroup->getCustomerGroup();
				$data['title'] = 'Customer Group';
				$data['Menu'] = 'Customer Group';
				$data['SubMenuOne'] = '';
				$data['Province'] = $this->M_province->getAllProvinceArea();
				//$this->load->view('templates/header', $data);
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/MainMenu/CustomerGroup/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');


		}

		public function AjaxSearching()
		{
				/*
				$data['name'] = $this->input->get('name');
				$data['village'] = $this->input->get('village');
				$data['city'] = $this->input->get('city');
				$data['province'] = $this->input->get('province');
				*/

				$name = $this->input->get('name');
				$village = $this->input->get('village');
				$city = $this->input->get('city');
				$province = $this->input->get('province');

				//$category = $this->input->get('category');
				//$data['Customer'] = $this->M_customer->getFilteredCustomer($nama,$village,$city,$category);
				$data['CustomerGroup'] = $this->M_customergroup->getFilteredCustomerGroup($name,$village,$city,$province);
				$this->load->view('CustomerRelationship/MainMenu/CustomerGroup/V_ajax_cari',$data);
		}

		public function Details($id)
		{		
				$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['CustomerGroup'] = $this->M_customergroup->getCustomerGroup($plaintext_string);
				$data['CustomerGroupMember'] = $this->M_customergroup->getCustomerGroupMember($plaintext_string);
				$data['title'] = 'Customer Group';
				$data['Menu'] = 'Customer Group';
				$data['SubMenuOne'] = '';

				$data['title'] = 'Update Customer Group';

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/MainMenu/CustomerGroup/V_details', $data);
				$this->load->view('V_Footer',$data);
		}
		
		public function AddMember($id)
		{
				$this->load->helper('form');
				$this->load->library('form_validation');
				
				$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);

				$this->form_validation->set_rules('txtCustomerName', 'Customer Name', 'required');

				$id_cust = $this->input->post('hdnCustomerId');
			
				$data=array(
					'customer_group_id'			=> $plaintext_string,
					'last_update_date'			=> $this->input->post('hdnDate'),
					'last_updated_by'			=> $this->input->post('hdnUser')
					);
				
				$this->M_customer->postUpdate($data, $id_cust);
				
				$encrypted_string = $this->encrypt->encode($this->input->post('hdnCustomerGroupId'));
				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
				
				redirect('CustomerRelationship/CustomerGroup/Details/'.$id);

				
		}
		
		public function DeleteMember($id,$id_cust)
		{		
				$id=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$id= $this->encrypt->decode($id);
				
				$id_cust=str_replace(array('-', '_', '~'), array('+', '/', '='), $id_cust);
				$id_cust = $this->encrypt->decode($id_cust);
			
				$data=array(
					'customer_group_id'			=> (NULL),
					'last_update_date'			=> $this->input->post('hdnDate'),
					'last_updated_by'			=> $this->input->post('hdnUser')
					);
				
				$this->M_customer->postUpdateGroup($data, $id_cust);
				
				$encrypted_string = $this->encrypt->encode($id);
				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
				
				redirect('CustomerRelationship/CustomerGroup/Details/'.$encrypted_string);

				
		}

		public function Update($id)
		 {					
				$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['CustomerGroup'] = $this->M_customergroup->getCustomerGroup($plaintext_string);
				$data['title'] = 'Update Customer Group';
				$data['Menu'] = 'Customer Group';
				$data['SubMenuOne'] = '';

				$cust_group = $this->M_customergroup->getCustomerGroup($plaintext_string);
				foreach($cust_group as $st){
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

				//$this->load->view('templates/header', $data);
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/MainMenu/CustomerGroup/V_update', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}

		public function PostUpdateToDb()
		{
				$this->load->helper('form');
				$this->load->library('form_validation');

				$this->form_validation->set_rules('txtCustomerGroup', 'Customer Group', 'required');
				//$this->form_validation->set_rules('startDate', 'Start Date', 'required');

				$id = $this->input->post('hdnCustomerGroupId');

				$data['title'] = 'Update Customer Group';

				$data=array(
					'customer_group_name' 		=> strtoupper($this->input->post('txtCustomerGroup')),
					'address' 				    => strtoupper($this->input->post('txtAddress')),
					'province_id' 				=> $this->input->post('txtProvince'),
					'city_regency_id' 			=> $this->input->post('txtCityRegency'),
					'village_id' 				=> $this->input->post('txtVillage'),
					'district_id' 				=> $this->input->post('txtDistrict'),
					'last_update_date'			=> $this->input->post('hdnDate'),
					'last_updated_by'			=> $this->input->post('hdnUser')
					);

				$this->M_customergroup->postUpdate($data, $id);
				//$this->load->view('templates/header', $data);

				$encrypted_string = $this->encrypt->encode($this->input->post('hdnCustomerGroupId'));
				$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

				redirect('CustomerRelationship/CustomerGroup/Details/'.$encrypted_string);
				//$this->load->view('templates/footer');
		}

        public function Create()
		{

				$this->form_validation->set_rules('txtCustomerGroup', 'Customer Group', 'required');
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['title'] = 'New Customer Group';

				if ($this->form_validation->run() === FALSE)
				{		//$data['Province'] = $this->M_province->getProvince();
						$data['Province'] = $this->M_province->getAllProvinceArea();

						$data['Menu'] = 'Customer Group';
						$data['SubMenuOne'] = '';
						//$this->load->view('templates/header', $data);
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/CustomerGroup/V_create', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');

				}
				else
				{
						$data = array(
							'customer_group_name' 		=> strtoupper($this->input->post('txtCustomerGroup')),
							'address' 				    => strtoupper($this->input->post('txtAddress')),
							'province_id' 				=> $this->input->post('txtProvince'),
							'city_regency_id' 			=> $this->input->post('txtCityRegency'),
							'village_id' 				=> $this->input->post('txtVillage'),
							'district_id' 				=> $this->input->post('txtDistrict'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
							);

						$this->M_customergroup->setCustomerGroup($data);
						redirect('CustomerRelationship/CustomerGroup');
				}
		}
}
