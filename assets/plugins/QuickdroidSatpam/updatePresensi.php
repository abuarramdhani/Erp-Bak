<?php
require_once('koneksiPersonalia.php');

$spdl_id 		= $_POST['spdl_id']; //$this->input->post('spdl_id');
$stat 			= $_POST['stat'];//$this->input->post('stat');
$tanggal		= $_POST['tanggal'];//$this->input->post('tanggal');
$jam_pulang 	= $_POST['jam_pulang'];//$this->input->post('jam_pulang');
$menit_pulang 	= $_POST['menit_pulang'];//$this->input->post('menit_pulang');
$currentTime	= $_POST['currentTime'];//$this->input->post('currentTime');

if(!empty($spdl_id) || !empty($stat) || !empty($idLogin)){
	$sql ="UPDATE \"Presensi\".tpresensi_dl set tanggal=current_date,waktu=to_char(current_timestamp, 'HH24:MI:SS'), tgl_realisasi='".$tanggal."', wkt_realisasi='".$currentTime."' WHERE spdl_id='".$spdl_id."' and stat='".$stat."'";

	$query = pg_query($conn,$sql);
	
	if(pg_affected_rows($query)>0){
 	$data['status'] = true;
	$data['result'][] = "Berhasil";
	} 	
	else{
	$data['status'] = false;
	$data['result'][] = "Gagal";
	}


}
else{
	$data['status'] = false;
	$data['result'][] = "Gagal Param Valid";}

print_r(json_encode($data));
?>