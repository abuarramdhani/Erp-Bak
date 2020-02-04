<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_EditData extends CI_Controller {

	function __construct() {
		parent::__construct();
        if(!$this->session->is_logged){ redirect('index'); }
		$this->load->library('Log_Activity');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/PotonganGaji/M_editdata');
    }

	public function index() {
        $potonganId = $this->input->post('potonganId');
        if(empty($potonganId)) { echo '<b>Tidak dapat menerima ID potongan...</b>'; die; }
		$data['UserMenu'] = $this->M_user->getUserMenu($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->session->userid, $this->session->responsibility_id);
        $data['Title'] = 'Edit Data';
        $data['Menu'] = $data['SubMenuOne'] = $data['SubMenuTwo'] = null;
        $potongan = $this->M_editdata->getPotongan($potonganId);
        $data['potonganId'] = $potonganId;
        $data['noind'] = $potongan->noind;
        $data['pekerja'] = $potongan->noind.' - '.$potongan->nama;
        $data['tipePembayaran'] = $potongan->tipe_pembayaran;
        $data['jenisPotonganId'] = $potongan->jenis_potongan_id;
        $data['jenisPotongan'] = $potongan->jenis_potongan;
        $data['periode'] = date('M Y', strtotime($potongan->periode_mulai_potong));
        $data['nominalTotal'] = $potongan->nominal_total;
        $data['simulasi'] = $this->M_editdata->getPotonganDetail($potonganId);
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPresensi/PotonganGaji/V_EditData', $data);
		$this->load->view('V_Footer', $data);
	}

    function getPekerjaList() {
        $term = $this->input->post('term');
        if(empty($term)) {
			echo json_encode($this->M_editdata->getPekerjaList());
		} else {
			echo json_encode($this->M_editdata->searchPekerja(strtolower($term)));
		}
    }

    function getJenisPotonganList() {
        $term = $this->input->post('term');
        if(empty($term)) {
			echo json_encode($this->M_editdata->getJenisPotonganList());
		} else {
			echo json_encode($this->M_editdata->searchJenisPotongan(strtolower($term)));
		}
	}

	public function updateData() {
		$potonganId = $this->input->post('potonganId');
        $pekerja = $this->input->post('pekerja');
        $jenisPotongan = $this->input->post('jenisPotongan');
        $nominalTotal = $this->input->post('nominalTotal');
        $tipePembayaran = $this->input->post('tipePembayaran');
        $periode = $this->input->post('periode');
        $periodeSimulasi = json_decode($this->input->post('periodeSimulasi'));
        $potonganSimulasi = json_decode($this->input->post('potonganSimulasi'));
        $nominalSimulasi = json_decode($this->input->post('nominalSimulasi'));
        $sisaSimulasi = json_decode($this->input->post('sisaSimulasi'));
		$statusSimulasi = json_decode($this->input->post('statusSimulasi'));
		$response = array('success' => false);
		if(!empty($potonganId) && !empty($pekerja) && !empty($jenisPotongan) && !empty($nominalTotal) && !empty($tipePembayaran) && !empty($periode) && !empty($periodeSimulasi) && !empty($potonganSimulasi) && !empty($nominalSimulasi) && !empty($sisaSimulasi) && !empty($statusSimulasi)) {
			$dataPotongan = array(
				'noind' => $pekerja,
				'jenis_potongan_id' => $jenisPotongan,
				'nominal_total' => $nominalTotal,
				'tipe_pembayaran' => $tipePembayaran,
				'periode_mulai_potong' => $periode
			);
			$dataPotonganDetail = array();
			for($i = 0; $i < count($periodeSimulasi); $i++) {
				$dataPotonganDetail[$i] = array(
					'potongan_id' => $potonganId,
					'periode_potongan' => $periodeSimulasi[$i],
					'potongan_ke' => $potonganSimulasi[$i],
					'nominal_potongan' => $nominalSimulasi[$i],
					'sisa' => $sisaSimulasi[$i],
					'status' => $statusSimulasi[$i]
				);
			}
			$response['success'] = $this->M_editdata->updateData($potonganId, $dataPotongan, $dataPotonganDetail);
			//insert to t_log
			$aksi = 'MASTER PRESENSI';
			$detail = 'Update Potongan Gaji Noind='.$pekerja;
			$this->log_activity->activity_log($aksi, $detail);
			//
		}
		echo json_encode($response);
	}
}
