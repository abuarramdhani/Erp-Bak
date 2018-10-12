<?php
for ($i=0; $i < 2; $i++) { 
	
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
	<div style="width: 100%; height: 20px; border: 1px solid black; font-size: 18px;text-align: center;padding-top: -5px;">
		<p>SLIP PEMBAYARAN UPAH PEKERJA HARIAN PUSAT<br>PERIODE TANGGAL : <?php $period = explode(' - ', $periode); echo date('d F Y',strtotime($period[0])); echo " - "; echo date('d F Y',strtotime($period[1]));?></p>
	</div>
	<div style="width: 100%;height:500px;border-left: 1px solid black; border-right: 1px solid black;padding-top: 10px;">
		<table style="width: 100%;font-size: 16px;">
			<tr>
				<td style="width: 10%; text-align: center; height: 20px">NO</td>
				<td style="width: 40%;">NAMA PEKERJA</td>
				<td style="text-align: center;" colspan="2">PARAF</td>
			</tr>
			<?php
			$no=1;
			foreach ($pekerja as $key) {
				?>
				<tr>
					<td style="text-align: center;"><?php echo $no;?></td>
					<td><?php echo $key['nama'];?></td>
					<td colspan="2" style="
					<?php
					if ($no%2 == '0') {
						echo "text-align: right;";
					}
					?>"><?php echo $no;?>....................................</td>
				</tr>
				<?php
				$no++;
			}
			?>
		</table>
		<div style="margin-top: 120px;margin-left: 350px;font-size: 17px; width: 100%;">
			<label>Yogyakarta, <?php echo date('d-F-Y');?></label>
		</div>
		<table style="width: 100%;font-size: 17px;">
			<tr>
				<td style="width: 30%;text-align: center;">Menyetujui</td>
				<td style="width: 35%;text-align: center;">Mengetahui</td>
				<td style="text-align: center;">Penanggung Jawab</td>
			</tr>
		</table>
		<table style="margin-top: 50px;font-size: 17px; text-align: center; width: 100%">
			<tr>
				<td style="width: 30%;text-align: center;">Bambang Yudhosuseno</td>
				<td style="width: 35%;text-align: center;">Eko Prasetyo Adhi</td>
				<td><?php if ($i == '0'){echo "Mugiyana";}else{echo "Tukimin PHP";}?></td>
			</tr>
		</table>
		<table style="font-size: 17px; text-align: center; width: 100%;border-bottom: 1px solid black;">
			<tr>
				<td style="width: 30%;text-align: center;">Ass. Ka. Dept. Personalia</td>
				<td style="width: 35%;text-align: center;">Kasie Civil Maintenance</td>
				<td><?php if ($i == '0'){echo "Kepala Tukang";}else{echo "Supervisor";}?></td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>
<?php if($i == '0'){
	echo "<div style='page-break-after:always;';></div>";
	}?>
<?php
}
?>
