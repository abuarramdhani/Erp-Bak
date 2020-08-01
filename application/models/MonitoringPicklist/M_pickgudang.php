<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pickgudang extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getSubinv($term) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT msi.secondary_inventory_name sub_inv_code,
                        msi.description sub_inv_desc
                FROM mtl_secondary_inventories msi
                WHERE msi.secondary_inventory_name LIKE '%$term%'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
	}
	
	public function getdataBelum($sub, $tgl1, $tgl2) {
        $oracle = $this->load->database('oracle', true);
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
				--
				,(select kpa_ppic.APPROVED_DATE
					from khs_picklist_approved kpa_ppic
					where kpa_ppic.PICKLIST = mtrh.REQUEST_NUMBER
						and kpa_ppic.PROCESS = 1 -- ppic
						) release_ppic
				,kpa.APPROVED_DATE realase_fabrikasi
				,wdj.SCHEDULED_START_DATE date_job
				,mil.SEGMENT1 locator
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
				,MTL_ITEM_LOCATIONS mil
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
            and wro.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID (+)
			and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
			and wdj.STATUS_TYPE not in (5, 6, 12)
			--
			and mtrh.REQUEST_NUMBER = kpa.PICKLIST 
			-- 
			and (select count(kpa_fab.PICKLIST)
					from khs_picklist_approved kpa_fab
					where kpa_fab.PROCESS in (1,2,3)
					and kpa_fab.PICKLIST = kpa.PICKLIST
					) = 2
			and kpa.PROCESS = 2 -- fabrikasi
			and mtrl.FROM_SUBINVENTORY_CODE = '$sub'
			--  and bd.DEPARTMENT_CLASS_CODE = 'WELD'
			and TRUNC(wdj.SCHEDULED_START_DATE) BETWEEN to_date('$tgl1','DD/MM/YYYY') AND to_date('$tgl2','DD/MM/YYYY')
			order by 12 desc ";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
	}
	
	public function getdataSudah($sub, $tgl1, $tgl2) {
        $oracle = $this->load->database('oracle', true);
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
				--
				,(select kpa_ppic.APPROVED_DATE
					from khs_picklist_approved kpa_ppic
					where kpa_ppic.PICKLIST = mtrh.REQUEST_NUMBER
						and kpa_ppic.PROCESS = 1 -- ppic
						) release_ppic
				,kpa.APPROVED_DATE realase_gudang
				,wdj.SCHEDULED_START_DATE date_job
				,mil.SEGMENT1 locator
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
				,MTL_ITEM_LOCATIONS mil
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
            and wro.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID (+)       
			and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
			and wdj.STATUS_TYPE not in (5, 6, 12)
			--
			and mtrh.REQUEST_NUMBER = kpa.PICKLIST 
			-- 
			and (select count(kpa_fab.PICKLIST)
					from khs_picklist_approved kpa_fab
					where kpa_fab.PROCESS in (1,2,3)
					and kpa_fab.PICKLIST = kpa.PICKLIST
					) = 3
			and kpa.PROCESS = 3 -- gudang
			and mtrl.FROM_SUBINVENTORY_CODE = '$sub'
			--  and bd.DEPARTMENT_CLASS_CODE = 'WELD'
			and TRUNC(wdj.SCHEDULED_START_DATE) BETWEEN to_date('$tgl1','DD/MM/YYYY') AND to_date('$tgl2','DD/MM/YYYY')";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
	}
	
	public function cekapp($nojob, $picklist){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_picklist_approved where picklist = '$picklist' and job_number = '$nojob' and process = 3";
		$query = $oracle->query($sql);
		return $query->result_array();
	}
	
	public function getdetail($picklist){
		$oracle = $this->load->database('oracle', true);
		$sql = "select mtrl.INVENTORY_ITEM_ID, msib.SEGMENT1, msib.DESCRIPTION, mtrl.QUANTITY 
				from mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl, mtl_system_items_b msib
				where mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
				and mtrl.HEADER_ID = mtrh.HEADER_ID
				and mtrl.ORGANIZATION_ID = msib.ORGANIZATION_ID
				and mtrh.REQUEST_NUMBER = '$picklist'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	
	public function approveData($picklist, $nojob, $user){
		$oracle = $this->load->database('oracle', true);
		$sql = "insert into khs_picklist_approved(PICKLIST, JOB_NUMBER, PROCESS, APPROVED_DATE, PERSON)
		VALUES('$picklist','$nojob',3,SYSDATE,'$user')";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}

	public function recallData($nojob, $picklist){
		$oracle = $this->load->database('oracle', true);
		$sql = "delete from khs_picklist_approved where picklist = '$picklist' and job_number = '$nojob' and process = 3";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}

	public function cekapprove2($nojob){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_picklist_approved where job_number = '$nojob' and process = 3";
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
