<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_tambahdata extends CI_Controller {

	function __construct() {
		parent::__construct();
        if(!$this->session->is_logged){ redirect('index'); }
		$this->load->library('Log_Activity');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/PotonganGaji/M_tambahdata');
    }

	public function index() {
		$data['UserMenu'] = $this->M_user->getUserMenu($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->session->userid, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->session->userid, $this->session->responsibility_id);
        $data['Title'] = 'Tambah Data Potongan';
		$data['Menu'] = $data['SubMenuOne'] = $data['SubMenuTwo'] = null;
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPresensi/PotonganGaji/V_TambahData', $data);
		$this->load->view('V_Footer', $data);
	}

    function getPekerjaList() {
        $term = $this->input->post('term');
        if(empty($term)) {
			echo json_encode($this->M_tambahdata->getPekerjaList());
		} else {
			echo json_encode($this->M_tambahdata->searchPekerja(strtolower($term)));
		}
    }

    function getJenisPotonganList() {
        $term = $this->input->post('term');
        if(empty($term)) {
			echo json_encode($this->M_tambahdata->getJenisPotonganList());
		} else {
			echo json_encode($this->M_tambahdata->searchJenisPotongan(strtolower($term)));
		}
	}

	function saveData() {
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
		if(!empty($pekerja) && !empty($jenisPotongan) && !empty($nominalTotal) && !empty($tipePembayaran) && !empty($periode) && !empty($periodeSimulasi) && !empty($potonganSimulasi) && !empty($nominalSimulasi) && !empty($sisaSimulasi) && !empty($statusSimulasi)) {
			$savePotonganResponse = $this->M_tambahdata->savePotongan(array(
				'noind' => $pekerja,
				'jenis_potongan_id' => $jenisPotongan,
				'nominal_total' => $nominalTotal,
				'tipe_pembayaran' => $tipePembayaran,
				'periode_mulai_potong' => $periode
			));
			$response['success'] = $savePotonganResponse['success'];
			if($savePotonganResponse['success']) {
				for($i = 0; $i < count($periodeSimulasi); $i++) {
					$this->M_tambahdata->saveDetailPotongan(array(
						'potongan_id' => $savePotonganResponse['potonganId'],
						'periode_potongan' => $periodeSimulasi[$i],
						'potongan_ke' => $potonganSimulasi[$i],
						'nominal_potongan' => $nominalSimulasi[$i],
						'sisa' => $sisaSimulasi[$i],
						'status' => $statusSimulasi[$i]
					));
				}
			}
			//insert to t_log
			$aksi = 'MASTER PRESENSI';
			$detail = 'Create Potongan Gaji Noind='.$pekerja;
			$this->log_activity->activity_log($aksi, $detail);
			//
		}
		echo json_encode($response);
	}

	function cekDuplikat(){
		$noind = $this->input->post('noind');
		$nominal = $this->input->post('nominal');
		$jenis = $this->input->post('jenis');
		$nominal = str_replace(".", "", $nominal);
		$data = $this->M_tambahdata->getPotonganByNoindNominalJenis($noind,$nominal,$jenis);
		if (!empty($data)) {
			$jumlah = count($data);
		}else{
			$jumlah = '0';
		}
		$arr = array(
			'jumlah' 	=> $jumlah,
			'data' 		=> $data,
			'noind' 	=> $noind,
			'nominal' 	=> $nominal,
			'jenis' 	=> $jenis
		);
		echo json_encode($arr);
	}
}
