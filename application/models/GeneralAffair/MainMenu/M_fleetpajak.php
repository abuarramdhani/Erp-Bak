<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetpajak extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetPajak($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_pajak');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_pajak', array('pajak_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFleetPajak($data)
    {
        return $this->db->insert('ga.ga_fleet_pajak', $data);
    }

    public function updateFleetPajak($data, $id)
    {
        $this->db->where('pajak_id', $id);
        $this->db->update('ga.ga_fleet_pajak', $data);
    }

    public function deleteFleetPajak($id)
    {
        $this->db->where('pajak_id', $id);
        $this->db->delete('ga.ga_fleet_pajak');
    }

	public function getFleetKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_kendaraan');

		return $query->result_array();
	}

}

/* End of file M_fleetpajak.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetpajak.php */
/* Generated automatically on 2017-08-05 13:29:59 */