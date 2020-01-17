<?php
    session_start();

    if (count($_SESSION) == 0) {
      $data = array(
        'ok' => false,
        'msg' => "Anda belum login",
        'data' => []
      );
      header('Content-Type: Application/json');
      echo json_encode($data);
      exit();
    }

 ?>
