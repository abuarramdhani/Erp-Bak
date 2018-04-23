<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetbengkel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetBengkel($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_bengkel');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_bengkel', array('bengkel_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFleetBengkel($data)
    {
        return $this->db->insert('ga.ga_fleet_bengkel', $data);
    }

    public function updateFleetBengkel($data, $id)
    {
        $this->db->where('bengkel_id', $id);
        $this->db->update('ga.ga_fleet_bengkel', $data);
    }

    public function deleteFleetBengkel($id)
    {
        $this->db->where('bengkel_id', $id);
        $this->db->delete('ga.ga_fleet_bengkel');
    }
}

/* End of file M_fleetbengkel.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetbengkel.php */
/* Generated automatically on 2018-04-02 13:05:31 */