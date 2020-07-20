<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 *
 */
class C_Rekap extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ADMCabang/M_monitoringpresensi');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		if(!$this->M_monitoringpresensi->getAksesAtasanProduksi($this->session->user)){
			echo "Prohibited";exit();
		}
		$user_id = $this->session->userid;

		$data['Title'] = 'ADM Cabang';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pekerja(){
		if(!$this->M_monitoringpresensi->getAksesAtasanProduksi($this->session->user)){
			echo "Prohibited";exit();
		}
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Per Pekerja';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['status'] = $this->M_monitoringpresensi->statusKerja();
		$data['unit'] = $this->M_monitoringpresensi->ambilUnit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/Rekap/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getData(){
		$tanggalAwal = $this->input->post('tanggalAwal');
		$tanggalAkhir = $this->input->post('tanggalAkhir');
		$kodesie = $this->session->kodesie;
		$statusKerja = $this->input->post('statusKerja[]');
		$unitKerja = $this->input->post('unitKerja');
		$seksiKerja = $this->input->post('seksiKerja');
		if(!empty($statusKerja)){
			$statusKerja = array_map(function($val){
				return "'$val'";
			}, $statusKerja);
			$statusKerja = implode(",", $statusKerja);

			$q_status = "AND left(a.noind,1) IN ($statusKerja) ";
		}else{
			$q_status = "";
		}

		if(!empty($unitKerja)){
			$q_unit = "AND left(a.kodesie,5) = '$unitKerja'";
		}else{
			$q_unit = "";
		}

		if(!empty($seksiKerja)){
			$seksiKerja = explode(' - ', $seksiKerja)[0];
			$q_seksi = "AND left(a.kodesie,7) = '$seksiKerja' ";
		}else{
			$q_seksi = "";
		}

		$data = $this->M_monitoringpresensi->rekapPekerja($tanggalAwal,$tanggalAkhir,$kodesie,$q_status,$q_unit,$q_seksi);
		// echo "<pre>";
		// print_r($data);
		// die;
		print_r(json_encode($data));
	}

	function cetakPDF(){
		ini_set('memory_limit', '256M');
		ini_set('max_execution_time', 300);
		$this->load->library('pdf');
		$tanggalAwal = $this->input->get('tanggalAwal');
		$tanggalAkhir = $this->input->get('tanggalAkhir');

		$diff = abs(strtotime($tanggalAkhir) - strtotime($tanggalAwal));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)) + 1;

		$statusKerja = $this->input->get('statusKerja');
		$unitKerja = $this->input->get('unitKerja');
		$seksiKerja = $this->input->get('seksiKerja');
		if($statusKerja != "empty"){
			$statusKerja = explode(',', $statusKerja);
			$statusKerja = array_map(function($val){
				return "'$val'";
			}, $statusKerja);
			$statusKerja = implode(",", $statusKerja);

			$q_status = "AND left(a.noind,1) IN ($statusKerja) ";
		}else{
			$q_status = "";
		}

		if(!empty($unitKerja) and $unitKerja != ""){
			$q_unit = "AND left(a.kodesie,5) = '$unitKerja'";
		}else{
			$q_unit = "";
		}

		if(!empty($seksiKerja) and $seksiKerja != ""){
			$seksiKerja = explode(' - ', $seksiKerja)[0];
			$q_seksi = "AND left(a.kodesie,7) = '$seksiKerja' ";
		}else{
			$q_seksi = "";
		}


		$kodesie = $this->session->kodesie;

		$data['data'] = $this->M_monitoringpresensi->rekapPekerja($tanggalAwal,$tanggalAkhir,$kodesie,$q_status,$q_unit,$q_seksi);
		$data['days'] = $days;

		$formatTglAwal = date('d_F_Y',strtotime($tanggalAwal));
    	$formatTglAkhir = date('d_F_Y',strtotime($tanggalAkhir));

		// echo "<pre>";
		// print_r($data);exit();
		$pdf = $this->pdf->load();
		$pdf = new mPDF('', 'A4-L', 0, '', 10, 10, 10, 10, 5, 5);
		$html 	= $this->load->view('ADMCabang/Rekap/V_RekapPDF',$data,true);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet,1);
		$pdf->AddPage();

		$pdf->WriteHTML($html,2);
		$pdf->Output('rekapPekerja_'.$formatTglAwal.'-'.$formatTglAkhir.'.pdf','I');
		$pdf->set_time_limit(0);

	}

	function cetakExcel(){
		$this->load->library('Excel');
		$tanggalAwal = $this->input->get('tanggalAwal');
		$tanggalAkhir = $this->input->get('tanggalAkhir');

		$diff = abs(strtotime($tanggalAkhir) - strtotime($tanggalAwal));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)) + 1;

		$statusKerja = $this->input->get('statusKerja');
		$unitKerja = $this->input->get('unitKerja');
		$seksiKerja = $this->input->get('seksiKerja');
		if($statusKerja != "empty"){
			$statusKerja = explode(',', $statusKerja);
			$statusKerja = array_map(function($val){
				return "'$val'";
			}, $statusKerja);
			$statusKerja = implode(",", $statusKerja);

			$q_status = "AND left(a.noind,1) IN ($statusKerja) ";
		}else{
			$q_status = "";
		}

		if(!empty($unitKerja) and $unitKerja != ""){
			$q_unit = "AND left(a.kodesie,5) = '$unitKerja'";
		}else{
			$q_unit = "";
		}

		if(!empty($seksiKerja) and $seksiKerja != ""){
			$seksiKerja = explode(' - ', $seksiKerja)[0];
			$q_seksi = "AND left(a.kodesie,7) = '$seksiKerja' ";
		}else{
			$q_seksi = "";
		}


		$kodesie = $this->session->kodesie;

		$data = $this->M_monitoringpresensi->rekapPekerja($tanggalAwal,$tanggalAkhir,$kodesie,$q_status,$q_unit,$q_seksi);

		// echo "<pre>";
		// print_r($data);exit();

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

		$worksheet->getStyle('A3:L3')->applyFromArray($thead);
		$worksheet->getStyle('A3:L3')->applyFromArray($borderleft);
		$worksheet->getStyle('A3')->applyFromArray($borderright);
		$worksheet->getStyle('B3')->applyFromArray($borderright);
		$worksheet->getStyle('C3')->applyFromArray($borderright);
		$worksheet->getStyle('D3')->applyFromArray($borderright);
		$worksheet->getStyle('E3')->applyFromArray($borderright);
		$worksheet->getStyle('F3')->applyFromArray($borderright);
		$worksheet->getStyle('G3')->applyFromArray($borderright);
		$worksheet->getStyle('H3')->applyFromArray($borderright);
		$worksheet->getStyle('I3')->applyFromArray($borderright);
		$worksheet->getStyle('J3')->applyFromArray($borderright);
		$worksheet->getStyle('K3')->applyFromArray($borderright);
		$worksheet->getStyle('L3')->applyFromArray($borderright);
		$worksheet->getStyle('A3:L3')->applyFromArray($bordertop);
		$worksheet->getStyle('A3:L3')->applyFromArray($borderbottom);



		//Width
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);

		$sheet->setTitle('Sheet1');
		$sheet->setCellValue('A3','No');
		$sheet->setCellValue('B3','Nomor Induk');
		$sheet->setCellValue('C3','Nama');
		$sheet->setCellValue('D3','Seksi');
		$sheet->setCellValue('E3','Jumlah Terlambat');
		$sheet->setCellValue('F3','Jumlah Izin Pribadi');
		$sheet->setCellValue('G3','Jumlah Mangkir');
		$sheet->setCellValue('H3','Jumlah Sakit');
		$sheet->setCellValue('I3','Jumlah Izin Pamit (Cuti)');
		$sheet->setCellValue('J3','Jumlah Izin Perusahaan');
		$sheet->setCellValue('K3','Jumlah Kehadiran');
		$sheet->setCellValue('L3','Persentase Kehadiran');

		$i = 3;
		$nomor = 0;
		$persentaseKehadiran = 0;
		foreach ($data as $key => $value) {
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
			$kolomJ='J'.$i;
			$kolomK='K'.$i;
			$kolomL='L'.$i;

			$persentaseKehadiran = round(((intval($value['bekerja']) - intval($value['izin_pribadi']) ) / $days * 100),2);
			// $persentaseKehadiran = round(($value['bekerja'] / $days * 100),2);

			$sheet  ->setCellValueExplicit($kolomA, $nomor, PHPExcel_Cell_DataType::TYPE_NUMERIC)
					->setCellValueExplicit($kolomB, $value['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomC, rtrim($value['nama']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomD, $value['seksi'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomE, $value['terlambat'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomF, $value['izin_pribadi'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomG, $value['mangkir'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomH, $value['sakit'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomI, $value['izin_pamit'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomJ, $value['izin_perusahaan'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomK, $value['bekerja'] , PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomL, $persentaseKehadiran.' % ' , PHPExcel_Cell_DataType::TYPE_STRING);

		$worksheet->getStyle($kolomA)->applyFromArray($alignment);
		$worksheet->getStyle($kolomB)->applyFromArray($alignment);
		$worksheet->getStyle($kolomD)->applyFromArray($alignment);
		$worksheet->getStyle($kolomA.':'.$kolomL)->applyFromArray($tdata);


		$worksheet->getStyle($kolomA)->applyFromArray($borderleft);$worksheet->getStyle($kolomA)->applyFromArray($borderright);
		$worksheet->getStyle($kolomB)->applyFromArray($borderleft);$worksheet->getStyle($kolomB)->applyFromArray($borderright);
		$worksheet->getStyle($kolomC)->applyFromArray($borderleft);$worksheet->getStyle($kolomC)->applyFromArray($borderright);
		$worksheet->getStyle($kolomD)->applyFromArray($borderleft);$worksheet->getStyle($kolomD)->applyFromArray($borderright);
		$worksheet->getStyle($kolomE)->applyFromArray($borderleft);$worksheet->getStyle($kolomE)->applyFromArray($borderright);
		$worksheet->getStyle($kolomF)->applyFromArray($borderleft);$worksheet->getStyle($kolomF)->applyFromArray($borderright);
		$worksheet->getStyle($kolomG)->applyFromArray($borderleft);$worksheet->getStyle($kolomG)->applyFromArray($borderright);
		$worksheet->getStyle($kolomH)->applyFromArray($borderleft);$worksheet->getStyle($kolomH)->applyFromArray($borderright);
		$worksheet->getStyle($kolomI)->applyFromArray($borderleft);$worksheet->getStyle($kolomI)->applyFromArray($borderright);
		$worksheet->getStyle($kolomJ)->applyFromArray($borderleft);$worksheet->getStyle($kolomJ)->applyFromArray($borderright);
		$worksheet->getStyle($kolomK)->applyFromArray($borderleft);$worksheet->getStyle($kolomK)->applyFromArray($borderright);
		$worksheet->getStyle($kolomL)->applyFromArray($borderleft);$worksheet->getStyle($kolomL)->applyFromArray($borderright);

		$worksheet->getStyle($kolomA)->applyFromArray($borderbottom);$worksheet->getStyle($kolomA)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomB)->applyFromArray($borderbottom);$worksheet->getStyle($kolomB)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomC)->applyFromArray($borderbottom);$worksheet->getStyle($kolomC)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomD)->applyFromArray($borderbottom);$worksheet->getStyle($kolomD)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomE)->applyFromArray($borderbottom);$worksheet->getStyle($kolomE)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomF)->applyFromArray($borderbottom);$worksheet->getStyle($kolomF)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomG)->applyFromArray($borderbottom);$worksheet->getStyle($kolomG)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomH)->applyFromArray($borderbottom);$worksheet->getStyle($kolomH)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomI)->applyFromArray($borderbottom);$worksheet->getStyle($kolomI)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomJ)->applyFromArray($borderbottom);$worksheet->getStyle($kolomJ)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomK)->applyFromArray($borderbottom);$worksheet->getStyle($kolomK)->applyFromArray($bordertop);
		$worksheet->getStyle($kolomL)->applyFromArray($borderbottom);$worksheet->getStyle($kolomL)->applyFromArray($bordertop);
		}
		// $worksheet->getStyle('E4:'.$kolomI)->getAlignment()
  //   										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    	$formatTglAwal = date('d_F_Y',strtotime($tanggalAwal));
    	$formatTglAkhir = date('d_F_Y',strtotime($tanggalAkhir));


		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=rekapPekerja_".$formatTglAwal." - ".$formatTglAkhir.".xls");
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

	function getGrafik(){
		$noinduk = $this->input->get('noinduk');
		$tanggalAwal = $this->input->get('tanggalAwal');
		$tanggalAkhir = $this->input->get('tanggalAkhir');
		$kodesie = $this->session->kodesie;


		$dt = $this->M_monitoringpresensi->getGrafikPiePerPekerja($noinduk,$tanggalAwal,$tanggalAkhir,$kodesie);

		$label = array();
		$presensi = array();
		$tanggalPresensi = array();
		$dt[0]['bekerja'] -= $dt[0]['izin_pribadi'];
		foreach ($dt[0] as $key => $value) {
			if($key != "noind" and $key != "nama" and $key != "seksi" and $key != "masukkerja" and $key != "tgl_izin_pribadi" and $key != "tgl_mangkir" and $key != "tgl_sakit" and $key != "tgl_izin_pamit" and $key != "tgl_izin_perusahaan" and $key != "tgl_terlambat" and $key != "tgl_bekerja"){
				if($key == "terlambat")
					$key = "Terlambat";
				if($key == "izin_pribadi")
					$key = "Izin Pribadi";
				if($key == "mangkir")
					$key = "Mangkir";
				if($key == "sakit")
					$key = "Sakit";
				if($key == "izin_pamit")
					$key = "Izin Pamit (Cuti)";
				if($key == "bekerja")
					$key = "Bekerja";
				if($key == "izin_perusahaan")
					$key = "Izin Perusahaan";
				$label[] = $key;

				$presensi[] = $value;
			}
				$tanggalPresensi[$key] = $value;


		}
		$tglBekerja = explode(' , ', $tanggalPresensi['tgl_bekerja']);
		$tglIzinPribadi = explode(' , ', $tanggalPresensi['tgl_izin_pribadi']);
		foreach ($tglBekerja as $key => $bkj) {
			foreach ($tglIzinPribadi as $key => $izinPribadi) {
				if($bkj == $izinPribadi){
					unset($tglBekerja[array_search($bkj, $tglBekerja)]);
				}
			}
		}
		$tglBekerja = array_values($tglBekerja);
		$tglBekerja = implode(' , ', $tglBekerja);

		$tanggalPresensi['tgl_bekerja'] = $tglBekerja;
		$data['inf'] = $dt[0];
		$data['label'] = $label;
		$data['data'] = $presensi;
		$data['tanggalPresensi'] = $tanggalPresensi;
		print_r(json_encode($data));
	}
}
?>
