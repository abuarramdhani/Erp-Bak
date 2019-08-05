<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ComposeMessage extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
       	  
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

	public function index()
	{
        $this->checkSession();
        
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
  
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('PurchaseManagementSendPO/MainMenu/V_ComposeMessage',$data);
        $this->load->view('V_Footer',$data);
    }

    public function SendEmail()
	{
		// Get email content using Ajax
		$po_number		= $_POST['po_number'];
		$getTargetEmail = $_POST['toEmail'];
		$getCCEmail		= $_POST['ccEmail'];
		$getBCCEmail	= $_POST['bccEmail'];
		$subject	 	= $_POST['subject'];
		$format_message	= $_POST['format_message'];
		$body			= $_POST['body'];
		$toEmail		= preg_replace('/\s+/', '', explode(',', $getTargetEmail));
		$ccEmail		= preg_replace('/\s+/', '', explode(',', $getCCEmail));
		$bccEmail		= preg_replace('/\s+/', '', explode(',', $getBCCEmail));
		
		if (empty($body)) {
			$body = ' ';
	   	}

		// Get PDF from other function
		$this->PurchaseManagementDocument($po_number);

		// Directory var
		$doc_dir		= './assets/upload/PurchaseManagementSendPO/Attachment/';
		$doc_filename	= 'Pedoman Kerjasama Vendor Rev 7 (Quick Reference PO)';

		$pdf_dir		= './assets/upload/PurchaseManagementSendPO/Temporary/PDFDocument/';
		$pdf_filename	= 'SURAT PENGIRIMAN BARANG_PO '.$po_number;
		$pdf_format		= '.pdf';

		if (file_exists($doc_dir.preg_replace('/[^a-zA-Z0-9]/', '', $doc_filename).$pdf_format) == TRUE && file_exists($doc_dir.$doc_filename.$pdf_format) == FALSE) 
		{
			rename($doc_dir.preg_replace('/[^a-zA-Z0-9]/', '', $doc_filename).$pdf_format , $doc_dir.$doc_filename.$pdf_format);
		};

		// FTP //
			// Initialise the connection parameters  
			$ftp_server 	 = 'purchasing.quick.com';  
			$ftp_username	 = 'SENDPO';  
			$ftp_password 	 = '123456';
			$ftp_local_dir	 = './assets/upload/PurchaseManagementSendPO/Temporary/FTPDocument/';
			$ftp_server_dir	 = './1.PENGUMUMAN/ADS2800W/Choirul/';
			$ftp_file_format = '.pdf';

			// Create an FTP connection  
			$conn = ftp_connect($ftp_server) or die('Tidak dapat terhubung ke server sharing.');  

			// Try to login
			if (@ftp_login($conn, $ftp_username, $ftp_password)) {
				// echo json_encode("Terhubung dengan $ftp_username@$ftp_server\n");
				// exit;
			} else {
				echo json_encode('Tidak dapat terhubung ke server sharing.');
				exit;
			}

			// Turn passive mode on (Prevent Unable to build data connection: Connection timed out)
			ftp_pasv($conn, TRUE);

			// Change FTP directory
			ftp_cdup($conn);
			ftp_chdir($conn, '/mnt/NASB/SUPPLIER_ADMIN/');
			// echo ftp_pwd($conn);

			// Download Files
			if (ftp_size($conn, $ftp_server_dir.$po_number.$ftp_file_format) > 0) 
			{		
				$files = ftp_get($conn, $ftp_local_dir.$po_number.$ftp_file_format, $ftp_server_dir.$po_number.$ftp_file_format, FTP_BINARY);
			}else{
				echo json_encode('Lampiran dengan PO Number "'.$po_number.'" tidak ditemukan.');
				exit;
			}

			// Close connection
			ftp_close($conn);
		// FTP //

		// Load library email
		$this->load->library('PHPMailerAutoload');
		$mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

		// Set connection SMTP Webmail
        $mail->isSMTP();
        $mail->Host = 'mail.quick.co.id';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true)
				);
        $mail->Username = 'purchasing.sec12@quick.co.id';
        $mail->Password = 'uZa78cf4npur2018sec12';
        $mail->WordWrap = 50;

        // Set email content to sent
		$mail->setFrom('purchasing.sec12@quick.co.id', 'Admin PO CV. KHS');
		foreach ($ccEmail as $key => $ccE) {
			$mail->AddCC($ccE);
		}
		foreach ($bccEmail as $key => $bccE) {
			$mail->AddBCC($bccE);
		}
		foreach ($toEmail as $key => $toE) {
			$mail->addAddress($toE);
		}
			if (file_exists($ftp_local_dir.$po_number.$ftp_file_format) == TRUE) 
			{
				$mail->addAttachment($ftp_local_dir.$po_number.$ftp_file_format);
			};
			if (file_exists($pdf_dir.$pdf_filename.$pdf_format) == TRUE) 
			{
				$mail->addAttachment($pdf_dir.$pdf_filename.$pdf_format);
			};
			if ($format_message != 'English') {
				if (file_exists($doc_dir.$doc_filename.$pdf_format) == TRUE) 
				{
					$mail->addAttachment($doc_dir.$doc_filename.$pdf_format);
				}else{
					echo json_encode('Lampiran '.$doc_filename.' tidak ditemukan.');
					exit;
				};	
			};
	
			if (isset($_FILES['file_attach1']) && $_FILES['file_attach1']['error'] == UPLOAD_ERR_OK) 
			{
				$mail->AddAttachment($_FILES['file_attach1']['tmp_name'],$_FILES['file_attach1']['name']);
			};
			if (isset($_FILES['file_attach2']) && $_FILES['file_attach2']['error'] == UPLOAD_ERR_OK) 
			{
				$mail->AddAttachment($_FILES['file_attach2']['tmp_name'],$_FILES['file_attach2']['name']);
			};
		$mail->Subject = $subject;
		$mail->msgHTML($body);
		
		// Send email
		if (!$mail->send()) {
			echo json_encode(null);
			// echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo json_encode('Message sent!');
		}

		// Delete saved local files
		if (file_exists($ftp_local_dir.$po_number.$ftp_file_format) == TRUE) {
			unlink($ftp_local_dir.$po_number.$ftp_file_format);
		};
		if (file_exists($pdf_dir.$pdf_filename.$pdf_format) == TRUE) {
			unlink($pdf_dir.$pdf_filename.$pdf_format);
		};
	}

	public function getUserEmail($id)
	{
		$this->load->model('PurchaseManagementSendPO/MainMenu/M_composemessage');
		
		$email = $this->M_composemessage->getEmailAddress($id);
		if (!empty($email)){
			$data  = str_replace(' /', ',', $email[0]['EMAIL']);
			echo json_encode($data);
		}else{
			echo json_encode(null);
		}
	}

	public function PurchaseManagementDocument($id)
	{
		$this->load->model('PurchaseManagementSendPO/MainMenu/M_composemessage');

		$result 	= $this->M_composemessage->getDeliveryLetters($id);
		$nomor_po 	= $id;
		$max_data 	= 1;
		
		$total_page = ceil(sizeof($result)/$max_data);
		$size 		= sizeof($result);
			
		$temp2 = array();
		$loop  = 0;
		$x     = 0;
		for ($i=0; $i < $total_page; $i++){ 
			if($size < $max_data){
				$loop = $size;
			}else{
				$loop = $max_data;
			}
			for ($j=0; $j < $loop; $j++) { 
				$temp2[$i][$j] = $result[$x];
				$x++;
			}
			$size -= $max_data;
		}

		$data['RESULT'] = $result;
		$data['DETAIL'] = $temp2;
		// $data['NO_DIPAKE'] = $this->getNoSekarang($nomor_po);
		$data['NO_PO'] = $nomor_po;

		if(empty($data['DETAIL'])){
			echo json_encode('Lampiran dengan PO Number "'.$nomor_po.'" tidak ditemukan.');
			exit();
		}

		// ------ GENERATE QRCODE ------
		$this->load->library('ciqrcode');
			// ------ CREATE DIRECTORY TEMPORARY QR CODE ------
				if(!is_dir('./img'))
				{
					mkdir('./img', 0777, true);
					chmod('./img', 0777);
				}
		$params['data']		= $nomor_po;
		$params['level']	= 'H';
		$params['size']		= 10;
		$params['black']	= array(255,255,255);
		$params['white']	= array(0,0,0);
		$params['savename'] = './img/'.$nomor_po.'.png';
		$this->ciqrcode->generate($params);
		
		// ------ GENERATE PDF ------
		$this->load->library('Pdf');

		$pdf 		= $this->pdf->load();
		$pdf        = new mPDF('utf-8','A4-P', 0, '', 3, 3, 3, 14, 3, 3);
		$pdf_dir	= './assets/upload/PurchaseManagementSendPO/Temporary/PDFDocument/';
		$filename 	= 'SURAT PENGIRIMAN BARANG_PO '.$nomor_po.'.pdf';	
		$content 	= $this->load->view('PurchaseManagementSendPO/Report/V_Content', $data,true);
		$footer 	= '<p style="text-align:right">PO : '.$nomor_po.'</p>';
		
		$pdf->SetHTMLFooter($footer);
		$pdf->WriteHTML($content);

		$pdf->debug = true;
		$pdf->Output($pdf_dir.$filename, 'F');
		
		if(is_file($params['savename'])){
			unlink($params['savename']);
		}
	}
}