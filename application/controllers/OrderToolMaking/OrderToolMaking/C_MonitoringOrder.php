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
		$data['siapa'] = 'Kasie Pengorder'; // resp. order tool making

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderToolMaking/V_MonitoringOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	function getUser(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringorder->getUser($term);
		echo json_encode($data);
	}
	
	function getAssign(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringorder->assign_order($term);
		echo json_encode($data);
	}

	public function TblModifikasi()
	{
		$noind 			= $this->session->user;
		$data['siapa'] 	= $this->input->post('siapa'); // keterangan responsibility user login
		$query 			= $this->iniquery($data['siapa'], $noind); // buat filter tambahan berdasarkan responsibility
		$getdata 		= $this->M_monitoringorder->getdatamodif($query); // cari data modifikasi
		$datanya		= $this->getdatanya($getdata, 'Modifikasi', $data['siapa']);
		$data['ket']	= 'modif';
		$data['warna']	= '#75C6FF';
		$data['data'] 	= $datanya;
		$this->load->view('OrderToolMaking/V_TblRequest', $data);
	}

	public function TblRekondisi()
	{
		$noind 			= $this->session->user;
		$data['siapa'] 	= $this->input->post('siapa');
		$query 			= $this->iniquery($data['siapa'], $noind);
		$getdata 		= $this->M_monitoringorder->getdatarekondisi($query);
		$datanya		= $this->getdatanya($getdata, 'Rekondisi', $data['siapa']);
		$data['ket']	= 'rekon';
		$data['warna']	= '#63E6D0';
		$data['data'] 	= $datanya;
		$this->load->view('OrderToolMaking/V_TblRequest', $data);
	}

	public function TblBaru()
	{
		$noind 			= $this->session->user;
		$data['siapa'] 	= $this->input->post('siapa');
		$query 			= $this->iniquery($data['siapa'], $noind);
		$getdata 		= $this->M_monitoringorder->getdatabaru($query);
		$datanya		= $this->getdatanya($getdata, 'Baru', $data['siapa']);
		$data['ket']	= 'baru';
		$data['warna']	= '#FFCA75';
		$data['data'] 	= $datanya;
		$this->load->view('OrderToolMaking/V_TblRequest', $data);
	}

	public function getdatanya($getdata, $tabel, $siapa){
		$datanya = array();
		foreach ($getdata as $key => $value) {
			$status = $this->M_monitoringorder->cekaction($value['no_order'], ''); // cek approval dari data yg terbaru
			$getdata[$key]['status'] = $this->caristatus($status, $value['jenis'], $tabel, $value['assign_order']); // buat status
			if ($tabel == 'Baru') {
				$getdata[$key]['no_tool'] = $value['no_alat_tm'];
			}else {
				$notool = $this->carirevisi($value['no_order'], $value['no_alat_bantu'], 'No Alat Bantu');
				$getdata[$key]['no_tool'] = empty($value['no_alat_tm']) || $value['no_alat_tm'] == '-' ? $notool : $value['no_alat_tm'];
			}
			
			if ($siapa == 'Kasie Pengorder' || $siapa == 'Kasie PPC TM') {
				array_push($datanya, $getdata[$key]);
			}else {
				$cek = $this->dataygtampil($getdata[$key]['status'], $siapa);
				$cek == 1  ? array_push($datanya, $getdata[$key]) : '';
			}
		}
		return $datanya;
	}
	
	public function dataygtampil($status, $siapa){
		$rev = $siapa == 'Kasie Pengorder' ? 1 : 
					($siapa == 'Ass Ka Nit Pengorder' && $status == 'DIPERIKSA ASS. KA. UNIT PENGORDER' ? 1 :
					($siapa == 'Kasie PE' && $status == 'DIPERIKSA KEPALA SEKSI PE' ? 1 :
					($siapa == 'Ass Ka Nit PE' && $status == 'DIPERIKSA ASS. KA. UNIT PE' ? 1 :
					($siapa == 'Designer Produk' && $status == 'DIPERIKSA DESIGNER PRODUK' ? 1 :
					($siapa == 'Unit QA/QC' && $status == 'DIPERIKSA UNIT QC/QA' ? 1 :
					($siapa == 'KaDep Produksi' && $status == 'DIPERIKSA KEPALA DEPARTMENT PRODUKSI' ? 1 :
					($siapa == 'Ass Ka Nit TM' && $status == 'DIPERIKSA ASS. KA. UNIT TOOL MAKING' ? 1 :
					($siapa == 'Kasie PPC TM' && $status == 'DIPERIKSA KEPALA SEKSI TOOL MAKING' ? 1 : 0))))))));
		// echo "<pre>";print_r($rev);exit();
		return $rev;
	}
	
	public function iniquery($siapa, $noind){
		if ($siapa == 'Kasie Pengorder') { // resp order tool making
			$query = "where pengorder = '$noind'";
		}elseif ($siapa == 'Ass Ka Nit Pengorder') { // resp order tool making - ass ka nit pengorder
			$query = "where assign_approval = '$noind'";
		}elseif ($siapa == 'Unit QA/QC') { // resp order tool making - qc qa
			$query = "where jenis = 'IJSM' or jenis = 'INSPECTION JIG' or jenis LIKE '%MASTER%' or jenis LIKE '%GAUGE%'";
		}else { // resp order tool making lainnya
			$query = '';
		}
		return $query;
	}

	public function caristatus($status, $jenis, $ket, $assign){ // buat status yang akan ditampilkan di tabel
		if (!empty($status)) { // sudah diapprove
			$siapa = $status[0]['person']; // yang approve, berdasarkan responsibility / yang approve terakhir
			if ($siapa == 2) { // approve askanit pengorder / resp. order tool making - ass ka nit pengorder
				$sts = 'DIPERIKSA KEPALA SEKSI PE';
			}elseif ($siapa == 3) { // approve kepala seksi pe / resp. order tool making - pe
				$sts = 'DIPERIKSA ASS. KA. UNIT PE';
			}elseif ($siapa == 4) { // approve askanit pe / resp. order tool making - askanit pe
				$sts = 'DIPERIKSA DESIGNER PRODUK';
			}elseif ($siapa == 5 ) { // approve designer produk / resp. order tool making - designer produk, status berdasarkan ketentuan berikut wkkw
				if ($jenis == 'IJSM' || $jenis == 'INSPECTION JIG' || stripos($jenis, 'MASTER') !== FALSE || stripos($jenis, 'GAUGE') !== FALSE) {
					$sts = 'DIPERIKSA UNIT QC/QA'; // status ke qc/qa
				}else {
					if ($ket == 'Baru') { // jika dari tabel baru
						$sts = 'DIPERIKSA KEPALA DEPARTMENT PRODUKSI'; // status ke kadep
					}else{ // bukan dari tabel baru
						if (array_search('4', array_column($status, 'person'))) { // kalau sudah diapprove Askanit PE gaperlu approve Askanit TM
							$sts = 'DIPERIKSA KEPALA SEKSI TOOL MAKING';
						}else {
							$sts = 'DIPERIKSA ASS. KA. UNIT TOOL MAKING';
						}
					}
				}
			}elseif ($siapa == 6) { // approve qc/qa / resp. order tool making - qc qa
				if ($ket == 'Baru') { // jika dari tblbaru
					$sts = 'DIPERIKSA KEPALA DEPARTMENT PRODUKSI';
				}else{ // jika bukan dari tbl baru
					if (array_search('4', array_column($status, 'person'))) { // kalau sudah diapprove Askanit PE gaperlu approve Askanit TM
						$sts = 'DIPERIKSA KEPALA SEKSI TOOL MAKING';
					}else {
						$sts = 'DIPERIKSA ASS. KA. UNIT TOOL MAKING';
					}
				}
			}elseif ($siapa == 7) { // approve kadep produksi / resp order tool making - kadep produksi
				if (array_search('4', array_column($status, 'person'))) { // kalau sudah diapprove Askanit PE gaperlu approve Askanit TM
					$sts = 'DIPERIKSA KEPALA SEKSI TOOL MAKING';
				}else {
					$sts = 'DIPERIKSA ASS. KA. UNIT TOOL MAKING';
				}
			}elseif ($siapa == 8) { // approve askanit tool making / resp. order tool making - askanit tool making
				$sts = 'DIPERIKSA KEPALA SEKSI TOOL MAKING';
			}elseif ($siapa == 9) { // approve kepala seksi tool making / resp. order tool making - tool making
				$sts = 'SEDANG DIKERJAKAN : '.$assign.'';
			}elseif($siapa == 10) { // sudah klik kirim di resp. order tool making - tool making /barang sudah dikirim ke seksi pengorder
				$sts = 'DALAM PROSES PENGIRIMAN';
			}else { // sudah klik button terima di resp. order tool making / barang sudah diterima seksi pengorder
				$sts = 'FINISH';
			}
		}else{ // belum approve askanit pengorder
			$sts = 'DIPERIKSA ASS. KA. UNIT PENGORDER';
		}
		return $sts;
	}

	function OrderBaru(){
		$user = $this->session->username;
		$user_id = $this->session->userid;
		$data['Title'] = 'Monitoring Order';
		$data['Menu'] = 'Order Request';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$noid = $this->session->user;
		$cari = $this->M_monitoringorder->getseksiunit($noid);
		$data['tipe_produk'] = $this->M_monitoringorder->gettipeproduk();
		$data['seksi'] = $cari[0]['seksi'];
		$data['unit'] = $cari[0]['unit'];
		$data['jenis'] = array('DIES', 'MOULD/POLA', 'IJSM', 'INSPECTION JIG', 'TEMPLATE', 'DRILL JIG', 'FIXTURE', 'MASTER', 'GAUGE', 'ALAT LAIN');
		// echo "<pre>";print_r($nomor);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderToolMaking/V_OrderBaru', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function saveorder(){
		$cari_no		= $this->M_monitoringorder->get_no_order();
		$no 			= !empty($cari_no) ? $cari_no[0]['no_order'] + 1 : '039501'; // buat no order baru
		$no_order 		= sprintf("%07d", $no);
        $tgl_order      = $this->input->post('tgl_order');
        $seksi_order    = $this->input->post('seksi_order');
        $unit_order     = $this->input->post('unit_order');
        $order          = $this->input->post('order');
		$user_baru      = $this->input->post('user_baru[]'); //kalo order BARU
		$user2 = '';
		for ($u=0; $u < count($user_baru) ; $u++) { 
			$user2 = $u == 0 ? $user_baru[$u] : $user2.'; '.$user_baru[$u];
		}
		$user_mr		= $this->input->post('user_mr'); // kalo order MODIFIKASI / REKONDISI
        $no_proposal    = $this->input->post('no_proposal');
		$proposal		= $no_order.'_'.$no_proposal.'.pdf'; // nama file proposal
        $tgl_usul       = $this->input->post('tgl_usul');
        $jenis          = $this->input->post('jenis');
        if ($jenis == 'FIXTURE') {
            $jenis = $jenis.' '.$this->input->post('fixture'); // simpan jenis dan keterangan jenisnya
        }elseif ($jenis == 'MASTER') {
            $jenis = $jenis.' '.$this->input->post('master');
        }elseif ($jenis == 'GAUGE') {
            $jenis = $jenis.' '.$this->input->post('gauge');
        }elseif ($jenis == 'ALAT LAIN') {
            $jenis = $jenis.' '.$this->input->post('alat_lain');
        }else {
            $jenis = $jenis; // simpan jenis saja
		}
		$gambar_kerja	= 'GambarKerja_'.$no_order.'.png'; // nama file gamker
		$skets			= 'Skets_'.$no_order.'.png'; // nama file skets
        $kode_komponen  = $this->input->post('kode_komponen');
        $nama_komponen  = $this->input->post('nama_komponen');
        $tipe_produk    = $this->input->post('tipe_produk');
        $tgl_rilis      = $this->input->post('tgl_rilis');
        $mesin          = $this->input->post('mesin'); // khusus baru
        $poin           = $this->input->post('poin');
        $proses_ke      = $this->input->post('proses_ke');
        $dari           = $this->input->post('dari');
        $jml_alat       = $this->input->post('jml_alat'); // khusus baru
        // $distribusi     = $this->input->post('distribusi'); // khusus baru
        $dimensi        = $this->input->post('dimensi'); // khusus baru
        $flow_sebelum   = $this->input->post('flow_sebelum'); // khusus baru
        $flow_sesudah   = $this->input->post('flow_sesudah'); // khusus baru
        $acuan_alat     = $this->input->post('acuan_alat'); // khusus baru
        $layout         = $this->input->post('layout_alat'); // khusus baru
        if ($layout == 'Tunggal') {
            $layout = $layout;
        }elseif($layout != 'Tunggal' && $layout != '') { // layout multi, save jumlahnya saja
            $layout = $this->input->post('multi'); 
        }else {
			$layout = '';
		}
		
        $material       = $this->input->post('material'); // khusus jenis = DIES dan baru
        if ($material == 'Afval') {
            $material = $material;
        }elseif($material == 'Lembaran') {
            $lembar1	= $this->input->post('lembar1');
            $lembar2	= $this->input->post('lembar2');
            $material	= $material.' '.$lembar1.' X '.$lembar2;
        }else { // jenis bukan dies
			$material = '';
		}
		// echo "<pre>";print_r($user2);exit();
		$referensi1	= $this->input->post('referensi1'); // khusus baru
		$referensi2	= $this->input->post('referensi2'); // bukan baru
        $alasan		= $this->input->post('alasan_modif'); // khusus modifikasi / rekondisi
        $no_alat	= $this->input->post('no_alat_bantu'); // khusus modifikasi / rekondisi
		$assign		= $this->input->post('assign_order'); // approver order / kasie pengorder
		$pengorder	= $this->session->user;
		
		if(!is_dir('./assets/upload/OrderToolMaking/Proposal'))
		{
			mkdir('./assets/upload/OrderToolMaking/Proposal', 0777, true);
			chmod('./assets/upload/OrderToolMaking/Proposal', 0777);
		}
		$filename = './assets/upload/OrderToolMaking/Proposal/'.$proposal; // save file approval
		move_uploaded_file($_FILES['file_proposal']['tmp_name'],$filename);

		if(!is_dir('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder'))
		{
			mkdir('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder', 0777, true);
			chmod('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder', 0777);
		}
		$filename = './assets/upload/OrderToolMaking/Gambar_Kerja/Pengorder/'.$gambar_kerja; // save file gamker
		move_uploaded_file($_FILES['gambar_kerja']['tmp_name'],$filename);

		if(!is_dir('./assets/upload/OrderToolMaking/Skets/Pengorder'))
		{
			mkdir('./assets/upload/OrderToolMaking/Skets/Pengorder', 0777, true);
			chmod('./assets/upload/OrderToolMaking/Skets/Pengorder', 0777);
		}
		$filename = './assets/upload/OrderToolMaking/Skets/Pengorder/'.$skets; // save file skets
		move_uploaded_file($_FILES['file_skets']['tmp_name'],$filename);

		if (!empty($_FILES['file_inspect']['name'])) {
			$format = explode(".", $_FILES['file_inspect']['name']);
			$inspect_report  = 'Inspect_'.$no_order.'.'.$format[1].'';
			if(!is_dir('./assets/upload/OrderToolMaking/Inspect_Report'))
			{
				mkdir('./assets/upload/OrderToolMaking/Inspect_Report', 0777, true);
				chmod('./assets/upload/OrderToolMaking/Inspect_Report', 0777);
			}
			
			$filename = './assets/upload/OrderToolMaking/Inspect_Report/'.$inspect_report.''; // save inspection report
			move_uploaded_file($_FILES['file_inspect']['tmp_name'],$filename);
		}else {
			$inspect_report = '';
		}

		if ($order == 'BARU') { // save ke tabel baru
			$this->M_monitoringorder->saveorderbaru($no_order, $tgl_order, $seksi_order, $unit_order, $user2, $proposal, $no_proposal, $tgl_usul, $jenis, $gambar_kerja, $skets,
			$kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $mesin, $poin, $proses_ke, $dari, $jml_alat, $user2, $dimensi, $flow_sebelum, $flow_sesudah,
			$acuan_alat, $layout, $material, $referensi1, $assign, $pengorder);
		}elseif($order == 'MODIFIKASI') { // save ke tabel modifikasi
			$this->M_monitoringorder->saveordermodif($no_order, $tgl_order, $seksi_order, $unit_order, $user_mr, $tgl_usul, $jenis, $gambar_kerja, $skets,
			$kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat, $poin, $proses_ke, $dari, $alasan, $referensi2, $assign, $pengorder, $inspect_report);
		}else { // save ke tabel rekondisi
			$this->M_monitoringorder->saveorderrekon($no_order, $tgl_order, $seksi_order, $unit_order, $user_mr, $tgl_usul, $jenis, $gambar_kerja, $skets,
			$kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat, $poin, $proses_ke, $dari, $alasan, $referensi2, $assign, $pengorder, $inspect_report);
		}

		redirect(base_url('OrderToolMaking/MonitoringOrder/'));
	}

	public function ViewModifikasi(){ // lihat detail modifikasi
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa'); // user login berdasarkan responsibility
		$getdata 	= $this->M_monitoringorder->getdatamodif("where no_order = '".$no_order."'");
		$ket		= 'Modifikasi';
		// echo "<pre>";print_r($siapa);exit();
		$data['val'] = $this->getdatafix($getdata, $ket, $status); // cari data yang ditampilkan
		$this->load->view('OrderToolMaking/V_DetailOrder', $data);
		// echo $view;
	}
	
	public function ViewRekondisi(){
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa');
		$getdata 	= $this->M_monitoringorder->getdatarekondisi("where no_order = '".$no_order."'");
		$ket 		= 'Rekondisi';
		// echo "<pre>";print_r($siapa);exit();
		$data['val'] = $this->getdatafix($getdata, $ket, $status);
		$this->load->view('OrderToolMaking/V_DetailOrder', $data);
	}

	public function ViewBaru(){
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa');
		$getdata 	= $this->M_monitoringorder->getdatabaru("where no_order = '".$no_order."'");
		$ket 		= 'Baru';
		$data['val'] = $this->getdatafix($getdata, $ket, $status);
		// echo "<pre>";print_r($data);exit();
		$this->load->view('OrderToolMaking/V_DetailOrder', $data);
	}
	
	public function carirevisi($no_order, $val, $cek){
		$cari 	= $this->M_monitoringorder->cekrevisi($cek, $no_order); // cek revisi dari approval terbaru
		if ($cek == 'Gambar Kerja' || $cek == 'Skets') { // hal yang dicek
			if (!empty($cari)) { // ada revisi -> ambil data file dari folder $hasil
				$hasil = $cari[0]['person'] == 2 ? 'Ass_Ka_Nit_Pengorder' :
						($cari[0]['person'] == 5 ? 'Designer_Produk' :
						($cari[0]['person'] == 3 ? 'Kasie_PE' : 
						($cari[0]['person'] == 4 ? 'Ass_Ka_Nit_PE' : '')));
			}else { // tidak ada revisi -> ambil data file dari folder Pengorder
				$hasil = 'Pengorder';
			}
		}else {
			$hasil 	= !empty($cari) ? $cari[0]['value_rev'] : $val;
		}
		return $hasil;
	}

	public function getdatafix($data, $ket, $status){
		$fix = array();
		foreach ($data as $key => $val) {
			$fix['ket'] 		= $ket; // keterangan tabel baru/ modifikasi/ rekondisi
			$fix['siapa'] 		= 'Kasie Pengorder'; // responsibility yg dibuka user login
			$fix['status'] 		= $status;
			$fix['no_order'] 	= $val['no_order'];
			$fix['tgl_order'] 	= date('d/m/Y', strtotime($val['tgl_order']));
			$fix['seksi'] 		= $val['seksi'];
			$fix['unit'] 		= $val['unit'];
			$fix['jenis'] 		= $val['jenis'];
			$fix['user_nama'] 	= $this->carirevisi($val['no_order'], $val['nama_user'], 'User'); // cari revisi data user
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
			$fix['assign_order'] = $val['assign_order'];
			$nama_app 			= $this->M_monitoringorder->getseksiunit($val['assign_approval']); // cari seksi pic ass ka nit pengorder
			$nama_app 			= !empty($nama_app) ? $nama_app[0]['nama'] : ''; 
			$fix['assign'] 		= $val['assign_approval'].' - '.$nama_app;
			
			if ($ket == 'Baru') { // khusus tabel baru
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

	public function terimabarang(){
		$no_order 		= $this->input->post('no_order');
		$cek = $this->M_monitoringorder->cekaction($no_order, "and person = 11"); // status 11 = barang sudah diterima seksi pengorder
		if (empty($cek)) {
			$this->M_monitoringorder->saveaction($no_order, 11, 1, '', date('Y-m-d H:i:s'));
		}else {
			$this->M_monitoringorder->updateaction($no_order, 11, 1, '', date('Y-m-d H:i:s'));
		}
		redirect(base_url('OrderToolMaking/MonitoringOrder/'));
	}
	


}















