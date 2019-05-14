<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Tambahan extends CI_Controller
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
			redirect('index');
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
		$this->load->view('CateringManagement/Pesanan/V_Tambah');
		$this->load->view('V_Footer',$data);
	}

	public function tempatMakan()
	{
		$p = strtoupper($this->input->get('term'));

		$data = $this->M_pesanan->ambilTempatMakan($p);

		echo json_encode($data);
	}

	public function simpan()
	{
		$lokasi_kerja = $this->input->post('lokasi_pesanan');
		// $tgl_pesanan = $this->input->post('tanggal_pesanan');
		$tgl_pesanan = date('Y-m-d');
		$kd_shift = $this->input->post('shift_pesanan');
		$tempat_makan = $this->input->post('tempat_makan');
		$tambahan = $this->input->post('tambahan_pesanan');
		$pengurangan = $this->input->post('pengurangan_pesanan');

		// echo $tambahan;
		// exit();
		$array = array(
					'tgl_pesanan' => $tgl_pesanan,
					'tempat_makan' => $tempat_makan,
					'lokasi_kerja' => $lokasi_kerja,
					'kd_shift' => $kd_shift,
					'tambahan' => $tambahan,
					'pengurangan' => $pengurangan,
				);
		$this->M_pesanan->simpanTambahanKatering($array);

		$ru_where = array(
						'lokasi_kerja' => $lokasi_kerja,
						'tempat_makan' => $tempat_makan,
						'kd_shift' => $kd_shift,
						'tgl_pesanan' => $tgl_pesanan,
					);
		$pesanan = $this->M_pesanan->ambilPesananHariIni($ru_where);
		// $tambahkurang = $this->M_pesanan->ambilPenambahan($ru_where);

		// $tambah = $tambahkurang[0]['tambahan'];
		// $kurang = $tambahkurang[0]['pengurangan'];
		$jmltotal = ($pesanan[0]['jml_total']+$tambahan)-$pengurangan;

		$array_total = array(
							'jml_total' => $jmltotal,
						);
		$this->M_pesanan->editTotalPesanan($array_total,$ru_where);

		// echo $jmltotal;

		// echo "<pre>";
		// print_r($data);
		// exit();

		redirect('CateringManagement/PesananTambahan');

	}
	

	
}

/* End of file C_Printpp.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_Printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */