<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class C_JadwalPengiriman extends CI_Controller
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
		$this->load->model('CateringManagement/Cetak/M_jadwalpengiriman');
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

		$data['Title'] = 'Jadwal Pengiriman';
		$data['Menu'] = 'Cetak';
		$data['SubMenuOne'] = 'Jadwal Pengiriman';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['personalia'] = $this->M_jadwalpengiriman->getPekerjaPersonalia();
		$data['catering'] = $this->M_jadwalpengiriman->getCateringActive();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Cetak/JadwalPengiriman/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Read(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Jadwal Pengiriman';
		$data['Menu'] = 'Cetak';
		$data['SubMenuOne'] = 'Jadwal Pengiriman';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kd_katering = $this->input->post('txtKdCateringJadwalPengiriman');
		$nama_katering = $this->M_jadwalpengiriman->getCateringActiveByKd($kd_katering);
		$bln = $this->input->post('txtPeriodeJadwalPengiriman');
		$paket = $this->input->post('txtMenuPaketJadwalPengiriman');
		$tglPembuatan = $this->input->post('txtTanggalPembuatanJadwalPengiriman');
		$personPersonalia = $this->input->post('txtPersonaliaJadwalPengiriman');
		$personCatering = $this->input->post('txtCateringJadwalPengiriman');
		$data['pengiriman'] = array(
			'nama_catering' => $nama_katering['0']['nama'],
			'kode_catering' => $kd_katering,
			'bulan' => $bln,
			'paket' => $paket,
			'tanggalbuat' => $tglPembuatan,
			'ppersonalia' => $personPersonalia,
			'pcatering' => $personCatering
		);
		$hasil = $this->M_jadwalpengiriman->getTampilPesanan($kd_katering,$bln);
		$angka = 0;
		$bulan = array(
			"",
			"Januari",
			"Februari",
			"Maret",
			"April",
			"Mei",
			"Juni",
			"Juli",
			"Agustus",
			"September",
			"Oktober",
			"November",
			"Desember");
		$dayow = array(
			"",
			"Minggu",
			"Senin",
			"Selasa",
			"Rabu",
			"Kamis",
			"Jumat",
			"Sabtu"
		);
		foreach ($hasil as $key) {
			$angka2 = 0;
			if ($key['hari2'] == '0') {
				$arrData[$angka] = array(
					'tanggal' => $key['tanggal1']." ".$bulan[intval($key['bulan'])]." ".$key['tahun']."<br>(".$dayow[intval($key['hari1'])].")"
				);
			}else{
				$arrData[$angka] = array(
					'tanggal' => $key['tanggal1']." - ".$key['tanggal2']." ".$bulan[intval($key['bulan'])]." ".$key['tahun']."<br>(".$dayow[intval($key['hari1'])]." - ".$dayow[intval($key['hari2'])].")"
				);
			}
			
			if ($key['fs_tujuan_shift1'] == 't' or $key['fs_tujuan_shift1'] == '1') {
				$ket = $this->M_jadwalpengiriman->getKeteranganJadwalPengiriman($key['fs_kd_katering'],"1",$key['fs_tanggal'],$bulan[intval($key['bulan'])]);
				$wkt = $this->M_jadwalpengiriman->getWaktuJadwalPengiriman('4',$key['hari1']);
				$arrData[$angka]['jadwal'] = "SHIFT 1 & SHIFT UMUM";
				$arrData[$angka]['shift'] = "1";
				$arrData[$angka]['waktu'] = $wkt['0']['fs_jam_datang'];
				if (empty($ket)) {
					$arrData[$angka]['keterangan'] = "";
					$angka2++;
				}else{
					$arrData[$angka]['keterangan'] = $ket['0']['fs_keterangan'];
					$angka2++;
				}
				$angka++;
			}
			if ($key['fs_tujuan_shift2'] == 't' or $key['fs_tujuan_shift2'] == '1') {
				$ket = $this->M_jadwalpengiriman->getKeteranganJadwalPengiriman($key['fs_kd_katering'],"2",$key['fs_tanggal'],$bulan[intval($key['bulan'])]);
				$wkt = $this->M_jadwalpengiriman->getWaktuJadwalPengiriman('2',$key['hari1']);
				$arrData[$angka]['jadwal'] = "SHIFT 2";
				$arrData[$angka]['shift'] = "2";
				$arrData[$angka]['waktu'] = $wkt['0']['fs_jam_datang'];
				if (empty($ket)) {
					$arrData[$angka]['keterangan'] = "";
					$angka2++;
				}else{
					$arrData[$angka]['keterangan'] = $ket['0']['fs_keterangan'];
					$angka2++;
				}
				$angka++;
			}
			if ($key['fs_tujuan_shift3'] == 't' or $key['fs_tujuan_shift3'] == '1') {
				$ket = $this->M_jadwalpengiriman->getKeteranganJadwalPengiriman($key['fs_kd_katering'],"3",$key['fs_tanggal'],$bulan[intval($key['bulan'])]);
				$wkt = $this->M_jadwalpengiriman->getWaktuJadwalPengiriman('3',$key['hari1']);
				$arrData[$angka]['jadwal'] = "SHIFT 3";
				$arrData[$angka]['shift'] = "3";
				$arrData[$angka]['waktu'] = $wkt['0']['fs_jam_datang'];
				if (empty($ket)) {
					$arrData[$angka]['keterangan'] = "";
					$angka2++;
				}else{
					$arrData[$angka]['keterangan'] = $ket['0']['fs_keterangan'];
					$angka2++;
				}
				$angka++;
			}
			$arrData[$angka-$angka2]['jumlah'] = $angka2;
			// $angka++;
		}
		
		$data['table'] = $arrData;
// echo "<pre>";
// print_r($arrData);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Cetak/JadwalPengiriman/V_read.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Cetak(){
		$kd_katering = $this->input->post('txtKdCateringJadwalPengiriman');
		$nama_katering = $this->M_jadwalpengiriman->getCateringActiveByKd($kd_katering);
		$bln = $this->input->post('txtPeriodeJadwalPengiriman');
		$paket = $this->input->post('txtMenuPaketJadwalPengiriman');
		$tglPembuatan = $this->input->post('txtTanggalPembuatanJadwalPengiriman');
		$personPersonalia = $this->input->post('txtPersonaliaJadwalPengiriman');
		$personCatering = $this->input->post('txtCateringJadwalPengiriman');
		$data['pengiriman'] = array(
			'nama_catering' => $nama_katering['0']['nama'],
			'kode_catering' => $kd_katering,
			'bulan' => $bln,
			'paket' => $paket,
			'tanggalbuat' => $tglPembuatan,
			'ppersonalia' => $personPersonalia,
			'pcatering' => $personCatering
		);
		$hasil = $this->M_jadwalpengiriman->getTampilPesanan($kd_katering,$bln);
		$angka = 0;
		$bulan = array(
			"",
			"Januari",
			"Februari",
			"Maret",
			"April",
			"Mei",
			"Juni",
			"Juli",
			"Agustus",
			"September",
			"Oktober",
			"November",
			"Desember");
		$dayow = array(
			"",
			"Minggu",
			"Senin",
			"Selasa",
			"Rabu",
			"Kamis",
			"Jumat",
			"Sabtu"
		);
		foreach ($hasil as $key) {
			if ($key['hari2'] == '0') {
				$arrData[$angka] = array(
					'tanggal' => $key['tanggal1']." ".$bulan[intval($key['bulan'])]." ".$key['tahun']."<br>(".$dayow[intval($key['hari1'])].")",
					'jadwal' => "",
					'waktu' => "",
					'keterangan' => ""
				);
			}else{
				$arrData[$angka] = array(
					'tanggal' => $key['tanggal1']." - ".$key['tanggal2']." ".$bulan[intval($key['bulan'])]." ".$key['tahun']."<br>(".$dayow[intval($key['hari1'])]." - ".$dayow[intval($key['hari2'])].")",
					'jadwal' => "",
					'waktu' => "",
					'keterangan' => ""
				);
			}
			
			if ($key['fs_tujuan_shift1'] == 't' or $key['fs_tujuan_shift1'] == '1') {
				$ket = $this->M_jadwalpengiriman->getKeteranganJadwalPengiriman($key['fs_kd_katering'],"1",$key['fs_tanggal'],$bulan[intval($key['bulan'])]);

				if (empty($arrData[$angka]['jadwal'])) {
					$arrData[$angka]['jadwal'] = "SHIFT 1 & SHIFT UMUM";
					if (empty($ket)) {
						$arrData[$angka]['keterangan'] = "";
					}else{
						$arrData[$angka]['keterangan'] = $ket['0']['fs_keterangan'];
					}
				}else{
					$arrData[$angka]['jadwal'] = $arrData[$angka]['jadwal']."<br>SHIFT 1 & SHIFT UMUM";
					if (empty($ket)) {
						$arrData[$angka]['keterangan'] = $arrData[$angka]['keterangan']."<br>";
					}else{
						$arrData[$angka]['keterangan'] = $arrData[$angka]['keterangan']."<br>".$ket['0']['fs_keterangan'];
					}
				}
				 
			}
			if ($key['fs_tujuan_shift2'] == 't' or $key['fs_tujuan_shift2'] == '1') {
				$ket = $this->M_jadwalpengiriman->getKeteranganJadwalPengiriman($key['fs_kd_katering'],"2",$key['fs_tanggal'],$bulan[intval($key['bulan'])]);

				if (empty($arrData[$angka]['jadwal'])) {
					$arrData[$angka]['jadwal'] = "SHIFT 2";
					if (empty($ket)) {
						$arrData[$angka]['keterangan'] = "";
					}else{
						$arrData[$angka]['keterangan'] = $ket['0']['fs_keterangan'];
					}
				}else{
					$arrData[$angka]['jadwal'] = $arrData[$angka]['jadwal']."<br>SHIFT 2";
					if (empty($ket)) {
						$arrData[$angka]['keterangan'] = $arrData[$angka]['keterangan']."<br>";
					}else{
						$arrData[$angka]['keterangan'] = $arrData[$angka]['keterangan']."<br>".$ket['0']['fs_keterangan'];
					}
				}
			}
			if ($key['fs_tujuan_shift3'] == 't' or $key['fs_tujuan_shift3'] == '1') {
				$ket = $this->M_jadwalpengiriman->getKeteranganJadwalPengiriman($key['fs_kd_katering'],"3",$key['fs_tanggal'],$bulan[intval($key['bulan'])]);

				if (empty($arrData[$angka]['jadwal'])) {
					$arrData[$angka]['jadwal'] = "SHIFT 3";
					if (empty($ket)) {
						$arrData[$angka]['keterangan'] = "";
					}else{
						$arrData[$angka]['keterangan'] = $ket['0']['fs_keterangan'];
					}
				}else{
					$arrData[$angka]['jadwal'] = $arrData[$angka]['jadwal']."<br>SHIFT 3";
					if (empty($ket)) {
						$arrData[$angka]['keterangan'] = $arrData[$angka]['keterangan']."<br>";
					}else{
						$arrData[$angka]['keterangan'] = $arrData[$angka]['keterangan']."<br>".$ket['0']['fs_keterangan'];
					}
				}
				 
			}

			$angka++;
		}

		$data['table'] = $arrData;

		$pdf = $this->pdf->load();
		$pdf = new mPDF('', 'F4',8,10, 10, 10, 10, 9, 9);
		$filename = "JadwalPengiriman.pdf";
		$html = $this->load->view('CateringManagement/Cetak/JadwalPengiriman/V_cetak.php',$data,true);
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". <br>Halaman {PAGENO} dari {nb}</i>");
		$pdf->Output($filename, 'I');
	}

	public function Save(){
		$keterangan = strtoupper($this->input->post('keterangan'));
		$tanggal = $this->input->post('tanggal');
		$tanggal = explode("<br>", $tanggal);
		$tanggal = $tanggal['0'];
		$catering = $this->input->post('catering');
		$shift = $this->input->post('shift');
		$isi = $this->M_jadwalpengiriman->getCheckKeterangan($tanggal,$catering,$shift);
		if (empty($isi)) {
			$this->M_jadwalpengiriman->insertKeterangan($tanggal,$catering,$shift,$keterangan);
			return "insert";
		}else{
			$this->M_jadwalpengiriman->updateKeterangan($tanggal,$catering,$shift,$keterangan);
			return "update";
		}
	}
}
?>