<?php
$hostname = "192.168.168.85";
$username = "postgres";
$password = "password";
$database = "Personalia";
$port 	  = "5432";

$conn = pg_connect("host=".$hostname." port=".$port." user=".$username." password=".$password." dbname=".$database."");

if(!$conn){
    echo "gagal";
}

$data = $_POST['data'];
$data = substr($data, 0, 99);
$noind = $_POST['noind'];
$model = $_POST['model'];
$permission = $_POST['permission']; //camera, location, phone, storage
$now = date('Y-m-d H:i:s');

$sql = "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) VALUES('$now', '$permission', '$data', '$noind', '$model', 'ABSENSI ONLINE', NULL);";

pg_query($conn, $sql);