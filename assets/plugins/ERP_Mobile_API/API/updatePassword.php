<?php
require_once('koneksi.php');
$user_id = $_POST['user_id'];
$passwordbaru = $_POST['password'];

if(!empty($passwordbaru) || (!empty($user_id))){
	$sql = "UPDATE sys.sys_user SET user_password = '".$passwordbaru."' WHERE user_name='".$user_id."'";
	$query = pg_query($conn,$sql);
	$data['status'] = true;
	$data['result'] = 'Berhasil Mengubah Data';
}
else{
	$data['status'] = false;
}

print_r(json_encode($data));

?>