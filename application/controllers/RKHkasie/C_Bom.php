<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Bom extends CI_Controller
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
		$this->load->model('RKHkasie/M_rkhkasie');
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
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Daftar BOM';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RKHKasie/V_Bom');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
	public function getKodbar()
	{	
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_rkhkasie->getKodbar($term);
		echo json_encode($data);
		
	}
	function getDescCode()
	{
		$kodeitem  = $this->input->post('kodeitem');
		$desc = $this->M_rkhkasie->getdesckomp($kodeitem);
		// echo "<pre>";print_r($desc);exit();
		if ($desc== null) {

		echo json_encode('-');
		
		} else if ($desc!=null) {

    	echo json_encode($desc[0]['DESCRIPTION']);
			
		}
	}
	public function getBom()
	{
		$kodeitemm = $this->input->post('kodeitem');
		$kodeitem= strtoupper($kodeitemm);

		$result_bom =  $this->M_rkhkasie->getResultBom($kodeitem);
		// echo "<pre>";print_r($result_bom);exit();

		$data['result_bom'] = $result_bom;

		$this->load->view('RKHKasie/V_BomResult',$data);

	}
		public function getadaBom()
	{
		$kodeitemm = $this->input->post('kodeitem');
		$kodeitem= strtoupper($kodeitemm);
		$result_bom =  $this->M_rkhkasie->getResultBom($kodeitem);
		// echo "<pre>";print_r($result_bom);exit();
		$i=0;
		foreach ($result_bom as $bom) {
			$detail_bom = $this->M_rkhkasie->getDetailBom($bom['KODE_BARANG']);
			if ($detail_bom ==null) {
				$result_bom[$i]['DETAIL_BOM']=null;
			} else if ($detail_bom !=null) {
				
				$b=0;
				foreach ($detail_bom as $detbom) {
					$result_bom[$i]['DETAIL_BOM'][$b]['KODE'] = $detbom['COMPONENT_NUM'];
					$result_bom[$i]['DETAIL_BOM'][$b]['NAMA'] = $detbom['DESCRIPTION'];
					$result_bom[$i]['DETAIL_BOM'][$b]['QTY'] = round($detbom['QTY'],3);
					$result_bom[$i]['DETAIL_BOM'][$b]['ISI'] = round((1/$detbom['QTY']),3);

					$b++;	
				}
			}
			$i++;
		}
		// echo "<pre>";print_r($result_bom);exit();
		$data['result_bom'] = $result_bom;
		$this->load->view('RKHKasie/V_BomResultada',$data);


	}
			public function gettdkBom()
	{
		$kodeitemm = $this->input->post('kodeitem');
		$kodeitem= strtoupper($kodeitemm);
		$result_bom =  $this->M_rkhkasie->getResultBom($kodeitem);
		// echo "<pre>";print_r($result_bom);exit();
		$i=0;
		foreach ($result_bom as $bom) {
			$detail_bom = $this->M_rkhkasie->getDetailBom($bom['KODE_BARANG']);
			if ($detail_bom ==null) {
				$result_bom[$i]['DETAIL_BOM']=null;
			} else if ($detail_bom !=null) {
				
				$b=0;
				foreach ($detail_bom as $detbom) {
					$result_bom[$i]['DETAIL_BOM'][$b]['KODE'] = $detbom['COMPONENT_NUM'];
					$result_bom[$i]['DETAIL_BOM'][$b]['NAMA'] = $detbom['DESCRIPTION'];
					$result_bom[$i]['DETAIL_BOM'][$b]['QTY'] = round($detbom['QTY'],3);
					$b++;	
				}
			}
			$i++;
		}
		// echo "<pre>";print_r($result_bom);exit();
		$data['result_bom'] = $result_bom;
		$this->load->view('RKHKasie/V_BomResulttdk',$data);


	}
		public function getlihatbom()
	{
		$kodeitem = $this->input->post('kodeitem');
		// $kodeitem= strtoupper($kodeitemm);

		$detail_bom =  $this->M_rkhkasie->getDetailBom($kodeitem);

		// echo "<pre>";print_r($detail_bom);exit();
if ($detail_bom !=null) {
		$tbody = '';
		$urut=1;
		foreach ($detail_bom as  $detbom) {
			$isi = 1/$detbom['QTY'];
			$tbody .= '
			<tr>
			<td class="text-center">Pack '.$urut.'</td>
			<td class="text-center"><input type="hidden" name="kodebom[]" value="'.$detbom['COMPONENT_NUM'].'">'.$detbom['COMPONENT_NUM'].'</td>
			<td class="text-center"><input type="hidden" name="namabom[]" value="'.$detbom['DESCRIPTION'].'">'.$detbom['DESCRIPTION'].'</td>
			<td class="text-center"><input   type="hidden" name="qtybom[]" value="'.round($detbom['QTY'],3).'">'.round($detbom['QTY'],3).'</td>
			<td class="text-center"><input   type="hidden" name="isi[]" value="'.$isi.'">'.$isi.'</td>
			</tr>';
			$urut++;
		}

		$tabeldetail = '<div id="lihatbom" >
								<table class="table table-bordered">
									<thead class="bg-teal">
										<th class="text-center" style="width: 100px">Pack</th>
										<th class="text-center" style="width: 50px">Kode</th>
										<th class="text-center" style="width: 50px">Nama</th>
										<th class="text-center" style="width: 50px">Qty</th>
										<th class="text-center" style="width: 50px">Isi</th>


									</thead>
									<tbody>'.$tbody.'
									</tbody>
								</table>
							</div>';
} else{
	$tabeldetail = '<div id="lihatbom" >
								<h3 style="font-weight: bold; text-align : center;">Belum ada BOM</h3>
							</div>';
}
		echo $tabeldetail;
}
		public function geteditbom()
	{
		$kodeitem = $this->input->post('kodeitem');
		// $kodeitem= strtoupper($kodeitemm);

		$detail_bom =  $this->M_rkhkasie->getDetailBom($kodeitem);

		// echo "<pre>";print_r($detail_bom);exit();
if ($detail_bom !=null) {
		$tbody = '';
		$urut=1;
		foreach ($detail_bom as  $detbom) {
			$tbody .= '
			<tr class="trlama'.$urut.'">
				<td class="text-center"><input type="text" class="form-control" value="'.$detbom['COMPONENT_NUM'].'" id="kodebomedit'.$urut.'" name="kodebomedit[]" onkeyup="getdesckomp('.$urut.')"></td>

				<td class="text-center"><input type="text" class="form-control" id="namabomedit'.$urut.'" name="namabomedit[]" value="'.$detbom['DESCRIPTION'].'" readonly="readonly"></td>

				<td class="text-center"><input onkeypress="return angkasaja(event, false)" type="text" class="form-control"  id="qtybom"  value="'.round($detbom['QTY'],3).'" name ="qtybomedit[]"></td>

				<td class="text-center"><button class="btn btn-sm btn-danger hpspack'.$urut.'" onclick="hapuspack('.$urut.')"><i class="fa fa-minus"></i></button></td>
			</tr>';
			$urut++;
		}

		$tabeldetail = '<div id="editbom">
								<table class="table table-bordered">
								<thead class ="bg-yellow">
										<th class="text-center" style="width: 50px">Kode</th>
										<th class="text-center" style="width: 200px">Nama</th>
										<th class="text-center" style="width: 50px">Qty</th>
										<th class="text-center" style="width: 20px">Action</th>
									</thead>
									<tbody id="tambahpack">
											'.$tbody.'
									</tbody>
								</table>
								<div style="text-align: right;">
									<button class="btn btn-info btn-sm" onclick="tambahpack('.$urut.')">Tambah Pack</button>
									<button class="btn btn-success btn-sm">Usulkan</button>

								</div>
							</div>';
} else{
	$tabeldetail = '<div id="editbom" >
								<h3 style="font-weight: bold; text-align : center;">Belum ada BOM</h3>
							</div>';
}
		echo $tabeldetail;
}

public function exportbomall()
{
	require_once APPPATH.'third_party/Excel/PHPExcel.php';
	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

	$objPHPExcel = new PHPExcel();

// ---------------------------- BORDERING ---------------------------------//
	$thin = array ();
	$thin['borders']=array();
	$thin['borders']['allborders']=array();
	$thin['borders']['allborders']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$right = array ();
	$right['borders']=array();
	$right['borders']['right']=array();
	$right['borders']['right']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$left = array ();
	$left['borders']=array();
	$left['borders']['left']=array();
	$left['borders']['left']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$bottom = array ();
	$bottom['borders']=array();
	$bottom['borders']['bottom']=array();
	$bottom['borders']['bottom']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$top = array ();
	$top['borders']=array();
	$top['borders']['top']=array();
	$top['borders']['top']['style']=PHPExcel_Style_Border::BORDER_THIN;

	

// ------------------------------------------ ISI ---------------------------------------- //
	$objPHPExcel->setActiveSheetIndex(0);
	$worksheet = $objPHPExcel->getActiveSheet(0);


	$kodeitem=$this->input->post('kodeitem[]');
	$namaitem=$this->input->post('namaitem[]');


	// echo "<pre>";print_r($namaitem);exit();
	$arrayexport=array();
	for ($i=0; $i < sizeof($kodeitem) ; $i++) { 
		$arr = array(
			'kodeitem' => $kodeitem[$i], 
			'namaitem' => $namaitem[$i]
		);
		array_push($arrayexport, $arr);
	}
	// echo "<pre>";print_r($arrayexport);exit();
	$a=0;
	foreach ($arrayexport as $export) {
		$bom = $this->M_rkhkasie->getDetailBom($export['kodeitem']);
		// echo "<pre>";print_r($bom);
		$i=0;
		if ($bom != null) {
			foreach ($bom as $value) {
			$arrayexport[$a]['bom'][$i]['pack'] = 'Pack '.$value['LINE_ID'];
			$arrayexport[$a]['bom'][$i]['kode'] = $value['COMPONENT_NUM'];
			$arrayexport[$a]['bom'][$i]['nama'] = $value['DESCRIPTION'];
			$arrayexport[$a]['bom'][$i]['qty'] = $value['QTY'];
			$arrayexport[$a]['bom'][$i]['isi'] = 1 / $value['QTY'];

			$i++; 
		}
		} else{
			$arrayexport[$a]['bom']= null;
		}
	$a++;	
	}
	// echo "<pre>";print_r($arrayexport);exit();

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "No");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Kode Item");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Nama Item");
	$worksheet->getStyle('A1:F1')->applyFromArray ($thin);
	$worksheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold( true );

	$linearray=2;
	$line = 1;
	foreach ($arrayexport as $exp) {
	$worksheet->getStyle('A'.$linearray.':'.'F'.$linearray)->applyFromArray ($thin);
	$worksheet->mergeCells('D'.$linearray.':'.'F'.$linearray);
	$worksheet->mergeCells('B'.$linearray.':'.'C'.$linearray);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$linearray,$line);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$linearray, $exp['kodeitem']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$linearray, $exp['namaitem']);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$linearray.':'.'F'.$linearray)->getFont()->setItalic( true );


	$linearraysub = $linearray +1;
	$worksheet->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->applyFromArray ($thin);
	$worksheet->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->getFont()->setBold( true );

	$linearraysub2 = $linearraysub +1;

	if ($exp['bom'] !=null) {

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$linearraysub, "Pack");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$linearraysub, "Kode");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$linearraysub, "Nama");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$linearraysub, "Qty");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$linearraysub, "Isi");
		
		foreach ($exp['bom'] as $bom) {
	$worksheet->getStyle('A'.$linearraysub2.':'.'F'.$linearraysub2)->applyFromArray ($thin);
		$worksheet->mergeCells('A'.$linearraysub.':'.'A'.$linearraysub2);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$linearraysub2, $bom['pack']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$linearraysub2, $bom['kode'] );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$linearraysub2, $bom['nama'] );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$linearraysub2, round($bom['qty'],3));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$linearraysub2, round($bom['isi'],3));
		$worksheet->getStyle('E'.$linearraysub2.':'.'F'.$linearraysub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


		$linearraysub2++;
		}
	} else {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$linearraysub, "Tidak Ada BOM");
		$worksheet->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9E9E9E');
		$worksheet->mergeCells('A'.$linearraysub.':'.'F'.$linearraysub);
		$worksheet->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	}
	$line++;
	// $linearray+sizeof($exp['bom'])+1;
	$linearray = $linearraysub2;
	}
	// ---------------------------------- MERGE CELL ------------------------------------//

	$worksheet->mergeCells('B1:C1');
	$worksheet->mergeCells('D1:E1');
	$worksheet->mergeCells('E1:F1');
	// ----------------------------------- AUTO SIZE -------------------------------//

		$worksheet->getColumnDimension('A')->setAutoSize(true);
		$worksheet->getColumnDimension('B')->setAutoSize(true);
		$worksheet->getColumnDimension('C')->setAutoSize(true);
		$worksheet->getColumnDimension('D')->setAutoSize(true);
		$worksheet->getColumnDimension('E')->setAutoSize(true);
		$worksheet->getColumnDimension('F')->setAutoSize(true);





	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="List BOM All.xlsx"');
	ob_end_clean();
	$objWriter->save("php://output");
}
public function exportbomada()
{
	require_once APPPATH.'third_party/Excel/PHPExcel.php';
	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

	$objPHPExcel = new PHPExcel();

// ---------------------------- BORDERING ---------------------------------//
	$thin = array ();
	$thin['borders']=array();
	$thin['borders']['allborders']=array();
	$thin['borders']['allborders']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$right = array ();
	$right['borders']=array();
	$right['borders']['right']=array();
	$right['borders']['right']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$left = array ();
	$left['borders']=array();
	$left['borders']['left']=array();
	$left['borders']['left']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$bottom = array ();
	$bottom['borders']=array();
	$bottom['borders']['bottom']=array();
	$bottom['borders']['bottom']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$top = array ();
	$top['borders']=array();
	$top['borders']['top']=array();
	$top['borders']['top']['style']=PHPExcel_Style_Border::BORDER_THIN;

	

// ------------------------------------------ ISI ---------------------------------------- //
	$objPHPExcel->setActiveSheetIndex(0);
	$worksheet = $objPHPExcel->getActiveSheet(0);


	$kodeitem=$this->input->post('kodeitem[]');
	$namaitem=$this->input->post('namaitem[]');


	// echo "<pre>";print_r($namaitem);exit();
	$arrayexport=array();
	for ($i=0; $i < sizeof($kodeitem) ; $i++) { 
		$arr = array(
			'kodeitem' => $kodeitem[$i], 
			'namaitem' => $namaitem[$i]
		);
		array_push($arrayexport, $arr);
	}
	// echo "<pre>";print_r($arrayexport);exit();
	$a=0;
	foreach ($arrayexport as $export) {
		$bom = $this->M_rkhkasie->getDetailBom($export['kodeitem']);
		// echo "<pre>";print_r($bom);
		$i=0;
		if ($bom != null) {
			foreach ($bom as $value) {
			$arrayexport[$a]['bom'][$i]['pack'] = 'Pack '.$value['LINE_ID'];
			$arrayexport[$a]['bom'][$i]['kode'] = $value['COMPONENT_NUM'];
			$arrayexport[$a]['bom'][$i]['nama'] = $value['DESCRIPTION'];
			$arrayexport[$a]['bom'][$i]['qty'] = $value['QTY'];
			$arrayexport[$a]['bom'][$i]['isi'] = 1 / $value['QTY'];

			$i++; 
		}
		} else{
			$arrayexport= null;
		}
	$a++;	
	}
	// echo "<pre>";print_r($arrayexport);exit();

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "No");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Kode Item");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Nama Item");
	$worksheet->getStyle('A1:F1')->applyFromArray ($thin);
	$worksheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold( true );

	$linearray=2;
	$line = 1;
	foreach ($arrayexport as $exp) {
	$worksheet->getStyle('A'.$linearray.':'.'F'.$linearray)->applyFromArray ($thin);
	$worksheet->mergeCells('D'.$linearray.':'.'F'.$linearray);
	$worksheet->mergeCells('B'.$linearray.':'.'C'.$linearray);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$linearray,$line);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$linearray, $exp['kodeitem']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$linearray, $exp['namaitem']);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$linearray.':'.'F'.$linearray)->getFont()->setItalic( true );


	$linearraysub = $linearray +1;
	$worksheet->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->applyFromArray ($thin);
	$worksheet->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$linearraysub.':'.'F'.$linearraysub)->getFont()->setBold( true );

	$linearraysub2 = $linearraysub +1;


		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$linearraysub, "Pack");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$linearraysub, "Kode");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$linearraysub, "Nama");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$linearraysub, "Qty");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$linearraysub, "Isi");
		
		foreach ($exp['bom'] as $bom) {
	$worksheet->getStyle('A'.$linearraysub2.':'.'F'.$linearraysub2)->applyFromArray ($thin);
		$worksheet->mergeCells('A'.$linearraysub.':'.'A'.$linearraysub2);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$linearraysub2, $bom['pack']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$linearraysub2, $bom['kode'] );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$linearraysub2, $bom['nama'] );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$linearraysub2, round($bom['qty'],3));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$linearraysub2, round($bom['isi'],3));
		$worksheet->getStyle('E'.$linearraysub2.':'.'F'.$linearraysub2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


		$linearraysub2++;
		}
	$line++;
	// $linearray+sizeof($exp['bom'])+1;
	$linearray = $linearraysub2;
	}
	// ---------------------------------- MERGE CELL ------------------------------------//

	$worksheet->mergeCells('B1:C1');
	$worksheet->mergeCells('D1:E1');
	$worksheet->mergeCells('E1:F1');
	// ----------------------------------- AUTO SIZE -------------------------------//

		$worksheet->getColumnDimension('A')->setAutoSize(true);
		$worksheet->getColumnDimension('B')->setAutoSize(true);
		$worksheet->getColumnDimension('C')->setAutoSize(true);
		$worksheet->getColumnDimension('D')->setAutoSize(true);
		$worksheet->getColumnDimension('E')->setAutoSize(true);
		$worksheet->getColumnDimension('F')->setAutoSize(true);





	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="List BOM Ada.xlsx"');
	ob_end_clean();
	$objWriter->save("php://output");
}
public function exportbomtdk()
{
	require_once APPPATH.'third_party/Excel/PHPExcel.php';
	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';

	$objPHPExcel = new PHPExcel();

// ---------------------------- BORDERING ---------------------------------//
	$thin = array ();
	$thin['borders']=array();
	$thin['borders']['allborders']=array();
	$thin['borders']['allborders']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$right = array ();
	$right['borders']=array();
	$right['borders']['right']=array();
	$right['borders']['right']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$left = array ();
	$left['borders']=array();
	$left['borders']['left']=array();
	$left['borders']['left']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$bottom = array ();
	$bottom['borders']=array();
	$bottom['borders']['bottom']=array();
	$bottom['borders']['bottom']['style']=PHPExcel_Style_Border::BORDER_THIN;

	$top = array ();
	$top['borders']=array();
	$top['borders']['top']=array();
	$top['borders']['top']['style']=PHPExcel_Style_Border::BORDER_THIN;

	

// ------------------------------------------ ISI ---------------------------------------- //
	$objPHPExcel->setActiveSheetIndex(0);
	$worksheet = $objPHPExcel->getActiveSheet(0);


	$kodeitem=$this->input->post('kodeitem[]');
	$namaitem=$this->input->post('namaitem[]');


	// echo "<pre>";print_r($namaitem);exit();
	$arrayexport=array();
	for ($i=0; $i < sizeof($kodeitem) ; $i++) { 
		$arr = array(
			'kodeitem' => $kodeitem[$i], 
			'namaitem' => $namaitem[$i]
		);
		array_push($arrayexport, $arr);
	}
	// echo "<pre>";print_r($arrayexport);exit();


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "No");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Kode Item");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Nama Item");
	$worksheet->getStyle('A1:F1')->applyFromArray ($thin);
	$worksheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold( true );

	$linearray=2;
	$line = 1;
	foreach ($arrayexport as $exp) {
	$worksheet->getStyle('A'.$linearray.':'.'F'.$linearray)->applyFromArray ($thin);
	$worksheet->mergeCells('D'.$linearray.':'.'F'.$linearray);
	$worksheet->mergeCells('B'.$linearray.':'.'C'.$linearray);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$linearray,$line);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$linearray, $exp['kodeitem']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$linearray, $exp['namaitem']);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$linearray.':'.'F'.$linearray)->getFont()->setItalic( true );

	$line++;
	$linearray++;
	}
	// ---------------------------------- MERGE CELL ------------------------------------//

	$worksheet->mergeCells('B1:C1');
	$worksheet->mergeCells('D1:F1');
	// $worksheet->mergeCells('E1:F1');
	// ----------------------------------- AUTO SIZE -------------------------------//

		$worksheet->getColumnDimension('A')->setAutoSize(true);
		$worksheet->getColumnDimension('B')->setAutoSize(true);
		$worksheet->getColumnDimension('C')->setAutoSize(true);
		$worksheet->getColumnDimension('D')->setAutoSize(true);
		$worksheet->getColumnDimension('E')->setAutoSize(true);
		$worksheet->getColumnDimension('F')->setAutoSize(true);





	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="List BOM Tidak Ada.xlsx"');
	ob_end_clean();
	$objWriter->save("php://output");
}

	}
