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
			redirect('index');
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
		$this->load->view('StorageLocation/MainMenu/V_koreksi');
		$this->load->view('V_Footer',$data);
	}

	public function searchComponent()
	{
		$org_id	= $this->input->post('org');
		$sub_inv= $this->input->post('sub_inv');
		$item 	= $this->input->post('item');
		$locator= $this->input->post('locator');
		
		$data['Component'] = $this->M_correction->getSearchComponent($org_id,$sub_inv,$item,$locator);
		$this->load->view('StorageLocation/MainMenu/V_tablesearchcomponent',$data);
	}

	public function searchAssy()
	{
		$org_id		= $this->input->post('org');
		$sub_inv	= $this->input->post('sub_inv');
		$kode_assy	= $this->input->post('kode_assy');
		$data['Assy'] = $this->M_correction->getSearchAssy($org_id,$sub_inv,$kode_assy);
		$this->load->view('StorageLocation/MainMenu/V_tablesearchassy',$data);
	}

	public function saveAlamat()
	{
		$user 		= $this->session->userdata('user');
		$alamat		= $this->input->post('alamat');
		$item		= $this->input->post('item');
		$kode_assy	= $this->input->post('kode_assy');
		$type_assy	= $this->input->post('type_assy');
		$sub_inv	= $this->input->post('sub_inv');

		$this->M_correction->save_alamat($user, $alamat, $item, $kode_assy, $type_assy, $sub_inv);
	}

	public function saveLmk()
	{
		$user 		= $this->session->userdata('user');
		$lmk		= $this->input->post('lmk');
		$item		= $this->input->post('item');
		$kode_assy	= $this->input->post('kode_assy');
		$type_assy	= $this->input->post('type_assy');
		$sub_inv	= $this->input->post('sub_inv');

		$this->M_correction->save_lmk($user, $lmk, $item, $kode_assy, $type_assy, $sub_inv);
	}

	public function savePicklist()
	{
		$user 		= $this->session->userdata('user');
		$picklist	= $this->input->post('picklist');
		$item		= $this->input->post('item');
		$kode_assy	= $this->input->post('kode_assy');
		$type_assy	= $this->input->post('type_assy');
		$sub_inv	= $this->input->post('sub_inv');

		$this->M_correction->save_picklist($user, $picklist, $item, $kode_assy, $type_assy, $sub_inv);
	}
}