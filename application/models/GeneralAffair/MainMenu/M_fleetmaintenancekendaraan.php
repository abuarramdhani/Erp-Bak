<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetmaintenancekendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();  

        date_default_timezone_set('Asia/Jakarta');
    }

    public function getFleetMaintenanceKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilMaintenanceKendaraan  =   "   select  mtckendaraan.maintenance_kendaraan_id as kode_maintenance_kendaraan,
                                                        mtckendaraan.maintenance_kategori_id as kode_kategori_kendaraan,
                                                        mtckendaraan.kendaraan_id as kode_kendaraan,
                                                        kdrn.nomor_polisi as nomor_polisi,
                                                        to_char(mtckendaraan.tanggal_maintenance, 'DD-MM-YYYY HH24:MI:SS') as tanggal_maintenance,
                                                        mtckendaraan.kilometer_maintenance as kilometer_maintenance,
                                                        mtckategori.maintenance_kategori as kategori_maintenance,
                                                        mtckendaraan.alasan as alasan,
                                                        to_char(mtckendaraan.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                        to_char(mtckendaraan.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                                from    ga.ga_fleet_maintenance_kendaraan as mtckendaraan
                                                        join    ga.ga_fleet_kendaraan as kdrn
                                                            on  kdrn.kendaraan_id=mtckendaraan.kendaraan_id
                                                        join    ga.ga_fleet_maintenance_kategori as mtckategori
                                                            on  mtckategori.maintenance_kategori_id=mtckendaraan.maintenance_kategori_id
                                                where   mtckendaraan.end_date='9999-12-12 00:00:00'
                                                order by mtckendaraan.tanggal_maintenance desc;";

    		$query = $this->db->query($ambilMaintenanceKendaraan);
    	} else {
            $ambilMaintenanceKendaraan  =   "   select  mtckendaraan.maintenance_kendaraan_id as kode_maintenance_kendaraan,
                                                        mtckendaraan.maintenance_kategori_id as kode_kategori_kendaraan,
                                                        mtckendaraan.kendaraan_id as kode_kendaraan,
                                                        kdrn.nomor_polisi as nomor_polisi,
                                                        to_char(mtckendaraan.tanggal_maintenance, 'DD-MM-YYYY HH24:MI:SS') as tanggal_maintenance,
                                                        mtckendaraan.kilometer_maintenance as kilometer_maintenance,
                                                        mtckategori.maintenance_kategori as kategori_maintenance,
                                                        mtckendaraan.alasan as alasan,
                                                        to_char(mtckendaraan.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                        to_char(mtckendaraan.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus        
                                                from    ga.ga_fleet_maintenance_kendaraan as mtckendaraan
                                                        join    ga.ga_fleet_kendaraan as kdrn
                                                            on  kdrn.kendaraan_id=mtckendaraan.kendaraan_id
                                                        join    ga.ga_fleet_maintenance_kategori as mtckategori
                                                            on  mtckategori.maintenance_kategori_id=mtckendaraan.maintenance_kategori_id
                                                where   mtckendaraan.maintenance_kendaraan_id=$id";

    		$query = $this->db->query($ambilMaintenanceKendaraan);
    	}

    	return $query->result_array();
    }

    public function getFleetMaintenanceKendaraanDeleted()
    {
        $ambilMaintenanceKendaraanDeleted   =   "   select  mtckendaraan.maintenance_kendaraan_id as kode_maintenance_kendaraan,
                                                            mtckendaraan.maintenance_kategori_id as kode_kategori_kendaraan,
                                                            mtckendaraan.kendaraan_id as kode_kendaraan,
                                                            kdrn.nomor_polisi as nomor_polisi,
                                                            to_char(mtckendaraan.tanggal_maintenance, 'DD-MM-YYYY HH24:MI:SS') as tanggal_maintenance,
                                                            mtckendaraan.kilometer_maintenance as kilometer_maintenance,
                                                            mtckategori.maintenance_kategori as kategori_maintenance,
                                                            mtckendaraan.alasan as alasan,
                                                            to_char(mtckendaraan.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                            to_char(mtckendaraan.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus        
                                                    from    ga.ga_fleet_maintenance_kendaraan as mtckendaraan
                                                            join    ga.ga_fleet_kendaraan as kdrn
                                                                on  kdrn.kendaraan_id=mtckendaraan.kendaraan_id
                                                            join    ga.ga_fleet_maintenance_kategori as mtckategori
                                                                on  mtckategori.maintenance_kategori_id=mtckendaraan.maintenance_kategori_id
                                                    where   mtckendaraan.end_date!='9999-12-12 00:00:00'
                                                    order by mtckendaraan.tanggal_maintenance desc;";
        $query                              =   $this->db->query($ambilMaintenanceKendaraanDeleted);
        return $query->result_array();
    }

    public function setFleetMaintenanceKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_maintenance_kendaraan', $data);
    }

    public function updateFleetMaintenanceKendaraan($data, $id)
    {
        $this->db->where('maintenance_kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_maintenance_kendaraan', $data);
    }

    public function deleteFleetMaintenanceKendaraan($id)
    {
        $waktu_eksekusi                     = date('Y-m-d H:i:s');
        $deleteMaintenanceKendaraanDetail   = " update  ga.ga_fleet_maintenance_kendaraan
                                                set     end_date='$waktu_eksekusi'
                                                where   maintenance_kendaraan_id=$id";
        $query                              =   $this->db->query($deleteMaintenanceKendaraanDetail);       
    }

	public function getFleetKendaraan()
	{
        $ambilKendaraan     = " select  kdrn.kendaraan_id as kode_kendaraan,
                                        kdrn.nomor_polisi as nomor_polisi
                                from    ga.ga_fleet_kendaraan as kdrn
                                where   kdrn.end_date='9999-12-12 00:00:00';";
        $query = $this->db->query($ambilKendaraan);

        return $query->result_array();
	}


	public function getFleetMaintenanceKategori()
    {
        $ambilKategoriMaintenance     = "   select   mtckategori.maintenance_kategori_id as kode_kategori_maintenance,
                                                    mtckategori.maintenance_kategori as kategori_maintenance
                                            from    ga.ga_fleet_maintenance_kategori as mtckategori
                                            where   mtckategori.end_date='9999-12-12 00:00:00'";
        $query = $this->db->query($ambilKategoriMaintenance);

        return $query->result_array();
	}
	
	public function getFleetMaintenanceKendaraanDetail($id)
	{		
        $ambilDetailMaintenance     = " select  mtckdrndtl.*
                                        from    ga.ga_fleet_maintenance_kendaraan_detail as mtckdrndtl
                                        where   mtckdrndtl.maintenance_kendaraan_id=$id
                                                and     mtckdrndtl.end_date='9999-12-12 00:00:00'";
        $query                      =   $this->db->query($ambilDetailMaintenance);

		return $query->result_array();
	}

	public function setFleetMaintenanceKendaraanDetail($data)
	{
		return $this->db->insert('ga.ga_fleet_maintenance_kendaraan_detail', $data);
	}

	public function updateFleetMaintenanceKendaraanDetail($data, $id)
	{
		$this->db->where('maintenance_kendaraan_detail_id', $id);
        $this->db->update('ga.ga_fleet_maintenance_kendaraan_detail', $data);
	}

    public function deleteFleetMaintenanceKendaraanDetail($id)
    {
        $waktu_eksekusi                     = date('Y-m-d H:i:s');
        $deleteMaintenanceKendaraanDetail   = " update  ga.ga_fleet_maintenance_kendaraan_detail
                                                set     end_date='$waktu_eksekusi'
                                                where   maintenance_kendaraan_detail_id=$id";
        $query                              =   $this->db->query($deleteMaintenanceKendaraanDetail);
    }
    
}

/* End of file M_fleetmaintenancekendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetmaintenancekendaraan.php */
/* Generated automatically on 2017-08-05 13:43:03 */