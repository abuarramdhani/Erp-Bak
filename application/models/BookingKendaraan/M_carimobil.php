<?php
class M_carimobil extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }
  
    public function ambilNama($p)
    {
       $query = "select * from hrd_khs.pribadi where noind='$p'";
      return $this->personalia->query($query)->result_array();
    }
    public function ambilSeksi($p)
    {
      $query = "select * from hrd_khs.tseksi where seksi like '%$p%' order by kodesie";
      return $this->personalia->query($query)->result_array();
    }

    public function ambilPIC($p)
    {
      $query = "select * from hrd_khs.tpribadi where (noind like '%$p%' or nama like '%$p%') and keluar='0' order by noind";
      return $this->personalia->query($query)->result_array();
    }

    public function selectNoind()
    {
      $query = "select distinct(d.user_name) as id
            from ga.ga_fleet_data_booking a 
            left join ga.ga_fleet_kendaraan e
              on e.kendaraan_id=a.kendaraan_id
            left join ga.ga_fleet_merk_kendaraan b 
              on e.merk_kendaraan_id=b.merk_kendaraan_id
            left join ga.ga_fleet_pic_kendaraan c 
              on c.kendaraan_id=a.kendaraan_id
            left join sys.sys_user d 
              on c.employee_id=d.employee_id";
      $data = $this->db->query($query);
      return $data->result_array();
    }

    public function ambilPekerjaPIC($noind)
    {
      $query = "select a.noind,a.nama, b.seksi 
            from hrd_khs.tpribadi a 
            join hrd_khs.tseksi b 
              on a.kodesie=b.kodesie
            where a.noind in ($noind)";
      $data = $this->personalia->query($query);
      return $data->result_array();
    }

    public function ambilKendaraan()
    {
      $query = "select distinct(a.kendaraan_id) as idken,
                a.nomor_polisi,
               b.merk_kendaraan,
               a.foto_kendaraan,
               d.user_name,
               a.usable 
            from ga.ga_fleet_kendaraan a 
            left join ga.ga_fleet_merk_kendaraan b 
              on a.merk_kendaraan_id=b.merk_kendaraan_id
            left join ga.ga_fleet_pic_kendaraan c 
              on c.kendaraan_id=a.kendaraan_id
            left join sys.sys_user d 
              on c.employee_id=d.employee_id
             order by a.kendaraan_id asc";
      $data = $this->db->query($query);
      return $data->result_array();
    }
    public function simpanBooking($data_input)
    {
      $this->db->insert('ga.ga_fleet_data_booking',$data_input);
      return $this->db->insert_id();
    }
    public function ambildataBookingId($id)
    {
      $query = "select * from ga.ga_fleet_data_booking where id='$id'";
      return $this->db->query($query)->result_array();
    }
    public function ambilMobilId($ken_id)
    {
      $query = "select a.nomor_polisi,
               a.kendaraan_id,
               b.merk_kendaraan,
               a.foto_kendaraan,
               d.user_name,
               a.usable 
            from ga.ga_fleet_kendaraan a 
            join ga.ga_fleet_merk_kendaraan b 
              on a.merk_kendaraan_id=b.merk_kendaraan_id
            left join ga.ga_fleet_pic_kendaraan c 
              on c.kendaraan_id=a.kendaraan_id
            left join sys.sys_user d 
              on c.employee_id=d.employee_id
            where a.kendaraan_id='$ken_id'";
      $data = $this->db->query($query);
      return $data->result_array();
    }

    public function ambilLogId($username)
    {
      $query = "select a.*,b.foto_kendaraan,b.nomor_polisi,c.merk_kendaraan
                from ga.ga_fleet_data_booking a 
                inner join ga.ga_fleet_kendaraan b
                   on a.kendaraan_id=b.kendaraan_id
                join ga.ga_fleet_merk_kendaraan c 
                  on b.merk_kendaraan_id=c.merk_kendaraan_id
                where a.creation_user='$username'";
      return $this->db->query($query)->result_array();
    }
    public function cekIdinBooking($ken_id)
    {
      $query ="select * from ga.ga_fleet_data_booking where kendaraan_id='$ken_id'";
      return $this->db->query($query)->num_rows();
    }
    public function autoInsertBooking($array)
    {
      $this->db->insert('ga.ga_fleet_data_booking',$array);
      return;
    }
    public function ambilMobilBookingTidak($today)
    {
      $query="select distinct(a.kendaraan_id), b.nomor_polisi, b.foto_kendaraan, b.usable, c.merk_kendaraan, 
                     e.user_name
              from ga.ga_fleet_data_booking a
                left join ga.ga_fleet_kendaraan b
                  on a.kendaraan_id=b.kendaraan_id
                left join ga.ga_fleet_merk_kendaraan c
                  on b.merk_kendaraan_id=c.merk_kendaraan_id
                left join ga.ga_fleet_pic_kendaraan d
                  on a.kendaraan_id=d.kendaraan_id
                left join sys.sys_user e
                  on d.employee_id=e.employee_id
              where (a.tanggal='$today')";
      return $this->db->query($query)->result_array();
    }
    public function ambilMobilBooking($id_ken)
    {
      if ($id_ken != "") {
        $query="select distinct(a.kendaraan_id), b.nomor_polisi, b.foto_kendaraan, b.usable, c.merk_kendaraan, 
                       e.user_name
                from ga.ga_fleet_data_booking a
                  left join ga.ga_fleet_kendaraan b
                    on a.kendaraan_id=b.kendaraan_id
                  left join ga.ga_fleet_merk_kendaraan c
                    on b.merk_kendaraan_id=c.merk_kendaraan_id
                  left join ga.ga_fleet_pic_kendaraan d
                    on a.kendaraan_id=d.kendaraan_id
                  left join sys.sys_user e
                    on d.employee_id=e.employee_id
                where a.kendaraan_id NOT IN ($id_ken)";
        return $this->db->query($query)->result_array();
      }elseif ($id_ken == "") {
          $query="select distinct(a.kendaraan_id), b.nomor_polisi, b.foto_kendaraan, b.usable, c.merk_kendaraan, 
                       e.user_name
                from ga.ga_fleet_data_booking a
                  left join ga.ga_fleet_kendaraan b
                    on a.kendaraan_id=b.kendaraan_id
                  left join ga.ga_fleet_merk_kendaraan c
                    on b.merk_kendaraan_id=c.merk_kendaraan_id
                  left join ga.ga_fleet_pic_kendaraan d
                    on a.kendaraan_id=d.kendaraan_id
                  left join sys.sys_user e
                    on d.employee_id=e.employee_id";
          return $this->db->query($query)->result_array();
      }
     
    }
    // public function ambilMobilBookingFull()
    // {

    // }
    public function cekNullorNot($kendaraan_id)
    {
      $query = "select * from ga.ga_fleet_data_booking where (kendaraan_id='$kendaraan_id' and tanggal IS NULL)";
      return $this->db->query($query)->num_rows();
    }

    public function updateNullBooking($data_input,$kendaraan_id)
    {
      $this->db->where('kendaraan_id',$kendaraan_id);
      $this->db->update('ga.ga_fleet_data_booking',$data_input);
      return;
    }

    public function ambilIdBookingUpdated($kendaraan_id)
    {
      $this->db->where('kendaraan_id',$kendaraan_id);
      return $this->db->get('ga.ga_fleet_data_booking')->result_array();
    }
    public function ambilNamaPic($username)
    {
      $this->personalia->where('noind',$username);
      return $this->personalia->get('hrd_khs.tpribadi')->result_array();
    }
    public function ambilDataRequest($nama)
    {
      $this->db->where('pic_kendaraan',$nama);
      return $this->db->get('ga.ga_fleet_data_booking')->result_array();
    }
    public function ambilNamaPengemudi($id_pen)
    {
      $query = "select noind,nama from hrd_khs.tpribadi where noind in ($id_pen)";
      return $this->personalia->query($query)->result_array();
    }
    public function ambilNamaPemohon($id_pem)
    {
      $query = "select noind,nama from hrd_khs.tpribadi where noind in ($id_pem)";
      return $this->personalia->query($query)->result_array();
    }
}
?>