<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');


class M_MonitoringOmsetAkuntansi extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
 
    }

    public function mntrgomst(){
        $query = 
        "SELECT DISTINCT
            obha.ORDER_NUMBER, 
            obha.HEADER_ID,
            oblv.ATTRIBUTE1 PRICE_UNIT, 
            oblv.creation_date, 
            oblv.ORDERED_ITEM, 
            msib.DESCRIPTION,
        (
            SELECT sum(obla.ATTRIBUTE1) 
            FROM  
                oe_blanket_lines_all obla 
            WHERE
                obha.HEADER_ID = obla.HEADER_ID 
            AND 
                obla.INVENTORY_ITEM_ID !=918103
        ) DPP,
        (
            SELECT sum(oblee.BLANKET_LINE_MAX_AMOUNT) 
            FROM 
                oe_blanket_lines_ext oblee 
            WHERE
                oblee.ORDER_NUMBER = obha.ORDER_NUMBER
        ) 
        MAX_AMOUNT
            FROM
                oe_blanket_headers_all obha,
                oe_blanket_lines_all  oblv,
                MTL_SYSTEM_ITEMS_B msib
            WHERE 
                obha.HEADER_ID = oblv.HEADER_ID
            AND 
                msib.SEGMENT1 = oblv.ORDERED_ITEM
            AND 
                obha.ORDER_NUMBER > 111799999
            AND 
                oblv.INVENTORY_ITEM_ID != 918103
            -- ORDER BY
            --     order_number
        ";

        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }

    public function mntrgomst_fltr($start,$end){
        $query = 
        "SELECT DISTINCT
            obha.ORDER_NUMBER, 
            obha.HEADER_ID,
            oblv.ATTRIBUTE1 PRICE_UNIT, 
            oblv.creation_date, 
            oblv.ORDERED_ITEM, 
            msib.DESCRIPTION,
        (
            SELECT sum(obla.ATTRIBUTE1) 
            FROM  
                oe_blanket_lines_all obla 
            WHERE
                obha.HEADER_ID = obla.HEADER_ID 
            AND 
                obla.INVENTORY_ITEM_ID !=918103
        ) DPP,
        (
            SELECT sum(oblee.BLANKET_LINE_MAX_AMOUNT) 
            FROM 
                oe_blanket_lines_ext oblee 
            WHERE
                oblee.ORDER_NUMBER = obha.ORDER_NUMBER
        ) 
        MAX_AMOUNT
            FROM
                oe_blanket_headers_all obha,
                oe_blanket_lines_all  oblv,
                MTL_SYSTEM_ITEMS_B msib
            WHERE 
                obha.HEADER_ID = oblv.HEADER_ID
            AND
                obha.ORDER_NUMBER >= $start 
            AND 
                obha.ORDER_NUMBER <= $end
            AND 
                msib.SEGMENT1 = oblv.ORDERED_ITEM
            AND 
                obha.ORDER_NUMBER > 111799999
            AND 
                oblv.INVENTORY_ITEM_ID != 918103
            -- ORDER BY
            --     order_number
        ";

        $hasil = $this->oracle->query($query);
        return $hasil->result_array();
    }
}
?>