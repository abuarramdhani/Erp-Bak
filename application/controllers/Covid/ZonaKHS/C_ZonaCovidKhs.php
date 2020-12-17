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
		$user_id= $this->session->userid;
		$user 	= $this->session->user;

		$data['Title']			=	'Zonasi Covid KHS';
		$data['Header']			=	'Zonasi Covid KHS';
		$data['Menu'] 			= 	'Zonasi Covid KHS';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
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
		$user_id= $this->session->userid;
		$user 	= $this->session->user;

		$data['Title']			=	'Zonasi Covid KHS';
		$data['Header']			=	'Zonasi Covid KHS';
		$data['Menu'] 			= 	'Zonasi Covid KHS';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lokasi'] = $this->M_zonacovidkhs->getLokasiKerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/ZonaKHS/V_Add',$data);
		$this->load->view('V_Footer',$data);
	}

	function Insert(){
		$user 		= $this->session->user;
		$seksi 		= $this->input->post('seksi');
		$lokasi 	= $this->input->post('lokasi');
		$isolasi 	= $this->input->post('isolasi');
		$koordinat 	= $this->input->post('koordinat');

		$data = array(
			'nama_seksi' 	=> $seksi,
			'lokasi' 		=> $lokasi,
			'koordinat' 	=> $koordinat,
			'created_by' 	=> $this->session->user
		);
		$id = $this->M_zonacovidkhs->insertZonaKhs($data);

		if (isset($_POST['kasus'])) {
			$kasus = $this->input->post('kasus');
			if (!empty($kasus)) {
				foreach ($kasus as $k) {
					$detail = array(
						'id_zona' 			=> $id,
						'tgl_awal_isolasi' 	=> $k['tgl_awal'],
						'tgl_akhir_isolasi' => $k['tgl_akhir'],
						'kasus' 			=> $k['kasus'],
						'created_by' 		=> $this->session->user
					);
					$this->M_zonacovidkhs->insertZonaKhsDetail($detail);
				}
			}
		}
		$this->M_zonacovidkhs->insertZonaKhsHistory($id,$user,"AFTER INSERT");
		echo "sukses";
	}

	public function Edit($idEncoded){
		$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona = $this->encrypt->decode($id_zona);

		$data['idEncoded'] 	= $idEncoded;
		$data['zona'] 		= $this->M_zonacovidkhs->getZonaKhsByIdZona($id_zona);
		$data['kasus'] 		= $this->M_zonacovidkhs->getKasusByIdZona($id_zona);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Zonasi Covid KHS';
		$data['Header']			=	'Zonasi Covid KHS';
		$data['Menu'] 			= 	'Zonasi Covid KHS';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lokasi'] = $this->M_zonacovidkhs->getLokasiKerja();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/ZonaKHS/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	function Update($idEncoded){
		$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona = $this->encrypt->decode($id_zona);

		$seksi 		= $this->input->post('seksi');
		$lokasi 	= $this->input->post('lokasi');
		$koordinat 	= $this->input->post('koordinat');
		$user 		= $this->session->user;

		$this->M_zonacovidkhs->insertZonaKhsHistory($id_zona,$user,"BEFORE UPDATE");

		$data = array(
			'nama_seksi' 			=> $seksi,
			'lokasi' 				=> $lokasi,
			'koordinat' 			=> $koordinat,
			'last_tgl_akhir_isolasi'=> null,
			'created_by' 			=> $this->session->user,
			'created_timestamp' 	=> date('Y-m-d H:i:s')
		);
		$this->M_zonacovidkhs->updateZonaKhsByIdZona($data,$id_zona);

		$this->M_zonacovidkhs->deleteZonaKhsDetailByIdZona($id_zona);
		if (isset($_POST['kasus'])) {
			$kasus = $this->input->post('kasus');
			if (!empty($kasus)) {
				foreach ($kasus as $k) {
					$detail = array(
						'id_zona' 			=> $id_zona,
						'tgl_awal_isolasi' 	=> $k['tgl_awal'],
						'tgl_akhir_isolasi' => $k['tgl_akhir'],
						'kasus' 			=> $k['kasus'],
						'created_by' 		=> $this->session->user,
						'created_timestamp' => date('Y-m-d H:i:s')
					);
					$this->M_zonacovidkhs->insertZonaKhsDetail($detail);
				}
			}
		}
		
		$this->M_zonacovidkhs->insertZonaKhsHistory($id_zona,$user,"AFTER UPDATE");

		echo "sukses";
	}

	public function Delete($idEncoded){
		$user = $this->session->user;
		$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona = $this->encrypt->decode($id_zona);

		$this->M_zonacovidkhs->insertZonaKhsHistory($id_zona,$user,"BEFORE DELETE");

		$this->M_zonacovidkhs->deleteZonaKhsDetailByIdZona($id_zona);
		$this->M_zonacovidkhs->deleteZonaKhsByIdZona($id_zona);

		$data = $this->M_zonacovidkhs->getZonaKhsAll();
		foreach ($data as $key => $value) {
			$idEncoded = $this->encrypt->encode($value['id_zona']);
			$idEncoded = str_replace(array('+', '/', '='), array('-', '_', '~'), $idEncoded);
			$data[$key]['id_zona'] = $idEncoded;
		}
		echo json_encode($data);
	}

	function Email(){
		$user_id= $this->session->userid;
		$user 	= $this->session->user;

		$data['Title']			=	'Zonasi Covid KHS';
		$data['Header']			=	'Zonasi Covid KHS';
		$data['Menu'] 			= 	'Zonasi Covid KHS';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lokasi'] = $this->M_zonacovidkhs->getLokasiKerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/ZonaKHS/V_Email',$data);
		$this->load->view('V_Footer',$data);
	}

	function getAreaIsolasi(){
		$key = $this->input->get('term');
		$data = $this->M_zonacovidkhs->getAreaIsolasiByKey($key);
		foreach ($data as $key => $value) {
			$idEncoded = $this->encrypt->encode($value['id_zona']);
			$idEncoded = str_replace(array('+', '/', '='), array('-', '_', '~'), $idEncoded);
			$data[$key]['id_zona'] = $idEncoded;
		}
		echo json_encode($data);
	}

	function getKasus(){
		$idEncoded = $this->input->get('id_zona');
		$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona = $this->encrypt->decode($id_zona);
		$key = $this->input->get('term');

		$data = $this->M_zonacovidkhs->getKasusByKeyIdZona($key,$id_zona);
		foreach ($data as $key => $value) {
			$idEncoded = $this->encrypt->encode($value['id_zona_detail']);
			$idEncoded = str_replace(array('+', '/', '='), array('-', '_', '~'), $idEncoded);
			$data[$key]['id_zona_detail'] = $idEncoded;
		}
		echo json_encode($data);
	}

	function getPeriode($idEncoded){
		$id_zona_detail = str_replace(array('-', '_', '~'), array('+', '/', '='), $idEncoded);
		$id_zona_detail = $this->encrypt->decode($id_zona_detail);
		$data = $this->M_zonacovidkhs->getPeriodeByIdZonaDetail($id_zona_detail);
		echo json_encode($data);
	}

	function getMessageBody($data = false){
		if ($data === false) {
			$seksi = $this->input->post('area');
			$area = "";
			$isolasi = "";
			if (!empty($seksi)) {
				$tmp_seksi = array();
				$tmp_kasus = array();
				foreach ($seksi as $key => $value) {
					$tmp = array();
					$id_zona = str_replace(array('-', '_', '~'), array('+', '/', '='), $value['id_zona']);
					$id_zona = $this->encrypt->decode($id_zona);
					$id_zona_detail = str_replace(array('-', '_', '~'), array('+', '/', '='), $value['id_zona_detail']);
					$id_zona_detail = $this->encrypt->decode($id_zona_detail);
					$zona = $this->M_zonacovidkhs->getKasusZonaKhsByIdZonaIdZonaDetail($id_zona,$id_zona_detail);

					$nama_seksi = $zona->nama_seksi;
					$kasus = $zona->kasus;
					$tgl_awal = date("d/m/Y",strtotime($zona->tgl_awal_isolasi));
					$tgl_akhir = date("d/m/Y",strtotime($zona->tgl_akhir_isolasi));

					if (!in_array($nama_seksi, $tmp_seksi)) {
						$area .= "<ul style=\"list-style-type:circle\">
									<li>$nama_seksi</li>
								</ul>";
						$tmp_seksi[] = $nama_seksi;
						$tmp[] = array(
							'kasus' => $kasus,
							'tgl_awal' => $tgl_awal,
							'tgl_akhir' => $tgl_akhir
						);
						$tmp_kasus[] = array(
							'area' => $nama_seksi,
							'data' => $tmp
						);
					}else{
						foreach ($tmp_kasus as $key_tk => $value_tk) {
							if ($value_tk['area'] == $nama_seksi) {
								$tmp_kasus[$key_tk]['data'][] = array(
									'kasus' => $kasus,
									'tgl_awal' => $tgl_awal,
									'tgl_akhir' => $tgl_akhir
								);
							}
						}
					}
				}

				if (!empty($tmp_kasus)) {
					foreach ($tmp_kasus as $tk) {
						$isolasi .= "<ul style=\"list-style-type:circle\">
								<li>".$tk['area']." :";
						if (!empty($tk['data'])) {
							$isolasi .="<ul>";
							foreach ($tk['data'] as $dt) {
								$isolasi .= "<li>Tanggal ".$dt['tgl_awal']." s/d ".$dt['tgl_akhir'].". Kasus : ".$dt['kasus'];
								$isolasi .= "</li>";
							}
							$isolasi .="</ul>";
						}
						$isolasi .= "</li>
							</ul>";
						
					}
				}
			}
		}else{
			$nama_seksi = $data['nama_seksi'];
			$tgl_awal = date("d/m/Y",strtotime($data['tgl_awal_isolasi']));
			$tgl_akhir = date("d/m/Y",strtotime($data['tgl_akhir_isolasi']));
			$area = "<ul style=\"list-style-type:circle\">
						<li>$nama_seksi</li>
					</ul>";
			$isolasi = "<ul style=\"list-style-type:circle\">
						<li>$nama_seksi : $tgl_awal - $tgl_akhir</li>
					</ul>";
		}
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
		$text = "Selamat $waktu Bapak/Ibu,<br>
			Berkaitan dengan Update Zona Merah di Area CV KHS yaitu:
			<ul style=\"list-style-type:square\">
				<li>Pekerja yang isolasi di area sbb :
					$area
				</li>
				<li>Masa Isolasi Area tsb :
					$isolasi
				</li>
			</ul> 
			Maka,
			<ul style=\"list-style-type: lower-alpha;text-align: justify\">
				<li>Pekerja non isolasi dilarang untuk memasuki area isolasi tersebut.</li>
				<li>Pekerja isolasi dilarang untuk keluar dari Area Isolasi yang sudah ditentukan.</li>
				<li>Untuk Area Toilet dan Smoking Area, yang diberikan label untuk pekerja isolasi mohon untuk tidak masuk ke area tsb.</li>
				<li>Jika ada keperluan distribusi dokumen atau alat kerja dapat dilakukan dengan meletakan dokumen atau alat kerja tersebut di luar area isolasi dan untuk pekerja isolasi dan non isolasi diusahakan untuk tidak bertemu.</li>
				<li>Jika ada keperluan meeting atau berkomunikasi antara pekerja isolasi dengan pekerja non isolasi maka dapat dilakukan dengan menggunakan perangkat komunikasi voip, mygroup, atau teleconference.</li>
				<li>Pekerja isolasi wajib mengikuti protokoler sesuai KDU yang berlaku.</li>
			</ul>
			Dimohon Bapak / Ibu untuk menginformasikan pesan ini ke seluruh pekerja yang ada diseksi Bapak / Ibu atau dapat langsung mengakses laman Zona Covid KHS di <a href='http://erp.quick.com/assets/covid19/wilayah-khs/'>http://erp.quick.com/assets/covid19/wilayah-khs/</a><br>
			Jika ada pertanyaan, Bapak / Ibu dapat menghubungi kami di
			<a href=\"https://wa.me/6282136064473\">https://wa.me/6282136064473</a>
			Terima kasih.<br>
			<br>
			Salam sehat,<br>
			<br>
			Tim Pencegahan Penularan Covid19 KHS";
		if ($data === false) {
			$paket = array(
				'messageBody' => $text
			);
			echo json_encode($paket);
		}else{
			return $text;
		}
	}

	function sendEmail(){
		$emailBody = $this->input->post('email_body');
		$penerima = $this->input->post('penerima');
		if (!empty($emailBody) && !empty($penerima)) {
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
			foreach ($penerima as $rcv) {
				$mail->addAddress($rcv['alamat'], $rcv['nama']);
			}
			$mail->IsHTML(true);
			$mail->AltBody = 'This is a plain-text message body';

			$mail->Subject = 'Update Area Zona Merah di Perusahaan';
			$mail->msgHTML($emailBody);
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}else{
				echo "sukses";
			}
		}else{
			echo "Harus Preview Dulu dan Penerima minimal 1";
		}
	}
	
}

?>