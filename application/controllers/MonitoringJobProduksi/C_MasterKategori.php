<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterKategori extends CI_Controller
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
		$this->load->model('MonitoringJobProduksi/M_masterkategori');
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

		$data['Title'] = 'Data Master Kategori';
		$data['Menu'] = 'Data Master';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_MasterKategori', $data);
		$this->load->view('V_Footer',$data);
    }
    
    public function search(){
			$data['data'] = $this->M_masterkategori->getdata('');
		// echo "<pre>";print_r($data['data']);exit();
			$this->load->view('MonitoringJobProduksi/V_TblMaster', $data);
		}
	
    public function saveCategory(){
			$kategori = strtoupper($this->input->post('kategori'));
			$sub_kategori = $this->input->post('sub_kategori');
			// echo "<pre>";print_r($sub_kategori);exit();
			$cekID 		= $this->M_masterkategori->getdata("order by id_category desc");
			$id 			= !empty($cekID) ? $cekID[0]['ID_CATEGORY'] + 1 : 1;

			$cek = $this->M_masterkategori->getdata("where category_name = '".$kategori."'");
			if (empty($cek) && $kategori != '') {
				$this->M_masterkategori->saveKategori($id, $kategori);
				for ($i=0; $i < count($sub_kategori) ; $i++) { 
					$ceksub		= $this->M_masterkategori->getSubKategori("where id_category = $id and subcategory_name = '".$sub_kategori[$i]."'");
					if (!empty($sub_kategori[$i]) && empty($ceksub)) {
						$ceksub = $this->M_masterkategori->getSubKategori("order by id_subcategory desc");
						$id_sub	= !empty($ceksub) ? $ceksub[0]['ID_SUBCATEGORY'] + 1 : 1;
						$sub = strtoupper($sub_kategori[$i]);
						$this->M_masterkategori->saveSubCategory($id, $id_sub, $sub);
					}
				}
			}
		}
		
		public function editCategory(){
			$data['id'] 			= $this->input->post('id');
			$data['kategori'] 		= $this->input->post('kategori');
			$data['sub_kategori']	= $this->M_masterkategori->getSubKategori("where id_category = ".$data['id']."");
			$data['data_kategori']	= $this->M_masterkategori->getdata("where id_category = ".$data['id']."");
			// echo "<pre>";print_r($data);exit();
			$this->load->view('MonitoringJobProduksi/V_MdlEditMaster', $data);
		}

		public function updateBulan(){
			$id 	= $this->input->post('id');
			$bulan 	= sprintf("%02d", $this->input->post('bulan'));
			$data	= $this->M_masterkategori->getdata("where id_category = ".$id."");
			$bulan_kategori = $data[0]['MONTH'];
			$ket 	= $this->input->post('ket');
			if ($ket == 'N') {
				$month = !empty($bulan_kategori) ? $bulan_kategori.', '.$bulan : $bulan;
			}else {
				$bln = explode(", ", $bulan_kategori);
				$month = '';
				for ($i=0; $i < count($bln) ; $i++) { 
					if ($bln[$i] != $bulan) {
						$month = !empty($month) ? $month.', '.$bln[$i] : $bln[$i];
					}
				}
			}
			
			$this->M_masterkategori->updateBulan($id, $month);
		}
		
		public function updateCategory(){
			$id 			= $this->input->post('id');
			$kategori 		= strtoupper($this->input->post('kategori'));
			$sub			= $this->input->post('sub_kategori');
			// echo "<pre>";print_r($sub);exit();
			$cek = $this->M_masterkategori->getdata("where category_name = '".$kategori."'");
			if (empty($cek) && $kategori != '') {
				$this->M_masterkategori->updateKategori($id, $kategori);
			}
			for ($i=0; $i < count($sub) ; $i++) { 
				$ceksub		= $this->M_masterkategori->getSubKategori("where id_category = $id and subcategory_name = '".$sub[$i]."'");
				if (empty($ceksub) && !empty($sub[$i])) {
					$ceksub		= $this->M_masterkategori->getSubKategori("order by id_subcategory desc");
					$idsub		= empty($ceksub) ? 1 : $ceksub[0]['ID_SUBCATEGORY'] + 1;
					$subctgr	= strtoupper($sub[$i]);
					$this->M_masterkategori->saveSubCategory($id, $idsub, $subctgr);
				}
			}
		}
	
    public function deleteCategory(){
			$id = $this->input->post('id');
			$kategori = $this->input->post('kategori');
			$subcategory = $this->M_masterkategori->getSubKategori("where id_category = '$id'");
			if (!empty($subcategory)) {
				for ($s=0; $s < count($subcategory) ; $s++) { 
					$item = $this->M_itemlist->getdata("where category_name = '$id' and id_subcategory = ".$subcategory[$s]['ID_SUBCATEGORY']."");
					$idsub = "id_subcategory =  ".$subcategory[$s]['ID_SUBCATEGORY']."";
					$this->deleteitem($item, $id, $idsub);
				}
			}else {
				$item = $this->M_itemlist->getdata("where category_name = '$id'");
				$idsub = "id_subcategory is null";
				$this->deleteitem($item, $id, $idsub);
			}
			// echo "<pre>";print_r($item);exit();
			
			$this->M_masterkategori->deletesubcategory($id);
			$this->M_masterkategori->deletecategory($id, $kategori);
		}
		
		public function deleteitem($item, $id, $idsub){
			if (!empty($item)) {
				for ($i=0; $i < count($item); $i++) { 
					$plan = $this->M_setplan->getPlan("where inventory_item_id = '".$item[$i]['INVENTORY_ITEM_ID']."' and id_category = $id and $idsub");
					if (!empty($plan)) {
						$plandate = $this->M_setplan->getPlanDate('where plan_id = '.$plan[0]['PLAN_ID'].'');
						if (!empty($plandate)) {
							$this->M_setplan->deletePlanDate2($plan[0]['PLAN_ID']);
						}
						$this->M_setplan->deletePlan($plan[0]['PLAN_ID']);
					}
					$this->M_itemlist->deleteitem($id,$item[$i]['INVENTORY_ITEM_ID'], $idsub);
				}
			}
		}



}