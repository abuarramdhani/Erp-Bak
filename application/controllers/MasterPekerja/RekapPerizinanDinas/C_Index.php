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

		$data['Title'] = 'Rekap Perizinan Dinas';
		$data['Menu'] = 'Rekap Perizinan Dinas ';
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
		$this->checkSession();
		$user = $this->session->username;
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'REKAP DATA PERIZINAN DINAS';
		$data['Menu'] = 'Rekap Perizinan Dinas ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$perioderekap 		=	$this->input->post('periodeRekap');
		if (!empty($perioderekap)) {
			$explode = explode(' - ', $perioderekap);
			$periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
			$periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));

			if ($periode1 == $periode2) {
				$periode = "and cast(created_date as date) = '$periode1'";
				$data['IzinApprove'] = $this->M_index->IzinApprove($periode);
			}else if($periode1 != $periode2){
				$periode = "and cast(created_date as date) between '$periode1' and '$periode2'";
				$data['IzinApprove'] = $this->M_index->IzinApprove($periode);
			}
		}else {
			$data['IzinApprove'] = $this->M_index->IzinApprove($perioderekap);
		}

		$data['nama'] = $this->M_index->getAllNama();
		$today = date('Y-m-d');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/RekapPerizinanDinas/V_Process',$data);
		$this->load->view('V_Footer',$data);

	}

}
?>
