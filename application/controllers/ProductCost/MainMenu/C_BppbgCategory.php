<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_BppbgCategory extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
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
		$data['category']		= $this->M_bppbgcategory->getBppbgCategory();
		$data['no']				= 1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductCost/MainMenu/BppbgCategory/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$a = $this->input->post('category_code');
		$b = $this->input->post('category_description');
		$c = $this->input->post('general_description');

		$this->M_bppbgcategory->setBppbgCategory($a,$b,$c);

		redirect(site_url('ProductCost/BppbgCategory/'));
	}

	public function edit($id)
	{
		$a = $this->input->post('category_code');
		$b = $this->input->post('category_description');
		$c = $this->input->post('general_description');

		$this->M_bppbgcategory->updateCategory($id,$a,$b,$c);

		redirect(site_url('ProductCost/BppbgCategory/'));
	}

	public function delete($id)
	{
		$this->M_bppbgcategory->deleteCategory($id);
		redirect(site_url('ProductCost/BppbgCategory/'));
	}
}