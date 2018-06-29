<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getOrder($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('sm.sm_order');
    	} else {
    		$query = $this->db->get_where('sm.sm_order', array('id_order' => $id));
    	}

    	return $query->result_array();
    }

    public function setOrder($data)
    {
        return $this->db->insert('sm.sm_order', $data);
    }

    public function saveOrderDetail($lines)
    {
        return $this->db->insert('sm.sm_order_detail',$lines);
    }

    public function updateOrder($data, $id)
    {
        $this->db->where('id_order', $id);
        $this->db->update('sm.sm_order', $data);
    }

    public function deleteOrder($id)
    {
        $this->db->where('id_order', $id);
        $this->db->delete('sm.sm_order');
    }
}

/* End of file M_order.php */
/* Location: ./application/models/OrderSiteManagement/MainMenu/M_order.php */
/* Generated automatically on 2018-06-26 09:50:15 */