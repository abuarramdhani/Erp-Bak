<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_approval extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle', TRUE);
    $this->personalia = $this->load->database('personalia', TRUE);
  }

  function getApprovalMPA($employee_code, $status){
    if ($status == "1") {
        $sql = "SELECT DISTINCT kcm.DOCUMENT_NUMBER, kcm.NAMA_MESIN, kcm.TYPE_MESIN, kcm.SCHEDULE_DATE, kcm.ACTUAL_DATE, kcm.REQUEST_TO_2 
        FROM KHS_CEK_MESIN kcm 
        WHERE kcm.REQUEST_TO = '$employee_code'
        AND kcm.APPROVED_BY IS NULL
        AND kcm.APPROVED_DATE IS NULL
        AND kcm.STATUS_APPROVAL IS NULL
        ORDER BY kcm.DOCUMENT_NUMBER";
    }else if ($status == "2") {
        $sql = "SELECT DISTINCT kcm.DOCUMENT_NUMBER, kcm.NAMA_MESIN, kcm.TYPE_MESIN, kcm.SCHEDULE_DATE, kcm.ACTUAL_DATE 
        FROM KHS_CEK_MESIN kcm 
        WHERE kcm.REQUEST_TO_2 = '$employee_code'
        AND kcm.APPROVED_BY_2 IS NULL
        AND kcm.APPROVED_DATE_2 IS NULL
        AND kcm.STATUS_APPROVAL = '1'
        ORDER BY kcm.DOCUMENT_NUMBER";
    }
    $query = $this->oracle->query($sql);
    return $query->result_array();
}

// public function updateApproval1($nodoc, $noinduk, $req2)
// {
//   $currentDateTime = date('Y-m-d H:i:s'); //SYSDATE
//   $sql = "UPDATE KHS_CEK_MESIN kcm 
//   SET kcm.APPROVED_BY = '$noinduk'
//   , kcm.APPROVED_DATE =  TO_DATE('$currentDateTime', 'YYYY-MM-DD HH24:MI:SS')
//   , kcm.REQUEST_TO_2 = '$req2'
//   , kcm.STATUS_APPROVAL = '1'
//   WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
//   AND kcm.STATUS_APPROVAL IS NULL";

//   $query = $this->oracle->query($sql);
//   return $query;
// }

public function updateApproval1($nodoc, $noinduk)
{
  date_default_timezone_set('Asia/Jakarta');
  $currentDateTime = date('Y-m-d H:i:s'); //SYSDATE
  // echo $currentDateTime;exit;
  $sql = "UPDATE KHS_CEK_MESIN kcm 
  SET kcm.APPROVED_BY = '$noinduk'
  , kcm.APPROVED_DATE =  TO_DATE('$currentDateTime', 'YYYY-MM-DD HH24:MI:SS')
  , kcm.STATUS_APPROVAL = '1'
  WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
  AND kcm.STATUS_APPROVAL IS NULL";

  $query = $this->oracle->query($sql);
  return $query;
}

public function updateApproval2($nodoc, $noinduk)
{
  date_default_timezone_set('Asia/Jakarta');
  $currentDateTime = date('Y-m-d H:i:s'); //SYSDATE
  $sql = "UPDATE KHS_CEK_MESIN kcm 
  SET kcm.APPROVED_BY_2 = '$noinduk'
  , kcm.APPROVED_DATE_2 = TO_DATE('$currentDateTime', 'YYYY-MM-DD HH24:MI:SS')
  , kcm.STATUS_APPROVAL = '2'
  WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
  AND kcm.STATUS_APPROVAL = '1'";

  $query = $this->oracle->query($sql);
  return $query;
}

public function updateApprovalSeksi($nodoc, $req2)
{
  date_default_timezone_set('Asia/Jakarta');
  $currentDateTime = date('Y-m-d H:i:s'); //SYSDATE
  // echo $currentDateTime;exit;
  $sql = "UPDATE KHS_CEK_MESIN kcm 
  SET kcm.REQUEST_TO_2 = '$req2'
  WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
  AND kcm.STATUS_APPROVAL IS NULL";

  $query = $this->oracle->query($sql);
  return $query;
}

// function getNoInduk(){
//   $sql  = "select employee_name nama, employee_code noind from sys.sys_user as sys
//   left join er.er_employee_all as er on upper(trim(sys.user_name)) = upper(trim(er.employee_code))
//   where er.resign = 0";
//   $result  = $this->db->query($sql)->result_array();
//   return $result;
// }

function getNoInduk(){
  $sql  = "select distinct no_induk, nama from khs_approval_seksi_mpa";
  $result  = $this->oracle->query($sql)->result_array();
  return $result;
}

function getNama($noinduk){
  $sql  = "select employee_name nama from sys.sys_user as sys
  left join er.er_employee_all as er on upper(trim(sys.user_name)) = upper(trim(er.employee_code))
  where er.resign = 0
AND employee_code = '$noinduk'";
  $result  = $this->db->query($sql)->result_array();
  return $result;
}

}