<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_List extends CI_Controller {


	public function __construct()
    {
    	parent::__construct();

    	$this->load->helper('url');
    	$this->load->helper('html');
    	$this->load->library('session');
    	$this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

    	$this->load->model('M_Index');
    	$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SystemAdministration/MainMenu/M_module');
    	$this->load->model('SystemAdministration/MainMenu/Android/M_list');
    }
	
	public function index()
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Title']		= 'Mobile Approval';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['android'] = $this->M_list->getDataAndroid();
		$data['versi'] = $this->M_list->getLatestVersion();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Android/List/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function delete($id)
	{
		$data['id'] = $id;
		$this->M_list->delete($id);
		redirect('SystemAdministration/Android/List');
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Title']		= 'Mobile Approval';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['android'] = $this->M_list->getDataAndroidById($id);

			


		$noind = RTRIM($data['android'][0]['info_2']);
		// $this->akhirKontrak($data['android'][0]['info_1']);
		// $nama1 = 'NUGROHO';
		// print_r($data['android'][0]['info_2']);exit();
		// echo($nama.'<br>'.$nama1);exit;
		// $id = 'B0720';
		$data['akhirKontrak'] =  $this->M_list->getAkhirKontrak($noind);
		// print_r($data['akhirKontrak']); exit;
		$data['id'] = $id;
		// $data['nama'] =  $this->M_list->getAkhirKontrak($nama);
		// $data['akhir_kontrak'] = $this->M_list->getAkhirKontrak($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Android/List/V_Edit',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function listPekerja(){
		$id = $this->input->post('andro_employee');
		$keyword 			=	strtoupper($this->input->get('term'));
		$list = $this->M_list->listPekerja($id, $keyword);
		echo json_encode($list);
	}

	public function back(){
		redirect('SystemAdministration/Android/List');
	}

	public function updateData($id){
		// $data = ['info_1' => $this->input->post('andro-employee')];
		$tanggal = $this->input->post('valid-until');
		// echo $tanggal;exit();
		$valid_until = date('Y/m/d',strtotime($tanggal));
		// echo $valid_until;exit();
		$validation 	= $this->input->post('andro-status');
		$noinduk 		= $this->input->post('noindukKaryawan');
		$noinduk 		= strtoupper($noinduk);
		$namaPekerja	= $this->input->post('andro-employee');
		$data = ['info_1' => $namaPekerja,
				 'validation' => $validation,
				 'valid_until' => $valid_until,
				 'info_2'	=> $noinduk
				 ];
		// print_r($data);exit();		
		$emailKaryawan = $this->M_list->getEmployeeEmailByNoinduk($noinduk);
		// echo "<pre>";
		// print_r($emailKaryawan);exit();
		$internalMail 	= $emailKaryawan[0]['internal_mail'];
		$eksternalMail	= $emailKaryawan[0]['external_mail'];

		$android_id 		= $this->input->post('android_id');
		$imei 				= $this->input->post('imei');
		$hardware_serial	= $this->input->post('hwserial');
		$gsf 				= $this->input->post('gsf');

		$status="";
		if($validation==1){
			$status = "Disetujui";
		}else{
			$status = "Tidak Disetujui";
		}
		$approver 			= trim($this->session->employee);
		$noindukApprover	= $this->session->user;	


		$this->kirim_email($internalMail,$eksternalMail,$namaPekerja,$status,$approver,$noindukApprover,$android_id,$imei,$hardware_serial,$gsf);
		$this->M_list->updateData($id,$data);

		$this->session->set_flashdata('msg','sukses');
		redirect('SystemAdministration/Android/List');
	}

	public function akhirKontrak($noind){
		
	// $data['noind'] =  $this->M_list->getAkhirKontrak($noind);
	// echo "<pre>";  print_r($data);exit(); echo "</pre>";
	// redirect('SystemAdministration/Android/List');
	}

	public function login(){
		
		$this->load->model('M_index');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password_md5 = md5($password);
		$log = $this->M_Index->login($username,$password_md5);

		if($log){
			$detail = $this->M_list->getDetail($username);
			echo $detail[0]['employee_name'];
		}else{
			echo "0";
			
		}
	}

	public function loginAndroid(){
		
		//$this->load->model('M_index');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password_md5 = md5($password);
		$log = $this->M_Index->login($username,$password_md5);

		if($log){
			$user = $this->M_Index->getDetail($username);
			
			foreach($user as $user_item){
				$iduser 			= $user_item->user_id;
				$password_default 	= $user_item->password_default;
				$kodesie			= $user_item->section_code;
				$employee_name 		= $user_item->employee_name; 
				$kode_lokasi_kerja 	= $user_item->location_code;
			}
			$ses = array(
							'is_logged' 		=> 1,
							'userid' 			=> $iduser,
							'user' 				=> strtoupper($username),
							'employee'  		=> $employee_name,
							'kodesie' 			=> $kodesie,
							'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
						);
			$this->session->set_userdata($ses);
			
			echo $employee_name;
			
		}else{
			echo "0";
		}
	}

	function tambahData(){
		date_default_timezone_set("Asia/Jakarta");
		$tanggal = $this->input->post('valid_until');
		$valid_until = date('Y/m/d',strtotime($tanggal)); 
		// echo $valid_until;exit();

		$karyawan = $this->input->post('andro-employee');
		$karyawan = explode(" - ", $karyawan);
		$noinduk  = $karyawan[0];	
		$karyawan = $karyawan[1];

		
		$data =
		[
			'android_id' 		=> $this->input->post('androidid'),
			'imei'		 		=> $this->input->post('imei'),
			'hardware_serial'	=> $this->input->post('hwserial'),
			'gsf'				=> $this->input->post('gsf'),
			'info_1'			=> $karyawan,
			'info_2'			=> $noinduk,
			'valid_until'		=> $valid_until		];

		$this->M_list->tambahData($data);
		redirect('SystemAdministration/Android/List');
	
	}

	public function kirimEmailICTAndroid(){

				$namaPekerja 		= $this->input->post('namaPekerja');
				$noindukPekerja		= $this->input->post('noindukPekerja');
				$android_id 		= $this->input->post('android_id');
				$imei 				= $this->input->post('imei');
				$hardware_serial	= $this->input->post('hwserial');
				$gsf 				= $this->input->post('gsf');

				if(empty($namaPekerja) and empty($noindukPekerja)){
					$data['status'] = false;
					$data['message'] = 'Value Empty!';
					print_r(json_encode($data));
				}else{				
				$dataICT 			= $this->M_list->getEmailICT();
				// echo "<pre>";
				// print_r($dataICT);exit();
				$internalMailICT = "";
				$externalMailICT = "";
				$namaSeksiICT = "";
				foreach ($dataICT as $key => $emailICT) {
			
				$internalMailICT = $emailICT['internal_mail'];
				$externalMailICT = $emailICT['external_mail'];
				$namaSeksiICT	 = $emailICT['employee_name'];

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
				$mail->setFrom('noreply@quick.co.id', 'ERP Mobile');
				$mail->addAddress($emailICT['internal_mail'], 'Seksi ICT');
				$mail->AddCC('it.sec1@quick.co.id');
				if(!$emailICT['external_mail']==null || !$emailICT['external_mail']==""){
					$mail->addAddress($emailICT['external_mail'], 'Seksi ICT');
				}
				$mail->Subject = 'ERP Mobile Registrasi Android Baru';
				$mail->msgHTML("
				<h4>Registrasi Android Baru</h4><hr>
				Kepada Yth.<br>
				$namaSeksiICT<br><br>
				
				Kami informasikan bahwa $noindukPekerja - $namaPekerja telah melakukan registrasi Android untuk ERP Mobile, dengan detail sbb :<br><br>
				Android ID 				: $android_id<br>
				IMEI 					: $imei<br>
				Hardware Serial 		: $hardware_serial<br>
				GSF 					: $gsf<br><br>

				Anda dapat melakukan pengecekan melalui :<br> 
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				Apabila anda mengalami kendala dapat menghubungi ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}
			}
		}
	}


	function kirim_email($internalMail,$eksternalMail,$namaPekerja,$status,$approver,$noindukApprover,$android_id,$imei,$hardware_serial,$gsf){
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
				$mail->setFrom('noreply@quick.co.id', 'ERP Mobile');
				$mail->addAddress($internalMail, 'ERP Mobile User');
				$mail->AddCC('it.sec1@quick.co.id');
				if(!$eksternalMail==null){
					$mail->addAddress($eksternalMail, 'Status Registrasi Android ERP Mobile');
				}
				$mail->Subject = 'Status Registrasi Android Anda';
				$mail->msgHTML("
				<h4>Status Registrasi Android Anda</h4><hr>
				Kepada Yth.<br>
				$namaPekerja<br><br>
				
				Kami informasikan bahwa request hak akses ERP Mobile anda, dengan detail sbb :<br><br>
				Android ID 				: $android_id<br>
				IMEI 					: $imei<br>
				Hardware Serial 		: $hardware_serial<br>
				GSF 					: $gsf<br><br>

				Status : $status oleh $approver<br><br>

				Anda dapat melakukan pengecekan melalui :<br> 
				1. Internet : aplikasi Quick ERP Mobile. Apabila belum memiliki dapat menghubungi ICT di +62812545922 (Klik <a href='https://wa.me/62812545922' target='_blank'><strong>Disini</strong></a> untuk menghubungi via Whatsapp)<br>
				2. jaringan lokal : <a href='http://erp.quick.com' target='_blank'>http://erp.quick.com</a> atau klik <a href='http://erp.quick.com/'><strong>Disini</strong></a><br><br>

				<small>Email ini digenerate melalui QuickERP pada ".date('d-m-Y H:i:s').".<br>
				Apabila anda mengalami kendala dapat menghubungi ICT Support Center (08112545922) </small>");
				//Replace the plain text body with one created manually
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					//echo "Message sent!";
				}

		}
	}

	public function updateVersi(){
		$getPost = json_decode(file_get_contents('php://input'));
		$versiTerbaru = $getPost->versiTerbaru;
		$mandUpdate = $getPost->mandUpdate;

		$this->M_list->updateVersionControl($versiTerbaru,$mandUpdate);

		$data = $this->M_list->getLatestVersion();

		print_r(json_encode($data[0]));
	}

	
}