<?php
class M_hitung extends CI_Model {

    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle', true);
    //$this->oracle_dev = $this->load->database('oracle_dev',TRUE);
    }
	
	public function dataPUM($plan, $deptclass){
		$sql = "select distinct ffvv.FLEX_VALUE                                                 cost_center
				--,ffvv.DESCRIPTION                                                         cc_desc
				,bd.DEPARTMENT_CLASS_CODE                                                 seksi
				,br.RESOURCE_CODE                                                         resource_code
				,br.DESCRIPTION                                                           deskripsi
				,SUBSTR(br.DESCRIPTION, INSTR(br.DESCRIPTION, '-')+2, 5)                  jenis_mesin
				--,khs_ar_get_coa(br.ABSORPTION_ACCOUNT)                                    COA
				,kdmr.TAG_NUMBER
				,kdmr.NO_MESIN
				--,msib.ORGANIZATION_ID
				,msib.SEGMENT1                                                            kode_komponen
				,msib.DESCRIPTION                                                         deskripsi_komponen
				--,bor.ALTERNATE_ROUTING_DESIGNATOR
				,bos.OPERATION_SEQ_NUM                                                    opr_seq
				--,bd.DEPARTMENT_CODE
				,bos.OPERATION_DESCRIPTION                                                kode_proses
				--,bd.DEPARTMENT_CLASS_CODE
				,bores.RESOURCE_SEQ_NUM                                                   res_seq
				,bores.USAGE_RATE_OR_AMOUNT                                               usage_rate
				--,bores.SCHEDULE_SEQ_NUM
				,bores.ASSIGNED_UNITS                                                     assign_unit
				,cal.PERIODE
				,cal.URUT
				-- yang stok 
				--,nvl(khs_get_stock_awal1(:P_PLAN,msib.ORGANIZATION_ID,msib.INVENTORY_ITEM_ID),0)  stok_awal
				--
				,nvl(
					(            
					select sum(coalesce(md.DAILY_DEMAND_RATE, md.USING_REQUIREMENT_QUANTITY)) qty
			--                  ,to_char(md.USING_ASSEMBLY_DEMAND_DATE,'Mon-YY') periode
			--                  ,to_number(to_char(trunc(md.USING_ASSEMBLY_DEMAND_DATE),'YYYYMM')) urut
			--                  ,msib.INVENTORY_ITEM_ID item_id
			--                  ,msib.ORGANIZATION_ID org
			--                  ,mp.PLAN_ID 
						from msc_system_items msi
							,mtl_system_items_b msib
							,msc_demands md
							,msc_plans mp
							,mfg_lookups ml
					where msi.SR_INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
						and msi.ORGANIZATION_ID = msib.ORGANIZATION_ID
						-- demands
						and md.PLAN_ID = msi.PLAN_ID
						and md.SR_INSTANCE_ID = msi.SR_INSTANCE_ID
						and md.ORGANIZATION_ID = msi.ORGANIZATION_ID
						and md.INVENTORY_ITEM_ID = msi.INVENTORY_ITEM_ID
						and md.ORIGINATION_TYPE <> 52
						and mp.PLAN_ID = md.PLAN_ID
						-- lookup
						and ml.LOOKUP_TYPE = ('MSC_DEMAND_ORIGINATION')
						and ml.LOOKUP_CODE = md.ORIGINATION_TYPE
						-- parameter
			--               and msi.ORGANIZATION_ID =:P_IO_ID
						and mp.PLAN_ID = '$plan'
						and msib.INVENTORY_ITEM_ID = bor.ASSEMBLY_ITEM_ID
						and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
						and to_char(md.USING_ASSEMBLY_DEMAND_DATE,'Mon-YY') = cal.PERIODE
						and trunc(md.USING_ASSEMBLY_DEMAND_DATE) >= to_date('01'||to_char(sysdate,'MON-YY'))  
						and trunc(md.USING_ASSEMBLY_DEMAND_DATE) between to_date('01'||to_char(sysdate,'MON-YY')) 
																	and last_day(add_months( to_date('01'||to_char(sysdate,'MON-YY')),2))
						and khs_ascp_utilities_pkg.GET_ORDER_TYPE(mp.PLAN_ID,md.SR_INSTANCE_ID,md.DEMAND_ID) in ('Planned order demand','Forecast')
					group by to_char(md.USING_ASSEMBLY_DEMAND_DATE,'Mon-YY')
							,to_number(to_char(trunc(md.USING_ASSEMBLY_DEMAND_DATE),'YYYYMM'))
							,msib.INVENTORY_ITEM_ID
							,msib.ORGANIZATION_ID
							,mp.PLAN_ID 
							)
							,0)                                                           qty
			from bom_resources br
			,bom_department_resources bdr
			,bom_departments bd
			,bom_operation_resources bores
			,bom_operational_routings bor
			,bom_operation_sequences bos
			,mtl_system_items_b msib
			--
			,khs_daftar_mesin_resource kdmr
			--
			,gl_code_combinations gcc
			,fnd_flex_values_vl ffvv
			--
			,( 
				select to_char(bcd.CALENDAR_DATE,'Mon-YY') periode
					,to_number(to_char(bcd.CALENDAR_DATE,'YYYYMM')) urut
				from bom_calendar_dates bcd
				where bcd.CALENDAR_CODE = 'KHS_CAL'
				and trunc(bcd.CALENDAR_DATE) between to_date('01'||to_char(sysdate,'MON-YY')) 
				and last_day(add_months( to_date('01'||to_char(sysdate,'MON-YY')),2))          
			group by to_char(bcd.CALENDAR_DATE,'Mon-YY')
					,to_number(to_char(bcd.CALENDAR_DATE,'YYYYMM'))
						) cal 
			where br.ABSORPTION_ACCOUNT = gcc.CODE_COMBINATION_ID
			and br.RESOURCE_ID = bdr.RESOURCE_ID
			and br.RESOURCE_ID = kdmr.RESOURCE_ID
			and bdr.DEPARTMENT_ID = bd.DEPARTMENT_ID
			--
			and bores.RESOURCE_ID = br.RESOURCE_ID
			and bores.OPERATION_SEQUENCE_ID = bos.OPERATION_SEQUENCE_ID
			and bos.DEPARTMENT_ID = bd.DEPARTMENT_ID
			and bos.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
			and bos.DISABLE_DATE is null
			and bor.ALTERNATE_ROUTING_DESIGNATOR is null
			--
			and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
			and msib.INVENTORY_ITEM_ID = bor.ASSEMBLY_ITEM_ID
			and msib.INVENTORY_ITEM_STATUS_CODE <> 'Inactive'
			-- 
			--and msib.SEGMENT1 = 'ADB1BA0181CY-0'-- 'AAA1A00021AY-0' AAC1B00021AY-0  AAK1B0A001AY-0   ACA6BAA001AY-0
			and ffvv.FLEX_VALUE_SET_ID = 1013709 
			and ffvv.END_DATE_ACTIVE is null
			and br.DISABLE_DATE is null
			and substr(ffvv.FLEX_VALUE,0,1) in ('4','5','7','8') --fabrikasi
			--and ffvv.FLEX_VALUE = '5D36'
			and ffvv.FLEX_VALUE = gcc.SEGMENT4
			and bor.ORGANIZATION_ID = 102 -- ODM
			and bd.DEPARTMENT_CLASS_CODE = '$deptclass' --MACHE?  MACH1?  PRKTA  MACHB2  MACHD  PAINT.TKS  WELD  PRKTC  PRKTB  HTM  MACHA  MACHC  PAINT  MACHB
			order by urut, cost_center, no_mesin, tag_number, kode_komponen, opr_seq";

				$query = $this->oracle->query($sql);
				return $query->result_array();
			}

			function stockawal($deptclass, $plan)
			{
			$sql = "select xx.seksi                                                                 seksi
							,xx.kode_komponen                                                         kode_komponen
							,xx.deskripsi_komponen                                                    deskripsi_komponen
							,sum(xx.stok_awal)                                                        stok_awal
						from (
						select distinct bd.DEPARTMENT_CLASS_CODE                                        seksi
							,msib.SEGMENT1                                                            kode_komponen
							,msib.DESCRIPTION                                                         deskripsi_komponen
							--,nvl(khs_get_stock_awal1(:P_PLAN,msib.ORGANIZATION_ID,msib.INVENTORY_ITEM_ID),0)  stok_awal
							,moc.QUANTITY_RATE                                                        stok_awal
						from bom_resources br
							,bom_department_resources bdr
							,bom_departments bd
							,bom_operation_resources bores
							,bom_operational_routings bor
							,bom_operation_sequences bos
							,mtl_system_items_b msib
							--
							,khs_daftar_mesin_resource kdmr
							--
							,gl_code_combinations gcc
							,fnd_flex_values_vl ffvv
										,msc_orders_col_v moc 
										,msc_sub_inventories msci
										,msc_plan_sched_v mscp
										,msc_system_items msi 
						where br.ABSORPTION_ACCOUNT = gcc.CODE_COMBINATION_ID
						and br.RESOURCE_ID = bdr.RESOURCE_ID
						and br.RESOURCE_ID = kdmr.RESOURCE_ID
						and bdr.DEPARTMENT_ID = bd.DEPARTMENT_ID
						--
						and bores.RESOURCE_ID = br.RESOURCE_ID
						and bores.OPERATION_SEQUENCE_ID = bos.OPERATION_SEQUENCE_ID
						and bos.DEPARTMENT_ID = bd.DEPARTMENT_ID
						and bos.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
						and bos.DISABLE_DATE is null
						and bor.ALTERNATE_ROUTING_DESIGNATOR is null
						--
						and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
						and msib.INVENTORY_ITEM_ID = bor.ASSEMBLY_ITEM_ID
						and msib.INVENTORY_ITEM_STATUS_CODE <> 'Inactive'
						-- 
									and moc.ORDER_TYPE = 18
									and moc.OLD_DUE_DATE is null
									and msci.PLAN_ID = mscp.PLAN_ID
									and msci.ORGANIZATION_ID = mscp.ORGANIZATION_ID
									and msci.NETTING_TYPE = 1 -- checked
									and mscp.INPUT_SCHEDULE_ID = 112181 -- MPS/MRP
									and moc.SUBINVENTORY_CODE = msci.SUB_INVENTORY_CODE
									and moc.INVENTORY_ITEM_ID = msi.INVENTORY_ITEM_ID 
									and msci.PLAN_ID = '$plan'
									and msi.SR_INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
									and moc.ORGANIZATION_ID = 102
						--  and msib.SEGMENT1 = 'AAG1BA0001AY-0'-- 'AAA1A00021AY-0' AAC1B00021AY-0  AAK1B0A001AY-0   ACA6BAA001AY-0
						and ffvv.FLEX_VALUE_SET_ID = 1013709 
						and ffvv.END_DATE_ACTIVE is null
						and br.DISABLE_DATE is null
						and substr(ffvv.FLEX_VALUE,0,1) in ('4','5','7','8') --fabrikasi
						--and ffvv.FLEX_VALUE = '5D36'
						and ffvv.FLEX_VALUE = gcc.SEGMENT4
						and bor.ORGANIZATION_ID = 102 -- ODM
						and bd.DEPARTMENT_CLASS_CODE = '$deptclass' --MACHE?  MACH1?  PRKTA  MACHB2  MACHD  PAINT.TKS  WELD  PRKTC  PRKTB  HTM  MACHA  MACHC  PAINT  MACHB
						--group by bd.DEPARTMENT_CLASS_CODE, msib.SEGMENT1,msib.DESCRIPTION
						--order by seksi, kode_komponen
						) xx
						group by xx.seksi, xx.kode_komponen, xx.deskripsi_komponen
						order by kode_komponen";
				$query = $this ->oracle->query($sql);
				return $query->result_array();
		}

	public function seksidept($term){
		$sql = "select distinct bd.DEPARTMENT_CLASS_CODE||' - '||NVL(SUBSTR(br.DESCRIPTION, 0, INSTR(br.DESCRIPTION, '-')-2),'PAINTING AND PACKAGING')                 seksi
				,bd.DEPARTMENT_CLASS_CODE                                       seksi_code
				from bom_resources br
				,bom_department_resources bdr
				,bom_departments bd
				,bom_operational_routings bor
				,bom_operation_sequences bos
				,gl_code_combinations gcc
				,fnd_flex_values_vl ffvv
				,khs_daftar_mesin_resource kdmr
				where br.DISABLE_DATE is null
				and br.RESOURCE_ID = bdr.RESOURCE_ID
				and bdr.DEPARTMENT_ID = bd.DEPARTMENT_ID
				and br.ABSORPTION_ACCOUNT = gcc.CODE_COMBINATION_ID
				and br.RESOURCE_ID = kdmr.RESOURCE_ID
				--
				and bos.DEPARTMENT_ID = bd.DEPARTMENT_ID
				and bos.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
				and bos.DISABLE_DATE is null
				and bor.ALTERNATE_ROUTING_DESIGNATOR is null
				and bor.ORGANIZATION_ID = 102
				--
				and ffvv.FLEX_VALUE_SET_ID = 1013709
				and ffvv.END_DATE_ACTIVE is null
				and substr(ffvv.FLEX_VALUE,0,1) in ('4','5','7','8') --fabrikasi
				and ffvv.FLEX_VALUE = gcc.SEGMENT4
				and bd.DEPARTMENT_CLASS_CODE LIKE '%$term%'
				--and (NVL(SUBSTR(br.DESCRIPTION, 0, INSTR(br.DESCRIPTION, '-')-2),'PAINTING AND PACKAGING')) NOT IN ('MACHINING B TUKSONO','HEAT TREATMENT','MACHINING C TUKSONO','MACHINING D TUKSONO')
				order by seksi_code";
			$query = $this ->oracle->query($sql);
			return $query->result_array();
	}

	public function username($user){
        $sql = "select first_name, middle_names, last_name
        from PER_PEOPLE_F ppf 
        where ppf.NATIONAL_IDENTIFIER = '$user' 
        and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
        order by ppf.NATIONAL_IDENTIFIER desc";
        $query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function cekPUM($resource, $tagnum, $cost, $deptclass, $plan){
		$sql = "select * from khs_hasil_utilitas_mesin
				where resource_code = '$resource'
				and tag_number = '$tagnum'
				and cost_center = '$cost'
				and department_class_code = '$deptclass'
				and khs_plan = '$plan'";
		$query = $this ->oracle->query($sql);
		return $query->result_array();
	}
	
	public function insertPUM($resource, $nomesin, $tagnum, $jenis, $cost, $deptclass, $username, $utilitas, $date, $plan){
		$sql = "insert into khs_hasil_utilitas_mesin (resource_code, no_mesin, tag_number, jenis_mesin, cost_center, utilitas, department_class_code, last_update_date, last_update_by, khs_plan)
				values ('$resource', '$nomesin', '$tagnum', '$jenis', '$cost', '$utilitas', '$deptclass',to_timestamp('$date', 'DD/MM/YYYY'), '$username', '$plan')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('COMMIT');
	}

	public function updatePUM($resource, $nomesin, $tagnum, $jenis, $cost, $deptclass, $username, $utilitas, $date, $plan){
		$sql = "update khs_hasil_utilitas_mesin set last_update_date = to_timestamp('$date', 'DD/MM/YYYY'), last_update_by = '$username'
				where resource_code = '$resource'
				and no_mesin = '$nomesin'
				and tag_number = '$tagnum'
				and cost_center = '$cost'
				and department_class_code = '$deptclass'
				and khs_plan = '$plan'";
		$query = $this->oracle->query($sql);
        $query = $this->oracle->query('COMMIT');
	}

	public function cariHasilPUM($dept, $plan){
		$sql = "select distinct last_update_date, last_update_by
				from khs_hasil_utilitas_mesin
				where department_class_code = '$dept'
				and khs_plan = '$plan'";
		$query = $this ->oracle->query($sql);
		return $query->result_array();
	}

	public function deletePUM($dept, $plan){
		$sql = "delete from khs_hasil_utilitas_mesin where department_class_code = '$dept' and khs_plan = '$plan'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('COMMIT');
	}
	
	public function seksi($user){
        // $sql= "SELECT er.er_section.section_name FROM er.er_section WHERE er.er_section.section_code = '$kodesie'";
        $sql = "select FIRST_NAME,MIDDLE_NAMES,LAST_NAME
        from PER_PEOPLE_F ppf 
        where ppf.NATIONAL_IDENTIFIER = '$user' 
        and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
        order by ppf.NATIONAL_IDENTIFIER desc";
        $query = $this->oracle->query($sql);
		return $query->result_array();
    }
}


?>