<?php 

$hostname = "192.168.168.85";
$username = "postgres";
$password = "password";
$database = "erp";
$port 	  = "5432";

$conn = pg_connect("host=".$hostname." port=".$port." user=".$username." password=".$password." dbname=".$database."");

if(!$conn){
    echo "gagal";
}
?>