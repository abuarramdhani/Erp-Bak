<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MinMax extends CI_Controller
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
		$this->load->model('StockGdSparepart/M_minmax');

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

		$data['Title'] = 'Min Max';
		$data['Menu'] = 'Min Max';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_minmax->getdata();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGdSparepart/V_MinMax', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function uploadminmax(){
		require_once APPPATH.'third_party/Excel/PHPExcel.php';
		require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
		 
			$file_data  = array();
			 // load excel
			  $file = $_FILES['excel_file']['tmp_name'];
			  $load = PHPExcel_IOFactory::load($file);
			  $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
	
			//   echo "<pre>";
			//   print_r($sheets);
			//   exit();
	
			$i=1;
			  foreach($sheets as $row) {
				   if ($i != 1 && $i != 2) {
					   $item[] = $row['B'];
					   $desc[] = $row['C'];
					   $min[] = $row['D'];
					   $max[] = $row['E'];
					   $uom[] = $row['F'];
				   }
				   $i++;
			  }
			  
			$jml = sizeof($item);
			$data['import'] = array();
			  for ($b=0; $b < $jml; $b++) { 
				$array = array(
					'item' => $item[$b],
					'desc' => $desc[$b],
					'min' => $min[$b],
					'max' => $max[$b],
					'uom' => $uom[$b],
				);
				array_push($data['import'], $array);
				// $this->M_minmax->insertData($item[$b], $min[$b], $max[$b], $uom[$b]);
			}

		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Min Max';
		$data['Menu'] = 'Min Max';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGdSparepart/V_TblMinMax', $data);
		$this->load->view('V_Footer',$data);
			// redirect(base_url('StockGdSparepart/MinMaxStock'));
	}

	public function saveminmax(){
		$item = $this->input->post('item');
		$desc = $this->input->post('desc');
		$min = $this->input->post('min');
		$max = $this->input->post('max');
		$uom = $this->input->post('uom');

		$jml = sizeof($item);
		for ($b=0; $b < $jml; $b++) { 
			$cek = $this->M_minmax->cekimport($item[$b]);
			if (empty($cek)) {
				$this->M_minmax->insertData($item[$b], $desc[$b], $min[$b], $max[$b], $uom[$b]);
			}else {
				$this->M_minmax->updateData($item[$b], $min[$b], $max[$b]);
			}
		}
		redirect(base_url('StockGdSparepart/MinMaxStock'));
	}

	public function exportminmaxstock(){
		$getdata = $this->M_minmax->getdata();

		include APPPATH.'third_party/Excel/PHPExcel.php';
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('CV. KHS')
						->setLastModifiedBy('Quick')
						->setTitle("Min Max Stock Gudang Sparepart")
						->setSubject("CV. KHS")
						->setDescription("Min Max Stock Gudang Sparepart")
						->setKeywords("MinMax");
			
			$style_title = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
			);
			$style1 = array(
				'font' => array(
					'bold' => true,
					'wrap' => true,
				), 
				'alignment' => array(
					'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
			);
			$style2 = array(
				'alignment' => array(
					'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),'left' 		=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				
			);

			//TITLE
			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Min Max Stock Gudang Sparepart"); 
			$excel->getActiveSheet()->mergeCells('A1:F1'); 
			$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);

			$excel->setActiveSheetIndex(0)->setCellValue('A2', "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B2', "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('C2', "DESKRIPSI");
			$excel->setActiveSheetIndex(0)->setCellValue('D2', "MIN");
			$excel->setActiveSheetIndex(0)->setCellValue('E2', "MAX");
			$excel->setActiveSheetIndex(0)->setCellValue('F2', "UOM");
			$excel->getActiveSheet()->getStyle('A2')->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('B2')->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('C2')->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('D2')->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('E2')->applyFromArray($style1);
			$excel->getActiveSheet()->getStyle('F2')->applyFromArray($style1);

			$no=1;
			$numrow = 3;
			foreach ($getdata as $val) {
				// echo "<pre>";print_r($val['ITEM']);exit();
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['ITEM']);
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['DESCRIPTION']);
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['MIN']);
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['MAX']);
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['UOM']);
				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
			$numrow++;
			$no++; 
			}
			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(70); 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			// Set orientasi kertas jadi LANDSCAPE
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			// Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Min Max Stock Gudang Sparepart");
			$excel->setActiveSheetIndex(0);
			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Min Max Stock Gudang Sparepart.xlsx"'); 
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
	}
}