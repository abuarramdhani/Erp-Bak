<?php defined('BASEPATH')OR die('No direct script access allowed'); 
class C_MonOrder extends CI_Controller {
    function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		if(!$this->session->userdata('logged_in')) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('upload');
		$this->load->library('PHPMailerAutoload');
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('OrderSeksiRekayasa/M_submitorder');
    }

    public function checkSession(){
		if ($this->session->is_logged) {

        }else{
            redirect();
        }
	}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Monitoring Order';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['All_Order'] = $this->M_submitorder->getMonOrder(FALSE);
		$data['Belum_Otorisasi'] = $this->M_submitorder->getMonOrder(0);
		$data['Menunggu_Diterima'] = $this->M_submitorder->getMonOrder(1);
		$data['Order_Diterima'] = $this->M_submitorder->getMonOrder(2);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSeksiRekayasa/Agent/V_MonOrder',$data);
		$this->load->view('V_Footer',$data);
	}

	public function terimaOrder(){
		$id_order = $this->input->post('id_order');
		$status = $this->input->post('status');
		
		if (!$this->input->is_ajax_request()) {
            echo "Akses Terlarang !!";
        } else {
            $response = $this->M_submitorder->terimaOrder($id_order, $status);
			echo json_encode($response);
			// $response2 = $this->emailAlert($id_order);
			// echo json_encode($response2);
		}
		
		
	}
	
	public function emailAlert($id_order){
		$getEmail = $this->M_submitorder->getEmail($id_order);
		$UserEmail = $getEmail[0]['internal_mail'];
		$link = base_url("OrderSeksiRekayasa/View/$id_order");
		
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
		$mail->addAddress($UserEmail);
		
		$isi = 'Pengajuan Order dari '.$getEmail[0]['nama'].'telah diterima oleh Seksi Rekayasa. Rincian Order :<br/>
		No Order &nbsp;: '.$getEmail[0]['id_order'].'<br/>
		Jenis Order &nbsp;: '.$getEmail[0]['jenis_order'].'<br/>
		Nama Alat/Mesin &nbsp;: '.$getEmail[0]['nama_alat_mesin'].' <br/>
		Klik link untuk melihat Order <a href="'.$link.'" >disini</a>.
		<br/>';
		
		$mail->Subject = 'Order diterima Seksi Rekayasa';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			$result = "Error";
		} else {
			$result = "Success";
			echo json_encode($result);
		}
	}

}
?>