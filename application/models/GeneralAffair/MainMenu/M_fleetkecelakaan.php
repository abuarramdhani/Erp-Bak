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

	public function getFleetKendaraan()
	{
		$query = $this->db->get('ga.ga_fleet_kendaraan');

		return $query->result_array();
	}


	public function getEmployeeAll()
	{
		$query = $this->db->get('er.er_employee_all');

		return $query->result_array();
	}
	
	public function getFleetKecelakaanDetail($id)
	{
		$query = $this->db->get_where('ga.ga_fleet_kecelakaan_detail', array('kecelakaan_id' => $id));
		
		return $query->result_array();
	}

	public function setFleetKecelakaanDetail($data)
	{
		return $this->db->insert('ga.ga_fleet_kecelakaan_detail', $data);
	}

	public function updateFleetKecelakaanDetail($data, $id)
	{
		$this->db->where('kecelakaan_detail_id', $id);
        $this->db->update('ga.ga_fleet_kecelakaan_detail', $data);
	}
}

/* End of file M_fleetkecelakaan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkecelakaan.php */
/* Generated automatically on 2017-08-05 13:58:40 */