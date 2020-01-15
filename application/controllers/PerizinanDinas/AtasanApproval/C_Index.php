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
		$this->load->model('PerizinanDinas/AtasanApproval/M_index');

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

		$data['Title'] = 'Approve Atasan';
		$data['Menu'] = 'Perizinan Dinas';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if ($no_induk == 'B0898' || $no_induk == 'B0720' || $no_induk == 'B0819' || $no_induk == 'B0697' || $no_induk == 'B0696' || $no_induk == 'J1293' || $no_induk == 'B0307') {
			$data['UserMenu'] = $datamenu;
		}else {
			unset($datamenu[1]);
			$data['UserMenu'] = $datamenu;
		}

		$data['izin'] = $this->M_index->GetIzin($no_induk);
		$data['IzinApprove'] = $this->M_index->IzinApprove($no_induk);
		$data['IzinUnApprove'] = $this->M_index->IzinUnApprove($no_induk);
		$data['IzinReject'] = $this->M_index->IzinReject($no_induk);

		$today = date('Y-m-d');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerizinanDinas/AtasanApproval/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}

	public function update()
	{
		$status = $this->input->post('keputusan');
		$idizin = $this->input->post('id');
		$update= $this->M_index->update($status, $idizin);

		if ($status == 1) {
			$no = '0';
			$data['cekizin'] = $this->M_index->cekIzin($idizin);
			$nama = explode(', ', $data['cekizin'][0]['noind']);
			$tujuan = $this->M_index->getTujuanMakan($idizin);
			$updatePekerja = $this->M_index->updatePekerja($no, $idizin);

			if (date('H:i:s') <= '09:30:00') {
				for ($i=0; $i < count($nama); $i++) {
					for ($j=0; $j < count($tujuan) ; $j++) {
						if ($nama[$i] == $tujuan[$j]['noind']) {
							$data = array(
								'izin_id'	=> $idizin,
								'noinduk' 	=> $nama[$i],
								'tujuan' => $tujuan[$j]['tujuan'],
								'created_date' => date('Y-m-d H:i:s')
							);
							$insert = $this->M_index->taktual_izin($data);
						}
					}
				}
			}else {
				for ($i=0; $i < count($nama); $i++) {
					$data = array(
						'izin_id'	=> $idizin,
						'noinduk' 	=> $nama[$i],
						'created_date' => date('Y-m-d H:i:s')
					);
					$insert = $this->M_index->taktual_izin($data);
				}
			}
		}elseif ($status == 2) {
			$no = '5';
			$updatePekerja = $this->M_index->updatePekerja($no, $idizin);
			redirect('PerizinanDinas/AtasanApproval');
		}else{
		redirect('PerizinanDinas/AtasanApproval');
		}
	}

	public function editPekerjaDinas()
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

		$place = '';
		$getpekerja = $this->M_index->getTujuanMakan($id);
		$noinde = array_column($getpekerja, 'noind');
		$result = array_diff($noinde, $pekerja);

		if (!empty($result)) {
			foreach ($result as $key) {
				$update2_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '5', $id);
			}
		}

		foreach ($pekerja as $key) {
			$update_tpekerja_izin = $this->M_index->updatePekerjaBerangkat($key, '0', $id);
		}

		if ($pekerja > 1) {
			$place = $this->M_index->getTujuan($id, $implode, true);
			$place1 = array_column($place, 'tujuan');
			$imPlace = implode(", ", $place1);
			$update_tperizinan = $this->M_index->update_tperizinan($implode1, '1', $id, $imPlace);
		}else {
			$place = $this->M_index->getTujuan($id, $pekerja, false);
			$place1 = array_column($place, 'tujuan');
			$update_tperizinan = $this->M_index->update_tperizinan($pekerja, '1', $id, $place1);
		}

		if (date('H:i:s') <= '09:30:00') {
			for ($i=0; $i < count($pekerja); $i++) {
				$newEmployee = $this->M_index->getDataPekerja($pekerja[$i], $id);
					if ($pekerja[$i] == $newEmployee[0]['noind']) {
						$data = array(
							'izin_id'	=> $id,
							'noinduk' 	=> $pekerja[$i],
							'tujuan' => $newEmployee[0]['tujuan'],
							'created_date' => date('Y-m-d H:i:s')
						);
						$insert = $this->M_index->taktual_izin($data);
					}
			}
		}else {
			for ($i=0; $i < count($pekerja); $i++) {
				$data = array(
					'izin_id'	=> $id,
					'noinduk' 	=> $pekerja[$i],
					'created_date' => date('Y-m-d H:i:s')
				);
				$insert = $this->M_index->taktual_izin($data);
			}
		}
	}

}
?>
