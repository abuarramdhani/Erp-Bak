<?php
class C_AdditionalActivity extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('CustomerRelationship/Setting/M_additionalactivity');
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
				$data['AdditionalActivity'] = $this->M_additionalactivity->getAdditionalActivity();
				$data['title'] = 'Additional Activity';
				//$this->load->view('templates/header', $data);
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Addtional Activity';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/AdditionalActivity/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function Create()
		{		
				$this->form_validation->set_rules('txtAdditional', '', 'required');
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['title'] = 'New Category Additional Activity';
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Setting';
						$data['SubMenuOne'] = 'Setting Addtional Activity';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/Setting/AdditionalActivity/V_create', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							'additional_activity' 		=> $this->input->post('txtAdditional'),
							'description'			    => $this->input->post('txtDescription'),
							'creation_date' 			=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);
						
						$this->M_additionalactivity->setAdditionalAvtivity($data);
						
						redirect('CustomerRelationship/Setting/AdditionalActivity');
				}
				
		}
		
		public function Update($id)
		{		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				$data['AdditionalActivity'] = $this->M_additionalactivity->getAdditionalActivity($plaintext_string);
				$data['title'] = 'Update Additional Activity';
				
				$this->form_validation->set_rules('txtAdditional', '', 'required');
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['id'] = $id;
				
				if ($this->form_validation->run() === FALSE)
				{
				
					//$this->load->view('templates/header', $data);
					$data['Menu'] = 'Setting';
					$data['SubMenuOne'] = 'Setting Addtional Activity';
					$this->load->view('V_Header',$data);
					$this->load->view('V_Sidemenu',$data);
					$this->load->view('CustomerRelationship/Setting/AdditionalActivity/V_update', $data);
					$this->load->view('V_Footer',$data);
					//$this->load->view('templates/footer');
				}
				else{
					$data=array(			
							'additional_activity' 		=> $this->input->post('txtAdditional'),
							'description'			    => $this->input->post('txtDescription'),
							'last_update_date' 			=> $this->input->post('hdnDate'),
							'last_updated_by' 			=> $this->input->post('hdnUser'),
					);
					
					$this->M_additionalactivity->postUpdate($data, $plaintext_string);
					
					redirect('CustomerRelationship/Setting/AdditionalActivity');
				}
					
				
				//$this->load->view('templates/header', $data);
				
				//$this->load->view('templates/footer');
		}
}