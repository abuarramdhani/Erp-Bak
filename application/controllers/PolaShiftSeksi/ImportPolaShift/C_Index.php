<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('KonversiBulan');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PolaShiftSeksi/ImportPolaShift/M_index');
		$this->load->model('PolaShiftSeksi/Approval/M_approval');
		$this->load->model('PermohonanCuti/M_permohonancuti');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Import Pola Shift';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['listImpShift'] = $this->M_index->listImpShift($kodesie, $no_induk);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/ImportPolaShift/V_Table_List', $data);
		$this->load->view('V_Footer',$data);

	}

	public function addImShift()
	{
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		// echo "<pre>";
		// print_r($user_id);exit();

		$data['Title'] = 'Import Pola Shift';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/ImportPolaShift/V_Index', $data);
		$this->load->view('V_Footer',$data);

	}

	public function daftar_seksi()
	{
		$keyword 	 	=	strtoupper($this->input->get('term', TRUE));
		$tseksi			=	$this->M_index->tseksi($keyword);
		echo json_encode($tseksi);
	}

	public function DocumentProcess()
	{
		$PeriodeShift			=	$this->input->post('periodeshift');
		$KodeSeksi				=	$this->input->post('kodeseksi');
		$ImportDocument			=	$this->input->post('importdocument');
		$noind     				=	$this->session->user;
		$kodesie 				=	$this->session->kodesie;

		$data['pr'] = $PeriodeShift;
		// $data['ks'] = $KodeSeksi;
		// $data['seksi']	=	$this->M_index->tseksi($KodeSeksi);
		$tgl_akhir =  date("t", strtotime($PeriodeShift.'-01'));
		// echo "<pre>"; print_r($PeriodeShift); echo "<pre>"; print_r($KodeSeksi); echo "<pre>";print_r($ImportDocument); exit();

		if (empty($_FILES)) {
			echo "Dokumen File tidak dapat di temukan";
			exit();
		}
		$file = $_FILES['importdocument']['tmp_name'];
		// echo $file;
		$this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
		$objPHPExcel = PHPExcel_IOFactory::createReaderForFile($file);
		// $objPHPExcel = new PHPExcel();
		$objPHPExcel->setReadDataOnly(true);

		$inputFileType = PHPExcel_IOFactory::identify($file);
	    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	    // $objPHPExcel = $objReader->load($inputFileName);

		$objPHPExcel = $objPHPExcel->load($file);
		// exit();
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$readData = array();
		$tmpData = array();
		$head = array();
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle = $worksheet->getTitle();
			$highestRow = $worksheet->getHighestRow();
			$highestColumn =  $worksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

			for ($col=2; $col <= $highestColumnIndex-1 ; $col++) {
				$cell = $worksheet->getCellByColumnAndRow($col, 1);
				$head[] = $cell->getValue();
			}

			// get isi
			for ($row=2; $row <= $highestRow ; $row++) {
				$val = array();
				for ($col=0; $col <= $highestColumnIndex-1 ; $col++) {
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					if ($col == 0) {
						$val['noind']= $cell->getValue();
					}elseif ($col == 1) {
						$val['nama']= $cell->getValue();
					}else{
						$val['shift'][]= $cell->getValue();
					}
				}
			$hmm[] = $val;
			}
		}
		$data['document'] = $hmm;
		$data['head'] = $head;

		$arrListN = array_column($hmm, 'noind');
		$listNoind = implode("', '",  $arrListN);
		$gPkjShift = $this->M_index->getPkjShift($listNoind, $PeriodeShift);
		foreach ($gPkjShift as $gp) {
			// echo $gp['noind'];
			if (($key = array_search(rtrim($gp['noind']), $arrListN )) !== false) {
				unset($arrListN[$key]);
			}
		}
		
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;
		$no_induk = $this->session->user;

		$data['Title'] = 'Import Pola Shift';
		$data['Menu'] = 'Catering Management ';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		if (empty($gPkjShift)) {

			$data['gakDueSh'] = true;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PolaShiftSeksi/ImportPolaShift/V_Index', $data);
			$this->load->view('V_Footer',$data);
		}else{
			$newArrNoind = array_column($hmm, 'nama', 'noind');
			$dataArr = array();
			foreach ($arrListN as $k) {
				$dataArr[] = $k.' - '.$newArrNoind[$k];
			}
			$data['gakDue'] = $arrListN;
			$data['singGakDue'] = $dataArr;
			$approval1 = $this->M_permohonancuti->getApproval($noind, $kodesie);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PolaShiftSeksi/ImportPolaShift/V_Process', $data);
			$this->load->view('V_Footer',$data);
		}

	
	}

	public function save_ods()
	{
		$no_induk = $this->session->user;
		$tgl = $this->input->post('tgl');//32
		$noind = $this->input->post('noind');//14
		$shift = $this->input->post('shift');//14 // 32
		$pr = $this->input->post('pri');
		$ks = $this->input->post('kes');
		$atasan = $this->input->post('atasan');

		//kirim email ke atasan untuk notif
		$this->kirimEmail($atasan);

		$tgl_akhir =  date("t", strtotime($pr.'-01'));

		$max = count($tgl);
		$max_2 = count($noind);
		// $max_3 = count($shift);
		$pr_ex = explode('-', $pr);
		$m = $pr_ex[1];
		$y = $pr_ex[0];
		
		$start = 0; // untuk nentuin tanggal 1 nya atau lebih misal arr[0] nilainya 30 misal
		foreach ($tgl as $key) {
			if ($key == 1) {
				break;
			}
			$start++;
		}

		$now = date('Y-m-d H:i:s');

		for ($i=0; $i < $max_2; $i++) {
			$kodesie = $this->M_index->getKS($noind[$i]);

			for ($j=0; $j < $max; $j++) {
				if (empty($shift[$i][$j]) || $shift[$i][$j] == '') {
					//nothing
				}else{
					if ($j < $start || $tgl[$j] > $tgl_akhir) { // nemuin tanggal ini hari berapa
						continue;
						// $bulan = $m-1;
						// $hari = date('l', strtotime($y.'-'.$bulan.'-'.$tgl[$j]));
					}else{
						$bulan = $m;
						$hari = date('l', strtotime($y.'-'.$bulan.'-'.$tgl[$j]));
					}
					$hari = $this->konversibulan->convert_Hari_Indonesia($hari);

					$ds = $this->M_index->detail_shift($hari, $shift[$i][$j]);
					if (empty($ds)) {
						exit();
					}

					$arr = array(
						'tanggal'				=>	$y.'-'.$bulan.'-'.$tgl[$j],
						'noind'					=>	$noind[$i],
						'kd_shift'				=>	$ds[0]['kd_shift'],
						'kodesie'				=>	$kodesie,
						'jam_msk'				=>	$ds[0]['jam_msk'],
						'jam_akhmsk'			=>	$ds[0]['jam_akhmsk'],
						'jam_plg'				=>	$ds[0]['jam_plg'],
						'break_mulai'			=>	$ds[0]['break_mulai'],
						'break_selesai'			=>	$ds[0]['break_selesai'],
						'ist_mulai'				=>	$ds[0]['ist_mulai'],
						'ist_selesai'			=>	$ds[0]['ist_selesai'],
						'jam_kerja'				=>	$ds[0]['jam_kerja'],
						'tgl_import'			=>	$now,
						'import_by'				=>	$no_induk,
						'atasan'				=>	$atasan,
						);
					// echo json_encode('waw');
					$ins = $this->M_index->insert_shift($arr);
				}
			}
		}	
	}

	public function daftar_atasan()
	{
		// $term = $this->input->get('term');
		$noind = $this->session->user;

		$atasan = $this->M_index->getAtasan($noind);
		$arr = array();
		if (!empty($atasan)) {
			$list = $atasan[0]['atasan_langsung'];
			$list = str_replace('{', '', $list);
			$list = str_replace('}', '', $list);
			$list = str_replace('"', '', $list);
			$list = explode(',', $list);
			foreach ($list as $key) {
				$exp = explode(' - ', $key);
				$arr[] = array(
					'noind'	=> $exp[0],
					'nama'	=> $exp[1]
					);
			}
		}

		echo json_encode($arr);
	}

	public function ViewList($ks,$pr,$tgl_imp)
	{
		$tgl_imp = str_replace('%20', '_', $tgl_imp);
		$no_induk = $this->session->user;
		$usr = substr($no_induk, 0,1);
		if ($usr == 'B' ||$usr == 'D' ||$usr == 'J' || $no_induk == 'T0007') {
			//oke
		}else{
			echo "Access Denied";
			echo "<br>Anda akan kembali ke Halaman utama dalam 5 detik";
			header( "refresh:5;url=".base_url('PolaShiftSeksi') );
			exit();
		}
		//dari ERP
		$tgl_imp = str_replace('_', ' ', $tgl_imp);
		$data['tgl_imp'] = $tgl_imp;
		$detail = $this->M_approval->getDetail($ks, $pr,$tgl_imp);
		if (empty($detail)) {
			echo 'data kosong';exit();
		}
		$distintPekerja = $this->M_approval->getPkjDist($ks, $pr, $tgl_imp);
		$newArrPerPkj = array();
		$daftarNoind = array();
		foreach ($distintPekerja as $key) {
			$val = array();
			$daftarNoind[] = $key['noind'];
			$val['noind'] = $key['noind'];
			$val['nama'] = $key['employee_name'];
			foreach ($detail as $row) {
				if ($row['noind'] == $key['noind']) {
					$val['shift'][] = strtolower($row['inisial']);
					$val['tgl'][] = intval(substr($row['tanggal'], 8,2));
				}
			}
			$newArrPerPkj[] = $val;
		}
		$data['arrayPkj'] = $newArrPerPkj;

		// echo "<pre>";
		// print_r($newArrPerPkj);exit();

		//Dari Personalia
		$noinduk = implode("','", $daftarNoind);
		$data['arrayJav'] = "['".$noinduk."']";
		$detailP = $this->M_approval->getDetailPersonalia($ks, $pr);
		$distintPekerjaP = $this->M_approval->getPkjDistPersonalia($ks, $pr, $noinduk);
		$newArrPerPkjP = array();
		foreach ($distintPekerjaP as $k) {
			$valP = array();
			$valP['noind'] = $k['noind'];
			$valP['nama'] = $k['nama'];
			foreach ($detailP as $r) {
				if ($r['noind'] == $k['noind']) {
					$valP['shift'][] = strtolower($r['inisial']);
					$valP['tgl'][] = intval(substr($r['tanggal'], 8,2));
				}
			}
			$newArrPerPkjP[] = $valP;
		}
		$data['arrayPkjP'] = $newArrPerPkjP;

		$data['tgl_akhir'] =  date("t", strtotime($pr.'-01'));
		$user = $this->session->username;
		$this->checkSession();
		$user_id = $this->session->userid;

		$stz = $this->M_index->listImpShiftUniq($ks, $pr, $tgl_imp);
		$hari = date('d-M-Y', strtotime($stz[0]['tgl_approve']));

		if (!empty($stz[0]['alasan'])) {
			$data['calaut'] = 'callout callout-danger';
			$data['pesan'] = '<label>Rejected</label><p>Data Shift ini telah di Reject pada tanggal '.$hari.' dengan alasan 
								"'.$stz[0]['alasan'].'"</p>';
		}elseif (!empty($stz[0]['tgl_approve'])) {
			$data['calaut'] = 'callout callout-success';
			$data['pesan'] = '<label>Approved</label><p>Data Shift ini telah di Approve pada tanggal '.$hari.' </p>';
		}else{
			$data['calaut'] = 'callout callout';
			$data['pesan'] = '<label>Pending</label><p>Data Shift ini masih menunggu approval</p>';
		}

		$data['seksi']	=	$this->M_index->tseksi($ks);
		$data['kode_seksi']	= $ks;
		$data['periode'] =	$pr;

		$data['Title'] = 'Import Pola Shift';
		$data['Menu'] = 'Import Pola Shift';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PolaShiftSeksi/ImportPolaShift/V_View_Shift', $data);
		$this->load->view('V_Footer',$data);
	}

	function kirimEmail($noind)
	{
		$this->load->library('PHPMailerAutoload');
		$user = $this->session->user;
		$nama = $this->session->employee;
		$message = '<!DOCTYPE HTML">
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
						<h3 style="text-decoration: underline;">Approval Import Shift Seksi</h3>
					<hr style="height: 2px; background: black"/>
				
					<p>Kepada Yth Bapak / Ibu</p>
					<p>Kami informasikan bahwa '.$user.' - '.rtrim($nama).' telah melakukan request import shift dan membutuhkan approval dari Anda.</p>
					<p>Anda dapat melakukan pengecekan di link berikut :
					http://erp.quick.com/ atau klik <a href="http://erp.quick.com/" target="_blank">disini.</a></p>
					<p>
					Apabila ada kendala, silahkan hubungi seksi EDP (VoIP 15113).
					<br />
					Terima kasih.
					</p>
					
				</body>
				</html>';
		$emel = $this->M_index->getKS($noind, 'email_internal');
		// print_r($arr); exit();

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
        $mail->setFrom('noreply@quick.com', 'Pola SHift Seksi');
    	$mail->addAddress('enggal_aldiansyah@quick.com');
    	$mail->addAddress($emel);
        $mail->Subject = '!!! Approval Import Shift Seksi !!!';
		$mail->msgHTML($message);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		}
	}
}