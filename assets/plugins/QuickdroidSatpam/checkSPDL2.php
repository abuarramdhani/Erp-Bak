<?php
require_once('koneksiPersonalia.php');

$spdlCode = $_POST['spdlCode'];

$sql = "SELECT tpd.spdl_id,to_char(tpd.tanggal::date, 'YYYY-MM-DD') as tanggal,tpd.noind,rtrim(tp.nama) as nama,tpd.waktu, tpd.stat,to_char(tpd.tgl_realisasi::date, 'YYYY-MM-DD') as tanggal_real,tpd.wkt_realisasi from \"Presensi\".tpresensi_dl tpd inner join hrd_khs.tpribadi tp on tp.noind=tpd.noind where tpd.spdl_id='".$spdlCode."' order by tpd.waktu desc";

$query = pg_query($conn,$sql);

if(pg_num_rows($query) > 0){
	    while($row = pg_fetch_object($query)){
	        $data['status'] = true;
	        $data['result'][] = $row;
	    }
	}else{
	    $data['status'] = false;
	    $data['result'][] = "Data not Found";
	}

print_r(json_encode($data));
?>