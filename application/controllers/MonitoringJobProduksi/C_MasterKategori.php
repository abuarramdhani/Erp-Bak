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
			$cekID 		= $this->M_masterkategori->getdata("order by id_category desc");
			$id 			= !empty($cekID) ? $cekID[0]['ID_CATEGORY'] + 1 : 1;

			$cek = $this->M_masterkategori->getdata("where category_name = '".$kategori."'");
			if (empty($cek)) {
				$this->M_masterkategori->saveKategori($id, $kategori);
				echo "oke";
			}else {
				echo "not oke";
			}
    }
	
    public function deleteCategory(){
			$id = $this->input->post('id');
			$kategori = $this->input->post('kategori');
			$this->M_masterkategori->deletecategory($id, $kategori);
    }



}