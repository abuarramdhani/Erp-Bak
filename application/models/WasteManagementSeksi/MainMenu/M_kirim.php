<?php
Defined('BASEPATH') or exit('No direct script access allowed');

class M_kirim extends Ci_Model
{

	function __construct()
	{
		parent::__construct();
        $this->load->database();
	}

	public function getLimbahKirim(){
        $seksi = $this->session->kodesie;
        $query = "select limkir.id_kirim,
                        cast(limkir.tanggal_kirim as date) tanggal,
                        cast(limkir.tanggal_kirim as time) waktu,
                        limjen.jenis_limbah,
                        (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') section_name,
                        limkir.lokasi_kerja,
                        limkir.bocor,
                        limkir.jumlah_kirim,
                        limkir.berat_kirim,
                        (select limbah_satuan_all
                        from ga.ga_limbah_satuan_all limsatall
                        where limsatall.id_satuan_all = limkir.id_satuan) satuan,
                        limkir.status_kirim,
												limkir.id_satuan,
												(select limbah_satuan from ga.ga_limbah_satuan limsat where limsat.id_jenis_limbah = limkir.id_jenis_limbah ) limbah_satuan,
                        (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0') noind_pengirim,
                        (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    where limkir.kodesie_kirim = left('$seksi',7)
                    order by limkir.tanggal_kirim desc;";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getLimbahKirimAtasan($periode = false){
      $seksi = $this->session->kodesie;
      $statusBaru = 3;

      if($periode) {
        $periode = "and limkir.tanggal_kirim between '{$periode['0']}' and '{$periode['1']}'";
      } else {
        // periode dalam bulan sekarang
        $firstDate = date('Y-m-01');
        $lastDate = date('Y-m-t');
        $periode = "and limkir.tanggal_kirim between '{$firstDate}' and '{$lastDate}'";
      }

      // khusus untuk atasan seksi Waste Management akan muncul semua seksi
      $kodesieKasieWM = '101030100';
      $filterSeksi = "limkir.kodesie_kirim = left('$seksi',7) and";
      if($seksi == $kodesieKasieWM) {
        $filterSeksi = '';
      }

      $query = "select limkir.id_kirim,
                      cast(limkir.tanggal_kirim as date) tanggal,
                      cast(limkir.tanggal_kirim as time) waktu,
                      limjen.jenis_limbah,
                      (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') section_name,
                      limkir.lokasi_kerja,
                      limkir.bocor,
                      limkir.jumlah_kirim,
                      limkir.berat_kirim,
                      (select limbah_satuan_all
                      from ga.ga_limbah_satuan_all limsatall
                      where limsatall.id_satuan_all = limkir.id_satuan) satuan,
                      limkir.status_kirim,
                      limkir.id_satuan,
                      (select limbah_satuan from ga.ga_limbah_satuan limsat where limsat.id_jenis_limbah = limkir.id_jenis_limbah ) limbah_satuan,
                      (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0') noind_pengirim,
                      (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                  from ga.ga_limbah_kirim limkir
                  inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                  where $filterSeksi limkir.status_kirim = '$statusBaru' $periode
                  order by limkir.tanggal_kirim desc;";
      $result = $this->db->query($query);
      return $result->result_array();
  }

    public function getSekNama(){
        $query1 = "select left(sect.section_code, 7) section_code,
                    sect.section_name
                    from er.er_section sect
                    where sect.section_code like '%00'
                    and sect.section_name != '-'
                    order by sect.section_name; ";
        $result = $this->db->query($query1);
        return $result->result_array();
    }

    public function getLokasi(){
        $query3 = "select location_code,location_name
                    from er.er_location
                    where location_code = '01' or location_code = '02'
                    order by location_code ";
        $result = $this->db->query($query3);
        return $result->result_array();
    }

    public function getSekNamaByKodesie($kodesie){
        $query1 = "select sect.section_name
                    from er.er_section sect
                    where sect.section_code = '$kodesie'";
        $result = $this->db->query($query1);
        return $result->result_array();
    }

    public function getEmployeeCodeName($kodesie){
        $query = "select employee_code,employee_name
                    from er.er_employee_all
                    where resign = '0' and left(section_code,7) = '$kodesie' order by employee_code";
        $result = $this->db->query($query);
        return $result->result_array();
    }

		public function getSatuan($id){
			$query = "select * from ga.ga_limbah_satuan_all where id_jenis_limbah = '$id' and status = '1'";
			return $this->db->query($query)->result_array();
		}

    public function getLimJenis($kodesie){
				$where = '';
				if(!strstr($kodesie, '4060101')){
					$where = "WHERE NOT limjen.jenis_limbah = 'contaminated goods'";
				}
        $query2 = "SELECT limjen.id_jenis_limbah,
                    	limjen.jenis_limbah,
                    	limjen.kode_limbah,
                    	(select limbah_satuan from ga.ga_limbah_satuan limsat where limsat.id_jenis_limbah = limjen.id_jenis_limbah) satuan
                    FROM ga.ga_limbah_jenis limjen
										$where
                    ORDER BY limjen.jenis_limbah;";
        $result = $this->db->query($query2);
        return $result->result_array();
    }

    public function getKirimID(){
        $query = "select max(cast(id_kirim as int))+1 id from ga.ga_limbah_kirim;";
        $result = $this->db->query($query);
        return $result->result_array();
    }


		public function getSatLim(){
			return $this->db->query("select distinct limbah_satuan_all as satuan, id_satuan_all from ga.ga_limbah_satuan_all")->result_array();
		}

		public function getSatLimbyLim($id){
			return $this->db->query("select limbah_satuan_all as satuan, id_satuan_all from ga.ga_limbah_satuan_all where id_jenis_limbah = '$id' and status = '1'")->result_array();
		}

		public function getSatLimOld($id){
			return $this->db->query("select limbah_satuan as satuan from ga.ga_limbah_satuan where id_jenis_limbah = '$id'")->result_array();
		}

		public function getSatlimbyID($id){
			return $this->db->query("select limbah_satuan_all as satuan, id_satuan_all from ga.ga_limbah_satuan_all where id_satuan_all = '$id' and status = '1'")->result_array();
		}

    public function insertKirimLimbah($data){
        $id = $data['id_kirim'];
        $tanggal = $data['tanggal'];
        $waktu =$data['waktu'];
        $jenis = $data['jenis_limbah'];
        $pengirim = $data['pengirim'];
        $seksi = $this->session->kodesie;
        $lokasi = $data['lokasi_kerja'];
        $kondisi = $data['kondisi'];
        $jumlah = $data['jumlah'];
        $ket = $data['keterangan'];
        $tangwak = $tanggal." ".$waktu;
        $user = $this->session->user;
				$satuan = $data['id_satuan'];

        $query = "insert into ga.ga_limbah_kirim(id_kirim,id_jenis_limbah,tanggal_kirim,kodesie_kirim,lokasi_kerja,bocor,jumlah_kirim,ket_kirim,status_kirim,created_by,noind_pengirim, id_satuan) values('$id','$jenis','$tangwak',left('$seksi',7),'$lokasi','$kondisi','$jumlah','$ket','3','$user','$pengirim', '$satuan')";

        $this->db->query($query);
    }

    public function getLimKirim($id){
        $query = "select limkir.id_kirim,
                        cast(limkir.tanggal_kirim as date) tanggal,
                        cast(limkir.tanggal_kirim as time) waktu,
                        limjen.id_jenis_limbah,
                        limjen.jenis_limbah,
                        (select left(sect.section_code, 7) section_code from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') section_code,
                        (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') section_name,
                        limkir.lokasi_kerja,
                        limkir.bocor,
                        limkir.jumlah_kirim,
                        limkir.ket_kirim,
												limkir.id_satuan,
                        (select limbah_satuan_all from ga.ga_limbah_satuan_all where id_satuan_all = limkir.id_satuan) limbah_satuan_all,
												(select limbah_satuan from ga.ga_limbah_satuan limsat where limsat.id_jenis_limbah = limkir.id_jenis_limbah) limbah_satuan,
                        (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0')noind_pengirim,
                        (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    inner join ga.ga_limbah_satuan limsat on limsat.id_jenis_limbah = limjen.id_jenis_limbah
                    where id_kirim = '$id';";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function UpdateLimKirim($data){
        $id = $data['id_kirim'];
        $tanggal = $data['tanggal'];
        $waktu =$data['waktu'];
        $jenis = $data['jenis_limbah'];
        $lokasi = $data['lokasi_kerja'];
        $kondisi = $data['kondisi'];
        $jumlah = $data['jumlah'];
        $ket = $data['keterangan'];
        $tangwak = $tanggal." ".$waktu;
				$satuan = $data['id_satuan'];

        $query = "update ga.ga_limbah_kirim set tanggal_kirim = '$tangwak', id_jenis_limbah = '$jenis', lokasi_kerja = '$lokasi', bocor = '$kondisi', jumlah_kirim = '$jumlah', ket_kirim = '$ket', id_satuan = '$satuan' where id_kirim = '$id'";
        $this->db->query($query);
    }

    public function delLimKirim($id){
        $query = "delete from ga.ga_limbah_kirim where id_kirim = '$id';";
        $this->db->query($query);
    }

    public function getLimKirimMin($id){
        $query = "select limkir.created_by, limjen.jenis_limbah,
                    cast(limkir.tanggal_kirim as date) tanggal,
                    cast(limkir.tanggal_kirim as time) waktu,
                    (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
                    concat(limkir.jumlah_kirim,limsat.limbah_satuan) jumlah
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    inner join ga.ga_limbah_satuan limsat on limsat.id_jenis_limbah = limjen.id_jenis_limbah
                    where id_kirim = '$id'";
        // echo "<pre>"; print_r($query); exit();

        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getdatalimbahkirim($id){
        $query = "select limjen.jenis_limbah, limkir.bocor, (select location_name from er.er_location where location_code = limkir.lokasi_kerja) lokasi,
        (select employee_name from er.er_employee_all where employee_code = limkir.noind_pengirim) nama_pengirim,
        cast(limkir.tanggal_kirim as date) tanggal, 
        cast(limkir.tanggal_kirim as time) waktu,
        (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
        concat(limkir.jumlah_kirim) jumlah,  concat(limsat.limbah_satuan) satuan,
        limkir.berat_kirim,
        limkir.approver,
        (case 
           when limkir.approver <> '' then (select employee_name from er.er_employee_all where employee_code=limkir.approver) 
           else ''
         end) as approver_name,
         limkir. approver_time
        from ga.ga_limbah_kirim limkir
        inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
        inner join ga.ga_limbah_satuan limsat on limsat.id_jenis_limbah = limjen.id_jenis_limbah
        where id_kirim = '$id'";
                    
        $result = $this->db->query($query);
        return $result->result_array();
    }

    function checkAtasanApprove($user, $kodesie) {
      $personalia = $this->load->database('personalia', true);
      $seksi = substr($kodesie, 0,7);

      $sql = "SELECT kd_jabatan from hrd_khs.tpribadi where noind = '$user' and keluar='0'";
      $result = $personalia->query($sql)->result_array();

      return (count($result) && $result['0']['kd_jabatan'] < 13);
    }

    function atasanApprove($id) {
      $user = $this->session->user;
      $sql = "UPDATE ga.ga_limbah_kirim set status_kirim = '4', approver = '$user', approver_time=now() where id_kirim='$id'";
      return $this->db->query($sql);
    }

    function atasanReject($id) {
      $user = $this->session->user;
      $sql = "UPDATE ga.ga_limbah_kirim set status_kirim = '5', approver = '$user', approver_time=now() where id_kirim='$id'";
      return $this->db->query($sql);
    }
}

?>
