<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetpickendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetPicKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_pic_kendaraan');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_pic_kendaraan', array('pic_kendaraan_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFleetPicKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_pic_kendaraan', $data);
    }

    public function updateFleetPicKendaraan($data, $id)
    {
        $this->db->where('pic_kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_pic_kendaraan', $data);
    }

    public function deleteFleetPicKendaraan($id)
    {
        $this->db->where('pic_kendaraan_id', $id);
        $this->db->delete('ga.ga_fleet_pic_kendaraan');
    }

	public function getFleetKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_kendaraan');

		return $query->result_array();
	}

}

/* End of file M_fleetpickendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetpickendaraan.php */
/* Generated automatically on 2017-08-05 13:32:47 */