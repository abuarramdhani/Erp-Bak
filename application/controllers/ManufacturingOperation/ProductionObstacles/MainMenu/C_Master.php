<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//
class C_Master extends CI_Controller
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
		$this->load->model('ManufacturingOperation/ProductionObstacles/M_master');
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

	public function induk()
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

		$data['indukLogam'] = $this->M_master->induk();;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_masterInduk', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Cabang()
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

		$data['cabangLogam'] = $this->M_master->cabang();
	

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_masterCabang', $data);
		$this->load->view('V_Footer',$data);
	}

	public function addInduk()
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

		// $data['Core'] = $this->M_core->getCore();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_addDataInduk', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitInduk()
	{	
		$induk = $this->input->post('txt_induk[]');
		$type = $this->input->post('slc_cetakan');
		$kategori = $this->input->post('slc_kategori');
		$hambatan = $this->input->post('slc_hambatan');
		$user_id = $this->session->userid;


		echo '<pre>';
		print_r($induk);
		echo '</pre>';

		for ($i=0; $i <count($induk) ; $i++) { 
			$data = $this->M_master->saveInduk($induk[$i],$type,$kategori,$hambatan,$user_id);
		}
			
		redirect(base_url('ManufacturingOperation/ProductionObstacles/master/induk'));
	}	

	public function addCabang()
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

		// $data['Core'] = $this->M_core->getCore();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_addDataCabang', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitCabang()
	{	
		$cabang = $this->input->post('txt_cabang[]');
		$induk = $this->input->post('slcInduk');
		$user_id = $this->session->userid;


		echo '<pre>';
		print_r($cabang);
		echo '</pre>';

		for ($i=0; $i <count($cabang) ; $i++) { 
			$data = $this->M_master->saveCabang($cabang[$i],$induk,$user_id);
		}
			
		redirect(base_url('ManufacturingOperation/ProductionObstacles/master/cabang'));
	}

	public function updateCabang()
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

		$idCbg = $this->input->post('txt_idCbg');
		$data['dataCbg'] = $this->M_master->getDataCbgbyId($idCbg);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_updateCabang', $data);
		$this->load->view('V_Footer',$data);

	}

	public function saveUpdateCabang()
	{
		$induk = $this->input->post('slcInduk');
		$cabang = $this->input->post('txt_cabang');
		$id = $this->input->post('txt_idCabang');

		$data = $this->M_master->saveUpdateCabang($induk,$cabang,$id);
		redirect(base_url('ManufacturingOperation/ProductionObstacles/master/cabang'));
	}

	public function updateinduk()
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

		$idInd = $this->input->post('txt_idInduk');
		$data['dataInd'] = $this->M_master->getDataIndbyId($idInd);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/ProductionObstacles/V_updateInduk', $data);
		$this->load->view('V_Footer',$data);

	}

	public function saveUpdateInduk()
		{	
			$hambatan = $this->input->post('slc_hambatan');
			$cetakan = $this->input->post('slc_cetakan');
			$kategori = $this->input->post('slc_kategori');
			$induk = $this->input->post('txt_induk');
			$id = $this->input->post('txt_idInduk');
	
			$data = $this->M_master->saveUpdateInduk($id,$hambatan,$cetakan,$kategori,$induk);
			redirect(base_url('ManufacturingOperation/ProductionObstacles/master/induk'));
		}

}
?>