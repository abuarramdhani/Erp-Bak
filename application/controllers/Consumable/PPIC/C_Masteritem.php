<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Masteritem extends CI_Controller
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
		$this->load->model('Consumable/M_consumable');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master Item';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('Consumable/PPIC/V_MasterItem');
		$this->load->view('V_Footer', $data);
	}

	public function format_date($date)
	{
		$ss = explode("/", $date);
		return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
	}
	public function loadview()
	{
		$master = $this->M_consumable->selectmasteritem();
		$data['master'] = $master;
		$this->load->view('Consumable/PPIC/V_TblMasterItem', $data);
	}

	public function additem()
	{
		$inputan = '<div class="panel-body">
				<div class="col-md-4" style="text-align:right"><label>Item<label></div>
				<div class="col-md-5" style="text-align:left"><select class="form-control select2" id="ItemConsum" style="width:100%" data-placeholder="Pilih Item" name="ItemConsum" required="required"></select></div>
			</div>
			<div class="panel-body">
				<div class="col-md-4" style="text-align:right"><label>Deskripsi<label></div>
				<div class="col-md-5" style="text-align:left"><input type="text" class="form-control" id="DescConsum" placeholder="Deskripsi Otomatis" name="DescConsum" readonly="readonly"/></div>
			</div>
			<div class="panel-body">
				<div class="col-md-4" style="text-align:right"><label>Satuan<label></div>
				<div class="col-md-5" style="text-align:left"><input type="text" class="form-control" id="SatuanConsum" placeholder="Satuan Otomatis" name="SatuanConsum" readonly="readonly"/></div>
			</div>
			<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><button class="btn bg-teal btn-add-master-item">Insert</button></div>
			</div>
		';

		echo $inputan;
	}


	function itemmm()
	{

		$term = $this->input->get('term', TRUE);
		$term = strtoupper($term);
		$data = $this->M_consumable->itemmm($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function getDesc()
	{
		$item = $this->input->post('item');

		$desc = $this->M_consumable->getDescUom($item);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($desc[0]['DESKRIPSI']);
	}
	public function getUom()
	{
		$item = $this->input->post('item');
		$uom = $this->M_consumable->getDescUom($item);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($uom[0]['SATUAN']);
	}
	public function InsertMasterItem()
	{
		// $nama = $this->session->employee;

		date_default_timezone_set('Asia/Jakarta');
		$created_by = $this->session->user;
		$creation_date = date("Y-m-d H:i:s");
		$item_code = $this->input->post('ItemConsum');
		$item_desc = $this->input->post('DescConsum');
		$uom = $this->input->post('SatuanConsum');

		// echo "<pre>";print_r($creation_date);exit();


		$this->M_consumable->InsertMasterItem($item_code, $item_desc, $uom, $created_by, $creation_date);


		// redirect(base_url('ConsumablePPIC/MasterItem'));
	}
	public function cekItem()
	{
		$item = $this->input->post('item');
		$cek = $this->M_consumable->getDescItemMaster($item);

		if ($cek == null) {
			echo json_encode("tdk");
		} else {
			echo json_encode("ada");
		}
	}
}
