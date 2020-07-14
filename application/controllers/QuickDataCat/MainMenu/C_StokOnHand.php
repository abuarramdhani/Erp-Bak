<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_StokOnHand extends CI_Controller {
	function __construct()
	{
	   parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('QuickDataCat/MainMenu/M_lihatstockcat');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	public function Index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'QuickDataCat/DataCatKeluar/insert_act';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['data_onhand'] = $this->M_lihatstockcat->getDataCatOnHand2();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('QuickDataCat/MainMenu/V_LihatStockOnHand', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function exportExcelOnHand(){
		$data['data_stok_onhand'] = $this->M_lihatstockcat->getDataCatOnHand2();
		$this->load->view('QuickDataCat/Report/V_EXCELExportDataOnHand',$data);
	}
	
}