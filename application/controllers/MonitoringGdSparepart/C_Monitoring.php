<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
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
		$this->load->model('MonitoringGdSparepart/M_monitoring');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// menampilkan semua data
		$date = date('d/m/Y', strtotime('-1 days'));
		$date2 = date('d/m/Y');
		$dataTampil = $this->M_monitoring->tampilsemua($date, $date2);
		
		// pengelompokan data
		$a= 0;
		$array_sudah = array();
		$array_terkelompok = array();
		foreach ($dataTampil as $key => $value) {
			if (!in_array($value['NO_DOCUMENT'], $array_sudah)) {
				array_push($array_sudah, $value['NO_DOCUMENT']);
				// if ($no_document[$a] == $value['NO_DOCUMENT']) {
					$cari = $this->pencarian($value);
					$getBody = $cari['getbody'];
					$gdAsal = $cari['asal'];
					$status = $cari['status'];
				$a++;
				$array_terkelompok[$value['NO_DOCUMENT']]['header'] = $value; 
				$array_terkelompok[$value['NO_DOCUMENT']]['header']['statusket'] = $status; 
				$array_terkelompok[$value['NO_DOCUMENT']]['header']['gd_asal'] = $gdAsal; 
				$array_terkelompok[$value['NO_DOCUMENT']]['body'] = $getBody; 
				}
			}	

		$data['value'] = $array_terkelompok;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringGdSparepart/V_Monitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getPIC(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoring->getPIC($term);
		echo json_encode($data);
	}

	public function search() {
		$search			= $this->input->post('search_by');
		$no_document	= $this->input->post('no_document');
		$jenis_dokumen	= $this->input->post('jenis_dokumen');
		$tglAwal		= $this->input->post('tglAwal');
		$tglAkhir		= $this->input->post('tglAkhir');
		$pic			= $this->input->post('pic');
		$item			= $this->input->post('item');

		if ($search == 'export') {		// jika search by export excel
			$dataGET = $this->M_monitoring->getExport($jenis_dokumen, $tglAwal, $tglAkhir);
			
			// pengelompokan data export
			$a= 0;
			$array_sudah = array();
			$array_terkelompok = array();
			foreach ($dataGET as $key => $value) {
				if (!in_array($value['NO_DOCUMENT'], $array_sudah)) {
					array_push($array_sudah, $value['NO_DOCUMENT']);
						$cari = $this->pencarian($value);
						$getBody = $cari['getbody'];
						$gdAsal = $cari['asal'];
						$status = $cari['status'];
					$a++;
				$array_terkelompok[$value['NO_DOCUMENT']]['header'] = $value; 
				$array_terkelompok[$value['NO_DOCUMENT']]['header']['statusket'] = $status; 
				$array_terkelompok[$value['NO_DOCUMENT']]['header']['gd_asal'] = $gdAsal; 
				$array_terkelompok[$value['NO_DOCUMENT']]['body'] = $getBody; 
				}
			}	
			$data['value'] = $array_terkelompok;

		}else{
			$dataGET = $this->M_monitoring->getSearch($no_document, $jenis_dokumen, $tglAwal, $tglAkhir, $pic, $item);				
			// echo "<pre>"; 
			// print_r($dataGET); exit();
			// pengelompokan data
			$array_sudah = array();
			$array_terkelompok = array();
			foreach ($dataGET as $key => $value) {
				if (!in_array($value['NO_DOCUMENT'], $array_sudah)) {
					array_push($array_sudah, $value['NO_DOCUMENT']);
					if ($no_document == $value['NO_DOCUMENT']) {
						$getBody = $dataGET;
						$cari = $this->pencarian($value);
						$gdAsal = $cari['asal'];
						$status = $cari['status'];
					}else {
						$getBody = $this->M_monitoring->getSearch($value['NO_DOCUMENT'], $jenis_dokumen,  $tglAwal, $tglAkhir, $pic, $item);
						$cari = $this->pencarian($value);
						$gdAsal = $cari['asal'];
						$status = $cari['status'];
					}
					if ($status == 'Sudah terlayani' && $search == 'belumterlayani') {
						
					}else {
						$array_terkelompok[$value['NO_DOCUMENT']]['header'] = $value; 
						$array_terkelompok[$value['NO_DOCUMENT']]['header']['statusket'] = $status; 
						$array_terkelompok[$value['NO_DOCUMENT']]['header']['gd_asal'] = $gdAsal; 
						$array_terkelompok[$value['NO_DOCUMENT']]['body'] = $getBody; 
					}
				}
			}
			$data['value'] = $array_terkelompok;
		}
		if ($search == "belumterlayani") {
			$this->load->view('MonitoringGdSparepart/V_Result2', $data);
		}else{
			$this->load->view('MonitoringGdSparepart/V_Result', $data);
		}
	}

	public function pencarian($value){
		$cari = array();
		$cari['getbody'] = $this->M_monitoring->tampilbody($value['NO_DOCUMENT']);
		if ($value['JENIS_DOKUMEN'] == 'IO') {
			$getKet = $this->M_monitoring->getKet($value['NO_DOCUMENT']);
			$gudang = $this->M_monitoring->gdAsalIO($value['NO_DOCUMENT']);
			if (empty($gudang)) {
				$cari['asal'] = '';
			}else {
				$cari['asal'] = $gudang[0]['GUDANG_ASAL'];
			}
		}else if ($value['JENIS_DOKUMEN'] == 'LPPB') {
			$getKet = $this->M_monitoring->getKetLPPB($value['NO_DOCUMENT']);
			$cari['asal'] = 'PPB';
		}else if($value['JENIS_DOKUMEN'] == 'KIB'){
			$cek = $this->M_monitoring->cariKib($value['NO_DOCUMENT']);
			if (!empty($cek)) {
				$getKet = $this->M_monitoring->getKetKIB($value['NO_DOCUMENT']);
			}else {
				$getKet = $cari['getbody'];
			}
			$gudang = $this->M_monitoring->gdAsalKIB($value['NO_DOCUMENT']);
			if (empty($gudang)) {
				$cari['asal'] = '';
			}else {
				$cari['asal'] = $gudang[0]['SUBINVENTORY_CODE'];
			}
		}elseif ($value['JENIS_DOKUMEN'] == 'FPB') {
			$gudang = $this->M_monitoring->getKetFPB($value['NO_DOCUMENT']);
			if (empty($gudang)) {
				$cari['asal'] = '';
				$cari['status'] = '';
			}else {
				$cari['asal'] = $gudang[0]['SEKSI_KIRIM'];
				$cari['status'] = $gudang[0]['STATUS'] == 5 ? 'Belum terlayani' : 
									($gudang[0]['STATUS'] == 6 ? 'Sudah terlayani' : 'Sedang dibuat')
				;
			}
		}
		if ($value['JENIS_DOKUMEN'] != 'FPB') {
			$hitung_bd = count($cari['getbody']);
			$hitung_ket = count($getKet);
			if ($hitung_bd <= $hitung_ket) {
				$cari['status']= 'Sudah terlayani';
			} else {
				$cari['status'] = 'Belum terlayani';
			}
		}
		
		return $cari;
	}


	public function getUpdate(){
		if ($_POST['action'] == 'Export') {		
			$tanggal 	= $this->input->post('tanggal[]');
			$no_dokumen = $this->input->post('doc[]');
			$jenis_doc 	= $this->input->post('jenis[]');
			$kode 		= $this->input->post('item[]');
			$nama_brg 	= $this->input->post('nama_brg[]');
			$qty 		= $this->input->post('qty[]');
			$satuan 	= $this->input->post('uom[]');
			$jok 		= $this->input->post('qty_ok[]');
			$not 		= $this->input->post('qty_not[]');
			$asal 		= $this->input->post('gd_asal[]');
			$ket 		= $this->input->post('ketr[]');
			$action 	= $this->input->post('aktion[]');
			$keterangan	= $this->input->post('ktrgn[]');

			$dataMGS = array();
			for ($i=0; $i < count($kode) ; $i++) { 
				$array = array(
					'tanggal'		=> $tanggal[$i],
					'no_dokumen' 	=> $no_dokumen[$i],
					'jenis_doc' 	=> $jenis_doc[$i],
					'kode_barang' 	=> $kode[$i],
					'deskripsi' 	=> $nama_brg[$i],
					'qty' 			=> $qty[$i],
					'satuan' 		=> $satuan[$i],
					'status_ok' 	=> $jok[$i],
					'not_ok' 		=> $not[$i],
					'asal' 			=> $asal[$i],
					'ket' 			=> $ket[$i],
					'action' 		=> $action[$i],
					'keterangan'	=> $keterangan[$i],
				);
				array_push($dataMGS, $array);
			}
			// echo "<pre>"; print_r($dataMGS);exit();

			include APPPATH.'third_party/Excel/PHPExcel.php';
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('CV. KHS')
						->setLastModifiedBy('Quick')
						->setTitle("Monitoring Gudang Sparepart")
						->setSubject("CV. KHS")
						->setDescription("Monitoring Gudang Sparepart")
						->setKeywords("MGS");
			//style
			$style_title = array(
				'font' => array(
					'bold' => true,
					'size' => 15
				), 
				'alignment' => array(
					'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
			);
			$style_col = array(
				'font' => array('bold' => true), 
				'alignment' => array(
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'			=> true
				),
				'borders' => array(
					'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);
			$style_row = array(
				'alignment' => array(
					'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER, 
					'wrap'		=> true
				),
				'borders' => array(
					'top' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'bottom'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'left'		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);
			$style2 = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'		 => true
				),
				'borders' => array(
					'top' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Monitoring Gudang Sparepart"); 
			$excel->getActiveSheet()->mergeCells('A1:N1'); 
			$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "TANGGAL");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "NO. DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS DOKUMEN");
			$excel->setActiveSheetIndex(0)->setCellValue('E3', "KODE BARANG");
			$excel->setActiveSheetIndex(0)->setCellValue('F3', "NAMA BARANG");
			$excel->setActiveSheetIndex(0)->setCellValue('G3', "JUMLAH");
			$excel->setActiveSheetIndex(0)->setCellValue('H3', "SATUAN");
			$excel->setActiveSheetIndex(0)->setCellValue('I3', "STATUS");
			$excel->setActiveSheetIndex(0)->setCellValue('I4', "OK");
			$excel->setActiveSheetIndex(0)->setCellValue('J4', "NOT OK");
			$excel->setActiveSheetIndex(0)->setCellValue('K4', "KETERANGAN");
			$excel->setActiveSheetIndex(0)->setCellValue('L3', "ASAL");
			$excel->setActiveSheetIndex(0)->setCellValue('M3', "ACTION");
			$excel->setActiveSheetIndex(0)->setCellValue('N3', "KETERANGAN");
			$excel->getActiveSheet()->mergeCells('A3:A4'); 
			$excel->getActiveSheet()->mergeCells('B3:B4'); 
			$excel->getActiveSheet()->mergeCells('C3:C4'); 
			$excel->getActiveSheet()->mergeCells('D3:D4'); 
			$excel->getActiveSheet()->mergeCells('E3:E4'); 
			$excel->getActiveSheet()->mergeCells('F3:F4'); 
			$excel->getActiveSheet()->mergeCells('G3:G4'); 
			$excel->getActiveSheet()->mergeCells('H3:H4'); 
			$excel->getActiveSheet()->mergeCells('I3:K3'); 
			$excel->getActiveSheet()->mergeCells('L3:L4'); 
			$excel->getActiveSheet()->mergeCells('M3:M4'); 
			$excel->getActiveSheet()->mergeCells('N3:N4'); 

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);

			if (count($dataMGS) == 0){
				$excel->setActiveSheetIndex(0)->setCellValue('A3');
				$excel->setActiveSheetIndex(0)->setCellValue('B3');
				$excel->setActiveSheetIndex(0)->setCellValue('C3');
				$excel->setActiveSheetIndex(0)->setCellValue('E3');
				$excel->setActiveSheetIndex(0)->setCellValue('F3');
				$excel->setActiveSheetIndex(0)->setCellValue('G3');
				$excel->setActiveSheetIndex(0)->setCellValue('H3');
				$excel->setActiveSheetIndex(0)->setCellValue('I3');
				$excel->setActiveSheetIndex(0)->setCellValue('J3');
				$excel->setActiveSheetIndex(0)->setCellValue('K3');
				$excel->setActiveSheetIndex(0)->setCellValue('L3');
				$excel->setActiveSheetIndex(0)->setCellValue('M3');
				$excel->setActiveSheetIndex(0)->setCellValue('N3');

				$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
				$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
			}else {
				$no=1;
				$numrow = 5;
					foreach ($dataMGS as $dM) {	
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $dM['tanggal']);
						$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $dM['no_dokumen']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $dM['jenis_doc']);
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $dM['kode_barang']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $dM['deskripsi']);
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $dM['qty']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $dM['satuan']);
						$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $dM['status_ok']);
						$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $dM['not_ok']);
						$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $dM['ket']);
						$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $dM['asal']);
						$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $dM['action']);
						$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $dM['keterangan']);

						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
						$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style2);
					$numrow++;
					$no++; 
					}
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(13); 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(17); 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

			// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			// Set orientasi kertas jadi LANDSCAPE
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			// Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Monitoring Gudang Sparepart");
			$excel->setActiveSheetIndex(0);
			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Monitoring_Gudang_Sparepart.xlsx"'); 
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
			
		} else {
			//invalid action!
		}
		
	}

	public function saveJmlOk(){
		$jml_ok = $this->input->post('jml_ok');
		$item = $this->input->post('item');
		$doc 	= $this->input->post('doc');

		$query = "set JML_OK = '$jml_ok'";
		$this->M_monitoring->dataUpdate($item, $query, $doc);
	}

	public function saveNotOk(){
		$jml_not_ok = $this->input->post('jml_not_ok');
		$item = $this->input->post('item');
		$doc 	= $this->input->post('doc');
		
		$query = "set JML_NOT_OK = '$jml_not_ok'";
		$this->M_monitoring->dataUpdate($item, $query, $doc);
	}

	public function saveKetr(){
		$ket = $this->input->post('ket');
		$item = $this->input->post('item');
		$doc 	= $this->input->post('doc');
		
		$query = "set KETERANGAN = '$ket'";
		$this->M_monitoring->dataUpdate($item, $query, $doc);
	}

	public function saveAction(){
		$action = $this->input->post('action');
		$item = $this->input->post('item');
		$doc 	= $this->input->post('doc');
		
		$query = "set ACTION = '$action'";
		$this->M_monitoring->dataUpdate($item, $query, $doc);
	}
	
}