<?php if (!(defined('BASEPATH'))) exit('No direct script access allowed');

class C_MonitoringPE extends CI_Controller
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        $this->load->library('PHPMailerAutoload');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MonitoringPembelian/Monitoring/M_monitoringpe');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession(){
		if($this->session->is_logged){
			}else{
				redirect();
			}
	}

	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['MonitoringPE']  = $this->M_monitoringpe->getData();
		$data['EmailPembelian'] = $this->M_monitoringpe->getdataEmailPembelian();
		$data['EmailPE'] = $this->M_monitoringpe->getdataEmailPE();	

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPembelian/Monitoring/V_MonitoringPE',$data);
		$this->load->view('V_Footer',$data);

		}
	
	function SaveUpdatePembelianPE(){

		$id = $this->input->post('id');
		$itemCode = $this->input->post('seg1');
		$desc = $this->input->post('desc');
			$preproc = $this->input->post('preproc');
			$ppo = $this->input->post('ppo');
			$deliver = $this->input->post('deliver');
			$totproc = $this->input->post('totproc');
			$postproc = $this->input->post('postproc');
			$moq = $this->input->post('moq');
			$flm = $this->input->post('flm');
			$attr18 = $this->input->post('attr18');
		$status = $this->input->post('stat');
		$email = $this->input->post('EmailPembelian[]');
		$fullname = $this->input->post('fullname');
		$receive_close_tolerance = $this->input->post('receive_close_tolerance');
		$qty_rcv_tolerance = $this->input->post('qty_rcv_tolerance');
		$semua  = array();
		for ($i=0; $i < sizeof($itemCode) ; $i++) {
			$inv_id = $this->M_monitoringpe->getInvItemId($itemCode[$i]);
			$data = array(
					'INVENTORY_ITEM_ID' => $inv_id[0]['INVENTORY_ITEM_ID'],
					'BUYER_ID' 	=> $fullname[$i],
					'UPDATE_ID' 	=> $id[$i],
					'SEGMENT1' 	=> $itemCode[$i],
					'DESCRIPTION' => $desc[$i],
					'PREPROCESSING_LEAD_TIME' 	=> $preproc[$i],
					'PREPARATION_PO'	=> $ppo[$i],
					'DELIVERY'	=> $deliver[$i],
					'FULL_LEAD_TIME' 	=> $totproc[$i],
					'POSTPROCESSING_LEAD_TIME' 	=> $postproc[$i],
					'MINIMUM_ORDER_QUANTITY' 	=> $moq[$i],
					'FIXED_LOT_MULTIPLIER' 	=> $flm[$i],
					'ATTRIBUTE18' 	=> $attr18[$i],
					'RECEIVE_CLOSE_TOLERANCE' => $receive_close_tolerance[$i],
					'QTY_RCV_TOLERANCE' => $qty_rcv_tolerance[$i],
					'STATUS'	=> $status[$i]
				);
		$semua[] = $data;
		}

		// echo "<pre>";
		// print_r($semua);
		// exit();

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
        foreach ($email as $a) {
        	$mail->addAddress($a);       
        }       
        
       	$isi = '<h4>PERUBAHAN STATUS REQUEST</h4>';

       	foreach ($semua as $dt) {
	       	if ($dt['STATUS'] == 'APPROVED' || $dt['STATUS'] == 'REJECTED') {
	       		$isi .= '<b>Update Event ID : </b>'.$dt['UPDATE_ID'].'<br>';
	       		$isi .= '<b>Item Code : </b>'.$dt['SEGMENT1'].'<br>';
	       		$isi .= '<b>Description : </b>'.$dt['DESCRIPTION'].'<br>';
	       		$isi .= '<b>Status : </b>'.$dt['STATUS'].'<br><br>';
	       	}
		}

		$mail->Subject = 'Perubahan Status Data';
		$mail->msgHTML($isi);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!..<br>";
		}
		 	// echo "<pre>";
			// print_r($semua);
			// exit();
	
		$this->M_monitoringpe->UpdatePembelianPE($semua);
		redirect('MonitoringPembelian/HistoryRequest');
	}

	public function SettingEmailPE(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['EmailPE'] = $this->M_monitoringpe->getdataEmailPE();

			
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPembelian/Monitoring/V_EmailPE',$data);
		$this->load->view('V_Footer',$data);

		}	
	public function SaveEmailPE(){
		$email = $this->input->post('txtEmail');
		$this->M_monitoringpe->UpdateEmailPE($email);
		redirect('MonitoringPembelian/MonitoringPE/SettingEmailPE');
	}

	public function DeleteEmailPE($email){
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $email);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->M_monitoringpe->HapusEmailPE($plaintext_string);
		redirect('MonitoringPembelian/MonitoringPE/SettingEmailPE');
	}
}