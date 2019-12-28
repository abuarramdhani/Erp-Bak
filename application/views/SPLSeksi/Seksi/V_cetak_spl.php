<?php
$lst_tgl = "";
date_default_timezone_set('Asia/Jakarta');
foreach($data_spl as $d){
	try{
		if($lst_tgl!="" && $lst_tgl>=$d['Tgl_Lembur']){
			throw new Exception('lewati');
		}
?>

<html>
	<body >
		<div style="width: 100%;">
			<div>	<!-- header -->
				<table border="0" width="100%">
					<tr><td style="height:100%; width:5%; padding:3px;">
							<img src="<?php echo base_url('assets/img/logo.png') ?>" width="40px" height="50px" >
						</td>
						<td style="height:100%; width:85%">
							<p style="font-size:14px; font-weight:bold">CV. KARYA HIDUP SENTOSA</p>
							<p style="font-size:12px; font-weight:bold;">JL. MAGELANG 144</p>
							<p style="font-size:12px; font-weight:bold;">YOGYAKARTA</p>
						</td>
						<td style="height:100%; width:10%">
							<div style="border: 1px solid #000; font-size:12px; padding:3px;">
								FRM-HRM 00-31
							</div>
						</td></tr>
				</table>
			</div>

			<div style="height:70%">	<!-- body -->
				<div style="width:100%; padding:3px; font-size:14px; font-weight:bold; text-align:center">
					SURAT PERINTAH LEMBUR (SPL)<br>PROGRAM INPUT LEMBUR SEKSI
				</div>
				<div style="width:100%; padding:3px; font-size:12px;">
					<table border="0" width="100%">
						<tr><td style="width:10%; padding:3px; font-size:12px;">Unit</td>
							<td style="width:21%; padding:3px; font-size:12px;">: <?php echo $d['unit'] ?></td>
							<td style="width:10%; padding:3px; font-size:12px;">Departemen</td>
							<td style="width:21%; padding:3px; font-size:12px;">: <?php echo $d['dept'] ?></td>
							<td style="width:10%; padding:3px; font-size:12px;">Lembur ke</td>
							<td style="width:21%; padding:3px; font-size:12px;">: _____ dalam bulan ini</td></tr>
						<tr><td style="width:100%; padding:3px; font-size:12px;" colspan="6">
								Sehubungan dengan adanya pekerjaan yang bersifat penting dan mendesak yang harus segera diselesaikan, maka dengan ini kami sampaikan Surat Perintah Lembur
							</td></tr>
						<tr><td style="width:10%; padding:3px; font-size:12px;">Seksi</td>
							<td style="width:21%; padding:3px; font-size:12px;">: <?php echo $d['seksi'] ?></td>
							<td style="width:10%; padding:3px; font-size:12px;">Seksi lain yang terkait</td>
							<td style="width:21%; padding:3px; font-size:12px;">:</td>
							<td style="width:10%; padding:3px; font-size:12px;"></td>
							<td style="width:21%; padding:3px; font-size:12px;"></td></tr>
						<tr><td style="width:10%; padding:3px; font-size:12px;">Hari / Tgl</td>
							<td style="width:21%; padding:3px; font-size:12px;">: <?php echo date_format(date_create($d['Tgl_Lembur']), "d-m-Y") ?></td>
							<td style="width:10%; padding:3px; font-size:12px;">Jumlah Operator</td>
							<td style="width:21%; padding:3px; font-size:12px;">:</td>
							<td style="width:10%; padding:3px; font-size:12px;"></td>
							<td style="width:21%; padding:3px; font-size:12px;"></td></tr>
						<tr><td style="width:10%; padding:3px; font-size:12px;"></td>
							<td style="width:21%; padding:3px; font-size:12px;"></td>
							<td style="width:10%; padding:3px; font-size:12px;">Jumlah Pekerja Staf</td>
							<td style="width:21%; padding:3px; font-size:12px;">:</td>
							<td style="width:10%; padding:3px; font-size:12px;"></td>
							<td style="width:21%; padding:3px; font-size:12px;"></td></tr>
					</table><br>

					<table border="1" width="100%">
						<tr><th style="width:3%; padding:3px; font-size:12px; text-align:center">No.</th>
							<th style="width:15%; padding:3px; font-size:12px; text-align:center">Nama</th>
							<th style="width:5%; padding:3px; font-size:12px; text-align:center">Noind</th>
							<th style="width:5%; padding:3px; font-size:12px; text-align:center">Staf/OS/Operator</th>
							<th style="width:5%; padding:3px; font-size:12px; text-align:center">Kelompok Kerja</th>
							<th style="width:6%; padding:3px; font-size:12px; text-align:center">Target (%)/Pcs</th>
							<th style="width:6%; padding:3px; font-size:12px; text-align:center">Realisasi (%)/Pcs</th>
							<th style="width:10%; padding:3px; font-size:12px; text-align:center">Jam Lembur</th>
							<th style="width:3%; padding:3px; font-size:12px; text-align:center">B</th>
							<th style="width:3%; padding:3px; font-size:12px; text-align:center">I</th>
							<th style="width:40%; padding:3px; font-size:12px; text-align:center">Uraian Pekerjaan / Hambatan / Keterangan</th></tr>

						<?php
							$x = 1;
							$tmp_tgl = "";
							foreach($data_spl as $ds){
								if($ds['Tgl_Lembur'] == $d['Tgl_Lembur']){
						?>
						<tr><td style="padding:3px; font-size:12px; text-align:center"><?php echo $x; ?></td>
							<td style="padding:3px; font-size:12px; text-align:left"><?php echo $ds['nama']; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo $ds['Noind']; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo "-"; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo "-"; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo $ds['target']; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo $ds['realisasi']; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo $ds['Jam_Mulai_Lembur']." - ".$ds['Jam_Akhir_Lembur']; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo $ds['Break']; ?></td>
							<td style="padding:3px; font-size:12px; text-align:center"><?php echo $ds['Istirahat']; ?></td>
							<td style="padding:3px; font-size:12px; text-align:left"><?php echo $ds['Pekerjaan']; ?></td></tr>
						<?php
									$tmp_tgl = $ds['Tgl_Lembur'];
									$lst_tgl = $ds['Tgl_Lembur'];
									$x++;
								}
							}
						?>

					</table><br>
				</div>
			</div>

			<div>	<!-- footer -->
				<div style="width:100%; padding:3px; font-size:12px;">
					<table border="1" width="100%">
						<tr><td style="width:50%; padding:3px; font-size:12px; text-align:left" colspan="2">Yogyakarta, </td>
							<td style="width:50%; padding:3px; font-size:12px; text-align:center">Catatan</td></tr>
						<tr><td style="width:50%; padding:3px; font-size:12px; text-align:center" colspan="2">Menyetujui</td>
							<td style="width:50%; padding:3px; font-size:12px; text-align:center" rowspan="3"></td></tr>
						<tr><td style="width:25%; padding:3px; font-size:12px; text-align:center">Ass. Kepala Unit/Kepala Unit/Kepala Dept</td>
							<td style="width:25%; padding:3px; font-size:12px; text-align:center">Supervisor/ Kepala Seksi</td></tr>
						<tr><td style="width:25%; padding:3px; font-size:12px; text-align:center"><br><br><br><br><br></td>
							<td style="width:25%; padding:3px; font-size:12px; text-align:center"><br><br><br><br><br></td></tr>
					</table>
					** B = Break ; I = Istirahat ; Y = Pakai break / istirahat ; N = Tanpa break / istirahat
				</div>
			</div>

	</body>

</html>

<?php
	if($ds['Tgl_Lembur']!=$tmp_tgl && $tmp_tgl!="") {
		print_r('<pagebreak />');
	}

	}catch(Exception $e){
		// lewati
	}
}
?>
