<?php
class M_monitoring extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->oracle = $this->load->database ('oracle', TRUE);
  }

  public function getInfoJobs()
  {
    $sql = "  SELECT
                (
                  SELECT
                    COUNT(WDJ.WIP_ENTITY_ID) 
                  FROM
                    WIP_DISCRETE_JOBS WDJ
                  WHERE
                    wdj.STATUS_TYPE = 3
                    AND WDJ.ORGANIZATION_ID = 102
                    AND WDJ.SCHEDULED_START_DATE BETWEEN
                      trunc(trunc(sysdate,'MM')-1,'MM') AND SYSDATE
                ) RELEASED_JUMLAH_JOB,
                (
                  SELECT
                    COUNT(WRO.INVENTORY_ITEM_ID)
                  FROM
                    WIP_REQUIREMENT_OPERATIONS WRO,
                    WIP_DISCRETE_JOBS WDJ
                  WHERE
                    WRO.WIP_ENTITY_ID = WDJ.WIP_ENTITY_ID
                    AND WDJ.ORGANIZATION_ID = 102
                    AND WDJ.STATUS_TYPE = 3
                    AND WDJ.SCHEDULED_START_DATE BETWEEN
                      trunc(trunc(sysdate,'MM')-1,'MM') AND SYSDATE
                ) RELEASED_JUMLAH_PART,
                (
                  SELECT COUNT(*) 
                  FROM (
                    SELECT WRO.WIP_ENTITY_ID
                    FROM
                      WIP_DISCRETE_JOBS WDJ,
                      WIP_REQUIREMENT_OPERATIONS WRO
                    WHERE
                      WRO.WIP_ENTITY_ID = WDJ.WIP_ENTITY_ID
                      AND WDJ.ORGANIZATION_ID = 102
                      AND WDJ.STATUS_TYPE = 3
                      AND WRO.WIP_SUPPLY_TYPE = 1
                      AND nvl(WRO.QUANTITY_ALLOCATED,0) < WRO.REQUIRED_QUANTITY
                    GROUP BY WRO.WIP_ENTITY_ID)
                ) PENDING_JUMLAH_JOB,
                (
                  SELECT COUNT(*) 
                  FROM
                    WIP_REQUIREMENT_OPERATIONS WRO,
                    WIP_DISCRETE_JOBS WDJ
                  WHERE
                    WRO.WIP_ENTITY_ID = WDJ.WIP_ENTITY_ID
                    AND WDJ.ORGANIZATION_ID = 102
                    AND WDJ.STATUS_TYPE = 3
                    AND WRO.WIP_SUPPLY_TYPE = 1
                    AND nvl(WRO.QUANTITY_ALLOCATED,0) < WRO.REQUIRED_QUANTITY
                ) PENDING_JUMLAH_PART,
                (
                  SELECT COUNT(*) 
                  FROM
                    (SELECT
                      WRO.WIP_ENTITY_ID
                    FROM
                      WIP_DISCRETE_JOBS WDJ,
                      WIP_REQUIREMENT_OPERATIONS WRO
                    WHERE
                      WRO.WIP_ENTITY_ID = WDJ.WIP_ENTITY_ID
                      AND WDJ.ORGANIZATION_ID = 102
                      AND WDJ.STATUS_TYPE = 3
                      AND WRO.WIP_SUPPLY_TYPE = 1
                      AND WDJ.SCHEDULED_START_DATE BETWEEN
                        trunc(sysdate,'MM') AND SYSDATE
                      AND nvl(WRO.QUANTITY_ALLOCATED,0) >= WRO.REQUIRED_QUANTITY
                    GROUP BY WRO.WIP_ENTITY_ID)
                ) COMPLETE_JUMLAH_JOB,
                (
                  SELECT
                    COUNT(*) 
                  FROM
                    WIP_DISCRETE_JOBS WDJ,
                    WIP_REQUIREMENT_OPERATIONS WRO
                  WHERE
                    WRO.WIP_ENTITY_ID = WDJ.WIP_ENTITY_ID
                    AND WDJ.ORGANIZATION_ID = 102
                    AND WDJ.STATUS_TYPE = 3
                    AND WRO.WIP_SUPPLY_TYPE = 1
                    AND WDJ.SCHEDULED_START_DATE BETWEEN
                      trunc(sysdate,'MM') AND SYSDATE
                    AND nvl(WRO.QUANTITY_ALLOCATED,0) >= WRO.REQUIRED_QUANTITY
                ) COMPLETE_JUMLAH_PART,
                (
                  SELECT MIN(WDJ.SCHEDULED_START_DATE) 
                  FROM
                    WIP_DISCRETE_JOBS WDJ
                  WHERE
                    WDJ.ORGANIZATION_ID = 102
                    AND WDJ.STATUS_TYPE = 3
                ) JOB_TERLAMA
              FROM DUAL";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getSumPlanMonth($section)
  {
    $sql = "SELECT
              a.hari,
              a.label,
              ROUND(
                (
                  SELECT SUM(b.plan_qty)
                  from
                    (
                      SELECT
                                to_char(dp.created_date, 'dd-Mon-yyyy') as hari,
                                sum(dp.need_qty) plan_qty
                            FROM
                              pp.pp_daily_plans dp,
                              pp.pp_monthly_plans pmp
                            where
                              dp.section_id = pmp.section_id
                              AND to_char(pmp.plan_time, 'mm-yyyy') = to_char(current_date, 'mm-yyyy')
                              AND dp.section_id = $section
                                AND dp.created_date between
                                  date_trunc('month', current_date) and (date_trunc('month', current_date) + interval '1 month' - interval '1 day') 
                            group by 1
                            order by 1
                    ) b
                  where b.hari <= a.hari
                )/a.monthly_plan_quantity * 100
              , 2) prosentase_plan,
              ROUND((
                  SELECT SUM(b.achieve_qty)
                  from
                    (
                      SELECT
                                to_char(dp.created_date, 'dd-Mon-yyyy') as hari,
                                sum(dp.achieve_qty) achieve_qty
                            FROM
                              pp.pp_daily_plans dp,
                              pp.pp_monthly_plans pmp
                            where
                              dp.section_id = pmp.section_id
                              AND to_char(pmp.plan_time, 'mm-yyyy') = to_char(current_date, 'mm-yyyy')
                              AND dp.section_id = $section
                                AND dp.created_date between
                                  date_trunc('month', current_date) and (date_trunc('month', current_date) + interval '1 month' - interval '1 day') 
                            group by 1
                            order by 1
                    ) b
                  where b.hari <= a.hari
                )/a.monthly_plan_quantity * 100
                ,2) prosentase_achieve
            from
              (SELECT
                    to_char(dp.created_date, 'dd-Mon-yyyy') as hari,
                    to_char(dp.created_date, 'dd') as label,
                pmp.monthly_plan_quantity,
                    sum(dp.need_qty) plan_qty,
                    sum(dp.achieve_qty) achieve_qty
                FROM
                  pp.pp_daily_plans dp,
                  pp.pp_monthly_plans pmp
                where
                  dp.section_id = pmp.section_id
                  AND to_char(pmp.plan_time, 'mm-yyyy') = to_char(current_date, 'mm-yyyy')
                  AND dp.section_id = $section
                    AND dp.created_date between
                      date_trunc('month', current_date)
                      and
                      (date_trunc('month', current_date) + interval '1 month') 
                group by 1,2,3
                order by 1) a";
    
    $query = $this->db->query($sql);
    return $query->result_array();
  }
}