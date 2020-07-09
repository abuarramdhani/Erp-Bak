<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ChartDetail extends CI_Controller {

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
		
		$data['Menu'] = 'Detail';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data['GroupList'] = $this->M_chart->GetGroupList();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringBiayaProduksi/MainMenu/Detail/V_ChartDetail',$data);
        $this->load->view('V_Footer',$data);
	}

	public function AjaxGetFinanceCostByGroupName()
	{
		$arr = array(
			'label' => [],
			'tahun1' => [],
			'tahun2' => []
		);

		$bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

		$group = $this->input->post('GroupName');

		$data['FinanceCostByGroupName'] = $this->M_chart->GetFinanceCostByGroupName($group);

		foreach ($data['FinanceCostByGroupName'] as $key => $val) {
			array_push($arr['label'], $bulan[$val['BULAN']]);
			array_push($arr['tahun1'], $val['TAHUN1']);
			array_push($arr['tahun2'], $val['TAHUN2']);
		}

		echo json_encode($arr);
	}

	public function ExportReportToExcel($id)
	{
		$this->checkSession();

		$data['FinanceCostByGroupName'] = $this->M_chart->GetFinanceCostByGroupName($id);
		$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
	
		$group = $this->input->post('GroupName');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
		$objPHPExcel->getActiveSheet()->mergeCells('A1:C1')->mergeCells('A2:C2')->mergeCells('A3:C3')->mergeCells('A4:C4');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "BIAYA BULANAN DEPARTEMEN PRODUKSI");
		$objset->setCellValue("A2", $group);
		$objset->setCellValue("A3", "Januari 2018 - ".$bulan[(date('m')-1)]." 2018");
		$objset->setCellValue("A4", "Januari 2019 - ".$bulan[(date('m')-1)]." 2019");
		$objset->setCellValue("A6", "BULAN");
		$objset->setCellValue("B6", "TAHUN 1");
		$objset->setCellValue("C6", "TAHUN 2");

		$row = 7;
		foreach ($data['FinanceCostByGroupName'] as $key => $val) {
			$objset->setCellValue("A".$row, $val['BULAN']);
			$objset->setCellValue("B".$row, $val['TAHUN1']);
			$objset->setCellValue("C".$row, $val['TAHUN2']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:C6')
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Produksi')
					->getStyle('A7:C'.(count($data['FinanceCostByGroupName'])+7))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Biaya Bulanan - Golongan '.$group.' - Dept. Produksi - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}
	
	public function ExportDetailReportToExcel($id)
	{
		$this->checkSession();

		$data['FinanceCostDetailByGroupName'] = $this->M_chart->GetFinanceCostDetailByGroupName($id);
		$bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
	
		$group = $this->input->post('GroupName');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(80);		
		$objPHPExcel->getActiveSheet()->mergeCells('A1:D1')->mergeCells('A2:D2')->mergeCells('A3:D3')->mergeCells('A4:D4');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);

		$objset = $objPHPExcel->setActiveSheetIndex(0);

		$objset->setCellValue("A1", "DETAIL BIAYA BULANAN DEPARTEMEN PRODUKSI");
		$objset->setCellValue("A2", $group);
		$objset->setCellValue("A3", "Januari 2018 - ".$bulan[(date('m')-1)]." 2018");
		$objset->setCellValue("A4", "Januari 2019 - ".$bulan[(date('m')-1)]." 2019");
		$objset->setCellValue("A6", "No");
		$objset->setCellValue("B6", "TOTAL");
		$objset->setCellValue("C6", "CREATION DATE");
		$objset->setCellValue("D6", "LINE DESCRIPTION");

		$row = 7;
		foreach ($data['FinanceCostDetailByGroupName'] as $key => $val) {
			$objset->setCellValue("A".$row, $key+1);
			$objset->setCellValue("B".$row, $val['TOTAL']);
			$objset->setCellValue("C".$row, $val['CREATION_DATE']);
			$objset->setCellValue("D".$row, $val['LINE_DESCRIPTION']);
			$row++;
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:D6')
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()
					->setTitle('Monitoring Biaya Produksi')
					->getStyle('A7:D'.(count($data['FinanceCostDetailByGroupName'])+7))
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report Detail Biaya Bulanan - Golongan '.$group.' - Dept. Produksi - '.date('d M Y').'.xlsx"');
		$objWriter->save("php://output");
	}

}