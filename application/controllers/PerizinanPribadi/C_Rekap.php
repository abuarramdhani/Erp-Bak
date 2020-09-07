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

		$paramedik = $this->M_index->allowedAccess('1');
		$paramedik = array_column($paramedik, 'noind');

		$admin_hubker = $this->M_index->allowedAccess('2');
		$admin_hubker = array_column($admin_hubker, 'noind');

		if (in_array($no_induk, $paramedik)) {
			$data['UserMenu'] = $datamenu;
		} elseif (in_array($no_induk, $admin_hubker)) {
			unset($datamenu[0]);
			unset($datamenu[1]);
			$data['UserMenu'] = array_values($datamenu);
		} else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			unset($datamenu[3]);
			$data['UserMenu'] = array_values($datamenu);
		}

		$data['list_izin'] = $this->M_index->getLIzin();
		$data['list_noind'] = $this->M_index->getLIzinNoind();

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
		$kodesie = substr($kd_sie, 0, 7);

		$perioderekap 	= $this->input->get('periodeRekap');
		$jenis			= $this->input->get('jenis');
		$id				= $this->input->get('id');
		$noind 			= $this->input->get('noind');
		$export 		= $this->input->get('valButton');
		$perseksi		= $this->input->get('jenisPerseksi');
		$nama  			= $this->M_index->getNamaByNoind($user);
		$seksi 			= $this->M_penyerahan->getJabatanPreview($kd_sie);

		//insert to t_log
		$aksi = 'PERIZINAN PRIBADI';
		$detail = 'Rekap Perizinan Pribadi';
		$this->log_activity->activity_log($aksi, $detail);
		//
		if (!empty($perioderekap)) {
			$replace = str_replace('/', '-', $perioderekap);
			$explode = explode(' - ', $replace);
			$periode1 = date('Y-m-d', strtotime($explode[0]));
			$periode2 = date('Y-m-d', strtotime($explode[1]));

			$periode = "WHERE ip.created_date::date between '$periode1' and '$periode2'";
		} else {
			$periode = '';
		}

		if ($perseksi == 'Ya') {
			$jenis = '1';
		}

		if ($jenis == '1') {
			if (empty($id)) {
				$periode .= "";
			} else {
				$im_id = implode("', '", $id);
				if (empty($periode)) {
					$periode .= "WHERE ip.id in ($im_id)";
				} else {
					$periode .= "AND ip.id in ('$im_id')";
				}
			}
			if ($perseksi == 'Ya') {
				if (empty($periode)) {
					$periode .= "WHERE tp.kodesie like '$kodesie%'";
				} else {
					$periode .= "AND tp.kodesie like '$kodesie%'";
				}
			}
			$data['IzinApprove'] = $this->M_index->GetIzinPribadi($periode);
		} else {
			if (empty($noind)) {
				$periode .= "";
			} else {
				$arr = array();
				foreach ($noind as $key) {
					$arr[] = "ip.noind like '%$key%'";
				}
				$im_no = implode(" or ", $arr);
				if (empty($periode)) {
					$periode .= "WHERE $im_no";
				} else {
					$periode .= "AND ($im_no)";
				}
			}
			$data['IzinApprove'] = $this->M_index->GetIzinPribadiPerPekerja($periode);
		}
		$data['seksi'] = $this->M_index->getSeksi();
		$data['perseksi'] = $perseksi;
		$data['jenis'] = $jenis;
		if ($export == 'Excel') {
			$data['date'] = date("d-m-Y");

			$this->load->library("Excel");
			$this->load->view('PerizinanPribadi/V_RekapExcel', $data);
		} elseif ($export == 'PDF') {
			if (empty($data['IzinApprove'])) {
				echo json_encode('kosong');
			}
			if (empty($perioderekap)) {
				$tanggal = "All Periode";
			} else {
				if ($periode1 == $periode2) {
					$tanggal = date('d F Y', strtotime($periode1));
				} else {
					$tanggal = date('d/m/Y', strtotime($periode1)) . ' - ' . date('d/m/Y', strtotime($periode2));
				}
			}
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4-L', 10, 8, 10, 10, 30, 15, 8, 20);
			$filename = 'Rekap Perizinan Pribadi.pdf';

			$html = $this->load->view('PerizinanPribadi/V_PDF', $data, true);
			$pdf->setHTMLHeader('
				<table width="100%">
					<tr>
						<td width="50%"><h2><b>Rekap Data Perizinan Pribadi</b></h2></td>
						<td style="text-align: right;"><h5>Dicetak Oleh ' . $noind . ' - ' . $nama . ' pada Tanggal ' . date('d M Y H:i:s') . '</h5></td>
					</tr>
                    <tr>
						<td>Periode tarik : ' . $tanggal . '</td>
						<td style="text-align: right;"><h5>Seksi : ' . ucwords(mb_strtolower($seksi)) . '</h5></td>
					</tr>
				</table>
			');

			$pdf->WriteHTML($html, 2);
			$pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
		} else {
			if ($perseksi == "Ya") {
				$data['hiden'] = 'hidden';
			} else {
				$data['hiden'] = '';
			}
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
		$jenis = $_POST['jenis'];
		$user = $this->session->user;

		if ($jenis == '1') {
			$update = 't';
		} else {
			$update = 'f';
		}
		echo ($this->M_index->updateManualHubker($id, $update, $user)) ? "ok" : "no";
	}

	public function deleteData()
	{
		$id = $_POST['id'];

		$hapus = $this->M_index->deleteIzin($id);
		return $hapus;
	}
}
