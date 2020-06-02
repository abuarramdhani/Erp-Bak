<?php 
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class C_Tambahan extends CI_Controller
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
        $this->load->model('CateringManagement/Pesanan/M_tambahan');
        
        $this->checkSession();
    }

    public function checkSession(){
        if(!$this->session->is_logged){
            redirect('index');
        }
    }

    public function index(){
        $user_id = $this->session->userid;

        $data['Title'] = 'Pesanan Tambahan';
        $data['Menu'] = 'Pesanan Tambahan';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $tanggal = date('Y-m-d');

        $data['katering'] = $this->M_tambahan->getKatering();
        $data['tambahan'] = $this->M_tambahan->getListTambahanByTanggal($tanggal);
        
        $data['status'] = $this->session->statusCMTambahan;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('CateringManagement/Pesanan/Tambahan/V_index.php',$data);
        $this->load->view('V_Footer',$data);
    }

    public function searchActiveEmployees(){
        $key = $this->input->get('term');
        $data = $this->M_tambahan->getActiveEmployeebyKey($key);
        echo json_encode($data);
    }

    public function getListTambahan(){
        $tanggal = $this->input->get('tanggal');
        $data = $this->M_tambahan->getListTambahanByTanggal($tanggal);
        echo json_encode($data);
    }

    public function getTambahanDetail(){
        $id_tambahan = $this->input->get('id_tambahan');
        $data = array();
        if (!empty($id_tambahan)) {
            $tambahan = $this->M_tambahan->getTambahanByIdTambahan($id_tambahan);
            if (!empty($tambahan)) {
                $tambahan_detail = $this->M_tambahan->getTambahanDetailByIdTambahan($id_tambahan);
                if (!empty($tambahan_detail)) {
                    $data = array(
                        'status' => 'success',
                        'tambahan' => $tambahan,
                        'tambahan_detail' => array(
                            'status' => 'success',
                            'tambahan_detail' => $tambahan_detail
                        )
                    );  
                }else{
                    $data = array(
                        'status' => 'success',
                        'tambahan' => $tambahan,
                        'tambahan_detail' => array(
                            'status' => 'failed'
                        )
                    );
                }
            }else{
                $data = array(
                    'status' => 'failed'
                );
            }   
        }

        echo json_encode($data);
    }

    public function getUrutan(){
        $tanggal = $this->input->get('tanggal');
        $tempat_makan = $this->input->get('tempat_makan');
        $shift = $this->input->get('shift');

        $urutan = $this->M_tambahan->getUrutanByTanggalTempatMakanShift($tanggal,$tempat_makan,$shift);

        if (!empty($urutan)) {
            $urt = $urutan->fs_tanda;
        }else{
            $urt = '0';
        }

        $data = array(
            'status' => 'success',
            'urutan' => $urt
        );
        
        echo json_encode($data);
    }

    public function simpan(){
        // echo "<pre>";print_r($_POST);
        $tanggal = $this->input->post('txt-CM-Tambahan-Tanggal-Baru');
        $tempat_makan = $this->input->post('slc-CM-Tambahan-TempatMakan');
        $shift = $this->input->post('slc-CM-Tambahan-Shift');
        $kategori = $this->input->post('slc-CM-Tambahan-Kategori');
        $urutan = $this->input->post('slc-CM-Tambahan-Urutan');
        $jumlah = $this->input->post('txt-CM-Tambahan-JumlahPesan');
        $keterangan = $this->input->post('txt-CM-Tambahan-Keterangan');
        $pemohon = $this->input->post('slc-CM-Tambahan-Pemohon');
        $penerima = $this->input->post('txt-CM-Tambahan-Penerima-Noind');

        $id_tambahan = $this->input->post('txt-CM-Tambahan-IdTambahan');
        if (isset($id_tambahan) && !empty($id_tambahan)) {
            $tambahan = $this->M_tambahan->getTambahanByIdTambahan($id_tambahan);
        }
        $data = array(
            'status' => 'gagal'
        );

        if (isset($tambahan) && !empty($tambahan)) { // edit
            $kategori = $tambahan->fb_kategori;
            $id_tambahan = $tambahan->id_tambahan;
            $kat_a = array('1', '2', '3', '4', '5'); // penerima
            $kat_b = array('6', '7'); // jumlah, pemohon, keterangan
            if (in_array($kategori, $kat_a) || in_array($kategori, $kat_b)) {
                if (in_array($kategori, $kat_a)) {
                    $this->M_tambahan->deleteTambahanDetailByIdTambahan($id_tambahan);
                    if (!empty($penerima)) {
                        foreach ($penerima as $pn) {
                            $cekTambahanDetail = $this->M_tambahan->getTambahanDetailByIdTambahanNoind($id_tambahan, $pn);
                            if (empty($cekTambahanDetail)) {
                                $this->M_tambahan->insertTambahanDetail($id_tambahan,$pn);
                            }
                        }
                    }
                    $this->M_tambahan->updateTambahanJumlahByIdTambahan($id_tambahan);
                }elseif (in_array($kategori, $kat_b)) {
                    $update = array(
                        'fn_jumlah_pesanan' => $jumlah,
                        'fs_pemohon' => $pemohon,
                        'fs_keterangan' => $keterangan
                    );
                    $this->M_tambahan->updateTambahanByIdTambahan($id_tambahan,$update);
                }
                
                $cekPesanan = $this->M_tambahan->getPesananByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                $tempat_makan_ = $this->M_tambahan->getLokasiTempatMakanByTempatMakan($tempat_makan);
                if (!empty($cekPesanan)) { // sudah ada pesanan
                    $total_tambahan = $this->M_tambahan->getTotalTambahanByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                    $total_pengurangan = $this->M_tambahan->getTotalPenguranganByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);

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

                    $this->M_tambahan->updatePesananByTempatMakanTanggalShift($update,$tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                }else{ //belum ada pesanan
                    $total_tambahan = $this->M_tambahan->getTotalTambahanByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                    $total_pengurangan = $this->M_tambahan->getTotalPenguranganByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);

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
                        'fd_tanggal'          => $tambahan->fd_tanggal,
                        'fs_tempat_makan'     => $tambahan->fs_tempat_makan,
                        'fs_kd_shift'         => $tambahan->fs_kd_shift,
                        'fn_jumlah_staff'     => 0,
                        'fn_jumlah_nonstaff'  => 0,
                        'fn_jumlah'           => 0,
                        'fn_jumlah_tambahan'    => $jumlah_tambahan,
                        'fn_jumlah_pengurangan' => $jumlah_pengurangan,
                        'fn_jumlah_pesan'     => $jumlah_pesan,
                        'fs_tanda'            => '0',
                        'lokasi'              => $tempat_makan_->fs_lokasi
                    );

                    $this->M_tambahan->insertPesanan($insert);
                }

               $data = array(
                    'status' => 'sukses'
                );
            }else{
                $data = array(
                    'status' => 'gagal'
                );
            }
        }else{ // input baru
            $kat_a = array('1', '2', '3', '4', '5'); // penerima
            $kat_b = array('6', '7'); // jumlah, pemohon, keterangan
            if (in_array($kategori, $kat_a) || in_array($kategori, $kat_b)) {
                if (in_array($kategori, $kat_a)) {
                    if (!empty($penerima)) {
                        $jumlah = count($penerima);
                    }else{
                        $jumlah = 0;
                    }

                    $insert = array(
                        'fd_tanggal' => $tanggal, 
                        'fs_tempat_makan' => $tempat_makan, 
                        'fs_kd_shift' => $shift, 
                        'fn_jumlah_pesanan' => $jumlah, 
                        'fb_kategori' => $kategori,  
                    );
                    $id_tambahan = $this->M_tambahan->insertTambahan($insert);

                    $this->M_tambahan->deleteTambahanDetailByIdTambahan($id_tambahan);
                    if (!empty($penerima)) {
                        foreach ($penerima as $pn) {
                            $cekTambahanDetail = $this->M_tambahan->getTambahanDetailByIdTambahanNoind($id_tambahan, $pn);
                            if (empty($cekTambahanDetail)) {
                                $this->M_tambahan->insertTambahanDetail($id_tambahan,$pn);
                            }
                        }
                    }
                    $this->M_tambahan->updateTambahanJumlahByIdTambahan($id_tambahan);
                }elseif (in_array($kategori, $kat_b)) {
                    $insert = array(
                        'fd_tanggal' => $tanggal, 
                        'fs_tempat_makan' => $tempat_makan, 
                        'fs_kd_shift' => $shift, 
                        'fn_jumlah_pesanan' => $jumlah, 
                        'fb_kategori' => $kategori, 
                        'fs_pemohon' => $pemohon,  
                        'fs_keterangan' => $keterangan
                    );
                    $id_tambahan = $this->M_tambahan->insertTambahan($insert);
                }

                $tambahan = $this->M_tambahan->getTambahanByIdTambahan($id_tambahan);
                $cekPesanan = $this->M_tambahan->getPesananByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                $tempat_makan_ = $this->M_tambahan->getLokasiTempatMakanByTempatMakan($tempat_makan);
                if (!empty($cekPesanan)) { // sudah ada pesanan
                    $total_tambahan = $this->M_tambahan->getTotalTambahanByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                    $total_pengurangan = $this->M_tambahan->getTotalPenguranganByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                    
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

                    $this->M_tambahan->updatePesananByTempatMakanTanggalShift($update,$tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                }else{ //belum ada pesanan
                    $total_tambahan = $this->M_tambahan->getTotalTambahanByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                    $total_pengurangan = $this->M_tambahan->getTotalPenguranganByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);

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
                        'fd_tanggal'          => $tambahan->fd_tanggal,
                        'fs_tempat_makan'     => $tambahan->fs_tempat_makan,
                        'fs_kd_shift'         => $tambahan->fs_kd_shift,
                        'fn_jumlah_staff'     => 0,
                        'fn_jumlah_nonstaff'  => 0,
                        'fn_jumlah'           => 0,
                        'fn_jumlah_tambahan'    => $jumlah_tambahan,
                        'fn_jumlah_pengurangan' => $jumlah_pengurangan,
                        'fn_jumlah_pesan'     => $jumlah_pesan,
                        'fs_tanda'            => '0',
                        'lokasi'              => $tempat_makan_->fs_lokasi
                    );

                    $this->M_tambahan->insertPesanan($insert);
                }
                $data = array(
                    'status' => 'sukses'
                );
            }else{
                $data = array(
                    'status' => 'gagal'
                );
            }
        }
        echo json_encode($data);
    }

    public function hapus(){
        $id_tambahan = $this->input->post('id_tambahan');
        if (!empty($id_tambahan)) {
            $tambahan = $this->M_tambahan->getTambahanByIdTambahan($id_tambahan);
            if (!empty($tambahan)) {
                $this->M_tambahan->deleteTambahanByIdTambahan($id_tambahan);
                $this->M_tambahan->deleteTambahanDetailByIdTambahan($id_tambahan);

                $total_tambahan = $this->M_tambahan->getTotalTambahanByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                $total_pengurangan = $this->M_tambahan->getTotalPenguranganByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                $cekPesanan = $this->M_tambahan->getPesananByTempatMakanTanggalShift($tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
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

                $this->M_tambahan->updatePesananByTempatMakanTanggalShift($update,$tambahan->fs_tempat_makan,$tambahan->fd_tanggal,$tambahan->fs_kd_shift);
                    
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

}
?>