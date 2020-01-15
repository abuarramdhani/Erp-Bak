<?php
  require_once './session.php';
  require_once './connection.php';

  $no_spb = $_POST['no_spb'];
  $query = $conn_sql->query("SELECT * FROM tpb WHERE no_spb = $no_spb");
  $dataRow = array();
  while ($row = $query->fetch_assoc()) {
    $dr = array();
    $dr['confirmation'] = $row['confirmation'];
    array_push($dataRow, $dr);
  }

  $data = array(
              'ok' => true,
              'data' => $dataRow,
              'msg' => "Berhasil"
            );

  header('Content-Type: Application/json');
  echo json_encode($data);
 ?>
