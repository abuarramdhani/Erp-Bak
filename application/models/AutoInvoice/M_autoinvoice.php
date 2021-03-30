<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_autoinvoice extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }
    public function DoReady()
    {
        $sql = "SELECT DISTINCT
        wdd.BATCH_ID NO_DO
        ,ooha.ORDER_NUMBER SO_NUMBER
        ,hou.NAME OU
        FROM
        wsh_delivery_details wdd
        ,oe_order_headers_all ooha
        ,HR_ORGANIZATION_UNITS hou
        ,khs_shipconfirm_web ksw
        ,oe_order_lines_all oola
        WHERE 1=1
        AND wdd.SOURCE_HEADER_ID = ooha.HEADER_ID
        AND wdd.ORG_ID = hou.ORGANIZATION_ID
        AND wdd.RELEASED_STATUS = 'Y'
        AND wdd.SOURCE_LINE_ID = oola.LINE_ID
        AND oola.LINE_TYPE_ID in (1003, 1455)
        AND not exists (select wdd1.BATCH_ID from wsh_delivery_details wdd1 where wdd1.BATCH_ID = wdd.BATCH_ID and wdd1.RELEASED_STATUS = 'S')
        AND wdd.BATCH_ID = ksw.WDD_BATCH_ID(+)
        AND ksw.WDD_BATCH_ID is null
        order by wdd.BATCH_ID desc";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function DetailDO($do)
    {
        $sql = "SELECT DISTINCT
       MSIB.SEGMENT1
       ,MSIB.DESCRIPTION
       ,WDD.REQUESTED_QUANTITY_UOM
       ,WDD.REQUESTED_QUANTITY - NVL(WDD.CANCELLED_QUANTITY,0) REQUESTED_QUANTITY
       ,WDD.SHIPPED_QUANTITY
       FROM
       WSH_DELIVERY_DETAILS WDD
       ,MTL_SYSTEM_ITEMS_B MSIB
       WHERE 1=1
       AND WDD.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
       AND WDD.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
       AND WDD.RELEASED_STATUS = 'Y'
       AND WDD.BATCH_ID = $do -- parameter";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function InsertProcessDO($induk, $do)
    {
        $sql = "INSERT INTO khs_shipconfirm_web
        SELECT DISTINCT
        null
        ,wdd.BATCH_ID
        ,wdd.SOURCE_HEADER_NUMBER
        ,wdd.ORGANIZATION_ID
        ,null
        ,null
        ,null
        ,null
        ,null
        ,null
        ,'$induk' -- parameter
        ,wda.DELIVERY_ID
        ,null
        ,null
        FROM
        wsh_delivery_details wdd
        ,WSH_DELIVERY_ASSIGNMENTS WDA
        WHERE 1=1
        AND wda.DELIVERY_DETAIL_ID = wdd.DELIVERY_DETAIL_ID
        AND wdd.BATCH_ID = $do -- parameter";

        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function DoProcess()
    {
        $sql = "SELECT DISTINCT
        wdd.BATCH_ID NO_DO
        ,ooha.ORDER_NUMBER SO_NUMBER
        ,hou.NAME OU
        FROM
        wsh_delivery_details wdd
        ,oe_order_headers_all ooha
        ,HR_ORGANIZATION_UNITS hou
        ,khs_shipconfirm_web ksw
        WHERE 1=1
        AND wdd.SOURCE_HEADER_ID = ooha.HEADER_ID
        AND wdd.ORG_ID = hou.ORGANIZATION_ID
        AND wdd.RELEASED_STATUS = 'Y'
        AND not exists (select wdd1.BATCH_ID from wsh_delivery_details wdd1 where wdd1.BATCH_ID = wdd.BATCH_ID and wdd1.RELEASED_STATUS = 'S')
        AND wdd.BATCH_ID = ksw.WDD_BATCH_ID
        AND ksw.TRX_NUMBER is null";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function DoFinish()
    {
        $sql = "select
        ksw.WDD_BATCH_ID
        ,ksw.OOH_ORDER_NUMBER
        ,hou.NAME
        ,ksw.TRX_NUMBER
        ,ksw.CETAK_INVOICE_REQ_ID
        ,ksw.CETAK_RDO_REQ_ID
        from
        khs_shipconfirm_web ksw
        ,HR_ORGANIZATION_UNITS hou
        ,OE_ORDER_HEADERS_ALL OOHA
        where
        ksw.TRX_NUMBER is not null
        and ksw.CETAK_RDO_REQ_ID is not null
        and ksw.OOH_ORDER_NUMBER = ooha.ORDER_NUMBER
        and ooha.ORG_ID = hou.ORGANIZATION_ID";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function InvoiceToCetak($i)
    {
        $sql = "SELECT * FROM khs_inv_penj_format_kecil WHERE REQUEST_ID = $i";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function RDOToCetak($i)
    {
        $sql = "SELECT * FROM khs_cetak_ulang_rdo WHERE REQUEST_ID = $i order by ADJ_NAME";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}
