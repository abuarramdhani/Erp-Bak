<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function andon_timer($data)
    {
      $this->oracle->query("DELETE FROM KHS_TIMER_ANDON WHERE ID IS NOT NULL");
      foreach ($data as $key => $value) {
        $master = [
          'ID' => date('YmdHis'),
          'TIME_START' => $value['start_time'],
          'TIME_STOP' => $value['stop_time'],
          'HAR' => $value['hari']
        ];
        $this->oracle->insert('KHS_TIMER_ANDON', $master);
      }
      if ($this->oracle->affected_rows()) {
        return 1;
      }else {
        return 0;
      }
    }

    public function dataTimer($value='')
    {
      return $this->oracle->get('KHS_TIMER_ANDON')->result_array();
    }

    public function filter_history_agt($range_date)
    {
      $range =  explode(' - ', $range_date);
      return $this->oracle->query("SELECT d.*, TO_CHAR(d.CREATION_DATE, 'YYYY-MM-DD HH:MI:SS') date_time
                                   FROM KHS_ANDON_ITEM_DEV d
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

    public function delpos($item_id, $date)
    {
      $this->oracle->query("DELETE FROM KHS_ANDON_ITEM_DEV WHERE ITEM_ID = '$item_id' AND TO_CHAR(CREATION_DATE, 'YYYY-MM-DD HH:MI:SS') = '$date'");
      if ($this->oracle->affected_rows()) {
        return 200;
      }else {
        return 0;
      }
    }

    public function getinvid($param)
    {
    return $this->oracle->query("SELECT DISTINCT inventory_item_id, segment1, description FROM mtl_system_items_b WHERE
        (segment1 like '%$param%' or description like '%$param%')")->result_array();
    }

    public function historyandon($value='')
    {
      return $this->oracle->query("SELECT d.*, TO_CHAR(d.CREATION_DATE, 'YYYY-MM-DD HH:MI:SS') date_time
                                   FROM KHS_ANDON_ITEM_DEV d WHERE rownum<=100 ORDER BY CREATION_DATE DESC")->result_array();
    }

    public function runningandon($value='')
    {
      return $this->oracle->query("SELECT d.*, TO_CHAR(d.CREATION_DATE, 'YYYY-MM-DD HH:MI:SS') date_time FROM KHS_ANDON_ITEM_DEV d WHERE STATUS_JOB IN ('POS_1', 'POS_2', 'POS_3', 'POS_4') ORDER BY CREATION_DATE ASC")->result_array();
    }

    private function ambilserialdepanbelakang($item_id, $serial)
    {
      $res = $this->oracle->query("SELECT msi_body.segment1 BODY, msi_gt2a.segment1 gt2a, msi_gt1.segment1 gt1,
                                    msi_body.inventory_item_id id_body, msi_gt2a.inventory_item_id id_gt2a,
                                    msi_gt1.inventory_item_id id_gt1, ksc.serial_format,
                                    CASE
                                       WHEN kb.produk = 'KASUARI B'
                                          THEN 'B'
                                       ELSE TRIM (SUBSTR (ksc.serial_format,
                                                          1,
                                                          INSTR (ksc.serial_format, '-') - 1
                                                         )
                                                 )
                                    END serial_awal,
                                    TRIM (SUBSTR (ksc.serial_format,
                                                  INSTR (ksc.serial_format, '-', 1, 1) + 1,
                                                    LENGTH (ksc.serial_format)
                                                  - INSTR (ksc.serial_format, '-', 1, 1)
                                                 )
                                         ) serial_akhir
                                    FROM mtl_system_items_b msi_body,
                                    mtl_system_items_b msi_gt2a,
                                    mtl_system_items_b msi_gt1,
                                    khskartubody kb,
                                    khs_serial_code ksc
                                    WHERE kb.kode_body = msi_body.inventory_item_id
                                    AND kb.kode_gt2a = msi_gt2a.inventory_item_id
                                    AND kb.kode_gt1 = msi_gt1.inventory_item_id
                                    AND msi_body.organization_id = 81
                                    AND msi_gt2a.organization_id = 81
                                    AND msi_gt1.organization_id = 81
                                    AND kb.kode_body = ksc.item_id
                                    --AND kb.produk = ''
                                    and msi_gt1.INVENTORY_ITEM_ID = '$item_id'")->row_array();
        $h = $serial;
        if (!empty($res)) {
          $h = $res['SERIAL_AWAL'].$serial.$res['SERIAL_AKHIR'];
        }
        return $h;
    }

    public function cekjobdipos1($item_id, $serial)
    {
      $serial_ = $this->ambilserialdepanbelakang($item_id, $serial);
      $cek = $this->oracle->where('SERIAL', $serial_)->get('KHS_ANDON_ITEM_DEV')->row_array();
      if (!empty($cek['NO_JOB'])) {
        return [
          'status' => 200,
          'serial' => $serial_
        ];
      }else {
        return [
          'status' => 0,
          'serial' => $serial_
        ];
      }
    }

    public function insertpos1($nojob, $itemkode, $desc, $item_id, $serial)
    {
      $user = $this->session->user;
      $this->oracle->query("INSERT INTO KHS_ANDON_ITEM_DEV(ITEM_ID, KODE_ITEM, DESCRIPTION, NO_JOB, STATUS_JOB, CREATION_DATE, USER_LOGIN, SERIAL)
                            VALUES ('$item_id', '$itemkode', '$desc', '$nojob', 'POS_1', SYSDATE, '$user', '$serial')");
      if ($this->oracle->affected_rows()) {
        return 200;
      }else {
        return 0;
      }
    }

    public function getOldJob($item_id)
    {
      return $this->oracle->query("SELECT distinct
                                           wdj.primary_item_id item_id, wdj.creation_date, we.wip_entity_name no_job
                                          ,msib.segment1 kode_item, msib.description, wdj.start_quantity qty_job
                                          ,(wdj.start_quantity - wdj.quantity_completed) remaining_qty
                                          ,((wdj.start_quantity - wdj.quantity_completed)
                                                        - (SELECT COUNT (kai.no_job)
                                                             FROM KHS_ANDON_ITEM_DEV kai
                                                            WHERE kai.no_job = we.wip_entity_name
                                                              AND wdj.primary_item_id = kai.item_id)
                                                       ) remaining_wip
                                    FROM wip_entities we
                                        ,wip_discrete_jobs wdj
                                        ,mtl_system_items_b msib
                                        ,(SELECT min(wo.wip_entity_id) wip_entity_id
                                            FROM wip_operations wo ,wip_discrete_jobs wdj, wip_entities we
                                           WHERE wo.wip_entity_id = wdj.wip_entity_id
                                             AND we.wip_entity_id = wdj.wip_entity_id
                                             AND wdj.status_type = 3
                                             AND wdj.PRIMARY_ITEM_ID = '$item_id'
                                             AND ((wdj.start_quantity - wdj.quantity_completed)
                                                           - (SELECT COUNT (kai.no_job)
                                                                FROM KHS_ANDON_ITEM_DEV kai
                                                               WHERE kai.no_job = we.wip_entity_name
                                                                 AND wdj.primary_item_id = kai.item_id)
                                                          ) <> 0
                                             ) xx
                                    WHERE we.WIP_ENTITY_ID = xx.WIP_ENTITY_ID
                                      AND we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
                                      AND msib.INVENTORY_ITEM_ID = wdj.PRIMARY_ITEM_ID
                                      AND msib.ORGANIZATION_ID = wdj.ORGANIZATION_ID")->row_array();

    }

    public function filter_job_agt($range_date, $s)
    {
      $range =  explode(' - ', $range_date);
      $date1 = $range[0];
      $date2 = $range[1];

      if ($s == 'Y') {
        $f = "AND exists (select mtrh.ATTRIBUTE1 from mtl_txn_request_headers mtrh where mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID)";
      }else {
        $f = "AND NOT exists (select mtrh.ATTRIBUTE1 from mtl_txn_request_headers mtrh where mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID)";
      }
      // return $this->oracle->query("SELECT wdj.primary_item_id, we.wip_entity_name no_job, msib.segment1 kode_item, msib.description,
      //                                       wdj.start_quantity qty_job, wdj.quantity_completed, wdj.quantity_scrapped,
      //                                       (wdj.net_quantity - wdj.quantity_completed) remaining_qty,
      //                                       TO_CHAR(wdj.date_released, 'YYYY-MM-DD HH:MI:SS') date_released
      //                                  FROM wip_entities we,
      //                                       wip_discrete_jobs wdj,
      //                                       mtl_system_items_b msib,
      //                                       wip_operations wo,
      //                                       bom_departments bd
      //                                 WHERE we.wip_entity_id = wdj.wip_entity_id
      //                                   AND wdj.status_type = 3
      //                                   AND wdj.primary_item_id = msib.inventory_item_id
      //                                   AND wdj.organization_id = msib.organization_id
      //                                   AND wo.wip_entity_id = wdj.wip_entity_id
      //                                   AND wo.organization_id = wdj.organization_id
      //                                   AND wo.department_id = bd.department_id
      //                                   AND wo.organization_id = bd.organization_id
      //                                   AND bd.department_class_code = 'PRKTA'
      //                                   AND TO_CHAR(wdj.date_released, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'")->result_array();

      return $this->oracle->query("SELECT wdj.primary_item_id, we.wip_entity_name no_job, msib.segment1 kode_item, msib.description,
                                            wdj.start_quantity qty_job, wdj.quantity_completed, wdj.quantity_scrapped,
                                            (wdj.net_quantity - wdj.quantity_completed) remaining_qty,
                                            TO_CHAR(wdj.date_released, 'YYYY-MM-DD HH:MI:SS') date_released
                                       FROM wip_entities we,
                                            wip_discrete_jobs wdj,
                                            mtl_system_items_b msib,
                                            wip_operations wo,
                                            bom_departments bd
                                      WHERE we.wip_entity_id = wdj.wip_entity_id
                                        AND wdj.status_type = 3
                                        AND wdj.primary_item_id = msib.inventory_item_id
                                        AND wdj.organization_id = msib.organization_id
                                        AND wo.wip_entity_id = wdj.wip_entity_id
                                        AND wo.organization_id = wdj.organization_id
                                        AND wo.department_id = bd.department_id
                                        AND wo.organization_id = bd.organization_id
                                        AND bd.department_class_code = 'PRKTA'
                                        AND TO_CHAR(wdj.date_released, 'YYYY-MM-DD') BETWEEN '$date1' AND '$date2'
                                        $f")->result_array();
    }

}
