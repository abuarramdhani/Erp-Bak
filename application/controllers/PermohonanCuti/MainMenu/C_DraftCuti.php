<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** this menu created by DK-PKL 2019
 *  ticket from EDP/reny sulistya
 *  sorry for bad code :(
 *  write : 6 agst 2019
 */
class C_DraftCuti extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PermohonanCuti/M_permohonancuti');
		$this->load->model('PermohonanCuti/M_approval');
		//------cek hak akses halaman-------//
		$this->load->library('access');
		$this->access->page();
		//---------------^_^----------------//
		$this->checkSession();
	}

	public function checkSession()
	{
		if(!$this->session->is_logged){
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Menu'] = 'List Data Cuti';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info'] = $this->M_permohonancuti->getPekerja($noind);
		$data['Draft'] = $this->M_permohonancuti->getDraft($noind);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/DraftCuti/V_DraftCuti',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Delete(){ //to del cuti / call by ajax
		$this->M_permohonancuti->deleteCuti($_POST['id_cuti']);
	}

	public function Request(){ //to request cuti /call by ajax
		$id = $_POST['id_cuti'];
		$noind = $this->session->user;
		date_default_timezone_set('Asia/Jakarta');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id_cuti = $this->encrypt->decode($plaintext_string);
		$time = date('d-M-Y H:i:s');

		$getapproval = $this->M_permohonancuti->getApproval_cuti($id_cuti);
		$getnama = $this->M_permohonancuti->getNama($noind);
		$dataCuti = $this->M_approval->getDataCuti($id_cuti);

		$approval1 = $getapproval['0']['approver'];
		$approval2 = $getapproval['1']['approver'];

		$getapp1 = $this->M_permohonancuti->getNama($approval1);
		$getapp2 = $this->M_permohonancuti->getNama($approval2);

		$thread = array(
			'lm_pengajuan_cuti_id' => $id_cuti,
			'status' => '1',
			'detail' => '(Request Approval) - '.$getnama['0']['nama'].' Telah melakukan request approval Surat Permohonan Cuti',
			'waktu' => $time
		);

		$jenisCuti = $this->M_permohonancuti->getJenisCuti($id_cuti);

		$edp = '';
		if ($jenisCuti == '4' || $jenisCuti == '5' || $jenisCuti == '6' || $jenisCuti == '7') {
			$edp = ', Seksi EDP';
		}
		$app2 = '';
		if (!$approval2 == NULL){
			$app2 = ', '.$getapp2['0']['nama'];
		}

		$thread2 = array(
			'lm_pengajuan_cuti_id' => $id_cuti,
			'status' => '1',
			'detail' => '(Set Approver) - Surat Permohonan Cuti ini telah dimintakan approve kepada '.$getapp1['0']['nama'].' '.$app2.' '.$edp,
			'waktu' => $time
		);

		$this->M_permohonancuti->updateRequest($id_cuti, $time, $thread, $thread2, $approval1);

		//for notification first Approval//
		$detailCuti = $this->M_permohonancuti->getDetailPengajuan($id_cuti);

		$address = $this->M_approval->getMail($approval1);
		$object = $getnama['0']['nama'];

		$id_cuti_enkripsi = $this->encrypt->encode($id_cuti);
		$link = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_cuti_enkripsi);
		$link = base_url('PermohonanCuti/Approval/Inprocess/Detail/'.$link);

		if(empty($detailCuti['0']['kp'])){
			$keperluan = $detailCuti['0']['keperluan'];
		}else{
			$keperluan = $detailCuti['0']['kp'];
		}

		$jenis = $detailCuti['0']['jenis'];
		$this->sendMail($address, $object, $link, $keperluan, $jenis);

		echo "Sukses";
	}

	public function updateAlamat(){
		$alamat = $_POST['alamat'];
		$id_cuti = $_POST['id'];
		$this->M_permohonancuti->updateAlamat($alamat, $id_cuti);
		echo "sukses";
	}

	public function Detail($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id_cuti = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$data['Title'] = 'Detail Cuti';
		$data['Menu'] = 'Detail Cuti';
		$data['SubMenuOne'] = 'Detail Cuti';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Info'] = $this->M_permohonancuti->getPekerja($noind);
		// $data['Edit'] = $this->M_approval->getEdit($id); not yet needed
		$data['Detail'] = $this->M_permohonancuti->getDetailPengajuan($id_cuti);
		$data['keterangan'] = $this->M_approval->getKeterangan($data['Detail'][0]['keterangan']);
		$data['Thread'] = $this->M_permohonancuti->getDetailThread($id_cuti);
		$data['TglAmbil'] = $this->M_permohonancuti->getDetailTglAmbil($id_cuti);
		$data['Approver'] = $this->M_permohonancuti->getDetailApprover($id_cuti);

		$tgl = array();
		for ($i=0; $i < count($data['TglAmbil']) ; $i++) {
			$tgl[$i] = date("d-M-Y",strtotime($data['TglAmbil'][$i]['tgl_pengambilan']));
		}

		$data['banyakcuti'] = count($data['TglAmbil']);
		$data['tglambil'] = implode(', ',$tgl);
		$data['tglambilhpl'] = date('d/M/Y',strtotime($data['TglAmbil']['0']['tgl_pengambilan'])).' - '.date("d/M/Y",strtotime(max($data['TglAmbil'])['tgl_pengambilan']));
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PermohonanCuti/DraftCuti/V_Detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function sendMail($address, $object, $link, $keperluan, $jenis){
		$now = date('d-m-y H:i:s');
		$Quick = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'mail.quick.com',
			'smtp_user' => 'no-reply@quick.com',
			'smtp_pass' => '123456',
			'priority'  => 1,
			'smtp_keepalive'=> true,
			'smtp_port' => 587,
			'crlf'      => "\r\n",
			'newline'   => "\r\n"
		];
		$this->load->library('email', $Quick);
		$this->email->from('no-reply', 'Email Sistem - Cuti');
		$this->email->to($address);
		$this->email->subject('Permintaan Approval Cuti');
		$this->email->message("
		<br>
      <b>Permintaan Approval Cuti Baru</b><br><br>
      <hr><br>
      Anda mendapat pengajuan approval cuti dari <b>".$object."</b>. Rincian cuti : <br><br>
			Jenis Cuti   : ".$jenis." <br>
			Keperluan	   : ".($keperluan==null? "-" : $keperluan)." <br>
			Status cuti  : Menunggu Approval anda <br><br>
			Klik <a href=".$link.">disini</a> untuk Melihat detail Cuti disini
			<br>
			<br>
			<br>
			<small>Email ini digenerate melalui QuickERP pada {$now}.</small>
			");
		$this->email->send();
	}

	public function PreviewCetak($id_cuti){ // preview for Hari Perkiraan Lahir Letter :v
		$id_cuti_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id_cuti);
		$id_cuti = $this->encrypt->decode($id_cuti_decode);
		//insert to sys.log_activity
		$aksi = 'Permohonan Cuti';
		$detail = "Preview Cetak HPL Cuti Istimewa id=$id_cuti";
		$this->log_activity->activity_log($aksi, $detail);
		//
		$data['data'] = $this->M_permohonancuti->getDataLampiran($id_cuti);
		$now = date('d-m-Y');
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$this->normalLineheight = 4;
		$pdf 	=	new mPDF('utf-8', array(216,297), 10, "timesnewroman", 20, 20, 20, 10, 0, 0, 'P');
		$filename = 'Surat_Pernyataan_HPL_'.$data['data']['noind'].'_'.$now.'.pdf';

		$html = $this->load->view('PermohonanCuti/Cetak/V_LampiranPDF',$data,true);
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->setTitle($filename);
		$pdf->Output($filename, "I");
	}

	public function changeKep()
	{
		$jenis = $_POST['jenis'];
		$id_cuti = $_POST['id_cuti'];
		$data = $_POST['data'];

		if($this->M_permohonancuti->changeKep($jenis, $id_cuti, $data)){
			echo "Keperluan telah diubah";
		};
	}

	public function getOtorisasiTahunan(){
		$noind = $this->session->user;
		$today = time();
		$mintglambil = "6";
		$tahun = date('Y');

		$jenisCuti = $_POST['jenis_cuti'];

		$susulanEnd = explode(" - ", $_POST['tanggalsusulan']);

		$ambilcuti = $_POST['tanggal'];

		$tglambilcuti = explode(",",$ambilcuti);

		function date_sort($a, $b){
			return strtotime($a) - strtotime($b);
		}
		usort($tglambilcuti, "date_sort");

		$tglbolehambil = $this->M_permohonancuti->getTglAmbil($noind);

		$ambil = new DateTime($tglambilcuti['0']);
		$boleh = new DateTime($tglbolehambil['0']['tgl_boleh_ambil']);

		$mindate = strtotime($tglambilcuti['0']);
		$difference = $mindate - $today;
		$days = floor($difference / (60*60*24) + 1);

		$sisacuti = $this->M_permohonancuti->getSisaCuti($noind,$tahun);

		//-------------------Otorisiasi Tahunan----------------//
		//istirahat tahunan//
		if ($jenisCuti == "2") {
			if($ambil < $boleh){ //benar
				$notif = "2";
			}
			elseif ($days <= $mintglambil){
				$notif = "3";
			}
		//istirahat tahunan mendadak//
		}elseif ($jenisCuti == "3") {
			if($ambil < $boleh){
				$notif = "2";
			}
			elseif($days > 6){
				$notif = "4";
			}
		//istirahat susulan//
		}elseif ($jenisCuti == "13") {
			$maxdate = strtotime($susulanEnd['1']);

			$difference = $maxdate - $today;

			$days = floor($difference / (60*60*24) + 1);
			$ambil = new DateTime($susulanEnd['0']);

			$ambilcuti = explode(" - ", $_POST['tanggalsusulan']);
			$before = date('d-m-Y', strtotime($ambilcuti['0']));
			$after = date('d-m-Y', strtotime($ambilcuti['1']));

			$start_date = $before;
			$end_date   = $after;

			$start    = new DateTime($start_date);
			$end      = new DateTime($end_date);
			$interval = new DateInterval('P1D');
			$period   = new DatePeriod($start, $interval, $end);

			$tglambilcuti = array();
			$i = '0';
			foreach ($period as $day) {
				$tglambilcuti[$i] = $day->format('Y-m-d');
				$i++;
			}
			array_push($tglambilcuti, date('Y-m-d', strtotime($end_date)));

			//dicekdulu tgl sekarang, cek statuspkj tgl sebelumnya, jika = pkj tidak bisa ambil cuti, jika = PSK bisa ambil
			$beforeToday = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 days'));
			$cekPSK = $this->M_permohonancuti->cekPSK($beforeToday, $_SESSION['user']);
			if($cekPSK > 0){
				$pkj = 0; //cek apakah hari yg diambil pkj
				foreach ($tglambilcuti as $key) {
					$cekPKJ = $this->M_permohonancuti->cekPKJ($key, $_SESSION['user']);
					if($cekPKJ > 0){
						$pkj = 1;
					}
				}
			}else{
				$pkj = 1;
			}

			if($pkj > 0){
				$notif = '13';
			}else{
				if($ambil < $boleh ){
					$notif = "2";
				}elseif ($days >= 0) {
					$notif = "5";
				}
			}

		}

		$banyakharicuti = count($tglambilcuti);

		if($sisacuti['0']['sisa_cuti'] == '0'){
			//do nothing//
		}else{
			if($banyakharicuti > $sisacuti['0']['sisa_cuti']){
				$notif = "6";
			}
		}

		$data = array(
			'1' => "Sisa Cuti = 0",
			'2' => "Pekerja Belum Memiliki Cuti",
			'3' => "Pengajuan Cuti Tahunan min. H-6 pengambilan cuti",
			'4' => "Bukan Merupakan Cuti Mendadak",
			'5' => "Bukan Merupakan Cuti Susulan",
			'6' => "Jumlah Pengambilan Cuti Melebihi Sisa Cuti",
			'7' => "Bukan kejadian yang Terencana",
			'8' => "Harus mengirimkan Dokumen(Bukti) ke seksi Hubker",
			'9' => "Jumlah Cuti Melebihi Ketentuan",
			'10' => "Bukan termasuk acara mendadak (Acara yang terencana)",
			'11' => "Harap mengirimkan surat HPL dari Dokter / Rumah sakit",
			'12' => "Membuat surat pernyatan siap menanggung resiko",
			'13' => "Cuti tidak bisa diinput"
		);
		if(!empty($notif)){
			$notif = $data[$notif];
		}else{
			$notif = "-";
		}
		$data['0'] = $notif;
		echo json_encode($data);
		if($notif == '-'){
			$id_cuti = $_POST['id_cuti'];
			$this->M_permohonancuti->resetTglCuti($id_cuti);
			for ($i=0; $i < count($tglambilcuti) ; $i++) {
				$tglambil = array(
					'lm_pengajuan_cuti_id' => $id_cuti,
					'tgl_pengambilan' => $tglambilcuti[$i]
				);
				$this->M_permohonancuti->insertTglAmbil($tglambil);
			}
		}
	}

	public function getOtorisasiIstimewa()
	{
		$jenisCuti = $_POST['jenis_cuti'];

		if(isset($_POST['tanggal'])) { //selain cm
			$ambilcuti = $_POST['tanggal'];
			$hakcuti = $_POST['hak_cuti'];

			//array tgl ambil//
			$tglambilcuti = explode(",",$ambilcuti);

			function date_sort($a, $b){
				return strtotime($a) - strtotime($b);
			}
			usort($tglambilcuti, "date_sort");

			$ambil = new DateTime($tglambilcuti['0']);

			$mindate = $tglambilcuti['0'];
			$mindate = strtotime($mindate);
			$today = time();
			$difference = $mindate - $today;
			$days = floor($difference / (60*60*24) );
			$mintglambil = "3";
			$noind = $this->session->user;
			$tahun = date('Y');
			$sisacuti = $this->M_permohonancuti->getSisaCuti($noind,$tahun);
		}
		if(isset($_POST['hpl'])){ // ini cm
			$hpl = $_POST['hpl'];
			$before = $_POST['before'];
			$after = $_POST['after'];
			$hakcuti = 91;
		}

		//-------------------Otorisiasi Istimewa----------------//
		//1,2,4//
		$notif='';
		if ($jenisCuti == '4' OR $jenisCuti == '5' OR $jenisCuti == '7') {
			if($difference <= 0){
				// do nothing
			}else{
				$notif = '7';
			}
		}elseif ($jenisCuti == '6') {
			$ambil1 = $before;
			$ambil2 = $after;
			$jumlah = $before+$after;

			$date = date_create($hpl);
			$date1 = date_create($hpl);
			$before = '-'.$before;
			$after = $after;
			$before = date_add($date,date_interval_create_from_date_string($before."days"));
			$after =  date_add($date1,date_interval_create_from_date_string($after."days"));
			$before = date_format($before, 'd-m-Y');
			$after = date_format($after, 'd-m-Y');
			$beforeHPL = date('d F Y', strtotime($before));
			$afterHPL = date('d F Y', strtotime($after));

			if($jumlah > '90'){
				$notif = '9';
			}
		}elseif ($jenisCuti == "8" OR $jenisCuti == "9" OR $jenisCuti == "10" OR $jenisCuti == "12") {
			if($days < '3'){
				$notif = '10';
			}
		}elseif ($jenisCuti == '11'){
			if (count($tglambilcuti) > $hakcuti ){
				$notif = '9';
			}
		}
		if(isset($tglambilcuti)){
			if(count($tglambilcuti) > $hakcuti){
				$notif = '9';
			}
		}

		$data = array(
			'1' => "Sisa Cuti = 0",
			'2' => "Pekerja Belum Memiliki Cuti",
			'3' => "Pengajuan Cuti Tahunan min. H-6 pengambilan cuti",
			'4' => "Bukan Merupakan Cuti Mendadak",
			'5' => "Bukan Merupakan Cuti Susulan",
			'6' => "Jumlah Pengambilan Cuti Melebihi Sisa Cuti",
			'7' => "Bukan kejadian yang Terencana",
			'8' => "Harus mengirimkan Dokumen(Bukti) ke seksi Hubker",
			'9' => "Jumlah Cuti Melebihi Ketentuan",
			'10' => "Bukan termasuk acara mendadak (Acara yang terencana)",
			'11' => "Harap mengirimkan surat HPL dari Dokter / Rumah sakit",
			'12' => "Membuat surat pernyatan siap menanggung resiko"
		);
		if(!empty($notif)){
			$notif = $data[$notif];
		}else{
			$notif = "-";
		}

		if($jenisCuti == '6'){ // kirim ke ajax
			$data = array();
			$data['0'] = $notif;
			$data['1'] = $beforeHPL;
			$data['2'] = $afterHPL;
			$data['3'] = $ambil1;
			$data['4'] = $ambil2;
			$data['5'] = $jumlah;
			echo json_encode($data);
		}else{
			$data = array();
			$data['0'] = $notif;
			echo json_encode($data);
		}

		if($notif == '-'){
			$id_cuti = $_POST['id_cuti'];
			$this->M_permohonancuti->resetTglCuti($id_cuti);
			//insert to sys.log_activity
			$aksi = 'Permohonan Cuti';
			$detail = "Update Cuti Istimewa id=$id_cuti";
			$this->log_activity->activity_log($aksi, $detail);
			//

			if(isset($hpl)){
				$start_date = $before;
				$end_date   = $after;

				$start    = new DateTime($start_date);
				$end      = new DateTime($end_date);
				$interval = new DateInterval('P1D');
				$period   = new DatePeriod($start, $interval, $end);

				$hpl = array();
				$i = '0';
				foreach ($period as $day) {
					$hpl[$i] = $day->format('Y-m-d');
					$i++;
				}
				array_push($hpl, date('Y-m-d', strtotime($end_date)));

				$banyak = count($hpl);

				for ($i=0; $i < $banyak ; $i++) {
					$ambil = array(
						'lm_pengajuan_cuti_id' => $id_cuti,
						'tgl_pengambilan' => $hpl[$i]
					);
					$this->M_permohonancuti->insertTglAmbil($ambil);
				}
			}else{
				for ($i=0; $i < count($tglambilcuti) ; $i++) {
					$tglambil = array(
						'lm_pengajuan_cuti_id' => $id_cuti,
						'tgl_pengambilan' => $tglambilcuti[$i]
					);
					$this->M_permohonancuti->insertTglAmbil($tglambil);
				}
			}
		}
	}
}
