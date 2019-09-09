<?php
require_once('koneksiPersonalia.php');

$spdl_id 	= $_POST['spdl_id'];
$transac	= $_POST['transac'];

$sql = "SELECT count(*) FROM \"Presensi\".tpresensi_dl WHERE spdl_id = '".$spdl_id."' and stat='".$transac."'";
$query = pg_query($conn,$sql);

if(pg_num_rows($query) > 0){
	    while($row = pg_fetch_object($query)){
	        $data['status'] = true;
	        $data['result'][] = $row;
	    }
	}else{
	    $data['status'] = false;
	    $data['result'][] = "Data not Found";
	}
print_r(json_encode($data));	
?>