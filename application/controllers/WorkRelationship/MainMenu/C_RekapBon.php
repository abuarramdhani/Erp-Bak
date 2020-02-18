<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_RekapBon extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WorkRelationship/MainMenu/M_rekapbon');

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

		$user_id = $this->session->userid;


		$data['Title'] = 'Rekap Bon Pekerja';
		$data['Menu'] = 'Rekap Bon Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $noInduk='';
		// $dataBon = $data['bon'] = $this->M_rekapbon->getBill($noInduk);

		// foreach ($dataBon as $key => $bon) {
		// 	$noind = $bon['VENDOR_SITE_CODE'];
			
		// 	$employee = $this->M_rekapbon->getEmployee($noind);

		// 	$data['bon'][$key]['NOIND'] = $employee[0]['noind'];
		// 	$data['bon'][$key]['NAMA'] = $employee[0]['nama'];
		// 	// $data['bon'][$key]['JABATAN'] = $employee[0]['jabatan'];
		// 	// $data['bon'][$key]['DEPT'] = $employee[0]['dept'];
		// 	// $data['bon'][$key]['BIDANG'] = $employee[0]['bidang'];
		// 	// $data['bon'][$key]['UNIT'] = $employee[0]['unit'];
		// 	$data['bon'][$key]['SEKSI'] = $employee[0]['seksi'];
		// }
		
		// $data['employeeAll'] = $this->M_rekapbon->getEmployeeAll();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WorkRelationship/RekapBon/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function getEmployeeAll(){
		
		$name = $this->input->GET('term');
		$query = $this->M_rekapbon->getEmployeeAll($name);
		echo json_encode($query);
	}

	public function getTableWrEmployeeAll()
	{
		$noInduk=$this->input->post('employee');
		$dataBon = $data['bon'] = $this->M_rekapbon->getBill($noInduk);

		foreach ($dataBon as $key => $bon) {
			$noind = $bon['VENDOR_SITE_CODE'];
			
			$employee = $this->M_rekapbon->getEmployee($noind);

			$data['bon'][$key]['NOIND'] = $employee[0]['noind'];
			$data['bon'][$key]['NAMA'] = $employee[0]['nama'];
			// $data['bon'][$key]['JABATAN'] = $employee[0]['jabatan'];
			// $data['bon'][$key]['DEPT'] = $employee[0]['dept'];
			// $data['bon'][$key]['BIDANG'] = $employee[0]['bidang'];
			// $data['bon'][$key]['UNIT'] = $employee[0]['unit'];
			$data['bon'][$key]['SEKSI'] = $employee[0]['seksi'];
		}
		$table = $this->load->view('WorkRelationship/RekapBon/V_table', $data);
		return $table;
	}

	public function Pekerjakeluar(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Bon Pekerja Keluar';
		$data['Menu'] = 'Rekap Bon Pekerja Keluar';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WorkRelationship/RekapBon/V_keluar', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ProsesKeluar(){
		// echo "<pre>";print_r($_POST);exit();
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Bon Pekerja Keluar';
		$data['Menu'] = 'Rekap Bon Pekerja Keluar';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$tanggals = $this->input->post('txtTanggalKeluarWR');
		$data['tanggal'] = $tanggals;
		$tgl = explode(" - ", $tanggals);
		$data['pekerja'] = $this->M_rekapbon->getPekerjaKeluar($tgl['0'],$tgl['1']);
		$noind = "";
		foreach ($data['pekerja'] as $key) {
			if ($noind == "") {
				$noind = "'".$key['noind']."'";
			}else{
				$noind .= ",'".$key['noind']."'";
			}
		}

		if ($noind !== "") {
			$data['bon'] = $this->M_rekapbon->getBill2($noind);
		}

		// echo "<pre>";print_r($data['pekerja']);print_r($data['bon']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WorkRelationship/RekapBon/V_keluar', $data);
		$this->load->view('V_Footer',$data);
	}	
}
