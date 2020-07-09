<html>
<head>
</head>
<body>
<?php
		set_time_limit(0);
		ini_set("memory_limit", "2048M");

	?>
<?php 
	if (isset($latihan) && !empty($latihan)) {
		foreach ($latihan as $key => $value) {
			?>
			<div style="width: 100%;padding-right: 30px;">

			DAFTAR HADIR <?php echo $paket['0']['package_scheduling_name']?>
			<br>
			<table  style="width: 100%">
				<tbody>
					<tr>
						<td style="width: 60px;">Tanggal</td>
						<td style="width: 10px;">:</td>
						<td>
							<?php 
							if (isset($value['data']) && !empty($value['data'])) {
								$tanggal_pertama = "";
								$tanggal_terakhir = "";
								foreach ($value['data'] as $lt) {
									 $tanggal_terakhir = $lt['tanggal']; 
									 if ($tanggal_pertama == "") {
									 	$tanggal_pertama = $lt['tanggal'];
									 }
								}
								if ($tanggal_pertama !== $tanggal_terakhir) {
									echo $tanggal_pertama.' s/d '.$tanggal_terakhir;
								}else{
									echo $tanggal_pertama;
								}
										
							}
							?>
						</td>
						<td rowspan="4" style="text-align: right;">
				       <img style="height: 70px;" src="<?php echo base_url('/assets/img/admpelatihan_daftarhadir_tr.png') ?>" />
			          </td>

					</tr>
					<tr>
						<td style="width: 60px;">Waktu</td>
						<td style="width: 10px;">:</td>
						<td></td>
						
					</tr>
					<tr>
						<td style="width: 60px;">Ruang</td>
						<td style="width: 10px;">:</td>
						<td> </td>
						
						</tr>
					</tr>
				</tbody>
			</table>


			<table border="1" style="margin-left: 5px;font-size: 12px;margin-top: 10px;border-collapse: collapse;width: 100%;border: 1px solid black;">
				<thead>
					<tr>
						<th rowspan="3" style="background-color: yellow;width: 5%; height: 20px"><center>NO</center></th>
						<th rowspan="3" style="background-color: yellow;width: 5%"><center>NO INDUK</center></th>
						<th rowspan="3" style="background-color: yellow;width: 20%"><center>NAMA</center></th>
						<th rowspan="3" style="background-color: yellow;width: 25%"><center>SEKSI/UNIT</center></th>
						<th colspan="<?php echo $value['jumlah'] + 1 ?>" style="background-color: yellow; height: 20px"><center>PARAF</center></th>	
			        </tr>
			        <tr>
						<?php 
						if (isset($value['data']) && !empty($value['data'])) {
							foreach ($value['data'] as $lt) {
								?>
								<th colspan="<?php echo $lt['jumlah'] ?>" style="background-color: yellow;height: 20px"><center><?php echo $lt['tanggal']; ?></center></th>
								<?php
							}
						}
						?>
					</tr>
					<tr>
						<?php 
						if (isset($value['data']) && !empty($value['data'])) {
							foreach ($value['data'] as $lt) {
								if (isset($lt['latihan']) && !empty($lt['latihan'])) {
									foreach ($lt['latihan'] as $pk) {
										?>
										<th style="background-color: yellow;height: 20px;width:10%"><center><?php echo $pk; ?></center></th>
										<?php
									}
								}
							}
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (isset($peserta) && !empty($peserta)) { // jika ada peserta 
						$nomor = 1;
						foreach ($peserta as $pst) {
							?>
							<tr>
							    <td style="height: 20px ; border-bottom: 1px solid black;width: 5%;padding-left: 1px;  " ><center><?php echo $nomor; ?></center></td>
								<td style="height: 20px; border-bottom: 1px solid black;width: 5%;padding-left: 1px; "  ><center> <?php echo $pst['noind']?></center></td>
								<td style="height: 20px; border-bottom: 1px solid black;width: 20%;padding-left: 5px; "><?php echo $pst['employee_name']?></td>
								<td style="height: 20px; border-bottom: 1px solid black;width: 25%;padding-left: 5px; "><?php echo $pst['seksi']?></td>
								<?php 
								if (isset($value['data']) && !empty($value['data'])) {
									foreach ($value['data'] as $lt) {
										if (isset($lt['latihan']) && !empty($lt['latihan'])) {
											foreach ($lt['latihan'] as $pk) {
												?>
												<td style="height: 20px; border-bottom: 1px solid black;padding-left: 5px ;"><sup style="font-size: 6pt"><?php echo $nomor; ?></sup></td>
												<?php
											}
										}
									}
								}
								?>
							</tr>
							<?php
							$nomor++;
						}
						//$nomor--;
						if($nomor < 18){

							for ($i= $nomor; $i <= 18; $i++) { 
								?>
								<tr>
									<td style="height: 20px;  border-bottom: 1px solid black;width: 5%;padding-left: 1px; height: 20px" ><center><?php echo $nomor; ?></center></td>
									<td style="height: 20px; border-bottom: 1px solid black;width: 5%;padding-left: 1px; "  ></td>
									<td style="height: 20px; border-bottom: 1px solid black;width: 20%;padding-left: 5px; "></td>
									<td style="height: 20px; border-bottom: 1px solid black;width: 25%;padding-left: 5px; "></td>
									<?php 
									if (isset($value['data']) && !empty($value['data'])) {
										foreach ($value['data'] as $lt) {
											if (isset($lt['latihan']) && !empty($lt['latihan'])) {
												foreach ($lt['latihan'] as $pk) {
													?>
													<td style="height: 20px; border-bottom: 1px solid black;padding-left: 5px ;"><sup style="font-size: 6pt"><?php echo $nomor; ?></sup></td>
													<?php
												}
											}
										}
									}
									?>
								</tr>
								<?php
								$nomor++;
							}
						}

					}else{ 
					// jika tidak ada peserta
						$nomor = 1;
						for ($i=0 ; $i < 18; $i++) { 
							?>
							<tr>
								<td style=" border-bottom: 1px solid black;width: 5%;padding-left: 1px; height: 20px" ><center><?php echo $nomor; ?></center></td>
								<td style="border-bottom: 1px solid black;width: 5%;padding-left: 1px; "  ></td>
								<td style="border-bottom: 1px solid black;width: 20%;padding-left: 5px; "></td>
								<td style="border-bottom: 1px solid black;width: 25%;padding-left: 5px; "></td>
								<?php 
								if (isset($value['data']) && !empty($value['data'])) {
									foreach ($value['data'] as $lt) {
										if (isset($lt['latihan']) && !empty($lt['latihan'])) {
											foreach ($lt['latihan'] as $pk) {
												?>
												<td style="border-bottom: 1px solid black;padding-left: 5px ;"><sup style="font-size: 6pt"><?php echo $nomor; ?></sup></td>
												<?php
											}
										}
									}
								}
								?>
							</tr>
							<?php
							$nomor++;
						}
					}
					?>
				<!-- </tbody> -->
				<!-- <tfoot> -->
					<tr>
					 <td colspan="4" style=" border-left: 1px solid black ;border-bottom: 1px solid black; background-color: yellow;height: 20px"><center><b>TOTAL</b></center></td>
					 <?php 
					if (isset($value['data']) && !empty($value['data'])) {
						foreach ($value['data'] as $lt) {
							if (isset($lt['latihan']) && !empty($lt['latihan'])) {
								foreach ($lt['latihan'] as $pk) {
									?>
									<td style="border-bottom: 1px solid black;padding-left: 5px;background-color: yellow ;"><sup style="font-size: 4pt"></sup></td>
									<?php
								}
							}
						}
					}
					?>
					</tr>
					<tr><td colspan="<?= 4+$value['jumlah']+1 ?>" style="height: 20px !important; border-right: 1px  solid white; border-left: 1px solid white;"></td></tr>
					<tr><td colspan="3" rowspan="<?= count($trainer) + 1; ?>"  style="height: 20px; border-left: 1px solid white; border-top: 3px solid white;border-right: 1px solid black;border-bottom: 1px solid white"><font color="red">*</font> : BACA GAMBAR LAS<br><center><img style="width: 20%;" src="<?php echo base_url('/assets/img/admpelatihan_daftarhadir_ttd.png') ?>" /></center>
					</td>
					    <td style=" border: 1px solid black; border-top: 1px solid black; padding-left: 3px;background-color: yellow; height: 20px" ><center>TRAINER</center></td>
					    <td colspan="<?php echo $value['jumlah'] + 1 ?>" style=" border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;background-color: yellow;;padding-left: 5px; height: 20px" ><center>PARAF</center></td>
					<!-- </tr> -->
					

					    <?php 
					        
								if (isset($trainer) && !empty($trainer)) {
									foreach ($trainer as $tr) {
										?>
										<tr>

										<td style=" border-left: 1px solid black ;border-bottom: 1px solid black;padding-left: 1px; height: 20px" ><?php echo $tr['trainer_name']?><center> </center></td>
			                              <?php
			                            
									    	 	for ($i=0; $i < $value['jumlah'] +1  ; $i++) { ?>
									    	 		<td style="border-left: 1px solid black ;border-bottom: 1px solid black;border-right: 1px solid black;padding-left: 1px; "></td>
									    	 	
							        	<?php 
									        }
									      echo '</tr>';   
									    }
								    }
								?>
					</tr>
				</tbody>
			</table>

			<div style="page-break-after: always;"></div>
			<?php 
		}
	}
?>

</body>
</html>
