
<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_monitoringpengirimansparepart extends CI_Model
{
  var $oracle;
  function __construct()
  {
    parent::__construct();
    $this->load->database();
      $this->load->library('encrypt');
      // $this->oracle = $this->load->database('oracle', true);
   }
    public function checkSourceLogin($employee_code)
    {
        $db = $this->load->database();
        $sql = "select eea.employee_code, es.section_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function SelectDashboard() //pake database dev
    {
      $db = $this->load->database('dpostgre',true);
      $sql = "
       select
              osh.shipment_header_id                                                        no_shipment
              ,ovt.name                                                                     jenis_kendaraan
              ,osh.estimate_depart_date                                                     berangkat
              ,ofg.name                                                                     asal_gudang
              ,omc.name                                                                     cabang
--              ,CONCAT(op.name,'-',oc.name)                                                tujuan
              --,oct.name                                                                   jenis_muatan
              ,string_agg(distinct CONCAT(osl.quantity,' ',oum.name,' ',ou.name), ', ')     muatan
              ,OSH.is_full_flag                                                             status
              ,osh.actual_loading_date                                                      actual_loading
              ,osh.actual_depart_date                                                       actual_berangkat
      from
              om.om_shipment_header osh
              left join om.om_cabang omc on osh.shipment_to_cabang_id = omc.cabang_id
              left join om.om_shipment_line osl on osh.shipment_header_id = osl.shipment_header_id
              left join om.om_vehicle_type ovt on osh.vehicle_type_id = ovt.vehicle_type_id 
              left join om.om_finish_good ofg on osh.shipment_from_fg_id = ofg.finish_good_id
              left join om.om_content_type oct on osl.content_type_id = oct.content_type_id
              left join om.om_uom oum on osl.uom_id = oum.uom_id
              left join om.om_unit ou on osl.unit_id = ou.unit_id
              left join om.om_province op on osh.shipment_to_province_id = op.province_id
              left join om.om_city oc on osh.shipment_to_city_id = oc.city_id
    where osh.estimate_depart_date > now() - interval '1 day'
    -- and osh.estimate_depart_date > now() - interval '5 minute'
    and osh.actual_depart_date is null
      group by
              osh.shipment_header_id
              ,ovt.name
              ,osh.estimate_depart_date
              ,ofg.name
              ,op.name
              ,oc.name
              ,omc.name
              ,osh.is_full_flag
              ,osh.actual_loading_date                            
              ,osh.actual_depart_date                           
      order by osh.estimate_depart_date";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function FindShipment($no_ship)
    {
      $db = $this->load->database('dpostgre',true);
      $sql = "
      select
              osh.shipment_header_id                                                      no_shipment
              ,ovt.name                                                                   jenis_kendaraan
              ,osh.estimate_depart_date                                                   berangkat
              ,osh.estimate_loading_date                                                  loading
              ,ofg.name                                                                   asal_gudang
--              ,CONCAT(op.name,'-',oc.name)                                                tujuan
            ,ooc.name                                                                     cabang
            ,ooc.cabang_id                                                                cabang_id
--              ,op.province_id                                                           province_id
--              ,oc.city_id                                                               city_id
              ,ovt.vehicle_type_id                                                        jk_id
              ,ofg.finish_good_id                                                         fg_id
              --,oct.name                                                                 jenis_muatan
              ,string_agg(distinct CONCAT(osl.quantity,' ',oum.name,' ',ou.name), ', ')   muatan
              ,OSH.is_full_flag                                                           status
      from
              om.om_shipment_header osh
              left join om.om_shipment_line osl on osh.shipment_header_id = osl.shipment_header_id
              left join om.om_vehicle_type ovt on osh.vehicle_type_id = ovt.vehicle_type_id 
              left join om.om_finish_good ofg on osh.shipment_from_fg_id = ofg.finish_good_id
              left join om.om_content_type oct on osl.content_type_id = oct.content_type_id
              left join om.om_uom oum on osl.uom_id = oum.uom_id
              left join om.om_cabang ooc on ooc.cabang_id = osh.shipment_to_cabang_id
              left join om.om_unit ou on osl.unit_id = ou.unit_id
              left join om.om_province op on osh.shipment_to_province_id = op.province_id
              left join om.om_city oc on osh.shipment_to_city_id = oc.city_id  
              $no_ship
      group by
              osh.shipment_header_id
              ,ovt.name
              ,osh.estimate_depart_date
              ,osh.estimate_loading_date
              ,ofg.name
              ,op.name
              ,oc.name
              ,ooc.name 
              ,ooc.cabang_id
--              ,op.province_id
--              ,oc.city_id
              ,ovt.vehicle_type_id 
              ,ofg.finish_good_id
              ,osh.is_full_flag";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
  
    }

    // this down is for the options in New Shipment-----------------------------------------------------------------
    public function getUom()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select uom_id, name from om.om_uom";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     } 
     public function getUnit()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select unit_id, name from om.om_unit";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     } 

     public function getFinishGood()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select finish_good_id fingo, name from om.om_finish_good";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     }

     public function getCabang()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select cabang_id, name from om.om_cabang";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     }

     public function getId()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select shipment_header_id id from om.om_shipment_header";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     }

     public function getJK()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select vehicle_type_id jk, name from om.om_vehicle_type";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     }

      public function getContentId()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select content_type_id content_id, name from om.om_content_type";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     }

     public function getSparepart()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select content_type_id content_id, name from om.om_content_type where content_type_id not in (1,3)";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     }

     public function getUnitSp()
     {
      $db = $this->load->database('dpostgre',true);
      $sql = "select unit_id, name from om.om_unit where unit_id = 0";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
     }

     // untill here!-----------------------------------------------------------------------------

     public function editMPM($no_ship)
      {
        $db = $this->load->database('dpostgre',true);
        $sql = "select
                osh.shipment_header_id                                      no_shipment
                ,ovt.name                                                   jenis_kendaraan
                ,osl.creation_date                                          creation_date
                ,ofg.name                                                   dari_gudang
                ,CONCAT(op.name,'-',oc.name)                                tujuan
                ,oct.name                                                   jenis_muatan
                ,osl.quantity                                               quantity
                ,oum.name                                                   uom
                ,ou.name                                                    nama_unit
                ,oct.content_type_id                                        content_type_id
                ,oum.uom_id                                                 uom_id
                ,ou.unit_id                                                 unit_id
                ,OSH.is_full_flag
                from
                om.om_shipment_header osh
                left join om.om_shipment_line osl on osh.shipment_header_id = osl.shipment_header_id
                left join om.om_vehicle_type ovt on osh.vehicle_type_id = ovt.vehicle_type_id 
                left join om.om_finish_good ofg on osh.shipment_from_fg_id = ofg.finish_good_id
                left join om.om_content_type oct on osl.content_type_id = oct.content_type_id
                left join om.om_uom oum on osl.uom_id = oum.uom_id
                left join om.om_unit ou on osl.unit_id = ou.unit_id
                left join om.om_province op on osh.shipment_to_province_id = op.province_id
                left join om.om_city oc on osh.shipment_to_city_id = oc.city_id
                where osh.shipment_header_id = '$no_ship'";
      $runQuery = $db->query($sql);
      return $runQuery->result_array();
      } 

// -------------------------------------------------------------------------------------------------
       // update header
       public function updateMPM($edd,$eld,$fingo,$status,$cabang,$jk,$usr,$id)
       {
          $db = $this->load->database('dpostgre',true);
          $sql = "UPDATE om.om_shipment_header
                    SET estimate_depart_date = '$edd',
                    estimate_loading_date = '$eld',
                    shipment_from_fg_id = '$fingo',
                    is_full_flag = '$status',
                    shipment_to_cabang_id = '$cabang',
                    vehicle_type_id = '$jk',
                    creation_date = now(),
                    created_by = '$usr'
                    WHERE  shipment_header_id = '$id'";
        $runQuery = $db->query($sql);
         // echo $sql;
       }

       public function deleteMPM($id)
       {
         $db = $this->load->database('dpostgre',true);
         $sql = "DELETE 
                    FROM om.om_shipment_line
                    WHERE shipment_header_id = '$id'";
        $runQuery = $db->query($sql);
       }

       public function UpdatebyInsertMPM($noShip,$content,$jumlah,$tipe,$unit,$user)
       {
        $db = $this->load->database('dpostgre',true);
        $sql = "insert into om.om_shipment_line (creation_date, shipment_header_id, content_type_id, 
                quantity, uom_id, unit_id, created_by)
                values (now(), $noShip, $content, $jumlah, $tipe, $unit, '$user')";
        $runQuery = $db->query($sql);
        // echo $sql;
       }
    
         
}

?>