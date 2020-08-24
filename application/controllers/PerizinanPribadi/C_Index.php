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
		$this->load->model('PerizinanPribadi/M_index');

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

		$data['Title'] = 'Approve Atasan';
		$data['Menu'] = 'Perizinan Pribadi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$aksesRahasia = $this->M_index->allowedParamedik();
		$aksesRahasia = array_column($aksesRahasia, 'noind');

		if (array_search($no_induk, $aksesRahasia)) {
			$data['UserMenu'] = $datamenu;
		} else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			$data['UserMenu'] = $datamenu;
		}

		$today = date('Y-m-d');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanPribadi/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function index1()
	{
		//alur di approve IKP,
		// tizin_pribadi jika status 1 maka approve,
		// 2 reject,
		// 5 suto reject tapi ditampilkan un approve,

		// tizin_pribadi_detail dan taktual_pribadi
		// status - baru insert, ditampilkan un approve
		// status 1 approve, baru masuk di taktual_pribadi
		// status 3 keluar_ikp
		// status 4 kembali
		// status 5 reject
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Approve Atasan';
		$data['Menu'] = 'Perizinan Pribadi';
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
			$data['UserMenu'] = array_values($datamenu);
		}

		$data['nama'] = $this->M_index->getAllNama();
		$data['izin'] = $this->M_index->GetIzin($no_induk, '');
		$data['IzinPribadi'] = $this->M_index->GetIzin($no_induk, '1');
		$data['IzinSakit'] = $this->M_index->GetIzin($no_induk, '2');
		$data['IzinDinas'] = $this->M_index->GetIzin($no_induk, '3');

		$today = date('Y-m-d');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanPribadi/V_IKP', $data);
		$this->load->view('V_Footer', $data);
	}

	public function update()
	{
		$status = $this->input->post('keputusan');
		$idizin = $this->input->post('id');
		$update = $this->M_index->update($status, $idizin);

		redirect('IKP/ApprovalAtasan');
	}

	public function editPekerjaIKP()
	{
		$id = $this->input->post('id');

		$pekerja = $this->M_index->getPekerjaEdit($id);
		echo json_encode($pekerja);
	}

	public function updatePekerja()
	{
		$id = $this->input->post('id');
		$jenis = $this->input->post('jenis');
		$pekerja = $this->input->post('pekerja');
		$implode = implode("', '", $pekerja);
		$implode1 = implode(", ", $pekerja);

		$getpekerja = $this->M_index->getPekerja($id);
		$noinde = array_column($getpekerja, 'noind');
		$result = array_diff($noinde, $pekerja);
		$diserahkan = $this->M_index->getSerahkan($implode, $id);
		$ar = array();
		foreach ($diserahkan as $key) {
			if (!empty($key['diserahkan'])) {
				$ar[] = $key['diserahkan'];
			} else {
				$ar[] = '-';
			}
		}

		$imserahkan = implode(", ", $ar);


		if (!empty($result)) {
			foreach ($result as $key) {
				$update2_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '5', $id);
			}
		}

		foreach ($pekerja as $key) {
			$update_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '1', $id);
		}

		if ($pekerja > 1) {
			$update_tperizinan = $this->M_index->update_tperizinan($implode1, '1', $id, $imserahkan);
		} else {
			$update_tperizinan = $this->M_index->update_tperizinan($pekerja, '1', $id, $imserahkan);
		}

		for ($i = 0; $i < count($pekerja); $i++) {
			$newEmployee = $this->M_index->getDataPekerja($pekerja[$i], $id);
			if ($pekerja[$i] == $newEmployee[0]['noind']) {
				$data = array(
					'id'	=> $id,
					'noind' 	=> $pekerja[$i],
					'created_date' => date('Y-m-d H:i:s')
				);
				$insert = $this->M_index->taktual_pribadi($data);
			}
		}
	}
}
