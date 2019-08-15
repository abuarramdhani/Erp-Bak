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

			$this->load->library('form_validation');
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

			// $atasan2 = $this->M_submit->getAtasan('F2335',2);
			// print_r(json_encode($atasan2));	exit();

			$noinduk = $this->input->post('noinduk');
			$getKodeJabatan = $this->M_submit->getKodeJabatan($noinduk);

			if($noinduk != null){
					if (($getKodeJabatan >= 13) && ($getKodeJabatan != 19) && ($getKodeJabatan != 16)) {
					$atasan1 = $this->M_submit->getAtasan($noinduk, 1);
					$atasan2 = $this->M_submit->getAtasan($noinduk, 2);
					$data['atasan1'] = $atasan1;
					$data['atasan2'] = $atasan2;
				}else{
					$atasan2 = $this->M_submit->getAtasan($noinduk, 2);
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

		// echo "<pre>";
		// print_r($data['dataEmployee']);exit();

		$noinduk = $data['dataEmployee'][0]['noind'];

		// echo "<pre>";	
		// print_r($noinduk);exit();

		$data['employeeInfo'] = $this->M_absenatasan->getEmployeeInfo($noinduk);
		// echo "<pre>";
		// print_r($data['employeeInfo']);exit();

		$section_code = $data['employeeInfo'][0]['section_code'];
		$data['bidangUnit'] = $this->M_absenatasan->getFieldUnitInfo($section_code);

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
			$noinduk 	 = $employee[0]['noind'];
			$namaPekerja = $employee[0]['nama'];
			$jenisAbsen  = $employee[0]['jenis_absen'];
			$waktu		 = $employee[0]['waktu'];
			$lokasi		 = $employee[0]['lokasi'];
			$latitude	 = $employee[0]['latitude'];
			$longitude	 = $employee[0]['longitude'];
			$status 	 = "DiApprove";
			$dataAtasan	 = $this->M_absenatasan->getAtasan($id);
			$atasan 	 = $dataAtasan[0]['approver'];
			// print_r($atasan);exit();


			$employeeEmailData['email'] = $this->M_absenatasan->getEmployeeEmail($noinduk);
			// echo $employeeEmail['internal_mail'];exit();
			$internalMail = $employeeEmailData['email'][0]['internal_mail'];
			$eksternalMail	= $employeeEmailData['email'][0]['external_mail'];
			// print_r($internalMail);exit();


			$this->kirim_email($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan);
			$this->kirim_emailPersonalia($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan);

			$this->session->set_flashdata('msg','sukses');
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
			$noinduk 	 = $employee[0]['noind'];
			$namaPekerja = $employee[0]['nama'];
			$jenisAbsen  = $employee[0]['jenis_absen'];
			$waktu		 = $employee[0]['waktu'];
			$lokasi		 = $employee[0]['lokasi'];
			$latitude	 = $employee[0]['latitude'];
			$longitude	 = $employee[0]['longitude'];
			$status 	 = "DiTolak";
			$atasan 	 = $this->M_absenatasan->getAtasan($id);

			
			$employeeEmailData['email'] = $this->M_absenatasan->getEmployeeEmail($noinduk);
			// echo $employeeEmail['internal_mail'];exit();
			$internalMail = $employeeEmailData['email'][0]['internal_mail'];
			$eksternalMail	= $employeeEmailData['email'][0]['external_mail'];
			// print_r($internalMail);exit();


			$this->kirim_email($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan);

			redirect('AbsenAtasan/List');
		}

		function kirim_email($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan){
			date_default_timezone_set("Asia/Jakarta");

			if(!$internalMail==null){
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
				if(!$eksternalMail==null){
					$mail->addAddress($eksternalMail, 'Absensi Online Pekerja');
				}
				$mail->Subject = 'Status Absensi Online Anda';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$namaPekerja<br><br>
				
				Kami informasikan bahwa request approval Absen Online Anda, detail sbb :<br>
				Jenis Absen : $jenisAbsen<br>
				Waktu : $waktu<br>
				lokasi : $lokasi , koordinat : ( $latitude , $longitude ) 
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br>
				atau <br>

				Status : Telah $status oleh $atasan<br>

				Anda dapat melakukan pengecekan melalui : 
				1. Internet : aplikasi Quick ERP Mobile atau klik link ini <link ngarah lgs buka aplikasi>. Apabila belum memiliki aplikasinya dapat download di  <link>
				2. jaringan lokal : http://erp.quick.co (http://quick.co.id/dinas_luar)m atau klik <a href='http://erp.quick.com/'>disini</a><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				pabila anda mengalami kendala dapat menghubungi Seksi Hubker (xxxxxxxx) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				$mail->send();
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}

		}
	}


		function kirim_emailPersonalia($internalMail,$eksternalMail,$namaPekerja,$jenisAbsen,$waktu,$lokasi,$latitude,$longitude,$status,$atasan){
				date_default_timezone_set("Asia/Jakarta");
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
				$mail->addAddress('hbk@quick.com', 'Absensi Online Pekerja');
				$mail->addAddress('edp@quick.com', 'Absen Online Pekerja');
				$mail->Subject = 'Status Absensi Online Anda';
				$mail->msgHTML("
				<h4>Absensi Online</h4><hr>
				Kepada Yth.<br>
				$namaPekerja<br><br>
				
				Kami informasikan bahwa request approval Absen Online Anda, detail sbb :<br>
				Jenis Absen : $jenisAbsen<br>
				Waktu : $waktu<br>
				lokasi : $lokasi , koordinat : ( $latitude , $longitude ) 
				<a href='http://maps.google.com/maps?q=$latitude,$longitude''>Lihat Lokasi di Google Maps</a><br>
				atau <br>

				Status : Telah $status oleh $atasan<br>

				Anda dapat melakukan pengecekan melalui : 
				1. Internet : aplikasi Quick ERP Mobile atau klik link ini <link ngarah lgs buka aplikasi>. Apabila belum memiliki aplikasinya dapat download di  <link>
				2. jaringan lokal : http://erp.quick.co (http://quick.co.id/dinas_luar)m atau klik <a href='http://erp.quick.com/'>disini</a><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				pabila anda mengalami kendala dapat menghubungi Seksi Hubker (xxxxxxxx) atau ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				$mail->send();
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}
			}
	}
	
?>		