<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');


class C_Index extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');
			$this->load->helper('file');

			$this->load->library('Log_Activity');
			$this->load->library('form_validation');
			$this->load->library('pdf');
			$this->load->library('session');
			$this->load->library('encrypt');
			$this->load->library('email');
			$this->load->model('M_Index');
			$this->load->model('AbsenAtasan/M_absenatasan');
			$this->load->model('SystemIntegration/M_submit');
			$this->load->model('SystemAdministration/MainMenu/M_user');
		}

		public function checkSession()
		{
			if($this->session->is_logged){
			} else {
				redirect('index');
			}
		}

		function index(){
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenAtasan/V_Index',$data);
		$this->load->view('V_Footer',$data);
		}

		public function listData(){
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$employee = $this->session->employee;
		$nama = trim($employee);
		// print_r($approver);exit();
		$data['listData'] = $this->M_absenatasan->getList($nama);

		// $data['jenisAbsen'] = $this->M_absenatasan->getJenisAbsen();

		// echo "<pre>";
		// print_r($data['listData']);exit();

		// $data['listData'] = $this->M_absenatasan->getList();

		// $info = array();
		// foreach ($listData as $key => $data) {
		// $noinduk = $data['noind'];
		// $employeeInfo = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// $section_code = $employeeInfo['section_code'];
		// $unitInfo = $this->M_absenatasan->getFieldUnitInfo($section_code);
		// array_push($employeeInfo, $unitInfo);
		// array_push($info, $employeeInfo);
		// }

		// $noinduk = $data['listData'][0]['noind'];

		// echo "<pre>";
		// print_r($noinduk);exit();

		// $data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// echo "<pre>";
		// print_r($data['employeeInfo']);exit();

		// $section_code = $data['employeeInfo'][0]['section_code'];
		// $data['bidangUnit'] = $this->M_absenatasan->getFieldUnitInfo($section_code);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenAtasan/V_List',$data);
		$this->load->view('V_Footer',$data);
		}

		public function getAtasan(){
			$noinduk = $this->input->post('noinduk');
			$getKodeJabatan = $this->M_submit->getKodeJabatan($noinduk);

			if($noinduk != null){
					if (($getKodeJabatan >= 13) && ($getKodeJabatan != 19) && ($getKodeJabatan != 16)) {
					$atasan1 = $this->M_absenatasan->getAtasanApprover($noinduk, 1,$getKodeJabatan);
					$atasan2 = $this->M_absenatasan->getAtasanApprover($noinduk, 2,$getKodeJabatan);
					$data['atasan1'] = $atasan1;
					$data['atasan2'] = $atasan2;
				}else{
					$atasan2 = $this->M_absenatasan->getAtasanApprover($noinduk, 2,$getKodeJabatan);
					$data['atasan2'] = $atasan2;
				}


				$data['status'] = true;
				$data['result']	= "Berhasil";
			}
			else{
				$data['status'] = false;
				$data['result']	= "Gagal";
			}
				print_r(json_encode($data));

		}

		public function detail($id){
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dataEmployee'] = $this->M_absenatasan->getListAbsenById($id);

		$noinduk = $data['dataEmployee'][0]['noind'];

		$data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// echo "<pre>";print_r($data['dataEmployee']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AbsenAtasan/V_Approval',$data);
		$this->load->view('V_Footer',$data);
		}


		public function approveApproval($id){
			$status = 1;
			date_default_timezone_set('Asia/Jakarta');
			$tgl_approval = date('Y-m-d H:i:s');

			// echo $tgl_approval;exit();
			$data1 =
			['status' => $status,
			 'tgl_approval' => $tgl_approval
			];

			$this->M_absenatasan->approveAbsenApproval($id,$data1);

			$data2 =
			['status' => $status,
			 'tgl_status' => $tgl_approval
			];

			$this->M_absenatasan->approveAbsen($id,$data2);

			$employee = $this->M_absenatasan->getListAbsenById($id);
			// echo "<pre>";
			// print_r($employee);exit();
			$noinduk 	 	= $employee[0]['noind'];
			$namaPekerja 	= $employee[0]['nama'].' ('.$employee[0]['noind'].')';
			$jenisAbsen  	= $employee[0]['jenis_absen'];
			$waktu		 	= $employee[0]['waktu'];
			$lokasi		 	= $employee[0]['lokasi'];
			$latitude	 	= $employee[0]['latitude'];
			$longitude	 	= $employee[0]['longitude'];
			$status 	    = "DiApprove";
			$atasan 	 	= trim($this->session->employee).' ('.trim($this->session->user).')';
			// print_r($atasan);exit();
			$noindukAtasan	= $this->session->user;
			// $dataAtasan	 = $this->M_absenatasan->getAtasan($id);
			// $atasan 	 = $dataAtasan[0]['approver'];
			// print_r($atasan);exit();
			$employeeEmailData['email'] = $this->M_absenatasan->getEmployeeEmail($noinduk);
			// echo $employeeEmail['internal_mail'];exit();
			// echo "<pre>";print_r($employeeEmailData);exit();
			$internalMail = $employeeEmailData['email'][0]['internal_mail'];
			$eksternalMail	= $employeeEmailData['email'][0]['external_mail'];
			// print_r($internalMail);exit();

			$dataPersonalia = $this->M_absenatasan->getEmailPersonalia();
			// echo "<pre>";print_r($dataPersonalia);exit();

			$this->kirim_email($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan,$noindukAtasan);

			foreach ($dataPersonalia as $key => $personalia) {
				$internalMailPersonalia = $personalia['internal_mail'];
				$externalMailPersonalia	= $personalia['external_mail'];
				$namaPekerjaPersonalia	= $personalia['employee_name'];

			$this->kirim_emailPersonalia($namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan,$noindukAtasan,$internalMailPersonalia,$externalMailPersonalia,$namaPekerjaPersonalia);
			}

			$this->session->set_flashdata('msg','sukses');
			//insert to t_log
				$aksi = 'ABSEN ATASAN';
				$detail = 'APPROVE ID='.$id;
				$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('AbsenAtasan/List');
		}


		public function rejectApproval($id){
			$status = 2;
			date_default_timezone_set('Asia/Jakarta');
			$tgl_approval = date('Y-m-d H:i:s');

			// echo $this->input->post('reason');exit();
			$data1 =
			['status' => $status,
			'tgl_approval' => $tgl_approval,
			'reason' => $this->input->post('reason')
			];

			$this->M_absenatasan->rejectAbsenApproval($id,$data1);

			$data2=
			['status' => $status,
			 'tgl_status' => $tgl_approval
			];
			$this->M_absenatasan->rejectAbsen($id,$data2);

			$employee = $this->M_absenatasan->getListAbsenById($id);
			$noinduk 	 	= $employee[0]['noind'];
			$namaPekerja 	= $employee[0]['nama'].' ('.$employee[0]['noind'].')';
			$jenisAbsen  	= $employee[0]['jenis_absen'];
			$waktu		 	= $employee[0]['waktu'];
			$lokasi		 	= $employee[0]['lokasi'];
			$latitude	 	= $employee[0]['latitude'];
			$longitude	 	= $employee[0]['longitude'];
			$status 	 	= "DiTolak";
			$atasan 	 	= trim($this->session->employee).' ('.trim($this->session->user).')';
			$noindukAtasan	= $this->session->user;

			// $dataAtasan	 = $this->M_absenatasan->getAtasan($id);
			// $atasan 	 = $dataAtasan[0]['approver'];


			$employeeEmailData['email'] = $this->M_absenatasan->getEmployeeEmail($noinduk);
			// echo $employeeEmail['internal_mail'];exit();
			$internalMail = $employeeEmailData['email'][0]['internal_mail'];
			$eksternalMail	= $employeeEmailData['email'][0]['external_mail'];
			// print_r($internalMail);exit();


			$this->kirim_email($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan,$noindukAtasan);
			//insert to t_log
				$aksi = 'ABSEN ATASAN';
				$detail = 'REJECT ID='.$id;
				$this->log_activity->activity_log($aksi, $detail);
			//
			redirect('AbsenAtasan/List');
		}

		function cetakApproval($id){
			$mpdf = $this->pdf->load();
			$data['dataEmployee'] = $this->M_absenatasan->getListAbsenById($id);
			$noinduk = $data['dataEmployee'][0]['noind'];

			$data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
			//insert to t_log
			$aksi = 'ABSEN ATASAN';
			$detail = 'CETAK ID='.$id;
			$this->log_activity->activity_log($aksi, $detail);
			//

			$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$view 	= $this->load->view('AbsenAtasan/V_CetakPDFAbsen',$data,true);
			$mpdf 	= new mPDF('','A4',0,'',10,10,10,10);
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($view,2);
			$mpdf->showImageErrors = true;
			$mpdf->Output('DetailAbsen.pdf','I');
			$mpdf->set_time_limit(0);
		}

		function kirim_email($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan,$noindukAtasan){
			date_default_timezone_set("Asia/Jakarta");

			if(!empty($internalMail) and $internalMail != null and trim($internalMail) != '' and trim($internalMail) != '-'){
				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = 'm.quick.com';
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
				));
				$mail->Username = 'no-reply@quick.com';
				$mail->Password = "123456";
				$mail->setFrom('noreply@quick.co.id', 'Notifikasi Absensi Online');
				$mail->addAddress($internalMail, 'Absensi Online Pekerja');
				$mail->Subject = 'Status Absensi Online Anda';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$namaPekerja<br><br>

				Kami informasikan bahwa request approval Absen Online Anda, detail sbb :<br><br>
				Jenis Absen : $jenisAbsen<br>
				Waktu : $waktu<br>
				Lokasi : $lokasi , koordinat : ( $latitude , $longitude )
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br><br>

				Status : Telah $status oleh $atasan<br><br>

				Anda dapat melakukan pengecekan melalui :<br>
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				Apabila anda mengalami kendala dapat menghubungi Seksi Hubker (15109 / 15106) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error Internal: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}

		}

		if(!empty($eksternalMail) and $eksternalMail != null and trim($eksternalMail) != '' and trim($eksternalMail) != '-'){
				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'tls';
				$mail->Username = 'notification.hrd.khs1@gmail.com';
				$mail->Password = "tes123123123";
				$mail->setFrom('noreply@quick.co.id', 'Email Sistem');
				$mail->IsHTML(true);
				$mail->AltBody = 'This is a plain-text message body';
				$mail->addAddress($eksternalMail, $namaPekerja);
				$mail->Subject = 'Status Absensi Online Anda';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$namaPekerja<br><br>

				Kami informasikan bahwa request approval Absen Online Anda, detail sbb :<br><br>
				Jenis Absen : $jenisAbsen<br>
				Waktu : $waktu<br>
				Lokasi : $lokasi , koordinat : ( $latitude , $longitude )
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br><br>

				Status : Telah $status oleh $atasan<br><br>

				Anda dapat melakukan pengecekan melalui :<br>
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				Apabila anda mengalami kendala dapat menghubungi Seksi Hubker (15109 / 15106) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error Eksternal: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}

		}
	}

			function kirim_emailPersonalia($namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan,$noindukAtasan,$internalMailPersonalia,$externalMailPersonalia,$namaPekerjaPersonalia){
			date_default_timezone_set("Asia/Jakarta");

			if(!empty($internalMailPersonalia) and $internalMailPersonalia != null and trim($internalMailPersonalia) != '' and trim($internalMailPersonalia) != '-'){
				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = 'm.quick.com';
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
				));
				$mail->Username = 'no-reply@quick.com';
				$mail->Password = "123456";
				$mail->setFrom('noreply@quick.co.id', 'Notifikasi Absensi Online');
				$mail->addAddress($internalMailPersonalia, 'Absensi Online Pekerja');
				$mail->Subject = 'Absensi Online';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$namaPekerjaPersonalia<br><br>

				Kami informasikan bahwa terdapat pekerja yang melakukan absensi online dengan detail sbb :<br><br>
				Pekerja 		: $namaPekerja<br>
				Jenis Absen 	: $jenisAbsen<br>
				Waktu 			: $waktu<br>
				Lokasi 			: $lokasi , koordinat : ( $latitude , $longitude )
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br><br>

				Status : Telah $status oleh $atasan<br><br>

				Anda dapat melakukan pengecekan melalui :<br>
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				Apabila anda mengalami kendala dapat menghubungi Seksi Hubker (15109 / 15106) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error Internal: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}

				}

			if(!empty($externalMailPersonalia) and $externalMailPersonalia != null and trim($externalMailPersonalia) != '' and trim($externalMailPersonalia) != '-'){
				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'tls';
				$mail->Username = 'notification.hrd.khs1@gmail.com';
				$mail->Password = "tes123123123";
				$mail->setFrom('noreply@quick.co.id', 'Email Sistem');
				$mail->IsHTML(true);
				$mail->AltBody = 'This is a plain-text message body';
				$mail->addAddress($externalMailPersonalia, $namaPekerjaPersonalia);
				$mail->Subject = 'Absensi Online';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$namaPekerjaPersonalia<br><br>

				Kami informasikan bahwa terdapat pekerja yang melakukan absensi online dengan detail sbb :<br><br>
				Pekerja 		: $namaPekerja<br>
				Jenis Absen 	: $jenisAbsen<br>
				Waktu 			: $waktu<br>
				Lokasi 			: $lokasi , koordinat : ( $latitude , $longitude )
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br><br>

				Status : Telah $status oleh $atasan<br><br>

				Anda dapat melakukan pengecekan melalui :<br>
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				Apabila anda mengalami kendala dapat menghubungi Seksi Hubker (15109 / 15106) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error Eksternal: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}

				}
			}

			public function kirimEmailAtasanAndroid(){
				$namaPekerja 		= $this->input->post('namaPekerja');
				$atasan 			= ltrim($this->input->post('atasan')," ");
				$noindukPekerja		= $this->input->post('noindukPekerja');
				$jenisAbsen 		= $this->input->post('jenisAbsen');
				$waktu 				= $this->input->post('waktu');
				$lokasi 			= $this->input->post('lokasi');
				$latitude			= $this->input->post('latitude');
				$longitude			= $this->input->post('longitude');
				$noindukAtasan 		= explode(" - ", $atasan)[0];
				$namaAtasan 		= explode(" - ", $atasan)[1];
				$dataAtasan 		= $this->M_absenatasan->getEmployeeEmailByNama($noindukAtasan,$namaAtasan);
				$internalMailAtasan = $dataAtasan[0]['internal_mail'];
				$externalMailAtasan = $dataAtasan[0]['external_mail'];

				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = 'm.quick.com';
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
				));
				$mail->Username = 'no-reply@quick.com';
				$mail->Password = "123456";
				$mail->setFrom('noreply@quick.co.id', 'Notifikasi Absensi Online');
				$mail->addAddress($internalMailAtasan, 'Absensi Online Pekerja');
				$mail->Subject = 'Absensi Online';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$atasan<br><br>

				Kami informasikan bahwa $noindukPekerja - $namaPekerja telah melakukan request approval Absen Online, dengan detail sbb :<br><br>
				Jenis Absen : $jenisAbsen<br>
				Waktu : $waktu<br>
				Lokasi : $lokasi , koordinat : ( $latitude , $longitude )
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br><br>

				Anda dapat melakukan pengecekan melalui :<br>
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				pabila anda mengalami kendala dapat menghubungi Seksi Hubker (15109 / 15106) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error Internal: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}


				$this->load->library('PHPMailerAutoload');
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'tls';
				$mail->Username = 'notification.hrd.khs1@gmail.com';
				$mail->Password = "tes123123123";
				$mail->setFrom('noreply@quick.co.id', 'Email Sistem');
				$mail->IsHTML(true);
				$mail->AltBody = 'This is a plain-text message body';
				$mail->addAddress($externalMailAtasan, $atasan);
				$mail->Subject = 'Absensi Online';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$atasan<br><br>

				Kami informasikan bahwa $noindukPekerja - $namaPekerja telah melakukan request approval Absen Online, dengan detail sbb :<br><br>
				Jenis Absen : $jenisAbsen<br>
				Waktu : $waktu<br>
				Lokasi : $lokasi , koordinat : ( $latitude , $longitude )
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br><br>

				Anda dapat melakukan pengecekan melalui :<br>
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				pabila anda mengalami kendala dapat menghubungi Seksi Hubker (15109 / 15106) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error Eksternal: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}

			}

			public function TransferPresensiOnline(){
				$this->load->library('PHPMailerAutoload');
				$waktuAwal = date('Y-m-d H:i:s');
				date_default_timezone_set('Asia/Jakarta');

				$abson = $this->M_absenatasan->getAbsenCRONJ();
				$ins = array();
				$no = 0;
				$isiEmail = "";
				$table = "";
				$row = "";
				$exeMail = 0;
				$norow = 1;

				foreach ($abson as $key => $value) {
					$no++;
					$ins['noind'] = $value['noind'];
					$ins['noind_baru'] = $value['noind_baru'];
					$ins['kodesie'] = $value['kodesie'];
					$ins['tanggal'] = $value['tgl'];
					$ins['waktu'] = $value['wkt'];

					$cekRill = $this->M_absenatasan->cekPresensiRill($ins);
					// $this->M_absenatasan->deleteTrial('"FrontPresensi"', 'tpresensi');
 					// $this->M_absenatasan->deleteTrial('"Presensi"', 'tprs_shift');
					// $this->M_absenatasan->deleteTrial('"Presensi"', 'tpresensi_riil');

					if ($cekRill == 0) {
						if (substr($value['noind'], 0,1) == 'L') {
							$cek = $this->M_absenatasan->cekPresensiL($ins);
						}else{
							$cek = $this->M_absenatasan->cekPresensi($ins);
						}

						if ($cek == 0) {
							$exeMail++;
							if (substr($value['noind'], 0,1) == 'L') {
					 					$ins['user_']		=	'ABSON';
					 					$this->M_absenatasan->insert_presensi('"Presensi"', 'tprs_shift2', $ins);
							}else{
										$ins['user_']		=	'ABSON';
					 					$this->M_absenatasan->insert_presensi('"FrontPresensi"', 'tpresensi', $ins);
					 					$this->M_absenatasan->insert_presensi('"Presensi"', 'tprs_shift', $ins);
										$this->M_absenatasan->insert_presensi('"Presensi"', 'tpresensi_riil', $ins);
										unset($ins['nomor_sn']);

							}

							echo '<b style="color: green;">'.$value['noind'].' - '.$value['nama'].' - '.$value['jenis_absen'].$value['tgl'].' '.$value['wkt'].' - '.$value['lokasi']."<br>(".$value['longitude'].",".$value['latitude'].")".' - '.$value['approver']." ( ".$value['tgl_approval'].') - '.'</b><br><br>';

							$row .= "<tr>";
							$row .= "<td style='border: 1px solid black;width: 5%'>".$norow++."</td>";
							$row .= "<td style='border: 1px solid black;'>".$value['noind']."</td>";
							$row .= "<td style='border: 1px solid black;'>".$value['nama']."</td>";
							$row .= "<td style='border: 1px solid black;'>".$value['jenis_absen']."</td>";
							$row .= "<td style='border: 1px solid black;'>".$value['tgl']." ".$value['wkt']."</td>";
							$row .= "<td style='border: 1px solid black;'>".$value['lokasi']."<br>(".$value['longitude'].",".$value['latitude'].")"."</td>";
							$row .= "<td style='border: 1px solid black;'>".$value['approver']." ( ".$value['tgl_approval']." )</td>";
							$row .= "</tr>";
						}
					}
				}
				echo 'Jumlah Data : '.$no.'<br>';

				if($exeMail > 0 ){
					echo "Send Mail <br>";
					$mail = new PHPMailer;
					$mail->isSMTP();
					$mail->SMTPDebug = 0;
					$mail->Debugoutput = 'html';
					$mail->Host = 'm.quick.com';
					$mail->Port = 465;
					$mail->SMTPAuth = true;
					$mail->SMTPSecure = 'ssl';
					$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					));
					$mail->Username = 'no-reply@quick.com';
					$mail->Password = "123456";
					$mail->setFrom('noreply@quick.co.id', 'Cronjob Transfer Presensi Online');
					$mail->addAddress('kasie_ict_hrd@quick.com', 'Kasie ICT HRD');
					$mail->addAddress('edp@quick.com', 'Seksi EDP');
					$mail->addAddress('hbk@quick.com', 'Seksi Hubker');
					$mail->Subject = 'Transfer Presensi Online';
					$mail->msgHTML("
					<h4>Absensi Online</h4><hr>

					Kami informasikan bahwa cronjob Transfer Presensi Online telah berjalan dengan detail sbb :
						<br>
						<br>		
						<table style='border-collapse: collapse'>
						<thead>
						<tr>
						<th style='border: 1px solid black;'>No</th>
						<th style='border: 1px solid black;'>Nomor Induk</th>
						<th style='border: 1px solid black;'>Nama</th>
						<th style='border: 1px solid black;'>Jenis Absen</th>
						<th style='border: 1px solid black;'>Waktu Absen</th>
						<th style='border: 1px solid black;'>Lokasi</th>
						<th style='border: 1px solid black;'>Approver</th>
						</tr>
						<tbody>
						$row
						</tbody>
						</thead>
						</table><br><br>


					Anda dapat melakukan pengecekan melalui :<br> 
					1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
					2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

					<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
					pabila anda mengalami kendala dapat menghubungi Seksi Hubker (15109 / 15106) atau ICT Support Center (08112545922) </small>

						");
					if (!$mail->send()) {
						echo "Mailer Error: " . $mail->ErrorInfo;
					} else {
						//echo "Message sent!";
					}
				}
				


			}		
	}

?>