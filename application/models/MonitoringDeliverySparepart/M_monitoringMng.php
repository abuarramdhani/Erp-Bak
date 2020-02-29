<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoringMng extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function dataMonMng(){
      $sql = "select * from mds.mds_header_monitoring";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getDetail($root, $period){
      $sql = "select * from mds.mds_monitoring_management 
              where periode_monitoring = '$period' 
              and root_assembly = '$root' 
              and bom_level != '0' 
              order by component_num";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getDetail2($root, $period, $compnum){
      $sql = "select * from mds.mds_monitoring_management 
              where periode_monitoring = '$period' 
              and root_assembly = '$root' 
              and component_num = '$compnum' 
              and bom_level != '0'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    
    function getqtyTarget($root, $id, $no){
      $sql = "select * from mds.mds_target_monitoring where component_code = '$root' and id = '$id' and tanggal_target = '$no'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function cariqtySebelumnya($assembly, $id){
      $sql = "select * from mds.mds_monitoring_management where component_num = '$assembly' and id = '$id'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    
    function getTarget($root, $id, $no){
      $sql = "select * from mds.mds_target_monitoring where component_code = '$root' and id = '$id' and tanggal_target = '$no'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getDept2($period){
      $sql = "select * from mds.mds_monitoring_management where root_assembly = '$period'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getDataBom($component_code, $bom_version){
      $sql = "select * from mds.mds_delivery_sparepart 
              where root_assembly = '$component_code' 
              and identitas_bom = '$bom_version'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekHeader(){
      $sql = "select count(*) as jumlah from mds.mds_header_monitoring";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function desc($root){
      $sql = "select component_desc from mds.mds_header_monitoring 
              where component_code = '$root'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekBom($component_code, $bom_version){
      $sql = "select * from mds.mds_delivery_sparepart 
              where root_assembly = '$component_code' 
              and identitas_bom = '$bom_version'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekData($component_code, $bom_version, $periode){
      $sql = "select * from mds.mds_header_monitoring
              where component_code = '$component_code' 
              and identitas_bom = '$bom_version'
              and periode_monitoring = '$periode'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getseksi($compnum){
      $oracle = $this->load->database('oracle',true);
      $sql = "select distinct msib.SEGMENT1 assy
              ,msib.DESCRIPTION assy_desc
              ,bd.DEPARTMENT_CODE
              ,bd.DEPARTMENT_CLASS_CODE
        from bom_operational_routings bor
            ,bom_operation_sequences bos
            ,bom_operation_resources bores
            ,bom_departments bd
            ,bom_resources br
            --
            ,mtl_system_items_b msib
            ,mtl_item_locations mil
        where bor.ORGANIZATION_ID = 102
          and msib.SEGMENT1 = '$compnum'
          and bor.ASSEMBLY_ITEM_ID = msib.INVENTORY_ITEM_ID
          and bor.ORGANIZATION_ID = msib.ORGANIZATION_ID
          and bor.ORGANIZATION_ID = br.ORGANIZATION_ID
          and bor.COMPLETION_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
          --
          and bos.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
          and bos.DEPARTMENT_ID = bd.DEPARTMENT_ID
          and bor.ALTERNATE_ROUTING_DESIGNATOR is null
          and bd.DISABLE_DATE is null
          --
          and bores.RESOURCE_ID = br.RESOURCE_ID
          and bores.OPERATION_SEQUENCE_ID = bos.OPERATION_SEQUENCE_ID
        order by 1";
      $query = $oracle->query($sql);
      return $query->result_array();
  }

    public function saveTarget($id, $tgl_target, $qty_target, $root){
      $sql = "insert into mds.mds_target_monitoring (id, tanggal_target, qty_target, component_code)
              values('$id', '$tgl_target', '$qty_target', '$root')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
  }

    public function saveMonitoring($root, $asnum, $compnum, $item, $qty, $aspath, $level, $cycle, $identitas, $periode, $id){
      $sql = "insert into mds.mds_monitoring_management (root_assembly, assembly_num, component_num, item_type, qty, assembly_path,
              bom_level, is_cycle, identitas_bom, periode_monitoring, id)
              values('$root', '$asnum', '$compnum', '$item', '$qty', '$aspath', '$level', '$cycle', '$identitas', '$periode', '$id')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
  }

public function saveHeadTrg($root, $desc, $identitas, $periode, $id, $tgl, $qty){
  $sql = "insert into mds.mds_monitoring_management (root_assembly, assembly_num, component_num, item_type,
          bom_level, identitas_bom, periode_monitoring, id, qty_target_$tgl)
          values('$root', '$root', '$root', '$desc', '0', '$identitas','$periode', '$id', '$qty')";
  $query = $this->db->query($sql);
  $query2 = $this->db->query('commit');
  // echo $sql;
}

public function updateHeadTrg($root, $desc, $identitas, $periode, $id, $tgl, $qty){
  $sql = "update mds.mds_monitoring_management set qty_target_$tgl = '$qty'
          where root_assembly = '$root' 
          and identitas_bom = '$identitas'
          and component_num = '$root'
          and bom_level = '0'
          and id = '$id'";
  $query = $this->db->query($sql);
  $query2 = $this->db->query('commit');
  // echo $sql;
}

    public function saveheaderMon($root, $desc, $identitas, $periode, $id){
      $sql = "insert into mds.mds_header_monitoring (component_code, component_desc,
              identitas_bom, periode_monitoring, id)
              values('$root', '$desc', '$identitas', '$periode', '$id')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
  }

    public function updateMonitoring($root, $compnum, $level, $identitas, $qty2, $tgl2, $id){
      $sql = "update mds.mds_monitoring_management set qty_target_$tgl2 = '$qty2' 
              where root_assembly = '$root' 
              and identitas_bom = '$identitas'
              and component_num = '$compnum'
              and bom_level = '$level'
              and id = '$id'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
    }

  public function deleteHeader($component_code, $id){
    $sql = "delete from mds.mds_header_monitoring 
            where component_code = '$component_code'
            and id = '$id'";
    $query = $this->db->query($sql);
    $query2 = $this->db->query('commit');
    // echo $sql;
}

public function deleteMonitoring($component_code, $id){
      $sql = "delete from mds.mds_monitoring_management 
              where root_assembly = '$component_code'
              and id = '$id'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
  }

  public function deleteTarget($component_code, $id){
    $sql = "delete from mds.mds_target_monitoring
            where component_code = '$component_code'
            and id = '$id'";
    $query = $this->db->query($sql);
    $query2 = $this->db->query('commit');
    // echo $sql;
}

public function deleteAktual($component_code, $id){
  $sql = "delete from mds.mds_simpan_aktual
          where root_assembly = '$component_code'
          and id = '$id'";
  $query = $this->db->query($sql);
  $query2 = $this->db->query('commit');
  // echo $sql;
}

public function getCompCode($term){
  $oracle = $this->load->database('oracle',true);
  $sql = "select msib.segment1, msib.description
          from mtl_system_items_b msib
          where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
          and msib.organization_id = 81
          AND msib.SEGMENT1 LIKE '%$term%'
          OR msib.description LIKE '%$term%'";
  $query = $oracle->query($sql);
  return $query->result_array();
}

public function getDescCode($term){
  $oracle = $this->load->database('oracle',true);
  $sql = "select msib.description
          from mtl_system_items_b msib
          where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
          and msib.organization_id = 81
          AND msib.SEGMENT1 = '$term'";
  $query = $oracle->query($sql);
  return $query->result_array();
}

public function getBomVersion($root){
  $sql = "select identitas_bom from mds.mds_header_bom where component_code = '$root'";
  $query = $this->db->query($sql);
  return $query->result_array();
}

public function cekHak($user){
  $sql = "select * from mds.mds_user_management where no_induk = '$user'";
    $query = $this->db->query($sql);
    return $query->result_array();
  }

public function getHeader($bln){
  $sql = "select * from mds.mds_header_monitoring where periode_monitoring = '$identitas'";
  $query = $this->db->query($sql);
  return $query->result_array();
}


}
