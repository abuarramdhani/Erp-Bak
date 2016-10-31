<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_StockOpnamePusat extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('StockControl/M_stock_opname_pusat');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
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
		$data['Title'] = 'List Stock Opname Pusat';
		$data['Menu'] = 'Stock Opname Pusat';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['alert'] = $this->session->flashdata('alert');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockControl/StockOpnamePusat/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function monitoring()
	{
		$data['io_name'] = $this->M_stock_opname_pusat->io_name_list();
		//$data['sub_inventory'] = $this->M_stock_opname_pusat->sub_inventory_list();
		//$data['area'] = $this->M_stock_opname_pusat->area_list();
		//$data['locator'] = $this->M_stock_opname_pusat->locator_list();
		$next_seq = $this->M_stock_opname_pusat->next_seq();
		foreach ($next_seq as $seq) {
			$seq = $seq['seq']+1;
		}
		$data['next_seq'] = $seq;

		$this->load->view('StockControl/StockOpnamePusat/V_Monitoring',$data);
		$this->load->view('StockControl/StockOpnamePusat/V_Monitoring_table',$data);
		$this->load->view('StockControl/StockOpnamePusat/V_Monitoring_footer',$data);
	}

	public function getData()
	{
		$io_name = $this->input->post('txt_io_name');
		$sub_inventory = $this->input->post('txt_sub_inventory');
		$area = $this->input->post('txt_area_pusat');
		$locator = $this->input->post('txt_locator');
		if ($io_name == 'ALL') {
			$io_name = "io_name";
		}
		elseif ($io_name == 'X') {
			$io_name = "''";
		}
		else{
			$io_name = "'".$io_name."'";
		}

		if ($sub_inventory == 'ALL') {
			$sub_inventory = "sub_inventory";
		}
		elseif ($sub_inventory == 'X') {
			$sub_inventory = "''";
		}
		else{
			$sub_inventory = "'".$sub_inventory."'";
		}

		if ($area == 'ALL') {
			$area = "area";
		}
		elseif ($area == 'X') {
			$area = "''";
		}
		else{
			$area = "'".$area."'";
		}

		if ($locator == 'ALL') {
			$locator = "locator";
		}
		elseif ($locator == 'X') {
			$locator = "''";
		}
		else{
			$locator = "'".$locator."'";
		}

		$data['stock_opname_pusat'] = $this->M_stock_opname_pusat->stock_opname_pusat_filter($io_name,$sub_inventory,$area,$locator);

		$this->load->view('StockControl/StockOpnamePusat/V_Monitoring_table',$data);
	}

	public function SaveSO()
	{
		$qty = $this->input->post("qtySO");
		$master_id = $this->input->post("master_id");

		if ($qty == '-') {
			$qty_so = '0';
		}
		else{
			$qty_so = $qty;
		}
		$this->M_stock_opname_pusat->update_qty($qty_so,$master_id);
		echo '<input data-toggle="tooltip" data-placement="top" title="Press Enter to Submit!" class="form-control" style="width: 100%;" type="text" value="'.$qty_so.'" name="txt_qty_so" onchange="SaveSO_Pusat(\''.$master_id.'\',this)" />';
	}

	public function autocomplete($modul,$term){
		$term = strtolower($term);

		if ($modul == "io_name") {
			$autocomplete = $this->M_stock_opname_pusat->io_name_list($term);
		}
		elseif ($modul == "sub_inventory") {
			$autocomplete = $this->M_stock_opname_pusat->sub_inventory_list($term);
		}
		elseif ($modul == "area") {
			$autocomplete = $this->M_stock_opname_pusat->area_list($term);
		}
		elseif ($modul == "locator") {
			$autocomplete = $this->M_stock_opname_pusat->locator_list($term);
		}
		elseif ($modul == "saving_place") {
			$autocomplete = $this->M_stock_opname_pusat->saving_place_list($term);
		}
		elseif ($modul == "cost_center") {
			$autocomplete = $this->M_stock_opname_pusat->cost_center_list($term);
		}
		elseif ($modul == "type") {
			$autocomplete = $this->M_stock_opname_pusat->type_list($term);
		}
		elseif ($modul == "uom") {
			$autocomplete = $this->M_stock_opname_pusat->uom_list($term);
		}
		
		foreach ($autocomplete as $ac => $value) {
			foreach ($value as $val) {
				$arr['query'] = $term;
				$arr['suggestions'][] = array(
					'value'	=> $val
				);
			}
		}

		echo json_encode($arr);
	}

	public function new_component(){
		$io_name = $this->input->post('txt_new_io_name');
		$sub_inventory = $this->input->post('txt_new_sub_inventory');
		$area = $this->input->post('txt_new_area');
		$locator = $this->input->post('txt_new_locator');
		$saving_place = $this->input->post('txt_new_saving_place');
		$cost_center = $this->input->post('txt_new_cost_center');
		$seq = $this->input->post('txt_new_seq');
		$component_code = $this->input->post('txt_new_component_code');
		$component_desc = $this->input->post('txt_new_component_desc');
		$type = $this->input->post('txt_new_type');
		$onhand_qty = $this->input->post('txt_new_onhand_qty');
		$so_qty = $this->input->post('txt_new_so_qty');
		$uom = $this->input->post('txt_new_uom');

		$insert = $this->M_stock_opname_pusat->new_component($io_name,$sub_inventory,$area,$locator,$saving_place,$cost_center,$seq,$component_code,$component_desc,$type,$onhand_qty,$so_qty,$uom);
		if ($insert == 1) {
			$alert = '
				<div class="alert alert-success flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Data Insert Successfully
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						$(".flyover-top").addClass("in");
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 3000);
					});
				</script>
			';
		}
		else{
			$alert = '
				<div class="alert alert-danger flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Error occurred when insert data!
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						$(".flyover-top").addClass("in");
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 3000);
					});
				</script>
			';
		}

		$this->session->set_flashdata('alert', $alert);
		redirect('StockControl/stock-opname-pusat/monitoring');
	}

	public function edit_component(){
		$master_data_id = $this->input->post('master_data_id');
		$data['search_result'] = $this->M_stock_opname_pusat->edit_component($master_data_id);
		$this->load->view('StockControl/StockOpnamePusat/V_Update_Form',$data);
	}

	public function update_component(){
		$master_data_id = $this->input->post('txt_master_data_id');
		$io_name = $this->input->post('txt_new_io_name');
		$sub_inventory = $this->input->post('txt_new_sub_inventory');
		$area = $this->input->post('txt_new_area');
		$locator = $this->input->post('txt_new_locator');
		$saving_place = $this->input->post('txt_new_saving_place');
		$cost_center = $this->input->post('txt_new_cost_center');
		$seq = $this->input->post('txt_new_seq');
		$component_code = $this->input->post('txt_new_component_code');
		$component_desc = $this->input->post('txt_new_component_desc');
		$type = $this->input->post('txt_new_type');
		$onhand_qty = $this->input->post('txt_new_onhand_qty');
		$so_qty = $this->input->post('txt_new_so_qty');
		$uom = $this->input->post('txt_new_uom');

		$update = $this->M_stock_opname_pusat->update_component($master_data_id,$io_name,$sub_inventory,$area,$locator,$saving_place,$cost_center,$seq,$component_code,$component_desc,$type,$onhand_qty,$so_qty,$uom);
		if ($update == 1) {
			$alert = '
				<div class="alert alert-success flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Data Update Successfully
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						$(".flyover-top").addClass("in");
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 3000);
					});
				</script>
			';
		}
		else{
			$alert = '
				<div class="alert alert-danger flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Error occurred when update data!
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						$(".flyover-top").addClass("in");
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 3000);
					});
				</script>
			';
		}

		$this->session->set_flashdata('alert', $alert);
		redirect('StockControl/stock-opname-pusat/monitoring');
	}

	public function print_to_pdf(){
		$data['io_name'] = $this->M_stock_opname_pusat->io_name_list();
		$data['sub_inventory'] = $this->M_stock_opname_pusat->sub_inventory_list();
		$data['area'] = $this->M_stock_opname_pusat->area_list();
		$data['locator'] = $this->M_stock_opname_pusat->locator_list();

		$this->load->view('StockControl/StockOpnamePusat/V_Pdf_Filter', $data);
		$this->load->view('StockControl/StockOpnamePusat/V_Monitoring_footer', $data);
	}

	public function export_pdf(){
		ini_set('memory_limit', '-1');
		$io_name = $this->input->post('txt_io_name');
		$sub_inventory = $this->input->post('txt_sub_inventory');
		$area = $this->input->post('txt_area_pusat');
		$locator = $this->input->post('txt_locator');
		$tgl_so = $this->input->post('txt_tgl_so');

		if ($io_name == 'ALL') {
			$io_name = "io_name";
		}
		elseif ($io_name == 'X') {
			$io_name = "''";
		}
		else{
			$io_name = "'".$io_name."'";
		}

		if ($sub_inventory == 'ALL') {
			$sub_inventory = "sub_inventory";
		}
		elseif ($sub_inventory == 'X') {
			$sub_inventory = "''";
		}
		else{
			$sub_inventory = "'".$sub_inventory."'";
		}

		if ($area == 'ALL') {
			$area = "area";
		}
		elseif ($area == 'X') {
			$area = "''";
		}
		else{
			$area = "'".$area."'";
		}

		if ($locator == 'ALL') {
			$locator = "locator";
		}
		elseif ($locator == 'X') {
			$locator = "''";
		}
		else{
			$locator = "'".$locator."'";
		}
		
		$data['item_classification'] = $this->M_stock_opname_pusat->item_classification($io_name,$sub_inventory,$area,$locator);
		$data['tanggal_so'] = $tgl_so;
		$data['stock_opname_pusat'] = $this->M_stock_opname_pusat->stock_opname_pusat_filter($io_name,$sub_inventory,$area,$locator);

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('', 'A4-L', 0, '', 5, 5, 10, 12);

		$filename = 'Report-Stock-Opname-Pusat-'.time();

		$stylesheet = file_get_contents('assets/plugins/bootstrap/3.3.6/css/bootstrap.css');

		$html = $this->load->view('StockControl/StockOpnamePusat/V_Pdf_Table', $data, true);

		$pdf->setFooter('Halaman {PAGENO} dari {nbpg}');
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
		//print_r($data['item_classification']);
	}

	public function getFilterData(){
		$id = $this->input->get('value');
		$modul = $this->input->get('modul');

		echo '
			<option></option>
			<option value="ALL">ALL</option>
		';
		if ($modul == 'sub_inventory') {
			$data = $this->M_stock_opname_pusat->slc_SubInventory($id);
			foreach ($data as $data) {
				if ($data['sub_inventory'] == '') {
					echo '<option value="X">KOSONG</option>';
				}
				else{
					echo '<option value="'.$data['sub_inventory'].'">'.$data['sub_inventory'].'</option>';
				}
			}
		}
		elseif($modul == 'area'){
			$data = $this->M_stock_opname_pusat->slc_Area($id);
			foreach ($data as $data) {
				if ($data['area'] == '') {
					echo '<option value="X">KOSONG</option>';
				}
				else{
					echo '<option value="'.$data['area'].'">'.$data['area'].'</option>';
				}
			}
		}
		elseif($modul == 'locator'){
			$data = $this->M_stock_opname_pusat->slc_Locator($id);
			foreach ($data as $data) {
				if ($data['locator'] == '') {
					echo '<option value="X">KOSONG</option>';
				}
				else{
					echo '<option value="'.$data['locator'].'">'.$data['locator'].'</option>';
				}
			}
		}
	}
}
