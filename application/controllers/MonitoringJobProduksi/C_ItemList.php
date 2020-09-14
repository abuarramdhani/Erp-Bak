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
    
  public function search(){
			$kategori = $this->input->post('kategori');
			$getdata = $this->M_itemlist->getdata("where category_name = '$kategori'");
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
		$org_id 	= $this->M_itemlist->getitem2($inv_id);
		$cek = $this->M_itemlist->getdata("where category_name = '$kategori' and inventory_item_id = '$inv_id'");
		if (empty($cek)) {
			$this->M_itemlist->saveitem($kategori,$inv_id, $org_id[0]['ORGANIZATION_ID']);
			echo 'oke';
		}else {
			echo 'not oke';
		}
  }
	
  public function deleteitem(){
		$inv_id 	= $this->input->post('inv_id');
		$kategori 	= $this->input->post('kategori');
		$this->M_itemlist->deleteitem($kategori,$inv_id);
  }



}