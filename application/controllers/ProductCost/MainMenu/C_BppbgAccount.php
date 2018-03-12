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
		$this->load->model('ProductCost/M_bppbgcategory');
		  
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

		$data['Title']	= 'Create Bppbg Account';
		$data['Menu']	= 'Product Cost';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['costcenter']		= $this->M_bppbgaccount->getCostCenter();
		$data['accountnumber']	= $this->M_bppbgaccount->getAccountNumber();
		$data['category']		= $this->M_bppbgcategory->getBppbgCategory();
		
		$this->form_validation->set_rules('using_category_code', 'using_category_code', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductCost/MainMenu/BppbgAccount/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$NEXTVAL = $this->M_bppbgaccount->getNextVal();

			$a = $NEXTVAL[0]['NEXTVAL'];
			$b = $this->input->post('using_category_code');
			$c = $this->input->post('using_category');
			$d = $this->input->post('cost_center');
			$f = $this->input->post('account_number');
			$g = $this->input->post('account_attribute');

			$this->M_bppbgaccount->setAccount($a,$b,$c,$d,$f,$g);

			redirect(site_url('ProductCost/BppbgAccount/'));
		}
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;

		$data['Title']	= 'Edit Bppbg Account';
		$data['Menu']	= 'Product Cost';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['account']		= $this->M_bppbgaccount->getAccount($id);
		$data['costcenter']		= $this->M_bppbgaccount->getCostCenter();
		$data['accountnumber']	= $this->M_bppbgaccount->getAccountNumber();
		$data['category']		= $this->M_bppbgcategory->getBppbgCategory();
		$data['id']				= $id;
		
		$this->form_validation->set_rules('using_category_code', 'using_category_code', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductCost/MainMenu/BppbgAccount/V_edit', $data);
			$this->load->view('V_Footer',$data);	
		} else {

			$b = $this->input->post('using_category_code');
			$c = $this->input->post('using_category');
			$d = $this->input->post('cost_center');
			$f = $this->input->post('account_number');
			$g = $this->input->post('account_attribute');

			$this->M_bppbgaccount->updateAccount($id,$b,$c,$d,$f,$g);

			redirect(site_url('ProductCost/BppbgAccount/'));
		}
	}

	public function delete($id)
	{
		$this->M_bppbgaccount->deleteAccount($id);
		redirect(site_url('ProductCost/BppbgAccount/'));
	}
}