<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_BppbgAccount extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductCost/M_bppbgaccount');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Product Cost';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['account']		= $this->M_bppbgaccount->getAccount();
		$data['no']				= 1;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductCost/MainMenu/BppbgAccount/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title']	= 'Create Account';
		$data['Menu']	= 'Product Cost';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->form_validation->set_rules('txtProductComponentCodeHeader', 'Product Component Code', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductCost/MainMenu/BppbgAccount/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$accountAttr = $this->input->post('account_attribute');
			if (empty($accountAttr)) {
				$accountAttr = 'NULL';
			}

			$dataInsert = array(
				'USING_CATEGORY_CODE'		=> $this->input->post('using_category_code'),
				'USING_CATEGORY'			=> $this->input->post('using_category'),
				'COST_CENTER'				=> $this->input->post('cost_center'),
				'COST_CENTER_DESCRIPTION'	=> $this->input->post('cost_center_description'),
				'ACCOUNT_NUMBER'			=> $this->input->post('account_number'),
				'ACCOUNT_ATTRIBUTE'			=> $accountAttr,
				'CREATION_DATE'				=> SYSDATE
    		);

    		echo "<pre>";
    		print_r($dataInsert);
    		echo "</pre>";
    		exit;

			// $this->M_bppbgaccount->setAccount($data);

			redirect(site_url('ProductCost/BppbgAccount/'));
		}
	}
}