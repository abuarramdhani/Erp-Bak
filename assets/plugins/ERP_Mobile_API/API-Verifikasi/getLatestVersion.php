<?php
include('koneksi.php');

$sql = "select * from sys.sys_android_version_control";
$query = pg_query($conn,$sql);

if(pg_num_rows($query) > 0){
	$data['status'] = true;
	    while($row = pg_fetch_object($query)){
	        $data['result'][] = $row;
	    }
	}else{
	    $data['status'] = false;
	    $data['result'][] = "Data not Found";
	}

print_r(json_encode($data));	

?>