<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_import extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function validasiItem($itemcode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
            msib.INVENTORY_ITEM_ID ,
            msib.SEGMENT1 kode_item ,
            msib.DESCRIPTION ,
            msib.PRIMARY_UNIT_OF_MEASURE primary_uom ,
            muomt.UNIT_OF_MEASURE secondary_uom ,
            NVL(msib.PREPROCESSING_LEAD_TIME, 0) + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) total_lead_time,
            TO_CHAR((CASE WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)<10) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 10 AND EXTRACT(DAY FROM SYSDATE)<25) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 25 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 25) THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)<10) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)>= 10) THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) ELSE LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) END), 'DD-Mon-YYYY') default_nbd
        FROM
            mtl_system_items_b msib ,
            mtl_units_of_measure_tl muomt ,
            mtl_item_categories mic ,
            mtl_categories_b mcb
        WHERE
            msib.ORGANIZATION_ID IN (101,
            102)
            AND msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
            AND msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
            AND mic.CATEGORY_SET_ID = '1100000244'
            AND mic.category_id = mcb.category_id
            AND msib.SECONDARY_UOM_CODE = muomt.UOM_CODE(+)
            AND msib.SEGMENT1 = '$itemcode'
            -- parameter
            AND msib.INVOICEABLE_ITEM_FLAG = 'Y'");

        return $query->result_array();
    }

    public function validasiSubinventory($organization, $subinventory)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        msi.SECONDARY_INVENTORY_NAME
        ,msi.STATUS_ID
        from
        mtl_secondary_inventories msi
        ,mtl_parameters mp
        where
        msi.STATUS_ID <> 60
        and msi.ORGANIZATION_ID = mp.ORGANIZATION_ID
        and mp.ORGANIZATION_CODE = '$organization'
        and msi.SECONDARY_INVENTORY_NAME = '$subinventory'");

        return $query->result_array();
    }

    public function validasiLengkap($itemcode, $organization, $subinventory)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        msib.INVENTORY_ITEM_ID ,
        msib.SEGMENT1 kode_item ,
        msib.DESCRIPTION,
        msib.PRIMARY_UNIT_OF_MEASURE primary_uom ,
        muomt.UNIT_OF_MEASURE secondary_uom ,
        mp.ORGANIZATION_CODE ,
        msi.SECONDARY_INVENTORY_NAME ,
        CASE
            WHEN (mcb.CATEGORY_ID IN (67009,
            67010)
            AND EXTRACT(DAY FROM SYSDATE)<10) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0)
            WHEN (mcb.CATEGORY_ID IN (67009,
            67010)
            AND EXTRACT(DAY FROM SYSDATE)>= 10
            AND EXTRACT(DAY FROM SYSDATE)<25) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 25 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0)
            WHEN (mcb.CATEGORY_ID IN (67009,
            67010)
            AND EXTRACT(DAY FROM SYSDATE)>= 25) THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0)
            WHEN (mcb.CATEGORY_ID IN (67007,
            67008)
            AND EXTRACT(DAY FROM SYSDATE)<10) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0)
            WHEN (mcb.CATEGORY_ID IN (67007,
            67008)
            AND EXTRACT(DAY FROM SYSDATE)>= 10) THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0)
            ELSE LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0)
        END default_nbd,
        msib.ATTRIBUTE27 puller
    FROM
        mtl_system_items_b msib ,
        mtl_units_of_measure_tl muomt ,
        mtl_secondary_inventories msi ,
        mtl_parameters mp ,
        mtl_item_categories mic ,
        mtl_categories_b mcb
    WHERE
        msib.SECONDARY_UOM_CODE = muomt.UOM_CODE(+)
        AND msib.ORGANIZATION_ID = mp.ORGANIZATION_ID
        AND msib.ORGANIZATION_ID = msi.ORGANIZATION_ID
        AND msib.ORGANIZATION_ID IN (101,
        102)
        AND msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
        AND msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
        AND mic.CATEGORY_SET_ID = '1100000244'
        AND mic.category_id = mcb.category_id
        AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
        AND msi.STATUS_ID = 1
        AND mp.ORGANIZATION_CODE = '$organization'
        -- parameter ORG
        AND msi.SECONDARY_INVENTORY_NAME = '$subinventory'
        -- parameter subinventory
        AND msib.SEGMENT1 = '$itemcode'
        -- parameter masukan kode item");

        return $query->result_array();
    }
}
