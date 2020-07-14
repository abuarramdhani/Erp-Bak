<?php 
Defined('BASEPATH') or exit('No direct Script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Pengurangan extends CI_Controller
{
  
    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');

        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('form_validation');

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('CateringManagement/Pesanan/M_pengurangan');

        $this->checkSession();
    }

    public function checkSession(){
        if(!$this->session->is_logged){
            redirect('');
        }
    }

    public function index(){
        $user_id = $this->session->userid;

        $data['Title'] = 'Pengurangan Pesanan';
        $data['Menu'] = 'Pengurangan Pesanan';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['katering'] = $this->M_pengurangan->getKatering();
        $data['pengurangan'] = $this->M_pengurangan->getListPenguranganByTanggal(date('Y-m-d'));

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('CateringManagement/Pesanan/Pengurangan/V_index.php',$data);
        $this->load->view('V_Footer',$data);
    }

    public function searchActiveEmployees(){
        $key = $this->input->get('term');
        $data = $this->M_pengurangan->getActiveEmployeebyKey($key);
        echo json_encode($data);
    }

    public function getListPengurangan(){
        $tanggal = $this->input->get('tanggal');
        $data = $this->M_pengurangan->getListPenguranganByTanggal($tanggal);
        echo json_encode($data);
    }

    public function getPenguranganDetail(){
        $id_pengurangan = $this->input->get('id_pengurangan');

        $pengurangan = $this->M_pengurangan->getPenguranganByIdPengurangan($id_pengurangan);
        if (!empty($pengurangan)) {
            $pengurangan_detail = $this->M_pengurangan->getPenguranganDetailByIdPengurangan($pengurangan->id_pengurangan);
            if (!empty($pengurangan_detail)) {
                $data = array(
                    'status' => 'success',
                    'pengurangan' => $pengurangan,
                    'pengurangan_detail' => array(
                        'status' => 'success',
                        'pengurangan_detail' => $pengurangan_detail
                    )
                );  
            }else{
                $data = array(
                    'status' => 'success',
                    'pengurangan' => $pengurangan,
                    'pengurangan_detail' => array(
                        'status' => 'failed'
                    )
                );
            }
        }else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function simpan(){
        $tanggal = $this->input->post('txt-CM-Pengurangan-Tanggal-Baru');
        $tempat_makan = $this->input->post('slc-CM-Pengurangan-TempatMakan');
        $tempat_makan_baru = $this->input->post('slc-CM-Pengurangan-TempatMakanBaru');
        $shift = $this->input->post('slc-CM-Pengurangan-Shift');
        $kategori = $this->input->post('slc-CM-Pengurangan-Kategori');
        $penerima = $this->input->post('txt-CM-Pengurangan-Penerima-Noind');

        $id_pengurangan = $this->input->post('txt-CM-Tambahan-IdPengurangan');
        if (isset($id_pengurangan) && !empty($id_pengurangan)) {
            $pengurangan = $this->M_pengurangan->getPenguranganByIdPengurangan($id_pengurangan);
        }
        $data = array(
            'status' => 'gagal'
        );
        if (isset($pengurangan) && !empty($pengurangan)) { // edit

            $this->M_pengurangan->deletePenguranganDetailByIdPengurangan($id_pengurangan);
            if (!empty($penerima)) {
                foreach ($penerima as $pn) {
                    $cekPenguranganDetail = $this->M_pengurangan->getPenguranganDetailByIdPenguranganNoind($id_pengurangan, $pn);
                    if (empty($cekPenguranganDetail)) {
                        $this->M_pengurangan->insertPenguranganDetail($id_pengurangan,$pn);
                    }
                }
            }
            $this->M_pengurangan->updatePenguranganJumlahByIdPengurangan($id_pengurangan);

            $cekPesanan = $this->M_pengurangan->getPesananByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
            $tempat_makan_ = $this->M_pengurangan->getLokasiTempatMakanByTempatMakan($tempat_makan);
            if (!empty($cekPesanan)) { // sudah ada pesanan
                $total_tambahan = $this->M_pengurangan->getTotalTambahanByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                $total_pengurangan = $this->M_pengurangan->getTotalPenguranganByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                
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

                $this->M_pengurangan->updatePesananByTempatMakanTanggalShift($update,$pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
            }else{ //belum ada pesanan
                $total_tambahan = $this->M_pengurangan->getTotalTambahanByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                $total_pengurangan = $this->M_pengurangan->getTotalPenguranganByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
               
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
                    'fd_tanggal'          => $pengurangan->fd_tanggal,
                    'fs_tempat_makan'     => $pengurangan->fs_tempat_makan,
                    'fs_kd_shift'         => $pengurangan->fs_kd_shift,
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

            $data = array(
                'status' => 'sukses'
            );
        }else{ // input baru
            if (!empty($penerima)) {
                $jumlah = count($penerima);
            }else{
                $jumlah = 0;
            }

            $insert = array(
                'fd_tanggal' => $tanggal, 
                'fs_tempat_makan' => $tempat_makan, 
                'fs_kd_shift' => $shift, 
                'fn_jml_tdkpesan' => $jumlah, 
                'fb_kategori' => $kategori,  
            );
            $id_pengurangan = $this->M_pengurangan->insertPengurangan($insert);

            $this->M_pengurangan->deletePenguranganDetailByIdPengurangan($id_pengurangan);
            if (!empty($penerima)) {
                foreach ($penerima as $pn) {
                    $cekPenguranganDetail = $this->M_pengurangan->getPenguranganDetailByIdPenguranganNoind($id_pengurangan, $pn);
                    if (empty($cekPenguranganDetail)) {
                        $this->M_pengurangan->insertPenguranganDetail($id_pengurangan,$pn);
                    }
                }
            }
            $this->M_pengurangan->updatePenguranganJumlahByIdPengurangan($id_pengurangan);

            $pengurangan = $this->M_pengurangan->getPenguranganByIdPengurangan($id_pengurangan);

            $cekPesanan = $this->M_pengurangan->getPesananByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
            $tempat_makan_ = $this->M_pengurangan->getLokasiTempatMakanByTempatMakan($tempat_makan);
            if (!empty($cekPesanan)) { // sudah ada pesanan
                $total_tambahan = $this->M_pengurangan->getTotalTambahanByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                $total_pengurangan = $this->M_pengurangan->getTotalPenguranganByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                
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

                $this->M_pengurangan->updatePesananByTempatMakanTanggalShift($update,$pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
            }else{ //belum ada pesanan
                $total_tambahan = $this->M_pengurangan->getTotalTambahanByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                $total_pengurangan = $this->M_pengurangan->getTotalPenguranganByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
               
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
                    'fd_tanggal'          => $pengurangan->fd_tanggal,
                    'fs_tempat_makan'     => $pengurangan->fs_tempat_makan,
                    'fs_kd_shift'         => $pengurangan->fs_kd_shift,
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

            $data = array(
                'status' => 'sukses'
            );
        }
        echo json_encode($data);
    }

    public function hapus(){
        $id_pengurangan = $this->input->post('id_pengurangan');
        if (!empty($id_pengurangan)) {
            $pengurangan = $this->M_pengurangan->getPenguranganByIdPengurangan($id_pengurangan);
            if (!empty($pengurangan)) {
                $this->M_pengurangan->deletePenguranganByIdPengurangan($id_pengurangan);
                $this->M_pengurangan->deletePenguranganDetailByIdPengurangan($id_pengurangan);

                $total_tambahan = $this->M_pengurangan->getTotalTambahanByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                $total_pengurangan = $this->M_pengurangan->getTotalPenguranganByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                $cekPesanan = $this->M_pengurangan->getPesananByTempatMakanTanggalShift($pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                
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

                $this->M_pengurangan->updatePesananByTempatMakanTanggalShift($update,$pengurangan->fs_tempat_makan,$pengurangan->fd_tanggal,$pengurangan->fs_kd_shift);
                    
                $data = array(
                    'status' => 'sukses'
                );
            }else{
                $data = array(
                    'status' => 'gagal'
                );    
            }
        }else{
            $data = array(
                'status' => 'gagal'
            );
        }

        echo json_encode($data);
    }

    public function getPenerima(){
        $key = $this->input->get('term');
        $tempat_makan = $this->input->get('tempat_makan');
        $data = $this->M_pengurangan->getPenerimaByKeyTempatMakan($key,$tempat_makan);
        echo json_encode($data);
    }

    public function getTempatMakanBaru(){
        $key = $this->input->get('term');
        $tempat_makan = $this->input->get('tempat_makan');
        $kategori = $this->input->get('kategori');
        if ($kategori == "3") {
            $kategori = " and fs_perizinan_dinas = 1 ";
        }elseif ($kategori == "4") {
            $kategori = " and fs_perizinan_dinas = 2 ";
        }elseif ($kategori == "5") {
            $kategori = " and fs_perizinan_dinas = 3 ";
        }else{
            $kategori = " ";
        }
        $data = $this->M_pengurangan->getTempatMakanBaruByKeyTempatMakanKategori($key,$tempat_makan,$kategori);
        echo json_encode($data);
    }

}

?>