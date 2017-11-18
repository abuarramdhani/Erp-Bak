<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbahsatuan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getLimbahSatuan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_limbah_satuan');
    	} else {
    		$query = $this->db->get_where('ga.ga_limbah_satuan', array('id_satuan' => $id));
    	}

    	return $query->result_array();
    }

    public function setLimbahSatuan($data)
    {
        return $this->db->insert('ga.ga_limbah_satuan', $data);
    }

    public function updateLimbahSatuan($data, $id)
    {
        $this->db->where('id_satuan', $id);
        $this->db->update('ga.ga_limbah_satuan', $data);
    }

    public function deleteLimbahSatuan($id)
    {
        $this->db->where('id_satuan', $id);
        $this->db->delete('ga.ga_limbah_satuan');
    }
}

/* End of file M_limbahsatuan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahsatuan.php */
/* Generated automatically on 2017-11-13 08:50:52 */