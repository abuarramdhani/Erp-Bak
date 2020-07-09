<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_extention extends CI_Controller {
 
	public function __construct()
		{
			parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MorningGreeting/extention/M_extention');
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
		
	//Menampilkan halaman tabel data branch
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
		$data['branch']=$this->M_extention->branch('sf.branch_extention,sys.sys_organization');
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/extention/V_extention',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//Menambahkan data branch baru
	public function newBranch()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data_branch = $this->M_extention->data_branch();
		$data['data_branch'] = $data_branch;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/extention/V_newextention',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function newBranchSave()
        {
			$org_id			= $this->input->post('org_id');
			$ext_number			= $this->input->post('ext_number');
			$save_data_branch	= $this->M_extention->save_data_branch($org_id,$ext_number);
			redirect('MorningGreeting/extention');
        }
	
	//Mengedit data branch
	public function editBranch($branch_extention_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$search_data_branch = $this->M_extention->search_data_branch($branch_extention_id);
		$data_branch = $this->M_extention->data_branch();
		$data['search'] = $search_data_branch;
		$data['data_branch'] = $data_branch;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/extention/V_editextention',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function saveEditBranch()
		{
			$branch_extention_id = $this->input->post('branch_extention_id');
			$org_id = $this->input->post('org_id');
			$ext_number = $this->input->post('ext_number');
			$saveeditbranch = $this->M_extention->saveeditbranch($branch_extention_id,$org_id,$ext_number);
			redirect('MorningGreeting/extention');
		}
		
	//Menghapus data tabel branch
	public function deleteBranch($branch_extention_id)
	{
		$deletebranch = $this->M_extention->deletebranch($branch_extention_id);
		redirect('MorningGreeting/extention');
	}
}
