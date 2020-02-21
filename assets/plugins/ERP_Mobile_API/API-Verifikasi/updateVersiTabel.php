<?php
include('koneksi.php');

$current_version = $_POST['current_version'];
$gadget_id = $_POST['gadget_id'];

$sql = "update sys.sys_android set versi_aplikasi='$current_version' where gadget_id = '$gadget_id'";
$query = pg_query($conn,$sql);

$data['message'] = 'Exist';
print_r(json_encode($data));

?>