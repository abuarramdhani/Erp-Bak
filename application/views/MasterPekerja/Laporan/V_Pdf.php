<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="width: 21cm; height: 33cm;margin-top: 0px; font-size: 11px;max-height: 33cm; background-image: url(<?php echo base_url('assets/img/kk-tahap1-mod.jpg')?>); background-size: 100% 120%; background-blend-mode: normal; background-position: top center">
		<!-- <table width="100%">
			<tr>
				<td style="margin-bottom: 0px;padding-bottom: 0px;" width="20%">
					<img src="<?php echo base_url('assets/img/bpjs-logo.png'); ?>" width="20%" style="margin-left: 9px;">
				</td>
				<td style="margin-top: 0px;">
					 <center><h1 style=" font-size: 14px; font-weight: normal;"><b>LAPORAN KASUS KECELAKAAN KERJA<br>TAHAP I</b></h1></center>
				</td> 
				<td width="20%">
					<table style="border: 2px solid black; margin:9px;" width="100%">
						<tr>
							<td height="50px">
								<center><p style="margin-top: 5px; font-size: 11px">Formulir <br> <b>3 KK 1</b> <br> BPJS Ketenagakerjaan</p></center>	
							</td>
						
						</tr>
					</table>
				</td>
			</tr>
		</table> -->
		<!-- <table width="100%" style="font-family:arial black; border-top: 1px solid black;border-bottom: 1px solid black; padding: 5px; background-color: skyblue;">
			<tr>
				<td height="45px">
					<center><p style="font-size: 12px; margin: 2px;"><b>Laporan Kasus Kecelakaan Kerja Tahap 1 <br> Wajib dilaporkan  dalam waktu 2 x 24 Jam sejak terjadi kasus kecelakaan kerja</b></p></center>
				</td>
			</tr>
		</table> -->
		<div style="position: relative; padding-top: 173px; padding-left: 19px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px; word-spacing: -7px;"><?php echo $data['nama_perusahaan']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 21px; padding-top: -2px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 10px;"><?php echo $data['kode_mitra']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; padding-top: -3px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td height="24px"><?php echo $data['alamat_perusahaan']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 90px; padding-top: -4px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="134px" height="17px"><?php echo $data['desa_perusahaan']; ?></td>
					<td width="180px"><?php echo $data['kec_perusahaan']; ?></td>
					<td ><?php echo $data['kota_perusahaan']; ?></td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; padding-top: -4px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="248px" height="25px" style="letter-spacing: 10px; word-spacing: -5px;">
						<?php
							$notelp = $data['no_telp_perusahaan'];
							$no_telp1 = substr($notelp,0,-14);
							echo $no_telp1; 
						?>							
					</td>
					<td height="25px" style="letter-spacing: 10px; word-spacing: -5px;">
						<?php
							$notelp = $data['no_telp_perusahaan'];
							$no_telp1 = substr($notelp,-12);
							echo $no_telp1; 
						?>							
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; padding-top: -5px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="vertical-align: top; letter-spacing: 10px; word-spacing: -6px;"><?php echo $data['nama_kontak_p']; ?></td>
				</tr>
			</table>
		</div>
		
		<!-- <table style="font-family: arial black; font-size: 12px; margin-top: 15px;" width="100%">
			<tr>
				<td width="3%"><center>2.</center></td>
				<td width="25%">Nama Peserta</td>
				<td width="3%"><center>: </center></td>
				<td><?php echo $data['nama_peserta']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="30px">Nomor Referensi / nomor Peserta</td>
				<td width="3%"><center>: </center></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="20px">Jenis Kelamin</td>
				<td width="3%"><center>: </center></td>
				<td><?php if ($data['jenkel_peserta'] == 'L') {
					echo "laki-laki";
				}elseif ($data['jenkel_peserta'] == 'P') {
					echo "Perempuan";
				} ?></td>
			</tr>
			<tr>
				<td></td>
				<td height="20px">Tanggal Lahir</td>
				<td><center>: </center></td>
				<td><?php echo date('d F Y', strtotime($data['tgl_lahir'])); ?></td>
			</tr>
			<tr>
				<td></td>
				<td height="20px">Alamat/ no telp</td>
				<td><center>: </center></td>
				<td><?php echo $data['alamat_peserta']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td height="20px"></td>
				<td></td>
				<td ><pre style="border: none; background-color: white; font-family: arial black; font-size: 12px;">Desa/Kel <?php echo $data['desa_peserta']; ?>    Kec <?php echo $data['kec_peserta']; ?>    Kota/Kab <?php echo $data['kota_peserta']; ?></pre></td>
			</tr>
			<tr>
				<td></td>
				<td height="20px"></td>
				<td></td>
				<td><pre style="border: none; background-color: white; font-family: arial black; font-size: 12px;">Kode Pos <?php echo $data['kode_pos']; ?>    No Telp/hp <?php echo $data['no_telp_peserta']; ?></pre></td>
			</tr>
			<tr>
				<td></td>
				<td height="20px">Jenis Pekerjaan/jabatan</td>
				<td><center>: </center></td>
				<td><?php echo $data['jabatan_peserta']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td height="20px">Unit / Bidang/ Bagian perusahaan</td>
				<td><center>: </center></td>
				<td><?php echo $data['unit_peserta']; ?></td>
			</tr>
		</table> -->
		<div style="position: relative; padding-left: 22px; margin-top: 6px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="
					<?php
						$nama = $data['nama_peserta'];
						$jmlnama = strlen($nama);
						$varr = $jmlnama-1;
						$pecah_nama = explode(" ", $nama);
						$jmlarray = count($pecah_nama);
						$vari 	= $jmlarray-1;
						$lastname = $pecah_nama[$vari];
						$jmllast = strlen($lastname);
						$varila  = $jmllast-1;
						$lastawal = substr($lastname, 0, $jmllast-$varila);						
						$hurufawal = substr($nama, 0, $jmlnama-$varr);
// 						echo $hurufawal;

						if ($jmlnama <= 25) {
							if ($hurufawal == "I") {
						 		echo "letter-spacing: 10px;word-spacing: -5px";
							}else {
						 		echo "letter-spacing: 10px;word-spacing: -5px; padding-left: -1px;";
						 	}							
						 }else{
						 	echo "padding-left: -1px; letter-spacing: 9px;word-spacing: -6px;";
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
		<div style="position: relative; padding-left: 20px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
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
		<div style="position: relative; padding-left: 20px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="119px" >
						<table style=" width: 16px; margin-left: -5px; margin-top: -3px;">
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
						<table style="width: 16px; margin-left: -8px; margin-top: -3px;">
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
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="letter-spacing: 11px; word-spacing: 6px;"><?php echo date('d m Y', strtotime($data['tgl_lahir'])); ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td style="word-spacing: 2px; letter-spacing: 1px;"><?php echo $data['alamat_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 88px; margin-top: 1px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="135px"> <?php echo $data['desa_peserta']; ?></td>
					<td width="180px"><?php echo $data['kec_peserta']; ?></td>
					<td><?php echo $data['kota_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 113px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="183px" style="word-spacing: 79px; letter-spacing: 10px;"> <?php echo $data['kode_pos']; ?> </td>				
					<td style="word-spacing: 79px; letter-spacing: 10px;"> <?php $telp = str_replace(" ", "", $data['no_telp_peserta']); echo $telp; ?> </td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: 0px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td> <?php echo $data['jabatan_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: 9px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td><?php echo $data['unit_peserta']; ?></td>					
				</tr>
			</table>
		</div>
		<!-- <table style="font-family: arial black; font-size: 12px; margin-top: 15px;" width="100%">
			<tr>
				<td width="3%"><center>3.</center></td>
				<td width="25%">Upah tenaga kerja yang diterima</td>
				<td width="3%"><center>: </center></td>
				<td><?php echo $data['upah_status']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="30px">Jumlah upah yang diterima</td>
				<td width="3%"><center>: </center></td>
				<td>Rp <?php echo $data['upah_nominal']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="20px">Terbilang upah yang diterima</td>
				<td width="3%"><center>: </center></td>
				<td> <?php echo $data['terbilang']; ?> rupiah</td>
			</tr>
		</table> -->
		<div style="position: relative; padding-left: 20px; margin-top: 6px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="135px" >
						<table style="width: 16px; margin-left: -6px; margin-top: -3px;text-align: center;">
							<tr>
								<td height="13px">
									<?php
									if ($data['upah_status'] == "Perhari") {
									 	echo "V";
									 } 
									?>						
								</td>
							</tr>
						</table>
					</td>
					<td width="136px">
						<table style="width: 17px; margin-left: -9px; margin-top: -3px; text-align: center;">
							<tr>
								<td height="13px">
									<?php
									if ($data['upah_status'] == "Perbulan") {
									 	echo "V";
									 } 
									?>		
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style=" width: 17px; margin-left: -13px; margin-top: -3px;text-align: center;">
							<tr>
								<td height="13px">
									<?php
									if ($data['upah_status'] == "Pertahun") {
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
		<div style="position: relative; padding-left: 40px; margin-top: -4px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td><?php echo $data['upah_nominal']; ?></td>										
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 20px; margin-top: -3px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td><?php echo $data['terbilang']; ?> Rupiah</td>										
				</tr>
			</table>
		</div>
		
		
		<!-- <table style="font-family: arial black; font-size: 12px; margin-top: 15px;" width="100%">
			<tr>
				<td width="3%"><center>4.</center></td>
				<td width="25%">Tempat kejadian kecelakaan</td>
				<td width="3%"><center>: </center></td>
				<td> <?php echo $data['tempat_kecelakaan']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" >Alamat lokasi kejadian kecelakaan</td>
				<td width="3%" style="vertical-align: top;"><center>: </center></td>
				<td style="vertical-align: top;"><?php echo $data['alamat_kecelakaan']; ?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td width="3%"></td>
				<td><pre style="font-family: arial black; font-size: 12px; background-color: white; border: none;">Desa/Kel <?php echo $data['desa_kecelakaan']; ?>    Kec <?php echo $data['kec_kecelakaan']; ?>    Kota <?php echo $data['kota_kecelakaan']; ?></pre></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="20px">Tanggal Kecelakaan</td>
				<td width="3%"><center>: </center></td>
				<td><?php echo date('d F Y H:i', strtotime($data['tgl_kecelakaan'])); ?></td>
			</tr>
		</table> -->
		<div style="position: relative; padding-left: 20px; margin-top: 6px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="135px" >
						<table style=" width: 17px; margin-left: -6px; margin-top: -3px; text-align: center;">
							<tr>
								<td height="13px">
									<?php
									if ($data['tempat_kecelakaan'] == "Di dalam lokasi kerja") {
									 	echo "V";
									 } 
									?>						
								</td>
							</tr>
						</table>
					</td>
					<td width="136px">
						<table style=" width: 17px; margin-left: -9px; margin-top: -3px; text-align: center;">
							<tr>
								<td height="13px">
									<?php
									if ($data['tempat_kecelakaan'] == "Di luar lokasi kerja") {
									 	echo "V";
									 } 
									?>	
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 17px; margin-left: -13px; margin-top: -3px; text-align: center;">
							<tr>
								<td height="13px">
									<?php
									if ($data['tempat_kecelakaan'] == "Lalu lintas") {
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
		<div style="position: relative; padding-left: 20px; margin-top: -2px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td><?php echo $data['alamat_kecelakaan']; ?></td>										
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 87px; margin-top: -1px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="135px"><?php echo $data['desa_kecelakaan']; ?></td>
					<td width="180px"><?php echo $data['kec_kecelakaan']; ?></td>
					<td ><?php echo $data['kota_kecelakaan']; ?></td>										
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 45px; margin-top: 0px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="231px" style="word-spacing: -11px; letter-spacing: 11px;"><?php echo date('d m y', strtotime($data['tgl_kecelakaan'])); ?></td>
					<td style="word-spacing: -11px; letter-spacing: 11px;"><?php echo date('H i', strtotime($data['tgl_kecelakaan'])); ?></td>										
				</tr>
			</table>
		</div>
		
		<!-- <table style="font-family: arial black; font-size: 12px; margin-top: 15px;" width="100%">
			<tr>
				<td width="3%"><center>5.</center></td>
				<td width="25%">Deskripsi kecelakaan</td>
				<td width="3%"><center>: </center></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="30px">a) Tindakan bahaya penyebab kecelakaan</td>
				<td width="3%" style="vertical-align: top;"><center>: </center></td>
				<td style="vertical-align: center;"><input type="checkbox" name="cb_ini" ></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="30px">b) Kondisi yang menimbulkan bahaya dan menjadi pencetus terjadinya kecelakaan</td>
				<td width="3%" style="vertical-align: top;"><center>: </center></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="20px">c) Corak kecelakaan yang terjadi</td>
				<td width="3%" style="vertical-align: top;"><center>: </center></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="20px">d) Sumber penyebab cedera</td>
				<td width="3%" style="vertical-align: top;"><center>: </center></td>
				<td></td>
			</tr>
		</table>
	 -->
	 <!-- kece 1 -->
	<div style="position: relative; padding-left: 12px; margin-top: 27px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="231px">
						<table style="border: 1px solid black; width: 17px;text-align: center;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 1) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 1) { //memakai peralatan yg berbahaya
											echo "V";
										}				
									}
												
									?>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="border: 1px solid black; width: 17px;text-align: center;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 5) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 5) { //bekerja dengan kecepatan membahayakan
											echo "V";
										}				
									}
												
									?>
								</td>
							</tr>
						</table>
					</td>								
				</tr>
			</table>
	</div>
	<div style="position: relative; padding-left: 12px; margin-top: -5px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="231px">
						<table style="border: 1px solid black; width: 17px;text-align: center;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 2) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 2) { //lupa menggunakan apd
											echo "V";
										}				
									}
												
									?>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="border: 1px solid black; width: 17px;text-align: center; margin-top: 1px;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 6) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 6) { //bongkar pasang barang/muatan
											echo "V";
										}				
									}
												
									?>
								</td>
							</tr>
						</table>
					</td>	
				</tr>
			</table>
	</div>
	<div style="position: relative; padding-left: 12px; margin-top: -5px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="231px">
						<table style=" width: 17px;border: 1px solid black;text-align: center;margin-top: 1px;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 3) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 3) { //posisi saat bekerja tidak aman
											echo "V";
										}				
									}
												
									?>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="border: 1px solid black; width: 17px;text-align: center; margin-top: 2px;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 7) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 7) { //bekerja dengan objek/benda berputar
											echo "V";
										}				
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
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="231px">
						<table style=" width: 17px;text-align: center;border: 1px solid black;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 4) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 4) { //mengalami gangguan konsentrasi/perhatian
											echo "V";
										}				
									}
												
									?>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style=" width: 17px;text-align: center; border:1px solid black;
						<?php
							$kece1 = $data['kece1'];
							$jml1  = count($kece1);
							for ($p=0; $p < $jml1; $p++) { 
								$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
								if ($idkece1 == 8) {
									echo " padding: -4px;";
								}				
							}
										
							?> 
						?>">
							<tr>
								<td height="10px;">
									<?php
									$kece1 = $data['kece1'];
									$jml1  = count($kece1);
									for ($p=0; $p < $jml1; $p++) { 
										$idkece1 = $kece1[$p]['id_kecelakaan_detail'];
										if ($idkece1 == 8) { //lalai
											echo "V";
										}				
									}
												
									?>
								</td>
							</tr>
						</table>
					</td>	
				</tr>
			</table>
	</div>
	<!-- kece 2 -->
	<div style="position: relative; padding-left: 11px; margin-top: 9px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="231px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 9) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 9) { //pengamanan tidak sempurna
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 15) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 15) { //penggunaan peralatan/bahan tidak tepat
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>	
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -3px;
	<?php
// 	if ($idkece2 != 9 and $idkece2 != 15) {
// 		echo "margin-top: -1px;";
// 	}
	?>">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="231px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 10) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 10) { //adanya kecacatan
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 16) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 16) { //adanya prosedur/pengaturan tidak aman
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>	
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -3px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="231px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 11) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 11) { //penerangan yg tidak sempurna
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 17) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 17) { //ventilasi tidak sempurna
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>	
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -3px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="231px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 12) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 12) { //suasana kerja yg tidak aman
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 18) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 18) { //tekanan udara yg tidak aman
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>	
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -4px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="231px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 13) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 13) { //getaran yang berbahaya
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 19) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 19) { //bising
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>	
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -3px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="231px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 14) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 14) { //perlengkapan yang digunakan tidak aman
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece2 = $data['kece2'];
							$jml2  = count($kece2);
							for ($p=0; $p < $jml2; $p++) { 
								$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
								if ($idkece2 == 20) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece2 = $data['kece2'];
								$jml2  = count($kece2);
								for ($r=0; $r < $jml2; $r++) { 
									$idkece2 = $kece2[$r]['id_kecelakaan_detail'];
									if ($idkece2 == 20) { //adanya gerakan perputaran
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>	
			</tr>
		</table>
	</div>
	<!-- kece 3 -->
	<div style="position: relative; padding-left: 11px; margin-top: 5px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="83px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 21) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 21) { //terbentur
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="82px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 25) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 25) { //terpukul
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="165px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 29) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 29) { //terpapar
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 33) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 33) { //tersengat aliran listrik
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>	
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -2px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="83px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;margin-top: -1px;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 22) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 22) { //tertangkap
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="82px">
					<table style="width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 26) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 26) { //tergigit
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 30) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 30) { //jatuh dari ketinggian yg sama
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -4px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="83px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 23) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 23) { //tenggelam
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="82px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 27) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 27) { //terjepit
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 31) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 31) { //jatuh dari ketinggian yg berbeda
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -3px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="83px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 24) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 24) { //tertimbun
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="82px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 28) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 28) { //tergelincir
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece3 = $data['kece3'];
							$jml3  = count($kece3);
							for ($p=0; $p < $jml3; $p++) { 
								$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
								if ($idkece3 == 32) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece3 = $data['kece3'];
								$jml3  = count($kece3);
								for ($r=0; $r < $jml3; $r++) { 
									$idkece3 = $kece3[$r]['id_kecelakaan_detail'];
									if ($idkece3 == 32) { //penghisapan/penyerapan
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<!-- kece 4 -->
	<div style="position: relative; padding-left: 11px; margin-top: 10px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="165px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;margin-top: 1px;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 34) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 34) { //mesin(press)
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="148px">
					<table style=" width: 17px;border: 1px solid black;text-align: center; margin-top: 0px;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 40) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 40) { //penggerak mula dan pompa
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;margin-top: 1px;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 45) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 45) { //lift (barang/orang)
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -4px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="165px">
					<table style="border: 1px solid black; width: 17px;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 35) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 35) { //pengangkut/pengangkat barang
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="148px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 41) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 41) { //conveyor
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 46) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 46) { //alat transmisi mekanik
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -5px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="165px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;margin-top: -1px;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 36) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 36) { //perkakas pekerjaan tangan
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="148px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 42) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 42) { //pesawat uap dan bejana tekan
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 47) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 47) { //peralatan listrik
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -4px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="165px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 37) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 37) { //bahan kimia
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="148px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 43) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 43) { //debu berbahaya
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 48) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 48) { //radiasi dan bahan radioaktif
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -5px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td width="165px">
					<table style="width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 38) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 38) { //faktor lingkungan
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width="148px">
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 44) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 44) { //binatang
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style="width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 49) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 49) { //permukaan lantai di lingkungan kerja
										echo "V";
									}				
								}
											
								?>
							</td>
						</tr>
					</table>
				</td>					
			</tr>
		</table>
	</div>
	<div style="position: relative; padding-left: 11px; margin-top: -3px;">
		<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
			<tr>
				<td width="3%"></td>
				<td width="25%"></td>
				<td width="3%"></td>
				<td>
					<table style=" width: 17px;border: 1px solid black;text-align: center;
						<?php
							$kece4 = $data['kece4'];
							$jml4  = count($kece4);
							for ($p=0; $p < $jml4; $p++) { 
								$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
								if ($idkece4 == 39) {
									echo " padding: -3px;";
								}				
							}
										
							?> 
						?>">
						<tr>
							<td height="10px;">
								<?php
								$kece4 = $data['kece4'];
								$jml4  = count($kece4);
								for ($r=0; $r < $jml4; $r++) { 
									$idkece4 = $kece4[$r]['id_kecelakaan_detail'];
									if ($idkece4 == 39) { //bahan mudah terbakar dan panas
										echo "V";
									}				
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

	<div style="width: 21cm; height: 33cm;margin-top: 0px; font-size: 11px;max-height: 33cm; background-image: url(<?php echo base_url('assets/img/kk-tahap1-2.jpg')?>); background-size: 100% 120%; background-blend-mode: normal; padding-top: 120px;">
		<!-- <table width="100%" style="border-bottom: 1px solid black">
			<tr>
				<td style="margin-bottom: 0px;padding-bottom: 0px;" width="20%">
					<img src="<?php echo base_url('assets/img/bpjs-logo.png'); ?>" width="20%" style="margin-left: 9px;">
				</td>
				<td style="margin-top: 0px;">
					 <center><h1 style=" font-size: 14px; font-weight: normal;"><b>LAPORAN KASUS KECELAKAAN KERJA<br>TAHAP I</b></h1></center>
				</td>
				<td width="20%">
					<table style="border: 2px solid black; margin:9px;" width="100%">
						<tr>
							<td height="50px">
								<center><p style="margin-top: 5px; font-size: 11px">Formulir <br> <b>3 KK 1</b> <br> BPJS Ketenagakerjaan</p></center>	
							</td>
						
						</tr>
					</table>
				</td>
			</tr>
		</table> -->		
		<!-- <table style="font-family: arial black; font-size: 12px; margin-top: 15px;" width="100%">
			<tr>
				<td width="3%"><center>6.</center></td>
				<td width="25%">Uraian Kejadian Kecelakaan</td>
				<td width="3%"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="30px">- Bagaimana terjadinya kecelakaan</td>
				<td width="3%" style="vertical-align: top;"><center>: </center></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="20px">- Sebutkan bagian mesin, instalasi bahan atau lingkungan yang menyebabkan cidera *) <p style="font-size: 8px">*) tidak perlu diisi bagi peserta bukan penerima upah</p></td>
				<td width="3%" style="vertical-align: top;"><center>: </center></td>
				<td></td>
			</tr>
		</table>
		<table style="font-family: arial black; font-size: 12px; margin-top: 15px;" width="100%">
			<tr>
				<td width="3%"><center>7.</center></td>
				<td width="25%">Akibat yang diderita korban</td>
				<td width="3%"><center>: </center></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td width="25%" height="30px">Sebutkan bagian tubuh yang luka</td>
				<td width="3%"><center>: </center></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td width="3%"></td>
				<td></td>
			</tr>
		</table> -->
		<div style="position: relative; padding-left: 19px; margin-top: 25px; margin-left: -8px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td>
						<table style=" width: 463px; vertical-align: top; padding-left: 5px;">
							<tr>
								<td height="198px">
									<?php
										echo $data['kejadian'];
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 19px; margin-top: 23px; margin-left: -8px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td>
						<table style="width: 463px; vertical-align: top; padding-left: 5px;">
							<tr>
								<td height="129px">
									<?php
										echo $data['penyebab'];
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 18px; margin-top: 18px; margin-left: -7px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="99px">
						<table style="width: 17px; vertical-align: top; text-align: center;">
							<tr>
								<td height="10px">
									<?php
									if ($data['akibat'] == "Meninggal") {
									 	echo "V";
									 } 
									?>
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 17px; vertical-align: top; text-align: center;">
							<tr>
								<td height="10px">
									<?php
									if ($data['akibat'] == "Cedera/Luka") {
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
		<div style="position: relative; padding-left: 19px; margin-top: -1px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td >						
						<?php
						echo $data['akibat_detail'];
						?>							
					</td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 162px; margin-top: 26px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td >						
						<?php
						echo $data['nama_faskes'];
						?>							
					</td>					
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 154px; margin-top: -3px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="165px">
						<table style=" width: 17px; text-align: center;
						<?php
						if ($data['jenis_faskes'] == "Rumah Sakit Trauma Center") {
							echo "padding: -2px;";
						}
						?>">
							<tr>
								<td height="10px">
									<?php
										if ($data['jenis_faskes'] == "Rumah Sakit Trauma Center") {
											echo "V";
										}
									?>	
								</td>
							</tr>
						</table>											
					</td>
					<td>
						<table style="width: 17px; text-align: center;">
							<tr>
								<td height="10px">
									<?php
										if ($data['jenis_faskes'] == "Klinik Trauma Center") {
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
		<div style="position: relative; padding-left: 154px; margin-top: -1px;
		<?php
		if ($data['jenis_faskes'] == "Rumah Sakit Trauma Center") {
			echo "margin-top: -3px;";
		}
		if ($data['jenis_faskes'] == "Klinik Trauma Center") {
			echo "margin-top: -7px;";
		}
		?>">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td>
						<table style="width: 17px;">
							<tr>
								<td height="10px">
									<?php
										if ($data['jenis_faskes'] == "Bukan Jejaring TC") {
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
		<div style="position: relative; padding-left: 159px; margin-top: -1px;
		<?php
		if ($data['jenis_faskes'] == "Bukan Jejaring TC") {
			echo "margin-top: -5px";
		}
		?>">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td>
						<?php
						echo $data['alamat_faskes'];
						?>											
					</td>
				</tr>
			</table>
		</div>
		<div style="position: relative; padding-left: 11px; margin-top: 4px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td width="132px">
						<table style=" width: 17px; text-align: center;">
							<tr>
								<td height="10px">
									<?php
									if ($data['keadaan_penderita'] == "Rawat Jalan") {
										echo "V";
									}
									?>
								</td>
							</tr>
						</table>										
					</td>
					<td>
						<table style=" width: 17px; text-align: center;">
							<tr>
								<td height="10px">
									<?php
									if ($data['keadaan_penderita'] == "Rawat Inap") {
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
		<div style="position: relative; padding-left: 12px; margin-top: 19px;">
			<table style="font-family: arial black; font-size: 11px;position: fixed;" width="100%">
				<tr>
					<td width="3%"></td>
					<td width="25%"></td>
					<td width="3%"></td>
					<td>
						<table style="width: 463px; vertical-align: top; padding-left: 5px; padding-right: 5px;">
							<tr>
								<td height="117px;">
									<?php
										echo $data['keterangan_lain'];
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