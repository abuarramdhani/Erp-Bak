<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function filter_history_agt($range_date)
    {
      $range =  explode(' - ', $range_date);
      return $this->oracle->query("SELECT *
                                   FROM KHS_ANDON_ITEM_DEV
                                   WHERE TO_CHAR(creation_date, 'YYYY-MM-DD') BETWEEN '$range[0]' AND '$range[1]'")->result_array();
    }

    public function updatepos($data)
    {
      $this->oracle->where('ITEM_ID', $data['ITEM_ID'])->update('KHS_ANDON_ITEM_DEV', $data);
      if ($this->oracle->affected_rows()) {
        return 200;
      }else {
        return 0;
      }
    }

    public function delpos($item_id)
    {
      $this->oracle->query("DELETE FROM khs_andon_item_dev WHERE ITEM_ID = '$item_id'");
      if ($this->oracle->affected_rows()) {
        return 200;
      }else {
        return 0;
      }
    }

    public function historyandon($value='')
    {
      return $this->oracle->query("SELECT * FROM khs_andon_item_dev WHERE rownum<=100 ORDER BY CREATION_DATE DESC")->result_array();
    }

    public function runningandon($value='')
    {
      return $this->oracle->query("SELECT * FROM khs_andon_item_dev WHERE STATUS_JOB IN ('POS_1', 'POS_2', 'POS_3', 'POS_4') ORDER BY CREATION_DATE ASC")->result_array();
    }

    public function cekjobdipos1($nojob)
    {
      $cek =  $this->oracle->query("SELECT NO_JOB FROM khs_andon_item_dev WHERE NO_JOB = '$nojob'")->row_array();
      if (!empty($cek['NO_JOB'])) {
        return 200;
      }else {
        return 0;
      }
    }

    public function insertpos1($nojob, $itemkode, $desc, $item_id)
    {
      $user = $this->session->user;
      $this->oracle->query("INSERT INTO khs_andon_item_dev(ITEM_ID, KODE_ITEM, DESCRIPTION, NO_JOB, STATUS_JOB, CREATION_DATE, USER_LOGIN)
                            VALUES ('$item_id', '$itemkode', '$desc', '$nojob', 'POS_1', SYSDATE, '$user')");
      if ($this->oracle->affected_rows()) {
        return 200;
      }else {
        return 0;
      }
    }

    public function getOldJob($item_id)
    {
      return $this->oracle->query("SELECT wdj.primary_item_id item_id, wdj.creation_date, we.wip_entity_name no_job,
                   msib.segment1 kode_item, msib.description, wdj.start_quantity qty_job,
                   (wdj.net_quantity - wdj.quantity_completed - wdj.quantity_scrapped
                   ) remaining_qty,
                   (  wdj.start_quantity
                    - (SELECT COUNT (kai.no_job)
                         FROM khs_andon_item_dev kai
                        WHERE kai.no_job = we.wip_entity_name
                          AND wdj.primary_item_id = kai.item_id)
                   ) remaining_wip
              FROM wip_entities we, wip_discrete_jobs wdj, mtl_system_items_b msib
             WHERE we.wip_entity_id = wdj.wip_entity_id
               AND wdj.organization_id = msib.organization_id
               AND wdj.primary_item_id = msib.inventory_item_id
               AND wdj.primary_item_id = $item_id
               AND wdj.status_type = 3
               AND wdj.creation_date =
                            (SELECT MIN (wdj.creation_date)
                               FROM wip_discrete_jobs wdj
                              WHERE wdj.primary_item_id = $item_id AND wdj.status_type = 3)")->result_array();

    }

    public function filter_job_agt($range_date)
    {
      $range =  explode(' - ', $range_date);
      $date1 = date("d-M-Y", strtotime($range[0]));
      $date2 = date("d-M-Y", strtotime($range[1]));
      return $this->oracle->query("SELECT wdj.primary_item_id, we.wip_entity_name no_job, msib.segment1 kode_item, msib.description,
                                         wdj.start_quantity qty_job, wdj.quantity_completed, wdj.quantity_scrapped,
                                         (wdj.net_quantity - wdj.quantity_completed - wdj.quantity_scrapped) remaining_qty,
                                         wdj.date_released
                                    FROM wip_entities we,
                                         wip_discrete_jobs wdj,
                                         mtl_system_items_b msib,
                                         wip_operations wo,
                                         wip_operation_resources wor,
                                         bom_departments bd
                                   WHERE we.wip_entity_id = wdj.wip_entity_id
                                     AND wdj.status_type = 3
                                     AND wdj.primary_item_id = msib.inventory_item_id
                                     AND wdj.organization_id = msib.organization_id
                                     AND wo.wip_entity_id = wdj.wip_entity_id
                                     AND wo.organization_id = wdj.organization_id
                                     AND wor.wip_entity_id = wo.wip_entity_id
                                     AND wor.organization_id = wdj.organization_id
                                     AND wo.department_id = bd.department_id
                                     AND wo.organization_id = bd.organization_id
                                     AND wdj.date_released BETWEEN '$date1' AND '$date2'")->result_array();
    }
    // --job tertua
    // SELECT wdj.primary_item_id, wdj.creation_date, we.wip_entity_name no_job,
    //        msib.segment1 kode_item, msib.description, wdj.start_quantity qty_job,
    //        (wdj.net_quantity - wdj.quantity_completed - wdj.quantity_scrapped
    //        ) remaining_qty,
    //        (  wdj.start_quantity
    //         - (SELECT COUNT (kai.no_job)
    //              FROM khs_andon_item_dev kai
    //             WHERE kai.no_job = we.wip_entity_name
    //               AND wdj.primary_item_id = kai.item_id)
    //        ) remaining_wip
    //   FROM wip_entities we, wip_discrete_jobs wdj, mtl_system_items_b msib
    //  WHERE we.wip_entity_id = wdj.wip_entity_id
    //    AND wdj.organization_id = msib.organization_id
    //    AND wdj.primary_item_id = msib.inventory_item_id
    //    AND wdj.primary_item_id = 1710840
    //    AND wdj.status_type = 3
    //    AND wdj.creation_date =
    //                 (SELECT MIN (wdj.creation_date)
    //                    FROM wip_discrete_jobs wdj
    //                   WHERE wdj.primary_item_id = 1710840 AND wdj.status_type = 3)
    //
    // --list_job_released
    // SELECT we.wip_entity_name no_job
    //   FROM wip_entities we, wip_discrete_jobs wdj
    //  WHERE we.wip_entity_id = wdj.wip_entity_id
    //    AND wdj.status_type = 3
    //    AND wdj.primary_item_id = 1710840



}
