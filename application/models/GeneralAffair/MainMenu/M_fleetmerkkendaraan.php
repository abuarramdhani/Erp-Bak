<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetmerkkendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetMerkKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilMerkKendaraan     = " select  merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                merkkdrn.jenis_bahanbakar,
                                                merkkdrn.rasio_bahanbakar,
                                                merkkdrn.kapasitas_bahanbakar,
                                                to_char(merkkdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat
                                        from    ga.ga_fleet_merk_kendaraan as merkkdrn
                                        where   merkkdrn.end_date = '9999-12-12 00:00:00';";
    		$query = $this->db->query($ambilMerkKendaraan);
    	} else {
            $ambilMerkKendaraan     = " select  merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                merkkdrn.jenis_bahanbakar,
                                                merkkdrn.rasio_bahanbakar,
                                                merkkdrn.kapasitas_bahanbakar,
                                                to_char(merkkdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(merkkdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                        from    ga.ga_fleet_merk_kendaraan as merkkdrn
                                        where   merkkdrn.merk_kendaraan_id=$id;";
    		$query = $this->db->query($ambilMerkKendaraan);
    	}

    	return $query->result_array();
    }

    public function getFleetMerkKendaraanDeleted()
    {
        $ambilMerkKendaraanDeleted  = " select  merkkdrn.merk_kendaraan_id as kode_merk_kendaraan,
                                                merkkdrn.merk_kendaraan as merk_kendaraan,
                                                merkkdrn.jenis_bahanbakar,
                                                merkkdrn.rasio_bahanbakar,
                                                merkkdrn.kapasitas_bahanbakar,
                                                to_char(merkkdrn.creation_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(merkkdrn.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                        from    ga.ga_fleet_merk_kendaraan as merkkdrn
                                        where   merkkdrn.end_date != '9999-12-12 00:00:00';";

        $query                      =   $this->db->query($ambilMerkKendaraanDeleted);
        return $query->result_array();
    }

    public function ambilProdusenKendaraan()
    {
        $ambilProdusenKendaraan     = " select      prd.prod_name as produsen_kendaraan
                                        from        ga.ga_fleet_produsen_kendaraan as prd
                                        order by    produsen_kendaraan;";
        $query                      =   $this->db->query($ambilProdusenKendaraan);
        return $query->result_array();
    }

    public function setFleetMerkKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_merk_kendaraan', $data);
    }

    public function updateFleetMerkKendaraan($data, $id)
    {
        $this->db->where('merk_kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_merk_kendaraan', $data);
    }

    public function deleteFleetMerkKendaraan($id)
    {
        $tanggal_eksekusi       = date('Y-m-d H:i:s');

        $deleteMerkKendaraan    = " update  ga.ga_fleet_merk_kendaraan
                                    set     end_date='$tanggal_eksekusi'
                                    where   merk_kendaraan_id=$id;";
        $this->db->query($deleteMerkKendaraan);
    }
}

/* End of file M_fleetmerkkendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetmerkkendaraan.php */
/* Generated automatically on 2017-08-05 13:19:46 */