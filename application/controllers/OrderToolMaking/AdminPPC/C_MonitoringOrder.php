<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MonitoringOrder extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderToolMaking/M_monitoringorder');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Order';
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind = $this->session->user;
		$data['siapa'] = 'Admin PPC';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderToolMaking/V_MonitoringOrder', $data);
		$this->load->view('V_Footer',$data);
    }
		// view detail dan save revisi ada di c_monitoringorder folder approval tool making
		
	public function kirimbarang(){
		$no_order 	= $this->input->post('no_order');
		$ket 	= $this->input->post('ket');
		if ($ket == 'Modifikasi') {
			$get = $this->M_monitoringorder->getdatamodif("where no_order = '$no_order'");
		}elseif ($ket == 'Baru') {
			$get = $this->M_monitoringorder->getdatabaru("where no_order = '$no_order'");
		}else {
			$get = $this->M_monitoringorder->getdatarekondisi("where no_order = '$no_order'");
		}
		// echo "<pre>";print_r($get);exit();
		$cek 		= $this->M_monitoringorder->cekaction($no_order, "and person = 10"); // status 10 = barang sudah selesai / akan kirim ke seksi pengorder
		if (empty($cek)) {
			$this->M_monitoringorder->saveaction($no_order, 10, 1, '', date('Y-m-d H:i:s'), $this->session->user);
		}else {
			$this->M_monitoringorder->updateaction($no_order, 10, 1, '', date('Y-m-d H:i:s'), $this->session->user);
		}
		if (stripos($get[0]['jenis'], 'FIXTURE') !== FALSE) {
			$jenis = substr($get[0]['jenis'],0,7);
		}elseif (stripos($get[0]['jenis'], 'MASTER') !== FALSE) {
			$jenis = substr($get[0]['jenis'],0,6);
		}elseif (stripos($get[0]['jenis'], 'GAUGE') !== FALSE) {
			$jenis = substr($get[0]['jenis'],0,5);
		}elseif (stripos($get[0]['jenis'], 'ALAT LAIN') !== FALSE) {
			$jenis = substr($get[0]['jenis'],0,9);
		}else {
			$jenis = $get[0]['jenis'];
		}
		$this->send_email_kirim($get[0]['pengorder'], $get[0]['no_order'], $get[0]['seksi'], $jenis);
		redirect(base_url('OrderToolMakingAdminPPC/MonitoringOrder/'));
	}

	public function send_email_kirim($pengorder, $no_order, $seksi_order, $jenis){
		// kirim email ke tujuan kirim
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
		'allow_self_signed' => true)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;
		// set email content
		$mail->setFrom('no-reply@quick.com', 'Email Sistem');
		// cari email berdasarkan tujuan kirim
		$email = $this->M_monitoringorder->dataEmail($pengorder);
		// echo "<pre>";print_r($email);
		foreach ($email as $a) {
			$mail->addAddress($a['email_internal']);   
			// echo $a['email'];    
		}

		$isi = '<h4>REQUEST ORDER TOOL MAKING TELAH SELESAI DIBUAT DAN SEDANG DALAM PROSES KIRIM :</h4>
				<b>No Order :</b> '.$no_order.'<br>
				<b>Pengorder :</b> '.$pengorder.' - '.$email[0]['nama'].'<br>
				<b>Seksi Pengorder :</b> '.$seksi_order.'<br>
				<b>Pembuatan :</b> '.$jenis.'<br><br>
				Untuk proses approve jika order sudah diterima : <a href="'.base_url("OrderToolMaking/MonitoringOrder").'" target="_blank">klik disini</a>';

		$mail->Subject = 'Request Order Tool Making';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			// echo "Mailer Error: " . $mail->ErrorInfo;
			// exit();
		} else {
			// echo "Message sent!..<br>";
		}
	}
}