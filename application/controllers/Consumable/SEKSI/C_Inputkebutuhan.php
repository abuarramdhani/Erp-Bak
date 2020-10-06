<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Inputkebutuhan extends CI_Controller
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

		$data['Title'] = 'Input Standar Kebutuhan';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('Consumable/SEKSI/V_Inputkebutuhan');
		$this->load->view('V_Footer', $data);
	}

	public function format_date($date)
	{
		$ss = explode("/", $date);
		return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
	}
	public function loadvieww()
	{
		$created_by = $this->session->user;
		$carikodesie = $this->M_consumable->carikodesie($created_by);
		$kodesie = $carikodesie[0]['kodesie'];
		$kebutuhan = $this->M_consumable->selectkebutuhaninput($kodesie);

		for ($i = 0; $i < sizeof($kebutuhan); $i++) {

			$desc = $this->M_consumable->getDescUom($kebutuhan[$i]['item_code']);

			$kebutuhan[$i]['desc'] = $desc[0]['DESKRIPSI'];

			if ($kebutuhan[$i]['approve_status'] == 0) {
				$kebutuhan[$i]['status'] = 'Belum Approved';
			} else if ($kebutuhan[$i]['approve_status'] == 1) {
				$kebutuhan[$i]['status'] = 'Approved By Atasan';
			} else if ($kebutuhan[$i]['approve_status'] == 2) {
				$kebutuhan[$i]['status'] = 'Rejected By Atasan';
			} else if ($kebutuhan[$i]['approve_status'] == 3) {
				$kebutuhan[$i]['status'] = 'Approved By PPIC';
			} else if ($kebutuhan[$i]['approve_status'] == 4) {
				$kebutuhan[$i]['status'] = 'Rejected By PPIC';
			}
		}
		$data['kebutuhan'] = $kebutuhan;

		$this->load->view('Consumable/SEKSI/V_TblKebutuhan', $data);
	}

	public function addkebutuhan()
	{
		$inputan = '<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><a class="btn bg-yellow" id="addnewneed"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add New</a></div>
				<br><br>
				<div class="col-md-12" id="need_tabel">
					<table class="table table-bordered" style="width:100%">
						<thead class="bg-teal">
							<tr>
								<th class="text-center">Nama Item</th>
								<th class="text-center">Item Code</th>
								<th class="text-center">Quantity</th>	
							</tr>
						</thead>
						<tbody id="tambahannya_disini">
							<input type="hidden" value="1" id="urutan_kebutuhan"/>
							<tr>
							<td class="text-center" style="width:50%"><select class="form-control select2 item_kebutuhan_consum" id="item_kebutuhan_consum1" style="width:100%" data-placeholder="Pilih Item" name="item_kebutuhan_consum[]" required="required"></select></td>
							<td class="text-center" style="width:30%"><input type="text" class="form-control" id="desc_kebutuhan_consum1" readonly="readonly" /></td>
							<td class="text-center"><input type="text" class="form-control" id="qty_kebutuhan_consum1" name="qty_kebutuhan_consum[]" required="required" /></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-12" style="text-align:right"><button onclick="insertkebutuhan()" class="btn btn-info">Insert</button></div>
			</div>
		';

		echo $inputan;
	}


	function itemmm()
	{

		$term = $this->input->get('term', TRUE);
		$term = strtoupper($term);
		$data = $this->M_consumable->getItemMaster($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	public function cekItem()
	{
		$itemsudahterpilih = $this->input->post('itemsudahterpilih');
		$item = $this->input->post('item');

		if (!in_array($item, $itemsudahterpilih)) {
			echo "0";
		} else {
			echo "1";
		}
	}

	public function getDesc()
	{
		$item = $this->input->post('item');

		$desc = $this->M_consumable->getDescItemMaster($item);
		// echo "<pre>";print_r($desc);exit();
		echo json_encode($desc[0]['item_code']);
	}
	public function insertkebutuhan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$created_by = $this->session->user;
		$carikodesie = $this->M_consumable->carikodesie($created_by);
		$creation_date = date("Y-m-d H:i:s");
		$item_code = $this->input->post('item_kebutuhan_consum');
		$quantity = $this->input->post('qty_kebutuhan_consum');
		$kodesie = $carikodesie[0]['kodesie'];

		// echo "<pre>";
		// print_r($item_code);
		// print_r($quantity);
		// die;

		for ($i = 0; $i < sizeof($item_code); $i++) {
			$this->M_consumable->insertkebutuhan($item_code[$i], $quantity[$i], $kodesie, $created_by, $creation_date);
		}
	}
}
