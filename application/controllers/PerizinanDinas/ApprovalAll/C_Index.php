<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('upload');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PerizinanDinas/ApprovalAll/M_index');

		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Approve Atasan';
		$data['Menu'] = 'Perizinan Dinas';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$datamenu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$aksesRahasia = $this->M_index->allowedAccess();
		$aksesRahasia = array_column($aksesRahasia, 'noind');

		if (in_array($no_induk, $aksesRahasia)) {
			$data['UserMenu'] = $datamenu;
		} else {
			unset($datamenu[1]);
			unset($datamenu[2]);
			$data['UserMenu'] = $datamenu;
		}

		$a = array();
		$b = $this->M_index->getTujuanA(date('Y-m-d'));
		$c = $this->M_index->GetIzin(date('Y-m-d'));
		$d = array();
		$l = array();
		$makan = array();
		$data['izin'] = array();
		$output = array();
		$ot_makan = array();
		//untuk nyari pekerja
		foreach ($b as $key) {
			$a[$key['izin_id']][] = $key['pekerja'];
		}
		foreach ($a as $type => $label) {
			$output[] = array(
				'izin_id' => $type,
				'pekerja' => $label
			);
		}
		// untuk nyari makan
		foreach ($b as $key) {
			$makan[$key['izin_id']][] = $key['tujuan'];
		}
		foreach ($makan as $type => $label) {
			$ot_makan[] = array(
				'izin_id' => $type,
				'tujuan' => $label
			);
		}
		//menggabungkan data dengan makan
		foreach ($c as $key) {
			foreach ($ot_makan as $value) {
				if ($key['izin_id'] == $value['izin_id']) {
					$l[] = array_merge($key, $value);
				}
			}
		}
		//menggabungkan data dengan pekerja
		foreach ($l as $key) {
			foreach ($output as $value) {
				if ($key['izin_id'] == $value['izin_id']) {
					$data['izin'][] = array_merge($key, $value);
				}
			}
		}

		$data['atasan'] = $this->M_index->getAtasan();

		$today = date('Y-m-d');

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PerizinanDinas/ApproveAll/V_Index', $data);
		$this->load->view('PerizinanDinas/V_Footer', $data);
	}

	public function editPekerjaDinas()
	{
		$id = $this->input->post('id');

		$pekerja = $this->M_index->getPekerjaEdit($id);
		echo json_encode($pekerja);
	}

	public function updatePekerja()
	{
		$id = $this->input->post('id');
		$jenis = $this->input->post('jenis');
		$atasan = $this->input->post('atasan');
		$ket = $this->input->post('ket');
		$keluar = $this->input->post('keluar');
		$tgl = $this->input->post('tgl');
		$alasan = $this->input->post('alasan');
		$getAtasan = $this->M_index->getAtasanEdit($id);
		$data = $this->M_index->getTujuanMakan($id);
		$noind = array();
		foreach ($data as $key) {
			$implode1[] = $key['noind'];
		}

		if ($atasan != $getAtasan) {
			//update atasan
			$this->M_index->updateAtasan($atasan, $id);
			// disini bakalan send mail ke atasan yang baru
			$this->EmailAlert($atasan, $id, $implode1, $tgl, $ket, $keluar);
			//Kirim email ke atasan sebelumnya
			$this->EmailAlertPrevious($atasan, $id, $implode1, $tgl, $ket, $keluar, $alasan, $getAtasan);
			//inserto to tlog sys
			$aksi = 'ROTATE PERIZINAN DINAS';
			$detail = 'Rotasi Atasan izin_id= ' . $id . ' dari =' . $getAtasan . ' kepada= ' . $atasan;
			$this->log_activity->activity_log($aksi, $detail);
			//
		} else {
			echo 'sama';
		}
	}


	public function EmailAlert($atasan, $idizin, $noind, $tanggal, $keterangan, $berangkat)
	{
		//email
		$newArr = array();
		if ($noind > 1) {
			$get = implode("','", $noind);
			$getnama = $this->M_index->pekerja($get, true);
		} else {
			$getnama = $this->M_index->pekerja($noind, false);
		}
		for ($i = 0; $i < count($getnama); $i++) {
			$newArr[] = $getnama[$i]['noind'] . ' - ' . $getnama[$i]['nama'];
		};

		$namapekerja = implode(", ", $newArr);
		$daftarNama = str_replace(', ', '<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;', $namapekerja);

		$noindatasan = $this->M_index->pekerja($atasan, false);
		$noindatasan = $noindatasan[0]['nama'];
		$getEmail = $this->M_index->getEmail($atasan);
		$emailUser = $getEmail[0]['internal_mail'];

		$subject = "New!!! Approval Izin Dinas Perusahaan";
		$body = "Hi $noindatasan,
					<br>Izin Dinas dengan id : $idizin telah dibuat dan membutuhkan approval Anda, detail sebagai berikut :
					<br>
					<br><b>Tanggal &emsp;&emsp;:</b> " . date('d F Y', strtotime($tanggal)) . "
					<br>
					<br><b>Pekerja &emsp;&emsp;:</b> $daftarNama
					<br>
					<br><b>Keperluan &nbsp;&nbsp;:</b> $keterangan
					<br>
					<br><b>Jam Berangkat &nbsp;:</b> $berangkat WIB
					<br><br>
					<hr>
					<br>untuk melihat/ merespon izin ini, silahkan <a href='http://erp.quick.com/PerizinanDinas/AtasanApproval'>login</a> ke ERP";

		//send Email
		$this->load->library('PHPMailerAutoload');
		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';

		// set smtp
		$mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;

		// set email content
		$mail->setFrom('no-reply@quick.com', 'Email Sistem');
		$mail->addAddress($emailUser);
		$mail->Subject = $subject;
		$mail->msgHTML($body);

		// check error
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		}
	}

	public function EmailAlertPrevious($atasan, $idizin, $noind, $tanggal, $keterangan, $berangkat, $alasan, $getAtasanlama)
	{
		//email
		$newArr = array();
		if ($noind > 1) {
			$get = implode("', '", $noind);
			$getnama = $this->M_index->pekerja($get, true);
		} else {
			$getnama = $this->M_index->pekerja($noind, false);
		}
		for ($i = 0; $i < count($getnama); $i++) {
			$newArr[] = $getnama[$i]['noind'] . ' - ' . $getnama[$i]['nama'];
		};

		$namapekerja = implode(", ", $newArr);
		$daftarNama = str_replace(', ', '<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;', $namapekerja);

		$noindatasanlama = $this->M_index->pekerja($getAtasanlama, false);
		$noindatasanlama = $noindatasanlama[0]['nama'];
		$getEmail = $this->M_index->getEmail($getAtasanlama);
		$emailUser = $getEmail[0]['internal_mail'];

		$noindatasan = $this->M_index->pekerja($atasan, false);
		$noindatasan = $noindatasan[0]['nama'];

		$subject = "New!!! Rotate Approval Izin Dinas Perusahaan";
		$body = "Hi $noindatasanlama,
					<br>Izin Dinas dengan id : $idizin dengan detail sebagai berikut :
					<br>
					<br><b>Tanggal &emsp;&emsp;:</b> " . date('d F Y', strtotime($tanggal)) . "
					<br>
					<br><b>Pekerja &emsp;&emsp;:</b> $daftarNama
					<br>
					<br><b>Keperluan &nbsp;&nbsp;:</b> $keterangan
					<br>
					<br><b>Jam Berangkat &nbsp;:</b> $berangkat WIB
					<br>
					<br>Approver Perizinan Dinas telah dialihkan kepada <b>$atasan - $noindatasan</b> dengan alasan <b>$alasan</b>";

		//send Email
		$this->load->library('PHPMailerAutoload');
		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';

		// set smtp
		$mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;

		// set email content
		$mail->setFrom('no-reply@quick.com', 'Email Sistem');
		$mail->addAddress($emailUser);
		$mail->Subject = $subject;
		$mail->msgHTML($body);

		// check error
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		}
	}
}
