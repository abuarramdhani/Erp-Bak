<?php Defined('BASEPATH') or exit('No direct script accsess allowed');
/**
 *
 */
class C_DatabaseQTW extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('Encrypt');
        $this->daerah = $this->load->database('daerah', true);
        $this->dabes = $this->load->database('personalia', true);
        $this->load->model('ADMPelatihan/M_databaseqtw');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MasterPekerja/Pekerja/PekerjaKeluar/M_pekerjakeluar');
        $this->checkSession();
        date_default_timezone_set('Asia/Jakarta');
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
        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring List Database QTW';
        $data['Menu'] = 'Database QTW';
        $data['SubMenuOne'] = 'Input Data Peserta QTW';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['data'] = $this->M_databaseqtw->getAllData();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_monitoring', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_Footer', $data);
    }

    public function create()
    {
        $user_id = $this->session->userid;

        $data['Title'] = 'Database QTW';
        $data['Menu'] = 'Database QTW';
        $data['SubMenuOne'] = 'Input Data Peserta QTW';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_index', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_Footer', $data);
    }

    public function findPemandu()
    {
        $term = ucwords(strtoupper($_GET['term']));
        $tanggal = date('Y-m-d', strtotime($_GET['tanggal_slc']));
        $mulai = $_GET['mulai_slc'];
        $selesai = $_GET['selesai_slc'];
        if ($_GET['loker_slc'] == 'Tuksono') {
            $loker = '02';
        } else if ($_GET['loker_slc'] == 'Pusat') {
            $loker = '01';
        } else {
            $loker = '';
        }

        $explode = explode(' ', $mulai);
        $explode2 = explode(' ', $selesai);

        if (count($explode) == 1 && count($explode2) == 1) {
            $data = $this->M_databaseqtw->getPemandu($tanggal, $term, $mulai, $selesai, $loker);
        } else if (count($explode) > 1 && count($explode2) > 1) {
            $array = array(
                '0' => $explode[1],
                '1' => $explode[2],
                '2' => $explode[3]
            );

            $implod = implode('-', $array);
            $tanggal = date('Y-m-d', strtotime($implod));
            $start = date('H:i:s', strtotime($explode[4]));
            $end = date('H:i:s', strtotime($explode2[4]));
            $data = $this->M_databaseqtw->getPemandu($tanggal, $term, $start, $end, $loker);
        }

        echo json_encode($data);
    }

    public function deleteData()
    {
        $id = $_GET['id'];
        $decrypted_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
        $decrypted_string = $this->encrypt->decode($decrypted_string);
        $del = $this->M_databaseqtw->deleteData($decrypted_string);
        print_r($del);
        die;
    }

    public function editData()
    {
        $id = $_GET['id'];
        $decrypted_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
        $decrypted_string = $this->encrypt->decode($decrypted_string);
        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring List Database QTW';
        $data['Menu'] = 'Database QTW';
        $data['SubMenuOne'] = 'Input Data Peserta QTW';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['data'] = $this->M_databaseqtw->getAllData($decrypted_string);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_edit', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_Footer', $data);
    }

    public function searchDetailInstansi()
    {
        $jenis = $this->input->post('a');

        if ($jenis == '1') {
            $data = $this->M_databaseqtw->getSekolah();
        } elseif ($jenis == '2') {
            $data = $this->M_databaseqtw->getUniv();
        } else {
            $data = 'wrong';
        }

        echo json_encode($data);
    }

    public function save()
    {
        $jenis              = $_POST['slcJnsQtw'];
        $alamat             = $_POST['txtaAlamatQtw'];
        $tujuan             = $_POST['slcTjnQtw'];
        $tanggal            = $_POST['txttglqtw'];
        $kodepos            = $_POST['txtKodePosQtw'];
        $pemandu            = $_POST['slcPicQtw'];
        $hp_tamu            = $_POST['inpHpLawan'];
        $pic_tamu           = $_POST['inpPicLawan'];
        $kendaraan          = implode(', ', $_POST['kendaraan_qtw']);
        $waktu_mulai        = $_POST['txtTimeAwalqtw'];
        $waktu_selesai      = $_POST['txtTimeAkhirqtw'];
        $jml_kendaraan      = implode(', ', $_POST['jml_kdrn_qtw']);
        $detail_Institusi   = $_POST['slcDtlQtw'];
        $pendamping         = $_POST['inp_tua_qtw'];
        $peserta            = $_POST['inp_muda_qtw'];

        if ($jenis != '3') {
            $kel                = $_POST['txtKelQtw'];
            $kec                = $_POST['txtKecQtw'];
            $kab                = $_POST['txtKabQtw'];
            $prov               = $_POST['txtProvQtw'];
            $provinsi = $this->daerah->query("SELECT nama from provinsi where id_prov = '$prov'")->row()->nama;
            $kabupaten = $this->daerah->query("SELECT nama from kabupaten where id_prov = '$prov' and id_kab = '$kab'")->row()->nama;
            $kecamatan = $this->daerah->query("SELECT nama from kecamatan where id_kab = '$kab' and id_kec = '$kec'")->row()->nama;
            $desa = $this->daerah->query("SELECT nama from kelurahan where id_kec = '$kec' and id_kel = '$kel'")->row()->nama;
        }

        //Insert data
        $array  = array(
            'jenis_institusi' => $jenis,
            'dtl_institusi'   => $detail_Institusi,
            'pic'             => ucwords(strtoupper($pic_tamu)),
            'nohp_pic'        => $hp_tamu,
            'alamat'          => ucwords(strtoupper($alamat)),
            'prop'            => ($jenis != '3') ? $provinsi : null,
            'kab'             => ($jenis != '3') ? $kabupaten : null,
            'kec'             => ($jenis != '3') ? $kecamatan : null,
            'desa'            => ($jenis != '3') ? $desa : null,
            'kd_pos'          => $kodepos,
            'kendaraan'       => $kendaraan,
            'jml_kendaraan'   => $jml_kendaraan,
            'wkt_mulai	'     => $waktu_mulai,
            'wkt_selesai'     => $waktu_selesai,
            'pemandu'         => $pemandu,
            'created_date'    => date('Y-m-d'),
            'tanggal'         => date('Y-m-d 00:00:00', strtotime($tanggal)),
            'pendamping'      => $pendamping,
            'peserta'         => $peserta,
            'tujuan'          => $tujuan,
        );
        $this->M_databaseqtw->insertTdabesQtw($array);

        redirect('QuickWisata/DBQTW/');
    }

    public function updateQTW()
    {
        $id                 = $_POST['id_qtw'];
        $tujuan             = $_POST['slcTjnQtw'];
        $tanggal            = $_POST['txttglqtw'];
        $pemandu            = $_POST['slcPicQtw'];
        $hp_tamu            = $_POST['inpHpLawan'];
        $pic_tamu           = $_POST['inpPicLawan'];
        $kendaraan          = implode(', ', $_POST['kendaraan_qtw']);
        $waktu_mulai        = $_POST['txtTimeAwalqtw'];
        $waktu_selesai      = $_POST['txtTimeAkhirqtw'];
        $jml_kendaraan      = implode(', ', $_POST['jml_kdrn_qtw']);
        $pendamping         = $_POST['inp_tua_qtw'];
        $peserta            = $_POST['inp_muda_qtw'];

        //Insert data
        $array  = array(
            'pic'             => ucwords(strtoupper($pic_tamu)),
            'nohp_pic'        => $hp_tamu,
            'kendaraan'       => $kendaraan,
            'jml_kendaraan'   => $jml_kendaraan,
            'wkt_mulai	'     => $waktu_mulai,
            'wkt_selesai'     => $waktu_selesai,
            'pemandu'         => $pemandu,
            'created_date'    => date('Y-m-d'),
            'tanggal'         => date('Y-m-d 00:00:00', strtotime($tanggal)),
            'pendamping'      => $pendamping,
            'peserta'         => $peserta,
            'tujuan'          => $tujuan,
        );
        $this->M_databaseqtw->updateQTW($array, $id);

        redirect('QuickWisata/DBQTW/');
    }

    //Kalender QTW

    public function KalendarQTW()
    {
        $user_id = $this->session->userid;

        $data['Title'] = 'Database QTW';
        $data['Menu'] = 'Database QTW';
        $data['SubMenuOne'] = 'Input Data Peserta QTW';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_calender', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_Footer', $data);
    }

    public function cekThisMonth()
    {
        $jadwal = $this->M_databaseqtw->getAllAgenda();

        $color = array(
            '0' => '#21b71f',
            '1' => '#de2c16',
            '2' => '#e0da25',
            '3' => '#6ea9dc',
        );

        $i = 0;
        for ($x = 0; $x < count($jadwal); $x++) {
            $jadwal[$x]['start'] = strtotime($jadwal[$x]['start']);
            $jadwal[$x]['end'] = strtotime($jadwal[$x]['end']);
            $jadwal[$x]['id'] = $jadwal[$x]['id_qtw'];
            $jadwal[$x]['allDay'] = false;
            $jadwal[$x]['color'] = $color[$i];
            if ($i == (count($color) - 1)) $i = 0;
            $i++;
        }

        echo json_encode($jadwal);
    }

    public function getDetailData()
    {
        $id = $_POST['id'];
        $data = $this->M_databaseqtw->getAllData($id);
        $data['pelatihan'] = $this->dabes->query("select noind, trim(nama) as nama from hrd_khs.tpribadi where kodesie like '402010%' and keluar = '0' order by noind")->result_array();

        $kendaraan = explode(', ', $data[0]['kendaraan']);
        $jml_kendaraan = explode(', ', $data[0]['jml_kendaraan']);
        $a = array();
        $i = 0;
        foreach ($kendaraan as $key) {
            $a[] = array(
                'nama' => $key,
                'jumlah' => $jml_kendaraan[$i++]
            );
        }
        $data['kendaraan'] = $a;
        echo json_encode($data);
    }

    public function gantiPemandu()
    {
        $noind = $_GET['noind'];
        $id = $_GET['id'];

        $cek = $this->M_databaseqtw->cekDataPemandu($id);
        if ($cek == $noind) {
            echo json_encode('NOT');
        } else if ($cek != $noind) {
            $set = array(
                'pemandu' => $noind
            );

            $this->M_databaseqtw->updatePemandu($id, $set);

            echo json_encode('OK');
        }
    }

    //ReportKalender
    public function ReportKalendarQTW()
    {
        $user_id = $this->session->userid;

        $data['Title'] = 'Database QTW';
        $data['Menu'] = 'Database QTW';
        $data['SubMenuOne'] = 'Input Data Peserta QTW';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_report', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_Footer', $data);
    }

    public function generateData($jenis, $tahun, $start, $end)
    {
        if ($jenis == 1) {
            if ($tahun) {
                $trigger = "where tanggal between '" . date('Y-01-01', strtotime($tahun)) . "' and '" . date('Y-12-31', strtotime($tahun)) . "' and status_qtw = '0'";
            } else {
                $trigger = "where status_qtw = '0'";
            }
        } else {
            if ($start && $end) {
                $trigger = "where tanggal between '" . date('Y-m-01', strtotime($start)) . "' and '" . date('Y-m-t', strtotime($end)) . "' and status_qtw = '0'";
            } else {
                $trigger = "where status_qtw = '0'";
            }
        }
        $getData = $this->dabes->query("SELECT * from \"Sie_Pelatihan\".tdabes_qtw $trigger order by tanggal, wkt_mulai")->result_array();

        return $getData;
    }

    public function findDataReview()
    {
        $data  = $_POST['data'];
        $jenis = $data['jenis'];

        $getData = $this->generateData($jenis, $data['tahun'], $data['start'], $data['end']);
        $array = array();
        foreach ($getData as $key) {
            if ($jenis == 1) {
                $array[date('Y-m', strtotime($key['tanggal']))][] = $key;
                $text = '';
                foreach ($array as $key => $value) {
                    $nomor = 1;
                    $text .= '<div class="col-lg-12 text-center" style="background-color: #6ea9dc"><b>' . date('M Y', strtotime($key)) . '</b></div><table class="table datatable table-stripped"><thead><tr><th style="width: 5%;">No<th style="width: 10%;">Tanggal<th style="width: 10%;">Waktu<th style="width: 25%;">Instansi<th style="width: 5%;">Tujuan<th style="width: 15%;">PIC Quick<th style="width: 20%;">PIC Instansi<th style="width: 3%;">Pendamping<th style="width: 3%;">Peserta</th></tr></thead><tbody>';
                    foreach ($value as $nano) {
                        $nama_pemandu = $this->dabes->query("SELECT noind || ' - ' || trim(nama) as name from hrd_khs.tpribadi where noind = '" . $nano['pemandu'] . "'")->row()->name;
                        $text .= '<td style="width: 3px;">' . $nomor++ . '<td style="width: 10px;">' . date('d-m-Y', strtotime($nano['tanggal'])) . '<td style="width: 10px;">' . date('H:i', strtotime($nano['wkt_mulai'])) . ' - ' . date('H:i', strtotime($nano['wkt_selesai'])) . '<td style="width: 25px;">' . $nano['dtl_institusi'] . '<td style="width: 5px;">' . $nano['tujuan'] . '<td style="width: 15px;">' . $nama_pemandu . '<td style="width: 15px;">(' . $nano['nohp_pic'] . ') - ' . $nano['pic'] . '<td style="width: 3px;">' . $nano['pendamping'] . '<td style="width: 3px;">' . $nano['peserta'] . '</td><tr>';
                    }
                    $text .= '</body></table><br>';
                }
            } else {
                $array[$key['tanggal']][] = $key;
                $text = '';
                foreach ($array as $key => $value) {
                    $nomor = 1;
                    $text .= '<div class="col-lg-12 text-center" style="background-color: #6ea9dc"><b>' . date('d M Y', strtotime($key)) . '</b></div><table class="table datatable table-stripped"><thead><tr><th style="width: 5%;">No<th style="width: 10%;">Waktu<th style="width: 25%;">Instansi<th style="width: 5%;">Tujuan<th style="width: 15%;">PIC Quick<th style="width: 20%;">PIC Instansi<th style="width: 3%;">Pendamping<th style="width: 3%;">Peserta</th></tr></thead><tbody>';
                    foreach ($value as $nano) {
                        $nama_pemandu = $this->dabes->query("SELECT noind || ' - ' || trim(nama) as name from hrd_khs.tpribadi where noind = '" . $nano['pemandu'] . "'")->row()->name;
                        $text .= '<td>' . $nomor++ . '<td>' . date('H:i', strtotime($nano['wkt_mulai'])) . ' - ' . date('H:i', strtotime($nano['wkt_selesai'])) . '<td>' . $nano['dtl_institusi'] . '<td>' . $nano['tujuan'] . '<td>' . $nama_pemandu . '<td>(' . $nano['nohp_pic'] . ') - ' . $nano['pic'] . '<td>' . $nano['pendamping'] . '<td>' . $nano['peserta'] . '</td><tr>';
                    }
                    $text .= '</body></table><br>';
                }
            }
        }

        echo json_encode($text);
    }

    public function findDataPDF()
    {
        $button = $_GET['a'];
        $jenis = $_GET['jenis'];
        $user = $this->session->user;
        $nama_user = $this->dabes->query("SELECT noind || ' - ' || trim(nama) as name from hrd_khs.tpribadi where noind = '" . $user . "'")->row()->name;

        if ($jenis == 1) {
            $namain = 'Tahun ' . date('Y', strtotime($_GET['tahun']));
        } else if (date('M Y', strtotime($_GET['start'])) == date('M Y', strtotime($_GET['end']))) {
            $namain = 'Bulan ' . date('M Y', strtotime($_GET['start']));
        } else {
            $namain = 'Bulan ' . date('M Y', strtotime($_GET['start'])) . ' - ' . date('M Y', strtotime($_GET['end']));
        }

        $getData = $this->generateData($jenis, $_GET['tahun'], $_GET['start'], $_GET['end']);
        if ($button == '2') {
            //Data PDF
            $array = array();
            foreach ($getData as $key) {
                if ($jenis == 1) {
                    $array[date('Y-m', strtotime($key['tanggal']))][] = $key;
                    $text = '';
                    foreach ($array as $key => $value) {
                        $nomor = 1;
                        $text .= '<table class="table table-stripped" style="border-collapse: collapse; border: 1px solid black; width: 100%;"><thead><tr><th colspan="9" class="col-lg-12 text-center" style="background-color: #6ea9dc;">' . date('M Y', strtotime($key)) . '</tr><tr><th style="width: 3%;">No<th style="border-left: 1px solid black; width: 10%;">Tanggal<th style="border-left: 1px solid black; width: 10%;">Waktu<th style="border-left: 1px solid black; width: 27%;">Instansi<th style="border-left: 1px solid black; width: 5%;">Tujuan<th style="border-left: 1px solid black; width: 5%;">PIC<th style="border-left: 1px solid black; width: 10%;">PIC Peserta<th style="border-left: 1px solid black; width: 5%; white-space: nowrap;">Pendamping<th style="border-left: 1px solid black; width: 5%;">Peserta</th></tr></thead><tbody>';
                        foreach ($value as $nano) {
                            $nama_pemandu = $this->dabes->query("SELECT noind || ' - ' || trim(nama) as name from hrd_khs.tpribadi where noind = '" . $nano['pemandu'] . "'")->row()->name;
                            $text .= '<tr style="border: 1px solid black;"><td style="width: 3%; text-align: center">' . $nomor++ . '<td style="border-left: 1px solid black; width: 10%; text-align: center;">' . date('d-m-Y', strtotime($nano['tanggal'])) . '<td style="border-left: 1px solid black; width: 10%; text-align: center;">' . date('H:i', strtotime($nano['wkt_mulai'])) . ' - ' . date('H:i', strtotime($nano['wkt_selesai'])) . '<td style="border-left: 1px solid black; width: 27%">' . $nano['dtl_institusi'] . '<td style="border-left: 1px solid black; width: 5%">' . $nano['tujuan'] . '<td style="border-left: 1px solid black; width: 20%;">' . $nama_pemandu . '<td style="border-left: 1px solid black; width: 20%;">(' . $nano['nohp_pic'] . ') - ' . $nano['pic'] . '<td style="border-left: 1px solid black; width: 5%;">' . $nano['pendamping'] . '<td style="border-left: 1px solid black; width: 5%;">' . $nano['peserta'] . '</td></tr>';
                        }
                        $text .= '</tbody></table><br>';
                    }
                } else {
                    $array[$key['tanggal']][] = $key;
                    $text = '';
                    foreach ($array as $key => $value) {
                        $nomor = 1;
                        $text .= '<table class="table table-stripped" style="border-collapse: collapse; border: 1px solid black; width: 100%;"><thead><tr><th colspan="8" class="col-lg-12 text-center" style="background-color: #6ea9dc;">' . date('d M Y', strtotime($key)) . '</tr><tr><th style="width: 3%; text-align: center">No<th style="border-left: 1px solid black; width: 10%;">Waktu<th style="border-left: 1px solid black; width: 30%;">Instansi<th style="border-left: 1px solid black; width: 5%;">Tujuan<th style="border-left: 1px solid black; width: 10%;">PIC<th style="border-left: 1px solid black; width: 10%;">PIC Peserta<th style="border-left: 1px solid black; width: 5%; white-space: nowrap;">Pendamping<th style="border-left: 1px solid black; width: 5%;">Peserta</th></tr></thead><tbody>';
                        foreach ($value as $nano) {
                            $nama_pemandu = $this->dabes->query("SELECT noind || ' - ' || trim(nama) as name from hrd_khs.tpribadi where noind = '" . $nano['pemandu'] . "'")->row()->name;
                            $text .= '<tr style="border: 1px solid black;"><td style="width: 3%; text-align: center">' . $nomor++ . '<td style="border-left: 1px solid black; width: 10%; text-align: center;">' . date('H:i', strtotime($nano['wkt_mulai'])) . ' - ' . date('H:i', strtotime($nano['wkt_selesai'])) . '<td style="border-left: 1px solid black;  width: 30%">' . $nano['dtl_institusi'] . '<td style="border-left: 1px solid black; width: 5%">' . $nano['tujuan'] . '<td style="border-left: 1px solid black; width: 20%;">' . $nama_pemandu . '<td style="border-left: 1px solid black; width: 20%;">(' . $nano['nohp_pic'] . ') - ' . $nano['pic'] . '<td style="border-left: 1px solid black; width: 5%;">' . $nano['pendamping'] . '<td style="border-left: 1px solid black; width: 5%;">' . $nano['peserta'] . '</td></tr>';
                        }
                        $text .= '</tbody></table><br>';
                    }
                }
            }

            $this->load->library('pdf');
            $mpdf = $this->pdf->load();
            $pdf = new mPDF('utf-8', 'A4-L', 8, 5, 10, 10, 30, 15, 8, 20);
            $filename = 'Rekap Database QTW ' . $namain . '.pdf';

            $pdf->setHTMLHeader('
            <table width="100%">
            <tr>
            <td width="50%"><h2><b>Rekap ' . ($jenis == 1 ? 'Tahunan' : 'Bulanan') . ' Database QTW</b></h2><h4>Periode Rekap ' . $namain . '</h4></td>
            <td><h4>Dicetak Oleh ' . $nama_user . ' pada Tanggal ' . date('d F Y H:i:s') . '</h4></td>
            </tr>
            </table>
            ');

            $pdf->WriteHTML($text, 2);
            $pdf->setTitle($filename);
            $pdf->Output($filename, 'I');
        } else if ($button == '3') {
            //Data Excel
            $this->load->library("Excel");
            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getProperties()->setCreator('KHS ERP')
                ->setTitle("REKAP DATABASE QTW " . $namain)
                ->setSubject("REKAP DATABASE QTW")
                ->setDescription("Rekap Database QTW")
                ->setKeywords("QTW");

            $style = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
            );

            $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
            $objPHPExcel->getActiveSheet()->getStyle('A1:I3')->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A1:I3')->getFont()->setBold(TRUE);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth('3');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth('10');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth('13');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth('30');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth('10');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth('30');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth('30');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth('5');
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth('5');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATABASE QTW");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "TANGGAL");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "WAKTU");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "INSTANSI");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "TUJUAN");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "PIC QUICK");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "PIC PESERTA");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "PENDAMPING");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "PESERTA");

            $i = 4;
            $no = 1;
            foreach ($getData as $key) {
                $nama_pemandu = $this->dabes->query("SELECT noind || ' - ' || trim(nama) as name from hrd_khs.tpribadi where noind = '" . $key['pemandu'] . "'")->row()->name;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $no++);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, date('d-m-Y', strtotime($key['tanggal'])));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, date("H:i", strtotime($key['wkt_mulai'])) . ' - ' . date("H:i", strtotime($key['wkt_mulai'])));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $key['dtl_institusi']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $key['tujuan']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $nama_pemandu);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, '(' . $key['nohp_pic'] . ') - ' . $key['pic']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, $key['pendamping']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, $key['peserta']);
                $i++;
                $objPHPExcel->getActiveSheet()->getRowDimension($no)->setRowHeight(15);
            }

            $objPHPExcel->getActiveSheet()->setTitle('REKAP DATABASE QTW');

            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("RekapDatabaseQTW.xls");

            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function TrafficQTW()
    {
        $user_id = $this->session->userid;

        $data['Title'] = 'Grafik Database QTW';
        $data['Menu'] = 'Grafik Database QTW';
        $data['SubMenuOne'] = 'Grafik Database QTW';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_grafik', $data);
        $this->load->view('ADMPelatihan/DatabaseQTW/V_Footer', $data);
    }

    public function dataGrafik()
    {
        // template bulan
        $data['tahun'] = $_GET['tahun'];
        $grafik = $this->M_databaseqtw->getDataGrafik($data['tahun']);
        $data['bulan'] = array(
            '0' => 'Januari',
            '1' => 'Februari',
            '2' => 'Maret',
            '3' => 'April',
            '4' => 'Mei',
            '5' => 'Juni',
            '6' => 'Juli',
            '7' => 'Agustus',
            '8' => 'September',
            '9' => 'Oktober',
            '10' => 'November',
            '11' => 'Desember'
        );

        $template = array_map(function ($key, $item) {
            return array(
                "no" => $key,
                "bulane" => $item,
                "jumlah" => 0
            );
        }, array_keys($data['bulan']), $data['bulan']);

        foreach ($grafik as $key => $item) {
            $template[$item['no']] = $item;
        }

        $data['template'] = $template;

        echo json_encode($data);
    }

    public function getDetailGrafik()
    {
        $bulan = $_GET['periode'];
        $tahun = $_GET['tahun'];

        if ($bulan == 'Januari') {
            $bulan = '01';
        } elseif ($bulan == 'Februari') {
            $bulan = '02';
        } elseif ($bulan == 'Maret') {
            $bulan = '03';
        } elseif ($bulan == 'April') {
            $bulan = '04';
        } elseif ($bulan == 'Mei') {
            $bulan = '05';
        } elseif ($bulan == 'Juni') {
            $bulan = '06';
        } elseif ($bulan == 'Juli') {
            $bulan = '07';
        } elseif ($bulan == 'Agustus') {
            $bulan = '08';
        } elseif ($bulan == 'September') {
            $bulan = '09';
        } elseif ($bulan == 'Oktober') {
            $bulan = '10';
        } elseif ($bulan == 'November') {
            $bulan = '11';
        } elseif ($bulan == 'Desember') {
            $bulan = '12';
        }

        $params = date('Y-m', strtotime($tahun . '-' . $bulan));
        $data = $this->M_databaseqtw->getDataLabel($params);
        echo json_encode($data);
    }
}
