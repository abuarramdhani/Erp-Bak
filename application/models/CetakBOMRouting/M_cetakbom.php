<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetakbom extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
  }

  public function selectproduk($term) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT distinct
            kjb.KODE_DIGIT
            ,kjb.JENIS_BARANG 
            ,kjb.DESCRIPTION
            from khs_jenis_barang kjb
            ,mtl_system_items_b msib
            where msib.ORGANIZATION_ID = 81
            and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
            and kjb.JENIS_BARANG = 'KOMPONEN/IMPLEMEN'
            and kjb.KODE_DIGIT(+) = case when substr(msib.SEGMENT1,0,2) in ('MF','RZ')
            then substr(msib.SEGMENT1,0,4)
            when substr(msib.SEGMENT1,0,2) = 'ME'
            then substr(msib.SEGMENT1,0,9)
            when substr(msib.SEGMENT1,0,3) in ('MDN','MDP')
            then substr(msib.SEGMENT1,0,4)
            when substr(msib.SEGMENT1,0,1) = ('L')
            and substr(msib.SEGMENT1,0,2) not in ('LB','LK','LL','LP','L-')
            then substr(msib.SEGMENT1,0,2)
            when substr(msib.SEGMENT1,0,2) = 'RS'
            then substr(msib.SEGMENT1,0,2)
            else substr(msib.SEGMENT1,0,3)
            end
            and kjb.DESCRIPTION like '%$term%'
            order by 1,2
 ";

       $query = $oracle->query($sql);
        return $query->result_array();
 }
  public function selectprodukdesc($produk) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT distinct
            kjb.KODE_DIGIT
            ,kjb.JENIS_BARANG 
            ,kjb.DESCRIPTION
            from khs_jenis_barang kjb
            ,mtl_system_items_b msib
            where msib.ORGANIZATION_ID = 81
            and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
            and kjb.JENIS_BARANG = 'KOMPONEN/IMPLEMEN'
            and kjb.KODE_DIGIT(+) = case when substr(msib.SEGMENT1,0,2) in ('MF','RZ')
            then substr(msib.SEGMENT1,0,4)
            when substr(msib.SEGMENT1,0,2) = 'ME'
            then substr(msib.SEGMENT1,0,9)
            when substr(msib.SEGMENT1,0,3) in ('MDN','MDP')
            then substr(msib.SEGMENT1,0,4)
            when substr(msib.SEGMENT1,0,1) = ('L')
            and substr(msib.SEGMENT1,0,2) not in ('LB','LK','LL','LP','L-')
            then substr(msib.SEGMENT1,0,2)
            when substr(msib.SEGMENT1,0,2) = 'RS'
            then substr(msib.SEGMENT1,0,2)
            else substr(msib.SEGMENT1,0,3)
            end
            AND kjb.KODE_DIGIT = '$produk'
            order by 1,2
 ";

       $query = $oracle->query($sql);
        return $query->result_array();
 }
   public function getkomponen($term) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT msib.segment1, msib.description 
FROM mtl_system_items_b msib 
WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'  
AND msib.organization_id = 81
AND msib.segment1 LIKE '$term%'
 ";

       $query = $oracle->query($sql);
        return $query->result_array();
 }
 public function getdesckomponen($komp) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT msib.segment1, msib.description 
FROM mtl_system_items_b msib 
WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'  
AND msib.organization_id = 81
AND msib.segment1 = '$komp'
 ";

       $query = $oracle->query($sql);
        return $query->result_array();
 }
    public function getseksiodm() {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT(bd.DEPARTMENT_CLASS_CODE) ROUTING_CLASS FROM bom_departments bd
             where bd.DISABLE_DATE is null order by bd.DEPARTMENT_CLASS_CODE asc ";

       $query = $oracle->query($sql);
        return $query->result_array();
 }
     public function getseksiopm() {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT(FRH.ROUTING_CLASS) FROM fm_rout_hdr frh";

       $query = $oracle->query($sql);
        return $query->result_array();
 }

   public function getdatapdf($kode,$seksi) {
    $oracle = $this->load->database('oracle', true);
    $sql = "
    -- SELECT DISTINCT bor.alternate_routing_designator, msib.segment1 item, msib.description,
    --             bd.department_code department, br.resource_code,
    --             bores.usage_rate_or_amount, bores.assigned_units,
    --             (SELECT crc.resource_rate
    --                FROM bom_resources br2,
    --                     cst_cost_types cct,
    --                     cst_resource_costs crc
    --               WHERE br2.organization_id = 102
    --                 AND br2.resource_id = crc.resource_id
    --                 AND cct.cost_type_id = crc.cost_type_id
    --                 AND br2.resource_code = br.resource_code) resource_cost,
    --             bos.operation_description kode_proses, bos.attribute7 proses,
    --             kdmr.no_mesin
    --        FROM bom_operational_routings bor,
    --             mtl_system_items_b msib,
    --             bom_operation_sequences bos,
    --             bom_operation_resources bores,
    --             bom_departments bd,
    --             bom_resources br,
    --             khs_daftar_mesin_resource kdmr
    --       WHERE bor.assembly_item_id = msib.inventory_item_id
    --         AND bor.organization_id = msib.organization_id
    --         AND bor.routing_sequence_id = bos.routing_sequence_id
    --         AND bos.department_id = bd.department_id
    --         AND bd.organization_id = 102
    --         AND bores.operation_sequence_id = bos.operation_sequence_id
    --         AND bores.resource_id = br.resource_id
    --         AND br.organization_id = 102
    --         AND br.disable_date IS NULL
    --         -- AND bd.disable_date IS NULL
    --         -- AND bor.alternate_routing_designator IS NULL
    --         AND kdmr.resource_id(+) = br.resource_id
    --         AND msib.segment1 = '$kode'
    --         AND bd.department_class_code = '$seksi'
    --    ORDER BY 1, 4

                    select bor.ORGANIZATION_ID
            ,msib.segment1
            ,msib.description
            ,bor.ALTERNATE_ROUTING_DESIGNATOR alt
            ,bos.OPERATION_SEQ_NUM opr_no
            ,BOS.OPERATION_DESCRIPTION KODE_PROSES
            --,BOS.ATTRIBUTE7
                ,mach.RESOURCE_CODE
                ,mach.DESCRIPTION
                ,mach.DFF
                ,mach.NO_MESIN
            --    ,mach.TAG_NUMBER
            --    ,mach.SPEC_MESIN
                ,mach.ASSIGNED_UNITS machine_qt
            ,opt.USAGE_RATE_OR_AMOUNT
            ,(opt.USAGE_RATE_OR_AMOUNT*3600) CT
            ,floor(23400/(opt.USAGE_RATE_OR_AMOUNT*3600))target
            ,opt.assigned_units opt_qty
            from mtl_system_items_b msib
            ,bom_operational_routings bor
            ,bom_operation_sequences bos
            ,bom_departments bd
                ,(select borsop.OPERATION_SEQUENCE_ID
                ,borsop.USAGE_RATE_OR_AMOUNT
                ,borsop.ASSIGNED_UNITS 
                from bom_operation_resources borsop
                ,bom_resources brop
                where borsop.RESOURCE_ID = brop.RESOURCE_ID
                and brop.RESOURCE_TYPE = 2
                and brop.DISABLE_DATE is null) opt
                ,(select borsmc.OPERATION_SEQUENCE_ID
                ,brmc.RESOURCE_CODE
                ,kdmr.DFF
                ,kdmr.NO_MESIN
                ,kdmr.TAG_NUMBER
                ,kdmr.SPEC_MESIN
                ,brmc.DESCRIPTION
                ,borsmc.ASSIGNED_UNITS 
                from bom_operation_resources borsmc
                ,bom_resources brmc
                ,khs_daftar_mesin_resource kdmr
                where borsmc.RESOURCE_ID = brmc.RESOURCE_ID
                and brmc.RESOURCE_TYPE = 1
                and brmc.AUTOCHARGE_TYPE = 1
                and brmc.DISABLE_DATE is null
                and borsmc.RESOURCE_ID = kdmr.RESOURCE_ID(+))mach
            where bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
            and bos.DEPARTMENT_ID = bd.DEPARTMENT_ID
            and bd.ORGANIZATION_ID = bor.ORGANIZATION_ID
            and bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
            and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
            and bos.DISABLE_DATE is null
            and bos.OPERATION_SEQUENCE_ID = opt.OPERATION_SEQUENCE_ID(+)
            and bos.OPERATION_SEQUENCE_ID = mach.OPERATION_SEQUENCE_ID(+)
            and msib.segment1 = '$kode'
            AND bd.department_class_code = '$seksi'
       ";

       $query = $oracle->query($sql);
        return $query->result_array();
 }

    public function getdatapdf2($kode) {
    $oracle = $this->load->database('oracle', true);
    $sql = "
--     SELECT mb1.segment1 assembly_num, mb2.segment1 component_num, mb2.description,
--        flv1.meaning item_type, bc.component_quantity qty,
--        mb2.primary_uom_code, flv2.meaning supply_type, bc.supply_subinventory,
--        mil.segment1 supply_locator, bc.attribute1 from_subinventory,
--        (SELECT mil.segment1
--           FROM mtl_item_locations mil
--          WHERE bc.attribute2 = mil.inventory_location_id) from_locator
--   FROM bom.bom_components_b bc,
--        bom.bom_structures_b bs,
--        inv.mtl_system_items_b mb1,
--        inv.mtl_system_items_b mb2,
--        fnd_lookup_values flv1,
--        fnd_lookup_values flv2,
--        mtl_item_locations mil
--  WHERE bs.assembly_item_id = mb1.inventory_item_id
--    AND bc.component_item_id = mb2.inventory_item_id
--    AND bc.bill_sequence_id = bs.bill_sequence_id
--    AND mb1.organization_id = mb2.organization_id
--    AND bs.organization_id = mb2.organization_id
--    AND bc.disable_date IS NULL
--    AND bs.alternate_bom_designator IS NULL
--    AND mb1.organization_id = 102
--    AND mb2.item_type = flv1.lookup_code
--    AND flv1.lookup_type = 'ITEM_TYPE'
--    AND bc.wip_supply_type = flv2.lookup_code
--    AND flv2.lookup_type = 'WIP_SUPPLY'
--    AND bc.supply_locator_id = mil.inventory_location_id(+)
--    AND mb1.segment1 = '$kode'

select msib.SEGMENT1 assembly_num
,msib.DESCRIPTION assy_desc
,bom.ALTERNATE_BOM_DESIGNATOR alt
,bic.ITEM_NUM num
,msib2.SEGMENT1 component_num
,msib2.DESCRIPTION
,bic.COMPONENT_QUANTITY qty
,msib2.PRIMARY_UOM_CODE
,flv.MEANING supply_type
,bic.SUPPLY_SUBINVENTORY
,mil.SEGMENT1 supply_locator
,bic.ATTRIBUTE1 from_subinventory
,mil2.SEGMENT1 from_locator
from bom_bill_of_materials bom
,bom_inventory_components bic
,mtl_system_items_b msib
,mtl_system_items_b msib2
,mtl_item_locations mil
,mtl_item_locations mil2
,fnd_lookup_values flv
where bom.BILL_SEQUENCE_ID = bic.BILL_SEQUENCE_ID
and bom.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
and bom.ORGANIZATION_ID = msib.ORGANIZATION_ID
and bic.COMPONENT_ITEM_ID = msib2.INVENTORY_ITEM_ID
and bic.DISABLE_DATE is null
and msib2.ORGANIZATION_ID = bom.ORGANIZATION_ID
and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
and bic.ATTRIBUTE2 = mil2.INVENTORY_LOCATION_ID(+)
and bic.WIP_SUPPLY_TYPE = flv.LOOKUP_CODE
and flv.LOOKUP_TYPE = 'WIP_SUPPLY'
and msib.SEGMENT1  ='$kode'
order by msib.SEGMENT1, bom.ALTERNATE_BOM_DESIGNATOR, bic.ITEM_NUM
";

       $query = $oracle->query($sql);
        return $query->result_array();
 }
   
 }