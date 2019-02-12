<?php
Defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class M_info extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getLimbah(){
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

	public function getSeksi(){
		$query1 = "select left(sect.section_code, 7) section_code, 
                    sect.section_name 
                    from er.er_section sect 
                    where sect.section_code like '%00' 
                    and sect.section_name != '-' 
                    order by sect.section_name; ";       
        $result = $this->db->query($query1);
        return $result->result_array();
	}

    public function chartSeksi($id,$tanggal){
        // $query = "select sum(cast(kirim.berat_kirim as integer)) berat,seksi.section_name 
        // from ga.ga_limbah_kirim kirim 
        // inner join er.er_section seksi on kirim.kodesie_kirim = left(seksi.section_code, 7) and section_code like '%00' 
        // where kirim.id_jenis_limbah = '$id' and to_char(kirim.tanggal_kirim, 'month Y') = to_char(cast('1 ".$tanggal."' as date),'month Y')  and status_kirim = '1' 
        // group by seksi.section_name order by sum(cast(kirim.berat_kirim as integer)) desc;";

        $awal = $tanggal['0'];
        $akhir = $tanggal['1'];
        $query = "  select sum(cast(kirim.berat_kirim as float)) berat,seksi.section_name 
                    from ga.ga_limbah_kirim kirim 
                    inner join er.er_section seksi on kirim.kodesie_kirim = left(seksi.section_code, 7) and section_code like '%00' 
                    where kirim.id_jenis_limbah = '$id' and kirim.tanggal_kirim between '$awal' and '$akhir' and status_kirim = '1' 
                    group by seksi.section_name order by sum(cast(kirim.berat_kirim as float)) desc;";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function chartLimbah($sie,$tanggal = FALSE){
        // $query = "select sum(cast(kirim.berat_kirim as integer)) berat,jenis.jenis_limbah 
        // from ga.ga_limbah_kirim kirim 
        // inner join ga.ga_limbah_jenis jenis on kirim.id_jenis_limbah = jenis.id_jenis_limbah 
        // where kirim.kodesie_kirim = '$sie' and to_char(kirim.tanggal_kirim, 'month Y') = to_char(cast('1 ".$tanggal."' as date),'month Y')  and status_kirim = '1' 
        // group by jenis.jenis_limbah order by sum(cast(kirim.berat_kirim as integer)) desc;";
        $awal = $tanggal['0'];
        $akhir = $tanggal['1'];
        if (isset($tanggal) and !empty($tanggal)) {
            $kon = "kirim.tanggal_kirim between '$awal' and '$akhir'";
        }else{
            $kon = "tanggal_kirim between concat(extract(year from current_timestamp),'-',extract(month from current_timestamp),'-','1')::date and (concat(extract(year from current_timestamp + interval '1 month'),'-',extract(month from current_timestamp + interval '1 month'),'-','1')::date - interval '1 days')::date ";
        }
        
        $query = "  select sum(cast(kirim.berat_kirim as integer)) berat,jenis.jenis_limbah 
                    from ga.ga_limbah_kirim kirim 
                    inner join ga.ga_limbah_jenis jenis on kirim.id_jenis_limbah = jenis.id_jenis_limbah 
                    where kirim.kodesie_kirim = '$sie' and $kon and status_kirim = '1'
                    group by jenis.jenis_limbah order by sum(cast(kirim.berat_kirim as integer)) desc;";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getPeriodeDefault(){
        $query = "select concat(extract(year from current_timestamp),'-',extract(month from current_timestamp),'-','1')::date awal,(concat(extract(year from current_timestamp + interval '1 month'),'-',extract(month from current_timestamp + interval '1 month'),'-','1')::date - interval '1 days')::date akhir";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}
?>