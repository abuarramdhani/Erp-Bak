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
            $ambilPICKendaraan  = " select  pic.pic_kendaraan_id,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            concat_ws('<br/>', er.employee_code, er.employee_name) as pic,
                                            concat_ws('<br/>sampai dengan<br/>', to_char(pic.dari_periode, 'DD-MM-YYYY'), to_char(pic.sampai_periode,'DD-MM-YYYY')) as periode,
                                            to_char(pic.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(pic.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_pic_kendaraan as pic
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=pic.kendaraan_id
                                            join    er.er_employee_all as er
                                                on  er.employee_id=pic.employee_id
                                    where   pic.end_date='12-12-9999 00:00:00';";
    		$query = $this->db->query($ambilPICKendaraan);
    	} else {
            $ambilPICKendaraan  = " select  pic.pic_kendaraan_id,
                                            kdrn.nomor_polisi as nomor_polisi,
                                            concat_ws(' - ', er.employee_code, er.employee_name) as pic,
                                            concat_ws(' sampai dengan ', to_char(pic.dari_periode, 'DD-MM-YYYY'), to_char(pic.sampai_periode,'DD-MM-YYYY')) as periode,
                                            to_char(pic.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                            to_char(pic.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from    ga.ga_fleet_pic_kendaraan as pic
                                            join    ga.ga_fleet_kendaraan as kdrn
                                                on  kdrn.kendaraan_id=pic.kendaraan_id
                                            join    er.er_employee_all as er
                                                on  er.employee_id=pic.employee_id
                                    where   pic.pic_kendaraan_id=$id;";

    		$query = $this->db->query($ambilPICKendaraan);
    	}

    	return $query->result_array();
    }

    public function getFleetPicKendaraanDeleted()
    {
            $ambilPICKendaraanDeleted   = " select  pic.pic_kendaraan_id,
                                                    kdrn.nomor_polisi as nomor_polisi,
                                                    concat_ws('<br/>', er.employee_code, er.employee_name) as pic,
                                                    concat_ws('<br/>sampai dengan<br/>', to_char(pic.dari_periode, 'DD-MM-YYYY'), to_char(pic.sampai_periode,'DD-MM-YYYY')) as periode,
                                                    to_char(pic.creation_date,'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                    to_char(pic.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                            from    ga.ga_fleet_pic_kendaraan as pic
                                                    join    ga.ga_fleet_kendaraan as kdrn
                                                            on  kdrn.kendaraan_id=pic.kendaraan_id
                                                    join    er.er_employee_all as er
                                                            on  er.employee_id=pic.employee_id
                                        where   pic.end_date!='12-12-9999 00:00:00';";
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

	public function getFleetKendaraan()
	{
        $ambilKendaraan     = " select   kdrn.kendaraan_id as kode_kendaraan,
                                        kdrn.nomor_polisi as nomor_polisi
                                from    ga.ga_fleet_kendaraan as kdrn
                                where   kdrn.end_date='9999-12-12 00:00:00';";
		$query = $this->db->query($ambilKendaraan);

		return $query->result_array();
	}

}

/* End of file M_fleetpickendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetpickendaraan.php */
/* Generated automatically on 2017-08-05 13:32:47 */