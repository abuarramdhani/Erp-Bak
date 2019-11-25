<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_createkib extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	function getHeader($no)    
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT gbh.BATCH_NO batch_number,
				msib.SEGMENT1 item_code,
				msib.DESCRIPTION ,
				mcb.segment1 TYPE_PRODUCT,
				msib.PRIMARY_UOM_CODE UOM_CODE,
				bcs.DESCRIPTION shift,
				frh.ROUTING_CLASS DEPT_CLASS,
				gmd.PLAN_QTY target_ppic
				FROM GME_BATCH_HEADER gbh ,
				  fm_rout_hdr frh,
				  gme_material_details gmd ,
				  mtl_system_items_b msib ,
				  mtl_item_categories mic ,
				  mtl_categories_b mcb ,
				  bom_calendar_shifts bcs
				WHERE gbh.BATCH_ID             = gmd.BATCH_ID
				AND gbh.ROUTING_ID             = frh.ROUTING_ID
				AND gmd.INVENTORY_ITEM_ID      = msib.INVENTORY_ITEM_ID
				AND gmd.ORGANIZATION_ID        = msib.ORGANIZATION_ID
				AND msib.INVENTORY_ITEM_ID     = mic.INVENTORY_ITEM_ID
				AND msib.ORGANIZATION_ID       = mic.ORGANIZATION_ID
				AND mic.CATEGORY_ID            = mcb.CATEGORY_ID
				AND mic.CATEGORY_SET_ID        = 1100000042
				AND gmd.LINE_TYPE              = 1
				AND gbh.BATCH_NO               = '$no' ----------------------------------> No Batch
				and khs_shift(gbh.PLAN_START_DATE)    = bcs.SHIFT_NUM
				";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDetail($no)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT gbh.batch_no, msib.segment1, msib.description,
				       sum(mmt.transaction_quantity) transaction_quantity, mmt.subinventory_code,
				       mmt.locator_id,
				       mil.description locator_name,
				       CASE
				          WHEN mmt.subinventory_code NOT LIKE '%REJECT%'
				          AND mmt.subinventory_code NOT LIKE '%AFVAL%'
				             THEN 'OK'
				          WHEN mmt.subinventory_code NOT LIKE '%SM%'
				          AND mmt.subinventory_code NOT LIKE '%AFVAL%'
				             THEN 'REJECT'
				          WHEN mmt.subinventory_code NOT LIKE '%SM%'
				          AND mmt.subinventory_code NOT LIKE '%REJECT%'
				             THEN 'SCRAP'
				       END status
				--       mmt.*
				  FROM mtl_material_transactions mmt,
				       gme_batch_header gbh,
				       mtl_system_items_b msib,
				       mtl_item_locations mil
				 WHERE mmt.transaction_source_id = gbh.batch_id
				   AND mmt.organization_id = gbh.organization_id
				   AND mmt.inventory_item_id = msib.inventory_item_id
				   AND mmt.organization_id = msib.organization_id
				   AND mmt.transaction_type_id in (44,17)
				   AND mmt.locator_id = mil.inventory_location_id(+)
				   AND gbh.batch_no = '$no'
				   group by mmt.subinventory_code,gbh.batch_no, msib.segment1, msib.description,mmt.locator_id,mil.description";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getQty($no)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT gmd.WIP_PLAN_QTY PLAN_QTY, gmd.ACTUAL_QTY
				FROM GME_BATCH_HEADER gbh ,
				  gme_material_details gmd 
				WHERE gbh.BATCH_ID             = gmd.BATCH_ID
				AND gmd.LINE_TYPE              = 1
				AND gbh.BATCH_NO               = '$no'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getMO($no,$status)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT count(*) jumlah
			        from mtl_txn_request_headers mtrh, 
			       mtl_txn_request_lines mtrl,
			       mtl_system_items_b msib,
			       GME_BATCH_HEADER gbh
			       where mtrh.HEADER_ID = mtrl.HEADER_ID
			       and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
			       and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
			       and mtrh.ATTRIBUTE1 = gbh.BATCH_ID
			       and mtrh.ORGANIZATION_ID = gbh.ORGANIZATION_ID
			       and gbh.BATCH_NO = '$no'
			       and mtrh.ATTRIBUTE2 = '$status'";
		$query = $oracle->query($sql);
		$result = $query->result_array();
		return $result[0]['JUMLAH'];
	}

	function getSubInv($org)
	{
		$oracle = $this->load->database('oracle',TRUE);
		// $sql = "SELECT temp.ORGANIZATION_ID
		// 		     , hou.NAME
		// 		     , temp.ORGANIZATION_CODE
		// 		     , temp.SUB_INV_CODE
		// 		     , temp.SUB_INV_DESC
		// 		FROM (
		// 		      SELECT DISTINCT mp.ORGANIZATION_CODE organization_code
		// 		           , DECODE (hoi.ORG_INFORMATION_CONTEXT, 'Accounting Information',
		// 		                     TO_NUMBER (hoi.ORG_INFORMATION3), TO_NUMBER (NULL)
		// 		                    ) organization_id
		// 		           , msi.SECONDARY_INVENTORY_NAME sub_inv_code
		// 		           , msi.DESCRIPTION sub_inv_desc 
		// 		      FROM HR_ORGANIZATION_INFORMATION hoi
		// 		         , MTL_PARAMETERS mp
		// 		         , MTL_SECONDARY_INVENTORIES msi
		// 		         , HR_ALL_ORGANIZATION_UNITS haou
		// 		      WHERE hoi.ORGANIZATION_ID = mp.ORGANIZATION_ID
		// 		        AND DECODE (hoi.ORG_INFORMATION_CONTEXT, 'Accounting Information',
		// 		                    TO_NUMBER (hoi.ORG_INFORMATION3), TO_NUMBER (NULL)
		// 		                   ) IS NOT NULL
		// 		        AND haou.ORGANIZATION_ID = hoi.ORGANIZATION_ID
		// 		        AND msi.ORGANIZATION_ID = haou.ORGANIZATION_ID
		// 		        and msi.STATUS_ID = 1
		// 		     ) temp
		// 		   , HR_ALL_ORGANIZATION_UNITS hou
		// 		WHERE temp.ORGANIZATION_ID = hou.ORGANIZATION_ID
		// 		      and temp.ORGANIZATION_CODE = '$org'
		// 		ORDER BY temp.ORGANIZATION_ID
		// 		       , temp.ORGANIZATION_CODE
		// 		       , temp.SUB_INV_CODE";
		$sql = "SELECT mp.ORGANIZATION_CODE, mp.ORGANIZATION_ID, msi.SECONDARY_INVENTORY_NAME SUB_INV_CODE, msi.DESCRIPTION SUB_INV_DESC 
			        from mtl_secondary_inventories msi, MTL_PARAMETERS MP
			        where msi.ORGANIZATION_ID = mp.ORGANIZATION_ID
			        and mp.ORGANIZATION_CODE = '$org'
			        and msi.DISABLE_DATE is null";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDataDefault($batch_number)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql ="SELECT fmd.ATTRIBUTE1 to_organization_id , fmd.ATTRIBUTE2 to_subinventory_code ,fmd.ATTRIBUTE3 to_locator_id
				FROM fm_matl_dtl fmd ,
				  gmd_recipes_b grb ,
				  fm_rout_hdr frh,
				  GME_BATCH_HEADER gbh
				WHERE fmd.LINE_TYPE     = 1
				AND fmd.FORMULA_ID    = grb.FORMULA_ID
				AND grb.ROUTING_ID    = frh.ROUTING_ID
				AND gbh.ROUTING_ID    = frh.ROUTING_ID
				AND gbh.BATCH_NO = '$batch_number'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getJobID($no)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT gbh.BATCH_ID, gmd.INVENTORY_ITEM_ID
				FROM GME_BATCH_HEADER gbh ,
				  gme_material_details gmd 
				WHERE gbh.BATCH_ID             = gmd.BATCH_ID
				AND gmd.LINE_TYPE              = 1
				AND gbh.BATCH_NO               = '$no' ";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function createTemp($data)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$oracle->trans_start();
		$oracle->insert('CREATE_MO_KIB_TEMP',$data);
		$oracle->trans_complete();
	}

	function createMO($nour,$ip_address,$job_id,$subInv,$locator,$subInvFrom,$locatorFrom,$status)
	{
		$conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
		// $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
			if (!$conn) {
	   			 $e = oci_error();
	    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}
		  
		$sql =  "BEGIN APPS.KHS_CREATE_MO_PL(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6,:P_PARAM7,:P_PARAM8,:P_PARAM9,:P_PARAM10); END;";

		// $locator = 29;
		$param4 = '';
		$username = 'AA TECH TSR 01';
		$ip = $ip_address;
		$jan = 64;

		//Statement does not change
		$stmt = oci_parse($conn,$sql);                     
		oci_bind_by_name($stmt,':P_PARAM1',$subInvFrom);           
		oci_bind_by_name($stmt,':P_PARAM2',$locatorFrom); 
		oci_bind_by_name($stmt,':P_PARAM3',$subInv);
		oci_bind_by_name($stmt,':P_PARAM4',$locator);
		oci_bind_by_name($stmt,':P_PARAM5',$username);
		oci_bind_by_name($stmt,':P_PARAM6',$ip_address);
		oci_bind_by_name($stmt,':P_PARAM7',$jan);
		oci_bind_by_name($stmt,':P_PARAM8',$job_id);
		oci_bind_by_name($stmt,':P_PARAM9',$nour);
		oci_bind_by_name($stmt,':P_PARAM10',$status);


		
		

		// //But BEFORE statement, Create your cursor
		$cursor = oci_new_cursor($conn);
		
		// // On your code add the latest parameter to bind the cursor resource to the Oracle argument
		// oci_bind_by_name($stmt,":OUTPUT_CUR", $cursor,-1,OCI_B_CURSOR);
		
		// Execute the statement as in your first try
		oci_execute($stmt);
		
		// // and now, execute the cursor
		oci_execute($cursor);
		
		// // Use OCIFetchinto in the same way as you would with SELECT
		// while ($data = oci_fetch_assoc($cursor, OCI_RETURN_LOBS )) {
		//     print_r($data}
		// }
 		  // $params = array(
     //                    array('name'=>':P_PARAM1', 'value'=>'$subInvFrom', 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM2', 'value'=>29, 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM3', 'value'=>'$subInv', 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM4', 'value'=>29, 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM5', 'value'=>'AA TECH TSR 01', 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM6', 'value'=>'$ip_address', 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM7', 'value'=>64, 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM8', 'value'=>'$job_id', 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM9', 'value'=>'$nour', 'type'=>SQLT_CHR, 'length'=>-1),
     //                    array('name'=>':P_PARAM10', 'value'=>'$status', 'type'=>SQLT_CHR, 'length'=>-1)
     //      );

    	//   // oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
		  // $r = ociexecute($stmt);
		  
		  // $oracle->query($sql,$params);

		// $oracle->trans_complete();
	}

	function deleteTemp($ip, $job_id)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "DELETE from CREATE_MO_KIB_TEMP where IP_ADDRESS = '$ip' and JOB_ID = $job_id ";
		$oracle->trans_start();
		$oracle->query($sql);
		$oracle->trans_complete();
	}


	function getKIBNumber($no)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT mtrh.REQUEST_NUMBER no_kib,
		       msib.SEGMENT1,
		       msib.DESCRIPTION,
		       mtrl.QUANTITY,
		       mtrh.FROM_SUBINVENTORY_CODE,
		       mtrh.TO_SUBINVENTORY_CODE
		        from mtl_txn_request_headers mtrh, 
		       mtl_txn_request_lines mtrl,
		       mtl_system_items_b msib,
		       GME_BATCH_HEADER gbh
		       where mtrh.HEADER_ID = mtrl.HEADER_ID
		       and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
		       and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
		       and mtrh.ATTRIBUTE1 = gbh.BATCH_ID
		       and mtrh.ORGANIZATION_ID = gbh.ORGANIZATION_ID
		       and gbh.BATCH_NO = '$no'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getResultMO($no)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT mtrh.REQUEST_NUMBER no_kib,
			       msib.SEGMENT1,
			       msib.DESCRIPTION,
			       mtrl.QUANTITY,
			       mtrh.FROM_SUBINVENTORY_CODE,
			       mtrh.TO_SUBINVENTORY_CODE
			        from mtl_txn_request_headers mtrh, 
			       mtl_txn_request_lines mtrl,
			       mtl_system_items_b msib,
			       GME_BATCH_HEADER gbh
			       where mtrh.HEADER_ID = mtrl.HEADER_ID
			       and msib.INVENTORY_ITEM_ID = mtrl.INVENTORY_ITEM_ID
			       and msib.ORGANIZATION_ID = mtrl.ORGANIZATION_ID
			       and mtrh.ATTRIBUTE1 = gbh.BATCH_ID
			       and mtrh.ORGANIZATION_ID = gbh.ORGANIZATION_ID
			       and gbh.BATCH_NO = '$no'";
		$query  =$oracle->query($sql);
		return $query->result_array();
	}

	function getLocator($org,$subInv)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = " SELECT mil.INVENTORY_LOCATION_ID, mil.DESCRIPTION from mtl_item_locations mil, mtl_parameters mp
			        where mil.ORGANIZATION_ID = mp.ORGANIZATION_ID
			        and mil.ENABLED_FLAG = 'Y'
			        and mp.ORGANIZATION_CODE = '$org'
			        and mil.SUBINVENTORY_CODE = '$subInv'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getOrgFrom($no){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = " SELECT mp.ORGANIZATION_CODE 
					FROM GME_BATCH_HEADER gbh, MTL_PARAMETERS MP
					WHERE gbh.ORGANIZATION_ID = mp.ORGANIZATION_ID
					and gbh.BATCH_NO = '$no'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getPeriod($date){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = " SELECT oap.OPEN_FLAG FROM org_acct_periods OAP
			       WHERE OAP.ORGANIZATION_ID = 101
			       AND OAP.PERIOD_NAME = '$date' ";
		$query = $oracle->query($sql);
		$result = $query->result_array();
		return $result[0]['OPEN_FLAG'];
	}

	function getHandling($item_code,$org){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT MSIB.UNIT_VOLUME FROM MTL_SYSTEM_ITEMS_B MSIB, MTL_PARAMETERS MP
		       WHERE MSIB.ORGANIZATION_ID = MP.ORGANIZATION_ID
		       AND MSIB.SEGMENT1 = '$item_code'
		       AND MP.ORGANIZATION_CODE = '$org'";
		$query = $oracle->query($sql);
		$result = $query->result_array();
		return $result[0]['UNIT_VOLUME'];
	}

	function getDataKIB($qtyhandling, $no){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT  gbh.ORGANIZATION_ID ,
					    frh.ROUTING_CLASS ROUTING_DEPT_CLASS ,
					    gbh.PLAN_START_DATE PLANED_DATE,
					    bcs.SHIFT_NUM PLANSHIFT_NUM,
					    gob.OPRN_ID,
					    gmd.INVENTORY_ITEM_ID PRIMARY_ITEM_ID,
					    gmd.PLAN_QTY SCHEDULED_QUANTITY,
					    $qtyhandling QTY_KIB,
					    frh.ROUTING_ID DEPARTMENT_ID,
					-- --    'KIBSHMTXXX' KIB_CODE,
					--     frh2.ROUTING_CLASS|| TO_CHAR (SYSDATE, 'RRMM')
					--              || LPAD (KHS_CREATE_MO_SEQ.NEXTVAL, 5, '0') KIB_CODE,
					    mp.ORGANIZATION_CODE KIB_GROUP,
					    'N' inventory_trans_flag,
					    NULL qty_transaction,
					    gbh.BATCH_ID order_id,
					    NULL flag_cancel,
					    sysdate creation_date,
					    NULL BATCHSTEP_ID
					FROM GME_BATCH_HEADER gbh ,
					  fm_rout_hdr frh,
					  gme_material_details gmd ,
					  mtl_system_items_b msib ,
					  mtl_item_categories mic ,
					  mtl_categories_b mcb ,
					  gme_batch_steps gbs ,
					  gmd_operations_b gob ,
					  gme_batch_step_activities gbsa ,
					  gmd_operation_activities goa ,
					  gme_batch_step_resources gbsr ,
					  cr_rsrc_mst_tl crmt ,
					  cr_rsrc_mst_b crmb,
					  bom_calendar_shifts bcs,
					  --
					  GME_BATCH_HEADER gbh2,
					  fm_rout_hdr frh2,
					  mtl_parameters mp
					WHERE gbh.BATCH_ID             = gmd.BATCH_ID
					AND gbh.ROUTING_ID             = frh.ROUTING_ID
					AND gmd.INVENTORY_ITEM_ID      = msib.INVENTORY_ITEM_ID
					AND gmd.ORGANIZATION_ID        = msib.ORGANIZATION_ID
					AND msib.INVENTORY_ITEM_ID     = mic.INVENTORY_ITEM_ID
					AND msib.ORGANIZATION_ID       = mic.ORGANIZATION_ID
					AND mic.CATEGORY_ID            = mcb.CATEGORY_ID
					AND mic.CATEGORY_SET_ID        = 1100000042
					AND gmd.LINE_TYPE              = 1
					AND gbh.BATCH_ID               = gbs.BATCH_ID
					AND gbs.OPRN_ID                = gob.OPRN_ID
					AND gbh.BATCH_ID               = gbsa.BATCH_ID
					AND gbsa.OPRN_LINE_ID          = goa.OPRN_LINE_ID
					AND gob.OPRN_ID                = goa.OPRN_ID
					AND gbs.BATCHSTEP_ID           = gbsa.BATCHSTEP_ID
					AND gbs.BATCH_ID               = gbsr.BATCH_ID
					AND gbs.BATCHSTEP_ID           = gbsr.BATCHSTEP_ID
					AND gbsa.BATCHSTEP_ACTIVITY_ID = gbsr.BATCHSTEP_ACTIVITY_ID
					AND gbsr.RESOURCES             =crmb.RESOURCES
					AND gbsr.RESOURCES             =crmt.RESOURCES
					AND crmb.RESOURCE_CLASS        = 'MESIN'
					AND gbh.ORGANIZATION_ID        = mp.ORGANIZATION_ID
					AND gbh.BATCH_NO               = '$no' ----------------------------------> No Batch
					and khs_shift(gbh.PLAN_START_DATE)    = bcs.SHIFT_NUM
					AND gbh2.ROUTING_ID           = frh2.ROUTING_ID
					AND gbh2.BATCH_ID               = gbh.BATCH_ID ";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getKIB($status,$no,$kib){
		$oracle = $this->load->database('oracle',TRUE);
		$qstatus = "";
		$qkib = "";
		if ($status == null) {
			$qkib = "and mtrh.REQUEST_NUMBER = NVL('".$kib."',mtrh.REQUEST_NUMBER)";
		}

		if ($kib == null) {
			$qstatus = "AND mtrh.ATTRIBUTE2 = '".$status."' ";
		}

		if ($kib != null && $status != null) {
			$qkib = "and mtrh.REQUEST_NUMBER = NVL('".$kib."',mtrh.REQUEST_NUMBER)";
			$qstatus = "AND mtrh.ATTRIBUTE2 = '".$status."' ";
		}


		$sql=" SELECT  
				  mtrh.FROM_SUBINVENTORY_CODE,
				  mtrl.TO_SUBINVENTORY_CODE,
				  mtrl.QUANTITY,
				  gbs.BATCHSTEP_NO opr_seq,
				  gbsa.ACTIVITY ,
				  msib.SEGMENT1 item_code,
				  msib.DESCRIPTION ,
				  msib.CONTAINER_TYPE_CODE kode_kontainer,
  				  FLV.MEANING deskripsi_kontainer,
				  mcb.segment1 tipe_product,
				  gmd.PLAN_QTY plan_qty,
				  gmd.ACTUAL_QTY actual_qty,
				  decode(mtrh.ATTRIBUTE2,1,'OK',2,'REJECT',3,'SCRAP') status, 
				  mtrh.REQUEST_NUMBER,
				   gbh.BATCH_NO batch_number
				FROM GME_BATCH_HEADER gbh ,
				  fm_rout_hdr frh,
				  gme_material_details gmd ,
				  mtl_system_items_b msib ,
				  mtl_item_categories mic ,
				  mtl_categories_b mcb ,
				  gme_batch_steps gbs ,
				  gmd_operations_b gob ,
				  gme_batch_step_activities gbsa ,
				  gmd_operation_activities goa ,
				  gme_batch_step_resources gbsr ,
				  cr_rsrc_mst_tl crmt ,
				  cr_rsrc_mst_b crmb,
				  bom_calendar_shifts bcs,
				  mtl_txn_request_headers mtrh,
				  mtl_txn_request_lines mtrl,
				  fnd_lookup_values flv
				WHERE gbh.BATCH_ID             = gmd.BATCH_ID
				AND gbh.ROUTING_ID             = frh.ROUTING_ID
				AND gmd.INVENTORY_ITEM_ID      = msib.INVENTORY_ITEM_ID
				AND gmd.ORGANIZATION_ID        = msib.ORGANIZATION_ID
				AND msib.INVENTORY_ITEM_ID     = mic.INVENTORY_ITEM_ID
				AND msib.ORGANIZATION_ID       = mic.ORGANIZATION_ID
				AND mic.CATEGORY_ID            = mcb.CATEGORY_ID
				AND mic.CATEGORY_SET_ID        = 1100000042
				AND gmd.LINE_TYPE              = 1
				AND gbh.BATCH_ID               = gbs.BATCH_ID
				AND gbs.OPRN_ID                = gob.OPRN_ID
				AND gbh.BATCH_ID               = gbsa.BATCH_ID
				AND gbsa.OPRN_LINE_ID          = goa.OPRN_LINE_ID
				AND gob.OPRN_ID                = goa.OPRN_ID
				AND gbs.BATCHSTEP_ID           = gbsa.BATCHSTEP_ID
				AND gbs.BATCH_ID               = gbsr.BATCH_ID
				AND gbs.BATCHSTEP_ID           = gbsr.BATCHSTEP_ID
				AND gbsa.BATCHSTEP_ACTIVITY_ID = gbsr.BATCHSTEP_ACTIVITY_ID
				AND gbsr.RESOURCES             = crmb.RESOURCES
				AND gbsr.RESOURCES             = crmt.RESOURCES
				and gbh.BATCH_ID               = mtrh.ATTRIBUTE1
				and mtrh.HEADER_ID             = mtrl.HEADER_ID
				and msib.CONTAINER_TYPE_CODE   = flv.LOOKUP_CODE (+)
				and flv.LOOKUP_TYPE (+)        = 'CONTAINER_TYPE'
				AND crmb.RESOURCE_CLASS        = 'MESIN'
				AND gbh.BATCH_NO               = '$no' ----------------------------------> No Batch
				and khs_shift(gbh.PLAN_START_DATE)    = bcs.SHIFT_NUM
				$qstatus 
				$qkib ";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getKIB2($status,$batch_number, $kib){
		$oracle = $this->load->database('oracle',TRUE);
		// if ($kib == 0) {
		// 	$kib = NULL;
		// }
		$sql = " SELECT kkk.FROM_SUBINVENTORY_CODE FROM_SUBINVENTORY_CODE
			      ,kkk.TO_SUBINVENTORY_CODE
			      ,msi.ATTRIBUTE1 ALIAS_KODE
			      ,decode(kkk.ITEM_STATUS,1,'OK',2,'REJECT',3,'SCRAP') status
			      ,msib.SEGMENT1 item_code
			      ,msib.DESCRIPTION
			      ,msib.CONTAINER_TYPE_CODE kode_kontainer
				  ,kkk.QTY_HANDLING HANDLING_QTY
			      ,flv.DESCRIPTION deskripsi_kontainer
			      ,gmd.PLAN_QTY plan_qty
			      ,gmd.ACTUAL_QTY actual_qty
			      ,kkk.QTY_KIB QUANTITY
			      ,kkk.KIBCODE request_number
			      ,gbh.BATCH_NO batch_number
			      ,gbs.BATCHSTEP_NO opr_seq
			      ,gbsa.ACTIVITY
			      -- status
			from khs_kib_kanban kkk
			    ,gme_material_details gmd
			    ,gme_batch_header gbh
			    ,gme_batch_steps gbs
			    ,gme_batch_step_activities gbsa
			    ,mtl_system_items_b msib 
			    ,fnd_lookup_values flv
			    ,mtl_secondary_inventories msi
			where kkk.ORDER_ID = gbh.BATCH_ID
			  and kkk.ORGANIZATION_ID = gbh.ORGANIZATION_ID
			  and gbh.BATCH_ID = gmd.BATCH_ID
			  --
			  and gbh.BATCH_ID = gbs.BATCH_ID
			  and gbs.BATCHSTEP_ID = gbsa.BATCHSTEP_ID
			  --
			  and msib.CONTAINER_TYPE_CODE   = flv.LOOKUP_CODE (+)
			  and flv.LOOKUP_TYPE (+)            = 'CONTAINER_TYPE'
			  --
			  and msib.INVENTORY_ITEM_ID = kkk.PRIMARY_ITEM_ID
			  and msib.ORGANIZATION_ID = kkk.ORGANIZATION_ID
			  and kkk.TO_SUBINVENTORY_CODE = msi.SECONDARY_INVENTORY_NAME(+)
			  and kkk.TO_ORG_ID = msi.ORGANIZATION_ID(+)
			      AND gbh.BATCH_NO = '$batch_number'
			   AND kkk.ITEM_STATUS = '$status'
			  --
			  and gmd.LINE_TYPE = 1
			  and kkk.KIBCODE =  NVL('$kib',kkk.KIBCODE) --= in ('SHMT181201689')";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getKIB222($status,$batch_number,$kib) {
		//batch number diganti item
		$oracle = $this->load->database('oracle',TRUE);

		$itemku = $batch_number;
		$N = 'N';

		if ($status != 1) {
			$statusku = "and kkk.PRINT_FLAG = 'N'";
		} else {
			// $statusku = "and kkk.PRINT_FLAG = NVL(null,'N')";
			$statusku = "and kkk.PRINT_FLAG = 'Y'";
		}

		if ($kib != null) {
			$kibku = "and kkk.KIBCODE =  NVL('$kib',kkk.KIBCODE)";
		} else {
			$kibku = 'and kkk.KIBCODE =  NVL(NULL,kkk.KIBCODE)';
		}
		

		$sql = "SELECT kkk.FROM_SUBINVENTORY_CODE FROM_SUBINVENTORY_CODE
				  ,mil.SEGMENT1 TO_LOCATOR 
                  ,kkk.TO_SUBINVENTORY_CODE
                  ,msi.ATTRIBUTE1 ALIAS_KODE
                  ,msib.SEGMENT1 item_code
                  ,msib.DESCRIPTION
                  ,msib.CONTAINER_TYPE_CODE kode_kontainer
                  ,kkk.QTY_HANDLING HANDLING_QTY
                  ,flv.DESCRIPTION deskripsi_kontainer
                  ,kkk.QTY_KIB QUANTITY
                  ,kkk.KIBCODE request_number
                  -- status
            from khs_kib_kanban kkk
                ,mtl_system_items_b msib 
                ,fnd_lookup_values flv
                ,mtl_secondary_inventories msi
                ,MTL_ITEM_LOCATIONS mil
            where msib.CONTAINER_TYPE_CODE   = flv.LOOKUP_CODE (+)
              and flv.LOOKUP_TYPE (+)            = 'CONTAINER_TYPE'
              --
              and msib.INVENTORY_ITEM_ID = kkk.PRIMARY_ITEM_ID
              and msib.ORGANIZATION_ID = kkk.ORGANIZATION_ID
              and kkk.TO_SUBINVENTORY_CODE = msi.SECONDARY_INVENTORY_NAME(+)
              and kkk.TO_ORG_ID = msi.ORGANIZATION_ID(+)
              --
              and mil.INVENTORY_LOCATION_ID = kkk.TO_LOCATOR_ID
              --
			  and msib.SEGMENT1 = '$itemku'
              and kkk.INVENTORY_TRANS_FLAG = 'N'
              $statusku
              $kibku";

        $query = $oracle->query($sql);
		return $query->result_array();
        // return $sql;
           //--= in ('SHMT181201689')
	}
	

	function getKIB22($status,$batch_number, $kib){
		$oracle = $this->load->database('oracle',TRUE);
		// if ($kib == 0) {
		// 	$kib = NULL;
		// }
		$sql = " SELECT kkk.FROM_SUBINVENTORY_CODE FROM_SUBINVENTORY_CODE 
				      ,kkk.TO_SUBINVENTORY_CODE
				      ,mil.SEGMENT1 TO_LOCATOR 
				      ,msi.ATTRIBUTE1 ALIAS_KODE
				      ,decode(kkk.ITEM_STATUS,1,'OK',2,'REJECT',3,'SCRAP') status
				      ,msib.SEGMENT1 item_code
				      ,msib.DESCRIPTION
				      ,msib.CONTAINER_TYPE_CODE kode_kontainer
					  ,kkk.QTY_HANDLING HANDLING_QTY
				      ,flv.DESCRIPTION deskripsi_kontainer
				      ,wdj.START_QUANTITY plan_qty
				      ,wdj.QUANTITY_COMPLETED actual_qty
				      ,kkk.QTY_KIB QUANTITY
				      ,kkk.KIBCODE request_number
				      ,we.WIP_ENTITY_NAME batch_number
				      ,bos.OPERATION_SEQ_NUM opr_seq
				      ,bd.DEPARTMENT_CODE ACTIVITY
				FROM wip_discrete_jobs wdj,
					wip_entities we,
					khs_kib_kanban kkk,
					fnd_lookup_values flv,
					mtl_secondary_inventories msi,
					mtl_system_items_b msib,
					bom_operational_routings bor,
					bom_operation_sequences bos,
					bom_departments bd,
					wip_operations wo,
					MTL_ITEM_LOCATIONS mil
				WHERE wdj.WIP_ENTITY_ID = we.WIP_ENTITY_ID
					and wdj.ORGANIZATION_ID = we.ORGANIZATION_ID
					and wdj.WIP_ENTITY_ID = kkk.ORDER_ID
					and wdj.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
					and wdj.ORGANIZATION_ID = msib.ORGANIZATION_ID
					and msib.CONTAINER_TYPE_CODE   = flv.LOOKUP_CODE (+)
					and flv.LOOKUP_TYPE (+)            = 'CONTAINER_TYPE'
					and msib.INVENTORY_ITEM_ID = kkk.PRIMARY_ITEM_ID
					and msib.ORGANIZATION_ID = kkk.ORGANIZATION_ID
					and kkk.TO_SUBINVENTORY_CODE = msi.SECONDARY_INVENTORY_NAME(+)
					and kkk.TO_ORG_ID = msi.ORGANIZATION_ID(+)
					and wdj.PRIMARY_ITEM_ID = bor.ASSEMBLY_ITEM_ID
					and wdj.ORGANIZATION_ID = bor.ORGANIZATION_ID
					and bor.ROUTING_SEQUENCE_ID=bos.ROUTING_SEQUENCE_ID
					and bos.DEPARTMENT_ID = bd.DEPARTMENT_ID
					and we.WIP_ENTITY_ID = wo.WIP_ENTITY_ID
					and we.ORGANIZATION_ID = wo.ORGANIZATION_ID
					and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
					and wo.ORGANIZATION_ID = bd.ORGANIZATION_ID
					and bor.ALTERNATE_ROUTING_DESIGNATOR is null
					--
		            and kkk.TO_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
		            --
					and we.WIP_ENTITY_NAME = '$batch_number'
					AND kkk.ITEM_STATUS = '$status'
					and kkk.KIBCODE =  NVL('$kib',kkk.KIBCODE)
			";
		$query = $oracle->query($sql);
		return $query->result_array();
		// return $sql;
	}

	function getKIB3($no_batch){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT kkk.kibcode NOMORSET
				 ,msibassy.SEGMENT1 kode_assy
				 ,msibassy.DESCRIPTION desc_assy
				 ,kkk.QTY_HANDLING qty_assy
				 ,msibassy.PRIMARY_UOM_CODE uom_assy
				 ,kkk.PRINT_FLAG
				 ,kkk.FROM_SUBINVENTORY_CODE
				 ,milfrom.SEGMENT1 from_locator
				 ,kkk.TO_SUBINVENTORY_CODE
				 ,milto.SEGMENT1 to_locator
				 ,msibkom.segment1 kode_komp
				 ,msibkom.description desc_komp
				 ,kkk.qty_kib
				 ,msibkom.PRIMARY_UOM_CODE uom_komp
				 ,msi.ATTRIBUTE1 ALIAS_KODE
				FROM 
				MTL_SYSTEM_ITEMS_B msibkom ,
				 mtl_system_items_b msibassy,
				khs_kib_kanban kkk ,
				mtl_item_locations milfrom,
				mtl_item_locations milto,
				mtl_secondary_inventories msi
				WHERE kkk.kibcode = '$no_batch'
				and kkk.ORGANIZATION_ID = msibkom.ORGANIZATION_ID
				AND msibkom.INVENTORY_ITEM_ID = kkk.PRIMARY_ITEM_ID
				and msibassy.INVENTORY_ITEM_ID = kkk.KETERANGAN
				and msibassy.ORGANIZATION_ID = kkk.TO_ORG_ID
				and kkk.FROM_LOCATOR_ID = milfrom.INVENTORY_LOCATION_ID (+)
				and kkk.TO_LOCATOR_ID = milto.INVENTORY_LOCATION_ID (+)
				and kkk.TO_SUBINVENTORY_CODE = msi.SECONDARY_INVENTORY_NAME(+)
				and kkk.TO_ORG_ID = msi.ORGANIZATION_ID(+)";
		$query = $oracle->query($sql);
		return $query->result_array();
		// return $sql;
	}

	function saveKIB($data){
		$oracle = $this->load->database('oracle',TRUE);
		$oracle->trans_start();
		$oracle->insert('KHS_KIB_KANBAN',$data);
		$oracle->trans_complete();
	}

	function getOrgId($org){
		$oracle = $this->load->database('oracle',TRUE);
		$sql=" SELECT mp.organization_id FROM mtl_parameters mp
				WHERE mp.organization_code = '$org' ";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getKIBNumber2($job_id){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT  frh.ROUTING_CLASS|| TO_CHAR (SYSDATE, 'RRMM')
		             || LPAD (KHS_CREATE_MO_SEQ.NEXTVAL, 5, '0') NO_KIB
		        FROM GME_BATCH_HEADER gbh,
		          fm_rout_hdr frh
		        WHERE gbh.ROUTING_ID           = frh.ROUTING_ID
		        AND gbh.BATCH_ID               = '$job_id'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getAliasKode($subInv){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = " SELECT ATTRIBUTE1 KODE_ALIAS
				 FROM mtl_secondary_inventories msi
				 WHERE msi.ORGANIZATION_ID in (101,102,225)
				 AND SECONDARY_INVENTORY_NAME = '$subInv'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}
	function updateFlagPrint($batch_number,$kib){
		$oracle = $this->load->database('oracle',TRUE);
		if ($kib) {
			$sql = "UPDATE KHS_KIB_KANBAN SET PRINT_FLAG = 'Y' WHERE KIBCODE = '$kib' ";
		}else{
			if ($batch_number) {
				$sqlgetBatchId = "SELECT batch_id FROM gme_batch_header WHERE batch_no = '$batch_number'";
				$queryBatchId = $oracle->query($sqlgetBatchId);
				$ArrBatchId = $queryBatchId->result_array();
				$BatchId = $ArrBatchId[0]['BATCH_ID'];
				$sql = "UPDATE KHS_KIB_KANBAN SET PRINT_FLAG = 'Y' WHERE ORDER_ID = '$BatchId'";
			}

		}
		$query = $oracle->query($sql);
	}

	function getItemId($batch_number) {
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT distinct msib.INVENTORY_ITEM_ID from mtl_system_items_b msib where msib.SEGMENT1 = '$batch_number'";
		$query = $oracle->query($sql);
		return $query->result_array();
		// return $sql;

	}

	function updateFlagPrint2($batch_number){
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "UPDATE KHS_KIB_KANBAN SET PRINT_FLAG = 'Y' WHERE PRIMARY_ITEM_ID = '$batch_number' ";
		$query = $oracle->query($sql);
	}


}

