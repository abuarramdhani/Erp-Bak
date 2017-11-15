<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbahjenis extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getLimbahJenis($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_limbah_jenis');
    	} else {
    		$query = $this->db->get_where('ga.ga_limbah_jenis', array('id_jenis_limbah' => $id));
    	}

    	return $query->result_array();
    }

    public function setLimbahJenis($data)
    {
        return $this->db->insert('ga.ga_limbah_jenis', $data);
    }

    public function updateLimbahJenis($data, $id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->update('ga.ga_limbah_jenis', $data);
    }

    public function deleteLimbahJenis($id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->delete('ga.ga_limbah_jenis');
    }
}

/* End of file M_limbahjenis.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahjenis.php */
/* Generated automatically on 2017-11-13 08:49:52 */