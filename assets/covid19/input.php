<?php 
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Input Data Map Covid-19</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME'].str_replace("covid19/input.php", "plugins/bootstrap/3.3.7/css/bootstrap.css", $_SERVER['REQUEST_URI']) ?>">
	    <link type="text/css" rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'].str_replace("covid19/input.php", 'theme/css/AdminLTE.min.css', $_SERVER['REQUEST_URI']) ?>" />
	    <link type="text/css" rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'].str_replace("covid19/input.php", 'theme/css/skins/_all-skins.min.css', $_SERVER['REQUEST_URI']) ?>" />
		<script src="http://<?php echo $_SERVER['SERVER_NAME'].str_replace("covid19/input.php", "plugins/jquery-2.1.4.min.js", $_SERVER['REQUEST_URI']) ?>" type="text/javascript"></script>
		<script src="http://<?php echo $_SERVER['SERVER_NAME'].str_replace("covid19/input.php", "plugins/bootstrap/3.3.7/js/bootstrap.min.js", $_SERVER['REQUEST_URI']) ?>" type="text/javascript"	></script>
	</head>
	<body class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="box box-solid box-primary">
					<div class="box-header with-border">
						
					</div>
					<div class="box-bbody">
						<div class="row">
							<div class="col-lg-12 text-center">
								<?php if (isset($_GET['kd']) && !empty($_GET['kd'])) {
									$kode = $_GET['kd'];
									$data_json = file_get_contents("http://".$_SERVER['SERVER_NAME'].str_replace("input.php", "jawa.json", $_SERVER['REQUEST_URI']));
									$data = json_decode($data_json);
									if (isset($_POST['txtRawat']) && !empty($_POST['txtRawat'])) {
										if (!empty($data)) {
											foreach ($data->features as $key1 => $value1) {
												foreach ($_POST['txtRawat'] as $key2 => $value2) {
													if (str_replace(".", "", $value1->properties->HASC_2) == $key2) {
														$data->features[$key1]->properties->dirawat = $value2;
													}
												}
											}
											$data_new = json_encode($data);
											file_put_contents(dirname(__FILE__)."/jawa.json", $data_new);
											echo "<h1>Perubahan Berhasil Disimpan</h1><br><a href=\"\">Klik Disini untuk menuju halaman utama edit</a>";
										}
									}else{
										if($kode == "ID.BT"){
											echo '<h1>Data Pasien Positif Dirawat Provinsi Banten</h1>';
										}elseif($kode == "ID.JR"){
											echo '<h1>Data Pasien Positif Dirawat Provinsi Jawa Barat</h1>';
										}elseif($kode == "ID.JK"){
											echo '<h1>Data Pasien Positif Dirawat Provinsi DKI Jakarta</h1>';
										}elseif($kode == "ID.JT"){
											echo '<h1>Data Pasien Positif Dirawat Provinsi Jawa Tengah</h1>';
										}elseif($kode == "ID.YO"){
											echo '<h1>Data Pasien Positif Dirawat Provinsi DI Yogyakarta</h1>';
										}elseif($kode == "ID.JI"){
											echo '<h1>Data Pasien Positif Dirawat Provinsi Jawa Timur</h1>';
										}
										?>
										<h2>Input Sesuai Dengan Data</h2>
										<form class="form-horizontal" action="" method="POST">
											<?php
											if (!empty($data)) {
												foreach ($data->features as $key => $value) {
													if (substr($value->properties->HASC_2, 0, 5) == $kode) {
														?>
														<div class="col-lg-4">
															<div class="form-group">
																<label class="col-lg-8 control-label"><?php echo "(".$value->properties->TYPE_2.") ".$value->properties->NAME_2 ?></label>
																<div class="col-lg-4">
																	<input type="number" name="txtRawat[<?php echo str_replace(".", "", $value->properties->HASC_2) ?>]" class="form-control" value="<?php echo $value->properties->dirawat ?>" placeholder="Jumlah Positif Dirawat">
																</div>
															</div>
														</div>
														<?php 
													}
												}
											}
											?>
											<div class="col-lg-12">
												<div class="form-group">
													<button type="submit" class="btn btn-primary">SIMPAN</button>
												</div>
											</div>
										</form>
										<?php
									}
								}else{
									?>
									<h1>Pilih Provinsi yang Ingin Diupdate !</h1>
									<hr>
									<a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'?kd=ID.BT' ?>" class="btn btn-primary">Update Banten</a>
									<a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'?kd=ID.JR' ?>" class="btn btn-primary">Update Jawa Barat</a>
									<a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'?kd=ID.JK' ?>" class="btn btn-primary">Update DKI Jakarta</a>
									<a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'?kd=ID.JT' ?>" class="btn btn-primary">Update Jawa Tengah</a>
									<a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'?kd=ID.YO' ?>" class="btn btn-primary">Update DI Yogyakarta</a>
									<a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'?kd=ID.JI' ?>" class="btn btn-primary">Update Jawa Timur</a>
									<hr>
									<br>
									<?php
								} ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>