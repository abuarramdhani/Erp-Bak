<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monhand extends CI_Controller
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
        $this->load->model('DbHandling/M_dbhandling');

        $this->checkSession();
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('index');
        }
    }

    public function index()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring Handling';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $filterbyseksi = $this->M_dbhandling->select_seksi();
        $filterbyproduk = $this->M_dbhandling->select_produk();
        $filterbysarana = $this->M_dbhandling->select_sarana();

        for ($i = 0; $i < sizeof($filterbysarana); $i++) {
            $datasarana = $this->M_dbhandling->selectdatatoedit($filterbysarana[$i]['id_master_handling']);
            if ($datasarana != null) {
                $filterbysarana[$i]['kode'] = $datasarana[0]['kode_handling'];
                $filterbysarana[$i]['nama'] = $datasarana[0]['nama_handling'];
            } else {
                $filterbysarana[$i]['kode'] = 'Invalid';
                $filterbysarana[$i]['nama'] = 'Invalid';
            }
        }

        $data['filterbyseksi'] = $filterbyseksi;
        $data['filterbyproduk'] = $filterbyproduk;
        $data['filterbysarana'] = $filterbysarana;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('DbHandling/TIM/V_MonHand', $data);
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function loadviewreqhand()
    {
        $handling = $this->M_dbhandling->getnewdatahandbystat();
        for ($i = 0; $i < sizeof($handling); $i++) {
            $sarana_handling = $this->M_dbhandling->selectdatatoedit($handling[$i]['id_master_handling']);
            if ($sarana_handling == null) {
                $handling[$i]['sarana'] = 'Invalid';
            } else {
                $handling[$i]['sarana'] = $sarana_handling[0]['nama_handling'];
            }
        }
        $data['handling'] = $handling;
        $this->load->view('DbHandling/TIM/V_TblReqHand', $data);
    }
    public function loadviewreqhand2()
    {
        $handling = $this->M_dbhandling->getrevdatahandbystat();
        for ($i = 0; $i < sizeof($handling); $i++) {
            $sarana_handling = $this->M_dbhandling->selectdatatoedit($handling[$i]['id_master_handling']);
            if ($sarana_handling == null) {
                $handling[$i]['sarana'] = 'Invalid';
            } else {
                $handling[$i]['sarana'] = $sarana_handling[0]['nama_handling'];
            }
        }
        $data['handling'] = $handling;
        $this->load->view('DbHandling/TIM/V_TblReqRevHand', $data);
    }
    public function loadviewdatahand()
    {

        $sarana = $this->input->post('sarana');
        $produk = $this->input->post('produk');
        $seksi = $this->input->post('seksi');

        if ($sarana != null) {
            $datahandling = $this->M_dbhandling->selectdatahandlingbysarana($sarana);
        } else if ($produk != null) {
            $datahandling = $this->M_dbhandling->selectdatahandlingbyprod($produk);
        } else if ($seksi != null) {
            $datahandling = $this->M_dbhandling->selectdatahandlingseksi($seksi);
        } else {
            $datahandling = $this->M_dbhandling->selectdatahandling();
        }

        for ($i = 0; $i < sizeof($datahandling); $i++) {
            $sarana_handling = $this->M_dbhandling->selectdatatoedit($datahandling[$i]['id_master_handling']);
            if ($sarana_handling == null) {
                $datahandling[$i]['sarana'] = 'Invalid';
            } else {
                $datahandling[$i]['sarana'] = $sarana_handling[0]['nama_handling'];
            }
        }

        $data['datahandling'] = $datahandling;
        $this->load->view('DbHandling/TIM/V_TblDataHand', $data);
    }
    public function tambahdatahandling()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Tambah Data Handling';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $id_seksi = ['UPPL', 'Sheet Metal', 'Machining', 'Perakitan', 'PnP', 'Gudang', 'Subkon'];

        $array_idseksi = array();
        for ($i = 0; $i < sizeof($id_seksi); $i++) {
            if ($id_seksi[$i] == 'UPPL') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ff00ff';
            } else if ($id_seksi[$i] == 'Sheet Metal') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#94bd5e';
            } else if ($id_seksi[$i] == 'Machining') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ffff00';
            } else if ($id_seksi[$i] == 'Perakitan') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#99ccff';
            } else if ($id_seksi[$i] == 'PnP') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ff8080';
            } else if ($id_seksi[$i] == 'Gudang') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#cccccc';
            } else if ($id_seksi[$i] == 'Subkon') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ffcc99';
            }
        }

        // echo "<pre>";
        // print_r($array_idseksi);
        // exit();
        $data['array_idseksi'] = $array_idseksi;


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('DbHandling/TIM/V_TambahDataHandling', $data);
        $this->load->view('V_Footer', $data);
    }
    function form()
    {

        $id    = $this->input->post('segment1');
        $master = $this->M_dbhandling->selectmasterseksi($id);

        // echo "<pre>";
        // print_r($master);
        // exit();

        echo '<option></option>';
        foreach ($master as $mast) {
            echo '<option value="' . $mast['seksi'] . '">' . $mast['seksi'] . '</option>';
        }
    }
    public function arrayidseksi()
    {
        $id_seksi = ['UPPL', 'Sheet Metal', 'Machining', 'Perakitan', 'PnP', 'Gudang', 'Subkon'];


        $array_idseksi = array();
        for ($i = 0; $i < sizeof($id_seksi); $i++) {
            if ($id_seksi[$i] == 'UPPL') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ff00ff';
            } else if ($id_seksi[$i] == 'Sheet Metal') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#94bd5e';
            } else if ($id_seksi[$i] == 'Machining') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ffff00';
            } else if ($id_seksi[$i] == 'Perakitan') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#99ccff';
            } else if ($id_seksi[$i] == 'PnP') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ff8080';
            } else if ($id_seksi[$i] == 'Gudang') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#cccccc';
            } else if ($id_seksi[$i] == 'Subkon') {
                $array_idseksi[$i]['id'] = $id_seksi[$i];
                $array_idseksi[$i]['warna'] = '#ffcc99';
            }
        }

        // echo "<pre>";
        // print_r($array_idseksi);
        // exit();
        $data = $array_idseksi;
        echo json_encode($data);
    }
    public function detaildatahandling($id)
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Detail Data Handling';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $datahandling = $this->M_dbhandling->selectdatahandlingbyid($id);
        $DataHandTbl = $this->M_dbhandling->selectdatahandlingbykom($datahandling[0]['kode_komponen']);
        $status_komp = $this->M_dbhandling->selectstatuskompbyid($datahandling[0]['id_status_komponen']);
        if ($status_komp == null) {
            $datahandling[0]['stat_komp'] = 'Invalid';
        } else {
            $datahandling[0]['stat_komp'] = $status_komp[0]['kode_status'] . ' - ' . $status_komp[0]['status'];
        }
        // $datahandling[0]['kode_stat_komp'] = $status_komp[0]['kode_status'];

        $sarana = $this->M_dbhandling->selectdatatoedit($datahandling[0]['id_master_handling']);
        if ($sarana == null) {
            $datahandling[0]['sarana'] = 'Invalid';
        } else {
            $datahandling[0]['sarana'] = $sarana[0]['kode_handling'] . ' - ' . $sarana[0]['nama_handling'];
        }


        if ($datahandling[0]['proses'] == 'Linear') {
            $prosess = $this->M_dbhandling->getProses($id);
            for ($v = 0; $v < sizeof($prosess); $v++) {
                $seksi = $this->M_dbhandling->selectdatatoedit2($prosess[$v]['id_proses_seksi']);

                $dataProses[$v]['urutan'] = $prosess[$v]['urutan'];
                $dataProses[$v]['id_proses_seksi'] = $prosess[$v]['id_proses_seksi'];
                if ($seksi != null) {
                    $dataProses[$v]['seksi'] = $seksi[0]['seksi'];

                    if ($seksi[0]['identitas_seksi'] == 'UPPL') {
                        $dataProses[$v]['warna'] = '#ff00ff';
                    } else if ($seksi[0]['identitas_seksi'] == 'Sheet Metal') {
                        $dataProses[$v]['warna'] = '#94bd5e';
                    } else if ($seksi[0]['identitas_seksi'] == 'Machining') {
                        $dataProses[$v]['warna'] = '#ffff00';
                    } else if ($seksi[0]['identitas_seksi'] == 'Perakitan') {
                        $dataProses[$v]['warna'] = '#99ccff';
                    } else if ($seksi[0]['identitas_seksi'] == 'PnP') {
                        $dataProses[$v]['warna'] = '#ff8080';
                    } else if ($seksi[0]['identitas_seksi'] == 'Gudang') {
                        $dataProses[$v]['warna'] = '#cccccc';
                    } else if ($seksi[0]['identitas_seksi'] == 'Subkon') {
                        $dataProses[$v]['warna'] = '#ffcc99';
                    }
                } else {
                    $dataProses[$v]['seksi'] = 'Invalid';
                    $dataProses[$v]['warna'] = 'white';
                }
            }

            $data['dataProses'] = $dataProses;
        }

        $image = $this->M_dbhandling->getGambar($id);

        // echo "<pre>";
        // print_r($dataProses);
        // exit;

        $data['datahandling'] = $datahandling;
        $data['DataHandTbl'] = $DataHandTbl;
        $data['image'] = $image;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('DbHandling/TIM/V_DetailDataHandling', $data);
        $this->load->view('V_Footer', $data);
    }
    public function detailreqhandling($id)
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Detail Request Handling';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('DbHandling/TIM/V_DetailReqHandling');
        $this->load->view('V_Footer', $data);
    }

    public function imgcarousel()
    {
        $id = $this->input->post('id');
        $proses = $this->input->post('proses');

        $gambar = $this->M_dbhandling->getGambar($id);
        // echo "<pre>";
        // print_r($proses);
        // exit();

        $b = 0;
        $divcontent = "";
        $li = "";
        if ($gambar != null) {
            $d = '';
            if ($proses == 'Linear') {

                foreach ($gambar as $img) {
                    if ($b == 0) {
                        $li .= '<li data-target="#imgcarousel" data-slide-to="' . $b . '" class="active"></li>';
                        $divcontent .=
                            '<div class="item active">
                            <center><p style="font-size : 12pt">Foto ' . $img['urutan'] . '</p></center>
                            <center><a href ="' . base_url('assets/upload/DatabaseHandling/fotolinier' . $img['id_handling'] . $img['urutan'] . '.png') . '" target="_blank"><img  style="max-width:700px;max-height:700px" src="' . base_url('assets/upload/DatabaseHandling/fotolinier' . $img['id_handling'] . $img['urutan'] . '.png') . '" ></a><br></center>
                        </div>';
                    } else {
                        $li .= '<li data-target="#imgcarousel" data-slide-to="' . $b . '"></li>';
                        $divcontent .=
                            '<div class="item">
                            <center><p style="font-size : 12pt">Foto ' . $img['urutan'] . '</p></center>
                            <center><a href ="' . base_url('assets/upload/DatabaseHandling/fotolinier' . $img['id_handling'] . $img['urutan'] . '.png') . '" target="_blank"><img  style="max-width:700px;max-height:700px" src="' . base_url('assets/upload/DatabaseHandling/fotolinier' . $img['id_handling'] . $img['urutan'] . '.png') . '"></a><br></center>
                        </div>';
                    }

                    $b++;
                }
            } else {
                foreach ($gambar as $img) {
                    if ($b == 0) {
                        $li .= '<li data-target="#imgcarousel" data-slide-to="' . $b . '" class="active"></li>';
                        $divcontent .=
                            '<div class="item active">
                            <center><p style="font-size : 12pt">Foto ' . $img['urutan'] . '</p></center>
                            <center><a href ="' . base_url('assets/upload/DatabaseHandling/fotononlinier' . $img['id_handling'] . $img['urutan'] . '.png') . '" target="_blank"><img  style="max-width:700px;max-height:700px" src="' . base_url('assets/upload/DatabaseHandling/fotononlinier' . $img['id_handling'] . $img['urutan'] . '.png') . '"></a><br></center>
                        </div>';
                    } else {
                        $li .= '<li data-target="#imgcarousel" data-slide-to="' . $b . '"></li>';
                        $divcontent .=
                            '<div class="item">
                            <center><p style="font-size : 12pt">Foto ' . $img['urutan'] . '</p></center>
                            <center><a href ="' . base_url('assets/upload/DatabaseHandling/fotononlinier' . $img['id_handling'] . $img['urutan'] . '.png') . '" target="_blank"><img  style="max-width:700px;max-height:700px" src="' . base_url('assets/upload/DatabaseHandling/fotononlinier' . $img['id_handling'] . $img['urutan'] . '.png') . '"></a><br></center>
                        </div>';
                    }

                    $b++;
                }
            }
        } else {
            $d = 'none';
            $divcontent = '<div style="height: 400px; margin-top:200px"><center><p style="font-weight:bold">Tidak Ada Foto</p></center></div>';
        }

        $carousel = '  
        <div id="imgcarousel" class="carousel slide" data-ride="carousel" style="height: 500px;" data-interval="false">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            ' . $li . '
          </ol>
      
          <!-- Wrapper for slides -->
          <div class="carousel-inner" style="height: 400px;">
                ' . $divcontent . '
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#imgcarousel" data-slide="prev">
                    <span style="color:gray" class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#imgcarousel" data-slide="next">
                    <span style="color:gray" class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
          </div>
          <center><span style="color:red;font-size:8pt;display:' . $d . '">*klik foto untuk melihat ukuran asli</span></center>
        </div>';

        echo $carousel;
    }
    public function proseshandling()
    {
        $id = $this->input->post('id');
        $proses = $this->input->post('proses');
        if ($proses == 'Linear') {
            $dataProses = $this->M_dbhandling->getProses($id);
            $div = "";
            for ($d = 0; $d < sizeof($dataProses); $d++) {
                $count = sizeof($dataProses);
                if ($count >= 1 &&  $count <= 3) {
                    $style_kotak = "width:40mm";
                    $style_arrow = "width:20mm";
                    $font = "12pt";
                } else if (3 < $count && $count <= 6) {
                    $style_kotak = "width:25mm";
                    $style_arrow = "width:15mm";
                    $font = "10pt";
                } else if (6 < $count && $count <= 9) {
                    $style_kotak = "width:20mm";
                    $style_arrow = "width:10mm";
                    $font = "9pt";
                } else {
                    $style_kotak = "width:17mm";
                    $style_arrow = "width:7mm";
                    $font = "8pt";
                }

                $Id_seksi = $this->M_dbhandling->selectdatatoedit2($dataProses[$d]['id_proses_seksi']);
                if ($Id_seksi != null) {
                    if ($Id_seksi[0]['identitas_seksi'] == 'Machining') {
                        $warna = '#ffff00';
                        $Id_seksi[0]['seksi'] = $Id_seksi[0]['seksi'];
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Gudang') {
                        $warna = '#cccccc';
                        $Id_seksi[0]['seksi'] = $Id_seksi[0]['seksi'];
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'PnP') {
                        $warna = '#ff8080';
                        $Id_seksi[0]['seksi'] = $Id_seksi[0]['seksi'];
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Sheet Metal') {
                        $warna = '#94bd5e';
                        $Id_seksi[0]['seksi'] = $Id_seksi[0]['seksi'];
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'UPPL') {
                        $warna = '#ff00ff';
                        $Id_seksi[0]['seksi'] = $Id_seksi[0]['seksi'];
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Perakitan') {
                        $warna = '#99ccff';
                        $Id_seksi[0]['seksi'] = $Id_seksi[0]['seksi'];
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Subkon') {
                        $warna = '#ffcc99';
                        $Id_seksi[0]['seksi'] = $Id_seksi[0]['seksi'];
                    }
                } else {
                    $warna = '#white';
                    $Id_seksi[0]['seksi'] = 'Invalid';
                }



                if ($d == 0) {
                    $div .= ' 
                <div style="display: inline-block;">
                    <div style="height:75px;text-align:center;padding: 20px 0;display:none"><i class="fa fa-arrow-right fa-2x"></i></div>
                </div>
                <div style="display: inline-block;">
                    <div style="background-color: ' . $warna . ';border: 1px solid black;text-align:center;padding: 20px 0;' . $style_kotak . '"><p style="margin:10px;font-size:' . $font . '">' . $Id_seksi[0]['seksi'] . '</p></div>
                </div>';
                } else {
                    $div .= ' 
                <div style="display: inline-block;">
                    <div style="height:75px;text-align:center;padding: 20px 0;' . $style_arrow . '"><i class="fa fa-arrow-right fa-2x"></i></div>
                </div>
                <div style="display: inline-block;">
                    <div style="background-color: ' . $warna . ';border: 1px solid black;text-align:center;padding: 20px 0;' . $style_kotak . '"><p style="margin:10px;font-size:' . $font . '">' . $Id_seksi[0]['seksi'] . '</p></div>
                </div>';
                }
            }
            $proses = '
            <div class="panel-body" style="height: 500px;">
               <div style="border:1px solid black;margin:20px;text-align:center;border-collapse:collapse;padding:20px">' . $div . '</div>
            </div>';
        } else {
            $proses = '
            <div class="panel-body" style="height: 500px;">
                <center><img  style="width:50%" src="' . base_url('assets/upload/DatabaseHandling/prosesnonlinier' . $id . '.png') . '"></center>
            </div>';
        }
        echo $proses;
    }

    public function PrintDataHandling($id)
    {
        $dataHandling = $this->M_dbhandling->selectdatahandlingbyid($id);
        $image = $this->M_dbhandling->getGambar($id);

        if ($dataHandling[0]['proses'] == 'Linear') {
            $prosesline = $this->M_dbhandling->getProses($id);

            for ($d = 0; $d < sizeof($prosesline); $d++) {

                $Id_seksi = $this->M_dbhandling->selectdatatoedit2($prosesline[$d]['id_proses_seksi']);

                if ($Id_seksi != null) {
                    if ($Id_seksi[0]['identitas_seksi'] == 'Machining') {
                        $array_proses[$d]['seksi'] = $Id_seksi[0]['seksi'];
                        $array_proses[$d]['warna'] = '#ffff00';
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Gudang') {
                        $array_proses[$d]['seksi'] = $Id_seksi[0]['seksi'];
                        $array_proses[$d]['warna'] = '#cccccc';
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'PnP') {
                        $array_proses[$d]['seksi'] = $Id_seksi[0]['seksi'];
                        $array_proses[$d]['warna'] = '#ff8080';
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Sheet Metal') {
                        $array_proses[$d]['seksi'] = $Id_seksi[0]['seksi'];
                        $array_proses[$d]['warna'] = '#94bd5e';
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'UPPL') {
                        $array_proses[$d]['seksi'] = $Id_seksi[0]['seksi'];
                        $array_proses[$d]['warna'] = '#ff00ff';
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Perakitan') {
                        $array_proses[$d]['seksi'] = $Id_seksi[0]['seksi'];
                        $array_proses[$d]['warna'] = '#99ccff';
                    } else if ($Id_seksi[0]['identitas_seksi'] == 'Subkon') {
                        $array_proses[$d]['seksi'] = $Id_seksi[0]['seksi'];
                        $array_proses[$d]['warna'] = '#99ccff';
                    }
                } else {
                    $array_proses[$d]['seksi'] = 'Invalid';
                    $array_proses[$d]['warna'] = 'white';
                }
            }
            $data['array_proses'] = $array_proses;
        }

        $sarana_handling = $this->M_dbhandling->selectdatatoedit($dataHandling[0]['id_master_handling']);
        if ($sarana_handling != null) {
            $dataHandling[0]['sarana'] = $sarana_handling[0]['nama_handling'];
        } else {
            $dataHandling[0]['sarana'] = 'Invalid';
        };

        // echo "<pre>";
        // print_r($dataHandling);
        // exit();

        ob_start();

        $data['dataHandling'] = $dataHandling;
        $data['image'] = $image;


        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 297), 0, '', 3, 3, 76, 50, 3, 3); //----- A5-L
        $filename = 'CobaPrintHandling.pdf';
        $html = $this->load->view('DbHandling/TIM/V_PdfHandling', $data, true);        //-----> Fungsi Cetak PDF
        $foot = $this->load->view('DbHandling/TIM/V_PdfHandlingFooter', $data, true);        //-----> Fungsi Cetak PDF
        $head = $this->load->view('DbHandling/TIM/V_PdfHandlingHeader', $data, true);
        $footer = $this->load->view('DbHandling/TIM/V_PdfHandlingFooter2', $data, true);
        ob_end_clean();
        // $pdf->shrink_tables_to_fit = 1;
        // $pdf->charset_in = 'iso-8859-4';
        $pdf->SetHTMLHeader($head);
        $pdf->SetHTMLFooter($footer);                                                //-----> Pakai Library MPDF
        $pdf->WriteHTML($html);
        $pdf->SetHTMLFooter($foot);                                               //-----> Pakai Library MPDF
        $pdf->Output($filename, 'I');
    }
    public function suggestproduk()
    {
        $term = $this->input->get('term', TRUE);
        // $term = strtoupper($term);
        $data = $this->M_dbhandling->selectproduk($term);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function suggestsarana()
    {
        $term = $this->input->get('term', TRUE);
        // $term = strtoupper($term);
        $data = $this->M_dbhandling->selectsarana($term);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function statuskomp()
    {
        $term = $this->input->get('term', TRUE);
        // $term = strtoupper($term);
        $data = $this->M_dbhandling->selectstatuskompp($term);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function kodekomp()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        $data = $this->M_dbhandling->kodekomp($term);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function getDesckompp()
    {
        $kode = $this->input->post('kode');
        $desc = $this->M_dbhandling->desckomp($kode);
        echo json_encode($desc[0]['DESCRIPTION']);
    }
    public function cekKodeKomp()
    {
        $kode = $this->input->post('kode');
        $cek = $this->M_dbhandling->cekKode($kode);
        if ($cek == null) {
            echo json_encode("0");
        } else {
            for ($d = 0; $d < sizeof($cek); $d++) {
                $rev[$d] = $cek[$d]['rev_no'];
            }
            rsort($rev);
            $dataEdit = $this->M_dbhandling->dataEdit($kode, $rev[0]);
            echo json_encode($dataEdit[0]['id_handling']);
        }
    }
    public function adddatahandling()
    {
        date_default_timezone_set('Asia/Jakarta');
        $lastupdate_by = $this->session->user;
        $lastupdate_date = date("Y-m-d H:i:s");
        $kode = $this->input->post('kodekompp');
        $desc = $this->input->post('namakomp');
        $status_komp = $this->input->post('status_komp');
        $status_kompp = $this->M_dbhandling->selectstatuskompbyid($status_komp);
        $produk = $this->input->post('produkk');
        $sarana = $this->input->post('saranahand');
        $sar = $this->M_dbhandling->selectdatatoedit($sarana);
        $qty = $this->input->post('qtyhand');
        $berat = $this->input->post('weighthand');
        $seksi = $this->input->post('seksihand');
        $proses = $this->input->post('prosesss');
        $urutan_proses = $this->input->post('nomorproses[]');
        $proses_seksi = $this->input->post('prosesseksi[]');
        $keterangan = $this->input->post('kethand');
        $explode = explode("-", $produk);
        $kode_produk = $explode[0];
        $nama_produk = $explode[1];
        $docdigit4 = substr($kode, 3, 6);
        $split = str_split($docdigit4);

        // echo "<pre>";
        // print_r($status_komp);
        // exit();


        if ($split[5] == '-') {
            $doc_no = 'SH-' . $sar[0]['kode_handling'] . '-' . $kode_produk . '-' . substr($docdigit4, 0, 5) . '-' . $status_kompp[0]['kode_status'];
        } else {
            $doc_no = 'SH-' . $sar[0]['kode_handling'] . '-' . $kode_produk . '-' . $docdigit4 . '-' . $status_kompp[0]['kode_status'];
        }


        $this->M_dbhandling->insertdatahandling($lastupdate_date, $lastupdate_by, $doc_no, $kode, $desc, $status_komp, $kode_produk, $nama_produk, $sarana, $qty, $berat, $seksi, $proses, $keterangan);
        $lastval = $this->M_dbhandling->getIdHandling();



        $id = $lastval[0]['lastval'];

        $urutangambarproseslinear = $this->input->post('fotoproseslinear[]');
        $gambarproseslinear = $this->input->post('gambarproses[]');
        $prosesnonlinear = $this->input->post('prosesnonlinear[]');
        $urutangambarprosesnonlinear = $this->input->post('fotoprosesnonlinear[]');
        $gambarprosesnonlinear = $this->input->post('gambarprosesnonlinear[]');

        if ($proses == 'Linear') {
            for ($i = 0; $i < sizeof($urutan_proses); $i++) {
                $id_proses_seksi =  $this->M_dbhandling->cariidproseseksi($proses_seksi[$i]);
                $this->M_dbhandling->insertproseshandling($id, $urutan_proses[$i], $id_proses_seksi[0]['id_proses_seksi']);
            }

            // if (!is_dir('./assets/upload/DatabaseHandling')) {
            //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
            chmod('./assets/upload/DatabaseHandling', 0777);
            // }

            for ($a = 0; $a < sizeof($urutangambarproseslinear); $a++) {
                $this->M_dbhandling->insertgambar($id, $urutangambarproseslinear[$a]);

                $filename = "assets/upload/DatabaseHandling/fotolinier" . $id . $urutangambarproseslinear[$a] . '.png';
                $temp_name = $_FILES['gambarproses']['tmp_name'][$a];
                // Check if file already exists
                if (file_exists($filename)) {
                    move_uploaded_file($temp_name, $filename);
                } else {
                    move_uploaded_file($temp_name, $filename);
                }
            }
        } else if ($proses == 'Non Linear') {

            // if (!is_dir('./assets/upload/DatabaseHandling')) {
            //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
            chmod('./assets/upload/DatabaseHandling', 0777);
            // }

            $filename = "assets/upload/DatabaseHandling/prosesnonlinier" . $id . '.png';
            $temp_name = $_FILES['prosesnonlinear']['tmp_name'][0];
            // Check if file already exists
            if (file_exists($filename)) {
                move_uploaded_file($temp_name, $filename);
            } else {
                move_uploaded_file($temp_name, $filename);
            }

            for ($a = 0; $a < sizeof($urutangambarprosesnonlinear); $a++) {
                $this->M_dbhandling->insertgambar($id, $urutangambarprosesnonlinear[$a]);

                $filename = "assets/upload/DatabaseHandling/fotononlinier" . $id . $urutangambarprosesnonlinear[$a] . '.png';
                $temp_name = $_FILES['gambarprosesnonlinear']['tmp_name'][$a];
                // Check if file already exists
                if (file_exists($filename)) {
                    move_uploaded_file($temp_name, $filename);
                } else {
                    move_uploaded_file($temp_name, $filename);
                }
            }
        }
        redirect(base_url('DbHandling/MonitoringHandling'));
    }
    public function revHand()
    {
        $id = $this->input->post('id');
        $dataHandrev = $this->M_dbhandling->selectdatahandlingbyid($id);
        $stats_kmp = $this->M_dbhandling->selectstatuskompbyid($dataHandrev[0]['id_status_komponen']);

        // echo "<pre>";
        // print_r($stats_kmp);
        // exit();

        $ListSeksi = $this->M_dbhandling->listSeksirev($dataHandrev[0]['seksi']);

        $optseksi = '';
        for ($i = 0; $i < sizeof($ListSeksi); $i++) {
            $optseksi .= '<option value ="' . $ListSeksi[$i]['seksi'] . '">' . $ListSeksi[$i]['seksi'] . '</option>';
        }
        $stats_kmp_All = $this->M_dbhandling->selectstatuskomp();
        if ($stats_kmp == null) {
            $dataHandrev[0]['status_komp'] = 'Invalid';
        } else {
            $dataHandrev[0]['status_komp'] = $stats_kmp[0]['kode_status'] . ' - ' . $stats_kmp[0]['status'];
        }
        // $dataHandrev[0]['status_komp_kode'] = $stats_kmp[0]['kode_status'];
        $id_seksi = ['UPPL', 'Sheet Metal', 'Machining', 'Perakitan', 'PnP', 'Gudang', 'Subkon'];
        $sar_This = $this->M_dbhandling->selectdatatoedit($dataHandrev[0]['id_master_handling']);
        if ($sar_This == null) {
            $dataHandrev[0]['sarana_name'] = 'Invalid';
            $dataHandrev[0]['sarana_kode'] = '';
        } else {
            $dataHandrev[0]['sarana_name'] = $sar_This[0]['nama_handling'];
            $dataHandrev[0]['sarana_kode'] = $sar_This[0]['kode_handling'];
        }
        $sar_All = $this->M_dbhandling->selectmasterhandling();

        $opti = '';
        for ($f = 0; $f < sizeof($sar_All); $f++) {
            if ($sar_All[$f]['id_master_handling'] != $dataHandrev[0]['id_master_handling']) {
                $opti .= '<option value="' . $sar_All[$f]['id_master_handling'] . '">' . $sar_All[$f]['nama_handling'] . '</option>';
            }
        }
        $Saranaa =
            '<div class="panel-body">
                <div class="col-md-3" style="text-align:right"><label>Sarana</label></div>
                <div class="col-md-8"> 
                    <select class="form-control select2 SarAna" name="SarAna" style="width:100%">
                        <option value="' . $dataHandrev[0]['id_master_handling'] . '">' . $dataHandrev[0]['sarana_name'] . '</option>
                        ' . $opti . '
                    </select>
                </div>
            </div>';
        $opt = '';
        for ($d = 0; $d < sizeof($stats_kmp_All); $d++) {
            if ($stats_kmp_All[$d]['id_status_komponen'] != $dataHandrev[0]['id_status_komponen']) {
                $opt .= '<option value="' . $stats_kmp_All[$d]['id_status_komponen'] . '">' . $stats_kmp_All[$d]['kode_status'] . ' - ' . $stats_kmp_All[$d]['status'] . '</option>';
            }
        }
        $StatKomp =
            '<div class="panel-body">
                <div class="col-md-3" style="text-align:right"><label>Status Komponen</label></div>
                <div class="col-md-8"> 
                    <select class="form-control select2 StatKomp" name="statKomp" style="width:100%">
                        <option value="' . $dataHandrev[0]['id_status_komponen'] . '">' . $dataHandrev[0]['status_komp'] . '</option>
                        ' . $opt . '
                    </select>
                </div>
            </div>';
        $pi = '';
        if ($dataHandrev[0]['proses'] == 'Linear') {
            $pi = '<option value="Non Linear">Non Linear</option>';
        } else {
            $pi = '<option value="Linear">Linear</option>';
        }
        $selectProses = '
        <div class="panel-body">
            <input type="hidden" value="' . $dataHandrev[0]['proses'] .  '" id="pronih"/>
            <div class="col-md-3" style="text-align:right;"><label>Proses</label></div>
            <div class="col-md-8">
                <select class="form-control select2 Pros_Es" name="Pros_Es" onchange="prosesonchange()" style="width:100%">
                    <option value="' . $dataHandrev[0]['proses'] . '">' . $dataHandrev[0]['proses'] .  '</option>
                    ' . $pi . '
                </select>
            </div>
        </div>';

        $alur_proses = '';
        $btntambah = '';
        $previewPros = '';
        $preview = '';
        $optionNewLinear = '';
        $prosesAll = $this->M_dbhandling->selectmasterprosesseksi();
        for ($d = 0; $d < sizeof($prosesAll); $d++) {
            $optionNewLinear .= '<option value="' . $prosesAll[$d]['identitas_seksi'] . '">' . $prosesAll[$d]['identitas_seksi'] . '</option>';
        }
        if ($dataHandrev[0]['proses'] == 'Linear') {
            $HandProRev = $this->M_dbhandling->getProses($dataHandrev[0]['id_handling']);
            $count = sizeof($HandProRev);
            if ($count >= 1 &&  $count <= 3) {
                $style_kotak = "width:40mm";
                $style_arrow = "width:20mm";
                $font = "12pt";
            } else if (3 < $count && $count <= 6) {
                $style_kotak = "width:25mm";
                $style_arrow = "width:15mm";
                $font = "10pt";
            } else if (6 < $count && $count <= 9) {
                $style_kotak = "width:20mm";
                $style_arrow = "width:10mm";
                $font = "9pt";
            } else {
                $style_kotak = "width:17mm";
                $style_arrow = "width:7mm";
                $font = "8pt";
            }
            for ($i = 0; $i < sizeof($HandProRev); $i++) {
                $proses = $this->M_dbhandling->selectdatatoedit2($HandProRev[$i]['id_proses_seksi']);
                if ($proses != null) {
                    $HandProRev[$i]['seksi'] = $proses[0]['seksi'];
                    $HandProRev[$i]['identitas_seksi'] = $proses[0]['identitas_seksi'];
                    if ($HandProRev[$i]['identitas_seksi'] == "Machining") {
                        $color = "#ffff00";
                    } else if ($HandProRev[$i]['identitas_seksi'] == "Gudang") {
                        $color = "#cccccc";
                    } else if ($HandProRev[$i]['identitas_seksi'] == "PnP") {
                        $color = "#ff8080";
                    } else if ($HandProRev[$i]['identitas_seksi'] == "Sheet Metal") {;
                        $color = "#94bd5e";
                    } else if ($HandProRev[$i]['identitas_seksi'] == "UPPL") {
                        $color = "#ff00ff";
                    } else if ($HandProRev[$i]['identitas_seksi'] == "Perakitan") {
                        $color = "#99ccff";
                    } else if ($HandProRev[$i]['identitas_seksi'] == "Subkon") {
                        $color = "#ffcc99";
                    }
                } else {
                    $HandProRev[$i]['seksi'] = 'Invalid';
                    $HandProRev[$i]['identitas_seksi'] = 'Invalid';
                    $color = "white";
                }

                $op = '';
                for ($d = 0; $d < sizeof($prosesAll); $d++) {
                    if ($prosesAll[$d]['id_proses_seksi'] != $HandProRev[$i]['id_proses_seksi']) {
                        $op .= '<option value="' . $prosesAll[$d]['id_proses_seksi'] . '">' . $prosesAll[$d]['seksi'] . '</option>';
                    }
                }
                $opt = '';
                for ($b = 0; $b < sizeof($id_seksi); $b++) {
                    if ($id_seksi[$b] != $HandProRev[$i]['identitas_seksi']) {
                        $opt .= '<option value="' . $id_seksi[$b] . '">' . $id_seksi[$b] . '</option>';
                    }
                }
                $alur_proses .= '
                    <div class="panel-body haha' . $i . '">
                        <input type="hidden" name="indexproses[]" value="' . $i . '"/>
                        <div class="col-md-3" style="text-align:right;color:white"><label>Proses</label></div>
                        <div class="col-md-1"><input class="form-control" name="urutPros[]" value="' . $HandProRev[$i]['urutan'] . '" readonly="readonly" type="text"/></div>
                        <div class="col-md-3"> 
                            <select style="width:100%" class="form-control select2 idSek_si" id="Id_Sek_Si' . $i . '" onchange="getwarnaid(' . $i . ')">
                                <option value="' . $HandProRev[$i]['identitas_seksi'] . '">' . $HandProRev[$i]['identitas_seksi'] . '</option>
                                ' . $opt . '
                            </select>
                        </div>
                        <div class="col-md-1" id="warna_Id_Seksi' . $i . '" style="background-color: ' . $color . ';color:' . $color . ';font-size:16pt;padding:2px;">A</div>
                        <div class="col-md-3"> 
                            <select onchange="tuliskan(' . $i . ')" style="width:100%" class="form-control select2 Pro_sesSeksi" name="ProSesSeksi[]" id="Pros_Seksi' . $i . '">
                                <option value="' . $HandProRev[$i]['seksi'] . '">' . $HandProRev[$i]['seksi'] . '</option>
                                ' . $op . '
                            </select>
                        </div>
                        <div class="col-md-1"><a onclick="deleteproses(' . $i . ')" class="btn btn-danger"><i class="fa fa-minus"></i></a></div>
                    </div>';
                if ($i == 0) {
                    $preview .= '
                            <div style="display: inline-block;">
                                <div id="arrowprosSes' . $i . '" style="display:none;height:75px; margin:10px;text-align:center;padding: 10px 0;"><i class="fa fa-arrow-right"></i></div>
                            </div>
                            <div style="display: inline-block;">
                                <div class="kotakan" id="Kotakk' . $i . '" style="border: 1px solid black;text-align:center;padding: 10px 0;background-color: ' . $color . ';' . $style_kotak . '">
                                    <p class="ketPrev" style="margin:10px;font-size:' . $font . '" id="tulisanKotakk' . $i . '">' . $HandProRev[$i]['seksi'] . '</p>
                                </div>
                            </div>';
                } else {
                    $preview .= '
                            <div style="display: inline-block;">
                                <div class="arahpenunjuk" id="arrowprosSes' . $i . '" style="height:75px;text-align:center;padding: 10px 0;' . $style_arrow . '"><i class="fa fa-arrow-right"></i></div>
                            </div>
                            <div style="display: inline-block;">
                                <div class="kotakan" id="Kotakk' . $i . '" style="border: 1px solid black;text-align:center;padding: 10px 0;background-color: ' . $color . ';' . $style_kotak . '">
                                    <p class="ketPrev" style="margin:10px;font-size:' . $font . '" id="tulisanKotakk' . $i . '">' . $HandProRev[$i]['seksi'] . '</p>
                                </div>
                            </div>';
                }
            }
            $btntambah = '
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;color:white"><label>A</label></div>
                <div class="col-md-8" style="text-align:right;"><a onclick="addprosess()" class="btn btn-success">Add Proses</a></div>
            </div>';
            $previewPros .= '
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;">      
                <label> Preview Proses : </label>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-12" style="border: 1px solid black; border-collapse: collapse;padding-top:15px;text-align:center" id="preview_ProsSes">      
                ' . $preview . '
                </div>
            </div>';
        } else {
            $alur_proses .= ' 
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;color:white"><label>Proses</label></div>
                <div class="col-md-8"><input type="file" name="pros_non_linier" id="pros_non_linier" onchange="previewimagenonlinier(this)" class="form-control" accept=".jpg, .png, ,jpeg"/></div>
            </div>
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                <div class="col-md-8"><center><img id="imgnonlinier" style="width:50%" src="' . base_url('assets/upload/DatabaseHandling/prosesnonlinier' . $dataHandrev[0]['id_handling'] . '.png') . '"><img id="previewimgchange" style="width:50%;display:none"></center></div>
            </div>';
            $btntambah = '';
        }
        $gambwarr = '';
        $gambar = $this->M_dbhandling->getGambar($dataHandrev[0]['id_handling']);
        for ($g = 0; $g < sizeof($gambar); $g++) {
            if ($dataHandrev[0]['proses'] == 'Linear') {
                if ($g == 0) {
                    $gambwarr .= '
                    <div id="has' . $g . '">
                        <div class="panel-body">
                            <input type="hidden" name="indexGambr[]" value="' . $g . '"/>
                            <div class="col-md-3" style="text-align:right"><label>Foto</label></div>
                            <div class="col-md-1"><input class="form-control" name ="uRutGambar[]" value="' . $gambar[$g]['urutan'] . '" readonly="readonly" type="text"/></div>
                            <div class="col-md-6"><input type="file" id="fotoHandling' . $g . '" name="fotoHandling[]" onchange="PrevImg(this,' . $g . ')" class="form-control" accept=".jpg, .png, ,jpeg"/><span style="font-size:9pt;color:red">*Pilih File untuk mengganti foto</span></div>
                            <div class="col-md-1"><a class="btn btn-danger" onclick="deletpoto(' . $g . ')"><i class="fa fa-minus"></i></a></div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                            <div class="col-md-8"><center><img id="showPrevImg' . $g . '" style="width:50%;display:none"><img id="hideifprev' . $g . '"  style="width:50%" src="' . base_url('assets/upload/DatabaseHandling/fotolinier' . $gambar[$g]['id_handling'] . $gambar[$g]['urutan'] . '.png') . '"></center></div>
                        </div>
                    </div>';
                } else {
                    $gambwarr .= '
                    <div id="has' . $g . '">
                        <div class="panel-body">
                            <input type="hidden" name="indexGambr[]" value="' . $g . '"/>
                            <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                            <div class="col-md-1"><input class="form-control" name ="uRutGambar[]" value="' . $gambar[$g]['urutan'] . '" readonly="readonly" type="text"/></div>
                            <div class="col-md-6"><input type="file" id="fotoHandling' . $g . '" name="fotoHandling[]" onchange="PrevImg(this,' . $g . ')" class="form-control" accept=".jpg, .png, ,jpeg"/><span style="font-size:9pt;color:red">*Pilih File untuk mengganti foto</span></div>
                            <div class="col-md-1"><a class="btn btn-danger" onclick="deletpoto(' . $g . ')"><i class="fa fa-minus"></i></a></div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                            <div class="col-md-8"><center><img id="showPrevImg' . $g . '" style="width:50%;display:none"><img id="hideifprev' . $g . '"  style="width:50%" src="' . base_url('assets/upload/DatabaseHandling/fotolinier' . $gambar[$g]['id_handling'] . $gambar[$g]['urutan'] . '.png') . '"></center></div>
                        </div>
                    </div>';
                }
            } else {
                if ($g == 0) {
                    $gambwarr .= '
                    <div id="has' . $g . '">
                        <div class="panel-body">
                            <input type="hidden" name="indexGambr[]" value="' . $g . '"/>
                            <div class="col-md-3" style="text-align:right"><label>Foto</label></div>
                            <div class="col-md-1"><input class="form-control" name ="uRutGambar[]" value="' . $gambar[$g]['urutan'] . '" readonly="readonly" type="text"/></div>
                            <div class="col-md-6"><input type="file" id="fotoHandling' . $g . '" name="fotoHandling[]" onchange="PrevImg(this,' . $g . ')" class="form-control" accept=".jpg, .png, ,jpeg"/><span style="font-size:9pt;color:red">*Pilih File untuk mengganti foto</span></div>
                            <div class="col-md-1"><a class="btn btn-danger" onclick="deletpoto(' . $g . ')"><i class="fa fa-minus"></i></a></div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                            <div class="col-md-8"><center><img id="showPrevImg' . $g . '" style="width:50%;display:none"><img id="hideifprev' . $g . '"  style="width:50%" src="' . base_url('assets/upload/DatabaseHandling/fotononlinier' . $gambar[$g]['id_handling'] . $gambar[$g]['urutan'] . '.png') . '"></center></div>
                        </div>
                    </div>';
                } else {
                    $gambwarr .= '
                    <div id="has' . $g . '">
                        <div class="panel-body">
                            <input type="hidden" name="indexGambr[]" value="' . $g . '"/>
                            <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                            <div class="col-md-1"><input class="form-control" name ="uRutGambar[]" value="' . $gambar[$g]['urutan'] . '" readonly="readonly" type="text"/></div>
                            <div class="col-md-6><input type="file" id="fotoHandling' . $g . '" name="fotoHandling[]" onchange="PrevImg(this,' . $g . ')" class="form-control" accept=".jpg, .png, ,jpeg"/><span style="font-size:9pt;color:red">*Pilih File untuk mengganti foto</span></div>
                            <div class="col-md-1"><a class="btn btn-danger" onclick="deletpoto(' . $g . ')"><i class="fa fa-minus"></i></a></div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                            <div class="col-md-8"><center><img id="showPrevImg' . $g . '" style="width:50%;display:none"><img id="hideifprev' . $g . '"  style="width:50%" src="' . base_url('assets/upload/DatabaseHandling/fotononlinier' . $gambar[$g]['id_handling'] . $gambar[$g]['urutan'] . '.png') . '"></center></div>
                        </div>
                    </div>';
                }
            }
        }

        $piew = '
        <form name="Orderform" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post" action="' . base_url('DbHandling/MonitoringHandling/insertedit') . '">
            <input type="hidden" value="' . $id . '" name="IDHandling"/>
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;"><label>Kode Komponen</label></div>
                <div class="col-md-8"><input type="text" class="form-control" name="KodKomponen" value="' . $dataHandrev[0]['kode_komponen'] . '" readonly="readonly"/></div>
            </div>
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;"><label>Nama Dokumen</label></div>
                <div class="col-md-8"><input type="text" class="form-control" name="NamKomponen" value="' . $dataHandrev[0]['nama_komponen'] . '" readonly="readonly"/></div>
            </div>
            ' . $StatKomp . '
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;"><label>Produk</label></div>
                <div class="col-md-8"><input type="text" class="form-control" value="' . $dataHandrev[0]['kode_produk'] . ' - ' . $dataHandrev[0]['nama_produk'] . '" readonly="readonly"/></div>
            </div>
            ' . $Saranaa . '
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;"><label>Qty / Handling</label></div>
                <div class="col-md-8"><input type="text" name="qty_handlingg" class="form-control" value="' . $dataHandrev[0]['qty_handling'] . '"/></div>
            </div>
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;"><label>Berat</label></div>
                <div class="col-md-8"><input type="text" name="berat_handling" class="form-control" value="' . $dataHandrev[0]['berat'] . '"/></div>
            </div>
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;"><label>Seksi</label></div>
                <div class="col-md-8"><select style="width:100%" class="form-control select2" id="seksi_handling" name="seksi_handling"><option value="' . $dataHandrev[0]['seksi'] . '">' . $dataHandrev[0]['seksi'] . '</option>' . $optseksi . '</select></div>
            </div>
            ' . $selectProses . '
            <div class="prosesawal">
                <div class="addPros">
                    ' . $alur_proses . '
                </div>
                ' . $btntambah . '
                ' . $previewPros . '
            </div>
            <div class="prosesiflinear" style="display : none">
                <div class="linierappend">
                    <div class="panel-body">
                        <input type="hidden" name="indexprosess[]" value="0"/>
                        <div class="col-md-3" style="text-align:right;color:white"><label>Proses</label></div>
                        <div class="col-md-1"><input class="form-control" name="urutPross[]" value="1" readonly="readonly" type="text"/></div>
                        <div class="col-md-3"> 
                            <select style="width:100%" class="form-control select2 idSek_si"  id="Id_Sek_Sii0" onchange="getwarnaidd(0)" data-placeholder="Select">
                                <option></option>  
                                ' . $optionNewLinear . '
                            </select>
                        </div>
                        <div class="col-md-1" id="warna_Id_Seksii0" style="background-color: white;color:white;font-size:16pt;padding:2px;">A</div>
                        <div class="col-md-3"> 
                            <select style="width:100%" onchange="tulis(0)" class="form-control select2 Pro_sesSeksi" name="ProSesSekksi[]" id="Pros_Seksii0" data-placeholder="Select">
                                <option></option>
                            </select>
                        </div>
                    </div> 
                </div>  
                <div class="panel-body">
                    <div class="col-md-3" style="text-align:right;color:white"><label>A</label></div>
                    <div class="col-md-8" style="text-align:right"><a class="btn btn-success" onclick="appendiflinear()">Add Proses</a></div>
                </div>
                <div class="panel-body">
                    <div class="col-md-3" style="text-align:right;"><label>Preview Proses</label></div>
                    <div class="col-md-8" style="border: 1px solid black; border-collapse: collapse" id="appendselectproses">
                        <div style="display: inline-block;">
                            <div id="arrowprosSess0" style="display:none;height:75px; margin:10px;text-align:center;padding: 10px 0;"><i class="fa fa-arrow-right fa-2x"></i></div>
                        </div>
                        <div style="display: inline-block;">
                            <div id="Kotakkk0" style="border: 1px solid black;margin:10px;text-align:center;padding: 10px 0;background-color: white">
                                <p style="margin:10px" id="TulisKotakkk0" ></p>
                            </div>
                        </div>
                    </div>   
                </div>      
            </div>
            <div class="prosesifnonlinear" style ="display:none">
                <div class="panel-body">
                    <div class="col-md-3" style="text-align:right;color:white"><label>Proses</label></div>
                    <div class="col-md-8"><input type="file" id="proses_non_2" name="proses_non_2" onchange="previewimagenonlinier2(this)" class="form-control" accept=".jpg, .png, ,jpeg"/></div>
                </div>
                <div class="panel-body">
                    <div class="col-md-3" style="text-align:right;color:white"><label>Foto</label></div>
                    <div class="col-md-8"><center><img id="PrevImaGe" style="width:50%"></center></div>
                </div>
            </div>
            <div class="addImg">
                ' . $gambwarr . '
            </div>
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;color:white"><label>A</label></div>
                <div class="col-md-8" style="text-align:right;"><a class="btn bg-teal" onclick="addfoto()">Add Foto</a></div>
            </div>
            <div class="panel-body">
                <div class="col-md-3" style="text-align:right;"><label>Keterangan</label></div>
                <div class="col-md-8"><textarea class="form-control" name="ket_handl">' . $dataHandrev[0]['keterangan'] . '</textarea></div>
            </div>
            <div class="panel-body">
                <div class="col-md-12" style="text-align:right;"><button class="btn btn-success">Save</button></div>
            </div>
        </form>';

        echo $piew;
    }
    function insertedit()
    {
        $idd = $this->input->post('IDHandling');
        $dataHandling = $this->M_dbhandling->selectdatahandlingbyid($idd);
        $id_master_handling = $this->input->post('SarAna');
        $qty_handling = $this->input->post('qty_handlingg');
        $berat_handling = $this->input->post('berat_handling');
        $seksi_handling = $this->input->post('seksi_handling');
        $statKomp = $this->input->post('statKomp');
        date_default_timezone_set('Asia/Jakarta');
        $lastupdate_by = $this->session->user;
        $lastupdate_date = date("Y-m-d H:i:s");
        $proses = $this->input->post('Pros_Es');
        $keterangan = $this->input->post('ket_handl');
        $rev_no = $dataHandling[0]['rev_no'] + 1;
        $manual_proses = $this->input->post('ProSesSeksi[]');
        $sar = $this->M_dbhandling->selectdatatoedit($id_master_handling);
        $status_kompp = $this->M_dbhandling->selectstatuskompbyid($statKomp);
        $docdigit4 = substr($dataHandling[0]['kode_komponen'], 3, 6);
        $split = str_split($docdigit4);


        if ($split[5] == '-') {
            $doc_no = 'SH-' . $sar[0]['kode_handling'] . '-' . $dataHandling[0]['kode_produk'] . '-' . substr($docdigit4, 0, 5) . '-' . $status_kompp[0]['kode_status'];
        } else {
            $doc_no = 'SH-' . $sar[0]['kode_handling'] . '-' . $dataHandling[0]['kode_produk'] . '-' . $docdigit4 . '-' . $status_kompp[0]['kode_status'];
        }

        // echo "<pre>";
        // print_r($doc_no);
        // print_r($dataHandling);
        // print_r($id_master_handling);
        // print_r($qty_handling);
        // print_r($berat_handling);
        // print_r($seksi_handling);
        // print_r($statKomp);
        // print_r($lastupdate_by);
        // print_r($lastupdate_date);
        // print_r($proses);
        // print_r($keterangan);
        // print_r($rev_no);
        // exit();

        $this->M_dbhandling->insertdatahandlingrev($rev_no, $lastupdate_date, $lastupdate_by, $doc_no, $dataHandling[0]['kode_komponen'], $dataHandling[0]['nama_komponen'], $statKomp, $dataHandling[0]['kode_produk'], $dataHandling[0]['nama_produk'], $id_master_handling, $qty_handling, $berat_handling, $seksi_handling, $proses, $keterangan);
        $lastval = $this->M_dbhandling->getIdHandling();
        $id = $lastval[0]['lastval'];

        if ($proses == 'Linear') {
            $uRutGambar = $this->input->post('uRutGambar[]');

            if ($dataHandling[0]['proses'] == 'Linear') {
                $manual_proses = $this->input->post('ProSesSeksi[]');
                $urutan_proses = $this->input->post('urutPros[]');

                for ($g = 0; $g < sizeof($manual_proses); $g++) {
                    $id_proses_seksi =  $this->M_dbhandling->cariidproseseksi($manual_proses[$g]);
                    $this->M_dbhandling->insertproseshandling($id, $urutan_proses[$g], $id_proses_seksi[0]['id_proses_seksi']);
                }
                for ($i = 0; $i < sizeof($uRutGambar); $i++) {
                    $this->M_dbhandling->insertgambar($id, $uRutGambar[$i]);

                    // if (!is_dir('./assets/upload/DatabaseHandling')) {
                    //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
                    chmod('./assets/upload/DatabaseHandling', 0777);
                    // }
                    $filename = "assets/upload/DatabaseHandling/fotolinier" . $id . $uRutGambar[$i] . '.png';
                    $temp_name = $_FILES['fotoHandling']['tmp_name'][$i];
                    if ($temp_name == null) {
                        $imagePath = "assets/upload/DatabaseHandling/fotolinier" . $idd . $uRutGambar[$i] . '.png';
                        $newPath = "assets/upload/DatabaseHandling/fotolinier";
                        $ext = '.png';
                        $newName  = $newPath . $id . $uRutGambar[$i] . $ext;
                        copy($imagePath, $newName);
                    } else {
                        if (file_exists($filename)) {
                            move_uploaded_file($temp_name, $filename);
                        } else {
                            move_uploaded_file($temp_name, $filename);
                        }
                    }
                }
            } else {
                $manual_proses = $this->input->post('ProSesSekksi[]');
                $urutan_proses = $this->input->post('urutPross[]');
                for ($g = 0; $g < sizeof($manual_proses); $g++) {
                    $id_proses_seksi =  $this->M_dbhandling->cariidproseseksi($manual_proses[$g]);
                    $this->M_dbhandling->insertproseshandling($id, $urutan_proses[$g], $id_proses_seksi[0]['id_proses_seksi']);
                }
                for ($i = 0; $i < sizeof($uRutGambar); $i++) {
                    $this->M_dbhandling->insertgambar($id, $uRutGambar[$i]);

                    // if (!is_dir('./assets/upload/DatabaseHandling')) {
                    //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
                    chmod('./assets/upload/DatabaseHandling', 0777);
                    // }
                    $filename = "assets/upload/DatabaseHandling/fotolinier" . $id . $uRutGambar[$i] . '.png';
                    $temp_name = $_FILES['fotoHandling']['tmp_name'][$i];
                    if ($temp_name == null) {
                        $imagePath = "assets/upload/DatabaseHandling/fotononlinier" . $idd . $uRutGambar[$i] . '.png';
                        $newPath = "assets/upload/DatabaseHandling/fotolinier";
                        $ext = '.png';
                        $newName  = $newPath . $id . $uRutGambar[$i] . $ext;
                        copy($imagePath, $newName);
                    } else {
                        if (file_exists($filename)) {
                            move_uploaded_file($temp_name, $filename);
                        } else {
                            move_uploaded_file($temp_name, $filename);
                        }
                    }
                }
            }
        } else {
            $uRutGambar = $this->input->post('uRutGambar[]');
            if ($dataHandling[0]['proses'] == 'Non Linear') {

                // if (!is_dir('./assets/upload/DatabaseHandling')) {
                //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
                chmod('./assets/upload/DatabaseHandling', 0777);
                // }

                $filename = "assets/upload/DatabaseHandling/prosesnonlinier" . $id . '.png';
                $temp_name = $_FILES['pros_non_linier']['tmp_name'];
                if ($temp_name == null) {
                    $imagePath = "assets/upload/DatabaseHandling/prosesnonlinier" . $idd . '.png';
                    $newPath = "assets/upload/DatabaseHandling/prosesnonlinier";
                    $ext = '.png';
                    $newName  = $newPath . $id . $ext;
                    copy($imagePath, $newName);
                } else {
                    if (file_exists($filename)) {
                        move_uploaded_file($temp_name, $filename);
                    } else {
                        move_uploaded_file($temp_name, $filename);
                    }
                }
                for ($i = 0; $i < sizeof($uRutGambar); $i++) {
                    $this->M_dbhandling->insertgambar($id, $uRutGambar[$i]);

                    // if (!is_dir('./assets/upload/DatabaseHandling')) {
                    //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
                    chmod('./assets/upload/DatabaseHandling', 0777);
                    // }
                    $filename = "assets/upload/DatabaseHandling/fotononlinier" . $id . $uRutGambar[$i] . '.png';
                    $temp_name = $_FILES['fotoHandling']['tmp_name'][$i];
                    if ($temp_name == null) {
                        $imagePath = "assets/upload/DatabaseHandling/fotononlinier" . $idd . $uRutGambar[$i] . '.png';
                        $newPath = "assets/upload/DatabaseHandling/fotononlinier";
                        $ext = '.png';
                        $newName  = $newPath . $id . $uRutGambar[$i] . $ext;
                        copy($imagePath, $newName);
                    } else {
                        if (file_exists($filename)) {
                            move_uploaded_file($temp_name, $filename);
                        } else {
                            move_uploaded_file($temp_name, $filename);
                        }
                    }
                }
            } else {
                // proses_non_2
                // if (!is_dir('./assets/upload/DatabaseHandling')) {
                //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
                chmod('./assets/upload/DatabaseHandling', 0777);
                // }
                $filename = "assets/upload/DatabaseHandling/prosesnonlinier" . $id . '.png';
                $temp_name = $_FILES['proses_non_2']['tmp_name'];
                if (file_exists($filename)) {
                    move_uploaded_file($temp_name, $filename);
                } else {
                    move_uploaded_file($temp_name, $filename);
                }
                for ($i = 0; $i < sizeof($uRutGambar); $i++) {
                    $this->M_dbhandling->insertgambar($id, $uRutGambar[$i]);

                    // if (!is_dir('./assets/upload/DatabaseHandling')) {
                    //     mkdir('./assets/upload/DatabaseHandling', 0777, true);
                    chmod('./assets/upload/DatabaseHandling', 0777);
                    // }
                    $filename = "assets/upload/DatabaseHandling/fotononlinier" . $id . $uRutGambar[$i] . '.png';
                    $temp_name = $_FILES['fotoHandling']['tmp_name'][$i];
                    if ($temp_name == null) {
                        $imagePath = "assets/upload/DatabaseHandling/fotolinier" . $idd . $uRutGambar[$i] . '.png';
                        $newPath = "assets/upload/DatabaseHandling/fotononlinier";
                        $ext = '.png';
                        $newName  = $newPath . $id . $uRutGambar[$i] . $ext;
                        copy($imagePath, $newName);
                    } else {
                        if (file_exists($filename)) {
                            move_uploaded_file($temp_name, $filename);
                        } else {
                            move_uploaded_file($temp_name, $filename);
                        }
                    }
                }
            }
        }

        // fotoHandling[]
        // echo "<pre>";
        // print_r($_FILES);
        // exit();
        redirect(base_url('DbHandling/MonitoringHandling'));
    }
    public function updateterima()
    {
        $id = $this->input->post('id');
        $datatoupdate = $this->M_dbhandling->selectdatahandlingbyid($id);
        $databykomp = $this->M_dbhandling->selectdatahandlingbykom($datatoupdate[0]['kode_komponen']);

        // echo "<pre>";
        // print_r($datatoupdate[0]['kode_komponen']);
        // exit();

        if ($databykomp != null) {
            for ($f = 0; $f < sizeof($databykomp); $f++) {
                $rev_no[$f] = $databykomp[$f]['rev_no'];
            }
            rsort($rev_no);
            $rev = $rev_no[0] + 1;
        } else {
            $rev = 0;
        }
        $this->M_dbhandling->updateterima($id, $rev);
    }
    public function updatereject()
    {
        $id = $this->input->post('id');
        $this->M_dbhandling->updatereject($id);
    }
    public function suggestseksi()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        $data = $this->M_dbhandling->select2_seksi($term);
        echo json_encode($data);
    }
}
