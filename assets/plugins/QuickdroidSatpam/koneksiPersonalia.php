<?php 

$hostname = "database.quick.com";
$username = "postgres";
$password = "password";
$database = "Personalia";
$port 	  = "5432";

$conn = pg_connect("host=".$hostname." port=".$port." user=".$username." password=".$password." dbname=".$database."");

if(!$conn){
    echo "gagal";
}
?>