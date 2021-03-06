<?php defined('BASEPATH') or die('No direct script access allowed');
class M_input extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        // $this->load->library('csvimport');
        $this->oracle = $this->load->database('oracle',true);
        // $this->db = $this->load->database('oracle',true);
    }

    public function CheckIDOK($no_id_ok){
        $sql= "select * from khs_barang_datang_ok where no_id = '$no_id_ok'";
		$query = $this->oracle->query($sql);
		return $query->num_rows();
    }
    
    public function CheckIDNotOK($no_id_not_ok){
        $sql= "select * from khs_barang_datang_rev where no_id = '$no_id_not_ok'";
		$query = $this->oracle->query($sql);
		return $query->num_rows();
	}
	

    // public function getsupplier($term){
	// 	$sql = "select distinct vendor_name from PO_VENDORS where vendor_name like '%$term%' ";
	// 	$query = $this->oracle->query($sql);
	// 	return $query->result();
	// }
	
    public function GetIdSupplier($vendor){
        $sql ="SELECT vendor_id from PO_VENDORS where vendor_name='$vendor'";
        $query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
    public function ceksisaQuantity($nopo,$cekitem_id)
	{
		$sql= "SELECT distinct 
						msib.SEGMENT1 item
					,pol.ITEM_ID
					,pol.ITEM_DESCRIPTION
					,pol.QUANTITY qty
					,poh.SEGMENT1 nomor_po
					,hrl.LOCATION_CODE subinv
					,nvl(
							(select sum(ktbl.QTY)
							from KHS_BARANG_DATANG_OK ktbl 
							where ktbl.NO_PO = poh.SEGMENT1
								and ktbl.ITEM_ID = pol.ITEM_ID
								group by ktbl.ITEM_ID
							),0) qty2
					,pol.QUANTITY - nvl(
							(select sum(ktbl.QTY)
							from KHS_BARANG_DATANG_OK ktbl 
							where ktbl.NO_PO = poh.SEGMENT1
								and ktbl.ITEM_ID = pol.ITEM_ID
								group by ktbl.ITEM_ID
							),0) quantity
				from mtl_system_items_b msib
					,po_lines_all pol
					,po_headers_all poh
					,po_line_locations_all plla
					,hr_locations_all hrl
				where pol.ITEM_ID = msib.INVENTORY_ITEM_ID
				and poh.PO_HEADER_ID = pol.PO_HEADER_ID
				and  plla.PO_LINE_ID(+) = pol.PO_LINE_ID
				and hrl.LOCATION_ID (+) = plla.SHIP_TO_LOCATION_ID
				-- and msib.SEGMENT1 = nvl('',tabel.item)
				-- and msib.SEGMENT1 = ktbl.ITEM(+)
				and poh.SEGMENT1 = '$nopo' 
				and pol.ITEM_ID = '$cekitem_id'";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
	}

    public function getTable($nopo){
		$sql= "SELECT distinct 
						msib.SEGMENT1 item
					,pol.ITEM_ID
					,pol.ITEM_DESCRIPTION
					,pol.QUANTITY qty
					,poh.SEGMENT1 nomor_po
					,hrl.LOCATION_CODE subinv
					,nvl(
							(select sum(ktbl.QTY)
							from KHS_BARANG_DATANG_OK ktbl 
							where ktbl.NO_PO = poh.SEGMENT1
								and ktbl.ITEM_ID = pol.ITEM_ID
								group by ktbl.ITEM_ID
							),0) qty2
					,pol.QUANTITY - nvl(
							(select sum(ktbl.QTY)
							from KHS_BARANG_DATANG_OK ktbl 
							where ktbl.NO_PO = poh.SEGMENT1
								and ktbl.ITEM_ID = pol.ITEM_ID
								group by ktbl.ITEM_ID
							),0) quantity
				from mtl_system_items_b msib
					,po_lines_all pol
					,po_headers_all poh
					,po_line_locations_all plla
					,hr_locations_all hrl
				where pol.ITEM_ID = msib.INVENTORY_ITEM_ID
				and poh.PO_HEADER_ID = pol.PO_HEADER_ID
				and  plla.PO_LINE_ID(+) = pol.PO_LINE_ID
				and hrl.LOCATION_ID (+) = plla.SHIP_TO_LOCATION_ID
				-- and msib.SEGMENT1 = nvl('',tabel.item)
				-- and msib.SEGMENT1 = ktbl.ITEM(+)
				and poh.SEGMENT1 = '$nopo'
				order by msib.SEGMENT1";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
	}
	
	public function getSupplier($nopo)
	{
		$sql= "SELECT pov.VENDOR_NAME
				from po_headers_all pha
					,po_vendors pov
				where pha.SEGMENT1 = '$nopo'
					and pha.VENDOR_ID = pov.VENDOR_ID";
		$query = $this->oracle->query($sql);    
        return $query->result_array();
    }
	public function getItemId($ln1)
	{
		$sql= "SELECT DISTINCT msib.inventory_item_id item_id FROM mtl_system_items_b msib WHERE msib.segment1 = '$ln1'";
        $query = $this->oracle->query($sql);                             
        return $query->result_array();
        // return $sql;
	}

	function getGudang($term)
	{
		$sql = "SELECT msi.secondary_inventory_name, mp.organization_code, hou.NAME,
						loc.location_code
				FROM mtl_secondary_inventories msi,
						mtl_parameters mp,
						hr_organization_units hou,
						hr_locations_all_v loc
				WHERE mp.organization_id = msi.organization_id
					AND msi.organization_id = hou.organization_id
					AND hou.location_id = loc.location_id
					AND (upper(msi.secondary_inventory_name)) like upper('$term%')";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
	function item($kode)
	{

		$sql="SELECT distinct msib.segment1,
					msib.inventory_item_id item_id,
					msib.description, 
					msib.primary_uom_code,
					'N' exp
			from mtl_system_items_b msib,
				mtl_onhand_quantities_detail moqd
			where (upper(msib.segment1) like upper('%$kode%') or upper(msib.description) like upper('%$kode%')) 
			and msib.segment1 <> 'NCC07B'
			and INVENTORY_ITEM_STATUS_CODE = 'Active'
			and moqd.inventory_item_id = msib.inventory_item_id
			union 
			select distinct msib.segment1,
			msib.inventory_item_id item_id,
							msib.description,
							msib.primary_uom_code,
							'Y' exp
			from mtl_system_items_b msib
			where msib.organization_id = 81
				and msib.stock_enabled_flag = 'N'
				and msib.inventory_item_flag = 'N'
				and msib.costing_enabled_flag = 'N'  
				and INVENTORY_ITEM_STATUS_CODE = 'Active' 
				and (upper(msib.segment1) like  upper('%$kode%') or upper(msib.description) like  upper('%$kode%'))
				and msib.segment1 <> 'NCC07B'";
		$query=$this->oracle->query($sql);
		return $query->result_array();
	}

    public function insertItemOk($nopo,$nosj,$Item,$ItemDescription,$Qty,$subinv,$item_id,$tanggal_datang,$note,$supplier,$no_id)
	{
		$sql= "INSERT into KHS_BARANG_DATANG_OK (created_date,no_po,no_sj,item,item_description,qty,subinv,item_id,tanggal_datang,catatan,vendor,no_id)
                values (current_timestamp,'$nopo','$nosj','$Item','$ItemDescription','$Qty','$subinv','$item_id',TO_TIMESTAMP('$tanggal_datang', 'MM-DD-YYYY HH24:MI:SS'),'$note','$supplier','$no_id')";
		$query = $this->oracle->query($sql); 
    }

    public function insertItemRev($lnnosj,$lnitemcode,$lnitemdesc,$lnitemid,$lnqty,$lnitemid,$linenote,$tanggal_datang,$lnnote,$no_id)
	{
		$sql= "insert into KHS_BARANG_DATANG_REV (created_date,no_sj,item,item_description,qty,item_id,tanggal_datang,catatan,no_id)
                values (current_timestamp,'$lnnosj','$lnitemcode','$lnitemdesc','$lnqty','$lnitemid',TO_TIMESTAMP('$tanggal_datang', 'MM-DD-YYYY HH24:MI:SS'),'$lnnote','$no_id')";
        $query = $this->oracle->query($sql); 
    }
    

}