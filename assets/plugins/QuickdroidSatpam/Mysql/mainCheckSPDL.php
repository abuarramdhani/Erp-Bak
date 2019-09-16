<?php
include('koneksiMysql.php');

$content = $_POST['content'];

$sql ="SELECT tspd.spdl_id,tspd.noind, tspd.realisasi_approved,tspd.draft_approved, tspd.group_input, tspd.group_user, tp.kodesie, tp.nama, (SELECT concat(CASE WHEN tspdd.transportasi_berangkat_ket_2 is NULL THEN '' ELSE tspdd.transportasi_berangkat_ket_2 END,',',concat(date_format(min(tspdd.dari),'%Y-%m-%d'),'|',date_format(max(tspdd.sampai),'%Y-%m-%d'))) FROM t_surat_perintah_dl_detail tspdd WHERE tspdd.spdl_id=tspd.spdl_id ORDER BY tspdd.dari ASC LIMIT 1) AS kendaraan FROM t_surat_perintah_dl tspd INNER JOIN t_pekerja tp ON tp.noind=tspd.noind WHERE tspd.spdl_id='".$content."' ";

$query = $conn->query($sql);

if(mysqli_num_rows($query) > 0){
	    while($row = mysqli_fetch_object($query)){
	        $data['status'] = true;
	        $data['result'][] = $row;
	    }
	}else{
	    $data['status'] = false;
	    $data['result'][] = "Data not Found";
	}


print_r(json_encode($data));
?>