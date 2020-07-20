<?php
class C_CustomerDriver extends CI_Controller {
		
        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/MainMenu/M_customerdriver');
				$this->load->model('CustomerRelationship/MainMenu/M_customer');
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
		{		$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['CustomerDriver'] = $this->M_customerdriver->getCustomerDriver();
				$data['title'] = 'Customer Driver';

				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/CustomerDriver/V_index', $data);
				//$this->load->view('templates/footer');
		}
		
		/*public function searchCustomer($id = FALSE)
		{		$id = str_replace("~", " ", $id);
		
				$data['Customer'] = $this->M_customer->getCustomer($id);
				$data['title'] = 'Customer';
				//$this->load->view('templates/header', $data);
				$this->load->view('CustomerRelationship/CustomerDriver/V_search_customer', $data);
		}
		*/
		
		public function Update($id/*id relation*/)
		{		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['CustomerDriver'] = $this->M_customerdriver->getCustomerDriverId($plaintext_string);
				$data['title'] = 'Update Driver';
				$data['id'] = $id;
				$data['Driver'] = $this->M_customerdriver->getDriver($data['CustomerDriver'][0]['owner_id'],$data['CustomerDriver'][0]['customer_id']);
				
				$this->form_validation->set_rules('slcCustDriver', 'Tractor Driver Name', 'required');
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = "Customer";
						$data['SubMenuOne'] = '';
						
						//$this->load->view('templates/header', $data);
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/CustomerDriver/V_update', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');

				}
				else
				{	
						$data_customer = $this->input->post('slcCustDriver');
						$ex_per = explode("-",$data_customer);
						$driver_id = $ex_per[0];
						$category_id = $ex_per[1]; 
						
						$data = array(
							'customer_id'				=> $driver_id ,
							'category_id' 				=> $category_id,
							'start_date'				=> $this->input->post('txtStartDate'),
							'end_date'					=> $this->input->post('txtEndDate'),
							'last_update_date' 			=> $this->input->post('hdnDate'),
							'last_updated_by' 			=> $this->input->post('hdnUser'),
							//'active_status'				=> $this->input->post('hdnActiveStatus'),
							'description'				=> $this->input->post('txtDescription')
						);
					
					if($data['end_date'] == '')
					{	$data['end_date'] = NULL; } 
					//$customer_id = $this->input->post('hdnOwnerId');
					
					$customer_id = $this->encrypt->encode($this->input->post('hdnOwnerId'));
					$customer_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $customer_id);

					$this->M_customerdriver->postUpdate($data, $plaintext_string);
					//$this->load->view('templates/header', $data);
					redirect('CustomerRelationship/Customer/Details/'.$customer_id);
					//$this->load->view('templates/footer');
				}
				
		}
		
        public function Create($id)
		{					
				$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				
				$this->form_validation->set_rules('slcCustDriver', 'Driver Name', 'required');
				//$this->form_validation->set_rules('txtTelephoneNumber', 'Telephone Number', 'required');
				
				$user_id = $this->session->userid;
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['title'] = 'New Customer Driver';
				$data['id'] = $id;
				$data['Driver'] = $this->M_customerdriver->getDriver($plaintext_string);
				
				
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = "Customer";
						$data['SubMenuOne'] = '';
						//$id = "";
						$data['Customer'] = $this->M_customer->getCustomer($id);
						//$this->load->view('templates/header', $data);
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/MainMenu/CustomerDriver/V_create', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');

				}
				else
				{		$data_customer = $this->input->post('slcCustDriver');
						$ex_per = explode("-",$data_customer);
						$driver_id = $ex_per[0];
						$category_id = $ex_per[1]; 
			
						$data = array(
							'customer_id'				=> $driver_id,
							'category_id' 				=> $category_id,
							'start_date'				=> $this->input->post('txtStartDate'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser'),
							'end_date'					=> $this->input->post('txtEndDate'),
							'owner_id'					=> $plaintext_string,
							'description'				=> $this->input->post('txtDescription')
						);
						
						if($data['description'] == '')
						{	$data['description'] = NULL; }
						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }
						
						$this->M_customerdriver->setCustomerDriver($data);
						redirect('CustomerRelationship/Customer/Details/'.$id);
				}
		}
}