<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_salesomset extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() 
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('SalesMonitoring/M_salesomset');
		$this->load->helper('download');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	//indeks
	public function index()
	{
		$thismonth = date('m');
		$thisyear = date('Y');
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['salesomset'] = $this->M_salesomset->viewSalesomset($thismonth,$thisyear);
		$data['source_year'] = $this->M_salesomset->viewYear();
		$data['source_organization'] = $this->M_salesomset->viewOrganization();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/salesomset/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//download file as CSV
	public function downloadcsv(){
		$row  = $this->M_salesomset->downloadSalesomsetcsv();
        $name = 'Salesomset.csv';
        force_download($name,$row);
	}
	
	//download file as XML
	public function downloadxml(){
		$row  = $this->M_salesomset->downloadSalesomsetxml();
        $name = 'Salesomset.xml';
        force_download($name,$row);
	}
	
	//download file as pdf
	public function downloadpdf(){
		$data['data'] = $this->M_salesomset->viewFullsalesomset();
		$filename= 'salesomset'.time().'.pdf';
		$data['page_title'] = 'Salesomset';

		ini_set('memory_limit','300M');
		$html = $this->load->view('SalesMonitoring/setting/salesomset/V_pdf', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Quick Sales Management |{PAGENO}| Sales Omset');
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');

	}
	
	//download filter file as pdf
	public function downloadpdffilter(){
		$organization = $this->input->post('txt_pdf_organization');
		$month = $this->input->post('txt_pdf_month');
		$year = $this->input->post('txt_pdf_year');
		
		$data['data'] = $this->M_salesomset->filterSalesomset($month,$year,$organization);
		$filename= 'salesomsetfiltered'.time().'.pdf';
		$data['page_title'] = 'Salesomset Filtered';

		ini_set('memory_limit','300M');
		$html = $this->load->view('SalesMonitoring/setting/salesomset/V_pdf', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Quick Sales Management |{PAGENO}| Sales Omset');
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');

	}
	
	//profilter ndex
	public function profilter(){
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['source_year'] = $this->M_salesomset->viewYear();
		$data['source_organization'] = $this->M_salesomset->viewOrganization();
		
		$organization = $this->input->post('txt_profilter_organization');
		$month = $this->input->post('txt_profilter_month');
		$year = $this->input->post('txt_profilter_year');
		
		$data['select_org'] = $organization;
		$data['select_mon'] = $month;
		$data['select_yea'] = $year;
		
		$result = $this->M_salesomset->filterSalesomset($month,$year,$organization);
		$data['result'] = $result;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/salesomset/V_filter',$data);
		$this->load->view('V_Footer',$data);
	}
}
