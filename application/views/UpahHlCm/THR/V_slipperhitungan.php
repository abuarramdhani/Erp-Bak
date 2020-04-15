<?php
if (isset($data) and !empty($data)) {
	$datake=-1;
	foreach ($data as $dt) {
	$datake++;
?>

<html>
<head>
</head>
<body>
<?php 
		set_time_limit(0);
		ini_set("memory_limit", "2048M");
							
	?>
<div style="margin: 10px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 2px;padding-top: 10mm">
	<table style="width:100%; padding: 0px; font-size: 11px; font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
		<tr>
			<td style="width: 10%" rowspan="5"></td>
			<td style="width: 46%;">
			</td>
			<td style="width: 10%">
				<p>Tanggal</p>
			</td>
			<td style="width: 5px;">
				<p>:</p>
			</td>
			<td>
				<label><?php echo date('d F Y',strtotime($tanggal));?></label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p>Nama</p>
			</td>
			<td style="width: 5px;">
				<p>:</p>
			</td>
			<td>
				<label><?php echo substr($dt['employee_name'],0,25) ?> / <?php echo $dt['noind'] ?></label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<p>Jabatan</p>
			</td>
			<td>
				<p>:</p>
			</td>
			<td>
				<label><?php echo $dt['pekerjaan'] ?></label>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
</div>
<div>
	<table style="width: 90%; font-size: 11px;border-collapse:separate; border-spacing:0 5px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px; margin-left: 5%;margin-right: 7%;margin-top: 20mm;margin-bottom: 10px;">
			<tr >
				<th style="width: 50px;">No</th>
				<th colspan="7" style="text-align: left; padding-left: 10px;">Keterangan</th>
				<th style="text-align: center;">Jumlah</th>
			</tr>
				<tr>
					<td style="width: 10px;text-align: center;">1</td>
					<td style="width: 200px;">Tunjangan Hari Raya</td>
					<td style="width: 70px;text-align: right;padding-right: 10%"></td>
					<td style="width: 60px;"></td>
					<td style="width: 40px;"></td>
					<td style="width:30px;"></td>
					<td style="width: 140px;text-align: right;padding-right: 10%"></td>
					<td style="width: 30px;">Rp</td>
					<td style="text-align: right;">
						<?php 
						if ($dt['nominal_thr'] != null) {
							echo number_format($dt['nominal_thr'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">&nbsp;</td>
					<td></td>
					<td style="text-align: right;padding-right: 10%"></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;padding-right: 10%"></td>
					<td></td>
					<td style="text-align: right;"></td>
				</tr>
				<tr>
					<td style="text-align: center;">&nbsp;</td>
					<td></td>
					<td style="text-align: right;padding-right: 10%"></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;padding-right: 10%"></td>
					<td></td>
					<td style="text-align: right;"></td>
				</tr>
				<tr>
					<td style="text-align: center;">&nbsp;</td>
					<td></td>
					<td style="text-align: right;padding-right: 10%"></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;padding-right: 10%"></td>
					<td></td>
					<td style="text-align: right;"></td>
				</tr>
			
			<tr>
				<td style="text-align: center;">&nbsp;</td>
				<td></td>
				<td style="text-align: right;padding-right: 10%"></td>
				<td></td>
				<td></td>
				<td></td>
				<td style="text-align: right;padding-right: 10%"></td>
				<td></td>
				<td style="text-align: right;"></td>
			</tr>
			<tr>
				<td colspan="6"></td>
				<td>Total Diterima</td>
				<td style="border-top: 1px black solid;">Rp</td>
				<td style="text-align: right;"><?php echo number_format($dt['nominal_thr'],'0',',','.') ?></td>
			</tr>
	</table>
	
	<div style="margin-left: 230px; font-size: 11px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
		<label><i><b>GAJIKU BERASAL DARI UANG PELANGGAN</b></i></label>
	</div>
		
</div>
</body>
</html>
<div style="<?php 
$co = count($data);
if ($co > '1' && $datake!=($co-1)) {
	echo "page-break-before: always;";
}?>">
	
</div> 
<?php
	}
}
?>