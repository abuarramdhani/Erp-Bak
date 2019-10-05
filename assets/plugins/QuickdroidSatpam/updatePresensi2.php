<?php
require_once('koneksiPersonalia.php');

$spdl_id 		= $_POST['spdl_id']; //$this->input->post('spdl_id');
$stat 			= $_POST['stat'];//$this->input->post('stat');
$idLogin		= $_POST['idLogin'];// $this->input->post('idLogin');


if(!empty($spdl_id) || !empty($stat) || !empty($idLogin)){
	$sql ="UPDATE \"Presensi\".tpresensi_dl set tanggal=current_date,user_='".$idLogin."' where spdl_id='".$spdl_id."' and stat='".$stat."'";

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