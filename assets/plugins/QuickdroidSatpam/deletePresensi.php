<?php
require_once('koneksiPersonalia.php');
$spdl_id = $_POST['spdl_id'];

if(!empty($spdl_id)){
 $sql = "DELETE FROM \"Presensi\".tpresensi_dl WHERE spdl_id='".$spdl_id."' AND waktu is null";
 $query = pg_query($conn,$sql);

 if(pg_affected_rows($query)>0){
 	$data['status'] = true;
	$data['result'][] = "Berhasil";
} 	

}else{
	$data['status'] = false;
	$data['result'][] = "Gagal";
}

print_r(json_encode($data));
?>