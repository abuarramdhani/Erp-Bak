<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_ItemList extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringJobProduksi/M_itemlist');
		$this->load->model('MonitoringJobProduksi/M_setplan');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Set Item List';
		$data['Menu'] = 'Set Item List';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['kategori'] = $this->M_itemlist->getCategory();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_ItemList', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function kodeitem(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_itemlist->getitem($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function cekSubCategory(){
		$kategori = $this->input->post('kategori');
		$getdata = $this->M_itemlist->getSubCategory("where id_category = '$kategori'");
		$view = '<option></option>';
		foreach ($getdata as $key => $value) {
			$view .= '<option value="'.$value['ID_SUBCATEGORY'].'">'.$value['SUBCATEGORY_NAME'].'</option>';
		}
		echo $view;
	}
    
  public function search(){
			$kategori = $this->input->post('kategori');
			$subkategori = $this->input->post('subkategori');
			$subkategori = $subkategori != '' ? "id_subcategory = $subkategori" : 'id_subcategory is NULL';
			$getdata = $this->M_itemlist->getdata("where category_name = '$kategori' and $subkategori");
			foreach ($getdata as $key => $value) {
				$item = $this->M_itemlist->getitem2($value['INVENTORY_ITEM_ID']);
				$getdata[$key]['ITEM'] = $item[0]['SEGMENT1'];
				$getdata[$key]['DESKRIPSI'] = $item[0]['DESCRIPTION'];
			}
			$data['data'] = $getdata;
		// echo "<pre>";print_r($data['data']);exit();
        $this->load->view('MonitoringJobProduksi/V_TblItem', $data);
	}
	
  public function saveitem(){
		$inv_id 	= $this->input->post('item');
		$kategori 	= $this->input->post('kategori');
		$subkategori 	= $this->input->post('subkategori');
		$sub = $subkategori != '' ? "id_subcategory = $subkategori" : 'id_subcategory is NULL';
		$org_id 	= $this->M_itemlist->getitem2($inv_id);
		$cek = $this->M_itemlist->getdata("where category_name = '$kategori' and inventory_item_id = '$inv_id' and $sub");
		if (empty($cek) && $inv_id != '') {
			$subkategori = $subkategori != '' ? $subkategori : 'NULL';
			$this->M_itemlist->saveitem($kategori,$inv_id, $org_id[0]['ORGANIZATION_ID'], $subkategori);
			echo 'oke';
		}else {
			echo 'not oke';
		}
  }
	
  public function deleteitem(){
		$inv_id 	= $this->input->post('inv_id');
		$kategori 	= $this->input->post('kategori');
		$subkategori 	= $this->input->post('subkategori');
		$sub = $subkategori != '' ? "id_subcategory = $subkategori" : 'id_subcategory is NULL';
		$plan = $this->M_setplan->getPlan("where inventory_item_id = '$inv_id' and id_category = $kategori and $sub");
		if (!empty($plan)) {
			$plandate = $this->M_setplan->getPlanDate('where plan_id = '.$plan[0]['PLAN_ID'].'');
			if (!empty($plandate)) {
				$this->M_setplan->deletePlanDate2($plan[0]['PLAN_ID']);
			}
			$this->M_setplan->deletePlan($plan[0]['PLAN_ID']);
		}
		$this->M_itemlist->deleteitem($kategori,$inv_id, $sub);
  }

	public function updateflag(){
		$inv_id 	= $this->input->post('inv_id');
		$kategori 	= $this->input->post('kategori');
		$subkategori 	= $this->input->post('subkategori');
		$sub = $subkategori != '' ? "id_subcategory = $subkategori" : 'id_subcategory is NULL';
		$flag 	= $this->input->post('flag');
		$flag		= $flag == 'Y' ? '' : 'Y';
		$this->M_itemlist->updateflag($inv_id, $kategori, $sub, $flag);
	}
	
	public function updateflagall(){
		$kategori 	= $this->input->post('kategori');
		$subkategori 	= $this->input->post('subkategori');
		$sub = $subkategori != '' ? "id_subcategory = $subkategori" : 'id_subcategory is NULL';
		$flag 	= $this->input->post('flag');
		$flag		= $flag == 'Y' ? '' : 'Y';
		$this->M_itemlist->updateflagall($kategori, $sub, $flag);
	}


}