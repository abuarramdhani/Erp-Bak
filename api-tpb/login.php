<?php
  include_once './connection.php';

  $noind = $_POST['username'];
  $password = $_POST['password'];
  $pass = md5($password);

  // $stmt = oci_parse($conn, 'SELECT * FROM kurir_tracking where ID_PEKERJA = :noind');
  // oci_bind_by_name($stmt, ':noind', $noind);
  // oci_execute($stmt);
  //
  // $getData = oci_fetch_assoc($stmt);
  $stmt = $conn_sql->prepare("SELECT * FROM tp_login where username = ? and password = ?");
  $stmt->bind_param("ss", $noind, $pass);
  $stmt->execute();
  $getData = $stmt->get_result()->fetch_assoc();
  if ($getData != false) {
    $data = array(
      'ok' => true,
      'msg' => "Berhasil login",
      'data' => [$getData],
    );

    session_start();
    $_SESSION['logged'] = true;
    $_SESSION['noind'] = $noind;
    $_SESSION['kacab'] = $getData['kacab'] == 'Y'?  true : false;

  }else {

    $data = array(
      'ok' => false,
      'msg' => "Silahkan cek kembali data yang anda masukan",
      'data' => []
    );
  }

  header('Content-Type: application/json');
  echo json_encode($data);
  // echo 'test';
  // echo json_encode($getData['kacab'])

 ?>
