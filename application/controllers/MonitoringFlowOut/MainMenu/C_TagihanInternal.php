<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_TagihanInternal extends CI_Controller
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
		$this->load->library('Excel');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringFlowOut/M_internal');

		$this->checkSession();
	}
	
    public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Tagihan Internal';
		$data['Menu'] = 'Tagihan Internal';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Filter'] = 'Pure';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['allTagihan'] = $this->M_internal->getTagihan();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/Master/V_TagihanInternal', $data);
		$this->load->view('V_Footer', $data);
	}
	
	public function search()
	{
		$txtTglMFO1 = $_POST['txtTglMFO1'];
		$txtTglMFO2 = $_POST['txtTglMFO2'];
		$slcSeksiFAjx = $_POST['slcSeksiFAjx'];

		$newtxtTglMFO1 = date('Y-m-d', strtotime($txtTglMFO1));
		$newtxtTglMFO2 = date('Y-m-d', strtotime($txtTglMFO2));

		$data['allTagihan'] = $this->M_internal->filterCar($newtxtTglMFO1, $newtxtTglMFO2, $slcSeksiFAjx);

		if (empty($data['allTagihan'])){
			echo "<center><h3 style='color:red;'>Data tidak ditemukan</h3></center>";
		} else {
		return $this->load->view('MonitoringFlowOut/Master/V_ViewResultTagInt', $data);
		}
	}

	public function ExportInt() {
		$tglAwal = $this->input->post('txtTglMFO1');
		$tglAkhir = $this->input->post('txtTglMFO2');
		$seksi = $this->input->post('seksi2');

		if ($tglAwal){
			$dataSelected = $this->M_internal->filterCar(
				date('Y-m-d', strtotime($tglAwal)),
				date('Y-m-d', strtotime($tglAkhir)),
				$seksi
			);
		} else {
			$dataAll = $this->M_internal->getTagihan();
		}

		$objPHPExcel = new PHPExcel();
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$worksheet = $objPHPExcel->getActiveSheet();
		$objImage = imagecreatefrompng(base_url("assets/img/logo.png"));
		$objDrawing->setName('Logo QUICK');
		$objDrawing->setDescription('Logo QUICK');
		$objDrawing->setImageResource($objImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG);
		$objDrawing->setHeight(50);
		$objDrawing->setWidth(50);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($worksheet);

		// Styling
		$worksheet->mergeCells('A1:H3');
		$worksheet->mergeCells('F5:G5');

		$worksheet->getColumnDimension('A')->setWidth(5); //Mo
		$worksheet->getColumnDimension('B')->setWidth(20); //Seksi Penemu
		$worksheet->getColumnDimension('C')->setWidth(15); //Tgl
		$worksheet->getColumnDimension('D')->setWidth(25); //Type
		$worksheet->getColumnDimension('E')->setWidth(35); //Komponen
		$worksheet->getColumnDimension('F')->setWidth(40); //Kasus
		$worksheet->getColumnDimension('G')->setWidth(20); //Kasus
		$worksheet->getColumnDimension('H')->setWidth(25); //Seksi PJ

		$worksheet->getRowDimension('5')->setRowHeight(32); //Height Content Header


		$worksheet->getStyle('A1')->applyFromArray(array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'bold' => true,
				'size' => 20
			),
		));

		$worksheet->getStyle('A4:H4')->applyFromArray(array (
			'font' => array (
				'bold'  => true,
				'color' => array('rgb' => '000000')
			)
		));

		$worksheet->getStyle('A5:H5')->applyFromArray(array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'       => true
			),
			'font' => array (
				'bold'  => true,
				'color' => array('rgb' => '000000')
			),
			'borders' => array(
				'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
				)
				),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'FFFFFF00')
			),
			
		));

		//Only Middle and Center Content
		$MidCenter = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		
		//Content Styling
		$cont = array(
			'alignment' => array(
				'wrap'       => true,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			),
			'font' => array (
				'color' => array('rgb' => '000000')
			)
		);

		$worksheet->setCellValue('A1', 'REKAPITULASI FLOW OUT BELUM KIRIM CAR');
		$worksheet->setCellValue('A4', 'UPDATE : ' . date('d-m-Y'));
		if ($tglAwal) {
			$worksheet->setCellValue('D4', 'RENTANG WAKTU : ' . $tglAwal . ' s/d ' . $tglAkhir);
		} else {
			$worksheet->setCellValue('D4', 'RENTANG WAKTU : Semua Waktu');
		}
		if ($tglAwal) {
			$worksheet->setCellValue('H4', 'SEKSI : ' . $seksi);
		} else {
			$worksheet->setCellValue('H4', 'SEKSI : Semua Seksi');
		}
		$worksheet->setCellValue('A5', 'NO');
		$worksheet->setCellValue('B5', 'SEKSI PENEMU');
		$worksheet->setCellValue('C5', 'TGL FLOWOUT');
		$worksheet->setCellValue('D5', 'TYPE PRODUK');
		$worksheet->setCellValue('E5', 'KOMPONEN');
		$worksheet->setCellValue('F5', 'KASUS');
		$worksheet->setCellValue('H5', 'SEKSI PJ');

		//Content
		$highestRow = 6;
		$nomor = 1;

		if ($tglAwal){
			for ($i=0; $i < sizeof($dataSelected); $i++) {
				$worksheet->mergeCells('F'. $highestRow .':G'. $highestRow);
				$worksheet->setCellValue('A' . $highestRow, $nomor)->getStyle('A' . $highestRow)->applyFromArray($MidCenter);
				$worksheet->setCellValue('B' . $highestRow, $dataSelected[$i]['seksi_penemu'])->getStyle('B' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('C' . $highestRow, date('d-m-Y', strtotime($dataSelected[$i]['tanggal'])))->getStyle('C' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('D' . $highestRow, $dataSelected[$i]['type'])->getStyle('D' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('E' . $highestRow, $dataSelected[$i]['component_name'])->getStyle('E' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('F' . $highestRow, $dataSelected[$i]['kronologi_p'])->getStyle('F' . $highestRow)->applyFromArray($cont); $worksheet->getStyle('G' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('H' . $highestRow, $dataSelected[$i]['seksi_penanggungjawab'])->getStyle('H' . $highestRow)->applyFromArray($cont);
				
				$highestRow++;
				$nomor++;
			}
		} else {
			for ($i=0; $i < sizeof($dataAll); $i++) { 
				$worksheet->mergeCells('F'. $highestRow .':G'. $highestRow);
				$worksheet->setCellValue('A' . $highestRow, $nomor)->getStyle('A' . $highestRow)->applyFromArray($MidCenter);
				$worksheet->setCellValue('B' . $highestRow, $dataAll[$i]['seksi_penemu'])->getStyle('B' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('C' . $highestRow, date('d-m-Y', strtotime($dataAll[$i]['tanggal'])))->getStyle('C' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('D' . $highestRow, $dataAll[$i]['type'])->getStyle('D' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('E' . $highestRow, $dataAll[$i]['component_name'])->getStyle('E' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('F' . $highestRow, $dataAll[$i]['kronologi_p'])->getStyle('F' . $highestRow)->applyFromArray($cont); $worksheet->getStyle('G' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('H' . $highestRow, $dataAll[$i]['seksi_penanggungjawab'])->getStyle('H' . $highestRow)->applyFromArray($cont);
				
				$highestRow++;
				$nomor++;
			}
		}
		$bottomsheet = $highestRow + 8;
			//Bottom Styling
		$worksheet->getStyle('F' . $bottomsheet . ':H' . ($bottomsheet + 6))->applyFromArray(array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'font' => array(
				'bold'  => true
			)
		));
		$worksheet->getRowDimension($bottomsheet+1)->setRowHeight(30); //Height Content Header
		$worksheet->setCellValue('F' . ($bottomsheet + 1), 'Menyetujui');
		$worksheet->setCellValue('F' . ($bottomsheet + 3), '..............................');
		$worksheet->setCellValue('F' . ($bottomsheet + 4), 'Ka. / Ass. Ka. Unit Quality Inspection');

		$worksheet->setCellValue('H' . $bottomsheet, 'Yogyakarta, .............................');
		$worksheet->setCellValue('H' . ($bottomsheet + 1), 'Dibuat,');
		$worksheet->setCellValue('H' . ($bottomsheet + 3), '............................');
		$worksheet->setCellValue('H' . ($bottomsheet + 4), 'Kepala Seksi Madya QI A');

		//Final
		$worksheet->setTitle('Tagihan Internal');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REKAPITULASI FLOW OUT INTERNAL BELUM KIRIM CAR ' . date('d-m-Y') . '.xls"');
		$objWriter->save("php://output");
	}
}
