<html>

<head></head>

<body>
	<?php
	setlocale(LC_TIME, 'id_ID.utf8');
	set_time_limit(0);
	ini_set("memory_limit", "2048M");

	foreach ($cekData as $cek) {
		$plusOJT = date('Y-m-d', strtotime('+' . $cek['lama_trainee'] . ' months', strtotime($cek['tgl_masuk'])));
		$OJT1 = date('Y-m-d', strtotime('-6 months', strtotime($plusOJT)));
		$actualOJT1 = date('Y-m-d', strtotime('-1 days', strtotime($OJT1)));
		$actualOJT2 = date('Y-m-d', strtotime('-1 days', strtotime($plusOJT)));
	}

	?>
	<div style="width: 100%;padding-right: 30px;">
		<table style="font-size: 13px">
			<tr>
				<td>No
				<td>:
				<td><?= $no_surat ?></td>
			</tr>
			<tr>
				<td>Hal
				<td>:
				<td>Penyerahan <?php
								if ($allinOne == '2') {
									echo 'Trainee Staff';
								} elseif ($allinOne == '7' || $allinOne == '8' || $allinOne == '13') {
									echo 'Peserta PKL';
								} elseif ($allinOne == '12' || $allinOne == '9' || $allinOne == '14' || $allinOne == '16') {
									echo 'Tenaga Kerja ' . $jenis;
								} elseif ($allinOne == '11') {
									echo 'Kontrak Non Staff';
								} elseif ($allinOne == '10') {
								} elseif ($allinOne == '4' || $allinOne == '5') {
									echo 'Calon ' . $jenis;
								} else if ($allinOne == '15') {
									echo 'Calon Pekerja Waktu Tertentu (Kontrak)';
								} else {
									echo $jenis;
								} ?></td>
			</tr>
		</table>
		<br>
		<table style="font-size: 13px">
			<tr>
				<td>Kepada Yth. :</td>
			</tr>
			<tr>
				<td><?= $kepada ?></td>
			</tr>
			<tr>
				<td><u>di tempat</u></td>
			</tr>
		</table>
		<!-- Custom Body Surat -->
		<?php if ($allinOne == '1' || $allinOne == '2' || $allinOne == '3' || $allinOne == '10') { ?>
			<!-- noind D, DSupervisor, C Trainee, E -->
			<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?= $terbilang ?>) orang <?php if ($allinOne == '1') {
																														echo '<i>Staff Management Trainee B</i>';
																													} elseif ($allinOne == '2') {
																														echo '<i>Staff Management Trainee C</i>';
																													} elseif ($allinOne == '10') {
																														echo 'pekerja';
																													} else {
																														echo 'pekerja <i>' . strtolower($jenis) . '</i>';
																													} ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-' ? '' : 'SEKSI ' . $cekData[0]['seksi'] . ',' ?> <?= $cekData[0]['unit'] == '-' ? '' : 'UNIT ' . $cekData[0]['unit'] . ',' ?> <?= $cekData[0]['dept'] == '-' ? '' : 'DEPARTEMEN ' . $cekData[0]['dept'] ?>.</b></p>
			<p style="font-size: 13px;">Adapun nama <?php if ($allinOne == '1' || $allinOne == '2') {
														echo 'trainee';
													} else if ($allinOne == '10') {
														echo 'pekerja';
													} else {
														echo '<i>' . strtolower($jenis) . '</i>';
													} ?> tersebut adalah :</p>
			<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
				<tr>
					<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal']; ?>
					<td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja']; ?></b></td>
				</tr>
				<thead>
					<tr>
						<th style="border: 1px solid;"><i>No</i></th>
						<th style="border: 1px solid;"><i>Nama</i></th>
						<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
						<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
						<th style="border: 1px solid;"><i>Noind</i></th>
						<?php if ($allinOne == '3') { ?><th style="border: 1px solid;"><i>Gol</i></th><?php } ?>
						<th style="border: 1px solid;"><i><?= ($allinOne == '3') ? 'Trainee' : 'Lama Trainee' ?></i></th>
						<th style="border: 1px solid;"><i>Terhitung Tanggal</i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($cekData as $key) { ?>
						<tr>
							<td style="border: 1px solid;"><?= $no++; ?></td>
							<td style="border: 1px solid;"><?= $key['nama'] ?></td>
							<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
							<td style="border: 1px solid;"><?= $key['noind'] ?></td>
							<?php if ($allinOne == '3') { ?><td style="border: 1px solid;"><?= ($key['gol']) ? $key['gol'] : '-' ?></td><?php } ?>
							<td style="border: 1px solid;"><?= $key['lama_trainee'] . ' bulan' ?></td>
							<td style="border: 1px solid;"><?= ($key['lama_trainee'] == '0') ? date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['diangkat'])) : date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['diangkat'] . '-1 day')) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php
			if ($allinOne == '10') { ?>
				<p style="font-size: 13px;">Evaluasi Trainee berakhir pada tanggal <?= strftime('%d %B %Y', strtotime($cekData[0]['akhkontrak'])); ?><br>Kami menantikan hasil evaluasi trainee yang bersangkutan.</p>
			<?php } else { ?>
				<ul>
					<?php if ($allinOne == '3') { ?>
						<li style="font-size: 13px; padding-left: -25px;">Evaluasi OJT-1 berakhir pada tanggal <?= strftime('%d %B %Y', strtotime($actualOJT1)); ?></li>
						<li style="font-size: 13px; padding-left: -25px;">Evaluasi OJT-2 berakhir pada tanggal <?= strftime('%d %B %Y', strtotime($actualOJT2)); ?></li>
					<?php } else { ?>
						<li style="font-size: 13px; padding-left: -25px;">Evaluasi trainee berakhir pada tanggal <?= strftime('%d %B %Y', strtotime($cekData[0]['akhkontrak'])); ?></li>
					<?php } ?>
				</ul>
				<p style="font-size: 13px;">Kami menantikan hasil evaluasi trainee yang bersangkutan.</p>
			<?php } ?>
			<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>
		<?php } else if ($allinOne == '4' || $allinOne == '5' || $allinOne == '15') { ?>
			<!-- Kode induk D, H, T -->
			<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?= $terbilang ?>) orang <?= $allinOne == '15' ? 'pekerja ' . strtolower($jenis) : strtolower($jenis); ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-' ? '' : 'SEKSI ' . $cekData[0]['seksi'] . ',' ?> <?= $cekData[0]['unit'] == '-' ? '' : 'UNIT ' . $cekData[0]['unit'] . ',' ?> <?= $cekData[0]['dept'] == '-' ? '' : 'DEPARTEMEN ' . $cekData[0]['dept'] ?>.</b></p>
			<p style="font-size: 13px;">Adapun nama <?= $allinOne == '15' ? 'pekerja waktu tertentu' : strtolower($jenis); ?> tersebut adalah :</p>

			<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
				<tr>
					<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?>
					<td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
				</tr>
				<thead>
					<tr>
						<th style="border: 1px solid;"><i>No</i></th>
						<th style="border: 1px solid;"><i>Nama</i></th>
						<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
						<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
						<th style="border: 1px solid;"><i>Noind</i></th>
						<th style="border: 1px solid;"><i>Gol</i></th>
						<th style="border: 1px solid;"><i>Orientasi Kerja</i></th>
						<th style="border: 1px solid;"><i>Kontrak Kerja</i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($cekData as $key) {
					?>
						<tr>
							<td style="border: 1px solid;"><?= $no++; ?></td>
							<td style="border: 1px solid;"><?= $key['nama'] ?></td>
							<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
							<td style="border: 1px solid;"><?= $key['noind'] ?></td>
							<td style="border: 1px solid;"><?= $key['gol'] ? $key['gol'] : '-' ?></td>
							<td style="border: 1px solid;"><?= ($key['lama_trainee'] != '0') ? date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['diangkat'] . '-1 day')) : date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['diangkat'])) ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['diangkat'])) . ' - ' . date('d/m/Y', strtotime($key['akhkontrak'])) ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<p style="font-size: 13px;">Dan untuk kemudian apabila berdasarkan hasil evaluasi selama menjalani orientasi pekerja tersebut dapat menunjukkan unjuk kerja yang diharapkan,
				maka <?= $allinOne == '15' ? 'pekerja waktu tertentu' : strtolower($jenis); ?> akan bekerja di CV. Karya Hidup Sentosa dengan masa kontrak kerja sebagaimana tersebut di atas.</p>
			<?php if ($allinOne != '5') { ?><p style="font-size: 13px;">Pekerja tersebut akan mendapatkan <u>Insentif Kerajinan</u> mulai tanggal <u><?= strftime('%d %B %Y', strtotime($cek['tgl_mulaiik'])); ?></u>.</p><?php } ?>
			<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>

		<?php } elseif ($allinOne == '6' || $allinOne == '16') {  ?>
			<!-- Kode Induk G dan N -->
			<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?= $terbilang ?>) orang <?= $allinOne == '6' ? $jenis : 'Tenaga Kerja ' . $jenis ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-' ? '' : 'SEKSI ' . $cekData[0]['seksi'] . ',' ?> <?= $cekData[0]['unit'] == '-' ? '' : 'UNIT ' . $cekData[0]['unit'] . ',' ?> <?= $cekData[0]['dept'] == '-' ? '' : 'DEPARTEMEN ' . $cekData[0]['dept'] ?>.</b></p>
			<p style="font-size: 13px;">Adapun nama <?= $allinOne == '6' ? $jenis : 'Tenaga Kerja ' . $jenis ?> tersebut adalah :</p>

			<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
				<tr>
					<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?>
					<td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
				</tr>
				<thead>
					<tr>
						<th style="border: 1px solid;"><i>No</i></th>
						<th style="border: 1px solid;"><i>Nama</i></th>
						<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
						<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
						<th style="border: 1px solid;"><i>Noind</i></th>
						<th style="border: 1px solid;"><i>Masa Kerja</i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($cekData as $key) {
					?>
						<tr>
							<td style="border: 1px solid;"><?= $no++; ?></td>
							<td style="border: 1px solid;"><?= $key['nama'] ?></td>
							<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
							<td style="border: 1px solid;"><?= $key['noind'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } elseif ($allinOne == '7' || $allinOne == '8' || $allinOne == '13') {  ?>
			<!-- Kode Induk F, L, Q -->
			<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?= $terbilang ?>) orang <?= $allinOne == '8' ? 'peserta magang' : 'siswa PKL (Praktik Kerja Lapangan)' ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-' ? '' : 'SEKSI ' . $cekData[0]['seksi'] . ',' ?> <?= $cekData[0]['unit'] == '-' ? '' : 'UNIT ' . $cekData[0]['unit'] . ',' ?> <?= $cekData[0]['dept'] == '-' ? '' : 'DEPARTEMEN ' . $cekData[0]['dept'] ?>.</b></p>
			<p style="font-size: 13px;">Adapun nama <?= $allinOne == '8' ? 'peserta magang' : 'siswa PKL' ?> tersebut adalah :</p>

			<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
				<tr>
					<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?>
					<td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
				</tr>
				<thead>
					<tr>
						<th style="border: 1px solid;"><i>No</i></th>
						<th style="border: 1px solid;"><i>Nama</i></th>
						<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
						<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
						<th style="border: 1px solid;"><i>Asal Sekolah</i></th>
						<th style="border: 1px solid;"><i>Noind</i></th>
						<th style="border: 1px solid;"><i><?= $allinOne == '8' ? 'Masa Magang' : 'Masa PKL' ?></i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($cekData as $key) { ?>
						<tr>
							<td style="border: 1px solid;"><?= $no++; ?></td>
							<td style="border: 1px solid;"><?= $key['nama'] ?></td>
							<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
							<td style="border: 1px solid;"><?= $key['sekolah'] ?></td>
							<td style="border: 1px solid;"><?= $key['noind'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>

		<?php } elseif ($allinOne == '9' || $allinOne == '12' || $allinOne == '14') { ?>
			<!-- Kode Induk K , P, C Outsorcing-->
			<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?= $terbilang ?>) orang tenaga kerja <?= strtolower($jenis) ?> untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-' ? '' : 'SEKSI ' . $cekData[0]['seksi'] . ',' ?> <?= $cekData[0]['unit'] == '-' ? '' : 'UNIT ' . $cekData[0]['unit'] . ',' ?> <?= $cekData[0]['dept'] == '-' ? '' : 'DEPARTEMEN ' . $cekData[0]['dept'] ?>.</b></p>
			<p style="font-size: 13px;">Adapun nama pekerja <?= strtolower($jenis) ?> tersebut adalah :</p>

			<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
				<tr>
					<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?>
					<td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
				</tr>
				<thead>
					<tr>
						<th style="border: 1px solid;"><i>No</i></th>
						<th style="border: 1px solid;"><i>Nama</i></th>
						<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
						<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
						<th style="border: 1px solid;"><i>Noind</i></th>
						<th style="border: 1px solid;"><i>Asal <?= $allinOne == '12' ? 'Pemborongan' : 'Outsourcing'; ?></i></th>
						<th style="border: 1px solid;"><i>Mulai Kerja</i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($cekData as $key) {
					?>
						<tr>
							<td style="border: 1px solid;"><?= $no++; ?></td>
							<td style="border: 1px solid;"><?= $key['nama'] ?></td>
							<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
							<td style="border: 1px solid;"><?= $key['noind'] ?></td>
							<td style="border: 1px solid;"><?= $key['asal_outsourcing'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgl_masuk'])) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php if ($allinOne != '14') { ?><p style="font-size: 13px;">Pekerja tersebut akan mendapatkan <u>Insentif Kerajinan</u> mulai tanggal <u><?= strftime('%d %B %Y', strtotime($cek['tgl_mulaiik'])); ?></u>.</p><?php } ?>
			<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>
		<?php } elseif ($allinOne == '11') { ?>
			<!-- Kode Induk C -->
			<p style="font-size: 13px;">Dengan ini kami serahkan <?= count($cekData) ?> (<?= $terbilang ?>) orang pekerja Kontrak Non Staff untuk ditempatkan di <b><?= $cekData[0]['seksi'] == '-' ? '' : 'SEKSI ' . $cekData[0]['seksi'] . ',' ?> <?= $cekData[0]['unit'] == '-' ? '' : 'UNIT ' . $cekData[0]['unit'] . ',' ?> <?= $cekData[0]['dept'] == '-' ? '' : 'DEPARTEMEN ' . $cekData[0]['dept'] ?>.</b></p>
			<p style="font-size: 13px;">Adapun nama pekerja waktu tertentu tersebut adalah :</p>

			<table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
				<tr>
					<td colspan="3"><b>Kantor Asal : <?= $cekData[0]['kantor_asal'] ?>
					<td colspan="6"><b>Lokasi Kerja : <?= $cekData[0]['lokasi_kerja'] ?></b></td>
				</tr>
				<thead>
					<tr>
						<th style="border: 1px solid;"><i>No</i></th>
						<th style="border: 1px solid;"><i>Nama</i></th>
						<th style="border: 1px solid;"><i>Temp.Lhr</i></th>
						<th style="border: 1px solid;"><i>Tgl.Lhr</i></th>
						<th style="border: 1px solid;"><i>Noind</i></th>
						<th style="border: 1px solid;"><i>Gol</i></th>
						<th style="border: 1px solid;"><i>Orientasi Kerja</i></th>
						<th style="border: 1px solid;"><i>Kontrak Kerja</i></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 1;
					foreach ($cekData as $key) {
					?>
						<tr>
							<td style="border: 1px solid;"><?= $no++; ?></td>
							<td style="border: 1px solid;"><?= $key['nama'] ?></td>
							<td style="border: 1px solid;"><?= $key['templahir'] ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['tgllahir'])) ?></td>
							<td style="border: 1px solid;"><?= $key['noind'] ?></td>
							<td style="border: 1px solid;"><?= $key['gol'] ? $key['gol'] : '-' ?></td>
							<td style="border: 1px solid;"><?= ($key['lama_trainee'] != '0') ? date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['diangkat'] . '-1 day')) : date('d/m/Y', strtotime($key['tgl_masuk'])) . ' - ' . date('d/m/Y', strtotime($key['diangkat'])) ?></td>
							<td style="border: 1px solid;"><?= date('d/m/Y', strtotime($key['diangkat'])) . ' - ' . date('d/m/Y', strtotime($key['akhkontrak'])) ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<p style="font-size: 13px;">Dan untuk kemudian apabila berdasarkan hasil evaluasi selama menjalani orientasi pekerja tersebut dapat menunjukkan unjuk kerja yang diharapkan,
				maka pekerja waktu tertentu akan bekerja di CV. Karya Hidup Sentosa dengan masa kontrak kerja sebagaimana tersebut di atas.</p>
			<p style="font-size: 13px;">Mohon seksi dapat menginformasikan pola shift pekerja yang bersangkutan kepada sie hubungan kerja periode bulan berjalan maksimal 1 hari setelah pekerja masuk seksi.</p>
		<?php }

		if ($allinOne == '8' || $allinOne == '13' || $allinOne == '7') {
			echo "<p style='font-size: 13px;'>Demikian untuk menjadikan periksa, dan kami menantikan hasil evaluasi kerja siswa PKL bersangkutan.<br>Atas bantuan dan kerjasamanya kami ucapkan terimakasih.</p>";
		} else {
			echo "<p style='font-size: 13px;'>Demikian surat penyerahan ini, atas bantuan dan kerjasamanya kami ucapkan terimakasih.</p>";
		}
		?>
		<table style="width: 100%; font-size: 13px; margin-top: 10px;">
			<tr>
				<td>Yogyakarta,
					<?= strftime('%d %B %Y', strtotime($tgl_cetak));
					?></td>
			</tr>
			<tr>
				<td style="width: 60%">Departemen Personalia</td>
			</tr>
			<tr>
				<td style="width: 60%">ub. Kepala,</td>
			</tr>
		</table>
		<table style="font-size: 13px;margin-top: 45px;margin-bottom: 20px;">
			<tr>
				<td style="width: 60%"><u><?php echo ucwords(strtolower($approval[0]['nama'])) ?> </u></td>

			</tr>
			<tr>
				<td><?php echo ucwords(strtolower($approval[0]['jabatan'])) ?></td>

			</tr>
		</table>
		Tembusan :<br>
		<?php
		$no = 1;
		if ($tembusan) {
			foreach ($tembusan as $value) {
				if ($allinOne == '1' || $allinOne == '2') {
					echo $no++ . '. ' . $value . '<br>';
				} else {
					if ($allinOne == '10' || $allinOne == '11' || $allinOne == '14') {
						if (strstr($value, 'DEPARTEMEN') || strstr($value, 'BIDANG') || strstr($value, 'UNIT')) {
							unset($value);
						} else {
							if (strstr($value, 'KHS TUKSONO')) {
								$tebus = explode(' KHS TUKSONO', $value);
								echo $no++ . '. ' . $tebus[0] . '<br>';
							} else {
								echo $no++ . '. ' . $value . '<br>';
							}
						}
					} else {
						if (strstr($value, 'DEPARTEMEN') || strstr($value, 'BIDANG')) {
							unset($value);
						} else {
							if (strstr($value, 'KHS TUKSONO')) {
								$tebus = explode(' KHS TUKSONO', $value);
								echo $no++ . '. ' . $tebus[0] . '<br>';
							} else {
								echo $no++ . '. ' . $value . '<br>';
							}
						}
					}
				}
			}
			echo $no++ . '. ADMINISTRATOR PENGGAJIAN <br>';
			if ($allinOne == '10' || $allinOne == '11' || $allinOne == '14') {
				echo $no++ . '. KEPALA SEKSI KOORDINATOR AKUNTANSI CABANG <br>';
			}
			echo $no++ . '. ARSIP';
		} else {
			echo '1. ADMINISTRATOR PENGGAJIAN <br>';
			if ($allinOne == '10' || $allinOne == '11' || $allinOne == '14') {
				echo '2. KEPALA SEKSI KOORDINATOR AKUNTANSI CABANG <br>';
				echo '3. ARSIP';
			} else {
				echo '2. ARSIP';
			}
		} ?>
		<p style="font-size: 13px;"><?= $petugas . '/' . $petugas2 ?></p>
	</div>
</body>

</html>