<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Report extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->checkSession();
    }

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['title'] = 'Storage Location Report';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StorageLocation/Report/V_report',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateReport()
	{
		// ----------------- inisialisasi data -----------------
		$org_id 	= $this->input->post('IdOrganization');
		$sub_inv 	= $this->input->post('SlcSubInventori');
		$locator 	= $this->input->post('SlcLocator');
		$component 	= $this->input->post('SlcItem');
		$a 			= explode('|', $component);
		$kode_item 	= $a[0];

		// ----------------- load material -----------------
		$this->load->model('StorageLocation/Report/M_report');
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();
		$styleThead = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
				'size'	=> 14,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$styleBorder = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$styleTitle = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'	=> 24,
			),
			'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        	)
		);
		$data = $this->M_report->getStorageData($sub_inv,$locator,$kode_item,$org_id);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();

		// ----------------- Set format table -----------------
		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(24);
		$worksheet->getColumnDimension('C')->setWidth(58);
		$worksheet->getColumnDimension('D')->setWidth(24);
		$worksheet->getColumnDimension('E')->setWidth(24);
		$worksheet->getColumnDimension('F')->setWidth(24);
		$worksheet->getColumnDimension('G')->setWidth(24);
		$worksheet->getColumnDimension('H')->setWidth(45);
		$worksheet->getColumnDimension('I')->setWidth(5);
		$worksheet->getColumnDimension('J')->setWidth(5);
		$worksheet->getColumnDimension('K')->setWidth(5);
		$worksheet->getColumnDimension('L')->setWidth(5);

		$worksheet->getStyle('A3:L3')->applyFromArray($styleThead);
		$worksheet	->getStyle('A3:L3')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('337ab7');

		// ----------------- Set table header -----------------
		$worksheet->mergeCells('A1:L1');
		$worksheet->getStyle('A1:L1')->applyFromArray($styleTitle);
		// $worksheet->getStyle("A1:L1")->getFont()->setSize(18);
		$worksheet->setCellValue('A1', 'STORAGE LOCATION MONITORING');

		$worksheet->setCellValue('A3', 'NO');
		$worksheet->setCellValue('B3', 'COMPONENT');
		$worksheet->setCellValue('C3', 'DESCRIPTION');
		$worksheet->setCellValue('D3', 'ASSEMBLY CODE');
		$worksheet->setCellValue('E3', 'ASSEMBLY NAME');
		$worksheet->setCellValue('F3', 'ASSEMBLY TYPE');
		$worksheet->setCellValue('G3', 'SUBINVENTORY');
		$worksheet->setCellValue('H3', 'STORAGE LOCATION');
		$worksheet->setCellValue('I3', 'LPPB/MO/KIB');
		$worksheet->setCellValue('J3', 'PICKLIST');
		$worksheet->setCellValue('K3', 'ON HAND');
		$worksheet->setCellValue('L3', 'ATR');

		// ----------------- Set table body -----------------
		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($data as $dt) {
			$worksheet->getStyle('A'.$highestRow.':L'.$highestRow)->applyFromArray($styleBorder);
			if ($dt['LMK'] == '1') {
				$LMK = 'V';
			}else{
				$LMK = '-';
			}
			if ($dt['PICKLIST'] == '1') {
				$PICKLIST = 'V';
			}else{
				$PICKLIST = '-';
			}
			if ($dt['ONHAND_QTY'] == null) {
				$ONHAND_QTY = '0';
			}else{
				$ONHAND_QTY = $dt['ONHAND_QTY'];
			}
			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $dt['ITEM']);
			$worksheet->setCellValue('C'.$highestRow, $dt['DESCRIPTION']);
			$worksheet->setCellValue('D'.$highestRow, $dt['KODE_ASSEMBLY']);
			$worksheet->setCellValue('E'.$highestRow, $dt['NAMA_ASSEMBLY']);
			$worksheet->setCellValue('F'.$highestRow, $dt['TYPE_ASSEMBLY']);
			$worksheet->setCellValue('G'.$highestRow, $dt['SUB_INV']);
			$worksheet->setCellValue('H'.$highestRow, $dt['ALAMAT']);
			$worksheet->setCellValue('I'.$highestRow, $LMK);
			$worksheet->setCellValue('J'.$highestRow, $PICKLIST);
			$worksheet->setCellValue('K'.$highestRow, $ONHAND_QTY);
			$worksheet->setCellValue('L'.$highestRow, $dt['ATR']);
			$highestRow++;
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Storage Location');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Storage_Location_'.time().'.xlsx"');
		$objWriter->save("php://output");

		// $this->load->view('StorageLocation/Report/V_StorageReport', $data, true);
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect();
		}
	}
}