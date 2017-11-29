<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbahperlakuan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getLimbahPerlakuan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ga.ga_limbah_perlakuan');
    	} else {
    		$query = $this->db->get_where('ga.ga_limbah_perlakuan', array('id_perlakuan' => $id));
    	}

    	return $query->result_array();
    }

    public function setLimbahPerlakuan($data)
    {
        return $this->db->insert('ga.ga_limbah_perlakuan', $data);
    }

    public function updateLimbahPerlakuan($data, $id)
    {
        $this->db->where('id_perlakuan', $id);
        $this->db->update('ga.ga_limbah_perlakuan', $data);
    }

    public function deleteLimbahPerlakuan($id)
    {
        $this->db->where('id_perlakuan', $id);
        $this->db->delete('ga.ga_limbah_perlakuan');
    }
}

/* End of file M_limbahperlakuan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahperlakuan.php */
/* Generated automatically on 2017-11-13 08:50:30 */