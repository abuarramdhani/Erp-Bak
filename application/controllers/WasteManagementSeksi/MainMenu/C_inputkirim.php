<?php
Defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_inputkirim extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WasteManagementSeksi/MainMenu/M_kirim');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function getSession(){
		if ($this->session->is_logged) {
			
		}else{
			redirect('');
		}
	}

	public function index(){
		$this->getSession();

		$user_id = $this->session->userid;

		$data['Title'] = 'Input Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['LimbahKirim'] = $this->M_kirim->getLimbahKirim();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagementSeksi/InputKirimLimbah/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$this->getSession();

		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Create Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';
		// print_r($_POST); exit();
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JenisLimbah'] = $this->M_kirim->getLimJenis();
		$data['Seksi'] = $this->M_kirim->getSekNamaByKodesie($kodesie);
		$data['Pekerja'] = $this->M_kirim->getEmployeeByKodesie($kodesie);

		if (empty($_POST)) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagementSeksi/InputKirimLimbah/V_create',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$id = $this->M_kirim->getKirimID();
			if ($id['0']['id'] == null) {
				$id['0']['id'] = "1";
			}
			$datapost = array(
				'id_kirim' => $id['0']['id'],
				'tanggal' => $this->input->post('txtTanggalKirimLimbah'), 
				'waktu' => $this->input->post('txtWaktuKirimLimbah'), 
				'jenis_limbah' => $this->input->post('txtJenisLimbah'),
				'pengirim' => $this->input->post('txtPengirimLimbah'), 
				'kondisi' => $this->input->post('txtKondisi'), 
				'jumlah' => $this->input->post('txtJumlah'), 
				'keterangan' => $this->input->post('txtKeterangan'), 
			);
			// echo "<pre>";
			// print_r($datapost);
			// print_r($_POST); exit();
			$this->M_kirim->insertKirimLimbah($datapost);
			$encrypted_string = $this->encrypt->encode($id['0']['id']);
            $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			redirect(site_url('WasteManagementSeksi/InputKirimLimbah/Sendmail/Create/'.$encrypted_string));
		}

		
	}

	public function EditKirim($id){
		$this->getSession();

		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title'] = 'Edit Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JenisLimbah'] = $this->M_kirim->getLimJenis();
		$data['Seksi'] = $this->M_kirim->getSekNamaByKodesie($kodesie);
		$data['KirimLimbah'] = $this->M_kirim->getLimKirim($plaintext_string);

		if (empty($_POST)) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagementSeksi/InputKirimLimbah/V_edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$datapost = array(
				'id_kirim' => $plaintext_string,
				'tanggal' => $this->input->post('txtTanggalKirimLimbah'), 
				'waktu' => $this->input->post('txtWaktuKirimLimbah'), 
				'jenis_limbah' => $this->input->post('txtJenisLimbah'), 
				'kondisi' => $this->input->post('txtKondisi'), 
				'jumlah' => $this->input->post('txtJumlah'), 
				'keterangan' => $this->input->post('txtKeterangan'), 
			);
			// echo "<pre>";
			// print_r($datapost);
			// print_r($_POST); exit();
			$this->M_kirim->UpdateLimKirim($datapost);
			redirect(site_url('WasteManagementSeksi/InputKirimLimbah/Sendmail/Edit/'.$id));
		}
		
	}

	public function DelKirim($id){
		$this->getSession();

		$user_id = $this->session->userid;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title'] = 'Edit Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Input Kirim Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->M_kirim->delLimKirim($plaintext_string);
		$data['LimbahKirim'] = $this->M_kirim->getLimbahKirim();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagementSeksi/InputKirimLimbah/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SendMail($aksi,$id){
		$this->load->library('PHPMailerAutoload');

		$this->getSession();

		$user_id = $this->session->userid;
		$user_name = $this->session->user;

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$limbah = $this->M_kirim->getLimKirimMin($plaintext_string);
		$jenis = $limbah['0']['jenis_limbah'];
		$seksi = $limbah['0']['seksi'];
		$jumlah = $limbah['0']['jumlah'];
		$tanggal = $limbah['0']['tanggal'];
		$waktu = $limbah['0']['waktu'];

		

		if ($aksi == "Create") {
			$text = "user <b> ".$user_name." </b> telah menginput kiriman limbah. ";
		}else{
			$text = "user <b> ".$user_name." </b> telah mengedit kiriman limbah. ";
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
				
					<p> '.$text.' <br> Dengan detail sebagai berikut :
					</p>
					<table>
					<tr>
					<td>Tanggal Kirim</td>
					<td> : </td>
					<td>'.$tanggal.'</td>
					</tr>
					<tr>
					<tr>
					<td>Waktu Kirim</td>
					<td> : </td>
					<td>'.$waktu.'</td>
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
    	$mail->addAddress('wst@quick.com','Seksi Waste Management');
        $mail->Subject = 'Waste Management';
		$mail->msgHTML($message);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		} else {
			redirect(base_url('WasteManagementSeksi/InputKirimLimbah'));
		}
	}
}
?>