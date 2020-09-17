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
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
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
				if (!empty($br['selesai_isolasi'])) {
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
			// echo $id_wawancara;exit();
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
					$config['upload_path']          = './assets/upload/Covid/Wawancara/';
					$config['allowed_types']        = 'jpg|png|gif|bmp|jpeg|jpe|tiff|tif|svg|cdr|psd';
					$config['file_name']		 	= $nama;
					$config['max_size']			 	= '20000';
					$config['overwrite'] 			= TRUE;
					$this->upload->initialize($config);
		    		if ($this->upload->do_upload('lampiranWawancara'.$key_lamp))
		    		{
		        		$this->upload->data();
		        		
						$lampiran = array(
							'wawancara_id' => $id_wawancara,
							'lampiran_nama' => $filename,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => $this->session->user,
							'lampiran_path' => 'assets/upload/Covid/Wawancara/'.$nama
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
					$config['upload_path']          = './assets/upload/Covid/Wawancara/';
					$config['allowed_types']        = 'jpg|png|gif|bmp|jpeg|jpe|tiff|tif|svg|cdr|psd';
					$config['file_name']		 	= $nama;
					$config['max_size']			 	= '20000';
					$config['overwrite'] 			= TRUE;
					$this->upload->initialize($config);
		    		if ($this->upload->do_upload('lampiranWawancara'.$key_lamp))
		    		{
		        		$this->upload->data();
		        		
						$lampiran = array(
							'wawancara_id' => $id_wawancara,
							'lampiran_nama' => $filename,
							'created_date' => date('Y-m-d H:i:s'),
							'created_by' => $this->session->user,
							'lampiran_path' => 'assets/upload/Covid/Wawancara/'.$nama
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

		$this->M_monitoringcovid->deletePekerjaById($plaintext_string);

		$result = array(
			'status' => 'sukses'
		);
		echo json_encode($result);
	}

	public function WawancaraIsolasi($encrypted_id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

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
			<div style='background-color: black; height: 5px;'></div>
			<div style='background-color: black; height: 5px;margin-top: 5px;'></div>");
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
	        		$this->upload->data();
	        		
					$lampiran = array(
						'wawancara_id' => $id_wawancara,
						'lampiran_nama' => $filename,
						'created_date' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->user,
						'lampiran_path' => 'assets/upload/Covid/Wawancara/'.$nama
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
}

?>