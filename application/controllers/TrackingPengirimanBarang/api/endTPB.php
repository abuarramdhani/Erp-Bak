<?php
  require_once './session.php';
  require_once './connection.php';

  $no_spb = $_POST['no_spb'];
  $status = $_POST['status'];
  $penerima = $_POST['penerima'];

  if (empty($no_spb) || empty($status)) {
    $data = array(
      'ok' => false,
      'msg' => "Data tidak boleh kosong",
      'data' => []
    );
    echo json_encode($data);die();
  }

  $stmt = $conn_sql->prepare("UPDATE tpb SET last_update_date = now(), status = ?, penerima = ?, end_date = now() where no_spb = ?");
  $stmt->bind_param("sss", $status, $penerima, $no_spb);
  $stmt->execute();

  $newStmt = $conn_sql->prepare("SELECT * FROM tpb where no_spb = ?");
  $newStmt->bind_param("s", $no_spb);
  $newStmt->execute();
  $dataRow[] = $newStmt->get_result()->fetch_assoc();
  $data = array(
    'ok' => true,
    'msg' => "Berhasil",
    'data' => $dataRow
  );

  echo json_encode($data);
 ?>
