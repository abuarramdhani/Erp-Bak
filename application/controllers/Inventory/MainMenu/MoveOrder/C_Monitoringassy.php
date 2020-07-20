<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoringassy extends CI_Controller
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
		$this->load->model('Inventory/M_monitoringassy','M_monitoringassy');


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

		$data['Title'] = 'Monitoring Assy';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Inventory/MainMenu/MoveOrder/V_FilterMon');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}

	public function sugestion()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringassy->selectassy($term);
		echo json_encode($data);
	}

		public function sugestiondept()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringassy->selectdept($term);
		echo json_encode($data);
	}

	public function Searchmonitoringassy(){

		$dept = $this->input->post('dept');
		$assy = $this->input->post('assy');
		// echo "<pre>";print_r($dept);print_r($assy);exit();

		$departement = NULL;
		$kodeassy = NULL;

		if ($dept != '') {
			$departement = "and bd.DEPARTMENT_CLASS_CODE = '$dept'";
		}
		if ($assy !='') {
			$kodeassy = "and msib.SEGMENT1 = '$assy'";
		}

		// echo "<pre>";print_r($departement);print_r($assy);exit();

		$monitoringassy = $this->M_monitoringassy->dataassy($departement, $kodeassy);

		// echo "<pre>";print_r($monitoringassy);exit();

		$data['monitoringassy'] = $monitoringassy;
		$this->load->view('Inventory/MainMenu/MoveOrder/V_Monitoringassy', $data);

	}

	public function exportPending(){
		$data['date'] = $this->input->post('date');
		$dept 	= $this->input->post('dept');
		$shift 	= $this->input->post('shift');
		$no_job = $this->input->post('no_job');
		$assy 	= $this->input->post('assy');

		$shift 	= $this->M_monitoringassy->getShift2($shift);
		$desc 	= $this->M_monitoringassy->getDescDept($dept);
		$data['shift'] 	= $shift[0]['DESCRIPTION'];
		$data['dept'] 	= $dept.' - '.$desc[0]['DESCRIPTION'];
		// echo "<pre>";print_r($desc);exit();

		$tampung = array();
		for ($i=0; $i < count($no_job) ; $i++) { 
			$no_job2	= explode('<>', $no_job[$i]);
			$assy2		= explode('<>', $assy[$i]);

			$atr = ",khs_inv_qty_att(wdj.ORGANIZATION_ID,wro.INVENTORY_ITEM_ID,wro.ATTRIBUTE1,wro.ATTRIBUTE2,'') atr";
			$cari = $this->M_monitoringassy->getKurang($no_job2[0],$atr);
			foreach ($cari as $kQty => $vQty) {
				if ($vQty['REQ'] > $vQty['ATR']){
					$cek = $this->M_monitoringassy->checkPicklist($no_job2[0]);
					if (empty($cek)) {
						$array = array(
							'no_job' => $no_job2[0],
							'kode_assy' => $assy2[0],
							'item' => $vQty['ITEM_CODE'],
							'desc' => $vQty['ITEM_DESC'],
							'subinv' => $vQty['GUDANG_ASAL'],
							'req' => $vQty['REQ'],
							'stok' => $vQty['ATR'],
						);
					array_push($tampung, $array);
					}
				}
			}
		}
		// echo "<pre>";print_r($tampung);exit();
		$data['data'] = $tampung;

		include APPPATH.'third_party/Excel/PHPExcel.php';
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('CV. KHS')
						->setLastModifiedBy('Quick')
						->setTitle("Report Pendingan Job")
						->setSubject("CV. KHS")
						->setDescription("Report Pendingan Job")
						->setKeywords("Job Pending");

			$style_title = array(
				'font' => array(
					'bold' => true,
					'size' => 15
				), 
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
			);
			$style_col = array(
				'font' => array('bold' => true), 
				'alignment' => array(
					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
					'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'		=> true
				),
				'borders' => array(
					'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
					'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
				)
			);
			$style = array(
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
			$style2 = array(
				'alignment' => array(
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

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Report Pendingan Job"); 
			$excel->getActiveSheet()->mergeCells('A1:H1'); 
			$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
			
			$excel->setActiveSheetIndex(0)->setCellValue('A3', "Department");
			$excel->setActiveSheetIndex(0)->setCellValue('A4', "Tanggal");
			$excel->setActiveSheetIndex(0)->setCellValue('A5', "Shift");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', ": ".$data['dept']);
			$excel->setActiveSheetIndex(0)->setCellValue('C4', ": ".$data['date']);
			$excel->setActiveSheetIndex(0)->setCellValue('C5', ": ".$data['shift']);
			$excel->setActiveSheetIndex(0)->setCellValue('A7', "NO.");
			$excel->setActiveSheetIndex(0)->setCellValue('B7', "NO. JOB");
			$excel->setActiveSheetIndex(0)->setCellValue('C7', "ITEM");
			$excel->setActiveSheetIndex(0)->setCellValue('D7', "KOMPONEN");
			$excel->setActiveSheetIndex(0)->setCellValue('E7', "DESKRIPSI");
			$excel->setActiveSheetIndex(0)->setCellValue('F7', "SUBINV");
			$excel->setActiveSheetIndex(0)->setCellValue('G7', "REQ");
			$excel->setActiveSheetIndex(0)->setCellValue('H7', "STOK");
			$excel->getActiveSheet()->mergeCells('A3:B3'); 
			$excel->getActiveSheet()->mergeCells('A4:B4'); 
			$excel->getActiveSheet()->mergeCells('A5:B5'); 
			$excel->getActiveSheet()->mergeCells('C3:H3'); 
			$excel->getActiveSheet()->mergeCells('C4:H4'); 
			$excel->getActiveSheet()->mergeCells('C5:H5'); 
			$excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E7')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F7')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G7')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H7')->applyFromArray($style_col);

			if (count($tampung) == 0){
				$excel->setActiveSheetIndex(0)->setCellValue('A8', "No data available in table"); 
				$excel->getActiveSheet()->mergeCells('A8:H8');
				$excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_title);
			}else {
				$no=1;
				$numrow = 8;
					foreach ($tampung as $val) {
						// echo "<pre>";print_r($val);exit();
						$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
						$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['no_job']);
						$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['kode_assy']);
						$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['item']);
						$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['desc']);
						$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['subinv']);
						$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['req']);
						$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['stok']);
						$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style);
						$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style);
						$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style);
						$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style);
						$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
						$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style);
						$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style);
						$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style);
					$numrow++;
					$no++; 
					}
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

			// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			// Set orientasi kertas jadi LANDSCAPE
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			// Set judul file excel nya
			$excel->getActiveSheet(0)->setTitle("Report Pendingan Job");
			$excel->setActiveSheetIndex(0);
			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Report-Pendingan-Job.xlsx"'); 
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');


	}


}