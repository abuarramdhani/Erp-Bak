<?php
class C_CustomerCategory extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/Setting/M_customercategory');
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
				$data['CustomerCategory'] = $this->M_customercategory->getCustomerCategory();
				$data['title'] = 'Customer Category';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Customer Category';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/CustomerCategory/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function Update($id)
		{		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				$data['CustomerCategory'] = $this->M_customercategory->getCustomerCategory($plaintext_string);
				$data['title'] = 'Update Customer Category';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Customer Category';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/CustomerCategory/V_update', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function PostUpdateToDb()
		{		
				$this->form_validation->set_rules('txtCustCategory', 'Customer Category', 'required');
				$this->form_validation->set_rules('txtStartDate', 'Tanggal Aktif Dari', 'required');
				
				$id = $this->input->post('hdnCustomerCategoryId');
				
				$data['title'] = 'Update Customer Category';
				
				 $checked1 = $this->input->post('chkOwner');
				 $checked2 = $this->input->post('chkDriver');
					if(isset($checked1) == TRUE)
						{ $owner = 'Y'; }
					else
						{ $owner = 'N'; }
					
					if(isset($checked2) == TRUE)
						{ $driver = 'Y'; }
					else
						{ $driver = 'N'; }
				
				$data=array(			
					'customer_category_name'	=> strtoupper(trim($this->input->post('txtCustCategory'))),
					'owner'						=> $owner,
					'driver'					=> $driver,
					'start_date'				=> $this->input->post('txtStartDate'),
					'end_date'					=> $this->input->post('txtEndDate'),
					'last_update_date'			=> $this->input->post('hdnDate'),
					'last_updated_by'			=> $this->input->post('hdnUser')
					);
					
					if($data['end_date'] == '')
					{	$data['end_date'] = NULL; }
				
				$this->M_customercategory->postUpdate($data, $id, $owner);
				//$this->load->view('templates/header', $data);
				redirect('CustomerRelationship/Setting/CustomerCategory');
				//$this->load->view('templates/footer');
		}

        public function Create()
		{		
				$this->form_validation->set_rules('txtCustCategory', 'Customer Category', 'required');
				$this->form_validation->set_rules('txtStartDate', 'Tanggal Aktif Dari', 'required');
				
				$data['title'] = 'Create Customer Category';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				if ($this->form_validation->run() === FALSE)
				{
						//$this->load->view('templates/header', $data);
						$data['Menu'] = 'Setting';
						$data['SubMenuOne'] = 'Setting Customer Category';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/Setting/CustomerCategory/V_create', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');

				}
				else
				{	
					 $checked1 = $this->input->post('chkOwner');
					 $checked2 = $this->input->post('chkDriver');
						if(isset($checked1) == TRUE)
							{ $owner = 'Y'; }
						else
							{ $owner = 'N'; }
						
						if(isset($checked2) == TRUE)
							{ $driver = 'Y'; }
						else
							{ $driver = 'N'; }
					
						$data=array(			
							'customer_category_name'	=> strtoupper(trim($this->input->post('txtCustCategory'))),
							'owner'						=> $owner,
							'driver'					=> $driver,
							'start_date'				=> $this->input->post('txtStartDate'),
							'end_date'					=> $this->input->post('txtEndDate'),
							'last_update_date'			=> $this->input->post('hdnDate'),
							'last_updated_by'			=> $this->input->post('hdnUser')
							);
						
						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }
						
						$this->M_customercategory->setCustomerCategory($data, $owner);
						redirect('CustomerRelationship/Setting/CustomerCategory');
				}
		}
		
}