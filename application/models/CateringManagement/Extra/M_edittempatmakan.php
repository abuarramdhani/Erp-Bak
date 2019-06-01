<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_edittempatmakan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db = $this->load->database('personalia',TRUE);
    }

    public function getKodeSeksi(){
    	$seksi = $this->session->kodesie;
    	$query = "select ts.kodesie, ts.dept, ts.bidang, ts.unit, ts.seksi, ts.pekerjaan
    				from hrd_khs.tseksi ts
    				order by ts.seksi;";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getSekNamaByKodesie($kodesie){
        $query1 = "select ts.kodesie
                    from hrd_khs.tseksi ts
                    where ts.kodesie = '$kodesie'";
        $result = $this->db->query($query1);
        return $result->result_array();
    }

   public function getID($kodesie)
    {
      $sql = "select ts.seksi,ts.unit,ts.bidang,ts.dept,ts.pekerjaan,tp.tempat_makan
              from hrd_khs.tseksi ts
                inner join hrd_khs.tpribadi tp
                  on tp.kodesie=ts.kodesie
              where ts.kodesie='$kodesie'
              group by ts.seksi,ts.unit,ts.bidang,ts.dept,ts.pekerjaan,tp.tempat_makan
              order by tempat_makan asc";
      return $this->db->query($sql)->result_array();
    }

     public function getShow()
     {
       $query2="select tl.lokasi_kerja, tp.noind, tp.nama, tp.tempat_makan1, tp.tempat_makan2, ts.seksi, ts.unit, ts.bidang, ts.dept
                from hrd_khs.tpribadi tp
                 inner join hrd_khs.tseksi ts
                   on tp.kodesie=ts.kodesie
                 inner join hrd_khs.tlokasi_kerja tl
                   on tp.lokasi_kerja = tl.id_
                 where tp.keluar = '0' and tp.lokasi_kerja in ('01','02') and left(noind,1) not in('Z')
                 GROUP BY tl.lokasi_kerja, tp.noind, tp.nama, tp.tempat_makan1, tp.tempat_makan2, ts.seksi, ts.unit, ts.bidang, ts.dept
                 ORDER BY tp.noind";
       return $this->db->query($query2)->result_array();
     }

     public function edit()
     {
       $query3="select tp.noind, tp.nama, tp.tempat_makan1, tp.tempat_makan2, ts.seksi, ts.unit, ts.bidang, ts.dept
       from hrd_khs.tpribadi tp
       inner join hrd_khs.tseksi ts
       on tp.kodesie=ts.kodesie
       GROUP BY tp.noind, tp.nama, tp.tempat_makan1, tp.tempat_makan2, ts.seksi, ts.unit, ts.bidang, ts.dept
       limit 10";
       // echo $query3;exit();
       return $this->db->query($query3)->result_array();
     }

     public function update($noind,$makan,$makan1)
     {
       $sql="update hrd_khs.tpribadi
            set tempat_makan1='$makan', tempat_makan2='$makan1'
            where noind='$noind'";

      $this->db->query($sql);
     }

     public function getTempat()
     {
       $query4 = "select distinct tempat_makan1, tempat_makan2
              from hrd_khs.tpribadi
              order by tempat_makan1, tempat_makan2 asc";
      return $this->db->query($query4)->result_array();
     }

     public function getEdit($noind)
     {
       $query3="select tp.noind, tp.nama, tp.tempat_makan1, tp.tempat_makan2, ts.seksi, ts.unit, ts.bidang, ts.dept, tp.kodesie, tl.lokasi_kerja
       from hrd_khs.tpribadi tp
       inner join hrd_khs.tseksi ts
       on tp.kodesie=ts.kodesie
       inner join hrd_khs.tlokasi_kerja tl
       on tp.lokasi_kerja=tl.id_
       where tp.noind = '$noind'
       GROUP BY tp.noind, tp.nama, tp.tempat_makan1, tp.tempat_makan2, ts.seksi, ts.unit, ts.bidang, ts.dept, tp.kodesie, tl.lokasi_kerja";
       return $this->db->query($query3)->result_array();
     }

     public function updateAll($makan1,$makan2,$kodesie)
      {
        $query4 = "update hrd_khs.tpribadi
        set tempat_makan1='$makan1', tempat_makan2='$makan2'
        where kodesie='$kodesie' and keluar = '0'";
        return $this->db->query($query4);
      }

      public function insertLog($user,$makan1,$makan2,$kodesie)
       {
         $query4 = "INSERT INTO hrd_khs.tlog
                   (wkt, menu, ket, noind, jenis, program, noind_baru)
                  VALUES
                  (now(),
                  'MUTASI TEMPAT MAKAN',
                   'EDIT TEMPAT MAKAN kodesie = $kodesie  -> tempat_makan1 = $makan1 tempat_makan2 = $makan2 ',
                   '$user',
                  'EDIT PER KODESIE',
                  'KATERING ERP',
                  ''
                ) ;";

         return $this->db->query($query4);
       }

      public function updateStaff($makan1,$makan2,$kodesie)
       {
         $query4 = "update hrd_khs.tpribadi
         set tempat_makan1='$makan1', tempat_makan2='$makan2'
         where kodesie='$kodesie'
         and (noind like 'B%' or noind like 'J%')
         and keluar = '0' and left(noind,1) not in('Z')";
         return $this->db->query($query4);
       }

       public function insertLoga($user,$makan1,$makan2,$kodesie)
        {
          $query4 = "INSERT INTO hrd_khs.tlog
                    (wkt, menu, ket, noind, jenis, program, noind_baru)
                   VALUES
                   (now(),
                   'MUTASI TEMPAT MAKAN',
                    'EDIT TEMPAT MAKAN kodesie = $kodesie  -> tempat_makan1 = $makan1 tempat_makan2 = $makan2',
                    '$user',
                   'EDIT PER KODESIE UNTUK STAFF B & J',
                   'KATERING ERP',
                   ''
                 ) ;";

          return $this->db->query($query4);
        }

        public function updateNonStaff($makan1,$makan2,$kodesie)
         {
           $query4 = "update hrd_khs.tpribadi
           set tempat_makan1='$makan1', tempat_makan2='$makan2'
           where kodesie='$kodesie'
           and (noind like 'A%' or noind like 'H%')
           and keluar = '0' and left(noind,1) not in('Z')";
           return $this->db->query($query4);
         }

         public function insertLogb($user,$makan1,$makan2,$kodesie)
          {
            $query4 = "INSERT INTO hrd_khs.tlog
                      (wkt, menu, ket, noind, jenis, program, noind_baru)
                     VALUES
                     (now(),
                     'MUTASI TEMPAT MAKAN',
                      'EDIT TEMPAT MAKAN kodesie = $kodesie  -> tempat_makan1 = $makan1 tempat_makan2 = $makan2',
                      '$user',
                     'EDIT PER KODESIE UNTUK NON STAFF A & H',
                     'KATERING ERP',
                     ''
                   ) ;";

            return $this->db->query($query4);
          }

       public function getMakan()
       	{
       		$query6 = "select distinct tempat_makan
          from hrd_khs.tpribadi
          where trim(tempat_makan)!='-'
          order by tempat_makan asc";
          return $this->db->query($query6)->result_array();
       	}

}
?>
