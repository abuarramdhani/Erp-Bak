<?php
require_once("koneksi.php");

$android_id = $_POST['android_id'];
$imei = $_POST['imei'];
$hardware_serial = $_POST['hardware_serial'];
$gsf = $_POST['gsf'];
$nama = $_POST['info_1'];
$noInduk = $_POST['info_2'];
$tanggalRequest = $_POST['register_request_date'];
$validation = $_POST['validation'];
if(!empty($android_id) || !empty($imei) || !empty($hardware_serial) || !empty($gsf)|| !empty($nama)|| !empty($noInduk)|| !empty($tanggalRequest)|| !empty($validation)){
		$sql="SELECT COUNT(*) FROM sys.sys_android WHERE android_id='".$android_id."' AND imei='".$imei."' AND hardware_serial='".$hardware_serial."' AND gsf='".$gsf."'";
		$d = pg_query($conn,$sql);
		$total=0;
		while ($row = pg_fetch_row($d)[0]) {
		     $total = $row[0];
		}

		if ($total==0) {
			$sql="INSERT INTO sys.sys_android 
	        (android_id, imei, hardware_serial, gsf,info_1,info_2,register_request_date,validation)

	        VALUES ('".$android_id."', '".$imei."', '".$hardware_serial."', '".$gsf."','".$nama."','".$noInduk."','".$tanggalRequest."','".$validation."')";    

	        $gas = pg_query($conn,$sql);
	        if(pg_affected_rows($gas)>0){
	        	$data['status'] = true;
	        	$data['result'][] = "Berhasil Menambah Data";
	        }else{
	        	$data['status'] = false;
	        	$data['result'][] = "Gagal Menambah Data";
	        }
	        
		}else{
			$data['status'] = false;
	        $data['result'][] = "Data sudah ada";
		}   

}else{
    $data['status'] = false;
    $data['result'][] = "Attribute Harus terisi semua";
}

print_r(json_encode($data));

// if(!empty($android_id) || !empty($imei) || !empty($hardware_serial) || !empty($gsf)|| !empty($noInduk)|| !empty($catatan)|| !empty($tanggalRequest)){
//         $sql="INSERT INTO sys.sys_android 
//         (android_id, imei, hardware_serial, gsf,employee_id,info_1,register_request_date)

//         VALUES ('".$android_id."', '".$imei."', '".$hardware_serial."', '".$gsf."','".$noInduk."','".$catatan."','".$tanggalRequest."')";    

//         $gas = pg_query($conn,$sql);

//         $data['status'] = true;
//         $data['result'][] = "Berhasil Menambah Data";

// }
?>