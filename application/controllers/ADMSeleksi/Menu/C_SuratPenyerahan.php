<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SuratPenyerahan extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Log_Activity');
    $this->load->library('General');
    $this->load->library('pdf');
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->library('Personalia');

    $this->dabes = $this->load->database('personalia', TRUE);
    $this->load->model('MasterPekerja/Pekerja/PekerjaKeluar/M_pekerjakeluar');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('ADMSeleksi/M_penyerahan');

    date_default_timezone_set('Asia/Jakarta');
    $this->checkSession();
  }

  public function checkSession()
  {
    if (!($this->session->is_logged)) {
      redirect('');
    }
  }

  //Function untuk monitoring
  public function index()
  {
    $data     =    $this->general->loadHeaderandSidemenu('ADM Seleksi - Quick ERP', 'Surat Penyerahan', 'Surat Penyerahan');
    $data['approval'] = $this->M_penyerahan->getApproval();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('ADMSeleksi/Penyerahan/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  public function getDataSP()
  {
    $data           = $_POST['data'];
    $kodesie        = $data['kodesie'];
    $tanggal        = date('Y-m-d', strtotime($data['tanggal']));
    $jenis          = $data['jenis'];
    $ruangLingkup   = $data['ruangLingkup'];

    $jenis_pekerja = $this->dabes->query("SELECT jenis from \"Surat\".tnoind_penyerahan where no_jenis = '$jenis'")->row()->jenis;
    $res = $this->M_penyerahan->ambilDataAll($kodesie, $tanggal, $jenis_pekerja, $ruangLingkup);

    echo json_encode($res);
  }

  public function EditData()
  {
    $data     =    $this->general->loadHeaderandSidemenu('ADM Seleksi - Quick ERP', 'Edit Surat Penyerahan', 'Surat Penyerahan');
    $kode = $this->input->get('kode');

    $explode = explode('|', $kode);
    $tanggal = date('Y-m-d', strtotime($explode[2]));
    $gol1 = array(
      '1',
      '2',
      '3'
    );
    $gol2 = array(
      'A',
      'B',
      'C'
    );
    $gol3 = array(
      'PKL1',
      'PKL2',
      'PKL3'
    );

    $noind = $explode[1];

    $data['data'] = $this->M_penyerahan->getDataEdit($explode[0], $explode[1], $tanggal, $explode[3]);

    $a = $data['data'][0]['gol'];
    if (in_array($a, $gol1)) {
      $data['gol'] = $gol1;
    } elseif (in_array($a, $gol2)) {
      $data['gol'] = $gol2;
    } elseif (in_array($a, $gol3)) {
      $data['gol'] = $gol3;
    } else {
      $merge = array_merge($gol1, $gol2);
      $mergeAll = array_merge($merge, $gol3);
      $data['gol'] = $mergeAll;
    }

    $data['pekerjaan'] = $this->M_penyerahan->getPekerjaan(substr($data['data'][0]['kodesie'], 0, 7));
    $data['tpribadi'] = $this->M_penyerahan->getTpribadi($noind, $field = 'pidgin_account, email_internal');

    $data['tempat_makan'] = $this->M_penyerahan->getTempatMakan();
    $data['lokasi'] = $this->M_penyerahan->getLokasi();
    $data['kantor'] = $this->M_penyerahan->getKantor();
    $data['shift'] = $this->M_penyerahan->getShift();
    $data['jurusan'] = $this->M_penyerahan->getjurusan();
    $sekul = $this->M_penyerahan->getSkul();
    $univ = $this->M_penyerahan->getUniv();
    $data['skul'] = array_merge($sekul, $univ);
    $data['kodejabatan'] = $this->dabes->query("SELECT kd_jabatan, upper(jabatan) as jabatan from hrd_khs.torganisasi order by kd_jabatan")->result_array();

    $kode_induk = substr($explode[1], 0, 1);
    if ($kode_induk == 'B' || $kode_induk == 'J' || $kode_induk == 'L') {
      $data['jabatan_upah'] = $this->dabes->query("SELECT kd_jabatan as kd_upah, nama_jabatan from hrd_khs.tb_master_jab where tgl_tberlaku = '9999-12-31 00:00:00'")->result_array();
    } else {
      $data['jabatan_upah'] = $this->M_penyerahan->getJabatanUpah($kode_induk);
    }

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('ADMSeleksi/Penyerahan/V_Edit', $data);
    $this->load->view('V_Footer', $data);
  }

  public function saveEditPenyerahan()
  {
    require_once(APPPATH . 'controllers/ADMSeleksi/Openfire/Openfire.php');
    require_once(APPPATH . 'controllers/ADMSeleksi/Zimbra/Zimbra.php');

    $noind      = $_POST['input_noind_baru_SP'];
    $jenis      = $_POST['slc_pkj_SP'];
    $kodesie    = $_POST['inpKodesie_SP'];
    $kantor     = $_POST['slc_kantor_SP'];
    $loker      = $_POST['slc_loker_SP'];
    $ruang      = $_POST['txt_ruang_SP'];
    $tmp_makan  = $_POST['slc_makan_SP'];
    $shift      = $_POST['txt_Shift_SP'];
    $kd_pkj     = $_POST['inpt_pekerjaan'];
    $nama       = $_POST['def_Nama_pkj'];
    $agama      = $_POST['inp_Agama_SP'];
    $jenkel     = $_POST['inp_jenkel_SP'];
    $tmp_lahir  = $_POST['txtLokasi_Lahir'];
    $tgl_lahir  = $_POST['inp_tgl_lahir'];
    $status     = $_POST['txt_status_pri'];
    $nik        = $_POST['txtNIK_SP'];
    $no_kk      = $_POST['txt_noKK_SP'];
    $pendidikan = $_POST['txtPend_SP'];
    $sekolah    = $_POST['txtSkul_SP'];
    $jurusan    = $_POST['txtJurusan_SP'];
    $alamat     = $_POST['txt_alamat_SP'];
    $prop       = $_POST['txt_Prov_SP'];
    $kab        = $_POST['txt_Kota_SP'];
    $kec        = $_POST['txtKec_SP'];
    $desa       = $_POST['txtDesa_SP'];
    $kodepos    = $_POST['inp_kodepos_SP'];
    $telpun     = $_POST['txt_noTlp_SP'];
    $no_hp      = $_POST['txt_noHP_SP'];
    $kd_jabatan = $_POST['txt_kd_jabatan_SP'];
    $jabatan    = $_POST['txt_jabatan_SP'];
    $jab_upah   = $_POST['slc_jab_upah'];
    $npwp       = $_POST['txtNPWP_SP'];
    $golongan   = $_POST['slc_gol_pkj_SP'];
    $kontrak_hubker = $_POST['txt_lama_kontrak'];
    $akt_seleksi    = $_POST['inp_tgl_angkat_SP'];
    $ori_hubker     = $_POST['txt_try_hubker'];
    $ik_hubker      = $_POST['txt_IK_hubker'];
    $tgl_pyrhn = date('Y-m-d', strtotime($_POST['txt_tgl_SP']));


    $Zimbra = new Zimbra;
    // email_address, email_display_name, email_password
    // :TODO verifiy that right email
    $email_address = $this->input->post('email_address');
    $email_display_name = $nama;
    $email_password = '123456';

    try {
      $Zimbra->createAccount($email_address, $email_password, $email_display_name);
      // add to mandatory distribution
      $Zimbra->email = $email_address;
      $Zimbra->addDistributions($Zimbra->mandatoryDistributions);
      $Zimbra->addRelatedDepartemenDistributions($kodesie, $loker);
      // if success code below will execute
      $email_internal = $email_address;
    } catch (Exception $e) {
      // What happen when error ?
      # :TODO
    }


    $pidgin_username = $this->input->post('pidgin_username');
    $Openfire = new Openfire;
    $domain = "@chat.quick.com";
    // pidgin_username, pidgin_name, pidgin_email, pidgin_password
    $pidgin_username = $this->input->post('pidgin_username'); // this from email
    $pidgin_email = $pidgin_username . $domain;
    $pidgin_name = $nama;
    $pidgin_password = '123456';

    try {
      $Openfire->createUser($pidgin_username, $pidgin_name, $pidgin_email, $pidgin_password);
      $pidgin_account = $pidgin_email;
    } catch (Exception $e) {
    }

    if ($jab_upah) {
      $explode_jabatan = explode('|', $jab_upah);
      $stat_jab_upah = array(
        'kd_jabatan'    => $explode_jabatan[0],
        'nama_jabatan'  => $explode_jabatan[1],
      );
      $this->M_penyerahan->updateStatusjabatan($stat_jab_upah, $noind);
    }

    if (intval($prop)) {
      $provinsi   = $this->M_pekerjakeluar->ambilProv($prop);
      $kabupaten  = $this->M_pekerjakeluar->ambilKab($kab);
      $kecamatan  = $this->M_pekerjakeluar->ambilKec($kec);
      $desa       = $this->M_pekerjakeluar->ambilDesa($desa);
    }

    //Insert into hrd_khs.tpribadi
    $jenis = $this->M_penyerahan->getNoJenisPenyerahan($jenis);
   
    if ($golongan == 'PKL1') {
      $masaPKL = '6';
    } elseif ($golongan == 'PKL2') {
      $masaPKL = '12';
    } elseif ($golongan == 'PKL3') {
      $masaPKL = '36';
    } else {
      $masaPKL = '';
    }
    if ($jenis == '13') {
        //kode Q
      $lamaPKL = $this->M_penyerahan->getLamaPKL($nama, $nik);
      $rlamaPKL = $lamaPKL['kontrak_os'];
      if (!empty($rlamaPKL)) {
        $rlamaPKL = explode(' ', $rlamaPKL)[0];
        if (is_numeric($rlamaPKL) && $rlamaPKL != '') {
          $masaPKL = $rlamaPKL;
        }
      }
      if (!empty($masaPKL)) {
        $tgl_keluar     = date('Y-m-d', strtotime("+" . $masaPKL . " months", strtotime($tgl_pyrhn)));
      } else {
        $tgl_keluar     = date('Y-m-d', strtotime("+1 months", strtotime($tgl_pyrhn)));
      }
      $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
      $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
      $lama_kontrak = '';
    } elseif ($jenis == '7') {
      if ($masaPKL) {
        $tgl_keluar     = date('Y-m-d', strtotime("+" . $masaPKL . " months", strtotime($tgl_pyrhn)));
      } else {
        $tgl_keluar     = date('Y-m-d', strtotime("+1 months", strtotime($tgl_pyrhn)));
      }
      $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
      $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
      $lama_kontrak = '';
    } elseif ($jenis == '8') {
      $akhir_kontrak  = date('Y-m-d', strtotime("+6 months", strtotime($tgl_pyrhn)));
      $tgl_keluar     = date('Y-m-d', strtotime("+1 days", strtotime($akhir_kontrak)));
      $tgl_selesai_pkl = $akhir_kontrak;
      $lama_kontrak = '';
    } elseif ($jenis == '4' || $jenis == '5' || $jenis == '11' || $jenis == '15') {
      $tgl_keluar     = date('Y-m-d', strtotime("+" . $kontrak_hubker . " months", strtotime($akt_seleksi)));
      $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
      $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
      $lama_kontrak = $kontrak_hubker;
    } else { //1, 2, 3, 6, 7, 9, 10, 12, 14, 16
      $tgl_keluar     = date('Y-m-d', strtotime("+" . $kontrak_hubker . " months", strtotime($tgl_pyrhn)));
      $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
      $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
      $lama_kontrak = $kontrak_hubker;
    }

    //Update hrd_khs.tpribadi
    $pribadi = array(
      'kantor_asal'   => $kantor,
      'lokasi_kerja'  => $loker,
      'ruang'         => $ruang,
      'tempat_makan'  => $tmp_makan,
      'nama'          => $nama,
      'agama'         => $agama,
      'jenkel'        => $jenkel,
      'templahir'     => $tmp_lahir,
      'tgllahir'      => $tgl_lahir,
      'statnikah'     => $status,
      'nik'           => $nik,
      'no_kk'         => $no_kk,
      'pendidikan'    => $pendidikan,
      'sekolah'       => ucwords(strtoupper($sekolah)),
      'jurusan'       => $jurusan,
      'alamat'        => $alamat,
      'prop'          => (intval($prop)) ? $provinsi : $prop,
      'kab'           => (intval($kab)) ? $kabupaten : $kab,
      'kec'           => (intval($kec)) ? $kecamatan : $kec,
      'desa'          => (intval($desa)) ? $desa : $desa,
      'kodepos'       => $kodepos,
      'telepon'       => $telpun,
      'nohp'          => $no_hp,
      'npwp'          => $npwp,
      'kd_jabatan'    => $kd_jabatan,
      'jabatan'       => $jabatan,
      'diangkat'      => $akt_seleksi,
      'masukkerja'    => date('Y-m-d', strtotime($tgl_pyrhn)),
      'lmkontrak'     => $lama_kontrak,
      'akhkontrak'    => $akhir_kontrak,
      'tglkeluar'     => $tgl_keluar,
      'golkerja'      => $golongan,
      'kd_pkj'        => $kd_pkj,
      'pidgin_account'        => $pidgin_username,
      'email_internal'        => $email_address
    );
    $this->M_penyerahan->updateTpribadi($pribadi, $noind);

    //Update "Surat".tsurat_penyerahan
    $surat_penyerahan = array(
      'asal_sekolah'      => ucwords(strtoupper($sekolah)),
      'ruang'             => $ruang,
      'tgl_masuk'         => date('Y-m-d', strtotime($tgl_pyrhn)),
      'tgl_selesai_pkl'   => $tgl_selesai_pkl,
      'tgl_mulaiik'       => $ik_hubker ? $ik_hubker : date('Y-m-d', strtotime('1900-01-01')),
      'lama_trainee'      => $ori_hubker ? $ori_hubker : '0',
      'lama_kontrak'      => $kontrak_hubker ? $kontrak_hubker : '0',
      'gol'               => $golongan
    );
    $this->M_penyerahan->updateTSuratPenyerahan($surat_penyerahan, $noind);

    //Update "Presensi".tpolapernoind
    $this->M_penyerahan->updatePolaNoind($noind, $shift, $kodesie);

    //Tidak update hrd_khs.trefjabatan
    //Tidak update ""Adm_Seleksi"".tb_pekerja_diangkat_versi_seleksi
    //Tidak update "FrontPresensi.ttmppribadi

    //Update "Presensi".tshiftpekerja
    //Di generate berdasarkan sisa hari di bulan berjalan terhitung dari tanggal masuk
    if ($jenis != '6') { // jika bukan TKPW / noind G
      $arTshiftPekerja = array();
      $tanggal = array();
      $akhir_bulan = date('t', strtotime($tgl_pyrhn));
      $tgl_serahin = date('d', strtotime($tgl_pyrhn));
      $hasil = false;
      $noind_baru = $this->dabes->query("SELECT noind_baru from hrd_khs.tpribadi where noind = '$noind'")->row()->noind_baru;
      while (!$hasil) {
        if ($tgl_serahin != $akhir_bulan) {
          array_push($tanggal, date('Y-m-') . $tgl_serahin);
        } else {
          array_push($tanggal, date('Y-m-') . $tgl_serahin);
          $hasil = true;
        }
        $tgl_serahin++;
      }
      foreach ($tanggal as $key) {
        $libur = $this->M_penyerahan->getTlibur($key);
        $hari = date('l', strtotime($key));
        if ($hari == 'Sunday') {
          $num = '1';
        } else if ($hari == 'Monday') {
          $num = '2';
        } else if ($hari == 'Tuesday') {
          $num = '3';
        } else if ($hari == 'Wednesday') {
          $num = '4';
        } else if ($hari == 'Thursday') {
          $num = '5';
        } else if ($hari == 'Friday') {
          $num = '6';
        } else {
          $num = '7';
        }
        $dataShift = $this->M_penyerahan->getDataShift($shift, $num);
        foreach ($dataShift as $value) {
          $cekShiftPekerja = $this->M_penyerahan->cekPekerjaDalamShift($key, $noind, $kodesie);
          if (empty($cekShiftPekerja)) {
            if (!$libur) {
              $arTshiftPekerja = array(
                'tanggal'           => $key,
                'noind'             => $noind,
                'kd_shift'          => $value['kd_shift'],
                'kodesie'           => $kodesie,
                'tukar'             => '0',
                'jam_msk'           => $value['jam_msk'],
                'jam_akhmsk'        => $value['jam_akhmsk'],
                'jam_plg'           => $value['jam_plg'],
                'break_mulai'       => $value['break_mulai'],
                'break_selesai'     => $value['break_selesai'],
                'ist_mulai'         => $value['ist_mulai'],
                'ist_selesai'       => $value['ist_selesai'],
                'jam_kerja'         => $value['jam_kerja'],
                'user_'             => $this->session->user,
                'noind_baru'        => $noind_baru
              );
              $this->M_penyerahan->insertTshiftPekerja($arTshiftPekerja);
            }
          } else {
            $arTshiftPekerja = array(
              'kd_shift'          => $value['kd_shift'],
              'jam_msk'           => $value['jam_msk'],
              'jam_akhmsk'        => $value['jam_akhmsk'],
              'jam_plg'           => $value['jam_plg'],
              'break_mulai'       => $value['break_mulai'],
              'break_selesai'     => $value['break_selesai'],
              'ist_mulai'         => $value['ist_mulai'],
              'ist_selesai'       => $value['ist_selesai'],
              'jam_kerja'         => $value['jam_kerja'],
              'user_'             => $this->session->user,
            );
            $this->M_penyerahan->updateTshiftPekerja(
              //data
              $value['kd_shift'],
              $value['jam_msk'],
              $value['jam_akhmsk'],
              $value['jam_plg'],
              $value['break_mulai'],
              $value['break_selesai'],
              $value['ist_mulai'],
              $value['ist_selesai'],
              $value['jam_kerja'],
              $this->session->user,
              //where
              $key,
              $noind,
              $kodesie
            );
            if ($libur) {
              $this->M_penyerahan->deleteShiftAhad($key, $noind);
            }
          }
        }
      }
    }
    echo "<script>window.close()</script>";
  }

  public function previewPDF()
  {
    $kode = $this->input->get('pekerja');
    $kepada = $this->input->get('kepada');
    $no_tgl = $this->input->get('tgl_serah');
    $no_kodesie = $this->input->get('kodesie');
    $data['petugas'] = $this->input->get('petugas');
    $approval = $this->input->get('approve');
    $data['petugas2'] = $this->input->get('petugas2');
    $data['tgl_cetak'] = $this->input->get('tgl_cetak');
    $jenis = $this->input->get('jenis');

    $implode = str_replace(",", "', '", $kode);
    $jenis_pekerja = $this->dabes->query("SELECT jenis from \"Surat\".tnoind_penyerahan where no_jenis = '$jenis'")->row()->jenis;
    $explode_jenis = explode('] ', $jenis_pekerja);
    $data['jenis'] = $explode_jenis[1];
    $allinOne = explode('[', $explode_jenis[0]);
    $data['allinOne'] = $jenis;
    $data['approval'] = $this->dabes->query("SELECT trim(a.nama) as nama, (select jabatan from hrd_khs.trefjabatan where noind = a.noind and kodesie = a.kodesie and kd_jabatan = a.kd_jabatan) as jabatan FROM hrd_khs.tpribadi a where a.noind = '$approval' and keluar = '0'")->result_array();
    $data['cekData'] = $this->M_penyerahan->getDetailPreview($implode);
    $data['terbilang'] = $this->terbilang(count($data['cekData']));
    $explode = explode('|', $kepada);
    $kodesie = $explode[0];
    $kd_jabatan = $explode[1];
    $find_kepada = $this->M_penyerahan->getAtasanDetail($kd_jabatan, $kodesie);
    $panjang = strlen($find_kepada);
    $cek_min = substr($find_kepada, $panjang - 1, $panjang);
    if ($cek_min == '-') {
      $cari_belakangnya = $this->M_penyerahan->getJabatanPreview($kodesie);
      $data['kepada'] = substr($find_kepada, 0, $panjang - 1) . $cari_belakangnya;
    } else {
      $data['kepada'] = $find_kepada;
    }
    $tembusan = $this->personalia->tembusan($kd_jabatan, $kodesie, $data['cekData'][0]['lokasi_kerja']);
    $data['tembusan'] = $tembusan;
    $bulanan = date('Ym', strtotime($no_tgl));

    $a = array();
    $noind = array();
    foreach ($data['cekData'] as $key) {
      $a[] = $key['nokeb'];
      $noind[] = $key['noind'];
    }
    $a = array_unique($a);

    $data['lampiran'] = $this->M_penyerahan->getDataLampiran(implode("', '", $a), implode("', '", $noind));
    $no_surat = $this->M_penyerahan->cekNo_Sp($implode, $bulanan);

    if (empty($no_surat)) {
      $cek_noSurat = $this->M_penyerahan->cekNo_Surat($bulanan, $data['kepada'], $jenis_pekerja, $implode);
      if (!empty($cek_noSurat)) {
        $no_surat = $cek_noSurat[0]['no_surat'];
        ($no_surat == '000' || $no_surat == null || $no_surat == '' || empty($no_surat)) ? $no_surat = '001' : $no_surat;
        $this->M_penyerahan->updateNoSurat($no_surat, $implode, $bulanan);
      } else {
        $cekcek = $this->M_penyerahan->getNoSurat2($bulanan);
        $no_surat = str_pad($cekcek, 3, 0, 0);
        ($no_surat == '000' || $no_surat == null || $no_surat == '' || empty($no_surat)) ? $no_surat = '001' : $no_surat;
        $set_noSurat = array(
          'no_surat'  => $no_surat,
          'hal_surat' => 'PS',
          'kd_surat'  => 'KI-C',
          'bulan'     => $bulanan,
          'tujuan'    => $data['kepada'],
          'tgl_cetak' => date('Y-m-d')
        );
        $this->M_penyerahan->insertNomorSurat($set_noSurat);
        $this->M_penyerahan->updateNoSurat($no_surat, $implode, $bulanan);
      }
      $data['no_surat'] = $no_surat . '/PS/KI-C/' . date('m/y', strtotime($no_tgl));
    } else {
      if ($no_surat == '000' || $no_surat == null || $no_surat == '' || empty($no_surat)) {
        $no_surat = '001';
        $this->M_penyerahan->updateNomorTSurat($bulanan);
      }
      $this->M_penyerahan->updateNoSurat($no_surat, $implode, $bulanan);
      $data['no_surat'] = $no_surat . '/PS/KI-C/' . date('m/y', strtotime($no_tgl));
    }

    $this->load->library('pdf');
    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8', 'A4', 11, 11, 11, 11, 20, 8);
    $filename = 'Surat Penyerahan ' . date('Ymd') . '.pdf';
    $pdf->AddPage('P');
    $html = $this->load->view('ADMSeleksi/Penyerahan/V_Cetak', $data, true);
    $pdf->WriteHTML($html, 2);
    $pdf->AddPage('L');
    $html1 = $this->load->view('ADMSeleksi/Penyerahan/V_lampiran', $data, true);
    $pdf->WriteHTML($html1, 2);
    $pdf->setTitle($filename);
    $pdf->Output($filename, 'I');
  }

  //-----------------------------------------------------Terbilang-------------------------------------------------------//
  function penyebut($nilai)
  {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
      $temp = $this->penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
      $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . $this->penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . $this->penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
  }

  function terbilang($nilai)
  {
    if ($nilai < 0) {
      $hasil = "minus " . trim($this->penyebut($nilai));
    } else {
      $hasil = trim($this->penyebut($nilai));
    }
    return $hasil;
  }
  //------------------------------------------------Selesai Terbilang--------------------------------------------------------//

  //Function untuk Create
  public function index_create()
  {
    $data     =    $this->general->loadHeaderandSidemenu('ADM Seleksi - Quick ERP', 'Create Surat Penyerahan', 'Surat Penyerahan');

    $data['kodesie'] = $this->M_penyerahan->getKodesie();
    $data['tempat_makan'] = $this->M_penyerahan->getTempatMakan();
    $data['lokasi'] = $this->M_penyerahan->getLokasi();
    $data['kantor'] = $this->M_penyerahan->getKantor();
    $data['shift'] = $this->M_penyerahan->getShift();
    $data['jurusan'] = $this->M_penyerahan->getjurusan();
    $sekul = $this->M_penyerahan->getSkul();
    $univ = $this->M_penyerahan->getUniv();
    $data['skul'] = array_merge($sekul, $univ);
    $data['approval'] = $this->M_penyerahan->getApproval();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('ADMSeleksi/Penyerahan/V_Create', $data);
    $this->load->view('V_Footer', $data);
  }

  public function kodesie()
  {
    $keyword           = $this->input->post('kodesie');
    $data['kodesie']  = $this->M_penyerahan->getKodesie($keyword);
    $data['kerja']    = $this->M_penyerahan->getPekerjaan(substr($keyword, 0, 7));
    echo json_encode($data);
  }

  public function getPekerjaan()
  {
    $kode = $this->input->post('kode');
    $now = date('Y-01-01');
    $tahun = date('Ym', strtotime('-1 years', strtotime($now)));
    $data['butuh'] = $this->M_penyerahan->getKebutuhan($kode, $tahun);
    echo json_encode($data);
  }

  public function getJabatan()
  {
    $kd = $this->input->post('kd');
    $kodesie = $this->input->post('kodesie');
    $seksi = $this->M_penyerahan->getSeksiCoallesce($kodesie);
    $jabatan = $this->dabes->query("SELECT trim(jabatan) as jabatan from hrd_khs.torganisasi where kd_jabatan='$kd'")->row()->jabatan;
    $data = ucwords(strtoupper($jabatan)) . " " . $seksi;

    echo json_encode($data);
  }

  public function getDataPekerja()
  {
    $jenis = $this->input->get('jenis');
    $kode = $this->input->get('kode');
    $text = $this->input->get('term');
    $now = date('Y-01-01');
    $trigger_tahun = date('Ym', strtotime('-1 years', strtotime($now)));
    $text_upper = ucwords(strtoupper($text));
    if ($jenis == '1') {
      $data = $this->M_penyerahan->getDataPekerjaBaruSP($kode, $text_upper, $trigger_tahun);
    } else {
      $data = $this->M_penyerahan->getDataPekerjaSP($text_upper, $trigger_tahun);
    }

    echo json_encode($data);
  }

  // public function getSudahDiserahkan()
  // {
  //     $kode = $this->input->post('kode');
  //     $ruang_lingkup = $this->input->post('lingkup');
  //     $kodesie = $this->input->post('kodesie');
  //     $data['pkj'] = $this->M_penyerahan->ambilDataSudahDiserahkan($kode, $ruang_lingkup, $kodesie);
  //     $data['tempat_makan'] = $this->M_penyerahan->getTempatMakan();
  //     $data['lokasi'] = $this->M_penyerahan->getLokasi();
  //     $data['kantor'] = $this->M_penyerahan->getKantor();
  //     $data['shift'] = $this->M_penyerahan->getShift();
  //     $data['jurusan'] = $this->M_penyerahan->getjurusan();
  //     $sekul = $this->M_penyerahan->getSkul();
  //     $univ = $this->M_penyerahan->getUniv();
  //     $data['skul'] = array_merge($sekul, $univ);
  //     $data['pemborong'] = $this->M_penyerahan->getPemborong();

  //     echo json_encode($data);
  // }

  /**
   * Refactor by DK
   * 
   * What this function do ? :
   * - Insert hrd_khs.tb_status_jabatan
   * - Create Email account|optional
   * - Create Pidgin accoung|optional
   * - Insert hrd_khs.tpribadi
   * - Insert "Surat".tsurat_penyerahan
   * - Insert "Adm_Seleksi".tb_pekerja_diangkat_versi_seleksi
   * - Insert "Presensi".tshiftpekerja
   * - Insert "Presensi".tpolapernoind'
   * - Insert hrd_khs.trefjabatan
   * - Insert "FrontPresensi".ttmppribadi'
   * 
   * This execute by Ajax Request
   */
  public function saveDataPenyerahan()
  {
    # Load class for create pidgin account
    require_once(APPPATH . 'controllers/ADMSeleksi/Openfire/Openfire.php');
    # Load class for create email account
    require_once(APPPATH . 'controllers/ADMSeleksi/Zimbra/Zimbra.php');

    $jenis_pkj      = $this->input->post('jenis_pkj');
    //Data Diri
    $nama           = $this->input->post('nama');
    $agama          = $this->input->post('agama');
    $jenkel         = $this->input->post('jenkel');
    $tmp_lahir      = $this->input->post('tmp_lhr');
    $tgl_lhr        = $this->input->post('tgl_lhr');
    $status         = $this->input->post('status');
    $nik            = $this->input->post('nik');
    $npwp           = $this->input->post('npwp');
    $no_kk          = $this->input->post('no_kk');
    $pendidikan     = $this->input->post('pend');
    $skul           = $this->input->post('skul');
    $jurusan        = $this->input->post('jurusan');
    $alamat         = $this->input->post('alamat');
    $prov           = $this->input->post('prov');
    $kab            = $this->input->post('kab');
    $kec            = $this->input->post('kec');
    $desa           = $this->input->post('desa');
    $kd_pos         = $this->input->post('kd_pos');
    $no_tlp         = $this->input->post('no_tlp');
    $no_hp          = $this->input->post('no_hp');
    $status         = $this->input->post('nikah');
    //Data Perusahaan
    $tgl_sls_magang = $this->input->post('sls_magang'); # unused
    $kelas          = $this->input->post('kelas');
    $otsorcing      = $this->input->post('otsorcing');
    $tgl_pyrhn      = $this->input->post('txt_tgl_SP');
    $golongan       = $this->input->post('golongan');
    $jenis          = $this->input->post('jenis');
    $ruang_lingkup  = $this->input->post('ruang_lingkup');
    $kode_induk     = $this->input->post('kode');
    $kodesie        = $this->input->post('kodesie');
    $pekerjaan      = $this->input->post('pekerjaan');
    $tempat_kerja   = $this->input->post('tempat'); # unused
    $noind          = $this->input->post('noind');
    $kantor         = $this->input->post('kantor');
    $loker          = $this->input->post('loker');
    $ruang          = $this->input->post('ruang');
    $no_keb         = $this->input->post('no_keb');
    $kd_lamaran     = $this->input->post('kd_lmrn');
    $tmp_makan      = $this->input->post('tmp_mkn');
    $shift          = $this->input->post('shift');
    $kd_jabatan     = $this->input->post('kd_jabatan');
    $jabatan        = $this->input->post('jabatan');
    $kd_jab_hubker  = $this->input->post('kd_hubker');
    $stat_jab       = $this->input->post('status_jabatan');
    $jabatan_upah   = $this->input->post('jabatan_upah');
    //Data Hubker
    $ori_hubker     = $this->input->post('ori_hubker');
    $kontrak_hubker = $this->input->post('kontrak_hubker');
    $ik_hubker      = $this->input->post('ik_hubker');
    //Data Seleksi
    $ori_seleksi    = $this->input->post('ori_seleksi');
    $akt_seleksi    = $this->input->post('akt_seleksi');
    $masaPKL        = $this->input->post('MasaPKL');

    $tseksi         = $this->M_penyerahan->getKodesie($kodesie);
    $maxNoindBaru   = $this->M_penyerahan->getMaxNoindBaru();
    $jenis_pkj      = $this->M_penyerahan->getJenisPenyerahan($jenis);
    $noind_baru     = str_pad($maxNoindBaru + 1, 7, 0, '0');
    $kode_SP        = $this->M_penyerahan->getMaxCode();

    if (intval($prov)) {
      $prov   = $this->M_pekerjakeluar->ambilProv($prop);
    }
    if (intval($kab)) {
      $kab  = $this->M_pekerjakeluar->ambilKab($kab);
    }
    if (intval($kec)) {
      $kec  = $this->M_pekerjakeluar->ambilKec($kec);
    }
    if (intval($desa)) {
      $desa       = $this->M_pekerjakeluar->ambilDesa($desa);
    }

    //Insert tb_status_jabatan
    $nomoran = array(
      '01',
      '02'
    );

    try {
      $exJab = explode('|', $jabatan_upah);
      foreach ($nomoran as $nom) {
        $arrayStatusJab = array(
          'noind'         => $noind,
          'nama'          => $nama,
          'kd_jabatan'    => ($jabatan_upah) ? $exJab[0] : '',
          'nama_jabatan'  => ($jabatan_upah) ? $exJab[1] : '',
          'kd_status'     => $kd_jab_hubker,
          'nama_status'   => $stat_jab,
          'tgl_berlaku'   => date('Y-m-d 00:00:00'),
          'tgl_tberlaku'  => $nom == '01' ? date('Y-m-d 00:00:00') : '9999-12-31 00:00:00',
          'noind_baru'    => $noind_baru,
          'status_data'   => $nom,
        );
        $this->M_penyerahan->insertToStatusJabatan($arrayStatusJab);
      }

      // Insert into hrd_khs.tpribadi
      if ($jenis == '13') {
        //kode Q
        $lamaPKL = $this->M_penyerahan->getLamaPKL($nama, $nik);
        $rlamaPKL = $lamaPKL['kontrak_os'];
        if (!empty($rlamaPKL)) {
          $rlamaPKL = explode(' ', $rlamaPKL)[0];
          if (is_numeric($rlamaPKL) && $rlamaPKL != '') {
            $masaPKL = $rlamaPKL;
          }
        }

        if (!empty($masaPKL) && $masaPKL > 0) {
          $tgl_keluar     = date('Y-m-d', strtotime("+" . $masaPKL . " months", strtotime($tgl_pyrhn)));
        } else {
          $tgl_keluar     = date('Y-m-d', strtotime("+1 months", strtotime($tgl_pyrhn)));
        }

        $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
        $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
        $lama_kontrak = '';
      } elseif ($jenis == '7') {
        if ($masaPKL) {
          $tgl_keluar     = date('Y-m-d', strtotime("+" . $masaPKL . " months", strtotime($tgl_pyrhn)));
        } else {
          $tgl_keluar     = date('Y-m-d', strtotime("+1 months", strtotime($tgl_pyrhn)));
        }
        $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
        $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
        $lama_kontrak = '';
      } elseif ($jenis == '8') {
        $akhir_kontrak  = date('Y-m-d', strtotime("+6 months", strtotime($tgl_pyrhn)));
        $tgl_keluar     = date('Y-m-d', strtotime("+1 days", strtotime($akhir_kontrak)));
        $tgl_selesai_pkl = $akhir_kontrak;
        $lama_kontrak = '';
      } elseif ($jenis == '4' || $jenis == '5' || $jenis == '11' || $jenis == '15') {
        $tgl_keluar     = date('Y-m-d', strtotime("+" . $kontrak_hubker . " months", strtotime($akt_seleksi)));
        $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
        $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
        $lama_kontrak = $kontrak_hubker;
      } else { //1, 2, 3, 6, 7, 9, 10, 12, 14, 16
        $tgl_keluar     = date('Y-m-d', strtotime("+" . $kontrak_hubker . " months", strtotime($tgl_pyrhn)));
        $akhir_kontrak  = date('Y-m-d', strtotime("-1 days", strtotime($tgl_keluar)));
        $tgl_selesai_pkl = date('Y-m-d', strtotime('1900-01-01'));
        $lama_kontrak = $kontrak_hubker;
      }

      /**
       * --------------------------------------
       * Handle create Email(Zimbra) Account
       * --------------------------------------
       */
      $isEmailChecked = !empty($this->input->post('create_email_account'));
      $email_internal = null;
      if ($isEmailChecked) {
        $Zimbra = new Zimbra;
        // email_address, email_display_name, email_password
        // :TODO verifiy that right email
        $email_address = $this->input->post('email_address');
        $email_display_name = $this->input->post('email_display_name');
        $email_password = $this->input->post('email_password');

        try {
          $Zimbra->createAccount($email_address, $email_password, $email_display_name);
          // add to mandatory distribution
          $Zimbra->email = $email_address;
          $Zimbra->addDistributions($Zimbra->mandatoryDistributions);
          $Zimbra->addRelatedDepartemenDistributions($kodesie, $loker);
          // if success code below will execute
          $email_internal = $email_address;
        } catch (Exception $e) {
          // What happen when error ?
          # :TODO
        }
      }

      /**
       * -------------------------------
       * Handle create Pidgin Account
       * -------------------------------
       */
      $isPidginChecked = !empty($this->input->post('create_pidgin_account'));
      $pidgin_account = null;
      if ($isPidginChecked) {
        $Openfire = new Openfire;
        $domain = "@chat.quick.com";
        // pidgin_username, pidgin_name, pidgin_email, pidgin_password
        $pidgin_username = $this->input->post('pidgin_username'); // this from email
        $pidgin_email = $pidgin_username . $domain;
        $pidgin_name = $this->input->post('pidgin_name');
        $pidgin_password = $this->input->post('pidgin_password');

        # Group in KHS
        // $khs_group = "KHS GROUP";

        try {
          $Openfire->createUser($pidgin_username, $pidgin_name, $pidgin_email, $pidgin_password);
          // $Openfire->addUserToGroup($pidgin_username, $khs_group); // this replaced by default setting on openfire server
          // if success code below will execute
          $pidgin_account = $pidgin_email;
        } catch (Exception $e) {
          // What happen when error ?
          # :TODO
        }
      }

      // This will be not null if process on pidgin or email is done
      if ($pidgin_account || $email_internal) {
        $receiverEmail = "rheza_egha@quick.com"; // Kasie IT - Hardware
        $applicationName = "ADM Seleksi - Surat Penyerahan";
        $subject = "Sistem ERP - Akun Pidgin/Email Baru Telah Dibuat";
        $receiverName = "Bp. Rheza";
        $createdFor = $noind . " - " . $nama;
        $creator = $this->session->user . " - " . $this->session->employee;

        $accountContent = [];

        // load component html
        if ($email_internal) {
          array_push($accountContent, [
            'title' => 'Email',
            'username' => $email_display_name,
            'password' => $email_password,
            'email' => $email_internal,
            'accountLink' => '#'
          ]);
        }

        // load component html
        if ($pidgin_account) {
          array_push($accountContent, [
            'title' => 'Pidgin',
            'username' => $pidgin_username,
            'password' => $pidgin_password,
            'email' => $pidgin_email,
            'accountLink' => 'http://chat.quick.com:9090/user-properties.jsp?username=' . $pidgin_username
          ]);
        }

        $bodyHTML = $this->load->view('ADMSeleksi/Penyerahan/Email/Template/NewAccountNotification', compact([
          'receiverName',
          'applicationName',
          'createdFor',
          'creator',
          'accountContent',
        ]), true);

        // prevent displaying errors, so we use try catch
        try {
          $this->sendEmail($receiverEmail, $subject, $bodyHTML);

          // email backup
          $this->sendEmail('backup_mail@quick.com', $subject, $bodyHTML);
        } catch (Exception $e) {
        }
      }

      $dataPribadi = array(
        'noind'             => $noind,
        'nama'              => ucwords(strtoupper($nama)),
        'templahir'         => $tmp_lahir,
        'tgllahir'          => $tgl_lhr,
        'jenkel'            => $jenkel,
        'agama'             => $agama,
        'alamat'            => $alamat,
        'prop'              => $prov,
        'kab'               => $kab,
        'kec'               => $kec,
        'desa'              => $desa,
        'kodepos'           => $kd_pos,
        'telepon'           => $no_tlp,
        'statnikah'         => $status,
        'nohp'              => $no_hp,
        'pendidikan'        => ucwords(strtoupper($pendidikan)),
        'sekolah'           => ucwords(strtoupper($skul)),
        'jurusan'           => ucwords(strtoupper($jurusan)),
        'kodesie'           => $kodesie,
        'golkerja'          => $golongan,
        'asal_outsourcing'  => $otsorcing == null ? '-' : $otsorcing,
        'diangkat'          => $akt_seleksi,
        'masukkerja'        => date('Y-m-d', strtotime($tgl_pyrhn)),
        'lmkontrak'         => $lama_kontrak,
        'akhkontrak'        => $akhir_kontrak,
        'tglkeluar'         => $tgl_keluar,
        'tempat_makan'      => $tmp_makan,
        'tempat_makan1'     => $tmp_makan,
        'tempat_makan2'     => $tmp_makan,
        'lokasi_kerja'      => $loker,  //tambahan
        'kantor_asal'       => $kantor, //tambahan
        'ruang'             => $ruang,
        'nokeb'             => $no_keb,
        'ganti'             => $jenis_pkj == 'checked' ? 't' : 'f',
        'kd_pkj'            => $pekerjaan,
        'nik'               => $nik,
        'npwp'              => $npwp, //tambahan
        'no_kk'             => $no_kk,
        'noind_baru'        => $noind_baru,
        'kd_jabatan'        => $kd_jabatan, //tambahan
        'jabatan'           => $jabatan, //tambahan
        'kode_status_kerja' => $kode_induk,
        'email_internal'    => $email_internal,
        'pidgin_account'    => $pidgin_account
      );

      $this->M_penyerahan->insertPribadi($dataPribadi);

      //Insert into "Surat".tSurat_Penyerahan
      $arTsuratPenyerahan = array(
        'kode'              => $kode_SP,
        'bulan'             => date('Ym', strtotime($tgl_pyrhn)),
        'noind'             => $noind,
        'nama'              => ucwords(strtoupper($nama)),
        'ruang_lingkup'     => ucfirst($ruang_lingkup),
        'kodesie'           => $kodesie,
        'tempat'            => ucwords(strtoupper($ruang_lingkup)) . ' ' . $tseksi[0]['seksi'],
        'kelas'             => $kelas,
        'tgl_masuk'         => date('Y-m-d', strtotime($tgl_pyrhn)),
        'tgl_selesai_pkl'   => $tgl_selesai_pkl,
        'tgl_mulaiik'       => $ik_hubker ? $ik_hubker : date('Y-m-d', strtotime('1900-01-01')),
        'lama_trainee'      => $ori_hubker ? $ori_hubker : '0',
        'lama_kontrak'      => $kontrak_hubker ? $kontrak_hubker : '0',
        'asal_sekolah'      => ucwords(strtoupper($skul)),
        'asal_outsorcing'   => $otsorcing == null ? '' : $otsorcing,
        'kodelamaran'       => $kd_lamaran,
        'status_angkat'     => 'f',
        'gol'               => $golongan,
        'ruang'             => $ruang,
        'cetak'             => 'f',
        'noind_baru'        => $noind_baru,
        'jenis_pkj'         => $jenis_pkj
      );
      $this->M_penyerahan->insertTSuratPenyerahan($arTsuratPenyerahan);

      //Insert into "Adm_Seleksi".tb_pekerja_diangkat_versi_seleksi
      $arPkjSeleksi = array(
        'noind'          => $noind,
        'noind_baru'     => $noind_baru,
        'tgl_masuk'      => date('Y-m-d', strtotime($tgl_pyrhn)),
        'lama_orientasi' => $ori_seleksi,
        'tgl_diangkat'   => ($akt_seleksi) ? $akt_seleksi : date('Y-m-d', strtotime('1900-01-01')),
        'lama_kontrak'   => '0',
        'tgl_keluar'     => date('Y-m-d', strtotime('9999-12-31'))
      );
      $this->M_penyerahan->insertPekerjaVersiSeleksi($arPkjSeleksi);

      //Insert into "Presensi".tshiftpekerja
      //Di generate berdasarkan sisa hari di bulan berjalan
      if ($jenis != '6') { // jika bukan TKPW / noind G
        $arTshiftPekerja = array();
        $tanggal = array();
        $akhir_bulan = date('t', strtotime($tgl_pyrhn));
        $now = date('d', strtotime($tgl_pyrhn));

        // to generate array of date from tgl penyerahan to end of that month
        // untuk membuat array yg berisi tanggal dari tgl penyerahan sampai tanggal akhir bulan tgl penyerahan
        $hasil = false;
        while (!$hasil) {
          array_push($tanggal, date('Y-m-', strtotime($tgl_pyrhn)) . $now);

          if ($now == $akhir_bulan) {
            $hasil = true;
          }
          $now++;
        }

        foreach ($tanggal as $key) {
          $libur = $this->M_penyerahan->getTlibur($key);
          $hari = date('l', strtotime($key));
          if ($hari == 'Sunday') {
            $num = '1';
          } else if ($hari == 'Monday') {
            $num = '2';
          } else if ($hari == 'Tuesday') {
            $num = '3';
          } else if ($hari == 'Wednesday') {
            $num = '4';
          } else if ($hari == 'Thursday') {
            $num = '5';
          } else if ($hari == 'Friday') {
            $num = '6';
          } else {
            $num = '7';
          }

          $dataShift = $this->M_penyerahan->getDataShift($shift, $num);

          foreach ($dataShift as $value) {
            $cekShiftPekerja = $this->M_penyerahan->cekPekerjaDalamShift($key, $noind, $kodesie);
            if (empty($cekShiftPekerja)) {
              if (!$libur) {
                $arTshiftPekerja = array(
                  'tanggal'           => $key,
                  'noind'             => $noind,
                  'kd_shift'          => $value['kd_shift'],
                  'kodesie'           => $kodesie,
                  'tukar'             => '0',
                  'jam_msk'           => $value['jam_msk'],
                  'jam_akhmsk'        => $value['jam_akhmsk'],
                  'jam_plg'           => $value['jam_plg'],
                  'break_mulai'       => $value['break_mulai'],
                  'break_selesai'     => $value['break_selesai'],
                  'ist_mulai'         => $value['ist_mulai'],
                  'ist_selesai'       => $value['ist_selesai'],
                  'jam_kerja'         => $value['jam_kerja'],
                  'user_'             => $this->session->user,
                  'noind_baru'        => $noind_baru
                );
                $this->M_penyerahan->insertTshiftPekerja($arTshiftPekerja);
              }
            }
          }
        }
      }

      //Insert into "Presensi".tpolapernoind
      $cekHariPola = date('l', strtotime(date('Y-m-01', strtotime("+1 months", strtotime($tgl_pyrhn)))));

      if ($cekHariPola == 'Sunday') {
        $tgl_lanjut = date('Y-m-02', strtotime("+1 months", strtotime($tgl_pyrhn)));
      } else {
        $tgl_lanjut = date('Y-m-01', strtotime("+1 months", strtotime($tgl_pyrhn)));
      }

      $arTpolaperNoind = array(
        'kodesie'       => $kodesie,
        'kodepola'      => '6',
        'pola_kombinasi' => '4',
        'noind'         => $noind,
        'shift_lanjut'  => '1',
        'tgl_lanjut'    => $tgl_lanjut,
        'user_'         => $this->session->user,
        'noind_baru'    => $noind_baru
      );

      $this->M_penyerahan->insertTpola($arTpolaperNoind);

      //Insert into hrd_khs.trefjabatan
      $arTref = array(
        'noind'         => $noind,
        'kodesie'       => $kodesie,
        'kd_jabatan'    => $kd_jabatan,
        'jabatan'       => $jabatan,
        'kd_jbt_dl'     => '-',
        'noind_baru'    => $noind_baru
      );

      $this->M_penyerahan->insertTrefjabatan($arTref);

      //Insert into "FrontPresensi".ttmppribadi
      $arTmpPribadi = array(
        'noind'         => $noind,
        'nama'          => ucwords(strtoupper($nama)),
        'kodesie'       => $kodesie,
        'dept'          => $tseksi[0]['dept'],
        'seksi'         => $tseksi[0]['seksi'],
        'pekerjaan'     => $tseksi[0]['pekerjaan'],
        'noind_baru'    => $noind_baru
      );

      $this->M_penyerahan->insertTtmpPribadi($arTmpPribadi);

      return response()->json([
        'success' => true,
        'message' => 'OK',
        'code' => 200
      ]);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'code' => 500
      ]);
    }
  }

  /**
   * To send email
   * 
   * @param String $destination Email destination or receiver
   * @param String $subject     Email Subject
   * @param String $bodyString  Email with string of HTML
   * 
   * @return Boolean
   */
  private function sendEmail($destination, $subject, $bodyString)
  {
    // Load Email Library
    $this->load->library('PHPMailerAutoload');
    $mail = new PHPMailer();
    $mail->SMTPDebug   = 0;
    $mail->Debugoutput = 'html';

    // Set Connection SMTP Mail
    $mail->isSMTP();
    $mail->Host        = 'm.quick.com';
    $mail->Port        = 465;
    $mail->SMTPAuth    = TRUE;
    $mail->SMTPSecure  = 'ssl';
    $mail->SMTPOptions = [
      'ssl' => [
        'verify_peer'       => FALSE,
        'verify_peer_name'  => FALSE,
        'allow_self_signed' => TRUE
      ]
    ];
    $mail->Username = 'no-reply@quick.com';
    $mail->Password = '123456';
    $mail->WordWrap = 50;

    $mail->setFrom('notification@quick.co.id', $subject);
    $mail->addAddress($destination);

    // Set Email Content
    $mail->IsHTML(TRUE);
    $mail->Subject = $subject;
    $mail->Body    = $bodyString;

    return $mail->send();
  }

  public function plusPekerja()
  {
    $form = $this->input->post('formUtama');
    $kode = '';
    $pekerja = '';
    $data['jenis'] = '';
    foreach ($form as $key => $value) {
      if ($value['name'] == 'inputKode') {
        $kode .= $value['value'];
      }
      if ($value['name'] == 'slc_pri_pkj_SP') {
        $pekerja .= $value['value'];
      }
      if ($value['name'] == 'input_Pekerja_SP') {
        $data['jenis'] .= $value['value'];
      }
      if ($value['name'] == 'slc_kodesie_SP') {
        $kodesie[] = $value['value'];
      }
      if ($value['name'] == 'slc_pkj_SP') {
        $jenis[] = $value['value'];
      }
    }

    if ($data['jenis'] == '1') {
      $data['pkj'] = $this->M_penyerahan->getDetailBerkas($pekerja);
    } else {
      $data['pkj'] = $this->M_penyerahan->getDetailPKJKHS($pekerja);
    }

    $data['noind'] = null;

    if ($kode == 'C') {
      $cabang = $this->M_penyerahan->getKodesie($kodesie[0]);
      $daerah = explode(' ', $cabang[0]['seksi']);

      $a = $daerah[1];
      if ($a == 'PERWAKILAN') {
        $a = $daerah[2];
      } elseif ($a == 'BANYUASIN') {
        $a = "TANJUNG";
      }

      if ($a == 'SURABAYA' || $a == 'BANJARMASIN' || $a == 'NGANJUK') {
        $digit = '0';
      } elseif ($a == 'MAKASSAR' || $a == 'SIDRAP' || $a == 'PALU') {
        $digit = '1';
      } elseif ($a == 'TANJUNG' || $a == 'TUGUMULYO' || $a == 'PADANG' || $a == 'JAMBI') {
        $digit = '2';
      } elseif ($a == 'JAKARTA' || $a == 'PONTIANAK') {
        $digit = '3';
      } elseif ($a == 'MEDAN' || $a == 'PEKANBARU') {
        $digit = '4';
      } elseif ($a == 'SAMPIT' || $a == 'SAMARINDA') {
        $digit = '5';
      } elseif ($a == 'SUBANG') {
        $digit = '6';
      }

      $kedua = '';
      if ($kodesie[0] == '209030100') {
        $kedua = '0';
      } else {
        if ($jenis[0] == '10') {
          $kedua = '1';
        } else if ($jenis[0] == '11') {
          $kedua = '2';
        } else if ($jenis[0] == '14') {
          $kedua = '3';
        } else {
          $kedua = '4';
        }
      }

      $noindTrig = 'C' . $digit . $kedua;
      $nom = $this->M_penyerahan->getNoindMaxC($noindTrig);
      if (empty($nom)) {
        $nom = $noindTrig . '00';
      }
      $noind = $nom;
      $is_exist = false;
      while (!$is_exist) {
        $cek = $this->M_penyerahan->cekNoind($noind);
        if ($cek) {
          $noind++;
        } else {
          $is_exist = true;
        }
      }
      $data['noind'] = $noind;
    } else {
      $noind = $this->M_penyerahan->getNoindMax($kode);
      $noind_cek = array(
        $noind[0]['new']
      );
      $find = false;
      $data['noind'] = null;

      $allNoind = $this->M_penyerahan->getNoindTpribadi($kode);
      while (!$find) {
        $noind_cek = array_values($noind_cek);
        $cek = in_array($noind_cek[0], $allNoind) ? false : true;
        if ($cek) {
          $data['noind'] = $noind_cek[0];
          $find = true;
        } else {
          $ada = substr($noind_cek[0], 1, 4);
          $plus = $ada + 1;
          $panjang = 4 - strlen($plus);
          if ($panjang != 0) {
            if ($plus >= '10000') {
              $nol = str_pad($plus, 5, 0, 0);
            } else {
              $nol = str_pad($plus, 4, 0, 0);
            }
          } else {
            $nol = $plus;
          }

          $real = $kode . $nol;
          unset($noind_cek[0]);
          array_push($noind_cek, $real);
        }
      }
    }

    $sekul = $this->M_penyerahan->getSkul();
    $univ = $this->M_penyerahan->getUniv();
    $data['skul'] = array_merge($sekul, $univ);
    $data['lokasi'] = $this->M_penyerahan->getLokasi();
    $data['kantor'] = $this->M_penyerahan->getKantor();
    $data['shift'] = $this->M_penyerahan->getShift();
    $data['jurusan'] = $this->M_penyerahan->getjurusan();
    $data['pemborong'] = $this->M_penyerahan->getPemborong();
    $data['tempat_makan'] = $this->M_penyerahan->getTempatMakan();
    $data['kodejabatan'] = $this->dabes->query("SELECT kd_jabatan, upper(jabatan) as jabatan from hrd_khs.torganisasi order by kd_jabatan")->result_array();
    $data['stat_jab'] = $this->M_penyerahan->getStatusJabatan($kode);
    if ($kode == 'B' || $kode == 'J' || $kode == 'L') {
      $data['jabatan_upah'] = $this->dabes->query("SELECT kd_jabatan as kd_upah, nama_jabatan from hrd_khs.tb_master_jab where tgl_tberlaku = '9999-12-31 00:00:00'")->result_array();
    } else {
      $data['jabatan_upah'] = $this->M_penyerahan->getJabatanUpah($kode);
    }
    echo json_encode($data);
  }

  public function getDataTable()
  {
    $kode    = $this->M_penyerahan->getJenisPenyerahan($_POST['kode']);
    $kodesie = $_POST['kodesie'];
    $tanggal = $_POST['tanggal'];
    $lingkup = $_POST['lingkup'];
    $data = $this->M_penyerahan->ambilDataAll($kodesie, $tanggal, $kode, $lingkup);

    $array = array();
    if ($data) {
      foreach ($data as $key) {
        $array[] = array(
          'noind' => $key['noind'],
          'nama'  => $key['nama'],
          'kodesie' => $key['kodesie'],
          'seksi' => $key['seksi'],
          'kode' => $key['kode'],
          'gabungan' => $key['kode'] . '|' . $key['noind'] . '|' . $tanggal . '|' . $key['noind_baru']
        );
      }
    }
    echo json_encode($array);
  }

  public function getKepada()
  {
    $kodesie = array(
      substr($_POST['kodesie'], 0, 3),
      str_pad(substr($_POST['kodesie'], 0, 1), 9, 0, 1)
    );
    $data = '';
    $pekerja = $_POST['pekerja'];
    $jenis = $_POST['jenis'];
    if ($pekerja) {
      $implode = implode("', '", $pekerja);
      $kd_jabatan = $this->M_penyerahan->getKdJabatan($implode);
      $data = $this->M_penyerahan->getKepada($kodesie, $kd_jabatan, $jenis, $_POST['kodesie']);
    }
    echo json_encode($data);
  }
}
