<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SetPlan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringJobProduksi/M_setplan');
		$this->load->model('MonitoringJobProduksi/M_usermng');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$username = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Set Plan Produksi';
		$data['Menu'] = 'Set Plan Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $user = $this->session->user;
		// $cekHak = $this->M_usermng->getUser("where no_induk = '$user'");
		// if (!empty($cekHak)) {
		// 	if ($cekHak[0]['JENIS'] == 'Admin') {
		// 		$data['UserMenu'] = array($UserMenu[0], $UserMenu[1]);
		// 	}else {
		// 		$data['UserMenu'] = $UserMenu;
		// 	}
		// }else {
		// 	$data['UserMenu'] = $UserMenu;
		// }

		$data['kategori'] = $this->M_setplan->getCategory('');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_SetPlan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function jumlahHari($bulan, $tahun){
        if ($bulan == '01' || $bulan == '03' || $bulan == '05' || $bulan == '07' || $bulan == '08' || $bulan == '10' || $bulan == '12') {
            $hari = 31;
        }elseif ($bulan == '04' || $bulan == '06' || $bulan == '09' || $bulan == '11') {
            $hari = 30;
        }elseif ($bulan == '02') {
            if ($tahun%4 == 0) {
                $hari = 29;
            }else {
                $hari = 28;
            }
		}
		return $hari;
	}
    
    public function search(){
        $kategori   = $this->input->post('kategori');
		$bulan      = $this->input->post('bulan');
		$data['bulan2'] = $bulan;
		$data['kategori2'] = $kategori;
        $bulan 		= explode("/", $bulan);
		$data['bulan'] = $bulan[1].$bulan[0];
		// $subkategori   = $this->input->post('subkategori');
		// $data['subcategory'] = $subkategori;
		// $sub = empty($subkategori) ? 'id_subcategory is null' : "id_subcategory = ".$subkategori."";
        // echo "<pre>";print_r($bulan);exit();
        $data['hari'] = $this->jumlahHari($bulan[0], $bulan[1]);
		
		$getdata	= $this->M_setplan->getdataMonitoring($kategori);
		$getplandate	= $this->M_setplan->getPlanDate('');
		$datanya = array();
		foreach ($getdata as $key => $value) {
			$item = $this->M_setplan->getitem2($value['INVENTORY_ITEM_ID']);
			$plan = $this->M_setplan->getPlan("where inventory_item_id = ".$value['INVENTORY_ITEM_ID']." and month = ".$data['bulan']." and id_category = $kategori");
			$getdata[$key]['ITEM'] = $item[0]['SEGMENT1'];
			$getdata[$key]['DESKRIPSI'] = $item[0]['DESCRIPTION'];
			$getdata[$key]['JUMLAH'] = 0;
			if (!empty($plan)) {
				$getdata[$key]['PLAN_ID'] = $plan[0]['PLAN_ID'];
				for ($i=0; $i < $data['hari']; $i++) { 
					$getdata[$key][$i] = $this->getPlanDate($plan[0]['PLAN_ID'], ($i+1), $getplandate);
					$getdata[$key]['JUMLAH'] += $getdata[$key][$i];
				}
				$planbulanan = $this->M_setplan->getPlanDate("where plan_id = ".$plan[0]['PLAN_ID']." and value_plan_month is not null");
				!empty($planbulanan)? $getdata[$key]['JUMLAH'] += $planbulanan[0]['VALUE_PLAN_MONTH'] : '';
			}else {
				$getdata[$key]['PLAN_ID'] = '';
				for ($i=0; $i < $data['hari'] ; $i++) { 
					$getdata[$key][$i] = '';
					$getdata[$key]['JUMLAH'] = 0;
				}
			}
			array_push($datanya, $getdata[$key]);
		}
		
		usort($datanya, function($y, $z) {
			return strcasecmp($y['ITEM'], $z['ITEM']);
		});
		$data['data'] = $datanya;

        $this->load->view('MonitoringJobProduksi/V_TblSetplan', $data);
	}

	public function getPlanDate($id, $tgl, $data){
		$value = '';
		foreach ($data as $key => $val) {
			if ($val['PLAN_ID'] == $id && $val['DATE_PLAN'] == $tgl) {
				$value = $val['VALUE_PLAN'];
			}else {
				$value = $value;
			}
		}
		return $value;
	}
	
public function savePlan(){
 		$bulan 		= $this->input->post('bulan');
 		$kategori 	= $this->input->post('kategori');
 		$subkategori 	= $this->input->post('subcategory');
		$sub = empty($subkategori) ? 'id_subcategory is null' : "id_subcategory = ".$subkategori."";
		$subkategori = empty($subkategori) ? 'null' : $subkategori;
 		$item 		= $this->input->post('item[]');
 		$plan 		= $this->input->post('plan[]');
 		$plan2 = count($plan)/(count($item)/2);
 		$plann = $plan2;
 		$p = 0;
 		// echo "<pre>";print_r($plan2);exit();
 		for ($i=0; $i < (count($item)/2) ; $i++) { 
 			$plan3 = array();
 			for ($x=$p; $x < $plan2 ; $x++) { 
 				array_push($plan3, $plan[$x]);
			 }
 			$p = $plan2;
 			$plan2 = $plan2 + $plann;
 			$cekdata = $this->M_setplan->getPlan("where inventory_item_id = ".$item[$i]." and month = $bulan and id_category = $kategori and $sub");
 			if (empty($cekdata)) {
				// echo "<pre>";print_r($plan3);exit();
 				$cekid = $this->M_setplan->getPlan('order by plan_id desc');
 				$id = !empty($cekid) ? $cekid[0]['PLAN_ID'] + 1 : 1;
 				$savePlan = $this->M_setplan->savePlan($id, $item[$i], $bulan, $kategori, $subkategori);
 				for ($a=0; $a < count($plan3) ; $a++) { 
 					if (!empty($plan3[$a])) {
 						$this->M_setplan->savePlanDate($id, ($a+1), $plan3[$a]);
 					}
 				}
 			}else {
				// echo "<pre>";print_r($cekdata);exit();
 				for ($b=0; $b < count($plan3) ; $b++) { 
 					$cekdate = $this->M_setplan->getPlanDate("where plan_id = ".$cekdata[0]['PLAN_ID']." and date_plan = ".($b+1)."");
 					if (!empty($cekdate) && !empty($plan3[$b])) {
 						$update = $this->M_setplan->updatePlanDate($cekdata[0]['PLAN_ID'], ($b+1), $plan3[$b]);
 					}elseif (empty($cekdate) && !empty($plan3[$b])) {
 						$save = $this->M_setplan->savePlanDate($cekdata[0]['PLAN_ID'], ($b+1), $plan3[$b]);
 					}elseif (!empty($cekdate) && empty($plan3[$b])) {
 						$delete = $this->M_setplan->deletePlanDate($cekdata[0]['PLAN_ID'], ($b+1));
 					}
 				}
 			}
 		}
 		redirect(base_url('MonitoringJobProduksi/SetPlan'));
	 }
	 
	public function importPlan(){
		require_once APPPATH.'third_party/Excel/PHPExcel.php';
		require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
		 
			$file_data  = array();
			 // load excel
			  $file = $_FILES['file_setplan']['tmp_name'];
			  $load = PHPExcel_IOFactory::load($file);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
	
			//   echo "<pre>";print_r($sheets);exit();
	
			$i=1; $x = 0;
			  foreach($sheets as $row) {
				   if ($i != 1 && $i != 2) {
						$kategori 	= $row['B'];
						$ktgr 		= $this->M_setplan->getCategory("where category_name = '$kategori'");
						$kategori	= $ktgr[0]['ID_CATEGORY'];
						$subcategory= $row['C'];
						if (!empty($subcategory)) {
							$subktgr 		= $this->M_setplan->getSubCategory("where id_subcategory = $subcategory");
							$subcategory	= $subktgr[0]['SUBCATEGORY_ID'];
							$sub			= "id_subcategory = ".$subktgr[0]['SUBCATEGORY_ID']."";
						}else {
							$sub			= "id_subcategory is null";
						}
						$bulan 		= $row['D'];
						$bulan1		= explode("/", $bulan);
						$bulan		= $bulan1[1].$bulan1[0];
						$inv 		= $row['G'];
						$cekplan = $this->M_setplan->getPlan("where inventory_item_id = ".$inv." and month = $bulan and id_category = $kategori and $sub");
						if (empty($cekplan)) {
							$cekid = $this->M_setplan->getPlan('order by plan_id desc');
							$id = !empty($cekid) ? $cekid[0]['PLAN_ID'] + 1 : 1;
							$savePlan = $this->M_setplan->savePlan($id, $inv, $bulan, $kategori, $subcategory);
						}else {
							$id = $cekplan[0]['PLAN_ID'];
						}

						$hari = $this->jumlahHari($bulan1[0], $bulan1[1]);
						$d = 7;
						for ($p=0; $p < $hari ; $p++) { 
							$a = $this->numbertoalpha($d);
							$plan = $row[$a];
							$cekdate = $this->M_setplan->getPlanDate("where plan_id = ".$id." and date_plan = ".($p+1)."");
							if (!empty($cekdate) && !empty($plan)) {
								$update = $this->M_setplan->updatePlanDate($id, ($p+1), $plan);
							}elseif (empty($cekdate) && !empty($plan)) {
								$save = $this->M_setplan->savePlanDate($id, ($p+1), $plan);
							}elseif (!empty($cekdate) && empty($plan)) {
								$delete = $this->M_setplan->deletePlanDate($id, ($p+1));
							}
					 
							$d++;
						}
						$x++;

				   }
				   $i++;
			  }
			  redirect(base_url('MonitoringJobProduksi/SetPlan'));
	}
 
	public function exportPlan(){
		$item 		= $this->input->post('item[]');
		$plan 		= $this->input->post('plan[]');
		$kode_item 	= $this->input->post('kode_item[]');
		$desc 		= $this->input->post('desc[]');
		$subcategory= $this->input->post('subcategory[]');
		$bulan 		= $this->input->post('bulan2');
		$bulan2		= explode("/", $bulan);
		// $bulan2		= $bulan2[0];
		$hari = $this->jumlahHari($bulan2[0], $bulan2[1]);
		// echo "<pre>";print_r($bulan);exit();
		
		$kategori 	= $this->input->post('kategori2');
		$ktgr 		= $this->M_setplan->getCategory("where id_category = $kategori");
		$kategori	= $ktgr[0]['CATEGORY_NAME'];
		
		$x = 0; $bts = 0;
		for ($i=0; $i < (count($item)/2) ; $i++) { 
			$bts = $bts + $hari;
			$datanya[$i]['inv'] = $item[$i];
			$datanya[$i]['kode_item'] = $kode_item[$i];
			$datanya[$i]['desc'] = $desc[$i];
			if (!empty($subcategory[$i])) {
				$subktgr = $this->M_setplan->getSubCategory("where id_subcategory = ".$subcategory[$i]."");
				$datanya[$i]['subcategory']	= $subktgr[0]['SUBCATEGORY_NAME'];
			}else {
				$datanya[$i]['subcategory']	= '';
			}
			$z = 0;
			for ($x=$x; $x < $bts ; $x++) { 
				$datanya[$i]['plan'.$z.''] = $plan[$x];
				$z++;
			}
		}
		// echo "<pre>";print_r($datanya);exit();

		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Monitoring Job Produksi")
					->setSubject("CV. KHS")
					->setDescription("Monitoring Job Produksi")
					->setKeywords("MJP");
		
		$style_title = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style1 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'bdeefc'),
			),
			'font' => array(
				'bold' => true,
			), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style2 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style3 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		$style4 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'E6E8E6'),
			),
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		if ($hari == 31) {
			$akhir = 'AL';
			$ajml = 'AM';
		}elseif ($hari == 30) {
			$akhir = 'AK';
			$ajml = 'AL';
		}elseif ($hari == 29){
			$akhir = 'AJ';
			$ajml = 'AK';
		}else {
			$akhir = 'AI';
			$ajml = 'AJ';
		}

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "KATEGORI");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "SUBKATEGORI");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "BULAN");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "KODE");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "DESKRIPSI");
		$excel->setActiveSheetIndex(0)->setCellValue('G1', "INVENTORY ITEM ID");
		$excel->setActiveSheetIndex(0)->setCellValue('H1', "TANGGAL");
		$excel->getActiveSheet()->mergeCells("A1:A2"); 
		$excel->getActiveSheet()->mergeCells("B1:B2"); 
		$excel->getActiveSheet()->mergeCells("C1:C2"); 
		$excel->getActiveSheet()->mergeCells("D1:D2"); 
		$excel->getActiveSheet()->mergeCells("E1:E2"); 
		$excel->getActiveSheet()->mergeCells("F1:F2"); 
		$excel->getActiveSheet()->mergeCells("G1:G2"); 
		$excel->getActiveSheet()->mergeCells("H1:".$akhir."1"); 
		
		$row = 2;
		$col = 7;
		for ($i=0; $i < $hari ; $i++) { //tanggal 1 - akhir
			$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
			$col++;
		}
		
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B2')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('C2')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('D2')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('E1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('E2')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('F1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('F2')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('G1')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('G2')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("H1:".$akhir."2")->applyFromArray($style1);
		for ($n=7; $n < ($hari+7) ; $n++) { // styling tanggal col 7 - akhir
			$a = $this->numbertoalpha($n);
			$excel->getActiveSheet()->getStyle("".$a."2")->applyFromArray($style1);
		}
		
		$no=1;
		$numrow = 3;
		foreach ($datanya as $d) {	
			// echo "<pre>";print_r($d);exit();
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $kategori);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $d['subcategory']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $bulan);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $d['kode_item']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $d['desc']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $d['inv']);
			$col = 7;
			for ($i=0; $i < $hari ; $i++) { // value per tanggal
				$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $numrow, $d['plan'.$i.'']);
				$col++;
			}

			// $baris = $numrow+$i;
			$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("B$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("C$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("D$numrow")->applyFromArray($style2);
			$excel->getActiveSheet()->getStyle("E$numrow")->applyFromArray($style2);
			$excel->getActiveSheet()->getStyle("F$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("G$numrow")->applyFromArray($style3);
			for ($n=7; $n < ($hari+7) ; $n++) { // styling kolom tanggal/numrow
				$a = $this->numbertoalpha($n);
				$excel->getActiveSheet()->getStyle("$a$numrow")->applyFromArray($style2);
			}
			$numrow++;
			$no++;
		}
				
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(13); 
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); 
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15); 
		for($col = 'G'; $col !== $ajml; $col++) { // autowidth
			$excel->getActiveSheet()
				->getColumnDimension($col)
				->setAutoSize(true);
		}
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Setplan");
		$excel->setActiveSheetIndex();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="SetPlan-Job-Produksi-'.$kategori.'-'.$bulan.'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
	public function numbertoalpha($n){
		for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
		$r = chr($n%26 + 0x41) . $r;
		return $r;
	}

 
 



}