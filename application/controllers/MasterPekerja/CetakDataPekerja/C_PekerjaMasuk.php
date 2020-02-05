<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_PekerjaMasuk extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('pdf');

		$this->load->model('MasterPekerja/CetakDataPekerja/M_datapekerja');
		$pdf 	=	$this->pdf->load();
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	function getPetugas(){
		$keyword = $this->input->get('term');
		$petugas = $this->M_datapekerja->getPetugas($keyword);
		echo json_encode($petugas);
	}

	function getLokasiKerja(){
		$keyword = $this->input->get('term');
		$lokasiKerja = $this->M_datapekerja->getLokasiKerja($keyword);
		echo json_encode($lokasiKerja);
	}

	function index()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/CetakDataPekerja/V_IndexPekerjaMasuk',$data);
		$this->load->view('V_Footer',$data);
	}

	function exportExcel(){
		$this->load->library('Excel');
		$periode 		= $this->input->post('periode');
		$lokasiKerja	= $this->input->post('lokasi');
		$petugas 		= $this->input->post('petugas');

		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Export Excel Data Pekerja Masuk Periode ='.$periode;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$periode 		= explode(' - ', $periode);
		$tanggal_awal 	= $periode[0];
		$tanggal_akhir 	= $periode[1];
		$tanggal_awal	= str_replace('/', '-', $tanggal_awal);
		$tanggal_akhir	= str_replace('/', '-', $tanggal_akhir);
		$tanggal_awal= date('Y-m-d',strtotime($tanggal_awal));
		$tanggal_akhir= date('Y-m-d',strtotime($tanggal_akhir));
		$bulanTahun = date('F Y',strtotime($tanggal_awal));
		$bulan = date('F Y',strtotime($tanggal_awal));
		if(strpos($bulan, 'January') !== false){
			$bulan = str_replace('January', 'Januari', $bulan);
		}
		elseif (strpos($bulan, 'February') !== false) {
			$bulan = str_replace('February', 'Februari', $bulan);
		}
		elseif (strpos($bulan, 'March') !== false) {
			$bulan = str_replace('March', 'Maret', $bulan);
		}
		elseif (strpos($bulan, 'April') !== false) {
			$bulan = str_replace('April', 'April', $bulan);
		}
		elseif (strpos($bulan, 'May') !== false) {
			$bulan = str_replace('May', 'Mei', $bulan);
		}
		elseif (strpos($bulan, 'June') !== false) {
			$bulan = str_replace('June', 'Juni', $bulan);
		}
		elseif (strpos($bulan, 'July') !== false) {
			$bulan = str_replace('July', 'Juli', $bulan);
		}
		elseif (strpos($bulan, 'August') !== false) {
			$bulan = str_replace('August', 'Agustus', $bulan);
		}
		elseif (strpos($bulan, 'September') !== false) {
			$bulan = str_replace('September', 'September', $bulan);
		}
		elseif (strpos($bulan, 'October') !== false) {
			$bulan = str_replace('October', 'Oktober', $bulan);
		}
		elseif (strpos($bulan, 'November') !== false) {
			$bulan = str_replace('November', 'November', $bulan);
		}
		elseif (strpos($bulan, 'December') !== false) {
			$bulan = str_replace('December', 'Desember', $bulan);
		}
		else{
			$bulan = $bulan;
		}


		$kdLokasi 		= explode(' - ', $lokasiKerja)[0];
		$namaLokasi 	= explode(' - ', $lokasiKerja)[1];

		$noindPetugas	= explode(' - ', $petugas)[0];
		$namaPetugas 	= explode(' - ', $petugas)[1];

		$getPekerjaMasuk = $this->M_datapekerja->getPekerjaMasuk($tanggal_awal,$tanggal_akhir,$kdLokasi);
		if($getPekerjaMasuk == FALSE){
			$this->session->set_flashdata('pesan','Tidak Ada Data');
			redirect('MasterPekerja/CetakPekerjaMasuk');
		}else{
		// echo "<pre>";
		// print_r($getPekerjaMasuk);
		// exit();


		$objPHPExcel 	= new PHPExcel();
		$worksheet 		= $objPHPExcel->getActiveSheet();
		$sheet 			= $objPHPExcel->setActiveSheetIndex(0);

		//Style
		$borderleft = array(
		    'borders' => array(
		        'left' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		        ),
		    )
		);
		$borderright = array(
		    'borders' => array(
		        'right' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		        ),
		    )
		);
		$borderbottom = array(
		    'borders' => array(
		        'bottom' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		        ),
		    )
		);
		$bordertop = array(
		    'borders' => array(
		        'top' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		        ),
		    )
		);

		$bold = array(
		    'font'  => array(
		            'bold'  => true,
		            'size'  => 10
		        ),
			'alignment' => array(
		       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			   )
		    );

		$thead = array(
			'font'  => array(
		            'bold'  => true,
		            'size'  => 9
		        ),
			'alignment' => array(
		       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			   )
		    );

		$alignment = array(
			'alignment' => array(
		       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			   )
			);
		$tdata = array(
			'font'  => array(
		            'size'  => 8
		        )
			);
		$tdataKurung = array(
			'font'  => array(
		            'size'  => 8
		        ),
			'alignment' => array(
		       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			   )
			);



		$worksheet->getStyle('A1:A3')->applyFromArray($bold);
		$worksheet->getStyle('A5:I5')->applyFromArray($thead);
		$worksheet->getStyle('A5:I5')->applyFromArray($borderleft);
		$worksheet->getStyle('A5')->applyFromArray($borderright);
		$worksheet->getStyle('B5')->applyFromArray($borderright);
		$worksheet->getStyle('C5')->applyFromArray($borderright);
		$worksheet->getStyle('D5')->applyFromArray($borderright);
		$worksheet->getStyle('E5')->applyFromArray($borderright);
		$worksheet->getStyle('F5')->applyFromArray($borderright);
		$worksheet->getStyle('G5')->applyFromArray($borderright);
		$worksheet->getStyle('H5')->applyFromArray($borderright);
		$worksheet->getStyle('I5')->applyFromArray($borderright);
		$worksheet->getStyle('A5:I5')->applyFromArray($bordertop);
		$worksheet->getStyle('A5:I5')->applyFromArray($borderbottom);

		$worksheet->mergeCells('A1:I1');
		$worksheet->mergeCells('A2:I2');
		$worksheet->mergeCells('A3:I3');

		//Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(30);

		//Value
		$sheet->setTitle('Sheet1');
		$sheet->setCellValue('A1','DATA PEKERJA MASUK CV. KARYA HIDUP SENTOSA');
		$sheet->setCellValue('A2','BULAN '.strtoupper($bulan));
		$sheet->setCellValue('A3','LOKASI KERJA '.$namaLokasi);
		$sheet->setCellValue('A5','NO');
		$sheet->setCellValue('B5','NO INDUK');
		$sheet->setCellValue('C5','NAMA');
		$sheet->setCellValue('D5','TGL.MASUK');
		$sheet->setCellValue('E5','ALAMAT');
		$sheet->setCellValue('F5','DESA');
		$sheet->setCellValue('G5','KECAMATAN');
		$sheet->setCellValue('H5','KABUPATEN');
		$sheet->setCellValue('I5','PROPINSI');

		$i = 5;
		$nomor = 0;
		foreach ($getPekerjaMasuk as $key => $data) {
			$i++;
			$nomor++;

			$kolomA='A'.$i;
			$kolomB='B'.$i;
			$kolomC='C'.$i;
			$kolomD='D'.$i;
			$kolomE='E'.$i;
			$kolomF='F'.$i;
			$kolomG='G'.$i;
			$kolomH='H'.$i;
			$kolomI='I'.$i;


					// ->setCellValueExplicit($kolomC, $data->nama, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit($kolomD, $data->masukkerja, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit($kolomE, $data->alamat, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit($kolomF, $data->desa, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit($kolomG, $data->kec, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit($kolomH, $data->kab, PHPExcel_Cell_DataType::TYPE_STRING)
					// ->setCellValueExplicit($kolomI, $data->prop, PHPExcel_Cell_DataType::TYPE_STRING)

			$sheet  ->setCellValueExplicit($kolomA, $nomor, PHPExcel_Cell_DataType::TYPE_NUMERIC)
					->setCellValueExplicit($kolomB, $data->noind, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomC, rtrim($data->nama), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomD, date('Y-m-d',strtotime($data->masukkerja)), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomE, rtrim($data->alamat), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomF, rtrim($data->desa), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomG, rtrim($data->kec), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomH, rtrim($data->kab), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomI, rtrim($data->prop), PHPExcel_Cell_DataType::TYPE_STRING)
					;
			$worksheet->getStyle($kolomA)->applyFromArray($alignment);
			$worksheet->getStyle($kolomB)->applyFromArray($alignment);
			$worksheet->getStyle($kolomD)->applyFromArray($alignment);
			$worksheet->getStyle($kolomA.':'.$kolomI)->applyFromArray($tdata);

			$worksheet->getStyle($kolomA)->applyFromArray($borderleft);$worksheet->getStyle($kolomA)->applyFromArray($borderright);
			$worksheet->getStyle($kolomB)->applyFromArray($borderleft);$worksheet->getStyle($kolomB)->applyFromArray($borderright);
			$worksheet->getStyle($kolomC)->applyFromArray($borderleft);$worksheet->getStyle($kolomC)->applyFromArray($borderright);
			$worksheet->getStyle($kolomD)->applyFromArray($borderleft);$worksheet->getStyle($kolomD)->applyFromArray($borderright);
			$worksheet->getStyle($kolomE)->applyFromArray($borderleft);$worksheet->getStyle($kolomE)->applyFromArray($borderright);
			$worksheet->getStyle($kolomF)->applyFromArray($borderleft);$worksheet->getStyle($kolomF)->applyFromArray($borderright);
			$worksheet->getStyle($kolomG)->applyFromArray($borderleft);$worksheet->getStyle($kolomG)->applyFromArray($borderright);
			$worksheet->getStyle($kolomH)->applyFromArray($borderleft);$worksheet->getStyle($kolomH)->applyFromArray($borderright);
			$worksheet->getStyle($kolomI)->applyFromArray($borderleft);$worksheet->getStyle($kolomI)->applyFromArray($borderright);

			$worksheet->getStyle($kolomA)->applyFromArray($borderbottom);$worksheet->getStyle($kolomA)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomB)->applyFromArray($borderbottom);$worksheet->getStyle($kolomB)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomC)->applyFromArray($borderbottom);$worksheet->getStyle($kolomC)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomD)->applyFromArray($borderbottom);$worksheet->getStyle($kolomD)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomE)->applyFromArray($borderbottom);$worksheet->getStyle($kolomE)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomF)->applyFromArray($borderbottom);$worksheet->getStyle($kolomF)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomG)->applyFromArray($borderbottom);$worksheet->getStyle($kolomG)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomH)->applyFromArray($borderbottom);$worksheet->getStyle($kolomH)->applyFromArray($bordertop);
			$worksheet->getStyle($kolomI)->applyFromArray($borderbottom);$worksheet->getStyle($kolomI)->applyFromArray($bordertop);


		}

		$sheet->setCellValue('E'.($nomor+9),'Seksi Hubungan Kerja');
		$sheet->setCellValue('G'.($nomor+9),'Penerima Laporan');
		$sheet->setCellValue('E'.($nomor+16),rtrim($namaPetugas));
		$sheet->setCellValue('F'.($nomor+16),'(');
		$sheet->setCellValue('H'.($nomor+16),')');

		$worksheet->getStyle('E'.($nomor+9))->applyFromArray($tdataKurung);
		$worksheet->getStyle('G'.($nomor+9))->applyFromArray($tdataKurung);
		$worksheet->getStyle('E'.($nomor+16))->applyFromArray($tdataKurung);
		$worksheet->getStyle('F'.($nomor+16))->applyFromArray($tdataKurung);
		$worksheet->getStyle('H'.($nomor+16))->applyFromArray($tdataKurung);

		$dateAwal = date_create($tanggal_awal);
		$dateAwal = date_format($dateAwal,'d-M-Y');

		$dateAkhir = date_create($tanggal_akhir);
		$dateAkhir = date_format($dateAkhir,'d-M-Y');

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=RekapDataPekerjaMasuk_".str_replace(' ', '-', $bulan).".xls");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objPHPExcel->getProperties()->setCreator("Sistem")
										 ->setLastModifiedBy("Sistem")
										 ->setTitle("Sistem")
										 ->setSubject("Sistem")
										 ->setDescription("Sistem")
										 ->setKeywords("Sistem")
										 ->setCategory("Sistem");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	}

	function preview(){
		$periode 		= $this->input->post('periode');
		$lokasiKerja	= $this->input->post('lokasi');
		$petugas 		= $this->input->post('petugas');

		$pecah_periode 	= explode(' - ', $periode);
		$tanggal_awal 	= $pecah_periode[0];
		$tanggal_akhir 	= $pecah_periode[1];
		$tanggal_awal	= str_replace('/', '-', $tanggal_awal);
		$tanggal_akhir	= str_replace('/', '-', $tanggal_akhir);
		$tanggal_awal= date('Y-m-d',strtotime($tanggal_awal));
		$tanggal_akhir= date('Y-m-d',strtotime($tanggal_akhir));
		$bulan = date('F Y',strtotime($tanggal_awal));
		if(strpos($bulan, 'January') !== false){
			$bulan = str_replace('January', 'Januari', $bulan);
		}
		elseif (strpos($bulan, 'February') !== false) {
			$bulan = str_replace('February', 'Februari', $bulan);
		}
		elseif (strpos($bulan, 'March') !== false) {
			$bulan = str_replace('March', 'Maret', $bulan);
		}
		elseif (strpos($bulan, 'April') !== false) {
			$bulan = str_replace('April', 'April', $bulan);
		}
		elseif (strpos($bulan, 'May') !== false) {
			$bulan = str_replace('May', 'Mei', $bulan);
		}
		elseif (strpos($bulan, 'June') !== false) {
			$bulan = str_replace('June', 'Juni', $bulan);
		}
		elseif (strpos($bulan, 'July') !== false) {
			$bulan = str_replace('July', 'Juli', $bulan);
		}
		elseif (strpos($bulan, 'August') !== false) {
			$bulan = str_replace('August', 'Agustus', $bulan);
		}
		elseif (strpos($bulan, 'September') !== false) {
			$bulan = str_replace('September', 'September', $bulan);
		}
		elseif (strpos($bulan, 'October') !== false) {
			$bulan = str_replace('October', 'Oktober', $bulan);
		}
		elseif (strpos($bulan, 'November') !== false) {
			$bulan = str_replace('November', 'November', $bulan);
		}
		elseif (strpos($bulan, 'December') !== false) {
			$bulan = str_replace('December', 'Desember', $bulan);
		}
		else{
			$bulan = $bulan;
		}


		$kdLokasi 		= explode(' - ', $lokasiKerja)[0];
		$namaLokasi 	= explode(' - ', $lokasiKerja)[1];

		$getPekerjaMasuk = $this->M_datapekerja->getPekerjaMasuk($tanggal_awal,$tanggal_akhir,$kdLokasi);
		if($getPekerjaMasuk == FALSE){
			$this->session->set_flashdata('pesan','Tidak Ada Data');
			redirect('MasterPekerja/CetakPekerjaMasuk');
		}else{
			$user_id = $this->session->userid;

			$data['Header']			=	'Master Pekerja - Quick ERP';
			$data['Title']			=	'Master Pekerja';
			$data['Menu'] 			= 	'';
			$data['SubMenuOne'] 	= 	'';
			$data['SubMenuTwo'] 	= 	'';

			$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$data['dataPekerja'] = $getPekerjaMasuk;
			$data['bulan']		= $bulan;
			$data['lokasi']		= $namaLokasi;

			$data['periode']		= $periode;
			$data['slclokasi']		= $lokasiKerja;
			$data['petugas']		= $petugas;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/CetakDataPekerja/V_IndexPekerjaMasuk',$data);
			$this->load->view('V_Footer',$data);
		}
	}
}
