<?php
Defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class M_limbahkelola extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getLimbahKirim(){
		$query = 	"select limkir.id_kirim,
                        cast(limkir.tanggal_kirim as date) tanggal,
                        cast(limkir.tanggal_kirim as time) waktu,
                        limjen.jenis_limbah,
                        (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
                        concat(limkir.jumlah_kirim, ' ',(select limbah_satuan 
                        from ga.ga_limbah_satuan limsat 
                        where limsat.id_jenis_limbah = limjen.id_jenis_limbah)) jumlah,
                        limkir.lokasi_kerja,
                        limkir.berat_kirim,
                        limkir.status_kirim,
                        (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0')
                        pekerja,
                        (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    order by limkir.tanggal_kirim desc";
        $result = $this->db->query($query);
        return $result->result_array();
	}

	public function getLimbahKirimById($id){
		$query = 	"select limkir.id_kirim,
                        cast(limkir.tanggal_kirim as date) tanggal,
                        cast(limkir.tanggal_kirim as time) waktu,
                        limjen.jenis_limbah,
                        (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi,
                        concat(limkir.jumlah_kirim, ' ',(select limbah_satuan 
                        from ga.ga_limbah_satuan limsat 
                        where limsat.id_jenis_limbah = limjen.id_jenis_limbah)) jumlah,
                        limkir.lokasi_kerja,
                        limkir.berat_kirim,
                        limkir.bocor,
                        limkir.ket_kirim,
                        limkir.status_kirim,
                        (select concat(employee_code,' - ',employee_name) from er.er_employee_all where employee_code = limkir.noind_pengirim and resign = '0')
                        pekerja,
                        (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah
                    where id_kirim = '$id'
                    order by limkir.tanggal_kirim desc";
        $result = $this->db->query($query);
        return $result->result_array();
	}

	public function DeleteLimbahKirim($id){
		$query = "delete from ga.ga_limbah_kirim where id_kirim = '$id'";
		$this->db->query($query);
	}
    public function getLokasi(){
        $query2 = "select location_code,location_name
                from er.er_location
                order by location_code";

        $result = $this->db->query($query2);
        return $result->result_array();
    }

	public function updateLimbahStatus($status,$id){
		$query = "update ga.ga_limbah_kirim set status_kirim = '$status' where id_kirim = '$id'";
		$this->db->query($query);
	}

	public function updateLimbahberat($berat,$id){
		$query = "update ga.ga_limbah_kirim set berat_kirim = '$berat' where id_kirim = '$id'";
		$this->db->query($query);
	}

    public function getSeksiEmail($id){
        $query = "select created_by from ga.ga_limbah_kirim where id_kirim = '$id'";
        $hasil = $this->db->query($query);
        $userseksi = $hasil->result_array();
        $user = $userseksi['0']['created_by'];
        
        $query = "select email_kirim,seksi_kirim from ga.ga_limbah_kirim_email where user_seksi = '$user'"; 
        $result = $this->db->query($query);

        return $result->result_array();
    }

    public function getLimKirimMin($id){
        $query = "select limjen.jenis_limbah,
                    cast(limkir.tanggal_kirim as date) tanggal,
                    (select sect.section_name from er.er_section sect where left(sect.section_code,7) = limkir.kodesie_kirim and sect.section_code like '%00') seksi
                    (select concat(location_code,' - ',location_name) from er.er_location where location_code = limkir.lokasi_kerja) noind_location,
                    concat(limkir.jumlah_kirim,' ',limsat.limbah_satuan) jumlah,
                    limkir.lokasi_kerja,
                    limkir.berat_kirim berat 
                    from ga.ga_limbah_kirim limkir
                    inner join ga.ga_limbah_jenis limjen on limjen.id_jenis_limbah = limkir.id_jenis_limbah 
                    inner join ga.ga_limbah_satuan limsat on limsat.id_jenis_limbah = limjen.id_jenis_limbah
                    where id_kirim = '$id';";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}

?>