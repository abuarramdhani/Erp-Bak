<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Pembelian extends CI_Controller
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

		$data['Title'] = 'Monitoring Seksi Pembelian';
		$data['Menu'] = 'Request Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['view'] = 'Pembelian';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PendaftaranMasterItem/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}

	public function modalDetail(){
		$no 					= $this->input->post('no');
		$data['ket'] 			= $this->input->post('ket');
		$header['no_dokumen'] 	= $this->input->post('nodoc');
		$header['seksi'] 		= $this->input->post('seksi');
		$header['tgl'] 			= $this->input->post('tgl');
		$header['status'] 		= $this->input->post('status');

		$getdata = $this->M_request->getdatafull('and kpr.id_request = '.$no.' order by kpr.id_item');
		$datanya = array();
		foreach ($getdata as $key => $val) {
			$org = $this->M_request->dataOrgAssign($val['ID_ITEM']); // cari org assign
			$org_assign = '';
			for ($i=0; $i < count($org) ; $i++) { 
				$org_assign .= $i == 0 ? $org[$i]['ORG_ASSIGN'] : '; '.$org[$i]['ORG_ASSIGN'];
			}
			$getdata[$key]['ORG_ASSIGN'] = $org_assign;

			// data tambahan
			if ($data['ket'] == 'needpembelian' && $val['STATUS_REQUEST'] != 'R' && ($val['MAKE_BUY'] != 'MAKE')) { // untuk tabel needed pembelian
				$item = $val['ITEM_FIX'];
				$getdata[$key]['APPROVER'] = $this->approve($item);
				$getdata[$key]['PEMBELIAN'] = $this->M_request->getApprovePembelian($val['ITEM_FIX']);
			}
			array_push($datanya, $getdata[$key]);
		}
		$data['data'] = $datanya;
		$data['header'] = $header;
		// echo "<pre>";print_r($data);exit();
		$this->load->view('PendaftaranMasterItem/V_DetailPembelian', $data);
	}

	public function approve($item){ // pic approve berdasarkan item
		$kode = substr($item,0,1);
		if ($kode == 'N' || $kode == 'Q') {
			$approve = 'DRS. HENDRO WIJAYANTO';
		}elseif ($kode == 'G' || $kode == 'H' || $kode == 'I' || $kode == 'J') {
			if ($kode == 'J') {
				$kode = substr($item,0,4);
				if ($kode == 'JANG') {
					$approve = 'HARUN ALRASYID';
				}elseif ($kode == 'JASA') {
					$kode = substr($item,0,6);
					if ($kode == 'JASA01') {
						$approve = 'HARUN ALRASYID';
					}else {
						$approve = 'RIA CAHYANI';
					}
				}else {
					$approve = 'RIA CAHYANI';
				}
			}else{
				$approve = 'HARUN ALRASYID';
			}
		}elseif ($kode == 'L' || $kode == 'P' || $kode == 'S') {
			$approve = 'RIA CAHYANI';
		}else {
			$approve = 'SUGENG SUTANTO';
		}
		return $approve;
	}

	public function getBuyer(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getBuyer($term);
		echo json_encode($data);
	}
	
	public function getApproval(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getApprover($term);
		echo json_encode($data);
	}

	public function submitpembelian(){
		$no_dokumen 	= $this->input->post('no_dokumen');
		$id_request 	= $this->input->post('id_request[]');
		$id_item 		= $this->input->post('id_item[]');
		$buyer 			= $this->input->post('buyer[]');
		$pre_proses 	= $this->input->post('pre_process[]');
		$preparation 	= $this->input->post('preparation[]');
		$delivery 		= $this->input->post('delivery[]');
		$total_proses 	= $this->input->post('total_process[]');
		$post_proses 	= $this->input->post('post_process[]');
		$total_lead 	= $this->input->post('total_lead[]');
		$moq 			= $this->input->post('moq[]');
		$flm 			= $this->input->post('flm[]');
		$approver 		= $this->input->post('approver[]');
		$keterangan 	= $this->input->post('ket[]');
		$receive 		= $this->input->post('receive_close[]');
		$tolerance 		= $this->input->post('tolerance[]');
		$comment 		= $this->input->post('comment[]');
		$tgl 			= gmdate("d/m/Y H:i:s", time()+60*60*7);
		$pic 			= $this->session->user;
		// echo "<pre>";print_r($id_item);exit();
		for ($i=0; $i < count($id_item) ; $i++) { 
			$cek = $this->M_request->dataPembelian($id_item[$i]); // cek data sudah disave / belum
			if (empty($cek)) {
				$this->M_request->savePembelian($id_item[$i], $buyer[$i], $pre_proses[$i], $preparation[$i], $delivery[$i], $total_proses[$i], $post_proses[$i],
				$total_lead[$i], $moq[$i], $flm[$i], $approver[$i], $keterangan[$i], $receive[$i], $tolerance[$i], $tgl, $pic, $comment[$i]);
			}
		}
		$update_status = $this->M_request->updateHeader($no_dokumen, 'Pengecekan PIEA');
		// kirim email ke piea
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
		//cari email
		$email = $this->M_settingdata->dataEmail("where username = 'PIEA'");
		foreach ($email as $a) {
			$mail->addAddress($a['EMAIL']);   
			// echo $a['email'];    
		}
		
		$isi = '<h4>PENDAFTARAN MASTER ITEM</h4>
				<b>No Dokumen : '.$no_dokumen.'</b><br><br>';
		$datanya = $this->M_request->getdatafull("and kpr.id_request = '".$id_request[0]."'");
		for ($i=0; $i < count($datanya) ; $i++) {
			if ($datanya[$i]['STATUS_REQUEST'] == 'P') {
				$sts = 'Pendaftaran Baru';
			}elseif ($datanya[$i]['STATUS_REQUEST'] == 'R') {
				$sts = 'Revisi';
			}elseif ($datanya[$i]['STATUS_REQUEST'] == 'I') {
				$sts = 'Inactive';
			}
			$isi .= '<b>Status : </b>'.$sts.'<br>';
			$isi .= '<b>Kode Item : </b>'.$datanya[$i]['ITEM_FIX'].'<br>';
			$isi .= '<b>Deskripsi : </b>'.$datanya[$i]['DESC_FIX'].'<br><br>';
			
		}
		
		$mail->Subject = 'Pendaftaran Master Item';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!..<br>";
		}
		redirect(base_url('MasterItemPembelian/Request/'));
	}


}