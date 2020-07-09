<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_HubkerApd extends CI_Controller
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
			redirect('');
		}
	}

	public function hubker()
	{
		$data = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Pengembalian APD', 'Hubker', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}
		
		$data['new'] = $this->M_papd->countStatusApd(0);
		$data['app'] = $this->M_papd->countStatusApd(1);
		$data['rej'] = $this->M_papd->countStatusApd(2);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PengembalianAPD/hubker/V_Hubker_View',$data);
		$this->load->view('V_Footer',$data);
	}

	public function view_data()
	{
		$stat = $this->input->get('stat');
		$data  = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Pengembalian APD', 'Hubker', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}
		if ($stat == 'all') {
			$data['list'] = $this->M_papd->getListPengembalian();
		}else{
			$data['list'] = $this->M_papd->getListPengembalianbyStat($stat);
		}
		$data['stat'] = $stat;
		// echo $stat;exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PengembalianAPD/hubker/V_Table',$data);
		$this->load->view('V_Footer',$data);
	}

	public function view_data_detail()
	{
		$id = $this->input->get('id');
		$data  = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Pengembalian APD', 'Hubker', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}
		$data['list'] = $this->M_papd->getListPengembalian();

		$data['barang'] = $this->M_papd->getListAPDbyID($id);
		$data['pkj'] 	= $this->M_papd->getListPengembalianById($id);
		$data['status'] = $data['pkj'][0]['status'];
		$data['arr'] = array(
			'APRON DADA', 'APRON KAKI','APRON LENGAN','BAJU SUPPORT','BODY HARNESS','HELM','SPECTACLE CLEAR','SPECTACLE SMOKE',
			'RESPIRATOR','SAFETY GOOGLE CLEAR','SAFETY GOOGLE SMOKE','SAFETY SHOES'
			);
		$data['ukuran'] = array('S', 'M', 'L', 'XL');
		for ($i=30; $i < 61; $i++) { 
			$data['ukuran'][] = $i;
		}
		$data['id'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PengembalianAPD/hubker/V_Table_Detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function terima_apd()
	{
		$noind = $this->session->user;
		$id = $this->input->get('id');
		$status = $this->input->get('status');

		$arr = array(
			'approve_date'	=>	date('Y-m-d H:i:s'),
			'approve_by'	=>	$noind,
			'status'	=>	$status,
			);
		$up = $this->M_papd->updateAPD($arr, $id);
		if($up)
			redirect('pengembalian-apd/hubker/view_data?stat='.$status);
	}

	public function view_only()
	{
		$id = $this->input->get('id');
		$data  = $this->general->loadHeaderandSidemenu('Pengembalian APD', 'Pengembalian APD', '', '', '');
		$kodesie = $this->session->kodesie;
		if (strpos($kodesie, '4010101') === false) {
			array_pop($data['UserMenu']);
		}
		$data['list'] = $this->M_papd->getListPengembalian();

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
		$data['id'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PengembalianAPD/hubker/V_Table_Detail_Only',$data);
		$this->load->view('V_Footer',$data);
	}
}