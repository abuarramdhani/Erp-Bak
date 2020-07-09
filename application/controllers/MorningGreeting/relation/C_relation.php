<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_relation extends CI_Controller {
	
	public function __construct()
		{
			parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MorningGreeting/relation/M_relation');
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
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['relation']=$this->M_relation->relation();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/relation/V_relation',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//Menambahkan data relation baru
	public function newRelation()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data_branch = $this->M_relation->data_branch();
		$province = $this->M_relation->province();
		$data['data_branch'] = $data_branch;
		$data['province'] = $province;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/relation/V_newrelation',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function newRelationSave()
        {
			$relation_name		= $this->input->post('relation_name');
			$npwp				= $this->input->post('npwp');
			$oracle_cust_id		= $this->input->post('oracle_cust_id');
			$city_regency_id	= $this->input->post('txtCityRegency');
			$org_id				= $this->input->post('org_id');
			$contact_number		= $this->input->post('contact_number');
			$contact_number_split	= explode(',', $contact_number);
			
			$save_data_relation	= $this->M_relation->save_data_relation($relation_name,$npwp,$oracle_cust_id,$city_regency_id,$org_id,$contact_number_split);
			
			$relationid=$save_data_relation[0]['ins_id'];
			
			//memasukan detail kontak number
			foreach ($contact_number_split as $value) {
						$save_data_relation_number	= $this->M_relation->save_data_relation_number($relation_name,$value,$relationid);
					}
			redirect('MorningGreeting/relation');
        }
	
	//Mengedit data relation
	public function editRelation($relation_id)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			//$data['user'] = $usr;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$data['search'] = $this->M_relation->search_data_relation($relation_id);
			$relation = $this->M_relation->search_data_relation($relation_id);
				foreach($relation as $rlt){
					$pr_id = $rlt['province_id'];
				}
				if($pr_id == null){ $pr_id = "0";}

			$data['data_branch'] = $this->M_relation->data_branch();
			$data['province'] = $this->M_relation->province();
			$data['data_city'] = $this->M_relation->data_city($pr_id);
			$data['search_cn'] = $this->M_relation->search_data_relation_cn($relation_id);
			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MorningGreeting/relation/V_editrelation',$data);
			$this->load->view('V_Footer',$data);
		}
	
	public function saveEditRelation()
		{
			//Meng-UPDATE data di tabel relation
			$relation_id = $this->input->post('relation_id');
			$relation_name = $this->input->post('relation_name');
			$npwp = $this->input->post('npwp');
			$oracle_cust_id = $this->input->post('oracle_cust_id');
			$city_regency_id = $this->input->post('txtCityRegency');
			$org_id = $this->input->post('org_id');
			$saveeditrelation	= $this->M_relation->saveeditrelation($relation_id,$relation_name,$npwp,$oracle_cust_id,$city_regency_id,$org_id);
			
			//DELETE data di tabel contact_number
			$deleterelation_contact	= $this->M_relation->deleterelation_contact($relation_id);
			
			$contact_number			= $this->input->post('contact_number');
			$contact_number_split	= explode(',', $contact_number);
			
			//memasukan detail kontak number
			foreach ($contact_number_split as $value) {
						$save_edit_relation_number	= $this->M_relation->save_edit_relation_number($relation_name,$value,$relation_id);
					}
			redirect('MorningGreeting/relation');
		}
		
	//Menghapus data tabel relation
	public function deleteRelation($relation_id)
	{
		$deleterelation = $this->M_relation->deleterelation($relation_id);
		$deleterelation_contact = $this->M_relation->deleterelation_contact($relation_id);
		redirect('MorningGreeting/relation');
	}
}
