<?php
defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);
class C_splpersonalia extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');

		$this->load->model('SPLSeksi/M_splseksi');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		date_default_timezone_set('Asia/Jakarta');
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
			// any
		} else {
			redirect('');
		}
	}

	public function menu($a, $b, $c)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = $a;
		$data['SubMenuOne'] = $b;
		$data['SubMenuTwo'] = $c;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		return $data;
	}

	//fingertemp

	public function finger()
	{
		$data = $this->menu('Daftar jari', '', '');
		$data['fingertemp'] = $this->M_splseksi->gettfingerphp();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SPLSeksi/Personalia/V_finger', $data);
		$this->load->view('V_Footer', $data);
	}

	public function getfingerdata()
	{
		$noind = $this->input->post('noind');
		$userid = $this->M_splseksi->getUseridByNoind($noind);
		$finger = $this->M_splseksi->getfingerdata($noind);
		$data = "";
		foreach ($finger as $temp) {
			$action = "";
			if (strlen($temp['temp']) > 0) {
				$action = "<button type='button' data-fid='" . $temp['id_finger'] . "' data-noind='" . $noind . "' data-userid='" . $userid . "' class='btn btn-danger spl-fingertemp-modal-finger-delete'><span class='fa fa-trash'></span></button>";
			} else {
				$temp['temp'] = "<b style='color: red'>Kosong</b>";
				$action = "<button type='button' data-fid='" . $temp['id_finger'] . "' data-noind='" . $noind . "' data-userid='" . $userid . "' class='btn btn-success spl-fingertemp-modal-finger-add'><span class='fa fa-plus'></span></button>";
			}
			$data .= "<tr>
    					<td>" . $temp['id_finger'] . "</td>
    					<td>" . $temp['jari'] . "</td>
    					<td>" . $temp['temp'] . "</td>
    					<td>" . $action . "</td>
    				</tr>";
		}

		echo $data;
	}

	public function finger_register()
	{
		$userid 	= $_GET['userid'];
		$finger = $_GET['finger'];
		$time_limit_reg = 15;
		echo "$userid;SecurityKey;" . $time_limit_reg . ";" . base_url("SPL/DaftarFingerspot/finger_process_register?userid=" . $userid . "&finger=" . $finger) . ";" . base_url("SPL/DaftarFingerspot/finger_register_get_ac");
	}

	public function finger_process_register()
	{
		$data 		= explode(";", $_POST['RegTemp']);
		$vStamp 	= $data[0];
		$sn 		= $data[1];
		$user_id	= $data[2];
		$regTemp 	= $data[3];

		$device = $this->M_splseksi->getDeviceBySn($sn);

		$salt = md5($device->ac . $device->vkey . $regTemp . $sn . $user_id);

		if (strtoupper($vStamp) == strtoupper($salt)) {
			$userid = $_GET['userid'];
			$finger = $_GET['finger'];
			$noind = $this->M_splseksi->getNoindByUserid($userid);
			$insert = array(
				'user_id' => $userid,
				'user_name' => $noind,
				'kd_finger' => $finger,
				'finger_data' => $regTemp
			);
			$this->M_splseksi->insertFingerTemp($insert);
			$res['result'] = true;
			$res['server'] = "Error insert registration data!";
			echo "empty";

			// $msg = "Berhasil";
			// echo base_url("SPL/DaftarFingerspot/finger_register_error?msg=".$msg);
		} else {

			$msg = "Parameter Invalid ... :: " . strtoupper($vStamp) . " tidak sama dengan " . strtoupper($salt);
			echo base_url("SPL/DaftarFingerspot/finger_register_error?msg=" . $msg);
		}
	}

	public function finger_register_error()
	{
		print_r($_GET);
	}

	public function finger_register_get_ac()
	{
		$vc = $_GET['vc'];
		$data = $this->M_splseksi->getAcSnByVc($vc);

		echo $data->ac . $data->sn;
	}

	public function getUserfinger()
	{
		$key = $this->input->get('key');
		$data = $this->M_splseksi->getUserfinger(strtoupper($key));
		echo json_encode($data);
	}

	public function deleteFingerTemp()
	{
		$jari = $this->input->post('jari');
		$userid = $this->input->post('userid');
		$this->M_splseksi->deleteFingertemp($userid, $jari);
	}

	public function deleteFingertempAll()
	{
		$noind = $this->input->post('noind');
		$this->M_splseksi->deleteFingertempAll($noind);
	}

	public function generateFingertempTable()
	{
		$fingertemp = $this->M_splseksi->gettfingerphp();
		$data = "";
		$number = 1;
		foreach ($fingertemp as $temp) {
			$data .= "<tr>
				<td>
					" . $number . "
				</td>
				<td>
					" . $temp['noind'] . "
				</td>
				<td>
					" . $temp['noind_baru'] . "
				</td>
				<td>
					" . $temp['nama'] . "
				</td>
				<td>
					" . $temp['jumlah'] . "
				</td>
				<td>
					<button class='btn btn-warning spl-fingertemp-modal-add-temp-triger' data-id='" . $temp['noind'] . "' style='border-radius: 0px'>
						Finger
					</button>
					<button class='btn btn-danger spl-fingertemp-delete' data-id='" . $temp['noind'] . "' style='border-radius: 0px'>
						Delete
					</button>
				</td>
			</tr>";
			$number++;
		}

		echo $data;
	}
	//fingerspot

	public function fingerspot()
	{
		$data = $this->menu('Daftar Fingerspot', '', '');
		$data['fingerprint'] = $this->M_splseksi->gettcodefingerprint();
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SPLSeksi/Personalia/V_fingerspot', $data);
		$this->load->view('V_Footer', $data);
	}

	public function insertFingerspot()
	{
		$sn = $this->input->post('sn');
		$vc = $this->input->post('vc');
		$ac = $this->input->post('ac');
		$vkey = $this->input->post('vkey');

		$data = array(
			'SN' => $sn,
			'Verification_Code' => $vc,
			'Activation_Code' => $ac,
			'VKEY' => $vkey
		);

		$this->M_splseksi->inserttcodefingerprint($data);
	}

	public function updateFingerspot()
	{
		$id = $this->input->post('idf');
		$sn = $this->input->post('sn');
		$vc = $this->input->post('vc');
		$ac = $this->input->post('ac');
		$vkey = $this->input->post('vkey');

		$data = array(
			'SN' => $sn,
			'Verification_Code' => $vc,
			'Activation_Code' => $ac,
			'VKEY' => $vkey
		);

		$this->M_splseksi->updatetcodefingerprint($data, $id);
	}

	public function deleteFingerspot()
	{
		$id = $this->input->post('id');

		$this->M_splseksi->deletetcodefingerprint($id);
	}

	public function generateFingerspotTable()
	{
		$fingerprint = $this->M_splseksi->gettcodefingerprint();

		$number = 1;
		$data = "";
		foreach ($fingerprint as $finger) {
			$data .= "<tr>
						<td>
						" . $number . "
						</td>
						<td class='d-sn'>
						" . $finger['SN'] . "
						</td>
						<td class='d-vc'>
						" . $finger['Verification_Code'] . "
						</td>
						<td class='d-ac'>
						" . $finger['Activation_Code'] . "
						</td>
						<td class='d-vkey'>
						" . $finger['VKEY'] . "
						</td>
						<td>
							<button class='btn btn-warning spl-fingerprint-modal-edit-triger' data-id='" . $finger['ID_'] . "' style='border-radius: 0px'>
								Edit
							</button>
							<button class='btn btn-danger spl-fingerprint-delete' data-id='" . $finger['ID_'] . "' style='border-radius: 0px'>
								Delete
							</button>
						</td>
					</tr>";
			$number++;
		}
		echo $data;
	}
}
