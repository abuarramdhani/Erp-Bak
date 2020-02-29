<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_bom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getBom($item){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT CONNECT_BY_ROOT q_bom.assembly_num  root_assembly,
                q_bom.assembly_num,  q_bom.component_num, q_bom.description, q_bom.item_type, q_bom.qty,
                SUBSTR(SYS_CONNECT_BY_PATH(q_bom.assembly_Num, ' <-- '),5) assembly_path,
                LEVEL  bom_level,  CONNECT_BY_ISCYCLE is_cycle
              FROM
                (SELECT  mb1.segment1  assembly_num, mb2.segment1 component_num,mb2.DESCRIPTION,flv.meaning item_type, bc.component_quantity qty
                 FROM  bom.bom_components_b  bc,
                       bom.bom_structures_b  bs,
                       inv.mtl_system_items_b  mb1,
                       inv.mtl_system_items_b  mb2,
              fnd_lookup_values flv
                 WHERE  bs.assembly_item_id = mb1.inventory_item_id
                 AND    bc.component_item_id = mb2.inventory_item_id
                 AND    bc.bill_sequence_id = bs.bill_sequence_id
                 AND    mb1.organization_id = mb2.organization_id
                 AND    bs.organization_id = mb2.organization_id
                 AND    bc.disable_date Is Null
                 AND    bs.alternate_bom_designator IS NULL
                 AND    mb1.organization_id  = 102
                 and mb2.item_type = flv.lookup_code
              and flv.lookup_type = 'ITEM_TYPE'
                ) q_bom
              START WITH  q_bom.assembly_Num in 
              --(select segment1 
              --from mtl_system_items_b msib, 
              --fnd_lookup_values flv2 
              --where organization_id = 102 
              --   and msib.item_type = flv2.lookup_code
              --and flv2.lookup_type = 'ITEM_TYPE'
              --and flv2.MEANING = 'KHS FG Spart Jual NonSerialODM'
              --)             
              ('$item')  --AAB5B0A001AZ-0
              CONNECT BY NOCYCLE PRIOR q_bom.component_num = q_bom.assembly_num
              ORDER SIBLINGS BY q_bom.assembly_Num";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
  
  
    public function getDepthBom($item){
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT max(BOM_LEVEL) Depth from
                (SELECT 
                  CONNECT_BY_ROOT q_bom.assembly_num  root_assembly,
                  q_bom.assembly_num,  q_bom.component_num, q_bom.description, q_bom.item_type, q_bom.qty,
                  SUBSTR(SYS_CONNECT_BY_PATH(q_bom.assembly_Num, ' <-- '),5) assembly_path,
                  LEVEL  bom_level,  CONNECT_BY_ISCYCLE is_cycle
                FROM
                  (SELECT  mb1.segment1  assembly_num, mb2.segment1 component_num,mb2.DESCRIPTION,flv.meaning item_type, bc.component_quantity qty
                   FROM  bom.bom_components_b  bc,
                         bom.bom_structures_b  bs,
                         inv.mtl_system_items_b  mb1,
                         inv.mtl_system_items_b  mb2,
                fnd_lookup_values flv
                   WHERE  bs.assembly_item_id = mb1.inventory_item_id
                   AND    bc.component_item_id = mb2.inventory_item_id
                   AND    bc.bill_sequence_id = bs.bill_sequence_id
                   AND    mb1.organization_id = mb2.organization_id
                   AND    bs.organization_id = mb2.organization_id
                   AND    bc.disable_date Is Null
                   AND    bs.alternate_bom_designator IS NULL
                   AND    mb1.organization_id  = 102
                   and mb2.item_type = flv.lookup_code
                and flv.lookup_type = 'ITEM_TYPE'
                  ) q_bom
                START WITH  q_bom.assembly_Num in 
                --(select segment1 
                --from mtl_system_items_b msib, 
                --fnd_lookup_values flv2 
                --where organization_id = 102 
                --   and msib.item_type = flv2.lookup_code
                --and flv2.lookup_type = 'ITEM_TYPE'
                --and flv2.MEANING = 'KHS FG Spart Jual NonSerialODM'
                --)             
                ('$item')  --AAB5B0A001AZ-0
                CONNECT BY NOCYCLE PRIOR q_bom.component_num = q_bom.assembly_num
                ORDER SIBLINGS BY q_bom.assembly_Num)";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getHeader(){
      $sql = "select * from mds.mds_header_bom";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekIdentitas($version, $root){
      $sql = "select * from mds.mds_header_bom 
              where component_code = '$root' 
              and identitas_bom = '$version'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekHeader(){
      $sql = "select count(*) as jumlah from mds.mds_header_bom";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getDesc($item){
      $oracle = $this->load->database('oracle',true);
      $sql = "select msib.DESCRIPTION
              from mtl_system_items_b msib
              where msib.ORGANIZATION_ID = 81
              and msib.SEGMENT1 = '$item'";
      $query = $oracle->query($sql);
      return $query->result_array();
    }

    public function saveHeader($id,$code, $desc, $identitas, $ket){
      $sql = "insert into mds.mds_header_bom (id, component_code, component_desc, identitas_bom, keterangan)
              values('$id', '$code', '$desc', '$identitas', '$ket')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
    }

    public function saveBom($root_assembly, $assembly_num, $component_num, $item_type, $qty, $assembly_path, $bom_level, $is_cycle, $identitas_bom, $id){
      $sql = "insert into mds.mds_delivery_sparepart (root_assembly, assembly_num, component_num, item_type, qty, assembly_path, bom_level, is_cycle, identitas_bom, id)
              values('$root_assembly', '$assembly_num', '$component_num', '$item_type', '$qty', '$assembly_path', '$bom_level', '$is_cycle', '$identitas_bom', '$id')";
      $query = $this->db->query($sql);
      $query2 = $this->db->query('commit');
      // echo $sql;
    }

    function getDetail2($root, $id){
      $sql = "select * from mds.mds_delivery_sparepart 
              where root_assembly = '$root' 
              and id = '$id' 
              order by component_num";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getDept2($root){
      $sql = "select * from mds.mds_delivery_sparepart 
              where root_assembly = '$root'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function desc($root){
      $sql = "select component_desc 
              from mds.mds_header_bom 
              where component_code = '$root'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function deleteMonitoring($id, $root, $identitas){
      $sql = "delete from mds.mds_delivery_sparepart 
              where id = '$id' 
              and root_assembly = '$root' 
              and identitas_bom = '$identitas'";
      $query = $this->db->query($sql);
      $query = $this->db->query('commit');
      // return $query->result_array();
    }

    public function cekHak($user){
    $sql = "select hak_akses 
            from mds.mds_user_management 
            where no_induk = '$user'";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function deleteBom($code, $id){
      $sql = "delete from mds.mds_delivery_sparepart
              where root_assembly = '$code'
              and id = '$id'";
      $query = $this->db->query($sql);
      $query = $this->db->query('commit');
    }

    public function deleteHeader($code, $id){
      $sql = "delete from mds.mds_header_bom
              where component_code = '$code'
              and id = '$id'";
      $query = $this->db->query($sql);
      $query = $this->db->query('commit');
    }
}
