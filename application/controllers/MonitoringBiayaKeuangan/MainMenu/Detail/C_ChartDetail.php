<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ChartDetail extends CI_Controller 
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
		if ( $this->session->is_logged ){
		} else {
			redirect('');
		}
	}

	public function index() 
	{
        $this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Detail';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data['SectionList'] = $this->M_chart->GetSectionList();
		$data['AccountList'] = $this->M_chart->GetAccountList();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringBiayaKeuangan/MainMenu/Detail/V_ChartDetail',$data);
        $this->load->view('V_Footer',$data);
	}
	
	public function AjaxGetAccountListBySectionName()
	{
		$sec = $this->input->post('SecName');

		$data['SectionList'] = $this->M_chart->GetAccountList($sec);

		echo json_encode($data);
	}

	public function AjaxGetFinanceCostByAccountNameAndSection() 
	{
		$arr['label'] = array();
		$arr['tahun1'] = array();
		$arr['tahun2'] = array();
		$bulan = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

		$sec = $this->input->post('SecName');
		$acc = $this->input->post('AccName');

		$data['FinanceCostByAccountName'] = $this->M_chart->GetFinanceCostByAccountNameAndSectionName($sec,$acc);

		foreach ($data['FinanceCostByAccountName'] as $key => $val) {
			array_push($arr['label'], $bulan[$val['BULAN']]);
			array_push($arr['tahun1'], $val['TAHUN1']);
			array_push($arr['tahun2'], $val['TAHUN2']);
		}

		echo json_encode($arr);
	}

	public function ExportReportToExcel($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$id = explode('-',$id);
		$sec = $id[0];
		$acc = $id[1];

		$data['FinanceCostByAccountNameAndSectionname'] = $this->M_chart->GetFinanceCostByAccountNameAndSectionName($sec,$acc);

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "BULAN");
		$objset->setCellValue("B1", "TAHUN 1");
		$objset->setCellValue("C1", "TAHUN 2");

		$row = 2;
		foreach ($data['FinanceCostByAccountNameAndSectionname'] as $key => $val) {
			$objset->setCellValue("A".$row, $val['BULAN']);
			$objset->setCellValue("B".$row, $val['TAHUN1']);
			$objset->setCellValue("C".$row, $val['TAHUN2']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Keuangan')
					->getStyle('A1:C'.(count($data['FinanceCostByAccountNameAndSectionname'])+1))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Monitoring Biaya Keuangan - Biaya Bulanan - Seksi '.$sec.' Akun '.$acc.' - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}
	
	public function ExportDetailReportToExcel($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$id = explode('-',$id);
		$sec = $id[0];
		$acc = $id[1];

		$data['FinanceCostByAccountNameAndSectionname'] = $this->M_chart->GetFinanceCostDetailReportByAccountNameAndSectionName($sec,$acc);

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(80);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "No");
		$objset->setCellValue("B1", "TANGGAL DIBUAT");
		$objset->setCellValue("C1", "TOTAL");
		$objset->setCellValue("D1", "KETERANGAN");

		$row = 2;
		foreach ($data['FinanceCostByAccountNameAndSectionname'] as $key => $val) {
			$objset->setCellValue("A".$row, $key+1);
			$objset->setCellValue("B".$row, $val['CREATION_DATE']);
			$objset->setCellValue("C".$row, $val['TOTAL']);
			$objset->setCellValue("D".$row, $val['DESCRIPTION']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Keuangan')
					->getStyle('A1:D'.(count($data['FinanceCostByAccountNameAndSectionname'])+1))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Monitoring Biaya Keuangan - Detail Biaya Bulanan - Seksi '.$sec.' Akun '.$acc.' - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}

}