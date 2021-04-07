<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_request extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->oracle = $this->load->database('oracle', true);
    }
    
    public function cekrequesttemp($term){
      $sql = "select * from mcl.tbl_request_temp $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function getNamaBarang($term) {
        $sql = "select distinct msib.inventory_item_id, msib.segment1, msib.description
                from mtl_system_items_b msib
                where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and msib.organization_id = 81
                $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function getCost_Center($term, $ket){
      $sql = "SELECT
                  ffv.FLEX_VALUE as COST_CENTER,
                  ffvt.DESCRIPTION as PEMAKAI,
                  ffv.ATTRIBUTE10
              from fnd_flex_values ffv,
                  fnd_flex_values_TL ffvt
              where ffv.FLEX_VALUE_SET_ID=1013709
                  and ffv.ATTRIBUTE10 != ' '
                  and ffv.ATTRIBUTE10 = '$ket'
                  and ffv.FLEX_VALUE_ID=ffvt.FLEX_VALUE_ID
                  AND ffv.END_DATE_ACTIVE IS NULL
                  AND ffv.flex_value NOT LIKE '0000'
                  and ffv.ENABLED_FLAG = 'Y'
                  and ffv.SUMMARY_FLAG = 'N'
                  and (ffv.FLEX_VALUE like '%$term%' or ffvt.DESCRIPTION like '%$term%')
              order by ffv.FLEX_VALUE";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getSubinv($io) {
      $sql = "SELECT   msi.secondary_inventory_name, msi.description
                  FROM mtl_secondary_inventories msi, mtl_parameters mp
                WHERE msi.disable_date IS NULL
                  AND msi.organization_id = mp.organization_id
                  AND mp.organization_code = '$io'
              ORDER BY msi.secondary_inventory_name";
      $query = $this->oracle->query($sql);
      return $query->result_array();
      // return $sql;
    }

    public function getLokator($subinv){
        $sql = "SELECT
                  distinct(mil.SUBINVENTORY_CODE),
                  moq.LOCATOR_ID,
                  mil.SEGMENT1,
                  mil.DESCRIPTION
              from mtl_item_locations mil,
                  mtl_onhand_quantities moq
              where mil.SUBINVENTORY_CODE = '$subinv'
              and mil.INVENTORY_LOCATION_ID =moq.LOCATOR_ID
              ORDER BY mil.SEGMENT1 ASC";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
    
    public function getLokatorID($locator){
      $sql = "SELECT mil.inventory_location_id
                FROM mtl_item_locations mil
              WHERE mil.segment1 = '$locator'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
    
    public function getItem($term,$subinv, $lokator){
      $sql = "SELECT msib.INVENTORY_ITEM_ID, msib.SEGMENT1, msib.DESCRIPTION,
                    khs_inv_qty_oh (msib.organization_id, msib.inventory_item_id, msi.secondary_inventory_name, mil.inventory_location_id, NULL) onhand,
                    msib.primary_uom_code, msib.secondary_uom_code
              FROM mtl_system_items_b msib,
                    mtl_secondary_inventories msi,
                    mtl_item_locations mil
              WHERE msib.organization_id = msi.organization_id
                AND msi.organization_id = mil.organization_id(+)
                AND msi.secondary_inventory_name = mil.subinventory_code(+)
                AND msi.secondary_inventory_name = NVL ('$subinv', msi.secondary_inventory_name)
                --AND NVL (mil.segment1, 0) IN (NVL ('$lokator', NVL (mil.segment1, 0)))
                $term
                order by msib.SEGMENT1 ASC";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  
  public function getseksi($user){
    $oracle = $this->load->database('personalia',true);
    $sql = "select ts.seksi, ts.unit, tp.nama
            from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
            where tp.kodesie = ts.kodesie
            and tp.noind = '$user'";
    $query = $oracle->query($sql);
    return $query->result_array();
  }
  
  public function getOrgAssign(){
    $sql = "SELECT mp.organization_id, mp.organization_code, hou.NAME                
            FROM hr_organization_units_v hou,                        
                hr_organization_information_v hoi,                        
                hr_lookups hl1,                        
                hr_lookups hl2,                        
                hr_lookups hl3,                        
                hz_geographies geo,                        
                mtl_parameters mp                
            WHERE hou.organization_id = hoi.organization_id                    
            AND hoi.organization_id = mp.organization_id                    
            AND hoi.org_information_context = 'CLASS'                    
            AND geo.geography_code(+) = hou.region_1                    
            AND geo.geography_type(+) = 'PROVINCE'                    
            AND hl1.lookup_code(+) = hou.style                    
            AND hl1.lookup_type(+) = 'GHR_US_CNTRY_WRLD_CTZN'                    
            AND hl2.lookup_code(+) = hou.country                    
            AND hl2.lookup_type(+) = 'PER_US_COUNTRY_CODE'                    
            AND hl3.lookup_code(+) = hou.postal_code                    
            AND hl3.lookup_type(+) = 'GHR_US_POSTAL_COUNTRY_CODE'                    --pembatasan untuk io aktif                    
            AND hoi.org_information1_meaning = 'Inventory Organization'                    
            AND hou.date_to IS NULL
            order by 2 asc";
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

public function getOrgID($io){
  $sql = "SELECT mp.organization_id, mp.organization_code      
          FROM mtl_parameters mp                
          WHERE mp.organization_code = '$io'";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

public function assign_order($term){
  $sql = "SELECT su.user_name, vsu.employee_name
          FROM sys.sys_user su,
          sys.sys_user_application sua,
          sys.sys_user_group_menu sugm,
          sys.sys_module smod,
          sys.vi_sys_user vsu
          WHERE su.user_id = sua.user_id
          AND vsu.user_id = su.user_id
          AND sua.user_group_menu_id = sugm.user_group_menu_id
          AND smod.module_id= sugm.module_id
          AND sugm.user_group_menu_id = 2801 --id Miscellaneous Kepala Seksi Utama
          AND su.user_name like'%$term%'";
  $query = $this->db->query($sql);
  return $query->result_array();
}

public function assign_cabang($term){
  $sql = "SELECT su.user_name, vsu.employee_name
          FROM sys.sys_user su,
          sys.sys_user_application sua,
          sys.sys_user_group_menu sugm,
          sys.sys_module smod,
          sys.vi_sys_user vsu
          WHERE su.user_id = sua.user_id
          AND vsu.user_id = su.user_id
          AND sua.user_group_menu_id = sugm.user_group_menu_id
          AND smod.module_id= sugm.module_id
          AND sugm.user_group_menu_id = 2806 --id Miscellaneous Kepala Cabang
          AND su.user_name like'%$term%'";
  $query = $this->db->query($sql);
  return $query->result_array();
}

public function assign_ppc($term){
  $sql = "SELECT su.user_name, vsu.employee_name
          FROM sys.sys_user su,
          sys.sys_user_application sua,
          sys.sys_user_group_menu sugm,
          sys.sys_module smod,
          sys.vi_sys_user vsu
          WHERE su.user_id = sua.user_id
          AND vsu.user_id = su.user_id
          AND sua.user_group_menu_id = sugm.user_group_menu_id
          AND smod.module_id= sugm.module_id
          AND sugm.user_group_menu_id = 2802 --id Miscellaneous Seksi PPC
          AND su.user_name like'%$term%'";
  $query = $this->db->query($sql);
  return $query->result_array();
}

public function getUser($term){
  $oracle = $this->load->database('personalia',true);
  $sql = " SELECT distinct noind, nama
      FROM hrd_khs.tpribadi 
      where noind like '%$term%'
      or nama like '%$term%'";
  $query = $oracle->query($sql);
  return $query->result_array();
}

public function getUom($term){
  $sql = "select muomt.UOM_CODE, muomt.UNIT_OF_MEASURE
          from mtl_units_of_measure_tl muomt
          where muomt.UOM_CODE like '%$term%'
          order by muomt.UOM_CODE asc";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

public function getLokasiIO($term){
  $sql = "SELECT   haou.organization_id ou_id, haou.NAME, ood.organization_code,
            ood.organization_name organization_desc
          FROM hr_all_organization_units haou, org_organization_definitions ood
          WHERE ood.operating_unit = haou.organization_id
          AND ood.disable_date IS NULL
          AND ood.ORGANIZATION_CODE = '$term'
          ORDER BY  1, 3";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

public function getBranchIO($term){
  $sql = "select distinct 
            xsrd.VALUE_CONSTANT branch
          from xla_seg_rule_details xsrd
          ,xla_seg_rules_fvl xsrf
          ,xla_conditions xc
          ,mtl_parameters mp
          where xsrd.SEGMENT_RULE_CODE = xsrf.SEGMENT_RULE_CODE
          and xsrd.APPLICATION_ID = xsrf.APPLICATION_ID
          and xc.SEGMENT_RULE_DETAIL_ID = xsrd.SEGMENT_RULE_DETAIL_ID
          and mp.ORGANIZATION_ID = xc.VALUE_CONSTANT
          -- 
          and xsrf.SEGMENT_RULE_CODE = 'KHS_ALL_BRANCH'
          and xsrf.APPLICATION_ID = 707
          --
          and mp.ORGANIZATION_CODE = '$term'";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}


public function getNoserial($term, $subinv, $item){
  $sql = "SELECT   msn.serial_number
            FROM mtl_serial_numbers msn, mtl_system_items_b msib
          WHERE msn.current_status = 3
            AND msn.inventory_item_id = msib.inventory_item_id
            AND msn.current_organization_id = msib.organization_id
            AND msn.current_subinventory_code = '$subinv'
            AND msib.segment1 = '$item'
            AND msn.serial_number like '%$term%'
          ORDER BY 1";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

public function getItemCostODM($item){
  $sql = "SELECT msib.segment1 item, msib.description, cic.cost_type_id, cct.cost_type,
            cic.item_cost
          FROM mtl_system_items_b msib, cst_item_costs cic, cst_cost_types cct
          WHERE msib.organization_id = 102
          AND msib.inventory_item_status_code = 'Active'
          AND msib.segment1 = '$item'
          AND msib.inventory_item_id = cic.inventory_item_id
          AND msib.organization_id = cic.organization_id
          AND cic.cost_type_id = cct.cost_type_id
          AND cct.cost_type_id = 2";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

public function getItemCostOPM($item){
  $sql = "SELECT   msib.segment1 item, msib.description, ccd.cost_type_id,
            cmm.cost_mthd_code, SUM (ccd.cmpnt_cost) item_cost
          FROM mtl_system_items_b msib,
            cm_cmpt_dtl ccd,
            gmf_period_statuses gps,
            cm_mthd_mst cmm
          WHERE msib.organization_id = 101
          AND msib.inventory_item_status_code = 'Active'
          AND msib.segment1 = '$item'
          AND ccd.inventory_item_id = msib.inventory_item_id
          AND ccd.organization_id = msib.organization_id
          AND ccd.period_id = gps.period_id
          AND ccd.cost_type_id = cmm.cost_type_id
          AND TRUNC (ADD_MONTHS (:p_tgl_input, -1)) >= gps.start_date
          AND TRUNC (ADD_MONTHS (:p_tgl_input, -1)) <= gps.end_date
          GROUP BY msib.segment1, msib.description, ccd.cost_type_id,
            cmm.cost_mthd_code";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

public function getAlasan(){
  $sql = "select * from mcl.mcl_tbl_alasan order by alasan asc";
  $query = $this->db->query($sql);
  return $query->result_array();
}

public function getTypeTransact($term){
  $sql = "SELECT *
          FROM mtl_transaction_types
          WHERE (       description LIKE 'Miscell%'
                    AND transaction_type_name LIKE 'KHS%'
                  OR     description LIKE 'Adjustment%'
                    AND transaction_type_name LIKE 'KHS%'
                  OR transaction_type_name LIKE 'Lot Conversion%'
                )
                AND transaction_type_name LIKE '%$term%'
          order by transaction_type_name";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

public function getAkunCOA($term, $cost_center){
  $sql = "SELECT DISTINCT gcc.segment3 akun, ffv_akun.description desc_akun,
            gcc.segment4 cost_center, ffv_cc.description desc_cc
          FROM gl_code_combinations gcc,
            fnd_flex_values_vl ffv_akun,
            fnd_flex_values_vl ffv_cc
          WHERE ffv_akun.flex_value_set_id = 1013708
          AND ffv_akun.flex_value = gcc.segment3
          AND ffv_cc.flex_value_set_id = 1013709
          AND ffv_cc.flex_value = gcc.segment4
          AND gcc.segment4 = '$cost_center'
          AND gcc.segment3 like '%$term%'
          ORDER BY gcc.segment3, gcc.segment4";
  $query = $this->oracle->query($sql);
  return $query->result_array();
}

    public function saveTemp($data){
      $this->db->trans_start();
      $this->db->insert('mcl.tbl_request_temp',$data);
      $this->db->trans_complete();
    }

    public function deleteTemp($term){
      $sql = "delete from mcl.tbl_request_temp $term";
      $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function cekheader($term){
      $sql = "select * from mcl.mcl_header_request $term
              order by id desc";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function cekitemrequest($term){
      $sql = "SELECT mir.*, 
              case when mkp.revisi_qty is null
              then mir.qty
              else mkp.revisi_qty
              end qty,
              mcr.tipe_transaksi,
              mcr.coa,
              mcr.deskripsi_akun_biaya deskripsi_biaya,
              mcr.deskripsi_cc,
              mcr.total_cost,
              mcr.produk
              FROM mcl.mcl_item_request mir
              FULL JOIN mcl.mcl_kadep_prod mkp
              ON mir.id_item = mkp.id_item
              FULL JOIN mcl.mcl_costing_request mcr
              ON mir.id_item = mcr.id_item
              $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function approver_misc($id){
      $sql = "SELECT mas.pic pic_askanit, mas.tgl_approve tgl_askanit,
                    mca.pic pic_cabang, mca.tgl_approve tgl_cabang,
                    mpp.pic pic_ppc, mpp.tgl_approve tgl_ppc,
                    mkp.pic pic_kadep, mkp.tgl_approve tgl_kadep,
                    mcr.pic pic_costing, mcr.tgl_approve tgl_costing,
                    mak.pic pic_akt, mak.tgl_approve tgl_akt,
                    mci.pic pic_input, mci.tgl_approve tgl_input
              FROM mcl.mcl_item_request mir
                FULL JOIN mcl.mcl_cabang mca
                ON mir.id_item = mca.id_item
                FULL JOIN mcl.mcl_askanit mas
                ON mir.id_item = mas.id_item
                FULL JOIN mcl.mcl_ppc mpp
                ON mir.id_item = mpp.id_item
                FULL JOIN mcl.mcl_kadep_prod mkp
                ON mir.id_item = mkp.id_item
                FULL JOIN mcl.mcl_costing_request mcr
                ON mir.id_item = mcr.id_item
                FULL JOIN mcl.mcl_akuntansi mak
                ON mir.id_item = mak.id_item
                FULL JOIN mcl.mcl_costing_input mci
                ON mir.id_item = mci.id_item
              WHERE mir.id_item = $id";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function cariReject($id){
      $sql = "SELECT 
              case when mca.action = 'Reject' then mca.pic
                  when mas.action = 'Reject' then mas.pic
                  when mpc.action = 'Reject' then mpc.pic
                  when mkp.action = 'Reject' then mkp.pic
                  when mcr.action = 'Reject' then mcr.pic
                  when mak.action = 'Reject' then mak.pic
                  when mci.action = 'Reject' then mci.pic
              end pic,
              case when mca.action = 'Reject' then mca.note
                  when mas.action = 'Reject' then mas.note
                  when mpc.action = 'Reject' then mpc.note
                  when mkp.action = 'Reject' then mkp.note
                  when mcr.action = 'Reject' then mcr.note
                  when mak.action = 'Reject' then mak.note
                  when mci.action = 'Reject' then mci.reference
              end note
              FROM mcl.mcl_item_request mir
              FULL JOIN mcl.mcl_cabang mca
              ON mir.id_item = mca.id_item
              FULL JOIN mcl.mcl_askanit mas
              ON mir.id_item = mas.id_item
              FULL JOIN mcl.mcl_ppc mpc
              ON mir.id_item = mpc.id_item
              FULL JOIN mcl.mcl_kadep_prod mkp
              ON mir.id_item = mkp.id_item
              FULL JOIN mcl.mcl_akuntansi mak
              ON mir.id_item = mak.id_item
              FULL JOIN mcl.mcl_costing_request mcr
              ON mir.id_item = mcr.id_item
              FULL JOIN mcl.mcl_costing_input mci
              ON mir.id_item = mci.id_item
              where mir.id_item = $id";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function cekserialnumber($term){
      $sql = "select *
              from mtl_serial_numbers msn
              where msn.SERIAL_NUMBER = '$term'";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
    
    public function saveHeader($data){
      $this->db->trans_start();
      $this->db->insert('mcl.mcl_header_request',$data);
      $this->db->trans_complete();
    }

    public function updateHeader($status, $id){
      $sql = "update mcl.mcl_header_request
              set status = '$status'
              where id = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function saveItem($idheader, $iditem, $jenis, $ket_cost, $cost_center, $inv_item, $item, $desc,
    $qty, $onhand, $ket_uom, $first_uom, $secondary_uom, $inventory, $locator, $no_serial, $alasan,$desc_alasan, $attachment){
      $sql = "insert into mcl.mcl_item_request (id_header, id_item, issue_receipt, ket_cost_center, cost_center, inventory_item_id, kode_item, deskripsi_item,
              qty, onhand, ket_uom, uom, secondary_uom, inventory, locator, no_serial, alasan, deskripsi_alasan, attachment)
              values ($idheader, $iditem, '$jenis', '$ket_cost', '$cost_center', $inv_item, '$item', '$desc',
              $qty, $onhand, '$ket_uom', '$first_uom', '$secondary_uom', '$inventory', '$locator', '$no_serial', '$alasan',
              '$desc_alasan', '$attachment')";
      $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function getdataCabang($term){
      $sql = "select * from mcl.mcl_cabang $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function getdataAskanit($term){
      $sql = "select * from mcl.mcl_askanit $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function getdataPPC($term){
      $sql = "select * from mcl.mcl_ppc $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function getdataKadep($term){
      $sql = "select * from mcl.mcl_kadep_prod $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function getdataCosting($term){
      $sql = "select * from mcl.mcl_costing_request $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function getdataCostingInput($term){
      $sql = "select * from mcl.mcl_costing_input $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function getdataAkt($term){
      $sql = "select * from mcl.mcl_akuntansi $term";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function saveCabang($iditem, $action, $note, $pic, $tgl){
      $sql = "insert into mcl.mcl_cabang (id_item, action, note, pic, tgl_approve)
              values($iditem, '$action', '$note', '$pic', '$tgl')";
      $query = $this->db->query($sql);
    }
    
    public function saveAskanit($iditem, $action, $note, $pic, $tgl){
      $sql = "insert into mcl.mcl_askanit (id_item, action, note, pic, tgl_approve)
              values($iditem, '$action', '$note', '$pic', '$tgl')";
      $query = $this->db->query($sql);
    }
    
    public function savePPC($iditem, $action, $note, $pic, $tgl){
      $sql = "insert into mcl.mcl_ppc (id_item, action, note, pic, tgl_approve)
              values($iditem, '$action', '$note', '$pic', '$tgl')";
      $query = $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function saveKadep($iditem, $qty, $action, $note, $pic, $tgl){
      $sql = "insert into mcl.mcl_kadep_prod (id_item, revisi_qty, action, note, pic, tgl_approve)
              values($iditem, $qty, '$action', '$note', '$pic', '$tgl')";
      $query = $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function saveCosting($id_item, $action, $note, $tipe_transaksi, $coa, $desc_biaya, $desc_cc, $total_cost, $pic, $tgl, $produk){
      $sql = "insert into mcl.mcl_costing_request (id_item, action, note, tipe_transaksi, coa, deskripsi_akun_biaya, deskripsi_cc, 
              total_cost, pic, tgl_approve, produk)
              values($id_item, '$action', '$note', '$tipe_transaksi', '$coa', '$desc_biaya', '$desc_cc', '$total_cost', '$pic', '$tgl', '$produk')";
      $query = $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function saveAkt($iditem, $action, $note, $pic, $tgl){
      $sql = "insert into mcl.mcl_akuntansi (id_item, action, note, pic, tgl_approve)
              values($iditem, '$action', '$note', '$pic', '$tgl')";
      $query = $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function saveCostingInput($iditem, $action, $reference, $pic, $tgl){
      $sql = "insert into mcl.mcl_costing_input (id_item, action, reference, pic, tgl_approve)
              values($iditem, '$action', '$reference', '$pic', '$tgl')";
      $query = $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function deleteItem($id){
      $sql = "delete from mcl.mcl_item_request where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }

    public function deleteCabang($id){
      $sql = "delete from mcl.mcl_cabang where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }

    public function deleteAskanit($id){
      $sql = "delete from mcl.mcl_askanit where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }

    public function deletePPC($id){
      $sql = "delete from mcl.mcl_ppc where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }

    public function deleteKadep($id){
      $sql = "delete from mcl.mcl_kadep_prod where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }
    
    public function deleteCosting($id){
      $sql = "delete from mcl.mcl_costing_request where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }

    public function deleteAkt($id){
      $sql = "delete from mcl.mcl_akuntansi where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }

    public function deleteInput($id){
      $sql = "delete from mcl.mcl_costing_input where id_item = $id";
      $this->db->query($sql);
      $this->db->query('commit');
    }

    public function cekMTI($no_dokumen, $inv_id){
      $sql = "select *
              from mtl_transactions_interface mti
              where mti.SOURCE_CODE = 'ERP MISCELLANEOUS'
              and mti.TRANSACTION_SOURCE_NAME = '$no_dokumen'
              and mti.INVENTORY_ITEM_ID = $inv_id";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function InputOracle($uom, $lokator_id, $user_id, $inv_id,$inventory, $org_id, $no_dokumen, $quantity, $type_transact_id, $reference, $branch, $account, $cost_center){
      $sql = "insert into mtl_transactions_interface (transaction_uom ,transaction_date
                    ,source_code ,source_line_id ,source_header_id
                    ,process_flag ,transaction_mode ,lock_flag ,locator_id 
                    ,last_update_date ,last_updated_by ,creation_date ,created_by 
                    , inventory_item_id ,subinventory_code ,organization_id 
                    ,transaction_source_name ,transaction_source_id ,transaction_quantity
                    ,primary_quantity ,transaction_type_id ,TRANSACTION_REFERENCE ,dst_segment1
                    ,dst_segment2 ,dst_segment3 ,dst_segment4 ,dst_segment5)
              VALUES(	'$uom',-- //transaction uom
                      SYSDATE,-- //transaction date
                      'ERP MISCELLANEOUS',-- //source code
                      -1,-- //source line id
                      -1,-- //source header id
                      1,-- //process flag
                      3,-- //transaction mode
                      2,-- //lock flag
                      $lokator_id,-- //locator id
                      SYSDATE,-- //last update date
                      $user_id,-- //last updated by
                      SYSDATE,-- //creation date
                      $user_id,-- //created by
                      $inv_id,-- //inventory item id
                      '$inventory',-- //From subinventory code
                      $org_id,-- //organization id
                      '$no_dokumen',-- //transaction source(nomor BPBGT)
                        NULL,-- //transaction source id
                      $quantity,-- //transaction quantity issue *-1
                      $quantity,-- //Primary quantity issue *-1
                      $type_transact_id,-- //transaction type id
                      '$reference',--//reference
                      '1',-- //segment account combination
                      '$branch',-- //segment2 account combination
                      '$account',-- //segment3 account combination
                      UPPER('$cost_center'),-- //segment4 account combination
                      '000')";
      $query = $this->oracle->query($sql);
      $query = $this->oracle->query('commit');

    }

    public function InputSerial($mti_id, $noserial){
      $sql = "INSERT INTO mtl_serial_numbers_interface(
              transaction_interface_id,
              last_update_date,
              last_updated_by,
              creation_date,
              created_by,
              fm_serial_number,
              to_serial_number) values (
              $mti_id,  -- For serial controlled ONLY use MTI.transaction_interface_id
              sysdate,
              0,
              sysdate,
              0,
              '$noserial',
              '$noserial')";
      $query = $this->oracle->query($sql);
      $query = $this->oracle->query('commit');

    }

    public function runAPI($user_id){
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
			if (!$conn) {
	   			 $e = oci_error();
	    		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}
		  
      $sql = "BEGIN APPS.KHS_RUN_FND (:P_USER_ID); END;";

      //Statement does not change
      $stmt = oci_parse($conn,$sql);                     
      oci_bind_by_name($stmt,':P_USER_ID',$user_id);           
      
      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      
      // and now, execute the cursor
      oci_execute($cursor);
    }



}
