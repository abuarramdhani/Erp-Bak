<?php
  require_once './connection.php';
  $id_login = $_POST['id_login'];

  if (!empty($id_login)) {
    header('Content-Type: Application/json');
    $checkID = checkID($conn_sql, $id_login);
    if (count($checkID) != 0) {
      $data = array(
        'ok' => true,
        'data' => [$checkID],
        'msg' => ''
      );
    }else {
      $data = array(
        'ok' => false,
        'data' => [],
        'msg' => 'Posisi tidak ditemukan'
      );
    }

    echo json_encode($data);
  }

  function checkID($conn, $id_login)
  {
    $stmt = $conn->prepare("SELECT tpp.*, tpl.nama_pekerja FROM tp_login tpl RIGHT JOIN tp_position tpp on tpl.id_login = tpp.id_login Where tpp.id_login = ?");
    $stmt->bind_param('s', $id_login);
    $stmt->execute();
    $row = $stmt->get_result();
    return $row->fetch_assoc();
  }

 ?>
