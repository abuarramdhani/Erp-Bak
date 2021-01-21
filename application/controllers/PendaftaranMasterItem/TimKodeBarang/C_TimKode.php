<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TimKode extends CI_Controller
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

		$data['Title'] = 'Monitoring Tim Kode Barang';
		$data['Menu'] = 'Request Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['view'] = 'TimKode';
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PendaftaranMasterItem/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getItem(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$ket = 'tidak'; // ket awal berarti kode item belum digunakan
		$data = $this->M_request->getNamaBarang("AND msib.segment1 = '$term'");
		$ket = !empty($data) ? 'ada' : $ket; // jika sudah ada di msib ket berubah jadi 'ada', kalau tidak ket tidak berubah
		$data2 = $this->M_request->dataItem("where kode_item = '".$term."'");
		$ket = !empty($data2) ? 'ada' : $ket;  // jika sudah didaftarkan di master item sebelumnya ket berubah jadi 'ada', kalau tidak ket tidak berubah
		// echo "<pre>";print_r($data);exit();
		echo json_encode($ket);
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
			$org = $this->M_request->dataOrgAssign($val['ID_ITEM']); // cari org assign
			$org_assign = '';
			for ($i=0; $i < count($org) ; $i++) { 
				$org_assign .= $i == 0 ? $org[$i]['ORG_ASSIGN'] : '; '.$org[$i]['ORG_ASSIGN'];
			}
			$getdata[$key]['ORG_ASSIGN'] = $org_assign;
			$getdata[$key]['ITEM'] 	= !empty($val['REV_KODE']) && $val['REV_KODE'] != '-' ? $val['REV_KODE'] : '-';
			$getdata[$key]['DESC'] 	= !empty($val['REV_DESC']) && $val['REV_DESC'] != '-' ? $val['REV_DESC'] : '-';
		}
		$data['data'] = $getdata;
		$data['header'] = $header;
		$this->load->view('PendaftaranMasterItem/V_DetailTimKode', $data);
	}

	public function submitTimKode(){
		$no_document 	= $this->input->post('no_document');
		$status 		= $this->input->post('status[]');
		$id_item 		= $this->input->post('id_item[]');
		$kode_item 		= $this->input->post('kode_item[]');
		$desc_item 		= $this->input->post('desc_item[]');
		$revisi_kode 	= $this->input->post('revisi_kode[]');
		$revisi_desc 	= $this->input->post('revisi_desc[]');
		$tgl 			= gmdate("d/m/Y H:i:s", time()+60*60*7);
		$pic 			= $this->session->user;
		$update_status 	= $this->M_request->updateHeader($no_document, 'Pengecekan Akuntansi');
		for ($i=0; $i < count($id_item); $i++) { 
			$cek = $this->M_request->dataTimKode($id_item[$i]);
			if (empty($cek)) {
				$item = strtoupper($revisi_kode[$i]);
				$desc = strtoupper($revisi_desc[$i]);
				$this->M_request->saveTimkode($id_item[$i], $item, $desc, $tgl, $pic);
			}
		}
		// kirim email ke akuntansi
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
		$email = $this->M_settingdata->dataEmail("where username = 'Akuntansi'");
		foreach ($email as $a) {
			$mail->addAddress($a['EMAIL']);   
			// echo $a['email'];    
		}
		
		$isi ='';
		$isi .= '<h4>PENDAFTARAN MASTER ITEM</h4>
				<b>No Dokumen : '.$no_document.'</b><br><br>';
		for ($i=0; $i < count($id_item) ; $i++) {
			if ($status[$i] == 'P') {
				$sts = 'Pendaftaran Baru';
			}elseif ($status[$i] == 'R') {
				$sts = 'Revisi';
			}elseif ($status[$i] == 'I') {
				$sts = 'Inactive';
			}
			// cek revisi kode barang dan deskripsi
			$kode = $revisi_kode[$i] != '-' ? $revisi_kode[$i] : $kode_item[$i];
			$desc = $revisi_desc[$i] != '-' ? $revisi_desc[$i] : $desc_item[$i];

			$isi .= '<b>Status : </b>'.$sts.'<br>';
			$isi .= '<b>Kode Item : </b>'.$kode.'<br>';
			$isi .= '<b>Deskripsi : </b>'.$desc.'<br><br>';
		}
		
		$mail->Subject = 'Pendaftaran Master Item';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!..<br>";
		}
		redirect(base_url('MasterItemTimKode/Request/'));
	}


}