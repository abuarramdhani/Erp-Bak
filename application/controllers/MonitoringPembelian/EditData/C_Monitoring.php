<?php if (!(defined('BASEPATH'))) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
{	
	public function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	       	$this->load->library('PHPMailerAutoload');
	        $this->load->library('csvimport');
	        $this->load->library('Pdf');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MonitoringPembelian/Monitoring/M_monitoring');
			  
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
		$data['EmailPembelian'] = $this->M_monitoring->getdataEmailPembelian();
		$data['EmailPE'] = $this->M_monitoring->getdataEmailPE();
		$data['Monitoring']  = array();
	
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPembelian/Monitoring/V_Monitoring',$data);
		$this->load->view('V_Footer',$data);

	}	

	function SaveUpdatePembelian(){
		$id = $this->regen();
		$date = $this->input->post('date');
		$itemCode = $this->input->post('itemCode');
		$description = $this->input->post('desc');
		$uom1 = $this->input->post('uom1');
		$uom2 = $this->input->post('uom2');
		$fullname = $this->input->post('per1');
		$preproc = $this->input->post('preProc');
		$ppo = $this->input->post('ppo');
		$deliver = $this->input->post('deliver');
		$totproc = $this->input->post('totProc');
		$postproc = $this->input->post('postProc');
		$totlead = $this->input->post('totLead');
		$moq = $this->input->post('moq');
		$flm = $this->input->post('flm');
		$attr18 = $this->input->post('attr18');
		$stat = $this->input->post('stat');
		$keterangan = $this->input->post('keterangan');
		$receive_close_tolerance = $this->input->post('receive_close_tolerance');
		$qty_rcv_tolerance = $this->input->post('qty_rcv_tolerance');
		$email = $this->input->post('EmailPE[]');
		$cetak = '0';

		$tahun = date('y');
		$bulan = date('m');
		$updateid = 'PA'.$tahun.$bulan.$id;
		$semua  = array();
		for ($i=0; $i < sizeof($itemCode) ; $i++) { 
			$data = array(
				'UPDATE_ID' => $updateid,
				'UPDATE_DATE' => $date[$i],
				'SEGMENT1' 	=> $itemCode[$i],
				'DESCRIPTION' 	=> $description[$i],
				'PRIMARY_UOM_CODE' 	=> $uom1[$i],
				'SECONDARY_UOM_CODE' 	=> $uom2[$i],
				'FULL_NAME' 	=> $fullname[$i],
				'PREPROCESSING_LEAD_TIME' 	=> $preproc[$i],
				'PREPARATION_PO' 	=> $ppo[$i],
				'DELIVERY' 	=> $deliver[$i],
				'FULL_LEAD_TIME'	=> $totproc[$i],
				'POSTPROCESSING_LEAD_TIME'	=> $postproc[$i],
				'TOTAL_LEADTIME'	=> $totlead[$i],
				'MINIMUM_ORDER_QUANTITY'	=> $moq[$i],
				'FIXED_LOT_MULTIPLIER'	=> $flm[$i],
				'ATTRIBUTE18'	=> $attr18[$i],
				'STATUS' => $stat[$i],
				'KETERANGAN' => $keterangan[$i],
				'RECEIVE_CLOSE_TOLERANCE' => $receive_close_tolerance[$i],
				'QTY_RCV_TOLERANCE' => $qty_rcv_tolerance[$i],
				'CETAK' => $cetak 
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

       	$isi = '<h4>REQUEST PERUBAHAN DATA (ID = '.$updateid.')</h4>';
       	foreach ($semua as $dt) {
	       		$isi .= '<b>Item Code : </b>'.$dt['SEGMENT1'].'<br>';
	       		$isi .= '<b>Description : </b>'.$dt['DESCRIPTION'].'<br>';
	       		$isi .= '<b>Keterangan : </b>'.$dt['KETERANGAN'].'<br><br>';
		}

		$mail->Subject = 'Request Perubahan Data ('.$updateid.')';
		$mail->msgHTML($isi);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!..<br>";
		}
		// echo "<pre>";
		// print_r($email);
		// exit();

		$this->M_monitoring->savePerubahan($semua);
		redirect('MonitoringPembelian/Monitoring');
	}

	function SaveUpdatePembelianCSV(){
		$id = $this->regen();
		$date = date("d-M-y");
		$itemCode = $this->input->post('seg1');
		$description = $this->input->post('desc');
		$uom1 = $this->input->post('uom1');
		$uom2 = $this->input->post('uom2');
		$fullname = $this->input->post('fullname');
		$preproc = $this->input->post('preproc');
		$ppo = $this->input->post('prepo');
		$deliver = $this->input->post('deliv');
		$postproc = $this->input->post('posproc');
		$moq = $this->input->post('moq');
		$flm = $this->input->post('flm');
		$attr18 = $this->input->post('attr18');
		$stat = $this->input->post('stat');
		$keterangan = $this->input->post('keterangan');
		$receive_close_tolerance = $this->input->post('receive_close_tolerance');
		$qty_rcv_tolerance = $this->input->post('qty_rcv_tolerance');
		$email = $this->input->post('EmailPE[]');
		$cetak = '0';

		$bulan = date('m');
		$tahun = date('y');
		$updateid = 'PA'.$tahun.$bulan.$id;

		$semua  = array();
		for ($i=0; $i < sizeof($itemCode) ; $i++) { 
			$data = array(
				'UPDATE_ID' => $updateid,
				'UPDATE_DATE' => $date,
				'SEGMENT1' 	=> $itemCode[$i],
				'DESCRIPTION' 	=> $description[$i],
				'PRIMARY_UOM_CODE' 	=> $uom1[$i],
				'SECONDARY_UOM_CODE' 	=> $uom2[$i],
				'FULL_NAME' 	=> $fullname[$i],
				'PREPROCESSING_LEAD_TIME' 	=> $preproc[$i],
				'PREPARATION_PO'	=> $ppo[$i],
				'DELIVERY'	=> $deliver[$i],
				'FULL_LEAD_TIME'	=> $ppo[$i]+$deliver[$i] ,
				'POSTPROCESSING_LEAD_TIME'	=> $postproc[$i],
				'TOTAL_LEADTIME'	=> $preproc[$i] + $ppo[$i] + $deliver[$i] + $postproc[$i],
				'MINIMUM_ORDER_QUANTITY'	=> $moq[$i],
				'FIXED_LOT_MULTIPLIER'	=> $flm[$i],
				'ATTRIBUTE18'	=> $attr18[$i],
				'STATUS' => $stat[$i],
				'KETERANGAN' => $keterangan[$i],
				'RECEIVE_CLOSE_TOLERANCE' => $receive_close_tolerance[$i],
				'QTY_RCV_TOLERANCE' => $qty_rcv_tolerance[$i],
				'CETAK' => $cetak
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
        
       	$isi = '<h4>REQUEST PERUBAHAN DATA (ID = '.$updateid.')</h4>';
       	foreach ($semua as $dt) {
	       		$isi .= '<b>Item Code : </b>'.$dt['SEGMENT1'].'<br>';
	       		$isi .= '<b>Description : </b>'.$dt['DESCRIPTION'].'<br>';
	       		$isi .= '<b>Keterangan : </b>'.$dt['KETERANGAN'].'<br><br>';
		}

		$mail->Subject = 'Request Perubahan Data (ID = '.$updateid.')';
		$mail->msgHTML($isi);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!..<br>";
		}

		// echo "<pre>";
		// print_r($email);
		// exit();

		$this->M_monitoring->savePerubahan($semua);
		redirect('MonitoringPembelian/Monitoring');
	}

	function suggestions()
	{
	   
	   $term = $this->input->get('term',TRUE);
	   $term = strtoupper($term);
	   $data = $this->M_monitoring->searchItem($term);
	   echo json_encode($data);
	}

	function getItemDetail(){
		$param = $this->input->post('params');
		// baris 
		$last = end($param);
		$data = $this->M_monitoring->searchItem($last);
		
		// select aprover
		$html_select = '';
		$Approver = $this->M_monitoring->getApprover();
		$ApproverN = $this->M_monitoring->getApproverN();
		$ApproverQ = $this->M_monitoring->getApproverQ();
		$ApproverG = $this->M_monitoring->getApproverG();
		$ApproverH = $this->M_monitoring->getApproverH();
		$ApproverI = $this->M_monitoring->getApproverI();
		$ApproverL = $this->M_monitoring->getApproverL();
		$ApproverP = $this->M_monitoring->getApproverP();
		$ApproverS = $this->M_monitoring->getApproverS();
		$ApproverR = $this->M_monitoring->getApproverR();
		$ApproverJ = $this->M_monitoring->getApproverJ();
		$ApproverJASA01 = $this->M_monitoring->getApproverJASA01();
		$ApproverJANG = $this->M_monitoring->getApproverJANG();
		$Approverlain = $this->M_monitoring->getApproverlain();
		// echo "<pre>";
		// print_r($Approver);
		// exit();
			if (substr($last, 0,1) == 'N') {
				$html_select .=  '<option selected="selected">'.$ApproverN['0']['FLEX_VALUE'].'</option>';
			} elseif (substr($last, 0,1) == 'Q') {
				$html_select .=  '<option selected="selected">'.$ApproverQ['0']['FLEX_VALUE'].'</option>';
			}elseif (substr($last, 0,1) == 'G') {
				$html_select .=  '<option selected="selected">'.$ApproverG['0']['FLEX_VALUE'].'</option>';
			}elseif (substr($last, 0,1) == 'H') {
				$html_select .=  '<option selected="selected">'.$ApproverH['0']['FLEX_VALUE'].'</option>';
			}elseif (substr($last, 0,1) == 'I') {
				$html_select .=  '<option selected="selected">'.$ApproverI['0']['FLEX_VALUE'].'</option>';
			}elseif (substr($last, 0,1) == 'L') {
				$html_select .=  '<option selected="selected">'.$ApproverL['0']['FLEX_VALUE'].'</option>';
			}elseif (substr($last, 0,1) == 'P') {
				$html_select .=  '<option selected="selected">'.$ApproverP['0']['FLEX_VALUE'].'</option>';
			}elseif (substr($last, 0,1) == 'S') {
				$html_select .=  '<option selected="selected">'.$ApproverS['0']['FLEX_VALUE'].'</option>';
			}elseif (substr($last, 0,1) == 'R') {
				$html_select .=  '<option selected="selected">'.$ApproverR['0']['FLEX_VALUE'].'</option>';
			}elseif ((substr($last, 0,1) == 'J') && (substr($last, 0,6) != 'JASA01') && (substr($last, 0,4) != 'JANG')) {
		    	$html_select .=  '<option selected="selected">'.$ApproverJ['0']['FLEX_VALUE'].'</option>';
		    }elseif (substr($last, 0,6) == 'JASA01') {
		    	$html_select .=  '<option selected="selected">'.$ApproverJASA01['0']['FLEX_VALUE'].'</option>';
		    }elseif (substr($last, 0,4) == 'JANG') {
		    	$html_select .=  '<option selected="selected">'.$ApproverJANG['0']['FLEX_VALUE'].'</option>';
		    }elseif ($last != NULL) {
		    	$html_select .=  '<option selected="selected">'.$Approverlain['0']['FLEX_VALUE'].'</option>';
		    }
		  
		  foreach($Approver as $name) {
				$html_select .= '<option value="'.$name['FLEX_VALUE'].'">'.$name['FLEX_VALUE'].'</option>';
		  }
		  // echo "<pre>";
		  // print_r($html_select);
		  // exit();
		  $data[0]['select'] = $html_select;
		  $html_select_buyer = '';
		  $buyer = $this->M_monitoring->getBuyer();

		  foreach($buyer as $b) {
		  	$html_select_buyer .= '<option value="'.$b['FULL_NAME'].'">'.$b['FULL_NAME'].'</option>';
		  }

		  $data[0]['buyer'] = $html_select_buyer;
		echo json_encode($data);
	}

	public function regen(){
		$back = 1;
		check:

		$num = str_pad($back, 4, "0", STR_PAD_LEFT);
		$check = $this->M_monitoring->cekNomor($num);

		if (!empty($check)) {
			$back++;
			GOTO check;
		}
		return $num;	
	}
	// Export data in CSV format 
	public function exportCSV(){ 
	 $filename = 'DataItem_'.date('d-m-Y').'.csv'; 
	 header("Content-Description: File Transfer"); 
	 header("Content-Disposition: attachment; filename=$filename"); 
	 header("Content-Type: application/csv; ");	 
	 // get data 
	 $usersData = $this->M_monitoring->getDataCsv();
	 // file creation 
	 $file = fopen('php://output', 'w');
	 $header = array("ITEM CODE","ITEM DESCRIPTION","UOM1","UOM2","BUYER","PRE-PROCESSING LEAD TIME","PREPARATION PO","DELIVERY","POST-PROCESSING LEAD TIME","MOQ","FLM","NAMA APPROVER PO","RECEIVE CLOSE TOLERANCE","TOLERANCE","KETERANGAN"); 
	 fputcsv($file, $header);
	 foreach ($usersData as $key=>$line){ 
	   fputcsv($file,$line); 
	 }
	 fclose($file); 
	 exit; 
	}

	// Import data from CSV
	function load_data() {
	  $result = $this->M_monitoring->getDataCsv();
	 }

	function import(){
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['EmailPembelian'] = $this->M_monitoring->getdataEmailPembelian();
		$data['EmailPE'] = $this->M_monitoring->getdataEmailPE();
		$data['MonitoringUpdate']  = array();
		
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
	  	foreach($file_data as $row) {
		   $data['MonitoringUpdate'][] = array( 'SEGMENT1' => $row["ITEM CODE"],
		          			'DESCRIPTION'  => $row["ITEM DESCRIPTION"],
		          			'PRIMARY_UOM_CODE'   => $row["UOM1"],
		          			'SECONDARY_UOM_CODE'   => $row["UOM2"],
		          			'FULL_NAME'   => $row["BUYER"],
		          			'PREPROCESSING_LEAD_TIME'   => $row["PRE-PROCESSING LEAD TIME"],
		          			'ATTRIBUTE6'   => $row["PREPARATION PO"],
		          			'ATTRIBUTE8'   => $row["DELIVERY"],
		          			'POSTPROCESSING_LEAD_TIME'   => $row["POST-PROCESSING LEAD TIME"],
		          			'MINIMUM_ORDER_QUANTITY'   => $row["MOQ"],
		          			'FIXED_LOT_MULTIPLIER'   => $row["FLM"],
		          			'ATTRIBUTE18'   => $row["NAMA APPROVER PO"],
		          			'RECEIVE_CLOSE_TOLERANCE'   => $row["RECEIVE CLOSE TOLERANCE"],
		          			'QTY_RCV_TOLERANCE'   => $row["TOLERANCE"],
		          			'KETERANGAN' => $row["KETERANGAN"]
		   		);
	  	}
	 	// echo "<pre>";
		// print_r($data['MonitoringUpdate']);
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPembelian/Monitoring/V_Update',$data['MonitoringUpdate']);
		$this->load->view('V_Footer',$data);
	}

	public function SettingEmailPembelian(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['EmailPembelian'] = $this->M_monitoring->getdataEmailPembelian();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPembelian/Monitoring/V_EmailPembelian',$data);
		$this->load->view('V_Footer',$data);
		}	

	public function SaveEmailPembelian(){
		$email = $this->input->post('txtEmail');
		$this->M_monitoring->UpdateEmailPembelian($email);
		redirect('MonitoringPembelian/EditData/SettingEmailPembelian');
	}

	public function DeleteEmailPembelian($email){
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $email);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->M_monitoring->HapusEmailPembelian($plaintext_string);
		redirect('MonitoringPembelian/EditData/SettingEmailPembelian');
	}

	public function ExportPDF(){
		
		$temp = array();
		
		$max_data = 10;
	
		$noDok = $this->input->post('nodok');

		$result = $this->M_monitoring->getdataPDF($noDok);

		if ( !empty($result)) {
		
		$this->M_monitoring->setCetak($noDok);
		
		$total_page = ceil(sizeof($result)/$max_data);
		$size = sizeof($result);

		$html = '<style type="text/css">
					table.header{ 
						border-spacing: 0;font-family: "verdana";font-size: 14px;
					}
					.header tr{
						border: 1px solid black;padding: 0;
					}
					.header td{
						padding: 0 0 0 5px;border: 1px solid black;
					}
					table.content{ 
						border-spacing: 0;font-family: "verdana";font-size: 14px;
					}
					.content tr{
						border: 1px solid black;padding: 0;
					}
					.content td{
						padding: 0 0 0 0;border: 1px solid black;
					}
					.isi td{
						padding-left: 3px;
						font-size: 10px;
					}
					#char{
						padding-left: 1%;
					}
					table.footer{ 
						border-spacing: 0;font-family: "verdana";font-size: 16px;
					}
					.footer tr{
					}
					.footer td{
					}
					table.kelompok{
						border-spacing: 0;
					}
					.kelompok tr{
						border: 1px solid black;
					}
					.kelompok td{
						padding: 5px 5px 5px 5px; border: 1px solid black; font-family: "verdana";font-size: 14px;
					}
					table.ttd{
						border-spacing: 0;font-family: "verdana";font-size: 10px;
					}
					.ttd tr{
						border: 1px solid black;
					}
					.ttd td{
						padding: 2px 0 3px 5px;border: 1px solid black;margin: 10px 10px 10px 10px;
					}

					.ttd #ttd tr td{
						margin-top 40px;
					}	

					table.kelompok-kosong{
						border-spacing: 0;
					}
					.kelompok-kosong tr{
						border: 0px solid black;
					}
					.kelompok-kosong td{
						padding: 5px 5px 5px 5px; border: 0px solid black; font-family: "verdana";font-size: 14px;
					}
					table.ttd-kosong{
						border-spacing: 0;font-family: "verdana";font-size: 10px;
					}
					.ttd-kosong tr{
						border: 0px solid black;
					}
					.ttd-kosong td{
						padding: 2px 0 3px 5px;border: 0px solid black;margin: 10px 10px 10px 10px;
					}
				</style>';

		$temp2 = array();
		$loop = 0;
		$x = 0;
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
		
		$tgl = date('d');
		
		$bln = date('n');
		
		if ($bln == 1) {
			$bulan = 'Januari';
		} elseif ($bln == 2) {
			$bulan = 'Februari';
		} elseif ($bln == 3) {
			$bulan = 'Maret';
		} elseif ($bln == 4) {
			$bulan = 'April';
		} elseif ($bln == 5) {
			$bulan = 'Mei';
		} elseif ($bln == 6) {
			$bulan = 'Juni';
		} elseif ($bln == 7) {
			$bulan = 'Juli';
		} elseif ($bln == 8) {
			$bulan = 'Agustus';
		} elseif ($bln == 9) {
			$bulan = 'September';
		} elseif ($bln == 10) {
			$bulan = 'Oktober';
		} elseif ($bln == 11) {
			$bulan = 'November';
		} elseif ($bln == 12) {
			$bulan = 'Desember';
		}

		$tahun = date('Y');

		$tanggal = $tgl .' '. $bulan .' '. $tahun;

		$this->load->library('Pdf');
		$pdf 	 = $this->pdf->load();
		$pdf 	 = new mPDF('utf-8','legal', 0, '', 7, 7, 5,0);
		
		$total_page = ceil(sizeof($result)/$max_data);
		$size = sizeof($result);
		$loop = 0;
		$no = 1;
		for ($k=0; $k < $total_page; $k++){
			$html .= '<table class="header" width="100%" style="padding-bottom: 10px;">
					<tr>
						<td rowspan="4" width="10%" style="padding: 3px;">
							<center>
								<img style="height: 10%" src="'.base_url('/assets/img/logopatent.png').'">
							</center>
						</td>
						<td rowspan="4" style="vertical-align: top; padding-top: 5px;"><b style="font-size: 22px;">CV. KARYA HIDUP SENTOSA</b><br>
							<div style="font-size: 13px;">Jl. Magelang no.144</div>
							<b style="font-size: 15px;">Form Pengajuan/Update Attribut Pembelian pada Kode Barang</b></td>
						<td width="15%">NOMOR DOKUMEN</td>
						<td colspan="2"><b>'.$noDok.'</b></td>
					</tr>
					<tr>
						<td>TANGGAL PENGAJUAN</td>
						<td colspan="2">'.$tanggal.'</td>
					</tr>
					<tr>
						<td>JENIS PENGAJUAN<sup style="font-size: 6px;">1</sup></td>
						<td width="10%"><center>BARU</center></td>
						<td width="10%"><center>UPDATE</center></td>
					</tr>
					<tr>
						<td>LAMPIRAN<sup style="font-size: 6px;">2</sup></td>
						<td></td>
						<td><center>LEMBAR</center></td>
					</tr>
				</table>
				<table class="content" width="100%" style="padding-bottom: 10px;">
				<tr>
					<td rowspan="2" width="2%"><center>NO</center></td>
					<td rowspan="2" width="12%"><center>ITEM CODE</center></td>
					<td rowspan="2" width="13%"><center>ITEM DESCRIPTION</center></td>
					<td colspan="2"><center>BUYER</center></td>
					<td rowspan="2" width="5%"><center>PRE-PROCESS LEAD TIME<sup style="font-size: 6px;">3</sup></center></td>
					<td colspan="2"><center>TOTAL PROCESS LEAD TIME<sup style="font-size: 6px;">4</sup></center></td>
					<td rowspan="2" width="5%"><center>POST-PROCESS LEAD TIME<sup style="font-size: 6px;">7</sup></center></td>
					<td rowspan="2" width="5%"><center>TOTAL LEAD TIME<sup style="font-size: 6px;">8</sup></center></td>
					<td rowspan="2" width="5%"><center>UOM</center></td>
					<td rowspan="2" width="5%"><center>MOQ</center></td>
					<td rowspan="2" width="5%"><center>FLM</center></td>
					<td rowspan="2" width="10%"><center>APPROVER<sup style="font-size: 6px;">9</sup></center></td>
					<td rowspan="2" width="10%"><center>KETERANGAN</center></td>					
				</tr>
				<tr>
					<td width="7%"><center>NAMA</center></td>
					<td width="5%"><center>PARAF</center></td>
					<td width="5%"><center>PREPARE PO<sup style="font-size: 6px;">5</sup></center></td>
					<td width="6%"><center>DELIVERY<sup style="font-size: 6px;">6</sup></center></td>
				</tr>';

			if($size < $max_data){
				$loop = $size;
			}else{
				$loop = $max_data;
			}

			for ($l=0; $l < $loop; $l++) { 
				$html .= '<tr class="isi">
							<td><center>'.$no.'</center></td>
							<td><center>'.$temp2[$k][$l]['SEGMENT1'].'</center></td>
							<td id="char">'.$temp2[$k][$l]['DESCRIPTION'].'</td>
							<td id="char">'.$temp2[$k][$l]['FULL_NAME'].'</td>
							<td></td>
							<td><center>'.$temp2[$k][$l]['PREPROCESSING_LEAD_TIME'].'</center></td>
							<td><center>'.$temp2[$k][$l]['PREPARATION_PO'].'</center></td>
							<td><center>'.$temp2[$k][$l]['DELIVERY'].'</center></td>
							<td><center>'.$temp2[$k][$l]['POSTPROCESSING_LEAD_TIME'].'</center></td>
							<td><center>'.$temp2[$k][$l]['TOTAL_LEADTIME'].'</center></td>
							<td><center>'.$temp2[$k][$l]['PRIMARY_UOM_CODE'].'</center></td>
							<td><center>'.$temp2[$k][$l]['MINIMUM_ORDER_QUANTITY'].'</center></td>
							<td><center>'.$temp2[$k][$l]['FIXED_LOT_MULTIPLIER'].'</center></td>
							<td id="char">'.$temp2[$k][$l]['ATTRIBUTE18'].'</td>
							<td id="char">'.$temp2[$k][$l]['KETERANGAN'].'</td>
						</tr>';
				$no++;
			}

			$size -= $max_data;
			$last =  $total_page-1;
			$html .= '</table>';

			if ($k < $last && $last !=0){
				$halaman = $k+1;
				$html .= '<table class="footer" width="100%">
						<tr>
							<td width="60%"> 
							</td>
							<td>
									<table class="kelompok-kosong">
										<tr>
											<td width="40%"><center></center></td>
											<td width="20%"><center></center></td>
											<td width="40%"><center></center></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<table class="ttd-kosong" width="80%" height="5%" style="padding-left: 20px; padding-top: 20px;">
									<tr>
										<td width="20%" style="font-size: 18px;"><center></center></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"></td>
										<td width="20%" style="font-size: 18px;"><center></center></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"></td>
										<td width="20%" style="font-size: 18px;"><center></center></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"></td>
										<td width="20%" style="font-size: 18px;"></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"></td>
										<td width="20%" style="font-size: 18px;"></td>
									</tr>
									<tr style="vertical-align: bottom;" id="ttd">
										<td style="font-size: 15px;"><center><br><br><br></center></td>
										<td style="font-size: 15px;"><center><br><br><br></center></td>
										<td style="font-size: 15px;"><center><br><br><br></center></td>
										<td style="font-size: 15px;"><center><br><br><br></center></td>
										<td style="font-size: 15px;"><center><br><br><br></center></td>
									</tr>
									<tr>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;"></td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;"></td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;"></td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;"></td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;"></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding-top: 10px; font-size: 11px;">FRM-PUR-00-28 Rev.02 (21/05/18)</td>
							<td style="float: right; padding-top: 10px;">
							<table>
								<tr>
									<td width="42%"><br></td>
									<td width="40%"><br></td>
									<td width="18%" style="font-size: 11px; float: right;">Halaman '.$halaman.' dari '.$total_page.'</td>
								</tr>
							</table>
							</td>
						</tr>
					</table>';
				$html .= "<pagebreak />";
			}	
		}

		$html .= '<table class="footer" width="100%">
						<tr>
							<td width="60%">
								<b><u>Notes</u></b>
								<div>1. Coret salah satu</div>
								<div>2. Dokumen atau data yang digunakan sebagai dasar penentuan lead time</div>
								<div>3. Lead time dari PP create sampai dengan PR Approved (standar 2 hari kerja)</div>
								<div>4. Lead time pemrosesan di pembelian (preparation lead time+delivery lead time)</div>
								<div>5. Lead time dari PR approved - PO approved (by system)</div>
								<div>6. Lead time dari PO approved sampai barang diterima PBB</div>
								   <div style="padding-left: 1.5em">*) Khusus untuk item subkontraktor (Outside processing type), Delivery PO lead time memuat std. post processing lead time,</div> 
								   <div style="padding-left: 1.5em">karena adanya kendala pada proses  auto create PR dari job jika field Post Processing Lead time pada master item terisi</div>
								<div>7. Lead time dari barang diterma PBB sampai barang diproses deliver (deliver ke seksi pemesan jika expense, deliver ke gudang jika item stock)</div>
								   <div style="padding-left: 1.5em">*) Perhitungan lead time merujuk pada ES-PBB-01-01 dan ES-QCT-01-43</div>
								   <div style="padding-left: 1.5em">*) Khusus untuk item subkontraktor (Outside processing type), Std. post processing digabungkan ke dalam Delivery PO lead time</div>
								<div>8. Total lead time = Preprocessing lead time + total processing lead time + post processing lead time</div>
								<div>9. Penentuan Nama Approver PO sesuai tabel pengelompokan approver</div> 
							</td>
							<td rowspan="2" width="40%" style="vertical-align: top;">
								<b>Tabel Pengelompokan Approver</b>
								<div>
									<table class="kelompok">
										<tr>
											<td width="40%"><center><b>DASAR PENGELOMPOKAN</b></center></td>
											<td width="20%"><center><b>KELOMPOK BARANG</b></center></td>
											<td width="40%"><center><b>APPROVER PO</b></center></td>
										</tr>
										<tr>
											<td>Kode awal : N--</td>
											<td>ASET</td>
											<td>DRS. HENDRO WIJAYANTO</td>
										</tr>
										<tr>
											<td>Kode awal : Q--</td>
											<td>PROMOSI</td>
											<td>DRS. HENDRO WIJAYANTO</td>
										</tr>
										<tr>
											<td>Kode awal : G--</td>
											<td>BDL</td>
											<td>HARUN ALRASYID</td>
										</tr>
										<tr>
											<td>Kode awal : H--</td>
											<td>BDL</td>
											<td>HARUN ALRASYID</td>
										</tr>
										<tr>
											<td>Kode awal : I--</td>
											<td>BDL</td>
											<td>HARUN ALRASYID</td>
										</tr>
										<tr>
											<td>Kode awal : L--</td>
											<td>MATERIAL</td>
											<td>RIA CAHYANI</td>
										</tr>
										<tr>
											<td>Kode awal : P--</td>
											<td>OFFICE SUPPLIES</td>
											<td>RIA CAHYANI</td>
										</tr>
										<tr>
											<td>Kode awal : S--</td>
											<td>BANGUNAN</td>
											<td>RIA CAHYANI</td>
										</tr>
										<tr>
											<td>Kode jasa non JASA01, non JANG--</td>
											<td>JASA LAIN-LAIN</td>
											<td>RIA CAHYANI</td>
										</tr>
										<tr>
											<td>Kode awal : JANG--</td>
											<td>EKSPEDISI</td>
											<td>HARUN ALRASYID</td>
										</tr>
										<tr>
											<td>Kode awal : JASA01</td>
											<td>EKSPEDISI</td>
											<td>HARUN ALRASYID</td>
										</tr>
										<tr>
											<td>Kode awal : R--</td>
											<td>MAINTENANCE</td>
											<td>SUGENG SUTANTO</td>
										</tr>
										<tr>
											<td>Kode selain di atas</td>
											<td>NON MATERIAL</td>
											<td>SUGENG SUTANTO</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<table class="ttd" width="80%" height="5%" style="padding-left: 20px; padding-top: 20px;">
									<tr>
										<td width="20%" style="font-size: 18px;"><center>Diajukan</center></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"><b>&rarr;</b></td>
										<td width="20%" style="font-size: 18px;"><center>Didistribusikan</center></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"><b>&rarr;</b></td>
										<td width="20%" style="font-size: 18px;"><center>Diterima PIEA</center></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"><b>&rarr;</b></td>
										<td width="20%" style="font-size: 18px;"><center>Diterima Pembelian</center></td>
										<td rowspan="3" style="border: 0; font-size: 15px; padding-left: 0;"><b>&rarr;</b></td>
										<td width="20%" style="font-size: 18px;"><center>Diperiksa</center></td>
									</tr>
									<tr style="vertical-align: bottom;" id="ttd">
										<td style="font-size: 15px;"><center><br><br><br>(M.Ary Pamujo)</center></td>
										<td style="font-size: 15px;"><center><br><br><br>(Rika Ambarwati)</center></td>
										<td style="font-size: 15px;"><center><br><br><br>(Yosephin S,N)</center></td>
										<td style="font-size: 15px;"><center><br><br><br>(Rika Ambarwati)</center></td>
										<td style="font-size: 15px;"><center><br><br><br>(Rika Ambarwati)</center></td>
									</tr>
									<tr>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;">Tgl.</td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;">Tgl.</td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;">Tgl.</td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;">Tgl.</td>
										<td style="padding-top: 7px; padding-bottom: 7px; font-size: 18px;">Tgl.</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding-top: 10px;">FRM-PUR-00-28 Rev.02 (21/05/18)</td>
							<td style="float: right; padding-top: 10px;">
							<table>
								<tr>
									<td width="40%"><br></td>
									<td width="40%"><br></td>
									<td width="20%">Halaman '.$total_page.' dari '.$total_page.'</td>
								</tr>
							</table>
							</td>
						</tr>
					</table>';

		$path       = 'upload/';
	    $file_name ="FormUpdateAttribut-".$noDok."-".date('dmy').".pdf";
	    $pdf->AddPage('L');
	    $pdf->WriteHTML($html); 
	    $pdf->debug = true;
	    $pdf->Output($file_name, "I");
	} else {
		echo "<script>alert('Nomor Dokumen ".$noDok." Sudah Dicetak'); window.location.href='" . base_url() . "MonitoringPembelian/Monitoring';</script>";
	}

	}
}