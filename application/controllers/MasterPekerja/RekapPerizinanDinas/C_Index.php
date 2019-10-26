<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/RekapPerizinanDinas/M_index');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		// echo "<pre>";
		// print_r($user_id);exit();

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		
		$today = date('Y-m-d');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/RekapPerizinanDinas/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}

	public function rekapbulanan()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		
		$perioderekap 		=	$this->input->post('periodeRekap');


		$data['Title'] = 'REKAP DATA PERIZINAN DINAS';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['IzinApprove'] = $this->M_index->IzinApprove($perioderekap);

			// echo "<pre>"; print_r($data['IzinApprove']);exit();
		$approve = array();
		foreach($data['IzinApprove'] as $key) {
			$nama = explode(', ', $key['noind']);
				$newArr = array();
			foreach ($nama as $row) {
				$pekerja = $this->M_index->pekerja($row);
				$newArr[] = $row.' - '.$pekerja;
			}
			$namapekerja = implode(", ",$newArr);
			$key['namapekerja'] = $namapekerja;
			$namaatasan = $this->M_index->pekerja($key['atasan_aproval']);
			$key['namaatasan'] = $key['atasan_aproval'].' - '.$namaatasan;
			$approve[] = $key;
			// echo "<pre>"; print_r($approve);exit();
		 }
		$data['IzinApprove'] = $approve;
			// echo "<pre>"; print_r($data['IzinApprove']);exit();

		
		$today = date('Y-m-d');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/RekapPerizinanDinas/V_Process',$data);
		$this->load->view('V_Footer',$data);

	}

}
?>
