<?php
    http_response_code(200);
    error_reporting(0);
    @ini_set('display_errors', 0);

    include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Selamat Datang di API ERP kami</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <h1>Selamat Datang di API ERP kami</h1>
    <h3>Status Server : <?php
        if ($conn->connect_error) {
            http_response_code(502);
            ?>
            <span style="color:red">Down</span>
            <?php
        } else{
            ?>
            <span style="color:green">Up</span>
            <?php
        }
    ?></h3>
</body>
</html>