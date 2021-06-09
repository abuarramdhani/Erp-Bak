<?php 

class M_hitungopm extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->oracle = $this->load->database('oracle', true);
        //$this->oracle_dev = $this->load->database('oracle_dev',TRUE);
    }

    public function getResources($routclass, $term){
        $sql = "SELECT DISTINCT gor.resources, crmb.resource_desc
        FROM fm_rout_hdr frh,
             fm_rout_dtl frd,
             gmd_operations gos,
             gmd_operation_activities goa,
             gmd_operation_resources gor,
             cr_rsrc_mst crmb,
             gmd_recipes gc,
             fm_form_mst ffm,
             fm_matl_dtl fmd
       WHERE frh.routing_class = '$routclass'
         AND frh.routing_id = frd.routing_id
         AND frd.oprn_id = gos.oprn_id
         AND gos.oprn_id = goa.oprn_id
         AND goa.oprn_line_id = gor.oprn_line_id
         AND gor.resources = crmb.resources
         AND crmb.resource_class = 'MESIN'
         AND frh.routing_id = gc.routing_id
         AND gc.formula_id = ffm.formula_id
         AND gc.recipe_version = 1
         AND gc.recipe_status = 700 --Approved for General Use
         AND ffm.formula_vers = 1
         AND ffm.formula_id = fmd.formula_id
         AND fmd.line_type = 1
         AND gor.resources LIKE '%$term%'
    ORDER BY 1";
        $query = $this ->oracle->query($sql);
        return $query->result_array();
    }

    public function getDataOPM($routclass, $rsrc){
        $sql = "SELECT DISTINCT xsrd.value_constant cost_center, gor.resources,
        crmb.resource_desc, 'GROUP' jenis_resource, kdmro.no_mesin,
        kdmro.tag_number, msib.inventory_item_id, 
        msib.segment1 kode_komponen, msib.description,
        gor.resource_usage
   FROM fm_rout_hdr frh,
        fm_rout_dtl frd,
        gmd_operations gos,
        gmd_operation_activities goa,
        gmd_operation_resources gor,
        cr_rsrc_mst crmb,
        xla_conditions xc,
        xla_seg_rule_details xsrd,
        khs_daftar_mesin_resource_opm kdmro,
        gmd_recipes gc,
        fm_form_mst ffm,
        fm_matl_dtl fmd,
        mtl_system_items_b msib
  WHERE frh.routing_class = '$routclass'
    AND frh.routing_id = frd.routing_id
    AND frd.oprn_id = gos.oprn_id
    AND gos.oprn_id = goa.oprn_id
    AND goa.oprn_line_id = gor.oprn_line_id
    AND gor.resources = crmb.resources
    AND crmb.resource_class = 'MESIN'
    AND gor.resources = xc.value_constant
    AND xc.segment_rule_detail_id = xsrd.segment_rule_detail_id
    AND gor.resources = kdmro.resources
    AND kdmro.oprn_line_id IN (15489, 15490)
    AND frh.routing_id = gc.routing_id
    AND gc.formula_id = ffm.formula_id
    AND gc.recipe_version = 1
    AND gc.recipe_status = 700 --Approved for General Use
    AND ffm.formula_vers = 1
    AND ffm.formula_id = fmd.formula_id
    AND fmd.line_type = 1
    AND fmd.inventory_item_id = msib.inventory_item_id
    AND ffm.owner_organization_id = msib.organization_id
    AND gor.resources LIKE '%$rsrc%'
    -- AND gor.resources IN ('SM-ROLLCWR', 'SM-ROLLTCV', 'SM-CNCBRANDER')
ORDER BY xsrd.value_constant,
        kdmro.no_mesin,
        kdmro.tag_number,
        msib.segment1";
        $query = $this ->oracle->query($sql);
        return $query->result_array();
    }

    public function getsapod($item_id, $plan){
        $sql = "SELECT NVL (khs_stock_awal ($item_id, 102, $plan), 0) stok_awal,
        khs_ascp_month(102, $item_id, $plan, TO_CHAR(sysdate, 'Mon-YY')) pod1,
        khs_ascp_month(102, $item_id, $plan, TO_CHAR(add_months(sysdate, 1), 'Mon-YY')) pod2,
        khs_ascp_month(102, $item_id, $plan, TO_CHAR(add_months(sysdate, 2), 'Mon-YY')) pod3
    FROM DUAL";
        $query = $this ->oracle->query($sql);
        return $query->result_array();
    }

    public function getHeaderBln(){
        $sql = "SELECT   TO_CHAR (SYSDATE, 'YYYYMM') urut,
        TO_CHAR (SYSDATE, 'Mon-YY') bulan
   FROM DUAL
UNION
SELECT   TO_CHAR (ADD_MONTHS (SYSDATE, 1), 'YYYYMM') urut,
        TO_CHAR (ADD_MONTHS (SYSDATE, 1), 'Mon-YY') bulan
   FROM DUAL
UNION
SELECT   TO_CHAR (ADD_MONTHS (SYSDATE, 2), 'YYYYMM') urut,
        TO_CHAR (ADD_MONTHS (SYSDATE, 2), 'Mon-YY') bulan
   FROM DUAL
ORDER BY 1";
        $query = $this ->oracle->query($sql);
        return $query->result_array();
    }

}

?>