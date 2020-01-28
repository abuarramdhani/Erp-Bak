<?php
require_once("koneksi.php");

$noinduk 		= $_POST['noinduk'];
$longitude 		= $_POST['longitude'];
$latitude	    = $_POST['latitude'];
$lokasi 		= $_POST['lokasi'];
$tanggal 		= $_POST['tanggal'];
$waktu 			= $_POST['waktu'];
$jenis_absen_id = $_POST['jenis_absen_id'];
$gambar 		= $_POST['gambar'];
$status			= $_POST['status'];
$tanggal_status	= $_POST['tanggal_status'];
$nama			= $_POST['nama'];
$atasan 		= $_POST['atasan'];
if(!empty($noinduk) && !empty($longitude) && !empty($latitude) && !empty($lokasi) && !empty($tanggal) && !empty($waktu) && !empty($jenis_absen_id) && !empty($gambar) && !empty($tanggal_status) && !empty($atasan)){
		$sql="SELECT COUNT(*) FROM at.at_absen WHERE noind='".$noinduk."' AND longitude='".$longitude."' AND latitude='".$latitude."' AND lokasi='".$lokasi."' AND tgl='".$tanggal."' AND waktu='".$waktu."' AND jenis_absen_id='".$jenis_absen_id."' AND gambar='".$gambar."' AND status='".$status."' AND tgl_status='".$tanggal_status."' AND nama='".$nama."' ";

		$d = pg_query($conn,$sql);
 		$total=0;		
		while ($row = pg_fetch_row($d)[0]) {
		     $total = $row[0];
		}

		if ($total==0) {
			if(empty(json_decode(getWaktu($latitude,$longitude),true)['error'])){
				$ambilWaktu = json_decode(getWaktu($latitude,$longitude),true);
				if(!empty($ambilWaktu)){
	    			$wktAPI = $ambilWaktu['date_time'];	
				}else{
					$wktAPI = $waktu;
				}
			}else{
					$wktAPI = $waktu;
			}			
			
			$sql="INSERT INTO at.at_absen 
	        (noind, longitude, latitude, lokasi,tgl,waktu,jenis_absen_id,gambar,status,tgl_status,nama)

	        VALUES ('".$noinduk."', '".$longitude."', '".$latitude."', '".$lokasi."','".$tanggal."','".$wktAPI."','".$jenis_absen_id."','".$gambar."','".$status."','".$tanggal_status."','".$nama."')";
	        $gas = pg_query($conn,$sql);

	        $sql2 	= "INSERT INTO at.at_absen_approval (approver,absen_id) VALUES('".$atasan."',(SELECT currval('at.at_absen_absen_id_seq')))";
	    	$gas2	= pg_query($conn,$sql2);

	        $data['status'] = true;
	        $data['result'][] = "Berhasil Menambah Data";
		}else{
			$data['status'] = false;
	        $data['result'][] = "Data sudah ada";
		}   

}else{
    $data['status'] = false;
    $data['result'][] = "Attribute Harus terisi semua";
}

function getWaktu($lat,$long){
	$url = "https://api.ipgeolocation.io/timezone?apiKey=af5a18596b654244816c78e33229c006&lat=".$lat."&long=".$long."";
	$curl = curl_init();
	set_time_limit(0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_URL,$url);
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		$response = ("Error #:" . $err);
	}
	else
	{
		$response;
	}
	return $response;
}

print_r(json_encode($data));
?>