<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_IsolasiMandiri extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/IsolasiMandiri/M_isolasimandiri');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Isolasi Mandiri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Isolasi Mandiri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['data'] = $this->M_isolasimandiri->getSuratIsolasiMandiriAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Isolasi Mandiri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Isolasi Mandiri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Pekerja(){
		$key = $this->input->get('term');
		$data = $this->M_isolasimandiri->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function Preview(){
		$kepada = $this->input->get('simTo');
		$pekerja = $this->input->get('simPekerja');
		$wawancara = $this->input->get('simWawancara');
		$mulai = $this->input->get('simMulai');
		$selesai = $this->input->get('simSelesai');
		$hari = $this->input->get('simHari');
		$status = $this->input->get('simStatus');
		$dibuat = $this->input->get('simDibuat');
		$menyetujui = $this->input->get('simMenyetujui');
		$mengetahui = $this->input->get('simMengetahui');
		$cetak = $this->input->get('simCetak');
		$noSurat = $this->input->get('simNo');

		$pekerja_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($pekerja);
		$kepada_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($kepada);
		$dibuat_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($dibuat);
		$menyetujui_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($menyetujui);
		$mengetahui_arr = $this->M_isolasimandiri->getDetailPekerjaByNoind($mengetahui);

		if ($status == "PRM") {
			$status = "dirumahkan";
		}else{
			$status = "pekerja sakit keterangan dokter";
		}

		$surat_array = $this->M_isolasimandiri->getSuratIsolasiMandiriTemplate();
		$surat_text = $surat_array[0]['isi_surat'];
		$surat_text = str_replace("surat_isolasi_mandiri_no_surat", $noSurat, $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_kepada_nama", ucwords(strtolower($kepada_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_kepada_jabatan", ucwords(strtolower($kepada_arr[0]['jabatan'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_pekerja_nama", ucwords(strtolower($pekerja_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_pekerja_noind", $pekerja_arr[0]['noind'], $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_pekerja_unit", ucwords(strtolower($pekerja_arr[0]['unit'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_wawancara", strftime('%d %B %Y',strtotime($wawancara)), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_hari_angka", $hari, $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_hari_kalimat", $this->readNumber($hari), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_mulai", strftime('%d %B %Y',strtotime($mulai)), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_selesai", strftime('%d %B %Y',strtotime($selesai)), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_status", $status, $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_tanggal_dibuat", strftime('%d %B %Y',strtotime($cetak)), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_mengetahui_nama", ucwords(strtolower($mengetahui_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_menyetujui_nama", ucwords(strtolower($menyetujui_arr[0]['nama'])), $surat_text);
		$surat_text = str_replace("surat_isolasi_mandiri_dibuat_nama", ucwords(strtolower($dibuat_arr[0]['nama'])), $surat_text);

		$data = array(
			'surat' => $surat_text,
			'get_' => $_GET,
			'surat_asli' => $surat_array
		);
		echo json_encode($data);
		
	}

	public function Simpan(){
		// echo "<pre>";print_r($_POST);exit();
		// $no_surat = "003/TIM-COVID19/V/20";
		$tanggal_cetak = $this->input->post('txtMPSuratIsolasiMandiriCetakTanggal');
		$nomor = $this->M_isolasimandiri->getLastNoSuratByTanggalCetak($tanggal_cetak);
		if (!empty($nomor)) {
			$no = ($nomor[0]['nomor'] + 1)."";
			if (strlen($no) < 3) {
				for ($i=strlen($no); $i < 3; $i++) { 
					$no = "0".$no;
				}
			}
		}else{
			$no = "001";
		}
		$bulan_romawi = array(
			1 	=> "I",
			2 	=> "II",
			3 	=> "III",
			4 	=> "IV",
			5 	=> "V",
			6 	=> "VI",
			7 	=> "VII",
			8 	=> "VIII",
			9 	=> "IX",
			10 	=> "X",
			11 	=> "XI",
			12 	=> "XII"
		);
		$no_surat = $no."/TIM-COVID19/".$bulan_romawi[intval(date('m', strtotime($tanggal_cetak)))].'/'.date('y', strtotime($tanggal_cetak));

		// echo $no_surat;exit();

		$data_insert = array(
			'pekerja' 				=> $this->input->post('slcMPSuratIsolasiMandiriPekerja'),
			'kepada' 				=> $this->input->post('slcMPSuratIsolasiMandiriTo'),
			'mengetahui' 			=> $this->input->post('slcMPSuratIsolasiMandiriMengetahui'),
			'menyetujui' 			=> $this->input->post('slcMPSuratIsolasiMandirimenyetujui'),
			'dibuat' 				=> $this->input->post('slcMPSuratIsolasiMandiriDibuat'),
			'no_surat' 				=> $no_surat,
			'tgl_wawancara' 		=> $this->input->post('txtMPSuratIsolasiMandiriWawancaraTanggal'),
			'tgl_mulai' 			=> $this->input->post('txtMPSuratIsolasiMandiriMulaiIsolasiTanggal'),
			'tgl_selesai' 			=> $this->input->post('txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal'),
			'jml_hari' 				=> $this->input->post('txtMPSuratIsolasiMandiriJumlahHari'),
			'status' 				=> $this->input->post('slcMPSuratIsolasiMandiriStatus'),
			'tgl_cetak' 			=> $this->input->post('txtMPSuratIsolasiMandiriCetakTanggal'),
			'isi_surat' 			=> str_replace("surat_isolasi_mandiri_no_surat",$no_surat,$this->input->post('txtMPSuratIsolasiMandiriSurat')),
			'created_by' 			=> $this->session->user
		);

		$this->M_isolasimandiri->insertSuratIsolasiMandiri($data_insert);

		redirect(base_url('MasterPekerja/Surat/SuratIsolasiMandiri'));
	}

	public function Hapus($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;

		$this->M_isolasimandiri->deleteSuratIsolasiMandiriByID($id);

		redirect(base_url('MasterPekerja/Surat/SuratIsolasiMandiri'));
	}

	public function PDF($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;
		
		$data['data'] = $this->M_isolasimandiri->getSuratIsolasiMandiriById($id);

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 10, "timesnewroman", 20, 20, 50, 20, 20, 5);
		$filename = 'Surat Tugas Pekerja'.$value.'.pdf';
		// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pcetak', $data);
		$html = $this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_cetak', $data, true);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function readNumber($number){
		if (strlen($number."") <= 4) {
			$num = $number."";
			$retval = "";
			$panjang = strlen($num);
			for ($i= ($panjang - 1); $i >= 0; $i--) { 
				$index = ($panjang - 1) - $i;
				// echo $num[$i].' - '.$i.' - '.$num[$index];
				if ($i == 0) {
					if ($panjang > 1) {
						if ($num[$index - 1] != "1" && $num[$index] != "0") {
							$retval .= $this->readNumber2($num[$index]);
						}
					}else{
						$retval .= $this->readNumber2($num[$index]);
					}
				}elseif ($i == 1) {
					if ($num[$index] == "1") {
						if ($num[$index + 1] == "0") {
							$retval .= " sepuluh ";
						}elseif($num[$index + 1] == "1"){
							$retval .= " sebelas ";
						}else{
							$retval .= $this->readNumber2($num[$index + 1]);
							$retval .= " belas ";
						}
					}elseif($num[$index] == "0"){
						$retval .= "";
					}else{
						$retval .= $this->readNumber2($num[$index]);
						$retval .= " puluh ";

					}
				}elseif ($i == 2) {
					if ($num[$index] == "1") {
						$retval .= " seratus ";
					}elseif($num[$index] == "0"){
						$retval .= "";
					}else{
						$retval .= $this->readNumber2($num[$index]);
						$retval .= " ratus ";
					}
				}elseif ($i == 3) {
					if ($num[$index] == "1") {
						$retval .= " seribu ";
					}elseif($num[$index] == "0"){
						$retval .= "";
					}else{
						$retval .= $this->readNumber2($num[$index]);
						$retval .= " ribu ";

					}
				}
				// echo "<br>";
			}

			return $retval;
			// echo $retval;
		}else{
			return "max 9999";
		}
	}

	public function readNumber2($number){
		$number_array = array (
			0 => "nol",
			1 => "satu",
			2 => "dua",
			3 => "tiga",
			4 => "empat",
			5 => "lima",
			6 => "enam",
			7 => "tujuh",
			8 => "delapan",
			9 => "sembilan"
		);

		return $number_array[$number];
	}

	public function Ubah($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;

		$data['data'] = $this->M_isolasimandiri->getSuratIsolasiMandiriById($id);
		$data['id_encoded'] = $id_encoded;

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Surat Isolasi Mandiri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Isolasi Mandiri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/IsolasiMandiri/V_edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id_encoded){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encoded);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;

		$data_update = array(
			'pekerja' 				=> $this->input->post('slcMPSuratIsolasiMandiriPekerja'),
			'kepada' 				=> $this->input->post('slcMPSuratIsolasiMandiriTo'),
			'mengetahui' 			=> $this->input->post('slcMPSuratIsolasiMandiriMengetahui'),
			'menyetujui' 			=> $this->input->post('slcMPSuratIsolasiMandirimenyetujui'),
			'dibuat' 				=> $this->input->post('slcMPSuratIsolasiMandiriDibuat'),
			'no_surat' 				=> $this->input->post('txtMPSuratIsolasiMandiriNoSurat'),
			'tgl_wawancara' 		=> $this->input->post('txtMPSuratIsolasiMandiriWawancaraTanggal'),
			'tgl_mulai' 			=> $this->input->post('txtMPSuratIsolasiMandiriMulaiIsolasiTanggal'),
			'tgl_selesai' 			=> $this->input->post('txtMPSuratIsolasiMandiriSelesaiIsolasiTanggal'),
			'jml_hari' 				=> $this->input->post('txtMPSuratIsolasiMandiriJumlahHari'),
			'status' 				=> $this->input->post('slcMPSuratIsolasiMandiriStatus'),
			'tgl_cetak' 			=> $this->input->post('txtMPSuratIsolasiMandiriCetakTanggal'),
			'isi_surat' 			=> str_replace("surat_isolasi_mandiri_no_surat",$no_surat,$this->input->post('txtMPSuratIsolasiMandiriSurat')),
			'created_by' 			=> $this->session->user
		);

		$this->M_isolasimandiri->updateSuratIsolasiMandiriByID($data_update,$id);

		redirect(base_url('MasterPekerja/Surat/SuratIsolasiMandiri'));
	}
}

?>