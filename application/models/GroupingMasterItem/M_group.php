<?php
class M_group extends CI_Model
{

    var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function get_data_group_header($header_id = null)
    {
        $where = '';
        if($header_id != null){
            $where = 'WHERE header_id = '.$header_id;
        }
        $query = $this->oracle->query("SELECT DISTINCT * FROM khs_cst_item_header $where");
        return $query->result_array();
    }

    public function get_data_group_line($header_id)
    {
        $query = $this->oracle->query("
        SELECT DISTINCT head.group_name, msib.segment1, msib.description, msib.ITEM_TYPE,
            flv.meaning type_code, line.creation_date, head.header_id, line.line_id, line.inventory_item_id item_id
        FROM khs_cst_item_line line, khs_cst_item_header head,
            mtl_system_items_b msib, fnd_lookup_values flv
        WHERE line.header_id = head.header_id AND line.header_id = $header_id
            and msib.inventory_item_id = line.inventory_item_id
            and msib.organization_id = 81 
            and msib.item_type = flv.lookup_code
            and flv.lookup_type = 'ITEM_TYPE' order by line.line_id");
        return $query->result_array();
    }

    public function get_data_items($code){
        $query = $this->oracle->query("
            SELECT DISTINCT msib.inventory_item_id item_id, msib.segment1, msib.description, msib.item_type,
                flv.meaning type
            FROM mtl_system_items_b msib, fnd_lookup_values flv
            WHERE msib.inventory_item_status_code = 'Active' and flv.lookup_code = msib.item_type
                AND flv.lookup_type = 'ITEM_TYPE' AND msib.segment1 like '$code%'
        ");
        return $query->result_array();
    }

    public function insert_data_group_header($name, $desc, $user){
        $this->oracle->query("INSERT INTO khs_cst_item_header(HEADER_ID, GROUP_NAME, DESCRIPTION, CREATION_DATE, CREATED_BY) 
            VALUES (null, '$name', '$desc', null, '$user')");
        $header_id = $this->oracle->query("SELECT MAX(header_id) header_id from khs_cst_item_header");
        return $header_id->result_array();
    }

    public function insert_data_group_line($header_id, $item, $user){
        $this->oracle->query("INSERT INTO khs_cst_item_line VALUES (null, $header_id, $item, null, '$user')");
    }

    public function update_data_group_header($name, $desc, $user, $header_id){
        $this->oracle->query("
            UPDATE khs_cst_item_header
            SET group_name = '$name',
                description = '$desc',
                last_update_date = sysdate,
                last_update_by = '$user'
            WHERE header_id = $header_id
        ");
    }

    public function delete_data_group($id, $table, $column){
        $column = $column.'_id';
        $this->oracle->query("DELETE FROM khs_cst_item_$table WHERE $column = $id");
    }

    public function get_detail_item($item){
        $query = $this->oracle->query("
            SELECT DISTINCT msib.description, flv.meaning type_code, msib.inventory_item_id item_id
            FROM mtl_system_items_b msib, fnd_lookup_values flv
            WHERE msib.organization_id = 81 
            and msib.item_type = flv.lookup_code
            and msib.segment1 = '$item'
            and flv.lookup_type = 'ITEM_TYPE'");
        return $query->result_array();
    }
}
?>