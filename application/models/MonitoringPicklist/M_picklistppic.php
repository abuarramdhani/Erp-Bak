<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_picklistppic extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    function getDept($term)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = " SELECT distinct dept, description 
				  FROM KHS_DEPT_ROUT_CLASS_V
                  WHERE dept like '%$term%'
				  ORDER BY dept asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDataBelum($dept, $tgl1, $tgl2)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select distinct
					msib_produk.SEGMENT1 produk
				,msib_produk.DESCRIPTION produk_desc
				,msib_produk.INVENTORY_ITEM_ID item_id_produk 
				,msib_produk.ORGANIZATION_ID org_id_produk
				,bd.DEPARTMENT_CLASS_CODE department
				,mtrh.REQUEST_NUMBER picklist
				,we.WIP_ENTITY_NAME job_no
				,mtrl.FROM_SUBINVENTORY_CODE from_subinv
				,mtrl.TO_SUBINVENTORY_CODE to_subinv
			--      ,wdj.ALTERNATE_ROUTING_DESIGNATOR alt
				,wdj.START_QUANTITY 
			--      ,msib_compnt.SEGMENT1 kode_komponen
			--      ,msib_compnt.DESCRIPTION komp_desc
			--      ,msib_compnt.INVENTORY_ITEM_ID item_id_komp
			--      ,msib_compnt.ORGANIZATION_ID  org_id_komp
			--      ,wro.QUANTITY_PER_ASSEMBLY qty_unit
			from mtl_txn_request_headers mtrh
				,mtl_txn_request_lines mtrl
				,mtl_system_items_b msib_produk
			--    ,mtl_system_items_b msib_compnt
				--
				,wip_entities we
				,wip_discrete_jobs wdj
				,wip_requirement_operations wro
				,wip_operations wo
				,bom_departments bd 
			where mtrh.HEADER_ID = mtrl.HEADER_ID
			--  and mtrl.INVENTORY_ITEM_ID = msib_compnt.INVENTORY_ITEM_ID
			--  and mtrl.ORGANIZATION_ID = msib_compnt.ORGANIZATION_ID
			--
			and we.WIP_ENTITY_ID = mtrh.ATTRIBUTE1
			and we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
			and wdj.PRIMARY_ITEM_ID = msib_produk.INVENTORY_ITEM_ID
			and wdj.ORGANIZATION_ID = msib_produk.ORGANIZATION_ID
			and wro.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
			and wro.ORGANIZATION_ID = wdj.ORGANIZATION_ID
			and wro.WIP_ENTITY_ID = wo.WIP_ENTITY_ID
			and wro.OPERATION_SEQ_NUM = wo.OPERATION_SEQ_NUM
			and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
			and wdj.STATUS_TYPE not in (4, 5, 6, 12)
			--
			and mtrh.REQUEST_NUMBER not in (select distinct kpa.PICKLIST 
												from khs_picklist_approved kpa
												)
			-- 
			and bd.DEPARTMENT_CLASS_CODE = '$dept'
			and TRUNC(wdj.SCHEDULED_START_DATE) BETWEEN to_date('$tgl1','DD/MM/YYYY') AND to_date('$tgl2','DD/MM/YYYY')";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDataSudah($dept, $tgl1, $tgl2)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select distinct
		msib_produk.SEGMENT1 produk
	   ,msib_produk.DESCRIPTION produk_desc
	   ,msib_produk.INVENTORY_ITEM_ID item_id_produk 
	   ,msib_produk.ORGANIZATION_ID org_id_produk
	   ,bd.DEPARTMENT_CLASS_CODE department
	   ,mtrh.REQUEST_NUMBER picklist
	   ,we.WIP_ENTITY_NAME job_no
	   ,mtrl.FROM_SUBINVENTORY_CODE from_subinv
	   ,mtrl.TO_SUBINVENTORY_CODE to_subinv
 --      ,wdj.ALTERNATE_ROUTING_DESIGNATOR alt
	   ,wdj.START_QUANTITY 
 --      ,msib_compnt.SEGMENT1 kode_komponen
 --      ,msib_compnt.DESCRIPTION komp_desc
 --      ,msib_compnt.INVENTORY_ITEM_ID item_id_komp
 --      ,msib_compnt.ORGANIZATION_ID  org_id_komp
 --      ,wro.QUANTITY_PER_ASSEMBLY qty_unit
 from mtl_txn_request_headers mtrh
	 ,mtl_txn_request_lines mtrl
	 ,mtl_system_items_b msib_produk
 --    ,mtl_system_items_b msib_compnt
	 --
	 ,wip_entities we
	 ,wip_discrete_jobs wdj
	 ,wip_requirement_operations wro
	 ,wip_operations wo
	 ,bom_departments bd 
	 --
	 ,khs_picklist_approved kpa
 where mtrh.HEADER_ID = mtrl.HEADER_ID
 --  and mtrl.INVENTORY_ITEM_ID = msib_compnt.INVENTORY_ITEM_ID
 --  and mtrl.ORGANIZATION_ID = msib_compnt.ORGANIZATION_ID
   --
   and we.WIP_ENTITY_ID = mtrh.ATTRIBUTE1
   and we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
   and wdj.PRIMARY_ITEM_ID = msib_produk.INVENTORY_ITEM_ID
   and wdj.ORGANIZATION_ID = msib_produk.ORGANIZATION_ID
   and wro.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
   and wro.ORGANIZATION_ID = wdj.ORGANIZATION_ID
   and wro.WIP_ENTITY_ID = wo.WIP_ENTITY_ID
   and wro.OPERATION_SEQ_NUM = wo.OPERATION_SEQ_NUM
   and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
	 and wdj.STATUS_TYPE not in (4, 5, 6, 12)
   --
   and mtrh.REQUEST_NUMBER = kpa.PICKLIST 
   -- 
   and (select count(kpa_fab.PICKLIST)
		  from khs_picklist_approved kpa_fab
		 where kpa_fab.PROCESS in (1,2,3)
		   and kpa_fab.PICKLIST = kpa.PICKLIST
		 ) = 1
   and kpa.PROCESS = 1 -- ppic
   and bd.DEPARTMENT_CLASS_CODE = '$dept'
   and TRUNC(wdj.SCHEDULED_START_DATE ) BETWEEN to_date('$tgl1','DD/MM/YYYY') AND to_date('$tgl2','DD/MM/YYYY')";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function approvePPIC($picklist, $nojob, $user){
		$oracle = $this->load->database('oracle', true);
		$sql = "insert into khs_picklist_approved(PICKLIST, JOB_NUMBER, PROCESS, APPROVED_DATE, PERSON)
		VALUES('$picklist','$nojob',1,SYSDATE,'$user')";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}

	public function recallPPIC($picklist, $nojob){
		$oracle = $this->load->database('oracle', true);
		$sql = "delete from khs_picklist_approved where picklist = '$picklist' and job_number = '$nojob'";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}

	public function cekapprove($picklist, $nojob){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_picklist_approved where picklist = '$picklist' and job_number = '$nojob' and process = 2";
		$query = $oracle->query($sql);
		return $query->result_array();
	}
	
	public function cekapprove2($picklist){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_picklist_approved where picklist = '$picklist' and process = 1";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function cekdeliver($picklist){
		$oracle = $this->load->database('oracle', true);
		$sql = "select sum(mtrl.QUANTITY_DELIVERED) deliver
		from mtl_txn_request_headers mtrh,
		mtl_txn_request_lines mtrl
		where mtrh.HEADER_ID = mtrl.HEADER_ID
		and mtrh.REQUEST_NUMBER = '$picklist'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

}
