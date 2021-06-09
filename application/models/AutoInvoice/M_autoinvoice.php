<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_autoinvoice extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    public function DoReady()
    {
        $sql = "select * from auto_inv_do_ready";

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
       ,wdd.source_line_id
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
        ,null
        ,null
        FROM
        wsh_delivery_details wdd
        ,WSH_DELIVERY_ASSIGNMENTS WDA
        WHERE 1=1
        AND wda.DELIVERY_DETAIL_ID = wdd.DELIVERY_DETAIL_ID
        AND wdd.BATCH_ID = $do -- parameter
        AND wda.DELIVERY_ID is not null";

        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function DoProcess()
    {
        $sql = "select * from auto_inv_do_process";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function DoFinish()
    {
        $sql = "select * from auto_inv_do_finish";

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
    public function UpdateFlagFinish($wdd, $flag, $approver)
    {
        $sql = "UPDATE KHS_SHIPCONFIRM_WEB SET APPROVAL_FLAG = '$flag', APPROVED_BY = '$approver' WHERE WDD_BATCH_ID = $wdd";

        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function getApprover($i)
    {
        $sql = "SELECT APPROVED_BY FROM KHS_SHIPCONFIRM_WEB WHERE WDD_BATCH_ID = $i";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getApprover2($i)
    {
        $sql = "SELECT APPROVED_BY FROM KHS_SHIPCONFIRM_WEB WHERE CETAK_RDO_REQ_ID = $i";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getnameApprover($i)
    {
        $sql = "SELECT trim(nama) as nama FROM hrd_khs.tpribadi WHERE noind = '$i'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }
}
