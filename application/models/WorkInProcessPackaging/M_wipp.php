<?php
class M_wipp extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }


  public function minMax($value)
  {
    $res = [];
    // $res = $this->oracle->where('KODE_ASSY', $valaue)->get('KHS_SP_MINMAX')->result_array();
    return $res;
  }

   public function LabelKecil($segment_1)
   {
     $res = $this->oracle->query("SELECT  distinct msib.SEGMENT1,
           '*'||replace(msib.SEGMENT1,' ','')||'*' barcode,
            substr(msib.DESCRIPTION,1,53) DESCRIPTION,
            to_char(sysdate,'DD-MM-RR') tanggal,
         (select distinct substr(MCK1.SEGMENT1,4) TYPE
                   from
                      MTL_MATERIAL_TRANSACTIONS MMT1,
                      MTL_SYSTEM_ITEMS_B MSIB1,
                      MTL_ITEM_CATEGORIES MIC1,
                      mtl_category_sets_tl MCST1,
                      mtl_categories_b_kfv MCK1
                   where
                      MMT1.INVENTORY_ITEM_ID = MSIB1.INVENTORY_ITEM_ID
                      and MIC1.INVENTORY_ITEM_ID = MSIB1.INVENTORY_ITEM_ID
                      and MCST1.CATEGORY_SET_ID = MIC1.CATEGORY_SET_ID
                      and MCST1.CATEGORY_SET_NAME = 'KHS CETAK BARCODE'
                      and MCK1.CATEGORY_ID = MIC1.CATEGORY_ID
                      and MSIB1.SEGMENT1 =  '".$segment_1."'
                      and MIC1.ORGANIZATION_ID = MMT1.ORGANIZATION_ID
                      and MIC1.INVENTORY_ITEM_ID = MMT1.INVENTORY_ITEM_ID
                      and MMT1.ORGANIZATION_ID = MSIB1.ORGANIZATION_ID) TYPE
     from
          MTL_SYSTEM_ITEMS_B msib
     where
         msib.ORGANIZATION_ID = '102'
         and msib.SEGMENT1 like '$segment_1'
     order by msib.SEGMENT1")->result_array();

     return $res;
   }

   public function cek_job($nojob)
   {
     $res = $this->db->select('id, qty, nama_item, usage_rate, scedule_start_date, waktu_satu_shift, photo')->where('no_job', $nojob)->get('wip_pnp.job_list')->result_array();
     return $res;
   }

    public function cekLineSaved($date)
    {
        $response = $this->db->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        if (empty($response)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function cekLineSaved2($date)
    {
        $response = $this->db->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline1($date)
    {
        $response = $this->db->where('line', 1)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline2($date)
    {
        $response = $this->db->where('line', 2)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline3($date)
    {
        $response = $this->db->where('line', 3)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline4($date)
    {
        $response = $this->db->where('line', 4)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function getline5($date)
    {
        $response = $this->db->where('line', 5)->where('date_target', $date)->get('wip_pnp.line_data')->result_array();
        return $response;
    }

    public function ceklineaja($param)
    {
        $cek = $this->db->where('date_target', $param)
                      ->get('wip_pnp.line_data')->result_array();
        if ($cek !== '') {
            $this->db->delete('wip_pnp.line_data', ['date_target' => $param]);
        }
    }

    public function insert_data_line($data)
    {
        $this->db->insert('wip_pnp.line_data', $data);
    }

    public function updateTarget_Pe($param, $data)
    {
        $this->db->where('nama', $param)->update('wip_pnp.line', ['target_max' => $data]);
        if ($this->db->affected_rows() == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function setTarget_Pe($p)
    {
        if ($p == '') {
            $response = $this->db->select('target_max, nama')->order_by('nama', 'asc')->get('wip_pnp.line')->result_array();
            return $response;
        } else {
            $response = $this->db->select('target_max')->where('nama', $p)->get('wip_pnp.line')->result_array();
            return $response;
        }
    }

    public function getSplit($value, $date)
    {
        $response = $this->db->where('no_job', $value)->where('date_target', $date)->order_by('id', 'asc')->get('wip_pnp.job_list')->result_array();
        return $response;
    }

    public function insertSplit($data, $ca)
    {
        $this->db->insert('wip_pnp.job_list', $data);
        if ($this->db->affected_rows() == 1) {
            return 1;
        } else {
            return 2;
        }

    }

    public function insertSplit_($data, $ca)
    {
        $cek = $this->db->select('no_job, date_target')
                      ->where('create_at', $ca)
                      ->get('wip_pnp.job_list')
                      ->row();
        if (!empty($cek->no_job)) {
            $nj = $cek->no_job;
            $this->db->delete('wip_pnp.job_list', ['no_job' => $nj, 'create_at' => $ca]);
            $this->db->insert('wip_pnp.job_list', $data);
            if ($this->db->affected_rows() == 1) {
                return 1;
            } else {
                return 2;
            }
        } else {
            $this->db->insert('wip_pnp.job_list', $data);
            if ($this->db->affected_rows() == 1) {
                return 1;
            } else {
                return 2;
            }

        }
    }

    public function delete_parent_job($id)
    {
      $this->db->delete('wip_pnp.job_list', ['kode_item' => $id]);
    }

    public function getPhoto()
    {
        $response = $this->db->distinct()
                             ->select('kode_item, nama_item, photo')->where('photo !=', null)
                             ->get('wip_pnp.item_photo')
                             ->result_array();
        return $response;
    }

    public function delete_photo($id)
    {
      $this->db->delete('wip_pnp.item_photo', ['kode_item' => $id]);
      if ($this->db->affected_rows() == 1) {
          return 1;
      } else {
          return 2;
      }
    }

    public function insertPhoto($data)
    {
        $cek = $this->db->select('kode_item')->where('kode_item', $data['kode_item'])->get('wip_pnp.item_photo')->row();
        if (!empty($cek->kode_item)) {
          $this->where('kode_item', $data['kode_item'])->update('wip_pnp.item_photo', $data);
        }else {
          $this->db->insert('wip_pnp.item_photo', $data);
        }
    }

    // public function getListRKH($value)
    // {
    //     $wipp = $this->db->select('wip_pnp.job_list.*
    //                             , wip_pnp.split_job.no_job as no_job_split
    //                             , wip_pnp.split_job.item as kode_item_split
    //                             , wip_pnp.split_job.qty as qty_split
    //                             , wip_pnp.split_job.id_split
    //                             , wip_pnp.split_job.target_pe as target_pe_split')
    //                    ->join('wip_pnp.split_job', 'wip_pnp.split_job.date_target = wip_pnp.job_list.date_target and wip_pnp.split_job.no_job = wip_pnp.job_list.no_job', 'left')
    //                    ->where('wip_pnp.job_list.date_target', $value)
    //                    ->order_by('kode_item', 'asc')
    //                    ->get('wip_pnp.job_list')
    //                    ->result_array();
    //     return $wipp;
    // }

    public function getListRKH($value)
    {
        $wipp = $this->db->select('wip_pnp.job_list.*')
                       ->where('wip_pnp.job_list.date_target', $value)
                       ->order_by('kode_item', 'asc')
                       ->get('wip_pnp.job_list')
                       ->result_array();
        return $wipp;
    }

    public function getLR()
    {
        $wipp = $this->db->distinct()
                       ->select('date_target, waktu_satu_shift')
                       ->order_by('date_target', 'desc')
                       ->get('wip_pnp.job_list')->result_array();
        return $wipp;
    }

    public function ceknojob($nj)
    {
        $cek = $this->db->select('no_job')
                         ->where('no_job', $nj)
                         ->get('wip_pnp.job_list')
                         ->row();
        if (!empty($cek->no_job)) {
            $val = [
         'status' => 2,
         'no_job' => $cek->no_job
       ];
            return $val;
        } else {
            return 1;
        }
    }

    public function savenewRKH($data)
    {
        if (!empty($data['date_target'])) {
            $this->db->insert('wip_pnp.job_list', $data);
            return 1;
        } else {
            return 0;
        }
    }

    public function getPP()
    {
        $wipp = $this->db->order_by('kode_item', 'asc')->get('wip_pnp.product_priority')->result_array();
        return $wipp;
    }

    public function productPriorityDelete($data)
    {
        if (!empty($data['id'])) {
            $this->db->where('id', $data['id'])->delete('wip_pnp.product_priority');
            return 1;
        } else {
            return 0;
        }
    }

    public function productPrioritySave($data)
    {
        $cek = $this->db->select('kode_item')->where('kode_item', $data['kode_item'])->get('wip_pnp.product_priority')->row();
        if (!empty($cek->kode_item)) {
            return 2;
        } else {
            if (!empty($data['kode_item']) && !empty($data['nama_item'])) {
                $this->db->insert('wip_pnp.product_priority', $data);
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function JobRelease()
    {
        $response = $this->oracle->query("SELECT DISTINCT we.wip_entity_name no_job
                         ,wdj.SCHEDULED_START_DATE
                         ,wdj.completion_subinventory
                         ,msib_assy.segment1 kode_assy
                         ,msib_assy.DESCRIPTION
                         ,wdj.start_quantity
                         ,khs_inv_qty_oh (225, 
                                         msib_assy.inventory_item_id,
                                         'SP-YSP',
                                         NULL,
                                         NULL
                                        ) onhand_ysp
                         ,bd.department_code
                         ,bores.usage_rate_or_amount
                    FROM wip_entities we,
                         wip_discrete_jobs wdj,
                         wip_requirement_operations wro,
                         mtl_system_items_b msib_comp,
                         mtl_system_items_b msib_assy,
                         bom_departments bd,
                         bom_operation_sequences bos,
                         bom_operation_resources bores,
                         bom_operational_routings bor,
                         bom_resources br
                   WHERE we.wip_entity_id = wdj.wip_entity_id
                     AND wdj.completion_subinventory LIKE 'INT-P&%'
                     AND wdj.wip_entity_id = wro.wip_entity_id
                     AND wro.inventory_item_id = msib_comp.inventory_item_id
                     AND wro.organization_id = msib_comp.organization_id
                     AND wdj.primary_item_id = msib_assy.inventory_item_id
                     AND wdj.organization_id = msib_assy.organization_id
                     --
                     AND bor.assembly_item_id = msib_assy.inventory_item_id
                     AND bor.organization_id = msib_assy.organization_id
                     AND bos.routing_sequence_id = bor.routing_sequence_id
                     AND bd.department_id = bos.department_id
                     AND wro.department_id = bd.department_id
                     AND bores.operation_sequence_id = bos.operation_sequence_id
                     AND bores.resource_id = br.resource_id
                     AND wdj.STATUS_TYPE = 3
                     AND br.resource_code not like 'OPTR%'
                     AND bd.department_code like 'PP%'
                     order by msib_assy.segment1 ASC, wdj.SCHEDULED_START_DATE DESC")->result_array();
        return $response;
    }

    public function JobReleaseSelected($d)
    {
      $response = $this->oracle->query("SELECT DISTINCT msib_assy.segment1 kode_assy
                       -- ,we.wip_entity_name no_job
                       ,wdj.SCHEDULED_START_DATE
                       ,wdj.completion_subinventory
                       ,msib_assy.DESCRIPTION
                --        ,wdj.start_quantity
                --        ,khs_inv_qty_oh (225, 
                --                        msib_assy.inventory_item_id,
                --                        'SP-YSP',
                --                        NULL,
                --                        NULL
                --                       ) onhand_ysp
                       ,bd.department_code
                --        ,bores.usage_rate_or_amount
                  FROM wip_entities we,
                       wip_discrete_jobs wdj,
                       wip_requirement_operations wro,
                       mtl_system_items_b msib_comp,
                       mtl_system_items_b msib_assy,
                       bom_departments bd,
                       bom_operation_sequences bos,
                       bom_operation_resources bores,
                       bom_operational_routings bor,
                       bom_resources br
                 WHERE we.wip_entity_id = wdj.wip_entity_id
                   AND wdj.completion_subinventory LIKE 'INT-P&%'
                   AND wdj.wip_entity_id = wro.wip_entity_id
                   AND wro.inventory_item_id = msib_comp.inventory_item_id
                   AND wro.organization_id = msib_comp.organization_id
                   AND wdj.primary_item_id = msib_assy.inventory_item_id
                   AND wdj.organization_id = msib_assy.organization_id
                   --
                   AND bor.assembly_item_id = msib_assy.inventory_item_id
                   AND bor.organization_id = msib_assy.organization_id
                   AND bos.routing_sequence_id = bor.routing_sequence_id
                   AND bd.department_id = bos.department_id
                   AND wro.department_id = bd.department_id
                   AND bores.operation_sequence_id = bos.operation_sequence_id
                   AND bores.resource_id = br.resource_id
                   AND wdj.STATUS_TYPE = 3
                   AND br.resource_code not like 'OPTR%'
                   AND bd.department_code like 'PP%'
                   AND (msib_assy.segment1 LIKE '$d%'OR msib_assy.DESCRIPTION LIKE '$d%')
                   order by msib_assy.segment1 ASC, wdj.SCHEDULED_START_DATE DESC")->result_array();
        return $response;
    }

    public function getitembykodeitem($kode_item)
    {
      $response = $this->oracle->query("SELECT DISTINCT we.wip_entity_name no_job
                       ,wdj.SCHEDULED_START_DATE
                       ,wdj.completion_subinventory
                       ,msib_assy.segment1 kode_assy
                       ,msib_assy.DESCRIPTION
                       ,wdj.start_quantity
                       ,khs_inv_qty_oh (225, 
                                       msib_assy.inventory_item_id,
                                       'SP-YSP',
                                       NULL,
                                       NULL
                                      ) onhand_ysp
                       ,bd.department_code
                       ,bores.usage_rate_or_amount
                  FROM wip_entities we,
                       wip_discrete_jobs wdj,
                       wip_requirement_operations wro,
                       mtl_system_items_b msib_comp,
                       mtl_system_items_b msib_assy,
                       bom_departments bd,
                       bom_operation_sequences bos,
                       bom_operation_resources bores,
                       bom_operational_routings bor,
                       bom_resources br
                 WHERE we.wip_entity_id = wdj.wip_entity_id
                   AND wdj.completion_subinventory LIKE 'INT-P&%'
                   AND wdj.wip_entity_id = wro.wip_entity_id
                   AND wro.inventory_item_id = msib_comp.inventory_item_id
                   AND wro.organization_id = msib_comp.organization_id
                   AND wdj.primary_item_id = msib_assy.inventory_item_id
                   AND wdj.organization_id = msib_assy.organization_id
                   --
                   AND bor.assembly_item_id = msib_assy.inventory_item_id
                   AND bor.organization_id = msib_assy.organization_id
                   AND bos.routing_sequence_id = bor.routing_sequence_id
                   AND bd.department_id = bos.department_id
                   AND wro.department_id = bd.department_id
                   AND bores.operation_sequence_id = bos.operation_sequence_id
                   AND bores.resource_id = br.resource_id
                   AND wdj.STATUS_TYPE = 3
                   AND br.resource_code not like 'OPTR%'
                   AND bd.department_code like 'PP%'
                   AND msib_assy.segment1 LIKE '$kode_item'
                   order by msib_assy.segment1 ASC, wdj.SCHEDULED_START_DATE DESC")->result_array();

        if (!empty($response)) {
           return $response;
        }else {
          $responses = [];
          return $responses;
        }
    }

    public function getDetailBom($kodebarang)
    {
        $sql = " SELECT
        rownum line_id
        ,CONNECT_BY_ROOT q_bom.assembly_num root_assembly
        -- ,q_bom.component_num
        -- ,q_bom.component_id
        ,q_bom.description
        -- ,q_bom.item_num
        -- ,q_bom.item_type
        -- ,q_bom.qty
        -- ,q_bom.uom
        -- ,SUBSTR(SYS_CONNECT_BY_PATH(q_bom.assembly_Num, ' <-- '),5) assembly_path
        -- ,LEVEL  bom_level
        -- ,organization_id
        -- ,organization_code
        -- ,item_cost--,  CONNECT_BY_ISCYCLE is_cycle
         FROM
         (SELECT mb1.segment1 assembly_num, mb2.segment1 component_num,
                 mb2.inventory_item_id component_id, mb2.description,
                 bc.item_num, flv.meaning item_type, bc.component_quantity qty,
                 mb2.primary_uom_code uom, mb1.organization_id, mp.organization_code,
                 (SELECT cic.item_cost
                    FROM cst_item_costs cic
                   WHERE mb2.inventory_item_id = cic.inventory_item_id
                     AND mb2.organization_id = cic.organization_id
                     AND cic.cost_type_id = 1020--KHSStandar
                 ) item_cost
          FROM   bom.bom_components_b bc,
                 bom.bom_structures_b bs,
                 inv.mtl_system_items_b mb1,
                 inv.mtl_system_items_b mb2,
                 fnd_lookup_values flv,
                 mtl_parameters mp
          WHERE  bs.assembly_item_id = mb1.inventory_item_id
             AND bc.component_item_id = mb2.inventory_item_id
             AND bc.bill_sequence_id = bs.bill_sequence_id
             AND mb1.organization_id = mb2.organization_id
             AND bs.organization_id = mb2.organization_id
             AND bc.disable_date IS NULL
             AND bs.alternate_bom_designator IS NULL
             AND mb1.organization_id = NVL (102, mb1.organization_id) --in (102,386)
             AND mp.organization_id = mb1.organization_id
             AND mb2.item_type = flv.lookup_code
             AND flv.lookup_type = 'ITEM_TYPE'
         ) q_bom
         WHERE
         q_bom.component_num LIKE 'MGA%'
       START WITH  q_bom.assembly_Num IN ('$kodebarang')
       CONNECT BY NOCYCLE PRIOR q_bom.component_num = q_bom.assembly_num
       ORDER SIBLINGS BY q_bom.assembly_Num, q_bom.item_num";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}
