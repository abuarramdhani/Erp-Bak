<?php
defined('BASEPATH') OR exit('No direct script access allowed');
set_time_limit(0);
class C_splkasie extends CI_Controller {
	function __construct() {
        parent::__construct();

        $this->load->library('session');

		$this->load->model('SPLSeksi/M_splseksi');
		$this->load->model('SPLSeksi/M_splkasie');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		date_default_timezone_set('Asia/Jakarta');
    }

    public function checkSession(){
		if($this->session->is_logged){
			// any
		}else{
			redirect('');
		}
	}

    public function menu($a, $b, $c){
    	$this->checkSession();
    	$user_id = $this->session->userid;

		$data['Menu'] = $a;
		$data['SubMenuOne'] = $b;
		$data['SubMenuTwo'] = $c;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		return $data;
    }

    public function index(){
    	$this->checkSession();
		$data = $this->menu('', '', '');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Kasie/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function data_spl(){
		$this->checkSession();
		$wkt_validasi = $this->session->spl_validasi_waktu_kasie;
		// if (time() - $wkt_validasi > 120) {
		// 	$this->session->spl_validasi_kasie = FALSE;
		// 	redirect(site_url('SPL'));
		// }
		$this->session->spl_validasi_waktu_kasie = time();
		$data = $this->menu('', '', '');
		$data['lokasi'] = $this->M_splseksi->show_lokasi();
		$data['jari'] = $this->M_splseksi->getJari($this->session->userid);
		
		$status = $this->input->get('stat');
		
		$data['parameter'] = $status;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SPLSeksi/Kasie/V_data_spl',$data);
		$this->load->view('V_Footer',$data);
	}

	function convertUnOrderedlist($data){
		//separator ; (semicolon)
		$item = explode(';', $data);
		$html = "<ul>";
			foreach($item as $key){
				$html .= "<li>$key</li>";
			}
		$html .= "</ul>";
		return $html;
	}

	public function hitung_jam_lembur($noind, $kode_lembur, $tgl, $mulai, $selesai, $break, $istirahat){ //latest
		$day   = date('w', strtotime($tgl));

		$hari_indo = "Minggu Senin Selasa Rabu Kamis Jumat Sabtu";
		$array_hari = explode(' ', $hari_indo);
		//--------------------core variable
		$KET  		= $this->M_splseksi->getKeteranganJamLembur($noind);
		$JENIS_HARI	= $this->M_splseksi->getJenisHari($tgl, $noind);
		$HARI 		= $array_hari[$day];
		//-----------------------
		$treffjamlembur = $this->M_splseksi->treffjamlembur($KET, $JENIS_HARI, $HARI);

		//----cari berapa menit lemburnya
		$first = explode(':', $mulai);
		$second = explode(':', $selesai);

		if(count($first) == 1){
			$first[1] = 00;
		}

		if(count($second) == 1){
			$second[1] = 00;
		}

		$a = $first[0]*60+$first[1];
		$b = $second[0]*60+$second[1];

		if($a>$b){
		 	$zero = 24*60; // jam sehari dalam menit
		 	$z = $zero - $a;
		 	$lama_lembur = $z+$b;
		}else{
			$lama_lembur = $b-$a;
		}

		$shift = $this->M_splseksi->selectShift($noind, $tgl);
		if($kode_lembur == '005'){
			$shift = (strtotime($shift->jam_plg) - strtotime($shift->jam_msk));
			$shift = $shift/60;
		 	$result = $lama_lembur-$shift;
		}else{
		 	$result = $lama_lembur;
		}
		//-----end cari menit lembur

		//-----------------------core variable
		$MENIT_LEMBUR = $result;
		//buat jaga jaga error
		$BREAK = $break == 'Y' ? 15 : 0;
		$ISTIRAHAT = $istirahat == 'Y' ? 45 : 0;

		$allShift = $this->M_splseksi->selectAllShift($tgl);

		if(!empty($allShift)){
			if ($istirahat == 'Y') { //jika pekerja memilih istirahat
				$ISTIRAHAT = 0;
				$distinct_start = [];

				foreach($allShift as $shift){
					$rest_start = strtotime($shift['ist_mulai']);
					$rest_end   = strtotime($shift['ist_selesai']);

					if($rest_start == $rest_end){
						continue;
					}

					//biar jam break tidak terdouble
					if(in_array($rest_start, $distinct_start)){
						continue;
					}else{
						$distinct_start[] = $rest_start;
					}

					$overtime_start = strtotime($mulai);
					$overtime_end   = strtotime($selesai);

					if (($rest_start > $overtime_start && $rest_end < $overtime_end)) { // jika jam istirahat masuk range lembur
						$ISTIRAHAT = $ISTIRAHAT + 45;
					}else if($rest_start > $overtime_start && $rest_end > $overtime_end && $rest_start < $overtime_end){
						$ISTIRAHAT = $ISTIRAHAT + (45 + ($overtime_end - $rest_end)/60);
					}
				}
			}
			
			if ($break == 'Y') { //jika pekerja memilih istirahat
				$BREAK = 0;
				$distinct_start = [];

				foreach($allShift as $shift){
					$break_start = strtotime($shift['break_mulai']);
					$break_end   = strtotime($shift['break_selesai']);

					//jika tidak ada istirahat, lewati
					if($break_start == $break_end){
						continue;
					}

					//biar jam break tidak terdouble
					if(in_array($break_start, $distinct_start)){
						continue;
					}else{
						$distinct_start[] = $break_start;
					}

					$overtime_start = strtotime($mulai);
					$overtime_end   = strtotime($selesai);
				
					if ($break_start > $overtime_start && $break_end < $overtime_end) { // jika jam istirahat masuk range lembur
						$BREAK = $BREAK + 15;
					}else if($break_start > $overtime_start && $break_end > $overtime_end && $break_start < $overtime_end){
						$BREAK = $BREAK + (15 + ($overtime_end - $break_end)/60);
					}
				}
			}
		}

		//----------------------
		$estimasi = 0;
		if(!empty($treffjamlembur)):
			$total_lembur = $MENIT_LEMBUR-($BREAK+$ISTIRAHAT);

			$i = 0;
			while($total_lembur > 0){
				$jml_jam = $treffjamlembur[$i]['jml_jam'] * 60;
				$pengali = $treffjamlembur[$i]['pengali'];

				if($total_lembur > $jml_jam){

					$estimasi = $estimasi + $jml_jam * $pengali/60;
					$total_lembur = $total_lembur - $jml_jam;
				}else{

					$estimasi = $estimasi + ($total_lembur * $pengali/60);
					$estimasi = number_format($estimasi,2);
					$total_lembur = 0;
				}
				$i++;
			}
		else:
			$estimasi = "tdk bisa diproses";
		endif;

		return $estimasi;
	}

	public function cut_kodesie($id){
		$z = 0;
		for($x=-1; $x>=-strlen($id); $x--){
			if(substr($id, $x, 1) == "0"){
				$z++;
			}else{
				break;
			}
		}

		$data = substr($id, 0, strlen($id)-$z);
		return $data;
	}

	public function data_spl_filter(){
		$this->checkSession();
		$this->session->spl_validasi_waktu_kasie = time();
		$user = $this->session->user;
		$dari = $this->input->post('dari');
		$dari = date_format(date_create($dari), "Y-m-d");
		$sampai = $this->input->post('sampai');
		$sampai = date_format(date_create($sampai), "Y-m-d");
		$status = $this->input->post('status');
		$lokasi = $this->input->post('lokasi');
		$noind = $this->input->post('noind');
		$kodesie = $this->input->post('kodesie');

		// get akses seksi
		$akses_sie = array();
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = $this->cut_kodesie($ak['kodesie']);
			foreach($akses_spl as $as){
				$akses_sie[] = $this->cut_kodesie($as['kodesie']);
			}
		}

		$data_spl = array();
		$show_list_spl = $this->M_splkasie->show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie, $kodesie);
		foreach($show_list_spl as $sls){
			$index = array();

			if($sls['Status'] == "01"){
				$index[] = '<input type="checkbox" name="splid[]" class="spl-chk-data"
					value="'.$sls['ID_SPL'].'" style="width:20px; height:20px; vertical-align:bottom;">';
			}else{
				$index[] = "";
			}

			$index[] = $sls['Tgl_Lembur'];
			$index[] = $sls['Noind'];
			$index[] = $sls['nama'];
			$index[] = $sls['kodesie'];
			$index[] = $sls['seksi'];
			$index[] = $this->convertUnOrderedlist($sls['Pekerjaan']);
			$index[] = $sls['nama_lembur'];
			$index[] = $sls['Jam_Mulai_Lembur'];
			$index[] = $sls['Jam_Akhir_Lembur'];
			$index[] = $sls['Break'];
			$index[] = $sls['Istirahat'];
			$index[] = $this->hitung_jam_lembur($sls['Noind'], $sls['Kd_Lembur'], $sls['Tgl_Lembur'], $sls['Jam_Mulai_Lembur'], $sls['Jam_Akhir_Lembur'], $sls['Break'], $sls['Istirahat']);
			$index[] = $this->convertUnOrderedlist($sls['target']);
			$index[] = $this->convertUnOrderedlist($sls['realisasi']);
			$index[] = $sls['alasan_lembur'];
			$index[] = $sls['Deskripsi']." ".$sls['User_'];
			$index[] = $sls['Tgl_Berlaku'];

			$data_spl[] = $index;
		}
		echo json_encode($data_spl);
	}

	public function data_spl_approv($id, $stat, $ket){
		$this->checkSession();
		$this->session->spl_validasi_waktu_kasie = time();
		$user = $this->session->user;
		$data_spl = $this->M_splseksi->show_current_spl('', '', '', $id);

		foreach($data_spl as $ds){
			// Generate ID Riwayat
			$maxid = $this->M_splseksi->show_maxid("splseksi.tspl_riwayat", "ID_Riwayat");
			if(empty($maxid)){
				$splr_id = "0000000001";
			}else{
				$splr_id = $maxid->id;
				$splr_id = substr("0000000000", 0, 10-strlen($splr_id)).$splr_id;
			}

			// Approv or Cancel
			if($stat == "21"){
				$log_jenis = "Approve";
				$spl_ket = $ket." (Approve By Kasie)";
			}else{
				$log_jenis = "Cancel";
				$spl_ket = $ket." (Cancel By Kasie)";
			}

			// Insert data
			$log_ket = "Noind:".$ds['Noind']." Tgl:".$ds['Tgl_Lembur']." Kd:".$ds['Kd_Lembur'].
				" Jam:".$ds['Jam_Mulai_Lembur']."-".$ds['Jam_Akhir_Lembur']." Break:".$ds['Break'].
				" Ist:".$ds['Istirahat']." Pek:".$ds['Pekerjaan']."<br />";

			$data_log = array(
				"wkt" => date('Y-m-d H:i:s'),
				"menu" => "Kasie",
				"jenis" => $log_jenis,
				"ket" => $log_ket,
				"noind" => $user);
			$to_log = $this->M_splseksi->save_log($data_log);

			$data_spl = array(
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Status" => $stat,
				"User_" => $user);
			$to_spl = $this->M_splseksi->update_spl($data_spl, $id);
			$noind_baru = $this->M_splseksi->getNoindBaru($ds['Noind']);

			$data_splr = array(
				"ID_Riwayat" => $splr_id,
				"ID_SPL" => $id,
				"Tgl_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Tdk_Berlaku" => date('Y-m-d H:i:s'),
				"Tgl_Lembur" => $ds['Tgl_Lembur'],
				"Noind" => $ds['Noind'],
				"Noind_Baru" => $noind_baru,
				"Kd_Lembur" => $ds['Kd_Lembur'],
				"Jam_Mulai_Lembur" => $ds['Jam_Mulai_Lembur'],
				"Jam_Akhir_Lembur" => $ds['Jam_Akhir_Lembur'],
				"Break" => $ds['Break'],
				"Istirahat" => $ds['Istirahat'],
				"Pekerjaan" => $ds['Pekerjaan'],
				"Status" => $stat,
				"User_" => $user,
				"Revisi" => "0",
				"Keterangan" => $spl_ket,
				"target" => $ds['target'],
				"realisasi" => $ds['realisasi'],
				"alasan_lembur" => $ds['alasan_lembur']);
			$to_splr = $this->M_splseksi->save_splr($data_splr);
		}
	}

	public function send_email($status,$spl_id,$ket) {
		$this->checkSession();
		$this->session->spl_validasi_waktu_kasie = time();
		$akses_sie = array();
		$user = $this->session->user;
		$akses_kue = $this->M_splseksi->show_pekerja('', $user, '');
		$akses_spl = $this->M_splseksi->show_akses_seksi($user);
		foreach($akses_kue as $ak){
			$akses_sie[] = substr($this->cut_kodesie($ak['kodesie']), 0, 5);

			foreach($akses_spl as $as){
				$akses_sie[] = substr($this->cut_kodesie($as['kodesie']), 0, 5);
			}
		}

		$data[] = "email atasan ???";
		foreach($akses_sie as $as){
			$e_asska = $this->M_splkasie->show_email_addres($as);
			foreach($e_asska as $ea){
				$data[] = $ea['internal_mail'];
			}
		}
		$isiPesan = "<table style='border-collapse: collapse;width: 100%'>";
		$spl_id = explode('.', $spl_id);
		$idspl = "";
		foreach ($spl_id as $id) {
			if ($idspl == "") {
				$idspl .= "'".$id."'";
			}else{
				$idspl .= ",'".$id."'";
			}
		}
		$pesan = $this->M_splkasie->show_spl_byid($idspl);
		$tgl_lembur = "";
		$pkj_lembur = "";
		$brk_lembur = "";
		$ist_lembur	= "";
		$jns_lembur = "";
		$no = 1;
		foreach ($pesan as $key) {
			if ($tgl_lembur !== $key['tgl_lembur'] or $pkj_lembur !== $key['Pekerjaan'] or $brk_lembur !== $key['Break'] or $ist_lembur !== $key['Istirahat'] or $jns_lembur !== $key['Kd_Lembur']) {
				$no = 1;
				$isiPesan .= "	<tr><td>&nbsp;</td></tr><tr>
								<td>Tanggal</td><td colspan='7'> : ".$key['tgl_lembur']."</td></tr>
								<tr><td>jenis</td><td colspan='7'> : ".$key['nama_lembur']."</td></tr>
								<tr><td>Istirahat</td><td colspan='7'> : ".$key['Istirahat']."</td></tr>
								<tr><td>Break</td><td colspan='7'> : ".$key['Break']."</td></tr>
								<tr><td>Pekerjaan</td><td colspan='7'> : ".$key['Pekerjaan']."</td></tr>
								<tr>
									<td style='border: 1px solid black'>No</td>
									<td style='border: 1px solid black'>Pekerja</td>
									<td style='border: 1px solid black'>Kodesie</td>
									<td style='border: 1px solid black'>Seksi</td>
									<td style='border: 1px solid black'>Unit</td>
									<td style='border: 1px solid black'>Waktu Lembur</td>
									<td style='border: 1px solid black'>Target</td>
									<td style='border: 1px solid black'>Realisasi</td>
									<td style='border: 1px solid black'>Alasan</td>
								</tr>";
			}
			$isiPesan .= "<tr>
							<td style='border: 1px solid black;text-align: center'>$no</td>
							<td style='border: 1px solid black'>".$key['Noind']." ".$key['nama']."</td>
							<td style='border: 1px solid black;text-align: center'>".$key['kodesie']."</td>
							<td style='border: 1px solid black'>".$key['seksi']."</td>
							<td style='border: 1px solid black'>".$key['unit']."</td>
							<td style='border: 1px solid black'>".$key['jam_mulai_lembur']." - ".$key['Jam_Akhir_Lembur']."</td>
							<td style='border: 1px solid black;text-align: center'>".$key['target']."</td>
							<td style='border: 1px solid black;text-align: center'>".$key['realisasi']."</td>
							<td style='border: 1px solid black'>".$key['alasan_lembur']."</td>
						</tr>";
			$no++;
			$tgl_lembur = $key['tgl_lembur'] ;
			$pkj_lembur = $key['Pekerjaan'] ;
			$brk_lembur = $key['Break'] ;
			$ist_lembur = $key['Istirahat'] ;
			$jns_lembur = $key['Kd_Lembur'] ;
		}
		$isiPesan .= "</table>";
		$email[] = array(
			"actn" => "offline",
			"host" => "m.quick.com",
			"port" => 465,
			"user" => "no-reply",
			"pass" => "123456",
			"from" => "no-reply@quick.com",
			"adrs" => "");

		foreach($email as $e){
			$this->load->library('PHPMailerAutoload');
			$mail = new PHPMailer;
			//Tell PHPMailer to use SMTP
			$mail->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail->Host = $e['host'];
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = $e['port'];
			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					));
			//Username to use for SMTP authentication
			$mail->Username = $e['user'];
			//Password to use for SMTP authentication
			$mail->Password = $e['pass'];
			//Set who the message is to be sent from
			$mail->setFrom($e['from'], 'Email Sistem');
			//Set an alternative reply-to address
			// $mail->addReplyTo('it.sec3@quick.com', 'Khoerul Amri');
			//Set who the message is to be sent to
			$mail->addAddress($e['adrs'], 'Monitoring Transaction');
			foreach($data as $d){
				$mail->addAddress($d, 'Lembur (Approve Asska)');
			}
			//Set the subject line
			$mail->Subject = 'Anda telah menerima permintaan approval spl';
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML("
			<h4>Lembur (Appove Asska)</h4><hr>
			Kepada Yth Bapak/Ibu<br><br>

			Kami informasikan bahwa anda telah menerima permintaan<br>
			approval untuk keperluan lembur pekerja.<br>
			Berikut ini daftar yang telah di Approve oleh : <b>$user - {$this->session->employee}</b><br>
			dengan keterangan : <b>$ket</b><br><br>
			$isiPesan
			<br>
			Anda dapat melakukan pengecekan di link berikut :<br>
			- http://erp.quick.com atau klik <a href='http://erp.quick.com'>disini</a><br><br>

			<small>Email ini digenerate melalui sistem erp.quick.com pada ".date('d-m-Y H:i:s').".<br>
			Apabila anda mengalami kendala dapat menghubungi Seksi ICT (12300)</small>");
			//send the message, check for errors
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo "Message sent!";
			}
		}
	}

	public function send_email_2($status,$spl_id,$ket){
		$this->checkSession();
		$this->session->spl_validasi_waktu_kasie = time();
		$user = $this->session->user;
		$spl_id = explode('.', $spl_id);
		$idspl = "";
		foreach ($spl_id as $id) {
			if ($idspl == "") {
				$idspl .= "'".$id."'";
			}else{
				$idspl .= ",'".$id."'";
			}
		}
		$pesan = $this->M_splkasie->show_spl_byid_2($idspl);
		$tgl_lembur = "";
		$pkj_lembur = "";
		$brk_lembur = "";
		$ist_lembur	= "";
		$jns_lembur = "";
		$no = 1;
		$data = array();
		$number = 0;
		$op_spl = "";
		foreach ($pesan as $key) {
			if ($op_spl !== $key['user_']) {
				if ($number !== 0) {
					$data[$number]['isiPesan'] .= "</table>";
				}
				$number++;
				$data[$number]['user'] = $key['user_'];
				$data[$number]['isiPesan'] = "<table style='border-collapse: collapse;width: 100%'>";
				$data[$number]['email'] = $this->M_splkasie->getEmailAddress($key['user_']);
			}else{

			}
			if ($tgl_lembur !== $key['tgl_lembur'] or $pkj_lembur !== $key['Pekerjaan'] or $brk_lembur !== $key['Break'] or $ist_lembur !== $key['Istirahat'] or $jns_lembur !== $key['Kd_Lembur']) {
				$no = 1;
				$data[$number]['isiPesan'] .= "	<tr><td>&nbsp;</td></tr>
								<tr><td>Tanggal</td><td colspan='7'> : ".$key['tgl_lembur']."</td></tr>
								<tr><td>jenis</td><td colspan='7'> : ".$key['nama_lembur']."</td></tr>
								<tr><td>Istirahat</td><td colspan='7'> : ".$key['Istirahat']."</td></tr>
								<tr><td>Break</td><td colspan='7'> : ".$key['Break']."</td></tr>
								<tr><td>Pekerjaan</td><td colspan='7'> : ".$key['Pekerjaan']."</td></tr>
								<tr>
									<td style='border: 1px solid black'>No</td>
									<td style='border: 1px solid black'>Pekerja</td>
									<td style='border: 1px solid black'>Kodesie</td>
									<td style='border: 1px solid black'>Seksi</td>
									<td style='border: 1px solid black'>Unit</td>
									<td style='border: 1px solid black'>Waktu Lembur</td>
									<td style='border: 1px solid black'>Target</td>
									<td style='border: 1px solid black'>Realisasi</td>
									<td style='border: 1px solid black'>Alasan</td>
								</tr>";
			}
			$data[$number]['isiPesan'] .= "<tr>
											<td style='border: 1px solid black;text-align: center'>$no</td>
											<td style='border: 1px solid black'>".$key['Noind']." ".$key['nama']."</td>
											<td style='border: 1px solid black;text-align: center'>".$key['kodesie']."</td>
											<td style='border: 1px solid black'>".$key['seksi']."</td>
											<td style='border: 1px solid black'>".$key['unit']."</td>
											<td style='border: 1px solid black'>".$key['jam_mulai_lembur']." - ".$key['Jam_Akhir_Lembur']."</td>
											<td style='border: 1px solid black;text-align: center'>".$key['target']."</td>
											<td style='border: 1px solid black;text-align: center'>".$key['realisasi']."</td>
											<td style='border: 1px solid black'>".$key['alasan_lembur']."</td>
										</tr>";
			$no++;
			$tgl_lembur = $key['tgl_lembur'] ;
			$pkj_lembur = $key['Pekerjaan'] ;
			$brk_lembur = $key['Break'] ;
			$ist_lembur = $key['Istirahat'] ;
			$jns_lembur = $key['Kd_Lembur'] ;
			$op_spl = $key['user_'];
		}
		$data[$number]['isiPesan'] .= "</table>";
		// print_r($data);exit();
		$this->load->library('PHPMailerAutoload');
		if ($status == '25' or $status == '21') {
			//approve
			foreach ($data as $dt) {
				$message = "<h4>Lembur</h4><hr>
							Kepada Yth Bapak/Ibu<br><br>

							Kami informasikan bahwa SPL yang anda inputkan<br>
							telah di <b>Approve</b> oleh Kasie.<br>
							Berikut ini daftar yang telah di Approve oleh : <b>$user - {$this->session->employee}</b><br>
							dengan keterangan : <b>$ket</b><br><br>
							".$dt['isiPesan']."
							<br>
							Anda dapat melakukan pengecekan di link berikut :<br>
							- http://erp.quick.com atau klik <a href='http://erp.quick.com'>disini</a><br><br>

							<small>Email ini digenerate melalui sistem erp.quick.com pada ".date('d-m-Y H:i:s').".<br>
							Apabila anda mengalami kendala dapat menghubungi Seksi ICT (12300)</small>";
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = "m.quick.com";
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						));
				$mail->Username = "no-reply";
				$mail->Password = "123456";
				$mail->setFrom("no-reply@quick.com", 'Email Sistem');
				$mail->addAddress("", 'Monitoring Transaction');
				$mail->addAddress($dt['email'], 'Lembur (Approve Kasie)');
				$mail->Subject = 'SPL Anda telah di Approve';
				$mail->msgHTML($message);
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}
			}
		}else{
			//reject
			foreach ($data as $dt) {
				$message = "<h4>Lembur</h4><hr>
							Kepada Yth Bapak/Ibu<br><br>

							Kami informasikan bahwa SPL yang anda inputkan<br>
							telah di <b>Reject</b> oleh Kasie.<br>
							Berikut ini daftar yang telah di Reject oleh : <b>$user - {$this->session->employee}</b><br>
							dengan keterangan : <b>$ket</b><br><br>
							".$dt['isiPesan']."
							<br>
							Anda dapat melakukan pengecekan di link berikut :<br>
							- http://erp.quick.com atau klik <a href='http://erp.quick.com'>disini</a><br><br>

							<small>Email ini digenerate melalui sistem erp.quick.com pada ".date('d-m-Y H:i:s').".<br>
							Apabila anda mengalami kendala dapat menghubungi Seksi ICT (12300)</small>";

				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Debugoutput = 'html';
				$mail->Host = "m.quick.com";
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						));
				$mail->Username = "no-reply";
				$mail->Password = "123456";
				$mail->setFrom("no-reply@quick.com", 'Email Sistem');
				$mail->addAddress("", 'Monitoring Transaction');
				$mail->addAddress($dt['email'], 'Lembur (Approve Kasie)');
				$mail->Subject = 'SPL Anda telah di Reject';
				$mail->msgHTML($message);
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}
			}
		}
	}

	function fp_proces(){
		$time_limit_ver = "10";
		$user_id = $this->input->get('userid');
		$kd_finger = $this->input->get('finger_id');
		$finger	= $this->M_splkasie->show_finger_user(array('user_id' => $user_id, 'kd_finger' => $kd_finger));

		$status = $this->input->get('stat');
		$ket = $this->input->get('ket');
		$spl_id = $this->input->get('data');

		echo "
		$user_id;".$finger->finger_data.";SecurityKey;".$time_limit_ver.";".site_url("ALK/Approve/fp_verification?status=$status&spl_id=$spl_id&ket=$ket&finger_id=$kd_finger").";".site_url("ALK/Approve/fp_activation").";extraParams";
		// variabel yang di tmpilkan belum bisa di ubah
	}

	function fp_activation(){
		$filter = array("Verification_Code" => $_GET['vc']);
		$data = $this->M_splkasie->show_finger_activation($filter);
		echo $data->Activation_Code.$data->SN;
	}

	function fp_verification(){
		$data = explode(";",$_POST['VerPas']);
		$user_id = $data[0];
		$vStamp = $data[1];
		$time = $data[2];
		$sn = $data[3];

		$filter 	= array("SN" => $sn);
		$kd_finger = $this->input->get('finger_id');
		$fingerData = $this->M_splkasie->show_finger_user(array('user_id' => $user_id, 'kd_finger' => $kd_finger));
		$device 	= $this->M_splkasie->show_finger_activation($filter);

		$salt = md5($sn.$fingerData->finger_data.$device->Verification_Code.$time.$user_id.$device->VKEY);

		if (strtoupper($vStamp) == strtoupper($salt)) {
			$status = $_GET['status'];
			$spl_id = $_GET['spl_id'];
			$ket = $_GET['ket'];

			echo site_url("ALK/Approve/fp_succes?status=$status&spl_id=$spl_id&ket=$ket");
		}else{
			echo "Parameter invalid..";
		}
	}

	function fp_succes(){
		$status = $_GET['status'];
		$spl_id = $_GET['spl_id'];
		$ket = $_GET['ket'];

		foreach(explode('.', $spl_id) as $si){
			$this->data_spl_approv($si, $status, $ket);
		}

		if ($status == '25' or $status == '21') {
			$this->send_email($status,$spl_id,$ket);
		}

		$this->send_email_2($status,$spl_id,$ket);
		
		$this->session->spl_validasi_waktu_kasie = time();
		
		if(!empty($status) && !empty($spl_id)) {
			echo "<script>localStorage.setItem('resultApproveSPL', true);window.close();</script>";
		}else {
			echo "<script>localStorage.setItem('resultApproveSPL', 3);window.close();</script>"; //result error
		}
	}

	//validasi user kasie & asska
	function fp_proces_val(){
		$time_limit_ver = "10";
		$user_id = $this->input->get('userid');
		$kd_finger = $this->input->get('finger_id');
		$finger	= $this->M_splkasie->show_finger_user(array('user_id' => $user_id, 'kd_finger' => $kd_finger));

		$res_id = $this->input->get('res_id');
		echo "$user_id;".$finger->finger_data.";SecurityKey;".$time_limit_ver.";".site_url("ALK/Approve/fp_verification_val?res_id=".$res_id.'&finger_id='.$kd_finger).";".site_url("ALK/Approve/fp_activation").";extraParams";
		// variabel yang di tmpilkan belum bisa di ubah
	}

	function fp_verification_val(){
		$data = explode(";",$_POST['VerPas']);
		$user_id = $data[0];
		$vStamp = $data[1];
		$time = $data[2];
		$sn = $data[3];

		$filter 	= array("SN" => $sn);
		$kd_finger = $this->input->get('finger_id');
		$fingerData = $this->M_splkasie->show_finger_user(array('user_id' => $user_id,'kd_finger' => $kd_finger));
		$device 	= $this->M_splkasie->show_finger_activation($filter);

		$salt = md5($sn.$fingerData->finger_data.$device->Verification_Code.$time.$user_id.$device->VKEY);

		if (strtoupper($vStamp) == strtoupper($salt)) {
			$res_id = $this->input->get('res_id');
			echo site_url("ALK/Approve/fp_succes_val?res_id=".$res_id.'&finger_id='.$kd_finger);
		}else{
			echo site_url("ALK/Approve/fp_fail_val?res_id=".$res_id);
		}
	}

	function fp_succes_val(){
		$nama = $this->session->employee;
		$jari = $this->input->get('finger_id');
		$this->session->spl_validasi_jari = $jari;
		$finger = $this->M_splkasie->getFingerName($jari);
		if ($this->session->sex == 'L') {
			$yth = "Bpk.";
		}else{
			$yth = "Ibu";
		}
		$this->session->spl_validasi_log = "Selamat $yth $nama,   anda telah terverifikasi menggunakan $finger Anda.<br>
		Silahkan tunggu beberapa saat, Anda akan otomatis diarahkan ke halaman approval. Atau silahkan klik <a href='".site_url('SPL')."'>link ini</a> untuk langsung menuju ke halaman approval.";
		// print_r($_SESSION);exit();
		if ($this->input->get('res_id') == 2592) {
			$this->session->spl_validasi_kasie = TRUE;
			$this->session->spl_validasi_waktu_kasie = time();
			echo "User SPL Kasie Sukses Terverifikasi<br>Kembali ke Halaman sebelumnya dan tunggu hingga selesai memuat halaman";
			// print_r($_SESSION);exit();
			// echo "<script>window.close();</script>";
			redirect(site_url('SPL'));
		}elseif ($this->input->get('res_id') == 2593){
			$this->session->spl_validasi_asska = TRUE;
			$this->session->spl_validasi_waktu_asska = time();
			echo "User SPL Asska Sukses Terverifikasi<br>Kembali ke Halaman sebelumnya dan tunggu hingga selesai memuat halaman";
			// echo "<script>window.close();</script>";
			redirect(site_url('SPL'));
		}else{
			$this->session->spl_validasi_log = "Selamat $yth $nama,   anda telah terverifikasi menggunakan $finger Anda.<br>
				Silahkan tunggu beberapa saat, Anda akan otomatis diarahkan ke halaman SPL Operator. Atau silahkan klik <a href='".site_url('SPL')."'>link ini</a> untuk langsung menuju ke halaman SPL Operator.";
			$this->session->spl_validasi_operator = TRUE;
			$this->session->spl_validasi_waktu_operator = time();
			echo "User SPL Operator Sukses Terverifikasi<br>Kembali ke Halaman sebelumnya dan tunggu hingga selesai memuat halaman";
			// echo "<pre>";print_r($_SESSION);exit();
			// echo "<script>window.close();</script>";
			redirect(site_url('SPL'));
		}
	}

	function fp_fail_val(){
		if ($this->input->get('res_id') == 2592) {
			$this->session->spl_validasi_kasie = FALSE;
			echo "User SPL Kasie Gagal Terverifikasi<br>";
			// echo "<script>window.close();</script>";
		}elseif ($this->input->get('res_id') == 2593){
			$this->session->spl_validasi_asska = FALSE;
			echo "User SPL Asska Gagal Terverifikasi<br>";
			// echo "<script>window.close();</script>";
		}else{
			$this->session->spl_validasi_operator = FALSE;
			echo "User SPL Operator Gagal Terverifikasi<br>";
			// echo "<script>window.close();</script>";
		}
	}
}
