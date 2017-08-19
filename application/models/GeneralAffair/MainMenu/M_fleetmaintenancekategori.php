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
    		$query = $this->db->get('ga.ga_fleet_maintenance_kategori');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_maintenance_kategori', array('maintenance_kategori_id' => $id));
    	}

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
        $this->db->where('maintenance_kategori_id', $id);
        $this->db->delete('ga.ga_fleet_maintenance_kategori');
    }
}

/* End of file M_fleetmaintenancekategori.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetmaintenancekategori.php */
/* Generated automatically on 2017-08-05 13:33:39 */