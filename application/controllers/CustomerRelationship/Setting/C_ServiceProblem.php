<?php
class C_ServiceProblem extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('CustomerRelationship/Setting/M_serviceproblem');
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
				$data['ServiceProblem'] = $this->M_serviceproblem->getServiceProblem();
				$data['title'] = 'Service Problem';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Service Problem';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/ServiceProblem/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function Create()
		{		
				$this->form_validation->set_rules('txtProblemName', '', 'required');
				
				$data['title'] = 'New Service Problem';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				if ($this->form_validation->run() === FALSE)
				{
						$data['Menu'] = 'Setting';
						$data['SubMenuOne'] = 'Setting Service Problem';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/Setting/ServiceProblem/V_create', $data);
						$this->load->view('V_Footer',$data);

				}
				else
				{
						$data = array(
							
							'service_problem_name' 		=> strtoupper($this->input->post('txtProblemName')),
							'description' 				=> strtoupper($this->input->post('txtDescription')),
							'active'				 	=> $this->input->post('slcActive'),
							'creation_date'				=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);
												
						
						$this->M_serviceproblem->setServiceProblem($data);
						
						redirect('CustomerRelationship/Setting/ServiceProblem');
				}
				
		}
		
		public function Update($id)
		{		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				$data['ServiceProblem'] = $this->M_serviceproblem->getServiceProblem($plaintext_string);
				$data['title'] = 'Update Service Problem';
				
				$this->form_validation->set_rules('txtProblemName', '', 'required');
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['id'] = $id;
				
				if ($this->form_validation->run() === FALSE)
				{
				
					//$this->load->view('templates/header', $data);
					$data['Menu'] = 'Setting';
					$data['SubMenuOne'] = 'Setting Service Problem';
					$this->load->view('V_Header',$data);
					$this->load->view('V_Sidemenu',$data);
					$this->load->view('CustomerRelationship/Setting/ServiceProblem/V_update', $data);
					$this->load->view('V_Footer',$data);
					//$this->load->view('templates/footer');
				}
				else{
					$data=array(			
						'service_problem_name' 		=> strtoupper($this->input->post('txtProblemName')),
						'description' 				=> strtoupper($this->input->post('txtDescription')),
						'active'				 	=> $this->input->post('slcActive'),
						'last_update_date'			=> $this->input->post('hdnDate'),
						'last_updated_by'			=> $this->input->post('hdnUser')
					);
					
					$this->M_serviceproblem->postUpdate($data, $plaintext_string);
					
					redirect('CustomerRelationship/Setting/ServiceProblem');
				}
					
				
				//$this->load->view('templates/header', $data);
				
				//$this->load->view('templates/footer');
		}
}