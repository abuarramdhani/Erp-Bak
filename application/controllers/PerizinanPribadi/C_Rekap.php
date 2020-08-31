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
		$this->load->model('ADMSeleksi/M_penyerahan');

		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('');
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

		$datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$paramedik = $this->M_index->allowedParamedik();
		$paramedik = array_column($paramedik, 'noind');

		if (in_array($no_induk, $paramedik)) {
			$data['UserMenu'] = $datamenu;
		} else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			$data['UserMenu'] = array_values($datamenu);
		}
		$data['list_izin'] = $this->M_index->getLIzin('id')->result_array();
		$data['list_noind'] = $this->M_index->getLIzinNoind()->result_array();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanPribadi/V_Indexrekap', $data);
		$this->load->view('V_Footer', $data);
	}

	public function rekapbulanan()
	{
		$this->checkSession();
		$kd_sie = $this->session->kodesie;
		$user = $this->session->user;

		$perioderekap 	= $this->input->get('periodeRekap');
		$jenis			= $this->input->get('jenis');
		$id				= $this->input->get('id');
		$noind 			= $this->input->get('noind');
		$export 		= $this->input->get('valButton');
		$nama  			= $this->M_index->getNamaByNoind($user);
		$seksi 			= $this->M_penyerahan->getJabatanPreview($kd_sie);

		//insert to t_log
		$aksi = 'PERIZINAN PRIBADI';
		$detail = 'Rekap Perizinan Pribadi';
		$this->log_activity->activity_log($aksi, $detail);
		//
		if (!empty($perioderekap)) {
			$explode = explode(' - ', $perioderekap);
			$periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
			$periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));

			$periode = "ip.created_date::date between '$periode1' and '$periode2'";
		} else {
			$periode = '';
		}

		if ($jenis == 1) {
			if (empty($id)) {
				$and = "";
			} else {
				$im_id = implode("', '", $id);
				$and = "ip.id in ('$im_id')";
			}
		} else {
			if (empty($noind)) {
				$and = "";
			} else {
				$arr = array();
				foreach ($noind as $key) {
					$arr[] = "ip.noind like '%$key%'";
				}
				$im_no = implode(" or ", $arr);
				$and = "($im_no)";
			}
		}

		$data['jenis'] = '1';
		$data['IzinApprove'] = $this->M_index->GetIzinPribadi($periode, $and, '');

		if ($export == 'Excel') {
			$data['date'] = date("d-m-Y");

			$this->load->library("Excel");
			$this->load->view('PerizinanPribadi/V_RekapExcel', $data);
		} elseif ($export == 'PDF') {
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4-L', 10, 8, 10, 10, 30, 15, 8, 20);
			$filename = 'Rekap Perizinan Pribadi.pdf';

			$html = $this->load->view('PerizinanPribadi/V_PDF', $data, true);
			$pdf->setHTMLHeader('
				<table width="100%">
					<tr>
						<td width="50%" rowspan="2"><h2><b>Rekap Data Perizinan</b></h2></td>
						<td style="text-align: right;"><h5>Dicetak Oleh ' . $noind . ' - ' . $nama . ' pada Tanggal ' . date('d M Y H:i:s') . '</h5></td>
					</tr>
                    <tr>
						<td style="text-align: right;"><h5>Seksi : ' . ucwords(mb_strtolower($seksi)) . '</h5></td>
					</tr>
				</table>
			');

			$pdf->WriteHTML($html, 2);
			$pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
		} else {
			$data['hiden'] = '';
			if ($jenis == '1') {
				$view = $this->load->view('PerizinanPribadi/V_Process', $data);
			} else {
				$view = $this->load->view('PerizinanPribadi/V_Human', $data);
			}
			echo json_encode($view);
		}
	}

	public function updateManual()
	{
		$id = $_POST['id'];

		$cek = $this->M_index->GetIzinbyId($id)->result_array();
		$manual = $cek[0]['manual'];
		// print_r($manual);
		// die;
		$update = ($manual == 'f') ? 'f' : 't';

		echo ($this->M_index->updateManualHubker($id, $update)) ? "ok" : "no";

		//SEMANGATTTTT
	}
}
