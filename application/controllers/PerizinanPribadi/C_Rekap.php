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
		$this->load->library('Log_Activity');
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

		$datamenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$paramedik = $this->M_index->allowedParamedik();
		$paramedik = array_column($paramedik, 'noind');

		if (in_array($no_induk, $paramedik)) {
			$data['UserMenu'] = $datamenu;
		}else {
			unset($datamenu[1]);
			$data['UserMenu'] = array_values($datamenu);
		}
		$data['list_izin'] = $this->M_index->getLIzin('id')->result_array();
		$data['list_noind'] = $this->M_index->getLIzinNoind()->result_array();

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
		$id				= $this->input->post('id');
		$noind 			= $this->input->post('noind');

		//insert to t_log
		$aksi = 'PERIZINAN DINAS';
		$detail = 'Rekap Perizinan Dinas';
		$this->log_activity->activity_log($aksi, $detail);
		//
		if (!empty($perioderekap)) {
			$explode = explode(' - ', $perioderekap);
			$periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
			$periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));

			$periode = "and ip.created_date::date between '$periode1' and '$periode2'";

		}else{
			$periode = '';
		}

		if ($jenis == 1) {
			if (empty($id)) {
				$and = "";
			}else{
				$im_id = implode("', '", $id);
				$and = "and ip.id in ('$im_id')";
			}
		}else{
			if (empty($noind)) {
				$and = "";
			}else{
				$arr = array();
				foreach ($noind as $key) {
					$arr[] = "ip.noind like '%$key%'";
				}
				$im_no = implode(" or ", $arr);
				$and = "and ($im_no)";
			}
		}

		$data['IzinApprove'] = $this->M_index->IzinApprove($periode, $and);
		$view = $this->load->view('PerizinanPribadi/V_Process',$data);
		echo json_encode($view);
	}

}
?>
