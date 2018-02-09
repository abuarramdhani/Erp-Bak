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
                     mil.segment1 seksi
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
                       wdj.COMPLETION_SUBINVENTORY
              ORDER BY wdj.DATE_RELEASED";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getJobLine($id=FALSE)
    {
      $sql = "SELECT we.WIP_ENTITY_NAME ,
                     msib.segment1 ASSY ,
                     msib.DESCRIPTION ASSY_DESC,
                     mil.SEGMENT1 Seksi ,
                     bcb.ITEM_NUM ,
                     msib2.SEGMENT1,
                     msib2.DESCRIPTION ,
                     bcb.COMPONENT_QUANTITY,
                     msib2.PRIMARY_UOM_CODE ,
                     decode(bcb.WIP_SUPPLY_TYPE, 1,'Push',3,'Pull') supply_type,
                     mmt.SUBINVENTORY_CODE
              FROM bom_bill_of_materials bbom ,
                   bom_components_b bcb ,
                   mtl_system_items_b msib ,
                   mtl_system_items_b msib2 ,
                   wip_entities we ,
                   wip_discrete_jobs wdj ,
                   bom_operational_routings bor ,
                   mtl_item_locations mil,
                   mtl_material_transactions mmt
              WHERE bbom.BILL_SEQUENCE_ID = bcb.BILL_SEQUENCE_ID
                AND bbom.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
                AND bbom.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND msib2.INVENTORY_ITEM_ID = bcb.COMPONENT_ITEM_ID
                AND msib2.ORGANIZATION_ID = msib.ORGANIZATION_ID
                AND bbom.ORGANIZATION_ID = 102
                AND bbom.ALTERNATE_BOM_DESIGNATOR IS NULL
                AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                AND bcb.DISABLE_DATE IS NULL
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
              GROUP BY we.WIP_ENTITY_NAME ,
                       msib.segment1 ,
                       msib.DESCRIPTION ,
                       mil.SEGMENT1 ,
                       bcb.ITEM_NUM ,
                       msib2.SEGMENT1,
                       msib2.DESCRIPTION ,
                       bcb.COMPONENT_QUANTITY,
                       msib2.PRIMARY_UOM_CODE ,
                       bcb.WIP_SUPPLY_TYPE,
                       mmt.SUBINVENTORY_CODE
              ORDER BY bcb.ITEM_NUM ASC";
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

    public function getJobReplacementNumber($id)
    {
      $this->db->select('*');
      $this->db->from('mo.mo_replacement_job');
      $this->db->where('job_number', $id);

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