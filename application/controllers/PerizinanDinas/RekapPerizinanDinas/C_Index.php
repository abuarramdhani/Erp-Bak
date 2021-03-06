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
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PerizinanDinas/RekapPerizinanDinas/M_index');

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

		$data['Title'] = 'Rekap Perizinan Dinas';
		$data['Menu'] = 'Rekap Perizinan Dinas ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
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

		$today = date('Y-m-d');
		$data['Izin_id'] = $this->M_index->getIDIzin();
		$data['noind'] = $this->M_index->getNoind();
		$data['tgl'] = date('d/m/Y');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanDinas/RekapPerizinanDinas/V_Index', $data);
		$this->load->view('PerizinanDinas/V_Footer', $data);
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
			$wkt_satu = str_replace('/', '-', $explode[0]);
			$wkt_dua = str_replace('/', '-', $explode[1]);
			$periode1 = date('Y-m-d', strtotime($wkt_satu));
			$periode2 = date('Y-m-d', strtotime($wkt_dua));

			if ($periode1 == $periode2) {
				$periode = "WHERE cast(ti.created_date as date) = '$periode1'";
				$periodea = "WHERE cast(tp.created_date as date) = '$periode1'";
			} else if ($periode1 != $periode2) {
				$periode = "WHERE cast(ti.created_date as date) between '$periode1' and '$periode2'";
				$periodea = "WHERE cast(tp.created_date as date) between '$periode1' and '$periode2'";
			}

			if (!empty($id)) {
				$id 			= implode("', '", $id);
				$periode .= " AND ti.izin_id IN ('$id')";
			}

			if (!empty($noind)) {
				$noind 			= implode("', '", $noind);
				$periodea .= " AND ti.noind IN ('$noind')";
			}
		} else {
			$periode = $perioderekap;
			$periodea = $perioderekap;

			if (!empty($id)) {
				$id 			= implode("', '", $id);
				$periode .= "WHERE ti.izin_id IN ('$id')";
			}

			if (!empty($noind)) {
				$noind 			= implode("', '", $noind);
				$periodea .= "WHERE ti.noind IN ('$noind')";
			}
		}

		if ($jenis == '1') {
			$izin = $this->M_index->IzinApprove($periode);
			//untuk nyari pekerja
			$a = $this->M_index->getTujuanA($periode);
			$b = array();
			$output = array();
			foreach ($a as $key) {
				$b[$key['izin_id']][] = $key['pekerja'];
			}
			foreach ($b as $type => $label) {
				$output[] = array(
					'izin_id' => $type,
					'pekerja' => $label
				);
			}
			// untuk nyari makan
			$makan = array();
			$ot_makan = array();
			foreach ($a as $key) {
				$makan[$key['izin_id']][] = $key['tujuan'];
			}
			foreach ($makan as $type => $label) {
				$ot_makan[] = array(
					'izin_id' => $type,
					'tujuan' => $label
				);
			}
			//menggabungkan data dengan makan
			$c = array();
			foreach ($izin as $key) {
				foreach ($ot_makan as $value) {
					if ($key['izin_id'] == $value['izin_id']) {
						$c[] = array_merge($key, $value);
					}
				}
			}
			//menggabungkan data dengan pekerja
			$data['IzinApprove'] = array();
			foreach ($c as $key) {
				foreach ($output as $value) {
					if ($key['izin_id'] == $value['izin_id']) {
						$data['IzinApprove'][] = array_merge($key, $value);
					}
				}
			}
			$view = $this->load->view('PerizinanDinas/RekapPerizinanDinas/V_Process', $data);
		} else {
			$data['pekerja'] = $this->M_index->getPekerja($periodea);
			$view = $this->load->view('PerizinanDinas/RekapPerizinanDinas/V_Human', $data);
		}
		echo json_encode($view);
	}

	public function hapusini($id)
	{
		$lnoind = $this->M_index->getIDIzinbyID($id);
		$noind = '';
		foreach ($lnoind as $key) {
			$noind .= $key['noind'] . ' ';
		}
		$aksi = 'HAPUS PERIZINAN DINAS';
		$detail = 'Hapus Izin ID=' . $id . ' noind=' . $noind;
		$this->log_activity->activity_log($aksi, $detail);
		$del = $this->M_index->hapusIzin($id);

		return $del;
	}
}
