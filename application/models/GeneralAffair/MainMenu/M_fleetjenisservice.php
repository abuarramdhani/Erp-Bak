<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetjenisservice extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFleetJenisService($id = FALSE)
    {
        if ($id === FALSE) {
            $query = $this->db->get('ga.ga_fleet_jenis_service');
        } else {
            $query = $this->db->get_where('ga.ga_fleet_jenis_service', array('jenis_service_id' => $id));
        }

        return $query->result_array();
    }

    public function setFleetJenisService($data)
    {
        return $this->db->insert('ga.ga_fleet_jenis_service', $data);
    }

    public function updateFleetJenisService($data, $id)
    {
        $this->db->where('jenis_service_id', $id);
        $this->db->update('ga.ga_fleet_jenis_service', $data);
    }

    public function deleteFleetJenisService($id)
    {
        $this->db->where('jenis_service_id', $id);
        $this->db->delete('ga.ga_fleet_jenis_service');
    }
}

/* End of file M_fleetbengkel.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetbengkel.php */
/* Generated automatically on 2018-04-02 13:05:31 */