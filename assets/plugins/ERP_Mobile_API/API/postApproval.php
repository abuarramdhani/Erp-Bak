<?php
require_once("koneksi.php");

$spesial = special_character();

$noinduk 		= $_POST['noinduk'];
$longitude 		= $_POST['longitude'];
$latitude	    = $_POST['latitude'];
$lokasi 		= str_replace(array_keys($spesial), $spesial, $_POST['lokasi']);
$lokasi 		= str_replace('é', 'e', $lokasi);
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
			if(isset($ambilWaktu['date_time']) && !empty($ambilWaktu['date_time'])){
    			$wktAPI = $ambilWaktu['date_time'];
			}else{
				$ambilWaktu = json_decode(getWaktu2($latitude,$longitude),true);
				if(isset($ambilWaktu['time']) && !empty($ambilWaktu['time'])){
    				$wktAPI = $ambilWaktu['time'].':'.date('s');
				}else{
					$wktAPI = $waktu;
				}
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

			       		$errLog[] = "API Error #2: ".pg_result_error($result2);
			       		$errLog[] = $sql;
			       		$errLog[] = $sql2;
						$errLog[] = json_encode($_POST);
						insert_log_error($errLog, $conn);
					}
						
				}else{
					$data['status'] = false;
		       		$data['result'][] = "API Error #1: ".pg_result_error($result);

		       		$errLog[] = "API Error #1: ".pg_result_error($result);
					$errLog[] = $sql;
					$errLog[] = json_encode($_POST);
					insert_log_error($errLog, $conn);
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
    $errLog[] = json_encode($_POST);
    insert_log_error($errLog, $conn);
}

function getWaktu($lat,$long){
    //login menggunakan quick.tractor@gmail.com
    // sign in google account
	$url = "https://api.ipgeolocation.io/timezone?apiKey=27ba676ee67b4dd18919ba838dac72a4&lat=".$lat."&long=".$long."";
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

function getWaktu2($lat,$long){
	$url = "http://api.geonames.org/timezoneJSON?lat=".$lat."&lng=".$long."&username=it.sec1";
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

function insert_log_error($data, $conn)
{
	$time 		= date('Y-m-d H:i:s');
	$noinduk 	= $_POST['noinduk'];
	foreach ($data as $key ) {
		$sql = "INSERT INTO sys.sys_log_activity (log_time, log_user, log_aksi, log_detail) VALUES('$time', '$noinduk', 'Error Absen Online', '$key');";
		@@$d = pg_query($conn,$sql);
	}
}

function special_character()
{
	return $replace = [
    '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
    '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae',
    '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
    'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
    'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
    'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
    'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
    'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
    'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
    'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
    'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
    'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
    'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
    'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
    'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
    '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
    'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
    'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
    'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
    'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
    'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
    'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
    'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
    'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
    'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
    'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
    'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
    'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
    '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
    'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
    'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
    'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
    'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
    'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
    'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
    'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
    'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
    'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
    'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
    'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
    'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
    'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
    'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
    'ю' => 'yu', 'я' => 'ya'
];
}

print_r(json_encode($data));
?>