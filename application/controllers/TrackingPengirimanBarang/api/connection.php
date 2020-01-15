<?php
  include_once './init.php';
  $conn = oci_connect($db_user, $db_pass, $db_host);
  $conn_sql = new mysqli('database.quick.com', 'erp', 'qu1ck1953', 'quickc01_trackingpengirimanbarang');
  if (!$conn || !$conn_sql) { //!$conn ||
    $e = $conn->oci_error();
    echo json_encode(array(
      'ok' => false,
      'msg' => $e['message']
    ));
    die();
  }
 ?>
