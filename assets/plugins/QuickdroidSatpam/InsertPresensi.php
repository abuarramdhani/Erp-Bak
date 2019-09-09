<?php 
require_once('koneksiPersonalia.php');

$spdl_id 		= $_POST['spdl_id'];// $this->input->post('spdl_id');
$no_ind			= $_POST['no_ind'];//$this->input->post('no_ind');
$kodesie 		= $_POST['kodesie'];//$this->input->post('kodesie');
$stat 			= $_POST['stat'];//$this->input->post('stat');
$idLogin		= $_POST['idLogin'];//$this->input->post('idLogin');
$rencana		= $_POST['rencana'];//$this->input->post('rencana');

if(!empty($spdl_id) || !empty($no_ind) || !empty($kodesie) || !empty($spdl_id) || !empty($idLogin) || !empty($rencana)){
	 $sql = "INSERT INTO \"Presensi\".tpresensi_dl (tanggal,noind,kodesie,user_,noind_baru,transfer,spdl_id,stat,keterangan) VALUES(current_date,'".$no_ind."', '".$kodesie."', '".$idLogin."', null, '0','".$spdl_id."','".$stat."','".$rencana."')";
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
	$data['result'][] = "Param Valid";
}

print_r(json_encode($data));
?>