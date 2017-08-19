<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetkecelakaan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetKecelakaan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_kecelakaan');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_kecelakaan', array('kecelakaan_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFleetKecelakaan($data)
    {
        return $this->db->insert('ga.ga_fleet_kecelakaan', $data);
    }

    public function updateFleetKecelakaan($data, $id)
    {
        $this->db->where('kecelakaan_id', $id);
        $this->db->update('ga.ga_fleet_kecelakaan', $data);
    }

    public function deleteFleetKecelakaan($id)
    {
        $this->db->where('kecelakaan_id', $id);
        $this->db->delete('ga.ga_fleet_kecelakaan');
    }
}

/* End of file M_fleetkecelakaan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkecelakaan.php */
/* Generated automatically on 2017-08-05 14:12:53 */