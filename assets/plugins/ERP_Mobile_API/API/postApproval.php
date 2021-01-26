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
		$sql="SELECT COUNT(*) FROM at.at_absen WHERE noind='".$noinduk."' AND longitude='".$longitude."' AND latitude='".$latitude."' AND tgl='".$tanggal."' AND jenis_absen_id='".$jenis_absen_id."' AND gambar='".$gambar."' AND status='".$status."' AND tgl_status='".$tanggal_status."' AND nama='".$nama."' ";

		$d = pg_query($conn,$sql);
 		$total=0;		
		while ($row = pg_fetch_row($d)[0]) {
		     $total = $row[0];
		}

		if ($total==0) {
			$ambilWaktu = json_decode(getWaktu($latitude,$longitude),true);
			if(!empty($ambilWaktu['date_time'])){
    			$wktAPI = $ambilWaktu['date_time'];
			}else{
				$wktAPI = $waktu;
			}			
			
			try {
				$wktNow =  new DateTime($wktAPI);
				$waktuNow = $wktNow->format('Y-m-d H:i:s');
				$validDate = true;
			} catch (Exception $e) {
				$validDate = false;
			}

			if ($validDate == true) {
				$sql="INSERT INTO at.at_absen 
		        (noind, longitude, latitude, lokasi,tgl,waktu,jenis_absen_id,gambar,status,tgl_status,nama)
		        VALUES ('".$noinduk."', '".$longitude."', '".$latitude."', '".trim($lokasi)."','".$tanggal."','".$waktuNow."','".$jenis_absen_id."','".$gambar."','".$status."','".$tanggal_status."','".$nama."')";
		        pg_send_query($conn, $sql);
				$result = pg_get_result($conn);

				if (empty(pg_result_error($result))) {
			        $sql2 	= "INSERT INTO at.at_absen_approval (approver,absen_id) VALUES('".$atasan."',(SELECT currval('at.at_absen_absen_id_seq')))";

			    	pg_send_query($conn, $sql2);
					$result2 = pg_get_result($conn);
					
					if (empty(pg_result_error($result2))) {
				        $data['status'] = true;
				        $data['result'][] = "Berhasil Menambah Data";
					}else{
						$data['status'] = false;
			       		$data['result'][] = "API Error #2: ".pg_result_error($result2);
					}
						
				}else{
					$data['status'] = false;
		       		$data['result'][] = "API Error #1: ".pg_result_error($result);
				}

			}else{
				$data['status'] = false;
	       		$data['result'][] = "API Error : DateTime not Valid ".$wktAPI;
			}


		}else{
			$data['status'] = false;
	        $data['result'][] = "Data sudah ada";
		}   

}else{
    $data['status'] = false;
    $data['result'][] = "Attribute Harus terisi semua";
}

function getWaktu($lat,$long){
	$url = "https://api.ipgeolocation.io/timezone?apiKey=zaf5a18596b654244816c78e33229c006&lat=".$lat."&long=".$long."";
	$curl = curl_init();
	set_time_limit(0);
	curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_HTTPGET, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
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