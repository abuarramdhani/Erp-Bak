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
				<div class="alert bg-primary flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Data Insert Successfully

					<script type="text/javascript">
						$(document).ready(function(){
							$(".flyover-top").addClass("in");
							setTimeout(function(){
								$(".flyover-top").removeClass("in");
								setTimeout(function(){
									$(".flyover-top").remove();
								}, 2000);
							}, 3000);;
						});
					</script>
				</div>
			';
		}
		else{
			$alert = '
				<div class="alert alert-danger flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Error occurred when insert data!

					<script type="text/javascript">
						$(document).ready(function(){
							$(".flyover-top").addClass("in");
							setTimeout(function(){
								$(".flyover-top").removeClass("in");
								setTimeout(function(){
									$(".flyover-top").remove();
								}, 2000);
							}, 3000);
						});
					</script>
				</div>
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
				<div class="alert bg-primary flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Data Update Successfully

					<script type="text/javascript">
						$(document).ready(function(){
							$(".flyover-top").addClass("in");
							setTimeout(function(){
								$(".flyover-top").removeClass("in");
								setTimeout(function(){
									$(".flyover-top").remove();
								}, 2000);
							}, 3000);
						});
					</script>
				</div>
			';
		}
		else{
			$alert = '
				<div class="alert alert-danger flyover flyover-top">
					<button type="button" class="close" data-dismiss="alert"><b style="color: #fff;">&times;</b></button>
					Error occurred when update data!

					<script type="text/javascript">
						$(document).ready(function(){
							$(".flyover-top").addClass("in");
							setTimeout(function(){
								$(".flyover-top").removeClass("in");
								setTimeout(function(){
									$(".flyover-top").remove();
								}, 2000);
							}, 3000);
						});
					</script>
				</div>
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

		$this->load->view('StockControl/StockOpnamePusat/V_Export_Filter', $data);
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

	public function export_excel(){
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
		
		$item_classification = $this->M_stock_opname_pusat->item_classification($io_name,$sub_inventory,$area,$locator);
		$stock_opname_pusat = $this->M_stock_opname_pusat->stock_opname_pusat_filter($io_name,$sub_inventory,$area,$locator);

		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleArray = array(
			'font'  => array(
				'bold'  => true
			)
		);

		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(20);
		$worksheet->getColumnDimension('C')->setWidth(40);
		$worksheet->getColumnDimension('D')->setWidth(10);
		$worksheet->getColumnDimension('E')->setWidth(15);
		$worksheet->getColumnDimension('F')->setWidth(10);
		$worksheet->getColumnDimension('G')->setWidth(7);
		$worksheet->getColumnDimension('H')->setWidth(7);
		$worksheet->getColumnDimension('I')->setWidth(20);

		if(!(empty($item_classification))){
			$highest_row = 1;
			foreach ($item_classification as $ic) {
				$worksheet->mergeCells('A'.$highest_row.':I'.$highest_row);
				$worksheet->setCellValue('A'.$highest_row, 'DAFTAR KODE BARANG - STOCK OPNAME - CV. KARYA HIDUP SENTOSA');
				$worksheet->getStyle('A'.$highest_row)->applyFromArray($styleArray);
				$worksheet->getStyle('A'.$highest_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$highest_row = $worksheet->getHighestRow() + 2;

				$worksheet->mergeCells('A'.$highest_row.':B'.$highest_row);
				$worksheet->setCellValue('A'.$highest_row, 'NAMA IO');
				$worksheet->setCellValue('C'.$highest_row, $ic['io_name']);

				$worksheet->mergeCells('A'.($highest_row+1).':B'.($highest_row+1));
				$worksheet->setCellValue('A'.($highest_row+1), 'SUB INVENTORY');
				$worksheet->setCellValue('C'.($highest_row+1), $ic['sub_inventory']);

				$worksheet->mergeCells('A'.($highest_row+2).':B'.($highest_row+2));
				$worksheet->setCellValue('A'.($highest_row+2), 'AREA');
				$worksheet->setCellValue('C'.($highest_row+2), $ic['area']);

				$worksheet->mergeCells('A'.($highest_row+3).':B'.($highest_row+3));
				$worksheet->setCellValue('A'.($highest_row+3), 'LOCATOR');
				$worksheet->setCellValue('C'.($highest_row+3), $ic['locator']);

				$worksheet->mergeCells('G'.$highest_row.':I'.$highest_row);
				$worksheet->mergeCells('G'.($highest_row+1).':I'.($highest_row+1));
				$worksheet->mergeCells('G'.($highest_row+2).':I'.($highest_row+2));
				$worksheet->mergeCells('G'.($highest_row+3).':I'.($highest_row+3));

				$worksheet->mergeCells('E'.$highest_row.':F'.$highest_row);
				$worksheet->setCellValue('E'.$highest_row, 'PETUGAS INPUT');
				$worksheet->setCellValue('G'.$highest_row, '.........................................................');

				$worksheet->mergeCells('E'.($highest_row+1).':F'.($highest_row+1));
				$worksheet->setCellValue('E'.($highest_row+1), 'TANGGAL SO');
				$worksheet->setCellValue('G'.($highest_row+1), $tgl_so);

				$worksheet->mergeCells('E'.($highest_row+2).':F'.($highest_row+2));
				$worksheet->setCellValue('E'.($highest_row+2), 'NAMA PENCATAT');
				$worksheet->setCellValue('G'.($highest_row+2), '.........................................................');

				$worksheet->mergeCells('E'.($highest_row+3).':F'.($highest_row+3));
				$worksheet->setCellValue('E'.($highest_row+3), 'PIC AREA');
				$worksheet->setCellValue('G'.($highest_row+3), '.........................................................');

				$highest_row = $worksheet->getHighestRow() + 2;
				$border_corner = $highest_row;
				$worksheet->setCellValue('A'.$highest_row, 'No');
				$worksheet->setCellValue('B'.$highest_row, 'Kode Barang');
				$worksheet->setCellValue('C'.$highest_row, 'Nama Barang');
				$worksheet->setCellValue('D'.$highest_row, 'Type');
				$worksheet->setCellValue('E'.$highest_row, 'Lokasi Simpan');
				$worksheet->setCellValue('F'.$highest_row, 'On Hand');
				$worksheet->setCellValue('G'.$highest_row, 'UOM');
				$worksheet->setCellValue('H'.$highest_row, 'So QTY');
				$worksheet->setCellValue('I'.$highest_row, 'Ket');

				$worksheet->getStyle('A'.$highest_row.':I'.$highest_row)->applyFromArray($styleArray);
				$worksheet->getStyle('A'.$highest_row.':I'.$highest_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$worksheet->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

				$highest_row = $worksheet->getHighestRow() + 1;
				if(!(empty($stock_opname_pusat))){
					$no=0;
					foreach($stock_opname_pusat as $sop) {
						if ($sop['io_name'] == $ic['io_name'] && $sop['sub_inventory'] == $ic['sub_inventory'] && $sop['area'] == $ic['area'] && $sop['locator'] == $ic['locator']) {
							$no++;
							$worksheet->setCellValue('A'.$highest_row, $no);
							$worksheet->setCellValue('B'.$highest_row, $sop['component_code'], PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValue('C'.$highest_row, $sop['component_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValue('D'.$highest_row, $sop['type'], PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValue('E'.$highest_row, $sop['saving_place'], PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValue('F'.$highest_row, $sop['onhand_qty'], PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValue('G'.$highest_row, $sop['uom'], PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValue('H'.$highest_row, $sop['so_qty'], PHPExcel_Cell_DataType::TYPE_STRING);

							$highest_row++;
						}
					}
					$borderStyle = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						)
					);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$border_corner.':I'.($highest_row-1))->applyFromArray($borderStyle);
					unset($borderStyle);
				}
				$highest_row = $worksheet->getHighestRow() + 5;
			}
		}

		$worksheet->setTitle('Report Stock Opname Pusat');
		$worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report-Stock-Opname-Pusat-'.time().'.xlsx"');
		$objWriter->save("php://output");
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
