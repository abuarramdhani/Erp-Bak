<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetmaintenancekategori extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetMaintenanceKategori($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilKategoriMaintenance   = " select  mtckategori.maintenance_kategori_id as kode_kategori_maintenance,
                                                    mtckategori.maintenance_kategori as kategori_maintenance,
                                                    to_char(mtckategori.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat
                                            from    ga.ga_fleet_maintenance_kategori as mtckategori
                                            where   mtckategori.end_date = '9999-12-12 00:00:00';";

    		$query = $this->db->query($ambilKategoriMaintenance);
    	} else {
            $ambilKategoriMaintenance   = " select  mtckategori.maintenance_kategori_id as kode_kategori_maintenance,
                                                    mtckategori.maintenance_kategori as kategori_maintenance,
                                                    to_char(mtckategori.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                    to_char(mtckategori.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                            from    ga.ga_fleet_maintenance_kategori as mtckategori
                                            where   mtckategori.maintenance_kategori_id=$id;";

    		$query = $this->db->query($ambilKategoriMaintenance);
    	}

    	return $query->result_array();
    }

    public function getFleetMaintenanceKategoriDeleted()
    {
        $ambilKategoriMaintenanceDeleted    = " select  mtckategori.maintenance_kategori_id as kode_kategori_maintenance,
                                                        mtckategori.maintenance_kategori as kategori_maintenance,
                                                        to_char(mtckategori.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                        to_char(mtckategori.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                                from    ga.ga_fleet_maintenance_kategori as mtckategori
                                                where   mtckategori.end_date != '9999-12-12 00:00:00';";

        $query                              =   $this->db->query($ambilKategoriMaintenanceDeleted);
        return $query->result_array();
    }

    public function setFleetMaintenanceKategori($data)
    {
        return $this->db->insert('ga.ga_fleet_maintenance_kategori', $data);
    }

    public function updateFleetMaintenanceKategori($data, $id)
    {
        $this->db->where('maintenance_kategori_id', $id);
        $this->db->update('ga.ga_fleet_maintenance_kategori', $data);
    }

    public function deleteFleetMaintenanceKategori($id)
    {
        $tanggal_eksekusi           = date('Y-m-d H:i:s');

        $deleteKategoriMaintenance  = " update  ga.ga_fleet_maintenance_kategori
                                        set     end_date='$tanggal_eksekusi'
                                        where   maintenance_kategori_id=$id;";

        $this->db->query($deleteKategoriMaintenance);
    }
}

/* End of file M_fleetmaintenancekategori.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetmaintenancekategori.php */
/* Generated automatically on 2017-08-05 13:33:39 */