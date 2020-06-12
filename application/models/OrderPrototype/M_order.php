<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
    $this->personalia = $this->load->database('personalia', true);

  }
    function getNama($term)
  {
  $sql = "Select p.noind, p.nama
From hrd_khs.tpribadi p
Where p.noind like '%$term%' or p.nama like '%$term%'";
    
  $query = $this->personalia->query($sql);
  return $query->result_array();
  }

  public function selectproses() {
    // $oracle = $this->load->database('oracle', true);
    $sql = "SELECT * FROM eop.process";

    $query = $this->db->query($sql);
    return $query->result_array();
  }
   public function select_id($nama) {
    // $oracle = $this->load->database('oracle', true);
    $sql = "SELECT id_proses FROM eop.process where nama_proses='$nama'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

    public function ceknomororder($no_order) {
    $sql = "SELECT no_order FROM eop.order where no_order = '$no_order'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function insertorder($no_order ,$tgl_order, $dd_order, $kode_komponen, $nama_komponen, $type, $qty, $tgl_kirim_material, $keterangan) {
    $sql = "insert into eop.order(no_order ,tgl_order, dd_order, kode_komponen, nama_komponen, type, qty, tgl_kirim_material, keterangan) values ('$no_order' ,'$tgl_order', '$dd_order', '$kode_komponen', '$nama_komponen', '$type', '$qty', '$tgl_kirim_material', '$keterangan')";

    $query = $this->db->query($sql);
        return $sql;
  }
   public function insertorder2($no_order ,$tgl_order, $dd_order, $kode_komponen, $nama_komponen, $type, $qty, $keterangan) {
    $sql = "insert into eop.order(no_order ,tgl_order, dd_order, kode_komponen, nama_komponen, type, qty, keterangan) values ('$no_order' ,'$tgl_order', '$dd_order', '$kode_komponen', '$nama_komponen', '$type', '$qty', '$keterangan')";

    $query = $this->db->query($sql);
        return $sql;
  }

    public function insertorderproses($no_order ,$id_proses, $urutan) {
    $sql = "insert into eop.order_proses(no_order ,id_proses, urutan, done) values ('$no_order' ,'$id_proses', '$urutan', 'N')";

    $query = $this->db->query($sql);
        return $sql;
  }

    public function monitoringorder() {
    $sql = "SELECT * FROM eop.order ORDER BY no_order DESC";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function progress($no_order) {
    $sql = "SELECT * FROM eop.order_proses where no_order = '$no_order' ORDER BY urutan ASC";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

    public function nama_proses($id) {
    $sql = "SELECT nama_proses FROM eop.process where id_proses = '$id' ";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

      public function updateterima($no_order,$datetime) {
    // $oracle = $this->load->database('oracle', true);
    $sql = "UPDATE eop.order SET terima = 'Y' , tgl_act_terima = '$datetime'  where no_order = '$no_order' ";

    $query = $this->db->query($sql);
         return $sql;
  }

      public function dataedit($no_order) {
    // $oracle = $this->load->database('oracle', true);
    $sql = "SELECT * FROM eop.order where no_order = '$no_order' ";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function update($no_order,$due_date,$tgl_kirim_material,$kode_komponen,$nama_komponen,$type,$qty,$keterangan)
  {
  $sql = "UPDATE eop.order SET dd_order = '$due_date' , kode_komponen = '$kode_komponen', nama_komponen='$nama_komponen', type = '$type', qty = '$qty', tgl_kirim_material='$tgl_kirim_material', keterangan ='$keterangan' where no_order = '$no_order' ";

    $query = $this->db->query($sql);
         return $sql;
  }

    public function update2($no_order,$due_date,$kode_komponen,$nama_komponen,$type,$qty,$keterangan)
  {
  $sql = "UPDATE eop.order SET dd_order = '$due_date' , kode_komponen = '$kode_komponen', nama_komponen='$nama_komponen', type = '$type', qty = '$qty', tgl_kirim_material= NULL , keterangan ='$keterangan' where no_order = '$no_order'";

    $query = $this->db->query($sql);
         return $sql;
  }

  public function saveproses($nama_proses)
  {
     $sql = "insert into eop.process(nama_proses) values ('$nama_proses')";

    $query = $this->db->query($sql);
        return $sql;
  }

  public function hapusproses($nama_proses)
  {
     $sql = "delete FROM eop.process where nama_proses='$nama_proses'";

    $query = $this->db->query($sql);
        return $sql;
  }

  public function update_proses_order($urutan,$proses_order,$no_order)
  {
  $sql = "UPDATE eop.order_proses SET id_proses  = '$proses_order' where no_order = '$no_order' and urutan ='$urutan' ";

    $query = $this->db->query($sql);
         return $sql;
  }

    public function cek_urutan($no_order,$urutan) {
    $sql = "SELECT * FROM eop.order_proses where no_order = '$no_order' and urutan = '$urutan'";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

    public function hapusprosess($no_order, $urutan) {
    $sql = "DELETE FROM eop.order_proses where no_order = '$no_order' and urutan='$urutan'";

    $query = $this->db->query($sql);
    // return $query->result_array();
    return $sql;
  }

  public function update_tanggal_terima($no_order,$datetime)
  {
     $sql = "UPDATE eop.order SET tgl_terima_material  = '$datetime' where no_order = '$no_order'";

    $query = $this->db->query($sql);
         return $sql;
  }
  public function kirim($no_order,$datetime) {
    // $oracle = $this->load->database('oracle', true);
    $sql = "UPDATE eop.order SET kirim = 'Y', tgl_act_kirim = '$datetime' where no_order = '$no_order' ";

    $query = $this->db->query($sql);
         return $sql;
  }
    public function updatetgljob($no_order, $tgl_job) {
    // $oracle = $this->load->database('oracle', true);
    $sql = "UPDATE eop.order SET tgl_job_turun = '$tgl_job'  where no_order = '$no_order' ";

    $query = $this->db->query($sql);
         return $sql;
  }
      public function updateqtyfinish($no_order, $qty_finish) {
    // $oracle = $this->load->database('oracle', true);
    $sql = "UPDATE eop.order SET qty_finish = '$qty_finish'  where no_order = '$no_order' ";

    $query = $this->db->query($sql);
         return $sql;
  }
       public function updateprogress($urutanpro,$actionpro,$no_order){
    // $oracle = $this->load->database('oracle', true);
    $sql = "UPDATE eop.order_proses SET done = '$actionpro'  where no_order = '$no_order' and urutan='$urutanpro' ";

    $query = $this->db->query($sql);
         return $sql;
  }
   public function updatelastup($date,$time,$no_order){
    // $oracle = $this->load->database('oracle', true);
    $sql = "UPDATE eop.order SET last_updated_date = '$date', last_updated_time = '$time'  where no_order = '$no_order' ";

    $query = $this->db->query($sql);
         return $sql;
  }
    public function updatePIC($no_order,$pic_fab){
    // $oracle = $this->load->database('oracle', true);
    $sql = "UPDATE eop.order SET pic_fabrikasi = '$pic_fab' where no_order = '$no_order' ";

    $query = $this->db->query($sql);
         return $sql;
  }


}