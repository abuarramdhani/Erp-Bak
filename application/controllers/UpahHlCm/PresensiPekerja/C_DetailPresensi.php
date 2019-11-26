<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class C_DetailPresensi extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('encrypt');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_presensipekerja');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
		date_default_timezone_set('Asia/Jakarta');
		$this->checkSession();
    }

    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}


    public function index(){
    	
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Presensi Pekerja';
		$data['SubMenuOne'] = 'Detail Presensi';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['tanggal'] = $this->M_presensipekerja->getTanggalDefault();
		// echo "<pre>";print_r($datareal);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/PresensiPekerja/V_IndexDetailPresensi',$data);
		$this->load->view('V_Footer',$data);
    }

    public function lihatwaktuabsen(){
    	$periode = $this->input->post('periode');
    	$prd = explode(" - ", $periode);
    	$noind = $this->input->post('noind');
    	$data = $this->M_presensipekerja->getWaktuAbsen(trim($noind),$prd['0'],$prd['1']);
    	echo json_encode($data);
    }

    public function lihatdata(){
    	$jenis_presensi = $this->input->get('kom_1');
    	$jenis_tampilan = $this->input->get('kom_2');
    	$cutoff_awal = $this->input->get('kom_3');
    	$cutoff_akhir = $this->input->get('kom_4');
    	$pkjoff_awal = $this->input->get('kom_5');
    	$pkjoff_akhir = $this->input->get('kom_6');
    	$pkjoff = $this->input->get('kom_7');

    	if ($jenis_presensi == "Presensi") {
    		$absen = $this->M_presensipekerja->getAbsenByParams($cutoff_awal,$cutoff_akhir,$pkjoff,$pkjoff_awal,$pkjoff_akhir);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' => $key['nama'],
							'noind' => $key['noind'],
							'data' => array()
						);
				}

				if ($key['kd_ket'] == "TT") {
					$keterangan = "T";
				}elseif($key['kd_ket'] == "TM"){
					$keterangan = "M";
				}elseif ($key['kd_ket'] == "TIK") {
					$keterangan = $this->M_presensipekerja->getProporsionalTIK($key['noind'],$key['tanggal']);
				}elseif ($key['kd_ket'] == "CT") {
					$susulan_ct = $this->M_presensipekerja->getSusulan("CT",$key['noind'],$key['tanggal']);
					if (!empty($susulan_ct)) {
						$keterangan = "CT*";
					}else{
						$keterangan = "CT";
					}
				}elseif ($key['kd_ket'] == "PSK") {
					$susulan_psk = $this->M_presensipekerja->getSusulan("SK",$key['noind'],$key['tanggal']);
					if (!empty($susulan_psk)) {
						$keterangan = "SK*";
					}else{
						$keterangan = "SK";
					}
				}elseif ($key['kd_ket'] !== "PKJ" and $key['kd_ket'] !== "PLB" and $key['kd_ket'] !== "HL") {
					$keterangan = substr($key['kd_ket'], -2);
				}elseif ($key['kd_ket'] !== "HL") {
					if ($jenis_tampilan == "1") {
						$keterangan = "/";
					}else{
						$keterangan = $this->M_presensipekerja->getInisial($key['noind'],$key['tanggal']);
					}
					
				}

				if ($keterangan !== "") {
					$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;
				}
				$simpan_noind = $key['noind'];
			}
			// $data['absen'] = $datareal;
			$data_tanggal = $this->M_presensipekerja->getTanggalByParams($cutoff_awal,$cutoff_akhir);
			//header awal
			$header_bulan = '<th rowspan="2" style="text-align: center;vertical-align: middle;">No. Induk</th>
							<th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>';
			$header_tanggal = "";
			$simpan_bulan_tahun = "";
			$simpan_bulan = "";
			$simpan_tahun = "";
			$hitung_colspan = 1;
			$tanggal_pertama = "";
			$tanggal_terakhir = "";
			$bulan = array (
							1 =>   'Januari',
								'Februari',
								'Maret',
								'April',
								'Mei',
								'Juni',
								'Juli',
								'Agustus',
								'September',
								'Oktober',
								'November',
								'Desember'
							);
			foreach ($data_tanggal as $dt_bulan) {
				$header_tanggal .= "<th style='text-align: center'>".$dt_bulan['hari']."</th>";
				if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
					$hitung_colspan++;
				}else{
					if ($simpan_bulan !== "") {
						$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
						$hitung_colspan = 1;
					}else{
						$tanggal_pertama = $dt_bulan['tanggal'];
					}
				}
				$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
				$simpan_bulan = $dt_bulan['bulan'];
				$simpan_tahun = $dt_bulan['tahun'];
			}
			$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
			$tanggal_terakhir = $dt_bulan['tanggal'];
			$data['header'] = "<tr>$header_bulan</tr><tr>$header_tanggal</tr>";
			//header akhir
			//body awal
			$body = "";
			foreach ($datareal as $abs) {
				$body .= "<tr><td style='text-align: center;vertical-align: middle'>".$abs['noind'];
				$body .= "<input type='hidden' value='".$tanggal_pertama." - ".$tanggal_terakhir."'>";
				$body .= "</td><td>".$abs['nama']."</td>";
				foreach ($data_tanggal as $dt_tanggal) {
					$keterangan = "-";
					if (isset($abs['data'][$dt_tanggal['index_tanggal']]) and !empty($abs['data'][$dt_tanggal['index_tanggal']])) {
						$keterangan = $abs['data'][$dt_tanggal['index_tanggal']];
					}
					$body .= "<td style='text-align: center;vertical-align: middle'>$keterangan</td>";
				}
				$body .= "</tr>";
			}
			$data['body'] = $body;
			//body akhir
    	}else{
    		$absen = $this->M_presensipekerja->getLemburByParams($cutoff_awal,$cutoff_akhir,$pkjoff,$pkjoff_awal,$pkjoff_akhir);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' => $key['nama'],
							'noind' => $key['noind'],
							'data' => array()
						);
				}

				
				$keterangan = round(floatval($key['total_lembur']),2);
				
				$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;

				$simpan_noind = $key['noind'];
			}
			// $data['absen'] = $datareal;
			$data_tanggal = $this->M_presensipekerja->getTanggalByParams($cutoff_awal,$cutoff_akhir);
			//header awal
			$header_bulan = '<th rowspan="2" style="text-align: center;vertical-align: middle;">No. Induk</th>
							<th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>';
			$header_tanggal = "";
			$simpan_bulan_tahun = "";
			$simpan_bulan = "";
			$simpan_tahun = "";
			$hitung_colspan = 1;
			$tanggal_pertama = "";
			$tanggal_terakhir = "";
			$bulan = array (
							1 =>   'Januari',
								'Februari',
								'Maret',
								'April',
								'Mei',
								'Juni',
								'Juli',
								'Agustus',
								'September',
								'Oktober',
								'November',
								'Desember'
							);
			foreach ($data_tanggal as $dt_bulan) {
				$header_tanggal .= "<th style='text-align: center'>".$dt_bulan['hari']."</th>";
				if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
					$hitung_colspan++;
				}else{
					if ($simpan_bulan !== "") {
						$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
						$hitung_colspan = 1;
					}else{
						$tanggal_pertama = $dt_bulan['tanggal'];
					}
				}
				$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
				$simpan_bulan = $dt_bulan['bulan'];
				$simpan_tahun = $dt_bulan['tahun'];
			}
			$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
			$tanggal_terakhir = $dt_bulan['tanggal'];
			$data['header'] = "<tr>$header_bulan</tr><tr>$header_tanggal</tr>";
			//header akhir
			//body awal
			$body = "";
			foreach ($datareal as $abs) {
				$body .= "<tr><td style='text-align: center;vertical-align: middle'>".$abs['noind'];
				$body .= "<input type='hidden' value='".$tanggal_pertama." - ".$tanggal_terakhir."'>";
				$body .= "</td><td>".$abs['nama']."</td>";
				foreach ($data_tanggal as $dt_tanggal) {
					$keterangan = "-";
					if (isset($abs['data'][$dt_tanggal['index_tanggal']]) and !empty($abs['data'][$dt_tanggal['index_tanggal']])) {
						$keterangan = $abs['data'][$dt_tanggal['index_tanggal']];
					}
					$body .= "<td style='text-align: center;vertical-align: middle'>$keterangan</td>";
				}
				$body .= "</tr>";
			}
			$data['body'] = $body;
			//body akhir
    	}

    	echo json_encode($data);
    }

    public function cetakdetailpresensi(){
    	$jenis_presensi = $this->input->get('kom_1');
    	$jenis_tampilan = $this->input->get('kom_2');
    	$cutoff_awal = $this->input->get('kom_3');
    	$cutoff_akhir = $this->input->get('kom_4');
    	$pkjoff_awal = $this->input->get('kom_5');
    	$pkjoff_akhir = $this->input->get('kom_6');
    	$pkjoff = $this->input->get('kom_7');

    	if ($jenis_presensi == "Presensi") {
    		$absen = $this->M_presensipekerja->getAbsenByParams($cutoff_awal,$cutoff_akhir,$pkjoff,$pkjoff_awal,$pkjoff_akhir);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' => $key['nama'],
							'noind' => $key['noind'],
							'data' => array()
						);
				}

				if ($key['kd_ket'] == "TT") {
					$keterangan = "T";
				}elseif($key['kd_ket'] == "TM"){
					$keterangan = "M";
				}elseif ($key['kd_ket'] == "TIK") {
					$keterangan = $this->M_presensipekerja->getProporsionalTIK($key['noind'],$key['tanggal']);
				}elseif ($key['kd_ket'] == "CT") {
					$susulan_ct = $this->M_presensipekerja->getSusulan("CT",$key['noind'],$key['tanggal']);
					if (!empty($susulan_ct)) {
						$keterangan = "CT*";
					}else{
						$keterangan = "CT";
					}
				}elseif ($key['kd_ket'] == "PSK") {
					$susulan_psk = $this->M_presensipekerja->getSusulan("SK",$key['noind'],$key['tanggal']);
					if (!empty($susulan_psk)) {
						$keterangan = "SK*";
					}else{
						$keterangan = "SK";
					}
				}elseif ($key['kd_ket'] !== "PKJ" and $key['kd_ket'] !== "PLB" and $key['kd_ket'] !== "HL") {
					$keterangan = substr($key['kd_ket'], -2);
				}elseif ($key['kd_ket'] !== "HL") {
					if ($jenis_tampilan == "1") {
						$keterangan = "/";
					}else{
						$keterangan = $this->M_presensipekerja->getInisial($key['noind'],$key['tanggal']);
					}
					
				}

				if ($keterangan !== "") {
					$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;
				}
				$simpan_noind = $key['noind'];
			}
			$data['absen'] = $datareal;
			$data['tanggal'] = $this->M_presensipekerja->getTanggalByParams($cutoff_awal,$cutoff_akhir);
			
    	}else{
    		$absen = $this->M_presensipekerja->getLemburByParams($cutoff_awal,$cutoff_akhir,$pkjoff,$pkjoff_awal,$pkjoff_akhir);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' => $key['nama'],
							'noind' => $key['noind'],
							'data' => array()
						);
				}

				
				$keterangan = round(floatval($key['total_lembur']),2);
				
				$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;

				$simpan_noind = $key['noind'];
			}
			$data['absen'] = $datareal;
			$data['tanggal'] = $this->M_presensipekerja->getTanggalByParams($cutoff_awal,$cutoff_akhir);
    	}

    	$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4-L', 8, '', 6, 5, 5, 5, 5, 5);
		$filename = 'DetailPresensi_'.$cutoff_awal.'_'.$cutoff_akhir.'.pdf';
		// $this->load->view('UpahHlCm/PresensiPekerja/V_cetakDetailPresensi', $data);
		$html = $this->load->view('UpahHlCm/PresensiPekerja/V_cetakDetailPresensi', $data, true);
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM pada oleh ".$this->session->user." tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i>");
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
    }

    public function simpandetailpresensi(){
    	$jenis_presensi = $this->input->get('kom_1');
    	$jenis_tampilan = $this->input->get('kom_2');
    	$cutoff_awal = $this->input->get('kom_3');
    	$cutoff_akhir = $this->input->get('kom_4');
    	$pkjoff_awal = $this->input->get('kom_5');
    	$pkjoff_akhir = $this->input->get('kom_6');
    	$pkjoff = $this->input->get('kom_7');
    	$keterangan_detail = $this->input->get('kom_8');

    	if ($jenis_presensi == "Presensi") {
    		$absen = $this->M_presensipekerja->getAbsenByParams($cutoff_awal,$cutoff_akhir,$pkjoff,$pkjoff_awal,$pkjoff_akhir);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' => $key['nama'],
							'noind' => $key['noind'],
							'data' => array()
						);
				}

				if ($key['kd_ket'] == "TT") {
					$keterangan = "T";
				}elseif($key['kd_ket'] == "TM"){
					$keterangan = "M";
				}elseif ($key['kd_ket'] == "TIK") {
					$keterangan = $this->M_presensipekerja->getProporsionalTIK($key['noind'],$key['tanggal']);
				}elseif ($key['kd_ket'] == "CT") {
					$susulan_ct = $this->M_presensipekerja->getSusulan("CT",$key['noind'],$key['tanggal']);
					if (!empty($susulan_ct)) {
						$keterangan = "CT*";
					}else{
						$keterangan = "CT";
					}
				}elseif ($key['kd_ket'] == "PSK") {
					$susulan_psk = $this->M_presensipekerja->getSusulan("SK",$key['noind'],$key['tanggal']);
					if (!empty($susulan_psk)) {
						$keterangan = "SK*";
					}else{
						$keterangan = "SK";
					}
				}elseif ($key['kd_ket'] !== "PKJ" and $key['kd_ket'] !== "PLB" and $key['kd_ket'] !== "HL") {
					$keterangan = substr($key['kd_ket'], -2);
				}elseif ($key['kd_ket'] !== "HL") {
					if ($jenis_tampilan == "1") {
						$keterangan = "/";
					}else{
						$keterangan = $this->M_presensipekerja->getInisial($key['noind'],$key['tanggal']);
					}
					
				}
				if ($keterangan !== "") {
					$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;
				}
				

				$simpan_noind = $key['noind'];
			}
			$data['absen'] = $datareal;
			$data['tanggal'] = $this->M_presensipekerja->getTanggalByParams($cutoff_awal,$cutoff_akhir);
			
    	}else{
    		$absen = $this->M_presensipekerja->getLemburByParams($cutoff_awal,$cutoff_akhir,$pkjoff,$pkjoff_awal,$pkjoff_akhir);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' => $key['nama'],
							'noind' => $key['noind'],
							'data' => array()
						);
				}

				
				$keterangan = round(floatval($key['total_lembur']),2);
				
				$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;

				$simpan_noind = $key['noind'];
			}
			$data['absen'] = $datareal;
			$data['tanggal'] = $this->M_presensipekerja->getTanggalByParams($cutoff_awal,$cutoff_akhir);
    	}

    	$data_simpan = array(
    		'tgl_awal_periode' => $cutoff_awal,
    		'tgl_akhir_periode' => $cutoff_akhir,
    		'created_by' => $this->session->user,
    		'isi' => json_encode($data),
    		'jenis_presensi' => $jenis_presensi,
    		'jenis_tampilan' => $jenis_tampilan,
    		'pekerja_keluar' => $pkjoff,
    		'tgl_awal_pekerja_keluar' => $pkjoff_awal,
    		'tgl_akhir_pekerja_keluar' => $pkjoff_akhir,
    		'asal' => 'Detail Presensi',
    		'keterangan' => $keterangan_detail
    	); 

    	$this->M_presensipekerja->insertArsip($data_simpan);

    	echo "Selesai";

    }
}

?>