<?php defined('BASEPATH') or die('No direct script access allowed');
class M_View extends CI_Model
{
	
	// function __construct()
	// {
	// 	parent::__construct();
	// 	$this->load->database();
	// }
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',true);
    }

    function selectDeptClass($term)
	{
		$sql = "SELECT distinct bd.DEPARTMENT_CLASS_CODE
        FROM bom_departments bd
		where bd.DEPARTMENT_CLASS_CODE LIKE '%$term%'
        ORDER BY bd.DEPARTMENT_CLASS_CODE";
		$query = $this ->oracle->query($sql);
		return $query->result_array();
	}

	function selectDeptCode($deptclass)
	{
		$sql="SELECT bd.DEPARTMENT_CODE ,bd.DESCRIPTION
		from bom_departments bd
		where bd.DEPARTMENT_CLASS_CODE like '$deptclass'
		order by bd.DEPARTMENT_CODE";
		$query =$this->oracle->query($sql);
		return $query->result_array();
	}

	function finditem(){
		$sql="";
		$query=$this->oracle->query($sql);
		return $query->result_array();
	}

	function searchTanggal($tanggal1,$tanggal2)
	{
		$sql = "select * from im.im_master_bon_bppct 
				where flag = 'N'
				and creation_date between '$tanggal1' AND '$tanggal2'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function searchdata($available_op,$hari_kerja,$input_parameter,$deptclass,$deptcode,$monthPeriode2){
		$sql="SELECT xx.resources
		,xx.resource_desc
		,xx.period
		,xx.item
		,xx.item_desc
		,xx.resource_type
		,xx.assigned_units
		,xx.cycle_time
		,xx.qty_op
		,(max(xx.qty_op) over (partition by xx.resources))                        max_qty_op
		,(sum(xx.qty_op) over (partition by xx.resources))                        total_qty_op
		,xx.tgt_shift
		,xx.dept
		,xx.needs
		,xx.need_shift
		,(sum(xx.need_shift) over (partition by xx.resources))                    total_need_shift
		,xx.available_op
		,(
		  (
		   xx.available_op/(
							max(xx.qty_op) over (partition by xx.resources)
							)
		   )*xx.hari_kerja*xx.parameter
			 )                                                                    available_shift
		,(
		  round(
		  (
		   sum(xx.need_shift) over (partition by xx.resources)
		   )/(
			  (
			   xx.available_op/(
								max(xx.qty_op) over (partition by xx.resources)
								)
			   )*xx.hari_kerja*xx.parameter
				 ),4)*100
					)                                                           loading
		,ceil(
		 (
		  round(
		  (
		   sum(xx.need_shift) over (partition by xx.resources)
		   )/(
			  (
			   xx.available_op/(
								max(xx.qty_op) over (partition by xx.resources)
								)
			   )*xx.hari_kerja*xx.parameter
				 ),4)
				   )*(
					  xx.available_op
					  )
						)                                                         needs_op
			FROM (
			select distinct
					br.RESOURCE_CODE resources
					,br.DESCRIPTION resource_desc
					,msib.SEGMENT1                                                            item
					,msib.DESCRIPTION                                                         item_desc
					,br.RESOURCE_TYPE
					,bores.ASSIGNED_UNITS
					,bd.DEPARTMENT_CLASS_CODE                                                 dept
					,bores.USAGE_RATE_OR_AMOUNT cycle_time
					,(select boresop.ASSIGNED_UNITS
						from bom_operational_routings borop
							,bom_operation_sequences bosop
							,bom_operation_resources boresop
							,bom_resources brop
							,bom_departments bdop
							,mtl_system_items_b msibop
					where borop.ASSEMBLY_ITEM_ID = msibop.INVENTORY_ITEM_ID
						and borop.ORGANIZATION_ID = msibop.ORGANIZATION_ID
						--
						and bosop.ROUTING_SEQUENCE_ID = borop.ROUTING_SEQUENCE_ID
						and bosop.DEPARTMENT_ID = bdop.DEPARTMENT_ID
						and bdop.DEPARTMENT_ID = bos.DEPARTMENT_ID 
						--
						and boresop.OPERATION_SEQUENCE_ID = bosop.OPERATION_SEQUENCE_ID
						and boresop.RESOURCE_ID = brop.RESOURCE_ID
						and brop.RESOURCE_TYPE = 2
						and brop.AUTOCHARGE_TYPE = 1
						--
						and msibop.SEGMENT1 = msib.SEGMENT1 
						and borop.ALTERNATE_ROUTING_DESIGNATOR is null
			--           and rownum = 1
						) qty_op
					,round(7/(bores.USAGE_RATE_OR_AMOUNT))                                    tgt_shift
					,kin.NEEDS
					,round(kin.NEEDS/(round(7/(bores.USAGE_RATE_OR_AMOUNT))),1)               need_shift
					,kin.PERIOD
					,replace('$available_op','#') available_op
					,replace('$hari_kerja','#') hari_kerja
					,replace('$input_parameter','#') parameter
			from bom_operational_routings bor
				,bom_operation_sequences bos
				,bom_operation_resources bores
				,bom_resources br
				,bom_departments bd
				,khs_inv_needs kin
				,mtl_system_items_b msib
			where bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
				and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
				--
				and bos.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
				and bos.DEPARTMENT_ID = bd.DEPARTMENT_ID
				--
				and bores.OPERATION_SEQUENCE_ID = bos.OPERATION_SEQUENCE_ID
				and bores.RESOURCE_ID = br.RESOURCE_ID
				and br.RESOURCE_TYPE = 1
				and br.AUTOCHARGE_TYPE = 1
				--
				and msib.INVENTORY_ITEM_ID = kin.ITEM_ID
				and bor.ALTERNATE_ROUTING_DESIGNATOR is null
				-- parameter
				and msib.ORGANIZATION_ID = 102
				and bd.DEPARTMENT_CLASS_CODE LIKE '$deptclass'
				and br.RESOURCE_CODE LIKE '$deptcode'
				and kin.PERIOD LIKE '$monthPeriode2'
			group by br.RESOURCE_CODE 
					,br.DESCRIPTION 
					,bores.USAGE_RATE_OR_AMOUNT 
					,bos.DEPARTMENT_ID
					,msib.SEGMENT1 
					,bores.USAGE_RATE_OR_AMOUNT
					,br.RESOURCE_TYPE
					,bores.ASSIGNED_UNITS
					,msib.SEGMENT1
					,msib.DESCRIPTION
					,bd.DEPARTMENT_CLASS_CODE                                               
					,kin.NEEDS                                                            
					,kin.PERIOD
			order by kin.PERIOD, bd.DEPARTMENT_CLASS_CODE, br.RESOURCE_CODE, msib.SEGMENT1
				) xx
			";
		$query=$this->oracle->query($sql);
		// return($sql);
		return $query->result_array();
	}

	public function saveData($data) {
		// echo '<pre>';
		// print_r($data);
		// exit();
		// $sql = "INSERT INTO KHS_TAMPUNG_LOAD_ODM 
		// 				where DEPARTMENT_CLASS = '$deptclass' 
		// 				AND RESOURCES = '$RESOURCES' 
		// 				AND PERIODE = '$monthPeriode'
		// 				AND ITEM_CODE = '$ITEM_CODE'";
		// $query=$this->oracle->query($sql);
		// return $query->result_array();
		$this->oracle->insert('KHS_TAMPUNG_LOAD_ODM', $data);
	}

	public function update($data){
		// echo '<pre>';
		// print_r($data);
		// exit();
		// $deptclass, $kunci['RESOURCES'], $monthPeriode
		$sql="UPDATE KHS_TAMPUNG_LOAD_ODM 
		set 
		RESOURCES= '".$data['RESOURCES']."' ,
					RESOURCE_DESC = '".$data['RESOURCE_DESC']."',
					ITEM_CODE = '".$data['ITEM_CODE']."',
					ITEM_DESCRIPTION = '".$data['ITEM_DESCRIPTION']."',
					CYCLE_TIME = '".$data['CYCLE_TIME']."',
					QTY_OP = '".$data['QTY_OP']."',
					TGT_SHIFT = '".$data['TGT_SHIFT']."',
					NEEDS = '".$data['NEEDS']."',
					NEEDS_SHIFT = '".$data['NEEDS_SHIFT']."',
					TOTAL_NEEDS_SHIFT = '".$data['TOTAL_NEEDS_SHIFT']."',
					AVAILABLE_OP = '".$data['AVAILABLE_OP']."',
					AVAILABLE_SHIFT = '".$data['AVAILABLE_SHIFT']."',
					LOADING = '".$data['LOADING']."',
					NEEDS_OP = '".$data['NEEDS_OP']."',
					JUMLAH_HARI_KERJA = 	'".$data['JUMLAH_HARI_KERJA']."',
					PARAMETER = '".$data['PARAMETER']."',
					DEPARTMENT_CLASS = '".$data['DEPARTMENT_CLASS']."',
					PERIODE = '".$data['PERIODE']."'
		where DEPARTMENT_CLASS='".$data['DEPARTMENT_CLASS']."' 
		and PERIODE='".$data['PERIODE']."' 
		and RESOURCES='".$data['RESOURCES']."'";
		$query= $this->oracle->query($sql);
		// return $query->result_array();
}

	public function cektabel($deptclass, $RESOURCES, $monthPeriode, $ITEM_CODE)
	{
		$sql = "SELECT * from KHS_TAMPUNG_LOAD_ODM 
						where DEPARTMENT_CLASS = '$deptclass' 
						AND RESOURCES = '$RESOURCES' 
						AND PERIODE = '$monthPeriode'
						AND ITEM_CODE = '$ITEM_CODE'";
		$query=$this->oracle->query($sql);
		return $query->result_array();
		// return $sql;
	}
}