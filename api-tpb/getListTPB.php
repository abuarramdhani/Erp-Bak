<?php
  require_once './session.php';
  require_once './connection.php';

  $nama_pekerja = $_POST['nama_pekerja'];

  $stmt = $conn_sql->prepare("SELECT * FROM tpb where nama_pekerja = ?");
  $stmt->bind_param("s", $nama_pekerja);
  $stmt->execute();

  $rows = $stmt->get_result();
  $dataRow = array();
  while ($row = $rows->fetch_assoc()) {
    $dataRow[] = $row;
  }
  $data = array(
              'ok' => true,
              'msg' => "Berhasil",
              'data' => $dataRow
            );
  echo json_encode($data);
 ?>
