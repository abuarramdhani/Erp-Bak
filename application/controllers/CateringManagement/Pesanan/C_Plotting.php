<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Plotting extends CI_Controller
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
		$this->load->model('CateringManagement/Pesanan/M_pesanan');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$today = date('Y-m-d');
		$data['tambahan'] = $this->M_pesanan->ambilTambahanKatering($today);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Pesanan/V_Plotting');
		$this->load->view('V_Footer',$data);
	}

	public function lihat()
	{
		$tgl = $this->input->post('tanggal_pesanan');
		$shift = $this->input->post('shift_pesanan');
		$lokasi = $this->input->post('lokasi_pesanan');

		$data['data'] = $this->M_pesanan->ambilAll($tgl,$shift,$lokasi);

		$data['jadwal'] = $this->M_pesanan->ambilJadwal($tgl,$shift);

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$today = date('Y-m-d');
		$data['tambahan'] = $this->M_pesanan->ambilTambahanKatering($today);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Pesanan/V_Plotting',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pindah()
	{
		$shift = $this->input->post('Shift_pesan');
		$tgl = $this->input->post('tanggal_katering');
		$lokasi = $this->input->post('lokasi_kerja');
		$tempat_makan = $this->input->post('tempat_makan');
		$tempat_katering = $this->input->post('tempat_katering');

		$ru_where = array(
					'tgl_pesanan' => $tgl,
					'kd_shift' => $shift,
					'tempat_makan' => $tempat_makan,
					'lokasi_kerja' => $lokasi,
				);
		$array = array(
					'fs_kd_katering' => $tempat_katering,
				);
		$this->M_pesanan->updatePlotting($ru_where,$array);

		redirect('CateringManagement/Plotting');
	}
	
	

	
}

/* End of file C_Printpp.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_Printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */