<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_InternalView extends CI_Controller
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
		$this->load->model('MonitoringFlowOut/M_master');

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

		$data['Title'] = 'Internal View';
		$data['Menu'] = 'Internal View';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['dats'] = $this->M_internal->getInternal();
		$data['seksi'] = $this->M_master->getSeksi();
		$data['onlyseksi'] = $this->M_master->getSeksi2();
		$data['getAllIns'] = $this->M_internal->getAllInsp();

		for($i=0; $i < count($data['onlyseksi']); $i++){
			$data['seksi2'][$i] = $data['onlyseksi'][$i]['seksi'];
		}

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/Internal/V_IntView', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getQi($id)
	{
		$data = $this->M_internal->getEditInsp($id);
		echo json_encode($data);
	}

	function delInternal($id, $link_qr, $link_car)
	{
		unlink('./assets/upload/MonitoringFlowOut/uploadQr/' . $link_qr);
		unlink('./assets/upload/MonitoringFlowOut/uploadCar/' . $link_car);
		$this->M_internal->delInternal($id);
		redirect(base_url('MonitoringFlowOut/InternalView'));
	}

	public function search()
	{
		$txtTglMFO1 = $_POST['txtTglMFO1'];
		$txtTglMFO2 = $_POST['txtTglMFO2'];
		$slcSeksiFAjx = $_POST['slcSeksiFAjx'];

		$newtxtTglMFO1 = date('Y-m-d', strtotime($txtTglMFO1));
		$newtxtTglMFO2 = date('Y-m-d', strtotime($txtTglMFO2));

		$data['dats'] = $this->M_internal->sortByDate($newtxtTglMFO1, $newtxtTglMFO2, $slcSeksiFAjx);
		if (empty($data['dats'])){
			echo "<center><h3 style='color:red;'>Data tidak ditemukan</h3></center>";
		} else {
		return $this->load->view('MonitoringFlowOut/Internal/V_ViewResult', $data);
		}
	}

	function edit($id)
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Internal Edit';
		$data['Menu'] = 'Internal Edit';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['fail'] = $this->M_master->getPoss();
		$data['seksi'] = $this->M_master->getSeksi();
		$data['getEdit'] = $this->M_internal->getOne($id);
		$data['getEdIns'] = $this->M_internal->getEditInsp($id);
		$data['id'] = $id;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/Internal/V_IntEdit', $data);
		$this->load->view('V_Footer', $data);
	}

	function update($id)
	{
		$arrPJ = $this->input->post('txtSeksiPenanggungJawab[]');
		$txtSeksiPenanggungJawab = implode(",", $arrPJ);

		if ($_FILES['upQr']['name'] != '') {
			unlink('./assets/upload/MonitoringFlowOut/uploadQr/' . $this->input->post('fileLamaQr'));
			$temp = explode(".", $_FILES["upQr"]["name"]);
			$newfilenameQr = "upQr_" . date('d-M-Y_h-i-a') . '.' . end($temp);
			mkdir('./assets/upload/MonitoringFlowOut/uploadQr/', 0777, true);
			move_uploaded_file($_FILES["upQr"]["tmp_name"], "./assets/upload/MonitoringFlowOut/uploadQr/" . $newfilenameQr);
			chmod('./assets/upload/MonitoringFlowOut/uploadQr/'.$newfilenameQr, 0777);
		} else {
			$newfilenameQr = $this->input->post('fileLamaQr');
		}
		if ($_FILES['upCar']['name'] != '') {
			unlink('./assets/upload/MonitoringFlowOut/uploadCar/' . $this->input->post('fileLamaCar'));
			$temp = explode(".", $_FILES["upCar"]["name"]);
			$newfilenameCar = "upCar_" . date('d-M-Y_h-i-a') . '.' . end($temp);
			mkdir('./assets/upload/MonitoringFlowOut/uploadCar/', 0777, true);
			move_uploaded_file($_FILES["upCar"]["tmp_name"], "./assets/upload/MonitoringFlowOut/uploadCar/" . $newfilenameCar);
			chmod('./assets/upload/MonitoringFlowOut/uploadCar/' . $newfilenameCar, 0777);
		} else {
			$newfilenameCar = $this->input->post('fileLamaCar');
		}
		if (!empty($this->input->post('txtComponentCode'))) {
			$component_code_int = $this->input->post('txtComponentCode');
		} else {
			$component_code_int = NULL;
		}
		if (!empty($this->input->post('txtComponentName'))) {
			$component_name = $this->input->post('txtComponentName');
		} else {
			$component_name = NULL;
		}
		if (!empty($this->input->post('txtType'))) {
			$type = $this->input->post('txtType');
		} else {
			$type = NULL;
		}
		if (!empty($this->input->post('txtTanggal'))) {
			$tanggal2 = $this->input->post('txtTanggal');
			$tanggal = date('Y-m-d', strtotime($tanggal2));
		} else {
			$tanggal = NULL;
		}
		if (!empty($this->input->post('txtKronologiPerm'))) {
			$kronologi_p = $this->input->post('txtKronologiPerm');
		} else {
			$kronologi_p = NULL;
		}
		if (!empty($this->input->post('txtSeksiPenemu'))) {
			$seksi_penemu = $this->input->post('txtSeksiPenemu');
		} else {
			$seksi_penemu = NULL;
		}
		if (!empty($this->input->post('txtStatus'))) {
			$status = $this->input->post('txtStatus');
		} else {
			$status = NULL;
		}
		if (!empty($txtSeksiPenanggungJawab)) {
			$seksi_penanggungjawab = $txtSeksiPenanggungJawab;
		} else {
			$seksi_penanggungjawab = NULL;
		}
		if (!empty($this->input->post('txtJumlah'))) {
			$jumlah = $this->input->post('txtJumlah');
		} else {
			$jumlah = NULL;
		}
		if (!empty($this->input->post('tglDistr'))) {
			$tgl_distr2 = $this->input->post('tglDistr');
			$tgl_distr = date('Y-m-d', strtotime($tgl_distr2));
		} else {
			$tgl_distr = NULL;
		}
		if (!empty($this->input->post('tglKirim'))) {
			$tgl_kirim2 = $this->input->post('tglKirim');
			$tgl_kirim = date('Y-m-d', strtotime($tgl_kirim2));
		} else {
			$tgl_kirim = NULL;
		}
		if (!empty($this->input->post('txtDueDateActCar'))) {
			$due_date2 = $this->input->post('txtDueDateActCar');
			$due_date = date('Y-m-d', strtotime($due_date2));
		} else {
			$due_date = NULL;
		}
		if (!empty($this->input->post('txtMeth'))) {
			$metode = $this->input->post('txtMeth');
		} else {
			$metode = NULL;
		}
		if (!empty($this->input->post('txtQC'))) {
			$status_fo = $this->input->post('txtQC');
		} else {
			$status_fo = NULL;
		}
		if (!empty($this->input->post('txtPoss'))) {
			$possible_fail = $this->input->post('txtPoss');
		} else {
			$possible_fail = NULL;
		}

		$dataInt = array(
			'component_code_int'	=> $component_code_int,
			'component_name'		=> $component_name,
			'type'					=> $type,
			'tanggal'				=> $tanggal,
			'kronologi_p'			=> $kronologi_p,
			'seksi_penemu'			=> $seksi_penemu,
			'status'				=> $status,
			'seksi_penanggungjawab'	=> $seksi_penanggungjawab,
			'jumlah'				=> $jumlah,
			'tgl_distr'				=> $tgl_distr,
			'tgl_kirim'				=> $tgl_kirim,
			'due_date'				=> $due_date,
			'metode'				=> $metode,
			'upload_qr'				=> $newfilenameQr,
			'upload_car'			=> $newfilenameCar,
			'status_fo'				=> $status_fo,
			'possible_fail'			=> $possible_fail,
			'dater'					=> date("Y-m-d H:i:s")
		);
		$this->M_internal->updateInternal($id, $dataInt);

		$noUrut = $this->input->post('hdnNomorUrut[]');

		for ($i = 0; $i < sizeof($noUrut); $i++) {
			$id_uq[$i] = $this->input->post('txtId[' . $i . ']');
			$duedate[$i] = date('Y-m-d', strtotime($this->input->post('txtVerDueDate[' . $i . ']')));
			$real[$i] = date('Y-m-d', strtotime($this->input->post('txtRealisasi[' . $i . ']')));
			$pic[$i] = $this->input->post('txtPic[' . $i . ']');
			$catatan[$i] = $this->input->post('txtCat[' . $i . ']');

			if ($pic[$i]) {
				if ($id_uq[$i] == NULL || $id_uq[$i] == '') {
					$this->M_internal->insQi(
						$duedate[$i],
						$real[$i],
						$pic[$i],
						$catatan[$i],
						$id
					);
				} else {
					$this->M_internal->updateQi(
						$duedate[$i],
						$real[$i],
						$pic[$i],
						$catatan[$i],
						$id,
						$id_uq[$i]
					);
				}
			} else { }
		}
		redirect(base_url('MonitoringFlowOut/InternalView'));
	}

	function delQi($id)
	{
		$this->M_internal->delQi($id);
		echo 1;
	}

	public function Grafik()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Grafik';
		$data['Menu'] = 'Grafik';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringFlowOut/Master/V_Grafik', $data);
		$this->load->view('V_Footer', $data);
	}

	public function DataGrafikMFO()
	{
		$monthGraf = $_POST["monthGraf"];
		$yearGraf = $_POST["yearGraf"];

		$data['perSeksi'] = $this->M_internal->disBySeksi($monthGraf, $yearGraf);
		
		$duata['count'] = array();
		$duata['seksi'] = array();

		foreach ($data['perSeksi'] as $nilai) {
			array_push($duata['count'], $nilai['count']);
			array_push($duata['seksi'], $nilai['seksi_penanggungjawab']);
		}

		echo json_encode($duata);
	}
	
	public function ExportInt() {
		$tglAwal = $this->input->post('txtTglMFO1');
		$tglAkhir = $this->input->post('txtTglMFO2');
		$seksi = $this->input->post('seksi2');

		if ($tglAwal){
			$dataSelected = $this->M_internal->sortByDate(
				date('Y-m-d', strtotime($tglAwal)),
				date('Y-m-d', strtotime($tglAkhir)),
				$seksi
			);
		} else {
			$dataAll = $this->M_internal->getInternal();
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
		$worksheet->mergeCells('A1:K3');

		$worksheet->getColumnDimension('A')->setWidth(5); //Mo
		$worksheet->getColumnDimension('B')->setWidth(20); //Seksi Penemu
		$worksheet->getColumnDimension('C')->setWidth(15); //Tgl
		$worksheet->getColumnDimension('D')->setWidth(25); //Type
		$worksheet->getColumnDimension('E')->setWidth(35); //Komponen
		$worksheet->getColumnDimension('F')->setWidth(40); //Kasus
		$worksheet->getColumnDimension('G')->setWidth(20); //PossFail
		$worksheet->getColumnDimension('H')->setWidth(5); //Qr
		$worksheet->getColumnDimension('I')->setWidth(5); //Car
		$worksheet->getColumnDimension('J')->setWidth(20); //Seksi PJ
		$worksheet->getColumnDimension('K')->setWidth(15); //Status

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

		$worksheet->getStyle('A4:K4')->applyFromArray(array (
			'font' => array (
				'bold'  => true,
				'color' => array('rgb' => '000000')
			)
		));

		$worksheet->getStyle('A5:K5')->applyFromArray(array(
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

		$worksheet->setCellValue('A1', 'REKAPITULASI FLOW OUT INTERNAL');
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
		$worksheet->setCellValue('G5', 'POSSIBLE FAILURE');
		$worksheet->setCellValue('H5', 'QR');
		$worksheet->setCellValue('I5', 'CAR');
		$worksheet->setCellValue('J5', 'SEKSI PJ');
		$worksheet->setCellValue('K5', 'STATUS');

		//Content
		$highestRow = 6;
		$nomor = 1;

		if ($tglAwal){
			for ($i=0; $i < sizeof($dataSelected); $i++) { 
				$worksheet->setCellValue('A' . $highestRow, $nomor)->getStyle('A' . $highestRow)->applyFromArray($MidCenter);
				$worksheet->setCellValue('B' . $highestRow, $dataSelected[$i]['seksi_penemu'])->getStyle('B' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('C' . $highestRow, date('d-m-Y', strtotime($dataSelected[$i]['tanggal'])))->getStyle('C' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('D' . $highestRow, $dataSelected[$i]['type'])->getStyle('D' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('E' . $highestRow, $dataSelected[$i]['component_name'])->getStyle('E' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('F' . $highestRow, $dataSelected[$i]['kronologi_p'])->getStyle('F' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('G' . $highestRow, $dataSelected[$i]['possible_fail'])->getStyle('G' . $highestRow)->applyFromArray($cont);
				if (empty($dataSelected[$i]['upload_qr'])){
					$worksheet->setCellValue('H' . $highestRow, '×')->getStyle('H' . $highestRow)->applyFromArray($MidCenter);
				} else {
					$worksheet->setCellValue('H' . $highestRow, '✓')->getStyle('H' . $highestRow)->applyFromArray($MidCenter);
				}

				if (empty($dataSelected[$i]['upload_car'])){
					$worksheet->setCellValue('I' . $highestRow, '×')->getStyle('I' . $highestRow)->applyFromArray($MidCenter);
				} else {
					$worksheet->setCellValue('I' . $highestRow, '✓')->getStyle('I' . $highestRow)->applyFromArray($MidCenter);
				}
				$worksheet->setCellValue('J' . $highestRow, $dataSelected[$i]['seksi_penanggungjawab'])->getStyle('J' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('K' . $highestRow, $dataSelected[$i]['status'])->getStyle('K' . $highestRow)->applyFromArray($cont);
				
				$highestRow++;
				$nomor++;
			}
		} else {
			for ($i=0; $i < sizeof($dataAll); $i++) { 
				$worksheet->setCellValue('A' . $highestRow, $nomor)->getStyle('A' . $highestRow)->applyFromArray($MidCenter);
				$worksheet->setCellValue('B' . $highestRow, $dataAll[$i]['seksi_penemu'])->getStyle('B' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('C' . $highestRow, date('d-m-Y', strtotime($dataAll[$i]['tanggal'])))->getStyle('C' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('D' . $highestRow, $dataAll[$i]['type'])->getStyle('D' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('E' . $highestRow, $dataAll[$i]['component_name'])->getStyle('E' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('F' . $highestRow, $dataAll[$i]['kronologi_p'])->getStyle('F' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('G' . $highestRow, $dataAll[$i]['possible_fail'])->getStyle('G' . $highestRow)->applyFromArray($cont);
				if (empty($dataAll[$i]['upload_qr'])){
					$worksheet->setCellValue('H' . $highestRow, '×')->getStyle('H' . $highestRow)->applyFromArray($MidCenter);
				} else {
					$worksheet->setCellValue('H' . $highestRow, '✓')->getStyle('H' . $highestRow)->applyFromArray($MidCenter);
				}

				if (empty($dataAll[$i]['upload_car'])){
					$worksheet->setCellValue('I' . $highestRow, '×')->getStyle('I' . $highestRow)->applyFromArray($MidCenter);
				} else {
					$worksheet->setCellValue('I' . $highestRow, '✓')->getStyle('I' . $highestRow)->applyFromArray($MidCenter);
				}
				$worksheet->setCellValue('J' . $highestRow, $dataAll[$i]['seksi_penanggungjawab'])->getStyle('J' . $highestRow)->applyFromArray($cont);
				$worksheet->setCellValue('K' . $highestRow, $dataAll[$i]['status'])->getStyle('K' . $highestRow)->applyFromArray($cont);
				
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
		$worksheet->setTitle('Internal');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REKAPITULASI FLOW OUT INTERNAL ' . date('d-m-Y') . '.xls"');
		$objWriter->save("php://output");
	}
}
