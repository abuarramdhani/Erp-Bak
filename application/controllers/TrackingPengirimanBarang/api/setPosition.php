<?php
  require_once './connection.php';

  $id_login = $_POST['id_login'];
  $lat = $_POST['lat'];
  $long = $_POST['long'];

  if (!empty($id_login) && !empty($lat) && !empty($long)) {
    header('Content-Type: Application/json');
    setPosition($conn_sql, $id_login, $lat, $long);
  }

  function setPosition($conn, $id_login, $lat, $long)
  {
    $query = "SELECT * FROM tp_login tpl RIGHT JOIN tp_position tpp on tpl.id_login = tpp.id_login Where tpp.id_login = ?";
    $check = $conn->prepare($query);
    $check->bind_param('s', $id_login);
    $check->execute();
    $get = $check->get_result();

    if ($get->num_rows) {
      Update($conn, $id_login, $lat, $long);
    }else {
      Insert($conn, $id_login, $lat, $long);
    }
  }

  function Update($conn, $id_login, $lat, $long)
  {

    try {
      $query = "Update tp_position tpp set tpp.lat = ?, tpp.long = ? Where id_login = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('ssi', $lat, $long, $id_login);
      $stmt->execute();
      $data = array(
        'ok' => true,
        'data' => [],
        'msg' => 'Berhasil Update'
      );
    } catch (Exception $e) {
      $data = array(
        'ok' => false,
        'data' => [],
        'msg' => $e
      );
    }

    echo json_encode($data);
    die();
  }

  function Insert($conn, $id_login, $lat, $long)
  {
    $query = "INSERT INTO tp_position VALUES(?, ?, ?)";

    try {
      $stmt = $conn->prepare($query);
      $stmt->bind_param('iss', $id_login, $long, $lat);
      $stmt->execute();
      $data = array(
        'ok' => true,
        'data' => [],
        'msg' => 'Berhasil Update'
      );
    } catch (Exception $e) {
      $data = array(
        'ok' => false,
        'data' => [],
        'msg' => $e
      );
    }

    echo json_encode($data);
    die();
  }
 ?>
