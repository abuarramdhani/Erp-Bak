<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_XFIN extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_selep');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Generate XFIN';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/XFIN/V_index');
		$this->load->view('V_Footer', $data);
	}

	/*EXPORT*/
	public function export()
	{
		// $selepdata = $this->M_selep->getSelep();
		require(APPPATH . 'third_party\Excel\PHPExcel.php');
		require(APPPATH . 'third_party\Excel\PHPExcel\Writer\Excel5.php');
		$this->checkSession();
		$user_id = $this->session->userid;

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ICT");
		$objPHPExcel->getProperties()->setTitle("CheckSelep");
		$objPHPExcel->setActiveSheetIndex(0);
		$objset = $objPHPExcel->getActiveSheet();

		$objset->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objset->getPageSetup()->setFitToWidth(1);

		//BETWEEN
		$txtStartDate = $this->input->post('txtStartDate');
		$txtEndDate = $this->input->post('txtEndDate');
		$selepdate = $this->M_selep->getSelepDate($txtStartDate, $txtEndDate);
		
		//false
		$f = false;

		//TH KOLOM
		$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X");
		$val = array(
			"TGL", "SHIFT", "KELOMPOK", "KODECOR", "KODEBRG", "NAMABRG", "KODEPRO", "JUMLAH", "BAIK", "REPAIR", "REJECT", "KETERANGAN",
			"RGER_RT,N,4,0", "RGER_PH,N,4,0", "RGER_CW,N,4,0", "RINT_RT,N,4,0", "RINT_PH,N,4,0", "RINT,CW,N,4,0", "CASTING",
			"NOBP", "TGLBP", "CETAKBP", "NOBP_GB", "CETAKBP_GB"
		);

		$style = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$style2 = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		for ($a = 0; $a < 24; $a++) {
			$objset->setCellValue($cols[$a] . '1', $val[$a]);
			$objset->getColumnDimension('A')->setWidth(13); //TGL
			$objset->getColumnDimension('B')->setWidth(40); //SHIFT
			$objset->getColumnDimension('C')->setWidth(25); //KELOMPOK
			$objset->getColumnDimension('D')->setWidth(10); //KODECOR
			$objset->getColumnDimension('E')->setWidth(25); //KODEBRG
			$objset->getColumnDimension('F')->setWidth(30); //NAMABRG
			$objset->getColumnDimension('G')->setWidth(10); //KODEPRO
			$objset->getColumnDimension('H')->setWidth(10); //JML
			$objset->getColumnDimension('I')->setWidth(10); //BAIK
			$objset->getColumnDimension('J')->setWidth(10); //REPAIR
			$objset->getColumnDimension('K')->setWidth(10); //REJECT
			$objset->getColumnDimension('L')->setWidth(20); //KETERANGAN
			$objset->getColumnDimension('M')->setWidth(10); //RGER_RT
			$objset->getColumnDimension('N')->setWidth(10); //RGER_PH
			$objset->getColumnDimension('O')->setWidth(10); //RGER_CW
			$objset->getColumnDimension('P')->setWidth(10); //RINT_RT
			$objset->getColumnDimension('Q')->setWidth(10); //RINT_PH
			$objset->getColumnDimension('R')->setWidth(10); //RINT_CW
			$objset->getColumnDimension('S')->setWidth(10); //CASTING
			$objset->getColumnDimension('T')->setWidth(10); //NOBP
			$objset->getColumnDimension('U')->setWidth(13); //TGLBP
			$objset->getColumnDimension('V')->setWidth(10); //CETAKBP
			$objset->getColumnDimension('W')->setWidth(10); //NOBP_GB
			$objset->getColumnDimension('X')->setWidth(14); //CETAKBP_GB
			$objset->getStyle($cols[$a] . '1')->applyFromArray($style);
			$objset->getRowDimension('1')->setRowHeight(20);
		}
		$baris  = 2;
		//KODE BARANG
		$monthCode = array(
			array('month' => 1, 'code' => 'A'),
			array('month' => 2, 'code' => 'B'),
			array('month' => 3, 'code' => 'C'),
			array('month' => 4, 'code' => 'D'),
			array('month' => 5, 'code' => 'E'),
			array('month' => 6, 'code' => 'F'),
			array('month' => 7, 'code' => 'G'),
			array('month' => 8, 'code' => 'H'),
			array('month' => 9, 'code' => 'J'),
			array('month' => 10, 'code' => 'K'),
			array('month' => 11, 'code' => 'L'),
			array('month' => 12, 'code' => 'M')
		);
		$yearCode = array(
			array('year' => 0, 'code' => 'N'),
			array('year' => 1, 'code' => 'P'),
			array('year' => 2, 'code' => 'Q'),
			array('year' => 3, 'code' => 'R'),
			array('year' => 4, 'code' => 'S'),
			array('year' => 5, 'code' => 'U'),
			array('year' => 6, 'code' => 'V'),
			array('year' => 7, 'code' => 'W'),
			array('year' => 8, 'code' => 'Y'),
			array('year' => 9, 'code' => 'Z'),
		);

		foreach ($selepdate as $sd) {
			$baik = $sd['qc_qty_ok'];
			$origDate = $sd['selep_date'];
			$newDate = date("d-m-Y", strtotime($origDate));
			$brg = (explode("|", $sd['component_code']));

			$val = explode('-', $newDate);
			// echo '<pre>';print_r($val);exit;
			//PISAH
			
			foreach ($monthCode as $value) {
				if ($val[1] == $value['month']) {
					$bulan = $value['code'];
				}
			}
			
			foreach ($yearCode as $v) {
				if (substr($val[2], -1) == $v['year']) {
					$tahun = $v['code'];
				}
			}

			//ISI
			$objset->getStyle('A' . $baris)->applyFromArray($style2);
			$objset->getStyle('B' . $baris)->applyFromArray($style2);
			$objset->getStyle('C' . $baris)->applyFromArray($style2);
			$objset->getStyle('D' . $baris)->applyFromArray($style2);
			$objset->getStyle('E' . $baris)->applyFromArray($style2);
			$objset->getStyle('F' . $baris)->applyFromArray($style2);
			$objset->getStyle('G' . $baris)->applyFromArray($style2);
			$objset->getStyle('H' . $baris)->applyFromArray($style2);
			$objset->getStyle('I' . $baris)->applyFromArray($style2);
			$objset->getStyle('J' . $baris)->applyFromArray($style2);
			$objset->getStyle('K' . $baris)->applyFromArray($style2);
			$objset->getStyle('L' . $baris)->applyFromArray($style2);
			$objset->getStyle('M' . $baris)->applyFromArray($style2);
			$objset->getStyle('N' . $baris)->applyFromArray($style2);
			$objset->getStyle('O' . $baris)->applyFromArray($style2);
			$objset->getStyle('P' . $baris)->applyFromArray($style2);
			$objset->getStyle('Q' . $baris)->applyFromArray($style2);
			$objset->getStyle('R' . $baris)->applyFromArray($style2);
			$objset->getStyle('S' . $baris)->applyFromArray($style2);
			$objset->getStyle('T' . $baris)->applyFromArray($style2);
			$objset->getStyle('U' . $baris)->applyFromArray($style2);
			$objset->getStyle('V' . $baris)->applyFromArray($style2);
			$objset->getStyle('W' . $baris)->applyFromArray($style2);
			$objset->getStyle('X' . $baris)->applyFromArray($style2);

			$objset->setCellValue('A' . $baris, $newDate); //TGL
			$objset->setCellValue('B' . $baris, $sd['shift']); //SHIFT
			$objset->setCellValue('C' . $baris, $sd['job_id']); //KELOMPOK
			$objset->setCellValue('D' . $baris, $bulan . '' . $tahun); //KODECOR
			$objset->setCellValue('E' . $baris, $brg[0]); //KODEBRG
			$objset->setCellValue('F' . $baris, $sd['component_description']); //NAMABRG

			$kode_barang = $this->M_selep->getKodeProses($brg[0]);
			
			$rejected = $sd['qc_qty_not_ok'];

			$tglBp = date('d-m-Y', strtotime($newDate. ' + 3 days'));

			foreach ($kode_barang as $key => $codebrg) {
				$objset->setCellValue('G' . $baris, $codebrg['kode_proses']); //KODEPRO
			}

			$objset->setCellValue('H' . $baris, $sd['selep_quantity']); //JML
			$objset->setCellValue('I' . $baris, $baik); //BAIK
			$objset->setCellValue('J' . $baris, ""); //REPAIR
			$objset->setCellValue('K' . $baris, $rejected); //REJECT
			$objset->setCellValue('L' . $baris, $sd['keterangan']); //KETERANGAN
			$objset->setCellValue('M' . $baris, ""); //RGER_RT
			$objset->setCellValue('N' . $baris, ""); //RGER_PH
			$objset->setCellValue('O' . $baris, ""); //RGER_CW
			$objset->setCellValue('P' . $baris, ""); //RINT_RT
			$objset->setCellValue('Q' . $baris, ""); //RINT_PH
			$objset->setCellValue('R' . $baris, ""); //RINT_CW
			$objset->setCellValue('S' . $baris, ""); //CASTING
			$objset->setCellValue('T' . $baris, ""); //NOBP
			$objset->setCellValue('U' . $baris, $tglBp); //TGLBP
			$objset->setCellValue('V' . $baris, $f); //CETAKBP
			$objset->setCellValue('W' . $baris, ""); //NOBP_GB
			$objset->setCellValue('X' . $baris, $f); //CETAKBP_GB
			$baris++;
		}
		$filename = "Check Selep " . date("d-m-Y") . ".xls";

		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
	}
}
