<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetkir extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetKir($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_kir');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_kir', array('kir_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFleetKir($data)
    {
        return $this->db->insert('ga.ga_fleet_kir', $data);
    }

    public function updateFleetKir($data, $id)
    {
        $this->db->where('kir_id', $id);
        $this->db->update('ga.ga_fleet_kir', $data);
    }

    public function deleteFleetKir($id)
    {
        $this->db->where('kir_id', $id);
        $this->db->delete('ga.ga_fleet_kir');
    }

	public function getFleetKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_kendaraan');

		return $query->result_array();
	}

}

/* End of file M_fleetkir.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkir.php */
/* Generated automatically on 2017-08-05 13:31:35 */