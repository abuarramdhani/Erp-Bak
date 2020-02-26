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
	<div style="width: 100%; height: 20px; border: 1px solid black; font-size: 14px;text-align: center;padding-top: -5px;">
		<p>SLIP PEMBAYARAN UPAH PEKERJA HARIAN <?php if($i=='0'){echo "PUSAT";}else{echo "TUKSONO";}?><br>PERIODE TANGGAL : 
		<?php 
		$period = explode(' - ', $periode);
		$month1=date('m',strtotime($period[0]));
		$month2=date('m',strtotime($period[1]));
		echo date('d',strtotime($period[0]));
				if ($month1=='01') {
					echo " Januari ";
				}elseif ($month1=='02') {
					echo " Februari ";
				}elseif ($month1=='03') {
					echo " Maret ";
				}elseif ($month1=='04') {
					echo " April ";
				}elseif ($month1=='05') {
					echo " Mei ";
				}elseif ($month1=='06') {
					echo " Juni ";
				}elseif ($month1=='07') {
					echo " Juli ";
				}elseif ($month1=='08') {
					echo " Agustus ";
				}elseif ($month1=='09') {
					echo " September ";
				}elseif ($month1=='10') {
					echo " Oktober ";
				}elseif ($month1=='11') {
					echo " November ";
				}elseif ($month1=='12') {
					echo " Desember ";
				};
		echo date('Y',strtotime($period[0]));
		echo " - ";
		echo date('d',strtotime($period[1]));
		if ($month2=='01') {
					echo " Januari ";
				}elseif ($month2=='02') {
					echo " Februari ";
				}elseif ($month2=='03') {
					echo " Maret ";
				}elseif ($month2=='04') {
					echo " April ";
				}elseif ($month2=='05') {
					echo " Mei ";
				}elseif ($month2=='06') {
					echo " Juni ";
				}elseif ($month2=='07') {
					echo " Juli ";
				}elseif ($month2=='08') {
					echo " Agustus ";
				}elseif ($month2=='09') {
					echo " September ";
				}elseif ($month2=='10') {
					echo " Oktober ";
				}elseif ($month2=='11') {
					echo " November ";
				}elseif ($month2=='12') {
					echo " Desember ";
				};
		echo date('Y',strtotime($period[1]));
		?>
		</p>
	</div>
	<div style="width: 100%;height:auto;border-left: 1px solid black; border-right: 1px solid black;padding-top: 10px;">
		<table style="width: 70%;font-size: 11px;width: 100%">
			<tr>
				<td style="width: 10%; text-align: center; height: 20px">NO</td>
				<td style="width: 10%; text-align: center; height: 20px">NO INDUK</td>
				<td style="width: 37%;">NAMA PEKERJA</td>
				<td style="width: 90px;text-align: center;" colspan="2">PARAF</td>
			</tr>
			<?php
			$no=1;
			foreach ($pekerja as $key) {
				if ($i=='0') {
					if ($key['lokasi_kerja']=='01') {
						?>
						<tr>
							<td style="text-align: center;"><?php echo $no;?></td>
							<td style="text-align: center;"><?php echo $key['noind'];?></td>
							<td><?php echo $key['nama'];?></td>
							<?php
							if ($no%2 == '0') {
								?>
									<td></td>
									<td><?php echo $no;?>....................................</td>
								<?php
							}else{
								?>
									<td><?php echo $no;?>....................................</td>
									<td></td>
								<?php
							}
							?>
						</tr>
						<?php
						$no++;
						}
					}elseif ($i=='1') {
						if ($key['lokasi_kerja']=='02') {
							?>
							<tr>
								<td style="text-align: center;"><?php echo $no;?></td>
								<td style="text-align: center;"><?php echo $key['noind'];?></td>
								<td><?php echo $key['nama'];?></td>
								<?php
								if ($no%2 == '0') {
									?>
										<td></td>
										<td><?php echo $no;?>....................................</td>
									<?php
								}else{
									?>
										<td><?php echo $no;?>....................................</td>
										<td></td>
									<?php
								}
								?>
							</tr>
							<?php
							$no++;
						}
					}
					
				}
			?>
		</table>
		<div style="margin-top: 60px;margin-left: 350px;font-size: 13px; width: 100%;">
			<label>Yogyakarta, <?php 
				echo date('d');
				$month=date('m');
				if ($month=='01') {
					echo " Januari ";
				}elseif ($month=='02') {
					echo " Februari ";
				}elseif ($month=='03') {
					echo " Maret ";
				}elseif ($month=='04') {
					echo " April ";
				}elseif ($month=='05') {
					echo " Mei ";
				}elseif ($month=='06') {
					echo " Juni ";
				}elseif ($month=='07') {
					echo " Juli ";
				}elseif ($month=='08') {
					echo " Agustus ";
				}elseif ($month=='09') {
					echo " September ";
				}elseif ($month=='10') {
					echo " Oktober ";
				}elseif ($month=='11') {
					echo " November ";
				}elseif ($month=='12') {
					echo " Desember ";
				};
				echo date('Y');
			?></label>
		</div>
		<table style="width: 100%;font-size: 13px;">
			<tr>
				<td style="width: 30%;text-align: center;"><!-- Menyetujui --></td>
				<td style="width: 35%;text-align: center;">Mengetahui</td>
				<td style="text-align: center;">Penanggung Jawab</td>
			</tr>
		</table>
		<table style="margin-top: 50px;font-size: 13px; text-align: center; width: 100%; text-transform: lowercase;">
			<tr>
				<td style="width: 30%;text-align: center;">
					<!-- <?php
					foreach ($pj as $key) {
						if ($i == '0') {
							if ($key['id_status'] == '3' and $key['lokasi_kerja'] == '01') {
								$nama = strtolower($key['nama']);
								echo ucwords($nama);
							}
						}else {
							if ($key['id_status'] == '3' and $key['lokasi_kerja'] == '02') {
								$nama = strtolower($key['nama']);
								echo ucwords($nama);
							}
						} 
					}
					?> -->
				</td>
				<td style="width: 35%;text-align: center;">
					<?php
					foreach ($pj as $key) {
						if ($i == '0') {
							if ($key['id_status'] == '2' and $key['lokasi_kerja'] == '01') {
								$nama = strtolower($key['nama']);
								echo ucwords($nama);
							}
						}else {
							if ($key['id_status'] == '2' and $key['lokasi_kerja'] == '02') {
								$nama = strtolower($key['nama']);
								echo ucwords($nama);
							}
						} 
					}
					?>
				</td>
				<td>
					<?php
					foreach ($pj as $key) {
						if ($i == '0') {
							if ($key['id_status'] == '1' and $key['lokasi_kerja'] == '01') {
								$nama = strtolower($key['nama']);
								echo ucwords($nama);
							}
						}else {
							if ($key['id_status'] == '1' and $key['lokasi_kerja'] == '02') {
								$nama = strtolower($key['nama']);
								echo ucwords($nama);
							}
						} 
					}
					?>
				</td>
			</tr>
		</table>
		<table style="font-size: 13px; text-align: center; width: 100%;border-bottom: 1px solid black;">
			<tr>
				<td style="width: 30%;text-align: center;">
					<!-- <?php
					foreach ($pj as $key) {
						if ($i == '0') {
							if ($key['id_status'] == '3' and $key['lokasi_kerja'] == '01') {
								$jabatan = strtolower($key['jabatan']);
								echo ucwords($jabatan);
							}
						}else {
							if ($key['id_status'] == '3' and $key['lokasi_kerja'] == '02') {
								$jabatan = strtolower($key['jabatan']);
								echo ucwords($jabatan);
							}
						} 
					}
					?> -->
				</td>
				<td style="width: 35%;text-align: center;">
					<?php
					foreach ($pj as $key) {
						if ($i == '0') {
							if ($key['id_status'] == '2' and $key['lokasi_kerja'] == '01') {
								$jabatan = strtolower($key['jabatan']);
								echo ucwords($jabatan);
							}
						}else {
							if ($key['id_status'] == '2' and $key['lokasi_kerja'] == '02') {
								$jabatan = strtolower($key['jabatan']);
								echo ucwords($jabatan);
							}
						} 
					}
					?>
				</td>
				<td>
					<?php
					foreach ($pj as $key) {
						if ($i == '0') {
							if ($key['id_status'] == '1' and $key['lokasi_kerja'] == '01') {
								$jabatan = strtolower($key['jabatan']);
								echo ucwords($jabatan);
							}
						}else {
							if ($key['id_status'] == '1' and $key['lokasi_kerja'] == '02') {
								$jabatan = strtolower($key['jabatan']);
								echo ucwords($jabatan);
							}
						} 
					}
					?>
				</td>
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
