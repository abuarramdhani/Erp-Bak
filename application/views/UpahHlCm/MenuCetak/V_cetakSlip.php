<?php
if (isset($res) and !empty($res)) {
	$datake=-1;
	foreach ($res as $key) {
		$lain = "";
		$nomlain = "";
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
<div style="margin: 10px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 2px;">
	<table style="width:100%; padding: 0px; font-size: 11px; font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
		<tr>
			<td style="width: 10%" rowspan="5"></td>
			<td style="width: 46%;">
			</td>
			<td style="width: 10%">
				<p>Tanggal</p>
			</td>
			<td colspan="2">
				<label><?php $period = explode(' - ', $periode);echo date('d F Y',strtotime($period[0]));echo " - ";echo date('d F Y',strtotime($period[1]));?></label>
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
				<label><?php echo $key['nama'] ?></label>
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
				<label><?php echo $key['pekerjaan'] ?></label>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
</div>
<div>
	<table style="width: 100%; font-size: 10px;border-collapse:separate; border-spacing:0 5px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
			<tr >
				<th style="width: 50px;">No</th>
				<th colspan="7" style="text-align: left; padding-left: 10px;">Keterangan</th>
				<th style="text-align: center;">Jumlah</th>
			</tr>
			<?php if (isset($key['gp'])) { ?>
				<tr>
					<td style="width: 10px;text-align: center;">1</td>
					<td style="width: 200px;">Gaji Pokok</td>
					<td style="width: 70px;">
						<?php 
						if ($key['gp'] != null) {
							echo $key['gp'];						
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
						if ($key['nomgp'] != null) {
							echo number_format($key['nomgp'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td style="width: 30px;">Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['gp'] != null and $key['nomgp'] != null) {
							echo number_format($key['gp']*$key['nomgp'],'0',',','.');						
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
						if ($key['lmbr'] != null) {
							echo $key['lmbr'];						
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
						if ($key['nomlmbr'] != null) {
							echo number_format($key['nomlmbr'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['lmbr'] != null and $key['nomlmbr'] != null) {
							echo number_format($key['lmbr']*($key['nomlmbr']),'0',',','.');						
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
						if ($key['um'] != null) {
							echo $key['um'];						
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
						if ($key['nomum'] != null) {
							echo number_format($key['nomum'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['um'] != null and $key['nomum'] != null) {
							echo number_format($key['um']*$key['nomum'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">4</td>
					<td>Uang Makan Puasa</td>
					<td>
						<?php 
						if ($key['ump'] != null) {
							echo $key['ump'];						
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
						if ($key['nomump'] != null) {
							echo number_format($key['nomump'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['ump'] != null and $key['nomump'] != null) {
							echo number_format($key['ump']*$key['nomump'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
			<?php }else{ ?>
				<tr>
					<td style="width: 10px;text-align: center;">1</td>
					<td style="width: 200px;">Gaji Pokok</td>
					<td style="width: 70px;">
						<?php 
						if ($key['gp1'] != null) {
							echo $key['gp1'];						
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
						if ($key['nomgp1'] != null) {
							echo number_format($key['nomgp1'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td style="width: 30px;">Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['gp1'] != null and $key['nomgp1'] != null) {
							echo number_format($key['gp1']*$key['nomgp1'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="width: 10px;text-align: center;"></td>
					<td style="width: 200px;">Gaji Pokok</td>
					<td style="width: 70px;">
						<?php 
						if ($key['gp2'] != null) {
							echo $key['gp2'];						
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
						if ($key['nomgp2'] != null) {
							echo number_format($key['nomgp2'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td style="width: 30px;">Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['gp2'] != null and $key['nomgp2'] != null) {
							echo number_format($key['gp2']*$key['nomgp2'],'0',',','.');						
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
						if ($key['lmbr1'] != null) {
							echo $key['lmbr1'];						
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
						if ($key['nomlmbr1'] != null) {
							echo number_format($key['nomlmbr1'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['lmbr1'] != null and $key['nomlmbr1'] != null) {
							echo number_format($key['lmbr1']*($key['nomlmbr1']),'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;"></td>
					<td>Lembur</td>
					<td>
						<?php 
						if ($key['lmbr2'] != null) {
							echo $key['lmbr2'];						
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
						if ($key['nomlmbr2'] != null) {
							echo number_format($key['nomlmbr2'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['lmbr2'] != null and $key['nomlmbr2'] != null) {
							echo number_format($key['lmbr2']*($key['nomlmbr2']),'0',',','.');						
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
						if ($key['um1'] != null) {
							echo $key['um1'];						
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
						if ($key['nomum1'] != null) {
							echo number_format($key['nomum1'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['um1'] != null and $key['nomum1'] != null) {
							echo number_format($key['um1']*$key['nomum1'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;"></td>
					<td>Uang Makan Hari Biasa</td>
					<td>
						<?php 
						if ($key['um2'] != null) {
							echo $key['um2'];						
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
						if ($key['nomum2'] != null) {
							echo number_format($key['nomum2'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['um2'] != null and $key['nomum2'] != null) {
							echo number_format($key['um2']*$key['nomum2'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">4</td>
					<td>Uang Makan Puasa</td>
					<td>
						<?php 
						if ($key['ump1'] != null) {
							echo $key['ump1'];						
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
						if ($key['nomump1'] != null) {
							echo number_format($key['nomump1'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['ump1'] != null and $key['nomump1'] != null) {
							echo number_format($key['ump1']*$key['nomump1'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;"></td>
					<td>Uang Makan Puasa</td>
					<td>
						<?php 
						if ($key['ump2'] != null) {
							echo $key['ump2'];						
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
						if ($key['nomump2'] != null) {
							echo number_format($key['nomump2'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
					<td>Rp</td>
					<td style="text-align: center;">
						<?php 
						if ($key['ump2'] != null and $key['nomump2'] != null) {
							echo number_format($key['ump2']*$key['nomump2'],'0',',','.');						
						}else{
							echo "...";
						}
						?>
					</td>
				</tr>
			<?php } ?>

			<?php 
			$nomor = 5;
			if($key['tambahan'] == 1 or $key['potongan'] == 1){
				if ($key['tambahan'] == 1) {
					?>
			<tr>
				<td style="text-align: center;"><?php echo $nomor ?></td>
				<td>Tambahan Gaji Pokok</td>
				<td><?php echo number_format($key['tambahan_gp'],'2','.','') ?></td>
				<td>hari</td>
				<td>x</td>
				<td>Rp</td>
				<td><?php echo number_format($key['tambahan_gp_per_a'],'0',',','.') ?></td>
				<td>Rp</td>
				<td style="text-align: center;"><?php echo number_format($key['tambahan_gp_total'],'0',',','.') ?></td>
			</tr>
			<tr>
				<td style="text-align: center;"></td>
				<td>Tambahan Lembur</td>
				<td><?php echo number_format($key['tambahan_lembur'],'2','.','') ?></td>
				<td>Jam</td>
				<td>x</td>
				<td>Rp</td>
				<td><?php echo number_format($key['tambahan_lembur_per_a'],'0',',','.') ?></td>
				<td>Rp</td>
				<td style="text-align: center;"><?php echo number_format($key['tambahan_lembur_total'],'0',',','.') ?></td>
			</tr>
			<tr>
				<td style="text-align: center;"></td>
				<td>Tambahan Uang Makan</td>
				<td><?php echo number_format($key['tambahan_um'],'2','.','') ?></td>
				<td>hari</td>
				<td>x</td>
				<td>Rp</td>
				<td><?php echo number_format($key['tambahan_um_per_a'],'0',',','.') ?></td>
				<td>Rp</td>
				<td style="text-align: center;"><?php echo number_format($key['tambahan_um_total'],'0',',','.') ?></td>
			</tr>
					<?php
					$nomor++;
				}

				if ($key['potongan'] == 1) {
					?>
			<tr>
				<td style="text-align: center;"><?php echo $nomor ?></td>
				<td>Potongan Gaji Pokok</td>
				<td><?php echo number_format($key['potongan_gp'],'2','.','') ?></td>
				<td>hari</td>
				<td>x</td>
				<td>Rp</td>
				<td><?php echo number_format($key['potongan_gp_per_a'],'0',',','.') ?></td>
				<td>Rp</td>
				<td style="text-align: center;"><?php echo number_format($key['potongan_gp_total'],'0',',','.') ?></td>
			</tr>
			<tr>
				<td style="text-align: center;"></td>
				<td>Potongan Lembur</td>
				<td><?php echo number_format($key['potongan_lembur'],'2','.','') ?></td>
				<td>Jam</td>
				<td>x</td>
				<td>Rp</td>
				<td><?php echo number_format($key['potongan_lembur_per_a'],'0',',','.') ?></td>
				<td>Rp</td>
				<td style="text-align: center;"><?php echo number_format($key['potongan_lembur_total'],'0',',','.') ?></td>
			</tr>
			<tr>
				<td style="text-align: center;"></td>
				<td>Potongan Uang Makan</td>
				<td><?php echo number_format($key['potongan_um'],'2','.','') ?></td>
				<td>hari</td>
				<td>x</td>
				<td>Rp</td>
				<td><?php echo number_format($key['potongan_um_per_a'],'0',',','.') ?></td>
				<td>Rp</td>
				<td style="text-align: center;"><?php echo number_format($key['potongan_um_total'],'0',',','.') ?></td>
			</tr>
					<?php
					$nomor++;
				}

			} ?>
			<tr>
				<td style="text-align: center;">
					<?php 
					echo $nomor;
					?>
				</td>
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
						echo number_format($nomlain,'0',',','.');						
					}else{
						echo "...";
					}
					?>
				</td>
				<td>Rp</td>
				<td style="text-align: center;">
					<?php 
					if ($lain != null and $nomlain != null) {
						echo number_format($lain*$nomlain,'0',',','.');						
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
				<td style="text-align: center;"><?php echo number_format($key['total_terima'],'0',',','.')?></td>
			</tr>
	</table>
	<?php if (isset($key['gp'])) { 
		if($key['tambahan'] == 1 or $key['potongan'] == 1){
			if ($key['tambahan'] == 0 or $key['potongan'] == 0) {
				?>
		<div style="margin-left: 230px; font-size: 14px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
			<label><i><b>GAJIKU BERASAL DARI UANG PELANGGAN</b></i></label>
		</div>
				<?php 
			}else{
				?>
		<div style="margin-left: 230px; font-size: 14px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
			<label><i><b>GAJIKU BERASAL DARI UANG PELANGGAN</b></i></label>
		</div>
				<?php 
			}
		}else{
			?>
		<div style="margin-left: 230px; font-size: 14px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
			<label><i><b>GAJIKU BERASAL DARI UANG PELANGGAN</b></i></label>
		</div>
			<?php 
		}
		?>
	<?php }else{ ?>
		<div style="margin-left: 230px; font-size: 14px;font-family: Arial, Helvetica, sans-serif; letter-spacing: 1px;">
			<label><i><b>GAJIKU BERASAL DARI UANG PELANGGAN</b></i></label>
		</div>
	<?php } ?>
		
</div>
</body>
</html>
<div style="<?php 
$co = count($res);
if ($co > '1' && $datake!=$co) {
	echo "page-break-before: always;";
}?>">
	
</div> 
<?php
	}
}
?>