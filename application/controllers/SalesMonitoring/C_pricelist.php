<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_pricelist extends CI_Controller {

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
		$this->load->model('SalesMonitoring/M_pricelist');
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
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['source_itemname'] = $this->M_pricelist->viewItemname();
		$data['source_itemcode'] = $this->M_pricelist->viewItemcode();
		
		$data['pricelist'] = $this->M_pricelist->viewPricelist();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/pricelist/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//indeks dari halaman create
	public function createPricelist()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/pricelist/V_create');
		$this->load->view('V_Footer',$data);
	}
	
	//indeks dari halaman update
	public function updatePricelist($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$select = $this->M_pricelist->searchPricelist($id);
		$data['selected']= $select;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/pricelist/V_update',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//menambah data
	public function create()
	{
		$itemcode = $this->input->post('txt_item_code');
		$price = $this->input->post('txt_price');
		$startdate = $this->input->post('txt_start_date');
		$enddate = $this->input->post('txt_end_date');
		$lastupdated = $this->input->post('txt_last_updated');
		$lastupdateby = $this->input->post('txt_last_update_by');
		$creationdate = $this->input->post('txt_creation_date');
		$createdby = $this->input->post('txt_created_by');
		$create = $this->M_pricelist->insertPricelist($itemcode,$price,$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,$createdby);
		redirect('SalesMonitoring/pricelist');
	}
	
	//menghapus data
	public function delete($id)
	{
		$this->M_pricelist->deletePricelist($id);
		redirect('SalesMonitoring/pricelist');
	}
	
	//memperbaharui data
	public function update()
	{
		$id = $this->input->post('txt_pricelist_index_id');
		$itemcode = $this->input->post('txt_item_code');
		$price = $this->input->post('txt_price');
		$startdate = $this->input->post('txt_start_date');
		$enddate = $this->input->post('txt_end_date');
		$lastupdated = $this->input->post('txt_last_updated');
		$lastupdateby = $this->input->post('txt_last_update_by');
		$creationdate = $this->input->post('txt_creation_date');
		$createdby = $this->input->post('txt_created_by');
		$update = $this->M_pricelist->updatePricelist($id,$itemcode,$price,$startdate,$enddate,$lastupdated,$lastupdateby,$creationdate,$createdby);
		redirect('SalesMonitoring/pricelist');		
	}
	
	//download file as CSV
	public function downloadcsv(){
		$row  = $this->M_pricelist->downloadpricelistcsv();
        $name = 'Pricelist.csv';
        force_download($name,$row);
	}
	
	//download file as XML
	public function downloadxml(){
		$row  = $this->M_pricelist->downloadpricelistxml();
        $name = 'Pricelist.xml';
        force_download($name,$row);
	}
	
	//download file as pdf
	public function downloadpdf(){
		$data['data'] = $this->M_pricelist->viewPricelist();
		$filename= 'pricelist'.time().'.pdf';
		$data['page_title'] = 'Pricelist';

			ini_set('memory_limit','3000M');
			$html = $this->load->view('SalesMonitoring/setting/pricelist/V_pdf', $data, true);
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf->SetFooter('Quick Sales Management |{PAGENO}| Pricelist Index');
			$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
			$pdf->WriteHTML($html);
			$pdf->Output($filename, 'D');
		
	}
	
	//profilter index
	public function profilter(){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['source_itemname'] = $this->M_pricelist->viewItemname();
		$data['source_itemcode'] = $this->M_pricelist->viewItemcode();
		
		$itemcode = $this->input->post('txt_profilter_itemcode');
		$productname = $this->input->post('txt_profilter_productname');

		$pricelow = $this->input->post('txt_profilter_pricelow'); if ($pricelow==""){$pricelow="pi.price";};
		$pricehigh = $this->input->post('txt_profilter_pricehigh'); if ($pricehigh==""){$pricehigh="pi.price";};
		
		$data['select_ico'] = $itemcode;
		$data['select_pna'] = $productname;
		$data['select_plo'] = $pricelow;
		$data['select_phi'] = $pricehigh;
		
		$result = $this->M_pricelist->filterPricelist($itemcode,$productname,$pricelow,$pricehigh);
		$data['result'] = $result;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/pricelist/V_filter',$data);
		$this->load->view('V_Footer',$data);
	}
	
	
}
