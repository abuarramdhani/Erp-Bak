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
                        (select limbah_satuan
                        from ga.ga_limbah_satuan limsat
                        where limsat.id_jenis_limbah = limjen.id_jenis_limbah) satuan,
                        limkir.status_kirim,
                        (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0') noind_pengirim,
                        (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    where limkir.kodesie_kirim = left('$seksi',7)
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

    public function getLimJenis($kodesie){
				$where = '';
				if(!strstr($kodesie, '4060101')){
					$where = "WHERE NOT limjen.kode_limbah = 'A108d'";
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

        $query = "insert into ga.ga_limbah_kirim(id_kirim,id_jenis_limbah,tanggal_kirim,kodesie_kirim,lokasi_kerja,bocor,jumlah_kirim,ket_kirim,status_kirim,created_by,noind_pengirim) values('$id','$jenis','$tangwak',left('$seksi',7),'$lokasi','$kondisi','$jumlah','$ket','3','$user','$pengirim')";

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
                        limsat.limbah_satuan,
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

        $query = "update ga.ga_limbah_kirim set tanggal_kirim = '$tangwak', id_jenis_limbah = '$jenis', lokasi_kerja = '$lokasi', bocor = '$kondisi', jumlah_kirim = '$jumlah', ket_kirim = '$ket' where id_kirim = '$id'";
        $this->db->query($query);
    }

    public function delLimKirim($id){
        $query = "delete from ga.ga_limbah_kirim where id_kirim = '$id';";
        $this->db->query($query);
    }

    public function getLimKirimMin($id){
        $query = "select limjen.jenis_limbah,
                    cast(limkir.tanggal_kirim as date) tanggal,
                    cast(limkir.tanggal_kirim as time) waktu,
                    (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
                    concat(limkir.jumlah_kirim,limsat.limbah_satuan) jumlah
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    inner join ga.ga_limbah_satuan limsat on limsat.id_jenis_limbah = limjen.id_jenis_limbah
                    where id_kirim = '$id'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}

?>
