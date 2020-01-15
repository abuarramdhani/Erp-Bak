<?php
  include_once './session.php';

  session_destroy();
  echo json_encode(array(
    'ok' => true,
    'msg' => "Berhasil Logout",
    'data' => []
  ));
 ?>
