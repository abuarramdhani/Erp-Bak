<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_qualitycontrol');
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
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

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);



		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtCheckingDateHeader', 'CheckingDate', 'required');
		$this->form_validation->set_rules('txtPrintCodeHeader', 'PrintCode', 'required');
		$this->form_validation->set_rules('txtCheckingQuantityHeader', 'CheckingQuantity', 'required');
		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperationUP2L/QualityControl/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'checking_date' => $this->input->post('txtCheckingDateHeader'),
				'print_code' => $this->input->post('txtPrintCodeHeader'),
				'checking_quantity' => $this->input->post('txtCheckingQuantityHeader'),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader'),
				'created_by' => $this->session->userid,
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

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['PrintCode'] = $this->M_moulding->getPrintCode();

		// echo "<pre>";
		// print_r($data);
		// exit();

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtCheckingDateHeader', 'CheckingDate', 'required');
		$this->form_validation->set_rules('txtPrintCodeHeader', 'PrintCode', 'required');
		$this->form_validation->set_rules('txtCheckingQuantityHeader', 'CheckingQuantity', 'required');
		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperationUP2L/QualityControl/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'checking_date' => $this->input->post('txtCheckingDateHeader',TRUE),
				'print_code' => $this->input->post('txtPrintCodeHeader',TRUE),
				'checking_quantity' => $this->input->post('txtCheckingQuantityHeader',TRUE),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader',TRUE),
				'last_updated_by' => $this->session->userid,
				);
			$this->M_qualitycontrol->updateQualityControl($data, $plaintext_string);

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

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		// $plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl($id);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_read', $data);
		$this->load->view('V_Footer',$data);

	}

	/* READ DETAIL DATA */
	public function read_detail($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		// $plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControlDetail($id);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/QualityControl/V_read_detail', $data);
		$this->load->view('V_Footer',$data);

	}

	/* DELETE DATA */
	public function delete($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_qualitycontrol->deleteQualityControl($plaintext_string);

		redirect(site_url('ManufacturingOperationUP2L/QualityControl'));
	}

	public function createLaporan1()
	{	
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_qualitycontrol->getComponent($tanggal1, $tanggal2);


		// echo "<pre>";
		// print_r($section);
		// exit();

		$this->load->library('Excel');

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
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

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
		$worksheet->getColumnDimension('S')->setWidth(10);
		$worksheet->getColumnDimension('T')->setWidth(10);
		$worksheet->getColumnDimension('U')->setWidth(5);
		$worksheet->getColumnDimension('V')->setWidth(5);
		$worksheet->getColumnDimension('W')->setWidth(5);
		$worksheet->getColumnDimension('X')->setWidth(5);
		$worksheet->getColumnDimension('Y')->setWidth(5);
		$worksheet->getColumnDimension('Z')->setWidth(5);
		$worksheet->getColumnDimension('AA')->setWidth(5);
		$worksheet->getColumnDimension('AB')->setWidth(10);
		$worksheet->getColumnDimension('AC')->setWidth(10);
		$worksheet->getColumnDimension('AC')->setWidth(15);

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
		$worksheet->setCellValue('B1', 'MONITORING PRODUKSI UP2L Bulan : '.date('F').' dari '.$tanggal1.' s/d '.$tanggal2);

		

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
		$worksheet->setCellValue('S4', 'JML REJ');
		$worksheet->setCellValue('T4', 'BAIK');
		$worksheet->setCellValue('U4', 'KP');
		$worksheet->setCellValue('V4', 'GS');
		$worksheet->setCellValue('W4', 'CP');
		$worksheet->setCellValue('X4', 'TT');
		$worksheet->setCellValue('Y4', 'MS');
		$worksheet->setCellValue('Z4', 'LL');
		$worksheet->setCellValue('AA4', 'RV');
		$worksheet->setCellValue('AB4', 'JML REJ');
		$worksheet->setCellValue('AC4', 'BAIK');
		$worksheet->setCellValue('AD4', 'IP');
		$worksheet->setCellValue('AE4', 'TGL');



		$worksheet->getStyle('A3:D3')->getAlignment()->setWrapText(true);
		$worksheet->getStyle('A1:D3')->applyFromArray($aligncenter);
		$worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
		$worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);
		// ----------------- DYNAMIC DATA -----------------


		
		$highestRow = $worksheet->getHighestRow()+2;
		foreach ($section as $sc) {
			// $worksheet->getStyle('F'.$highestRow.':G'.$highestRow)->applyFromArray($styleBorder);

			$worksheet->setCellValue('B'.$highestRow, 'NAMA KOMPONEN : '.$sc['component_description']." => ".$sc['component_code']);

			$data['detail'] = $this->M_qualitycontrol->getPrintCode($sc['component_code']);



			$highestRow = $highestRow+1;
			$no = 1;	   
			foreach ($data['detail'] as $value) {

				$worksheet->setCellValue('A'.$highestRow,$no);
				$worksheet->setCellValue('B'.$highestRow,$value['print_code']);
				$worksheet->setCellValue('C'.$highestRow,$value['moulding_quantity']);

				$originalDate = $value['production_date'];
				$newDate = date("d-m-Y", strtotime($originalDate));

				$worksheet->setCellValue('AE'.$highestRow,$newDate);

				$scrap = $this->M_qualitycontrol->getDetail($value['moulding_id']);
				$reject  = 0;
				foreach ($scrap as $key) {

					if($key['kode_scrap'] == 'RC'){
						$worksheet->setCellValue('D'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'KP'){
						$worksheet->setCellValue('E'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'DF'){
						$worksheet->setCellValue('F'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}

					if($key['kode_scrap'] == 'CT'){
						$worksheet->setCellValue('G'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'TS'){
						$worksheet->setCellValue('H'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'CW'){
						$worksheet->setCellValue('I'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'PH'){
						$worksheet->setCellValue('J'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'GS'){
						$worksheet->setCellValue('K'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'CP'){
						$worksheet->setCellValue('L'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'TT'){
						$worksheet->setCellValue('M'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'BC'){
						$worksheet->setCellValue('N'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'NK'){
						$worksheet->setCellValue('O'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'MS'){
						$worksheet->setCellValue('P'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}

					if($key['kode_scrap'] == 'RT'){
						$worksheet->setCellValue('Q'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}
					if($key['kode_scrap'] == 'LL'){
						$worksheet->setCellValue('R'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
					}

				}

				$bongkar_qty = 0;
				$bongkar = $this->M_qualitycontrol->getBongkar($value['moulding_id']);
				foreach ($bongkar as $key) {
					$bongkar_qty += $key['qty'];	
				}


				$baik = (int)$value['moulding_quantity'] - $reject;
				$worksheet->setCellValue('S'.$highestRow, $reject);
				$worksheet->setCellValue('T'.$highestRow, $baik);

				$hasil = $baik - $bongkar_qty;

				$worksheet->setCellValue('AD'.$highestRow, $hasil);

						// $baik = (int) $value 

			   // 	 		$worksheet->setCellValue('AD'.$highestRow, $value['']);

				$highestRow++;
				$no++;
			}
			// $worksheet->setCellValue('F'.$highestRow, $no++);
			// $worksheet->setCellValue('G'.$highestRow, $sc['print_code']);
			
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Monitoring_Produksi_'.time().'.xls"');
		$objWriter->save("php://output");
	}


//------------------------------------------------- Create Laporan 2 ------------------------------------//
	public function createLaporan2(){
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');



		$kodekolom = $this->M_qualitycontrol->get4CharComp();
		
		
		$this->load->library('Excel');

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
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

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
		$worksheet->setCellValue('A3', 'Jogjakarta');
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
		$worksheet->setCellValue('H9', 'Hasil Baik (Pcs)');
		$worksheet->setCellValue('I9', '% Renc');
		$worksheet->setCellValue('J9', 'Tonage Baik (Kg)');
		$worksheet->setCellValue('K9', 'IP');
		$worksheet->setCellValue('L9', 'Tonage IP (Kg)');
		$worksheet->setCellValue('M9', 'Jumlah Reject (Pcs)');
		$worksheet->setCellValue('N9', 'Tonage Reject (Kg)');
		$worksheet->setCellValue('O9', '% Reject (Pcs)');
		$worksheet->setCellValue('P9', 'Prediksi Baik (Pcs)');
		$worksheet->setCellValue('Q9', '% Renc');
		$worksheet->setCellValue('R10', 'MS');
		$worksheet->setCellValue('S10', 'DF');
		$worksheet->setCellValue('T10', 'KP');
		$worksheet->setCellValue('U10', 'CT');
		$worksheet->setCellValue('V10', 'TS');
		$worksheet->setCellValue('W10', 'GS');
		$worksheet->setCellValue('X10', 'CP');
		$worksheet->setCellValue('Y10', 'RT');
		$worksheet->setCellValue('Z10', 'CW');
		$worksheet->setCellValue('AA10', 'TT');
		$worksheet->setCellValue('AB10', 'BC');
		$worksheet->setCellValue('AC10', 'PH');
		$worksheet->setCellValue('AD10', 'KS');
		$worksheet->setCellValue('AE10', 'NK');
		$worksheet->setCellValue('AF10', 'CR');
		$worksheet->setCellValue('AG10', 'RC');
		$worksheet->setCellValue('AH10', 'LL');


		$worksheet->setCellValue('A6', "Bulan:".date('F'));
		$worksheet->setCellValue('A7', "Tgl: ".$tanggal1." s/d ".$tanggal2);
		
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

		$highestRow = $worksheet->getHighestRow()+2;
		foreach ($kodekolom as $sc) {
			// $worksheet->getStyle('F'.$highestRow.':G'.$highestRow)->applyFromArray($styleBorder);

			

			$data['detail'] = $this->M_qualitycontrol->getComponentWhere($sc['component_code'],$tanggal1,$tanggal2);


			$worksheet->setCellValue('B'.$highestRow, 'Tractor : '.$sc['component_code']);

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


			$highestRow = $highestRow+1;
			$no = 1;	   
			foreach ($data['detail'] as $value) {


				$master = $this->M_qualitycontrol->getMasterItem($value['component_code']);
				$bongkar = $this->M_qualitycontrol->getBongkarWhere($value['moulding_id']);


				$bongkar_qty = $bongkar[0]['qty'];


				$scrap = $this->M_qualitycontrol->getDetail($value['moulding_id']);


				$reject = 0;

				foreach ($scrap as $key) {

					if($key['kode_scrap'] == 'RC'){
						$worksheet->setCellValue('AG'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_rc += $key['quantity'];

					}
					if($key['kode_scrap'] == 'KP'){
						$worksheet->setCellValue('T'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_kp += $key['quantity'];
					}
					if($key['kode_scrap'] == 'DF'){
						$worksheet->setCellValue('S'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_df += $key['quantity'];
					}

					if($key['kode_scrap'] == 'CT'){
						$worksheet->setCellValue('U'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_ct += $key['quantity'];
					}
					if($key['kode_scrap'] == 'TS'){
						$worksheet->setCellValue('V'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_ts += $key['quantity'];
					}
					if($key['kode_scrap'] == 'CW'){
						$worksheet->setCellValue('Z'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_cw += $key['quantity'];
					}
					if($key['kode_scrap'] == 'PH'){
						$worksheet->setCellValue('AC'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_ph += $key['quantity'];
					}
					if($key['kode_scrap'] == 'RT'){
						$worksheet->setCellValue('Y'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_rt += $key['quantity'];
					}
					if($key['kode_scrap'] == 'GS'){
						$worksheet->setCellValue('W'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_gs += $key['quantity'];
					}
					if($key['kode_scrap'] == 'CP'){
						$worksheet->setCellValue('X'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_cp += $key['quantity'];
					}
					if($key['kode_scrap'] == 'TT'){
						$worksheet->setCellValue('AA'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_tt += $key['quantity'];
					}
					if($key['kode_scrap'] == 'BC'){
						$worksheet->setCellValue('AB'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_bc += $key['quantity'];
					}
					if($key['kode_scrap'] == 'NK'){
						$worksheet->setCellValue('AE'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_nk += $key['quantity'];
					}
					if($key['kode_scrap'] == 'MS'){
						$worksheet->setCellValue('R'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_ms += $key['quantity'];
					}
					if($key['kode_scrap'] == 'CR'){
						$worksheet->setCellValue('AF'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_cr += $key['quantity'];
					}
					if($key['kode_scrap'] == 'LL'){
						$worksheet->setCellValue('AH'.$highestRow,$key['quantity']);
						$reject += $key['quantity'];
						$sum_ll += $key['quantity'];
					}
				}



				$berat = $master[0]['berat'];
				$jumlah_qty = $value['moulding_quantity'];
				$hasil_baik = $jumlah_qty - $reject;
				$ip = $hasil_baik - $bongkar_qty;
				$tonage = $berat * $hasil_baik;	
				$tonage_berat = $ip * $tonage;
				$tonage_reject = $reject * $berat;
				$persen_reject = ($reject / $hasil_baik) * 100;

				$worksheet->setCellValue('A'.$highestRow,$no);
				$worksheet->setCellValue('B'.$highestRow,$value['component_code']);
				$worksheet->setCellValue('C'.$highestRow,$value['component_description']);
				$worksheet->setCellValue('D'.$highestRow,$faktor_pengali);
				$worksheet->setCellValue('E'.$highestRow,$berat);
				$worksheet->setCellValue('F'.$highestRow,'0');
				$worksheet->setCellValue('G'.$highestRow,$jumlah_qty);
				$worksheet->setCellValue('H'.$highestRow,$hasil_baik);
				$worksheet->setCellValue('I'.$highestRow,'0');
				$worksheet->setCellValue('J'.$highestRow,$tonage);
				$worksheet->setCellValue('K'.$highestRow,$ip);
				$worksheet->setCellValue('L'.$highestRow,$tonage_berat);
				$worksheet->setCellValue('M'.$highestRow,$reject);
				$worksheet->setCellValue('N'.$highestRow,$tonage_reject);
				$worksheet->setCellValue('O'.$highestRow,number_format((float)$persen_reject, 2, '.', '')."%");

				$sum_total_cetak += $jumlah_qty;
				$sum_hasil_baik += $hasil_baik;
				$sum_tonage_baik += $tonage;
				$sum_ip += $ip;
				$sum_tonage_ip += $tonage_berat;
				$sum_reject += $reject;
				$sum_tonage_reject += $tonage_reject;
				$sum_persen_reject +=  $persen_reject; 

				
				$persen_tonage_baik += ($jumlah_qty * $berat);


				$highestRow++;
				$no++;

			}
			// $worksheet->setCellValue('F'.$highestRow, $no++);
			// $worksheet->setCellValue('G'.$highestRow, $sc['print_code']);

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



			$worksheet->setCellValue('B'.$highestRow,"Sub Total QTY");
			$worksheet->setCellValue('G'.$highestRow,$sum_total_cetak);
			$worksheet->setCellValue('H'.$highestRow,$sum_hasil_baik);
			$worksheet->setCellValue('J'.$highestRow,$sum_tonage_baik);
			$worksheet->setCellValue('K'.$highestRow,$sum_ip);
			$worksheet->setCellValue('L'.$highestRow,$sum_tonage_ip);
			$worksheet->setCellValue('M'.$highestRow,$sum_reject);
			$worksheet->setCellValue('N'.$highestRow,$sum_tonage_reject);
			$worksheet->setCellValue('O'.$highestRow,number_format((float)$sum_persen_reject, 2, '.', '')."%");

			$worksheet->setCellValue('AG'.$highestRow,$sum_rc);
			$worksheet->setCellValue('T'.$highestRow,$sum_kp);
			$worksheet->setCellValue('S'.$highestRow,$sum_df);
			$worksheet->setCellValue('U'.$highestRow,$sum_ct);
			$worksheet->setCellValue('V'.$highestRow,$sum_ts);
			$worksheet->setCellValue('Z'.$highestRow,$sum_cw);
			$worksheet->setCellValue('AC'.$highestRow,$sum_ph);
			$worksheet->setCellValue('Y'.$highestRow,$sum_rt);
			$worksheet->setCellValue('W'.$highestRow,$sum_gs);
			$worksheet->setCellValue('X'.$highestRow,$sum_cp);
			$worksheet->setCellValue('AA'.$highestRow,$sum_tt);
			$worksheet->setCellValue('AB'.$highestRow,$sum_bc);
			$worksheet->setCellValue('AE'.$highestRow,$sum_nk);
			$worksheet->setCellValue('R'.$highestRow,$sum_ms);	
			$worksheet->setCellValue('AF'.$highestRow,$sum_cr);
			$worksheet->setCellValue('AH'.$highestRow,$sum_ll);

			$highestRow++;
			$worksheet->setCellValue('B'.$highestRow,"Prosentase (%)");
			if($sum_hasil_baik != 0){
				$persen_hasil_baik = ($sum_hasil_baik / ($sum_hasil_baik+$sum_reject)) * 100;
				$persen_tonage_baik = ($sum_tonage_baik / $persen_tonage_baik) * 100;
				$persen_jum_reject = 100 - $persen_hasil_baik;
				$persen_tonage_reject = 100 - $persen_tonage_baik;	
			}
			$worksheet->setCellValue('H'.$highestRow,number_format((float)$persen_hasil_baik,2,'.','')."%");
			$worksheet->setCellValue('J'.$highestRow,number_format((float)$persen_tonage_baik,2,'.','')."%");
			$worksheet->setCellValue('M'.$highestRow,number_format((float)$persen_jum_reject,2,'.','')."%");
			$worksheet->setCellValue('N'.$highestRow,number_format((float)$persen_tonage_reject,2,'.','')."%");
			
			$highestRow +=2;
			$worksheet->setCellValue('B'.$highestRow,"Sub Total Berat");
			
			$highestRow++;
			$worksheet->setCellValue('B'.$highestRow,"Prosentase (% Berat)");
			
			$highestRow +=2;
		}


		$worksheet->setCellValue('B'.$highestRow,"Total Produksi");
		$worksheet->setCellValue('G'.$highestRow,$sum_total_jmlh_cetak);
		$worksheet->setCellValue('H'.$highestRow,$sum_total_hasil_baik);
		$worksheet->setCellValue('J'.$highestRow,$sum_total_tonage_baik);
		$worksheet->setCellValue('K'.$highestRow,$sum_total_ip);
		$worksheet->setCellValue('L'.$highestRow,$sum_total_tonage_ip);
		$worksheet->setCellValue('M'.$highestRow,$sum_total_jumlah_reject);
		$worksheet->setCellValue('N'.$highestRow,$sum_total_tonage_reject);

		$worksheet->setCellValue('AG'.$highestRow,$total_sum_rc);
		$worksheet->setCellValue('T'.$highestRow,$total_sum_kp);
		$worksheet->setCellValue('S'.$highestRow,$total_sum_df);
		$worksheet->setCellValue('U'.$highestRow,$total_sum_ct);
		$worksheet->setCellValue('V'.$highestRow,$total_sum_ts);
		$worksheet->setCellValue('Z'.$highestRow,$total_sum_cw);
		$worksheet->setCellValue('AC'.$highestRow,$total_sum_ph);
		$worksheet->setCellValue('Y'.$highestRow,$total_sum_rt);
		$worksheet->setCellValue('W'.$highestRow,$total_sum_gs);
		$worksheet->setCellValue('X'.$highestRow,$total_sum_cp);
		$worksheet->setCellValue('AA'.$highestRow,$total_sum_tt);
		$worksheet->setCellValue('AB'.$highestRow,$total_sum_bc);
		$worksheet->setCellValue('AE'.$highestRow,$total_sum_nk);
		$worksheet->setCellValue('R'.$highestRow,$total_sum_ms);	
		$worksheet->setCellValue('AF'.$highestRow,$total_sum_cr);
		$worksheet->setCellValue('AH'.$highestRow,$total_sum_ll);


		$highestRow++;

		$prosentase_hasil_baik = $sum_total_hasil_baik/($sum_total_jmlh_cetak-$sum_total_ip)*100;
		$prosentase_tonage_baik = $sum_total_tonage_baik/($sum_total_tonage_baik+$sum_total_tonage_reject)*100;
		$prosentase_jumlah_reject = $sum_total_jumlah_reject/($sum_total_jmlh_cetak-$sum_total_ip)*100;
		$prosentase_tonage_reject = $sum_total_tonage_reject/($sum_total_tonage_baik+$sum_total_tonage_reject)*100;
		
		$worksheet->setCellValue('B'.$highestRow,"Prosentase");
		$worksheet->setCellValue('H'.$highestRow,$prosentase_hasil_baik);
		$worksheet->setCellValue('J'.$highestRow,$prosentase_tonage_baik);
		$worksheet->setCellValue('M'.$highestRow,$prosentase_jumlah_reject);
		$worksheet->setCellValue('N'.$highestRow,$prosentase_tonage_reject);

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
		
		$worksheet->setCellValue('AG'.$highestRow,$prosentase_sum_rc);
		$worksheet->setCellValue('T'.$highestRow,$prosentase_sum_kp);
		$worksheet->setCellValue('S'.$highestRow,$prosentase_sum_df);
		$worksheet->setCellValue('U'.$highestRow,$prosentase_sum_ct);
		$worksheet->setCellValue('V'.$highestRow,$prosentase_sum_ts);
		$worksheet->setCellValue('Z'.$highestRow,$prosentase_sum_cw);
		$worksheet->setCellValue('AC'.$highestRow,$prosentase_sum_ph);
		$worksheet->setCellValue('Y'.$highestRow,$prosentase_sum_rt);
		$worksheet->setCellValue('W'.$highestRow,$prosentase_sum_gs);
		$worksheet->setCellValue('X'.$highestRow,$prosentase_sum_cp);
		$worksheet->setCellValue('AA'.$highestRow,$prosentase_sum_tt);
		$worksheet->setCellValue('AB'.$highestRow,$prosentase_sum_bc);
		$worksheet->setCellValue('AE'.$highestRow,$prosentase_sum_nk);
		$worksheet->setCellValue('R'.$highestRow,$prosentase_sum_ms);	
		$worksheet->setCellValue('AF'.$highestRow,$prosentase_sum_cr);
		$worksheet->setCellValue('AH'.$highestRow,$prosentase_sum_ll);

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Evaluasi_Produksi_'.time().'.xls"');
		$objWriter->save("php://output");
	}

	public function createLaporan3()
	{	
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_qualitycontrol->getComponentThis($tanggal1, $tanggal2);



		$this->load->library('Excel');

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
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

		// ----------------- Set format table -----------------
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
		// $worksheet->setCellValue('B1', 'MONITORING PRODUKSI UP2L Bulan : '.date('F').' dari '.$tanggal1.' s/d '.$tanggal2);

		

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
		$worksheet->setCellValue('AE3', 'HASIL BAIK');
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
		$worksheet->setCellValue('BA3', 'REJECT QC');
		$worksheet->setCellValue('BB3', 'HASIL BAIK');
		$worksheet->setCellValue('BC3', 'REJECT');
		$worksheet->setCellValue('BD3', 'KETERANGAN');
		




        // $worksheet->getStyle('A3:D3')->getAlignment()->setWrapText(true);
        // $worksheet->getStyle('A1:D3')->applyFromArray($aligncenter);
        // // $worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
        // // $worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);
		// ----------------- DYNAMIC DATA -----------------
		
		$kelompok = 'A';
		$temp_date = '';
		$highestRow = $worksheet->getHighestRow()+2;
		foreach ($section as $sc) {

			if($sc['production_date'] == $temp_date){
				$kelompok++;
			}else{
				$temp_date = $sc['production_date'];
				$kelompok = 'A';
			}

			$worksheet->setCellValue('A'.$highestRow,$sc['production_date']);
			$worksheet->setCellValue('B'.$highestRow,$kelompok);
			$worksheet->setCellValue('C'.$highestRow,$sc['print_code']);
			$worksheet->setCellValue('D'.$highestRow,$sc['component_code']);
			$worksheet->setCellValue('E'.$highestRow,$sc['moulding_quantity']);
			

			$scrap = $this->M_qualitycontrol->getDetail($sc['moulding_id']);
			$reject = 0;
			$quantity = $sc['moulding_quantity'];

			$berat = $this->M_qualitycontrol->getMasterItem($sc['component_code']);
			$worksheet->setCellValue('F'.$highestRow,$berat[0]['kode_proses']);


			$reject_qc = $this->M_qualitycontrol->getQtyRejectQC($sc['print_code']);


			$worksheet->setCellValue('G'.$highestRow,0);
			$worksheet->setCellValue('H'.$highestRow,0);
			$worksheet->setCellValue('I'.$highestRow,0);
			$worksheet->setCellValue('J'.$highestRow,0);
			$worksheet->setCellValue('K'.$highestRow,0);
			$worksheet->setCellValue('L'.$highestRow,0);
			$worksheet->setCellValue('M'.$highestRow,0);
			$worksheet->setCellValue('N'.$highestRow,0);
			$worksheet->setCellValue('O'.$highestRow,0);
			$worksheet->setCellValue('P'.$highestRow,0);
			$worksheet->setCellValue('Q'.$highestRow,0);
			$worksheet->setCellValue('R'.$highestRow,0);
			$worksheet->setCellValue('S'.$highestRow,0);
			$worksheet->setCellValue('T'.$highestRow,0);
			$worksheet->setCellValue('U'.$highestRow,0);
			$worksheet->setCellValue('V'.$highestRow,0);
			$worksheet->setCellValue('W'.$highestRow,0);
			$worksheet->setCellValue('X'.$highestRow,0);
			$worksheet->setCellValue('Y'.$highestRow,0);
			$worksheet->setCellValue('Z'.$highestRow,0);
			$worksheet->setCellValue('AA'.$highestRow,0);
			$worksheet->setCellValue('AB'.$highestRow,0);

			foreach ($scrap as $key) {

				if($key['kode_scrap'] == 'RC'){
					$worksheet->setCellValue('G'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'DF'){
					$worksheet->setCellValue('H'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'CR'){
					$worksheet->setCellValue('I'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];	
				}

				if($key['kode_scrap'] == 'TK'){
					$worksheet->setCellValue('J'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'PR'){
					$worksheet->setCellValue('K'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'KP'){
					$worksheet->setCellValue('L'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'CT'){
					$worksheet->setCellValue('M'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];

				}

				if($key['kode_scrap'] == 'TS'){
					$worksheet->setCellValue('N'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];

				}

				if($key['kode_scrap'] == 'CO'){
					$worksheet->setCellValue('O'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}


				if($key['kode_scrap'] == 'CW'){
					$worksheet->setCellValue('P'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}


				if($key['kode_scrap'] == 'SC'){
					$worksheet->setCellValue('Q'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];

				}

				if($key['kode_scrap'] == 'PH'){
					$worksheet->setCellValue('R'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'SG'){
					$worksheet->setCellValue('S'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'GS'){
					$worksheet->setCellValue('T'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'CP'){
					$worksheet->setCellValue('U'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'TT'){
					$worksheet->setCellValue('V'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}
				if($key['kode_scrap'] == 'BC'){
					$worksheet->setCellValue('W'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'KS'){
					$worksheet->setCellValue('X'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'NK'){
					$worksheet->setCellValue('Y'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'MS'){
					$worksheet->setCellValue('Z'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'RT'){
					$worksheet->setCellValue('AA'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

				if($key['kode_scrap'] == 'PK'){
					$worksheet->setCellValue('AB'.$highestRow,$key['quantity']);
					$reject += $key['quantity'];
				}

			}

			$hasil_baik = $quantity - $reject;
			$ip = $hasil_baik * $berat[0]['berat'];

			$reject_qc_2 = 0;
			if($reject_qc[0]['scrap_quantity'] > 0){
				$reject_qc_2 = $reject_qc[0]['scrap_quantity'];
			}

			$hasil_baik_2 = $hasil_baik - $reject_qc_2;

			$total_reject = $reject + $reject_qc_2;

			$worksheet->setCellValue('AC'.$highestRow,$reject);
			$worksheet->setCellValue('AD'.$highestRow,$ip);
			$worksheet->setCellValue('AE'.$highestRow,$hasil_baik);
			$worksheet->setCellValue('BA'.$highestRow,$reject_qc_2);
			$worksheet->setCellValue('BB'.$highestRow,$hasil_baik_2);
			$worksheet->setCellValue('BC'.$highestRow,$total_reject);
			$worksheet->setCellValue('BD'.$highestRow,$sc['keterangan']);
			$highestRow++;
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="DET_TRAN_'.time().'.xls"');
		$objWriter->save("php://output");
	}

	public function createLaporan4()
	{	
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_qualitycontrol->getComponentThis($tanggal1, $tanggal2);



		$this->load->library('Excel');

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
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

		// ----------------- Set format table -----------------
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
		// $worksheet->setCellValue('B1', 'MONITORING PRODUKSI UP2L Bulan : '.date('F').' dari '.$tanggal1.' s/d '.$tanggal2);

		

		$worksheet->setCellValue('A3', 'TANGGAL');
		$worksheet->setCellValue('B3', 'KODE KELOMPOK');
		$worksheet->setCellValue('C3', 'KODE COR');
		$worksheet->setCellValue('D3', 'KODE KOMPONEN');
		$worksheet->setCellValue('F3', 'KODE PROSES');
		$worksheet->setCellValue('E3', 'HASIL COR');
		$worksheet->setCellValue('G3', 'HASIL BAIK');
		$worksheet->setCellValue('H3', 'RMURNI');
		$worksheet->setCellValue('I3', 'RBEBDC');
		$worksheet->setCellValue('J3', 'RINTC');
		$worksheet->setCellValue('K3', 'RMURNIT');
		$worksheet->setCellValue('L3', 'RBEBDT');
		$worksheet->setCellValue('M3', 'RINTT');
		$worksheet->setCellValue('N3', 'RMURNIF');
		$worksheet->setCellValue('O3', 'RBEBDF');
		$worksheet->setCellValue('P3', 'RINTF');
		$worksheet->setCellValue('Q3', 'REJC25');
		$worksheet->setCellValue('R3', 'REJT25');
		

        // $worksheet->getStyle('A3:D3')->getAlignment()->setWrapText(true);
        // $worksheet->getStyle('A1:D3')->applyFromArray($aligncenter);
        // // $worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
        // // $worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);

		// ----------------- DYNAMIC DATA -----------------
		
		$kelompok = 'A';
		$temp_date = '';
		$highestRow = $worksheet->getHighestRow()+2;
		foreach ($section as $sc) {

			if($sc['production_date'] == $temp_date){
				$kelompok++;
			}else{
				$temp_date = $sc['production_date'];
				$kelompok = 'A';
			}

			$worksheet->setCellValue('A'.$highestRow,$sc['production_date']);
			$worksheet->setCellValue('B'.$highestRow,$kelompok);
			$worksheet->setCellValue('C'.$highestRow,$sc['print_code']);
			$worksheet->setCellValue('D'.$highestRow,$sc['component_code']);
			$worksheet->setCellValue('E'.$highestRow,$sc['moulding_quantity']);
			

			$scrap = $this->M_qualitycontrol->getDetail($sc['moulding_id']);
			$reject = 0;
			$quantity = $sc['moulding_quantity'];

			$berat = $this->M_qualitycontrol->getMasterItem($sc['component_code']);

			$worksheet->setCellValue('F'.$highestRow,$berat[0]['kode_proses']);

			$reject_qc = $this->M_qualitycontrol->getQtyRejectQC($sc['print_code']);

			$hasil_baik = $quantity - $reject;
			$ip = $hasil_baik * $berat[0]['berat'];


			$scrap = $this->M_qualitycontrol->getDetail($sc['moulding_id']);


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
			$sum_pr = 0;
			$sum_tk = 0;
			$sum_ks = 0;
			$sum_pk = 0;

			$reject = 0;


			foreach ($scrap as $key) {

				if($key['kode_scrap'] == 'PK'){
					$reject += $key['quantity'];
					$sum_pk += $key['quantity'];
				}
				if($key['kode_scrap'] == 'RC'){
					$reject += $key['quantity'];
					$sum_rc += $key['quantity'];
				}
				if($key['kode_scrap'] == 'KS'){
					$reject += $key['quantity'];
					$sum_ks += $key['quantity'];
				}

				if($key['kode_scrap'] == 'TK'){
					$reject += $key['quantity'];
					$sum_tk += $key['quantity'];

				}
				if($key['kode_scrap'] == 'KP'){
					$reject += $key['quantity'];
					$sum_kp += $key['quantity'];
				}
				if($key['kode_scrap'] == 'DF'){
					$reject += $key['quantity'];
					$sum_df += $key['quantity'];
				}

				if($key['kode_scrap'] == 'CT'){
					$reject += $key['quantity'];
					$sum_ct += $key['quantity'];
				}
				if($key['kode_scrap'] == 'TS'){
					$reject += $key['quantity'];
					$sum_ts += $key['quantity'];
				}
				if($key['kode_scrap'] == 'CW'){
					$reject += $key['quantity'];
					$sum_cw += $key['quantity'];
				}
				if($key['kode_scrap'] == 'PH'){
					$reject += $key['quantity'];
					$sum_ph += $key['quantity'];
				}
				if($key['kode_scrap'] == 'RT'){
					$reject += $key['quantity'];
					$sum_rt += $key['quantity'];
				}
				if($key['kode_scrap'] == 'GS'){
					$reject += $key['quantity'];
					$sum_gs += $key['quantity'];
				}
				if($key['kode_scrap'] == 'CP'){
					$reject += $key['quantity'];
					$sum_cp += $key['quantity'];
				}
				if($key['kode_scrap'] == 'TT'){
					$reject += $key['quantity'];
					$sum_tt += $key['quantity'];
				}
				if($key['kode_scrap'] == 'BC'){
					$reject += $key['quantity'];
					$sum_bc += $key['quantity'];
				}
				if($key['kode_scrap'] == 'NK'){
					$reject += $key['quantity'];
					$sum_nk += $key['quantity'];
				}
				if($key['kode_scrap'] == 'MS'){
					$reject += $key['quantity'];
					$sum_ms += $key['quantity'];
				}
				if($key['kode_scrap'] == 'CR'){
					$reject += $key['quantity'];
					$sum_cr += $key['quantity'];
				}
				if($key['kode_scrap'] == 'LL'){
					$reject += $key['quantity'];
					$sum_ll += $key['quantity'];
				}
				if($key['kode_scrap'] == 'PR'){
					$reject += $key['quantity'];
					$sum_pr += $key['quantity'];
				}
			}


			$rmurnic = $sum_df + $sum_pr + $sum_tk + $sum_cr;
			$rejc25 = $sum_gs + $sum_bc + $sum_ks + $sum_ms ;
			$rintc = $sum_cp + $sum_nk + $sum_tt;

			$rbebdc = $sum_kp + $sum_ct + $sum_ts;
			$rbebdc = $rbebdc + $sum_rt + $sum_pk + $sum_cw + $sum_ph;

			$rmurnit = $sum_kp + $sum_ct + $sum_ct + $sum_ts;
			$rejt25 = $sum_gs + $sum_bc + $sum_ks +	 $sum_ms;
			$rintt = $sum_cp + $sum_nk + $sum_tt + $sum_rt + $sum_rc + $sum_pk;
			$rbebdt = $sum_df + $sum_pr + $sum_tk + $sum_cw + $sum_ph + $sum_cr;

			$rmurnif = $sum_cw + $sum_ph;
			$rintf = $sum_rt + $sum_pk;
			$rbebdf = $sum_df + $sum_pr + $sum_tk + $sum_kp + $sum_ct;
			$rbebdf = $rbebdf + $sum_ct + $sum_ts + $sum_cr + $rintc + $rejc25;



			$reject_qc_2 = 0;	
			if($reject_qc[0]['scrap_quantity'] > 0){
				$reject_qc_2 = $reject_qc[0]['scrap_quantity'];
			}

			$hasil_baik_2 = $hasil_baik - $reject_qc_2;

			$total_reject = $reject + $reject_qc_2;

			$worksheet->setCellValue('G'.$highestRow,$hasil_baik_2);
			$worksheet->setCellValue('H'.$highestRow,$rmurnic);
			$worksheet->setCellValue('I'.$highestRow,$rbebdc);
			$worksheet->setCellValue('J'.$highestRow,$rintc);
			$worksheet->setCellValue('K'.$highestRow,$rmurnit);
			$worksheet->setCellValue('L'.$highestRow,$rbebdt);
			$worksheet->setCellValue('M'.$highestRow,$rintt);
			$worksheet->setCellValue('N'.$highestRow,$rmurnif);
			$worksheet->setCellValue('O'.$highestRow,$rbebdf);
			$worksheet->setCellValue('P'.$highestRow,$rintf);
			$worksheet->setCellValue('Q'.$highestRow,$rejc25);
			$worksheet->setCellValue('R'.$highestRow,$rejt25);

       		// $worksheet->setCellValue('AC'.$highestRow,$reject);
       		// $worksheet->setCellValue('AD'.$highestRow,$ip);
       		// $worksheet->setCellValue('AE'.$highestRow,$hasil_baik);
       		// $worksheet->setCellValue('BA'.$highestRow,$reject_qc_2);
       		// $worksheet->setCellValue('BB'.$highestRow,$hasil_baik_2);
       		// $worksheet->setCellValue('BC'.$highestRow,$total_reject);

			$highestRow++;
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="BPKEAKT_'.time().'.xls"');
		$objWriter->save("php://output");
	}



	public function createLaporan5()
	{	
		$tanggal1 = $this->input->post('tanggal_awal');
		$tanggal2 = $this->input->post('tanggal_akhir');

		$section = $this->M_qualitycontrol->getAbsensi($tanggal1, $tanggal2);


		$this->load->library('Excel');

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
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

		// ----------------- Set format table -----------------
		$worksheet->getColumnDimension('A')->setWidth(10);
		$worksheet->getColumnDimension('B')->setWidth(10);
		$worksheet->getColumnDimension('C')->setWidth(10);
		$worksheet->getColumnDimension('D')->setWidth(10);
		$worksheet->getColumnDimension('E')->setWidth(10);
		$worksheet->getColumnDimension('F')->setWidth(10);

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
		// $worksheet->setCellValue('B1', 'MONITORING PRODUKSI UP2L Bulan : '.date('F').' dari '.$tanggal1.' s/d '.$tanggal2);

		

		$worksheet->setCellValue('A3', 'TANGGAL');
		$worksheet->setCellValue('B3', 'NO INDUK');
		$worksheet->setCellValue('C3', 'KODE KELOMPOK');
		$worksheet->setCellValue('D3', 'KODE COR');
		$worksheet->setCellValue('F3', 'PRESENSI');
		$worksheet->setCellValue('E3', 'PRODUKSI');
		$worksheet->setCellValue('G3', 'NIL_OTT');
		$worksheet->setCellValue('H3', 'WH');
		$worksheet->setCellValue('I3', 'LEMBUR');
		




        // $worksheet->getStyle('A3:D3')->getAlignment()->setWrapText(true);
        // $worksheet->getStyle('A1:D3')->applyFromArray($aligncenter);
        // // $worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
        // // $worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);
		// ----------------- DYNAMIC DATA -----------------
		
		$kelompok = 'A';
		$temp_date = '';
		$highestRow = $worksheet->getHighestRow()+2;
		foreach ($section as $sc) {

			if($sc['print_code'] == $temp_date){
				$kelompok++;
			}else{
				$temp_date = $sc['print_code'];
				$kelompok = 'A';
			}

			$worksheet->setCellValue('A'.$highestRow,$sc['kerad']);
			$worksheet->setCellValue('B'.$highestRow,$sc['no_induk']);
			$worksheet->setCellValue('C'.$highestRow,$kelompok);
			$worksheet->setCellValue('D'.$highestRow,$sc['print_code']);
			$worksheet->setCellValue('E'.$highestRow,$sc['produksi']);
			$worksheet->setCellValue('F'.$highestRow,$sc['presensi']);
			$worksheet->setCellValue('G'.$highestRow,$sc['nilai_ott']);
			$worksheet->setCellValue('I'.$highestRow,$sc['lembur']);


       		// $worksheet->setCellValue('AC'.$highestRow,$reject);
       		// $worksheet->setCellValue('AD'.$highestRow,$ip);
       		// $worksheet->setCellValue('AE'.$highestRow,$hasil_baik);
       		// $worksheet->setCellValue('BA'.$highestRow,$reject_qc_2);
       		// $worksheet->setCellValue('BB'.$highestRow,$hasil_baik_2);
       		// $worksheet->setCellValue('BC'.$highestRow,$total_reject);

			$highestRow++;
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="IND_TRAN_'.time().'.xls"');
		$objWriter->save("php://output");
	}


}

/* End of file C_QualityControl.php */
/* Location: ./application/controllers/ManufacturingOperationUP2L/MainMenu/C_QualityControl.php */
/* Generated automatically on 2017-12-20 14:51:22 */