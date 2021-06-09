<?php


class M_notulasampling extends CI_Model
{
  protected $sampling_table = 'Catering.tnotula_sampling';
  protected $katering_table = 'Catering.tkatering';
  protected $katering_jadwal = 'Catering.tjadwal';

  public function __construct()
  {
    parent::__construct();

    $this->load->database();
    $this->personalia = $this->load->database('personalia', true);
  }

  /**
   * Get sampling
   * 
   * @param String $year_month
   * @param String $kd_katering Kode Penyedia Catering
   */
  public function getSampling($year_month = false, $kd_katering = false)
  {
    $sql = $this->personalia
      ->select("
        st.*,
        kt.*,
        (
          case 
            when cast(st.shift as varchar) = '1' then '1 / Umum'
            else cast(st.shift as varchar)
          end
        ) as shift_alias,
        (
          case
            when st.berat is null or st.standard is null then null
            else (
              case
                when st.berat < st.standard then '1'
                else '0'
              end
            )
          end
        ) denda
      ")
      ->from($this->sampling_table . " st")
      ->join($this->katering_table . " kt", 'kt.fs_kd_katering = st.kd_katering', 'inner')
      ->where_not_in('trim(st.menu)', ['', '-', ' '])
      ->order_by('st.tanggal', 'ASC')
      ->order_by('st.id', 'ASC');

    if ($year_month) {
      $sql
        ->where("to_char(st.tanggal, 'YYYY-MM') = ", $year_month);
    }

    if ($kd_katering) {
      $sql->where('lower(st.kd_katering)', strtolower($kd_katering));
    }

    return $sql->get()
      ->result_object();
  }

  /**
   * 
   * @return Bool
   */
  public function checkSamplingIsExist($month, $kd_catering)
  {
    return $this->personalia
      ->where("to_char(tanggal, 'YYYY-MM') = ", $month)
      ->where('kd_katering', $kd_catering)
      ->from($this->sampling_table)
      ->limit(1)
      ->get()
      ->num_rows() == 1;
  }

  public function insertBatchSampling($data)
  {
    return $this->personalia->insert_batch($this->sampling_table, $data);
  }

  public function updateBatchSampling($data)
  {
    return $this->personalia->update_batch($this->sampling_table, $data, 'id');
  }

  public function getCateringProvider()
  {
    return $this->personalia
      ->order_by('fs_nama_katering', 'ASC')
      ->where('fb_status', true) // katering aktif
      ->get($this->katering_table)
      ->result_object();
  }

  public function getJadwalCatering($yearMonth, $kd_catering)
  {
    return $this->personalia
      ->select('
        kj.*,
        tk.fs_nama_katering
      ')
      ->from($this->katering_jadwal . " kj")
      ->join($this->katering_table . " tk", 'tk.fs_kd_katering = kj.fs_kd_katering')
      ->where("to_char(kj.fd_tanggal, 'YYYY-MM') = ", $yearMonth)
      ->where('kj.fs_kd_katering', $kd_catering)
      ->order_by('kj.fd_tanggal')
      ->get()
      ->result_object();
  }

  public function getMenuCatering($year, $month, $hari, $lokasi, $shift)
  {
    $sql =
      "SELECT
        tm.*,
        tmd.*
      FROM 
        \"Catering\".t_menu tm 
        inner join \"Catering\".t_menu_detail tmd on tmd.menu_id = tm.menu_id
      WHERE 
        tm.tahun = '$year' 
        and tm.bulan = '$month' 
        and tmd.tanggal = '$hari'
        and tm.lokasi = '$lokasi' 
        and tm.shift = '$shift'
      ORDER BY 
        tmd.tanggal ASC
      ";

    return $this->personalia->query($sql)->row();
  }
}
