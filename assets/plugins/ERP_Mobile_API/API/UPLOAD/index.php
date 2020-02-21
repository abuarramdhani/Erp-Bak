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
		$data['status'] = false;
  		$data['message'] = "Gambar tidak ditemukan";
}
else{
	if(move_uploaded_file($image, $file_path.'/'.$imagename)){
		$data['status'] = true;
		$data['message'] = "Sukses Upload Gambar";
	}else{
		$data['status'] = false;
		$data['message'] = 'Gagal Upload Gambar';
	}
 }
print_r(json_encode($data));

?>
