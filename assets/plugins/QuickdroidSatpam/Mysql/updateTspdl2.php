<?php
include('koneksiMysql.php');

$tanggal 		= $_POST['tanggal'];
$currentTime		= $_POST['currentTime'];
$spdl_id		= $_POST['spdl_id'];

if(!empty($tanggal) || !empty($currentTime) || !empty($spdl_id)){
	$sql 	= "UPDATE t_surat_perintah_dl_realisasi set aktual_sampai='".$tanggal." ".$currentTime."' WHERE spdr_detail_id=(SELECT max(spdr_detail_id) from (SELECT spdr_detail_id FROM t_surat_perintah_dl_realisasi WHERE spdl_id='".$spdl_id."' ) as tb1)";

	$query 	= $conn->query($sql);

	if(mysqli_affected_rows($conn)>0){
		$data['status'] = true;
		$data['result'][] = "Berhasil";
	}else{
		$data['status'] = false;
		$data['result'][] = "Gagal";
	}
}else{
	$data['status'] = false;
	$data['result'][] = "Gagal, Param Valid";
}

print_r(json_encode($data));


?>



