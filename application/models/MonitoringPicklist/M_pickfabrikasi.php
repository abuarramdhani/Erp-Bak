<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pickfabrikasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
	}
	
	function getShift($date=FALSE)
	{
		$oracle = $this->load->database('oracle',TRUE);
		if ($date === FALSE) {
			$date = date('Y/m/d');
		}
		$sql = "select BCS.SHIFT_NUM,BCS.DESCRIPTION
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

    function getdataBelum($dept, $tgl1, $tgl2)
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
				--
				,kpa.APPROVED_DATE realase_ppic
				,wdj.SCHEDULED_START_DATE date_job
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
			and wdj.STATUS_TYPE not in (4, 5, 6, 7, 12)
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
			and TRUNC(wdj.SCHEDULED_START_DATE) BETWEEN to_date('$tgl1','DD/MM/YYYY') AND to_date('$tgl2','DD/MM/YYYY')
			order by 11 desc ";
		$query = $oracle->query($sql);
		// echo "<pre>";print_r($sql);exit();
		return $query->result_array();
	}
	
	function getdataBelum2($picklist)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select TO_CHAR(sysdate, 'DD-MON-YYYY HH24:MI:SS') tgl_cetak,
		TO_CHAR(wdj.SCHEDULED_START_DATE, 'DD-MON-YYYY HH24:MI:SS') tgl_job,
		bd.DEPARTMENT_CLASS_CODE dept_class,
		mtrh.FROM_SUBINVENTORY_CODE,
		mil.SEGMENT1 FROM_LOCATOR,
		mtrh.REQUEST_NUMBER no_picklist,
		we.WIP_ENTITY_NAME no_job,
		msib.SEGMENT1 kode_item,
		msib.DESCRIPTION,
        wdj.START_QUANTITY
		from mtl_txn_request_headers mtrh,
		mtl_txn_request_lines mtrl,
		wip_entities we,
		wip_discrete_jobs wdj,
		mtl_system_items_b msib,
		wip_requirement_operations wro,
		wip_operations wo,
		bom_departments bd,
		mtl_item_locations mil
		where mtrh.HEADER_ID = mtrl.HEADER_ID
		and mtrh.ATTRIBUTE1 = we.WIP_ENTITY_ID
		and we.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
		and we.ORGANIZATION_ID = msib.ORGANIZATION_ID
		and we.WIP_ENTITY_ID = wdj.WIP_ENTITY_ID
		and mtrl.INVENTORY_ITEM_ID = wro.INVENTORY_ITEM_ID
		and wro.WIP_ENTITY_ID = we.WIP_ENTITY_ID
		and wro.ORGANIZATION_ID = we.ORGANIZATION_ID
		and wro.WIP_ENTITY_ID = wo.WIP_ENTITY_ID
		and wro.OPERATION_SEQ_NUM = wo.OPERATION_SEQ_NUM
		and wo.DEPARTMENT_ID = bd.DEPARTMENT_ID
		and mtrl.FROM_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
		and mtrh.REQUEST_NUMBER = '$picklist'
		group by
		wdj.SCHEDULED_START_DATE,
		bd.DEPARTMENT_CLASS_CODE,
		mtrh.FROM_SUBINVENTORY_CODE,
		mil.SEGMENT1,
		mtrh.REQUEST_NUMBER,
		we.WIP_ENTITY_NAME,
		msib.SEGMENT1,
		msib.DESCRIPTION,
        wdj.START_QUANTITY";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getdataSudah($dept, $tgl1, $tgl2)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select distinct
				to_char(we.CREATION_DATE, 'dd-mm-yyyy') creation_date
				,msib_produk.SEGMENT1 produk
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
			and wdj.STATUS_TYPE not in (4, 5, 6, 7, 12)
			--
			and mtrh.REQUEST_NUMBER = kpa.PICKLIST 
			-- 
			and (select count(kpa_fab.PICKLIST)
					from khs_picklist_approved kpa_fab
					where kpa_fab.PROCESS in (1,2,3)
					and kpa_fab.PICKLIST = kpa.PICKLIST
					) = 2
			and kpa.PROCESS = 2 -- fabrikasi
			and bd.DEPARTMENT_CLASS_CODE = '$dept'
			and TRUNC(wdj.SCHEDULED_START_DATE) BETWEEN to_date('$tgl1','DD/MM/YYYY') AND to_date('$tgl2','DD/MM/YYYY')
			order by 13";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getdataSudah2($dept, $tgl, $picklist)
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
				--
				,(select kpa_ppic.APPROVED_DATE
					from khs_picklist_approved kpa_ppic
					where kpa_ppic.PICKLIST = mtrh.REQUEST_NUMBER
						and kpa_ppic.PROCESS = 1 -- ppic
						) release_ppic
				,kpa.APPROVED_DATE realase_fabrikasi
				,wdj.SCHEDULED_START_DATE date_job
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
			and wdj.STATUS_TYPE not in (4, 5, 6, 7, 12)
			--
			and mtrh.REQUEST_NUMBER = kpa.PICKLIST 
			-- 
			and (select count(kpa_fab.PICKLIST)
					from khs_picklist_approved kpa_fab
					where kpa_fab.PROCESS in (1,2,3)
					and kpa_fab.PICKLIST = kpa.PICKLIST
					) = 2
			and kpa.PROCESS = 2 -- fabrikasi
			and bd.DEPARTMENT_CLASS_CODE = '$dept'
			and to_char(wdj.SCHEDULED_START_DATE,'DD-MM-YYYY') = '$tgl'  
			and mtrh.REQUEST_NUMBER = '$picklist'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}
	
	public function approveData($picklist, $nojob, $user){
		$oracle = $this->load->database('oracle', true);
		$sql = "insert into khs_picklist_approved(PICKLIST, JOB_NUMBER, PROCESS, APPROVED_DATE, PERSON)
		VALUES('$picklist','$nojob',2,SYSDATE,'$user')";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}

	public function recallData($picklist, $nojob){
		$oracle = $this->load->database('oracle', true);
		$sql = "delete from khs_picklist_approved where picklist = '$picklist' and job_number = '$nojob' and process = 2";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}

	public function cekapprove($picklist, $nojob){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_picklist_approved where picklist = '$picklist' and job_number = '$nojob' and process = 3";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function cekapprove2($picklist){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_picklist_approved where picklist = '$picklist' and process = 2";
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
	
	public function permintaanApprove($nojob, $date, $shift){
		$oracle = $this->load->database('oracle', true);
		$sql = "insert into khs_pelayanan_picklist(JOB_NUMBER, TANGGAL_PELAYANAN, SHIFT)
		VALUES('$nojob', to_date('$date', 'DD/MM/YYYY') ,$shift)";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}

	public function recallpermintaan($no){
		$oracle = $this->load->database('oracle', true);
		$sql = "delete from khs_pelayanan_picklist where job_number = '$no'";
		$query = $oracle->query($sql);
		$query = $oracle->query('commit');
	}
	
	public function cariReqPelayanan(){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_pelayanan_picklist order by 2, 3";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	public function cariReqPelayanan2($nojob){
		$oracle = $this->load->database('oracle', true);
		$sql = "select job_number, 
					to_char(tanggal_pelayanan, 'dd-Mon-yyyy') tanggal_pelayanan,
					shift 
				from khs_pelayanan_picklist 
				where job_number like '$nojob%'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}
	
	public function cariReqPelayanan3($no){
		$oracle = $this->load->database('oracle', true);
		$sql = "select * from khs_pelayanan_picklist where job_number = '$nojob'";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getShift2($shift)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "select BCS.SHIFT_NUM,BCS.DESCRIPTION
				from BOM_SHIFT_TIMES bst
				    ,BOM_CALENDAR_SHIFTS bcs
				    ,bom_shift_dates bsd
				where bst.CALENDAR_CODE = bcs.CALENDAR_CODE
				  and bst.SHIFT_NUM = bcs.SHIFT_NUM
				  and bcs.CALENDAR_CODE='KHS_CAL'
				  and bst.shift_num = bsd.shift_num
				  and bst.calendar_code=bsd.calendar_code
				  and bsd.SEQ_NUM is not null
				  and BCS.SHIFT_NUM = $shift
				  ORDER BY BCS.SHIFT_NUM asc";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getPerbedaan($no_mo, $subinv)
	{		
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "with kqem as
				(
				select distinct 
					kqem.*
					,case when kqem.job_from_subinv is null 
							and kqem.bom_from_subinv is not null
							and kqem.code is null
							then 'KOMPONEN DI MO GUDANG : ' || kqem.required_quantity || ' PCS'
							when nvl (kqem.job_comp_qty,0) <> nvl (kqem.bom_comp_qty,0)
							and kqem.code is null
							then 'LAYANI QTY SESUAI JOB : ' || kqem.required_quantity || ' PCS'
							when kqem.code = 'ITEM JOB'
							then 'TAMBAHAN KOMPONEN : ' || kqem.required_quantity || ' PCS'
							when kqem.code = 'ITEM BOM'
							then 'TIDAK PERLU DILAYANI'
					else null
					end perbedaan
				from khs_qweb_ect_jobom_mo kqem
					,mtl_txn_request_headers mtrh
				where mtrh.REQUEST_NUMBER = '$no_mo'
				and (kqem.BOM_FROM_SUBINV = '$subinv' or kqem.JOB_FROM_SUBINV = '$subinv')
				and kqem.JOB_ID = mtrh.ATTRIBUTE1
				)
				select *
				from kqem
				where kqem.perbedaan is not null
				order by kqem.COMPONENT";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

}
