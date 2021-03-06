<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<div style="width: 100%;border: 1px solid black;padding-left: 5px;border-top: 0px solid white;">
		Kepada Yth :<br>
		Departemen Personalia<br>
		Bersama ini kami sampaikan, bahwa telah dilakukan wawancara dengan pekerja terkait Covid 19, dengan detail sebagai berikut :
	</div>
	<table style="width: 100%;border: 1px solid black;border-collapse: collapse;border-top: 0px solid white;">
		<tr>
			<td colspan="9"><b>Identitas Pekerja</b></td>
		</tr>
		<tr>
			<td style="width: 20%">Nama / No. Induk</td>
			<td style="width: 2%">:</td>
			<td style="width: 28%"><?php echo (isset($data) && !empty($data)) ? ucwords(strtolower($data->nama)).' / '.$data->noind : ''; ?></td>
			<td style="width: 10%">Seksi</td>
			<td style="width: 2%">:</td>
			<td colspan="4"><?php echo (isset($data) && !empty($data)) ? ucwords(strtolower($data->seksi)) : ''; ?></td>
		</tr>
		<tr>
			<td>Tanggal Interaksi</td>
			<td>:</td>
			<?php
				if (isset($data->range_tgl_interaksi) && !empty($data->range_tgl_interaksi)) {
					$tgl = $data->range_tgl_interaksi;
					$tgl = explode(' - ', $tgl);
					$tgl1 = date('Y-m-d', strtotime($tgl[0]));
					$tgl2 = date('Y-m-d', strtotime($tgl[1]));
					$show = strftime('%d %b %Y', strtotime($tgl1)).' - '.strftime('%d %b %Y', strtotime($tgl2));
					$tgl = $tgl[0];
				}else{
					$tgl = $data->tgl_interaksi;
					$show = strftime('%d %B %Y', strtotime($tgl));
				}
			?>
			<td><?php echo (isset($data) && !empty($data)) ? $show : ''; ?></td>
			<td colspan="3" style="width: 25%">Lama Interaksi s/d hari ini</td>
			<td style="width: 2%">:</td>
			<td style="width: 9%"><?php echo (isset($data) && !empty($data)) ? ((strtotime(date('Y-m-d'))-strtotime($tgl))/(60*60*24)) : ''; ?></td>
			<td style="width: 4%">hari</td>
		</tr>
		<tr>
			<td>Kasus</td>
			<td>:</td>
			<td colspan="7"><?php echo (isset($data) && !empty($data)) ? $data->kasus : ''; ?></td>
		</tr>
	</table>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;">
		<b>Data tambahan hasil wawancara :</b>
	</div>
	<div class="pnomargin" style="width: 100%;border: 1px solid black;border-top: 0px solid white;max-height: 250px;">
		<?php 
			if (isset($data->keterangan)) {
				echo $data->keterangan;
			}
			if (isset($wawancara) && !empty($wawancara)) {
				echo str_replace('_', '<br>', $wawancara->hasil_wawancara);
			} 
		?>
	</div>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;">
		<b>Lampiran Foto :</b>
	</div>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;height: 140px;padding: 1%">
		<?php 
			if (isset($lampiran) && !empty($lampiran)) {
				foreach ($lampiran as $key_lamp => $val_lamp) {
					?>
					<img src="<?php echo base_url($val_lamp['lampiran_path']) ?>" style="max-height: 150px;max-width: 290px;float: left;height: auto; width: auto">
					<?php 
				}
			}
		?>
	</div>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;">
		Berdasarkan data wawancara diatas mohon diputuskan apakah pekerja tersebut perlu melakukan prosedur isolasi mandiri, dan apakah pekerja tersebut perlu melakukan rapid test atau tidak.
	</div>
	<table style="width: 100%;border: 1px solid black;border-collapse: collapse;border-top: 0px solid white;">
		<tr>
			<td colspan="4"><b>Keputusan</b>:<i style="color: #b2bec3">(Diisi oleh Ketua/Koordinator Tim Covid)</i></td>
		</tr>
		<tr>
			<td style="width: 5%;text-align: center;">
				<input type="checkbox" style="height: 20px;width: 50px;">
			</td>
			<td style="width: 30%">Ya, perlu isolasi mandiri</td>
			<td style="width: 30%">selama : _______ hari</td>
			<td style="width: 35%">mulai tgl : ___________s/d___________</td>
		</tr>
		<tr>
			<td style="width: 5%;text-align: center;">
				<input type="checkbox"></td>
			<td colspan="3">Tidak Perlu Isolasi Mandiri</td>
		</tr>
	</table>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;">
		<b>Keterangan :</b>
	</div>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;height: 80px;">
		 <?php echo (isset($keputusan) && !empty($keputusan)) ? $keputusan->keterangan : '' ?>
	</div>
	<table style="width: 100%; page-break-inside: avoid" autosize="1">
		<tr>
			<td colspan="5">Yogyakarta, <?php echo $tanggal ?></td>
		</tr>
		<tr>
			<td colspan="5">Tim Pencegahan Penularan Virus Covid-19 CV. KHS</td>
		</tr>
		<tr>
			<td style="width: 30%;text-align: center;border-bottom: 1px solid black;height: 80px;vertical-align: bottom;"><?php echo ucwords(strtolower($this->session->employee)) ?></td>
			<td style="width: 5%"></td>
			<td style="width: 30%;text-align: center;border-bottom: 1px solid black;height: 80px;vertical-align: bottom;">Rajiwan</td>
			<td style="width: 5%"></td>
			<td style="width: 30%;text-align: center;border-bottom: 1px solid black;height: 80px;vertical-align: bottom;">Bambang Yudhosuseno</td>
		</tr>
		<tr>
			<td style="text-align: center;">Pewawancara</td>
			<td></td>
			<td style="text-align: center;">Ketua</td>
			<td></td>
			<td style="text-align: center;">Koordinator</td>
		</tr>
	</table>
</body>
</html>