
<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_monitoringpengirimangudang extends CI_Model
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
      $db = $this->load->database();
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
    and osh.actual_loading_date is null
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
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function FindShipment($no_ship)
    {
      $db = $this->load->database();
      $sql = "
        select
              osh.shipment_header_id                                                      no_shipment
              ,ovt.name                                                                   jenis_kendaraan
              ,osh.estimate_depart_date                                                   berangkat
              ,osh.estimate_loading_date                                                  loading
              ,ofg.name                                                                   asal_gudang
--              ,CONCAT(op.name,'-',oc.name)                                              tujuan
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
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
  
    }

    // this down is for the options in New Shipment-----------------------------------------------------------------
    public function getUom()
     {
      $db = $this->load->database();
      $sql = "select uom_id, name from om.om_uom";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     } 
     public function getUnit()
     {
      $db = $this->load->database();
      $sql = "select unit_id, name from om.om_unit";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     } 

     public function getFinishGood()
     {
      $db = $this->load->database();
      $sql = "select finish_good_id fingo, name from om.om_finish_good";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getProvince()
     {
      $db = $this->load->database();
      $sql = "select province_id, name from om.om_province";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getCabang()
     {
      $db = $this->load->database();
      $sql = "select cabang_id, name from om.om_cabang";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getId()
     {
      $db = $this->load->database();
      $sql = "select shipment_header_id id from om.om_shipment_header";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getJK()
     {
      $db = $this->load->database();
      $sql = "select vehicle_type_id jk, name from om.om_vehicle_type";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

      public function getContentId()
     {
      $db = $this->load->database();
      $sql = "select content_type_id content_id, name from om.om_content_type";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     // untill here!-----------------------------------------------------------------------------

     public function editMPM($no_ship)
      {
        $db = $this->load->database();
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
          // echo $sql;exit();
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
      } 

      public function insertActualTime($id,$load,$status)
      {
        $db = $this->load->database();
        $sql = "UPDATE om.om_shipment_header
                SET 
                actual_loading_date = '$load',
                is_full_flag = '$status'
                WHERE  shipment_header_id = '$id'";
        $runQuery = $this->db->query($sql);
      }

      public function timegudang($id)
      {
        $db = $this->load->database();
        $sql = "select actual_loading_date, actual_depart_date from om.om_shipment_header where shipment_header_id = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
      }
      
    
         
}

?>