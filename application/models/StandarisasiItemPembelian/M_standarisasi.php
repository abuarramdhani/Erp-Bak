<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_standarisasi extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getItem($string)
    {
        $oracle = $this->load->database("oracle", true);
        $query = $oracle->query("SELECT 
                    msib.INVENTORY_ITEM_ID
                    ,msib.SEGMENT1
                    ,msib.DESCRIPTION
                    ,msib.PRIMARY_UOM_CODE
                    ,mcb.SEGMENT1 category
                    ,ppf.FULL_NAME BUYER
            from mtl_system_items_b msib
                ,mtl_item_categories mic
                ,mtl_category_sets mcs
                ,mtl_categories_b mcb
                ,per_people_f ppf
            where msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
                and msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
                and mic.CATEGORY_SET_ID = mcs.CATEGORY_SET_ID
                and mic.CATEGORY_ID = mcb.CATEGORY_ID
                and msib.ORGANIZATION_ID = 81
                and msib.BUYER_ID = ppf.PERSON_ID(+)
                and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and mcs.CATEGORY_SET_NAME = 'KHS PERSEDIAAN INVENTORY'
                AND (msib.SEGMENT1 LIKE '$string%'
                OR msib.DESCRIPTION LIKE '$string%')");

        return $query->result_array();
    }

    public function saveData($data)
    {
        $oracle = $this->load->database("oracle", true);
        $oracle->set('LAST_UPDATE',"SYSDATE",false);
        $oracle->insert('KHS.KHS_PURCHASE_ITEM_INFO',$data);
    }

    public function ListData()
    {
        $oracle = $this->load->database("oracle", true);
        $query = $oracle->query("SELECT
                msib.INVENTORY_ITEM_ID ,
                msib.SEGMENT1 item_code ,
                msib.DESCRIPTION ,
                msib.PRIMARY_UOM_CODE ,
                mcb.SEGMENT1 category ,
                ppf.FULL_NAME BUYER,
                kpii.*
            FROM
                mtl_system_items_b msib ,
                mtl_item_categories mic ,
                mtl_category_sets mcs ,
                mtl_categories_b mcb ,
                per_people_f ppf,
                khs.khs_purchase_item_info kpii
            WHERE
                msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
                AND msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
                AND mic.CATEGORY_SET_ID = mcs.CATEGORY_SET_ID
                AND mic.CATEGORY_ID = mcb.CATEGORY_ID
                AND msib.ORGANIZATION_ID = 81
                AND msib.BUYER_ID = ppf.PERSON_ID(+)
                AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                AND mcs.CATEGORY_SET_NAME = 'KHS PERSEDIAAN INVENTORY'
                AND msib.INVENTORY_ITEM_ID = kpii.INVENTORY_ITEM_ID");
        
        return $query->result_array();
    }

    public function UpdateItem($inventory_item_id, $item)
    {
        $oracle = $this->load->database("oracle", true);
        $oracle->where('INVENTORY_ITEM_ID', $inventory_item_id);
        $oracle->set('LAST_UPDATE',"SYSDATE",false);
        $oracle->update('KHS.KHS_PURCHASE_ITEM_INFO',$item);
    }

    public function getPersonId($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT ppf.ATTRIBUTE3,
        ppf.PERSON_ID  --ini yang disimpan di database order
        ,ppf.FULL_NAME
        from
        PER_PEOPLE_F ppf 
        where
        ppf.NATIONAL_IDENTIFIER = '$noind' --NIK
        and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'");
        return $query->result_array();
    }

    public function deleteItem($inv_id)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('INVENTORY_ITEM_ID',$inv_id);
        $oracle->delete('KHS.KHS_PURCHASE_ITEM_INFO');
    }

    public function checkItem($inventory_item_id)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('INVENTORY_ITEM_ID',$inventory_item_id);
        $query = $oracle->get('KHS.KHS_PURCHASE_ITEM_INFO');

        return $query->result_array();
    }
}