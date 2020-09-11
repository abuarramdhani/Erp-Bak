<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetakbom extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
    $this->personalia = $this->load->database('personalia', true);

  }

  function getNama($opr)
  {
  $sql = "SELECT trim(nama) as nama from hrd_khs.tpribadi 
      where noind = '$opr'";
    
  $query = $this->personalia->query($sql);
  return $query->result_array();
  }

  public function selectproduk($term) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select ffv.FLEX_VALUE ,ffvt.DESCRIPTION from fnd_flex_values ffv ,fnd_flex_values_tl ffvt 
    where ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID 
    and ffv.FLEX_VALUE_SET_ID = 1013710 
    and ffv.END_DATE_ACTIVE is null 
    and ffv.ENABLED_FLAG = 'Y' 
    and (upper(ffv.FLEX_VALUE) like upper('%$term%') or upper(ffvt.DESCRIPTION) like upper('%$term%'))
 ";
// return $sql;
       $query = $oracle->query($sql);
        return $query->result_array();

 }
  public function selectprodukdesc($produk) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select ffv.FLEX_VALUE
,ffvt.DESCRIPTION
from fnd_flex_values ffv
,fnd_flex_values_tl ffvt
where ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
and ffv.FLEX_VALUE_SET_ID = 1013710
and ffv.END_DATE_ACTIVE is null
and ffv.ENABLED_FLAG = 'Y'
and ffv.FLEX_VALUE = '$produk'
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
    if ($seksi == null) {
			$seksii = null;
		} else {
			$seksii = "AND bd.department_class_code = '$seksi'";
		}

      $sql = "Select bor.ORGANIZATION_ID
      ,msib.segment1
      ,msib.description
      ,bor.ROUTING_SEQUENCE_ID
      ,bor.ALTERNATE_ROUTING_DESIGNATOR alt
      ,bos.OPERATION_SEQUENCE_ID
      ,bos.OPERATION_SEQ_NUM opr_no
      ,BOS.OPERATION_DESCRIPTION KODE_PROSES
          ,mach.RESOURCE_CODE
          ,mach.NO_MESIN
          ,mach.ASSIGNED_UNITS machine_qt
      ,opt.assigned_units opt_qty
      ,round(opt.usage_rate_or_amount/opt.assigned_units,5) USAGE_RATE_OR_AMOUNT  --- New
      ,round(opt.usage_rate_or_amount/opt.assigned_units,5)*3600 CT --- New
      ,round(6.5/(round(opt.usage_rate_or_amount/opt.assigned_units,5))) target  --- New
      -- ,opt.USAGE_RATE_OR_AMOUNT
      -- ,(opt.USAGE_RATE_OR_AMOUNT*3600) CT
      -- ,floor(23400/(opt.USAGE_RATE_OR_AMOUNT*3600))target
      ,opt.LAST_UPDATE_DATE
      ,bos.ATTRIBUTE7 P1
      ,bos.ATTRIBUTE8 P2
      ,bos.ATTRIBUTE9 P3
      ,bos.ATTRIBUTE10 P4
      ,bos.ATTRIBUTE11 P5
      ,'#'||NVL(bos.ATTRIBUTE7, '$%' )||'#'||NVL(bos.ATTRIBUTE8, '$%' )||'#'||NVL(bos.ATTRIBUTE9, '$%' )||'#'||NVL(bos.ATTRIBUTE10, '$%' )||'#'||NVL(bos.ATTRIBUTE11, '$%' ) detail
      from mtl_system_items_b msib
      ,bom_operational_routings bor
      ,bom_operation_sequences bos
      ,bom_departments bd
          ,(select borsop.OPERATION_SEQUENCE_ID
          ,borsop.USAGE_RATE_OR_AMOUNT
          ,borsop.ASSIGNED_UNITS
          ,borsop.LAST_UPDATE_DATE 
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
      and bd.DEPARTMENT_CODE not like 'D-SUB%'
      and bd.ORGANIZATION_ID = bor.ORGANIZATION_ID
      and bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
      and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
      and bos.DISABLE_DATE is null
      and bos.OPERATION_SEQUENCE_ID = opt.OPERATION_SEQUENCE_ID(+)
      and bos.OPERATION_SEQUENCE_ID = mach.OPERATION_SEQUENCE_ID(+)
      and msib.segment1 like '$kode' 
      $seksii
      order by bos.OPERATION_SEQ_NUM ,bor.ROUTING_SEQUENCE_ID ,bos.OPERATION_SEQUENCE_ID";
       $query = $oracle->query($sql);
        return $query->result_array();
       // return $sql;
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
,bom.BILL_SEQUENCE_ID
,bom.ALTERNATE_BOM_DESIGNATOR alt
,bic.ITEM_NUM num
,msib2.SEGMENT1 component_num
,msib2.DESCRIPTION
,bic.COMPONENT_QUANTITY qty
,msib2.PRIMARY_UOM_CODE
,flv.MEANING supply_type
,bic.SUPPLY_SUBINVENTORY
,bic.OPERATION_SEQ_NUM OPR_NUM
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
  public function dataopm1($kode) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select msib.SEGMENT1
,msib.DESCRIPTION
,grvr.RECIPE_USE
,grvr.PREFERENCE
,grb.RECIPE_NO
,grb.RECIPE_VERSION
,grb.ROUTING_ID
,grb.FORMULA_ID
from gmd_recipe_validity_rules grvr
,gmd_recipes_b grb
,mtl_system_items_b msib
where grvr.RECIPE_ID = grb.RECIPE_ID
and grvr.ORGANIZATION_ID = grb.OWNER_ORGANIZATION_ID
and grvr.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
and grvr.ORGANIZATION_ID = msib.ORGANIZATION_ID
and grvr.RECIPE_USE = 0
and grvr.END_DATE is null
and grvr.VALIDITY_RULE_STATUS = 700
and msib.SEGMENT1 = '$kode'";

       $query = $oracle->query($sql);
        return $query->result_array();
 }

public function dataopm2($routing) {
    $oracle = $this->load->database('oracle', true);
// $sql = "select
// grb.ROUTING_ID
// ,grb.ROUTING_CLASS
// ,grb.ROUTING_NO
// ,grt.ROUTING_DESC
// ,grb.ROUTING_VERS
// ,grb.ROUTING_QTY
// ,grb.ROUTING_UOM
// ,gst.DESCRIPTION rout_status
// ,frd.ROUTINGSTEP_NO step
// ,gob.OPRN_NO
// ,gob.OPRN_VERS
// ,got.OPRN_DESC
// ,frd.STEP_QTY
// ,gob.PROCESS_QTY_UOM
// ,gst2.DESCRIPTION oprn_status
// ,goa.ACTIVITY
// ,gat.ACTIVITY_DESC
// ,goa.ACTIVITY_FACTOR
// ,mach.resources
// ,mach.resource_desc
// ,mach.resource_class
// ,'' proses
// ,'' nomor_mesin
// ,mach.RESOURCE_COUNT machine_qty
// ,opt.RESOURCE_COUNT operator_qty
// --,opt.RESOURCE_USAGE
// ,opt.PROCESS_QTY
// ,opt.RESOURCE_USAGE/opt.PROCESS_QTY resource_usage
// ,(opt.RESOURCE_USAGE/opt.PROCESS_QTY)*3600 ct
// ,23400/((opt.RESOURCE_USAGE/opt.PROCESS_QTY)*3600) target
// ,opt.LAST_UPDATE_DATE
// from
// gmd_routings_tl grt
// ,gmd_routings_b grb
// ,gmd_status_tl gst
// ,gmd_status_tl gst2
// ,fm_rout_dtl frd
// ,gmd_operations_tl got
// ,gmd_operations_b gob
// ,gmd_operation_activities goa
// ,gmd_activities_tl gat
// ,(select gor.OPRN_LINE_ID
// ,crmb.RESOURCES
// ,crmt.RESOURCE_DESC
// ,crmb.RESOURCE_CLASS
// ,gor.RESOURCE_USAGE/gor.PROCESS_QTY
// ,gor.RESOURCE_COUNT
// from gmd_operation_resources gor
// ,cr_rsrc_mst_b crmb ,cr_rsrc_mst_tl crmt
// where gor.RESOURCES=crmb.RESOURCES
// and gor.RESOURCES=crmt.RESOURCES
// --and gor.OPRN_LINE_ID = 18327
// and crmb.RESOURCE_CLASS = 'MESIN')mach
// ,(select gor2.OPRN_LINE_ID
// ,gor2.RESOURCE_USAGE
// ,gor2.PROCESS_QTY
// ,gor2.RESOURCE_COUNT
// ,gor2.LAST_UPDATE_DATE
// from gmd_operation_resources gor2
// ,cr_rsrc_mst_b crmb2
// where gor2.RESOURCES=crmb2.RESOURCES
// --and gor2.OPRN_LINE_ID = 18327
// and crmb2.RESOURCE_CLASS = 'OPERATOR')opt
// where
// grb.ROUTING_ID=grt.ROUTING_ID
// and grb.ROUTING_STATUS=gst.STATUS_CODE
// and grb.ROUTING_ID=frd.ROUTING_ID
// and grb.ROUTING_STATUS = 700
// and frd.OPRN_ID=gob.OPRN_ID
// and gob.OPRN_ID=got.OPRN_ID
// and gob.OPERATION_STATUS=gst2.STATUS_CODE
// and gob.OPRN_ID=goa.OPRN_ID
// and gob.OPERATION_STATUS = 700
// and goa.ACTIVITY=gat.ACTIVITY
// and grt.routing_id = '$routing'
// and goa.OPRN_LINE_ID = opt.OPRN_LINE_ID(+)
// and goa.OPRN_LINE_ID = mach.OPRN_LINE_ID(+)
// order by grt.ROUTING_ID
// ,grb.ROUTING_VERS";
$sql = "SELECT
grb.ROUTING_ID
,grb.ROUTING_CLASS
,grb.ROUTING_NO
,grt.ROUTING_DESC
,grb.ROUTING_VERS
,grb.ROUTING_QTY
,grb.ROUTING_UOM
,gst.DESCRIPTION rout_status
,frd.ROUTINGSTEP_NO OPRN_NUM
,gob.OPRN_NO
,gob.OPRN_VERS
,got.OPRN_DESC
,frd.STEP_QTY
,gob.PROCESS_QTY_UOM
,gst2.DESCRIPTION oprn_status
,goa.ACTIVITY
,gat.ACTIVITY_DESC
,goa.ACTIVITY_FACTOR
,goa.attribute1 kode_proses
,mach.resources
,mach.resource_desc
,mach.resource_class
,'' proses
,'' nomor_mesin
,mach.RESOURCE_COUNT machine_qty
,opt.RESOURCE_COUNT operator_qty
--,opt.RESOURCE_USAGE
,opt.PROCESS_QTY
,round((opt.RESOURCE_USAGE/opt.PROCESS_QTY),5) resource_usage ---> New
,round((opt.RESOURCE_USAGE/opt.PROCESS_QTY),5)*3600 CT ---> New
,round(6.5/(round((opt.RESOURCE_USAGE/opt.PROCESS_QTY),5))) target ---> New
-- ,opt.RESOURCE_USAGE/opt.PROCESS_QTY resource_usage
-- ,(opt.RESOURCE_USAGE/opt.PROCESS_QTY)*3600 ct
-- ,23400/((opt.RESOURCE_USAGE/opt.PROCESS_QTY)*3600) target
,opt.LAST_UPDATE_DATE
,goa.attribute2 P1
,goa.attribute3 P2
,goa.attribute4 P3
,'#'||NVL(goa.attribute2, '$%' )||'#'||NVL(goa.attribute3, '$%' )||'#'||NVL(goa.attribute4, '$%' ) detail
from
gmd_routings_tl grt
,gmd_routings_b grb
,gmd_status_tl gst
,gmd_status_tl gst2
,fm_rout_dtl frd
,gmd_operations_tl got
,gmd_operations_b gob
,gmd_operation_activities goa
,gmd_activities_tl gat
,(select gor.OPRN_LINE_ID
,crmb.RESOURCES
,crmt.RESOURCE_DESC
,crmb.RESOURCE_CLASS
,gor.RESOURCE_USAGE/gor.PROCESS_QTY
,gor.RESOURCE_COUNT
from gmd_operation_resources gor
,cr_rsrc_mst_b crmb ,cr_rsrc_mst_tl crmt
where gor.RESOURCES=crmb.RESOURCES
and gor.RESOURCES=crmt.RESOURCES
--and gor.OPRN_LINE_ID = 18327
and crmb.RESOURCE_CLASS = 'MESIN')mach
,(select gor2.OPRN_LINE_ID
,gor2.RESOURCE_USAGE
,gor2.PROCESS_QTY
,gor2.RESOURCE_COUNT
,gor2.LAST_UPDATE_DATE
from gmd_operation_resources gor2
,cr_rsrc_mst_b crmb2
where gor2.RESOURCES=crmb2.RESOURCES
--and gor2.OPRN_LINE_ID = 18327
and crmb2.RESOURCE_CLASS = 'OPERATOR')opt
where
grb.ROUTING_ID=grt.ROUTING_ID
and grb.ROUTING_STATUS=gst.STATUS_CODE
and grb.ROUTING_ID=frd.ROUTING_ID
and grb.ROUTING_STATUS = 700
and frd.OPRN_ID=gob.OPRN_ID
and gob.OPRN_ID=got.OPRN_ID
and gob.OPERATION_STATUS=gst2.STATUS_CODE
and gob.OPRN_ID=goa.OPRN_ID
and gob.OPERATION_STATUS = 700
and goa.ACTIVITY=gat.ACTIVITY
and grt.routing_id = '$routing'
and goa.OPRN_LINE_ID = opt.OPRN_LINE_ID(+)
and goa.OPRN_LINE_ID = mach.OPRN_LINE_ID(+)
order by grt.ROUTING_ID, frd.ROUTINGSTEP_NO
-- ,grb.ROUTING_VERS
";

       $query = $oracle->query($sql);
        return $query->result_array();
 }

 public function dataopm3($formula) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select fmd.FORMULA_ID
,decode(fmd.LINE_TYPE,1,'PRODUCT',2,'BY PRODUCT',-1,'INGREDIENT')tipe
,fmd.LINE_NO
,msib2.segment1
,msib2.DESCRIPTION
,fmd.QTY
,msib2.PRIMARY_UOM_CODE uom
,mp.ORGANIZATION_CODE IO_KIB
,fmd.ATTRIBUTE2 SUBINV_KIB
,mil.SEGMENT1 loc_kib
from fm_matl_dtl fmd
,fm_form_mst_b ffb
,mtl_parameters mp
,mtl_item_locations mil
,mtl_system_items_b msib2
where ffb.FORMULA_ID = fmd.FORMULA_ID
and ffb.FORMULA_STATUS  = 700
and ffb.OWNER_ORGANIZATION_ID = fmd.ORGANIZATION_ID
and fmd.INVENTORY_ITEM_ID = msib2.INVENTORY_ITEM_ID
and fmd.ORGANIZATION_ID = msib2.ORGANIZATION_ID
and fmd.ATTRIBUTE1 = mp.ORGANIZATION_ID(+)
and fmd.ATTRIBUTE3 = mil.INVENTORY_LOCATION_ID(+)
and fmd.FORMULA_ID = '$formula'
order by fmd.FORMULA_ID
,fmd.LINE_TYPE";

       $query = $oracle->query($sql);
        return $query->result_array();
 }
   
 }