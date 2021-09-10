<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MonitoringOrder extends CI_Controller
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
		$data['Menu'] = 'Request Order';
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
	
	function getSeksiOrder(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringorder->getSeksiOrder($term);
		echo json_encode($data);
	}
	
	function getAssign(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringorder->assign_order($term);
		echo json_encode($data);
	}
	
	function getProses(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringorder->getProses($term);
		echo json_encode($data);
	}
	
	function getmesin(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_monitoringorder->getmesin($term);
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
		// echo "<pre>";print_r($datanya);exit();
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
			// cari no tool
			if ($tabel == 'Baru') {
				$getdata[$key]['no_tool'] = $value['no_alat_tm'];
			}else {
				$notool = $this->carirevisi($value['no_order'], $value['no_alat_bantu'], 'No Alat Bantu');
				$getdata[$key]['no_tool'] = empty($value['no_alat_tm']) || $value['no_alat_tm'] == '-' ? $notool : $value['no_alat_tm'];
			}
			
			if ($siapa == 'Kasie Pengorder' || $siapa == 'Kasie PPC TM') { // resp. Order Tool Making dan OTM - Tool Making tampil semua data
				array_push($datanya, $getdata[$key]);
			}elseif ($siapa == 'Admin PPC') { // resp. Order Tool Making dan OTM - Tool Making tampil semua data
				if (!empty($status) && $status[0]['person'] == 9) {
					array_push($datanya, $getdata[$key]);
				}
			}else { // resp. lainnya hanya menampilkan data yang perlu diapprove saja
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
			$query = "where pengorder = '$noind' and (status_order not in (0,2,4) or status_order is null)"; //tidak ditolak dan cancel
		}elseif ($siapa == 'Ass Ka Nit Pengorder') { // resp order tool making - ass ka nit pengorder
			$query = "where assign_approval = '$noind' and status_order is null";
		}elseif ($siapa == 'Unit QA/QC') { // resp order tool making - qc qa
			$query = "where jenis = 'IJSM' or jenis = 'INSPECTION JIG' or jenis LIKE '%MASTER%' or jenis LIKE '%GAUGE%'  and status_order is null";
		}elseif ($siapa == 'Desainer Produk') { // resp order tool making desainer, data sesuai assign seksi desainer
			$cari = $this->M_monitoringorder->getseksiunit($noind);
			$seksi = $cari[0]['seksi'];
			if ($seksi == 'DESAIN A') {
				$query = "where assign_desainer = 'Desainer A' or assign_desainer is null and status_order is null";
			}elseif ($seksi == 'DESAIN B') {
				$query = "where assign_desainer = 'Desainer B' or assign_desainer is null and status_order is null";
			}elseif ($seksi == 'DESAIN C') {
				$query = "where assign_desainer = 'Desainer C' or assign_desainer is null and status_order is null";
			}else {
				$query = 'where status_order is null';
			}
		} elseif ($siapa == 'Kasie PPC TM') {
			$query = 'where status_order is null or status_order in (4,34)';
		}else { // resp order tool making lainnya
			$query = 'where status_order is null';
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
				$sts = 'FINISH : AB SUDAH JADI';
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
		$seksiorder = $this->db->select('mp.*')->where("mp.nama_seksi = '".$cari[0]['seksi']."'")->get('otm.otm_master_seksi mp')->result_array();
		$data['seksi_order'] = !empty($seksiorder) ? $seksiorder[0]['kode_seksi'] : '';
		$data['seksi'] = $cari[0]['seksi'];
		$data['unit'] = $cari[0]['unit'];
		$data['jenis'] = array('DIES', 'MOULD/POLA', 'IJSM', 'INSPECTION JIG', 'TEMPLATE', 'DRILL JIG', 'FIXTURE', 'MASTER', 'GAUGE', 'ALAT LAIN');
		$noasset = $this->M_monitoringorder->getnoasset(date('ymd'));
		if (empty($noasset)) {
			$data['noasset'] = 'N'.date('ymd').'000';
		}else {
			$urut = substr($noasset[0]['DOK_NUM'],-3);
			$data['noasset'] = 'N'.date('ymd').sprintf("%03d", ($urut+1));
		}

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
		$noasset = $this->M_monitoringorder->getnoasset(date('ymd'));
		if (empty($noasset)) {
			$no_proposal = 'N'.date('ymd').'000';
		}else {
			$urut = substr($noasset[0]['DOK_NUM'],-3);
			$no_proposal = 'N'.date('ymd').sprintf("%03d", ($urut+1));
		}
        $alasan_asset   = $this->input->post('alasan_asset');
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
		$gambar_kerja	= 'GambarKerja_'.$no_order.'-1.png'; // nama file gamker
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
        $flow_sebelum   = $this->input->post('flow_sebelum').' - '.$this->input->post('detailflow_sebelum'); // khusus baru
        $flow_sesudah   = $this->input->post('flow_sesudah').' - '.$this->input->post('detailflow_sesudah'); // khusus baru
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
		$assign_desainer	= $this->input->post('assign_desainer'); // approver desainer khusus order PE
		$pengorder	= $this->session->user;
		
		if (!empty($_FILES['file_proposal']['name'])) {
		if(!is_dir('./assets/upload/OrderToolMaking/Proposal'))
		{
			mkdir('./assets/upload/OrderToolMaking/Proposal', 0777, true);
			chmod('./assets/upload/OrderToolMaking/Proposal', 0777);
		}
		$filename = './assets/upload/OrderToolMaking/Proposal/'.$proposal; // save file approval
		move_uploaded_file($_FILES['file_proposal']['tmp_name'],$filename);
		}
		// save gambar kerja
		// $gb = $this->input->post('gamkernya');
		// echo "<pre>";print_r($gb);exit();
		if (!empty($_FILES['gambar_kerja']['name'])) {
			if(!is_dir('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder'))
			{
				mkdir('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder', 0777, true);
				chmod('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder', 0777);
			}

			for ($i=0; $i < count($_FILES['gambar_kerja']['name']) ; $i++) { 
				$gambar_kerja = $i == 0 ? $gambar_kerja : $gambar_kerja.';'.'GambarKerja_'.$no_order.'-'.($i+1).'.png';
				$gambar_kerja2 = $i == 0 ? $gambar_kerja : 'GambarKerja_'.$no_order.'-'.($i+1).'.png';
				$format = explode(".", $_FILES['gambar_kerja']['name'][$i]);
				$j = count($format);
				if ($format[$j-1] == 'png' || $format[$j-1] == 'PNG') {
					$im = imagecreatefrompng($_FILES['gambar_kerja']['tmp_name'][$i]);
				}else {
					$im = imagecreatefromjpeg($_FILES['gambar_kerja']['tmp_name'][$i]);
				}
				$color 	= imagecolorallocate($im,230, 90, 107);
				$sx = imagesx($im)/8;
				$sy = imagesy($im) - (imagesy($im)/5);
				imagestring($im,5,$sx,$sy,"KHUSUS ALAT BANTU",$color); // beri stamping digambar
		
				$filename = './assets/upload/OrderToolMaking/Gambar_kerja/Pengorder/'.$gambar_kerja2; // save file gamker
				imagepng($im, $filename);
				imagedestroy($im);
				move_uploaded_file($im,$filename);
				// move_uploaded_file($_FILES['gambar_kerja']['tmp_name'],$filename);
			}
		}

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
			$acuan_alat, $layout, $material, $referensi1, $assign, $pengorder, $assign_desainer, $alasan_asset);
			$this->M_monitoringorder->save_noasset($no_proposal, date('Y-m-d H:i:s'));
		}elseif($order == 'MODIFIKASI') { // save ke tabel modifikasi
			$this->M_monitoringorder->saveordermodif($no_order, $tgl_order, $seksi_order, $unit_order, $user_mr, $tgl_usul, $jenis, $gambar_kerja, $skets,
			$kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat, $poin, $proses_ke, $dari, $alasan, $referensi2, $assign, $pengorder, $inspect_report, $assign_desainer);
		}else { // save ke tabel rekondisi
			$this->M_monitoringorder->saveorderrekon($no_order, $tgl_order, $seksi_order, $unit_order, $user_mr, $tgl_usul, $jenis, $gambar_kerja, $skets,
			$kode_komponen, $nama_komponen, $tipe_produk, $tgl_rilis, $no_alat, $poin, $proses_ke, $dari, $alasan, $referensi2, $assign, $pengorder, $inspect_report, $assign_desainer);
		}
		if ($seksi_order == 'PE') { // jika order dari PE, auto approve Ass Ka Nit Pengorder dan PE, jadi langsung ke Ass Ka Nit PE
			$this->M_monitoringorder->saveaction($no_order, 2, 1, '', date('Y-m-d H:i:s'), $this->session->user);
			$this->M_monitoringorder->saveaction($no_order, 3, 1, '', date('Y-m-d H:i:s'), $this->session->user);
		}


		redirect(base_url('OrderToolMaking/MonitoringOrder/'));
	}

	public function sendorder(){
		$noorder = $this->input->post('no_order');
		$pengorder = $this->input->post('pengorder');
		$seksi_order = $this->input->post('seksi_order');
		$assign = $this->input->post('assign');
		$jenis = $this->input->post('jenis');
		$ket = $this->input->post('ket');

		$this->send_email_order($assign, $noorder, $seksi_order,$jenis, $pengorder);
		if ($ket == 'baru') {
			$this->M_monitoringorder->updatefilebaru('status_order = null',$noorder);
		}elseif ($ket == 'modif') {
			$this->M_monitoringorder->updatefilemodif('status_order = null',$noorder);
		}else{
			$this->M_monitoringorder->updatefilerekon('status_order = null',$noorder);
		}
	}
	
	public function cancelorder(){
		$noorder = $this->input->post('no_order');
		$pengorder = $this->input->post('pengorder');
		$seksi_order = $this->input->post('seksi_order');
		$assign = $this->input->post('assign');
		$jenis = $this->input->post('jenis');
		$ket = $this->input->post('ket');
		$status = $this->input->post('status');
		$status_order = $this->input->post('status_order');
		$siapa = $this->input->post('siapa');
		$alasan = $this->input->post('alasan');
		$cek_approval = $this->M_monitoringorder->cekaction($noorder, ''); // cek approval dari data yg terbaru
		// status 2 = tidak muncul
		// status 3 = approval pengorder
		// status 4 = approval ppc tm
		if (($cek_approval[0]['person'] < 9 || empty($cek_approval)) && $siapa == 'Kasie Pengorder') {
			$cancel = 2; // cancel dari pengorder belum approve PPC TM, langsung ilang
		}elseif ($cek_approval[0]['person'] >= 9 && $siapa == 'Kasie Pengorder') {
			$cancel = 4; // cancel dari pengorder sudah approve PPC TM, butuh approval PPC TM
			$ppctm = $this->M_monitoringorder->user_ppc_tm();
			foreach ($ppctm as $key => $value) {
				$this->send_email_cancel($value['user_name'], $noorder, $seksi_order, $jenis, $pengorder, 'Kasie PPC TM', $siapa, $ket, $alasan);
			}
		}elseif (($siapa == 'Kasie PE' || $siapa == 'Askanit PE') && $cek_approval[0]['person'] < 9) {
			$cancel = 3; // cancel dari PE belum approve PPC TM, butuh approval pengorder
			$this->send_email_cancel($pengorder, $noorder, $seksi_order, $jenis, $pengorder, 'Kasie Pengorder', $siapa, $ket, $alasan);
		}elseif (($siapa == 'Kasie PE' || $siapa == 'Askanit PE') && $cek_approval[0]['person'] >= 9) {
			$cancel = 34; // cancel dari PE belum approve PPC TM, butuh approval PPC TM dan pengorder
			$this->send_email_cancel($pengorder, $noorder, $seksi_order, $jenis, $pengorder, 'Kasie Pengorder', $siapa, $ket, $alasan);
			$ppctm = $this->M_monitoringorder->user_ppc_tm();
			foreach ($ppctm as $key => $value) {
				$this->send_email_cancel($value['user_name'], $noorder, $seksi_order, $jenis, $pengorder, 'Kasie PPC TM', $siapa, $ket, $alasan);
			}
		}elseif ($siapa == 'Kasie PPC TM') {
			$cancel = 3; // cancel dari PPC TM belum approve PPC TM, butuh approval pengorder
			$this->send_email_cancel($pengorder, $noorder, $seksi_order, $jenis, $pengorder, 'Kasie Pengorder', $siapa, $ket, $alasan);
		}

		if ($ket == 'baru') {
			$this->M_monitoringorder->updatefilebaru("status_order = $cancel, reject_by = '".$this->session->user."', alasan_reject = '$alasan'",$noorder);
		}elseif ($ket == 'modif') {
			$this->M_monitoringorder->updatefilemodif("status_order = $cancel, reject_by = '".$this->session->user."', alasan_reject = '$alasan'",$noorder);
		}else{
			$this->M_monitoringorder->updatefilerekon("status_order = $cancel, reject_by = '".$this->session->user."', alasan_reject = '$alasan'",$noorder);
		}
	}
	
	public function tolakorder(){
		$noorder = $this->input->post('no_order');
		$pengorder = $this->input->post('pengorder');
		$seksi_order = $this->input->post('seksi_order');
		$jenis = $this->input->post('jenis');
		$ket = $this->input->post('ket');
		$status = $this->input->post('status');
		$status_order = $this->input->post('status_order');
		$siapa = $this->input->post('siapa');
		$keterangan = $this->input->post('keterangan');
		$cek_approval = $this->M_monitoringorder->cekaction($noorder, ''); // cek approval dari data yg terbaru
		// status tolak 5, berubah 0 jika sudah disetujui pengorder
		// echo "<pre>";print_r($ket);exit();
		if ($ket == 'Baru') {
			$this->M_monitoringorder->updatefilebaru("status_order = 5, reject_by = '".$this->session->user."', alasan_reject = '$keterangan'",$noorder);
		}elseif ($ket == 'Modifikasi') {
			$this->M_monitoringorder->updatefilemodif("status_order = 5, reject_by = '".$this->session->user."', alasan_reject = '$keterangan'",$noorder);
		}else{
			$this->M_monitoringorder->updatefilerekon("status_order = 5, reject_by = '".$this->session->user."', alasan_reject = '$keterangan'",$noorder);
		}
		// $person = $this->cariperson($siapa);
		// $this->M_monitoringorder->saveaction($noorder, $person, 0, $keterangan, date('Y-m-d H:i:s'), $this->session->user);

		$this->send_email_tolak($pengorder, $noorder, $seksi_order, $jenis, $pengorder, 'Kasie Pengorder', $siapa, $ket, $keterangan);
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
					($person == 'Kasie PPC TM' ? 9 : 10)))))))); // resp. order tool making - tool making
		return $data;
	}

	public function send_email_order($tujuan, $no_order, $seksi_order, $jenis, $pengorder){
		// kirim email ke tujuan kirim
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
		// cari email berdasarkan tujuan kirim
		$email = $this->M_monitoringorder->dataEmail($tujuan);
		$nama = $this->M_monitoringorder->dataEmail($pengorder);
		// echo "<pre>";print_r($email);
		foreach ($email as $a) {
			$mail->addAddress($a['email_internal']);   
			// echo $a['email'];    
		}

		$isi = '<h4>REQUEST ORDER TOOL MAKING TELAH DIBUAT :</h4>
				<b>No Order :</b> '.$no_order.'<br>
				<b>Pengorder :</b> '.$pengorder.' - '.$nama[0]['nama'].'<br>
				<b>Seksi Pengorder :</b> '.$seksi_order.'<br>
				<b>Pembuatan :</b> '.$jenis.'<br><br>
				Untuk proses approval kunjungi : '.base_url("ApprovalToolMaking/MonitoringOrder").' atau <a href="'.base_url("ApprovalToolMaking/MonitoringOrder").'" target="_blank">klik disini</a>';

		$mail->Subject = 'Request Order Tool Making';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			// echo "Mailer Error: " . $mail->ErrorInfo;
			// exit();
		} else {
			// echo "Message sent!..<br>";
		}
	}

	
	public function send_email_cancel($tujuan, $no_order, $seksi_order, $jenis, $pengorder,$seksi_tujuan, $seksi_cancel, $ket, $alasan){
		// kirim email ke tujuan kirim
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
		// cari email berdasarkan tujuan kirim
		$email = $this->M_monitoringorder->dataEmail($tujuan);
		$nama = $this->M_monitoringorder->dataEmail($pengorder);
		$nama2 = $this->M_monitoringorder->dataEmail($this->session->user);
		// echo "<pre>";print_r($email);
		foreach ($email as $a) {
			$mail->addAddress($a['email_internal']);   
			// echo $a['email'];    
		}

		$isi = '<h4>REQUEST ORDER TOOL MAKING TELAH DICANCEL :</h4>
				<b>No Order : '.$no_order.'</b><br>
				<b>Pengorder :</b> '.$pengorder.' - '.$nama[0]['nama'].'<br>
				<b>Seksi Pengorder :</b> '.$seksi_order.'<br>
				<b>Pembuatan :</b> '.$jenis.'<br><br>
				<b>Dicancel oleh :</b> '.$seksi_cancel.'<br>
				<b> Pengcancel :</b> '.$this->session->user.' - '.$nama2[0]['nama'].'<br><br>
				<b>Alasan dicancel :</b> '.$alasan.'<br><br>
				Klik tombol dibawah ini untuk menyetujui :<br>
				<a href="'.base_url("OrderToolMaking/MonitoringOrder/konfirmasicancel/".$no_order."_".$ket."/".$seksi_tujuan."").'">
				<button class="btn">Setuju Cancel</button></a>';

		$mail->Subject = 'Request Order Tool Making';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			// echo "Mailer Error: " . $mail->ErrorInfo;
			// exit();
		} else {
			// echo "Message sent!..<br>";
		}
	}
	
	
	public function send_email_tolak($tujuan, $no_order, $seksi_order, $jenis, $pengorder,$seksi_tujuan, $seksi_cancel, $ket, $alasan){
		// kirim email ke tujuan kirim
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
		// cari email berdasarkan tujuan kirim
		$email = $this->M_monitoringorder->dataEmail($tujuan);
		$nama = $this->M_monitoringorder->dataEmail($pengorder);
		$nama2 = $this->M_monitoringorder->dataEmail($this->session->user);
		// echo "<pre>";print_r($email);
		foreach ($email as $a) {
			$mail->addAddress($a['email_internal']);   
			// echo $a['email'];    
		}

		$isi = '<h4>REQUEST ORDER TOOL MAKING TELAH DITOLAK :</h4>
				<b>No Order : '.$no_order.'</b><br>
				<b>Pengorder :</b> '.$pengorder.' - '.$nama[0]['nama'].'<br>
				<b>Seksi Pengorder :</b> '.$seksi_order.'<br>
				<b>Pembuatan :</b> '.$jenis.'<br><br>
				<b>Ditolak oleh :</b> '.$seksi_cancel.'<br>
				<b>Penolak :</b> '.$this->session->user.' - '.$nama2[0]['nama'].'<br>
				<b>Alasan ditolak :</b> '.$alasan.'<br><br>
				Klik tombol dibawah ini untuk menyetujui :<br>
				<a href="'.base_url("OrderToolMaking/MonitoringOrder/konfirmasicancel/".$no_order."_".$ket."/".$seksi_tujuan."").'">
				<button class="btn">Setuju Ditolak</button></a>';

		$mail->Subject = 'Request Order Tool Making';
		$mail->msgHTML($isi);
		if (!$mail->send()) {
			// echo "Mailer Error: " . $mail->ErrorInfo;
			// exit();
		} else {
			// echo "Message sent!..<br>";
		}
	}

	public function konfirmasicancel($noorder, $siapa){
		$pisah = explode("_", $noorder);
		$no_order = $pisah[0];
		$ket = $pisah[1];
		if ($ket == 'baru') {
			$getdata 	= $this->M_monitoringorder->getdatabaru("where no_order = '".$no_order."'");
		}elseif ($ket == 'modif') {
			$getdata 	= $this->M_monitoringorder->getdatamodif("where no_order = '".$no_order."'");
		}else {
			$getdata 	= $this->M_monitoringorder->getdatarekondisi("where no_order = '".$no_order."'");
		}

		$siapa = str_replace('%20', ' ', $siapa);

		if ($getdata[0]['status_order'] == 5) {
			$status = 0; // konfirmasi order ditolak
		}elseif ($siapa == 'Kasie Pengorder' && $getdata[0]['status_order'] == 34) {
			$status = 4; // butuh approval PPC TM
		}elseif ($siapa == 'Kasie PPC TM' && $getdata[0]['status_order'] == 34) {
			$status = 3; // butuh approval kasie pengorder
		}else {
			$status = 2;
		}
		
		if ($ket == 'baru') {
			$this->M_monitoringorder->updatefilebaru("status_order = $status",$no_order);
		}elseif ($ket == 'modif') {
			$this->M_monitoringorder->updatefilemodif("status_order = $status",$no_order);
		}else{
			$this->M_monitoringorder->updatefilerekon("status_order = $status",$no_order);
		}
		echo '<script type="text/javascript">
		alert("Cancel telah disetujui!");
		window.close();
		</script>';
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
	
	public function EditModifikasi(){ // lihat detail modifikasi
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa'); // user login berdasarkan responsibility
		$getdata 	= $this->M_monitoringorder->getdatamodif("where no_order = '".$no_order."'");
		$ket		= 'Modifikasi';
		// echo "<pre>";print_r($siapa);exit();
		$data['val'] = $this->getdatafix($getdata, $ket, $status); // cari data yang ditampilkan
		$this->load->view('OrderToolMaking/V_EditOrder', $data);
		// echo $view;
	}
	
	public function EditRekondisi(){
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa');
		$getdata 	= $this->M_monitoringorder->getdatarekondisi("where no_order = '".$no_order."'");
		$ket 		= 'Rekondisi';
		// echo "<pre>";print_r($siapa);exit();
		$data['val'] = $this->getdatafix($getdata, $ket, $status);
		$this->load->view('OrderToolMaking/V_EditOrder', $data);
	}
	
	public function EditBaru(){
		$no_order 	= $this->input->post('no_order');
		$status 	= $this->input->post('status');
		$siapa 		= $this->input->post('siapa');
		$getdata 	= $this->M_monitoringorder->getdatabaru("where no_order = '".$no_order."'");
		$ket 		= 'Baru';
		$data['val'] = $this->getdatafix($getdata, $ket, $status);
		// echo "<pre>";print_r($data);exit();
		$this->load->view('OrderToolMaking/V_EditOrder', $data);
	}

	
    
	public function saveEditProses(){
		$nama 			= $this->input->post('revisi[]'); // hal yang direvisi
		$isi 			= $this->input->post('isi_rev[]'); // value revisinya
        $no_order 		= $this->input->post('no_order');
        $ket 			= $this->input->post('ket');
		$action         = $this->input->post('action');
		$keterangan     = $this->input->post('keterangan');
		$siapa 			= $this->input->post('siapa');
		$seksi 			= $this->input->post('seksi_order');
		$assign_desainer = $this->input->post('assign_desainer');
		$ket_edit_rev 	= $this->input->post('edit_rev');
		// echo "<pre>";print_r($_FILES);
		// echo "<br>";print_r($isi);exit();
		
		if ($ket_edit_rev == 'revisi') {
			if ($ket == 'Baru') {
				$this->M_monitoringorder->updatefilebaru("status_order = null",$no_order);
			}elseif ($ket == 'Modifikasi') {
				$this->M_monitoringorder->updatefilemodif("status_order = null",$no_order);
			}else{
				$this->M_monitoringorder->updatefilerekon("status_order = null",$no_order);
			}
			$this->M_monitoringorder->update_status_revisi($no_order);
		}
		
		// echo "<pre>";
		$g = 0;
		for ($i=0; $i < count($nama) ; $i++) { 
			if ($nama[$i] == 'Gambar Produk') {
				if (!empty($_FILES['gamker']['name'][$g])) {
					if(!is_dir('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder'))
					{
						mkdir('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder', 0777, true);
						chmod('./assets/upload/OrderToolMaking/Gambar_kerja/Pengorder', 0777);
					}
					$format = explode(".", $_FILES['gamker']['name'][$g]);
					if ($format[1] == 'png' || $format[1] == 'PNG') {
						$im = imagecreatefrompng($_FILES['gamker']['tmp_name'][$g]);
					}else {
						$im = imagecreatefromjpeg($_FILES['gamker']['tmp_name'][$g]);
					}
					$color 	= imagecolorallocate($im,230, 90, 107);
					$sx = imagesx($im)/8;
					$sy = imagesy($im) - (imagesy($im)/5);
					imagestring($im,5,$sx,$sy,"KHUSUS ALAT BANTU",$color);
					
					if ($ket == 'Modifikasi') {
						$getgb = $this->M_monitoringorder->getdatamodif("where no_order = '$no_order'");
					}elseif ($ket == 'Baru') {
						$getgb = $this->M_monitoringorder->getdatabaru("where no_order = '$no_order'");
					}else {
						$getgb = $this->M_monitoringorder->getdatarekondisi("where no_order = '$no_order'");
					}

					$gb = explode(";",$getgb[0]['gambar_kerja']);
					$gk = 'GambarKerja_'.$no_order.'.png';
					for ($k=0; $k < count($gb) ; $k++) { 
						$gk = $gb[$k] == 'GambarKerja_'.$no_order.'-'.$isi[$i].'.png' ? $gb[$k] : $gk; 
					}
					
					$filename = './assets/upload/OrderToolMaking/Gambar_kerja/Pengorder/'.$gk;
					imagepng($im, $filename);
					imagedestroy($im);
					move_uploaded_file($im,$filename);
					// move_uploaded_file($_FILES['gamker']['tmp_name'],$filename);
				}
				$g++;
				$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $gk, date('Y-m-d H:i:s'),$this->session->user);
			}elseif ($nama[$i] == 'Skets') {
				$isi2 = 'Skets_'.$no_order.'.png';
				if (!empty($_FILES['skets']['name'])) {
					if(!is_dir('./assets/upload/OrderToolMaking/Skets/Pengorder'))
					{
						mkdir('./assets/upload/OrderToolMaking/Skets/Pengorder', 0777, true);
						chmod('./assets/upload/OrderToolMaking/Skets/Pengorder', 0777);
					}
					
					$filename = './assets/upload/OrderToolMaking/Skets/Pengorder/Skets_'.$no_order.'.png';
					move_uploaded_file($_FILES['skets']['tmp_name'],$filename);
				}
				$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $isi2, date('Y-m-d H:i:s'),$this->session->user);
			}elseif ($nama[$i] == 'Layout Alat Bantu') { // revisi khusus tabel baru
				if ($isi[$i] == 'Tunggal') {
					$isi2 = $isi[$i];
				}else {
					$isi2 = $this->input->post('multi');
				}
				$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $isi2, date('Y-m-d H:i:s'),$this->session->user);
			}elseif ($nama[$i] == 'Material Blank (Khusus DIES)') { // revisi khusus tabel baru dan jenis = DIES
				if ($isi[$i] == 'Afval') {
					$isi2 = $isi[$i];
				}else { 
					$lembar1	= $this->input->post('lembar1');
					$lembar2	= $this->input->post('lembar2');
					$isi2		= $isi[$i].' '.$lembar1.' X '.$lembar2;
				}
				$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $isi2, date('Y-m-d H:i:s'),$this->session->user);
			}elseif ($nama[$i] == 'Flow Proses Sebelumnya') { // revisi khusus tabel baru
				$isi2 = $isi[$i].' - '.$this->input->post('detailsblm');
				$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $isi2, date('Y-m-d H:i:s'),$this->session->user);
			}elseif ($nama[$i] == 'Flow Proses Sesudahnya') { // revisi khusus tabel baru
				$isi2 = $isi[$i].' - '.$this->input->post('detailssdh');
				$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $isi2, date('Y-m-d H:i:s'),$this->session->user);
			}elseif ($nama[$i] == 'Distribusi') { 
				$dis = $this->input->post('rev_distribusi[]');
				$isi2 = '';
				for ($d=0; $d < count($dis); $d++) { 
					$isi2 = $d == 0 ? $dis[$d] : $isi2.'; '.$dis[$d];
				}
				if ($isi2 != '') {
					$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $isi2, date('Y-m-d H:i:s'),$this->session->user);
				}
			}elseif ($nama[$i] == 'Assign Desainer') { // revisi khusus assign desainer
				if ($ket == 'Baru') {
					$this->M_monitoringorder->updatefilebaru("assign_desainer = '".$isi[$i]."'",$no_order);
				}elseif ($ket == 'Modifikasi') {
					$this->M_monitoringorder->updatefilemodif("assign_desainer = '".$isi[$i]."'",$no_order);
				}else{
					$this->M_monitoringorder->updatefilerekon("assign_desainer = '".$isi[$i]."'",$no_order);
				}
			}elseif ($nama[$i] == 'Jenis') { // revisi khusus jenis
				$detail = $this->input->post('detail_jenis');
				$isi2 = !empty($detail) ? $isi[$i].' '.$detail : $isi[$i];
				if ($ket == 'Baru') {
					$this->M_monitoringorder->updatefilebaru("jenis = '".$isi2."'",$no_order);
				}elseif ($ket == 'Modifikasi') {
					$this->M_monitoringorder->updatefilemodif("jenis = '".$isi2."'",$no_order);
				}else{
					$this->M_monitoringorder->updatefilerekon("jenis = '".$isi2."'",$no_order);
				}
			}elseif ($nama[$i] == 'Detail Jenis') { // revisi khusus detail jenis
				$jenis = $this->input->post('jenis');
				$isi2 = $jenis.' '.$isi[$i];
				if ($ket == 'Baru') {
					$this->M_monitoringorder->updatefilebaru("jenis = '".$isi2."'",$no_order);
				}elseif ($ket == 'Modifikasi') {
					$this->M_monitoringorder->updatefilemodif("jenis = '".$isi2."'",$no_order);
				}else{
					$this->M_monitoringorder->updatefilerekon("jenis = '".$isi2."'",$no_order);
				}
			}elseif (!empty($nama[$i])) {
				$this->M_monitoringorder->insertrevisi($no_order, 1, $nama[$i], $isi[$i], date('Y-m-d H:i:s'),$this->session->user);
			}
		}
		// exit();
		// echo "<pre>";print_r($_FILES);exit();
		
		redirect(base_url('OrderToolMaking/MonitoringOrder/'));
		// echo "<pre>";print_r($no_order);
	}   
	
	public function carirevisi($no_order, $val, $cek){
		$cari 	= $this->M_monitoringorder->cekrevisi($cek, $no_order); // cek revisi dari approval terbaru
		if ($cek == 'Gambar Produk') { // hal yang dicek
			$gb = explode(';', $val);
			for ($i=0; $i < count($gb) ; $i++) { 
				$cari 	= $this->M_monitoringorder->cekrevisi2($cek, $no_order, $gb[$i]); // cek revisi dari approval terbaru
				if (!empty($cari)) { // ada revisi -> ambil data file dari folder $hasil
					$hasil[] = $cari[0]['person'] == 2 ? 'Ass_Ka_Nit_Pengorder' :
							($cari[0]['person'] == 5 ? 'Designer_Produk' :
							($cari[0]['person'] == 3 ? 'Kasie_PE' : 
							($cari[0]['person'] == 4 ? 'Ass_Ka_Nit_PE' : 'Pengorder')));
				}else { // tidak ada revisi -> ambil data file dari folder Pengorder
					$hasil[] = 'Pengorder';
				}
			}
		}elseif($cek == 'Skets'){
			if (!empty($cari)) { // ada revisi -> ambil data file dari folder $hasil
				$hasil = $cari[0]['person'] == 2 ? 'Ass_Ka_Nit_Pengorder' :
						($cari[0]['person'] == 5 ? 'Designer_Produk' :
						($cari[0]['person'] == 3 ? 'Kasie_PE' : 
						($cari[0]['person'] == 4 ? 'Ass_Ka_Nit_PE' : 'Pengorder')));
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
			$fix['folder_gamker'] = $this->carirevisi($val['no_order'], $val['gambar_kerja'], 'Gambar Produk');
			$fix['skets'] 		= $val['skets'];
			$fix['folder_skets']= $this->carirevisi($val['no_order'], $val['skets'], 'Skets');
			$fix['kodekomp'] 	= $this->carirevisi($val['no_order'], $val['kode_komponen'], 'Kode Komponen');
			$fix['namakomp'] 	= $this->carirevisi($val['no_order'], $val['nama_komponen'], 'Nama Komponen');
			$fix['tipe_produk'] = $this->carirevisi($val['no_order'], $val['tipe_produk'], 'Tipe Produk');
			$fix['tgl_rilis'] 	= $this->carirevisi($val['no_order'], date('d/m/Y', strtotime($val['tgl_rilis'])), 'Tanggal Rilis Gambar');
			$fix['poin'] 		= $this->carirevisi($val['no_order'], $val['poin'], 'Proses');
			$fix['proses_ke'] 	= $this->carirevisi($val['no_order'], $val['proses_ke'], 'Proses Ke');
			$fix['dari'] 		= $this->carirevisi($val['no_order'], $val['dari'], 'Dari');
			$fix['referensi'] 	= $this->carirevisi($val['no_order'], $val['referensi'], 'Referensi / Datum Alat Bantu');
			$fix['assign_order'] = $val['assign_order'];
			$nama_app 			= $this->M_monitoringorder->getseksiunit($val['assign_approval']); // cari seksi pic ass ka nit pengorder
			$nama_app 			= !empty($nama_app) ? $nama_app[0]['nama'] : ''; 
			$fix['assign'] 		= $val['assign_approval'].' - '.$nama_app;
			$fix['assign_desainer'] = $val['assign_desainer'];
			$fix['stp_gambar_kerja'] = $val['stp_gambar_kerja'];
			$fix['status_order'] = $val['status_order'];
			$fix['pengorder'] = $val['pengorder'];
			$fix['reject_by'] = $val['reject_by'];
			
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
				$fix['alasan_asset'] = $this->carirevisi($val['no_order'], $val['alasan_asset'], 'Alasan Asset');
			}else { // tabel modifikasi dan rekondisi
				$fix['alasan'] 		= $this->carirevisi($val['no_order'], $val['alasan_modifikasi'], 'Alasan Modifikasi');
				$fix['no_alat'] 	= $this->carirevisi($val['no_order'], $val['no_alat_bantu'], 'No Alat Bantu');
				$fix['inspection_report'] 	= $val['inspection_report'];
			}
			$fix['poinrevisi'] = $this->M_monitoringorder->getpoinrevisi($val['no_order']);
		}
		return $fix;
	}

	public function terimabarang(){
		$no_order 		= $this->input->post('no_order');
		$cek = $this->M_monitoringorder->cekaction($no_order, "and person = 11"); // status 11 = barang sudah diterima seksi pengorder
		if (empty($cek)) {
			$this->M_monitoringorder->saveaction($no_order, 11, 1, '', date('Y-m-d H:i:s'), $this->session->user);
		}else {
			$this->M_monitoringorder->updateaction($no_order, 11, 1, '', date('Y-m-d H:i:s'), $this->session->user);
		}
		redirect(base_url('OrderToolMaking/MonitoringOrder/'));
	}
	


}















