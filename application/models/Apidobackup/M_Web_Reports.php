<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_web_reports extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }
    public function param()
    {  
         return $this->oracle->query("SELECT * FROM KHS_DO_SPB_BACKUP")->result_array();
    }
        
    public function MasterDO($id)
    {
      $response = $this->oracle->query("SELECT * from khs.khs_cetak_do_unit_sc_qr kc where kc.REQUEST_ID = '$id'")->result_array();
      if(empty($response)) {
          $response = array(
              'success' => false,
              'message' => 'data is empty.'
          );
      }
      return $response;
    }
    public function getBody($param)
    {
     
        return $this->oracle->query("SELECT * from KHS_QWEB_AUBODY_DOSPB1 kq where kq.REQUEST_NUMBER = '$param'")->result_array();
    }
    public function getBodyAllDO($param)
    {
      return $this->oracle->get('KHS_QWEB_AUBODY_DOSPB1')->result_array();
    }
    public function run()
    {
        // $conn = oci_connect('APPS', 'APPS', '192.168.7.3:1522/DEV');
        $conn = oci_connect('APPS', 'APPS', '192.168.7.1:1521/PROD');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $sql =  "BEGIN KHS_INSERT_DOSPB_BACKUP(sysdate); END;";
        //Statement does not change
        $stmt = oci_parse($conn, $sql);
        // oci_bind_by_name($stmt, ':P_PARAM1', $rm);
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
    public function headerSurat($id)
    {
      $query = "SELECT *
                from khs_qweb_header_dospb1 kqhd
                where kqhd.REQUEST_NUMBER = '$id'";
      $response = $this->oracle->query($query)->result_array();
      if (empty($response)) {
          $response = null;
      }
      return $response;
    }
    public function serial($data)
    {
        $query = "SELECT *
                    FROM khs_qweb_serial_dospb1 kqsd
                   WHERE kqsd.request_number = '$data'";
        $response = $this->oracle->query($query)->result_array();
        if (empty($response)) {
            $response = null;
        }
        return $response;
    }
    public function footersurat($data)
    {
        $query = "SELECT *
                  from khs_qweb_footer_dospb1 kqfd
                  where kqfd.REQUEST_NUMBER = '$data'";
        $response = $this->oracle->query($query)->result_array();
        if (empty($response)) {
            $response = array(
                'success' => 0,
                'message' => 'there is no data available.'
            );
        }
        return $response;
    }
    public function cekSpbDo($id)
    {
        $query = "SELECT kdt.delivery_type
                    FROM khs_detail_dospb kdt
                   WHERE kdt.request_number = '$id'
                   AND kdt.delivery_type like 'SPB%'
                   ";
        $response = $this->oracle->query($query)->result_array();
        if(empty($response)){
            $response = null;
        }
        return $response;
    }
}