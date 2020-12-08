<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_ZonaCovidKhs extends CI_Controller
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
		$this->load->model('Covid/ZonaKHS/M_zonacovidkhs');
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

		$data['Title']			=	'Zonasi Covid KHS';
		$data['Header']			=	'Zonasi Covid KHS';
		$data['Menu'] 			= 	'Zonasi Covid KHS';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['zona'] = $this->M_zonacovidkhs->getZonaKhsAll();
		$data['summary'] = $this->M_zonacovidkhs->getSummaryZonaKHS();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/ZonaKHS/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Add(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Zonasi Covid KHS';
		$data['Header']			=	'Zonasi Covid KHS';
		$data['Menu'] 			= 	'Zonasi Covid KHS';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lokasi'] = $this->M_zonacovidkhs->getLokasiKerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/ZonaKHS/V_Add',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Edit($idEncoded){
		$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona = $this->encrypt->decode($id_zona);

		$data['idEncoded'] = $idEncoded;
		$data['zona'] = $this->M_zonacovidkhs->getZonaKhsByIdZona($id_zona);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Zonasi Covid KHS';
		$data['Header']			=	'Zonasi Covid KHS';
		$data['Menu'] 			= 	'Zonasi Covid KHS';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lokasi'] = $this->M_zonacovidkhs->getLokasiKerja();
		// echo "<pre>";print_r($data);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/ZonaKHS/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	function Insert(){
		$user = $this->session->user;
		$seksi = $this->input->post('seksi');
		$lokasi = $this->input->post('lokasi');
		$isolasi = $this->input->post('isolasi');
		$koordinat = $this->input->post('koordinat');

		if ($isolasi == "1") {
			$tgl_awal = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');
			$kasus = $this->input->post('kasus');
			$email = $this->input->post('email');

			$data = array(
				'nama_seksi' => $seksi,
				'lokasi' => $lokasi,
				'isolasi' => $isolasi,
				'created_by' => $user,
				'tgl_awal_isolasi' => $tgl_awal,
				'tgl_akhir_isolasi' => $tgl_akhir,
				'kasus' => $kasus,
				'koordinat' => $koordinat,
				'last_tgl_akhir_isolasi' => null
			);

			$id = $this->M_zonacovidkhs->insertZonaKhs($data);
			$this->M_zonacovidkhs->insertZonaKhsHistory($id,$user);

			if ($email == "1") {
				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = "m.quick.com";
				$mail->Port = 25;
				$mail->SMTPAuth = true;
				$mail->SMTPAutoTLS = false;
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
				$mail->Username = "no-reply@quick.com";
				$mail->Password = "123456";
				$mail->setFrom('no-reply@quick.com', 'Email Sistem');
				$mail->addAddress('aji_kurniawan@quick.com', 'Aji');
				$mail->addAddress('rheza_egha@quick.com', 'Rheza');
				$mail->IsHTML(true);
				$mail->AltBody = 'This is a plain-text message body';

				$mail->Subject = 'Update Area Zona Merah di Perusahaan';
				$msgbody = $this->getMessageBody($data);
				$mail->msgHTML($msgbody);
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				}else{
					echo "sukses";
				}
			}else{
				echo "sukses";
			}
		}else{
			$data = array(
				'nama_seksi' => $seksi,
				'lokasi' => $lokasi,
				'isolasi' => $isolasi,
				'created_by' => $this->session->user,
				'koordinat' => $koordinat
			);

			$this->M_zonacovidkhs->insertZonaKhs($data);
			echo "sukses";
		}
	}

	function Update($idEncoded){
		$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona = $this->encrypt->decode($id_zona);

		$seksi = $this->input->post('seksi');
		$lokasi = $this->input->post('lokasi');
		$isolasi = $this->input->post('isolasi');
		$koordinat = $this->input->post('koordinat');
		$user = $this->session->user;

		if ($isolasi == "1") {
			$tgl_awal = $this->input->post('tgl_awal');
			$tgl_akhir = $this->input->post('tgl_akhir');
			$kasus = $this->input->post('kasus');
			$email = $this->input->post('email');

			$data = array(
				'nama_seksi' => $seksi,
				'lokasi' => $lokasi,
				'isolasi' => $isolasi,
				'tgl_awal_isolasi' => $tgl_awal,
				'tgl_akhir_isolasi' => $tgl_akhir,
				'kasus' => $kasus,
				'koordinat' => $koordinat,
				'last_tgl_akhir_isolasi' => null
			);

			$this->M_zonacovidkhs->updateZonaKhsByIdZona($data,$id_zona);
			$this->M_zonacovidkhs->insertZonaKhsHistory($id_zona,$user);

			if ($email == "1") {
				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = "m.quick.com";
				$mail->Port = 25;
				$mail->SMTPAuth = true;
				$mail->SMTPAutoTLS = false;
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
				$mail->Username = "no-reply@quick.com";
				$mail->Password = "123456";
				$mail->setFrom('no-reply@quick.com', 'Email Sistem');
				$mail->addAddress('aji_kurniawan@quick.com', 'Aji');
				$mail->addAddress('rheza_egha@quick.com', 'Rheza');
				$mail->IsHTML(true);
				$mail->AltBody = 'This is a plain-text message body';

				$mail->Subject = 'Update Area Zona Merah di Perusahaan';
				$msgbody = $this->getMessageBody($data);
				$mail->msgHTML($msgbody);
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				}else{
					echo "sukses";
				}
			}else{
				echo "sukses";
			}
		}else{
			$zona = $this->M_zonacovidkhs->getZonaKhsByIdZona($id_zona);
			if (!empty($zona) && $zona->isolasi == '1') {
				$last_tgl_akhir_isolasi = $zona->tgl_akhir_isolasi;
				$data = array(
					'nama_seksi' => $seksi,
					'lokasi' => $lokasi,
					'isolasi' => $isolasi,
					'tgl_awal_isolasi' => null,
					'tgl_akhir_isolasi' => null,
					'kasus' => null,
					'koordinat' => $koordinat,
					'last_tgl_akhir_isolasi' => $last_tgl_akhir_isolasi
				);
			}else{
				$data = array(
					'nama_seksi' => $seksi,
					'lokasi' => $lokasi,
					'isolasi' => $isolasi,
					'tgl_awal_isolasi' => null,
					'tgl_akhir_isolasi' => null,
					'kasus' => null,
					'koordinat' => $koordinat,
					'last_tgl_akhir_isolasi' => null
				);
			}

			$this->M_zonacovidkhs->updateZonaKhsByIdZona($data,$id_zona);
			$this->M_zonacovidkhs->insertZonaKhsHistory($id_zona,$user);
			echo "sukses";
		}
	}

	function getMessageBody($data){
		if (strtotime(date('H:i:s')) < strtotime("11:00:00")) {
			$waktu = "pagi";
		}elseif (strtotime(date('H:i:s')) > strtotime("14:00:00") && strtotime(date('H:i:s')) < strtotime("18:00:00")) {
			$waktu = "sore";
		}elseif (strtotime(date('H:i:s')) >= strtotime("18:00:00")) {
			$waktu = "malam";
		}elseif (strtotime(date('H:i:s')) >= strtotime("11:00:00") && strtotime(date('H:i:s')) <= strtotime("14:00:00")) {
			$waktu = "siang";
		}else{
			$waktu = "pagi";
		}
		$nama_seksi = $data['nama_seksi'];
		$tgl_awal = date("d/m/Y",strtotime($data['tgl_awal_isolasi']));
		$tgl_akhir = date("d/m/Y",strtotime($data['tgl_akhir_isolasi']));
		$text = "Selamat $waktu Bapak/Ibu,<br>
			Berkaitan dengan Update Zona Merah di Area CV KHS yaitu:
			<ul style=\"list-style-type:square\">
				<li>Pekerja yang isolasi di area sbb :
					<ul style=\"list-style-type:circle\">
						<li>$nama_seksi</li>
					</ul>
				</li>
				<li>Masa Isolasi Area tsb :
					<ul style=\"list-style-type:circle\">
						<li>$nama_seksi : $tgl_awal - $tgl_akhir</li>
					</ul>
				</li>
			</ul> 
			Maka,
			<ul style=\"list-style-type: lower-alpha;text-align: justify\">
				<li>Pekerja non isolasi dilarang untuk memasuki area isolasi tersebut.</li>
				<li>Pekerja isolasi dilarang untuk keluar dari Area Isolasi yang sudah ditentukan.</li>
				<li>Jika ada keperluan distribusi dokumen atau alat kerja dapat dilakukan dengan meletakan dokumen atau alat kerja tersebut di luar area isolasi dan untuk pekerja isolasi dan non isolasi diusahakan untuk tidak bertemu.</li>
				<li>Jika ada keperluan meeting atau berkomunikasi antara pekerja isolasi dengan pekerja non isolasi maka dapat dilakukan dengan menggunakan perangkat komunikasi voip, mygroup, atau teleconference.</li>
				<li>Pekerja isolasi wajib mengikuti protokoler sesuai KDU yang berlaku.</li>
			</ul>
			Dimohon Bapak / Ibu untuk menginformasikan pesan ini ke seluruh pekerja yang ada diseksi Bapak / Ibu.<br>
			Jika ada pertanyaan, Bapak / Ibu dapat menghubungi kami di
			<a href=\"https://wa.me/6282136064473\">https://wa.me/6282136064473</a>
			Terima kasih.<br>
			<br>
			Salam sehat,<br>
			<br>
			Tim Pencegahan Penularan Covid19 KHS";
		return $text;
	}

	public function Delete($idEncoded){
		$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona = $this->encrypt->decode($id_zona);

		$this->M_zonacovidkhs->deleteZonaKhsByIdZona($id_zona);

		$data = $this->M_zonacovidkhs->getZonaKhsAll();
		foreach ($data as $key => $value) {
			$idEncoded = $this->encrypt->encode($value['id_zona']);
			$idEncoded = str_replace(array('+', '/', '='), array('-', '_', '~'), $idEncoded);
			$data[$key]['id_zona'] = $idEncoded;
		}
		echo json_encode($data);
	}
}

?>