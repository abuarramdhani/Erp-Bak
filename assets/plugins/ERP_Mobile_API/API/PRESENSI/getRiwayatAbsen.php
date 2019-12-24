<?php
include('../koneksi.php');
$noinduk = $_POST['noinduk'];

if(!empty($noinduk)){
	$sql =  "SELECT a.absen_id,a.noind,a.latitude,a.longitude,a.lokasi,a.tgl,a.gambar,a.waktu,a.tgl_status,b.jenis_absen, 
CASE WHEN a.status ='0'
THEN 'Menunggu'
WHEN a.status = '1'
THEN 'Disetujui'
WHEN a.status='2'
THEN 'Ditolak' END as status_absen,
c.approver
 FROM at.at_absen a INNER JOIN at.at_jenis_absen b ON a.jenis_absen_id = b.jenis_absen_id INNER JOIN at.at_absen_approval c ON a.absen_id = c.absen_id WHERE a.noind='$noinduk' ORDER BY a.absen_id desc";
$result = pg_query($conn,$sql);

if(pg_num_rows($result) > 0){
	    while($row = pg_fetch_object($result)){
	        $data['status'] = true;
	        $data['result'][] = $row;
	    }
	}else{
	    $data['status'] = false;
	    $data['result'][] = "Data not Found";
	}
}else{
	$data['status'] 	= false;
	$data['result'][]	= "Nomor Induk Kosong";
}

print_r(json_encode($data));
?>