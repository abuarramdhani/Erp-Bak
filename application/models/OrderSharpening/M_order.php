<?php
class M_order extends CI_Model {

  var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->oracle = $this->load->database('oracle', true);
        $this->oracle_dev = $this->load->database('oracle_dev',TRUE);
    }

    public function getItem()
    {
    	$sql = "SELECT DISTINCT msib.SEGMENT1
    				  ,msib.DESCRIPTION 
    			  FROM mtl_system_items_b msib
				 WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
				   AND msib.SEGMENT1 like '%-T'";

      $query = $this->oracle_dev->query($sql);
      return $query->result_array();
    }

    public function getDeskripsi($param)
    {

    	$sql = "SELECT DISTINCT msib.DESCRIPTION 
    			  FROM mtl_system_items_b msib
				 WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
				   AND msib.SEGMENT1 like '%-T'
				   AND msib.SEGMENT1 = '$param'";

      $query = $this->oracle_dev->query($sql);
      return $query->result_array();
    }

    public function getLocator($subinv)
    {

      $sql = "SELECT mil.INVENTORY_LOCATION_ID, mil.SEGMENT1
  FROM mtl_item_locations mil
 WHERE mil.subinventory_code like '$subinv'
  -- AND mil.DESCRIPTION LIKE '%UMUM%'
  ";

      $query = $this->oracle_dev->query($sql);
      return $query->result_array();
    }

    public function cekNomor($no_order)
    {
      $sql = "SELECT * 
                FROM osp.osp_order_sharpening_dev
               WHERE no_order = '$no_order'";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekId ($idunix)
    {
      $sql = "SELECT * 
                FROM osp.osp_order_sharpening_dev
               WHERE idunix = '$idunix'";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getNomorOrder($idunix)
    {
      $sql = "SELECT *
              FROM osp.osp_order_sharpening_dev
              WHERE idunix = '$idunix'";
      $query = $this->db->query($sql);
      return $query->result_array();

    }

    public function cekOrderNumber($reff_number)
    {
      $sql = "SELECT * 
                FROM osp.osp_order_sharpening_dev
               WHERE reff_number = '$reff_number'";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function Insert($no_order,$item,$deskripsi,$qty,$tgl_order,$reff_number,$idunix,$subinv,$locator)
    
    {
      $sql = "INSERT INTO osp.osp_order_sharpening_dev (no_order,kode_barang,deskripsi_barang,qty,tgl_order,reff_number,idunix,subinv,locator)
          VALUES ('$no_order','$item','$deskripsi','$qty','$tgl_order','$reff_number','$idunix','$subinv','$locator')";
      $query = $this->db->query($sql);
    }

//-----------------------ANDROID START CODE----------------------------------------

    public function getAllData()
    {
      $sql = "SELECT * FROM osp.osp_order_sharpening_dev";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function hapusData($no_order) //-------------------------> Tidak Terpakai dalam Program
    {
      $sql = "DELETE FROM osp.osp_order_sharpening_dev WHERE no_order = '$no_order' ";
      $query = $this->db->query($sql);
      return $this->db->affected_rows();
    }

    public function injectData() //--------------------------------> Masih Alfa. Kelak dipakai, kayaknya
    {
      $sql = "INSERT INTO osp.osp_order_sharpening_dev (no_order,reff_number,kode_barang,qty) VALUES ('$no_order','$reff_number','$kode_barang','$qty')";
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function getInfo($param)
    {
      $sql = "SELECT msib.SEGMENT1, msib.DESCRIPTION, mtrl.QUANTITY, mtrl.LINE_STATUS 
              FROM mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl, mtl_system_items_b msib
              WHERE mtrh.HEADER_ID= mtrl.HEADER_ID 
              AND mtrh.REQUEST_NUMBER = '$param'
              AND mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
              AND msib.ORGANIZATION_ID = mtrh.ORGANIZATION_ID";
      $query = $this->oracle_dev->query($sql);
      return $query->result_array();
    }

//-----------------------START CODE----------------------------------------

    public function getAvailability($no_order)
    {
      $sql = "SELECT * FROM osp.osp_order_sharpening_dev WHERE osp.osp_order_sharpening_dev.no_order = '$no_order'";
      $query = $this->db->query($sql);
      return $query->num_rows();
    }

    public function getInventoryID($item)
    {
      $sql = "SELECT msib.INVENTORY_ITEM_ID FROM mtl_system_items_b msib
              WHERE msib.SEGMENT1 = '$item'";

      $query = $this->oracle_dev->query($sql);
      return $query->row_array();
    }

    public function getUom($item)
    {
      $sql = "SELECT msib.PRIMARY_UOM_CODE FROM mtl_system_items_b msib
              WHERE msib.SEGMENT1 = '$item'";

      $query = $this->oracle_dev->query($sql);
      return $query->row_array();
    }

    public function getRequestNumber($reff_number)
    {
      $sql = "SELECT mtrh.REQUEST_NUMBER FROM mtl_txn_request_headers mtrh
              WHERE mtrh.ATTRIBUTE1 = '$reff_number'";
      $query = $this->oracle_dev->query($sql);
      return $query->row_array();
    }

    public function getReffNumber($param)
    {
      $sql = "SELECT osp.osp_order_sharpening_dev.reff_number FROM osp.osp_order_sharpening_dev WHERE no_order = '$param'";
      $query = $this->db->query($sql);
      return $query->row_array();
    }

    public function getTranNumber($param)
    {
      $sql = "SELECT mtrh.REQUEST_NUMBER from mtl_txn_request_headers mtrh
              WHERE mtrh.ATTRIBUTE1 = $param";

      $query = $this->oracle_dev->query($sql);
      return $query->row_array();
      // return $sql;
    }

    public function getTransact($param)
    {
      $sql = "SELECT mtrh.REQUEST_NUMBER, mtrl.INVENTORY_ITEM_ID from mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl
              WHERE mtrh.ATTRIBUTE1 = '$param'
              and mtrl.HEADER_ID = mtrh.HEADER_ID";

      $query = $this->oracle_dev->query($sql);
      return $query->result_array();
    }

    public function getStatusTran($param)
    {
      $sql = "SELECT mtrl.line_status 
      FROM mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl, mtl_material_transactions mmts 
      WHERE mtrh.header_id = mtrl.header_id
         AND mtrh.organization_id = mtrl.organization_id
         AND mtrl.line_id = mmts.move_order_line_id
         AND mtrh.request_number = '$param'";

      $query = $this->oracle_dev->query($sql);
      return $query->row_array();
    }

    public function updateStatus($param)
    {
      $sql = "UPDATE osp.osp_order_sharpening_dev
              SET is_transact = 1 WHERE reff_number = '$param'";
      $query = $this->db->query($sql);
      return $this->db->affected_rows();
    }

    public function checkQuantity($param)
    {
      $sql = "SELECT mtrL.QUANTITY from mtl_txn_request_headers mtrh, mtl_txn_request_lines mtrl
             where mtrh.HEADER_ID = mtrl.HEADER_ID
             and mtrh.REQUEST_NUMBER = '$param' ";
      $query = $this->oracle_dev->query($sql);
      return $query->row_array();
    }

    //-----> Main Function of Move Order

    public  function createTemp($data)
    {
      $oracle = $this->load->database('oracle_dev',TRUE);
      $oracle->trans_start();
      $oracle->insert('CREATE_MO_ORDER_TR_TEMP',$data);
      $oracle->trans_complete();
      // $this->oracle = $this->load->database('oracle', true);
      // $sql = "INSERT INTO CREATE_MO_ORDER_TR_TEMP 
      //         (NO_URUT,INVENTORY_ITEM_ID,QUANTITY,UOM,IP_ADDRESS,ORDER_NUMBER)
      //         VALUES ('$data[NO_URUT]','$data[INVENTORY_ITEM_ID]','$data[QUANTITY]','$data[UOM]','$data[IP_ADDRESS]','$data[ORDER_NUMBER]');";
      // $query = $this->oracle->query($sql);
    }

    function deleteTemp($ip, $reff_number)
    {
      $oracle = $this->load->database('oracle_dev',TRUE);
      $sql = "DELETE FROM CREATE_MO_ORDER_TR_TEMP where IP_ADDRESS = '$ip' and  ORDER_NUMBER = $reff_number ";
      $oracle->trans_start();
      $oracle->query($sql);
      $oracle->trans_complete();
    }
// edit pseudonym
    function createMO($username,$ip_address,$transTypeID,$reff_number,$subinv,$locator)
    {

      // echo "<pre>";
      // print_r($subinv);
      // print_r($locator);
      // print_r($reff_number);
      // exit();

      $username = 'AA TECH TSR 01';
      $jan = 137;

      $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
             $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
      $sql =  "BEGIN APPS.KHS_CREATE_MO_ORDER_TR(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6); END;";

      //Statement does not change
      $stmt = oci_parse($conn,$sql);                     
      oci_bind_by_name($stmt,':P_PARAM1',$username);
      oci_bind_by_name($stmt,':P_PARAM2',$jan);
      oci_bind_by_name($stmt,':P_PARAM3',$ip_address);
      oci_bind_by_name($stmt,':P_PARAM4',$reff_number);
      oci_bind_by_name($stmt,':P_PARAM5',$subinv);
      oci_bind_by_name($stmt,':P_PARAM6',$locator);
// sampai sini 

//---
    // if (!$data) {
    // $e = oci_error($conn);  // For oci_parse errors pass the connection handle
    // trigger_error(htmlentities($e['message']), E_USER_ERROR);
    // }
//---
      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      
      // and now, execute the cursor
      oci_execute($cursor);
    }

    function transactMO($transNumber,$invID)
    {
      $username = 'AA TECH TSR 01';
      $org = 102;
      $subinv = 'TR-DM';
      $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
             $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

      $sql =  "BEGIN APPS.KHS_TRANSACT_MO_PER_ITEM(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5); END;";
      //Statement does not change
      $stmt2 = oci_parse($conn, 'commit');
      $stmt = oci_parse($conn,$sql);                     
      oci_bind_by_name($stmt,':P_PARAM1',$tra);
      oci_bind_by_name($stmt,':P_PARAM2',$org);
      oci_bind_by_name($stmt,':P_PARAM3',$username);
      oci_bind_by_name($stmt,':P_PARAM4',$subinv);
      oci_bind_by_name($stmt,':P_PARAM5',$invID);

      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      oci_execute($stmt2);
      
      // and now, execute the cursor
      oci_execute($cursor);

    }

//-----------------------END CODE----------------------------------------

}
?>