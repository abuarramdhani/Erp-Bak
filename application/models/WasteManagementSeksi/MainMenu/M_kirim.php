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
                        limkir.bocor,
                        limkir.jumlah_kirim,
                        limkir.berat_kirim,
                        (select limbah_satuan 
                        from ga.ga_limbah_satuan limsat 
                        where limsat.id_jenis_limbah = limjen.id_jenis_limbah) satuan,
                        limkir.status_kirim 
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

    public function getSekNamaByKodesie($kodesie){
        $query1 = "select sect.section_name 
                    from er.er_section sect 
                    where sect.section_code = '$kodesie'";       
        $result = $this->db->query($query1);
        return $result->result_array();
    }

    public function getLimJenis(){
        $query2 = "select limjen.id_jenis_limbah, 
                    limjen.jenis_limbah,
                    limjen.kode_limbah,
                    (select limbah_satuan 
                    from ga.ga_limbah_satuan limsat 
                    where limsat.id_jenis_limbah = limjen.id_jenis_limbah) satuan 
                    from ga.ga_limbah_jenis limjen
                    order by limjen.jenis_limbah;";
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
        $seksi = $this->session->kodesie;
        $kondisi = $data['kondisi']; 
        $jumlah = $data['jumlah']; 
        $ket = $data['keterangan'];
        $tangwak = $tanggal." ".$waktu;
        $user = $this->session->user;

        $query = "insert into ga.ga_limbah_kirim(id_kirim,id_jenis_limbah,tanggal_kirim,kodesie_kirim,bocor,jumlah_kirim,ket_kirim,status_kirim,created_by) values('$id','$jenis','$tangwak',left('$seksi',7),'$kondisi','$jumlah','$ket','3','$user');";

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
                        limkir.bocor,
                        limkir.jumlah_kirim,
                        limkir.ket_kirim,
                        limsat.limbah_satuan
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
        $kondisi = $data['kondisi']; 
        $jumlah = $data['jumlah']; 
        $ket = $data['keterangan'];
        $tangwak = $tanggal." ".$waktu;

        $query = "update ga.ga_limbah_kirim set tanggal_kirim = '$tangwak', id_jenis_limbah = '$jenis', bocor = '$kondisi', jumlah_kirim = '$jumlah', ket_kirim = '$ket' where id_kirim = '$id'";
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
                    concat(limkir.jumlah_kirim,' ',limsat.limbah_satuan) jumlah
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah 
                    inner join ga.ga_limbah_satuan limsat on limsat.id_jenis_limbah = limjen.id_jenis_limbah
                    where id_kirim = '$id';";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}

?>