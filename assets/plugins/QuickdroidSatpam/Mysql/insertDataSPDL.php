<?php
include('koneksiMysql.php');

$spdlId 			= $_POST['spdlId'];
$currentTime		= $_POST['currentTime'];
$jenis				= $_POST['jenis'];
$merk				= $_POST['merk'];
$warna				= $_POST['warna'];
$nopol				= $_POST['nopol'];
$filename			= $_POST['filename'];
$km 				= $_POST['km'];
$user				= $_POST['user'];

if(!empty($spdlId) || !empty($currentTime) || !empty($jenis) || !empty($merk) || !empty($warna) || !empty($nopol) || !empty($filename) || !empty($km) || !empty($user) ){
	$sql 	= "INSERT INTO t_kbl_kendaraan (spdl_id,waktu,jenis,merk,warna,nopol,file,kilometer,user_) VALUES(".$spdlId.", '".$currentTime."','".$jenis."', '".$merk."', '".$warna."', '".$nopol."', '".$filename."',".$km.",'".$user."')";

	$query	= mysqli_query($conn,$sql);

	if(mysqli_affected_rows($conn) > 0){
		$data['status'] = true;
		$data['result']	= "Berhasil";
	}else{
		$data['status'] = false;
		$data['result']	= "Gagal";
	}
}

print_r(json_encode($data));

?>