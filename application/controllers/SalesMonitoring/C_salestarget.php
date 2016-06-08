<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_salestarget extends CI_Controller {

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
		$this->load->model('SalesMonitoring/M_salestarget');
		$this->load->helper('download');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
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
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$thismonth = date('m');
		$thisyear = date('Y');
		
		$data['salestarget'] = $this->M_salestarget->viewSalestarget($thismonth,$thisyear);
		$data['source_year'] = $this->M_salestarget->viewYear();
		$data['source_organization'] = $this->M_salestarget->viewOrganization();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/V_salestarget',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//indeks dari halaman update
	public function updateSalestarget($id)
	{
		$select = $this->M_salestarget->searchSalestarget($id);
		$data['source'] = $this->M_salestarget->viewOrganization();
		$data['selected'] = $select;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/update/V_updatesalestarget',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//indeks dari halaman create
	public function createSalestarget()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['source'] = $this->M_salestarget->viewOrganization();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/create/V_createsalestarget',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//menambah data
	public function create()
	{
		$orgid = $this->input->post('txt_organization');
		$ordertype = $this->input->post('txt_order_type');
		$target = $this->input->post('txt_target');
		$month = $this->input->post('txt_month');
		$year = $this->input->post('txt_year');
		$startdate = $this->input->post('txt_start_date');
		$enddate = $this->input->post('txt_end_date');
		$lastupdated = $this->input->post('txt_last_updated');
		$lastupdateby = $this->input->post('txt_last_update_by');
		$creationdate = $this->input->post('txt_creation_date');
		$createdby = $this->input->post('txt_created_by');
		$create = $this->M_salestarget->insertSalestarget($ordertype,$month,$year,$target,$orgid,$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,$createdby);
		redirect('SalesMonitoring/salestarget');
	}
	
	//menghapus data
	public function delete($id)
	{
		$this->M_salestarget->deleteSalestarget($id);
		redirect('SalesMonitoring/salestarget');
	}
	
	//memperbaharui data
	public function update()
	{
		$id = $this->input->post('txt_sales_target_id');
		$orgid = $this->input->post('txt_organization');
		$ordertype = $this->input->post('txt_order_type');
		$target = $this->input->post('txt_target');
		$month = $this->input->post('txt_month');
		$year = $this->input->post('txt_year');
		$update = $this->M_salestarget->updateSalestarget($id,$orgid,$ordertype,$target,$month,$year);
		redirect('SalesMonitoring/salestarget');	
	}
	
	//download file as CSV
	public function downloadcsv(){
		$row  = $this->M_salestarget->downloadSalestargetcsv();
        $name = 'Salestarget.csv';
        force_download($name,$row);
	}
	
	//download file as XML
	public function downloadxml(){
		$row  = $this->M_salestarget->downloadSalestargetxml();
        $name = 'Salestarget.xml';
        force_download($name,$row);
	}
	
	//download filter file as pdf
	public function downloadpdffilter(){
		$organization = $this->input->post('txt_profilter_organization');
		$month = $this->input->post('txt_profilter_month');
		$year = $this->input->post('txt_profilter_year');
		
		$data['data'] = $this->M_salestarget->filterSalestarget($month,$year,$organization);
		$filename= 'salestargetfiltered'.time().'.pdf';
		$data['page_title'] = 'Salestarget Filtered';

		ini_set('memory_limit','300M');
		$html = $this->load->view('SalesMonitoring/setting/pdf/V_pdfsalestarget', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Quick Sales Management |{PAGENO}| Sales Target');
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');

	}
	
	//download file as pdf
	public function downloadpdf(){
		$data['data'] = $this->M_salestarget->viewFullsalestarget();
		$filename= 'salestarget'.time().'.pdf';
		$data['page_title'] = 'Salestarget';
		ini_set('memory_limit','300M');
		$html = $this->load->view('SalesMonitoring/setting/pdf/V_pdfsalestarget', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Quick Sales Management |{PAGENO}| Sales Target');
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
		
		
		$data['source_year'] = $this->M_salestarget->viewYear();
		$data['source_organization'] = $this->M_salestarget->viewOrganization();
		
		$organization = $this->input->post('txt_profilter_organization');
		$month = $this->input->post('txt_profilter_month');
		$year = $this->input->post('txt_profilter_year');
		
		$data['select_org'] = $organization;
		$data['select_mon'] = $month;
		$data['select_yea'] = $year;
		
		$result = $this->M_salestarget->filterSalestarget($month,$year,$organization);
		$data['result'] = $result;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/profilter/V_filtersalestarget',$data);
		$this->load->view('V_Footer',$data);
	}
}
?>