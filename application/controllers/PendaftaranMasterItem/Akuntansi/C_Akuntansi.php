<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Akuntansi extends CI_Controller
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
		$this->load->model('PendaftaranMasterItem/M_request');
		$this->load->model('PendaftaranMasterItem/M_settingdata');

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

		$data['Title'] = 'Monitoring Akuntansi';
		$data['Menu'] = 'Request Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['view'] = 'Akuntansi';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PendaftaranMasterItem/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getExpAcc(){
		$term = $this->input->get('term',TRUE);
		// $term = strtoupper($term);
		$data = $this->M_request->getExpAcc($term);
		echo json_encode($data);
	}

	public function modalDetail(){
		$no 					= $this->input->post('no');
		$data['ket'] 			= $this->input->post('ket');
		$header['no_dokumen'] 	= $this->input->post('nodoc');
		$header['seksi'] 		= $this->input->post('seksi');
		$header['tgl'] 			= $this->input->post('tgl');
		$header['status'] 		= $this->input->post('status');

		$getdata = $this->M_request->getdatafull('and kpr.id_request = '.$no.' order by kpr.id_item');
		foreach ($getdata as $key => $val) {
			$org = $this->M_request->dataOrgAssign($val['ID_ITEM']); //cari org assign
			$org_assign = '';
			for ($i=0; $i < count($org) ; $i++) { 
				$org_assign .= $i == 0 ? $org[$i]['ORG_ASSIGN'] : '; '.$org[$i]['ORG_ASSIGN'];
			}
			$getdata[$key]['ORG_ASSIGN'] = $org_assign;
		}
		$data['data'] 	= $getdata;
		$data['header'] = $header;
		$this->load->view('PendaftaranMasterItem/V_DetailAkuntansi', $data);
	}

	public function submitAkuntansi(){
		$no_doc 	= $this->input->post('no_document');
		$id_item 	= $this->input->post('id_item[]');
		$item 		= $this->input->post('item[]');
		$desc 		= $this->input->post('desc[]');
		$status 	= $this->input->post('status[]');
		$make_buy 	= $this->input->post('make_buy[]');
		$inv 		= $this->input->post('inv_value[]');
		$exp 		= $this->input->post('exp_acc[]');
		$comment	= $this->input->post('comment[]');
		$tgl 		= gmdate("d/m/Y H:i:s", time()+60*60*7);
		$pic 		= $this->session->user;
		$kirim 		= 'PIEA'; // tujuan kirim awal
		for ($i=0; $i < count($id_item); $i++) { 
			$cek= $this->M_request->dataAkuntansi($id_item[$i]); // cek data sudah disave / belum
			if (empty($cek)) { // data belum disave
				if ($make_buy[$i] != 'MAKE' || $status[$i] != 'R') {
					$kirim = 'Pembelian'; // jika ada make_buy = MAKE tujuan kirim jadi Pembelian
				}else {
					$kirim = $kirim; // tujuan kirim tetap
				}
				$this->M_request->saveAkuntansi($id_item[$i], $inv[$i], $exp[$i], $tgl, $pic, $comment[$i]);
			}
		}
		$update_status = $this->M_request->updateHeader($no_doc, 'Pengecekan '.$kirim.'');
		// echo "<pre>";print_r($kirim);exit();
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
		//cari email berdasarkan tujuan kirim
		$email = $this->M_settingdata->dataEmail("where username = '$kirim'");
		foreach ($email as $a) {
			$mail->addAddress($a['EMAIL']);   
			// echo $a['email'];    
		}
		
		$isi ='';
		$isi .= '<h4>PENDAFTARAN MASTER ITEM</h4>
				<b>No Dokumen : '.$no_doc.'</b><br><br>';
		for ($i=0; $i < count($id_item) ; $i++) {
			if ($status[$i] == 'P') {
				$sts = 'Pendaftaran Baru';
			}elseif ($status[$i] == 'R') {
				$sts = 'Revisi';
			}elseif ($status[$i] == 'I') {
				$sts = 'Inactive';
			}
			
			if ($kirim == 'Pembelian') { // tujuan kirim ke pembelian
				if ($make_buy[$i] != 'MAKE' || $status[$i] != 'R') {
					$isi .= '<b>Status : </b>'.$sts.'<br>';
					$isi .= '<b>Kode Item : </b>'.$item[$i].'<br>';
					$isi .= '<b>Deskripsi : </b>'.$desc[$i].'<br><br>';
				}
			}else { // tujuan kirim ke piea
				$isi .= '<b>Status : </b>'.$sts.'<br>';
				$isi .= '<b>Kode Item : </b>'.$item[$i].'<br>';
				$isi .= '<b>Deskripsi : </b>'.$desc[$i].'<br><br>';
			}
		}
		
		$mail->Subject = 'Pendaftaran Master Item';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!..<br>";
		}
		redirect(base_url('MasterItemAkuntansi/Request/'));
	}


}