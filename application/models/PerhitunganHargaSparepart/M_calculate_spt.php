<?php
defined('BASEPATH') or die('No direct script access allowed');

class M_calculate_spt extends CI_Model
{
  private $oracle;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->oracle = $this->load->database('oracle', true);
  }

  public function selectPending()
  {
    return $this->oracle
      ->query(
        "SELECT khs.*, msib.description item_desc, msib.segment1 item_code
        FROM khs_hitung_spt khs, mtl_system_items_b msib
       WHERE khs.item_id = msib.inventory_item_id
         AND khs.order_id = khs.order_id
         AND NVL (khs.progress_id, 0) NOT IN (-1, 3)
         AND msib.organization_id = 81"
      )->result();
  }
  public function RejectPIEA()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.comments comments_reject,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 2
    and khs_appr.approved_flag = 'N'
    and msib.organization_id = 81";
    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function RejectAKt()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.comments comments_reject,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 3
    and khs_appr.approved_flag = 'N'
    and msib.organization_id = 81";
    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function insertRows($rows)
  {
    $this->oracle
      ->insert_batch(strtoupper('apps.khs_hitung_spt'), $rows);
  }
  public function selectSelesai()
  {
    return $this->oracle
      ->query(
        "select distinct
        khs.*,
        msib.description item_desc,
        msib.segment1 item_code
   from
        khs_hitung_spt khs,
        mtl_system_items_b msib,
        khs_approval_hitung_spt khs_appr
   where
        khs.item_id = msib.inventory_item_id
        and khs_appr.order_id = khs.order_id 
        and msib.organization_id = 81
        and khs.progress_id = 3"
      )->result();
  }
  public function selectApprove1()
  {
    return $this->oracle
      ->query(
        "select
        khs.*,
        msib.description item_desc,
        msib.segment1 item_code
    from
        khs_hitung_spt khs,
        khs_approval_hitung_spt khs_appr,
        mtl_system_items_b msib
    where
        khs.item_id = msib.inventory_item_id
        and khs_appr.order_id = khs.order_id
        and khs_appr.approval_id = 1
        and khs_appr.approved_flag is null
        and msib.organization_id = 81"
      )->result();
  }
  public function cekOrderId($id)
  {
    return $this->oracle
      ->query(
        "SELECT * FROM KHS_HITUNG_SPT WHERE ORDER_ID =$id"
      )->result();
  }
  public function insertApproval($rows)
  {
    $this->oracle
      ->insert_batch(strtoupper('apps.KHS_APPROVAL_HITUNG_SPT'), $rows);
  }
  public function select_piea_user()
  {
    $sql = "SELECT su.user_id, su.user_name , er.employee_name ,sugm.user_group_menu_id, sugm.user_group_menu_name
    FROM sys.sys_user su,
    sys.sys_user_application sua,
    sys.sys_user_group_menu sugm,
    sys.sys_module smod,
    er.er_employee_all er
    where
    su.user_id = sua.user_id
    AND sua.user_group_menu_id = sugm.user_group_menu_id
    AND smod.module_id= sugm.module_id
    and sugm.user_group_menu_id = 2826
    and er.employee_code = su.user_name
    order by sugm.user_group_menu_name";

    $q = $this->db->query($sql);
    return $q->result_array();
  }
  public function UpdateApprovalMkt($a, $i)
  {
    $sql = "UPDATE khs_approval_hitung_spt set APPROVED_FLAG = 'Y', APPROVED_BY ='$i' where APPROVAL_ID=1 and ORDER_ID = $a";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function UpdateApprovalMktOrder($a)
  {
    $sql = "UPDATE khs_hitung_spt set PROGRESS_ID = 1 where ORDER_ID = $a";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function UpdateApprovaltoPIEA($a, $i)
  {
    $sql = "UPDATE khs_approval_hitung_spt set APPROVED_BY ='$i' where APPROVAL_ID = 2 and ORDER_ID = $a";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function UpdateRejectMkt($o, $i, $a)
  {
    $sql = "UPDATE khs_approval_hitung_spt set APPROVED_FLAG = 'N', APPROVED_BY ='$i', COMMENTS = '$a' where APPROVAL_ID = 1 and ORDER_ID = $o";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function UpdateRejectOrder($a)
  {
    $sql = "UPDATE khs_hitung_spt set PROGRESS_ID = -1 where ORDER_ID = $a";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function selectApprovedMkt()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 1
    and khs_appr.approved_flag = 'Y'
    and msib.organization_id = 81";

    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function selectRejectedMkt()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.comments comments_reject,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 1
    and khs_appr.approved_flag = 'N'
    and msib.organization_id = 81";

    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function PendingPIEA()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 2
    and khs.progress_id = 1
    and khs_appr.approved_flag is NULL
    and msib.organization_id = 81";

    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function PendingAccountancy()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 3
    and khs.progress_id = 2
    and khs_appr.approved_flag is NULL
    and msib.organization_id = 81";

    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function selectApprove2()
  {
    return $this->oracle
      ->query(
        "select
        khs.*,
        msib.description item_desc,
        msib.segment1 item_code
    from
        khs_hitung_spt khs,
        khs_approval_hitung_spt khs_appr,
        mtl_system_items_b msib
    where
        khs.item_id = msib.inventory_item_id
        and khs_appr.order_id = khs.order_id
        and khs_appr.approval_id = 2
        and khs_appr.approved_flag is null
        and msib.organization_id = 81"
      )->result();
  }
  public function UpdateApprovalPIEA($id, $induk)
  {
    $sql = "UPDATE khs_approval_hitung_spt set APPROVED_FLAG = 'Y', APPROVED_BY ='$induk' where APPROVAL_ID = 2 and ORDER_ID = $id";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function UpdateApprovalPIEAOrder($id, $master_item, $bom, $routing)
  {
    $sql = "UPDATE khs_hitung_spt set ITEM_FLAG ='$master_item', BOM_FLAG = '$bom', ROUTING_FLAG = '$routing', PROGRESS_ID = 2 where ORDER_ID = $id";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function UpdateRejectPIEA($o, $i, $a)
  {
    $sql = "UPDATE khs_approval_hitung_spt set APPROVED_FLAG = 'N', APPROVED_BY ='$i', COMMENTS = '$a' where APPROVAL_ID = 2 and ORDER_ID = $o";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function ApprovedPIEA()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 2
    and khs_appr.approved_flag = 'Y'
    and msib.organization_id = 81";

    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function SelectApprove3()
  {
    $sql = "select
        khs.*,
        msib.description item_desc,
        msib.segment1 item_code
    from
        khs_hitung_spt khs,
        khs_approval_hitung_spt khs_appr,
        mtl_system_items_b msib
    where
        khs.item_id = msib.inventory_item_id
        and khs_appr.order_id = khs.order_id
        and khs.progress_id = 2
        and khs_appr.approved_flag is null
        and msib.organization_id = 81";

    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function UpdateApprAkt($i, $induk)
  {
    $sql = "UPDATE khs_approval_hitung_spt set APPROVED_FLAG = 'Y',APPROVED_BY ='$induk' where APPROVAL_ID = 3 and ORDER_ID = $i";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function UpdateApprovalAktOrder($a, $f)
  {
    $sql = "UPDATE khs_hitung_spt set PROGRESS_ID = 3, FILE_SPT ='$f' where ORDER_ID = $a";

    $q = $this->oracle->query($sql);
    return $sql;
  }
  public function SelectApprovedAkt()
  {
    $sql = "select
    khs.*,
    msib.description item_desc,
    msib.segment1 item_code,
    khs_appr.approved_flag,
    khs_appr.action_date
from
    khs_hitung_spt khs,
    khs_approval_hitung_spt khs_appr,
    mtl_system_items_b msib
where
    khs.item_id = msib.inventory_item_id
    and khs_appr.order_id = khs.order_id
    and khs_appr.approval_id = 3
    and khs_appr.approved_flag = 'Y'
    and msib.organization_id = 81";

    $q = $this->oracle->query($sql);
    return $q->result_array();
  }
  public function UpdateRejectAkt($o, $i, $a)
  {
    $sql = "UPDATE khs_approval_hitung_spt set APPROVED_FLAG = 'N', APPROVED_BY ='$i', COMMENTS = '$a' where APPROVAL_ID = 3 and ORDER_ID = $o";

    $q = $this->oracle->query($sql);
    return $sql;
  }
}
