<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_report extends CI_Controller {
 
	public function __construct()
		{
			parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MorningGreeting/report/M_report');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->helper('download');
			$this->checkSession();
		}
	
	public function checkSession(){
			if($this->session->is_logged){

			}else{
				redirect('');
			}
		}
		
	//Menampilkan halaman menu report
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['data_branch'] = $this->M_report->data_branch();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/report/V_report',$data);
		$this->load->view('V_Footer',$data);
	}
	
//----------------------------------------------REPORT ALL ------------------------------------------------
	//Menampilkan SEMUA DATA report
	public function showAll()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['data_branch'] = $this->M_report->data_branch();

		$rangeAll = $this->input->post('rangeAll');

		$exRangeAll = explode(' - ', $rangeAll);
		//print_r($exRangeAll);
		//exit;
		$rangeAllStart = $exRangeAll[0];
		$rangeAllEnd = $exRangeAll[1];

		$data['range'] = $rangeAll;
		$data['data'] = $this->M_report->searchReportAll($rangeAllStart,$rangeAllEnd);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/report/V_reportShowAll',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//download file as CSV
	public function showAllDownloadCsv()
	{
		$rangeAll = $this->input->post('range');
		$exRangeAll = explode(' - ', $rangeAll);
		$rangeAllStart = $exRangeAll[0];
		$rangeAllEnd = $exRangeAll[1];

		$row  = $this->M_report->showAllDownloadCsv($rangeAllStart,$rangeAllEnd);
      $name = 'reportAll.csv';
      force_download($name,$row);
	}
	
	//download file as XML
	public function showAllDownloadXml()
	{
		$rangeAll = $this->input->post('range');
		$exRangeAll = explode(' - ', $rangeAll);
		$rangeAllStart = $exRangeAll[0];
		$rangeAllEnd = $exRangeAll[1];

		$row  = $this->M_report->showAllDownloadXml($rangeAllStart,$rangeAllEnd);
      $name = 'reportAll.xml';
      force_download($name,$row);
	}
	
	//download filter file as pdf
	public function showAllDownloadPdf(){
		$rangeAll = $this->input->post('range');
		$exRangeAll = explode(' - ', $rangeAll);
		$rangeAllStart = $exRangeAll[0];
		$rangeAllEnd = $exRangeAll[1];

		$data['range'] = $rangeAll;
		$data['data'] = $this->M_report->searchReportAll($rangeAllStart,$rangeAllEnd);
		$data['data_branch'] = $this->M_report->data_branch();
		$filename= 'Report-Data-By-Relation'.time().'.pdf';
		$data['page_title'] = 'Report Data Morning Greeting All Branch';

		ini_set('memory_limit','300M');
		$html = $this->load->view('MorningGreeting/report/pdf/V_pdfReportAll', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Morning Greeting Report ---- {PAGENO} ---- Show All Branch');
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');
	}
		

//----------------------------------------------REPORT by BRANCH ------------------------------------------------
	//Menampilkan DATA BRANCH report
	public function showByBranch()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$org_id = $this->input->post('org_id');
		$rangeBranch = $this->input->post('rangeBranch');
		$exRangeBranch = explode(' - ', $rangeBranch);
		$rangeBranchStart = $exRangeBranch[0];
		$rangeBranchEnd = $exRangeBranch[1];

		$data['branch'] = $this->M_report->reportDataBranch($org_id);
		$data['range'] = $rangeBranch;
		$data['data'] = $this->M_report->searchReportByBranch($org_id,$rangeBranchStart,$rangeBranchEnd);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/report/V_reportShowByBranch');
		$this->load->view('V_Footer',$data);
	}
	
	//download file as CSV
	public function showByBranchDownloadCsv()
	{
		$org_id = $this->input->post('org_id');
		$rangeBranch = $this->input->post('range');
		$exRangeBranch = explode(' - ', $rangeBranch);
		$rangeBranchStart = $exRangeBranch[0];
		$rangeBranchEnd = $exRangeBranch[1];
		$row  = $this->M_report->showByBranchDownloadCsv($org_id,$rangeBranchStart,$rangeBranchEnd);
      $name = 'reportByBranch.csv';
      force_download($name,$row);
	}
	
	//download file as XML
	public function showByBranchDownloadXml()
	{
		$org_id = $this->input->post('org_id');
		$rangeBranch = $this->input->post('range');
		$exRangeBranch = explode(' - ', $rangeBranch);
		$rangeBranchStart = $exRangeBranch[0];
		$rangeBranchEnd = $exRangeBranch[1];
		$row  = $this->M_report->showByBranchDownloadXml($org_id,$rangeBranchStart,$rangeBranchEnd);
      $name = 'reportByBranch.xml';
      force_download($name,$row);
	}
	
	//download filter file as pdf
	public function showByBranchDownloadPdf(){
		$org_id = $this->input->post('org_id');
		$rangeBranch = $this->input->post('range');
		$exRangeBranch = explode(' - ', $rangeBranch);
		$rangeBranchStart = $exRangeBranch[0];
		$rangeBranchEnd = $exRangeBranch[1];
		
		$data['branch'] = $this->M_report->reportDataBranch($org_id);
		$data['data'] = $this->M_report->searchReportByBranch($org_id,$rangeBranchStart,$rangeBranchEnd);
		$data['range'] = $rangeBranch;
		$filename= 'Report-Data-By-Branch'.time().'.pdf';
		$data['page_title'] = 'Report Data Morning Greeting By Branch';

		ini_set('memory_limit','300M');
		$html = $this->load->view('MorningGreeting/report/pdf/V_pdfReportByBranch', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Morning Greeting Report ---- {PAGENO} ---- Show By Branch');
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');
	} 
		

//----------------------------------------------REPORT by RELATION ------------------------------------------------
	public function showByRelation()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$org_id = $this->input->post('org_id');
		$month = $this->input->post('month');
		
		$data['data'] = $this->M_report->searchReportByRelation($org_id);
		$data['branch'] = $this->M_report->reportDataBranch($org_id);

		$data['month'] = $month;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MorningGreeting/report/V_reportShowByRelation',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//download report as CSV
	public function showByRelationDownloadCsv()
	{
		$org_id = $this->input->post('org_id');
		$row  = $this->M_report->downloadcsv($org_id);
      $name = 'reportByRelation.csv';
      force_download($name,$row);
	}
	
	//download report as XML
	public function showByRelationDownloadXml()
	{
		$org_id = $this->input->post('org_id');
		$row  = $this->M_report->downloadxml($org_id);
      $name = 'reportByRelation.xml';
      force_download($name,$row);
	}
	
	//download report as pdf
	public function showByRelationDownloadPdf(){
		$org_id = $this->input->post('org_id');
		
		$data['branch'] = $this->M_report->reportDataBranch($org_id);
		$data['data'] = $this->M_report->searchReportByRelation($org_id);
		$filename= 'Report-Data-By-Relation'.time().'.pdf';
		$data['page_title'] = 'Report Data Morning Greeting By Relation';

		ini_set('memory_limit','300M');
		$html = $this->load->view('MorningGreeting/report/pdf/V_pdfReportByRelation', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Morning Greeting Report ---- {PAGENO} ---- Show By Relation');
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');
	}
		
}
