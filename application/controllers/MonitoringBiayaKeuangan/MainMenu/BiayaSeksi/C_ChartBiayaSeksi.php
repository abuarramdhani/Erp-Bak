<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ChartBiayaSeksi extends CI_Controller 
{

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

		$this->load->model('MonitoringBiayaKeuangan/MainMenu/M_chart');
       	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		 }
	}

	public function checkSession() 
	{
		if ( $this->session->is_logged ) {
		} else {
			redirect('');
		}
	}

	public function index() 
	{
        $this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Bi. Seksi Tinggi ke Rendah';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringBiayaKeuangan/MainMenu/BiayaSeksi/V_ChartBiayaSeksi',$data);
        $this->load->view('V_Footer',$data);
	}

	public function AjaxGetSortedFinanceCostTotal()
	{
		$arr['label'] = array();
		$arr['tahun1'] = array();
		$arr['tahun2'] = array();

		$data['SortedFinanceCostTotal'] = $this->M_chart->GetSortedFinanceCostTotal();

		foreach ($data['SortedFinanceCostTotal'] as $key => $val) {
			array_push($arr['label'], array($val['FLEX_VALUE'], $val['DESCRIPTION']));
			array_push($arr['tahun1'], $val['TAHUN_1']);
			array_push($arr['tahun2'], $val['TAHUN_2']);
		}

		echo json_encode($arr);
	}
		
	public function ExportReportToExcel()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['SortedFinanceCostTotal'] = $this->M_chart->GetSortedFinanceCostTotal();

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "No");
		$objset->setCellValue("B1", "FLEX VALUE");
		$objset->setCellValue("C1", "DESCRIPTION");
		$objset->setCellValue("D1", "TAHUN 1");
		$objset->setCellValue("E1", "TAHUN 2");

		$row = 2;
		foreach ($data['SortedFinanceCostTotal'] as $key => $val) {
			$objset->setCellValue("A".$row, $key+1);
			$objset->setCellValue("B".$row, $val['FLEX_VALUE']);
			$objset->setCellValue("C".$row, $val['DESCRIPTION']);
			$objset->setCellValue("D".$row, $val['TAHUN_1']);
			$objset->setCellValue("E".$row, $val['TAHUN_2']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Keuangan')
					->getStyle('A1:E'.(count($data['SortedFinanceCostTotal'])+1))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Monitoring Biaya Keuangan - Biaya Seksi Tinggi ke Rendah - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}

}