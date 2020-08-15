<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoringrak extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getData($lokasi) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT msib.segment1 item, msib.description, lok.lokasi, ksm.MIN, ksm.MAX,
                        khs_inv_qty_oh (msib.organization_id, msib.inventory_item_id, lok.subinv, NULL, NULL) onhand
                FROM mtl_system_items_b msib, khsinvlokasisimpan lok, khs_sp_minmax ksm
                WHERE msib.organization_id = 225 --YSP
                    AND msib.inventory_item_id = lok.inventory_item_id
                    AND lok.subinv = 'SP-YSP'
                    AND msib.segment1 = ksm.item(+)
                    AND lok.lokasi LIKE '%$lokasi%'
                    order by 3";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }


}
