<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetmaintenancekendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetMaintenanceKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_maintenance_kendaraan');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_maintenance_kendaraan', array('maintenance_kendaraan_id' => $id));
    	}

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
        $this->db->where('maintenance_kendaraan_id', $id);
        $this->db->delete('ga.ga_fleet_maintenance_kendaraan');
    }

	public function getFleetKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_kendaraan');

		return $query->result_array();
	}


	public function getFleetMaintenanceKategori()
	{
		$query = $this->db->get('ga.ga_fleet_maintenance_kategori');

		return $query->result_array();
	}
	
	public function getFleetMaintenanceKendaraanDetail($id)
	{
		$query = $this->db->get_where('ga.ga_fleet_maintenance_kendaraan_detail', array('maintenance_kendaraan_id' => $id));
		
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
}

/* End of file M_fleetmaintenancekendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetmaintenancekendaraan.php */
/* Generated automatically on 2017-08-05 13:43:03 */