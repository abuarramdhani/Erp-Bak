<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_rkhkasie extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
  }

  public function getKodbar($term) {
    $oracle = $this->load->database('oracle_dev', true);
    $sql = " SELECT   mp.organization_code, msi.secondary_inventory_name subinv,
                 msib.inventory_item_id, msib.segment1 kode_barang,
                 msib.description,
                 --khs_inv_qty_oh (225, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) on_hand,
                 msib.primary_uom_code
                 ,msib.SEGMENT1||' - '||msib.DESCRIPTION                        item
            FROM mtl_parameters mp,
                 mtl_secondary_inventories msi,
                 mtl_system_items_b msib
           WHERE mp.organization_id = 225
             AND msi.secondary_inventory_name = 'SP-YSP'
             AND mp.organization_id = msi.organization_id
             AND msib.organization_id = msi.organization_id
             AND (msib.SEGMENT1||' - '||msib.DESCRIPTION) like '%$term%' ";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
    public function getResultBom($kodeitem) {
    $oracle = $this->load->database('oracle_dev', true);
    $sql = " SELECT   mp.organization_code, msi.secondary_inventory_name subinv,
                 msib.inventory_item_id, msib.segment1 kode_barang,
                 msib.description,
                 --khs_inv_qty_oh (225, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) on_hand,
                 msib.primary_uom_code
                 ,msib.SEGMENT1||' - '||msib.DESCRIPTION                        item
            FROM mtl_parameters mp,
                 mtl_secondary_inventories msi,
                 mtl_system_items_b msib
           WHERE mp.organization_id = 225
             AND msi.secondary_inventory_name = 'SP-YSP'
             AND mp.organization_id = msi.organization_id
             AND msib.organization_id = msi.organization_id
             AND msib.SEGMENT1 = '$kodeitem' ";

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
 public function getDetailBom($kodebarang) {
    $oracle = $this->load->database('oracle_dev', true);
    $sql = " SELECT 
       rownum line_id
       ,CONNECT_BY_ROOT q_bom.assembly_num                                      root_assembly
       ,q_bom.component_num
       ,q_bom.component_id
       ,q_bom.description
       ,q_bom.item_num
       ,q_bom.item_type
       ,q_bom.qty
       ,q_bom.uom
       ,SUBSTR(SYS_CONNECT_BY_PATH(q_bom.assembly_Num, ' <-- '),5)              assembly_path
       ,LEVEL  bom_level
       ,organization_id
       ,organization_code
       ,item_cost--,  CONNECT_BY_ISCYCLE is_cycle
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

    $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }

}