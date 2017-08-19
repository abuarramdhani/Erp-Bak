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
    		$query = $this->db->get('ga.ga_fleet_merk_kendaraan');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_merk_kendaraan', array('merk_kendaraan_id' => $id));
    	}

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
        $this->db->where('merk_kendaraan_id', $id);
        $this->db->delete('ga.ga_fleet_merk_kendaraan');
    }
}

/* End of file M_fleetmerkkendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetmerkkendaraan.php */
/* Generated automatically on 2017-08-05 13:19:46 */