<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_PekerjaApd extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('General');
		$this->load->model('M_Index');
		$this->load->model('MonitoringKomponen/MainMenu/M_monitoring_seksi');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PengembalianApd/M_papd');
		$this->load->library('excel');
		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function menu()
	{
		$user = $this->session->user;
		$data = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Pengembalian APD', '', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}
		// echo '<pre>';
		// print_r($data);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Hardware/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pekerja()
	{
		$data  = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Pengembalian APD', 'Pekerja', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}
		$data['list'] = $this->M_papd->getListPengembalianPekerja(substr($kodesie, 0, 7));

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PengembalianAPD/pekerja/V_Pekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getSemuaPkjTpribadi()
	{
		$noind = strtoupper($this->input->get('s'));
		$data = $this->M_papd->ListSemuaPkjTpribadi($noind);
		echo json_encode($data);
	}

	public function add_data()
	{
		$data  = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Input Data', 'Pekerja', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}

		$data['arr'] = array(
			'APRON DADA', 'APRON KAKI','APRON LENGAN','BAJU SUPPORT','BODY HARNESS','HELM','SPECTACLE CLEAR','SPECTACLE SMOKE',
			'RESPIRATOR','SAFETY GOOGLE CLEAR','SAFETY GOOGLE SMOKE','SAFETY SHOES'
			);
		$data['ukuran'] = array('S', 'M', 'L', 'XL');
		for ($i=30; $i < 61; $i++) { 
			$data['ukuran'][] = $i;
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PengembalianAPD/pekerja/V_Add_Data',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_data()
	{
		// echo "<pre>";
		// print_r($_POST);
		$user = $this->session->user;
		$pekerja = $this->input->post('pekerja');
		$arr1 = array(
			'noind'	=>	$pekerja,
			'create_by'	=>	$user,
			'create_date'	=>	date('Y-m-d H:i:s'),
			);
		// $insApd = 1;
		$insApd = $this->M_papd->insertAPD($arr1);

		$apd = $this->input->post('apd');
		$status = $this->input->post('status');
		$jumlah = $this->input->post('jumlah');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');

		$data = array();
		for ($i=0; $i < count($apd); $i++) { 
			$arr2 = array(
				'id_apd'	=>	$insApd,
				'nama_apd'	=>	$apd[$i],
				'jumlah'	=>	$jumlah[$i],
				'jenis'	=>	$jenis[$i],
				'ukuran'	=>	$ukuran[$i],
				'status'	=>	$status[$i],
				);
			$data[] = $arr2;
		}
		$this->M_papd->insertAPDdetail($data);
		redirect('pengembalian-apd/pekerja');
		// echo "<pre>";
		// print_r($data);exit();
	}

	public function save_data2()
	{
		$user = $this->session->user;
		$pekerja = $this->input->post('pekerja');
		$arr1 = array(
			'noind'	=>	$pekerja,
			'create_by'	=>	$user,
			'create_date'	=>	date('Y-m-d H:i:s'),
			);
		$insApd = $this->M_papd->insertAPD($arr1);

		echo json_encode(true);
	}

	public function edit_data()
	{
		$id = $this->input->get('id');
		$data  = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Input Data', 'Pekerja', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}
		$data['id'] = $id;

		$data['barang'] = $this->M_papd->getListAPDbyID($id);
		$data['pkj'] = $this->M_papd->getListPengembalianById($id);
		$data['arr'] = array(
			'APRON DADA', 'APRON KAKI','APRON LENGAN','BAJU SUPPORT','BODY HARNESS','HELM','SPECTACLE CLEAR','SPECTACLE SMOKE',
			'RESPIRATOR','SAFETY GOOGLE CLEAR','SAFETY GOOGLE SMOKE','SAFETY SHOES'
			);
		$data['ukuran'] = array('S', 'M', 'L', 'XL');
		for ($i=30; $i < 61; $i++) { 
			$data['ukuran'][] = $i;
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PengembalianAPD/pekerja/V_Edit_Data',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_edit()
	{
		$apd = $this->input->post('apd');
		$status = $this->input->post('status');
		$jumlah = $this->input->post('jumlah');
		$jenis = $this->input->post('jenis');
		$ukuran = $this->input->post('ukuran');
		$id = $this->input->post('id');

		$data = array();
		for ($i=0; $i < count($apd); $i++) { 
			$arr2 = array(
				'id_apd'	=>	$id,
				'nama_apd'	=>	$apd[$i],
				'jumlah'	=>	$jumlah[$i],
				'jenis'	=>	$jenis[$i],
				'ukuran'	=>	$ukuran[$i],
				'status'	=>	$status[$i],
				);
			$data[] = $arr2;
		}
		$del = $this->M_papd->deleteAPDdetail($id);
		if($del)
		$this->M_papd->insertAPDdetail($data);
		
		redirect('pengembalian-apd/pekerja');
	}

	public function del_data()
	{
		$id = $this->input->get('id');
		$this->M_papd->deleteAPDdetail($id);
		$this->M_papd->deleteAPDdata($id);
		redirect('pengembalian-apd/pekerja');
	}
}