<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetkendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetKendaraan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_kendaraan');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_kendaraan', array('kendaraan_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFleetKendaraan($data)
    {
        return $this->db->insert('ga.ga_fleet_kendaraan', $data);
    }

    public function updateFleetKendaraan($data, $id)
    {
        $this->db->where('kendaraan_id', $id);
        $this->db->update('ga.ga_fleet_kendaraan', $data);
    }

    public function deleteFleetKendaraan($id)
    {
        $this->db->where('kendaraan_id', $id);
        $this->db->delete('ga.ga_fleet_kendaraan');
    }

	public function getFleetJenisKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_jenis_kendaraan');

		return $query->result_array();
	}


	public function getFleetMerkKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_merk_kendaraan');

		return $query->result_array();
	}


	public function getFleetWarnaKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_warna_kendaraan');

		return $query->result_array();
	}

}

/* End of file M_fleetkendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkendaraan.php */
/* Generated automatically on 2017-08-05 13:23:25 */