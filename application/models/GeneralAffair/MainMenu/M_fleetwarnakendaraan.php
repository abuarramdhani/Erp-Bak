<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetwarnakendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetWarnaKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilWarnaKendaraan    = " select  warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                to_char(warnakdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat
                                        from    ga.ga_fleet_warna_kendaraan as warnakdrn
                                        where   warnakdrn.end_date='9999-12-12 00:00:00';";

    		$query = $this->db->query($ambilWarnaKendaraan);
    	} else {
            $ambilWarnaKendaraan    = " select  warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                to_char(warnakdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(warnakdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                        from    ga.ga_fleet_warna_kendaraan as warnakdrn
                                        where   warnakdrn.warna_kendaraan_id=$id;";

    		$query = $this->db->query($ambilWarnaKendaraan);
    	}

    	return $query->result_array();
    }

    public function getFleetWarnaKendaraanDeleted()
    {
        $ambilWarnaKendaraanDeleted = " select  warnakdrn.warna_kendaraan_id as kode_warna_kendaraan,
                                                warnakdrn.warna_kendaraan as warna_kendaraan,
                                                to_char(warnakdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(warnakdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                        from    ga.ga_fleet_warna_kendaraan as warnakdrn
                                        where   warnakdrn.end_date!='9999-12-12 00:00:00';";
        $query                      =   $this->db->query($ambilWarnaKendaraanDeleted);
        return $query->result_array();
    }

    public function setFleetWarnaKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_warna_kendaraan', $data);
    }

    public function updateFleetWarnaKendaraan($data, $id)
    {
        $this->db->where('warna_kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_warna_kendaraan', $data);
    }

    public function deleteFleetWarnaKendaraan($id)
    {
        $waktu_eksekusi         = date('Y-m-d H:i:s');

        $deleteWarnaKendaraan   = " update  ga.ga_fleet_warna_kendaraan
                                    set     end_date='$waktu_eksekusi'
                                    where   warna_kendaraan_id=$id;";

        $this->db->query($deleteWarnaKendaraan);
    }
}

/* End of file M_fleetwarnakendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetwarnakendaraan.php */
/* Generated automatically on 2017-08-05 13:20:05 */