<?php 
	if (isset($data) && !empty($data)) {
		echo $data[0]['isi_surat'];
	}else{
		echo "Ooppss Something Error";
	}
?>