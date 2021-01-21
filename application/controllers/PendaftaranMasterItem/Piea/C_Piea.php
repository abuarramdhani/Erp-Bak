<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Piea extends CI_Controller
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

		$data['Title'] = 'Monitoring PIEA';
		$data['Menu'] = 'Request Master Item';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['view'] = 'PIEA';
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
		foreach ($getdata as $key => $val) {		
			$org = $this->M_request->dataOrgAssign($val['ID_ITEM']); //cari org assign
			$org_assign = '';
			$template = array();
			for ($i=0; $i < count($org) ; $i++) { 
				$org_assign .= $i == 0 ? $org[$i]['ORG_ASSIGN'] : '; '.$org[$i]['ORG_ASSIGN']; // susun org assign
				// cari template
				$temp = $this->getTemplate($val['KODE_ITEM'], $val['MAKE_BUY'], $val['STOK'], $val['NO_SERIAL'], $val['INSPECT_AT_RECEIPT'], $val['ODM'], $val['OPM'], $val['JUAL'], $val['INV_VALUE'], $org[$i]['ORG_ASSIGN']);
				if ($temp != 'TEMPLATE TIDAK DITEMUKAN') {
					array_push($template, $temp);
				}
			}
			$getdata[$key]['ORG_ASSIGN'] = $org_assign;
			if (count($template) > 1) { // template yang ditemukan > 1
				$getdata[$key]['TEMPLATE'] 	= $template[0] == $template[1] ? $template[0] : 'TEMPLATE DOUBLE';
			}elseif(count($template) == 1) { // template ditemukan 1
				$getdata[$key]['TEMPLATE'] 	= $template[0];
			}else { // template tidak ditemukan
				$getdata[$key]['TEMPLATE'] 	= 'TEMPLATE TIDAK DITEMUKAN';
			}
		}
		$data['data'] = $getdata;
		$data['header'] = $header;
		$this->load->view('PendaftaranMasterItem/V_DetailPIEA', $data);
	}

	public function getTemplate($kodeitem, $mb, $stok, $serial, $inspect, $odm, $opm, $jual, $inv, $org){
		if (substr($kodeitem,0,1) == 'D') {
			$remark = 1;
		}elseif (substr($kodeitem, 0,1) == 'N') {
			if (substr($kodeitem,0,3) == 'NEF') {
				$remark = 2;
			}else {
				$remark = 3;
			}
		}else {
			$remark = 0;
		}
		// cari template
		$template = $this->M_request->template($mb, $stok, $serial, $inspect, $odm, $opm, $jual, $inv, $org);
		// echo "<pre>";print_r($template); exit();
		if (sizeof($template) > 1) { // template lebih dari 1
			if (sizeof($template) == 2 && $template[0]['TEMPLATE'] == $template[1]['TEMPLATE']) { // template sama
				$tmp = $template[0]['TEMPLATE'];
			}else { // template beda
				if ($mb == 'BUY' && $stok == 'N' && $serial == 'N' && $inspect == 'N' && $odm == '' && $opm == '' && $jual == '' && $inv == 'No' && $org == 'EXP') {
					if ($remark == 3) {
						$tmp = 'KHS Asset';
					}else {
						$tmp = 'KHS Expense';
					}
				}elseif ($mb == 'MAKE' && $stok == 'N' && $serial == 'N' && $inspect == 'N' && $odm == '' && $opm == '' && $jual == '' && $inv == 'No') {
					if ($remark == 3 && $org == 'EXP') {
						$tmp = 'KHS Asset';
					}elseif ($remark == 2 && $org == 'EXP') {
						$tmp = 'KHS Alat Bantu';
					}else {
						$tmp = 'TEMPLATE TIDAK DITEMUKAN';
					}
				}elseif ($mb == 'MAKE' && $stok == 'Y' && $serial == 'N' && $inspect == 'N' && $odm == '' && $opm == '' && $jual == 'Y' && $inv == 'Yes' && $org == 'ODM') {
					if ($remark == 1) {
						$tmp = 'KHS Barang Bekas dan Afval';
					}else {
						$tmp = 'KHS FG Spart Jual NonSerialODM';
					}
				}else {
					$tmp = 'TEMPLATE DOUBLE';
				}
			}
		}elseif (sizeof($template) < 1) { // template tidak ditemukan
			$tmp = 'TEMPLATE TIDAK DITEMUKAN';
		}else { // template ada
			$tmp = $template[0]['TEMPLATE'];
		}
		return $tmp;
	}


	public function submitPIEA(){
		$no_doc 	= $this->input->post('no_document');
		$id_req 	= $this->input->post('id_request[]');
		$status 	= $this->input->post('status[]');
		$id_item 	= $this->input->post('id_item[]');
		$item 		= $this->input->post('item[]');
		$desc		= $this->input->post('desc[]');
		$template	= $this->input->post('template[]');
		$action		= $this->input->post('action[]');
		$tgl 		= gmdate("d/m/Y H:i:s", time()+60*60*7);
		$pic 		= $this->session->user;
		for ($i=0; $i < count($id_item); $i++) { 
			$cek= $this->M_request->dataPIEA($id_item[$i]); // cek data sudah disave / belum
			if (empty($cek)) {
				$this->M_request->savePIEA($id_item[$i], $template[$i], $action[$i], $tgl, $pic);
			}
		}
		$update_status = $this->M_request->updateHeader($no_doc, 'Finished');
		// kirim email ke requester pendaftaran master item
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
		$head = $this->M_request->cekheader('where id_request = '.$id_req[0].''); // cari pic requester
		$email = $this->M_settingdata->dataEmail("where username = '".$head[0]['PIC']."'"); // cari email requester
		foreach ($email as $a) {
			$mail->addAddress($a['EMAIL']);   
			// echo $a['email'];    
		}
		
		$isi = '<h4>PENDAFTARAN MASTER ITEM</h4>
				<b>No Dokumen : '.$head[0]['NO_DOKUMEN'].'</b><br><br>';
		for ($i=0; $i < count($id_item) ; $i++) {
			if ($status[$i] == 'P') {
				$sts = 'Pendaftaran Baru';
			}elseif ($status[$i] == 'R') {
				$sts = 'Revisi';
			}elseif ($status[$i] == 'I') {
				$sts = 'Inactive';
			}
			$color = $action[$i] == 'ACCEPT' ? 'green' : 'red';
			$finish = $action[$i] == 'ACCEPT' ? 'OK' : 'NOT OK';
			
			$isi .= '<b>Status : </b>'.$sts.'<br>';
			$isi .= '<b>Kode Item : </b>'.$item[$i].'<br>';
			$isi .= '<b>Deskripsi : </b>'.$desc[$i].'<br>';
			$isi .= '<b>Finished  : <span style="color:'.$color.'">'.$finish.'</span></b><br><br>';
		}
		
		$mail->Subject = 'Pendaftaran Master Item';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!..<br>";
		}
		redirect(base_url('MasterItemPIEA/Request/'));
	}
}

