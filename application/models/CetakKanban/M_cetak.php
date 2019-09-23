<?php
class M_cetak extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->oracle = $this->load->database('oracle', true);
        $this->oracle_dev = $this->load->database('oracle_dev',TRUE);
    }

    function getDeptClass()
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT distinct dept, description
				FROM KHS_DEPT_ROUT_CLASS_V
			  	ORDER BY dept asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getShift($date=FALSE)
	{
		$oracle = $this->load->database('oracle',TRUE);
		if ($date === FALSE) {
			$date = date('Y/m/d');
		}
		$sql = 	"select BCS.SHIFT_NUM,BCS.DESCRIPTION
				from BOM_SHIFT_TIMES bst
			    ,BOM_CALENDAR_SHIFTS bcs
			    ,bom_shift_dates bsd
				where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
				and bst.SHIFT_NUM = bcs.SHIFT_NUM
				and bcs.CALENDAR_CODE='KHS_CAL'
				and bst.shift_num = bsd.shift_num
				and bst.calendar_code=bsd.calendar_code
				and bsd.SEQ_NUM is not null
				and bsd.shift_date=trunc(to_date('$date','YYYY/MM/DD'))
				ORDER BY BCS.SHIFT_NUM asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getJobFrom($term,$tuanggal, $shift)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = 	"SELECT DISTINCT we.wip_entity_name job_number
           		FROM wip_discrete_jobs wdj,
                wip_entities we,
                bom_calendar_shifts bcs
          		WHERE wdj.wip_entity_id = we.wip_entity_id
            	AND khs_shift (wdj.scheduled_start_date) = bcs.shift_num
            	AND to_char (wdj.scheduled_start_date, 'DD/MM/YYYY') = '$tuanggal'
            	AND bcs.shift_num = '$shift'
            	AND we.wip_entity_name  like upper('%$term%')";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getStatus(){
		$oracle = $this->load->database('oracle',TRUE);
		$sql =	"select *
				from khs_odm_list_job_status_v";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function updateData($kegunaan,$due_date,$wipid){
		$sql = "UPDATE WIP_DISCRETE_JOBS wdj set wdj.ATTRIBUTE3 = '$kegunaan', wdj.attribute1 = '$due_date' WHERE wdj.WIP_ENTITY_ID = '$wipid'";
		$query = $this->oracle->query($sql);
		echo $sql;
	}

	function updateDueDate($due_date, $wipid){
		$sql = "UPDATE WIP_DISCRETE_JOBS wdj set wdj.attribute1 = '$due_date' WHERE wdj.WIP_ENTITY_ID = '$wipid'";
		$query = $this->oracle->query($sql);
		echo $sql;
	}

	function updateKegunaan($kegunaan, $wipid){
		$sql = "UPDATE WIP_DISCRETE_JOBS wdj set wdj.ATTRIBUTE3 = '$kegunaan' WHERE wdj.WIP_ENTITY_ID = '$wipid'";
		$query = $this->oracle->query($sql);
		echo $sql;
	}

	function getData($tuanggal,$shift,$deptclass,$jobfrom,$jobto,$status){
		$oracle = $this->load->database('oracle',TRUE);
		//SEBELUM PENAMBAHAN LOCATION CODE
    	// $sql = 	"SELECT
	    //           we.WIP_ENTITY_NAME||'-'||wo.OPERATION_SEQ_NUM qr_code,
	    //           bdc.DEPARTMENT_CLASS_CODE ROUTING_CLASS_DESC,
	    //           we.WIP_ENTITY_ID ,
	    //           bcs.SHIFT_NUM,
	    //           wdj.STATUS_TYPE,
	    //           we.WIP_ENTITY_NAME JOB_NUMBER,
     //              msib.segment1 ITEM_CODE,
     //              msib.UNIT_VOLUME UNIT_VOLUME,
     //              msib.description,
     //              msib.PRIMARY_UOM_CODE UOM_CODE,
     //              (SELECT mcb.segment1
     //              FROM mtl_item_categories mic ,
     //                mtl_categories_b mcb
     //              WHERE msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
     //              AND msib.ORGANIZATION_ID     = mic.ORGANIZATION_ID
     //              AND mic.CATEGORY_ID          = mcb.CATEGORY_ID
     //              AND mic.CATEGORY_SET_ID      = 1100000042
     //              ) TYPE_PRODUCT,
     //              wdj.SCHEDULED_START_DATE,
     //              wdj.SCHEDULED_COMPLETION_DATE NEED_BY,
     //              bcs.description shift,
     //              wo.OPERATION_SEQ_NUM OPR_SEQ,
     //              wo.OPERATION_SEQUENCE_ID,
     //              bd.DEPARTMENT_CODE OPERATION,
     //              bd.DEPARTMENT_CLASS_CODE DEPT_CLASS,
     //              wo.DESCRIPTION KODE_PROSES,
     //              wo.ATTRIBUTE7 ACTIVITY,
     //              wdj.START_QUANTITY TARGET_PPIC,
     //              wdj.ATTRIBUTE3 TUJUAN,
     //              wdj.attribute1 DUE_DATE
     //            FROM wip_discrete_jobs wdj ,
     //              wip_entities we ,
     //              wip_operations wo ,
     //              bom_departments bd ,
     //              mtl_system_items_b msib,
     //              bom_calendar_shifts bcs,
     //              BOM_DEPARTMENT_CLASSES bdc
     //            WHERE wdj.WIP_ENTITY_ID      = we.WIP_ENTITY_ID
     //            --AND we.WIP_ENTITY_NAME       = 'D181100048'   ----------------------> no JOB
     //            -- AND bcs.SHIFT_NUM = '$shift'
     //            AND bcs.SHIFT_NUM = nvl('$shift',bcs.SHIFT_NUM)
     //            AND khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
     //            AND we.WIP_ENTITY_NAME between nvl('$jobfrom',we.WIP_ENTITY_NAME) and nvl('$jobto',we.WIP_ENTITY_NAME)
     //            AND bd.DEPARTMENT_CLASS_CODE = nvl('$deptclass',bd.DEPARTMENT_CLASS_CODE)
     //            AND wdj.STATUS_TYPE in (nvl('$status',wdj.STATUS_TYPE))
     //            AND to_char(wdj.SCHEDULED_START_DATE,'DD/MM/YYYY') = '$tuanggal'
     //            and wdj.STATUS_TYPE in (1,3)
     //            AND wdj.WIP_ENTITY_ID        = wo.WIP_ENTITY_ID
     //            AND wo.DEPARTMENT_ID         = bd.DEPARTMENT_ID
     //            AND wo.ORGANIZATION_ID       = bd.ORGANIZATION_ID
     //            AND bd.DEPARTMENT_CLASS_CODE = bdc.DEPARTMENT_CLASS_CODE
     //            AND wdj.PRIMARY_ITEM_ID      = msib.INVENTORY_ITEM_ID
     //            AND wdj.ORGANIZATION_ID      = msib.ORGANIZATION_ID
     //            AND bd.ORGANIZATION_ID = bdc.ORGANIZATION_ID
     //            AND wo.OPERATION_SEQ_NUM = 10";
		$sql = "SELECT
                  we.WIP_ENTITY_NAME||'-'||wo.OPERATION_SEQ_NUM qr_code,
                  bdc.DEPARTMENT_CLASS_CODE ROUTING_CLASS_DESC,
                  we.WIP_ENTITY_ID ,
                  bcs.SHIFT_NUM,
                  wdj.STATUS_TYPE,
                  we.WIP_ENTITY_NAME JOB_NUMBER,
                  msib.segment1 ITEM_CODE,
                  msib.UNIT_VOLUME UNIT_VOLUME,
                  msib.description,
                  msib.PRIMARY_UOM_CODE UOM_CODE,
                  (SELECT mcb.segment1
                  FROM mtl_item_categories mic ,
                    mtl_categories_b mcb
                  WHERE msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
                  AND msib.ORGANIZATION_ID     = mic.ORGANIZATION_ID
                  AND mic.CATEGORY_ID          = mcb.CATEGORY_ID
                  AND mic.CATEGORY_SET_ID      = 1100000042
                  ) TYPE_PRODUCT,
                  wdj.SCHEDULED_START_DATE,
                  wdj.SCHEDULED_COMPLETION_DATE NEED_BY,
                  bcs.description shift,
                  wo.OPERATION_SEQ_NUM OPR_SEQ,
                  wo.OPERATION_SEQUENCE_ID,
                  bd.DEPARTMENT_CODE OPERATION,
                  bd.DEPARTMENT_CLASS_CODE DEPT_CLASS,
                  wo.DESCRIPTION KODE_PROSES,
                  wo.ATTRIBUTE7 ACTIVITY,
                  wdj.START_QUANTITY TARGET_PPIC,
                  wdj.ATTRIBUTE3 TUJUAN,
                  wdj.attribute1 DUE_DATE,
                  hla.LOCATION_CODE
                FROM wip_discrete_jobs wdj ,
                  wip_entities we ,
                  wip_operations wo ,
                  bom_departments bd ,
                  mtl_system_items_b msib,
                  bom_calendar_shifts bcs,
                  BOM_DEPARTMENT_CLASSES bdc,
                  mtl_secondary_inventories msi,
                  HR_LOCATIONS_ALL hla,
                  bom_operational_routings bor,
                  bom_operation_sequences bos
                WHERE wdj.WIP_ENTITY_ID      = we.WIP_ENTITY_ID
                --AND we.WIP_ENTITY_NAME       = 'D181100048'   ----------------------> no JOB
--                 AND bcs.SHIFT_NUM = '$shift'
                AND bcs.SHIFT_NUM = nvl('$shift',bcs.SHIFT_NUM)
                AND khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
                AND we.WIP_ENTITY_NAME between nvl('$jobfrom',we.WIP_ENTITY_NAME) and nvl('$jobto',we.WIP_ENTITY_NAME)
                AND bd.DEPARTMENT_CLASS_CODE = nvl('$deptclass',bd.DEPARTMENT_CLASS_CODE)
                AND wdj.STATUS_TYPE in (nvl('$status',wdj.STATUS_TYPE))
                AND to_char(wdj.SCHEDULED_START_DATE,'DD/MM/YYYY') = '$tuanggal'
                and wdj.STATUS_TYPE in (1,3)
                AND wdj.WIP_ENTITY_ID        = wo.WIP_ENTITY_ID
                AND wo.DEPARTMENT_ID         = bd.DEPARTMENT_ID
                AND wo.ORGANIZATION_ID       = bd.ORGANIZATION_ID
                AND bd.DEPARTMENT_CLASS_CODE = bdc.DEPARTMENT_CLASS_CODE
                AND wdj.PRIMARY_ITEM_ID      = msib.INVENTORY_ITEM_ID
                AND wdj.ORGANIZATION_ID      = msib.ORGANIZATION_ID
                AND bd.ORGANIZATION_ID = bdc.ORGANIZATION_ID
                AND wo.OPERATION_SEQ_NUM = 10
                and bos.ROUTING_SEQUENCE_ID = wdj.COMMON_ROUTING_SEQUENCE_ID
                and bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
                and bor.COMPLETION_SUBINVENTORY = msi.SECONDARY_INVENTORY_NAME
                AND msi.DISABLE_DATE is null
                and msi.LOCATION_ID=hla.LOCATION_ID(+)";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

  	function getdataprint($date,$shift,$deptclass,$jobfrom,$jobto,$status){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT 
				  we.WIP_ENTITY_NAME||'-'||wo.OPERATION_SEQ_NUM qr_code,
				  bdc.DEPARTMENT_CLASS_CODE ROUTING_CLASS_DESC,
				  mesin.attribute1 NO_MESIN,
				  we.WIP_ENTITY_ID ,
				  we.WIP_ENTITY_NAME JOB_NUMBER,
				  msib.segment1 ITEM_CODE,
				  msib.UNIT_VOLUME UNIT_VOLUME,
				  msib.description,
				  (SELECT mcb.segment1
				  FROM mtl_item_categories mic ,
				    mtl_categories_b mcb
				  WHERE msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
				  AND msib.ORGANIZATION_ID     = mic.ORGANIZATION_ID
				  AND mic.CATEGORY_ID          = mcb.CATEGORY_ID
				  AND mic.CATEGORY_SET_ID      = 1100000042
				  ) TYPE_PRODUCT,
				  msib.PRIMARY_UOM_CODE UOM_CODE,
				  DECODE(wo.OPERATION_SEQ_NUM,
				  (SELECT MAX(wo2.OPERATION_SEQ_NUM)
				  FROM wip_operations wo2
				  WHERE wo2.WIP_ENTITY_ID = wo.WIP_ENTITY_ID
				  ),'FINISH','WIP') status_step,
				  wdj.SCHEDULED_START_DATE,
				  NVL(wdj.attribute1,wdj.SCHEDULED_COMPLETION_DATE) NEED_BY,
				   jmlop.ASSIGNED_UNITS jml_op,
				  bcs.description shift,
				  wo.OPERATION_SEQ_NUM OPR_SEQ,
				  wo.OPERATION_SEQUENCE_ID,
				  bd.DEPARTMENT_CODE OPERATION,
				  bd.DEPARTMENT_CLASS_CODE DEPT_CLASS,
				  wo.DESCRIPTION KODE_PROSES,
				  wo.ATTRIBUTE7 ACTIVITY,
				  mesin.RESOURCE_CODE RESOURCES,
				  wdj.START_QUANTITY TARGET_PPIC,
				  wdj.ATTRIBUTE3 TUJUAN,
				  TO_CHAR(wdj.DATE_RELEASED, 'YYYY/MM/DD HH24:Mi:SS') DATE_RELEASED,
				  TO_CHAR(wdj.CREATION_DATE, 'YYYY/MM/DD HH24:Mi:SS') CREATION_DATE,
				  -- wdj.DATE_RELEASED DATE_RELEASED,
				  floor(target.target) targetSK,
				  floor(330/390*target.target) targetJS,
				  '' PREVIOUS_OPERATION,
				  '' PREVIOUS_DEPT_CLASS,
				  '' NEXT_OPERATION,
				  '' NEXT_DEPT_CLASS
				FROM wip_discrete_jobs wdj ,
				  wip_entities we ,
				  wip_operations wo ,
				  bom_departments bd ,
				  mtl_system_items_b msib,
				  bom_calendar_shifts bcs,
				  BOM_DEPARTMENT_CLASSES bdc,
				  (SELECT bosms.OPERATION_SEQUENCE_ID,
				    brms.RESOURCE_CODE,
				    borsms.ATTRIBUTE1
				  FROM bom_operation_sequences bosms ,
				    bom_operation_resources borsms ,
				    bom_resources brms    
				  WHERE bosms.DISABLE_DATE       IS NULL
				  AND bosms.OPERATION_SEQUENCE_ID = borsms.OPERATION_SEQUENCE_ID
				  AND borsms.RESOURCE_ID          = brms.RESOURCE_ID
				  AND brms.RESOURCE_TYPE          = 1
				  AND brms.AUTOCHARGE_TYPE        = 1
				  AND brms.DISABLE_DATE          IS NULL
				    --and brms.ORGANIZATION_ID = 102
				  )mesin,
				  (SELECT bostg.OPERATION_SEQUENCE_ID,
				    ((6.5/borstg.USAGE_RATE_OR_AMOUNT)*borstg.ASSIGNED_UNITS)target
				  FROM bom_operation_sequences bostg ,
				    bom_operation_resources borstg ,
				    bom_resources brtg
				  WHERE bostg.DISABLE_DATE       IS NULL
				  AND bostg.OPERATION_SEQUENCE_ID = borstg.OPERATION_SEQUENCE_ID
				  AND borstg.RESOURCE_ID          = brtg.RESOURCE_ID
				  AND brtg.RESOURCE_TYPE          = 2
				  AND brtg.AUTOCHARGE_TYPE        = 1
				  AND brtg.DISABLE_DATE          IS NULL
				    --and brtg.ORGANIZATION_ID = 102
				  )target,
				(SELECT bosjo.OPERATION_SEQUENCE_ID,  -------------------------------------->tambahan
				    borsjo.ASSIGNED_UNITS  -------------------------------------->tambahan
				  FROM bom_operation_sequences bosjo ,  -------------------------------------->tambahan
				    bom_operation_resources borsjo ,  -------------------------------------->tambahan
				    bom_resources brjo  -------------------------------------->tambahan
				  WHERE bosjo.DISABLE_DATE       IS NULL  -------------------------------------->tambahan
				  AND bosjo.OPERATION_SEQUENCE_ID = borsjo.OPERATION_SEQUENCE_ID  -------------------------------------->tambahan
				  AND borsjo.RESOURCE_ID          = brjo.RESOURCE_ID  -------------------------------------->tambahan
				  AND brjo.RESOURCE_TYPE          = 2  -------------------------------------->tambahan
				  AND brjo.AUTOCHARGE_TYPE        = 1  -------------------------------------->tambahan
				  AND brjo.DISABLE_DATE          IS NULL)jmlop  -------------------------------------->tambahan
				WHERE wdj.WIP_ENTITY_ID      = we.WIP_ENTITY_ID
				--AND we.WIP_ENTITY_NAME       = 'D181100048'   ----------------------> no JOB
				AND bcs.SHIFT_NUM = '$shift'
				AND khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
				AND we.WIP_ENTITY_NAME between nvl('$jobfrom',we.WIP_ENTITY_NAME) and nvl('$jobto',we.WIP_ENTITY_NAME)
				AND bd.DEPARTMENT_CLASS_CODE = nvl('$deptclass',bd.DEPARTMENT_CLASS_CODE)
				AND wdj.STATUS_TYPE in (nvl('$status',wdj.STATUS_TYPE))
				AND to_char(wdj.SCHEDULED_START_DATE,'DD/MM/YYYY') = '$date'
				and wdj.STATUS_TYPE in (1,3)
				AND wdj.WIP_ENTITY_ID        = wo.WIP_ENTITY_ID
				AND wo.DEPARTMENT_ID         = bd.DEPARTMENT_ID
				AND wo.ORGANIZATION_ID       = bd.ORGANIZATION_ID
				AND bd.DEPARTMENT_CLASS_CODE = bdc.DEPARTMENT_CLASS_CODE
				AND wdj.PRIMARY_ITEM_ID      = msib.INVENTORY_ITEM_ID
				AND wdj.ORGANIZATION_ID      = msib.ORGANIZATION_ID
				AND bd.ORGANIZATION_ID = bdc.ORGANIZATION_ID
				AND wo.OPERATION_SEQUENCE_ID = mesin.OPERATION_SEQUENCE_ID (+)
				AND wo.OPERATION_SEQUENCE_ID = target.OPERATION_SEQUENCE_ID (+)
				AND wo.OPERATION_SEQUENCE_ID = jmlop.OPERATION_SEQUENCE_ID (+)";
		$query = $oracle->query($sql);
    	return $query->result_array();
		// return $sql;
	}

	function getProses($job1,$date2){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT 
                  we.WIP_ENTITY_ID ,
                  we.WIP_ENTITY_NAME JOB_NUMBER,
				  mesin.attribute1 NO_MESIN,
                  DECODE(wo.OPERATION_SEQ_NUM,
                  (SELECT MAX(wo2.OPERATION_SEQ_NUM)
                  FROM wip_operations wo2
                  WHERE wo2.WIP_ENTITY_ID = wo.WIP_ENTITY_ID
                  ),'FINISH','WIP') status_step,
                  wo.OPERATION_SEQ_NUM OPR_SEQ,
                  wo.OPERATION_SEQUENCE_ID,
                  bd.DEPARTMENT_CODE OPERATION,
                  bd.DEPARTMENT_CLASS_CODE DEPT_CLASS,
                  wo.DESCRIPTION KODE_PROSES,
                  wo.ATTRIBUTE7 ACTIVITY,
                  mesin.RESOURCE_CODE RESOURCES
                FROM wip_discrete_jobs wdj ,
                  wip_entities we ,
                  wip_operations wo ,
                  bom_departments bd ,
                  mtl_system_items_b msib,
                  bom_calendar_shifts bcs,
                  BOM_DEPARTMENT_CLASSES bdc,
                  (SELECT bosms.OPERATION_SEQUENCE_ID,
                    brms.RESOURCE_CODE,
                    borsms.ATTRIBUTE1
                  FROM bom_operation_sequences bosms ,
                    bom_operation_resources borsms ,
                    bom_resources brms    
                  WHERE bosms.DISABLE_DATE       IS NULL
                  AND bosms.OPERATION_SEQUENCE_ID = borsms.OPERATION_SEQUENCE_ID
                  AND borsms.RESOURCE_ID          = brms.RESOURCE_ID
                  AND brms.RESOURCE_TYPE          = 1
                  AND brms.AUTOCHARGE_TYPE        = 1
                  AND brms.DISABLE_DATE          IS NULL
                  )mesin,
                  (SELECT bostg.OPERATION_SEQUENCE_ID,
                    ((6.5/borstg.USAGE_RATE_OR_AMOUNT)*borstg.ASSIGNED_UNITS)target
                  FROM bom_operation_sequences bostg ,
                    bom_operation_resources borstg ,
                    bom_resources brtg
                  WHERE bostg.DISABLE_DATE       IS NULL
                  AND bostg.OPERATION_SEQUENCE_ID = borstg.OPERATION_SEQUENCE_ID
                  AND borstg.RESOURCE_ID          = brtg.RESOURCE_ID
                  AND brtg.RESOURCE_TYPE          = 2
                  AND brtg.AUTOCHARGE_TYPE        = 1
                  AND brtg.DISABLE_DATE          IS NULL
                  )target,
                (SELECT bosjo.OPERATION_SEQUENCE_ID,  -------------------------------------->tambahan
                    borsjo.ASSIGNED_UNITS  -------------------------------------->tambahan
                  FROM bom_operation_sequences bosjo ,  -------------------------------------->tambahan
                    bom_operation_resources borsjo ,  -------------------------------------->tambahan
                    bom_resources brjo  -------------------------------------->tambahan
                  WHERE bosjo.DISABLE_DATE       IS NULL  -------------------------------------->tambahan
                  AND bosjo.OPERATION_SEQUENCE_ID = borsjo.OPERATION_SEQUENCE_ID  -------------------------------------->tambahan
                  AND borsjo.RESOURCE_ID          = brjo.RESOURCE_ID  -------------------------------------->tambahan
                  AND brjo.RESOURCE_TYPE          = 2  -------------------------------------->tambahan
                  AND brjo.AUTOCHARGE_TYPE        = 1  -------------------------------------->tambahan
                  AND brjo.DISABLE_DATE          IS NULL)jmlop  -------------------------------------->tambahan
                WHERE wdj.WIP_ENTITY_ID      = we.WIP_ENTITY_ID
                --AND we.WIP_ENTITY_NAME       = 'D181100048'   ----------------------> no JOB
                AND khs_shift(wdj.SCHEDULED_START_DATE) = bcs.SHIFT_NUM
                AND we.WIP_ENTITY_NAME between nvl('$job1',we.WIP_ENTITY_NAME) and nvl('$job1',we.WIP_ENTITY_NAME)
                AND to_char(wdj.SCHEDULED_START_DATE,'DD/MM/YYYY') = '$date2'
                and wdj.STATUS_TYPE in (1,3)
                AND wdj.WIP_ENTITY_ID        = wo.WIP_ENTITY_ID
                AND wo.DEPARTMENT_ID         = bd.DEPARTMENT_ID
                AND wo.ORGANIZATION_ID       = bd.ORGANIZATION_ID
                AND bd.DEPARTMENT_CLASS_CODE = bdc.DEPARTMENT_CLASS_CODE
                AND wdj.PRIMARY_ITEM_ID      = msib.INVENTORY_ITEM_ID
                AND wdj.ORGANIZATION_ID      = msib.ORGANIZATION_ID
                AND bd.ORGANIZATION_ID = bdc.ORGANIZATION_ID
                AND wo.OPERATION_SEQUENCE_ID = mesin.OPERATION_SEQUENCE_ID (+)
                AND wo.OPERATION_SEQUENCE_ID = target.OPERATION_SEQUENCE_ID (+)
                AND wo.OPERATION_SEQUENCE_ID = jmlop.OPERATION_SEQUENCE_ID (+)
                order by wo.OPERATION_SEQ_NUM
                ";

            $query = $oracle->query($sql);
    		return $query->result_array();
	}
}
