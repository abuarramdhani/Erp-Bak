<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Cetak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('CetakKanbanToolRoom/M_cetak');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		$this->load->library('Excel');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakKanbanToolRoom/V_Cetak',$data);
		$this->load->view('V_Footer',$data);

	}
	public function Export(){
		// $filename = 'LayoutCSV_'.date('d-m-Y').'.csv';
		// header("Content-Description: File Transfer");
		// header("Content-Disposition: attachment; filename=$filename");
		// header("Content-Type: application/csv; ");

		// $file = fopen('php://output', 'w');
		// $header = array("KODE_BARANG","DESC","COST_CENTER","NO_BPPCT","JUMLAH_CETAK","ALUR_KANBAN","WARNA_KEPALA_KANBAN","WARNA_BADAN_KANBAN","WARNA_HEADER");
		// fputcsv($file, $header);
		// exit;


		// $filename = 'LayoutCSV_'.date('d-m-Y').'.csv';
		// header("Content-Description: File Transfer");
		// header("Content-Disposition: attachment; filename=$filename");
		// header("Content-Type: application/csv; ");
		// $list = array (
		// 	array("KODE_BARANG","DESC","COST_CENTER","NO_BPPCT","JUMLAH_CETAK","ALUR_KANBAN","WARNA_KEPALA_KANBAN","WARNA_BADAN_KANBAN","WARNA_HEADER"),
		// 	array('MJABATCMTYBC151F','FAMILY LINE STEERING GEAR 1','5C17','193','2','TOOL BOX C-01 / LINE STEERING GEAR 1 ( MACH. C )','SpringGreen','LimeGreen','DeepSkyBlue'),
		// 	array('MJABAWNMGYBC252B','FAMILY LINE STEERING GEAR 1','5C18','193','1','TOOL BOX C-01 / LINE STEERING GEAR 1 ( MACH. C )','Salmon','LightPink','Aqua')
		// );
		// $fp = fopen('php://output', 'w');
		// foreach ($list as $fields) {
		// 	fputcsv($fp, $fields);
		// }
		// fclose($fp);

	require_once APPPATH.'third_party/Excel/PHPExcel.php';
	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

	$objPHPExcel = new PHPExcel();
	$worksheet = $objPHPExcel->getActiveSheet();

	$worksheet->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "KODE_BARANG");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "MJABATCMTYBC151F");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "MJABAWNMGYBC252B");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "MJADGHCD00IC908A");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "DESC");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "FAMILY LINE STEERING GEAR 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "FAMILY LINE STEERING GEAR 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "FAMILY LINE STEERING GEAR 1");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "COST_CENTER");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "5C17");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "5C18");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "5C20");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "NO_BPPCT");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "193");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "193");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "193");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "JUMLAH_CETAK");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "2");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "2");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "1");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "ALUR_KANBAN");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "TOOL BOX C-01 / LINE STEERING GEAR 1 ( MACH. C )");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "TOOL BOX C-01 / LINE STEERING GEAR 1 ( MACH. C )");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "TOOL BOX C-01 / LINE STEERING GEAR 1 ( MACH. C )");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "WARNA_KEPALA_KANBAN");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "WARNA_BADAN_KANBAN");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "WARNA_HEADER");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "");

// Set width kolom
	$worksheet->getColumnDimension('A')->setWidth(25);
	$worksheet->getColumnDimension('B')->setWidth(35);
	$worksheet->getColumnDimension('C')->setWidth(20);
	$worksheet->getColumnDimension('D')->setWidth(20);
	$worksheet->getColumnDimension('E')->setWidth(20);
	$worksheet->getColumnDimension('F')->setWidth(50);
	$worksheet->getColumnDimension('G')->setWidth(30);
	$worksheet->getColumnDimension('H')->setWidth(30);
	$worksheet->getColumnDimension('I')->setWidth(25);

	// $worksheet->getStyle('G2')->getFont()->setColor('#6c8cff');
	// $worksheet->getStyle('H2')->getFont()->setColor('#1fe5b6');
	// $worksheet->getStyle('I2')->getFont()->setColor('#aa1414');

	// $objPHPExcel->getStyle('G2')->applyFromArray(
 //        array(
 //            'fill' => array(
 //            'type' => PHPExcel_Style_Fill::FILL_SOLID,
 //            'color' => array('rgb' => '6c8cff')
 //                )
 //            )
 //        );
	// $objPHPExcel->getStyle('H2')->applyFromArray(
 //        array(
 //            'fill' => array(
 //            'type' => PHPExcel_Style_Fill::FILL_SOLID,
 //            'color' => array('rgb' => '1fe5b6')
 //                )
 //            )
 //        );
	// $objPHPExcel->getStyle('I2')->applyFromArray(
 //        array(
 //            'fill' => array(
 //            'type' => PHPExcel_Style_Fill::FILL_SOLID,
 //            'color' => array('rgb' => 'aa1414')
 //                )
 //            )
 //        );
	$worksheet->getStyle('G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('6c8cff');
	$worksheet->getStyle('H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1fe5b6');
	$worksheet->getStyle('I2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('aa1414');

	$worksheet->getStyle('G3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('008000');
	$worksheet->getStyle('H3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D2691E');
	$worksheet->getStyle('I3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('008080');

	$worksheet->getStyle('G4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FF4500');
	$worksheet->getStyle('H4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FA8072');
	$worksheet->getStyle('I4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DAA520');

	$worksheet->getStyle('A1')->getFont()->setSize(12);
	$worksheet->getStyle('A2')->getFont()->setSize(12);
	$worksheet->getStyle('A3')->getFont()->setSize(12);
	$worksheet->getStyle('A4')->getFont()->setSize(12);

	$worksheet->getStyle('B1')->getFont()->setSize(12);
	$worksheet->getStyle('B2')->getFont()->setSize(12);
	$worksheet->getStyle('B3')->getFont()->setSize(12);
	$worksheet->getStyle('B4')->getFont()->setSize(12);

	$worksheet->getStyle('C1')->getFont()->setSize(12);
	$worksheet->getStyle('C2')->getFont()->setSize(12);
	$worksheet->getStyle('C3')->getFont()->setSize(12);
	$worksheet->getStyle('C4')->getFont()->setSize(12);

	$worksheet->getStyle('D1')->getFont()->setSize(12);
	$worksheet->getStyle('D2')->getFont()->setSize(12);
	$worksheet->getStyle('D3')->getFont()->setSize(12);
	$worksheet->getStyle('D4')->getFont()->setSize(12);

	$worksheet->getStyle('E1')->getFont()->setSize(12);
	$worksheet->getStyle('E2')->getFont()->setSize(12);
	$worksheet->getStyle('E3')->getFont()->setSize(12);
	$worksheet->getStyle('E4')->getFont()->setSize(12);

	$worksheet->getStyle('F1')->getFont()->setSize(12);
	$worksheet->getStyle('F2')->getFont()->setSize(12);
	$worksheet->getStyle('F3')->getFont()->setSize(12);
	$worksheet->getStyle('F4')->getFont()->setSize(12);

	$worksheet->getStyle('G1')->getFont()->setSize(12);
	$worksheet->getStyle('G2')->getFont()->setSize(12);
	$worksheet->getStyle('G3')->getFont()->setSize(12);
	$worksheet->getStyle('G4')->getFont()->setSize(12);

	$worksheet->getStyle('H1')->getFont()->setSize(12);
	$worksheet->getStyle('H2')->getFont()->setSize(12);
	$worksheet->getStyle('H3')->getFont()->setSize(12);
	$worksheet->getStyle('H4')->getFont()->setSize(12);

	$worksheet->getStyle('I1')->getFont()->setSize(12);
	$worksheet->getStyle('I2')->getFont()->setSize(12);
	$worksheet->getStyle('I3')->getFont()->setSize(12);
	$worksheet->getStyle('I4')->getFont()->setSize(12);

	$worksheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getDefaultRowDimension()->setRowHeight(-1);
	$worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$worksheet->setTitle('Kanban');
	$objPHPExcel->setActiveSheetIndex(0);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Layoutkanban.xlsx"');
	ob_end_clean();
	$objWriter->save("php://output");
	}
	public function Import(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['data_input']  = array();

		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		foreach($file_data as $row) {
			$data['data_input'][] = array(
				"KODE_BARANG"  	=> $row['KODE_BARANG'],
				"DESC"			=> $row['DESC'],
				"COST_CENTER" 	=> $row['COST_CENTER'],
				"NO_BPPCT"  	=> $row['NO_BPPCT'],
				"JUMLAH_CETAK"  => $row['JUMLAH_CETAK'],
				"ALUR_KANBAN"  	=> $row['ALUR_KANBAN'],
				"WARNA_KEPALA_KANBAN"  	=> $row['WARNA_KEPALA_KANBAN'],
				"WARNA_BADAN_KANBAN"  	=> $row['WARNA_BADAN_KANBAN'],
				"WARNA_HEADER"  => $row['WARNA_HEADER'],
			);
		}



		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakKanbanToolRoom/V_Tabel',$data['data_input']);
		$this->load->view('V_Footer',$data);
	}

	public function Report($data){
		//data dari csv
		// $data['kode_barang'] 	= $this->input->post('kode_barang[]');
		// $data['desc'] 			= $this->input->post('desc[]');
		// $data['cost_center'] 	= $this->input->post('cost_center[]');
		// $data['no_bppbgt'] 		= $this->input->post('no_bppbgt[]');
		// $data['jumlah_cetak'] 	= $this->input->post('jumlah_cetak[]');
		// $data['alur_kanban'] 	= $this->input->post('alur_kanban[]');

		//data dari oracle
		// echo "<pre>";
		// print_r($data);
		// exit();
		$bla = sizeof($data['jumlah_cetak']);
		for ($b=0; $b < $bla ; $b++) {
			$data['kanban'][$b] = $this->M_cetak->getCostCenter($data['cost_center'][$b]);
			$data['kanban2'][$b] = $this->M_cetak->getKodeBarang($data['kode_barang'][$b]);
			$data['kanban3'][$b] = $this->M_cetak->getNoMesin($data['cost_center'][$b]);
			$data['JumlahMesin'] = sizeof($data['kanban3'][$b]);
		}

		$jumlah_baris = sizeof($data['kode_barang']);
		$temp = array();
		$j=0;
		for ($i=0; $i < $jumlah_baris; $i++) {
			$a = array(
				'Kode_barang' 	=> $data['kode_barang'][$i],
				'Desc'			=> $data['desc'][$i],
				'Cost_center' 	=> $data['cost_center'][$i],
				'No_bppbgt' 	=> $data['no_bppbgt'][$i],
				'Jumlah_cetak' 	=> $data['jumlah_cetak'][$i],
				'Alur_kanban' 	=> $data['alur_kanban'][$i],
				'Kanban' 		=> $data['kanban'][$i],
				'Kanban2' 		=> $data['kanban2'][$i],
				'Kanban3' 		=> $data['kanban3'][$i],
				'Jumlahmesin' 	=> $data['JumlahMesin'],
			);
			array_push($temp, $a);
		}

		ob_start();

		$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
		if(!is_dir('.assets/img'))
		{
			mkdir('.assets/img', 0777, true);
			chmod('.assets/img', 0777);
		}

		foreach ($temp as $v) {
			$params['data']		= ($v['Kode_barang']."/".$v['Kanban2'][0]['DESCRIPTION']."/".$v['Cost_center']);
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './assets/img/'.($v['Kode_barang']).'.png';
			$this->ciqrcode->generate($params);

		}
		// ---------------------------------------------------
		//data yg dikirim ke report
		$datalist['jml_cetak'] = $data['jumlah_cetak'];
		$datalist['list'] = $temp;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(210,297), 0, '', 3, 3, 3, 3, 3, 3); //----- A5-L
    	$tglNama = date("d/m/Y-H:i:s");
    	$filename = 'CetakKanbanToolRoom_'.$tglNama.'.pdf';
    	$html = $this->load->view('CetakKanbanToolRoom/V_Report', $datalist, true);		//-----> Fungsi Cetak PDF
    	ob_end_clean();
    	$pdf->WriteHTML($html);												//-----> Pakai Library MPDF
    	$pdf->Output($filename, 'I');

    }


    public function importexcel(){

    	require_once APPPATH.'third_party/Excel/PHPExcel.php';
    	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

    	$this->checkSession();
    	$user_id = $this->session->userid;
    	$data['Menu'] = 'Dashboard';
    	$data['SubMenuOne'] = '';
    	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    	$data['data_input']  = array();

    	$file_data  = array();
		 // load excel
    	$file = $_FILES['excel_file']['tmp_name'];
    	$load = PHPExcel_IOFactory::load($file);
    	$sheets = $load->getActiveSheet()->toArray(null,true,true,true);


    	for ($i=1; $i < sizeof($sheets)+1; $i++) {

    		$colorG[] = $load->getActiveSheet()->getStyle('G'.$i)->getFill()->getStartColor()->getRGB();
    		$colorH[] = $load->getActiveSheet()->getStyle('H'.$i)->getFill()->getStartColor()->getRGB();
    		$colorI[] = $load->getActiveSheet()->getStyle('I'.$i)->getFill()->getStartColor()->getRGB();

    	}


		// echo "<pre>";
		// print_r($colorG);
		// print_r($colorH);
		// print_r($colorI);
		// exit();


    	$i=0;
    	foreach($sheets as $row) {
		 //   $a = array($row['A']
			// );
    		if ($i != 0) {
    			$file_dataA[] = $row['A'];
    			$file_dataB[] = $row['B'];
    			$file_dataC[] = $row['C'];
    			$file_dataD[] = $row['D'];
    			$file_dataE[] = $row['E'];
    			$file_dataF[] = $row['F'];
    			$file_dataG[] = $colorG[$i];
    			$file_dataH[] = $colorH[$i];
    			$file_dataI[] = $colorI[$i];
    		}
    		$i++;
    	}




    	$temp = array();
    	for ($i=0; $i < sizeof($file_dataA); $i++) {

    		$a = array(
    			'KODE_BARANG' 			=> $file_dataA[$i],
    			'DESC'					=> $file_dataB[$i],
    			'COST_CENTER' 			=> $file_dataC[$i],
    			'NO_BPPCT' 				=> $file_dataD[$i],
    			'JUMLAH_CETAK'			=> $file_dataE[$i],
    			'ALUR_KANBAN' 			=> $file_dataF[$i],
    			'WARNA_KEPALA_KANBAN' 	=> $file_dataG[$i],
    			'WARNA_BADAN_KANBAN'	=> $file_dataH[$i],
    			'WARNA_HEADER' 			=> $file_dataI[$i],
    		);
    		array_push($temp, $a);


    	}


		// echo "<pre>";
		// print_r($file_dataA);
		// print_r($file_dataB);
		// print_r($file_dataC);
		// print_r($file_dataD);
		// print_r($file_dataE);
		// print_r($file_dataF);
		// print_r($file_dataG);
		// print_r($file_dataH);
		// print_r($file_dataI);
		// exit();

    	$dataimport['hasilimport'] = $temp;

		// echo "<pre>";
		// print_r($dataimport);
		// exit();


    	$this->load->view('V_Header',$data);
    	$this->load->view('V_Sidemenu',$data);
    	$this->load->view('CetakKanbanToolRoom/V_Excel',$dataimport);
    	$this->load->view('V_Footer',$data);

    }

    public function makeID($data)
    {
    	$back = 1;

    	check:

    	$tahun = date('y');
    	$bulan = date('m');
    	$hari = date('d');

    	$idunix = $tahun.$bulan.$hari.str_pad($back, 3, "0", STR_PAD_LEFT).$data;

    	$check = $this->M_cetak->cekId($idunix);

		// echo "<pre>";
		// print_r($check);
		// exit();

    	if (!empty($check)) {
    		$back++;
    		GOTO check;
    	}

		// echo "<pre>";
		// print_r($idunix);
		// exit();

    	return $idunix;
    }

    public function InsertnReport() {

    	$data['kode_barang'] 	= $this->input->post('kode_barang[]');
    	$data['desc'] 			= $this->input->post('desc[]');
    	$data['cost_center'] 	= $this->input->post('cost_center[]');
    	$data['no_bppbgt'] 		= $this->input->post('no_bppbgt[]');
    	$data['jumlah_cetak'] 	= $this->input->post('jumlah_cetak[]');
    	$data['alur_kanban'] 	= $this->input->post('alur_kanban[]');
    	$data['warna_atas'] 	= $this->input->post('warna_atas[]');
    	$data['warna_bawah'] 	= $this->input->post('warna_bawah[]');
    	$data['warna_header'] 	= $this->input->post('warna_header[]');
    	$data['idunix'] = array();
    	for ($i=0; $i < sizeof($data['kode_barang']); $i++) {
				$idunix				= $this->makeID($data['kode_barang'][$i]);
				$kodebarang = $data['kode_barang'][$i];
				$nama_barang = $this->M_cetak->getNamaBarang($kodebarang);
				$data['nama_barang'][$i] = $nama_barang['0']['DESCRIPTION'];
				$cek_data = [
					'kode_barang' => $data['kode_barang'][$i],
					'cost_center' => $data['cost_center'][$i],
					'nama_barang' => $data['nama_barang'][$i],
					'nomor_bppct' => $data['no_bppbgt'][$i]
				];
				$cek = $this->M_cetak->cekdata($cek_data);
				if (empty($cek)) {
					$this->M_cetak->insert($idunix,$data['kode_barang'][$i],$data['cost_center'][$i],$data['nama_barang'][$i],$data['no_bppbgt'][$i]);
				}
    		array_push($data['idunix'], $idunix);
    	}

		// echo "<pre>";
		// print_r($data);
		// exit();

    	$bla = sizeof($data['jumlah_cetak']);
    	for ($b=0; $b < $bla ; $b++) {
    		$data['kanban'][$b] = $this->M_cetak->getCostCenter($data['cost_center'][$b]);
    		$data['kanban2'][$b] = $this->M_cetak->getKodeBarang($data['kode_barang'][$b]);
    		$data['kanban3'][$b] = $this->M_cetak->getNoMesin($data['cost_center'][$b]);
    		$data['JumlahMesin'][$b] = sizeof($data['kanban3'][$b]);
    	}

		// echo "<pre>";
		// print_r($data);
		// exit();

    	$jumlah_baris = sizeof($data['kode_barang']);
    	$temp = array();
    	$j=0;
    	for ($i=0; $i < $jumlah_baris; $i++) {
    		$a = array(
    			'Kode_barang' 	=> $data['kode_barang'][$i],
    			'Desc'			=> $data['desc'][$i],
    			'Cost_center' 	=> $data['cost_center'][$i],
    			'No_bppbgt' 	=> $data['no_bppbgt'][$i],
    			'Jumlah_cetak' 	=> $data['jumlah_cetak'][$i],
    			'Alur_kanban' 	=> $data['alur_kanban'][$i],
    			'warna_atas' 	=> $data['warna_atas'][$i],
    			'warna_bawah' 	=> $data['warna_bawah'][$i],
    			'warna_header' 	=> $data['warna_header'][$i],
    			'Kanban' 		=> $data['kanban'][$i],
    			'Kanban2' 		=> $data['kanban2'][$i],
    			'Kanban3' 		=> $data['kanban3'][$i],
    			'Jumlahmesin' 	=> $data['JumlahMesin'][$i],
    			'Idunix'		=> $data['idunix'][$i],
    		);
    		array_push($temp, $a);
    	}

		// echo "<pre>";
		// print_r($temp);
		// exit();

    	ob_start();

    	$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
    	if(!is_dir('.assets/img'))
    	{
    		mkdir('.assets/img', 0777, true);
    		chmod('.assets/img', 0777);
    	}

		// foreach ($temp as $v) {
		// echo "<pre>";
		// print_r($v['Idunix']);
		// exit();
		// 	$params['data']		= ($v['Idunix']);
		// 	$params['level']	= 'H';
		// 	$params['size']		= 10;
		// 	$params['black']	= array(255,255,255);
		// 	$params['white']	= array(0,0,0);
		// 	$params['savename'] = './assets/img/'.($v['Idunix']).'.png';
		// 	$this->ciqrcode->generate($params);

		// }
		// echo "<pre>";
		// print_r($temp);
		// exit();
    	foreach ($temp as $v) {
    		$params['data']		= ($v['Idunix']);
    		$params['level']	= 'H';
    		$params['size']		= 10;
    		$params['black']	= array(255,255,255);
    		$params['white']	= array(0,0,0);
    		$params['savename'] = './assets/img/'.($v['Idunix']).'.png';
    		$this->ciqrcode->generate($params);

    	}
		// ---------------------------------------------------
		//data yg dikirim ke report
    	$datalist['jml_cetak'] = $data['jumlah_cetak'];
    	$datalist['list'] = $temp;

		// echo "<pre>";
		// print_r($datalist);
		// exit();

    	$this->load->library('pdf');
    	$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(210,330), 0, '', 3, 3, 3, 3, 3, 3); //----- A5-L
    	$tglNama = date("dmY");
    	$filename = 'CetakKanbanToolRoom_'.$tglNama.'.pdf';
    	$html = $this->load->view('CetakKanbanToolRoom/V_Report', $datalist, true);		//-----> Fungsi Cetak PDF
    	ob_end_clean();
    	$pdf->WriteHTML($html);												//-----> Pakai Library MPDF
    	$pdf->Output($filename, 'I');
    }

		public function cekdata()
		{
			$cek_data = [
				'kode_barang' => 'MJABATCMTYBC151F',
				'cost_center' => '5C17',
				'nama_barang' => 'TCMT 16T308 HR YBC151 - Diamond',
				'nomor_bppct' => '193'
			];
		 	$cek = $this->M_cetak->cekdata($cek_data);
			if (!empty($cek)) {
				echo "<pre>";
				print_r($cek);
			}else {
				echo "ga ada";
			}

		}

		public function cetakAja()
		{
			$data['kode_barang'] 	= $this->input->post('kode_barang[]');
			$data['desc'] 			= $this->input->post('desc[]');
			$data['cost_center'] 	= $this->input->post('cost_center[]');
			$data['no_bppbgt'] 		= $this->input->post('no_bppbgt[]');
			$data['jumlah_cetak'] 	= $this->input->post('jumlah_cetak[]');
			$data['idunix'] = [];

			for ($i=0; $i < sizeof($data['kode_barang']); $i++) {
				$nama_barang = $this->M_cetak->getNamaBarang($data['kode_barang'][$i]);
				$data['nama_barang'][$i] = $nama_barang['0']['DESCRIPTION'];

				$idunix = $this->makeID($data['kode_barang'][$i]);

				$cek_data = [
					'kode_barang' => $data['kode_barang'][$i],
					'cost_center' => $data['cost_center'][$i],
					'nama_barang' => $data['nama_barang'][$i],
					'nomor_bppct' => $data['no_bppbgt'][$i]
				];
				$cek = $this->M_cetak->cekdata($cek_data);
				if (empty($cek)) {
					$this->M_cetak->insert($idunix,$data['kode_barang'][$i],$data['cost_center'][$i],$data['nama_barang'][$i],$data['no_bppbgt'][$i]);
				}

				array_push($data['idunix'], $idunix);
			}

			ob_start();
			$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
			if(!is_dir('./assets/img'))
			{
				mkdir('./assets/img', 0777, true);
				chmod('./assets/img', 0777);
			}

			foreach ($data['idunix'] as $v) {
				$params['data']		= $v;
				$params['level']	= 'H';
				$params['size']		= 2;
				$params['black']	= array(255,255,255);
				$params['white']	= array(0,0,0);
				$params['savename'] = './assets/img/'.$v.'.png';
				$this->ciqrcode->generate($params);
			}

			// echo "<pre>"; print_r($data['kode_barang']);die;

			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8',array(210,330), 0, '', 3, 3, 3, 3, 3, 3); //----- A5-L
			$tglNama = date("dmY");
			$filename = 'CetakKanbanToolRoom_min_'.$tglNama.'.pdf';
			$html = $this->load->view('CetakKanbanToolRoom/V_Cetak_Aja', $data, true);		//-----> Fungsi Cetak PDF
			ob_end_clean();
			$pdf->WriteHTML($html);												//-----> Pakai Library MPDF
			$pdf->Output($filename, 'I');

			foreach ($data['idunix'] as $v) {
				$params['savename'] = './assets/img/'.($v).'.png';
				if (!unlink($params['savename'])) {
						echo("Error deleting");
				} else {
						unlink($params['savename']);
				}
			}

		}
}
