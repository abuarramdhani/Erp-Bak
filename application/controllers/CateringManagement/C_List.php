<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_List extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
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
		$this->load->model('CateringManagement/M_list');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function index(){	
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Catering'] = $this->M_list->GetCateringList();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/List/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function create(){	
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/List/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function edit($id){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Catering List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Catering'] = $this->M_list->GetCateringForEdit($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/List/V_Edit',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function add(){
		$name 		= $this->input->post('TxtName');
		$code 		= $this->input->post('TxtCode');
		$address 	= $this->input->post('TxtAddress');
		$phone 		= $this->input->post('TxtPhone');
		$status		= $this->input->post('txtStatus');
		$pph		= $this->input->post('TxtPph');
		
		if ($pph == 1) {
			$pph_value = $this->input->post('TxtPphValue');
		} else {
			$pph_value	= 0;
		}
		
		$this->M_list->AddCatering($name,$code,$address,$phone,$pph,$status,$pph_value);
		redirect('CateringManagement/List');
	}
	
	public function update(){
		$id 		= $this->input->post('TxtId');
		$name 		= $this->input->post('TxtName');
		$code 		= $this->input->post('TxtCode');
		$address 	= $this->input->post('TxtAddress');
		$phone 		= $this->input->post('TxtPhone');
		$status		= $this->input->post('txtStatus');
		$pph		= $this->input->post('TxtPph');
		
		if ($pph == 1) {
			$pph_value = $this->input->post('TxtPphValue');
		} else {
			$pph_value	= 0;
		}
		
		$this->M_list->UpdateCatering($id,$name,$code,$address,$phone,$pph,$status,$pph_value);
		redirect('CateringManagement/List');
	}
	
	public function delete($id){
		$this->M_list->DeleteCatering($id);
		redirect('CateringManagement/List');
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
