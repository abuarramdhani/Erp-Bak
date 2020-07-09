<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Manageplan extends CI_Controller
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
		$this->load->model('ProductionPlan/M_productionplan');

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

		$data['Title'] = 'Management Plan';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$mont = date("F-Y");
		$hasilimport = $this->M_productionplan->dataplan($mont); //6

		$arrayplanhandlebar= array();
		$arrayplanbody= array();
		$arrayplandos= array();

		$item_id = array();
		foreach ($hasilimport as $import) {
			if (!in_array($import['id_item'], $item_id)) {
				array_push($item_id, $import['id_item']);

			$dataitem = $this->M_productionplan->dapatkanitem($import['id_item']); 
			$versi = $this->M_productionplan->cek($import['id_item'], $import['bulan']); 
				for ($i=0; $i < sizeof($versi) ; $i++) {
					$ulu = array(
						'kode_komponen' => $dataitem[0]['kode_item'] , 
						'nama_komponen' => $dataitem[0]['desc_item'],
						'bulan' => $import['bulan'],
						'versi_baru' => $versi[$i]['versi']
					);
					if ($dataitem[0]['jenis'] == 'Handle Bar') {
						array_push($arrayplanhandlebar, $ulu);	
					} else if ($dataitem[0]['jenis'] == 'Body') {
						array_push($arrayplanbody, $ulu);	
					} else if ($dataitem[0]['jenis'] == 'Dos') {
						array_push($arrayplandos, $ulu);	
					}
				}
			}

			
		}

		// echo "<pre>";print_r($arrayplandos);exit();

		$data['arrayplanhandlebar'] = $arrayplanhandlebar;
		$data['arrayplanbody'] = $arrayplanbody;
		$data['arrayplandos'] = $arrayplandos;


		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlan/V_ManagePlan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
		public function importexcel()
	{

	require_once APPPATH.'third_party/Excel/PHPExcel.php';
    require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

    	$monthh = $this->input->post('monthplan');
    	$month = strtoupper($monthh);
    	// echo "<pre>";print_r($month);exit();
		$file_data  = array();
		 // load excel
    	$file = $_FILES['excel_file']['tmp_name'];
    	$load = PHPExcel_IOFactory::load($file);
    	$sheets = $load->getActiveSheet()->toArray(null,true,true,true);

    	$i = 0;
		  foreach ($sheets as $sheet) {
		    if ($i > 1) {
		      $komponen[] = $sheet['A']; 
		      $nama[] = $sheet['B']; 
		      $tgl1[] = $sheet['C']; 
		      $tgl2[] = $sheet['D']; 
		      $tgl3[] = $sheet['E']; 
		      $tgl4[] = $sheet['F']; 
		      $tgl5[] = $sheet['G']; 
		      $tgl6[] = $sheet['H']; 
		      $tgl7[] = $sheet['I']; 
		      $tgl8[] = $sheet['J']; 
		      $tgl9[] = $sheet['K']; 
		      $tgl10[] = $sheet['L']; 
		      $tgl11[] = $sheet['M']; 
		      $tgl12[] = $sheet['N']; 
		      $tgl13[] = $sheet['O']; 
		      $tgl14[] = $sheet['P']; 
		      $tgl15[] = $sheet['Q']; 
		      $tgl16[] = $sheet['R']; 
		      $tgl17[] = $sheet['S']; 
		      $tgl18[] = $sheet['T']; 
		      $tgl19[] = $sheet['U']; 
		      $tgl20[] = $sheet['V']; 
		      $tgl21[] = $sheet['W']; 
		      $tgl22[] = $sheet['X']; 
		      $tgl23[] = $sheet['Y']; 
		      $tgl24[] = $sheet['Z']; 
		      $tgl25[] = $sheet['AA']; 
		      $tgl26[] = $sheet['AB']; 
		      $tgl27[] = $sheet['AC']; 
		      $tgl28[] = $sheet['AD']; 
		      $tgl29[] = $sheet['AE']; 
		      $tgl30[] = $sheet['AF']; 
		      $tgl31[] = $sheet['AG']; 
	
		    }
		    $i++;
		  }
    	$arraytoinsert = array();
    	$e=1;
    	for ($i=0; $i < sizeof($komponen); $i++) {
    		$id_item = $this->M_productionplan->dapatkaniditem($komponen[$i]);
    	
    		$a = array(
    			 'nomor' => $e,
    			 'bulan' => $monthh,
	    		 'id_item' => $id_item[0]['id_item'],  
			     'nama' => $nama[$i],  
			     'tgl1' => $tgl1[$i],  
			     'tgl2' => $tgl2[$i],  
			     'tgl3' => $tgl3[$i],  
			     'tgl4' => $tgl4[$i],  
			     'tgl5' => $tgl5[$i],  
			     'tgl6' => $tgl6[$i],  
			     'tgl7' => $tgl7[$i],  
			     'tgl8' => $tgl8[$i],  
			     'tgl9' => $tgl9[$i],  
			     'tgl10' => $tgl10[$i],  
			     'tgl11' => $tgl11[$i],  
			     'tgl12' => $tgl12[$i],  
			     'tgl13' => $tgl13[$i],  
			     'tgl14' => $tgl14[$i],  
			     'tgl15' => $tgl15[$i],  
			     'tgl16' => $tgl16[$i],  
			     'tgl17' => $tgl17[$i],  
			     'tgl18' => $tgl18[$i],  
			     'tgl19' => $tgl19[$i],  
			     'tgl20' => $tgl20[$i],  
			     'tgl21' => $tgl21[$i],  
			     'tgl22' => $tgl22[$i],  
			     'tgl23' => $tgl23[$i],  
			     'tgl24' => $tgl24[$i],  
			     'tgl25' => $tgl25[$i],  
			     'tgl26' => $tgl26[$i],  
			     'tgl27' => $tgl27[$i],  
			     'tgl28' => $tgl28[$i],  
			     'tgl29' => $tgl29[$i],  
			     'tgl30' => $tgl30[$i],  
			     'tgl31' => $tgl31[$i] 
    		);
    		array_push($arraytoinsert, $a);

    		$e++;
    	}


		// echo "<pre>";
		// print_r($arraytoinsert);
		// exit();

    	$dataplan = $this->M_productionplan->dataplan2();

		foreach ($arraytoinsert as $insert) {
			// foreach ($dataplan as $value) {
				$cek = $this->M_productionplan->cek($insert['id_item'], $insert['bulan']);
				if (!empty($cek)) {
					$versi = $cek[0]['versi'] + 1;
					$this->M_productionplan->insertplan($insert['bulan'],$insert['id_item'],$insert['nama'],$insert['tgl1'],$insert['tgl2'],$insert['tgl3'],$insert['tgl4'],$insert['tgl5'],$insert['tgl6'],$insert['tgl7'],$insert['tgl8'],$insert['tgl9'],$insert['tgl10'],$insert['tgl11'],$insert['tgl12'],$insert['tgl13'],$insert['tgl14'],$insert['tgl15'],$insert['tgl16'],$insert['tgl17'],$insert['tgl18'],$insert['tgl19'],$insert['tgl20'],$insert['tgl21'],$insert['tgl22'],$insert['tgl23'],$insert['tgl24'],$insert['tgl25'],$insert['tgl26'],$insert['tgl27'],$insert['tgl28'],$insert['tgl29'],$insert['tgl30'],$insert['tgl31'], $versi);
				} else {
					$versi = 1;
					$this->M_productionplan->insertplan($insert['bulan'],$insert['id_item'],$insert['nama'],$insert['tgl1'],$insert['tgl2'],$insert['tgl3'],$insert['tgl4'],$insert['tgl5'],$insert['tgl6'],$insert['tgl7'],$insert['tgl8'],$insert['tgl9'],$insert['tgl10'],$insert['tgl11'],$insert['tgl12'],$insert['tgl13'],$insert['tgl14'],$insert['tgl15'],$insert['tgl16'],$insert['tgl17'],$insert['tgl18'],$insert['tgl19'],$insert['tgl20'],$insert['tgl21'],$insert['tgl22'],$insert['tgl23'],$insert['tgl24'],$insert['tgl25'],$insert['tgl26'],$insert['tgl27'],$insert['tgl28'],$insert['tgl29'],$insert['tgl30'],$insert['tgl31'], $versi);
				}
			// }	
		}

	}
	public function Export(){

	require_once APPPATH.'third_party/Excel/PHPExcel.php';
	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

	$objPHPExcel = new PHPExcel();
	$worksheet = $objPHPExcel->getActiveSheet();

	$worksheet->mergeCells('A1:B1');
	$worksheet->mergeCells('C1:AG1');
	// $worksheet->getColumnDimension('A')->setAutoSize(true);
	// $worksheet->getColumnDimension('B')->setAutoSize(true);
	$worksheet->getColumnDimension('C')->setWidth(3);
	$worksheet->getColumnDimension('D')->setWidth(3);
	$worksheet->getColumnDimension('E')->setWidth(3);
	$worksheet->getColumnDimension('F')->setWidth(3);
	$worksheet->getColumnDimension('G')->setWidth(3);
	$worksheet->getColumnDimension('H')->setWidth(3);
	$worksheet->getColumnDimension('I')->setWidth(3);
	$worksheet->getColumnDimension('J')->setWidth(3);
	$worksheet->getColumnDimension('K')->setWidth(3);
	$worksheet->getColumnDimension('L')->setWidth(3);
	$worksheet->getColumnDimension('M')->setWidth(3);
	$worksheet->getColumnDimension('N')->setWidth(3);
	$worksheet->getColumnDimension('O')->setWidth(3);
	$worksheet->getColumnDimension('P')->setWidth(3);
	$worksheet->getColumnDimension('Q')->setWidth(3);
	$worksheet->getColumnDimension('R')->setWidth(3);
	$worksheet->getColumnDimension('S')->setWidth(3);
	$worksheet->getColumnDimension('T')->setWidth(3);
	$worksheet->getColumnDimension('U')->setWidth(3);
	$worksheet->getColumnDimension('V')->setWidth(3);
	$worksheet->getColumnDimension('W')->setWidth(3);
	$worksheet->getColumnDimension('X')->setWidth(3);
	$worksheet->getColumnDimension('Y')->setWidth(3);
	$worksheet->getColumnDimension('Z')->setWidth(3);
	$worksheet->getColumnDimension('AA')->setWidth(3);
	$worksheet->getColumnDimension('AB')->setWidth(3);
	$worksheet->getColumnDimension('AC')->setWidth(3);
	$worksheet->getColumnDimension('AD')->setWidth(3);
	$worksheet->getColumnDimension('AE')->setWidth(3);
	$worksheet->getColumnDimension('AF')->setWidth(3);
	$worksheet->getColumnDimension('AG')->setWidth(3);


	// $worksheet->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "KOMPONEN");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "KODE");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "NAMA");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "TANGGAL");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "2");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "3");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "4");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', "5");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', "6");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "7");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "8");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', "9");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "10");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "11");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "12");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "13");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "14");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', "15");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2', "16");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2', "17");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', "18");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U2', "19");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2', "20");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W2', "21");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X2', "22");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y2', "23");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z2', "24");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA2', "25");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB2', "26");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC2', "27");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD2', "28");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE2', "29");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF2', "30");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG2', "31");




	$worksheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$worksheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$worksheet->getDefaultRowDimension()->setRowHeight(-1);
	$worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$worksheet->setTitle();
	$objPHPExcel->setActiveSheetIndex(0);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Template_Plan.xlsx"');
	ob_end_clean();
	$objWriter->save("php://output");



}
		public function HasilPlan()
	{	
		$mont = $this->input->post('monthplan');
		$hasilimport = $this->M_productionplan->dataplan($mont); //6

		$arrayplanhandlebar= array();
		$arrayplanbody= array();
		$arrayplandos= array();

		$item_id = array();
		foreach ($hasilimport as $import) {
			if (!in_array($import['id_item'], $item_id)) {
				array_push($item_id, $import['id_item']);

			$dataitem = $this->M_productionplan->dapatkanitem($import['id_item']); 
			$versi = $this->M_productionplan->cek($import['id_item'], $import['bulan']); 
				for ($i=0; $i < sizeof($versi) ; $i++) {
					$ulu = array(
						'kode_komponen' => $dataitem[0]['kode_item'] , 
						'nama_komponen' => $dataitem[0]['desc_item'],
						'bulan' => $import['bulan'],
						'versi_baru' => $versi[$i]['versi']
					);
					if ($dataitem[0]['jenis'] == 'Handle Bar') {
						array_push($arrayplanhandlebar, $ulu);	
					} else if ($dataitem[0]['jenis'] == 'Body') {
						array_push($arrayplanbody, $ulu);	
					} else if ($dataitem[0]['jenis'] == 'Dos') {
						array_push($arrayplandos, $ulu);	
					}
				}
			}

			
		}

		// echo "<pre>";print_r($arrayplandos);exit();

		$data['arrayplanhandlebar'] = $arrayplanhandlebar;
		$data['arrayplanbody'] = $arrayplanbody;
		$data['arrayplandos'] = $arrayplandos;


		$this->load->view('ProductionPlan/V_PlanBody', $data);

		$this->load->view('ProductionPlan/V_PlanHandleBar', $data);
		
		$this->load->view('ProductionPlan/V_PlanDos',  $data);
	}



}