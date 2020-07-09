<?php
class C_Checklist extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/Setting/M_checklist');
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
				
				$data['Checklist'] = $this->M_checklist->getChecklist();
				$data['title'] = 'Checklist';

				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Connect Checklist';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/Checklist/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function Create()
		{		
				$this->form_validation->set_rules('txtNumber', 'Number', 'required');
				$this->form_validation->set_rules('txtDescription', 'Description', 'required');
				$data['Checklist'] = $this->M_checklist->getMaxSequence();
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['title'] = 'Create Checklist';
				
				if ($this->form_validation->run() === FALSE)
				{
						//$this->load->view('templates/header', $data);
						$data['Menu'] = 'Setting';
						$data['SubMenuOne'] = 'Setting Connect Checklist';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/Setting/Checklist/V_create', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');

				}
				else
				{	
						$data=array(	
							'no_urut_checklist' 		=> $this->input->post('txtNumber'),
							'checklist_description' 	=> strtoupper($this->input->post('txtDescription')),
							'end_date' 					=> $this->input->post('txtEndDate'),
							'last_update_date'			=> $this->input->post('hdnDate'),
							'last_updated_by'			=> $this->input->post('hdnUser')
							);
						
						if($data['end_date'] == '')
						{	$data['end_date'] = NULL; }
						
						$this->M_checklist->setChecklist($data);
						redirect('CustomerRelationship/Setting/Checklist');
				}
		}
		
		public function Update($id)
		{		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				$data['Checklist'] = $this->M_checklist->getChecklist($plaintext_string);
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['title'] = 'Update Checklist';

				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Connect Checklist';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/Checklist/V_update', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function PostUpdateToDb()
		{		
				$this->form_validation->set_rules('txtNumber', 'Number', 'required');
				$this->form_validation->set_rules('txtDescription', 'Description', 'required');
				
				$id = $this->input->post('txtChecklistId');
				
				$data['title'] = 'Update Checklist';
				
				$data=array(	
					'no_urut_checklist' 		=> $this->input->post('txtNumber'),
					'checklist_description' 	=> strtoupper($this->input->post('txtDescription')),
					'end_date' 					=> $this->input->post('txtEndDate'),
					'last_update_date'			=> $this->input->post('hdnDate'),
					'last_updated_by'			=> $this->input->post('hdnUser')
					);
					
					if($data['end_date'] == '')
					{	$data['end_date'] = NULL; }
				
				$this->M_checklist->postUpdate($data, $id);
				//$this->load->view('templates/header', $data);
				redirect('CustomerRelationship/Setting/Checklist');
				//$this->load->view('templates/footer');
		}
}