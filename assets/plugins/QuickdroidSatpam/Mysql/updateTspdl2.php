<?php
include('koneksiMysql.php');

$tanggal 		= $_POST['tanggal'];
$currentTime	= $_POST['currentTime'];
$spdl_id		= $_POST['spdl_id'];

if(!empty($tanggal) || !empty($currentTime) || !empty($spdl_id)){
	$sql 	="UPDATE t_surat_perintah_dl_realisasi set aktual_sampai='".$tanggal." ".$currentTime." where spdr_detail_id=(select max(spdr_detail_id) from (select spdr_detail_id from t_surat_perintah_dl_realisasi where spdl_id='".$spdl_id."' ) as tb1)";

	$query 	= $conn->query($sql);

	if(mysql_affected_rows($conn)>0){
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



