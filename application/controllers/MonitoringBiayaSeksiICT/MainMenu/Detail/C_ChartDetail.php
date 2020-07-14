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
		
		$data['Menu'] = 'Detail';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data['SectionList'] = $this->M_chart->GetSectionList();
		$data['AccountList'] = $this->M_chart->GetAccountList('1E01');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringBiayaSeksiICT/MainMenu/Detail/V_ChartDetail',$data);
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
		$arr   = array( 'label'  => [],
					    'tahun1' => [],
					    'tahun2' => []  );
		$bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

		$sec = $this->input->post('SecName');
		$acc = $this->input->post('AccName');

		$data['FinanceCostByAccountName'] = $this->M_chart->GetFinanceCostByAccountNameAndSectionName($sec,$acc);

		foreach ($data['FinanceCostByAccountName'] as $key => $val) {
			array_push($arr['label'], $bulan[$val['BULAN']]);
			array_push($arr['tahun1'], $val['TAHUN1']/2000000);
			array_push($arr['tahun2'], $val['TAHUN2']/2000000);
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
		$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

		$data['FinanceCostByAccountNameAndSectionname'] = $this->M_chart->GetFinanceCostByAccountNameAndSectionName($sec,$acc);

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true)->setSize(13);
		$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:C1')->mergeCells('A2:C2')->mergeCells('A3:C3')->mergeCells('A4:C4');

		$objset = $objPHPExcel->setActiveSheetIndex(0);
		
		$objset->setCellValue("A1", "GRAFIK INDEKS BIAYA BULANAN SEKSI ICT");
		$objset->setCellValue("A2", "AKUN ".$acc);
		$objset->setCellValue("A3", "Januari 2018 - ".$bulan[(date('m')-1)]." 2018");
		$objset->setCellValue("A4", "Januari 2019 - ".$bulan[(date('m')-1)]." 2019");

		$objset->setCellValue("A6", "BULAN");
		$objset->setCellValue("B6", "TAHUN 1");
		$objset->setCellValue("C6", "TAHUN 2");

		$row = 7;
		foreach ($data['FinanceCostByAccountNameAndSectionname'] as $key => $val) {
			$objset->setCellValue("A".$row, $val['BULAN']);
			$objset->setCellValue("B".$row, $val['TAHUN1']/2000000);
			$objset->setCellValue("C".$row, $val['TAHUN2']/2000000);
			$row++;
		}
					
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:C6')
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Keuangan')
					->getStyle('A7:C'.(count($data['FinanceCostByAccountNameAndSectionname'])+6))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Monitoring Indeks Biaya Bulanan Seksi ICT Akun '.$acc.' - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}
	
	public function ExportDetailReportToExcel($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$id = explode('-',$id);
		$sec = $id[0];
		$acc = $id[1];
		$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

		$data['FinanceCostByAccountNameAndSectionname'] = $this->M_chart->GetFinanceCostDetailReportByAccountNameAndSectionName($sec,$acc);

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true)->setSize(13);
		$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1')->mergeCells('A2:D2')->mergeCells('A3:D3');

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "GRAFIK DETAIL INDEKS BIAYA BULANAN SEKSI ICT");
		$objset->setCellValue("A2", "AKUN ".$acc);
		$objset->setCellValue("A3", "Januari 2019 - ".$bulan[(date('m')-1)]." 2019");

		$objset->setCellValue("A5", "No");
		$objset->setCellValue("B5", "TANGGAL DIBUAT");
		$objset->setCellValue("C5", "TOTAL");
		$objset->setCellValue("D5", "KETERANGAN");

		$row = 6;
		foreach ($data['FinanceCostByAccountNameAndSectionname'] as $key => $val) {
			$objset->setCellValue("A".$row, $key+1);
			$objset->setCellValue("B".$row, $val['CREATION_DATE']);
			$objset->setCellValue("C".$row, $val['TOTAL']/2000000);
			$objset->setCellValue("D".$row, $val['DESCRIPTION']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:D5')
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Keuangan')
					->getStyle('A6:D'.(count($data['FinanceCostByAccountNameAndSectionname'])+5))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Detail Monitoring Indeks Biaya Bulanan Seksi ICT Akun '.$acc.' - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}

}