<?php
foreach ($kom as $key) {
	$gpokok  = $key['gpokok'];
	$um		 = $key['um'];
	$lembur  = $key['lembur'];
	$nama 	 = $key['nama'];
	$jabatan = $key['pekerjaan'];
	$periodes = $periode;
	$lain = "";
	$nomlain = "";
	for ($i=0; $i < 8; $i++) { 
		if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
			$nomgpokok = $nom[$i]['nominal'];
		}
		if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
			$nomum = $nom[$i]['uang_makan'];
		}
	}
		
?>

<html>
<head>
</head>
</style>
<body>
<?php 
		set_time_limit(0);
		ini_set("memory_limit", "2048M");
							
	?>
<div style="margin: 10px;">
	<table style="width:100%; padding: 0px; font-size: 12px">
		<tr>
			<td style="width: 10%" rowspan="5">
				<img style="height: 80px; width: 70px" src="<?php echo base_url('/assets/img/logo.png') ?>" />
			</td>
			<td style="width: 46%;">
				<p>CV. KARYA HIDUP SENTOSA</p>
			</td>
			<td style="width: 10%">
				<p>Tanggal</p>
			</td>
			<td colspan="2">
				<label><?php $period = explode(' - ', $periodes);echo date('d F Y',strtotime($period[0]));echo " - ";echo date('d F Y',strtotime($period[1]));?></label>
			</td>
		</tr>
		<tr>
			<td>
				<p>Pabrik Mesin Alat Pertanian, Pengecoran Logam,</p>
			</td>
			<td>
				<p>Nama</p>
			</td>
			<td style="width: 5px;">
				<p>:</p>
			</td>
			<td>
				<label><?php echo $nama ?></label>
			</td>
		</tr>
		<tr>
			<td>
				<p>Dealer Utama Diesel Kubota</p>
			</td>
			<td>
				<p>Jabatan</p>
			</td>
			<td>
				<p>:</p>
			</td>
			<td>
				<label><?php echo $jabatan ?></label>
			</td>
		</tr>
		<tr>
			<td>
				<p>Telp:(0274)512095,563217, Fax (0274 ) 563523</p>
			</td>
		</tr>
	</table>
</div>
<div style="width: 100%;">
	<div style="width: 100%; height: 3px; background-color: black;"></div>
	<div style="width: 100%; height: 3px; background-color: grey; margin-top: 1px"></div>
</div>
<div style="text-align: center">
	<p style="font-size: 17px; color: black"><b>SLIP GAJI</b></p>
</div>

<div>
	<table style="width: 100%; font-size: 14px;border-collapse:separate; border-spacing:0 5px;">
			<tr >
				<th style="width: 50px;">No</th>
				<th colspan="7" style="text-align: left; padding-left: 10px;">Keterangan</th>
				<th style="text-align: center;">Jumlah</th>
			</tr>
			<tr>
				<td style="width: 10px;text-align: center;">1</td>
				<td style="width: 200px;">Gaji Pokok</td>
				<td style="width: 70px;">
					<?php 
					if ($gpokok != null) {
						echo $gpokok;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td style="width: 60px;">hari</td>
				<td style="width: 40px;">x</td>
				<td style="width:30px;">Rp</td>
				<td style="width: 140px;">
					<?php 
					if ($nomgpokok != null) {
						echo $nomgpokok;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td style="width: 30px;">Rp</td>
				<td style="text-align: center;">
					<?php 
					if ($gpokok != null and $nomgpokok != null) {
						echo $gpokok*$nomgpokok;						
					}else{
						echo "...";
					}
					?>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">2</td>
				<td>Lembur</td>
				<td>
					<?php 
					if ($lembur != null) {
						echo $lembur;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td>jam</td>
				<td>x</td>
				<td>Rp</td>
				<td>
					<?php 
					if ($nomgpokok != null) {
						echo $nomgpokok/7;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td>Rp</td>
				<td style="text-align: center;">
					<?php 
					if ($lembur != null and $nomgpokok != null) {
						echo $lembur*($nomgpokok/7);						
					}else{
						echo "...";
					}
					?>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">3</td>
				<td>Uang Makan Hari Biasa</td>
				<td>
					<?php 
					if ($um != null) {
						echo $um;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td>hari</td>
				<td>x</td>
				<td>Rp</td>
				<td>
					<?php 
					if ($nomum != null) {
						echo $nomum;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td>Rp</td>
				<td style="text-align: center;">
					<?php 
					if ($um != null and $nomum != null) {
						echo $um*$nomum;						
					}else{
						echo "...";
					}
					?>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">4</td>
				<td>Lain-lain</td>
				<td>
					<?php 
					if ($lain != "") {
						echo $lain;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td>hari</td>
				<td>x</td>
				<td>Rp</td>
				<td>
					<?php 
					if ($nomlain != "") {
						echo $nomlain;						
					}else{
						echo "...";
					}
					?>
				</td>
				<td>Rp</td>
				<td style="text-align: center;">
					<?php 
					if ($lain != null and $nomlain != null) {
						echo $lain*$nomlain;						
					}else{
						echo "...";
					}
					?>
				</td>
			</tr>
			<tr>
				<td colspan="6"></td>
				<td>Total Diterima</td>
				<td style="border-top: 1px black solid;">Rp</td>
				<td style="text-align: center;"><?php echo ($gpokok*$nomgpokok)+($lembur*($nomgpokok/7))+($um*$nomum)+($lain*$nomlain)?></td>
			</tr>
	</table>
	<div style="margin-top: 50px;margin-left: 440px;font-size: 14px;">
		<label>Yogyakarta, <?php echo date('d F Y');?></label>
	</div>
	<div style="margin-top: 70px; margin-left: 230px; font-size: 14px;">
		<label><i><b>GAJIKU BERASAL DARI UANG PELANGGAN</b></i></label>
	</div>
</div>
</body>
</html>
<div style="<?php 
$co = count($kom);
if ($co > '1') {
	echo "page-break-before: always;";
}?>">
	
</div> 
<?php
}
?>