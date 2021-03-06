<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_replacecomp extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',true);
        $this->personalia = $this->load->database('personalia',true);
    }

    public function getJobHeader($id=FALSE)
    {
      $sql = "SELECT we.WIP_ENTITY_NAME ,
                     TO_CHAR(wdj.DATE_RELEASED,'DD/MM/YYYY hh:mi:ss') RELEASE ,
                     msib.SEGMENT1 ,
                     msib.DESCRIPTION,
                     mil.segment1 seksi,
                     we.WIP_ENTITY_ID
              FROM mtl_system_items_b msib ,
                   wip_entities we ,
                   wip_discrete_jobs wdj,
                   bom_operational_routings bor,
                   mtl_item_locations mil
              WHERE msib.ORGANIZATION_ID = 102
                AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
                AND wdj.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
                AND wdj.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
                AND bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND wdj.COMPLETION_LOCATOR_ID = mil.INVENTORY_LOCATION_ID
                AND we.WIP_ENTITY_NAME = '$id'
              GROUP BY we.WIP_ENTITY_NAME,
                       wdj.DATE_RELEASED,
                       msib.SEGMENT1,
                       msib.DESCRIPTION,
                       mil.segment1,
                       wdj.COMPLETION_SUBINVENTORY,
                       we.WIP_ENTITY_ID
              ORDER BY wdj.DATE_RELEASED";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getJobLine($id=FALSE)
    {
      $sql = "SELECT we.WIP_ENTITY_NAME , msib.segment1 ASSY , msib.DESCRIPTION ASSY_DESC, mil.SEGMENT1 Seksi , WRO.OPERATION_SEQ_NUM , msib2.SEGMENT1, msib2.DESCRIPTION , wro.QUANTITY_ISSUED, msib2.PRIMARY_UOM_CODE , decode(wro.WIP_SUPPLY_TYPE, 1,'Push',3,'Pull') supply_type, mmt.SUBINVENTORY_CODE,
                (SELECT mil2.segment1
                 FROM mtl_item_locations mil2,
                      bom_operational_routings bor2
                 WHERE bor2.ASSEMBLY_ITEM_ID = msib2.INVENTORY_ITEM_ID
                   AND bor2.ORGANIZATION_ID = msib2.ORGANIZATION_ID
                   AND bor2.COMPLETION_LOCATOR_ID = mil2.INVENTORY_LOCATION_ID
                   AND bor2.ALTERNATE_ROUTING_DESIGNATOR IS NULL
                   AND mil2.ORGANIZATION_ID = msib2.ORGANIZATION_ID) asal,
                   msib2.INVENTORY_ITEM_ID,
                   we.ORGANIZATION_ID
              FROM mtl_system_items_b msib ,
                   mtl_system_items_b msib2 ,
                   wip_entities we ,
                   wip_discrete_jobs wdj ,
                   bom_operational_routings bor ,
                   mtl_item_locations mil,
                   mtl_material_transactions mmt,
                   WIP_REQUIREMENT_OPERATIONS WRO
              WHERE msib2.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
                AND wdj.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
                AND wdj.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND we.WIP_ENTITY_NAME = '$id'
                AND bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
                AND bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND bor.COMPLETION_LOCATOR_ID = mil.INVENTORY_LOCATION_ID
                AND mil.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND mmt.TRANSACTION_SOURCE_ID = we.WIP_ENTITY_ID
                AND mmt.INVENTORY_ITEM_ID = msib2.INVENTORY_ITEM_ID
                AND WRO.WIP_ENTITY_ID = WE.WIP_ENTITY_ID
                AND WRO.ORGANIZATION_ID = msib2.ORGANIZATION_ID
                AND wro.INVENTORY_ITEM_ID = msib2.INVENTORY_ITEM_ID
                -- AND we.ORGANIZATION_ID = 102
                AND wro.WIP_SUPPLY_TYPE = 1
              GROUP BY we.WIP_ENTITY_NAME ,
                       msib.segment1 ,
                       msib.DESCRIPTION ,
                       mil.SEGMENT1 ,
                       msib2.SEGMENT1,
                       msib2.DESCRIPTION ,
                       msib2.PRIMARY_UOM_CODE ,
                       mmt.SUBINVENTORY_CODE,
                       msib2.INVENTORY_ITEM_ID,
                       msib2.ORGANIZATION_ID,
                       wro.QUANTITY_ISSUED,
                       WRO.OPERATION_SEQ_NUM,
                       wro.WIP_SUPPLY_TYPE,
                       we.ORGANIZATION_ID
              ORDER BY wro.OPERATION_SEQ_NUM ASC";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function deleteRejectComp($id)
    {
      $this->db->where('job_number', $id);
      $this->db->delete('mo.mo_replacement_component');
    }

    public function getJobLineReject($id, $subinv=FALSE)
    {
      if ($subinv === FALSE) {
        $this->db->select('*');
        $this->db->from('mo.mo_replacement_component');
        $this->db->where('job_number', $id);
      }else{
        $this->db->select('*');
        $this->db->from('mo.mo_replacement_component');
        $this->db->where('job_number', $id);
        $this->db->where('subinventory_code', $subinv);
      }
      $query = $this->db->get();
      return $query->result_array();
    }

    public function getJobReplacementNumber($id,$subinv)
    {
      $this->db->select('*');
      $this->db->from('mo.mo_replacement_job');
      $this->db->where('job_number', $id);
      $this->db->where('subinventory_code', $subinv);

      $query = $this->db->get();
      return $query->result_array();
    }

    public function getLatestJobReplacementNumber($codeNumber)
    {
      $sql  = " SELECT max(replacement_number)
                FROM mo.mo_replacement_job
                WHERE replacement_number LIKE '$codeNumber%'";
      $query= $this->db->query($sql);
      return $query->result_array();
    }

    public function setJobReplacementNumber($data)
    {
      $this->db->insert('mo.mo_replacement_job', $data);

      $id = $this->db->insert_id();
      $this->db->select('*');
      $this->db->from('mo.mo_replacement_job');
      $this->db->where('replacement_job_id', $id);

      $query = $this->db->get();
      return $query->result_array();
    }
}