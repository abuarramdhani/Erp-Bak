<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();   
        $this->oracle = $this->load->database('oracle', true);
        // $this->oracle_dev = $this->load->database('oracle_dev', true);
    }
    
    public function getCategory($term){
        $sql = "select * from khs_kategori_item_monitoring $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataMonitoring($kategori){
        $sql = "select * from khs_category_item_monitoring where category_name = '$kategori'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getAktual2($kategori, $bulan){
        $sql = "select *            
        from khs_qweb_mon_produksi kqmp            
        where kqmp.CATEGORY_NAME = $kategori
        and kqmp.tgl_urut like '$bulan%'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    // public function getAktual($kategori, $bulan){
    //     $sql = "select distinct
    //                    kgim.INVENTORY_ITEM_ID
    //                   ,msib.SEGMENT1                                             item
    //                   ,msib.DESCRIPTION
    //                   ,to_char(wdj.SCHEDULED_START_DATE,'DD-MON-YYYY')           tanggal
    //                   ,to_char(wdj.SCHEDULED_START_DATE,'YYYYMMDD')               tgl_urut
    //                   ,sum(wdj.START_QUANTITY) over (partition by wdj.PRIMARY_ITEM_ID
    //                                                              ,wdj.ORGANIZATION_ID
    //                                                              ,to_char(wdj.SCHEDULED_START_DATE,'DD-MON-YYYY')
    //                                                              )          quantity
    //                   ,sum(wdj.QUANTITY_COMPLETED) over (partition by wdj.PRIMARY_ITEM_ID
    //                                                              ,wdj.ORGANIZATION_ID
    //                                                              ,to_char(wdj.SCHEDULED_START_DATE,'DD-MON-YYYY')
    //                                                              )          quantity_complete
    //             from wip_discrete_jobs wdj
    //                 ,khs_category_item_monitoring kgim
    //                 ,mtl_system_items_b msib
    //             where wdj.PRIMARY_ITEM_ID = kgim.INVENTORY_ITEM_ID
    //               and wdj.ORGANIZATION_ID = kgim.ORGANIZATION_ID
    //               and msib.INVENTORY_ITEM_ID = kgim.INVENTORY_ITEM_ID
    //               and msib.ORGANIZATION_ID = kgim.ORGANIZATION_ID
    //               and wdj.STATUS_TYPE in (1,3,12,4,5,15) -- unreleased, released, closed, complete,failed close
    //               and trunc(wdj.SCHEDULED_START_DATE) between nvl(TO_DATE ('01/' || '$bulan', 'DD/MM/YYYY'),wdj.SCHEDULED_START_DATE) and nvl(LAST_DAY (TO_DATE ('01/' || '$bulan', 'DD/MM/YYYY')),wdj.SCHEDULED_START_DATE)
    //               and kgim.CATEGORY_NAME = '$kategori'
    //             order by tgl_urut, item";
    //     $query = $this->oracle->query($sql);
    //     return $query->result_array();
    // }
    
    public function getitem($term){
        $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id             
                FROM mtl_system_items_b msib            
                WHERE msib.inventory_item_status_code = 'Active'              
                AND msib.inventory_item_id = '$term'
                AND msib.organization_id IN (101, 102, 225) --OPM, ODM, YSP         
                ORDER BY msib.segment1
                ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getPlan($id, $bulan, $kategori){
        $sql = "select * from khs_plan_item_monitoring where inventory_item_id = $id and month = $bulan and id_category = $kategori";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getPlanDate($term){
        $sql = "select * from khs_plan_item_monitoring_date $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function get_available_picklist($kode){
        $sql = "SELECT msib.segment1 assy_code, msib.description assy_desc,
                        msib.primary_uom_code uom_assy,
                        msib2.inventory_item_id, msib2.segment1 komponen,
                        msib2.description komp_desc, msib2.primary_uom_code uom_komponen,
                        bic.component_quantity,
                        khs_inv_qty_att (msib2.organization_id, msib2.inventory_item_id, bic.attribute1, bic.attribute2, '')  att,
                        khs_inv_qty_att (msib2.organization_id, msib2.inventory_item_id, bic.attribute1, bic.attribute2, '') / bic.component_quantity av_pick,
                        bic.attribute1 gudang_asal, mil.segment1 locator_asal
                FROM mtl_system_items_b msib,
                        mtl_system_items_b msib2,
                        bom_bill_of_materials bom,
                        bom_inventory_components bic,
                        mtl_item_locations mil
                WHERE msib.segment1 = '$kode'
                    AND msib.inventory_item_status_code = 'Active'
                    AND bom.assembly_item_id = msib.inventory_item_id
                    AND bom.organization_id = msib.organization_id
                    AND bom.organization_id = 102
                    AND bom.alternate_bom_designator IS NULL
                    AND bom.bill_sequence_id = bic.bill_sequence_id
                    AND bic.disable_date IS NULL
                    AND bic.component_item_id = msib2.inventory_item_id
                    AND bom.organization_id = msib2.organization_id
                    AND bic.attribute2 = mil.inventory_location_id
                    order by 9";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getdataSimulasi($kode, $qty, $param){
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
                ,khs_inv_qty_att(msib2.ORGANIZATION_ID,msib2.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') att
                ,(khs_inv_qty_att(msib2.ORGANIZATION_ID,msib2.INVENTORY_ITEM_ID,bic.ATTRIBUTE1,bic.ATTRIBUTE2,'') - bic.COMPONENT_QUANTITY*'$qty') kekurangan
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
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'DFG','','') DFG            
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'DMC','','') DMC            
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'FG-TKS','','') FG_TKS            
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-PAINT','','') INT_PAINT            
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-WELD','','') INT_WELD            
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-SUB','','') INT_SUB            
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'PNL-TKS','','') PNL_TKS            
                --,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'SM-TKS','','') SM_TKS
                ,khs_inv_qty_att(101,msib2.inventory_item_id,'SM-TKS','','') SM_TKS
                ,khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-ASSYGT','','') INT_ASSYGT,
                khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-ASSY','','') INT_ASSY,
                khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-MACHA','','') INT_MACHA,
                khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-MACHB','','') INT_MACHB,
                khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-MACHC','','') INT_MACHC,
                khs_inv_qty_att(msib2.organization_id,msib2.inventory_item_id,'INT-MACHD','','') INT_MACHD     
                ,wip.qty wip
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
                ,(select wdj.PRIMARY_ITEM_ID,sum(wdj.START_QUANTITY - (wdj.QUANTITY_COMPLETED + wdj.QUANTITY_SCRAPPED)) qty        
                from wip_discrete_jobs wdj        
                where wdj.STATUS_TYPE = 3        
                group by wdj.PRIMARY_ITEM_ID        
                ) wip
                where
                bom.bill_sequence_id = bic.bill_sequence_id
                and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
                and bom.organization_id = msib.organization_id
                and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
                and bom.ORGANIZATION_ID = msib2.ORGANIZATION_ID
                and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
                and bic.ATTRIBUTE2 = mil2.INVENTORY_LOCATION_ID(+)
                AND msib2.INVENTORY_ITEM_ID    = wip.primary_item_id(+)
                and bom.organization_id = 102
                and msib.SEGMENT1 = '$kode'
                and bom.ALTERNATE_BOM_DESIGNATOR is null
                and bic.DISABLE_DATE is null
                and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                $param
                --and bic.ATTRIBUTE1 is not null
                order by 21,1,2,3,4,5";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }
  
  public function getdataWIP($item){
    $sql = "select *
            from khs_qweb_job_wipicklist kqjw
            where kqjw.ASSY = '$item'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function getRemainingWIP($item){
    $sql = "select xx.ASSY
                ,sum (xx.START_QUANTITY) START_QUANTITY 
                ,sum (xx.REMAINING_QTY) REMAINING_QTY
            from (
            select distinct
                kqj.ASSY
                ,kqj.START_QUANTITY
                ,kqj.REMAINING_QTY
                ,kqj.NO_JOB
            from khs_qweb_job kqj
            where kqj.ASSY = '$item'
            ) xx
            group by xx.ASSY";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function getPicklist($item){
    $sql = "select kqjw.ASSY
                ,sum (kqjw.QPL_ASSY) QPL_ASSY
            from khs_qweb_job_wipicklist kqjw
            where kqjw.ASSY = '$item'
            group by kqjw.ASSY";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function getGudang($item){
    $sql = "SELECT DISTINCT msib.segment1
                ,khs_inv_qty_att(102,msib.inventory_item_id,'FG-TKS','','') FG_TKS
            ,khs_inv_qty_att(102,msib.inventory_item_id,'MLATI-DM','','') MLATI_DM
            FROM mtl_system_items_b msib
            WHERE msib.segment1 = '$item'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function getcomment($kategori, $bulan, $inv, $tgl){
    $sql = "select * from khs_comment_item_monitoring
            where id_category = $kategori
            and bulan = $bulan
            and inventory_item_id = $inv
            and tanggal = $tgl";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function savecomment($kategori, $bulan, $inv, $tgl, $comment){
    $sql = "insert into khs_comment_item_monitoring (id_category, inventory_item_id, bulan, tanggal, keterangan)
            values($kategori, $inv, $bulan, $tgl, '$comment')";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
}

public function updatecomment($kategori, $bulan, $inv, $tgl, $comment){
    $sql = "update khs_comment_item_monitoring set keterangan = '$comment'
            where id_category = $kategori
            and bulan = $bulan
            and inventory_item_id = $inv
            and tanggal = $tgl";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
}

public function getcommentPL($kategori, $bulan, $inv, $tgl){
    $sql = "select * from khs_commentpl_item_monitoring
            where id_category = $kategori
            and bulan = $bulan
            and inventory_item_id = $inv
            and tanggal = $tgl";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function savecommentPL($kategori, $bulan, $inv, $tgl, $comment){
    $sql = "insert into khs_commentpl_item_monitoring (id_category, inventory_item_id, bulan, tanggal, keterangan)
            values($kategori, $inv, $bulan, $tgl, '$comment')";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
}

public function updatecommentPL($kategori, $bulan, $inv, $tgl, $comment){
    $sql = "update khs_commentpl_item_monitoring set keterangan = '$comment'
            where id_category = $kategori
            and bulan = $bulan
            and inventory_item_id = $inv
            and tanggal = $tgl";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
}

public function getcommentC($kategori, $bulan, $inv, $tgl){
    $sql = "select * from khs_commentc_item_monitoring
            where id_category = $kategori
            and bulan = $bulan
            and inventory_item_id = $inv
            and tanggal = $tgl";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function savecommentC($kategori, $bulan, $inv, $tgl, $comment){
    $sql = "insert into khs_commentc_item_monitoring (id_category, inventory_item_id, bulan, tanggal, keterangan)
            values($kategori, $inv, $bulan, $tgl, '$comment')";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
}

public function updatecommentC($kategori, $bulan, $inv, $tgl, $comment){
    $sql = "update khs_commentc_item_monitoring set keterangan = '$comment'
            where id_category = $kategori
            and bulan = $bulan
            and inventory_item_id = $inv
            and tanggal = $tgl";
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query('commit');
}


}
