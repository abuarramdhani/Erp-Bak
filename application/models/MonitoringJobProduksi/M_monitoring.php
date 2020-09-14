<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();   
        $this->oracle = $this->load->database('oracle', true);
        $this->oracle_dev = $this->load->database('oracle_dev', true);
    }
    
    public function getCategory(){
        $sql = "select * from khs_kategori_item_monitoring";
        $query = $this->oracle_dev->query($sql);
        return $query->result_array();
    }
    
    public function getdataMonitoring($kategori){
        $sql = "select * from khs_category_item_monitoring where category_name = '$kategori'";
        $query = $this->oracle_dev->query($sql);
        return $query->result_array();
    }

    
    public function getAktual($kategori, $bulan){
        $sql = "select distinct
                       kgim.INVENTORY_ITEM_ID
                      ,msib.SEGMENT1                                             item
                      ,msib.DESCRIPTION
                      ,to_char(wdj.SCHEDULED_START_DATE,'DD-MON-YYYY')           tanggal
                      ,to_char(wdj.SCHEDULED_START_DATE,'YYYYMMDD')               tgl_urut
                      ,sum(wdj.START_QUANTITY) over (partition by wdj.PRIMARY_ITEM_ID
                                                                 ,wdj.ORGANIZATION_ID
                                                                 ,to_char(wdj.SCHEDULED_START_DATE,'DD-MON-YYYY')
                                                                 )          quantity
                      ,sum(wdj.QUANTITY_COMPLETED) over (partition by wdj.PRIMARY_ITEM_ID
                                                                 ,wdj.ORGANIZATION_ID
                                                                 ,to_char(wdj.SCHEDULED_START_DATE,'DD-MON-YYYY')
                                                                 )          quantity_complete
                from wip_discrete_jobs wdj
                    ,khs_category_item_monitoring kgim
                    ,mtl_system_items_b msib
                where wdj.PRIMARY_ITEM_ID = kgim.INVENTORY_ITEM_ID
                  and wdj.ORGANIZATION_ID = kgim.ORGANIZATION_ID
                  and msib.INVENTORY_ITEM_ID = kgim.INVENTORY_ITEM_ID
                  and msib.ORGANIZATION_ID = kgim.ORGANIZATION_ID
                  and wdj.STATUS_TYPE in (1,3,12,4,5) -- unreleased, released, closed, complete
                  and trunc(wdj.SCHEDULED_START_DATE) between nvl(TO_DATE ('01/' || '$bulan', 'DD/MM/YYYY'),wdj.SCHEDULED_START_DATE) and nvl(LAST_DAY (TO_DATE ('01/' || '$bulan', 'DD/MM/YYYY')),wdj.SCHEDULED_START_DATE)
                  and kgim.CATEGORY_NAME = '$kategori'
                order by tgl_urut, item";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getitem($term){
        $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id             
                FROM mtl_system_items_b msib            
                WHERE msib.inventory_item_status_code = 'Active'              
                AND msib.inventory_item_id = '$term'
                AND msib.organization_id IN (101, 102) --OPM, ODM         
                ORDER BY msib.segment1
                ";
        $query = $this->oracle_dev->query($sql);
        return $query->result_array();
    }
    
    public function getPlan($id, $bulan){
        $sql = "select * from khs_plan_item_monitoring where inventory_item_id = $id and month = $bulan";
        $query = $this->oracle_dev->query($sql);
        return $query->result_array();
    }
    
    public function getPlanDate(){
        $sql = "select * from khs_plan_item_monitoring_date";
        $query = $this->oracle_dev->query($sql);
        return $query->result_array();
    }

    public function getdataSimulasi($kode, $qty){
      $sql = "select
                msib.segment1 ASSY_code
                ,msib.description assy_Desc
                ,'$qty' start_quantity
                ,msib2.INVENTORY_ITEM_ID
                ,msib2.segment1 komponen
                ,msib2.description komp_desc
                ,msib2.PRIMARY_UOM_CODE UOM_KOMPONEN
                --,bic.COMPONENT_QUANTITY
                ,bic.COMPONENT_QUANTITY*'$qty' required_quantity
                ,msib.PRIMARY_UOM_CODE UOM_ASSY
                ,bom.ALTERNATE_BOM_DESIGNATOR ALT
                ,bic.OPERATION_SEQ_NUM
                ,bic.ITEM_NUM ITEM_SEQ
                ,msib2.SECONDARY_UOM_CODE SECONDARY_UOM_KOMPONEN
                ,bic.ATTRIBUTE1 gudang_asal
                ,mil2.SEGMENT1 locator_asal
                ,mil2.INVENTORY_LOCATION_ID locator_asal_id
                ,bic.SUPPLY_SUBINVENTORY gudang_tujuan
                ,bic.SUPPLY_LOCATOR_ID locator_tujuan_id 
                ,mil.SEGMENT1 locator_tujuan
                ,khs_inv_qty_att(msib2.ORGANIZATION_ID,msib2.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') att
                ,nvl(
                        (select sum(mtrl.QUANTITY)
                            from mtl_txn_request_headers mtrh
                                ,mtl_txn_request_lines mtrl
                                ,mtl_system_items_b msib_komp
                            where mtrh.HEADER_ID = mtrl.HEADER_ID
                            and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
                            and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
                            --
                            and mtrl.LINE_STATUS in (3,7)
                            and mtrh.HEADER_STATUS in (3,7)
                            and mtrl.INVENTORY_ITEM_ID = bic.COMPONENT_ITEM_ID
                            and mtrh.ORGANIZATION_ID = bom.ORGANIZATION_ID
                and mtrh.REQUEST_NUMBER like 'D%'
                    --           and mtrh.TRANSACTION_TYPE_ID in (64,137)
                    --           and msib_komp.SEGMENT1 in ('AAG1BA0021A1-0','AAG1BA0011A1-0')
                        group by mtrl.INVENTORY_ITEM_ID
                            ),0) mo
                    ,(
                            (khs_inv_qty_att(msib2.ORGANIZATION_ID,msib2.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'')
                                )-
                            (nvl(
                                (select sum(mtrl.QUANTITY)
                                    from mtl_txn_request_headers mtrh
                                        ,mtl_txn_request_lines mtrl
                                        ,mtl_system_items_b msib_komp
                                    where mtrh.HEADER_ID = mtrl.HEADER_ID
                                    and mtrh.ORGANIZATION_ID = msib_komp.ORGANIZATION_ID
                                    and mtrl.INVENTORY_ITEM_ID = msib_komp.INVENTORY_ITEM_ID
                                    --
                                    and mtrl.LINE_STATUS in (3,7)
                                    and mtrh.HEADER_STATUS in (3,7)
                                    and mtrl.INVENTORY_ITEM_ID = bic.COMPONENT_ITEM_ID
                                    and mtrh.ORGANIZATION_ID = bom.ORGANIZATION_ID
                and mtrh.REQUEST_NUMBER like 'D%'
                and mtrl.FROM_SUBINVENTORY_CODE = bic.ATTRIBUTE1
                            --           and mtrh.TRANSACTION_TYPE_ID in (64,137)
                            --           and msib_komp.SEGMENT1 in ('AAG1BA0021A1-0','AAG1BA0011A1-0')
                                group by mtrl.INVENTORY_ITEM_ID
                                    ),0) )
                                            ) kurang
                --,decode(bic.basis_type,'','Item','2','Lot') Basis
                --,bic.INCLUDE_IN_COST_ROLLUP
                --,decode(bic.wip_supply_type,1,'Push',2,'Assembly Pull',3,'Operation Pull',4,'Bulk',5,'Supplier',6,'Phantom') supply_type
                --,bic.SUPPLY_SUBINVENTORY subinventory
                --,mil.segment1 locator
                --,bic.DISABLE_DATE
                --,bic.ATTRIBUTE1
                --,bic.ATTRIBUTE2
                from
                bom_bill_of_materials bom
                ,bom_inventory_components bic
                ,mtl_system_items_b msib
                ,mtl_system_items_b msib2
                ,MTL_ITEM_LOCATIONS mil
                ,MTL_ITEM_LOCATIONS mil2
                where
                bom.bill_sequence_id = bic.bill_sequence_id
                and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
                and bom.organization_id = msib.organization_id
                and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
                and bom.ORGANIZATION_ID = msib2.ORGANIZATION_ID
                and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
                and bic.ATTRIBUTE2 = mil2.INVENTORY_LOCATION_ID(+)
                and bom.organization_id = 102
                and msib.SEGMENT1 = '$kode'
                and bom.ALTERNATE_BOM_DESIGNATOR is null
                and bic.DISABLE_DATE is null
                and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and bic.ATTRIBUTE1 is not null
                order by 1,2,3,4,5";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }


}
