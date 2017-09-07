<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_exportexcel extends CI_Model
{
	public function __construct()
	    {
	        parent::__construct();
	        $this->oracle = $this->load->database('oracle', TRUE);
	        $this->db = $this->load->database('default', TRUE);
	    }

	function getMaterial($material_casting)
		{
			$sql =" select distinct msib.SEGMENT1 MATERIAL_CODE , msib.DESCRIPTION MATERIAL_NAME 
					, round(fmd.QTY,4) QTY ,fmd.DETAIL_UOM UOM 
					from FM_MATL_DTL fmd , FM_FORM_MST ffm ,mtl_system_items_b msib
					where ffm.FORMULA_NO like '%$material_casting%'
						AND fmd.LINE_TYPE = -1
					    AND ffm.FORMULA_VERS = 1 
					    AND fmd.FORMULA_ID = ffm.FORMULA_ID
					    AND fmd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID";
			$query = $this->oracle->query($sql);
			return $query->result_array();
		}

	function getCostMachine($mesin_shelcore)
		{
			$sql ="select cost from co.khs_cost_machine where resource like '%$mesin_shelcore%'";
			$query = $this->db->query($sql);
			return $query->result_array();
				
		}

	function getCostElectric($mesin_shelcore)
		{
			$sql="select cost from co.khs_electric_cost where resource like '%$mesin_shelcore%'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getCostMold()
		{
			$sql="select cost from co.khs_cost_machine where resource ='Line Moulding'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getCostMoldElectric()
		{
			$sql="select cost from co.khs_electric_cost where resource ='Line Moulding'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getCostFinishing()
		{
			$sql="select cost from co.khs_cost_machine where resource ='Finishing'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getCostFinishingElectric()
		{
			$sql="select cost from co.khs_electric_cost where resource ='Finishing'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getRate($kode,$period,$year,$cost_type,$io)
		{
			$sql="select distinct msib.segment1, 
					msib.description,
					--gps.CALENDAR_CODE,
					--gps.PERIOD_CODE,
					--cmm.COST_MTHD_CODE,
					nvl((select sum(ccd1.CMPNT_COST) cost
					from cm_cmpt_dtl ccd1
					where ccd1.PERIOD_ID=ccd.PERIOD_ID
					and ccd1.COST_TYPE_ID=ccd.COST_TYPE_ID
					and ccd1.ORGANIZATION_ID=ccd.ORGANIZATION_ID
					and ccd1.INVENTORY_ITEM_ID=ccd.INVENTORY_ITEM_ID
					and ccd1.COST_CMPNTCLS_ID=1),0) +
					nvl((select sum(ccd2.CMPNT_COST) cost
					from cm_cmpt_dtl ccd2
					where ccd2.PERIOD_ID=ccd.PERIOD_ID
					and ccd2.COST_TYPE_ID=ccd.COST_TYPE_ID
					and ccd2.ORGANIZATION_ID=ccd.ORGANIZATION_ID
					and ccd2.INVENTORY_ITEM_ID=ccd.INVENTORY_ITEM_ID
					and ccd2.COST_CMPNTCLS_ID=2),0) MATERIAL_COST
					from cm_cmpt_dtl ccd,
					mtl_system_items_b msib,
					gmf_period_statuses gps,
					CM_MTHD_MST cmm, -----4245
					mtl_parameters mp
					where ccd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
					and ccd.ORGANIZATION_ID = msib.ORGANIZATION_ID
					and ccd.PERIOD_ID=gps.PERIOD_ID
					and ccd.COST_TYPE_ID=cmm.COST_TYPE_ID
					and ccd.ORGANIZATION_ID=mp.ORGANIZATION_ID
					and msib.segment1 like '%$kode%'
					and gps.CALENDAR_CODE = $year ---------------> Parameter : Tahun
					and gps.PERIOD_CODE = $period --------------------------> Parameter : Bulan
					and cmm.COST_MTHD_CODE = '$cost_type'  ---------> Parameter : Cost Type
					and mp.ORGANIZATION_CODE = '$io'----------> Parameter : IO";
			$query = $this->oracle->query($sql);
			return $query->result_array();
		}

}