<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class C_CekData extends CI_COntroller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PresenceManagement/MainMenu/M_cekdata');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Data Cabang';
		$data['Menu'] = 'Monitoring Presensi';
		$data['SubMenuOne'] = 'Data Cabang';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Cabang'] = $this->M_cekdata->getCabang();
		// print_r($data['Cabang']);exit();
		$this->form_validation->set_rules('required');
		if ($this->form_validation->run() === TRUE){
			$kd = $this->input->post('txtCabangCekData');
			$data['pembanding'] = $this->M_cekdata->getUtamaBanding($kd);
			$data['kd'] = $kd;
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MonitoringPresensi/V_DataCabang',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Detail($kd){
		$user_id = $this->session->userid;

		$data['Title'] = 'Cek Data Cabang';
		$data['Menu'] = 'Monitoring Presensi';
		$data['SubMenuOne'] = 'Data Cabang';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Cabang'] = $this->M_cekdata->getCabangByKd($kd);
		$PembandingUtama = $this->M_cekdata->getPembandingUtama($kd);
		$angka = 0;
		foreach ($PembandingUtama as $Pembanding) {
			if ($Pembanding['finger_utama'] !== $Pembanding['finger_banding']) {
				$finger = "<label class='label label-danger'>Not Ok</label>";
			}else{
				$PembandingFinger = $this->M_cekdata->getPembandingFinger($Pembanding['noind']);
				$finger = "<label class='label label-success'>Ok</label>";
				foreach ($PembandingFinger as $bandingfinger) {

					if($bandingfinger['jari_utama'] !== $bandingfinger['jari_banding']){
						$finger = "<label class='label label-danger'>Not Ok</label>";
					}else{
						if ($finger !== "<label class='label label-danger'>Not Ok</label>") {
							$finger = "<label class='label label-success'>Ok</label>";
						}
					}
				}
			}
			if ($Pembanding['password_utama'] !== $Pembanding['password_banding']) {
				$password = "<label class='label label-danger'>Not Ok</label>";
			}else{
				$password = "<label class='label label-success'>Ok</label>";
			}
			$arrData[$angka] = array(
				'noind' => $Pembanding['noind'],
				'nama' => $Pembanding['nama'],
				'noind_baru' => $Pembanding['noind_baru'],
				'finger' => $finger,
				'password' => $password
			);
			$angka++;
		}
		if (!empty($arrData)) {
			$data['hasilbanding'] = $arrData;
		}
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MonitoringPresensi/V_DataCabangDetail',$data);
		$this->load->view('V_Footer',$data);
	}
}

?>