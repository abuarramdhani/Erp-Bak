<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<div style="width: 100%;border: 1px solid black;padding-left: 5px;border-top: 0px solid white;">
		Kepada Yth :<br>
		Departemen Personalia<br>
		Bersama ini kami sampaikan, bahwa telah dilakukan wawancara terkait pekerja yang melakukan isolasi mandiri
		Covid 19, dengan detail sebagai berikut :
	</div>
	<table style="width: 100%;border: 1px solid black;border-collapse: collapse;border-top: 0px solid white;">
		<tr>
			<td colspan="9"><b>Identitas Pekerja</b></td>
		</tr>
		<tr>
			<td style="width: 20%">Nama / No. Induk</td>
			<td style="width: 2%">:</td>
			<td style="width: 38%"><?php echo (isset($data) && !empty($data)) ? ucwords(strtolower($data->nama)).' / '.$data->noind : ''; ?></td>
			<td style="width: 10%">Seksi</td>
			<td style="width: 2%">:</td>
			<td colspan="4"><?php echo (isset($data) && !empty($data)) ? ucwords(strtolower($data->seksi)) : ''; ?></td>
		</tr>
		<tr>
			<td>Tanggal Interaksi</td>
			<td>:</td>
			<td><?php echo (isset($data) && !empty($data)) ? $data->tgl_interaksi : ''; ?></td>
			<td colspan="3" style="width: 25%">Lama Interaksi s/d hari ini</td>
			<td style="width: 2%">:</td>
			<td style="width: 9%"><?php echo (isset($data) && !empty($data)) ? ((strtotime(date('Y-m-d'))-strtotime($data->tgl_interaksi))/(60*60*24)) : ''; ?></td>
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
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;height: 300px;">
		<?php 
			if (isset($wawancara) && !empty($wawancara)) {
				echo $wawancara->hasil_wawancara;
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
					<img src="<?php echo base_url($val_lamp['lampiran_path']) ?>" style="width: 300px;float: left;height: auto;">
					<?php 
				}
			}
		?>
	</div>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;">
		Berdasarkan hasil pengisian kuesioner & tambahan data wawancara diatas mohon diputuskan kapan pekerja
		dengan identitas diatas dapat masuk bekerja kembali di CV. KHS.
	</div>
	<table style="width: 100%;border: 1px solid black;border-collapse: collapse;border-top: 0px solid white;">
		<tr>
			<td colspan="2" style="width: 20%"><b>Keputusan</b></td>
			<td style="width: 2%">:</td>
			<td style="width: 78%"><i style="color: #b2bec3">(Diisi oleh Ketua/Koordinator Tim Covid)</i></td>
		</tr>
		<tr>
			<td style="width: 5%;text-align: center;">
				<input type="checkbox" style="height: 20px;width: 50px;" <?php echo (isset($keputusan) && !empty($keputusan) && $keputusan->keputusan == 1) ? 'checked="checked"' : '' ?>>
			</td>
			<td colspan="3">Masuk Kerja pada tanggal <?php echo (isset($keputusan) && !empty($keputusan) && $keputusan->keputusan == 1) ? $keputusan->tgl_keputusan : '' ?></td>
		</tr>
		<tr>
			<td style="width: 5%;text-align: center;"><input type="checkbox" <?php echo (isset($keputusan) && !empty($keputusan) && $keputusan->keputusan == 2) ? 'checked="checked"' : '' ?>></td>
			<td colspan="3">Tunda masuk kerja sampai dengan tanggal <?php echo (isset($keputusan) && !empty($keputusan) && $keputusan->keputusan == 2) ? $keputusan->tgl_keputusan : '' ?></td>
		</tr>
	</table>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;">
		<b>Keterangan :</b>
	</div>
	<div style="width: 100%;border: 1px solid black;border-top: 0px solid white;height: 80px;">
		 <?php echo (isset($keputusan) && !empty($keputusan)) ? $keputusan->keterangan : '' ?>
	</div>
	<table style="width: 100%">
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