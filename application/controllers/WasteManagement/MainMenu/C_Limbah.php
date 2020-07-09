<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_Limbah extends CI_Controller
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
		$this->load->library('upload');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('WasteManagement/MainMenu/M_limbah');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Koreksi Limbah';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Koreksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Limbah'] = $this->M_limbah->getLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/Limbah/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{

		$user_id = $this->session->userid;

		$data['getSeksi'] = $this->M_limbah->getSeksi();
		$data['jenis_limbah'] = $this->M_limbah->getJenisLimbah();

		$data['Title'] = 'Koreksi Limbah';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Koreksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		
		$this->form_validation->set_rules('txtNamaKirimHeader', 'nama', 'required');	
		
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/Limbah/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			
			if(!empty($_FILES['fileFoto']['name'])){
				$config['upload_path']          = './assets/limbah/standar-foto';
				$config['allowed_types']        = '*';
	        	$config['max_size']             = 20480;
	        	$config['file_name']		 	= filter_var($_FILES['fileFoto']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('fileFoto')) {
            		$this->upload->data();
        		} else {
        			$errorinfo = $this->upload->display_errors();
        		}
        	}

        	if(!empty($_FILES['fileLimbah']['name'])){
		        		$config['upload_path']          = './assets/limbah/kondisi-limbah';
						$config['allowed_types']        = '*';
			        	$config['max_size']             = 20480;
			        	$config['file_name']		 	= filter_var($_FILES['fileLimbah']['name'], FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);
			        	
			        	$this->upload->initialize($config);

			    		if ($this->upload->do_upload('fileLimbah')) {
		            		$this->upload->data();
		        		} else {
		        			$errorinfo = $this->upload->display_errors();
		        		}
	        }
        

			$data = array(
				'tanggal_kirim' => date("Y-m-d", strtotime($this->input->post('txtTanggalKirimHeader',true))),
				'seksi_kirim' => $this->input->post('cmbSeksiKirimHeader',true),
				'nama_kirim' => $this->input->post('txtNamaKirimHeader',true),
				'nama_limbah' => $this->input->post('txtNamaLimbahHeader',true),
				'nomor_limbah' => $this->input->post('txtNomorLimbahHeader',true),
				'jenis_limbah' => $this->input->post('cmbJenisLimbahHeader',true),
				'karakteristik_limbah' => $this->input->post('txtKarakteristikLimbahHeader',true),
				'kondisi_limbah' => filter_var($_FILES['fileLimbah']['name'], FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL), 
				'temuan_kemasan' => $this->input->post('txtTemuanKemasanHeader',true),
				'temuan_kebocoran' => $this->input->post('txtTemuanKebocoranHeader',true),
				'temuan_level_limbah' => $this->input->post('txtTemuanLevelLimbahHeader',true),
				'temuan_lain_lain' => $this->input->post('txtTemuanLainLainHeader',true),
				'standar_foto' => filter_var($_FILES['fileFoto']['name'], FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL), 
				'standar_refrensi' => $this->input->post('txaStandarRefrensiHeader',true),
				'standar_kemasan' => $this->input->post('txtStandarKemasanHeader',true),
				'standar_kebocoran' => $this->input->post('txtStandarKebocoranHeader',true),
				'standar_lain_lain' => $this->input->post('txtStandarLainLainHeader',true),
				'catatan_saran' => $this->input->post('txaCatatanSaranHeader',true),
				'start_date' =>  date('Y-m-d h:i:s'),
				'end_date' =>  date('Y-m-d h:i:s'),
				'creation_date' =>  date('Y-m-d h:i:s'),
				'created_by' => $this->session->userid,
				'temuan_kemasan_status' => $this->input->post('cmbTemuanKemasanStatusHeader',true),
				'temuan_kebocoran_status' => $this->input->post('cmbTemuanKebocoranStatusHeader',true),
				'temuan_level_limbah_status' => $this->input->post('cmbTemuanLevelLimbahStatusHeader',true),
				'temuan_lain_lain_status' => $this->input->post('cmbTemuanLainLainStatusHeader',true)
    		);

			$this->M_limbah->setLimbah($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('WasteManagement/Limbah/sendMail/create'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['getSeksi'] = $this->M_limbah->getSeksi();
		$data['jenis_limbah'] = $this->M_limbah->getJenisLimbah();

		$data['Title'] = 'Koreksi Limbah';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Koreksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Limbah'] = $this->M_limbah->getLimbah($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtNamaKirimHeader', 'nama', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/Limbah/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			if(!empty($_FILES['fileFoto']['name'])){
				$config['upload_path']          = './assets/limbah/standar-foto';
				$config['allowed_types']        = '*';
	        	$config['max_size']             = 20480;
	        	$config['file_name']		 	= filter_var($_FILES['fileFoto']['name'], FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('fileFoto')) {
            		$this->upload->data();
        		} else {
        			$errorinfo = $this->upload->display_errors();
        		}
        	} else {
        		$_FILES['fileFoto']['name'] = '';
        	}

        	if(!empty($_FILES['fileLimbah']['name'])){
        		$config['upload_path']          = './assets/limbah/kondisi-limbah';
				$config['allowed_types']        = '*';
	        	$config['max_size']             = 20480;
	        	$config['file_name']		 	= filter_var($_FILES['fileLimbah']['name'], FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);
	        	
	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('fileLimbah')) {
            		$this->upload->data();
        		} else {
        			$errorinfo = $this->upload->display_errors();
        		}
        	} else {
        		$_FILES['fileLimbah']['name'] = '';
        	}

			$data = array(
				'tanggal_kirim' => date("Y-m-d",strtotime($this->input->post('txtTanggalKirimHeader',TRUE))),
				'seksi_kirim' => $this->input->post('cmbSeksiKirimHeader',TRUE),
				'nama_kirim' => $this->input->post('txtNamaKirimHeader',TRUE),
				'nama_limbah' => $this->input->post('txtNamaLimbahHeader',TRUE),
				'nomor_limbah' => $this->input->post('txtNomorLimbahHeader',TRUE),
				'jenis_limbah' => $this->input->post('cmbJenisLimbahHeader',TRUE),
				'karakteristik_limbah' => $this->input->post('txtKarakteristikLimbahHeader',TRUE),
				'kondisi_limbah' => filter_var($_FILES['fileLimbah']['name'], FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL),
				'temuan_kemasan' => $this->input->post('txtTemuanKemasanHeader',TRUE),
				'temuan_kebocoran' => $this->input->post('txtTemuanKebocoranHeader',TRUE),
				'temuan_level_limbah' => $this->input->post('txtTemuanLevelLimbahHeader',TRUE),
				'temuan_lain_lain' => $this->input->post('txtTemuanLainLainHeader',TRUE),
				'standar_foto' => filter_var($_FILES['fileFoto']['name'], FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL),
				'standar_refrensi' => $this->input->post('txaStandarRefrensiHeader',TRUE),
				'standar_kemasan' => $this->input->post('txtStandarKemasanHeader',TRUE),
				'standar_kebocoran' => $this->input->post('txtStandarKebocoranHeader',TRUE),
				'standar_lain_lain' => $this->input->post('txtStandarLainLainHeader',TRUE),
				'catatan_saran' => $this->input->post('txaCatatanSaranHeader',TRUE),
				'end_date' => date('Y-m-d h:i:s'),
				'last_updated' => date('Y-m-d h:i:s'),
				'last_update_by' => $this->session->userid,
				'temuan_kemasan_status' => $this->input->post('cmbTemuanKemasanStatusHeader',TRUE),
				'temuan_kebocoran_status' => $this->input->post('cmbTemuanKebocoranStatusHeader',TRUE),
				'temuan_level_limbah_status' => $this->input->post('cmbTemuanLevelLimbahStatusHeader',TRUE),
				'temuan_lain_lain_status' => $this->input->post('cmbTemuanLainLainStatusHeader',TRUE),
    		);



			if(empty($_FILES['fileFoto']['name'])){
        		unset($data['standar_foto']);
        	}
        	if(empty($_FILES['fileLimbah']['name'])){
        		unset($data['kondisi_limbah']);
        	}

			$this->M_limbah->updateLimbah($data, $plaintext_string);

			redirect(site_url('WasteManagement/Limbah/sendMail/edit'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Koreksi Limbah';
		$data['Menu'] = 'Master Limbah';
		$data['SubMenuOne'] = 'Limbah Koreksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Limbah'] = $this->M_limbah->getLimbah($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/Limbah/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbah->deleteLimbah($plaintext_string);

		redirect(site_url('WasteManagement/Limbah/sendMail/delete'));
    }

    public function cetakPDF($id)
    {	
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		$data['Limbah'] = $this->M_limbah->getLimbah($plaintext_string);

    	$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$filename = 'data-limbah.pdf';
		
		$html = $this->load->view('WasteManagement/Limbah/V_Pdf', $data, true);

		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'D');
	}

	public function Report()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Report Koreksi Limbah';
		$data['Menu'] = 'Report Limbah';
		$data['SubMenuOne'] = 'Report Limbah Koreksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Limbah'] = $this->M_limbah->getLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/Limbah/V_Report', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Record()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Record Koreksi Limbah';
		$data['Menu'] = 'Record Limbah';
		$data['SubMenuOne'] = 'Record Limbah Koreksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Limbah'] = $this->M_limbah->getLimbah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/Limbah/V_Record', $data);
		$this->load->view('V_Footer',$data);
	}

	function sendMail($action){ 

		$this->load->library('PHPMailerAutoload');

		if($action == 'edit') {
			$keterangan = 'mengubah';
		} elseif($action == 'create') {
			$keterangan = 'menambahkan';
		} elseif($action == 'delete') {
			$keterangan = 'menghapus';
		}

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

        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$message 	= '	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://wwwhtml4/loose.dtd">
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
				
					<p> Admin WM telah <b>'.$keterangan.'</b> data <b>Limbah Koreksi</b>
					</p>
					<hr/>
					<p>
					Salam,
					<br/>
					<br/>
					<br/>
					<b style="text-decoration: underline;">Pengelola</b>
					<br/>
					</p>
					
				</body>
				</html>';
		
        $mail->setFrom('noreply@quick.com', 'Email Sistem');
        $mail->addAddress('ayu_rakhmadani@quick.com','Ayu Rakhmadani');
        $mail->addAddress('aljir_arafat@quick.com','Aljir Arafat');
        $mail->addAddress('arina_salma@quick.com','Arina Salma Rosyidah');
        $mail->Subject = 'Waste Management';
		$mail->msgHTML($message);
		
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		} else {
			redirect(base_url('WasteManagement/Limbah'));
		}
	}
}

/* End of file C_Limbah.php */
/* Location: ./application/controllers/WasteManagement/MainMenu/C_Limbah.php */
/* Generated automatically on 2017-07-31 10:47:07 */