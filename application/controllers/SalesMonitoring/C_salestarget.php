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
		$this->load->view('SalesMonitoring/setting/SalesTarget/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//indeks dari halaman update
	public function updateSalestarget($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$select = $this->M_salestarget->searchSalestarget($id);
		$data['source'] = $this->M_salestarget->viewOrganization();
		$data['selected'] = $select;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/SalesTarget/V_update',$data);
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
		$data['sourceOrderType'] = $this->M_salestarget->viewOrderType();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/salestarget/V_create',$data);
		$this->load->view('V_Footer',$data);
	}
//ajax selection
	public function filterOrganization()
	{
		$select = $this->input->post('select');
		$getCode = $this->M_salestarget->viewOrganization2($select);
		$code = $getCode[0]['org_code'];
		$getOrderType = $this->M_salestarget->viewOrderType2($code);
		echo json_encode($getOrderType);
	}

	public function filterOrganization2()
	{
		$select = $this->input->post('select');
		$getCode = $this->M_salestarget->viewOrganization2($select);
		$code = $getCode[0]['org_code'];
		$getOrderType = $this->M_salestarget->viewOrderType2($code);
		echo json_encode($getOrderType);
	}

	public function showTable()
	{
		$select = $this->input->post('select');
		$getOrderType = $this->M_salestarget->viewTabel($select);
		$data['order'] = $getOrderType;

		return $this->load->view('SalesMonitoring/setting/SalesTarget/V_tableOrder',$data);
	}

	public function SettingOrg()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		
		$data['province'] = $this->M_salestarget->viewProvince();
		$data['org'] = $this->M_salestarget->viewContentSetup();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/SalesTarget/V_setting_organization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function filterCity()
	{
		$prov_id = $this->input->post('prov');
		$getCity = $this->M_salestarget->viewCity($prov_id);

		echo json_encode($getCity);
	}

	public function filterDistrict()
	{
		$city_id = $this->input->post('city');
		$getDis = $this->M_salestarget->viewDistrict($city_id);

		echo json_encode($getDis);
	}

	public function filterVillage()
	{
		$kcmtn_id = $this->input->post('kcmtn');
		$getVill = $this->M_salestarget->viewVillage($kcmtn_id);

		echo json_encode($getVill);
	}

	public function saveSetupOrg()
	{
		$province = $this->input->post('province');
		$city = $this->input->post('city');
		$kecamatan = $this->input->post('kecamatan');
		$kelurahan = $this->input->post('kelurahan');
		$alamat = $this->input->post('alamat');
		$org_id = $this->input->post('org_id');
		$org_code = strtoupper($this->input->post('org_code'));
		$org_name = strtoupper($this->input->post('org_name'));

		$cekDuplikasi = $this->M_salestarget->cekRow($org_id);
		if ($cekDuplikasi == '0') {
		$this->M_salestarget->saveSetup($province,$city,$kecamatan,$kelurahan,$alamat,$org_id,$org_code,$org_name);
		echo json_encode(1);
		}else if ($cekDuplikasi !=='0'){
		echo json_encode(0);
		}
	}

	public function deleteOrg()
	{
		$org_id = $this->input->post('org_id');
		$delete = $this->M_salestarget->deleteOrg($org_id);
	}

	public function deleteOrder()
	{
		$item_id = $this->input->post('item_id');
		$delete = $this->M_salestarget->deleteOrder($item_id);
	}

	public function detailOrderEdit()
	{
		$item_id = $this->input->post('item_id');
		$data['order'] = $this->M_salestarget->getDataOrder($item_id);

		return $this->load->view('SalesMonitoring/setting/SalesTarget/v_mdlOrder',$data);
	}

	public function updateOrder()
	{
		$item_id = $this->input->post('item_id');
		$order = $this->input->post('new_order');

		$this->M_salestarget->updateOrder($item_id,$order);
	}

	public function insertOrder()
	{
		$order_type = $this->input->post('order_type');
		$param = $this->input->post('param'); //org_id
		$org_code = $this->M_salestarget->getCodeAndName($param);
		$code = $org_code[0]['ORG_CODE'];
		$org_name = $this->M_salestarget->getCodeAndName($param);
		$name = $org_name[0]['ORG_NAME'];

		$this->M_salestarget->insertNewOrderType($order_type,$param,$code,$name);
	}

	public function openMdlDetail()
	{
		$org_id = $this->input->post('org_id');
		$data['province'] = $this->M_salestarget->viewProvince();
		$data['list'] = $this->M_salestarget->getDataDetail($org_id);
		return $this->load->view('SalesMonitoring/setting/SalesTarget/V_mdlDetail',$data);
	}

	public function filterCity2()
	{
		$prov_id = $this->input->post('prov');
		$getCity = $this->M_salestarget->viewCity($prov_id);

		echo json_encode($getCity);
	}

	public function filterDistrict2()
	{
		$city_id = $this->input->post('city');
		$getDis = $this->M_salestarget->viewDistrict($city_id);

		echo json_encode($getDis);
	}

	public function filterVillage2()
	{
		$kcmtn_id = $this->input->post('kcmtn');
		$getVill = $this->M_salestarget->viewVillage($kcmtn_id);

		echo json_encode($getVill);
	}

	public function updateSetupOrg()
	{
		// echo "<pre>";print_r($_POST);exit();
		$province = $this->input->post('province');
		$city = $this->input->post('city');
		$kecamatan = $this->input->post('kecamatan');
		$kelurahan = $this->input->post('kelurahan');
		$alamat = $this->input->post('alamat');
		$org_id = $this->input->post('org_id');
		$org_code = strtoupper($this->input->post('org_code'));
		$org_name = strtoupper($this->input->post('org_name'));

		$this->M_salestarget->updateOrg($province,$city,$kecamatan,$kelurahan,$alamat,$org_id,$org_code,$org_name);
	}


	public function SettingOrder()
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
		// $data['sourceOrderType'] = $this->M_salestarget->viewOrderType();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/setting/SalesTarget/V_setting_order',$data);
		$this->load->view('V_Footer',$data);
	}

	public function createPlaceHolder()
	{
		$select = $this->input->post('select');
		$cek = $this->M_salestarget->viewOrganization2($select);
		$cekk = $cek[0]['org_code'];

		echo json_encode($cekk);

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
		$lastupdateby = $this->input->post('txt_last_update_by');
		$update = $this->M_salestarget->updateSalestarget($id,$orgid,$ordertype,$target,$month,$year,$lastupdateby);
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
		$organization = $this->input->post('txt_pdf_organization');
		$month = $this->input->post('txt_pdf_month');
		$year = $this->input->post('txt_pdf_year');
		
		$data['data'] = $this->M_salestarget->filterSalestarget($month,$year,$organization);
		$filename= 'salestargetfiltered'.time().'.pdf';
		$data['page_title'] = 'Salestarget Filtered';

		ini_set('memory_limit','300M');
		$html = $this->load->view('SalesMonitoring/setting/SalesTarget/V_pdf', $data, true);
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
		$html = $this->load->view('SalesMonitoring/setting/SalesTarget/V_pdf', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('Quick Sales Management |{PAGENO}| Sales Target');
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
		$this->load->view('SalesMonitoring/setting/SalesTarget/V_filter',$data);
		$this->load->view('V_Footer',$data);
	}
}
?>