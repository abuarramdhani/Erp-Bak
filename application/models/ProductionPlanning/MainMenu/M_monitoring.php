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
                                to_char(dp.due_time, 'dd-Mon-yyyy') as hari,
                                sum(dp.need_qty) plan_qty
                            FROM
                              pp.pp_daily_plans dp,
                              pp.pp_monthly_plans pmp
                            where
                              dp.section_id = pmp.section_id
                              AND to_char(pmp.plan_time, 'mm-yyyy') = to_char(current_date, 'mm-yyyy')
                              AND dp.section_id = $section
                                AND dp.due_time between
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
                                to_char(dp.due_time, 'dd-Mon-yyyy') as hari,
                                sum(dp.achieve_qty) achieve_qty
                            FROM
                              pp.pp_daily_plans dp,
                              pp.pp_monthly_plans pmp
                            where
                              dp.section_id = pmp.section_id
                              AND to_char(pmp.plan_time, 'mm-yyyy') = to_char(current_date, 'mm-yyyy')
                              AND dp.section_id = $section
                                AND dp.due_time between
                                  date_trunc('month', current_date) and (date_trunc('month', current_date) + interval '1 month' - interval '1 day')
                            group by 1
                            order by 1
                    ) b
                  where b.hari <= a.hari
                )/a.monthly_plan_quantity * 100
                ,2) prosentase_achieve
            from
              (SELECT
                    to_char(dp.due_time, 'dd-Mon-yyyy') as hari,
                    to_char(dp.due_time, 'dd') as label,
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
                    AND dp.due_time between
                      date_trunc('month', current_date)
                      and
                      (date_trunc('month', current_date) + interval '1 month')
                group by 1,2,3
                order by 1) a";
    
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getAchievementAllFab(){
    $sql = "SELECT ps.section_id,
              ps.section_name,
              COALESCE(round(
                cast((
                select sum(dp.achieve_qty)
                from pp.pp_daily_plans dp
                where
                  dp.created_date between
                    date_trunc('month', current_date)
                    and
                    current_timestamp
                  and dp.section_id = ps.section_id 
                group by dp.section_id
                ) as decimal) / cast((
                select pmp.monthly_plan_quantity
                from pp.pp_monthly_plans pmp
                where to_char(pmp.plan_time, 'mm-yyyy') = to_char(current_date, 'mm-yyyy')
                  and pmp.section_id = ps.section_id
                ) as decimal) *100
              ,0),0) || ' %' percentage
            from
              pp.pp_section ps
            where
              ps.section_id != 2
              and ps.section_id != 14
            order by ps.section_id";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function getDailyAchieve($id)
  {
    $sql = "  SELECT
                dp.section_id,
                coalesce(round(
                  cast((
                    sum(dp.achieve_qty)
                  ) as decimal) / cast((
                    sum(dp.need_qty)
                  ) as decimal) * 100
                ,2),0) || ' %' percentage
              from
                pp.pp_daily_plans dp
              where
                (case when dp.achieve_qty is null then 0 else dp.achieve_qty end) < dp.need_qty
                and dp.due_time <=
                  (
                    case when to_char(current_timestamp, 'HH24:MI:SS') >= to_char(to_timestamp('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS')
                      then to_timestamp((to_char(TIMESTAMP 'tomorrow', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                      else to_timestamp((to_char(TIMESTAMP 'today', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
                    END
                  )
                and dp.section_id = $id
              group by dp.section_id";

    $query = $this->db->query($sql);
    return $query->result_array();
  }

  public function updateAttr10($job=FALSE,$invSrc,$invDst,$itemCode,$locatorID,$terpakai,$trnscDate)
  {
    if ($job == FALSE) {
      $sql = "UPDATE MTL_MATERIAL_TRANSACTIONS MMT
              SET MMT.ATTRIBUTE10 = NVL(MMT.ATTRIBUTE10,0)+$terpakai
              WHERE
                MMT.TRANSACTION_ID = (
                  SELECT
                    MMT.TRANSACTION_ID
                  FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                  WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                    AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                    AND MMT.ORGANIZATION_ID = 102
                    AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                    AND MMT.SUBINVENTORY_CODE = '$invSrc'
                    AND MMT.TRANSFER_SUBINVENTORY = '$invDst'
                    AND MSIB.SEGMENT1 = '$itemCode'
                    AND MMT.TRANSACTION_DATE BETWEEN
                      (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                        (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                        ELSE
                        (trunc(sysdate-1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                      END)
                      AND
                      (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                        (trunc(sysdate+1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                        ELSE
                        (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                      END)
                    AND MMT.TRANSACTION_DATE = TO_DATE('$trnscDate', 'DD-MONTH-YYYY HH24:MI:SS')
              )";
    }else{
      $sql = "UPDATE MTL_MATERIAL_TRANSACTIONS MMT
              SET MMT.ATTRIBUTE10 = NVL(MMT.ATTRIBUTE10,0)+$terpakai
              WHERE
                MMT.TRANSACTION_ID = (
                  SELECT
                    MMT.TRANSACTION_ID
                  FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                  WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                    AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                    AND MMT.ORGANIZATION_ID = 102
                    AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                    AND MMT.SUBINVENTORY_CODE = '$invDst'
                    AND MMT.LOCATOR_ID = $locatorID
                    AND MMT.TRANSACTION_TYPE_ID = 44
                    AND MSIB.SEGMENT1 = '$itemCode'
                    AND MMT.TRANSACTION_DATE BETWEEN
                      (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                        (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                        ELSE
                        (trunc(sysdate-1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                      END)
                      AND
                      (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                        (trunc(sysdate+1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                        ELSE
                        (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                      END)
                    AND MMT.TRANSACTION_DATE = TO_DATE('$trnscDate', 'DD-MONTH-YYYY HH24:MI:SS')
              )";
    }
    $this->oracle->query($sql);
  }
}