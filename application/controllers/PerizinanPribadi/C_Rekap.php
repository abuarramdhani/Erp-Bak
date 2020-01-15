<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Rekap extends CI_Controller
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
		$this->load->model('PerizinanPribadi/M_index');

		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
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

		$data['Title'] = 'Rekap Perizinan Pribadi';
		$data['Menu'] = 'Rekap Perizinan Pribadi ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$today = date('Y-m-d');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerizinanPribadi/V_Indexrekap',$data);
		$this->load->view('V_Footer',$data);

	}

	public function rekapbulanan()
	{
		$this->checkSession();
		$user = $this->session->username;
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$perioderekap 	= $this->input->post('periodeRekap');
		$jenis			= $this->input->post('jenis');
		if (!empty($perioderekap)) {
			$explode = explode(' - ', $perioderekap);
			$periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
			$periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));

			if ($periode1 == $periode2) {
				$periode = "cast(tp.created_date as date) = '$periode1'";
				$data['IzinApprove'] = $this->M_index->IzinApprove($periode);
				$data['pekerja'] = $this->M_index->getPekerjarekap($periode);
			}else if($periode1 != $periode2){
				$periode = "cast(tp.created_date as date) between '$periode1' and '$periode2'";
				$data['pekerja'] = $this->M_index->getPekerjarekap($periode);
				$data['IzinApprove'] = $this->M_index->IzinApprove($periode);
			}
		}else {
			$data['pekerja'] = $this->M_index->getPekerjarekap($perioderekap);
			$data['IzinApprove'] = $this->M_index->IzinApprove($perioderekap);
		}

		$data['nama'] = $this->M_index->getAllNama();
		$today = date('Y-m-d');

		if ($jenis == '1') {
			$view = $this->load->view('PerizinanPribadi/V_Process',$data);
		}else {
			$view = $this->load->view('PerizinanPribadi/V_Human',$data);
		}
		echo json_encode($view);
	}

}
?>
