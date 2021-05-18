<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MonitoringOrder extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderToolMaking/M_monitoringorder');
		date_default_timezone_set('Asia/Jakarta');

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

		$data['Title'] = 'Monitoring Order';
		$data['Menu'] = 'Order Request';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind = $this->session->user;
		$data['siapa'] = 'Ass Ka Nit Pengorder';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderToolMaking/V_MonitoringOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ViewModifikasi(){
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa'); // responsibility berdasarkan user login
		$getdata 	= $this->M_monitoringorder->getdatamodif("where no_order = '".$no_order."'");
		$ket		= 'Modifikasi';
		// echo "<pre>";print_r($siapa);exit();
		$data['val'] = $this->getdatafix($getdata, $ket, $status, $siapa);
		if ($siapa == 'Kasie PPC TM') { // detail view resp. order tool making - tool making
			$this->load->view('OrderToolMaking/V_DetailTM', $data);
		}else {
			$this->load->view('OrderToolMaking/V_DetailApproval', $data);
		}
	}
	
	public function ViewRekondisi(){
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa');
		$getdata 	= $this->M_monitoringorder->getdatarekondisi("where no_order = '".$no_order."'");
		$ket 		= 'Rekondisi';
		// echo "<pre>";print_r($siapa);exit();
		$data['val'] = $this->getdatafix($getdata, $ket, $status, $siapa);
		if ($siapa == 'Kasie PPC TM') { // detail view resp. order tool making - tool making
			$this->load->view('OrderToolMaking/V_DetailTM', $data);
		}else {
			$this->load->view('OrderToolMaking/V_DetailApproval', $data);
		}
	}
	
	public function ViewBaru(){
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa');
		$getdata 	= $this->M_monitoringorder->getdatabaru("where no_order = '".$no_order."'");
		 
		$data['val'] = $this->getdatafix($getdata, 'Baru', $status, $siapa);
		if ($siapa == 'Kasie PPC TM') { // detail view resp. order tool making - tool making
			$this->load->view('OrderToolMaking/V_DetailTM', $data);
		}else {
			$this->load->view('OrderToolMaking/V_DetailApproval', $data);
		}
	}

	public function daftarrevisi(){
		$daftar = array('0' => array('nama_kolom' => 'User', 'status' => 1 ),
						'1' => array('nama_kolom' => 'Usulan Order Selesai', 'status' => 1 ),
						'2' => array('nama_kolom' => 'Gambar Kerja', 'status' => 9 ),
						'3' => array('nama_kolom' => 'Skets', 'status' => 9 ),
						'4' => array('nama_kolom' => 'Kode Komponen', 'status' => 5 ),
						'5' => array('nama_kolom' => 'Nama Komponen', 'status' => 1 ),
						'6' => array('nama_kolom' => 'Tipe Produk', 'status' => 1 ),
						'7' => array('nama_kolom' => 'Tanggal Rilis Gambar', 'status' => 5 ),
						'8' => array('nama_kolom' => 'Mesin Yang Digunakan', 'status' => 3 ),
						'9' => array('nama_kolom' => 'No Alat Bantu', 'status' => 2 ),
						'10' => array('nama_kolom' => 'Poin Yang Diproses', 'status' => 4 ),
						'11' => array('nama_kolom' => 'Proses Ke', 'status' => 4 ),
						'12' => array('nama_kolom' => 'Dari', 'status' => 4 ),
						'13' => array('nama_kolom' => 'Jumlah Alat', 'status' => 6 ),
						'14' => array('nama_kolom' => 'Distribusi', 'status' => 3 ),
						'15' => array('nama_kolom' => 'Dimensi & Toleransi (Untuk Gauge)', 'status' => 8 ),
						'16' => array('nama_kolom' => 'Flow Proses Sebelumnya', 'status' => 3 ),
						'17' => array('nama_kolom' => 'Flow Proses Sesudahnya', 'status' => 3 ),
						'18' => array('nama_kolom' => 'Acuan Alat Bantu', 'status' => 3 ),
						'19' => array('nama_kolom' => 'Layout Alat Bantu', 'status' => 3 ),
						'20' => array('nama_kolom' => 'Material Blank (Khusus DIES)', 'status' => 7 ),
						'21' => array('nama_kolom' => 'Referensi / Datum Alat Bantu', 'status' => 1 ),
					);
		$apa 	= $this->input->post('apa'); // asal view/detail dari tabel baru/ modifikasi/ rekondisi
		$jenis 	= $this->input->post('jenis');
		$siapa 	= $this->input->post('siapa'); // responsibility yg dibuka user login
		$data 	= array();
		foreach ($daftar as $key => $val) {
			if ($apa == 'Modifikasi' || $apa == 'Rekondisi') {
				if ($siapa == 'Designer Produk') { // resp. order tool making - design 
					if ($val['status'] == 5 || $val['status'] == 9) { // cuma bisa revisi yang statusnya 5 dan 9
						array_push($data, $val);
					}
				}elseif ($siapa == 'Kasie PE' || $siapa == 'Ass Ka Nit PE') { // resp. order tool making - pe dan - askanit pe
					if ($val['status'] == 4 || $val['status'] == 9) { // cuma bisa revisi status 4 dan 9
						array_push($data, $val);
					}
				}else if ($siapa == 'Kasie Pengorder' || $siapa == 'Ass Ka Nit Pengorder') { // resp order tool making dan order tool making - ass ka nit pengorder
					if ($val['status'] == 1 || $val['status'] == 2 || $val['status'] == 4 || $val['status'] == 5 || $val['status'] == 9) { // bisa revisi yg status 1,2,4,5,9
						array_push($data, $val);
					}
				}else { // resp lainnya bisa revisi status 1,2,4,5
					if ($val['status'] == 1 || $val['status'] == 2 || $val['status'] == 4 || $val['status'] == 5) {
						array_push($data, $val);
					}
				}
			}else { // tabel baru
				if ($siapa == 'Designer Produk') { // resp otm - design
					if ($val['status'] == 5 || $val['status'] == 9) { // bisa revisi status 5, 9
						array_push($data, $val);
					}
				}elseif ($siapa == 'Kasie PE' || $siapa == 'Ass Ka Nit PE') {
					if ($val['status'] == 4 || $val['status'] == 6 || $val['status'] == 9) { // bisa revisi status 4,6
						array_push($data, $val);
					}
				}else { // resp lainnya
					if ($jenis == 'DIES') { // jika jenis DIES
						if ($val['status'] != 2 && $val['status'] != 8) { // bisa revisi kecuali status 2, 8
							array_push($data, $val);
						}
					}elseif ($jenis == 'GAUGE') {
						if ($val['status'] != 2 && $val['status'] != 7) { // bisa revisi kecuali status 2, 7
							array_push($data, $val);
						}
					}else if ($siapa == 'Kasie Pengorder' || $siapa == 'Ass Ka Nit Pengorder') { // bisa revisi status 1,2,4,5,9
						if ($val['status'] == 1 || $val['status'] == 2 || $val['status'] == 4 || $val['status'] == 5 || $val['status'] == 9) {
							array_push($data, $val);
						}
					}else {// bisa revisi kecuali status 2, 7, 8, 9
						if ($val['status'] != 2 && $val['status'] != 7 && $val['status'] != 8 && $val['status'] != 9) {
							array_push($data, $val);
						}
					}
				}
			}
		}
		// echo "<pre>";print_r($data);
		// exit();
		$option = "<option></option>";
		for ($i=0; $i < count($data) ; $i++) { 
			$option .= '<option value="'.$data[$i]['nama_kolom'].'">'.$data[$i]['nama_kolom'].'</option>';
		}
		echo $option;
		// echo json_encode($data);
	}

	public function carirevisi($no_order, $val, $cek){
		$cari 	= $this->M_monitoringorder->cekrevisi($cek, $no_order); // cek data revisi
		if ($cek == 'Gambar Kerja' || $cek == 'Skets') { // hal yg direvisi
			if (!empty($cari)) { // ada revisi, ambil data file dari folder sesuai $hasil, berdasarkan responsibility yang dibuka user login/ $cari[0]['person]
				$hasil = $cari[0]['person'] == 2 ? 'Ass_Ka_Nit_Pengorder' :
						($cari[0]['person'] == 5 ? 'Designer_Produk' :
						($cari[0]['person'] == 3 ? 'Kasie_PE' : 
						($cari[0]['person'] == 4 ? 'Ass_Ka_Nit_PE' : '')));
			}else { // tidak ada revisi
				$hasil = 'Pengorder';
			}
		}else {
			$hasil 	= !empty($cari) ? $cari[0]['value_rev'] : $val;
		}
		return $hasil;
	}

	public function cariperson($person){
		$data = $person == 'Kasie Pengorder' ? 1 : // resp. order tool making
					($person == 'Ass Ka Nit Pengorder' ? 2 : // resp. approval tool making
					($person == 'Kasie PE' ? 3 :  // resp. order tool making - pe
					($person == 'Ass Ka Nit PE' ? 4 : // resp. order tool making - askanit pe
					($person == 'Designer Produk' ? 5 : // resp. order tool making - designer
					($person == 'Unit QA/QC' ? 6 : // resp. order tool making - qc qa
					($person == 'KaDep Produksi' ? 7 : // resp. order tool making - kadep produksi
					($person == 'Ass Ka Nit TM' ? 8 : // resp. order tool making - askanit tool making
					($person == 'Kasie PPC TM' ? 9 : '')))))))); // resp. order tool making - tool making
		return $data;
	}

	public function cariaction($no_order, $siapa){
		$person = $this->cariperson($siapa);
		$cari = $this->M_monitoringorder->cekaction($no_order, "and person = $person");
		$acc = !empty($cari) ? 'Accept' : '';
		$ket = !empty($cari) ? $cari[0]['keterangan'] : '';
		// echo "<pre>";print_r($cari);exit();

		$action = array('action' => $acc, 'keterangan' => $ket);
		return $action;
	}

    
	public function saveRevisiProses(){
		$nama 			= $this->input->post('revisi[]'); // hal yang direvisi
		$isi 			= $this->input->post('isi_rev[]'); // value revisinya
        $no_order 		= $this->input->post('no_order');
        $ket 			= $this->input->post('ket');
		$action         = $this->input->post('action');
		$keterangan     = $this->input->post('keterangan');
		$siapa 			= $this->input->post('siapa');
		$seksi 			= $this->input->post('seksi_order');

		$person = $this->cariperson($siapa);
		// echo "<pre>";print_r($nama);
		// echo "<br>";print_r($isi);exit();

		if (!empty($action)) {
			$action = 1; // action static Accept wkkw
			$cek = $this->M_monitoringorder->cekaction($no_order, "and person = $person"); // cek sudah save/ belum
			if (empty($cek)) {
				$this->M_monitoringorder->saveaction($no_order, $person, $action, $keterangan, date('Y-m-d H:i:s'));
			}else {
				$this->M_monitoringorder->updateaction($no_order, $person, $action, $keterangan, date('Y-m-d H:i:s'));
			}
		}

		// if ($siapa == 'Ass Ka Nit Pengorder' && $seksi == 'PRODUCTION ENGINEERING') { // kalau order dari PE auto approve PE
		// 	$this->M_monitoringorder->saveaction($no_order, ($person+1), 1, '', date('Y-m-d H:i:s'));
		// 	$this->M_monitoringorder->saveaction($no_order, ($person+2), 1, '', date('Y-m-d H:i:s'));
		// }elseif ($siapa == 'Designer Produk' && ($seksi == 'QA & QC' || stripos($seksi, 'QUALITY') !== FALSE)) {  // kalau order dari QA & QC auto approve QA & QC
		// 	$this->M_monitoringorder->saveaction($no_order, ($person+1), 1, '', date('Y-m-d H:i:s'));
		// }elseif ($siapa == 'Ass Ka Nit PE' && stripos($seksi, 'DESAIN') !== FALSE)) {  // kalau order dari Designer auto approve Designer
		// 	$this->M_monitoringorder->saveaction($no_order, ($person+1), 1, '', date('Y-m-d H:i:s'));
		// }
		
		if ($siapa == 'Ass Ka Nit Pengorder' && $seksi == 'PE') { // kalau order dari PE auto approve PE
			$this->M_monitoringorder->saveaction($no_order, ($person+1), 1, '', date('Y-m-d H:i:s'));
			$this->M_monitoringorder->saveaction($no_order, ($person+2), 1, '', date('Y-m-d H:i:s'));
		}elseif ($siapa == 'Designer Produk' && ($seksi == 'QA' || stripos($seksi, 'QC') !== FALSE)) {  // kalau order dari QA & QC auto approve QA & QC
			$this->M_monitoringorder->saveaction($no_order, ($person+1), 1, '', date('Y-m-d H:i:s'));
		}elseif ($siapa == 'Ass Ka Nit PE' && stripos($seksi, 'DES') !== FALSE) {  // kalau order dari Designer auto approve Designer
			$this->M_monitoringorder->saveaction($no_order, ($person+1), 1, '', date('Y-m-d H:i:s'));
		}
		
		// echo "<pre>";
		for ($i=0; $i < count($nama) ; $i++) { 
			if ($nama[$i] == 'Gambar Kerja') {
				$isi2 = 'GambarKerja_'.$no_order.'.png'; // buat nama file revisi
				$this->M_monitoringorder->insertrevisi($no_order, $person, $nama[$i], $isi2, date('Y-m-d H:i:s'));
			}elseif ($nama[$i] == 'Skets') {
				$isi2 = 'Skets_'.$no_order.'.png';
				$this->M_monitoringorder->insertrevisi($no_order, $person, $nama[$i], $isi2, date('Y-m-d H:i:s'));
			}elseif ($nama[$i] == 'Layout Alat Bantu') { // revisi khusus tabel baru
				if ($isi[$i] == 'Tunggal') {
					$isi2 = $isi[$i];
				}else {
					$isi2 = $this->input->post('multi');
				}
				$this->M_monitoringorder->insertrevisi($no_order, $person, $nama[$i], $isi2, date('Y-m-d H:i:s'));
			}elseif ($nama[$i] == 'Material Blank (Khusus DIES)') { // revisi khusus tabel baru dan jenis = DIES
				if ($isi[$i] == 'Afval') {
					$isi2 = $isi[$i];
				}else { 
					$lembar1	= $this->input->post('lembar1');
					$lembar2	= $this->input->post('lembar2');
					$isi2		= $isi[$i].' '.$lembar1.' X '.$lembar2;
				}
				$this->M_monitoringorder->insertrevisi($no_order, $person, $nama[$i], $isi2, date('Y-m-d H:i:s'));
			}elseif (!empty($nama[$i])) {
				$this->M_monitoringorder->insertrevisi($no_order, $person, $nama[$i], $isi[$i], date('Y-m-d H:i:s'));
			}
		}
		// exit();
		// folder simpan revisi skets/gamker sesuai responsibility yg dibuka user login
		$folder = $siapa == 'Kasie Pengorder' ? 'Pengorder' : 
				($siapa == 'Ass Ka Nit Pengorder' ? 'Ass_Ka_Nit_Pengorder' :
				($siapa == 'Designer Produk' ? 'Designer_Produk' : 
				($siapa == 'Kasie PE' ? 'Kasie_PE' : 
				($siapa == 'Ass Ka Nit PE'? 'Ass_Ka_Nit_PE' : ''))));
		// echo "<pre>";print_r($_FILES);exit();

		if (!empty($_FILES['gamker']['name'])) {
			if(!is_dir('./assets/upload/OrderToolMaking/Gambar_kerja/'.$folder.''))
			{
				mkdir('./assets/upload/OrderToolMaking/Gambar_kerja/'.$folder.'', 0777, true);
				chmod('./assets/upload/OrderToolMaking/Gambar_kerja/'.$folder.'', 0777);
			}
			
			$filename = './assets/upload/OrderToolMaking/Gambar_kerja/'.$folder.'/GambarKerja_'.$no_order.'.png';
			move_uploaded_file($_FILES['gamker']['tmp_name'],$filename);
		}
		
		if (!empty($_FILES['skets']['name'])) {
			if(!is_dir('./assets/upload/OrderToolMaking/Skets/'.$folder.''))
			{
				mkdir('./assets/upload/OrderToolMaking/Skets/'.$folder.'', 0777, true);
				chmod('./assets/upload/OrderToolMaking/Skets/'.$folder.'', 0777);
			}
			
			$filename = './assets/upload/OrderToolMaking/Skets/'.$folder.'/Skets_'.$no_order.'.png';
			move_uploaded_file($_FILES['skets']['tmp_name'],$filename);
		}
		// link redirect sesuai resp yg dibuka user login
		$link = $siapa == 'Kasie Pengorder' ? 'OrderToolMaking/' :   // resp order tool making
					($siapa == 'Ass Ka Nit Pengorder' ? 'ApprovalToolMaking/' : // resp approval tool making
					($siapa == 'Kasie PE' ? 'OrderToolMakingPE/' :  // resp otm - pe
					($siapa == 'Ass Ka Nit PE' ? 'OrderToolMakingAssPE/' : // resp otm - askanit pe
					($siapa == 'Designer Produk' ? 'OrderToolMakingDesigner/' : // resp otm - designer
					($siapa == 'Unit QA/QC' ? 'OrderToolMakingQCQA/' : // resp otm - qc qa
					($siapa == 'KaDep Produksi' ? 'OrderToolMakingKadepProduksi/' : // resp otm - kadep produksi
					($siapa == 'Ass Ka Nit TM' ? 'OrderToolMakingAssTM/' : // resp otm - askanit tool making
					($siapa == 'Kasie PPC TM' ? 'OrderToolMakingTM/' : '')))))))); // resp otm- tool making
		redirect(base_url(''.$link.'MonitoringOrder/'));
		// echo "<pre>";print_r($no_order);
	}   

	public function statusrevisi($status, $siapa){
		// echo "<pre>";print_r($status);exit();
		$rev = $siapa == 'Kasie Pengorder' ? 1 : 
					($siapa == 'Ass Ka Nit Pengorder' && $status == 'DIPERIKSA ASS. KA. UNIT PENGORDER' ? 1 :
					($siapa == 'Kasie PE' && $status == 'DIPERIKSA KEPALA SEKSI PE' ? 1 :
					($siapa == 'Ass Ka Nit PE' && $status == 'DIPERIKSA ASS. KA. UNIT PE' ? 1 :
					($siapa == 'Designer Produk' && $status == 'DIPERIKSA DESIGNER PRODUK' ? 1 :
					($siapa == 'Unit QA/QC' && $status == 'DIPERIKSA UNIT QC/QA' ? 1 :
					($siapa == 'KaDep Produksi' && $status == 'DIPERIKSA KEPALA DEPARTMENT PRODUKSI' ? 1 :
					($siapa == 'Ass Ka Nit TM' && $status == 'DIPERIKSA ASS. KA. UNIT TOOL MAKING' ? 1 :
					($siapa == 'Kasie PPC TM' && $status == 'DIPERIKSA KEPALA SEKSI TOOL MAKING' ? 1 : 0))))))));
		return $rev;
	}

	public function getdatafix($data, $ket, $status, $siapa){ // cari data yang akan ditampilkan
		$fix = array();
			foreach ($data as $key => $val) {
				$fix['ket'] 		= $ket;
				$fix['siapa'] 		= $siapa;
				$fix['status'] 		= $status;
				$fix['revisi'] 		= $this->statusrevisi($status, $siapa); // cek status dan resp. yg dibuka user login sama / tidak
				$fix['no_order'] 	= $val['no_order'];
				$fix['tgl_order'] 	= date('d/m/Y', strtotime($val['tgl_order']));
				$fix['seksi'] 		= $val['seksi'];
				$fix['unit'] 		= $val['unit'];
				$fix['jenis'] 		= $val['jenis'];
				$fix['user_nama'] 	= $this->carirevisi($val['no_order'], $val['nama_user'], 'User'); // cari revisi data
				// $fix['file_proposal'] = $val['file_proposal'];
				// $fix['no_proposal'] = $this->carirevisi($val['no_order'], $val['no_proposal'], 'No Proposal');
				$fix['tgl_usul'] 	= $this->carirevisi($val['no_order'], date('d/m/Y', strtotime($val['tgl_usulan'])), 'Usulan Order Selesai');
				$fix['gamker'] 		= $val['gambar_kerja'];
				$fix['folder_gamker'] = $this->carirevisi($val['no_order'], $val['gambar_kerja'], 'Gambar Kerja');
				$fix['skets'] 		= $val['skets'];
				$fix['folder_skets']= $this->carirevisi($val['no_order'], $val['skets'], 'Skets');
				$fix['kodekomp'] 	= $this->carirevisi($val['no_order'], $val['kode_komponen'], 'Kode Komponen');
				$fix['namakomp'] 	= $this->carirevisi($val['no_order'], $val['nama_komponen'], 'Nama Komponen');
				$fix['tipe_produk'] = $this->carirevisi($val['no_order'], $val['tipe_produk'], 'Tipe Produk');
				$fix['tgl_rilis'] 	= $this->carirevisi($val['no_order'], date('d/m/Y', strtotime($val['tgl_rilis'])), 'Tanggal Rilis Gambar');
				$fix['poin'] 		= $this->carirevisi($val['no_order'], $val['poin'], 'Poin Yang Diproses');
				$fix['proses_ke'] 	= $this->carirevisi($val['no_order'], $val['proses_ke'], 'Proses Ke');
				$fix['dari'] 		= $this->carirevisi($val['no_order'], $val['dari'], 'Dari');
				$fix['referensi'] 	= $this->carirevisi($val['no_order'], $val['referensi'], 'Referensi / Datum Alat Bantu');
				$fix['action']		= $this->cariaction($val['no_order'], $siapa);
				$fix['no_alat_tm'] 	= $val['no_alat_tm'];
				$fix['assign_order'] = $val['assign_order'];
				$fix['estimasi_finish'] = $val['estimasi_finish'] == '' || $val['estimasi_finish'] == '0001-01-01 BC' ? '' : date('d/m/Y', strtotime($val['estimasi_finish']));
	
				if ($ket == 'Baru') { // tebel baru
					$fix['file_proposal'] = $val['file_proposal'];
					$fix['no_proposal'] = $val['no_proposal'];
					$fix['mesin'] 		= $this->carirevisi($val['no_order'], $val['mesin'], 'Mesin Yang Digunakan');
					$fix['dimensi'] 	= $this->carirevisi($val['no_order'], $val['dimensi'], 'Dimensi dan Toleransi (Untuk Gauge)');
					$fix['flow_sebelum']= $this->carirevisi($val['no_order'], $val['flow_sebelum'], 'Flow Proses Sebelumnya');
					$fix['flow_sesudah']= $this->carirevisi($val['no_order'], $val['flow_sesudah'], 'Flow Proses Sesudahnya');
					$fix['acuan_alat'] 	= $this->carirevisi($val['no_order'], $val['acuan_alat_bantu'], 'Acuan Alat Bantu');
					$fix['layout_alat'] = $this->carirevisi($val['no_order'], $val['layout_alat_bantu'], 'Layout Alat Bantu');
					$fix['material'] 	= $this->carirevisi($val['no_order'], $val['material_blank'], 'Material Blank (Khusus DIES)');
					$fix['jml_alat']	= $this->carirevisi($val['no_order'], $val['jumlah_alat'], 'Jumlah Alat');
					$fix['distribusi'] 	= $this->carirevisi($val['no_order'], $val['distribusi'], 'Distribusi');
				}else { // tabel modifikasi dan rekondisi
					$fix['alasan'] 		= $this->carirevisi($val['no_order'], $val['alasan_modifikasi'], 'Alasan Modifikasi');
					$fix['no_alat'] 	= $this->carirevisi($val['no_order'], $val['no_alat_bantu'], 'No Alat Bantu');
					$fix['inspection_report'] 	= $val['inspection_report'];
				}
			}
		return $fix;
	}
	
	function selectUser(){
		$data = $this->M_monitoringorder->getUser('');
		$option = '';
		foreach ($data as $key => $val) {
			$option .= '<option style="font-size:15px" value="'.$val['NAMA_USER'].'">'.$val['NAMA_USER'].'</option>';
		}
		$select = '<select name="isi_rev[]" class="form-control actionorder" style="width:100%;" autocomplete="off">
					<option>Pilih User</option>
					'.$option.'
					</select>';
		echo $select;
	}
	
	function selectTipeProduk(){
		$data = $this->M_monitoringorder->gettipeproduk();
		$option = '';
		foreach ($data as $key => $val) {
			$option .= '<option style="font-size:15px" value="'.$val['PRODUK_DESC'].'">'.$val['PRODUK_DESC'].'</option>';
		}
		$select = '<select name="isi_rev[]" class="form-control actionorder" style="width:100%;" autocomplete="off">
					<option>Pilih Tipe Produk</option>
					'.$option.'
					</select>';
		echo $select;
	}

}















