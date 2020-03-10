<?php
Defined('BASEPATH')	or exit('No direct script access allowed');

/**
 * 
 */
class C_LimbahKelola extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WasteManagement/MainMenu/M_limbahkelola');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Kiriman Masuk';
		$data['Menu'] = 'Kelola Limbah';
		$data['SubMenuOne'] = 'Kiriman Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kiriman = $this->M_limbahkelola->getLimbahKirim();

		$kiriman = array_filter($kiriman, function($item) {
			if(strtotime($item['tanggal']) > strtotime('2020-03-10')) {
				return ($item['status_kirim'] == 4 || $item['status_kirim'] == 1);
			} else {
				return true;
			}
		});

		$data['Kiriman'] = $kiriman; 

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKelola/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Read($id){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title'] = 'Read Kiriman Masuk';
		$data['Menu'] = 'Kelola Limbah';
		$data['SubMenuOne'] = 'Kiriman Masuk';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['LimbahKirim'] = $this->M_limbahkelola->getLimbahKirimById($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahKelola/V_read',$data);
		$this->load->view('V_Footer',$data);
	}
	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkelola->DeleteLimbahKirim($plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk'));
	}

	public function Approve($id){

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$berat = $this->input->post('txtberat');
		$berat = str_replace(',', '.', $berat);
		$this->M_limbahkelola->updateLimbahBerat($berat,$plaintext_string);

		$this->M_limbahkelola->updateLimbahStatus('1',$plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk/Emailing/1/'.$id));
	}

	public function Reject($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkelola->updateLimbahStatus('2',$plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk/Emailing/2/'.$id));
	}

	public function Pending($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahkelola->updateLimbahStatus('3',$plaintext_string);

		redirect(site_url('WasteManagement/KirimanMasuk'));
	}

	public function Emailing($status, $id){
		$this->load->library('PHPMailerAutoload');

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$email = $this->M_limbahkelola->getSeksiEmail($plaintext_string);
		$limbah = $this->M_limbahkelola->getLimKirimMin($plaintext_string);
		$jenis = $limbah['0']['jenis_limbah'];
		$seksi = $limbah['0']['seksi'];
		$jumlah = $limbah['0']['jumlah'];
		$tanggal = $limbah['0']['tanggal'];
		$berat = '';
		$mailkosong = '';

		
		if (empty($email)) {
			$email['0']['email_kirim'] = 'wst@quick.com';
			$email['0']['seksi_kirim'] = 'Waste Management';
			$mailkosong = 'Seksi <b>'.$seksi.'</b> Belum Mempunyai Email Yang Terdaftar di ga_limbah_kirim_email.<br>Notifikasi email tidak dikirimkan karena data email tidak ditemukan.';
		}

		if ($status == "1") {
			$text = "Kiriman limbah sudah di <b>Approve</b> oleh Waste Management.";
			$berat = '<tr>
						<td>Berat</td>
						<td> : </td>
						<td>'.$limbah['0']['berat'].' Kg</td>
					</tr>';
		}else{
			$text = "Kiriman limbah sudah di <b>Reject</b> oleh Waste Management.";
		}

		$message = '	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://wwwhtml4/loose.dtd">
				<html>
				<head>
			 	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			  	<title>Mail Generated By System</title>
			  	<style>
				#main 	{
   	 						border: 1px solid black;
   	 						text-align: center;
   	 						border-collapse: collapse;
   	 						width: 100%;
						}
				#detail {
   	 						border: 1px solid black;
   	 						text-align: justify;
   	 						border-collapse: collapse;					
						}

			  	</style>
				</head>
				<body>
						<h3 style="text-decoration: underline;">Waste Management</h3>
					<hr/>
					<h4>'.$mailkosong.'</h4><br>
					<p> '.$text.' <br> Dengan detail sebagai berikut :
					</p>
					<table>
					<tr>
					<td>Tanggal Kirim</td>
					<td> : </td>
					<td>'.$tanggal.'</td>
					</tr>
					<tr>
					<td>Seksi</td>
					<td> : </td>
					<td>'.$seksi.'</td>
					</tr>
					<tr>
					<td>Jenis Limbah</td>
					<td> : </td>
					<td>'.$jenis.'</td>
					</tr>
					<tr>
					<td>Jumlah</td>
					<td> : </td>
					<td>'.$jumlah.'</td>
					</tr>
					'.$berat.'
					</table>
					<hr/>
					<p>
					Untuk melihat/mengelola, silahkan login ke ERP
					</p>
					
				</body>
				</html>';

		$mail = new PHPMailer(); 
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        $mail->isSMTP();
        $mail->Host = 'mail.quick.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true)
				);
        $mail->Username = 'no-reply';
        $mail->Password = '123456';
        $mail->WordWrap = 50;
        $mail->setFrom('noreply@quick.com', 'Email Sistem');
        foreach ($email as $key) {
        	$mail->addAddress($key['email_kirim'],$key['seksi_kirim']);
        }
        $mail->Subject = 'Waste Management';
		$mail->msgHTML($message);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		} else {
			redirect(base_url('WasteManagement/KirimanMasuk'));
		}
	}
}
