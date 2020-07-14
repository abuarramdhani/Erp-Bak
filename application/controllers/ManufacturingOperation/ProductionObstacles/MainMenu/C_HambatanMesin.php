<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_HambatanMesin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperation/ProductionObstacles/M_hambatanmesin');
		$this->load->model('ManufacturingOperation/Ajax/M_ajax');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	// public function index()
	// {
	// 	$user = $this->session->username;

	// 	$user_id = $this->session->userid;

	// 	$data['Title'] = 'Core';
	// 	$data['Menu'] = 'Manufacturing Operation';
	// 	$data['SubMenuOne'] = '';
	// 	$data['SubMenuTwo'] = '';

	// 	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	// 	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	// 	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	// 	$data['Core'] = $this->M_core->getCore();

	// 	$this->load->view('V_Header',$data);
	// 	$this->load->view('V_Sidemenu',$data);
	// 	$this->load->view('ManufacturingOperation/Core/V_index', $data);
	// 	$this->load->view('V_Footer',$data);
	// }

	public function Umum()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['HambatanUmum'] = $this->M_hambatanmesin->selectHmabatanUmum();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_hambatanUmum', $data);
		$this->load->view('V_Footer',$data);
	}

	public function addHambatanUmum()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_addDataHambatanUmum', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitHambatanUmum()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$induk = $this->input->post('slc_induk');

		$ind = $this->M_hambatanmesin->findInduk($induk);

		$ind1 = $ind[0]['induk'];

		$cabang = $this->input->post('slc_cabang');
		$mulai = $this->input->post('tgl_mulai');
		$selesai = $this->input->post('tgl_selesai');
		$type = $this->input->post('typeHambatan');

		$data['HambatanMesinUmum'] = $this->M_hambatanmesin->saveHmabatanUmum($ind1,$cabang,$mulai,$selesai,$type,$user_id);

		redirect(base_url('ManufacturingOperation/ProductionObstacles/Hambatan/mesin/umum'));
	}

	public function updateHambatanUmum()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'HambatanUmum';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = $this->input->post('id_hambatanUmum');
		$data['edtHam'] = $this->M_hambatanmesin->getHambyid($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_updateHambatanUmum', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitUpdateHU()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'HambatanUmum';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$induk = $this->input->post('slc_induk');

		$ind = $this->M_hambatanmesin->findInduk($induk);

		$ind1 = $ind[0]['induk'];

		$cabang = $this->input->post('slc_cabang');
		$mulai = $this->input->post('tgl_mulai');
		$selesai = $this->input->post('tgl_selesai');
		$type = $this->input->post('typeHambatan');
		$id = $this->input->post('idHambatan');
		$kategori = $this->input->post('kategori');
		if ($kategori=='permesin') {
			$kategori = '/PerMesin';
		}elseif ($kategori=='umum') {
			$kategori = '/umum';
		}

		$data['HambatanMesinUmum'] = $this->M_hambatanmesin->updateHambatanUmum($id,$ind1,$cabang,$mulai,$selesai,$type,$user_id);

		redirect(base_url('ManufacturingOperation/ProductionObstacles/Hambatan/mesin/').$kategori);
	}


	public function PerMesin()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['hambatanPerMesin'] = $this->M_hambatanmesin->selectHmabatanPerMesin();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_hambatanPerMesin', $data);
		$this->load->view('V_Footer',$data);
	}

	public function addHambatanPerMesin()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_addDataHambatanPerMesin', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitHambatanPerMesin()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$induk = $this->input->post('slc_induk');

		$ind = $this->M_hambatanmesin->findInduk($induk);

		$ind1 = $ind[0]['induk'];

		$cabang = $this->input->post('slc_cabang');
		$mulai = $this->input->post('tgl_mulai');
		$selesai = $this->input->post('tgl_selesai');
		$type = $this->input->post('typeHambatan');

		$data['hambatanPerMesin'] = $this->M_hambatanmesin->saveHmabatanPerMesin($ind1,$cabang,$mulai,$selesai,$type,$user_id);

		redirect(base_url('ManufacturingOperation/ProductionObstacles/Hambatan/mesin/PerMesin'));
	}

	public function updateHambatanPerMesin()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = $this->input->post('id_hambatanUmum');
		$data['edtHam'] = $this->M_hambatanmesin->getHambyid($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_updateHambatanPerMesin', $data);
		$this->load->view('V_Footer',$data);
	}

}
?>