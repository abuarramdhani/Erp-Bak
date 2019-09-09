<?php
require_once('koneksiERP.php');

$content = $_POST['content'];

$sql = "SELECT gfk.kendaraan_id,gfk.nomor_polisi,gfk.tahun_pembuatan,fjk.jenis_kendaraan,fmk.merk_kendaraan,fwk.warna_kendaraan FROM ga.ga_fleet_kendaraan gfk INNER JOIN ga.ga_fleet_jenis_kendaraan fjk ON fjk.jenis_kendaraan_id=gfk.jenis_kendaraan_id INNER JOIN ga.ga_fleet_merk_kendaraan fmk ON fmk.merk_kendaraan_id=gfk.merk_kendaraan_id INNER JOIN ga.ga_fleet_warna_kendaraan fwk ON fwk.warna_kendaraan_id=gfk.warna_kendaraan_id WHERE gfk.end_date='9999-12-12' AND gfk.nomor_polisi = '".$content."' ORDER BY gfk.nomor_polisi";

$query= pg_query($conn,$sql);

if(pg_num_rows($query) > 0){
	while($row = pg_fetch_object($query)){
	$data['status'] = true;
	$data['result'][] = $row;
}
}
else{
	$data['status'] = false;
	$data['result'][] = "Data Not Found";
}





 print_r(json_encode($data));


?>