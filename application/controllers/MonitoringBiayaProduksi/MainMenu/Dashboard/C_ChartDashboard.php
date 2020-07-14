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

		$this->load->model('MonitoringBiayaProduksi/MainMenu/M_chart');
       	  
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
	
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringBiayaProduksi/MainMenu/Dashboard/V_ChartDashboard',$data);
        $this->load->view('V_Footer',$data);
	}
		
	public function AjaxGetFinanceCostDashboard() 
	{
		$arr = array(
			'label' => [], 
			'tahun1' => [], 
			'tahun2' => []
		);

		$data['FinanceCostProductionDepartment'] = $this->M_chart->GetFinanceCostDashboard();

		foreach ($data['FinanceCostProductionDepartment'] as $key => $val) {
			array_push($arr['label'], $val['GOLONGAN']);
			array_push($arr['tahun1'], $val['TAHUN_1']);
			array_push($arr['tahun2'], $val['TAHUN_2']);
		}

		echo json_encode($arr);

	}

	public function ExportReportToExcel()
	{
		$this->checkSession();

		$data['FinanceCostProductionDepartment'] = $this->M_chart->GetFinanceCostDashboard();
		$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
	
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1')->mergeCells('A2:D2')->mergeCells('A3:D3');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12);

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "BIAYA PER GOLONGAN DEPARTEMEN PRODUKSI");
		$objset->setCellValue("A2", "Januari 2018 - ".$bulan[(date('m')-1)]." 2018");
		$objset->setCellValue("A3", "Januari 2019 - ".$bulan[(date('m')-1)]." 2019");
		$objset->setCellValue("A5", "No");
		$objset->setCellValue("B5", "GOLONGAN");
		$objset->setCellValue("C5", "TAHUN 1");
		$objset->setCellValue("D5", "TAHUN 2");

		$row = 6;
		foreach ($data['FinanceCostProductionDepartment'] as $key => $val) {
			$objset->setCellValue("A".$row, $key+1);
			$objset->setCellValue("B".$row, $val['GOLONGAN']);
			$objset->setCellValue("C".$row, $val['TAHUN_1']);
			$objset->setCellValue("D".$row, $val['TAHUN_2']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:D5')
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Produksi')
					->getStyle('A6:D'.(count($data['FinanceCostProductionDepartment'])+6))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Biaya Per Golongan - Dept. Produksi - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}

}