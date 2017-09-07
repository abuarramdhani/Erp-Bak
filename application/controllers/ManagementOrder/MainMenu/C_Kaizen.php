<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Kaizen extends CI_Controller {
	
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
		$this->load->model('ManagementOrder/M_kaizen');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
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
	
	public function index()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Kaizen';
		$data['SubMenuOne'] = 'Kaizen';
		$data['SubMenuTwo'] = '';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/MainMenu/V_Kaizen', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function Approve(){
		$selectMember = $this->M_kaizen->selectMember();
		$selectKaizen = $this->M_kaizen->selectKaizen();
		$data['member'] = $selectMember;
		$data['kaizen'] = $selectKaizen;
		echo json_encode($data);
	}
	
}
