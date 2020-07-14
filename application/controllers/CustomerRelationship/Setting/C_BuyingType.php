<?php
class C_BuyingType extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('CustomerRelationship/Setting/M_buyingtype');
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
				$data['BuyingType'] = $this->M_buyingtype->getBuyingType();
				$data['title'] = 'Customer Buying Type';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Buying Type';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/BuyingType/V_index', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function Create()
		{		
				$this->form_validation->set_rules('txtBuyingType', 'Buying Type', 'required');
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$data['title'] = 'Create Customer Buying Type';
				
				if ($this->form_validation->run() === FALSE)
				{
						//$this->load->view('templates/header', $data);
						$data['Menu'] = 'Setting';
						$data['SubMenuOne'] = 'Setting Buying Type';
						$this->load->view('V_Header',$data);
						$this->load->view('V_Sidemenu',$data);
						$this->load->view('CustomerRelationship/Setting/BuyingType/V_create', $data);
						$this->load->view('V_Footer',$data);
						//$this->load->view('templates/footer');

				}
				else
				{	
						$data = array(
							'buying_type_name' 			=> strtoupper($this->input->post('txtBuyingType')),
							'buying_type_description'	=> strtoupper($this->input->post('txtDescription')),
							'creation_date'				=> $this->input->post('hdnDate'),
							'created_by' 				=> $this->input->post('hdnUser')
						);
						
						if($data['buying_type_description'] == '')
						{	$data['buying_type_description'] = NULL; }
						
						$this->M_buyingtype->setBuyingType($data);
						redirect('CustomerRelationship/Setting/BuyingType');
				}
		}
		
		public function Update($id)
		{		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
				$plaintext_string = $this->encrypt->decode($plaintext_string);
				$data['BuyingType'] = $this->M_buyingtype->getBuyingType($plaintext_string);
				$data['title'] = 'Update Customer Buying Type';
				
				$user_id = $this->session->userid;
		
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				//$this->load->view('templates/header', $data);
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Buying Type';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/BuyingType/V_update', $data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');
		}
		
		public function PostUpdateToDb()
		{		
				$this->form_validation->set_rules('txtBuyingType', 'Buying Type', 'required');
				
				$id = $this->input->post('hdnBuyingTypeId');
				
				$data['title'] = 'Update Customer Buying Type';
				
				$data = array(
							'buying_type_name' 			=> strtoupper($this->input->post('txtBuyingType')),
							'buying_type_description'	=> strtoupper($this->input->post('txtDescription')),
							'last_update_date'			=> $this->input->post('hdnDate'),
							'last_updated_by'			=> $this->input->post('hdnUser')
						);
						
						if($data['buying_type_description'] == '')
						{	$data['buying_type_description'] = NULL; }
				
				$this->M_buyingtype->postUpdate($data, $id);
				redirect('CustomerRelationship/Setting/BuyingType');
		}
		
}