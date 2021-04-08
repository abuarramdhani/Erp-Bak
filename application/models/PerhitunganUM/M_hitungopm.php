<?php
    class M_hitungopm extends CI_Model {
        public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->oracle = $this->load->database('oracle', true);
        //$this->oracle_dev = $this->load->database('oracle_dev',TRUE);
        }

        public function routclass($term){
            $sql = "SELECT DISTINCT frh.routing_class
            FROM fm_rout_hdr frh
           WHERE frh.routing_class IN ('PTAS', 'SHMT')
             AND frh.routing_class LIKE '%$term%'
        ORDER BY 1";
            $query = $this ->oracle->query($sql);
            return $query->result_array();
        }

        public function dataPUMopm($routclass, $planopm){
            $sql = "SELECT DISTINCT xsrd.value_constant cost_center, gor.resources,
            crmb.resource_desc, 'GROUP' jenis_mesin, kdmro.no_mesin, 
            kdmro.tag_number, msib.segment1 kode_komponen, msib.description,
            gor.resource_usage, TO_CHAR (SYSDATE, 'Mon-YY') m1,
            NVL
               ((SELECT   SUM (COALESCE (md.daily_demand_rate, md.using_requirement_quantity)) qty
                     FROM msc_system_items msi,
                          mtl_system_items_b msib,
                          msc_demands md,
                          msc_plans mp,
                          mfg_lookups ml
                    WHERE msi.sr_inventory_item_id = msib.inventory_item_id
                      AND msi.organization_id = msib.organization_id
                      -- demands
                      AND md.plan_id = msi.plan_id
                      AND md.sr_instance_id = msi.sr_instance_id
                      AND md.organization_id = msi.organization_id
                      AND md.inventory_item_id = msi.inventory_item_id
                      AND md.origination_type <> 52
                      AND mp.plan_id = md.plan_id
                      -- lookup
                      AND ml.lookup_type = ('MSC_DEMAND_ORIGINATION')
                      AND ml.lookup_code = md.origination_type
                      AND mp.plan_id = '$planopm'
                      AND msib.inventory_item_id = fmd.inventory_item_id
                      AND msib.organization_id = ffm.owner_organization_id
                      AND TO_CHAR (md.using_assembly_demand_date, 'Mon-YY') = TO_CHAR (SYSDATE, 'Mon-YY')
                      AND TRUNC (md.using_assembly_demand_date) >= TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY'))
                      AND TRUNC (md.using_assembly_demand_date) BETWEEN TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY'))
                                 AND LAST_DAY (ADD_MONTHS (TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY')), 2))
                      AND khs_ascp_utilities_pkg.get_order_type (mp.plan_id, md.sr_instance_id, md.demand_id) IN ('Planned order demand', 'Forecast')
                 GROUP BY TO_CHAR (md.using_assembly_demand_date, 'Mon-YY'),
                          TO_NUMBER (TO_CHAR (TRUNC (md.using_assembly_demand_date), 'YYYYMM')),
                          msib.inventory_item_id,
                          msib.organization_id,
                          mp.plan_id),
                0) pod1,
            TO_CHAR (ADD_MONTHS (SYSDATE, 1), 'Mon-YY') m2,
            NVL
               ((SELECT   SUM (COALESCE (md.daily_demand_rate, md.using_requirement_quantity)) qty
                     FROM msc_system_items msi,
                          mtl_system_items_b msib,
                          msc_demands md,
                          msc_plans mp,
                          mfg_lookups ml
                    WHERE msi.sr_inventory_item_id = msib.inventory_item_id
                      AND msi.organization_id = msib.organization_id
                      -- demands
                      AND md.plan_id = msi.plan_id
                      AND md.sr_instance_id = msi.sr_instance_id
                      AND md.organization_id = msi.organization_id
                      AND md.inventory_item_id = msi.inventory_item_id
                      AND md.origination_type <> 52
                      AND mp.plan_id = md.plan_id
                      -- lookup
                      AND ml.lookup_type = ('MSC_DEMAND_ORIGINATION')
                      AND ml.lookup_code = md.origination_type
                      AND mp.plan_id = '$planopm'
                      AND msib.inventory_item_id = fmd.inventory_item_id
                      AND msib.organization_id = ffm.owner_organization_id
                      AND TO_CHAR (md.using_assembly_demand_date, 'Mon-YY') = TO_CHAR (ADD_MONTHS (SYSDATE, 1), 'Mon-YY')
                      AND TRUNC (md.using_assembly_demand_date) >= TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY'))
                      AND TRUNC (md.using_assembly_demand_date) BETWEEN TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY'))
                                 AND LAST_DAY (ADD_MONTHS (TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY')), 2))
                      AND khs_ascp_utilities_pkg.get_order_type (mp.plan_id, md.sr_instance_id, md.demand_id) IN ('Planned order demand', 'Forecast')
                 GROUP BY TO_CHAR (md.using_assembly_demand_date, 'Mon-YY'),
                          TO_NUMBER (TO_CHAR (TRUNC (md.using_assembly_demand_date), 'YYYYMM')),
                          msib.inventory_item_id,
                          msib.organization_id,
                          mp.plan_id),
                0
               ) pod2,
            TO_CHAR (ADD_MONTHS (SYSDATE, 2), 'Mon-YY') m3,
            NVL
               ((SELECT   SUM (COALESCE (md.daily_demand_rate, md.using_requirement_quantity)) qty
                     FROM msc_system_items msi,
                          mtl_system_items_b msib,
                          msc_demands md,
                          msc_plans mp,
                          mfg_lookups ml
                    WHERE msi.sr_inventory_item_id = msib.inventory_item_id
                      AND msi.organization_id = msib.organization_id
                      -- demands
                      AND md.plan_id = msi.plan_id
                      AND md.sr_instance_id = msi.sr_instance_id
                      AND md.organization_id = msi.organization_id
                      AND md.inventory_item_id = msi.inventory_item_id
                      AND md.origination_type <> 52
                      AND mp.plan_id = md.plan_id
                      -- lookup
                      AND ml.lookup_type = ('MSC_DEMAND_ORIGINATION')
                      AND ml.lookup_code = md.origination_type
                      AND mp.plan_id = '$planopm'
                      AND msib.inventory_item_id = fmd.inventory_item_id
                      AND msib.organization_id = ffm.owner_organization_id
                      AND TO_CHAR (md.using_assembly_demand_date, 'Mon-YY') = TO_CHAR (ADD_MONTHS (SYSDATE, 2), 'Mon-YY')
                      AND TRUNC (md.using_assembly_demand_date) >= TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY'))
                      AND TRUNC (md.using_assembly_demand_date) BETWEEN TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY'))
                                 AND LAST_DAY (ADD_MONTHS (TO_DATE ('01' || TO_CHAR (SYSDATE, 'MON-YY')), 2))
                      AND khs_ascp_utilities_pkg.get_order_type (mp.plan_id, md.sr_instance_id, md.demand_id) IN ('Planned order demand', 'Forecast')
                 GROUP BY TO_CHAR (md.using_assembly_demand_date, 'Mon-YY'),
                          TO_NUMBER (TO_CHAR (TRUNC (md.using_assembly_demand_date), 'YYYYMM')),
                          msib.inventory_item_id,
                          msib.organization_id,
                          mp.plan_id),
                0
               ) pod3
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
        -- AND gor.resources = 'POTAS TAKISAWA'
   ORDER BY xsrd.value_constant,
            kdmro.no_mesin,
            kdmro.tag_number,
            msib.segment1";
            $query = $this->oracle->query($sql);
            return $query->result_array();
        }

        public function stockawalopm($routclass, $planopm){
            $sql = "SELECT   routing_class, kode_komponen, description, SUM (stok_awal) stok_awal
            FROM (SELECT DISTINCT frh.routing_class, msib.segment1 kode_komponen,
                                  msib.description, moc.quantity_rate stok_awal
                             FROM fm_rout_hdr frh,
                                  gmd_recipes gc,
                                  fm_form_mst ffm,
                                  fm_matl_dtl fmd,
                                  mtl_system_items_b msib,
                                  msc_orders_col_v moc,
                                  msc_sub_inventories msci,
                                  msc_plan_sched_v mscp,
                                  msc_system_items msi
                            WHERE frh.routing_class = '$routclass'
                              AND frh.routing_id = gc.routing_id
                              AND gc.formula_id = ffm.formula_id
                              AND gc.recipe_version = 1
                              AND ffm.formula_vers = 1
                              AND ffm.formula_id = fmd.formula_id
                              AND fmd.line_type = 1
                              AND fmd.line_no = 1
                              AND fmd.inventory_item_id = msib.inventory_item_id
                              AND ffm.owner_organization_id = msib.organization_id
                              --
                              AND moc.order_type = 18
                              AND moc.old_due_date IS NULL
                              AND msci.plan_id = mscp.plan_id
                              AND msci.organization_id = mscp.organization_id
                              AND msci.netting_type = 1                     -- checked
                              AND mscp.input_schedule_id = 112181           -- MPS/MRP
                              AND moc.subinventory_code = msci.sub_inventory_code
                              AND moc.inventory_item_id = msi.inventory_item_id
                              AND msci.plan_id = '$planopm'
                              AND msi.sr_inventory_item_id = msib.inventory_item_id
                              AND moc.organization_id = 102)
        GROUP BY routing_class, kode_komponen, description
        ORDER BY kode_komponen";
            $query = $this ->oracle->query($sql);
            return $query->result_array();
        }

    }
?>