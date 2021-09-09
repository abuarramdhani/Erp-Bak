<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_moncat extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
    }
    
    public function getdataLPPB($lppb){
        $sql = "SELECT rsh.shipment_header_id, rsl.shipment_line_id, msib.segment1,
                        msib.description, msib.inventory_item_id, rsl.quantity_received,
                        rsl.quantity_shipped, rsl.primary_unit_of_measure, rt.transaction_type,
                        rt.quantity, rt.unit_of_measure, to_char(rt.transaction_date, 'dd/mm/yyyy hh24:mi:ss') transaction_date, rsh.receipt_num,
                        rsh.shipment_num, kkc.conversion conversion_rate,
                        rt.quantity / kkc.conversion pail
                FROM rcv_transactions rt,
                        rcv_shipment_headers rsh,
                        rcv_shipment_lines rsl,
                        mtl_system_items_b msib,
                        khs_konversi_cat kkc
                WHERE rt.shipment_header_id = rsh.shipment_header_id
                    AND rt.shipment_line_id = rsl.shipment_line_id
                    AND rsh.shipment_header_id = rsl.shipment_header_id
                    AND rsl.item_id = msib.inventory_item_id
                    AND rsh.ship_to_org_id = msib.organization_id
                    AND rt.transaction_type = 'RECEIVE'
                    AND kkc.inventory_item_id = msib.inventory_item_id
                    AND rsh.ship_to_org_id = 102
                    AND rsh.receipt_num = $lppb
                    order by msib.SEGMENT1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataCat($date, $item){
        $sql = "select msib.segment1, kmc.* 
                from khs_monitoring_cat kmc, mtl_system_items_b msib
                where msib.segment1 = '$item'
                and trunc(kmc.transaction_date) = to_date('$date', 'DD/MM/YYYY') 
                and msib.inventory_item_id = kmc.inventory_item_id
                order by kmc.CREATION_DATE desc, kmc.CODE desc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getMonitoringCat(){
        $sql = "select distinct msib.SEGMENT1, msib.DESCRIPTION,  
                kmc.RECEIPT_NUM, kmc.INVENTORY_ITEM_ID, kmc.QUANTITY, 
                to_char(kmc.TRANSACTION_DATE, 'DD/MM/YYYY HH24:MI:SS') transaction_date,
                kmc.CODE, to_char(kmc.CREATION_DATE, 'DD/MM/YYYY HH24:MI:SS') creation_date,
                kmc.CREATED_BY, kmc.STATUS_OUT, kmc.DOCUMENT, kmc.DOCUMENT_NUMBER
                from khs_monitoring_cat kmc,
                mtl_system_items_b msib
                where msib.INVENTORY_ITEM_ID = kmc.INVENTORY_ITEM_ID
                order by kmc.RECEIPT_NUM, msib.SEGMENT1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataCetakCat($code){
        $sql = "select distinct msib.SEGMENT1, msib.DESCRIPTION,  
                kmc.RECEIPT_NUM, kmc.INVENTORY_ITEM_ID, kmc.QUANTITY, 
                to_char(kmc.TRANSACTION_DATE, 'DD/MM/YYYY HH24:MI:SS') transaction_date,
                kmc.CODE, to_char(kmc.CREATION_DATE, 'DD/MM/YYYY HH24:MI:SS') creation_date,
                kmc.CREATED_BY, kmc.STATUS_OUT, kmc.DOCUMENT, kmc.DOCUMENT_NUMBER
                from khs_monitoring_cat kmc,
                mtl_system_items_b msib
                where msib.INVENTORY_ITEM_ID = kmc.INVENTORY_ITEM_ID
                and kmc.CODE = '$code'
                order by kmc.RECEIPT_NUM";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataCetakCat2($no_lppb){
        $sql = "select distinct msib.SEGMENT1, msib.DESCRIPTION,  
                kmc.RECEIPT_NUM, kmc.INVENTORY_ITEM_ID, kmc.QUANTITY, 
                to_char(kmc.TRANSACTION_DATE, 'DD/MM/YYYY HH24:MI:SS') transaction_date,
                kmc.CODE, to_char(kmc.CREATION_DATE, 'DD/MM/YYYY HH24:MI:SS') creation_date,
                kmc.CREATED_BY, kmc.STATUS_OUT, kmc.DOCUMENT, kmc.DOCUMENT_NUMBER
                from khs_monitoring_cat kmc,
                mtl_system_items_b msib
                where msib.INVENTORY_ITEM_ID = kmc.INVENTORY_ITEM_ID
                and kmc.RECEIPT_NUM = '$no_lppb'
                order by kmc.RECEIPT_NUM, kmc.CODE";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getSettingCat(){
        $sql = "SELECT   msib.segment1, msib.description, kkc.*
                FROM mtl_system_items_b msib, khs_konversi_cat kkc
                WHERE msib.organization_id = 81
                AND kkc.inventory_item_id = msib.inventory_item_id
                ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getitemsetting($term){
        $sql = "SELECT   msib.segment1, msib.description, msib.primary_uom_code,
                        msib.inventory_item_id
                FROM mtl_system_items_b msib
                WHERE msib.organization_id = 81
                    AND msib.segment1 LIKE 'MAPC%'
                    AND (msib.segment1 LIKE '%$term%' or msib.description LIKE '%$term%')
                    AND msib.inventory_item_status_code = 'Active'
                    AND msib.inventory_item_id NOT IN (SELECT kkc.inventory_item_id
                                                        FROM khs_konversi_cat kkc)
                ORDER BY 1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function input_cat($no_lppb, $inv, $qty, $trans_date, $code, $user)
    {
        $sql = "insert into khs_monitoring_cat (receipt_num, inventory_item_id, quantity, transaction_date, code, creation_date, created_by)
                values($no_lppb, $inv, $qty, to_date('$trans_date', 'DD/MM/YYYY HH24:MI:SS'), '$code', sysdate, '$user')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function input_history_cat($no_lppb, $inv, $qty, $trans_date, $code, $date, $user)
    {
        $sql = "insert into khs_history_monitoring_cat (receipt_num, inventory_item_id, quantity, transaction_date, code, creation_date, created_by)
                values($no_lppb, $inv, $qty, to_date('$trans_date', 'DD/MM/YYYY HH24:MI:SS'), '$code', to_date('$date', 'DD/MM/YYYY HH24:MI:SS'), '$user')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function hapus_cat($code)
    {
        $sql = "delete from khs_monitoring_cat where code = '$code'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function save_setting_cat($inv, $konversi)
    {
        $sql = "insert into khs_konversi_cat (inventory_item_id, conversion)
                values($inv, $konversi)";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function hapus_setting_cat($inv)
    {
        $sql = "delete from khs_konversi_cat where inventory_item_id = $inv";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function update_setting_cat($inv, $qty)
    {
        $sql = "update khs_konversi_cat 
                set conversion = $qty
                where inventory_item_id = $inv";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }



}
