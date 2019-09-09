<?php
$host = "dl.quick.com";
$user = "dl";
$pass = "qu1ck";
$db = "quickc01_dinas_luar_online";

$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn){
    echo "gagal";
}
?>