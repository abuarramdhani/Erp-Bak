<?php
class C_CustomerAdditional extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('CustomerRelationship/Setting/M_customeradditional');
				$this->load->model('SystemAdministration/MainMenu/M_user');
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->load->library('session');
				$this->load->helper('url');
				//$this->checkSession();
        }
		
		/* public function checkSession(){
			if($this->session->is_logged){
				
			}else{
				redirect('');
			}
		} */
		
		public function index()
		{
				$data['CustomerAdditional'] = $this->M_customeradditional->getCustomerAdditional();
				$data['title'] = 'Additional Information';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Cust. Additional Info';
				
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/CustomerAdditional/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function Create()
		{		
				$this->form_validation->set_rules('txtAdditionalName', 'Additional Name', 'required');
				
				$data['title'] = 'New Additional Information';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Setting';
						$data['SubMenuOne'] = 'Setting Cust. Additional Info';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/Setting/CustomerAdditional/V_create', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							'additional_name'			=> $this->input->post('txtAdditionalName'),
							'additional_description' 	=> $this->input->post('txtDescription'),
							'creation_date'				=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);
						
						if($data['additional_description'] == '')
						{	$data['additional_description'] = NULL; }
						
						
						$this->M_customeradditional->setCustomerAdditional($data);
						
						redirect('CustomerRelationship/Setting/CustomerAdditional');
				}
				
		}
		
		public function Update($id)
		{		
				$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				$data['CustomerAdditional'] = $this->M_customeradditional->getCustomerAdditional($plaintext_string);
				$data['title'] = 'Update Additional Information';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Cust. Additional Info';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/CustomerAdditional/V_update', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
				
		}
		
		public function PostUpdateToDb()
		{		
				$this->form_validation->set_rules('txtAdditionalName', 'Additional Name', 'required');
				
				$id = $this->input->post('hdnAdditionalId');
				
				$data['title'] = 'Update Additional Information';
				
				$data=array(			
					'additional_name'			=> $this->input->post('txtAdditionalName'),
					'additional_description'	=> $this->input->post('txtDescription'),
					'last_update_date'			=> $this->input->post('hdnDate'),
					'last_updated_by'			=> $this->input->post('hdnUser')
					);
					
					if($data['additional_description'] == '')
					{	$data['additional_description'] = NULL; }
				
				$this->M_customeradditional->postUpdate($data, $id);
				//$this->load->view('templates/header', $data);
				redirect('CustomerRelationship/Setting/CustomerAdditional');
				//$this->load->view('templates/footer');
		}
}