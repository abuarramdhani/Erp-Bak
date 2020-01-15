<?php
  require_once './session.php';
  require_once './connection.php';

  $username = $_POST['username'];
  $last_pass = $_POST['last_pass'];
  $new_pass = $_POST['new_pass'];

  header('Content-Type: Application/json');
  $cheks_last = $conn_sql->prepare("SELECT * FROM tp_login where username = ?");
  $cheks_last->bind_param("s", $username);
  $cheks_last->execute();
  $last = $cheks_last->get_result()->fetch_assoc();
  $data = array();
  if ($last['password'] != md5($last_pass)) {
    $data['ok'] = false;
    $data['msg'] = "Password lama anda salah";
    $data['data'] = [];

    echo json_encode($data);die();
  }

  $md5_nwe_pass = md5($new_pass);
  $update_pass = $conn_sql->prepare("UPDATE tp_login set password = ? where username = ?");
  $update_pass->bind_param("ss", $md5_nwe_pass, $username);
  $update_pass->execute();

  $select_user = $conn_sql->prepare("SELECT * FROM tp_login where username = ?");
  $select_user->bind_param("s", $username);
  $select_user->execute();
  $dt = $select_user->get_result();

  $data['ok'] = true;
  $data['msg'] = "Berhasil merubah password";
  $data['data'] = [$dt->fetch_assoc()];

  echo json_encode($data);

 ?>
