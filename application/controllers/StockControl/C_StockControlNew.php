<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_StockControlNew extends CI_Controller {

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

		$this->load->model('StockControl/M_stock_control_new');
		  
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
		$data['Title'] = 'List Stock Control';
		$data['Menu'] = 'Stock Control';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['alert'] = $this->session->flashdata('alert');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockControl/StockControlNew/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function monitoring()
	{
		$data['area'] = $this->M_stock_control_new->area_list();
		$data['subassy'] = $this->M_stock_control_new->subassy_list();

		$data['from'] = date('Y-m-d 00:00:00');
		$data['to'] = date('Y-m-d 23:59:59');
		
		$data['stock_on_date'] = $this->M_stock_control_new->qty_plan($data['from'],$data['to']);

		$this->load->view('StockControl/StockControlNew/V_Monitoring',$data);
		$this->load->view('StockControl/StockControlNew/V_Monitoring_table',$data);
		$this->load->view('StockControl/StockControlNew/V_Monitoring_footer',$data);
	}

	public function getData()
	{
		$area = $this->input->post('txt_area');
		$subassy = $this->input->post('txt_subassy');
		$from = $this->input->post('txt_date_from');
		$to = $this->input->post('txt_date_to');

		if ($area == 'All' || $area == '' ) {
			$area = "area";
		}
		else{
			$area = "'".$area."'";
		}

		if ($subassy == 'All' || $subassy == '') {
			$subassy = "subassy_desc";
		}
		else{
			$subassy = "'".$subassy."'";
		}

		$from = date('Y-m-d 00:00:00', strtotime($from));
		$to = date('Y-m-d 23:59:59', strtotime($to));

		$data['stock_on_date'] = $this->M_stock_control_new->qty_plan($from,$to);
		$data['production_list'] = $this->M_stock_control_new->production_list_filter($area,$subassy);
		foreach ($data['production_list'] as $pl) {
			foreach ($data['stock_on_date'] as $sod) {
				$data['data_'.$pl['master_data_id'].'_'.$sod['plan_id']] = $this->M_stock_control_new->transaction_list($pl['master_data_id'],$sod['plan_id']);
			}
		}

		$this->load->view('StockControl/StockControlNew/V_Monitoring_table',$data);
	}

	public function saveTransaction()
	{
		$qty = $this->input->post("qtySO");
		$master_id = $this->input->post("master_id");
		$plan_id = $this->input->post("plan_id");

		$master_data = $this->M_stock_control_new->select_master_data($master_id);
		$plan_data = $this->M_stock_control_new->select_plan_data($plan_id);

		if ($qty == '-') {
			$this->M_stock_control_new->delete_data($master_id,$plan_id);
			echo '<input data-toggle="tooltip" data-placement="top" title="Press Enter to Submit!" class="form-control" style="width: 100%;" type="text" value="" name="txt_qty_so" onchange="SaveSO(\''.$master_id.'\',\''.$plan_id.'\',this)" />';
		}
		else{
			foreach ($master_data as $md) {
				$qty_needed = $md['qty_component_needed'];
			}
			foreach ($plan_data as $pd) {
				$qty_plan = $pd['qty_plan'];
			}

			$check_transaction = $this->M_stock_control_new->check_transaction($master_id,$plan_id);
			if ($check_transaction == '0') {
				if ($qty < ($qty_needed*$qty_plan)) {
					$status = "KURANG";
				}
				elseif ($qty >= ($qty_needed*$qty_plan)) {
					$status = "LENGKAP";
				}
				$this->M_stock_control_new->insert_data($qty,$master_id,$plan_id,$status);
			}
			else{
				if ($qty < ($qty_needed*$qty_plan)) {
					$status = "KURANG";
				}
				elseif ($qty >= ($qty_needed*$qty_plan)) {
					$status = "DILENGKAPI";
				}
				$this->M_stock_control_new->update_data($qty,$master_id,$plan_id,$status);
			}

			if ($status == 'LENGKAP') {
				$style = "border-color: #008d4c ; box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.075) inset, 5px 5px 5px #008d4c;";
			}
			elseif ($status == 'KURANG') {
				$style = "border-color: #d33724 ; box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.075) inset, 5px 5px 5px #d33724;";
			}
			elseif ($status == 'DILENGKAPI') {
				$style = "border-color: #357ca5 ; box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.075) inset, 5px 5px 5px #357ca5;";
			}
			else{
				$style ="";
			}

			echo '<input data-toggle="tooltip" data-placement="top" title="Press Enter to Submit!" class="form-control" style="width: 100%;'.$style.'" type="text" value="'.$qty.'" name="txt_qty_so" onchange="SaveSO(\''.$master_id.'\',\''.$plan_id.'\',this)" />';
		}
	}

	public function export_excel()
	{
		$from = $this->input->post('txt_date_from_kekurangan');
		$to = $this->input->post('txt_date_to_kekurangan');

		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
			)
		);
		$bold = array(
			'font'  => array(
				'bold'  => true,
			));

		$area_list = $this->M_stock_control_new->area_export($from,$to);
		$subassy_list = $this->M_stock_control_new->subassy_export($from,$to);
		$component_list = $this->M_stock_control_new->component_export($from,$to);
		$periode = $this->M_stock_control_new->qty_plan($from,$to);

		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$worksheet->getColumnDimension('A')->setWidth(3);
		$worksheet->getColumnDimension('B')->setWidth(15);
		$worksheet->getColumnDimension('C')->setWidth(35);
		$worksheet->getColumnDimension('D')->setWidth(5);
		$worksheet->getColumnDimension('E')->setWidth(6);

		$worksheet->mergeCells('A1:A3');
		$worksheet->mergeCells('B1:B3');
		$worksheet->mergeCells('C1:C3');
		$worksheet->mergeCells('D1:D3');

		$worksheet->setCellValue('A1', 'NO');
		$worksheet->setCellValue('B1', 'KODE');
		$worksheet->setCellValue('C1', 'KOMPONEN');
		$worksheet->setCellValue('D1', 'PER UNIT');

		$col = "4";
		foreach ($periode as $per) {
			$column = PHPExcel_Cell::stringFromColumnIndex($col);
			$column1 = PHPExcel_Cell::stringFromColumnIndex($col+1);
			$column2 = PHPExcel_Cell::stringFromColumnIndex($col+2);
			$column3 = PHPExcel_Cell::stringFromColumnIndex($col+3);

			$worksheet->getColumnDimension($column)->setWidth(10);

			$worksheet->mergeCells($column.'1:'.$column3.'1');
			$worksheet->mergeCells($column.'2:'.$column.'3');
			$worksheet->mergeCells($column1.'2:'.$column1.'3');
			$worksheet->mergeCells($column2.'2:'.$column2.'3');
			$worksheet->mergeCells($column3.'2:'.$column3.'3');

			$worksheet->setCellValue($column.'1', date('Y-m-d', strtotime($per['plan_date'])));
			$worksheet->setCellValue($column.'2', 'QTY NEEDED');
			$worksheet->setCellValue($column1.'2', 'QTY ACTUAL');
			$worksheet->setCellValue($column2.'2', 'QTY KURANG');
			$worksheet	->getStyle($column2)
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('e9897e');
			$worksheet->setCellValue($column3.'2', 'STATUS');

			$col = $col+4;
		}

		$highestCol = PHPExcel_Cell::stringFromColumnIndex($col-1);

		$worksheet
			->getStyle('A1:'.$highestCol.'3')
			->getAlignment()
			->setWrapText(true);

		$worksheet
			->getStyle('A1:'.$highestCol.'3')
			->getAlignment()
			->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$worksheet
			->getStyle('A1:'.$highestCol.'3')
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A1:'.$highestCol.'3')->applyFromArray($styleArray);
		$worksheet	->getStyle('A1:'.$highestCol.'3')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');

		$row = 4;
		foreach ($area_list as $ar) {
			$worksheet->mergeCells('A'.$row.':D'.$row);
			$worksheet->setCellValue('A'.$row, $ar['area']);
			$worksheet
				->getStyle('A'.$row.':A'.$row)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet
				->getStyle('A'.$row.':A'.$row)
				->applyFromArray($bold);
			$row++;
			foreach ($subassy_list as $sub) {
				if ($sub['area'] == $ar['area']) {
					$worksheet->mergeCells('A'.$row.':D'.$row);
					$worksheet->setCellValue('A'.$row, $sub['subassy_desc']);
					$worksheet
						->getStyle('A'.$row.':A'.$row)
						->applyFromArray($bold);
					$no = 1;
					$row++;
					foreach ($component_list as $comp) {
						if ($comp['subassy_desc'] == $sub['subassy_desc']) {
							$worksheet->setCellValue('A'.$row, $no);
							$worksheet->setCellValue('B'.$row, $comp['component_code']);
							$worksheet->setCellValue('C'.$row, $comp['component_desc']);
							$worksheet->setCellValue('D'.$row, $comp['qty_component_needed']);

							$col = '4';
							foreach ($periode as $per) {
								//if ($per['plan_date'] == $comp['plan_date']) {
									${'data_'.$comp['master_data_id'].'_'.$per['plan_id']} = $this->M_stock_control_new->transaction_export($comp['master_data_id'],$per['plan_id']);
									if (empty(${'data_'.$comp['master_data_id'].'_'.$per['plan_id']})) {
										$qty_needed = '-';
										$qty_actual = '-';
										$qty_kurang = '-';
										$status = '-';
									}
									foreach (${'data_'.$comp['master_data_id'].'_'.$per['plan_id']} as $tr_status) {
										//if ($tr_status['plan_date'] == $comp['plan_date']) {
											$qty_needed = $tr_status['qty_plan']*$tr_status['qty_component_needed'];
											$qty_actual = $tr_status['qty'];
											$qty_kurang = ($tr_status['qty_plan']*$tr_status['qty_component_needed'])-$tr_status['qty'];
											$status = $tr_status['status_publish'];
										//}
									}
											$column = PHPExcel_Cell::stringFromColumnIndex($col);
											$column1 = PHPExcel_Cell::stringFromColumnIndex($col+1);
											$column2 = PHPExcel_Cell::stringFromColumnIndex($col+2);
											$column3 = PHPExcel_Cell::stringFromColumnIndex($col+3);
											$worksheet->setCellValue($column.$row, $qty_needed);
											$worksheet->setCellValue($column1.$row, $qty_actual);
											$worksheet->setCellValue($column2.$row, $qty_kurang);
											$worksheet->setCellValue($column3.$row, $status);
											$col = $col+4;
							//	}
							}
							$no++;
							$row++;	
						}
					}
					$row = $row+1;	
				}
			}
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report-Kekurangan-Komponen-'.time().'.xlsx"');
		$objWriter->save("php://output");
	}

	public function export_pdf(){
		$from = $this->input->post('txt_date_from_kekurangan');
		$to = $this->input->post('txt_date_to_kekurangan');

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('', 'A4-L');

		$filename = 'Report-Kekurangan-Komponen-'.time();

		$data['area_list'] = $this->M_stock_control_new->area_export($from,$to);
		$data['subassy_list'] = $this->M_stock_control_new->subassy_export($from,$to);
		$data['component_list'] = $this->M_stock_control_new->component_export($from,$to);
		$data['periode'] = $this->M_stock_control_new->qty_plan($from,$to);

		$stylesheet = file_get_contents('assets/plugins/bootstrap/3.3.6/css/bootstrap.css');

		$html = $this->load->view('StockControl/StockControlNew/V_table_pdf', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'D');
	}

	public function monitoring_kekurangan(){
		$data['from'] = date('Y-m-d 00:00:00');
		$data['to'] = date('Y-m-d 23:59:59');

		$data['area_list'] = $this->M_stock_control_new->area_export($data['from'],$data['to']);
		$data['subassy_list'] = $this->M_stock_control_new->subassy_export($data['from'],$data['to']);
		$data['component_list'] = $this->M_stock_control_new->component_export($data['from'],$data['to']);
		$data['periode'] = $this->M_stock_control_new->qty_plan($data['from'],$data['to']);


		foreach ($data['component_list'] as $comp) {
			foreach ($data['periode'] as $per) {
				$data['data_'.$comp['master_data_id'].'_'.$per['plan_id']] = $this->M_stock_control_new->transaction_export($comp['master_data_id'],$per['plan_id']);
			}
		}

		$this->load->view('StockControl/StockControlNew/V_Monitoring_Kekurangan', $data);
		$this->load->view('StockControl/StockControlNew/V_Monitoring_Kekurangan_table', $data);
		$this->load->view('StockControl/StockControlNew/V_Monitoring_Kekurangan_footer', $data);
	}

	public function getDataKekurangan(){
		$from = $this->input->post('txt_date_from_kekurangan');
		$to = $this->input->post('txt_date_to_kekurangan');

		$data['area_list'] = $this->M_stock_control_new->area_export($from,$to);
		$data['subassy_list'] = $this->M_stock_control_new->subassy_export($from,$to);
		$data['component_list'] = $this->M_stock_control_new->component_export($from,$to);
		$data['periode'] = $this->M_stock_control_new->qty_plan($from,$to);


		foreach ($data['component_list'] as $comp) {
			foreach ($data['periode'] as $per) {
				$data['data_'.$comp['master_data_id'].'_'.$per['plan_id']] = $this->M_stock_control_new->transaction_export($comp['master_data_id'],$per['plan_id']);
			}
		}

		$this->load->view('StockControl/StockControlNew/V_Monitoring_Kekurangan_table', $data);
	}
}
