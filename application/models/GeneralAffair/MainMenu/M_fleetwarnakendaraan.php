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
    		$query = $this->db->get('ga.ga_fleet_warna_kendaraan');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_warna_kendaraan', array('warna_kendaraan_id' => $id));
    	}

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
        $this->db->where('warna_kendaraan_id', $id);
        $this->db->delete('ga.ga_fleet_warna_kendaraan');
    }
}

/* End of file M_fleetwarnakendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetwarnakendaraan.php */
/* Generated automatically on 2017-08-05 13:20:05 */