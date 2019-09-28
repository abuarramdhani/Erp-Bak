<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_QualityControl extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_qualitycontrol');
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_moulding');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl();
		$data['Selep'] = $this->M_qualitycontrol->getSelep();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_index', $data);
		$this->load->view('V_Footer', $data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtCheckingDateHeader', 'CheckingDate', 'required');
		$this->form_validation->set_rules('txtPrintCodeHeader', 'PrintCode', 'required');
		$this->form_validation->set_rules('txtCheckingQuantityHeader', 'CheckingQuantity', 'required');
		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/QualityControl/V_create', $data);
			$this->load->view('V_Footer', $data);
		} else {
			$data = array(
				'checking_date' => $this->input->post('txtCheckingDateHeader'),
				'shift' => $this->input->post('txtShiftHeader'),
				'print_code' => $this->input->post('txtPrintCodeHeader'),
				'checking_quantity' => $this->input->post('txtCheckingQuantityHeader'),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader'),
				'created_by' => $this->session->userid,
				'last_updated_date' => date("Y-m-d H:i:s")
			);
			$this->M_qualitycontrol->setQualityControl($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('ManufacturingOperationUP2L/QualityControl'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);

		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */

		$data['QualityControl'] = $this->M_qualitycontrol->getEditQualityControl($id);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('ManufacturingOperationUP2L/QualityControl/V_update', $data);
			$this->load->view('V_Footer', $data);
		} else {
			$data = array(
				'checking_date' => $this->input->post('txtCheckingDateHeader', TRUE),
				'selep_quantity' => $this->input->post('txtSelepQuantityHeader', TRUE),
				'checking_quantity' => $this->input->post('txtCheckingQuantityHeader', TRUE),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader', TRUE),
				'last_updated_by' => $this->session->userid,
				'last_updated_date' => date("Y-m-d H:i:s")
			);
			
			$id_fix = $this->input->post('id_fix');
			$qty_qc_ok = $this->input->post('txtCheckingQuantityHeader');

			$this->M_qualitycontrol->updateQualityControl($data, $id);
			$this->M_qualitycontrol->update_qty_qc($qty_qc_ok, $id_fix);

			redirect(site_url('ManufacturingOperationUP2L/QualityControl'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		// print_r($id);exit();
		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControlbyId($id);

		/* LINES DATA */

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_read', $data);
		$this->load->view('V_Footer', $data);
	}
	/* FILTER BY DATE */
	public function selectByDate1()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['tmpl'] = 'A1';
		$dateQCUp2l = $this->input->post('dateSQCUp2l');
		$data['Selep'] = $this->M_qualitycontrol->selectByDate1($dateQCUp2l);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_index_search', $data);
		$this->load->view('V_Footer', $data);
	}
	public function selectByDate2()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['tmpl'] = 'A2';
		$dateQCUp2l = $this->input->post('dateQCUp2l');
		$data['QualityControl'] = $this->M_qualitycontrol->selectByDate2($dateQCUp2l);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_index_search', $data);
		$this->load->view('V_Footer', $data);
	}

	/* READ DETAIL DATA */
	public function read_detail($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		// $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		// $plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControlDetail($id);

		/* LINES DATA */

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_read_detail', $data);
		$this->load->view('V_Footer', $data);
	}

	/* DELETE DATA */
	public function delete($id, $sid)
	{
		$this->M_qualitycontrol->deleteQualityControl($id, $sid);
		redirect(site_url('ManufacturingOperationUP2L/QualityControl'));
	}

	public function createLaporan1()
	{
		echo 'Tunggu sebentar pak, masih dalam tahap perbaikan dan pengembangan<br><br>Edwin - ICT';exit;
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_qualitycontrol->getComponent($tanggal1, $tanggal2);

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleThead = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$styleNotice = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'ff0000'),
			)
		);
		$styleBorder = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$aligncenter = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				)
			)
		);

		// ----------------- Set format table -----------------
		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(55);
		$worksheet->getColumnDimension('C')->setWidth(10);
		$worksheet->getColumnDimension('D')->setWidth(5);
		$worksheet->getColumnDimension('E')->setWidth(5);
		$worksheet->getColumnDimension('F')->setWidth(5);
		$worksheet->getColumnDimension('G')->setWidth(5);
		$worksheet->getColumnDimension('H')->setWidth(5);
		$worksheet->getColumnDimension('I')->setWidth(5);
		$worksheet->getColumnDimension('G')->setWidth(5);
		$worksheet->getColumnDimension('J')->setWidth(5);
		$worksheet->getColumnDimension('K')->setWidth(5);
		$worksheet->getColumnDimension('L')->setWidth(5);
		$worksheet->getColumnDimension('M')->setWidth(5);
		$worksheet->getColumnDimension('N')->setWidth(5);
		$worksheet->getColumnDimension('O')->setWidth(5);
		$worksheet->getColumnDimension('P')->setWidth(5);
		$worksheet->getColumnDimension('Q')->setWidth(5);
		$worksheet->getColumnDimension('R')->setWidth(5);
		$worksheet->getColumnDimension('S')->setWidth(5);
		$worksheet->getColumnDimension('T')->setWidth(5);
		$worksheet->getColumnDimension('U')->setWidth(5);
		$worksheet->getColumnDimension('V')->setWidth(10);
		$worksheet->getColumnDimension('W')->setWidth(10);
		$worksheet->getColumnDimension('X')->setWidth(10);
		$worksheet->getColumnDimension('Y')->setWidth(15);
		$worksheet->getColumnDimension('Z')->setWidth(15);

		// ----------------- STATIC DATA -----------------
		$worksheet->setCellValue('B1', 'MONITORING PRODUKSI UP2L');
		$worksheet->setCellValue('B2', 'Bulan : ' . date('F') . ' dari (' . date("d-m-Y", strtotime($tanggal1))  . ' s/d ' . date("d-m-Y", strtotime($tanggal2)) . ')');



		$worksheet->setCellValue('A4', 'NO');
		$worksheet->setCellValue('B4', 'KODE COR');
		$worksheet->setCellValue('C4', 'CETAK');
		$worksheet->setCellValue('D4', 'RC');
		$worksheet->setCellValue('F4', 'DF');
		$worksheet->setCellValue('E4', 'KP');
		$worksheet->setCellValue('G4', 'CT');
		$worksheet->setCellValue('H4', 'TS');
		$worksheet->setCellValue('I4', 'CW');
		$worksheet->setCellValue('J4', 'PH');
		$worksheet->setCellValue('K4', 'GS');
		$worksheet->setCellValue('L4', 'CP');
		$worksheet->setCellValue('M4', 'TT');
		$worksheet->setCellValue('N4', 'BC');
		$worksheet->setCellValue('O4', 'NK');
		$worksheet->setCellValue('P4', 'MS');
		$worksheet->setCellValue('Q4', 'RT');
		$worksheet->setCellValue('R4', 'LL');
		$worksheet->setCellValue('S4', 'RV');
		$worksheet->setCellValue('T4', 'BAIK');
		$worksheet->setCellValue('U4', 'IP');
		$worksheet->setCellValue('V4', 'BONGKAR');
		$worksheet->setCellValue('W4', 'SCRAP');
		$worksheet->setCellValue('X4', 'JML REJ');
		$worksheet->setCellValue('Y4', 'PRINT CODE');
		$worksheet->setCellValue('Z4', 'TGL');



		$worksheet->getStyle('A3:D3')->getAlignment()->setWrapText(true);
		$worksheet->getStyle('A1:D3')->applyFromArray($aligncenter);
		$worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
		$worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);

		foreach (range('A', 'Z') as $alpha) {
			$worksheet->mergeCells($alpha . '4:' . $alpha . '5')->getStyle($alpha . '5:' . $alpha . '5')->applyFromArray($style);
		}

		// ----------------- DYNAMIC DATA -----------------



		$highestRow = $worksheet->getHighestRow() + 2;
		foreach ($section as $sc) {
			// $worksheet->mergeCell('')->getStyle('F'.$highestRow.':G'.$highestRow)->applyFromArray($styleBorder);
			$worksheet->setCellValue('B' . $highestRow, 'NAMA KOMPONEN : ' . $sc['component_description'] . " => " . $sc['component_code'])->mergeCells('B' . $highestRow . ':Z' . $highestRow)->getStyle('A' . $highestRow . ':Z' . $highestRow)->applyFromArray($styleBorder);

			$data['detail'] = $this->M_qualitycontrol->getPrintCode($sc['component_code']);



			$highestRow = $highestRow + 1;
			$no = 1;
			foreach (range('a', 'z') as $alpha) {

				$worksheet->getStyle($alpha . '4')->applyFromArray($style);
				$worksheet->getStyle($alpha . $highestRow)->applyFromArray($styleBorder);
			}
			foreach ($data['detail'] as $value) {

				$worksheet->setCellValue('A' . $highestRow, $no);
				$worksheet->setCellValue('C' . $highestRow, $value['moulding_quantity']);

				$originalDate = $value['production_date'];
				$newDate = date("d-m-Y", strtotime($originalDate));

				$worksheet->setCellValue('Z' . $highestRow, $newDate);

				$scrap = $this->M_qualitycontrol->getDetail($value['moulding_id']);
				$reject  = 0;
				foreach ($scrap as $key) {

					if ($key['kode_scrap'] == 'RC') {
						$worksheet->setCellValue('D' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'KP') {
						$worksheet->setCellValue('E' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'DF') {
						$worksheet->setCellValue('F' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'CT') {
						$worksheet->setCellValue('G' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'TS') {
						$worksheet->setCellValue('H' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'CW') {
						$worksheet->setCellValue('I' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'PH') {
						$worksheet->setCellValue('J' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'GS') {
						$worksheet->setCellValue('K' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'CP') {
						$worksheet->setCellValue('L' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'TT') {
						$worksheet->setCellValue('M' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'BC') {
						$worksheet->setCellValue('N' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'NK') {
						$worksheet->setCellValue('O' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'MS') {
						$worksheet->setCellValue('P' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'RT') {
						$worksheet->setCellValue('Q' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'LL') {
						$worksheet->setCellValue('R' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'RV') {
						$worksheet->setCellValue('S' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
					}
				}

				$bongkar_qty = 0;
				$bongkar = $this->M_qualitycontrol->getBongkar($value['moulding_id']);
				foreach ($bongkar as $key) {
					$bongkar_qty += $key['qty'];
				}
				$scrap_qty = 0;
				$scrap = $this->M_qualitycontrol->getScrap($value['moulding_id']);
				foreach ($scrap as $jmlScr) {
					$scrap_qty += $jmlScr['quantity'];
				}
				$baik = $bongkar_qty - $scrap_qty;
				$hasil = (int) $value['moulding_quantity'] - $bongkar_qty;

				$worksheet->setCellValue('T' . $highestRow, $baik);
				$worksheet->setCellValue('U' . $highestRow, $hasil);
				$worksheet->setCellValue('V' . $highestRow, $bongkar_qty);
				$worksheet->setCellValue('W' . $highestRow, $scrap_qty);
				$worksheet->setCellValue('X' . $highestRow, $reject);
				$worksheet->setCellValue('Y' . $highestRow, $value['print_code']);

				$worksheet->getStyle('A' . $highestRow . ':Z' . $highestRow)->applyFromArray($styleBorder);
				$highestRow++;
				$no++;
			}
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Monitoring_Produksi_' . time() . '.xls"');
		$objWriter->save("php://output");
	}

	public function createLaporan2()
	{
		echo 'Tunggu sebentar pak, masih dalam tahap perbaikan dan pengembangan<br><br>Edwin - ICT';exit;
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');


		$kodekolom = $this->M_qualitycontrol->get4CharComp();

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleThead = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$styleNotice = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'ff0000'),
			)
		);
		$styleBorder = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$aligncenter = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);

		// ----------------- Set format table -----------------
		$worksheet->getColumnDimension('A')->setWidth(20);
		$worksheet->getColumnDimension('B')->setWidth(30);
		$worksheet->getColumnDimension('C')->setWidth(15);
		$worksheet->getColumnDimension('D')->setWidth(8);
		$worksheet->getColumnDimension('E')->setWidth(8);
		$worksheet->getColumnDimension('F')->setWidth(8);
		$worksheet->getColumnDimension('G')->setWidth(8);
		$worksheet->getColumnDimension('H')->setWidth(8);
		$worksheet->getColumnDimension('I')->setWidth(8);
		$worksheet->getColumnDimension('G')->setWidth(8);
		$worksheet->getColumnDimension('J')->setWidth(8);
		$worksheet->getColumnDimension('K')->setWidth(8);
		$worksheet->getColumnDimension('L')->setWidth(8);
		$worksheet->getColumnDimension('M')->setWidth(8);
		$worksheet->getColumnDimension('N')->setWidth(8);
		$worksheet->getColumnDimension('O')->setWidth(8);
		$worksheet->getColumnDimension('P')->setWidth(8);
		$worksheet->getColumnDimension('Q')->setWidth(8);
		$worksheet->getColumnDimension('R')->setWidth(8);
		$worksheet->getColumnDimension('S')->setWidth(8);
		$worksheet->getColumnDimension('T')->setWidth(5);
		$worksheet->getColumnDimension('U')->setWidth(5);
		$worksheet->getColumnDimension('V')->setWidth(5);
		$worksheet->getColumnDimension('W')->setWidth(5);
		$worksheet->getColumnDimension('X')->setWidth(5);
		$worksheet->getColumnDimension('Y')->setWidth(5);
		$worksheet->getColumnDimension('Z')->setWidth(5);
		$worksheet->getColumnDimension('AA')->setWidth(5);
		$worksheet->getColumnDimension('AB')->setWidth(5);
		$worksheet->getColumnDimension('AC')->setWidth(5);
		$worksheet->getColumnDimension('AD')->setWidth(5);
		$worksheet->getColumnDimension('AE')->setWidth(5);
		$worksheet->getColumnDimension('AF')->setWidth(5);
		$worksheet->getColumnDimension('AG')->setWidth(5);
		$worksheet->getColumnDimension('AH')->setWidth(5);
		$worksheet->getColumnDimension('AJ')->setWidth(5);
		$worksheet->getColumnDimension('AI')->setWidth(5);


		// $worksheet->getStyle('A1:D1')->applyFromArray($styleThead);
		// $worksheet  ->getStyle('A1:D1')
		// 			->getFill()
		// 			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		// 			->getStartColor()
		// 			->setARGB('337ab7');
		// $worksheet->getStyle('A1:D3')->applyFromArray($styleBorder);
		// $worksheet->getStyle('F6:G6')->applyFromArray($styleThead);
		// $worksheet	->getStyle('F6:G6')
		// 			->getFill()
		// 			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		// 			->getStartColor()
		// 			->setARGB('337ab7');

		// ----------------- STATIC DATA -----------------
		$worksheet->setCellValue('A2', 'CV. Karya Hidup Sentosa');
		$worksheet->setCellValue('A3', 'Yogyakarta');
		$worksheet->setCellValue('A5', 'LAPORAN EVALUASI PRODUKSI PENGECORAN LOGAM');
		$worksheet->setCellValue('A6', 'Bulan: November');
		$worksheet->setCellValue('A7', 'Tgl: 01-11-2017 s/d 14-11-2017');
		$worksheet->setCellValue('A9', 'No.');
		$worksheet->setCellValue('B9', 'Kode Komponen');
		$worksheet->setCellValue('C9', 'Nama Komponen');
		$worksheet->setCellValue('D9', 'Fkt. Pengali');
		$worksheet->setCellValue('E9', 'Berat Komp(Kg)');
		$worksheet->setCellValue('F9', 'Renc. Prod. (Pcs)');
		$worksheet->setCellValue('G9', 'Jmlh Cetak (Pcs)');
		$worksheet->setCellValue('H9', 'Bongkar (Pcs)');
		$worksheet->setCellValue('I9', 'Scrap (Pcs)');
		$worksheet->setCellValue('J9', 'Hasil Baik (Pcs)');
		$worksheet->setCellValue('K9', '% Renc');
		$worksheet->setCellValue('L9', 'Tonage Baik (Kg)');
		$worksheet->setCellValue('M9', 'IP');
		$worksheet->setCellValue('N9', 'Tonage IP (Kg)');
		$worksheet->setCellValue('O9', 'Jumlah Reject (Pcs)');
		$worksheet->setCellValue('P9', 'Tonage Reject (Kg)');
		$worksheet->setCellValue('Q9', '% Reject (Pcs)');
		$worksheet->setCellValue('R9', 'Prediksi Baik (Pcs)');
		$worksheet->setCellValue('S9', '% Renc');
		$worksheet->setCellValue('T10', 'MS');
		$worksheet->setCellValue('U10', 'DF');
		$worksheet->setCellValue('V10', 'KP');
		$worksheet->setCellValue('W10', 'CT');
		$worksheet->setCellValue('X10', 'TS');
		$worksheet->setCellValue('Y10', 'GS');
		$worksheet->setCellValue('Z10', 'CP');
		$worksheet->setCellValue('AA10', 'RT');
		$worksheet->setCellValue('AB10', 'CW');
		$worksheet->setCellValue('AC10', 'TT');
		$worksheet->setCellValue('AD10', 'BC');
		$worksheet->setCellValue('AE10', 'PH');
		$worksheet->setCellValue('AF10', 'KS');
		$worksheet->setCellValue('AG10', 'NK');
		$worksheet->setCellValue('AH10', 'CR');
		$worksheet->setCellValue('AI10', 'RC');
		$worksheet->setCellValue('AJ10', 'LL');


		$worksheet->setCellValue('A6', "Bulan Print : " . date('F'));
		$worksheet->setCellValue('A7', "Tgl : " . $tanggal1 . " s/d " . $tanggal2);

		$worksheet->getStyle('A9:AA9')->getAlignment()->setWrapText(true);
		$worksheet->getStyle('A9:AA9')->applyFromArray($aligncenter);

		// $worksheet->getStyle('A1:D3')->applyFromArray($aligncenter);
		// $worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
		// $worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);
		// ----------------- DYNAMIC DATA -----------------

		$sum_total_jmlh_cetak = 0;
		$sum_total_hasil_baik = 0;
		$sum_total_tonage_baik = 0;
		$sum_total_ip  = 0;
		$sum_total_tonage_ip = 0;
		$sum_total_jumlah_reject = 0;
		$sum_total_tonage_reject = 0;
		$sum_total_prediksi_baik = 0;

		$count_total_jmlh_cetak = 0;
		$count_total_hasil_baik = 0;
		$count_total_tonage_baik = 0;
		$count_total_ip  = 0;
		$count_total_tonage_ip = 0;
		$count_total_jumlah_reject = 0;
		$count_total_tonage_reject = 0;
		$count_total_prediksi_baik = 0;

		$total_sum_rc = 0;
		$total_sum_kp = 0;
		$total_sum_df = 0;
		$total_sum_ct = 0;
		$total_sum_ts = 0;
		$total_sum_cw = 0;
		$total_sum_ph = 0;
		$total_sum_rt = 0;
		$total_sum_gs = 0;
		$total_sum_cp = 0;
		$total_sum_tt = 0;
		$total_sum_bc = 0;
		$total_sum_nk = 0;
		$total_sum_ms = 0;
		$total_sum_cr = 0;
		$total_sum_ll = 0;

		$highestRow = $worksheet->getHighestRow() + 2;
		foreach ($kodekolom as $sc) {
			
			$data['detail'] = $this->M_qualitycontrol->getComponentWhere($sc['component_code'], $tanggal1, $tanggal2);


			$worksheet->setCellValue('B' . $highestRow, 'Tractor : ' . $sc['component_code']);

			$faktor_pengali = 0.98;

			$sum_total_cetak = 0;
			$sum_hasil_baik = 0;
			$sum_tonage_baik = 0;
			$sum_ip = 0;
			$sum_tonage_ip = 0;
			$sum_reject = 0;
			$sum_tonage_reject = 0;
			$sum_persen_reject = 0;

			$persen_hasil_baik = 0;
			$persen_tonage_baik = 0;
			$persen_jum_reject = 0;
			$persen_tonage_reject = 0;

			$prosentase_hasil_baik = 0;
			$prosentase_tonage_baik = 0;
			$prosentase_jumlah_reject = 0;
			$prosentase_tonage_reject = 0;


			$sum_rc = 0;
			$sum_kp = 0;
			$sum_df = 0;
			$sum_ct = 0;
			$sum_ts = 0;
			$sum_cw = 0;
			$sum_ph = 0;
			$sum_rt = 0;
			$sum_gs = 0;
			$sum_cp = 0;
			$sum_tt = 0;
			$sum_bc = 0;
			$sum_nk = 0;
			$sum_ms = 0;
			$sum_cr = 0;
			$sum_ll = 0;



			$prosentase_sum_rc = 0;
			$prosentase_sum_kp = 0;
			$prosentase_sum_df = 0;
			$prosentase_sum_ct = 0;
			$prosentase_sum_ts = 0;
			$prosentase_sum_cw = 0;
			$prosentase_sum_ph = 0;
			$prosentase_sum_rt = 0;
			$prosentase_sum_gs = 0;
			$prosentase_sum_cp = 0;
			$prosentase_sum_tt = 0;
			$prosentase_sum_bc = 0;
			$prosentase_sum_nk = 0;
			$prosentase_sum_ms = 0;
			$prosentase_sum_cr = 0;
			$prosentase_sum_ll = 0;


			$highestRow = $highestRow + 1;
			$no = 1;

			foreach ($data['detail'] as $value) {

			
				$master = $this->M_qualitycontrol->getMasterItem($value['component_code']);
				$beratMaster = $master[0]['berat'];
				
				$bongkar = $this->M_qualitycontrol->getBongkarWhere($value['moulding_id']);
				if ($bongkar != null){
				

				$bongkar_qty = $bongkar[0]['qty'];
				

				$scrap = $this->M_qualitycontrol->getDetail($value['moulding_id']);


				$reject = 0;

				foreach ($scrap as $key) {
					// Kolom AF enggak ada
					if ($key['kode_scrap'] == 'RC') {
						$worksheet->setCellValue('AI' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_rc += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'KP') {
						$worksheet->setCellValue('V' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_kp += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'DF') {
						$worksheet->setCellValue('U' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_df += $key['quantity'];
					}

					if ($key['kode_scrap'] == 'CT') {
						$worksheet->setCellValue('W' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_ct += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'TS') {
						$worksheet->setCellValue('X' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_ts += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'CW') {
						$worksheet->setCellValue('AB' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_cw += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'PH') {
						$worksheet->setCellValue('AE' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_ph += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'RT') {
						$worksheet->setCellValue('AA' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_rt += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'GS') {
						$worksheet->setCellValue('Y' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_gs += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'CP') {
						$worksheet->setCellValue('Z' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_cp += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'TT') {
						$worksheet->setCellValue('AC' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_tt += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'BC') {
						$worksheet->setCellValue('AD' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_bc += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'NK') {
						$worksheet->setCellValue('AG' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_nk += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'MS') {
						$worksheet->setCellValue('T' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_ms += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'CR') {
						$worksheet->setCellValue('AH' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_cr += $key['quantity'];
					}
					if ($key['kode_scrap'] == 'LL') {
						$worksheet->setCellValue('AJ' . $highestRow, $key['quantity']);
						$reject += $key['quantity'];
						$sum_ll += $key['quantity'];
					}
				}
				//rumums scrap dan bongkar
				// here2
				$bongkar_qty = 0;
				$bongkar = $this->M_qualitycontrol->getBongkar($value['moulding_id']);
				foreach ($bongkar as $key) {
					$bongkar_qty += $key['qty'];
				}

				$scrap_qty = 0;
				$scrap = $this->M_qualitycontrol->getScrap($value['moulding_id']);
				foreach ($scrap as $jmlScr) {
					$scrap_qty += $jmlScr['quantity'];
				}
				$hasil_baik = $bongkar_qty - $scrap_qty;

				$jumlah_qty = $value['moulding_quantity'];

				$ip = $jumlah_qty - $bongkar_qty;


				$tonage = $beratMaster * $hasil_baik;
				$tonage_berat = $ip * $tonage;
				$tonage_reject = $reject * $beratMaster;
				$persen_reject = ($reject / $hasil_baik) * 100;
				
				$worksheet->setCellValue('A' . $highestRow, $no);
				$worksheet->setCellValue('B' . $highestRow, $value['component_code']);
				$worksheet->setCellValue('C' . $highestRow, $value['component_description']);
				$worksheet->setCellValue('D' . $highestRow, $faktor_pengali);
				$worksheet->setCellValue('E' . $highestRow, $beratMaster);
				$worksheet->setCellValue('F' . $highestRow, '0');
				$worksheet->setCellValue('G' . $highestRow, $jumlah_qty);
				$worksheet->setCellValue('H' . $highestRow, $bongkar_qty);
				$worksheet->setCellValue('I' . $highestRow, $scrap_qty);
				$worksheet->setCellValue('J' . $highestRow, $hasil_baik);
				$worksheet->setCellValue('K' . $highestRow, '0');
				$worksheet->setCellValue('L' . $highestRow, $tonage);
				$worksheet->setCellValue('M' . $highestRow, $ip);
				$worksheet->setCellValue('N' . $highestRow, $tonage_berat);
				$worksheet->setCellValue('O' . $highestRow, $reject);
				$worksheet->setCellValue('P' . $highestRow, $tonage_reject);
				$worksheet->setCellValue('Q' . $highestRow, number_format((float) $persen_reject, 2, '.', '') . "%");

				$sum_total_cetak += $jumlah_qty;
				$sum_hasil_baik += $hasil_baik;
				$sum_tonage_baik += $tonage;
				$sum_ip += $ip;
				$sum_tonage_ip += $tonage_berat;
				$sum_reject += $reject;
				$sum_tonage_reject += $tonage_reject;
				$sum_persen_reject +=  $persen_reject;

				$persen_tonage_baik += ($jumlah_qty * $beratMaster);
				
				$highestRow++;
				$no++;
				}
			}
			



			$sum_total_jmlh_cetak += $sum_total_cetak;
			$sum_total_hasil_baik += $sum_hasil_baik;
			$sum_total_tonage_baik  += $sum_tonage_baik;
			$sum_total_ip  += $sum_ip;
			$sum_total_tonage_ip += $sum_tonage_ip;
			$sum_total_jumlah_reject += $sum_reject;
			$sum_total_tonage_reject += $sum_tonage_reject;

			$total_sum_rc += $sum_rc;
			$total_sum_kp += $sum_kp;
			$total_sum_df += $sum_df;
			$total_sum_ct += $sum_ct;
			$total_sum_ts += $sum_ts;
			$total_sum_cw += $sum_cw;
			$total_sum_ph += $sum_ph;
			$total_sum_rt += $sum_rt;
			$total_sum_gs += $sum_gs;
			$total_sum_cp += $sum_cp;
			$total_sum_tt += $sum_tt;
			$total_sum_bc += $sum_bc;
			$total_sum_nk += $sum_nk;
			$total_sum_ms += $sum_ms;
			$total_sum_cr += $sum_cr;
			$total_sum_ll += $sum_ll;


			//2
			$worksheet->setCellValue('B' . $highestRow, "Sub Total QTY");
			$worksheet->setCellValue('G' . $highestRow, $sum_total_cetak);
			$worksheet->setCellValue('J' . $highestRow, $sum_hasil_baik);
			$worksheet->setCellValue('L' . $highestRow, $sum_tonage_baik);
			$worksheet->setCellValue('M' . $highestRow, $sum_ip);
			$worksheet->setCellValue('N' . $highestRow, $sum_tonage_ip);
			$worksheet->setCellValue('O' . $highestRow, $sum_reject);
			$worksheet->setCellValue('P' . $highestRow, $sum_tonage_reject);
			$worksheet->setCellValue('Q' . $highestRow, number_format((float) $sum_persen_reject, 2, '.', '') . "%");
			// echo "<br>";
			// echo "<br>";
			// echo "sum cetak = ";
			// print($sum_total_cetak);
			// echo "<br>";
			// echo "sum hasil baik = ";
			// print($sum_hasil_baik);
			// echo "<br>";
			// echo "sum ip = ";
			// print($sum_ip);
			$worksheet->setCellValue('AI' . $highestRow, $sum_rc);
			$worksheet->setCellValue('V' . $highestRow, $sum_kp);
			$worksheet->setCellValue('U' . $highestRow, $sum_df);
			$worksheet->setCellValue('W' . $highestRow, $sum_ct);
			$worksheet->setCellValue('X' . $highestRow, $sum_ts);
			$worksheet->setCellValue('AB' . $highestRow, $sum_cw);
			$worksheet->setCellValue('AE' . $highestRow, $sum_ph);
			$worksheet->setCellValue('AA' . $highestRow, $sum_rt);
			$worksheet->setCellValue('Y' . $highestRow, $sum_gs);
			$worksheet->setCellValue('Z' . $highestRow, $sum_cp);
			$worksheet->setCellValue('AC' . $highestRow, $sum_tt);
			$worksheet->setCellValue('AD' . $highestRow, $sum_bc);
			$worksheet->setCellValue('AG' . $highestRow, $sum_nk);
			$worksheet->setCellValue('T' . $highestRow, $sum_ms);
			$worksheet->setCellValue('AH' . $highestRow, $sum_cr);
			$worksheet->setCellValue('AJ' . $highestRow, $sum_ll);

			$highestRow++;
			$worksheet->setCellValue('B' . $highestRow, "Prosentase (%)");
			if ($sum_hasil_baik != 0) {
				$persen_hasil_baik = ($sum_hasil_baik / ($sum_hasil_baik + $sum_reject)) * 100;
				$persen_tonage_baik = ($sum_tonage_baik / $persen_tonage_baik) * 100;
				$persen_jum_reject = 100 - $persen_hasil_baik;
				$persen_tonage_reject = 100 - $persen_tonage_baik;
			}
			$worksheet->setCellValue('J' . $highestRow, number_format((float) $persen_hasil_baik, 2, '.', '') . "%");
			$worksheet->setCellValue('L' . $highestRow, number_format((float) $persen_tonage_baik, 2, '.', '') . "%"); // GA MUNCUL
			$worksheet->setCellValue('O' . $highestRow, number_format((float) $persen_jum_reject, 2, '.', '') . "%");
			$worksheet->setCellValue('P' . $highestRow, number_format((float) $persen_tonage_reject, 2, '.', '') . "%");

			$highestRow += 2;
			$worksheet->setCellValue('B' . $highestRow, "Sub Total Berat");

			$highestRow++;
			$worksheet->setCellValue('B' . $highestRow, "Prosentase (% Berat)");

			$highestRow += 2;
		} 

		//3
		$worksheet->setCellValue('B' . $highestRow, "Total Produksi");
		$worksheet->setCellValue('G' . $highestRow, $sum_total_jmlh_cetak);
		$worksheet->setCellValue('J' . $highestRow, $sum_total_hasil_baik);
		$worksheet->setCellValue('L' . $highestRow, $sum_total_tonage_baik);
		$worksheet->setCellValue('M' . $highestRow, $sum_total_ip);
		$worksheet->setCellValue('N' . $highestRow, $sum_total_tonage_ip);
		$worksheet->setCellValue('O' . $highestRow, $sum_total_jumlah_reject);
		$worksheet->setCellValue('P' . $highestRow, $sum_total_tonage_reject);

		$worksheet->setCellValue('AI' . $highestRow, $total_sum_rc);
		$worksheet->setCellValue('V' . $highestRow, $total_sum_kp);
		$worksheet->setCellValue('U' . $highestRow, $total_sum_df);
		$worksheet->setCellValue('W' . $highestRow, $total_sum_ct);
		$worksheet->setCellValue('X' . $highestRow, $total_sum_ts);
		$worksheet->setCellValue('AB' . $highestRow, $total_sum_cw);
		$worksheet->setCellValue('AE' . $highestRow, $total_sum_ph);
		$worksheet->setCellValue('AA' . $highestRow, $total_sum_rt);
		$worksheet->setCellValue('Y' . $highestRow, $total_sum_gs);
		$worksheet->setCellValue('Z' . $highestRow, $total_sum_cp);
		$worksheet->setCellValue('AC' . $highestRow, $total_sum_tt);
		$worksheet->setCellValue('AD' . $highestRow, $total_sum_bc);
		$worksheet->setCellValue('AG' . $highestRow, $total_sum_nk);
		$worksheet->setCellValue('T' . $highestRow, $total_sum_ms);
		$worksheet->setCellValue('AH' . $highestRow, $total_sum_cr);
		$worksheet->setCellValue('AJ' . $highestRow, $total_sum_ll);
		// echo "<br>";
		// echo "<br>";
		// echo "sum total jml cetak = ";
		// print($sum_total_jmlh_cetak);
		// echo "<br>";
		// echo "sum total hasil baik = ";
		// print($sum_total_hasil_baik);
		// echo "<br>";
		// echo "sum total ip = ";
		// print($sum_total_ip);

		$highestRow++;

		$prosentase_hasil_baik = $sum_total_hasil_baik / ($sum_total_jmlh_cetak - $sum_total_ip) * 100;
		$prosentase_tonage_baik = $sum_total_tonage_baik / ($sum_total_tonage_baik + $sum_total_tonage_reject) * 100;
		$prosentase_jumlah_reject = $sum_total_jumlah_reject / ($sum_total_jmlh_cetak - $sum_total_ip) * 100;
		$prosentase_tonage_reject = $sum_total_tonage_reject / ($sum_total_tonage_baik + $sum_total_tonage_reject) * 100;

		$worksheet->setCellValue('B' . $highestRow, "Prosentase");
		$worksheet->setCellValue('H' . $highestRow, $prosentase_hasil_baik);
		$worksheet->setCellValue('J' . $highestRow, $prosentase_tonage_baik);
		$worksheet->setCellValue('M' . $highestRow, $prosentase_jumlah_reject);
		$worksheet->setCellValue('N' . $highestRow, $prosentase_tonage_reject);

		$prosentase_sum_rc = $total_sum_rc / $sum_total_jumlah_reject * 100;
		$prosentase_sum_kp = $total_sum_kp / $sum_total_jumlah_reject * 100;
		$prosentase_sum_df = $total_sum_df / $sum_total_jumlah_reject * 100;
		$prosentase_sum_ct = $total_sum_ct / $sum_total_jumlah_reject * 100;
		$prosentase_sum_ts = $total_sum_ts / $sum_total_jumlah_reject * 100;
		$prosentase_sum_cw = $total_sum_cw / $sum_total_jumlah_reject * 100;
		$prosentase_sum_ph = $total_sum_ph / $sum_total_jumlah_reject * 100;
		$prosentase_sum_rt = $total_sum_rt / $sum_total_jumlah_reject * 100;
		$prosentase_sum_gs = $total_sum_gs / $sum_total_jumlah_reject * 100;
		$prosentase_sum_cp = $total_sum_cp / $sum_total_jumlah_reject * 100;
		$prosentase_sum_tt = $total_sum_tt / $sum_total_jumlah_reject * 100;
		$prosentase_sum_bc = $total_sum_bc / $sum_total_jumlah_reject * 100;
		$prosentase_sum_nk = $total_sum_nk / $sum_total_jumlah_reject * 100;
		$prosentase_sum_ms = $total_sum_ms / $sum_total_jumlah_reject * 100;
		$prosentase_sum_cr = $total_sum_cr / $sum_total_jumlah_reject * 100;
		$prosentase_sum_ll = $total_sum_ll / $sum_total_jumlah_reject * 100;
		//4
		$worksheet->setCellValue('AI' . $highestRow, $prosentase_sum_rc);
		$worksheet->setCellValue('V' . $highestRow, $prosentase_sum_kp);
		$worksheet->setCellValue('U' . $highestRow, $prosentase_sum_df);
		$worksheet->setCellValue('W' . $highestRow, $prosentase_sum_ct);
		$worksheet->setCellValue('X' . $highestRow, $prosentase_sum_ts);
		$worksheet->setCellValue('AB' . $highestRow, $prosentase_sum_cw);
		$worksheet->setCellValue('AE' . $highestRow, $prosentase_sum_ph);
		$worksheet->setCellValue('AA' . $highestRow, $prosentase_sum_rt);
		$worksheet->setCellValue('Y' . $highestRow, $prosentase_sum_gs);
		$worksheet->setCellValue('Z' . $highestRow, $prosentase_sum_cp);
		$worksheet->setCellValue('AC' . $highestRow, $prosentase_sum_tt);
		$worksheet->setCellValue('AD' . $highestRow, $prosentase_sum_bc);
		$worksheet->setCellValue('AG' . $highestRow, $prosentase_sum_nk);
		$worksheet->setCellValue('T' . $highestRow, $prosentase_sum_ms);
		$worksheet->setCellValue('AH' . $highestRow, $prosentase_sum_cr);
		$worksheet->setCellValue('AJ' . $highestRow, $prosentase_sum_ll);

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Evaluasi_Produksi_' . time() . '.xls"');
		$objWriter->save("php://output");
	}

	public function createLaporan3()
	{
		echo 'Tunggu sebentar pak, masih dalam tahap perbaikan dan pengembangan<br><br>Edwin - ICT';exit;
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_qualitycontrol->getComponentThis($tanggal1, $tanggal2); //hapus

		$vMould = $this->M_qualitycontrol->vMoulding($tanggal1, $tanggal2);
		$vMixing = $this->M_qualitycontrol->vMixing($tanggal1, $tanggal2);
		$vCore = $this->M_qualitycontrol->vCore($tanggal1, $tanggal2);
		$vOTT = $this->M_qualitycontrol->vOTT($tanggal1, $tanggal2);
		
		$jadi = array();
		$o = 0;
		foreach ($vMould as $vol) {
			$kodeProses = $this->M_qualitycontrol->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Moulding';
			$jadi[$o]['id'] = $vol['moulding_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = $kodeProses[0]['kode_proses'];
			$jadi[$o]['HasilCor'] = $vol['moulding_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['bongkar_qty'] - $vol['scrap_qty'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = (empty($vol['scrap_qty']) ? '0' : $vol['scrap_qty']);
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
	
		foreach ($vMixing as $vol) {
			$kodeProses = $this->M_qualitycontrol->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Mixing';
			$jadi[$o]['id'] = $vol['mixing_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = $kodeProses[0]['kode_proses'];
			$jadi[$o]['HasilCor'] = $vol['mixing_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['mixing_quantity'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
		
		foreach ($vCore as $vol) {
			$kodeProses = $this->M_qualitycontrol->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Core';
			$jadi[$o]['id'] = $vol['core_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = $kodeProses[0]['kode_proses'];
			$jadi[$o]['HasilCor'] = $vol['core_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['core_quantity'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}

		foreach ($vOTT as $vol) {
			$jadi[$o]['jenis'] = 'OTT';
			$jadi[$o]['id'] = $vol['id'];
			$jadi[$o]['Tanggal'] = $vol['otttgl'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['kode_cor'];
			$jadi[$o]['KodeKomponen'] = 'OTT';
			$jadi[$o]['KodeProses'] = '';
			$jadi[$o]['HasilCor'] = '';
			$jadi[$o]['HasilBaik'] = '';
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
	
		array_multisort(array_column($jadi, 'Tanggal'), SORT_ASC,
						array_column($jadi, 'KodeKelompok'),     SORT_ASC ,
						$jadi);

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleThead = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$styleNotice = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'ff0000'),
			)
		);
		$styleBorder = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$aligncenter = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);

		$worksheet->getColumnDimension('A')->setWidth(10);
		$worksheet->getColumnDimension('B')->setWidth(10);
		$worksheet->getColumnDimension('C')->setWidth(10);
		$worksheet->getColumnDimension('D')->setWidth(10);
		$worksheet->getColumnDimension('E')->setWidth(10);
		$worksheet->getColumnDimension('F')->setWidth(10);
		$worksheet->getColumnDimension('G')->setWidth(5);
		$worksheet->getColumnDimension('H')->setWidth(5);
		$worksheet->getColumnDimension('I')->setWidth(5);
		$worksheet->getColumnDimension('G')->setWidth(5);
		$worksheet->getColumnDimension('J')->setWidth(5);
		$worksheet->getColumnDimension('K')->setWidth(5);
		$worksheet->getColumnDimension('L')->setWidth(5);
		$worksheet->getColumnDimension('M')->setWidth(5);
		$worksheet->getColumnDimension('N')->setWidth(5);
		$worksheet->getColumnDimension('O')->setWidth(5);
		$worksheet->getColumnDimension('P')->setWidth(5);
		$worksheet->getColumnDimension('Q')->setWidth(5);
		$worksheet->getColumnDimension('R')->setWidth(5);
		$worksheet->getColumnDimension('S')->setWidth(5);
		$worksheet->getColumnDimension('T')->setWidth(5);
		$worksheet->getColumnDimension('U')->setWidth(5);
		$worksheet->getColumnDimension('V')->setWidth(5);
		$worksheet->getColumnDimension('W')->setWidth(5);
		$worksheet->getColumnDimension('X')->setWidth(5);
		$worksheet->getColumnDimension('Y')->setWidth(5);
		$worksheet->getColumnDimension('Z')->setWidth(5);
		$worksheet->getColumnDimension('AA')->setWidth(5);
		$worksheet->getColumnDimension('AB')->setWidth(5);
		$worksheet->getColumnDimension('AC')->setWidth(10);
		$worksheet->getColumnDimension('AD')->setWidth(10);
		$worksheet->getColumnDimension('AE')->setWidth(10);
		$worksheet->getColumnDimension('AF')->setWidth(5);
		$worksheet->getColumnDimension('AG')->setWidth(5);
		$worksheet->getColumnDimension('AH')->setWidth(5);
		$worksheet->getColumnDimension('AI')->setWidth(5);
		$worksheet->getColumnDimension('AJ')->setWidth(5);
		$worksheet->getColumnDimension('AK')->setWidth(5);
		$worksheet->getColumnDimension('AL')->setWidth(5);
		$worksheet->getColumnDimension('AM')->setWidth(5);
		$worksheet->getColumnDimension('AN')->setWidth(5);
		$worksheet->getColumnDimension('AO')->setWidth(5);
		$worksheet->getColumnDimension('AP')->setWidth(5);
		$worksheet->getColumnDimension('AQ')->setWidth(5);
		$worksheet->getColumnDimension('AR')->setWidth(5);
		$worksheet->getColumnDimension('AS')->setWidth(5);
		$worksheet->getColumnDimension('AT')->setWidth(5);
		$worksheet->getColumnDimension('AU')->setWidth(5);
		$worksheet->getColumnDimension('AV')->setWidth(5);
		$worksheet->getColumnDimension('AW')->setWidth(5);
		$worksheet->getColumnDimension('AX')->setWidth(5);
		$worksheet->getColumnDimension('AY')->setWidth(5);
		$worksheet->getColumnDimension('AZ')->setWidth(5);

		$worksheet->setCellValue('A3', 'TANGGAL');
		$worksheet->setCellValue('B3', 'KODE KELOMPOK');
		$worksheet->setCellValue('C3', 'KODE COR');
		$worksheet->setCellValue('D3', 'KODE KOMPONEN');
		$worksheet->setCellValue('F3', 'KODE PROSES');
		$worksheet->setCellValue('E3', 'HASIL COR');
		$worksheet->setCellValue('G3', 'RC');
		$worksheet->setCellValue('H3', 'DF');
		$worksheet->setCellValue('I3', 'CR');
		$worksheet->setCellValue('J3', 'TK');
		$worksheet->setCellValue('K3', 'PR');
		$worksheet->setCellValue('L3', 'KP');
		$worksheet->setCellValue('M3', 'CT');
		$worksheet->setCellValue('N3', 'TS');
		$worksheet->setCellValue('O3', 'CO');
		$worksheet->setCellValue('P3', 'CW');
		$worksheet->setCellValue('Q3', 'SC');
		$worksheet->setCellValue('R3', 'PH');
		$worksheet->setCellValue('S3', 'SG');
		$worksheet->setCellValue('T3', 'GS');
		$worksheet->setCellValue('U3', 'CP');
		$worksheet->setCellValue('V3', 'TT');
		$worksheet->setCellValue('W3', 'BC');
		$worksheet->setCellValue('X3', 'KS');
		$worksheet->setCellValue('Y3', 'NK');
		$worksheet->setCellValue('Z3', 'MS');
		$worksheet->setCellValue('AA3', 'RT');
		$worksheet->setCellValue('AB3', 'PK');
		$worksheet->setCellValue('AC3', 'REJECT UP2L');
		$worksheet->setCellValue('AD3', 'IP UP2L');
		$worksheet->setCellValue('AE3', 'HASIL BAIK UP2L');
		$worksheet->setCellValue('AF3', 'RC');
		$worksheet->setCellValue('AG3', 'DF');
		$worksheet->setCellValue('AH3', 'CR');
		$worksheet->setCellValue('AI3', 'TK');
		$worksheet->setCellValue('AJ3', 'PR');
		$worksheet->setCellValue('AK3', 'KP');
		$worksheet->setCellValue('AL3', 'CT');
		$worksheet->setCellValue('AM3', 'TS');
		$worksheet->setCellValue('AN3', 'CO');
		$worksheet->setCellValue('AO3', 'CW');
		$worksheet->setCellValue('AP3', 'SC');
		$worksheet->setCellValue('AQ3', 'PH');
		$worksheet->setCellValue('AR3', 'SG');
		$worksheet->setCellValue('AS3', 'GS');
		$worksheet->setCellValue('AT3', 'CP');
		$worksheet->setCellValue('AU3', 'TT');
		$worksheet->setCellValue('AV3', 'BC');
		$worksheet->setCellValue('AW3', 'KS');
		$worksheet->setCellValue('AX3', 'NK');
		$worksheet->setCellValue('AY3', 'MS');
		$worksheet->setCellValue('AZ3', 'RT');
		$worksheet->setCellValue('BA3', 'PK');
		$worksheet->setCellValue('BB3', 'REJECT QC');
		$worksheet->setCellValue('BC3', 'HASIL BAIK AKHIR');
		$worksheet->setCellValue('BD3', 'REJECT');
		$worksheet->setCellValue('BD3', 'KETERANGAN');

		$highestRow = $worksheet->getHighestRow() + 1;
		foreach ($section as $sc) {

			$worksheet->setCellValue('A' . $highestRow, $sc['production_date']);
			$worksheet->setCellValue('B' . $highestRow, ''); //Kode Kelompok
			$worksheet->setCellValue('C' . $highestRow, $sc['print_code']);
			$worksheet->setCellValue('D' . $highestRow, $sc['component_code']);
			$worksheet->setCellValue('E' . $highestRow, $sc['moulding_quantity']);


			$scrap = $this->M_qualitycontrol->getDetail($sc['moulding_id']);
			$reject = 0;
			$quantity = $sc['moulding_quantity'];

			$berat = $this->M_qualitycontrol->getMasterItem($sc['component_code']);


			$worksheet->setCellValue('F' . $highestRow, $berat[0]['kode_proses']);


			$reject_qc = $this->M_qualitycontrol->getQtyRejectQC($sc['print_code']);


			$worksheet->setCellValue('G' . $highestRow, 0);
			$worksheet->setCellValue('H' . $highestRow, 0);
			$worksheet->setCellValue('I' . $highestRow, 0);
			$worksheet->setCellValue('J' . $highestRow, 0);
			$worksheet->setCellValue('K' . $highestRow, 0);
			$worksheet->setCellValue('L' . $highestRow, 0);
			$worksheet->setCellValue('M' . $highestRow, 0);
			$worksheet->setCellValue('N' . $highestRow, 0);
			$worksheet->setCellValue('O' . $highestRow, 0);
			$worksheet->setCellValue('P' . $highestRow, 0);
			$worksheet->setCellValue('Q' . $highestRow, 0);
			$worksheet->setCellValue('R' . $highestRow, 0);
			$worksheet->setCellValue('S' . $highestRow, 0);
			$worksheet->setCellValue('T' . $highestRow, 0);
			$worksheet->setCellValue('U' . $highestRow, 0);
			$worksheet->setCellValue('V' . $highestRow, 0);
			$worksheet->setCellValue('W' . $highestRow, 0);
			$worksheet->setCellValue('X' . $highestRow, 0);
			$worksheet->setCellValue('Y' . $highestRow, 0);
			$worksheet->setCellValue('Z' . $highestRow, 0);
			$worksheet->setCellValue('AA' . $highestRow, 0);
			$worksheet->setCellValue('AB' . $highestRow, 0);

			foreach ($scrap as $key) {

				if ($key['kode_scrap'] == 'RC') {
					$worksheet->setCellValue('G' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'DF') {
					$worksheet->setCellValue('H' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'CR') {
					$worksheet->setCellValue('I' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'TK') {
					$worksheet->setCellValue('J' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'PR') {
					$worksheet->setCellValue('K' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'KP') {
					$worksheet->setCellValue('L' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'CT') {
					$worksheet->setCellValue('M' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'TS') {
					$worksheet->setCellValue('N' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'CO') {
					$worksheet->setCellValue('O' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}


				if ($key['kode_scrap'] == 'CW') {
					$worksheet->setCellValue('P' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}


				if ($key['kode_scrap'] == 'SC') {
					$worksheet->setCellValue('Q' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'PH') {
					$worksheet->setCellValue('R' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'SG') {
					$worksheet->setCellValue('S' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'GS') {
					$worksheet->setCellValue('T' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'CP') {
					$worksheet->setCellValue('U' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'TT') {
					$worksheet->setCellValue('V' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}
				if ($key['kode_scrap'] == 'BC') {
					$worksheet->setCellValue('W' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'KS') {
					$worksheet->setCellValue('X' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'NK') {
					$worksheet->setCellValue('Y' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'MS') {
					$worksheet->setCellValue('Z' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'RT') {
					$worksheet->setCellValue('AA' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}

				if ($key['kode_scrap'] == 'PK') {
					$worksheet->setCellValue('AB' . $highestRow, $key['quantity']);
					$reject += $key['quantity'];
				}
			}
			$bongkar_qty = 0;
			$bongkar = $this->M_qualitycontrol->getBongkar($sc['moulding_id']);
			foreach ($bongkar as $key) {
				$bongkar_qty += $key['qty'];
			}
			$scrap_qty = 0;
			$scrap = $this->M_qualitycontrol->getScrap($sc['moulding_id']);
			foreach ($scrap as $jmlScr) {
				$scrap_qty += $jmlScr['quantity'];
			}
			$hasil_baik_2 = $bongkar_qty - $scrap_qty;

			$hasil_baik = $quantity - $reject;
			// foreach ($berat as $beratKodeProses) {
			$ip = $hasil_baik * $berat[0]['berat'];
			// }
			$reject_qc_2 = 0;
			if ($reject_qc[0]['scrap_quantity'] > 0) {
				$reject_qc_2 = $reject_qc[0]['scrap_quantity'];
			}

			// $hasil_baik_2 = $hasil_baik - $reject_qc_2;

			$total_reject = $reject + $reject_qc_2;

			$worksheet->setCellValue('AC' . $highestRow, $reject);
			$worksheet->setCellValue('AD' . $highestRow, $ip);
			$worksheet->setCellValue('AE' . $highestRow, $hasil_baik_2);
			$worksheet->setCellValue('BA' . $highestRow, $reject_qc_2);
			$worksheet->setCellValue('BB' . $highestRow, $hasil_baik_2);
			$worksheet->setCellValue('BC' . $highestRow, $total_reject);
			$worksheet->setCellValue('BD' . $highestRow, $sc['keterangan']);
			$highestRow++;
		}

		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DET_TRAN_' . time() . '.xls"');
		$objWriter->save("php://output");
	}

	public function createLaporan4()
	{
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$vMould = $this->M_qualitycontrol->vMoulding($tanggal1, $tanggal2);
		$vMixing = $this->M_qualitycontrol->vMixing($tanggal1, $tanggal2);
		$vCore = $this->M_qualitycontrol->vCore($tanggal1, $tanggal2);
		$vOTT = $this->M_qualitycontrol->vOTT($tanggal1, $tanggal2);
		
		$jadi = array();
		$o = 0;
		foreach ($vMould as $vol) {
			$kodeProses = $this->M_qualitycontrol->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Moulding';
			$jadi[$o]['id'] = $vol['moulding_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = $kodeProses[0]['kode_proses'];
			$jadi[$o]['HasilCor'] = $vol['moulding_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['bongkar_qty'] - $vol['scrap_qty'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = (empty($vol['scrap_qty']) ? '0' : $vol['scrap_qty']);
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
	
		foreach ($vMixing as $vol) {
			$kodeProses = $this->M_qualitycontrol->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Mixing';
			$jadi[$o]['id'] = $vol['mixing_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = $kodeProses[0]['kode_proses'];
			$jadi[$o]['HasilCor'] = $vol['mixing_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['mixing_quantity'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
		
		foreach ($vCore as $vol) {
			$kodeProses = $this->M_qualitycontrol->getMasterItem($vol['component_code']);
			$jadi[$o]['jenis'] = 'Core';
			$jadi[$o]['id'] = $vol['core_id'];
			$jadi[$o]['Tanggal'] = $vol['production_date'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['print_code'];
			$jadi[$o]['KodeKomponen'] = $vol['component_code'];
			$jadi[$o]['KodeProses'] = $kodeProses[0]['kode_proses'];
			$jadi[$o]['HasilCor'] = $vol['core_quantity'];
			$jadi[$o]['HasilBaik'] = $vol['core_quantity'];
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}

		foreach ($vOTT as $vol) {
			$jadi[$o]['jenis'] = 'OTT';
			$jadi[$o]['id'] = $vol['id'];
			$jadi[$o]['Tanggal'] = $vol['otttgl'];
			$jadi[$o]['KodeKelompok'] = $vol['kode'];
			$jadi[$o]['KodeCor'] = $vol['kode_cor'];
			$jadi[$o]['KodeKomponen'] = 'OTT';
			$jadi[$o]['KodeProses'] = '';
			$jadi[$o]['HasilCor'] = '';
			$jadi[$o]['HasilBaik'] = '';
			$jadi[$o]['Rmurnic'] = 0;
			$jadi[$o]['Rbebdc'] = 0;
			$jadi[$o]['Rintc'] = 0;
			$jadi[$o]['Rmurnit'] = 0;
			$jadi[$o]['Rbebdt'] = 0;
			$jadi[$o]['Rintt'] = 0;
			$jadi[$o]['Rmurnif'] = 0;
			$jadi[$o]['Rbebdf'] = 0;
			$jadi[$o]['Rintf'] = 0;
			$jadi[$o]['Rejc25'] = 0;
			$jadi[$o]['Rejt25'] = 0;
			$o++;
		}
	
		array_multisort(array_column($jadi, 'Tanggal'), SORT_ASC,
						array_column($jadi, 'KodeKelompok'),     SORT_ASC ,
						$jadi);
		

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleThead = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				)
			)
		);
		$bold = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
			),
		);

		$worksheet->getColumnDimension('A')->setWidth(15);
		$worksheet->getColumnDimension('B')->setWidth(17);
		$worksheet->getColumnDimension('C')->setWidth(12);
		$worksheet->getColumnDimension('D')->setWidth(18);
		$worksheet->getColumnDimension('E')->setWidth(15);
		$worksheet->getColumnDimension('F')->setWidth(12);
		$worksheet->getColumnDimension('G')->setWidth(12);
		$worksheet->getColumnDimension('H')->setWidth(12);
		$worksheet->getColumnDimension('I')->setWidth(12);
		$worksheet->getColumnDimension('G')->setWidth(12);
		$worksheet->getColumnDimension('J')->setWidth(12);
		$worksheet->getColumnDimension('K')->setWidth(12);
		$worksheet->getColumnDimension('L')->setWidth(12);
		$worksheet->getColumnDimension('M')->setWidth(12);
		$worksheet->getColumnDimension('N')->setWidth(12);
		$worksheet->getColumnDimension('O')->setWidth(12);
		$worksheet->getColumnDimension('P')->setWidth(12);
		$worksheet->getColumnDimension('Q')->setWidth(12);
		$worksheet->getColumnDimension('R')->setWidth(12);
		$worksheet->getColumnDimension('S')->setWidth(12);
		$worksheet->getColumnDimension('T')->setWidth(12);
		$worksheet->getColumnDimension('U')->setWidth(12);
		$worksheet->getColumnDimension('V')->setWidth(12);
		$worksheet->getColumnDimension('W')->setWidth(12);
		$worksheet->getColumnDimension('X')->setWidth(12);
		$worksheet->getColumnDimension('Y')->setWidth(12);

		$worksheet->setCellValue('A4', 'TANGGAL')->getStyle('A4')->applyFromArray($styleThead);
		$worksheet->setCellValue('B4', 'KODE KELOMPOK')->getStyle('B4')->applyFromArray($styleThead);
		$worksheet->setCellValue('C4', 'KODE COR')->getStyle('C4')->applyFromArray($styleThead);
		$worksheet->setCellValue('D4', 'KODE KOMPONEN')->getStyle('D4')->applyFromArray($styleThead);
		$worksheet->setCellValue('E4', 'KODE PROSES')->getStyle('E4')->applyFromArray($styleThead);
		$worksheet->setCellValue('F4', 'HASIL COR')->getStyle('F4')->applyFromArray($styleThead);
		$worksheet->setCellValue('G4', 'HASIL BAIK')->getStyle('G4')->applyFromArray($styleThead);
		$worksheet->setCellValue('H4', 'RMURNI')->getStyle('H4')->applyFromArray($styleThead);
		$worksheet->setCellValue('I4', 'RBEBDC')->getStyle('I4')->applyFromArray($styleThead);
		$worksheet->setCellValue('J4', 'RINTC')->getStyle('J4')->applyFromArray($styleThead);
		$worksheet->setCellValue('K4', 'RMURNIT')->getStyle('K4')->applyFromArray($styleThead);
		$worksheet->setCellValue('L4', 'RBEBDT')->getStyle('L4')->applyFromArray($styleThead);
		$worksheet->setCellValue('M4', 'RINTT')->getStyle('M4')->applyFromArray($styleThead);
		$worksheet->setCellValue('N4', 'RMURNIF')->getStyle('N4')->applyFromArray($styleThead);
		$worksheet->setCellValue('O4', 'RBEBDF')->getStyle('O4')->applyFromArray($styleThead);
		$worksheet->setCellValue('P4', 'RINTF')->getStyle('P4')->applyFromArray($styleThead);
		$worksheet->setCellValue('Q4', 'REJC25')->getStyle('Q4')->applyFromArray($styleThead);
		$worksheet->setCellValue('R4', 'REJT25')->getStyle('R4')->applyFromArray($styleThead);

		$worksheet->setCellValue('A1', 'Laporan BPKEAKT')->getStyle('A1')->applyFromArray($bold);
		$worksheet->setCellValue('A2', date("d-m-Y", strtotime($tanggal1)) . ' s/d ' . date("d-m-Y", strtotime($tanggal2)))->getStyle('A2')->applyFromArray($bold);

		foreach (range('A', 'R') as $alpha) {
			$worksheet->mergeCells($alpha . '4:' . $alpha . '5')->getStyle($alpha . '5:' . $alpha . '5')->applyFromArray($style);
		}
		$highestRow = $worksheet->getHighestRow() + 1;

		foreach ($jadi as $akhir) {
			$worksheet->setCellValue('A' . $highestRow, $akhir['Tanggal']);
			$worksheet->setCellValue('B' . $highestRow, $akhir['KodeKelompok']);
			$worksheet->setCellValue('C' . $highestRow, $akhir['KodeCor']);
			$worksheet->setCellValue('D' . $highestRow, $akhir['KodeKomponen']);
			$worksheet->setCellValue('E' . $highestRow, $akhir['KodeProses']); 
			$worksheet->setCellValue('F' . $highestRow, $akhir['HasilCor']); 
			$worksheet->setCellValue('G' . $highestRow, $akhir['HasilBaik']); 
			$worksheet->setCellValue('H' . $highestRow, $akhir['Rmurnic']);
			$worksheet->setCellValue('I' . $highestRow, $akhir['Rbebdc']);
			$worksheet->setCellValue('J' . $highestRow, $akhir['Rintc']);
			$worksheet->setCellValue('K' . $highestRow, $akhir['Rmurnit']);
			$worksheet->setCellValue('L' . $highestRow, $akhir['Rbebdt']);
			$worksheet->setCellValue('M' . $highestRow, $akhir['Rintt']);
			$worksheet->setCellValue('N' . $highestRow, $akhir['Rmurnif']);
			$worksheet->setCellValue('O' . $highestRow, $akhir['Rbebdf']);
			$worksheet->setCellValue('P' . $highestRow, $akhir['Rintf']);
			$worksheet->setCellValue('Q' . $highestRow, $akhir['Rejc25']);
			$worksheet->setCellValue('R' . $highestRow, $akhir['Rejt25']);

			foreach (range('A', 'R') as $alpha) {
				$worksheet->getStyle($alpha . $highestRow . ':' . $alpha . $highestRow)->applyFromArray($style);
			}
			$highestRow++;
		}

		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="BPKEAKT_' . time() . '.xls"');
		$objWriter->save("php://output");
	}

	public function createLaporan5()
	{
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_qualitycontrol->getAbsensi($tanggal1, $tanggal2);

		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleThead = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000'),
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
		$aligncenter = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);

		$worksheet->getColumnDimension('A')->setWidth(15);
		$worksheet->getColumnDimension('B')->setWidth(10);
		$worksheet->getColumnDimension('C')->setWidth(20);
		$worksheet->getColumnDimension('D')->setWidth(15);
		$worksheet->getColumnDimension('E')->setWidth(10);
		$worksheet->getColumnDimension('F')->setWidth(10);
		$worksheet->getRowDimension(4)->setRowHeight(20);
		$worksheet->getStyle('A4:I4')->applyFromArray($aligncenter)->applyFromArray($styleThead);
		$worksheet->setCellValue('A1', 'LAPORAN IND_TRAN');
		$worksheet->setCellValue('A4', 'TANGGAL');
		$worksheet->setCellValue('B4', 'NO_INDUK');
		$worksheet->setCellValue('C4', 'KODE KELOMPOK');
		$worksheet->setCellValue('D4', 'KODE COR');
		$worksheet->setCellValue('E4', 'PRESENSI');
		$worksheet->setCellValue('F4', 'PRODUKSI');
		$worksheet->setCellValue('G4', 'NIL_OTT');
		$worksheet->setCellValue('H4', 'WH');
		$worksheet->setCellValue('I4', 'LEMBUR');
		$worksheet->setCellValue('A2', $tanggal1.' - '.$tanggal2);

		$highestRow = $worksheet->getHighestRow() + 1;
		foreach ($section as $sc) {
			$worksheet->getStyle('A'.$highestRow.':I'.$highestRow)->applyFromArray($styleBorder);
			$worksheet->setCellValue('A' . $highestRow, $sc['created_date']);
			$worksheet->setCellValue('B' . $highestRow, $sc['no_induk']);
			$worksheet->setCellValue('C' . $highestRow, $sc['kode']);
			$worksheet->setCellValue('D' . $highestRow, "");
			$worksheet->setCellValue('E' . $highestRow, $sc['presensi']);
			$worksheet->setCellValue('F' . $highestRow, $sc['produksi']);
			$worksheet->setCellValue('G' . $highestRow, $sc['nilai_ott']);
			$worksheet->setCellValue('H' . $highestRow, '');//WH
			$worksheet->setCellValue('I' . $highestRow, $sc['lembur']);
			$highestRow++;
		}

		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="IND_TRAN_' . time() . '.xls"');
		$objWriter->save("php://output");
	}
}
