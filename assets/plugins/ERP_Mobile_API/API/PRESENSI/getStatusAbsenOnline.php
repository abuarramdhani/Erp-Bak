
<?php
include('../koneksi.php');

$noinduk = $_POST['noinduk'];

$sql = "select a.user_name,a.user_id,b.user_group_menu_id,SUBSTRING(c.user_group_menu_name,27,1) as status_absen_online
FROM sys.sys_user a 
INNER JOIN sys.sys_user_application b ON a.user_id = b.user_id
INNER JOIN sys.sys_user_group_menu c ON b.user_group_menu_id = c.user_group_menu_id
WHERE a.user_name = '$noinduk' and c.user_group_menu_name LIKE 'Android%' and b.active = 'Y' ";

$exe = pg_query($conn,$sql);

if(!empty($noinduk)){
	if(pg_num_rows($exe) > 0){
		$data['status'] = true;
		while($row = pg_fetch_object($exe)){
			$data['result'][] = $row;
		}
	}else{
		$data['status'] = false;
		$data['result'][] = "Kosong";
	}
}else{
	$data['status'] = false;
	$data['result'][] = "Noinduk Not Found";
}

print_r(json_encode($data));

?>