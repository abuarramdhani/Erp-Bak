<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class C_UbahPekerjaan extends CI_Controller
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
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_upahphl');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Perubahan Pekerjaan HLCM';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Ubah Pekerjaan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if ($this->session->HlcmUbahPekerjaan !== FALSE) {
			$data['noind_sukses'] = $this->session->HlcmUbahPekerjaan;
			$this->session->HlcmUbahPekerjaan = FALSE;
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_ubahpekerjaan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CariPekerja(){
		$noind = $this->input->get('term');
		$data = $this->M_upahphl->getPekerjaSearch($noind);
		echo json_encode($data);
	}

	public function CariPekerjaBaru(){
		$noind = $this->input->get('term');
		$data = $this->M_upahphl->getPekerjaBaruSearch($noind);
		echo json_encode($data);
	}

	public function Simpan(){
		$noind = $this->input->post('cmbNoindHlcm');
		$nama = $this->input->post('txtNamaPekerjaHlcm');
		$pkjLama = $this->input->post('txtPekerjaanLamaHlcm');
		$pkjBaru = $this->input->post('txtPekerjaanBaruHlcm');
		$tglMulai = $this->input->post('txtMulaiBerlaku');

		if ($pkjLama == $pkjBaru) {
			$data = array(
				'tanggal_mulai_berlaku' => $tglMulai
			);
		}else{
			$data = array(
				'kode_pekerjaan' => $pkjBaru,
				'kode_pekerjaan2'=> $pkjLama,
				'tanggal_mulai_berlaku' => $tglMulai
			);
		}


		$this->M_upahphl->updateDataPekerjaHlcm($noind,$nama,$data);
		//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'UPDATE DATA PEKERJAAN NOIND='.$noind;
			$this->log_activity->activity_log($aksi, $detail);
		//

		$this->session->HlcmUbahPekerjaan = $noind;
		redirect(base_url('HitungHlcm/UbahPekerjaan'));
	}
}
?>
