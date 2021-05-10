<?php defined('BASEPATH') or die('No direct script access allowed');

class M_bapakhirkerja extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->khs_erp = $this->load->database('default', TRUE); // postgres erp
    $this->personalia = $this->load->database('personalia', TRUE);
  }
  // Getting Data
  public function getAllSuratBapAkhir()
  {
    $this->personalia->select('id, noind_pekerja ,nama_pekerja ,jabatan_pekerja ,date_created ,seksi_pekerja, tgl_akhir_kerja');
    $this->personalia->order_by('date_created','DESC');
    $all_surat = $this->personalia->get('"Surat".tsurat_akhir_kerja');
    return $all_surat->result_array();
  }
  public function getDataSurat($id)
  {
    $this->personalia->select('*');
    $this->personalia->where('id', $id);
    $data_surat = $this->personalia->get('"Surat".tsurat_akhir_kerja');
    return $data_surat->result_array();
  }
  public function ambilLayoutSurat()
  {
    return $this->personalia->select('isi_surat')->where('jenis_surat', 'BAP AKHIR KERJA')->get('Surat.tisi_surat')->result_array();
  }
  public function ambilSurat($id)
  { }
  // Adding And Removing Data
  public function insertSuratBapAkhirKerja($data)
  {
    $this->personalia->insert('"Surat".tsurat_akhir_kerja', $data);
  }
  public function deleteSurat($key)
  {
    $sql = "delete from \"Surat\".tsurat_akhir_kerja where id = '$key'";
    $this->personalia->query($sql);
  }
  // Updating Data 
  public function updateSurat($key, $data)
  {
    $this->personalia->where('id', $key)->update('"Surat".tsurat_akhir_kerja', $data);
  }
  // For Ajax
  public function getDataPekerja($key)
  {
    $sql = "select 
              tp.noind,
              tp.nama,
              ts.seksi,
              coalesce(tbpk.no_peserta,'-') as nobpk,
              coalesce(tbpkt.no_peserta,'-') as nobpkt,
              torg.jabatan,
              tp.akhkontrak,
              tp.lokasi_kerja,
              case
                when tp.lokasi_kerja = '01' then 'CV. Karya Hidup Sentosa - Pusat'
              else 
                'CV. Karya Hidup Sentosa - Tuksono'
              end as nama_lokasi
            from 
              hrd_khs.tpribadi tp
            inner join 
              hrd_khs.tseksi ts on tp.kodesie = ts.kodesie
            inner join
              hrd_khs.torganisasi torg on tp.kd_jabatan = torg.kd_jabatan
            left join
              hrd_khs.tbpjskes tbpk on tp.noind = tbpk.noind
            left join
              hrd_khs.tbpjstk tbpkt on tp.noind = tbpkt.noind
            where 
              (tp.noind like('$key%') or 
              tp.nama like('%$key%')) and
              tp.lokasi_kerja in('01','02') and
              tp.keluar = '0'";
    return $this->personalia->query($sql)->result_array();
  }
  public function getDataPetugas($key)
  {
    $sql = "select 
              tp.nama,
              tp.noind,
              case
                when 
                  tp.kd_jabatan = '11' then 'KEPALA SEKSI HUBUNGAN KERJA'
                when
                  tp.kd_jabatan = '13' then 'SUPERVISOR SEKSI HUBUNGAN KERJA'
                else
                  'ADMIN HUBUNGAN KERJA'
              end as jabatan
            from 
              hrd_khs.tpribadi tp
            where
              (tp.nama like('%$key%') or tp.noind like('$key%')) and
              (tp.kd_jabatan in('10','11','12','13') or tp.kd_pkj = '401010101') and 
              kodesie like('4010101%') and 
              keluar = '0'";
    return $this->personalia->query($sql)->result_array();
  }
  public function getSebabBerakhir()
  {
    $sql = "select
              initcap(fs_sbb_keluar) sebab_keluar
            from
              hrd_khs.tsebabkeluar
            where
              fs_no in('1','3','4','5','6')";
    return $this->personalia->query($sql)->result_array();
  }
}
