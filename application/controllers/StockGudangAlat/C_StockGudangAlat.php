<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_StockGudangAlat extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('personalia');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StockGudangAlat/M_stockgudangalat');

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
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Title'] = '';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['lihat_stok'] = $this->M_stockgudangalat->insertTable();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGudangAlat/V_InputStock',$data);
		$this->load->view('V_Footer',$data);
    }
    
    public function insertData() {
		// echo "<pre>";
		// print_r($_POST);exit();
		$tag =$this->input->post('tag');
        $nama =$this->input->post('nama');
        $merk =$this->input->post('merk');
        $qty =$this->input->post('qty');
		// $jenis =$this->input->post('jenis');
		$pilihan = $this->input->post('pilihan');
		// echo $tag;
		// echo $nama;
		// echo $merk;
		// echo $qty;
		// echo $pilihan;
		// exit();

		$this->M_stockgudangalat->insertData($tag,$nama,$merk,$qty,$pilihan); 

		redirect("StockGudangAlat/");
	}


}
?> 