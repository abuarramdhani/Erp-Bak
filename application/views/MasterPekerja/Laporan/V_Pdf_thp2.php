<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="width: 21cm; height: 33cm;margin-top: 0px; font-size: 12px;max-height: 33cm; background-image: url(<?php echo base_url('assets/img/lkk2-tahap1.jpg')?>); background-size: 100% 120%; background-blend-mode: normal; background-position: top center">
		<div style="position: relative; padding-top: 245px; padding-left: 19px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 9px; word-spacing: -3px;"><?php echo $data['nama_perusahaan']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 21px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;"><?php echo $data['kode_mitra']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; margin-top: -1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td height="24px"><?php echo $data['alamat_perusahaan']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 90px; margin-top: 3px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="132px" height="17px"><?php echo $data['desa_perusahaan']; ?></td>
					<td width="180px"><?php echo $data['kec_perusahaan']; ?></td>
					<td ><?php echo $data['kota_perusahaan']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; margin-top: -1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td height="25px" style="letter-spacing: 10px; word-spacing: -8px;">
						<?php
						if ($data['kode_mitra'] == "LL031935" or $data['kode_mitra'] == "LL030002") {
							$notelp = $data['no_telp_perusahaan'];
							$no_telp1 = substr($notelp,0,-14);
							echo $no_telp1; 
						}else {
							echo $data['no_telp_perusahaan'];
						}
						?>							
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; margin-top: -4px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="vertical-align: top; letter-spacing: 9px; word-spacing: -1px;"><?php echo $data['nama_kontak_p']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; margin-top: 11px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="
					<?php
						$nama = $data['nama_peserta'];
						$jmlnama = strlen($nama);
						$pecah_nama = explode(" ", $nama);
						$jmlarray = count($pecah_nama);
						$vari 	= $jmlarray-1;
						$lastname = $pecah_nama[$vari];
						$jmllast = strlen($lastname);
						$varila  = $jmllast-1;
						$lastawal = substr($lastname, 0, $jmllast-$varila);

						if ($jmlnama <= 25) {
						 	echo "letter-spacing: 9px;word-spacing: 0px";
						 }else{
						 	echo "padding-left: 0px; letter-spacing: 9px;word-spacing: -6px;";
						 }
					?>
					">
						<?php
							$nama = $data['nama_peserta'];
							$jmlnama = strlen($nama);
							$pecah_nama = explode(" ", $nama);
							$jmlarray = count($pecah_nama);
							$vari 	= $jmlarray-1;
							$lastname = $pecah_nama[$vari];
							$jmllast = strlen($lastname);
							$varila  = $jmllast-1;
							$lastawal = substr($lastname, 0, $jmllast-$varila);
							if ($jmlnama <= 25) {
								echo $nama;
							} else {
								for ($nm=0; $nm <= $vari; $nm++) { 
									if ($nm < $vari) {
										echo $pecah_nama[$nm];
										echo " ";
									}
									if ($nm == $vari) {
										echo $lastawal;
									}	
								}							
							}
						?>							
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: 1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;">
						<?php
						$nmrP = str_replace(" ", "", $data['nomor_peserta']);
						if ($nmrP != null) {
						 	echo $data['nomor_peserta'];
						 }else if ($nmrP == ""){
						 	echo "-";
						 }else{
						 	echo "-";
						 }
						 
						  ?>				
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: 1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="119px" >
						<table style="width: 16px; margin-left: -5px; margin-top: -3px;">
							<tr>
								<td height="13px">
									<?php if ($data['jenkel_peserta'] == "L") {
									?>
									<p>V</p>
									<?php
									} ?>									
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 16px; margin-left: -5px; margin-top: -3px;">
							<tr>
								<td height="13px">
									<?php if ($data['jenkel_peserta'] == "P") {
									?>
									<p>V</p>
									<?php
									} ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 44px; margin-top: -4px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: 9px;"><?php echo date('d m Y', strtotime($data['tgl_lahir'])); ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: 0px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="word-spacing: 2px; letter-spacing: 1px;"><?php echo $data['alamat_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 90px; margin-top: 0px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="132px"> <?php echo $data['desa_peserta']; ?></td>
					<td width="180px"><?php echo $data['kec_peserta']; ?></td>
					<td><?php echo $data['kota_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 115px; margin-top: 1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="182px" style="word-spacing: 79px; letter-spacing: 10px;"> <?php echo $data['kode_pos1']; ?> </td>				
					<td style="letter-spacing: 10px;"> <?php $telp = str_replace(" ", "", $data['no_telp_peserta']); echo $telp; ?> </td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: 3px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td> <?php echo $data['jabatan_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: 12px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td><?php echo $data['unit_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 44px; margin-top: 11px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: 9px;"><?php echo date('d m Y', strtotime($data['tgl_kk'])); ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 13px; margin-top: 8px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td>
						<table style="width: 16px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['disampaikan'] == "Belum disampaikan") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 13px; margin-top: 9px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="170px">
						<table style="width: 16px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['disampaikan'] == "Sudah disampaikan") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td style="letter-spacing: 10px; word-spacing: 9px;">
						<?php 
							if ($data['disampaikan'] == "Sudah disampaikan") {
								echo date('d m y', strtotime($data['tgl_sampai'])); 								
							}else {
								echo "-";
							}
						?>							
					</td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: 17px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="84px">
						<table style="width: 17px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['pengajuan'] == "Perusahaan") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td width="81px">
						<table style="width: 16px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['pengajuan'] == "Peserta") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td width="150px">
						<table style="width: 17px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['pengajuan'] == "Faskes Trauma Center") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td >
						<table style="width: 16px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['pengajuan'] == "Ahli Waris") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 43px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;">
						<?php
						if ($biaya[0]['nominal'] != null) {
							echo $biaya[0]['nominal'];
						}
						?>				
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 43px;
		<?php
		if ($biaya[0]['nominal'] == null) {
			echo "margin-top: 22px;";
		}else {
			echo "margin-top: 5px;";
		}
		?> ">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;">
						<?php
						if ($biaya[1]['nominal'] != null) {
							echo $biaya[1]['nominal'];
						}
						?>				
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 43px; 
		<?php
		if ($biaya[1]['nominal'] == null) {
			echo "margin-top: 22px;";
		}else {
			echo "margin-top: 6px;";
		}
		?> ">
			<table style=" font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;">
						<?php
						if ($biaya[2]['nominal'] != null) {
							echo $biaya[2]['nominal'];
						}
						?>				
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 43px;
		<?php
		if ($biaya[2]['nominal'] == null) {
			echo "margin-top: 22px;";
		}else {
			echo "margin-top: 7px;";
		}
		?> ">
			<table style=" font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;">
						<?php
						if ($biaya[3]['nominal'] != null) {
							echo $biaya[3]['nominal'];
						}
						?>				
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 43px; 
		<?php
		if ($biaya[3]['nominal'] == null) {
			echo "margin-top: 18px;";
		}else {
			echo "margin-top: 3px;";
		}
		?> ">
			<table style=" font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;">
						<?php
						if ($biaya[4]['nominal'] != null) {
							echo $biaya[4]['nominal'];
						}
						?>				
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px;
		<?php
		if ($biaya[4]['nominal'] == null) {
			echo "margin-top: 19px;";
		}else {
			echo "margin-top: 5px;";
		}
		?> ">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="84px">
						<table style=" width: 17px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['penerima'] == "Perusahaan") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td width="81px">
						<table style="width: 16px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['penerima'] == "Peserta") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td width="84px">
						<table style="width: 17px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['penerima'] == "Faskes Trauma Center") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>
					<td >
						<table style="width: 16px;">
							<tr>
								<td height="13px;">
									<?php
									if ($data['penerima'] == "Ahli Waris") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 116px; margin-top: 8px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="215px" style="letter-spacing: 10px; word-spacing: -8px">
						<?php
						if ($stmb[0]['periode_awal'] != null and $stmb[0]['periode_akhir'] != null) {
							echo date('d m Y', strtotime($stmb[0]['periode_awal']));
						}
						?>
					</td>
					<td style="letter-spacing: 10px; word-spacing: -8px">
						<?php
						if ($stmb[0]['periode_awal'] != null and $stmb[0]['periode_akhir'] != null) {
							echo date('d m Y', strtotime($stmb[0]['periode_akhir']));
						}
						?>
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 257px; margin-top: 17px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px">
						<?php
						if ($stmb[0]['nominal'] != null){
							echo $stmb[0]['nominal'];
						}
						?>
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 116px; margin-top: 11px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="215px" style="letter-spacing: 10px; word-spacing: -8px">
						<?php
						if ($stmb[1]['periode_awal'] != null and $stmb[1]['periode_akhir'] != null and $stmb[1]['nominal'] != null) {
							echo date('d m Y', strtotime($stmb[1]['periode_awal']));
						}
						?>
					</td>
					<td style="letter-spacing: 10px; word-spacing: -8px">
						<?php
						if ($stmb[1]['periode_awal'] != null and $stmb[1]['periode_akhir'] != null and $stmb[1]['nominal'] != null) {
							echo date('d m Y', strtotime($stmb[1]['periode_akhir']));
						}
						?>
					</td>									
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 257px; margin-top: 13px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px">
						<?php
						if ($stmb[1]['nominal'] != null){
							echo $stmb[1]['nominal'];
						}
						?>
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px;
		<?php
		if ($stmb[1]['nominal'] == null) {
			echo "margin-top: 101px;";
		}else {
			echo "margin-top: 73px;";
		}
		?> "> 
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td >
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['keterangan_dokter'] == "Terlampir") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: -1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td >
						<table style="width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['keterangan_dokter'] == "Tidak Terlampir") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>
					</td>						
				</tr>
			</table>
		</div>
		
	</div>
	<div style="width: 21cm; height: 33cm;margin-top: 0px; font-size: 12px;max-height: 33cm; background-image: url(<?php echo base_url('assets/img/lkk2-tahap2.jpg')?>); background-size: 100% 120%; background-blend-mode: normal; padding-top: 120px;">
		<div style="position: relative; padding-left: 140px; margin-top: 64px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<?php
							echo date('d m Y', strtotime($data['tgl_kk4']));
						?>							
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: 7px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<table style=" width: 17px;
						<?php
							foreach ($kk4 as $key => $value) {
								$ukk[] = $value['id_ket_kk4'];
							}
							if (in_array("1", $ukk)) {
								echo "padding-bottom: -4px; margin-left: 2px;";
							}
							?>">
							<tr>
								<td height="13px">
									<?php
									foreach ($kk4 as $key => $value) {
										$ukk[] = $value['id_ket_kk4'];
									}
									if (in_array("1", $ukk)) {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: -1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<table style=" width: 17px; 
						<?php
							foreach ($kk4 as $key => $value) {
								$ukk[] = $value['id_ket_kk4'];
							}
							if (in_array("2", $ukk)) {
								echo "padding-bottom: -4px; margin-left: 2px; margin-top: -5px; padding-top: 4px;";
							}
							?>">
							<tr>
								<td height="13px">
									<?php
									foreach ($kk4 as $key => $value) {
										$ukk[] = $value['id_ket_kk4'];
									}
									if (in_array("2", $ukk)) {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<table style=" width: 17px; margin-top: 3px;
						<?php
							foreach ($kk4 as $key => $value) {
								$ukk[] = $value['id_ket_kk4'];
							}
							if (in_array("3", $ukk)) {
								echo "padding-bottom: -4px; margin-left: 2px; margin-top: -3px;";
							}
							if (in_array("2", $ukk) and (in_array("3", $ukk))) {
								echo "margin-top: 0px;";
							}
							?>">
							<tr>
								<td height="13px">
									<?php
									foreach ($kk4 as $key => $value) {
										$ukk[] = $value['id_ket_kk4'];
									}
									if (in_array("3", $ukk)) {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<table style=" width: 17px; margin-top: 5px;
						<?php
							foreach ($kk4 as $key => $value) {
								$ukk[] = $value['id_ket_kk4'];
							}
							if (in_array("4", $ukk)) {
								echo "padding-bottom: -4px; margin-left: 2px; padding-top: 4px;margin-top: -3px;";
							}
							?>">
							<tr>
								<td height="13px">
									<?php
									foreach ($kk4 as $key => $value) {
										$ukk[] = $value['id_ket_kk4'];
									}
									if (in_array("4", $ukk)) {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<table style=" width: 17px;
						<?php
							foreach ($kk4 as $key => $value) {
								$ukk[] = $value['id_ket_kk4'];
							}
							if (in_array("5", $ukk)) {
								echo "padding-bottom: -4px; margin-left: 2px; margin-top: -3px;";
							}
							?>">
							<tr>
								<td height="13px">
									<?php
									foreach ($kk4 as $key => $value) {
										$ukk[] = $value['id_ket_kk4'];
									}
									if (in_array("5", $ukk)) {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: -3px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<table style=" width: 17px;
						<?php
							foreach ($kk4 as $key => $value) {
								$ukk[] = $value['id_ket_kk4'];
							}
							if (in_array("6", $ukk)) {
								echo "padding-bottom: -4px; margin-left: 2px; margin-top: -3px; padding-top: 2px;";
							}
							if (in_array("5", $ukk)) {
								echo "margin-top: -1px";
							}

							?>">
							<tr>
								<td height="13px">
									<?php
									foreach ($kk4 as $key => $value) {
										$ukk[] = $value['id_ket_kk4'];
									}
									if (in_array("6", $ukk)) {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 12px; margin-top: -3px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<table style=" width: 17px;
						<?php
							foreach ($kk4 as $key => $value) {
								$ukk[] = $value['id_ket_kk4'];
							}
							if (in_array("7", $ukk)) {
								echo "padding-bottom: -7px; margin-left: 2px; margin-top: 0px;";
							}else {
								echo "margin-bottom: -4px;";
							}
							if (in_array("6", $ukk)) {
								echo "margin-top: -1px; padding-bottom: -7px;";
							}
							?>">
							<tr>
								<td height="13px">
									<?php
									foreach ($kk4 as $key => $value) {
										$ukk[] = $value['id_ket_kk4'];
									}
									if (in_array("7", $ukk)) {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 42px; margin-top: 19px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<?php
						echo $data['santunan'];
						?>			
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 18px; margin-top: 76px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="
						<?php
						$nama = $data['p_nama'];
						$jmlnama = strlen($nama);
						$pecah_nama = explode(" ", $nama);
						$jmlarray = count($pecah_nama);
						$vari 	= $jmlarray-1;
						$lastname = $pecah_nama[$vari];
						$jmllast = strlen($lastname);
						$varila  = $jmllast-1;
						$lastawal = substr($lastname, 0, $jmllast-$varila);

						if ($jmlnama <= 25) {
						 	echo "letter-spacing: 9px;word-spacing: -6px";
						 }else{
						 	echo "padding-left: 0px; letter-spacing: 9px;word-spacing: -6px;";
						 }
					?>
					">
						<?php
							$nama = $data['p_nama'];
							$jmlnama = strlen($nama);
							$pecah_nama = explode(" ", $nama);
							$jmlarray = count($pecah_nama);
							$vari 	= $jmlarray-1;
							$lastname = $pecah_nama[$vari];
							$jmllast = strlen($lastname);
							$varila  = $jmllast-1;
							$lastawal = substr($lastname, 0, $jmllast-$varila);
							if ($jmlnama <= 25) {
								echo $nama;
							} else {
								for ($nm=0; $nm <= $vari; $nm++) { 
									if ($nm < $vari) {
										echo $pecah_nama[$nm];
										echo " ";
									}
									if ($nm == $vari) {
										echo $lastawal;
									}	
								}							
							}
						?>						
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 18px; margin-top: 1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -8px;">
						<?php
						echo $data['p_nik'];
						?>			
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 13px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="82px">
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Janda/Duda") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>
					<td width="66px">
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Anak") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>
					<td width="82px">
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Ayah/Ibu") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>
					<td width="100px">
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Kakek/Nenek") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>
					<td >
						<table style="width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Cucu") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>						
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 13px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="148px">
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Saudara Kandung") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>					
					<td width="82px">
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Mertua") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>
					<td>
						<table style=" width: 17px;">
							<tr>
								<td height="13px">
									<?php
									if ($data['p_status'] == "Pihak yang ditunjuk dalam wasiat") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>		
					</td>										
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; margin-top: 0px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td >
						<?php
							echo $data['p_alamat'];
						?>						
					</td>										
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 85px; margin-top: -1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="136px">
						<?php
							echo $data['desa'];
						?>						
					</td>
					<td width="177px">
						<?php
							echo $data['kecamatan'];
						?>						
					</td>
					<td >
						<?php
							echo $data['kota'];
						?>						
					</td>										
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 114px; margin-top: 1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="182px" style="letter-spacing: 10px;">
						<?php
							echo $data['kode_pos'];
						?>						
					</td>
					<td style="letter-spacing: 10px;">
						<?php
							echo $data['no_telp'];
						?>						
					</td>
														
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 18px; margin-top: 1px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;">
						<?php
							echo $data['no_rekening'];
						?>						
					</td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 18px; margin-top: 0px;">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -5px;">
						<?php
							echo $data['nama_bank'];
						?>						
					</td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 13px; margin-top: 26px;
		<?php
		if ($data['p_nama'] == null) {
			echo "margin-top: 134px;";
		}
		?>">
			<table style="font-family: arial black; font-size: 12px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td >
						<table style=" width: 200px; vertical-align: top;">
							<tr>
								<td height="100px">
									<?php
										echo $data['ket_lain'];
									?>
								</td>
							</tr>
						</table>												
					</td>					
				</tr>
			</table>
		</div>


	</div>
</body>
</html>