<?php
require_once("../koneksi.php");

$user_id = $_POST['user_id'];
$active = $_POST['active'];


if(!empty($user_id) || !empty($active)){
	// $sql = "SELECT * FROM sys.sys_android WHERE android_id='".$android_id."' AND imei='".$imei."' AND hardware_serial='".$hardware_serial."' AND gsf='".$gsf."'";

	$sql = "SELECT su.user_id,sugm.user_group_menu_id, sugm.user_group_menu_name, 
					smod.module_name,smod.module_link,sua.active,sua.user_application_id,sugm.org_id, smod.module_image
					FROM sys.sys_user su,
					sys.sys_user_application sua,
					sys.sys_user_group_menu sugm,
					sys.sys_module smod
					WHERE 
					1 = 1
					AND su.user_id = sua.user_id
					AND sua.user_group_menu_id = sugm.user_group_menu_id
					AND smod.module_id= sugm.module_id
					AND su.user_id=$user_id
					order by sugm.user_group_menu_name;";
					
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
