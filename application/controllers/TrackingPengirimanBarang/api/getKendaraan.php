<?php
  require_once './session.php';
  require_once './connection.php';

  $query = $conn_sql->query("SELECT * FROM tp_kendaraan");
  $dataRow = array();
  while ($row = $query->fetch_assoc()) {
    $dr = array();
    $dr['id_kendaraan'] = (int)$row['id_kendaraan'];
    $dr['kendaraan'] = $row['kendaraan'];
    $dr['nomor_kendaraan'] = $row['nomor_kendaraan'];
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
