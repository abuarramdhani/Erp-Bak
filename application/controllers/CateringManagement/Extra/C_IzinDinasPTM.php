<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_IzinDinasPTM extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_izindinasptm');
		$this->load->model('CateringManagement/HitungPesanan/M_hitungpesanan');
		$this->load->model('CateringManagement/Pesanan/M_tambahan');
		$this->load->model('CateringManagement/Pesanan/M_pengurangan');
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

		$data['Title']			=	'Izin Dinas Pusat Tuksono Mlati';
		$data['Header']			=	'Izin Dinas Pusat Tuksono Mlati';
		$data['Menu'] 			= 	'Extra';
		$data['SubMenuOne'] 	= 	'Izin Dinas Pusat Tuksono Mlati';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_izindinasptm->getPekerjaDinasHariIni();
		$data['data_cant_proses'] = $this->M_izindinasptm->getPekerjaDinasHariIniTidakBisaDiproses();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/IzinDinasPTM/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$data_awal = $this->M_izindinasptm->getPekerjaDinasHariIni(true);
		
		if (!empty($data_awal)) {
			foreach ($data_awal as $da) {
				if ($da['diproses_tambah'] == 'Belum diproses' || $da['diproses_kurang'] == 'Belum diproses') {
					$shift = '1';
					$tanggal = $da['tanggal'];
					$kategori = $this->getKategori($da['jenis_dinas']);
					$tempat_makan = $da['tempat_makan'];
					$tempat_makan_tujuan = $da['tujuan'];
					$noind = $da['noind'];
	
					$this->insertTambahan($tanggal,$tempat_makan_tujuan,$noind,$kategori,$shift);
		            $this->insertPengurangan($tanggal,$tempat_makan,$noind,$kategori,$shift);

					$this->updatePesananPerTempatMakan($tanggal,$tempat_makan,$shift);
		            $this->updatePesananPerTempatMakan($tanggal,$tempat_makan_tujuan,$shift);
				}
			}
		}

		// exit();		
		$data_akhir = $this->M_izindinasptm->getPekerjaDinasHariIni();
		echo json_encode($data_akhir);
	}

	public function getUserCatering(){
		$noind = $this->session->user;
		$data = $this->M_izindinasptm->getUserCateringByNoind($noind);
		if (!empty($data)) {
			echo "ya";
		}else{
			echo "tidak";
		}
	}

	public function getNotifikasiIzinDinasPTM(){
		$data = $this->M_izindinasptm->getPekerjaDinasHariIniBelumTerproses();
		if (!empty($data)) {
			echo count($data);
		}else{
			echo 0;
		}
	}

	function getKategori($jenis_dinas){
		$kategori = "";
		if ($jenis_dinas == 'PUSAT') {
			$kategori = '3';
		}elseif ($jenis_dinas == 'TUKSONO') {
			$kategori = '4';
		}elseif ($jenis_dinas == 'MLATI') {
			$kategori = '5';
		}

		return $kategori;
	}

	function insertTambahan($tanggal,$tempat_makan,$noind,$kategori,$shift){
		$tambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori);
		if (empty($tambahan)) {
			$tambahan_insert = array(
				'fd_tanggal' => $tanggal, 
                'fs_tempat_makan' => $tempat_makan, 
                'fs_kd_shift' => $shift, 
                'fn_jumlah_pesanan' => 0, 
                'fb_kategori' => $kategori,  
			);
			$hasil_tambahan = $this->M_tambahan->insertTambahan($tambahan_insert);
			$tambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori);
		}

		$id_tambahan = $tambahan['0']['id_tambahan'];

		$tambahan_detail = $this->M_tambahan->getTambahanDetailByIdTambahanNoind($id_tambahan,$noind);
		if (empty($tambahan_detail)) {
			$this->M_tambahan->insertTambahanDetail($id_tambahan,$noind);
		}

		$this->M_tambahan->updateTambahanJumlahByIdTambahan($id_tambahan);
	}

	function insertPengurangan($tanggal,$tempat_makan,$noind,$kategori,$shift){
		$tempat_makan_ = $this->M_pengurangan->getLokasiTempatMakanByTempatMakan($tempat_makan);
		$terhitung = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasiTempatMakanNoind($tanggal,$tempat_makan_->fs_lokasi,$tempat_makan,$noind);
		if (!empty($terhitung)) {
			$pengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori);
			if (empty($pengurangan)) {
	            $pengurangan_insert = array(
	                'fd_tanggal' => $tanggal, 
	                'fs_tempat_makan' => $tempat_makan, 
	                'fs_kd_shift' => $shift, 
	                'fn_jml_tdkpesan' => 0, 
	                'fb_kategori' => $kategori,  
	            );
				$hasil_pengurangan = $this->M_pengurangan->insertPengurangan($pengurangan_insert);
				$pengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempat_makan,$kategori);
			}

			$id_pengurangan = $pengurangan['0']['id_pengurangan'];

			$pengurangan_detail = $this->M_pengurangan->getPenguranganDetailByIdPenguranganNoind($id_pengurangan,$noind);
			if (empty($pengurangan_detail)) {
				$this->M_pengurangan->insertPenguranganDetail($id_pengurangan,$noind);
			}

			$this->M_pengurangan->updatePenguranganJumlahByIdPengurangan($id_pengurangan);
		}
	}

	function updatePesananPerTempatMakan($tanggal,$tempat_makan,$shift){
		// update pesanan tempat makan tujuan
        $cekPesanan = $this->M_pengurangan->getPesananByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift);
        $tempat_makan_ = $this->M_pengurangan->getLokasiTempatMakanByTempatMakan($tempat_makan);
        if (!empty($cekPesanan)) { // sudah ada pesanan
            $total_tambahan = $this->M_pengurangan->getTotalTambahanByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift);
            $total_pengurangan = $this->M_pengurangan->getTotalPenguranganByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift);
            
            $jumlah_staff = $cekPesanan->fn_jumlah_staff;
            $jumlah_nonstaff = $cekPesanan->fn_jumlah_nonstaff;
            $jumlah_awal = $cekPesanan->fn_jumlah_staff + $cekPesanan->fn_jumlah_nonstaff;
            if (!empty($total_tambahan)) {
                $jumlah_tambahan = $total_tambahan->jumlah;
            }else{
                $jumlah_tambahan = 0;
            }
            if (!empty($total_pengurangan)) {
                $jumlah_pengurangan = $total_pengurangan->jumlah;
            }else{
                $jumlah_pengurangan = 0;
            }
            $jumlah_pesan = $jumlah_awal + $jumlah_tambahan - $jumlah_pengurangan;

            $update = array(
                'fn_jumlah_staff'     => $jumlah_staff,
                'fn_jumlah_nonstaff'  => $jumlah_nonstaff,
                'fn_jumlah'           => $jumlah_awal,
                'fn_jumlah_tambahan'    => $jumlah_tambahan,
                'fn_jumlah_pengurangan' => $jumlah_pengurangan,
                'fn_jumlah_pesan'     => $jumlah_pesan
            );

            $this->M_pengurangan->updatePesananByTempatMakanTanggalShift($update,$tempat_makan,$tanggal,$shift);
        }else{ //belum ada pesanan
            $total_tambahan = $this->M_pengurangan->getTotalTambahanByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift);
            $total_pengurangan = $this->M_pengurangan->getTotalPenguranganByTempatMakanTanggalShift($tempat_makan,$tanggal,$shift);
           
            if (!empty($total_tambahan)) {
                $jumlah_tambahan = $total_tambahan->jumlah;
            }else{
                $jumlah_tambahan = 0;
            }
            if (!empty($total_pengurangan)) {
                $jumlah_pengurangan = $total_pengurangan->jumlah;
            }else{
                $jumlah_pengurangan = 0;
            }
            $jumlah_pesan = $jumlah_tambahan - $jumlah_pengurangan;

            $insert = array(
                'fd_tanggal'          => $tanggal,
                'fs_tempat_makan'     => $tempat_makan,
                'fs_kd_shift'         => $shift,
                'fn_jumlah_staff'     => 0,
                'fn_jumlah_nonstaff'  => 0,
                'fn_jumlah'           => 0,
                'fn_jumlah_tambahan'    => $jumlah_tambahan,
                'fn_jumlah_pengurangan' => $jumlah_pengurangan,
                'fn_jumlah_pesan'     => $jumlah_pesan,
                'fs_tanda'            => '0',
                'lokasi'              => $tempat_makan_->fs_lokasi
            );

            $this->M_pengurangan->insertPesanan($insert);
        }
	}

	public function prosesDihitung(){
		$tanggal = $this->input->post('tanggal');
		$noind = $this->input->post('noind');
		$tempat_makan_asal = $this->input->post('asal');
		$tempat_makan_tujuan = $this->input->post('tujuan');
		$action = $this->input->post('action');
		$jenis_dinas = $this->input->post('jenis_dinas');
		$kategori = $this->getKategori($jenis_dinas);
		$shift = '1';

		if ($action=="dihitung") {
			$this->insertTambahan($tanggal,$tempat_makan_tujuan,$noind,$kategori,$shift);
            $this->insertPengurangan($tanggal,$tempat_makan_asal,$noind,$kategori,$shift);

			$this->M_izindinasptm->deleteTidakDihitung($noind,$tanggal,$noind,$tempat_makan_tujuan);
		}elseif ($action=="tidakdihitung") {
			$pengurangan = $this->M_izindinasptm->getPenguranganId($noind,$tanggal,$tempat_makan_asal,$shift);
			if (!empty($pengurangan)) {
				$this->M_izindinasptm->deletePenguranganDetailByIdPenguranganNoind($pengurangan->id_pengurangan,$noind);
				$this->M_pengurangan->updatePenguranganJumlahByIdPengurangan($pengurangan->id_pengurangan);
			}

			$tambahan = $this->M_izindinasptm->getTambahanId($noind,$tanggal,$tempat_makan_tujuan,$shift);
			if (!empty($tambahan)) {
				$this->M_izindinasptm->deleteTambahanDetailByIdTambahanNoind($tambahan->id_tambahan,$noind);
				$this->M_tambahan->updateTambahanJumlahByIdTambahan($tambahan->id_tambahan);
			}

			$data = array(
				'noind' => $noind,
				'tanggal' => $tanggal,
				'tempat_makan_tujuan' => $tempat_makan_tujuan,
				'created_by' => $this->session->user
			);

			$this->M_izindinasptm->insertTidakDihitung($data);
		}
		
		$this->updatePesananPerTempatMakan($tanggal,$tempat_makan_asal,$shift);
        $this->updatePesananPerTempatMakan($tanggal,$tempat_makan_tujuan,$shift);

		$data_akhir = $this->M_izindinasptm->getPekerjaDinasHariIni();
		echo json_encode($data_akhir);
	}

}
?>