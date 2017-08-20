<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Scheduler extends CI_Controller {
	
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
		$this->load->model('ManagementOrder/M_scheduler');
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
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['action'] = '';
		$data['Title'] = 'SCHEDULER PROJECT';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/MainMenu/Scheduler/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function Create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['action'] = '';
		$data['Title'] = 'SCHEDULER PROJECT';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ClassificationProject'] = $this->M_scheduler->getClassificationProject();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/MainMenu/Scheduler/V_Create', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function getTicket(){
		$q = $this->input->post('term',true);
		$selectTicket = $this->M_scheduler->getTicket($q);
		echo json_encode($selectTicket);
	}
	
	function ChooseClassificationFormat(){
		$id = $this->input->post('id',true);
		$getFormat = $this->M_scheduler->getFormat($id);
		if(empty($getFormat)){
			echo "empty";
		}else{
			$no = 0;
			foreach($getFormat as $getFormat_item){
				$no++;
				echo "<tr>
						<td>".$no."</td>
						<td>".$getFormat_item['classification']."</td>
						<td></td>
						<td></td>
					  </tr>";
			}
		}
	}
	
}
