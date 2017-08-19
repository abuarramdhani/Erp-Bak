<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetjeniskendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetJenisKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_jenis_kendaraan');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_jenis_kendaraan', array('jenis_kendaraan_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFleetJenisKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_jenis_kendaraan', $data);
    }

    public function updateFleetJenisKendaraan($data, $id)
    {
        $this->db->where('jenis_kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_jenis_kendaraan', $data);
    }

    public function deleteFleetJenisKendaraan($id)
    {
        $this->db->where('jenis_kendaraan_id', $id);
        $this->db->delete('ga.ga_fleet_jenis_kendaraan');
    }
}

/* End of file M_fleetjeniskendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetjeniskendaraan.php */
/* Generated automatically on 2017-08-05 13:18:43 */