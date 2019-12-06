
<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_shipmentmonitoringgudang extends CI_Model
{
  var $oracle;
  // function __construct()
  // {
  //   parent::__construct();
  //   $this->load->database();
  //     $this->load->library('encrypt');
  //     // $this->oracle = $this->load->database('oracle', true);
  //  }

  function __construct()
{
    parent::__construct();
    $this->load->database();
          $this->load->library('encrypt');
          // $this->oracle = $this->load->database('oracle', true);
      // $this->db = $this->load->database();
//   $this->personalia = $this->load->database('personalia', true);
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
      $sql =  "
              SELECT 
              sh.shipment_header_id no_shipment,
              ev.vehicle_name jenis_kendaraan,
              sh.estimate_depart_date berangkat,
              sh.estimate_loading_date loading,
              CONCAT('PROVINSI ', pv.province_name,'-', ct.city_name) tujuan,
              string_agg(distinct CONCAT(sl.quantity,' ', go.goods_name), ', ') muatan,
              sum(sl.quantity) q,
              sum(sl.delivered_quantity) dq,
              sf.name asal_gudang,
              ec.nama_cabang cabang,
              ec.cabang_id cabang_id,
              pv.province_id province_id,
              ct.city_id city_id,
              ev.vehicle_id jk_id,
              sh.is_full_flag status,
              sh.created_by created_by,
              sh.actual_loading_date actual_loading,
              sh.actual_depart_date actual_berangkat,
              sh.pr_number pr,
              sh.pr_line_number prl,
              sh.creation_date,
              sh.full_percentage,
              hima.no_do
              FROM 
              ex.shipment_header sh left join ex.vehicle ev
              on sh.vehicle_type_id = ev.vehicle_id
              left join ex.ship_from sf
              on sh.ship_from_id = sf.ship_from_id
              left join ex.cabang ec
              on sh.ship_to_cabang_id = ec.cabang_id
              left join ex.province pv
              on sh.ship_to_province_id = pv.province_id 
              left join ex.city ct
              on sh.ship_to_city_id = ct.city_id
              left join ex.shipment_line sl
              on sh.shipment_header_id = sl.shipment_header_id
              join ex.goods go
              on sl.goods_id = go.goods_id
              join (SELECT SHIPMENT_HEADER_ID ,array_to_string(array_agg(no_do), ', '::text) AS no_do
                         FROM ex.shipment_line
                     group by SHIPMENT_HEADER_ID) hima on sh.shipment_header_id = hima.shipment_header_id
              where sh.actual_loading_date is null 
              -- and sh.estimate_depart_date > now()
              GROUP BY
              sh.shipment_header_id
              , ev.vehicle_name
              , sh.estimate_depart_date
              , sh.estimate_loading_date
              , pv.province_id
              , ct.city_name
              , sf.name
              , ec.nama_cabang
              , ec.cabang_id
              , ec.cabang_id
              , pv.province_id
              , ct.city_id
              , ev.vehicle_id
              , sh.is_full_flag
              , sh.created_by
              , pv.province_name
              , sh.actual_loading_date 
              , sh.actual_depart_date 
              , sh.pr_number 
              , sh.pr_line_number
              , sh.creation_date
              , sh.full_percentage
              , hima.no_do
              order by sh.estimate_depart_date";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getDetailPRQuery($nopr,$linepr)
    {
        $oracle = $this->load->database('oracle',true);
        $query = "select
                  pha.SEGMENT1 NOMOR_PO
                  ,pla.LINE_NUM LINE_PO
                  ,pv.VENDOR_NAME
                  ,pla.ITEM_DESCRIPTION
                  ,pla.UNIT_PRICE
                  from
                  PO_REQUISITION_LINES_ALL prla
                  ,PO_REQUISITION_HEADERS_ALL prha
                  ,PO_REQ_DISTRIBUTIONS_ALL prda
                  ,PO_DISTRIBUTIONS_ALL pda
                  ,PO_HEADERS_ALL pha
                  ,PO_LINES_ALL pla
                  ,PO_VENDORS pv
                  where
                  prha.REQUISITION_HEADER_ID = prla.REQUISITION_HEADER_ID
                  and prla.REQUISITION_LINE_ID = prda.REQUISITION_LINE_ID(+)
                  and prda.DISTRIBUTION_ID = pda.REQ_DISTRIBUTION_ID(+)
                  and pda.PO_HEADER_ID = pha.PO_HEADER_ID(+)
                  and pda.PO_LINE_ID = pla.PO_LINE_ID(+)
                  and pha.VENDOR_ID = pv.VENDOR_ID(+)
                  and prha.SEGMENT1 = $nopr 
                  and prla.LINE_NUM = $linepr ";
        $runQuery = $oracle->query($query);
        return $runQuery->result_array();
    }

    public function detailCabang($id_cabang)
    {
       $db = $this->load->database();
       $sql = "select  
               ec.province_id, 
               ec.city_id, 
               ect.city_name, 
               ep.province_name, 
               ec.address
             from ex.cabang ec
              left join ex.province ep on ep.province_id = ec.province_id
              left join ex.city ect on ect.city_id = ec.city_id
             where cabang_id = $id_cabang";
       $runQuery = $this->db->query($sql);
        return $runQuery->result_array();

    }

    public function selectValueOfMe()
    {
       $db = $this->load->database();
       $sql = "select distinct 
              eg.entrusted_id, 
              eg.goods_id,
              ed.goods_name,
              eg.quantity, 
              eg.creation_date, 
              eg.ship_to_cabang_id,
              eb.nama_cabang,
              eg.ship_to_province_id,
              ep.province_name,
              eg.ship_to_city_id,
              ec.city_name,
              eg.ship_to_address,
              eb.address,
              eg.warehouse_id,
              es.name nama_gudang,
              eg.accepted_quantity,
              eg.delivered_quantity
              from ex.entrusted_goods eg
              left join ex.city ec on eg.ship_to_city_id = ec.city_id
              left join ex.province ep on eg.ship_to_province_id = ep.province_id
              left join ex.cabang eb on eg.ship_to_cabang_id = eb.cabang_id
              left join ex.ship_from es on eg.warehouse_id = es.ship_from_id
              left join ex.goods ed on eg.goods_id = ed.goods_id
              where eg.delivered_quantity is null
              group by 
              eg.entrusted_id, 
              eg.goods_id, 
              eg.quantity, 
              eg.creation_date, 
              eg.ship_to_cabang_id,
              eb.nama_cabang,
              eg.ship_to_province_id,
              ep.province_name,
              eg.ship_to_city_id,
              ec.city_name,
              eg.ship_to_address,
              eb.address,
              eg.warehouse_id,
              es.name,
              eg.accepted_quantity,
              ed.goods_name,
              eg.delivered_quantity";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function UpdateDong($ent_id,$jumlah_gdg)
    {  $db = $this->load->database();
       $sql = "update ex.entrusted_goods set accepted_quantity = $jumlah_gdg where entrusted_id = $ent_id";
       $runQuery = $this->db->query($sql);
    }

    public function UpdateDong2($ent_id,$jumlah_gdg)
    {  $db = $this->load->database();
       $sql = "update ex.entrusted_goods set delivered_quantity = $jumlah_gdg where entrusted_id = $ent_id";
       $runQuery = $this->db->query($sql);
    }

    public function undelivered()
    {
     $db = $this->load->database();
     $sql = "SELECT 
              sh.shipment_header_id no_shipment,
              ev.vehicle_name jenis_kendaraan,
              sh.estimate_depart_date berangkat,
              sh.estimate_loading_date loading,
              CONCAT('PROVINSI ', pv.province_name,'-', ct.city_name) tujuan,
              string_agg(distinct CONCAT(sl.quantity,' ', go.goods_name), ', ') muatan,
              sum(sl.quantity) q,
              sum(sl.delivered_quantity) dq,
              sf.name asal_gudang,
              ec.nama_cabang cabang,
              ec.cabang_id cabang_id,
              pv.province_id province_id,
              ct.city_id city_id,
              ev.vehicle_id jk_id,
              sh.is_full_flag status,
              sh.created_by created_by,
              sh.actual_loading_date actual_loading,
              sh.actual_depart_date actual_berangkat,
              sh.pr_number pr,
              sh.pr_line_number prl,
              sh.creation_date,
              sh.full_percentage,
              aa.no_do
              FROM 
              ex.shipment_header sh left join ex.vehicle ev
              on sh.vehicle_type_id = ev.vehicle_id
              left join ex.ship_from sf
              on sh.ship_from_id = sf.ship_from_id
              left join ex.cabang ec
              on sh.ship_to_cabang_id = ec.cabang_id
              left join ex.province pv
              on sh.ship_to_province_id = pv.province_id 
              left join ex.city ct
              on sh.ship_to_city_id = ct.city_id
              left join ex.shipment_line sl
              on sh.shipment_header_id = sl.shipment_header_id
              join ex.goods go
              on sl.goods_id = go.goods_id
                join (SELECT SHIPMENT_HEADER_ID ,array_to_string(array_agg(no_do), ', '::text) AS no_do
                         FROM ex.shipment_line
                     group by SHIPMENT_HEADER_ID) aa on sh.shipment_header_id = aa.shipment_header_id
              -- where sl.delivered_quantity < sl.quantity
              -- or sl.delivered_quantity IS NULL
--              where sh.estimate_depart_date > now() - interval '1 day'
--              and sh.actual_loading_date is null
              GROUP BY
              sh.shipment_header_id
              , ev.vehicle_name
              , sh.estimate_depart_date
              , sh.estimate_loading_date
              , pv.province_id
              , ct.city_name
              , sf.name
              , ec.nama_cabang
              , ec.cabang_id
              , ec.cabang_id
              , pv.province_id
              , ct.city_id
              , ev.vehicle_id
              , sh.is_full_flag
              , sh.created_by
              , pv.province_name
              , sh.actual_loading_date 
              , sh.actual_depart_date 
              , sh.pr_number 
              , sh.pr_line_number
              , sh.creation_date
              , sh.full_percentage
              , aa.no_do";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function FindShipment($no_ship)
    {
      $db = $this->load->database();
      $sql = "SELECT 
              sh.shipment_header_id no_shipment,
              ev.vehicle_name jenis_kendaraan,
              sh.estimate_depart_date berangkat,
              sh.estimate_loading_date loading,
              CONCAT('PROVINSI ', pv.province_name,' - ', ct.city_name) tujuan,
              string_agg(distinct CONCAT(sl.quantity,' ', go.goods_name), ', ') muatan,
              sf.name asal_gudang,
              sf.ship_from_id fg_id,
              ec.nama_cabang cabang,
              ec.cabang_id cabang_id,
              pv.province_id province_id,
              ct.city_id city_id,
              ev.vehicle_id jk_id,
              sh.is_full_flag status,
              sh.created_by created_by,
              sh.actual_loading_date actual_loading,
              sh.actual_depart_date actual_berangkat,
              sh.pr_number pr,
              sh.pr_line_number prl,
              sh.ship_to_address alamat,
              sh.full_percentage persentase,
              ev.volume_cm3 volume,
              sh.full_percentage persentase,
              aa.no_do,
              sh.nama_driver,
              sh.plat_kendaraan
              FROM 
              ex.shipment_header sh left join ex.vehicle ev
              on sh.vehicle_type_id = ev.vehicle_id
              left join ex.ship_from sf
              on sh.ship_from_id = sf.ship_from_id
              left join ex.cabang ec
              on sh.ship_to_cabang_id = ec.cabang_id
              left join ex.province pv
              on sh.ship_to_province_id = pv.province_id 
              left join ex.city ct
              on sh.ship_to_city_id = ct.city_id
              left join ex.shipment_line sl
              on sh.shipment_header_id = sl.shipment_header_id
              join ex.goods go
              on sl.goods_id = go.goods_id
              join (SELECT SHIPMENT_HEADER_ID ,array_to_string(array_agg(no_do), ', '::text) AS no_do
                         FROM ex.shipment_line
                     group by SHIPMENT_HEADER_ID) aa on sh.shipment_header_id = aa.shipment_header_id
              $no_ship
              GROUP BY
              sh.shipment_header_id
              , ev.vehicle_name
              , sh.pr_line_number
              , sh.estimate_depart_date
              , sh.estimate_loading_date
              , pv.province_id
              , ct.city_name
              , sf.name
              , ec.nama_cabang
              , ec.cabang_id
              , ec.cabang_id
              , pv.province_name 
              , ct.city_id
              , ev.vehicle_id
              , sh.is_full_flag
              , sh.created_by
              , sh.actual_loading_date
              , sh.actual_depart_date
              , sh.pr_number
              , sh.ship_to_address
              , sf.ship_from_id
              , sh.full_percentage
              , ev.volume_cm3
              , sh.full_percentage
              , aa.no_do
              , sh.nama_driver
              , sh.plat_kendaraan
      ";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
  
    }

    // public function getDetailPRQuery($nopr,$linepr)
    // {
    //     $oracle = $this->load->database('oracle',true);
    //     $query = "select
    //               pha.SEGMENT1 NOMOR_PO
    //               ,pla.LINE_NUM LINE_PO
    //               ,pv.VENDOR_NAME
    //               ,pla.ITEM_DESCRIPTION
    //               ,pla.UNIT_PRICE
    //               from
    //               PO_REQUISITION_LINES_ALL prla
    //               ,PO_REQUISITION_HEADERS_ALL prha
    //               ,PO_REQ_DISTRIBUTIONS_ALL prda
    //               ,PO_DISTRIBUTIONS_ALL pda
    //               ,PO_HEADERS_ALL pha
    //               ,PO_LINES_ALL pla
    //               ,PO_VENDORS pv
    //               where
    //               prha.REQUISITION_HEADER_ID = prla.REQUISITION_HEADER_ID
    //               and prla.REQUISITION_LINE_ID = prda.REQUISITION_LINE_ID(+)
    //               and prda.DISTRIBUTION_ID = pda.REQ_DISTRIBUTION_ID(+)
    //               and pda.PO_HEADER_ID = pha.PO_HEADER_ID(+)
    //               and pda.PO_LINE_ID = pla.PO_LINE_ID(+)
    //               and pha.VENDOR_ID = pv.VENDOR_ID(+)
    //               and prha.SEGMENT1 = $nopr 
    //               and prla.LINE_NUM = $linepr ";
    //     $runQuery = $oracle->query($query);
    //     return $runQuery->result_array();
    // }

    // this down is for the options in New Shipment-----------------------------------------------------------------
    public function getUom()
     {
      $db = $this->load->database();
      $sql = "select uom_id, name from om.om_uom";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     } 
     public function getGoods($id)//done setup
     {
      $db = $this->load->database();
      $sql = "select goods_id, goods_name, volume_cm3 from ex.goods where goods_id = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     } 

     public function getUnitEdit()
     {
      $db = $this->load->database();
      $sql = "select * from om.om_unit";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     } 

     public function getFinishGood()//-------------------------done mawank
     {
      $db = $this->load->database();
      $sql = "select ship_from_id fg_id, name fg_name from ex.ship_from";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getProvince()//------------done
     {
      $db = $this->load->database();
      $sql = "select province_id prov_id, province_name prov_name from ex.province";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getKotaSmua()
     {
      $db = $this->load->database();
      $sql = "select city_id, province_id, city_name from ex.city";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getGoodss()
     {
      $db = $this->load->database();
      $sql = "select goods_id, goods_name, volume_cm3 from ex.goods";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getKota($prov)//------------done
     {
      $db = $this->load->database();
      $sql = "select city_id, province_id, city_name from ex.city where province_id = $prov";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getKotaCbg($prov)//------------done
     {
      $db = $this->load->database();
      $sql = "select city_id, province_id, city_name from ex.city where province_id = $prov";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getCityAll()
     {
      $db = $this->load->database();
      $sql = "select city_id, province_id, city_name from ex.city";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getCabang() //done
     {
      $db = $this->load->database();
      $sql = "select cabang_id, nama_cabang from ex.cabang";
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

     public function getJK() //--------------------------done-----------------------
     {
      $db = $this->load->database();
      $sql = "select vehicle_id, vehicle_name, volume_cm3 muatan from ex.vehicle";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getVolumee($id)
     {
      $db = $this->load->database();
      $sql = "select volume_cm3 from ex.vehicle where vehicle_id = $id ";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getUnitVol($id)
     {
      $db = $this->load->database();
      $sql = "select volume_cm3 from ex.goods where goods_id = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

      public function getContentId()
     {
      $db = $this->load->database();
      $sql = "select content_type_id content_id, name from om.om_content_type where content_type_id in (1,3)";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
     }

     public function getContentIdEdit()
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
              sh.shipment_header_id,
              sl.delivered_quantity,
              sl.goods_id,
              sl.quantity,
              sl.shipment_line_id,
              sl.creation_date,
              sl.created_by,
              sl.volume_goods,
              sl.volume_percentage,
              sl.no_do
              from ex.shipment_line sl
              join ex.shipment_header sh on sh.shipment_header_id = sl.shipment_header_id
              $no_ship";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
      } 

// proses saving MPM ada di sini bruh --------------------------------------------------

      public function saveInsertHeader2($estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$usrname,$kota,$provinsih,$alamat,$pr_number,$pr_line,$precentage)
      {
        $db = $this->load->database(); //done
        $sql = "insert into ex.shipment_header 
                      (estimate_depart_date,
                      estimate_loading_date,
                      ship_from_id,
                      is_full_flag,
                      ship_to_cabang_id,
                      vehicle_type_id,   
                      creation_date,
                      created_by,
                      ship_to_city_id,
                      ship_to_province_id,
                      ship_to_address,
                      pr_number,
                      pr_line_number,
                      full_percentage
                      ) 
                values ('$estimasi', 
                      '$estimasi_loading',
                      '$finish_good',
                      '$status',
                      '$cabang',  
                      '$kendaraan',
                      now(),
                      '$usrname',
                      '$kota',
                      '$provinsih',
                      '$alamat',
                      '$pr_number',
                      '$pr_line',
                      '$precentage')";
        // echo $sql;
        $runQuery = $this->db->query($sql);
      }

      public function getShipmentHeader()//done
       {
        $db = $this->load->database();
        $sql = "select max (shipment_header_id) id from ex.shipment_header";
        // echo $sql;
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();

       } 

       public function saveInsertLines($id,$unit,$jumlah,$usrname,$percentage_line,$volume_line)//done
       {
        $db = $this->load->database();
        $sql = "insert into ex.shipment_line 
                (creation_date, 
                shipment_header_id, 
                goods_id, 
                quantity,
                created_by,
                volume_goods,
                volume_percentage)
          values (now(), 
                '$id', 
                '$unit', 
                '$jumlah', 
                '$usrname',
                '$volume_line',
                '$percentage_line')";
                echo $sql;
        $runQuery = $this->db->query($sql);
       }
// -------------------------------------------------------------------------------------------------
       // update header
       public function updateheaderSMS($no_ship,$usrname,$estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$full_persen,$alamat,$provinsi,$koota,$pr_numb,$pr_linee,$actual_loading,$actual_berangkat,$driver,$plat)
       {
          $db = $this->load->database();
          $sql = "
                update 
                  ex.shipment_header 
                set 
                  created_by = '$usrname',
                  estimate_depart_date = '$estimasi',
                  estimate_loading_date = '$estimasi_loading',
                  ship_from_id = '$finish_good',
                  is_full_flag = '$status',
                  ship_to_cabang_id = '$cabang',
                  vehicle_type_id = '$kendaraan',
                  full_percentage = '$full_persen',
                  ship_to_address = '$alamat',
                  ship_to_province_id = '$provinsi',
                  ship_to_city_id = '$koota',
                  pr_number = '$pr_numb',
                  pr_line_number = '$pr_linee',
                  actual_loading_date = '$actual_loading',
                  actual_depart_date = '$actual_berangkat',
                  nama_driver = '$driver',
                  plat_kendaraan = '$plat'
                  where shipment_header_id = $no_ship";
        $runQuery = $this->db->query($sql);
                  // echo $sql;
       }

       public function deleteSMS($id)
       {
         $db = $this->load->database();
         $sql = "DELETE 
                    FROM ex.shipment_line
                    WHERE shipment_header_id = '$id'";
        $runQuery = $this->db->query($sql);
                  // echo $sql;

       }

       public function UpdatebyInsertSMS($no_ship,$jumlah,$unit,$jumlahvol,$pers_vol,$jml_terkirim,$usrname,$no_do)
       {
        $db = $this->load->database();
        $sql = "insert into ex.shipment_line 
                      (goods_id, quantity, creation_date, created_by, shipment_header_id, delivered_quantity, volume_goods, volume_percentage,no_do)
                values ('$unit', '$jumlah', now(), '$usrname', '$no_ship', '$jml_terkirim', '$jumlahvol', '$pers_vol', '$no_do')";
        $runQuery = $this->db->query($sql);
                  // echo $sql;
                
       }
// -----------------------setup----------------------------------------------------------------------------------------------
      public function SaveKota($kota,$id)
      {
        $db = $this->load->database();
        $sql = "insert into om.om_city (name, province_id) values ('$kota', '$id')";
        $runQuery = $this->db->query($sql);
        $sql2 = "delete from om.om_city where province_id = '0'";
        $runQuery = $this->db->query($sql2);

      }

      public function SaveProv($prov)
      {
        $db = $this->load->database();
        $sql = "insert into om.om_province (name) values ('$prov')";
        $runQuery = $this->db->query($sql);
      }

      public function SaveJK($jk)
      {
        $db = $this->load->database();
        $sql = "insert into om.om_vehicle_type (name) values ('$jk')";
        $runQuery = $this->db->query($sql);
      }

       public function SaveUnit($gn,$vg)//done
      {
        $db = $this->load->database();
        $sql = "insert into ex.goods (goods_name, volume_cm3) values ('$gn', $vg)";
        $runQuery = $this->db->query($sql);
      }

      
    public function InsertCabangName($cabangname,$id_prov,$id_kota,$alamatcabang)//done
    {
        $db = $this->load->database();
        $sql = "insert into ex.cabang (nama_cabang, province_id, city_id, address) values ('$cabangname', '$id_prov', '$id_kota', '$alamatcabang')";
        $runQuery = $this->db->query($sql);
    }

    public function UpdateCabangKuy($id,$alamat,$kota,$provinsi,$namacabang)
    {
        $db = $this->load->database();
        $sql = "update ex.cabang set 
                nama_cabang = '$namacabang', 
                province_id = '$provinsi', 
                city_id = '$kota', 
                address = '$alamat' 
                where cabang_id = $id";
        $runQuery = $this->db->query($sql);
        return $sql;
    }

    public function SetupCabang()//done
     {
        $db = $this->load->database();
        $sql = "select ec.cabang_id cabang_id, 
                  ec.nama_cabang nama_cabang, 
                  ec.province_id province_id,
                  ec.city_id city_id,
                  ep.province_name province_name, 
                  ect.city_name city_name, 
                  ec.address 
              from ex.cabang ec
              left join ex.province ep on ec.province_id = ep.province_id
              left join ex.city ect on ec.city_id = ect.city_id
              group by ec.cabang_id, 
                  ec.nama_cabang, 
                  ep.province_name, 
                  ect.city_name, 
                  ec.address,
                  ec.province_id,
                  ec.city_id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
     } 

     public function caricabang($id)//done
     {
        $db = $this->load->database();
        $sql = "select ec.cabang_id cabang_id, 
                  ec.nama_cabang nama_cabang, 
                  ec.province_id province_id,
                  ec.city_id city_id,
                  ep.province_name province_name, 
                  ect.city_name city_name, 
                  ec.address 
              from ex.cabang ec
              left join ex.province ep on ec.province_id = ep.province_id
              left join ex.city ect on ec.city_id = ect.city_id
              where cabang_id = $id
              group by ec.cabang_id, 
                  ec.nama_cabang, 
                  ep.province_name, 
                  ect.city_name, 
                  ec.address,
                  ec.province_id,
                  ec.city_id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
     }
     public function deleteRoow($iddaw)//done
     {
        $db = $this->load->database();
        $sql = "delete from ex.goods where goods_id = '$iddaw'";
        $runQuery = $this->db->query($sql);
     }

     public function deleteCabang($id)
     {
        $db = $this->load->database();
        $sql = "delete from ex.cabang where cabang_id = '$id'";
        $runQuery = $this->db->query($sql);
     }

     public function editRow($id,$alamat,$nama)
     {
        $db = $this->load->database();
        $sql = "update om.om_cabang set name = '$nama', alamat = '$alamat' where cabang_id = $id";
        // echo $sql;
        $runQuery = $this->db->query($sql);
     }
    public function setupvehicle() //done
    {   $db = $this->load->database();
        $sql = " select vehicle_id, vehicle_name, volume_cm3 from ex.vehicle";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function setupUnit()//done
    {
        $db = $this->load->database();
        $sql = "select goods_id, goods_name, volume_cm3 from ex.goods";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function deleteRowUnit($id)
    {
        $db = $this->load->database();
        $sql = "delete from om.om_unit where unit_id = $id";
        $runQuery = $this->db->query($sql);
    }

     public function deleteVehicleSMS($id)
    {
        $db = $this->load->database();
        $sql = "delete from ex.vehicle where vehicle_id = $id";
        $runQuery = $this->db->query($sql);
    }

    public function SaveKendaraan($vol, $name)//done
    {
        $db = $this->load->database();
        $sql = "insert into ex.vehicle (vehicle_name, volume_cm3) values ('$name', $vol)";
        $runQuery = $this->db->query($sql);
    }

    public function UpdateVehicle($id,$name,$volume)//done
    {
        $db = $this->load->database();
        $sql = "update ex.vehicle set vehicle_name = '$name', volume_cm3 = $volume where vehicle_id = $id";
        $runQuery = $this->db->query($sql);
    }


    public function saveGoods($id,$name,$vol)//done
    {
        $db = $this->load->database();
        $sql = "update ex.goods set goods_name = '$name', volume_cm3 = $vol where goods_id = $id";
        $runQuery = $this->db->query($sql);
    }

    public function getVehicle($id)//done
    {
        $db = $this->load->database();
        $sql = " select vehicle_id, vehicle_name, volume_cm3 from ex.vehicle where vehicle_id = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getGood()//done
    {
        $db = $this->load->database();
        $sql = "select goods_id, goods_name from ex.goods";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getGood2()//done
    {
        $db = $this->load->database();
        $sql = "select goods_id, goods_name from ex.goods";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function hapusShipment($id)
    {
        $db = $this->load->database();
        $sql = "delete from om.om_shipment_header where shipment_header_id = '$id'";
        $runQuery = $this->db->query($sql);
        $sql2 = "delete from om.om_shipment_line where shipment_header_id = '$id'";
        $runQuery = $this->db->query($sql2);
    }

    public function history()
    {
      $db = $this->load->database();
      $sql = "
           SELECT 
              sh.shipment_header_id no_shipment,
              ev.vehicle_name jenis_kendaraan,
              sh.estimate_depart_date berangkat,
              sh.estimate_loading_date loading,
              CONCAT('PROVINSI ', pv.province_name,'-', ct.city_name) tujuan,
              string_agg(distinct CONCAT(sl.quantity,' ', go.goods_name), ', ') muatan,
              sf.name asal_gudang,
              ec.nama_cabang cabang,
              ec.cabang_id cabang_id,
              pv.province_id province_id,
              ct.city_id city_id,
              ev.vehicle_id jk_id,
              sh.is_full_flag status,
              sh.created_by created_by,
              sh.actual_loading_date actual_loading,
              sh.actual_depart_date actual_berangkat,
              sh.pr_number pr,
              sh.creation_date creation_date,
              aa.no_do
              FROM 
              ex.shipment_header sh left join ex.vehicle ev
              on sh.vehicle_type_id = ev.vehicle_id
              left join ex.ship_from sf
              on sh.ship_from_id = sf.ship_from_id
              left join ex.cabang ec
              on sh.ship_to_cabang_id = ec.cabang_id
              left join ex.province pv
              on sh.ship_to_province_id = pv.province_id 
              left join ex.city ct
              on sh.ship_to_city_id = ct.city_id
              left join ex.shipment_line sl
              on sh.shipment_header_id = sl.shipment_header_id
              join ex.goods go
              on sl.goods_id = go.goods_id
              join (SELECT SHIPMENT_HEADER_ID ,array_to_string(array_agg(no_do), ', '::text) AS no_do
                         FROM ex.shipment_line
                     group by SHIPMENT_HEADER_ID) aa on sh.shipment_header_id = aa.shipment_header_id
              GROUP BY
              sh.shipment_header_id
              , ev.vehicle_name
              , sh.estimate_depart_date
              , sh.estimate_loading_date
              , pv.province_name
              , ct.city_name
              , sf.name
              , ec.nama_cabang
              , ec.cabang_id
              , ec.cabang_id
              , pv.province_id 
              , ct.city_id
              , ev.vehicle_id
              , sh.is_full_flag
              , sh.created_by
              , sh.actual_loading_date
              , sh.actual_depart_date
              , sh.pr_number
              , sh.creation_date
              , aa.no_do";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
      
    }

    public function getProvinsii()
    {
        $db = $this->load->database();
        $sql = "select province_id, name from om.om_province";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }
     public function getCity()
    {
        $db = $this->load->database();
        $sql = "select city_id, name, province_id from om.om_city";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

}

?>