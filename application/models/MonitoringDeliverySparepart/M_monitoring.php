<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }


    function getData($period){
      $sql = "select * from mds.mds_monitoring_management 
              where periode_monitoring = '$period' 
              order by bom_level, component_num";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getHeader($identitas){
      $sql = "select * from mds.mds_header_monitoring where periode_monitoring = '$identitas'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getTarget($root, $id){
      $sql = "select * from mds.mds_monitoring_management 
              where root_assembly = '$root' 
              and id = '$id' 
              and bom_level = '0' 
              order by component_num";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getCode($compnum, $id, $level){
      $sql = "select component_num from mds.mds_monitoring_management 
              where assembly_num = '$compnum' 
              and id = '$id' 
              and bom_level != '$level' 
              order by component_num";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getAktual($root, $id, $compnum){
      $sql = "select * from mds.mds_simpan_aktual 
              where root_assembly = '$root' 
              and id = '$id' 
              and component_num = '$compnum' 
              order by tanggal_aktual";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getDept2($period){
      $sql = "select * from mds.mds_monitoring_management where root_assembly = '$period'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getDetail2($compnum, $period, $root, $id, $unix){
      $sql = "select * from mds.mds_monitoring_management 
              where periode_monitoring = '$period' 
              and root_assembly = '$root' 
              and component_num = '$compnum' 
              and id = '$id' 
              and idunix = '$unix'
              order by component_num";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getqtyTarget($root, $id, $no){
      $sql = "select * from mds.mds_target_monitoring where component_code = '$root' and id = '$id' and tanggal_target = '$no'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getqtyTarget2($root, $id){
      $sql = "select * from mds.mds_target_monitoring where component_code = '$root' and id = '$id'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function cariqtySebelumnya($assembly, $id){
      $sql = "select * from mds.mds_monitoring_management where component_num = '$assembly' and id = '$id'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function updateQtyTarget($no, $compnum, $root, $id, $qty){
      $sql = "update mds.mds_monitoring_management set qty_target_$no = '$qty' 
              where root_assembly = '$root' 
              and id = '$id'
              and component_num = '$compnum'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
    }

    public function saveTarget($id, $qty, $root, $tgl){
      $sql = "insert into mds.mds_target_monitoring (id, tanggal_target, qty_target, component_code)
              values ('$id', '$tgl', '$qty','$root')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
    }

    public function saveAktual($compnum, $root, $id, $qty, $tgl, $version){
      $sql = "insert into mds.mds_simpan_aktual (id, root_assembly, component_num, identitas_bom, tanggal_aktual, qty_aktual)
              values ('$id', '$root', '$compnum', '$version', '$tgl', '$qty')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      echo $sql;
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

  public function cekHak($user){
    $sql = "select * from mds.mds_user_management 
            where no_induk = '$user'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }
    
    public function updateMonitoring($root, $compnum, $idunix, $bom_version, $qty, $tgl2, $id){
      $sql = "update mds.mds_monitoring_management set qty_target_$tgl2 = '$qty' 
              where root_assembly = '$root' 
              and identitas_bom = '$bom_version'
              and component_num = '$compnum'
              and id = '$id'
              and idunix = '$idunix'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      echo $sql;
    }

    public function terimaKomponen($compnum,$root, $id, $periode, $tgl){
      $sql = "update mds.mds_simpan_aktual set terima_komponen = '1'
              where root_assembly = '$root' 
              and component_num = '$compnum'
              and identitas_bom = '$periode'
              and tanggal_aktual = '$tgl'
              and id = '$id'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      echo $sql;
    }

    public function cekAktual($root, $compnum, $periode, $tgl){
      $sql = "select * from mds.mds_simpan_aktual
            where root_assembly = '$root'
            and component_num = '$compnum'
            and identitas_bom = '$periode'
            and tanggal_aktual = '$tgl'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekAktual2($root, $compnum, $periode, $id){
      $sql = "select * from mds.mds_simpan_aktual
            where root_assembly = '$root'
            and component_num = '$compnum'
            and identitas_bom = '$periode'
            and id = '$id'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function deleteTarget($id, $root, $tgl){
      $sql = "delete from mds.mds_target_monitoring
              where id = '$id'
              and component_code = '$root'
              and tanggal_target = '$tgl'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
    }

    public function deleteAktual($id, $root, $tgl, $compnum){
      $sql = "delete from mds.mds_simpan_aktual
              where id = '$id'
              and root_assembly = '$root'
              and component_num = '$compnum'
              and tanggal_aktual = '$tgl'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
    }

    public function cekQTY($id, $tgl){
      $sql = "select * from mds.mds_simpan_aktual
              where id = '$id'
              and tanggal_aktual = '$tgl'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function updateAktual($id, $tgl, $qty){
      $sql = "update mds.mds_simpan_aktual set qty_aktual = '$qty'
              where id = '$id'
              and tanggal_aktual = '$tgl'";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
    }
}
