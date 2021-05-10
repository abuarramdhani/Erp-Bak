<?php defined('BASEPATH') or exit('No direct script access allowed');

class C_BapAkhirKerja extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('MasterPekerja/Surat/BapAkhirKerja/M_bapakhirkerja');
    $this->load->library('General');
    $this->load->library('Log_Activity');
    $this->load->library('Personalia');
    $this->load->library('encrypt');
    if (!($this->session->is_logged)) {
      redirect('');
    }
  }
  // Utilities
  public function konversitanggaladdhr($tanggal)
  {
    $kirim   =  date('l d F Y', strtotime($tanggal));
    $kirim   =  str_replace(
      array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
      ),
      array(
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      ),
      $kirim
    );
    $kirim   =  str_replace(
      array(
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ),
      array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
      ),
      $kirim
    );
    return $kirim;
  }
  public function convertToindoBln($tgl)
  {
    $kirim   =  str_replace(
      array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
      ),
      array(
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      ),
      $tgl
    );
    return $kirim;
  }
  public function index()
  {
    $data = $this->general->loadHeaderandSidemenu('BAP AKHIR KERJA - Master Pekerja - Quick ERP', 'BAP AKHIR KERJA', 'Surat', 'BAP AKHIR KERJA');
    $data['all_surat'] = $this->M_bapakhirkerja->getAllSuratBapAkhir();
    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Surat/BapAkhirKerja/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  public function create()
  {
    $data = $this->general->loadHeaderandSidemenu('BAP AKHIR KERJA - Master Pekerja - Quick ERP', 'BAP AKHIR KERJA', 'Surat', 'BAP AKHIR KERJA');
    $data['sebab_berakhir'] = $this->M_bapakhirkerja->getSebabBerakhir();
    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Surat/BapAkhirKerja/V_Create', $data);
    $this->load->view('V_Footer', $data);
  }

  public function update($id)
  {
    $id = $this->general->dekripsi($id);
    $data = $this->general->loadHeaderandSidemenu('BAP AKHIR KERJA - Master Pekerja - Quick ERP', 'BAP AKHIR KERJA', 'Surat', 'BAP AKHIR KERJA');
    $data['sebab_berakhir'] = $this->M_bapakhirkerja->getSebabBerakhir();
    $data['data_surat'] = $this->M_bapakhirkerja->getDatasurat($id);
    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Surat/BapAkhirKerja/V_Update', $data);
    $this->load->view('V_Footer', $data);
  }

  public function add()
  {
    $user = $this->session->user;
    $tgl_panggilan = $this->input->post('tanggalSurat');
    $lokasi_kerja = $this->input->post('lokasiKerja');
    $nama_pekerja = $this->input->post('namaPekerja');
    $jabatan_pekerja = trim($this->input->post('jabatanPekerja'));
    $seksi_pekerja = $this->input->post('seksiPekerja');
    $nama_petugas = $this->input->post('namaPetugas');
    $jabatan_petugas = $this->input->post('jabatanPetugas');
    $tgl_akhir_kerja = $this->input->post('tanggalAkhirKerja');
    $tgl_berhenti_kerja = $this->input->post('tanggalBerhentiKerja');
    $sebab_berakhir = $this->input->post('sebabBerakhir');
    $tgl_penggajian = $this->input->post('tanggalPenggajian');
    $keterangan_penggajian = $this->input->post('keteranganPenggajian');
    $tgl_aktif_bpjs = $this->input->post('tanggalAktifBpjs');
    $tgl_nonAktif_bpjs = $this->input->post('tanggalNonAktifBpjs');
    $no_bpjskes = $this->input->post('no_bpjskes');
    $no_bpjskt = $this->input->post('no_bpjsket');
    $tgl_pencairan_jht = $this->input->post('tanggalPencairanJHT');
    $tgl_pengambilan_srpengalaman = $this->input->post('tanggalSuratPengalamanKerja');
    $laporan_pajak = $this->input->post('laporanPajak');
    $kontakhp_hr = $this->input->post('kontakHpHr');
    $pihak1 = $this->input->post('pihak1');
    $pihak2 = $this->input->post('pihak2');
    $template = $this->M_bapakhirkerja->ambilLayoutSurat()[0]['isi_surat'];
    $surat = str_replace(
      [
        '[hari_dpgl]',
        '[tgl_dpgl]',
        '[bln_dpgl]',
        '[thn_dpgl]',
        '[lokasi_kerja]',
        '[nama_pekerja]',
        '[jabatan_pekerja]',
        '[seksi_pekerja]',
        '[nama_petugas]',
        '[jabatan_petugas]',
        '[tgl_akhir_kerja]',
        '[tgl_berhenti_kerja]',
        '[alasan_berakhir]',
        '[tgl_penggajian]',
        '[keterangan_penggajian]',
        '[tgl_aktifbpjs]',
        '[tgl_nonaktifbpjs]',
        '[no_bpjskes]',
        '[no_bpjsket]',
        '[tgl_jht]',
        '[tgl_srpengalaman]',
        '[thn_pjk]',
        '[kontak_hphr]',
        '[pihak1]',
        '[pihak2]'
      ],
      [
        explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[0],
        explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[1],
        explode(' ',  $this->konversitanggaladdhr($tgl_panggilan))[2],
        explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[3],
        $lokasi_kerja,
        $nama_pekerja,
        $jabatan_pekerja,
        $seksi_pekerja,
        $nama_petugas,
        $jabatan_petugas,
        $this->personalia->konversitanggalIndonesia($tgl_akhir_kerja),
        $this->personalia->konversitanggalIndonesia($tgl_berhenti_kerja),
        $sebab_berakhir,
        $this->personalia->konversitanggalIndonesia($tgl_penggajian),
        $keterangan_penggajian,
        $this->convertToindoBln($tgl_aktif_bpjs),
        $this->convertToindoBln($tgl_nonAktif_bpjs),
        trim($no_bpjskes),
        trim($no_bpjskt),
        $this->convertToindoBln($tgl_pencairan_jht),
        $this->personalia->konversitanggalIndonesia($tgl_pengambilan_srpengalaman),
        empty($laporan_pajak) ? '-' : $laporan_pajak,
        explode('-', $kontakhp_hr)[1],
        $pihak1,
        $pihak2
      ],
      $template
    );
    $data_surat = [
      'tgl_panggilan' => $tgl_panggilan,
      'lokasi_kerja' => $lokasi_kerja,
      'nama_pekerja' => trim(explode('/', $nama_pekerja)[0]),
      'noind_pekerja' => trim(explode('/', $nama_pekerja)[1]),
      'jabatan_pekerja' => $jabatan_pekerja,
      'seksi_pekerja' => $seksi_pekerja,
      'nama_petugas' => trim(explode('/', $nama_petugas)[0]),
      'noind_petugas' => trim(explode('/', $nama_petugas)[1]),
      'jabatan_petugas' => $jabatan_petugas,
      'tgl_akhir_kerja' => $tgl_akhir_kerja,
      'tgl_berhenti_kerja' => $tgl_berhenti_kerja,
      'sebab_berakhir' => $sebab_berakhir,
      'tgl_penggajian' => $tgl_penggajian,
      'keterangan_penggajian' => $keterangan_penggajian,
      'tgl_aktif_bpjs' => $tgl_aktif_bpjs,
      'tgl_nonaktif_bpjs' => $tgl_nonAktif_bpjs,
      'no_bpjskt' => trim($no_bpjskt),
      'no_bpjskes' => trim($no_bpjskes),
      'tgl_pencairan_jht' => $tgl_pencairan_jht,
      'tgl_pengambilan_srpengalaman' => $tgl_pengambilan_srpengalaman,
      'tgl_laporan_pajak' => $laporan_pajak,
      'khp_personalia' => $kontakhp_hr,
      'pihak1' => $pihak1,
      'pihak2' => $pihak2,
      'isi_surat' => $surat,
      'created_by' => $user,
      'date_created' => date('Y-m-d H:I:S')
    ];
    $this->M_bapakhirkerja->insertSuratBapAkhirKerja($data_surat);
    redirect('MasterPekerja/Surat/BapAkhirKerja');
  }
  public function edit($id)
  {
    $id = $this->general->dekripsi($id);
    $user = $this->session->user;
    $tgl_panggilan = $this->input->post('tanggalSurat');
    $lokasi_kerja = $this->input->post('lokasiKerja');
    $nama_pekerja = $this->input->post('namaPekerja');
    $jabatan_pekerja = trim($this->input->post('jabatanPekerja'));
    $seksi_pekerja = $this->input->post('seksiPekerja');
    $nama_petugas = $this->input->post('namaPetugas');
    $jabatan_petugas = $this->input->post('jabatanPetugas');
    $tgl_akhir_kerja = $this->input->post('tanggalAkhirKerja');
    $tgl_berhenti_kerja = $this->input->post('tanggalBerhentiKerja');
    $sebab_berakhir = $this->input->post('sebabBerakhir');
    $tgl_penggajian = $this->input->post('tanggalPenggajian');
    $keterangan_penggajian = $this->input->post('keteranganPenggajian');
    $tgl_aktif_bpjs = $this->input->post('tanggalAktifBpjs');
    $tgl_nonAktif_bpjs = $this->input->post('tanggalNonAktifBpjs');
    $no_bpjskes = $this->input->post('no_bpjskes');
    $no_bpjskt = $this->input->post('no_bpjsket');
    $tgl_pencairan_jht = $this->input->post('tanggalPencairanJHT');
    $tgl_pengambilan_srpengalaman = $this->input->post('tanggalSuratPengalamanKerja');
    $laporan_pajak =  $this->input->post('laporanPajak');
    $kontakhp_hr = $this->input->post('kontakHpHr');
    $pihak1 = $this->input->post('pihak1');
    $pihak2 = $this->input->post('pihak2');
    $template = $this->M_bapakhirkerja->ambilLayoutSurat()[0]['isi_surat'];
    $surat = str_replace(
      [
        '[hari_dpgl]',
        '[tgl_dpgl]',
        '[bln_dpgl]',
        '[thn_dpgl]',
        '[lokasi_kerja]',
        '[nama_pekerja]',
        '[jabatan_pekerja]',
        '[seksi_pekerja]',
        '[nama_petugas]',
        '[jabatan_petugas]',
        '[tgl_akhir_kerja]',
        '[tgl_berhenti_kerja]',
        '[alasan_berakhir]',
        '[tgl_penggajian]',
        '[keterangan_penggajian]',
        '[tgl_aktifbpjs]',
        '[tgl_nonaktifbpjs]',
        '[no_bpjskes]',
        '[no_bpjsket]',
        '[tgl_jht]',
        '[tgl_srpengalaman]',
        '[thn_pjk]',
        '[kontak_hphr]',
        '[pihak1]',
        '[pihak2]'
      ],
      [
        explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[0],
        explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[1],
        explode(' ',  $this->konversitanggaladdhr($tgl_panggilan))[2],
        explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[3],
        $lokasi_kerja,
        $nama_pekerja,
        $jabatan_pekerja,
        $seksi_pekerja,
        $nama_petugas,
        $jabatan_petugas,
        $this->personalia->konversitanggalIndonesia($tgl_akhir_kerja),
        $this->personalia->konversitanggalIndonesia($tgl_berhenti_kerja),
        $sebab_berakhir,
        $this->personalia->konversitanggalIndonesia($tgl_penggajian),
        $keterangan_penggajian,
        $this->convertToindoBln($tgl_aktif_bpjs),
        $this->convertToindoBln($tgl_nonAktif_bpjs),
        trim($no_bpjskes),
        trim($no_bpjskt),
        $this->convertToindoBln($tgl_pencairan_jht),
        $this->personalia->konversitanggalIndonesia($tgl_pengambilan_srpengalaman),
        empty($laporan_pajak) ? '-' : $laporan_pajak,
        explode('-', $kontakhp_hr)[1],
        $pihak1,
        $pihak2
      ],
      $template
    );
    $data_surat = [
      'tgl_panggilan' => $tgl_panggilan,
      'lokasi_kerja' => $lokasi_kerja,
      'nama_pekerja' => trim(explode('/', $nama_pekerja)[0]),
      'noind_pekerja' => trim(explode('/', $nama_pekerja)[1]),
      'jabatan_pekerja' => $jabatan_pekerja,
      'seksi_pekerja' => $seksi_pekerja,
      'nama_petugas' => trim(explode('/', $nama_petugas)[0]),
      'noind_petugas' => trim(explode('/', $nama_petugas)[1]),
      'jabatan_petugas' => $jabatan_petugas,
      'tgl_akhir_kerja' => $tgl_akhir_kerja,
      'tgl_berhenti_kerja' => $tgl_berhenti_kerja,
      'sebab_berakhir' => $sebab_berakhir,
      'tgl_penggajian' => $tgl_penggajian,
      'keterangan_penggajian' => $keterangan_penggajian,
      'tgl_aktif_bpjs' => $tgl_aktif_bpjs,
      'tgl_nonaktif_bpjs' => $tgl_nonAktif_bpjs,
      'no_bpjskt' => trim($no_bpjskt),
      'no_bpjskes' => trim($no_bpjskes),
      'tgl_pencairan_jht' => $tgl_pencairan_jht,
      'tgl_pengambilan_srpengalaman' => $tgl_pengambilan_srpengalaman,
      'tgl_laporan_pajak' => $laporan_pajak,
      'khp_personalia' => $kontakhp_hr,
      'pihak1' => $pihak1,
      'pihak2' => $pihak2,
      'isi_surat' => $surat,
      'created_by' => $user,
      'date_created' => date('Y-m-d')
    ];
    // var_dump($no_bpjs);die;
    $this->M_bapakhirkerja->updateSurat($id, $data_surat);
    redirect('MasterPekerja/Surat/BapAkhirKerja');
  }
  public function deleteSurat()
  {
    $key = $this->general->dekripsi($this->input->post('id'));
    $this->M_bapakhirkerja->deleteSurat($key);
  }
  public function printSurat($id)
  {
    $id = $this->general->dekripsi($id);
    $pdf     =  $this->pdf->load();
    $isi_surat = $this->M_bapakhirkerja->getDataSurat($id)[0]['isi_surat'];
    $pdf     =  new mPDF('utf-8', array(216, 330), 10, "verdana", 20, 20, 10, 20, 0, 0, 'P', ['default_font' => 'verdana']);
    $pdf->AddPage();
    $pdf->WriteHTML($isi_surat);
    $pdf->setTitle('BAP AKHIR KERJA - ' . $id);
    $pdf->Output('BAP AKHIR KERJA - ' . $id . '.pdf', 'I');
  }
  // Ajax Request
  public function getDataPekerja()
  {
    $key = strtoupper(trim($this->input->get('p')));
    $result = $this->M_bapakhirkerja->getDataPekerja($key);
    echo json_encode($result);
  }
  public function getDataPetugas()
  {
    $key = strtoupper(trim($this->input->get('p')));
    $result = $this->M_bapakhirkerja->getDataPetugas($key);
    echo json_encode($result);
  }
  public function getSebabBerakhir()
  {
    $key = strtoupper(trim($this->input->get('p')));
    $result = $this->M_bapakhirkerja->getSebabBerakhir($key);
    echo json_encode($result);
  }
  public function previewSurat()
  {
    $tgl_panggilan = $this->input->post('tanggalSurat');
    $lokasi_kerja = $this->input->post('lokasiKerja');
    $nama_pekerja = $this->input->post('namaPekerja');
    $jabatan_pekerja = trim($this->input->post('jabatanPekerja'));
    $seksi_pekerja = $this->input->post('seksiPekerja');
    $nama_petugas = $this->input->post('namaPetugas');
    $jabatan_petugas = $this->input->post('jabatanPetugas');
    $tgl_akhir_kerja = $this->input->post('tanggalAkhirKerja');
    $tgl_berhenti_kerja = $this->input->post('tanggalBerhentiKerja');
    $sebab_berakhir = $this->input->post('sebabBerakhir');
    $tgl_penggajian = $this->input->post('tanggalPenggajian');
    $keterangan_penggajian = $this->input->post('keteranganPenggajian');
    $tgl_aktif_bpjs = $this->input->post('tanggalAktifBpjs');
    $tgl_nonAktif_bpjs = $this->input->post('tanggalNonAktifBpjs');
    $no_bpjskt = $this->input->post('no_bpjsket');
    $no_bpjskes = $this->input->post('no_bpjskes');
    $tgl_pencairan_jht = $this->input->post('tanggalPencairanJHT');
    $tgl_pengambilan_srpengalaman = $this->input->post('tanggalSuratPengalamanKerja');
    $laporan_pajak = $this->input->post('laporanPajak');
    $kontakhp_hr = $this->input->post('kontakHpHr');
    $pihak1 = $this->input->post('pihak1');
    $pihak2 = $this->input->post('pihak2');
    $template = $this->M_bapakhirkerja->ambilLayoutSurat()[0]['isi_surat'];
    $surat = str_replace(
      [
        '[hari_dpgl]',
        '[tgl_dpgl]',
        '[bln_dpgl]',
        '[thn_dpgl]',
        '[lokasi_kerja]',
        '[nama_pekerja]',
        '[jabatan_pekerja]',
        '[seksi_pekerja]',
        '[nama_petugas]',
        '[jabatan_petugas]',
        '[tgl_akhir_kerja]',
        '[tgl_berhenti_kerja]',
        '[alasan_berakhir]',
        '[tgl_penggajian]',
        '[keterangan_penggajian]',
        '[tgl_aktifbpjs]',
        '[tgl_nonaktifbpjs]',
        '[no_bpjskes]',
        '[no_bpjsket]',
        '[tgl_jht]',
        '[tgl_srpengalaman]',
        '[thn_pjk]',
        '[kontak_hphr]',
        '[pihak1]',
        '[pihak2]'
      ],
      [
        empty($tgl_panggilan) ? ' ' : explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[0],
        empty($tgl_panggilan) ? ' ' : explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[1],
        empty($tgl_panggilan) ? ' ' : explode(' ',  $this->konversitanggaladdhr($tgl_panggilan))[2],
        empty($tgl_panggilan) ? ' ' : explode(' ', $this->konversitanggaladdhr($tgl_panggilan))[3],
        $lokasi_kerja,
        $nama_pekerja,
        $jabatan_pekerja,
        $seksi_pekerja,
        $nama_petugas,
        $jabatan_petugas,
        $this->personalia->konversitanggalIndonesia($tgl_akhir_kerja),
        $this->personalia->konversitanggalIndonesia($tgl_berhenti_kerja),
        $sebab_berakhir,
        $this->personalia->konversitanggalIndonesia($tgl_penggajian),
        $keterangan_penggajian,
        $this->convertToindoBln($tgl_aktif_bpjs),
        $this->convertToindoBln($tgl_nonAktif_bpjs),
        trim($no_bpjskes),
        trim($no_bpjskt),
        $this->convertToindoBln($tgl_pencairan_jht),
        $this->personalia->konversitanggalIndonesia($tgl_pengambilan_srpengalaman),
        empty($laporan_pajak) ? '-' : $laporan_pajak,
        empty($kontakhp_hr) ? ' ' : explode('-', $kontakhp_hr)[1],
        $pihak1,
        $pihak2
      ],
      $template
    );
    echo json_encode($surat);
  }
}
