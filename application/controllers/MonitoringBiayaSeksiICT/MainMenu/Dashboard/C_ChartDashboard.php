<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ChartDashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('Excel');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('MonitoringBiayaSeksiICT/MainMenu/M_chart');
       	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		 }
	}

	public function checkSession() 
	{
		if ( $this->session->is_logged ){
		} else {
			redirect('');
		}
	}

	public function index() 
	{
        $this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
					
		$data['SectionList'] = $this->M_chart->GetSectionList();
	
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringBiayaSeksiICT/MainMenu/Dashboard/V_ChartDashboard',$data);
        $this->load->view('V_Footer',$data);
	}
		
	public function AjaxGetFinanceCostDashboardBySectionName() 
	{
		$arr = array( 'label'  => [],
			 	      'tahun1' => [],
					  'tahun2' => []  );

		$id = $this->input->post('SecName');

		$data['FinanceCostBySectionName'] = $this->M_chart->GetFinanceCostDashboardBySectionName($id);

		foreach ($data['FinanceCostBySectionName'] as $key => $val) {
			array_push($arr['label'], array($val['FLEX_VALUE'], $val['DESCRIPTION']));
			array_push($arr['tahun1'], $val['TAHUN_1']/2000000);
			array_push($arr['tahun2'], $val['TAHUN_2']/2000000);
		}

		echo json_encode($arr);

	}

	public function ExportReportToExcel($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
		$data['FinanceCostBySectionName'] = $this->M_chart->GetFinanceCostDashboardBySectionName($id);

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true)->setSize(13);
		$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:E1')->mergeCells('A2:E2')->mergeCells('A3:E3');

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "GRAFIK INDEKS BIAYA SEKSI ICT");
		$objset->setCellValue("A2", "Januari 2018 - ".$bulan[(date('m')-1)]." 2018");
		$objset->setCellValue("A3", "Januari 2019 - ".$bulan[(date('m')-1)]." 2019");

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A5", "No");
		$objset->setCellValue("B5", "FLEX VALUE");
		$objset->setCellValue("C5", "DESCRIPTION");
		$objset->setCellValue("D5", "TAHUN 1");
		$objset->setCellValue("E5", "TAHUN 2");

		$row = 6;
		foreach ($data['FinanceCostBySectionName'] as $key => $val) {
			$objset->setCellValue("A".$row, $key+1);
			$objset->setCellValue("B".$row, $val['FLEX_VALUE']);
			$objset->setCellValue("C".$row, $val['DESCRIPTION']);
			$objset->setCellValue("D".$row, $val['TAHUN_1']/2000000);
			$objset->setCellValue("E".$row, $val['TAHUN_2']/2000000);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:E5')
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Keuangan')
					->getStyle('A6:E'.(count($data['FinanceCostBySectionName'])+5))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Monitoring Indeks Biaya Seksi ICT - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}

}