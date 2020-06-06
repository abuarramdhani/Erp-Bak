<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class C_JadwalLayanan extends CI_Controller
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
		$this->load->model('CateringManagement/Cetak/M_jadwallayanan');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Jadwal Pelayanan';
		$data['Menu'] = 'Cetak';
		$data['SubMenuOne'] = 'Jadwal Pelayanan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Cetak/JadwalLayanan/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Read(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Jadwal Pelayanan';
		$data['Menu'] = 'Cetak';
		$data['SubMenuOne'] = 'Jadwal Pelayanan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$bln = $this->input->post('txtPeriodeJadwalLayanan');
		$paket = $this->input->post('txtPaketJadwalLayanan');
		$tglCetak = $this->input->post('txtTanggalJadwalLayanan');
		$lokasi = $this->input->post('slcLokasiJadwalLayanan');

		$tanggalTampilPesanan = $this->M_jadwallayanan->getTanggalTampilPesanan($bln,$lokasi);
		$angka = 0;
		$dayow = array("","Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		foreach ($tanggalTampilPesanan as $key) {
			if ($key['tanggal2'] == '0') {
				$arrData[$angka] = array(
					'tanggal' => $key['fs_tanggal']."<br>(".$dayow[$key['hari1']].")", 
					'shift1' => "", 
					'shift2' => "", 
					'shift3' => "", 
					'libur' => "", 
					'keterangan' => "" 
				);
			}else{
				$arrData[$angka] = array(
					'tanggal' => $key['fs_tanggal']."<br>(".$dayow[$key['hari1']]." - ".$dayow[$key['hari2']].")", 
					'shift1' => "", 
					'shift2' => "", 
					'shift3' => "", 
					'libur' => "", 
					'keterangan' => "" 
				);
			}

			$dataTampilPesanan = $this->M_jadwallayanan->getDataTampilPesanan($key['fs_tanggal'],$lokasi);
			foreach ($dataTampilPesanan as $value) {
				if ($value['fs_tujuan_shift1'] == 't') {
					if ($arrData[$angka]['shift1'] == "") {
						$arrData[$angka]['shift1'] = $value['fs_nama_katering'];
					}else{
						$arrData[$angka]['shift1'] = $arrData[$angka]['shift1']."<br>".$value['fs_nama_katering'];
					}
				}

				if ($value['fs_tujuan_shift2'] == 't') {
					if ($arrData[$angka]['shift2'] == "") {
						$arrData[$angka]['shift2'] = $value['fs_nama_katering'];
					}else{
						$arrData[$angka]['shift2'] = $arrData[$angka]['shift2']."<br>".$value['fs_nama_katering'];
					}
				}

				if ($value['fs_tujuan_shift3'] == 't') {
					if ($arrData[$angka]['shift3'] == "") {
						$arrData[$angka]['shift3'] = $value['fs_nama_katering'];
					}else{
						$arrData[$angka]['shift3'] = $arrData[$angka]['shift3']."<br>".$value['fs_nama_katering'];
					}
				}
			}

			if ($arrData[$angka]['shift1'] == "") {
				$arrData[$angka]['shift1'] = "-";
			}
			if ($arrData[$angka]['shift2'] == "") {
				$arrData[$angka]['shift2'] = "-";
			}
			if ($arrData[$angka]['shift3'] == "") {
				$arrData[$angka]['shift3'] = "-";
			}
			if ($arrData[$angka]['libur'] == "") {
				$arrData[$angka]['libur'] = "-";
			}
			
			$angka++;
		}
		$data['data'] = array(
			'bulan' => $bln, 
			'cetak' => $tglCetak, 
			'lokasi' => $lokasi,
			'paket' => $paket
		);
		$data['table'] = $arrData;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Cetak/JadwalLayanan/V_read.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Cetak(){
		$this->load->library('pdf');
		$bln = $this->input->post('txtPeriodeJadwalLayanan');
		$paket = $this->input->post('txtPaketJadwalLayanan');
		$tglCetak = $this->input->post('txtTanggalJadwalLayanan');
		$lokasi = $this->input->post('slcLokasiJadwalLayanan');

		$tanggalTampilPesanan = $this->M_jadwallayanan->getTanggalTampilPesanan($bln,$lokasi);
		$angka = 0;
		$dayow = array("","Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		foreach ($tanggalTampilPesanan as $key) {
			if ($key['tanggal2'] == '0') {
				$arrData[$angka] = array(
					'tanggal' => $key['fs_tanggal']."<br>(".$dayow[$key['hari1']].")", 
					'shift1' => "", 
					'shift2' => "", 
					'shift3' => "", 
					'libur' => "", 
					'keterangan' => "" 
				);
			}else{
				$arrData[$angka] = array(
					'tanggal' => $key['fs_tanggal']."<br>(".$dayow[$key['hari1']]." - ".$dayow[$key['hari2']].")", 
					'shift1' => "", 
					'shift2' => "", 
					'shift3' => "", 
					'libur' => "", 
					'keterangan' => "" 
				);
			}
			
			$dataTampilPesanan = $this->M_jadwallayanan->getDataTampilPesanan($key['fs_tanggal'],$lokasi);
			foreach ($dataTampilPesanan as $value) {
				if ($value['fs_tujuan_shift1'] == 't') {
					if ($arrData[$angka]['shift1'] == "") {
						$arrData[$angka]['shift1'] = $value['fs_nama_katering'];
					}else{
						$arrData[$angka]['shift1'] = $arrData[$angka]['shift1']."<br>".$value['fs_nama_katering'];
					}
				}

				if ($value['fs_tujuan_shift2'] == 't') {
					if ($arrData[$angka]['shift2'] == "") {
						$arrData[$angka]['shift2'] = $value['fs_nama_katering'];
					}else{
						$arrData[$angka]['shift2'] = $arrData[$angka]['shift2']."<br>".$value['fs_nama_katering'];
					}
				}

				if ($value['fs_tujuan_shift3'] == 't') {
					if ($arrData[$angka]['shift3'] == "") {
						$arrData[$angka]['shift3'] = $value['fs_nama_katering'];
					}else{
						$arrData[$angka]['shift3'] = $arrData[$angka]['shift3']."<br>".$value['fs_nama_katering'];
					}
				}
			}

			if ($arrData[$angka]['shift1'] == "") {
				$arrData[$angka]['shift1'] = "-";
			}
			if ($arrData[$angka]['shift2'] == "") {
				$arrData[$angka]['shift2'] = "-";
			}
			if ($arrData[$angka]['shift3'] == "") {
				$arrData[$angka]['shift3'] = "-";
			}
			if ($arrData[$angka]['libur'] == "") {
				$arrData[$angka]['libur'] = "-";
			}
			
			$angka++;
		}
		$data['data'] = array(
			'bulan' => $bln, 
			'cetak' => $tglCetak, 
			'paket' => $paket
		);
		$data['table'] = $arrData;
		
		$pdf = $this->pdf->load();
		$pdf = new mPDF('', 'F4',8,15, 15, 16, 16, 9, 9);
		$filename = "JadwalLayanan.pdf";
		$html = $this->load->view('CateringManagement/Cetak/JadwalLayanan/V_cetak.php',$data,true);
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}
}
?>