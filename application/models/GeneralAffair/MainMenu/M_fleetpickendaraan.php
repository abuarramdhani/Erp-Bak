<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetpickendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetPicKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilPICKendaraan  = " select  pic.pic_kendaraan_id as kode_pic_kendaraan,
                                            pic.kendaraan_id as kode_kendaraan,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            coalesce(pic.employee_id, pic.pic_kodesie) as kode,
                                            case    when    pic.employee_id is null and pic.pic_kodesie is not null then 'seksi'
                                                    when    pic.employee_id is not null and pic.pic_kodesie is null then 'pekerja'
                                            end as pilihan,
                                            case    when        pic.employee_id is null and pic.pic_kodesie is not null 
                                                        then    concat_ws('<br/>', seksi.unit_name, seksi.section_name)
                                                    when    pic.employee_id is not null and pic.pic_kodesie is null 
                                                        then    concat_ws('<br/>', er.employee_code, er.employee_name)
                                            end as pic,
                                            (select jenis_kendaraan from ga.ga_fleet_jenis_kendaraan jenis where jenis.jenis_kendaraan_id = kdrn.jenis_kendaraan_id) jenis_kendaraan,
                                            concat_ws('<br/>sampai dengan<br/>', to_char(pic.dari_periode, 'DD-MM-YYYY'), to_char(pic.sampai_periode,'DD-MM-YYYY')) as periode,
                                            to_char(pic.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(pic.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_pic_kendaraan as pic
                                            join        ga.ga_fleet_kendaraan as kdrn
                                                    on  kdrn.kendaraan_id=pic.kendaraan_id
                                            left join   er.er_employee_all as er
                                                    on  er.employee_id=pic.employee_id
                                            left join   er.er_section as seksi
                                                    on      seksi.section_code=pic.pic_kodesie::varchar
                                    where   pic.end_date='9999-12-12 00:00:00'
                                    order by pic.pic_kendaraan_id;";
    		$query = $this->db->query($ambilPICKendaraan);
    	} else {
            $ambilPICKendaraan  = " select  pic.pic_kendaraan_id as kode_pic_kendaraan,
                                            pic.kendaraan_id as kode_kendaraan,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            coalesce(pic.employee_id, pic.pic_kodesie) as kode,
                                            case    when    pic.employee_id is null and pic.pic_kodesie is not null then 'seksi'
                                                    when    pic.employee_id is not null and pic.pic_kodesie is null then 'pekerja'
                                            end as pilihan,                                            
                                            case    when        pic.employee_id is null and pic.pic_kodesie is not null 
                                                        then    concat_ws(' - ', seksi.unit_name, seksi.section_name)
                                                    when    pic.employee_id is not null and pic.pic_kodesie is null 
                                                        then    concat_ws(' - ', er.employee_code, er.employee_name)
                                            end as pic,
                                            concat_ws(' - ', to_char(pic.dari_periode, 'DD-MM-YYYY'), to_char(pic.sampai_periode,'DD-MM-YYYY')) as periode,
                                            to_char(pic.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(pic.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_pic_kendaraan as pic
                                            join        ga.ga_fleet_kendaraan as kdrn
                                                    on  kdrn.kendaraan_id=pic.kendaraan_id
                                            left join   er.er_employee_all as er
                                                    on  er.employee_id=pic.employee_id
                                            left join   er.er_section as seksi
                                                    on      seksi.section_code=pic.pic_kodesie::varchar                                                
                                    where   pic.pic_kendaraan_id=$id;";

    		$query = $this->db->query($ambilPICKendaraan);
    	}

    	return $query->result_array();
    }

    public function getFleetPicKendaraanCabang($lokasi)
    {
        $query = $this->db->query("select  pic.pic_kendaraan_id as kode_pic_kendaraan,
                                            pic.kendaraan_id as kode_kendaraan,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            coalesce(pic.employee_id, pic.pic_kodesie) as kode,
                                            case    when    pic.employee_id is null and pic.pic_kodesie is not null then 'seksi'
                                                    when    pic.employee_id is not null and pic.pic_kodesie is null then 'pekerja'
                                            end as pilihan,                                            
                                            case    when        pic.employee_id is null and pic.pic_kodesie is not null 
                                                        then    concat_ws(' - ', seksi.unit_name, seksi.section_name)
                                                    when    pic.employee_id is not null and pic.pic_kodesie is null 
                                                        then    concat_ws(' - ', er.employee_code, er.employee_name)
                                            end as pic,
                                            concat_ws(' - ', to_char(pic.dari_periode, 'DD-MM-YYYY'), to_char(pic.sampai_periode,'DD-MM-YYYY')) as periode,
                                            to_char(pic.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(pic.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_pic_kendaraan as pic
                                            join        ga.ga_fleet_kendaraan as kdrn
                                                    on  kdrn.kendaraan_id=pic.kendaraan_id
                                            left join   er.er_employee_all as er
                                                    on  er.employee_id=pic.employee_id
                                            left join   er.er_section as seksi
                                                    on      seksi.section_code=pic.pic_kodesie::varchar                              
                                    where   pic.end_date='9999-12-12 00:00:00' 
                                            and pic.kode_lokasi_kerja='$lokasi'");
        return $query->result_array();
    }

    public function getFleetPicKendaraanDeleted()
    {
            $ambilPICKendaraanDeleted   = " select  pic.pic_kendaraan_id as kode_pic_kendaraan,
                                                    pic.kendaraan_id as kode_kendaraan,
                                                    kdrn.nomor_polisi as nomor_polisi,
                                                    case    when    pic.employee_id is null and pic.pic_kodesie is not null then 'seksi'
                                                            when    pic.employee_id is not null and pic.pic_kodesie is null then 'pekerja'
                                                    end as pilihan,                                                    
                                                    coalesce(pic.employee_id, pic.pic_kodesie) as kode,
                                                    case    when        pic.employee_id is null and pic.pic_kodesie is not null 
                                                                then    concat_ws('<br/>', seksi.unit_name, seksi.section_name)
                                                            when    pic.employee_id is not null and pic.pic_kodesie is null 
                                                                then    concat_ws('<br/>', er.employee_code, er.employee_name)
                                                    end as pic,
                                                    (select jenis_kendaraan from ga.ga_fleet_jenis_kendaraan jenis where jenis.jenis_kendaraan_id = kdrn.jenis_kendaraan_id) jenis_kendaraan,
                                                    concat_ws('<br/>sampai dengan<br/>', to_char(pic.dari_periode, 'DD-MM-YYYY'), to_char(pic.sampai_periode,'DD-MM-YYYY')) as periode,
                                                    to_char(pic.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                    to_char(pic.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                            from    ga.ga_fleet_pic_kendaraan as pic
                                                    join        ga.ga_fleet_kendaraan as kdrn
                                                            on  kdrn.kendaraan_id=pic.kendaraan_id
                                                    left join   er.er_employee_all as er
                                                            on  er.employee_id=pic.employee_id
                                                    left join   er.er_section as seksi
                                                            on  seksi.section_code=pic.pic_kodesie::varchar  
                                            where   pic.end_date!='9999-12-12 00:00:00'
                                            order by pic.pic_kendaraan_id;";
        $query                      =   $this->db->query($ambilPICKendaraanDeleted);
        return $query->result_array();
    }

    public function getDaftarNama()
    {
        $ambilDaftarNama    = " select      pkj.employee_id as id_pekerja,
                                            concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar
                                from        er.er_employee_all as pkj
                                where       pkj.resign=0
                                            and     pkj.employee_code!='Z0000'
                                order by    pkj.employee_code;";
        $query              =   $this->db->query($ambilDaftarNama);
        return $query->result_array();
    }

    public function getDaftarSeksi()
    {
        $ambilDaftarSeksi   = " select      seksi.section_code as kode_seksi,
                                            concat_ws(' - ', seksi.unit_name, seksi.section_name) as nama_seksi
                                from        er.er_section as seksi
                                where       seksi.job_name='-'
                                            and     seksi.section_name!='-'
                                            and     right(seksi.section_code,2)='00'
                                order by    nama_seksi;";
        $query              =   $this->db->query($ambilDaftarSeksi);
        return $query->result_array();
    }

    public function setFleetPicKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_pic_kendaraan', $data);
    }

    public function updateFleetPicKendaraan($data, $id)
    {
        $this->db->where('pic_kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_pic_kendaraan', $data);
    }

    public function deleteFleetPicKendaraan($id)
    {

        $tanggal_eksekusi   =   date('Y-m-d H:i:s');

        $deletePICKendaraan = " update  ga.ga_fleet_pic_kendaraan
                                set     end_date='$tanggal_eksekusi'
                                where   pic_kendaraan_id=$id";
        $this->db->query($deletePICKendaraan);
    }

	public function getFleetKendaraan($query_lokasi)
	{
        $ambilKendaraan     = " select  kdrn.kendaraan_id as kode_kendaraan,
                                        kdrn.nomor_polisi as nomor_polisi
                                from    ga.ga_fleet_kendaraan as kdrn
                                where   kdrn.end_date='9999-12-12 00:00:00' $query_lokasi;";
		$query = $this->db->query($ambilKendaraan);

		return $query->result_array();
	}

}

/* End of file M_fleetpickendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetpickendaraan.php */
/* Generated automatically on 2017-08-05 13:32:47 */