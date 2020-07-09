<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Pesanan extends CI_Controller
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

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Pesanan/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function lihat()
	{
		

		$tgl = $this->input->post('tanggal_pesanan');
		$shift = $this->input->post('shift_pesanan');
		$lokasi = $this->input->post('lokasi_pesanan');

		// echo $lokasi;
		// exit();


		// $data['lihat_pesanan'] = $this->M_pesanan->ambilPesanan($tgl,$shift,$lokasi);
		$data['lihat_pesanan'] = $this->M_pesanan->cekData($tgl,$shift,$lokasi);

		$ru_where = array(
						'tgl_pesanan' => $tgl,
						'kd_shift' => $shift,
						'lokasi_kerja' => $lokasi,
					);

		$data['data_plot'] = $this->M_pesanan->ambilPloting($ru_where);


		// $data['tempat_pesan'] = $this->M_pesanan->tempatnya($shift,$tgl);
		// echo "<pre>";
		// print_r($data['data_plot']);
		// exit();


		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Pesanan/V_Index');
		$this->load->view('CateringManagement/Pesanan/V_cari',$data);
		$this->load->view('V_Footer',$data);
	}

	public function refresh()
	{
		

		$tgl = $this->input->post('tanggal_pesanan');
		$shift = $this->input->post('shift_pesanan');
		$lokasi = $this->input->post('lokasi_pesanan');

		// echo $lokasi;
		// exit();

		$cekData = $this->M_pesanan->cekData($tgl,$shift,$lokasi);

		if (empty($cekData)) {
			$pesanan = $this->M_pesanan->ambilPesanan($tgl,$shift,$lokasi);

			foreach ($pesanan as $key) {
				$tempat_makan = $key['tempat_makan'];
				$jml_shift = $key['jml_shift'];
				$jml_bukan_shift = $key['jml_bukan_shift'];
				if (empty($jml_bukan_shift)) {
					$jml_bukan_shift = 0;
				}
				$jml_total = $jml_shift+$jml_bukan_shift;

				$array = array(
							'tgl_pesanan' => $tgl,
							'tempat_makan' => $tempat_makan,
							'kd_shift' => $shift,
							'jml_shift' => $jml_shift,
							'jml_bukan_shift' => $jml_bukan_shift,
							'jml_total' => $jml_total,
							'lokasi_kerja' => $lokasi,
						);
				$this->M_pesanan->insertDataPesanan($array);
			}
		}else{
			$this->M_pesanan->hapusLama($tgl,$shift,$lokasi);

			$pesanan = $this->M_pesanan->ambilPesanan($tgl,$shift,$lokasi);

			foreach ($pesanan as $key) {
				$tempat_makan = $key['tempat_makan'];
				$jml_shift = $key['jml_shift'];
				$jml_bukan_shift = $key['jml_bukan_shift'];
				if (empty($jml_bukan_shift)) {
					$jml_bukan_shift = 0;
				}
				$jml_total = $jml_shift+$jml_bukan_shift;

				$array = array(
							'tgl_pesanan' => $tgl,
							'tempat_makan' => $tempat_makan,
							'kd_shift' => $shift,
							'jml_shift' => $jml_shift,
							'jml_bukan_shift' => $jml_bukan_shift,
							'jml_total' => $jml_total,
							'lokasi_kerja' => $lokasi,
						);
				$this->M_pesanan->insertDataPesanan($array);
			}
		}
		

		// $data['tempat_pesan'] = $this->M_pesanan->tempatnya($shift,$tgl);
		// echo "<pre>";
		// print_r($data['pesanan']);
		// exit();
		$data['lihat_pesanan'] = $this->M_pesanan->cekData($tgl,$shift,$lokasi);

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data Pesanan';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Pesanan/V_Index');
		$this->load->view('CateringManagement/Pesanan/V_cari',$data);
		$this->load->view('V_Footer',$data);
	}
	public function tempatPesan()
	{
		$p = strtoupper($this->input->get('term'));
		$tgl = $this->input->get('tgl');
		$shift = $this->input->get('shift');
		$lokasi = $this->input->get('lokasi');
		// $tempat_makan = $this->input->get('tempatmakan');

		$data = $this->M_pesanan->ambilTempatPesan($p,$tgl,$shift);

		echo json_encode($data);
	}

	public function transfer()
	{
		$shift = $this->input->post('Shift_pesan');
		$tgl = $this->input->post('tanggal_katering');
		$lokasi = $this->input->post('lokasi_kerja');
		$tempat_makan = $this->input->post('tempat_makan');
		$tempat_katering = $this->input->post('tempat_katering');

		$array = array(
					'tgl_pesanan' => $tgl,
					'kd_shift' => $shift,
					'tempat_makan' => $tempat_makan,
					'lokasi_kerja' => $lokasi,
					'fs_kd_katering' => $tempat_katering,
				);

		$this->M_pesanan->insertPlotting($array);

		redirect('CateringManagement/DataPesanan');
	}
	
}

/* End of file C_Printpp.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_Printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */