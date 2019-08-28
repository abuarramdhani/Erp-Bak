<?php defined('BASEPATH') or die('No direct script access allowed');
class M_input extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->library('csvimport');
        $this->oracle = $this->load->database('oracle',true);
    }

    public function selectOrgCode($term){
        $sql = "SELECT DISTINCT msib.organization_id, mp.organization_code
        from mtl_system_items_b msib,
        mtl_parameters mp
        where msib.organization_id = mp.organization_id
        and mp.organization_code IN ('ODM','YTH')
        order by mp.organization_code";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function bacaorgid($id){
        $sql ="SELECT DISTINCT mp.organization_code
        from mtl_system_items_b msib,
        mtl_parameters mp
        where msib.organization_id = mp.organization_id
        and mp.organization_code IN ('ODM','YTH') AND msib.organization_id='$id'
        order by mp.organization_code";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

	public function selectItemCode($orgcode, $term){
        $sql = "SELECT distinct  msib.segment1 item_code, msib.inventory_item_id item_id,msib.description descrip
                FROM mtl_system_items_b msib, mtl_parameters mp, bom_operational_routings bor,
                    bom_resources br, bom_operation_sequences bos, bom_operation_resources bores
                WHERE msib.organization_id = mp.organization_id
                    AND bor.assembly_item_id = msib.inventory_item_id
                    AND bor.organization_id = msib.organization_id
                    AND bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
                    AND bos.OPERATION_SEQUENCE_ID = bores.OPERATION_SEQUENCE_ID
                    AND bores.RESOURCE_ID = br.RESOURCE_ID
                    AND br.RESOURCE_TYPE = 1
                    AND br.AUTOCHARGE_TYPE = 1
                    AND msib.inventory_item_status_code = 'Active'
                    AND mp.organization_code LIKE '%$orgcode%'
                    AND msib.segment1 LIKE '%$term%'
                ORDER BY msib.segment1";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function cekData($item_id, $Periode4, $orgid){
        $sql="SELECT * from KHS_INV_NEEDS where ITEM_ID='$item_id' and period='$Periode4' and ORG_ID='$orgid'";
        $query= $this->oracle->query($sql);
        return $query->result_array();
    }
    public function cekDataPerubahan($item_id, $period){
        $sql="SELECT * from KHS_INV_NEEDS where ITEM_ID='$item_id' and period='$period'";
        $query= $this->oracle->query($sql);
        return $query->result_array();
    }

    public function saveData($data){
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->oracle->insert('KHS_INV_NEEDS',$data);
    }
    public function updateData($item_id, $period, $needs){
        $sql="UPDATE KHS_INV_NEEDS set NEEDS='$needs' where ITEM_ID='$item_id' and period='$period'";
        $query= $this->oracle->query($sql);
        // return $sql;
        // return $query->result_array();
    }
    public function savePerubahan($data){
        // echo '<pre>';
        // print_r($data);
        // exit();
        for ($j = 0 ; $j < sizeof($data) ; $j++) { 
            $this->oracle->insert('KHS_INV_NEEDS', $data[$j]);
        }
    }
    public function updatePerubahan($item_id, $period, $needs, $orgid){
        // echo '<pre>';
        // print_r($needs);
        // exit();
        $sql="UPDATE KHS_INV_NEEDS set NEEDS='$needs' where ITEM_ID='$item_id' and period='$period' and ORG_ID='$orgid'";
        $query= $this->oracle->query($sql);
        // return $query->result_array();
    }
    public function getitemid($itemcode){
        $sql="SELECT distinct msib.INVENTORY_ITEM_ID item_id
        from mtl_system_items_b msib
        ,bom_operational_routings bor
        where msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
        and bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID and msib.SEGMENT1='$itemcode'
        order by msib.SEGMENT1";
        $query= $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getitemid2($it){
        // echo "<pre>";
        // print_r($it);
        // exit();
        $sql="SELECT DISTINCT msib.INVENTORY_ITEM_ID item_id
        from mtl_system_items_b msib,
        mtl_parameters mp
        where msib.organization_id = mp.organization_id
        and msib.inventory_item_status_code = 'Active'
        and msib.SEGMENT1 = '$it'";
        $query= $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getorgid($orgcode3){
        $sql="SELECT DISTINCT mp.organization_id
        from mtl_system_items_b msib,
        mtl_parameters mp
        where msib.organization_id = mp.organization_id
        and mp.organization_code IN ('ODM','YTH') AND mp.organization_code='$orgcode3'
        order by mp.organization_code";
        $query= $this->oracle->query($sql);
        return $query->result_array();
    }
    public function getDataCsv(){
		$sql = "SELECT * FROM KHS_INV_NEEDS";
		$query = $this->oracle->query($sql);
		return $query->result_array();
    }
    public function getDataInput(){
		$sql = "SELECT msib.SEGMENT1 item_code,
        kin.PERIOD periode, 
        msib.DESCRIPTION descript,
        kin.NEEDS needs,
        msib.PRIMARY_UOM_CODE satuan 
        from mtl_system_items_b msib, khs_inv_needs kin
        where msib.INVENTORY_ITEM_ID = kin.ITEM_ID
        and msib.ORGANIZATION_ID = kin.ORG_ID";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
}