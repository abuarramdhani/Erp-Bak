<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_NotifDL extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_notifdl');
		$this->load->model('CateringManagement/HitungPesanan/M_hitungpesanan');
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

		$data['Title']			=	'Notifikasi DL';
		$data['Menu'] 			= 	'Extra';
		$data['SubMenuOne'] 	= 	'Notifikasi DL';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_notifdl->getDLThisDay();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/NotifDL/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$data_awal = $this->M_notifdl->getDLThisDay();
		if (!empty($data_awal)) {
			foreach ($data_awal as $da) {
				$tanggal = $da['tanggal'];
				$lokasi = $da['lokasi'];
				$tempat_makan = $da['tempat_makan'];
				$noind = $da['noind'];
				$shift = '1';
				$kategori = '6';
				$terhitung = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempat_makan,$noind);
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
	                if (!empty($jumlah_pengurangan)) {
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
	                if (!empty($jumlah_pengurangan)) {
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
		}
		$data_akhir = $this->M_notifdl->getDLThisDay();
		echo json_encode($data_akhir);
	}

	public function getNotifikasiDinasLuar(){
		$data = $this->M_notifdl->getDLThisDayBelumDiProses();
		if (!empty($data)) {
			echo count($data);
		}else{
			echo 0;
		}
	}
} ?>