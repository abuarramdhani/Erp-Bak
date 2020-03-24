<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_OrderList extends CI_Controller
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
		$this->load->model('TicketingMaintenance/M_agent');

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

		$data['Title'] = 'Order List';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['orderList'] = $this->M_agent->viewOrder();
		// echo "<pre>";print_r($data['orderList']);exit();
		$data['orderListWithName'] = $this->M_agent->selectNamaPengorder();

		// $noind = [];
		// foreach ($data['orderList'] as $key) {
		// 	$noind[] = $key['noind_pengorder'];
		// }
		// // echo count($noind);
		// for ($i=0; $i < count($noind); $i++) { 
		// 	$data = array(
		// 		'noind'  => $noind[$i]
		// 	);
		// $selectNama = $this->M_agent->selectNamaPengorder($data);
		// // echo "<pre>";print_r($data);exit();
		// }

		foreach ($data['orderList'] as $ini) {
			$data['untukmodal'][$ini['no_order']] = $ini;
		}
		// echo "<pre>";print_r($data['untukmodal']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_orderList', $data);
		$this->load->view('V_Footer',$data);
	}

	public function detail($id)
	{
		$user = $this->session->username;
		// echo $id;exit();
		$user_id = $this->session->userid;
		// echo $user_id;exit();
		$data['Title'] = 'Order List Detail';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// print_r($id);exit();
		$data['orderById'] = $this->M_agent->viewById($id); //select data order
		$data['noInduk'] = $this->session->user;

			// echo "<pre>";echo 'here I am'; 	echo "<pre>"; print_r($data['noInduk']);exit();

		$no_order = $data['orderById'][0]['no_order'];
		$data['viewLaporanPerbaikan'] = $this->M_agent->viewLaporanPerbaikan($no_order); //select laporan perbaikan

		if ($data['viewLaporanPerbaikan'] == null) {
			$data['viewLaporanPerbaikan'] = null;
			$data['viewKeterlambatan'] = $this->M_agent->viewKeterlambatan($id);
			if ($data['viewKeterlambatan'] == null) {
				$data['viewKeterlambatan'] = null;
			}else{
				$data['viewKeterlambatan'] = $this->M_agent->viewKeterlambatan($id);
			}

		}else{
			$data['viewLaporanPerbaikan'] = $this->M_agent->viewLaporanPerbaikan($no_order);
			$id_laporan = $data['viewLaporanPerbaikan'][0]['id_laporan']; //get id laporan
			// if ($id_laporan == null) {
				// $data['viewLangkahPerbaikan'] == null;
			// }else{
				$data['viewLangkahPerbaikan'] = $this->M_agent->viewLangkahPerbaikan($id_laporan); //select langkah perbaikan
			// }
	
			$getId = $this->M_agent->slcIdReparasi($no_order);
			// echo "<pre>";print_r($getId);
			// exit();
			
			// if ($getId == null) {
			// 	$getId = null;
			// }else{
			$getId = $this->M_agent->slcIdReparasi($no_order);
			// }
			$id_reparasi = $getId[0]['id'];
			$data['viewReparasi'] = $this->M_agent->viewDataReparasi($id,$id_reparasi); //select data reparasi
			// echo "<pre>";print_r($id_reparasi);exit();
			// $data['viewPelaksanaReparasi'] = $this->M_agent->viewPelaksanaReparasi($id_reparasi);
			if ($id_reparasi !== null) {
				$data['viewAllReparation'] = $this->M_agent->slcAllReparation($id);
			}else{
				$data['viewAllReparation'] = null;
			}
			// echo "<pre>";print_r($data);exit();

			// echo "<pre>";print_r($data['viewAllReparation']);exit();

			// $nama= [];
			// foreach ($data['viewPelaksanaReparasi'] as $key) {
			// 	$nama[] = trim($key['nama']);
			// 	$nama_pelaksana = implode(', ',$nama);
			// }
			// echo"<br>";echo "<pre>";print_r($nama_pelaksana);

			// echo "<pre>";print_r($data['viewReparasi']);

			$data['viewSparepart'] = $this->M_agent->viewSparePart($id);
			$data['viewKeterlambatan'] = $this->M_agent->viewKeterlambatan($id);
			// echo "<pre>";echo 'here I am'; print_r($data['viewSparepart']);exit();
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_orderListById', $data);
		$this->load->view('V_Footer',$data);
	}

	public function isiLaporan($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Laporan Perbaikan';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $this->M_agent->viewOnlyId($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_isiLaporan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function isiLaporanEdit($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Laporan Perbaikan';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $this->M_agent->viewOnlyId($id);
		$data['orderById'] = $this->M_agent->viewById($id); //select data order
		$no_order = $data['orderById'][0]['no_order'];
		$data['viewLaporanPerbaikan'] = $this->M_agent->viewLaporanPerbaikan($no_order); //select laporan perbaikan

		if ($data['viewLaporanPerbaikan'] == null) {
			$data['viewLaporanPerbaikan'] = null;
		}else{
			$data['viewLaporanPerbaikan'] = $this->M_agent->viewLaporanPerbaikan($no_order);
			$id_laporan = $data['viewLaporanPerbaikan'][0]['id_laporan']; //get id laporan
			$data['viewLangkahPerbaikan'] = $this->M_agent->viewLangkahPerbaikan($id_laporan); //select langkah perbaikan
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_isiLaporanEdit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function save_laporan() 
	{
		// echo "<pre>";print_r($_POST);exit();
		$no_order 			= $this->input->post('id');
		$kerusakan          = $this->input->post('kerusakan');
		$penyebab           = $this->input->post('penyebab');
		$langkah_pencegahan = $this->input->post('langkahPencegahan');
		$ver_perbaikan      = $this->input->post('verPerbaikan');

		$insertLaporanPerbaikan = $this->M_agent->insertLaporanPerbaikan($no_order,$kerusakan,$penyebab,$langkah_pencegahan,$ver_perbaikan);
	
		$dataId = $this->M_agent->selectIdLaporanPerbaikan($no_order);
		$id = $dataId[0]['id'];	
		// echo "<pre>";print_r($id);
		// exit();
		
		$urutan 			= $this->input->post('arry[]');
		$langkah_perbaikan  = $this->input->post('langkah_perbaikan[]');
		$status = 'reviewed';
		$now = date('Y/m/d h:i:s', time());

		for ($i=0; $i < count($langkah_perbaikan); $i++) { 
			$data = array(
				'id_laporan'  	=> $id,
				'urutan'		=> $urutan[$i],
				'langkah' 	    => $langkah_perbaikan[$i],
			);
		$insertLangkahPerbaikan = $this->M_agent->insertLangkahPerbaikan($data);
		}
		$updateStatus = $this->M_agent->updateStatus($status,$no_order);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);
	
		// redirect('TicketingMaintenance/Agent/OrderList/detail/'.$no_order);
	}

	public function save_laporanEdit() 
	{
		// echo "<pre>";print_r($_POST);exit();
		$no_order 			= $this->input->post('id');
		$kerusakan          = $this->input->post('kerusakan');
		$penyebab           = $this->input->post('penyebab');
		$langkah_pencegahan = $this->input->post('langkahPencegahan');
		$ver_perbaikan      = $this->input->post('verPerbaikan');

		$data['viewLaporanPerbaikan'] = $this->M_agent->viewLaporanPerbaikan($no_order);
		// echo "<pre>";print_r($data['viewLaporanPerbaikan']);
		$id_laporan			= $data['viewLaporanPerbaikan'][0]['id_laporan'];
		// echo $id_laporan;
		// exit();

		$updateLaporanPerbaikan = $this->M_agent->updateLaporanPerbaikan($kerusakan,$penyebab,$langkah_pencegahan,$ver_perbaikan,$id_laporan,$no_order);
		// exit();
		$idLapEr = $this->M_agent->slcIdLaporanPerbaikan($id_laporan);
		$id = $idLapEr[0]['id_laporan'];	

		$urutan 			= $this->input->post('arry[]');
		$langkah_perbaikan  = $this->input->post('langkah_perbaikan[]');

		$getId = $this->M_agent->selectIdReparasi($no_order);

		if ($getId == null) {
			$id_reparasi = null;	
			// $data['viewReparasi'] == null;	
		}else{
			$id_reparasi = $getId[0]['no_order'];
			$data['viewReparasi'] = $this->M_agent->viewDataReparasi($id_reparasi); //select data reparasi
		}
		// echo "<pre>";echo($id_reparasi);
		// exit();
		// if (condition) {
		// 	# code...
		// }
		// $data['viewReparasi'] = $this->M_agent->viewDataReparasi($id_reparasi);
		// if ($data['viewReparasi'] == null) {
		// 	$data['viewReparasi'] == null;
		// }else{
		// 	$data['viewReparasi'] = $this->M_agent->viewDataReparasi($id_reparasi); //select data reparasi
		// }
		// echo "<pre>";print_r($data['viewReparasi']);exit();
		// $data['viewPelaksanaReparasi'] = $this->M_agent->viewPelaksanaReparasi($id_reparasi);
		// if ($id_reparasi !== null) {
		// 	$data['viewAllReparation'] = $this->M_agent->slcAllReparation($id);
		// }else{
		// 	$data['viewAllReparation'] = null;
		// }


		if ($getId == null) {
			$status = 'reviewed';
		}else{
			// $status = 'action';
			$status_order = $this->M_agent->slcStatus($no_order);
			$status = $status_order[0]['status_order'];
			// echo "<pre>";echo($status);exit();
		}
		// echo $status; exit();
		// $status = 'action';
		$now = date('Y/m/d h:i:s', time());

		$deleteLangkahPerbaikan = $this->M_agent->deleteLangkahPerbaikan($id_laporan);
		// echo "<pre>";print_r($langkah_perbaikan);
		// exit();

		for ($i=0; $i < count($langkah_perbaikan); $i++) { 
			$data = array(
				'id_laporan'  	=> $id,
				'urutan'		=> $urutan[$i],
				'langkah' 	    => $langkah_perbaikan[$i],
			);
			// echo "<pre>";print_r($data);
		$insertLangkahPerbaikan = $this->M_agent->insertLangkahPerbaikan($data);
		}
		// exit();
		$updateStatus = $this->M_agent->updateStatus($status,$no_order);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);
	
		// redirect('TicketingMaintenance/Agent/OrderList/detail/'.$no_order);
	}

	public function isiReparasi($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Reparasi';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $this->M_agent->viewOnlyId($id);
		$noind = $this->session->user;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_isiReparasi', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Pelaksana()
	{ 		
		$pls = $this->input->GET('pls',TRUE);
		$pls = strtoupper($pls);  
		$pelaksana = $this->M_agent->Pelaksana($pls);
		echo json_encode($pelaksana);
		// $noind = $this->session->user;
		// $data['getSeksiUnit'] = $this->M_agent->detectSeksiUnit($noind);
		// $split = $data['getSeksiUnit'][0];
		// $seksi = $split['seksi'];
		// $unit = $split['unit'];
		// echo "<pre>";echo $noind;
		// echo "<pre>";print_r($data['getSeksiUnit']);exit();
	}

	public function saveReparasi()
	{
		// echo "<pre>";print_r($_POST);exit();
		$no_order = $this->input->post('no_order');
		// echo($no_order);exit();
		// $getId = $this->M_agent->getIdReparasi($no_order);
		$pelaksana = $this->input->post('pelaksana');

		for ($i=0; $i < count ($pelaksana) ; $i++) { 
			$plk[] = explode("- ", $pelaksana[$i]);
		}

		$no_induk = [];
		$nama_pelaksana = [];
		foreach ($plk as $key) {
			$no_induk[] = $key['0'];
			$nama_pelaksana[] = $key['1'];
		}

		// echo "<pre>";echo "nama pelaksana: ";print_r($nama_pelaksana);
		// echo "<pre>";echo "no induk: ";print_r($no_induk);
		// exit();
	
		$noind = [];
		$nama  = [];
		foreach ($plk as $key) {
			$noind[] = trim($key['0']);
			$nama[]  = trim($key['1']); 
		}
		$noind = implode(', ', $noind);
		$nama  = implode(', ', $nama);
		// echo $noind."<br>".$nama; 
		// die;
		
		$tgl_reparasi = $this->input->post('tanggal');
		$jam_mulai = $this->input->post('jamMulai');
		$jam_selesai = $this->input->post('jamSelesai');
		// exit();
		$status = 'action';
		$now = date('Y/m/d h:i:s', time());

		$insertReparasi = $this->M_agent->insertReparasi($no_order,$tgl_reparasi,$jam_mulai,$jam_selesai);
		$slcId = $this->M_agent->slcIdReparasi($no_order);
		$id_reparasi = $slcId[0]['id'];
		// echo"<pre>";print_r($id_reparasi);exit();

		// echo count($plk);exit();
		for ($i=0; $i < count($plk); $i++) { 
			$data = array(
				'id_reparasi'  	=> $id_reparasi,
				'nama'			=> $nama_pelaksana[$i],
				'no_induk' 	    => $no_induk[$i],
			);
		$insertPelaksanaRepasi = $this->M_agent->insertPelaksanaReparasi($data);
		}
		$updateStatus = $this->M_agent->updateStatus($status,$no_order);
		// echo "<pre>";print_r($updateStatus);exit();
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);

		redirect('TicketingMaintenance/Agent/OrderList/detail/'.$no_order);
	}

	public function deleteRiwayatReparasi($no_order,$id_reparasi)
	{
    	$dataRiwayat = $this->M_agent->deleteRiwayatReparasi($id_reparasi);      
		$dataPelaksana = $this->M_agent->deletePelaksanaReparasi($id_reparasi);      
		
		redirect('TicketingMaintenance/Agent/OrderList/detail/'.$no_order.'/#pg_2');
	}

	public function isiSparepart($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Sparepart';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $this->M_agent->viewOnlyId($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_isiSparepart', $data);
		$this->load->view('V_Footer',$data);
	}

	public function isiSparepartEdit($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Sparepart';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $this->M_agent->viewOnlyId($id);
		$data['viewSparepart'] = $this->M_agent->viewSparePart($id);
		// echo $id;
		// echo "<pre>";print_r($data['viewSparepart']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_isiSparepartEdit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function saveSparepart()
	{
		// echo "<pre>";print_r($_POST);
		$no_order = $this->input->post('no_order');
		$nama = $this->input->post('nm_spr');
		if ($nama == null) {
			$nama = $this->input->post('nm_sprT');
		}
		// echo $nama;die;
		$spesifikasi = $this->input->post('spek_spr');
		$jumlah = $this->input->post('jml_spr');
		$now = date('Y/m/d h:i:s', time());
		// exit();

		$this->M_agent->insertSparepart($no_order,$nama,$spesifikasi,$jumlah);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);

		redirect('TicketingMaintenance/Agent/OrderList/detail/'.$no_order);
	}

	public function deleteSparepart()
	{
		$no_order = $this->input->post('no_order');
		$id = $this->input->post('id_sparepart');

		$data = $this->M_agent->deleteSparepart($id);      
	}

	public function isiKeterlambatan($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Keterlambatan';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $this->M_agent->viewOnlyId($id);
		$data['selectOrder'] = $this->M_agent->viewById($id);
		$data['selectLate'] = $this->M_agent->viewLateById($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_isiKeterlambatan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function save_keterlambatan()
	{
		// echo "<pre>";print_r($_POST);exit();
		$no_order = $this->input->post('no_order');
		$alasan   = $this->input->post('alasan');
		$mulai    = $this->input->post('tanggalMulai');
		$selesai  = $this->input->post('tanggalSelesai');
		$tanggal_pengurangan = $this->input->post('tanggalPengurangan');
		// echo "<pre>";echo $tanggal_pengurangan;
		$update_duedate1 = date('Y-m-d', strtotime($selesai. '+'.$tanggal_pengurangan.' day'));
		// echo "<pre>";echo $update_duedate1;exit();
		// $status = 'overdue';
		$now = date('Y/m/d h:i:s', time());

		$insertKeterlambatan = $this->M_agent->insertKeterlambatan($no_order,$alasan,$mulai,$selesai);
		// $updateStatus = $this->M_agent->updateStatus($status,$no_order);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);
		$data['selectLate'] = $this->M_agent->viewLateById($no_order);
		// $getMax = $this->M_agent->slcTanggalMax($no_order);
			foreach ($data['selectLate'] as $kelar) {
				$finish_late = $kelar['waktu_selesai'];
				$finish_late = explode(" ", $finish_late);
			}
			$finish_max = max($finish_late); //kalo kek gini kan cuma max yg di database ndes!!

			$angka_penambah = date('Y-m-d', strtotime($finish_max. '+'.$tanggal_pengurangan.' day'));

			if ($data['selectLate'] == null) {
				$updateDueDate = $this->M_agent->updateDueDate($update_duedate1,$no_order);
			}else{
				$updateDueDate = $this->M_agent->updateDueDate($angka_penambah,$no_order);
			}

		redirect('TicketingMaintenance/Agent/OrderList/');
	}

	public function isiDone($id)
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Done Order';
		$data['Menu'] = 'Ticketing Maintenance Agent';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['id'] = $this->M_agent->viewOnlyId($id);

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['id'] = $this->M_agent->viewOnlyId($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/orderList/V_isiDone', $data);
		$this->load->view('V_Footer',$data);
	}

	public function saveDone()
	{
		// $noind = $this->session->user;
		// $now = date('Y/m/d h:i:s', time());
		// $status = 'done';
		$id = $this->input->post('id');
		$noind = $this->input->post('noind');
		$now = $this->input->post('now');
		$status = $this->input->post('status');

		$insertDone = $this->M_agent->saveDone($noind,$now,$id);
		$updateStatus = $this->M_agent->updateStatus($status,$id);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$id);

		// redirect('TicketingMaintenance/Agent/');
	}

	public function updateLastResponse($id)
	{
		$now = date('Y/m/d h:i:s', time());
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$id);
	}

	public function savePerkiraanSelesai()
	{
		$no_order = $this->input->post('no_Order');
		$perkiraan_selesai = $this->input->post('perkiraanSelesai');
		$tgl_order_diterima = date('Y/m/d h:i:s', time());
		$status = 'acc';
		$now = date('Y/m/d h:i:s', time());
		$noind = $this->session->user;
		
		// echo "<pre>";print_r($perkiraan_selesai);
		// echo "<pre>";print_r($tgl_order_diterima);
		// echo "<pre>";print_r($noind);
		// exit();

		$savePerkiraanSelesai = $this->M_agent->savePerkiraanSelesai($noind,$tgl_order_diterima,$perkiraan_selesai,$no_order);
		$updateStatus = $this->M_agent->updateStatus($status,$no_order);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);

		redirect('TicketingMaintenance/Agent/');
	}

	public function saveReject()
	{
		$no_order = $this->input->post('no_OrderReject');
		$tgl_reject = date('Y-m-d');
		$status = 'reject';
		$now = date('Y/m/d h:i:s', time());
		$reason = $this->input->post('alasan_Reject');
		// echo $reason;exit();

		$saveReject = $this->M_agent->saveReject($tgl_reject,$reason,$no_order);
		$updateStatus = $this->M_agent->updateStatus($status,$no_order);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);

		redirect('TicketingMaintenance/Agent/');	
	}

	public function updateOverdueDate()
	{
		$no_order = $this->input->post('modalEditOverdue');
		$new_date = date('Y-m-d');
		$status = 'reject';
		$now = date('Y/m/d h:i:s', time());
		// $reason = $this->input->post('alasan_Reject');
		// echo $reason;exit();

		$saveEdit = $this->M_agent->saveReject($new_date,$no_order);
		$updateStatus = $this->M_agent->updateStatus($status,$no_order);
		$updateLastResponse = $this->M_agent->updateLastResponse($now,$no_order);

		redirect('TicketingMaintenance/Agent/OrderList/detail/'.$no_order);
	}

	public function SparePart()
	{ 		
		$sp = $this->input->GET('sp',TRUE);
		$sp = strtoupper($sp);  
		$sparepart = $this->M_agent->slcSparepart($sp);
		echo json_encode($sparepart);
	}

	public function isiMasterKodeSeksi()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master Kode Seksi';
		$data['Menu'] = 'Master Kode Seksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['selectKodeSeksi'] = $this->M_agent->viewKodeSeksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/MasterKodeSeksi/V_CreateKodeSeksi', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Seksi()
	{
		$term = $this->input->GET('term',TRUE);
		$term = strtoupper($term);  
		$seksi = $this->M_agent->Seksi($term);
		echo json_encode($seksi);
	}

	public function saveMasterKodeSeksi()
	{
		// echo "<pre>";print_r($_POST);exit();
		$nama_seksi = $this->input->post('nm_seksi');
		$kode_seksi = $this->input->post('kode_seksi');

		$data['selectSeksi'] = $this->M_agent->selectSeksiMaster($nama_seksi);
		// print_r($data['selectSeksi']);
		if ($data['selectSeksi'] !== array()) {
			$updateMasterKodeSeksi = $this->M_agent->updateMasterKodeSeksi($kode_seksi,$nama_seksi);
		}else{
			$saveMasterKodeSeksi = $this->M_agent->saveMasterKodeSeksi($nama_seksi,$kode_seksi);
		}
		// die;

		redirect('TicketingMaintenance/Agent/MasterKodeSeksi/');
	}

	public function deleteKodeSeksi()
	{
		$id = $this->input->post('id_seksi');
		// echo $id;die;
		$data = $this->M_agent->deleteKodeSeksi($id);      
	}

	public function cetakOPPM($id)
	{
		$this->load->library('pdf');
		$pdf		= $this->pdf->load();
		$pdf 		= new mPDF('utf-8', 'F4', 0, '', 3, 3, 3, 0, 2, 2);
		$filename   = 'Lembar OPPM.pdf';
		
		$data['selectDataOrder'] = $this->M_agent->viewById($id); //select data order
		foreach ($data['selectDataOrder'] as $do) {
			$no_order = $do['no_order'];
		}
		$data['selectIdLapEr'] = $this->M_agent->selectIdLaporanPerbaikan($id);
		$id_laporan = $data['selectIdLapEr'][0]['id'];
		// if ($id_laporan == null) {
		// 	$id_laporan == null;
		// }

		if ($id_laporan !== null) {
			$data['selectDataLaporanPerbaikan'] = $this->M_agent->viewAllLangkahPerbaikan($id_laporan); //select data laporan perbaikan
			foreach ($data['selectDataLaporanPerbaikan'] as $key) {
				$no_order			  = $key['no_order'];
				$id_laporan			  = $key['id_laporan'];
				$kerusakan 			  = $key['kerusakan'];
				$penyebab_kerusakan   = $key['penyebab_kerusakan'];
				$langkah_pencegahan   = $key['langkah_pencegahan'];
				$verifikasi_perbaikan = $key['verifikasi_perbaikan'];
				$langkah 			  = $key['langkah'];
			}
			if (empty($data['selectDataLaporanPerbaikan'])) {
				$data['selectDataLaporanPerbaikan'] = $this->M_agent->viewLaporanPerbaikan($no_order);	
				foreach ($data['selectDataLaporanPerbaikan'] as $key) {
					$no_order			  = $key['no_order'];
					$id_laporan			  = $key['id_laporan'];
					$kerusakan 			  = $key['kerusakan'];
					$penyebab_kerusakan   = $key['penyebab_kerusakan'];
					$langkah_pencegahan   = $key['langkah_pencegahan'];
					$verifikasi_perbaikan = $key['verifikasi_perbaikan'];
					$langkah 			  = $key['langkah'];
				}
					for ($i=0; $i < 7 - $hitungDataLP; $i++) { 
						$data['selectDataLaporanPerbaikan'][] = array(
						"no_order"=> $no_order, 
						"id_laporan"=> $id_laporan,
						"kerusakan"=> $kerusakan,
						"penyebab_kerusakan"=> $penyebab_kerusakan,
						"langkah_pencegahan"=> $langkah_pencegahan,
						"verifikasi_perbaikan"=> $verifikasi_perbaikan,
						"urutan"=>"",
						"langkah"=>""
						);				
					}
					// echo "<pre>";print_r($data['selectDataLaporanPerbaikan']);die;
			}else{
				$hitungDataLP = count($data['selectDataLaporanPerbaikan']);
				if (count($data['selectDataLaporanPerbaikan']) < 7) {
					for ($i=0; $i < 7 - $hitungDataLP; $i++) { 
						$data['selectDataLaporanPerbaikan'][] = array(
						"no_order"=> $no_order, 
						"id_laporan"=> $id_laporan,
						"kerusakan"=> $kerusakan,
						"penyebab_kerusakan"=> $penyebab_kerusakan,
						"langkah_pencegahan"=> $langkah_pencegahan,
						"verifikasi_perbaikan"=> $verifikasi_perbaikan,
						"urutan"=>"",
						"langkah"=>""
						);				
					}
				}
			}
		}else{
				for ($i=0; $i < 7 - $hitungDataLP; $i++) { 
					$data['selectDataLaporanPerbaikan'][] = array("no_order"=>"", 
					"id_laporan"=>"",
					"kerusakan"=>"",
					"penyebab_kerusakan"=>"",
					"langkah_pencegahan"=>"",
					"verifikasi_perbaikan"=>"",
					"urutan"=>"",
					"langkah"=>"");				
				}
		}
		
		$data['selectReparasi'] = $this->M_agent->slcAllReparation($id); //select data reparasi
		$hitungDataReparasi = count($data['selectReparasi']);	
		if (count($data['selectReparasi']) < 5){
			for ($i=0; $i < 5 - $hitungDataReparasi ; $i++) { 
				$data['selectReparasi'][] = array("no_order"=>"", 
				"tgl_reparasi"=>"",
				"jam_mulai_reparasi"=>"",
				"jam_selesai_reparasi"=>"",
				"id_reparasi"=>"",
				"nama"=>"");
			}
		}
		$data['selectSparepart'] = $this->M_agent->viewSparePart($id); //select data sparepart

		$hitungData = count($data['selectSparepart']);			
		if (count($data['selectSparepart']) < 5){
			for ($i=0; $i < 5 - $hitungData ; $i++) { 
				$data['selectSparepart'][] = array("no_order"=>"", 
				"nama_sparepart"=>"",
				"spesifikasi"=>"",
				"jumlah"=>"",
				"id_sparepart"=>"");
			}
		}
		 
		$lambat = $this->M_agent->viewKeterlambatan($id); //select data keterlambatan
		for ($l=0; $l < sizeof($lambat); $l++) { 
			$tmpMulai = explode(" ", $lambat[$l]['waktu_mulai']); 
			$lambat[$l]['tgl_mulai'] = $tmpMulai[0];
			$lambat[$l]['jam_mulai'] = $tmpMulai[1];

			$tmpSelesai = explode(" ", $lambat[$l]['waktu_selesai']);
			$lambat[$l]['tgl_selesai'] = $tmpSelesai[0];
			$lambat[$l]['jam_selesai'] = $tmpSelesai[1];

		}
		
		$data['selectKeterlambatan'] = $lambat;

		$head = $this->load->view('TicketingMaintenance/Agent/Report/V_HeaderOPPM', $data, TRUE);
		$line = $this->load->view('TicketingMaintenance/Agent/Report/V_PDF', $data, TRUE);
		$foot = $this->load->view('TicketingMaintenance/Agent/Report/V_FooterOPPM', $data, TRUE);

		$pdf->SetHTMLHeader($head);
		$pdf->SetHTMLFooter($foot);
		$pdf->WriteHTML($line, 2);

    	$pdf->Output($filename, 'I');
	}

	public function checkRekap()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Order';
		$data['Menu'] = 'Rekap Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['selectKodeSeksi'] = $this->M_agent->viewKodeSeksi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TicketingMaintenance/Agent/Rekap/V_Rekap', $data);
		$this->load->view('V_Footer',$data);
	}

	public function slcMesinRekap()
	{
		$ms = $this->input->GET('ms',TRUE);
		// $ms = strtoupper($ms);  
		$namaMesin = $this->M_agent->selectNamaMesin($ms);
		echo json_encode($namaMesin);
	}

	public function slcSeksiRekap()
	{
		$sk = $this->input->GET('sk',TRUE);
		$sk = strtoupper($sk);  
		$namaSeksi = $this->M_agent->selectNamaSeksi($sk);
		echo json_encode($namaSeksi);
	}

	public function selectRekapOPPM()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Order';
		$data['Menu'] = 'Rekap Order';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// echo "<pre>";print_r($_POST);
		$jenis_parameter    = $this->input->post('filterRekap');
		$nama_mesin 		= $this->input->post('txtParMesin[]');
		// echo"<pre>";print_r($nama_mesin);
		if ($nama_mesin !== NULL) {
			$machine			= implode("", $nama_mesin);
			// echo"<pre>";print_r($machine);
			$mch				= explode(" ", $machine);
			$par_mach 			= $mch[0];
			// echo"<pre>"; print_r($mch); die;
			$mesin				= implode("' ,'", $nama_mesin);
			$msn				= implode("$", $nama_mesin);
			$data['namaMesin']	= $msn;
		}
		$seksi				= $this->input->post('txtParSeksi');	
		$tgl_reparasi_awal  = $this->input->post('txtRangeAwal');
		$tgl_reparasi_akhir = $this->input->post('txtRangeAkhir');
		$data['jenisParameter'] = $jenis_parameter;
		$data['namaSeksi']		= $seksi;

		if ($jenis_parameter == 'FilterMesin') {
			$data['selectRekapMesin'] = $this->M_agent->selectRecapByMesin($par_mach); //by date mesin

		//-----------------------------------------RECAP BY MESIN-----------------------------------//	
		$newdata = [];
		foreach($data['selectRekapMesin'] as $item){
			$newdata[$item['nama_mesin']][] = $item;
		}
		//echo "<pre>";print_r($newdata);

		$newarr = [];
		$realArray = [];
		$i = 0;

		foreach ($newdata as $item) {
			$prev = 0;
			$machine = $item[0]['nama_mesin'];
			$seksi = $item[0]['seksi'];
			$tgl_order = $item[0]['tgl_order'];

			foreach($item as $a){
				$realArray[$i][$a['no_order']] = $item;
			}

			foreach ($item as $b) {
				$idReparasi[$i][$b['id_reparasi']] = $item;
			}

			$newarr[$i]['machine_name'] = $machine;
			$newarr[$i]['section'] = $seksi;
			foreach ($item as $key) {
				$prev = $prev + $key['range'];

				$newarr[$i]['total_duration'] =  $prev;
			}

			$newarr[$i]['total_reparation'] = count($idReparasi[$i]);
			$newarr[$i]['total_machine'] = count($realArray[$i]); //TOTAL ORDER
			$newarr[$i]['sum'] = number_format(($newarr[$i]['total_duration'] / count($idReparasi[$i])/60),2); //MTBR
			$newarr[$i]['tanggal_awal'] = $tgl_reparasi_awal;
			$newarr[$i]['tanggal_akhir'] = $tgl_reparasi_akhir;
			// echo "<pre>";print_r($newarr[$i]['total_machine']);
			$i++;
		}
		
		$array_range = [];
		$no = 0;
		foreach ($newdata as $item) {
			$prev = 0;
			$prevTime = 0;

			$i = 0;

			foreach ($item as $key) {
				if($i == 0){
					$i++;
					$prevTime = $key['tgl_order'];
					continue;
				  }

				  $start_date = new DateTime($prevTime);
				  $end_date   = new DateTime($key['tgl_order']);
				  
				  $since_start = $start_date->diff($end_date);

				  $month   = $since_start->m * 30 * 24 * 60;
				  $days    = $since_start->d * 24 * 60;
				  $hours   = $since_start->h * 60;
				  $minutes = $since_start->m;
				  
				  //echo $key['tgl_order']."-".$days."-".$hours."-".$menit."<br>";
				  
				  $hasil = $month+$days+$hours+$minutes;
				  //echo $menit."<br>";				  
				  if($hasil != 0){
					$array_range[] = $hasil;
					// $array_range[$no][] = $hasil;
				  }
				  
				  $prevTime = $key['tgl_order'];
				  $prev =  $prev+($days+$hours+$minutes);
			}
			$no++;
		}
		// echo "<pre>";print_r($array_range);

		function count_all($a, $b){
			return $a = $a+$b;
		}

		$total_minutes = [];
		foreach($array_range as $key){
			// $total_minutes[] = array_reduce($key, 'count_all', '0');
			$total_minutes[] = $array_range;
		}
		// echo "<pre>";print_r($total_minutes);die;

		$j = 0;
		foreach($newarr as $key){
			// echo "<pre>";print_r($key);die;
			$jumlah_order = $key['total_machine'];
			if ($jumlah_order > 1) {
				$newarr[$j]['total_minutes'] = $array_range[$j];
				$newarr[$j]['end_result'] = number_format(($newarr[$j]['total_minutes']/$newarr[$j]['total_machine']/60),2);  //MTBR
			}else {
				$newarr[$j]['end_result'] = '-';
			}
			$j++;   
		}
		// die;
		$data['hasilRekapDataByMesin'] = $newarr; 

		//-----------------------------------------END OF RECAP BY MESIN-----------------------------------------//

		}elseif ($jenis_parameter == 'FilterSeksi') {
			$data['selectRekapSeksi'] = $this->M_agent->selectRecapBySeksi($seksi); //by date seksi

			$newdata = [];
			foreach($data['selectRekapSeksi'] as $item){
				$newdata[$item['nama_mesin']][] = $item;
			}
			// echo "<pre>";print_r($newdata);
	
			$newarr = [];
			$realArray = [];
			$i = 0;
	
			foreach ($newdata as $item) {
				$prev = 0;
				$machine = $item[0]['nama_mesin'];
				$seksi = $item[0]['seksi'];
				$tgl_order = $item[0]['tgl_order'];
	
				foreach($item as $a){
					$realArray[$i][$a['no_order']] = $item;
				}
	
				foreach ($item as $b) {
					$idReparasi[$i][$b['id_reparasi']] = $item;
				}
	
				$newarr[$i]['machine_name'] = $machine;
				$newarr[$i]['section'] = $seksi;
				foreach ($item as $key) {
					$prev = $prev + $key['range'];
	
					$newarr[$i]['total_duration'] =  $prev;
				}
	
				$newarr[$i]['total_reparation'] = count($idReparasi[$i]);
				$newarr[$i]['total_machine'] = count($realArray[$i]);
				$newarr[$i]['sum'] = number_format(($newarr[$i]['total_duration'] / count($idReparasi[$i])/60),2);
				$newarr[$i]['tanggal_awal'] = $tgl_reparasi_awal;
				$newarr[$i]['tanggal_akhir'] = $tgl_reparasi_akhir;
				$i++;
			}
			// die;
			//echo "<pre>";print_r($newdata);die;
			
			$array_range = [];
			$no = 0;
			foreach ($newdata as $item) {
				$prev = 0;
				$prevTime = 0;
	
				$i = 0;
	
				foreach ($item as $key) {
					if($i == 0){
						$i++;
						$prevTime = $key['tgl_order'];
						continue;
					  }
	
					  $start_date = new DateTime($prevTime);
					  $end_date   = new DateTime($key['tgl_order']);
					  
					  $since_start = $start_date->diff($end_date);
	
					  $month   = $since_start->m * 30 * 24 * 60;
					  $days    = $since_start->d * 24 * 60;
					  $hours   = $since_start->h * 60;
					  $minutes = $since_start->m;
					  
					  //echo $key['tgl_order']."-".$days."-".$hours."-".$menit."<br>";
					  
					  $hasil = $month+$days+$hours+$minutes;
					  //echo $menit."<br>";				  
					  if($hasil != 0){
						$array_range[] = $hasil;
						// $array_range[$no][] = $hasil;
					  }
					  
					  $prevTime = $key['tgl_order'];
					  $prev =  $prev+($days+$hours+$minutes);
				}
				$no++;
			}
			// echo "<pre>";print_r($array_range);
	
			function count_all($a, $b){
				return $a = $a+$b;
			}
	
			$total_minutes = [];
			foreach($array_range as $key){
				// $total_minutes[] = array_reduce($key, 'count_all', '0');
				$total_minutes[] = $array_range;
			}
			// echo "<pre>";print_r($total_minutes);die;
	
			$j = 0;
			foreach($newarr as $key){
				// echo "<pre>";print_r($key);die;
				$jumlah_order = $key['total_machine'];
				if ($jumlah_order > 1) {
					$newarr[$j]['total_minutes'] = $array_range[$j];
					$newarr[$j]['end_result'] = number_format(($newarr[$j]['total_minutes']/$newarr[$j]['total_machine']/60),2);  //MTBR
				}else {
					$newarr[$j]['end_result'] = '-';
				}
				$j++;    
			}
			// die;
			$data['hasilRekapDataBySeksi'] = $newarr; 

		}else{
			$data['selectRekapReparasi'] = $this->M_agent->selectRekapReparasi($tgl_reparasi_awal,$tgl_reparasi_akhir); //by date range

		//-----------------------------------------RECAP BY DATE RANGE-----------------------------------//
		$newdata = [];
		foreach($data['selectRekapReparasi'] as $item){
			$newdata[$item['nama_mesin']][] = $item;
		}
		//echo "<pre>";print_r($newdata);

		$newarr = [];
		$realArray = [];
		$i = 0;

		foreach ($newdata as $item) {
			$prev = 0;
			$machine = $item[0]['nama_mesin'];
			$seksi = $item[0]['seksi'];
			$tgl_order = $item[0]['tgl_order'];

			foreach($item as $a){
				$realArray[$i][$a['no_order']] = $item;
			}

			foreach ($item as $b) {
				$idReparasi[$i][$b['id_reparasi']] = $item;
			}

			$newarr[$i]['machine_name'] = $machine;
			$newarr[$i]['section'] = $seksi;
			foreach ($item as $key) {
				$prev = $prev + $key['range'];

				$newarr[$i]['total_duration'] =  $prev;
			}

			$newarr[$i]['total_reparation'] = count($idReparasi[$i]);
			$newarr[$i]['total_machine'] = count($realArray[$i]);
			// $newarr[$i]['sum'] = number_format(($newarr[$i]['total_duration'] / count($realArray[$i])/60),2);
			$newarr[$i]['sum'] = number_format(($newarr[$i]['total_duration'] / count($idReparasi[$i])/60),2);
			$newarr[$i]['tanggal_awal'] = $tgl_reparasi_awal;
			$newarr[$i]['tanggal_akhir'] = $tgl_reparasi_akhir;
			// echo "<pre>";print_r($newarr[$i]['total_machine']);
			$i++;
		}
		// die;
		//echo "<pre>";print_r($newdata);die;
		
		$array_range = [];
		$no = 0;
		foreach ($newdata as $item) {
			$prev = 0;
			$prevTime = 0;

			$i = 0;

			foreach ($item as $key) {
				if($i == 0){
					$i++;
					$prevTime = $key['tgl_order'];
					continue;
				  }

				  $start_date = new DateTime($prevTime);
				  $end_date   = new DateTime($key['tgl_order']);
				  
				  $since_start = $start_date->diff($end_date);

				  $month   = $since_start->m * 30 * 24 * 60;
				  $days    = $since_start->d * 24 * 60;
				  $hours   = $since_start->h * 60;
				  $minutes = $since_start->m;
				  
				  //echo $key['tgl_order']."-".$days."-".$hours."-".$menit."<br>";
				  
				  $hasil = $month+$days+$hours+$minutes;
				  //echo $menit."<br>";				  
				  if($hasil != 0){
					$array_range[] = $hasil;
					// $array_range[$no][] = $hasil;
				  }
				  
				  $prevTime = $key['tgl_order'];
				  $prev =  $prev+($days+$hours+$minutes);
			}
			$no++;
		}
		// echo "<pre>";print_r($array_range);die;

		function count_all($a, $b){
			return $a = $a+$b;
		}

		$total_minutes = [];
		foreach($array_range as $key){
			// $total_minutes[] = array_reduce($key, 'count_all', '0');
			$total_minutes[] = $array_range;
		}
		// echo "<pre>";print_r($total_minutes);die;

		$j = 0;
		foreach($newarr as $key){
		// echo "<pre>";print_r($key);die;
			$jumlah_order = $key['total_machine'];
			if ($jumlah_order > 1) {
				$newarr[$j]['total_minutes'] = $array_range[$j];
				$newarr[$j]['end_result'] = number_format(($newarr[$j]['total_minutes']/$newarr[$j]['total_machine']/60),2);  //MTBR
			}else {
				$newarr[$j]['end_result'] = '-';
			}
			$j++;    
		}
		// die;
		$data['hasilRekapData'] = $newarr; 
		// echo "<pre>";print_r($data['hasilRekapData']);die;

		//-----------------------------------------RECAP BY DATE RANGE-----------------------------------//			

	}

	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
	$this->load->view('TicketingMaintenance/Agent/Rekap/V_DataRekap', $data);
	$this->load->view('V_Footer',$data);

}

}