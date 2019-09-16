<?php
include('koneksiMysql.php');

$user = $_POST['user'];
$pass = $_POST['pass'];

if(!empty($user) && !empty($pass)){
	$sql = " SELECT noind, nama FROM t_pekerja WHERE kodesie LIKE '4010101%' AND noind='".$user."' AND (pass_word = '".md5($pass)."' AND ha_satpam=1 OR token = '".md5($pass)."') ";
	$query = $conn->query($sql);
	
	if(mysqli_num_rows($query) > 0){
	    while($row = mysqli_fetch_object($query)){
	        $data['status'] 	= true;
	        $data['result'][] 	= $row;

	        // $data2 = respond(true, $row);
	    }
	}else{
	    $data['status'] = false;
	    $data['result'][] = "Data not Found";
	}	
}else{
	$data['status'] = false;
	$data['result'][] = "Data Kosong";

}
print_r(json_encode($data));
?>