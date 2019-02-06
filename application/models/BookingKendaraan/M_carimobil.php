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
}
?>