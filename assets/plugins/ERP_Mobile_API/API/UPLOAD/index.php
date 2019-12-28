<?php

require_once("../koneksi.php");

$image = $_FILES['file']['tmp_name'];
$imagename = $_FILES['file']['name'];

// $file_path = $_SERVER['DOCUMENT_ROOT'] . '/API/NORI/UPLOAD/uploads/';
// $file_path = 'http://182.23.18.195/assets/upload/absenpekerja/';
$file_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/upload/absenpekerja';

if (!file_exists($file_path)) {
    mkdir($file_path, 0777, true);
}

if(!$image){
  echo json_encode(array('message'=>'required file is empty.'));
  $result = array("fail" => "error uploading file");
}
else{
  $newname = uniqid() . '.jpg';
  move_uploaded_file($image, $file_path.'/'.$imagename);
  $result = array("success" => "File successfully uploaded");
}
echo json_encode($result, JSON_PRETTY_PRINT);

?>
