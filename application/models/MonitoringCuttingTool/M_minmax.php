<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_minmax extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getKode($term) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT item, description
                FROM 
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description,
                    NVL (SUM (moqd.primary_transaction_quantity), 0) qty_onhand
                FROM mtl_system_items_b msib,
                    mtl_onhand_quantities_detail moqd,
                    mtl_item_locations mil
                WHERE msib.organization_id = 102
                AND msib.inventory_item_id = moqd.inventory_item_id
                AND msib.organization_id = moqd.organization_id
                AND moqd.subinventory_code = 'TR-TKS'
                AND moqd.locator_id = mil.inventory_location_id
                AND mil.inventory_location_id = 1131
                AND msib.segment1 not like '%-T'
                AND msib.SEGMENT1 not like '%-R'
                AND (msib.segment1 like '%$term%' or msib.description like '%$term%')
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description)
                order by 1";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function cekdata($item){
        $sql = "select * from mct.mct_setting_minmax where item = '$item'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function insertdata($item, $min, $max){
        $sql ="insert into mct.mct_setting_minmax (item, min_tr_tks, max_tr_tks)
                values ('$item', $mintr, $max)";
        $query = $this->db->query($sql);
    }

    public function updatedata($item, $mintr, $max){
        $sql = "update mct.mct_setting_minmax set min_tr_tks = '$mintr', max_tr_tks = '$max'
                where item = '$item'";
        $query = $this->db->query($sql);
    }

    public function getdata() {
        $sql ="SELECT * FROM mct.mct_setting_minmax order by 1";
        $query = $this->db->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdesc($item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select msib.DESCRIPTION 
                from mtl_system_items_b msib
                where msib.SEGMENT1 = '$item'
                and msib.ORGANIZATION_ID = 81";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
}

