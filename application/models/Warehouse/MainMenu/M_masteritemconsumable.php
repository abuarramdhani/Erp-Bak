<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masteritemconsumable extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getMasterItemConsumable($id = FALSE)
    {
    	if ($id === FALSE) {
    		$sql = "SELECT mi.consumable_id, mi.item_qty_min,mi.item_name , mi.item_desc ,mi.item_qty item_qty_awal,mi.item_qty - COALESCE(sum(tl.item_qty), 0 ) item_qty_sisa,COALESCE(sum(tl.item_qty), 0 ) item_qty_dipinjam, mi.item_barcode, mi.item_code
            from wh.wh_transaction_list tl right join wh.wh_master_item_consumable mi on tl.item_id = mi.item_code
            group by mi.item_code,mi.item_qty,mi.item_desc,mi.consumable_id";

            $data = $this->db->query($sql);
            return $data->result_array();

    	} else {
    		$query = $this->db->get_where('wh.wh_master_item_consumable', array('consumable_id' => $id));
    	}

    	return $query->result_array();
    }

    public function admin_check(){
            $sql = "select * from wh.wh_user_admin";
            $query = $this->db->query($sql);
            return $query->result_array();
        }

    public function setMasterItemConsumable($data)
    {
        return $this->db->insert('wh.wh_master_item_consumable', $data);
    }

    public function updateMasterItemConsumable($data, $id)
    {
        $this->db->where('consumable_id', $id);
        $this->db->update('wh.wh_master_item_consumable', $data);
    }

    public function deleteMasterItemConsumable($id)
    {
        $this->db->where('consumable_id', $id);
        $this->db->delete('wh.wh_master_item_consumable');
    }
}