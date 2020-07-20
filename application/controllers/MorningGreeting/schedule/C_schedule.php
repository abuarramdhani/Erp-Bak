<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_schedule extends CI_Controller {
 
	public function __construct()
		{
			parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MorningGreeting/schedule/M_schedule');
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
		
	//Menampilkan halaman tabel data schedule
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['schedule']=$this->M_schedule->schedule('sf.morning_greeting_schedule ,sf.relation ,sys.sys_organization ');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/schedule/V_schedule',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//Menambahkan data schedule baru
	public function newSchedule()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data_branch = $this->M_schedule->data_branch();
		$data_relation = $this->M_schedule->data_relation();
		$data['data_branch'] = $data_branch;
		$data['data_relation'] = $data_relation;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/schedule/V_newschedule',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function newScheduleSave()
        {
			$schedule_description	= $this->input->post('schedule_description');
			$day					= $this->input->post('day');
			$org_id					= $this->input->post('org_id');
			$relation_id			= $this->input->post('relation_id');
			$save_data_schedule		= $this->M_schedule->save_data_schedule($schedule_description,$day,$org_id,$relation_id);
			redirect('MorningGreeting/schedule');
        }
	
	//Mengedit data schedule
	public function editSchedule($schedule_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$search_data_schedule = $this->M_schedule->search_data_schedule($schedule_id);
		$data_branch = $this->M_schedule->data_branch();
		$data_relation = $this->M_schedule->data_relation();
		$data['data_relation'] = $data_relation;
		$data['search'] = $search_data_schedule;
		$data['data_branch'] = $data_branch;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/schedule/V_editschedule',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function saveEditSchedule()
		{
			$schedule_id = $this->input->post('schedule_id');
			$schedule_description = $this->input->post('schedule_description');
			$day = $this->input->post('day');
			$org_id = $this->input->post('org_id');
			$relation_id = $this->input->post('relation_id');
			$saveeditschedule = $this->M_schedule->saveeditschedule($schedule_id,$schedule_description,$day,$org_id,$relation_id);
			redirect('MorningGreeting/schedule');
		}
		
	//Menghapus data tabel schedule
	public function deleteSchedule($schedule_id)
	{
		$deleteschedule = $this->M_schedule->deleteschedule($schedule_id);
		redirect('MorningGreeting/schedule');
	}
}
