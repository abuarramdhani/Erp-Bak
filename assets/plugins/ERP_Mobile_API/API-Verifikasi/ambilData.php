<?php
require_once("koneksi.php");

$android_id = $_POST['android_id'];
$imei = $_POST['imei'];
$hardware_serial = $_POST['hardware_serial'];
$gsf = $_POST['gsf'];

if(!empty($android_id) || !empty($imei) || !empty($hardware_serial) || !empty($gsf)){
	$sql = "SELECT * FROM sys.sys_android WHERE android_id='".$android_id."' AND imei='".$imei."' AND hardware_serial='".$hardware_serial."' AND gsf='".$gsf."'";
	$query = pg_query($conn, $sql);

	if(pg_num_rows($query) > 0){
	    while($row = pg_fetch_object($query)){
	        $data['status'] = true;
	        $data['result'][] = $row;
	    }
	}else{
	    $data['status'] = false;
	    $data['result'][] = "Data not Found";
	}	
}else{
	$data['status'] = false;
	$data['result'][] = "Params not valid";
}


print_r(json_encode($data));
?>
