<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetkecelakaandetail extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetKecelakaanDetail($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_fleet_kecelakaan_detail');
    	} else {
    		$query = $this->db->get_where('ga.ga_fleet_kecelakaan_detail', array('kecelakaan_detail_id' => $id));
    	}

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

    public function deleteFleetKecelakaanDetail($id)
    {
        $this->db->where('kecelakaan_detail_id', $id);
        $this->db->delete('ga.ga_fleet_kecelakaan_detail');
    }
}

/* End of file M_fleetkecelakaandetail.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkecelakaandetail.php */
/* Generated automatically on 2017-08-05 14:11:34 */