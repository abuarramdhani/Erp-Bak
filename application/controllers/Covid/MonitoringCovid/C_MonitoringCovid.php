<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_MonitoringCovid extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Covid/MonitoringCovid/M_monitoringcovid');
		$this->load->model('MasterPekerja/Surat/IsolasiMandiri/M_isolasimandiri');
		date_default_timezone_set('Asia/Jakarta');

		// $this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Monitoring Covid';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'Monitoring Covid';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if (isset($_GET['status']) && !empty($_GET['status'])) {
			$status = $_GET['status'];
			if ($status == "0") {
				$data['data'] = $this->M_monitoringcovid->getPekerjaAll();
			}else{
				$data['data'] = $this->M_monitoringcovid->getPekerjaByStatus($status);
			}
			$data['status_kondisi'] = $status;
		}else{
			$data['data'] = $this->M_monitoringcovid->getPekerjaAll();
			$data['status_kondisi'] = '0';
		}

		$status_baru = $this->M_monitoringcovid->getPekerjaByStatus('1');
		if (!empty($status_baru)) {
			foreach ($status_baru as $br) {
				if (!empty($br['selesai_isolasi'])) {
					if (strtotime($br['mulai_isolasi']) <= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= strtotime($br['selesai_isolasi']." - 1 day")) {
						$this->M_monitoringcovid->updateStatusPekerjaById(2,$br['cvd_pekerja_id']);
					}elseif (strtotime(date('Y-m-d')) >= strtotime($br['selesai_isolasi'])) {
						$this->M_monitoringcovid->updateStatusPekerjaById(3,$br['cvd_pekerja_id']);
					}
				}
			}
		}
		$status_pemantauan = $this->M_monitoringcovid->getPekerjaByStatus('2');
		if (!empty($status_pemantauan)) {
			foreach ($status_pemantauan as $pt) {
				if (!empty($pt['selesai_isolasi'])) {
					if (strtotime(date('Y-m-d')) >= strtotime($pt['selesai_isolasi'])) {
						$this->M_monitoringcovid->updateStatusPekerjaById(3,$pt['cvd_pekerja_id']);
					}
				}
			}
		}

		$data['status'] = $this->M_monitoringcovid->getStatusKondisi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Monitoring Covid';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'Monitoring Covid';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$key = $this->input->get('term');
		$data = $this->M_monitoringcovid->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function getDetailPekerja(){
		$noind = $this->input->get('noind');
		$data = $this->M_monitoringcovid->getpekerjaDetailByNoind($noind);
		if (!empty($data)) {
			$result = array(
				'seksi' 	=> $data->seksi,
				'dept' 		=> $data->dept,
				'status' 	=> 'success'
			);
		}else{
			$result = array(
				'status' => 'failed'
			);
		}
		echo json_encode($result);
	}

	public function simpan(){
		$this->load->library('upload');
		$noind 				= $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja');
		$kasus 				= $this->input->post('txt-CVD-MonitoringCovid-Tambah-Kasus');
		$tgl_interaksi 		= $this->input->post('txt-CVD-MonitoringCovid-Tambah-TanggalInteraksi');
		$keterangan  		= $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan');
		$hasil_wawancara  	= $this->input->post('txa-CVD-MonitoringCovid-Tambah-Wawancara');
		$pekerja_id 		= $this->input->post('txt-CVD-MonitoringCovid-Tambah-PekerjaId');

		if (isset($pekerja_id) && !empty($pekerja_id)) {

			$data = array(
				'noind' 			=> $noind,
				'tgl_interaksi' 	=> $tgl_interaksi,
				'kasus' 			=> $kasus,
				'keterangan' 		=> $keterangan,
				'updated_by' 		=> $this->session->user,
				'updated_date' 		=> date('Y-m-d H:i:s')
			);
			
			$this->M_monitoringcovid->updatePekerjaById($data,$pekerja_id);

			$wawancara = $this->M_monitoringcovid->getWawancaraIsolasiByPekerjaId($pekerja_id);
			$id_wawancara = $wawancara->wawancara_id;
			$data = array(
				'hasil_wawancara' => $hasil_wawancara,
				'updated_date' => date('Y-m-d H:i:s'),
				'updated_by' => $this->session->user
			);
			$this->M_monitoringcovid->updateWawancaraById($data, $id_wawancara);

			$this->load->library('upload');

			foreach ($_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'] as $key_lamp => $val_lamp) {
				
				if (!empty($_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'][$key_lamp])) {
					$_FILES['lampiranWawancara'.$key_lamp]['name']		= str_replace(' ', '_', $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'][$key_lamp]);
					$_FILES['lampiranWawancara'.$key_lamp]['type']		= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['type'][$key_lamp];
					$_FILES['lampiranWawancara'.$key_lamp]['tmp_name']	= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['tmp_name'][$key_lamp];
					$_FILES['lampiranWawancara'.$key_lamp]['error']		= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['error'][$key_lamp];
					$_FILES['lampiranWawancara'.$key_lamp]['size']		= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['size'][$key_lamp];    

					$filename						= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'][$key_lamp];
					$ekstensi						= pathinfo($filename,PATHINFO_EXTENSION);
					$nama 							= str_replace(array(".".$ekstensi," "),array("","_"), $filename)."_".time().".".$ekstensi;
					$nama 							= str_replace('.', '_', $nama);
					$nama 							= str_replace('_'.$ekstensi, '.'.$ekstensi, $nama);
					$config['upload_path']          = './assets/upload/Covid/Wawancara/';
					$config['allowed_types']        = 'jpg|png|gif|bmp|jpeg|jpe|tiff|tif|svg|cdr|psd';
					$config['file_name']		 	= $nama;
					$config['max_size']			 	= '20000';
					$config['overwrite'] 			= TRUE;
					$this->upload->initialize($config);
		    		if ($this->upload->do_upload('lampiranWawancara'.$key_lamp))
		    		{
		        		$uploaded = $this->upload->data();
		        		
						$lampiran = array(
							'wawancara_id' => $id_wawancara,
							'lampiran_nama' => $filename,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => $this->session->user,
							'lampiran_path' => 'assets/upload/Covid/Wawancara/'.$uploaded['file_name']
						);
						$this->M_monitoringcovid->insertLampiran($lampiran);
		    		}
		    		else
		    		{
		    			$errorinfo = $this->upload->display_errors();
		    			echo $errorinfo;exit();
		    		}
				}
			}
		}else{
			$data = array(
				'noind' 			=> $noind,
				'tgl_interaksi' 	=> $tgl_interaksi,
				'kasus' 			=> $kasus,
				'keterangan' 		=> $keterangan,
				'created_by' 		=> $this->session->user,
				'created_date' 		=> date('Y-m-d H:i:s'),
				'status_kondisi_id' => 1
			);

			$id_pekerja = $this->M_monitoringcovid->insertPekerja($data);

			$data = array(
				'cvd_pekerja_id' 	=> $id_pekerja,
				'hasil_wawancara' 	=> $hasil_wawancara,
				'jenis'				=> 1,
				'created_date' 		=> date('Y-m-d H:i:s'),
				'created_by' 		=> $this->session->user
			);

			$id_wawancara = $this->M_monitoringcovid->insertWawancara($data);

			foreach ($_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'] as $key_lamp => $val_lamp) {
				
				if (!empty($_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'][$key_lamp])) {
					$_FILES['lampiranWawancara'.$key_lamp]['name']		= str_replace(' ', '_', $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'][$key_lamp]);
					$_FILES['lampiranWawancara'.$key_lamp]['type']		= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['type'][$key_lamp];
					$_FILES['lampiranWawancara'.$key_lamp]['tmp_name']	= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['tmp_name'][$key_lamp];
					$_FILES['lampiranWawancara'.$key_lamp]['error']		= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['error'][$key_lamp];
					$_FILES['lampiranWawancara'.$key_lamp]['size']		= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['size'][$key_lamp];    

					$filename						= $_FILES['file-CVD-MonitoringCovid-Tambah-Lampiran']['name'][$key_lamp];
					$ekstensi						= pathinfo($filename,PATHINFO_EXTENSION);
					$nama 							= str_replace(array(".".$ekstensi," "),array("","_"), $filename)."_".time().".".$ekstensi;
					$nama 							= str_replace('.', '_', $nama);
					$nama 							= str_replace('_'.$ekstensi, '.'.$ekstensi, $nama);
					$config['upload_path']          = './assets/upload/Covid/Wawancara/';
					$config['allowed_types']        = 'jpg|png|gif|bmp|jpeg|jpe|tiff|tif|svg|cdr|psd';
					$config['file_name']		 	= $nama;
					$config['max_size']			 	= '20000';
					$config['overwrite'] 			= TRUE;
					$this->upload->initialize($config);
		    		if ($this->upload->do_upload('lampiranWawancara'.$key_lamp))
		    		{
		        		$uploaded = $this->upload->data();
		        		
						$lampiran = array(
							'wawancara_id' => $id_wawancara,
							'lampiran_nama' => $filename,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => $this->session->user,
							'lampiran_path' => 'assets/upload/Covid/Wawancara/'.$uploaded['file_name']
						);
						$this->M_monitoringcovid->insertLampiran($lampiran);
		    		}
		    		else
		    		{
		    			$errorinfo = $this->upload->display_errors();
		    			echo $errorinfo;exit();
		    		}
				}
			}
		}
		redirect(base_url('Covid/MonitoringCovid'));
	}

	public function uploadRedactor(){
	   $config = array('upload_path' => './assets/upload/Covid/Redactor/',
	                'upload_url' => base_url('assets/upload/Covid/Redactor/'),
	                'allowed_types' => 'jpg|gif|png',
	                'overwrite' => false,
	    );

	    $this->load->library('upload', $config);

	    if ($this->upload->do_upload('file')) {
	        $data = $this->upload->data();
	        $array = array(
	            'filelink' => $config['upload_url'] .'/'. $data['file_name']
	        );
	        echo stripslashes(json_encode($array));
	    } else {
	        echo json_encode(array('error' => $this->upload->display_errors('', '')));
	    }
	}

	public function hapus(){
		$encrypted_id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$status = $this->input->get('status');
		$pkj = $this->M_monitoringcovid->getDetailcvdPekerja($plaintext_string);
		if (!empty($pkj['mulai_isolasi']) || !empty($pkj['selesai_isolasi'])) {
			$dataPrez = $this->M_isolasimandiri->getDataPresensiIs2($pkj['noind'], $pkj['mulai_isolasi'], $pkj['selesai_isolasi']);
			// exit();
			$mulai =  $pkj['mulai_isolasi'];
			$selesai =  $pkj['selesai_isolasi'];
			$pekerja =  $pkj['noind'];
			$arl = array(
				'wkt'	=>	date('Y-m-d H:i:s'),
				'transaksi'	=>	'DELETE DATA Presensi & edit presensi tanggal '.$mulai.' sampai '.$selesai.' noind '.$pekerja,
				'keterangan'	=>	json_encode($dataPrez),
				'program'	=>	'TIM-COVID19->MonitoringCovid',
				'tgl_proses'	=>	date('Y-m-d H:i:s'),
				);
			$this->M_isolasimandiri->instoLog2($arl);
		}

		if (!empty($pkj['isolasi_id'])) {
			$surat = $this->M_monitoringcovid->getSuratIs($pkj['isolasi_id']);
			$del = $this->M_monitoringcovid->delSuratIs($pkj['noind'], $surat['status'], $surat['tgl_mulai'], $surat['tgl_selesai']);
			$del = $this->M_monitoringcovid->delSuratIs2($pkj['noind'], $surat['status'], $surat['tgl_mulai'], $surat['tgl_selesai']);
			$del = $this->M_monitoringcovid->delwktIs($pkj['isolasi_id']);
		}
		$this->M_monitoringcovid->deletePekerjaById($plaintext_string);


		$result = array(
			'status' => 'sukses'
		);
		echo json_encode($result);
	}

	public function WawancaraIsolasi($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		// echo $plaintext_string;

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['id'] = $encrypted_id;
		$data['data'] = $this->M_monitoringcovid->getPekerjaById($plaintext_string);
		$data['wawancara'] = $this->M_monitoringcovid->getWawancaraIsolasiByPekerjaId($plaintext_string);
		$data['lampiran'] = $this->M_monitoringcovid->getLampiranByWawancaraId($data['wawancara']->wawancara_id);
		
		$this->load->library('pdf');

	    $pdf = $this->pdf->load();
	    $pdf = new mPDF('utf-8', 'A4', 10, '', 5, 5, 23, 15, 5, 5, 'P');
	    $tanggal = date('Y-m-d');
	    $data['tanggal'] = strftime('%d %h %Y');
	    $waktu = date('H:i:s');
	    $tanggal_hari = strftime('%d/%h/%Y %H:%M:%S %Z');
	    $filename = 'WAWANCARA_ISOLASI_'.$data['data']->noind.'_'.$data['data']->kasus.'_'.$tanggal.'.pdf';
	    // $this->load->view('Covid/MonitoringCovid/V_wawancaraisolasi', $data);
	    $html = $this->load->view('Covid/MonitoringCovid/V_wawancaraisolasi', $data, true);
	    // print_r($html);exit();
	    $pdf->SetHTMLFooter("<table  style='width: 100%;border-collapse: collapse'>
			<tr>
				<td style='width: 10%;padding-left: 3px;'>
					<i style='font-size: 8pt'>Halaman ini dicetak melalui QuickERP - Tim Covid oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".$tanggal_hari.". </i>
				</td>
				<td style='width: 14%;padding-right: 3px;text-align: right'>{PAGENO} / {nb}</td>
			</tr>
		</table>");
	    $pdf->SetHTMLHeader("<table  style='width: 100%;border-collapse: collapse'>
				<tr>
					<td rowspan='3' style='width: 7%;border: 1px solid black;'>
						<img src='".base_url('assets/img/logo.png')."' style='width: 50px;height: auto;'>
					</td>
					<td rowspan='3' style='text-align: center;vertical-align: middle;width: 68%;border: 1px solid black;'>
						<h2>BERITA ACARA WAWANCARA PEKERJA</h2>
						<h2><span style='color: red'>NON</span>-ISOLASI COVID 19 CV. KHS</h2>
					</td>
					<td style='width: 10%;border: 1px solid black;border-right: 1px solid white;padding-left: 3px;'>No. Form</td>
					<td style='width: 1%;border: 1px solid black;border-left: 1px solid white;'>:</td>
					<td style='width: 14%;border: 1px solid black;'></td>
				</tr>
				<tr>
					<td style='width: 10%;border: 1px solid black;border-right: 1px solid white;padding-left: 3px;'>Tanggal</td>
					<td style='width: 1%;border: 1px solid black;border-left: 1px solid white;'>:</td>
					<td style='width: 14%;border: 1px solid black;padding-left: 3px;'>".$data['tanggal']."</td>
				</tr>
				<tr>
					<td style='width: 10%;border: 1px solid black;border-right: 1px solid white;padding-left: 3px;'>Halaman</td>
					<td style='width: 1%;border: 1px solid black;border-left: 1px solid white;'>:</td>
					<td style='width: 14%;border: 1px solid black;padding-left: 3px;'>{PAGENO} / {nb}</td>
				</tr>
			</table>");
	    $pdf->WriteHTML('
		.pnomargin p{
			margin: 0px;
		}', 1);
	    $pdf->WriteHTML($html, 2);
	    $pdf->Output($filename, 'I');
	}

	public function MemoIsolasi($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$isolasi_id = $this->M_monitoringcovid->getPekerjaById($plaintext_string);
		// echo "<pre>";print_r($isolasi_id);exit();

		$data['memo'] = $this->M_monitoringcovid->getMemoIsolasiMandiriByPekerjaid($isolasi_id->isolasi_id);
		// print_r($data['memo'] );exit();
		$this->load->library('pdf');

	    $pdf = $this->pdf->load();
	    $pdf = new mPDF('utf-8', 'A4', 10, 'verdana', 20, 20, 45, 10, 10, 5, 'P');
	    $tanggal = date('Y-m-d');
	    $data['tanggal'] = strftime('%d %h %Y');
	    $waktu = date('H:i:s');
	    $tanggal_hari = strftime('%d/%h/%Y %H:%M:%S %Z');
	    $filename = 'WAWANCARA_ISOLASI_'.$data['data']->noind.'_'.$data['data']->kasus.'_'.$tanggal.'.pdf';
	    // $this->load->view('Covid/MonitoringCovid/V_wawancaraisolasi', $data);
	    // $html = $this->load->view('Covid/MonitoringCovid/V_wawancaraisolasi', $data, true);
	    $pdf->SetHTMLFooter("<table  style='width: 100%;border-collapse: collapse'>
			<tr>
				<td style='width: 10%;padding-left: 3px;'>
					<i style='font-size: 8pt'>Halaman ini dicetak melalui QuickERP - Tim Covid oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".$tanggal_hari.". </i>
				</td>
				<td style='width: 14%;padding-right: 3px;text-align: right'>{PAGENO} / {nb}</td>
			</tr>
		</table>");
	    $pdf->SetHTMLHeader("<table style='width: 100%;'>
				<tr>
					<td style='width: 20%;'>
						<img src='".base_url('assets/img/logo.png')."' style='width: 80px;height: auto;'>
					</td>
					<td style='vertical-align: middle;width: 80%;'>
						<h2>TIM PENCEGAHAN PENULARAN VIRUS COVID 19</h2>
						<h1>CV KARYA HIDUP SENTOSA</h1>
					</td>
				</tr>
			</table>
			<div style='background-color: black; height: 2px;'></div>
			<div style='background-color: black; height: 2px;margin-top: 2px;'></div>");
	    $pdf->WriteHTML(str_replace("MEMO", "", $data['memo']->isi_surat), 2);
	    $pdf->Output($filename, 'I');
	}

	public function TidakIsolasi($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_monitoringcovid->updateStatusPekerjaById(5,$plaintext_string);
		redirect(base_url('Covid/MonitoringCovid'));
	}

	public function edit($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Monitoring Covid';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'Monitoring Covid';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $encrypted_id;
		$data['data'] = $this->M_monitoringcovid->getPekerjaById($plaintext_string);
		$data['wawancara'] = $this->M_monitoringcovid->getWawancaraIsolasiByPekerjaId($plaintext_string);
		if (!empty($data['wawancara'])) {
			$data['lampiran'] = $this->M_monitoringcovid->getLampiranByWawancaraId($data['wawancara']->wawancara_id);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function FollowUp($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Monitoring Covid';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'Monitoring Covid';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $encrypted_id;
		$data['data'] = $this->M_monitoringcovid->getPekerjaById($plaintext_string);
		$data['wawancara'] = $this->M_monitoringcovid->getWawancaraMasukByPekerjaId($plaintext_string);
		if (!empty($data['wawancara'])) {
			$data['lampiran'] = $this->M_monitoringcovid->getLampiranByWawancaraId($data['wawancara']->wawancara_id);
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_followup',$data);
		$this->load->view('V_Footer',$data);
	}

	public function WawancaraMasuk($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $encrypted_id;
		$data['data'] = $this->M_monitoringcovid->getPekerjaById($plaintext_string);
		$data['wawancara'] = $this->M_monitoringcovid->getWawancaraMasukByPekerjaId($plaintext_string);
		if (!empty($data['wawancara'])) {
			$data['lampiran'] = $this->M_monitoringcovid->getLampiranByWawancaraId($data['wawancara']->wawancara_id);
		}

		$this->load->library('pdf');

	    $pdf = $this->pdf->load();
	    $pdf = new mPDF('utf-8', 'A4', 10, '', 5, 5, 23, 15, 5, 5, 'P');
	    $tanggal = date('Y-m-d');
	    $data['tanggal'] = strftime('%d %h %Y');
	    $waktu = date('H:i:s');
	    $tanggal_hari = strftime('%d/%h/%Y %H:%M:%S %Z');
	    $filename = 'WAWANCARA_MASUK_'.$data['data']->noind.'_'.$data['data']->kasus.'_'.$tanggal.'.pdf';
	    // $this->load->view('Covid/MonitoringCovid/V_wawancaramasuk', $data);
	    $html = $this->load->view('Covid/MonitoringCovid/V_wawancaramasuk', $data, true);
	    $pdf->SetHTMLFooter("<table  style='width: 100%;border-collapse: collapse'>
			<tr>
				<td style='width: 10%;padding-left: 3px;'>
					<i style='font-size: 8pt'>Halaman ini dicetak melalui QuickERP - Tim Covid oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".$tanggal_hari.". </i>
				</td>
				<td style='width: 14%;padding-right: 3px;text-align: right'>{PAGENO} / {nb}</td>
			</tr>
		</table>");
	    $pdf->SetHTMLHeader("<table  style='width: 100%;border-collapse: collapse'>
				<tr>
					<td rowspan='3' style='width: 7%;border: 1px solid black;'>
						<img src='".base_url('assets/img/logo.png')."' style='width: 50px;height: auto;'>
					</td>
					<td rowspan='3' style='text-align: center;vertical-align: middle;width: 68%;border: 1px solid black;'>
						<h2>BERITA ACARA WAWANCARA PEKERJA</h2>
						<h2>ISOLASI COVID 19 CV. KHS</h2>
					</td>
					<td style='width: 10%;border: 1px solid black;border-right: 1px solid white;padding-left: 3px;'>No. Form</td>
					<td style='width: 1%;border: 1px solid black;border-left: 1px solid white;'>:</td>
					<td style='width: 14%;border: 1px solid black;'></td>
				</tr>
				<tr>
					<td style='width: 10%;border: 1px solid black;border-right: 1px solid white;padding-left: 3px;'>Tanggal</td>
					<td style='width: 1%;border: 1px solid black;border-left: 1px solid white;'>:</td>
					<td style='width: 14%;border: 1px solid black;padding-left: 3px;'>".$data['tanggal']."</td>
				</tr>
				<tr>
					<td style='width: 10%;border: 1px solid black;border-right: 1px solid white;padding-left: 3px;'>Halaman</td>
					<td style='width: 1%;border: 1px solid black;border-left: 1px solid white;'>:</td>
					<td style='width: 14%;border: 1px solid black;padding-left: 3px;'>{PAGENO} / {nb}</td>
				</tr>
			</table>");
	    $pdf->WriteHTML($html, 2);
	    $pdf->Output($filename, 'I');
	}

	public function simpanWawancaraMasuk($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$hasil_wawancara = $this->input->post('hasilWawancara');
		$id_wawancara = $this->input->post('idWawancara');
		if (isset($id_wawancara) && !empty($id_wawancara)) {
			$updateWawancara = array(
				'hasil_wawancara' 	=> $hasil_wawancara,
				'updated_date' 		=> date('Y-m-d H:i:s'),
				'updated_by' 		=> $this->session->user
			);
			$this->M_monitoringcovid->updateWawancaraById($updateWawancara, $id_wawancara);
		}else{
			$insertWawancara = array(
				'cvd_pekerja_id' => $plaintext_string,
				'hasil_wawancara' => $hasil_wawancara,
				'created_date' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->user,
				'jenis' => 2
			);
			$id_wawancara = $this->M_monitoringcovid->insertWawancara($insertWawancara);
		}

		$this->M_monitoringcovid->updateStatusPekerjaById(4,$plaintext_string);

		$this->load->library('upload');

		foreach ($_FILES['lampiranWawancara']['name'] as $key_lamp => $val_lamp) {
			// echo $val_lamp;
			if (!empty($_FILES['lampiranWawancara']['name'][$key_lamp])) {
				$_FILES['lampiranWawancara'.$key_lamp]['name']		= str_replace(' ', '_', $_FILES['lampiranWawancara']['name'][$key_lamp]);
				$_FILES['lampiranWawancara'.$key_lamp]['type']		= $_FILES['lampiranWawancara']['type'][$key_lamp];
				$_FILES['lampiranWawancara'.$key_lamp]['tmp_name']	= $_FILES['lampiranWawancara']['tmp_name'][$key_lamp];
				$_FILES['lampiranWawancara'.$key_lamp]['error']		= $_FILES['lampiranWawancara']['error'][$key_lamp];
				$_FILES['lampiranWawancara'.$key_lamp]['size']		= $_FILES['lampiranWawancara']['size'][$key_lamp];    

				$filename						= $_FILES['lampiranWawancara']['name'][$key_lamp];
				$ekstensi						= pathinfo($filename,PATHINFO_EXTENSION);
				$nama 							= str_replace(array(".".$ekstensi," "),array("","_"), $filename)."_".time().".".$ekstensi;
				$config['upload_path']          = './assets/upload/Covid/Wawancara/';
				$config['allowed_types']        = 'jpg|png|gif|bmp|jpeg|jpe|tiff|tif|svg|cdr|psd';
				$config['file_name']		 	= $nama;
				$config['max_size']			 	= '20000';
				$config['overwrite'] 			= TRUE;
				$this->upload->initialize($config);
	    		if ($this->upload->do_upload('lampiranWawancara'.$key_lamp))
	    		{
	        		$uploaded = $this->upload->data();
	        		
					$lampiran = array(
						'wawancara_id' => $id_wawancara,
						'lampiran_nama' => $filename,
						'created_date' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->user,
						'lampiran_path' => 'assets/upload/Covid/Wawancara/'.$uploaded['file_name']
					);
					$this->M_monitoringcovid->insertLampiran($lampiran);
	    		}
	    		else
	    		{
	    			$errorinfo = $this->upload->display_errors();
	    			echo $errorinfo;
	    		}
			}
		}
		redirect(base_url('Covid/MonitoringCovid/'));
	}

	public function CekAbsensiPrm()
	{
		$encrypted_id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$status = $this->input->get('status');

		$pkj = $this->M_monitoringcovid->getDetailcvdPekerja($plaintext_string);
		if (!empty($pkj['isolasi_id'])) {
			$surat = $this->M_monitoringcovid->getSuratIs($pkj['isolasi_id']);
			$getAbsen = $this->M_monitoringcovid->getAbsenIs($pkj['noind'], $surat['status'], $surat['tgl_mulai'], $surat['tgl_selesai']);
			if (!empty($getAbsen)) {
				echo "1";
			}else{
				echo "0";
			}
		}else{
			echo '0';
		}
		// $dataAbsen = $this->M_monitoringcovid->getAbsenPRM($);
	}

	public function delAttch()
	{
		$id = $this->input->post('id');
		$del = $this->M_monitoringcovid->delAttchcvd($id);
		echo $del;
	}

	public function Tracing(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Tim Covid 19';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/V_Index',$data); -
		$this->load->view('V_Footer',$data);
	}

	public function DiriSendiri(){
		$user_id = $this->session->userid;
		$user = $this->session->user;
		$data['Title']			=	'Diri Sendiri';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_List_Diri_Sendiri',$data);
		// $this->load->view('Covid/MonitoringCovid/V_Inputdirisendiri',$data);
		$this->load->view('V_Footer',$data);
	}

	public function AnggotaKeluargaSerumah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Tim Covid 19';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_Inputanggotakeluarga',$data);
		$this->load->view('V_Footer',$data);
	}

	public function KedatanganTamu(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Tim Covid 19';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_Inputkedatangantamu',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Melaksanakan(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Tim Covid 19';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_Inputmelaksanakanacara',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Menghadiri(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Tim Covid 19';
		$data['Header']			=	'Tim Covid 19';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/MonitoringCovid/V_Inputmenghadiriacara',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getAtasan($value='')
	{
		$nid = $this->input->post('noind');
		echo json_encode($this->M_monitoringcovid->getApprover($nid));
	}

	public function insertDiriSendiri()
	{
		$covid_menginap = $this->input->post('covid_menginap');
		if($covid_menginap == 1)
		{
			$covid_menginap = 'Ya';
		}
		else {
			$covid_menginap = 'Tidak';
		}

		$covid_sakit_kembali = $this->input->post('covid_sakit_kembali');
		if($covid_sakit_kembali == 1)
		{
			$covid_sakit_kembali = 'Ya';
		}
		else {
			$covid_sakit_kembali = 'Tidak';
		}

		$covid_sakit = $this->input->post('covid_sakit');
		if($covid_sakit == 1)
		{
			$covid_sakit = 'Ya';
		}
		else {
			$covid_sakit = 'Tidak';
		}

		$covid_interaksi = $this->input->post('covid_interaksi');

		if($covid_interaksi == 1)
		{
			$covid_interaksi = 'Ya';
		}
		else {
			$covid_interaksi = 'Tidak';
		}
		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Departemen'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'wilayah' => $this->input->post('Wilayah'),
		'transportasi' => $this->input->post('Transportasi'),
		'anggota' => $this->input->post('Anggota'),
		'tujuan_alasan' => $this->input->post('Tujuan_Alasan'),
		'aktivitas' => $this->input->post('txt-CVD-Aktifitas'),
		'prokes' => $this->input->post('txt-CVD-Prokes'),
		'covid_menginap' => $covid_menginap,
		'nbr_jumlah_hari' => $this->input->post('nbr-jumlah-hari'),
		'covid_sakit' => $covid_sakit,
		'penyakit' => $this->input->post('txt-CVD-Penyakit'),
		'covid_sakit_kembali' => $covid_sakit_kembali,
		'penyakit_kembali' => $this->input->post('txt-CVD-Penyakit_kembali'),
		'covid_interaksi' => $covid_interaksi,
		'kasusinsertmeng' => 'DIRI SENDIRI KE LUAR KOTA',
		'jenis_interaksi' => $this->input->post('txt-CVD-Jenis_interaksi'),
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$wawancara = "<p>Wilayah : ".$data['wilayah'].'<br>'.
		"Transportasi : ".$data['transportasi'].'<br>'.
		"Yang ikut : ".$data['anggota'].'<br>'.
		"Tujuan alasan : ".$data['tujuan_alasan'].'<br>'.
		"Aktifitas : ".$data['aktivitas'].'<br>'.
		"Protokol : ".$data['prokes'].'<br>'.
		"Menginap : ".$data['covid_menginap'].','.$data['nbr_jumlah_hari'].'<br>'.
		"Yang dikunjungi sakit : ".$data['covid_sakit'].','.$data['penyakit'].'<br>'.
		"Sakit Setelah kembali : ".$data['covid_sakit_kembali'].','.$data['penyakit_kembali'].'<br>'.
		"Interaksi probable covid : ".$data['covid_interaksi'].','.$data['jenis_interaksi']."</p>";
		$data['wawancara'] = $wawancara;

		$id_wawancara = $this->M_monitoringcovid->insertDiriSendiri($data, $user);
		// $id_wawancara = 233;
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'diri_sendiri') {
			redirect('Covid/PelaporanPekerja/LuarKota/diri_sendiri');
		}else{

		}
	}




	public function insertAnggotaKeluarga($value='')
	{
		$covid_menginap = $this->input->post('covid_menginap');
		if($covid_menginap == 1)
		{
			$covid_menginap = 'Ya';
		}
		else {
			$covid_menginap = 'Tidak';
		}

		$covid_sakit_kembali = $this->input->post('covid_sakit_kembali');
		if($covid_sakit_kembali == 1)
		{
			$covid_sakit_kembali = 'Ya';
		}
		else {
			$covid_sakit_kembali = 'Tidak';
		}

		$covid_interaksi = $this->input->post('covid_interaksi');
		if($covid_interaksi == 1)
		{
			$covid_interaksi = 'Ya';
		}
		else {
			$covid_interaksi = 'Tidak';
		}
		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Departemen'),
		'status_anggota' => $this->input->post('Status_anggota'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'wilayah' => $this->input->post('Wilayah'),
		'transportasi' => $this->input->post('Transportasi'),
		'anggota' => $this->input->post('Anggota'),
		'tujuan_alasan' => $this->input->post('Tujuan_Alasan'),
		'aktivitas' => $this->input->post('txt-CVD-Aktifitas'),
		'prokes' => $this->input->post('txt-CVD-Prokes'),
		'covid_menginap' => $covid_menginap,
		'nbr_jumlah_hari' => $this->input->post('nbr-jumlah-hari'),
		'covid_sakit' => $this->input->post('covid_sakit'),
		'penyakit' => $this->input->post('txt-CVD-Penyakit'),
		'covid_sakit_kembali' => $covid_sakit_kembali,
		'penyakit_kembali' => $this->input->post('txt-CVD-Penyakit_kembali'),
		'covid_interaksi' => $covid_interaksi,
		'kasus' => 'ANGGOTA KELUARGA KE LUAR KOTA',
		'jenis_interaksi' => $this->input->post('txt-CVD-Jenis_interaksi'),
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$wawancara = "<p>Wilayah : ".$data['wilayah'].'<br>'.
		"Transportasi : ".$data['transportasi'].'<br>'.
		"Yang ikut : ".$data['anggota'].'<br>'.
		"Tujuan alasan : ".$data['tujuan<br>alasan'].'<br>'.
		"Aktifitas : ".$data['aktivitas'].'<br>'.
		"Protokol : ".$data['prokes'].'<br>'.
		"Menginap : ".$data['covid_menginap'].','.$data['nbr_jumlah_hari'].'<br>'.
		"Yang dikunjungi sakit : ".$data['covid_sakit'].','.$data['penyakit'].'<br>'.
		"Sakit Setelah kembali : ".$data['covid_sakit_kembali'].','.$data['penyakit_kembali'].'<br>'.
		"Interaksi probable covid : ".$data['covid_interaksi'].','.$data['jenis_interaksi']."</p>";
		$data['wawancara'] = $wawancara;

		$id_wawancara = $this->M_monitoringcovid->insertAnggotaKeluarga($data, $user);
		// $id_wawancara = 198;
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'anggota_keluarga') {
			redirect('Covid/PelaporanPekerja/LuarKota/anggota_keluarga');
		}else{

		}
	}


	public function insertKedatanganTamu($value='')
	{
		$covid_menginap = $this->input->post('covid_menginap');
		if($covid_menginap == 1)
		{
			$covid_menginap = 'Ya';
		}
		else {
			$covid_menginap = 'Tidak';
		}

		$covid_sakit = $this->input->post('covid_sakit');
		if($covid_menginap == 1)
		{
			$covid_sakit = 'Ya';
		}
		else {
			$covid_sakit = 'Tidak';
		}

		$covid_sakit_kembali = $this->input->post('covid_sakit_kembali');
		if($covid_sakit_kembali == 1)
		{
			$covid_sakit_kembali = 'Ya';
		}
		else {
			$covid_sakit_kembali = 'Tidak';
		}

		$covid_interaksi = $this->input->post('covid_interaksi');

		if($covid_interaksi == 1)
		{
			$covid_interaksi = 'Ya';
		}
		else {
			$covid_interaksi = 'Tidak';
		}
		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Departemen'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'wilayah' => $this->input->post('Wilayah'),
		'transportasi' => $this->input->post('Transportasi'),
		'jumlah_tamu' => $this->input->post('Jumlah_tamu'),
		'tujuan_alasan' => $this->input->post('Tujuan_Alasan'),
		'aktivitas' => $this->input->post('txt-CVD-Aktifitas'),
		'prokes' => $this->input->post('txt-CVD-Prokes'),
		'covid_menginap' => $covid_menginap,
		'nbr_jumlah_hari' => $this->input->post('nbr-jumlah-hari'),
		'covid_sakit' => $covid_sakit,
		'penyakit' => $this->input->post('txt-CVD-Penyakit'),
		'covid_interaksi' => $covid_interaksi,
		'kasus' => 'KEDATANGAN TAMU DARI LUAR KOTA',
		'jenis_interaksi' => $this->input->post('txt-CVD-Jenis_interaksi'),
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$wawancara = "<p>Wilayah : ".$data['wilayah'].'<br>'.
		"Transportasi : ".$data['transportasi'].'<br>'.
		"Jumlah tamu : ".$data['jumlah_tamu'].'<br>'.
		"Tujuan alasan : ".$data['tujuan_alasan'].'<br>'.
		"Aktifitas : ".$data['aktivitas'].'<br>'.
		"Protokol : ".$data['prokes'].'<br>'.
		"Menginap : ".$data['covid_menginap'].','.$data['nbr_jumlah_hari'].'<br>'.
		"Tamu yang datang sakit : ".$data['covid_sakit'].','.$data['penyakit'].'<br>'.
		"Interaksi probable covid : ".$data['covid_interaksi'].','.$data['jenis_interaksi']."</p>";
		$data['wawancara'] = $wawancara;
		// print_r($data);exit();
		$id_wawancara = $this->M_monitoringcovid->insertKedatanganTamu($data, $user);
		// $id_wawancara = 237;
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'kedatangan_tamu') {
			redirect('Covid/PelaporanPekerja/LuarKota/kedatangan_tamu');
		}else{

		}
	}

	public function insertMelaksanakanAcara($value='')
	{
		$covid_tamu_luar = $this->input->post('covid_tamu_luar');
		if($covid_tamu_luar == 1)
		{
			$covid_tamu_luar = 'Ya';
		}
		else {
			$covid_tamu_luar = 'Tidak';
		}

		$covid_lokasi_acara = $this->input->post('covid_lokasi_acara');
		if($covid_lokasi_acara == 1)
		{
			$covid_lokasi_acara = 'Indoor';
		}
		else {
			$covid_lokasi_acara = 'Outdoor';
		}
		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Departemen'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'jenis_acara' => $this->input->post('Jenis_acara'),
		'jumlah_tamu' => $this->input->post('Jumlah_tamu'),
		'covid_tamu_luar' => $covid_tamu_luar,
		'asal_tamu' => $this->input->post('txt-CVD-Tamu-Luar'),
		'waktu_run_down' => $this->input->post('txt-CVD-MonitoringCovid-Run-Down'),
		'prokes' => $this->input->post('txt-CVD-Prokes'),
		'lokasi_acara' => $covid_lokasi_acara,
		'kasus' => 'MELAKSANAKAN ACARA',
		'kapasitas_tempat' => $this->input->post('Kapasitas_tempat'),
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$wawancara = "<p>Jenis acara : ".$data['jenis_acara'].'<br>'.
		"Jumlah tamu : ".$data['jumlah_tamu'].'<br>'.
		"Ada tamu luar : ".$data['covid_tamu_luar'].','.$data['asal_tamu'].'<br>'.
		"Waktu dan Run Down : ".$data['waktu_run_down'].'<br>'.
		"Protokol : ".$data['prokes'].'<br>'.
		"Lokasi acara : ".$data['lokasi_acara'].'<br>'.
		"Kapasitas tempat : ".$data['kapasitas_tempat']."</p>";
		$data['wawancara'] = $wawancara;

		$id_wawancara = $this->M_monitoringcovid->insertMelaksanakanAcara($data, $user);
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'melaksanakan_acara') {
			redirect('Covid/PelaporanPekerja/AcaraMelibatkanBanyakOrang/melaksanakan_acara');
		}else{

		}
	}

	public function insertMenghadiriAcara($value='')
	{
		// print_r($_POST);exit();
		$covid_tamu_luar = $this->input->post('covid_tamu_luar');
		if($covid_tamu_luar == 1)
		{
			$covid_tamu_luar = 'Ya';
		}
		else {
			$covid_tamu_luar = 'Tidak';
		}

		$covid_lokasi_acara = $this->input->post('covid_lokasi_acara');
		if($covid_lokasi_acara == 1)
		{
			$covid_lokasi_acara = 'Indoor';
		}
		else {
			$covid_lokasi_acara = 'Outdoor';
		}
		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Departemen'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'jenis_acara' => $this->input->post('Jenis_acara'),
		'jumlah_tamu' => $this->input->post('Jumlah_tamu'),
		'covid_tamu_luar' => $covid_tamu_luar,
		'asal_tamu' => $this->input->post('txt-CVD-Tamu-Luar'),
		'waktu_run_down' => $this->input->post('txt-CVD-MonitoringCovid-Run-Down'),
		'prokes_penyelenggara' => $this->input->post('txt-CVD-Prokes-Penyelenggara'),
		'prokes_pekerja' => $this->input->post('txt-CVD-Prokes-Pekerja'),
		'lokasi_acara' => $covid_lokasi_acara,
		'kasus' => 'MENGHADIRI ACARA',
		'kapasitas_tempat' => $this->input->post('Kapasitas_tempat'),
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$wawancara = "<p>Jenis acara : ".$data['jenis_acara'].'<br>'.
		"Jumlah tamu : ".$data['jumlah_tamu'].'<br>'.
		"Ada tamu luar : ".$data['covid_tamu_luar'].','.$data['asal_tamu'].'<br>'.
		"Protokol penyelenggara: ".$data['prokes_penyelenggara'].'<br>'.
		"Protokol Diri Sendiri: ".$data['prokes_pekerja'].'<br>'.
		"Lokasi acara : ".$data['lokasi_acara'].'<br>'.
		"Kapasitas tempat : ".$data['kapasitas_tempat']."</p>";

		$data['wawancara'] = $wawancara;
		
		$id_wawancara = $this->M_monitoringcovid->insertmenghadiriAcara($data, $user);
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'menghadiri_acara') {
			redirect('Covid/PelaporanPekerja/AcaraMelibatkanBanyakOrang/menghadiri_acara');
		}else{

		}
	}

	public function insertSatuRumah()
	{
		// echo "<pre>";

		$hubungan = $this->input->post('hubungan');
		if ($hubungan == 'lainnya') {
			$hubungan = $this->input->post('hubungan_lainnya');
		}

		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Departemen'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'yang_kontak'	=> $this->input->post('yang_kontak'),
		'hubungan'	=> $hubungan,
		'riwayat'	=> $this->input->post('riwayat'),
		'gejala'	=> implode(', ', $this->input->post('gejala')),
		'tgl_gejala'	=> $this->input->post('tgl_gejala'),
		'lapor_puskesmas'	=> $this->input->post('lapor_puskesmas'),
		'hasil_uji'	=> $this->input->post('hasil_uji'),
		'kasus'	=> 'Kontak dengan Probable/Konfirmasi Covid 19 dalam Satu Rumah',
		'fasilitas'	=> implode(', ', $this->input->post('fasilitas')),
		'dekontaminasi'	=> $this->input->post('dekontaminasi'),
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$antibody = $this->input->post('fantibody');
		$data['antibody'] = $antibody;
		$antigen = $this->input->post('fantigen');
		$data['antigen'] = $antigen;
		$pcr = $this->input->post('fpcr');
		$data['pcr'] = $pcr;
		if ($antibody == '1') {
			$data['tgl_tes_antibody'] = $this->input->post('tgl_tes_antibody');
			$data['tgl_keluar_tes_antibody'] = $this->input->post('tgl_keluar_tes_antibody');
			$data['hasil_antibody'] = $this->input->post('hasil_antibody');
		}
		if ($antigen == '1') {
			$data['tgl_tes_antigen'] = $this->input->post('tgl_tes_antigen');
			$data['tgl_keluar_tes_antigen'] = $this->input->post('tgl_keluar_tes_antigen');
			$data['hasil_antigen'] = $this->input->post('hasil_antigen');
		}
		if ($pcr == '1') {
			$data['tgl_tes_pcr'] = $this->input->post('tgl_tes_pcr');
			$data['tgl_keluar_tes_pcr'] = $this->input->post('tgl_keluar_tes_pcr');
			$data['hasil_pcr'] = $this->input->post('hasil_pcr');
		}

		$data['jml_orangtua'] = $this->input->post('jml_orangtua');
		$data['jml_mertua'] = $this->input->post('jml_mertua');
		$data['jml_bojo'] = $this->input->post('jml_bojo');
		$data['jml_anak'] = $this->input->post('jml_anak');
		$data['jml_saudara_kandung'] = $this->input->post('jml_saudara_kandung');
		$data['jml_saudara_tidak_kandung'] = $this->input->post('jml_saudara_tidak_kandung');
		$data['anggota_lainnya'] = $this->input->post('anggota_lainnya');

		$lapusk = $this->input->post('lapor_puskesmas');
		if ($lapusk == 'Sudah') {
			$data['arahan_terduga'] = $this->input->post('arahan_terduga');
			$data['arahan_serumah'] = $this->input->post('arahan_serumah');
		}

		//start wawancara
		$hasilTest = '';
		if ($data['antibody'] == '1') {
			$hasilTest .= "Tanggal mulai tes Antibody : ".$data['tgl_tes_antibody'].', '.
			"Tanggal Keluar test Antibody : ".$data['tgl_keluar_tes_antibody'].', '.
			"Hasil test Antibody : ".$data['hasil_antibody'].'<br>';
		}
		if ($data['antigen'] == '1') {
			$hasilTest .= "Tanggal mulai tes Antigen : ".$data['tgl_tes_antigen'].', '.
			"Tanggal Keluar test Antigen : ".$data['tgl_keluar_tes_antigen'].', '.
			"Hasil test Antigen : ".$data['hasil_antigen'].'<br>';
		}
		if ($data['pcr'] == '1') {
			$hasilTest .= "Tanggal mulai tes PCR/Swab : ".$data['tgl_tes_pcr'].', '.
			"Tanggal Keluar test PCR/Swab : ".$data['tgl_keluar_tes_pcr'].', '.
			"Hasil test PCR/Swab : ".$data['hasil_pcr'].'<br>';
		}
		$anggotaK = '';
		if ($data['jml_orangtua'] > 0) {
			$anggotaK .= "Jumlah Orang Tua : ".$data['jml_orangtua'].', ';
		}
		if ($data['jml_mertua'] > 0) {
			$anggotaK .= "Jumlah Mertua : ".$data['jml_mertua'].', ';
		}
		if ($data['jml_bojo'] > 0) {
			$anggotaK .= "Jumlah Istri/Suami : ".$data['jml_bojo'].', ';
		}
		if ($data['jml_anak'] > 0) {
			$anggotaK .= "Jumlah Anak : ".$data['jml_anak'].', ';
		}
		if ($data['jml_saudara_kandung'] > 0) {
			$anggotaK .= "Jumlah Saudara Kandung : ".$data['jml_saudara_kandung'].', ';
		}
		if ($data['jml_saudara_tidak_kandung'] > 0) {
			$anggotaK .= "Jumlah Saudara tidak Kandung : ".$data['jml_saudara_tidak_kandung'].', ';
		}
		if ($data['anggota_lainnya'] != '') {
			$anggotaK .= "Anggota keluarga Lainnya : ".$data['anggota_lainnya'].'. ';
		}

		$laporPuskesmas = '';
		if ($data['lapor_puskesmas'] == 'Sudah') {
			$laporPuskesmas .= "Arahan untuk Orang yang terduga/terkonfirmasi Covid 19 : ".$data['arahan_terduga'].'<br>';
			$laporPuskesmas .= "Arahan untuk Orang yang tinggal serumah : ".$data['arahan_serumah'].'<br>';
		}

		$wawancara = "<p>Kontak Dengan : ".$data['yang_kontak'].'<br>'.
		"Hubungan : ".$data['hubungan'].'<br>'.
		"Riwayat Orang Tersebut : ".$data['riwayat'].'<br>'.
		"Gejala Awal : ".$data['gejala'].'<br>'.
		"Tanggal mulai Gejala : ".$data['tgl_gejala'].'<br>'.
		$hasilTest.
		$anggotaK.
		$laporPuskesmas.
		"Fasilitas : ".$data['fasilitas'].'<br>'.
		"Dekontaminasi : ".$data['dekontaminasi']."</p>";
		$data['wawancara'] = $wawancara;
		
		$id_wawancara = $this->M_monitoringcovid->kontakSatuRumah($data, $user);
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'satu_rumah') {
			redirect('Covid/PelaporanPekerja/Kontak/satu_rumah');
		}else{

		}
	}

	public function insertBedaRumah()
	{
		$hubungan = $this->input->post('hubungan');
		$arahan = $this->input->post('hubungan');
		if ($hubungan == 'lainnya') {
			$hubungan = $this->input->post('lainnya');
		}
		if ($arahan == '1') {
			$arahan = $this->input->post('arahan_deskripsi');
		}else{
			$arahan = 'Tidak Ada';
		}
		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Departemen'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'yang_kontak'	=> $this->input->post('yang_kontak'),
		'hubungan'	=> $hubungan,
		'jenis_interaksi'	=> $this->input->post('jenis_interaksi'),
		'jarak_rumah'	=> $this->input->post('jarak_rumah'),
		'intensitas'	=> $this->input->post('intensitas'),
		'durasi'	=> $this->input->post('durasi'),
		'protokol'	=> $this->input->post('protokol'),
		'kasus'	=> 'Kontak dengan Probable/Konfirmasi Covid 19 - Beda Rumah',
		'arahan'	=> $arahan,
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$wawancara = "<p>Yang kontak : ".$data['yang_kontak'].'<br>'.
		"Hubungan : ".$data['hubungan'].'<br>'.
		"Jarak Rumah : ".$data['jarak_rumah'].'<br>'.
		"Jenis Interaksi : ".$data['jenis_interaksi'].'<br>'.
		"Intensitas : ".$data['intensitas'].'<br>'.
		"Durasi : ".$data['durasi'].'<br>'.
		"Protokol : ".$data['protokol'].'<br>'.
		"Arahan : ".$data['arahan']."</p>";
		$data['wawancara'] = $wawancara;
		
		$id_wawancara = $this->M_monitoringcovid->kontakBedaRumah($data, $user);
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'beda_rumah') {
			redirect('Covid/PelaporanPekerja/Kontak/beda_rumah');
		}else{
			//nope
		}
	}

	public function insertProblaby()
	{
		$hubungan = $this->input->post('hubungan');
		$arahan = $this->input->post('hubungan');
		if ($hubungan == 'lainnya') {
			$hubungan = $this->input->post('lainnya');
		}
		if ($arahan == '1') {
			$arahan = $this->input->post('arahan_deskripsi');
		}else{
			$arahan = 'Tidak Ada';
		}
		$range = $this->input->post('txtPeriodeKejadian');
		$exrange = explode(' - ', $range);

		$user = $this->session->user;
		$data = [
		'no_induk' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja'),
		'id_pekerja' => $this->input->post('slc-CVD-MonitoringCovid-Tambah-PekerjaId'),
		'seksi' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Seksi'),
		'dept' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Departemen'),
		'tgl_kejadian' => $this->input->post('txtPeriodeKejadian'),
		'tgl_interaksi' => $exrange[0],
		'keterangan' => $this->input->post('txt-CVD-MonitoringCovid-Tambah-Keterangan'),
		'yang_kontak'	=> $this->input->post('yang_kontak'),
		'hubungan'	=> $hubungan,
		'jenis_interaksi'	=> $this->input->post('jenis_interaksi'),
		'intensitas'	=> $this->input->post('intensitas'),
		'durasi'	=> $this->input->post('durasi'),
		'protokol'	=> $this->input->post('protokol'),
		'arahan'	=> $arahan,
		'kasus'		=> 'Kontak dengan Probable/Konfirmasi Covid 19 - Beda Rumah',
		'atasan' => $this->input->post('slc-CVD-MonitoringCovid-Atasan'),
		];

		$wawancara = "<p>Yang kontak : ".$data['yang_kontak'].'<br>'.
		"Hubungan : ".$data['hubungan'].'<br>'.
		"Jenis Interaksi : ".$data['jenis_interaksi'].'<br>'.
		"Intensitas : ".$data['intensitas'].'<br>'.
		"Durasi : ".$data['durasi'].'<br>'.
		"Protokol : ".$data['protokol'].'<br>'.
		"Arahan : ".$data['arahan']."</p>";
		$data['wawancara'] = $wawancara;
		
		$id_wawancara = $this->M_monitoringcovid->kontakProblaby($data, $user);
		$this->uploadLampiranCvd($id_wawancara);
		$this->session->set_userdata('result', 'berhasil');
		$src = $this->input->post('source');
		$this->kirimEmailcvd($data);
		if ($src == 'problaby') {
			redirect('Covid/PelaporanPekerja/Kontak/interaksi');
		}else{
			//nope
		}
	}

	public function uploadLampiranCvd($id_wawancara = '')
	{
		$files = $_FILES;
		if (empty($files)) {
			return 'no image';
		}elseif ($id_wawancara == '') {
			return 'no id';
		}
		$user = $this->session->user;
		$this->load->library('upload');
		$user_form = $this->input->post('slc-CVD-MonitoringCovid-Tambah-Pekerja');
		$jumlahimg = count($_FILES['filesCVDLampiran']['name']);

		for ($a = 0; $a < $jumlahimg; $a++) {
			if (empty($files['filesCVDLampiran']['name'][$a]))
				continue;

			if (!is_dir('./assets/upload/Covid/Wawancara')) {
				mkdir('./assets/upload/Covid/Wawancara', 0777, true);
				chmod('./assets/upload/Covid/Wawancara', 0777);
			}
			$_FILES['filesCVDLampiran']['name']			= $files['filesCVDLampiran']['name'][$a];
			$_FILES['filesCVDLampiran']['type']			= $files['filesCVDLampiran']['type'][$a];
			$_FILES['filesCVDLampiran']['tmp_name']		= $files['filesCVDLampiran']['tmp_name'][$a];
			$_FILES['filesCVDLampiran']['error']		= $files['filesCVDLampiran']['error'][$a];
			$_FILES['filesCVDLampiran']['size']			= $files['filesCVDLampiran']['size'][$a];
			$this->load->library('image_lib');
			$ext = pathinfo($_FILES['filesCVDLampiran']['name'], PATHINFO_EXTENSION);
			$config =  array(
				'image_library'   => 'gd2',
				'source_image'    =>  $files['filesCVDLampiran']['tmp_name'][$a],
				'maintain_ratio'  =>  TRUE,
				'width'           =>  1000,
				'height'          =>  797,
				);
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$config['upload_path']      = './assets/upload/Covid/Wawancara/';
			$config['file_name']        = $user_form.'_cvd_'.date('YmdHis').'.'.$ext;
			$config['remove_spaces']    = true;
			$config['allowed_types']    = 'jpg|png';

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('filesCVDLampiran')) {
				echo $this->upload->display_errors();
				exit();
			} else {
				$data = array('upload_data' => $this->upload->data());
			}

			$pathfile = $config['upload_path'].$config['file_name'];
			$data2 = [
			'lampiran_path' => substr($pathfile, 1),
			'lampiran_nama' => $config['file_name'],
			'wawancara_id' => $id_wawancara
			];
			$res2 = $this->M_monitoringcovid->insertLampiran21($data2, $user);
		}
	}

	public function kirimEmailcvd($data)
	{
		$this->load->library('PHPMailerAutoload');

		$noind = $data['no_induk'];
		$pkj = $this->M_monitoringcovid->getDetailPekerja($noind);

		$message = '<p>Kasus : '.$data['kasus'].'</p>';
		$message .= '<p>Tanggal Interaksi : '.$data['tgl_interaksi'].'</p>';
		$message .= '<p>Data :</p>';
		$message .= $data['wawancara'];

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
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;
		$mail->setFrom('noreply@quick.com', 'TIM COVID 19');
		$mail->addAddress('emanuel_dakris@quick.com');
		$mail->addAddress('enggal_aldiansyah@quick.com');
		$mail->addAddress('rheza_egha@quick.com@quick.com');
		$mail->addAddress('nurul_wachidah@quick.com@quick.com');
		$mail->addAddress('hbk@quick.com@quick.com');
		$mail->Subject = 'Laporan Covid Baru dari '.trim($pkj['nama']).' ('.$noind.')';
		$mail->msgHTML($message);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		} else {
			// okey
		}
	}
}