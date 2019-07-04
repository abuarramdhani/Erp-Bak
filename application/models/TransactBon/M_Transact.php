<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_Transact extends CI_Model
{
	var $oracle;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
      $this->load->library('encrypt');
      $this->oracle = $this->load->database('oracle', true);
   }

   function search($slcNoBon)
   {
   $db = $this->load->database();
   $sql = "SELECT * FROM im.im_master_bon where no_bon='$slcNoBon' and jenis='I'";
   $query=$this->db->query($sql);
   return $query->result_array();
   }

   function searchBSTBP($slcNoBon)
   {
   $db = $this->load->database();
   $sql = "SELECT * FROM im.im_master_bon where no_bon='$slcNoBon'and jenis='R'";
   // print_r($sql);exit();
   $query=$this->db->query($sql);
   return $query->result_array();
   }

   function getSubInv($tampilTB)
   {
      $db = $this->load->database();
      $sql = "SELECT tujuan_gudang FROM im.im_master_bon where no_bon='$tampilTB'and jenis='R'";
      // print_r($sql);exit();
      $query=$this->db->query($sql);
      return $query->result_array();
   }

   function usrID($noind)
   {
      $oracle = $this->load->database('oracle',TRUE);
      $sql = "SELECT * FROM KHS_ALL_LOGIN_USER
      WHERE NOMOR_INDUK = '$noind'";
      // print_r($sql);exit();

      $query = $this->oracle->query($sql);
      return $query->row()->USER_ID;
   }

   function orgID($sub_inv)
   {
      $oracle = $this->load->database('oracle',TRUE);
      $sql = "SELECT organization_id FROM MTL_SECONDARY_INVENTORIES 
      WHERE secondary_inventory_name = '$sub_inv' AND disable_date IS null";
      // print_r($sql);exit();

      $query = $this->oracle->query($sql);
      return  $query->result_array();
   }

   function updatePostgre($serah, $no_id)
   {
      $db = $this->load->database();
      $sql = "UPDATE im.im_master_bon SET penyerahan = '$serah'
      WHERE no_id = '$no_id'";
      // echo $sql;exit();
      // print_r($sql);exit;
      $query = $this->db->query($sql);
      // return $sql;
   }
   
   function insertData($account,$kode_barang,$penyerahan,$no_urut,$tujuan_gudang,$lokator, 
   $ip_address,$produk,$keterangan,$satuan,$kode_cabang) {

      $oracle = $this->load->database('oracle',TRUE);
      $sql = "INSERT INTO MISCELLANEOUS_TAB (LOC_2,
      ITEM_NAME,
      REQ_QTY,
      LOC_1,
      FROM_SUBINVENTORY,
      LOC_5,
      IP_ADDRESS,
      LOC_3,
      LOC_4,
      UOM,
      KODE_CABANG)
      values ('$account', '$kode_barang', '$penyerahan', '$no_urut', '$tujuan_gudang', '$lokator', 
      '$ip_address', '$produk', '$keterangan', '$satuan', '$kode_cabang')";
      // echo $sql.'<br>';
      // echo $ip_address;
      // exit();
      $query = $this->oracle->query($sql);
      // return $query->result_array();
      // return $sql;
   }

   function insertData2($account,$kode_barang,$penyerahan,$no_urut,$tujuan_gudang,$lokator, 
   $ip_address,$produk,$keterangan,$satuan,$kode_cabang) {
      $oracle = $this->load->database('oracle',TRUE);
      $sql = "INSERT INTO MISCELLANEOUS_TAB (LOC_2,
      ITEM_NAME,
      QTY_KEMBALI,
      LOC_1,
      FROM_SUBINVENTORY,
      LOC_5,
      IP_ADDRESS,
      LOC_3,
      LOC_4,
      UOM,
      KODE_CABANG)
      values ('$account', '$kode_barang', '$penyerahan', '$no_urut', '$tujuan_gudang', '$lokator', 
      '$ip_address', '$produk', '$keterangan', '$satuan', '$kode_cabang')";
      // echo $sql.'<br>';
      // exit();
      // echo $ip_address;
      $this->oracle->query($sql);
      // return $query->result_array();
      // return $sql;
   }


      function updateFlag($no_bon,$no_id,$flag)
         {
         $sql = "UPDATE im.im_master_bon SET flag = '$flag'
               WHERE no_bon = '$no_bon' AND no_id = '$no_id'";
               // echo $sql;
               // echo $flag;
               // exit();
        $query = $this->db->query($sql);
         }

   function runAPI($usr_id,$no_bon,$account,$cost_center,$sub_inv){
      // echo "<pre>";
      // echo "$usr_id";
      // echo "<pre>";
      // echo "$no_bon";
      // echo "<pre>";
      // echo "$account";
      // echo "<pre>";
      // echo "$cost_center";
      // echo "<pre>";
      // echo "$sub_inv";
      // exit();

      $username = 'AA TECH TSR 01';
      $jan = 137;
      $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
             $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
      $sql =  "BEGIN APPS.KHS_MISCELLANEOUS_ALL(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4, :P_PARAM5); END;";
                                                                                         
      //Statement does not change
      $stmt = oci_parse($conn,$sql);                     
      oci_bind_by_name($stmt,':P_PARAM1',$usr_id);
      oci_bind_by_name($stmt,':P_PARAM2',$no_bon);
      oci_bind_by_name($stmt,':P_PARAM3',$account);
      oci_bind_by_name($stmt,':P_PARAM4',$cost_center);
      oci_bind_by_name($stmt,':P_PARAM5',$sub_inv);
 
      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      
      // and now, execute the cursor
      oci_execute($cursor);
   }

   function runAPI2($usr_id,$no_bon,$account,$cost_center,$ip_address,$org_id_array,$sub_inv,$lokator){
      if(empty($lokator)) { $lokator = ''; }
      // echo "<pre>";
      // print_r($usr_id);
      // print_r('<br/>');
      // print_r($no_bon);
      // print_r('<br/>');
      // print_r($account);
      // print_r('<br/>');
      // print_r($cost_center);
      // print_r('<br/>');
      // print_r($ip_address);
      // print_r('<br/>');
      // print_r($org_id_array);
      // print_r('<br/>');
      // print_r($lokator);
      // exit();

      $username = 'AA TECH TSR 01';
      $jan = 137;
      $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
      
      if (!$conn) {
         $e = oci_error();
         trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
         die('Can\'t connect to db');
      }
        
      $sql =  "BEGIN KHS_MISCELLANEOUS_BSTBP(:P_PARAM1,:P_PARAM2,:P_PARAM3,:P_PARAM4,:P_PARAM5,:P_PARAM6,:P_PARAM7,:P_PARAM8); END;";
      // $sql = "begin KHS_MISCELLANEOUS_BSTBP('5177','190628012','515515','4A03','192.168.168.220','102','KOM1-DM','');end;"
      // APPS.KHS_MISCELLANEOUS_BSTBP(P_USER_ID number,P_NO_BPPBGT number, P_ACCOUNT VARCHAR2, P_COST_CENTER VARCHAR2,IP_ADDRESS VARCHAR2,P_ORG_ID VARCHAR2,P_SUBINV VARCHAR2,P_LOCATOR_ID VARCHAR2) is
                                                                                         
      //Statement does not change
      $stmt = oci_parse($conn, $sql);                     
      oci_bind_by_name($stmt,':P_PARAM1', $usr_id);
      oci_bind_by_name($stmt,':P_PARAM2', $no_bon);
      oci_bind_by_name($stmt,':P_PARAM3', $account);
      oci_bind_by_name($stmt,':P_PARAM4', $cost_center);
      oci_bind_by_name($stmt,':P_PARAM5', $ip_address);
      oci_bind_by_name($stmt,':P_PARAM6', $org_id_array);
      oci_bind_by_name($stmt,':P_PARAM7', $sub_inv);
      oci_bind_by_name($stmt,':P_PARAM8', $lokator);
 
      // But BEFORE statement, Create your cursor
      $cursor = oci_new_cursor($conn);
      
      // Execute the statement as in your first try
      oci_execute($stmt);
      
      // and now, execute the cursor
      oci_execute($cursor);
   }

   function Fnd($usr_id) {
      // echo $usr_id;
      $username = 'AA TECH TSR 01';
      $jan = 137;
      $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
      // $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
             $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

   //  $sql = "BEGIN Fnd_Global.apps_initialize(" + user + ",50630,20003); :x := apps.Fnd_Request.submit_request('INV','INCTCM','Interface Inventory Transactions'); END;";
       $sql = "BEGIN APPS.KHS_RUN_FND(:P_PARAM1);END;";
      //  echo $sql.'<br>';
      //  exit();

       //Statement does not change
       $stmt = oci_parse($conn,$sql);                     
       oci_bind_by_name($stmt,':P_PARAM1',$usr_id);
   
       $cursor = oci_new_cursor($conn);
       
       // Execute the statement as in your first try
       oci_execute($stmt);
       
       // and now, execute the cursor
       oci_execute($cursor);
   }
   
   public function delete($ip_address) {

      $oracle = $this->load->database('oracle',TRUE);
      $sql = "DELETE FROM MISCELLANEOUS_TAB
      WHERE ip_address ='$ip_address'";
      // echo $sql;
      // print_r($ip_address);exit;
      // $oracle->trans_start();
      // //$oracle->query($sql);
      // $oracle->trans_complete();

      $this->oracle->query($sql);
   }

   public function getNoind() {
      $sql = "SELECT NOMOR_INDUK FROM KHS_ALL_LOGIN_USER";
      // return $sql;

      $query = $this->oracle->query($sql);
      return $query->result_array();
   }
   
}

?>