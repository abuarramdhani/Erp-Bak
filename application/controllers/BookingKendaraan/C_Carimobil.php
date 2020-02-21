<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Carimobil extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('Log_Activity');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('BookingKendaraan/M_carimobil');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
    }

	public function checkSession()
	{
		if($this->session->is_logged){
		}else{
			redirect();
		}
	}

	//------------------------show the dashboard-----------------------------
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kendaraan = $this->M_carimobil->ambilKendaraan();

		foreach ($kendaraan as $key) {
			if ($key['usable'] == 1) {
				$ken_id = $key['idken'];

				$cek = $this->M_carimobil->cekIdinBooking($ken_id);
				if ($cek == 0) {
					$array = array(
								'kendaraan_id' => $ken_id,
							);
					$this->M_carimobil->autoInsertBooking($array);
				}
			}
		}
		$today = date('Y-m-d');
		$tidak = $this->M_carimobil->ambilMobilBookingTidak($today);
		$jum = count($tidak);
		$id_ken = "";
		for ($u=0; $u < $jum; $u++) {
			if ($u == 0) {
				if ($jum == 1) {
					$id_ken = "'".$tidak[$u]['kendaraan_id']."'";
				}else{
					$id_ken = "'".$tidak[$u]['kendaraan_id'];
				}

			}else{
				if ($u == $jum-1) {
					$id_ken = $id_ken."','".$tidak[$u]['kendaraan_id']."'";
				}else{
					$id_ken = $id_ken."','".$tidak[$u]['kendaraan_id'];
				}
			}
		}

		$data['mobil'] = $this->M_carimobil->ambilMobilBooking($id_ken);
		$p =$this->M_carimobil->selectNoind();
		$jml = count($p);
		$noind = "";
		for ($i=0; $i < $jml; $i++) {
			if ($i == 0) {
				if ($jml == 1) {
					$noind = "'".$p[$i]['id']."'";
				}else{
					$noind = "'".$p[$i]['id'];
				}
			}else{
				if ($i == $jml-1) {
					$noind = $noind."','".$p[$i]['id']."'";
				}else{
					$noind = $noind."','".$p[$i]['id'];
				}
			}
		};
		$data['pic'] = $this->M_carimobil->ambilPekerjaPIC($noind);
		// $data['noind'] = $this->M_carimobil->selectNoind();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BookingKendaraan/V_carimobil',$data);
		$this->load->view('V_Footer',$data);
	}

	public function isidata($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BookingKendaraan/V_isidata',$data);
		$this->load->view('V_Footer',$data);
	}

	public function simpanbooking()
	{
		$kendaraan_id = $this->input->post('kendaraan_id');
		$pengemudi = $this->input->post('pengemudi_mobil');
		$dari = $this->input->post('periode_booking1');
		$sampai = $this->input->post('periode_booking2');
		$tujuan = $this->input->post('tujuan_booking');
		$keperluan = $this->input->post('keperluan_booking');
		$pemohon = $this->input->post('pemohon_booking');

		$data = $this->M_carimobil->ambilMobilId($kendaraan_id);
		if ($data[0]['user_name'] == "") {
			$pic = NULL;
			$seksi = NULL;
			$voip = NULL;
		}else{
			$noind = "'".$data[0]['user_name']."'";
			$row = $this->M_carimobil->ambilPekerjaPIC($noind);
			$pic = $row[0]['nama'];
			$seksi = $row[0]['seksi'];
			$voip = $data[0]['voip_pic'];
		}

		if ($pemohon == "") {
			$pemohon = $pengemudi;
		}

		$tgl1 = date('Y-m-d',strtotime($dari));
		$tgl2 = date('Y-m-d',strtotime($sampai));

		$tanggal1 = new DateTime($tgl1);
		$tanggal2 = new DateTime($tgl2);

		$jml = $tanggal1->diff($tanggal2);
		$jml = $jml->days;
		$tanggal = $tgl1;
		for ($i=0; $i <= $jml; $i++) {
			$data_input = array(
							'kendaraan_id' => $kendaraan_id,
							'pengemudi' => $pengemudi,
							'dari' => $dari,
							'sampai' => $sampai,
							'tujuan' => $tujuan,
							'keperluan' => $keperluan,
							'pemohon' => $pemohon,
							'created_date' => date('Y-m-d H:i:s'),
							'creation_user' => $this->session->user,
							'pic_kendaraan' => $pic,
							'pic_seksi' => $seksi,
							'tanggal' => $tanggal,
							'pic_voip' => $voip,
						);
			$cek = $this->M_carimobil->cekNullorNot($kendaraan_id);
			if ($cek == 0) {
				$id  = $this->M_carimobil->simpanBooking($data_input);
			}elseif ($cek == 1){
				$this->M_carimobil->updateNullBooking($data_input,$kendaraan_id);
				$he = $this->M_carimobil->ambilIdBookingUpdated($kendaraan_id);
				$id = $he[0]['id'];
			}
			//insert to t_log
				$aksi = 'BOOKING KENDARAAN';
				$detail = 'BOOKING KENDARAAN ID='.$id.' PEMOHON='.$pemohon;
				$this->log_activity->activity_log($aksi, $detail);
			//
			$tanggal = date('Y-m-d', strtotime('+1 days', strtotime($tanggal)));

		}
		redirect('BookingKendaraan/CariMobil/konfirmasi'.'/'.$id);
	}

	public function konfirmasi($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$d = $this->M_carimobil->ambildataBookingId($id);
		$ken_id = $d[0]['kendaraan_id'];

		$data['kendaraan'] = $this->M_carimobil->ambilMobilId($ken_id);
		$p = $data['kendaraan'];
		if ($p[0]['user_name'] != "") {
			$noind = "'".$p[0]['user_name']."'";
			$data['pic'] = $this->M_carimobil->ambilPekerjaPIC($noind);
		}else{
			$data['pic'] = "";
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BookingKendaraan/V_konfirmasi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cariseksi()
	{
		$p = strtoupper($this->input->get('term'));
		$data = $this->M_carimobil->ambilSeksi($p);

		echo json_encode($data);

	}
	public function cariPIC()
	{
		$p = strtoupper($this->input->get('term'));
		$data = $this->M_carimobil->ambilPIC($p);

		echo json_encode($data);
	}
	public function dapatNama()
	{
		$p = $this->input->post('val');
		$data = $this->M_carimobil->ambilNama($p);

		echo json_encode($data);
	}
	public function getMobil()
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$kendaraan = $this->M_carimobil->ambilKendaraan();


		$day = $this->input->post('tgl_caribooking');
		$tidak = $this->M_carimobil->ambilMobilBookingTidak($day);
		$jum = count($tidak);
		$id_ken = "";
		for ($u=0; $u < $jum; $u++) {
			if ($u == 0) {
				if ($jum == 1) {
					$id_ken = "'".$tidak[$u]['kendaraan_id']."'";
				}else{
					$id_ken = "'".$tidak[$u]['kendaraan_id'];
				}

			}else{
				if ($u == $jum-1) {
					$id_ken = $id_ken."','".$tidak[$u]['kendaraan_id']."'";
				}else{
					$id_ken = $id_ken."','".$tidak[$u]['kendaraan_id'];
				}
			}
		}

		$data['mobil'] = $this->M_carimobil->ambilMobilBooking($id_ken);
		$p =$this->M_carimobil->selectNoind();
		$jml = count($p);
		$noind = "";
		for ($i=0; $i < $jml; $i++) {
			if ($i == 0) {
				if ($jml == 1) {
					$noind = "'".$p[$i]['id']."'";
				}else{
					$noind = "'".$p[$i]['id'];
				}
			}else{
				if ($i == $jml-1) {
					$noind = $noind."','".$p[$i]['id']."'";
				}else{
					$noind = $noind."','".$p[$i]['id'];
				}
			}
		};
		$data['pic'] = $this->M_carimobil->ambilPekerjaPIC($noind);
		// $data['noind'] = $this->M_carimobil->selectNoind();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BookingKendaraan/V_carimobil',$data);
		$this->load->view('V_Footer',$data);
	}
}
