<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Correction extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StorageLocation/MainMenu/M_correction');
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
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
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Correction Storage Location';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StorageLocation/MainMenu/V_Koreksi');
		$this->load->view('V_Footer',$data);
	}

	public function searchComponent()
	{
		$org_id	= $this->input->post('org');
		$sub_inv= $this->input->post('sub_inv');
		$item 	= $this->input->post('item');
		$locator= $this->input->post('locator');
		
		$data['Component'] 	= $this->M_correction->getSearchComponent($org_id,$sub_inv,$item,$locator);
		$data['SubInv'] 	= $this->M_correction->getSubInv();
		$this->load->view('StorageLocation/MainMenu/V_tablesearchcomponent',$data);
	}

	public function searchAssy()
	{
		$org_id		= $this->input->post('org');
		$sub_inv	= $this->input->post('sub_inv');
		$kode_assy	= $this->input->post('kode_assy');
		
		$data['Assy'] = $this->M_correction->getSearchAssy($org_id,$sub_inv,$kode_assy);
		$data['SubInv'] 	= $this->M_correction->getSubInv();
		$this->load->view('StorageLocation/MainMenu/V_tablesearchassy',$data);
	}

	public function saveAlamat()
	{
		$user 	= $this->session->userdata('user');
		$alamat	= $this->input->post('alamat');
		$ID		= $this->input->post('ID');

		$this->M_correction->save_alamat($user,$alamat,$ID);
	}

	public function saveLmk()
	{
		$user 	= $this->session->userdata('user');
		$lmk 	= $this->input->post('lmk');
		$ID		= $this->input->post('ID');

		$this->M_correction->save_lmk($user,$lmk,$ID);
	}

	public function savePicklist()
	{
		$user 		= $this->session->userdata('user');
		$picklist	= $this->input->post('picklist');
		$ID			= $this->input->post('ID');
		$this->M_correction->save_picklist($user,$picklist,$ID);
	}

	public function compCodeSave()
	{
		$user 		= $this->session->userdata('user');
		$ID 		= $this->input->post('ID');
		$compCode 	= $this->input->post('compCode');

		$this->M_correction->compCodeSave($user,$ID,$compCode);
	}

	public function subInvSave()
	{
		$user 		= $this->session->userdata('user');
		$ID 		= $this->input->post('ID');
		$sub_inv 	= $this->input->post('sub_inv');

		$this->M_correction->subInvSave($user,$ID,$sub_inv);
	}

	public function Delete()
	{
		$ID 		= $this->input->post('ID');
		$this->M_correction->Delete($ID);
		redirect('StorageLocation/Correction');
	}
}