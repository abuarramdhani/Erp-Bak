<?php 
defined('BASEPATH') or exit("Omaewa mou shinderu");

/*
	Menu pengiriman limbah approve
	for better code, use visual studio code or atom
	indent 2 spaces
*/

class C_ApprovalLimbah extends CI_Controller {
    public function __construct() {
        parent::__construct();

        if(!$this->session->is_logged) {
            redirect(base_url(''));
        }

        $this->load->model('WasteManagementSeksi/MainMenu/M_kirim');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }

    function index() {
        $kodesie = $this->session->kodesie;
        $user = $this->session->user;
        $user_id = $this->session->userid;

        //check this one, is atasan or not
        $isAtasan = $this->M_kirim->checkAtasanApprove($user, $kodesie);

        $periode = isset($_GET['periode']) ? $_GET['periode'] : '';

        if(!$isAtasan) {
            redirect('WasteManagementSeksi');
        } else {
            $data['LimbahKirim'] = $this->M_kirim->getLimbahKirimAtasan($periode);
        }

        $data['Title'] = 'Atasan Approval Limbah';
				$data['Menu'] = 'Approval';
				$data['SubMenuOne'] = 'Approval';
				$data['SubMenuTwo'] = '';

				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('WasteManagementSeksi/ApprovalLimbah/V_Index', $data);
        $this->load->view('V_Footer');
    }

    // GET
    // @params id encyrpt
    // return redirect
    function approve($id) {
			$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
      $id_decoded = $this->encrypt->decode($plaintext_string);
      
      $this->M_kirim->atasanApprove($id_decoded);
      $this->SendMail('Create', $id_decoded);
      redirect(base_url('WasteManagementSeksi/ApprovalLimbah'));
    }

    // GET
    // @params id encyrpt
    // return redirect
    function reject($id) {
      $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
      $id_decoded = $this->encrypt->decode($plaintext_string);
			$this->M_kirim->atasanReject($id_decoded);
			
      redirect(base_url('WasteManagementSeksi/ApprovalLimbah'));
    }

    // send mail
    // @params -> (Create/other, id_limbah) -> example: $this->SendMail('Create', 213)
    private function SendMail($aksi, $id){
			$this->load->library('PHPMailerAutoload');

      $limbah = $this->M_kirim->getLimKirimMin($id);
			if(!count($limbah)) return false;
			
      $user_name = $limbah['0']['created_by'];
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
		}
	}
}