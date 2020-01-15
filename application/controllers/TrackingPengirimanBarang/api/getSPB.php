<?php
  require_once './session.php';
  require_once './connection.php';
	
  $no_spb = $_POST['no_spb'];
  $query = "select distinct mtrh.REQUEST_NUMBER
 							   from mtl_txn_request_headers mtrh 
							  where mtrh.REQUEST_NUMBER = :no_spb";
  $stmt = oci_parse($conn, $query);
  oci_bind_by_name($stmt, ':no_spb', $no_spb);
  oci_execute($stmt);
  //$dataRows = array();
//  while ($row = oci_fetch_assoc($stmt)) {
//	   $dataRows = $row;
//  }
  $spb = null;
  while (oci_fetch($stmt)) {
    $spb = oci_result($stmt, 'REQUEST_NUMBER');
  }
  
  $data = array(
              'ok' => true,
              'data' => $spb,
              'msg' => "Berhasil"
            );
  
  header('Content-Type: Application/json');
  echo json_encode($data);
  
//  while ($row = oci_fetch_assoc($stmt2)) {
//	   $dataRows[] = $row;
// }
 ?>