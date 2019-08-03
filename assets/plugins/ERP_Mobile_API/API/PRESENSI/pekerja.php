<?php 
require_once("../koneksi.php");
$username = $_POST['user_id'];

if(!$username){
	$data['status'] = false;
	$data['result'] = "Username tidak ditemukan";
}
else{
	$sql = "select * from sys.vi_sys_user where user_name='".$username."'";

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

}
	print_r(json_encode($data));
?>