<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Tambahan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringTambahan/M_pesanan');

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
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Pesanan Tambah Makan';
		$data['Menu'] = 'Pesanan Tambahan ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$today = date('Y-m-d');
		$data['tambahan'] = $this->M_pesanan->ambilTambahanKatering($today);
		$data['getnoind'] = $this->M_pesanan->ambilnoind();
		$data['getnoindberkas'] = $this->M_pesanan->ambiltberkas();
		$data['getkasie'] = $this->M_pesanan->getkasie();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringTambahan/V_Tambah');
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
		$tgl_pesanan = date('Y-m-d');
		$kd_shift = $this->input->post('shift_pesanan');
		$tempat_makan = $this->input->post('tempat_makan');
		$tambahan = $this->input->post('total_pesanan');
		$keperluan = $this->input->post('keperluan');
		$ket = $this->input->post('ketnoind');
		$implode = $this->input->post('implode');

		//insert to t_log
			$aksi = 'CATERING TAMBAHAN';
			$detail = 'TAMBAH MAKAN DI='.$tempat_makan.' PEMOHON='.$user;
			$this->log_activity->activity_log($aksi, $detail);
		//

		if($implode == 1){
			$in = implode("', '", $ket);
			$newin = "'$in'";
			$inputNama = str_replace("', '",', ',$in);
			$tmp_makan_tpribadi = $this->M_pesanan->getTempatMakanTpribadi(true ,$newin);
		}else{
			$in = $ket[0];
			$tmp_makan_tpribadi = $this->M_pesanan->getTempatMakanTpribadi(false, $in);
		}

		if ((($kd_shift == '1' || $kd_shift == '2' || $kd_shift == '3') && $keperluan == 'SELEKSI') || (($kd_shift == '1' || $kd_shift == '2' || $kd_shift == '3') && $keperluan == 'T/V')) {
			$array = array(
				'tgl_pesanan' => $tgl_pesanan,
				'tempat_makan' => $tempat_makan,
				'lokasi_kerja' => '01',
				'shift_tambahan' => $kd_shift,
				'tambahan' => $tambahan,
				'keterangan' => $inputNama,
				'user_' => $this->session->user,
				'status' => 1,
				'keperluan' => $keperluan
			);
			$this->M_pesanan->insertapprove($array);
		}

		$noind = $shift_validasi = $lokasi = array();
		if ($keperluan == 'LEMBUR_DATANG') {
			for ($i=0; $i < count($tmp_makan_tpribadi) ; $i++) {
				unset($noind);
				unset($shift_validasi);
				unset($lokasi);
				for ($j=0; $j < count($tmp_makan_tpribadi[$i]) ; $j++) {
						$noind[$j] = $tmp_makan_tpribadi[$i][$j]['noind'];
						$makan_validasi[$i][$j] = $tmp_makan_tpribadi[$i][$j]['tempat_makan'];
						$shift_validasi[$j] = $tmp_makan_tpribadi[$i][$j]['kd_shift'];
						$lokasi[$j] = $tmp_makan_tpribadi[$i][$j]['lokasi_kerja'];

						if ($kd_shift == '1') {
							$cekInvalid= $this->M_pesanan->getValidasiNoind($noind[$j], $makan_validasi[$i][$j]);
						}
						if ($kd_shift == '2') {
							$cekInvalid= $this->M_pesanan->getValidasiNoindShift2($noind[$j], $makan_validasi[$i][$j]);
						}
						if ($kd_shift == '3') {
							$cekInvalid= $this->M_pesanan->getValidasiNoindShift3($noind[$j], $makan_validasi[$i][$j]);
						}
						if(!empty($cekInvalid)){
							$validasi_noind[$i][] = $cekInvalid[0]['noind'];
							unset($noind[$j]);
						}
				}

				if(!empty($noind)){
					$noindNew = implode(', ', $noind);

					$array1 = array(
						'tgl_pesanan' => $tgl_pesanan,
						'tempat_makan' => $tmp_makan_tpribadi[$i][0]['tempat_makan'],
						'lokasi_kerja' => $lokasi[0],
						'shift_tambahan' => $kd_shift+1,
						'tambahan' => count($noind),
						'keterangan' => $noindNew,
						'user_' => $this->session->user,
						'status' => 1,
						'keperluan' => $keperluan,
						'shift_keterangan' => $shift_validasi[0]
					);
					$array2 = array(
						'tgl_pesanan' => $tgl_pesanan,
						'tempat_makan' => $tmp_makan_tpribadi[$i][0]['tempat_makan'],
						'lokasi_kerja' => $lokasi[0],
						'shift_tambahan' => $kd_shift,
						'tambahan' => count($noind),
						'keterangan' => $noindNew,
						'user_' => $this->session->user,
						'status' => 1,
						'keperluan' => $keperluan,
						'shift_keterangan' => $shift_validasi[0]
					);
					$this->M_pesanan->insertapprovedatang($array1, $array2);
				}
			}
		}

		$noind = $shift_validasi = $lokasi = array();
		if ($keperluan == 'LEMBUR_PULANG') {
			for ($i=0; $i < count($tmp_makan_tpribadi) ; $i++) {
				unset($noind);
				unset($shift_validasi);
				unset($lokasi);
				for ($j=0; $j < count($tmp_makan_tpribadi[$i]) ; $j++) {
						$noind[$j] = $tmp_makan_tpribadi[$i][$j]['noind'];
						$makan_validasi[$i][$j] = $tmp_makan_tpribadi[$i][$j]['tempat_makan'];
						$shift_validasi[$j] = $tmp_makan_tpribadi[$i][$j]['kd_shift'];
						$lokasi[$j] = $tmp_makan_tpribadi[$i][$j]['lokasi_kerja'];

						if ($kd_shift == '1') {
							$cekInvalid= $this->M_pesanan->getValidasiNoind($noind[$j], $makan_validasi[$i][$j]);
						}
						if ($kd_shift == '2') {
							$cekInvalid= $this->M_pesanan->getValidasiNoindShift2($noind[$j], $makan_validasi[$i][$j]);
						}
						if ($kd_shift == '3') {
							$cekInvalid= $this->M_pesanan->getValidasiNoindShift3($noind[$j], $makan_validasi[$i][$j]);
						}
						if(!empty($cekInvalid)){
							$validasi_noind[$i][] = $cekInvalid[0]['noind'];
							unset($noind[$j]);
						}
				}

				if(!empty($noind)){
					$noindNew = implode(', ', $noind);

					$array2 = array(
						'tgl_pesanan' => $tgl_pesanan,
						'tempat_makan' => $tmp_makan_tpribadi[$i][0]['tempat_makan'],
						'lokasi_kerja' => $lokasi[0],
						'shift_tambahan' => $kd_shift,
						'tambahan' => count($noind),
						'keterangan' => $noindNew,
						'user_' => $this->session->user,
						'status' => 1,
						'keperluan' => $keperluan,
						'shift_keterangan' => $shift_validasi[0]
					);
					$this->M_pesanan->insertapprove($array2);
				}
			}
		}


		if(isset($validasi_noind) && !empty($validasi_noind)){
			$validasi_noind = array_values($validasi_noind);
			$notif[0] = 'invalid';
			for ($i=0; $i < count($validasi_noind) ; $i++) {
				for ($j=0; $j < count($validasi_noind[$i]) ; $j++) {
					$whoInvalid[] = $validasi_noind[$i][$j];
				}
			}
			$total_mail = $tambahan - count($whoInvalid);
			$whoInvalid = implode(', ', $whoInvalid);
			$notif[1] = $whoInvalid;

			//keperluan e-mail
			$noind = $this->session->user;
			$object = $this->M_pesanan->getNama($noind);
			$seksi = $this->M_pesanan->getSieEmail($noind);
			$link = base_url('ApprovalTambahan');

			$this->sendMail($object, $link, $seksi, $total_mail);
		}else{
			//keperluan e-mail
			$noind = $this->session->user;
			$object = $this->M_pesanan->getNama($noind);
			$seksi = $this->M_pesanan->getSieEmail($noind);
			$link = base_url('ApprovalTambahan');

			$this->sendMail($object, $link, $seksi, $tambahan);
			$notif[0] = 'valid';
			$notif[1] = '';
		}

		echo json_encode($notif);
	}

	public function sendMail($object, $link, $seksi, $tambahan){
		$Quick = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'mail.quick.com',
			'smtp_user' => 'no-reply@quick.com',
			'smtp_pass' => '123456',
			'smtp_port' => 587,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];
		$this->load->library('email', $Quick);
		$this->email->from('no-reply', 'Permohonan Catering Tambahan');
		$getMail = $this->M_pesanan->getInMail();
		if (empty($getMail) || $getMail == '-') {
			$this->email->to('ayu_yuliana@quick.com');
		}else {
			$this->email->to($getMail);
		}
		$this->email->subject('Permintaan Approval Catering Tambahan');
		$this->email->message("Anda mendapat pengajuan approval <b>Tambahan Catering</b> dari <b>".$object."</b>, dengan rincian : <br><br>
			Jumlah : ".$tambahan." <br>
			Seksi : ".$seksi." <br>
			Status : <style= 'text-color: orange';>Menunggu Approval anda <br><br>
			Klik <a href=".$link.">Link</a> untuk Melihat Pesanan disini <br>
			");
		$this->email->send();
	}

}
