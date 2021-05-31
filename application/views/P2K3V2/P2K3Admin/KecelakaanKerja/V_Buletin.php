<style>
	.br-left {
		border-left: 1px solid black;
	}

	.br-right {
		border-right: 1px solid black;
	}

	.br-bottom {
		border-bottom: 1px solid black;
	}

	.br-top {
		border-top: 1px solid black;
	}

	.center {
		text-align: center;
	}

	.kotak {
		width: 15px;
		height: 10px;
		border: 1px solid black;
	}

	label {
		font-weight: bold;
	}

	.table1 {
		padding-top: 10px;
		padding-left: 30px;
	}

	.tbl-pad tr td {
		text-align: center;
		padding: 3px;
	}
</style>
<div style="width: 100%; height: 100%; border: 1px solid black;">
	<table style="width: 100%;" class="br-bottom">
		<tr>
			<td style="width: 7%; text-align: center;">
				<img src="./assets/img/logo/logo.png" style="width: 100px;">
			</td>
			<td class="br-left br-right" style="width: 50%; text-align: center;">
				<h4 style="font-weight: bold;">PANITIA PEMBINA KESELAMATAN DAN KESEHATAN KERJA ( P2K3 )</h4>
				<br>
				<h3 style="font-weight: bold;">CV. KARYA HIDUP SENTOSA – YOGYAKARTA</h3>
				<h4 style="font-weight: bold;">BULETIN KECELAKAAN TAHUN <?= $tahun ?></h4>
			</td>
			<td style="width: 7%; text-align: center;">
				<img src="./assets/img/logo/p2k3-bg-white.png" style="width: 100px;">
			</td>
			<td style="width: 12%;" class="center br-left">
				<p style="font-weight: bold;">Mengetahui</p>
				<br><br><br><br>
				<p style="font-weight: bold;">(⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ )</p>
				<p style="font-weight: bold;">Ketua P2K3</p>
			</td>
			<td style="width: 12%;" class="center br-left br-right">
				<p style="font-weight: bold;">Diperiksa</p>
				<br><br><br><br>
				<p style="font-weight: bold;">( ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ )</p>
				<p style="font-weight: bold;"> Sie. Promosi</p>
			</td>
			<td style="width: 12%;" class="center">
				<p style="font-weight: bold;">Dibuat</p>
				<br><br><br><br>
				<p style="font-weight: bold;">(⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀ )</p>
				<p style="font-weight: bold;">Sekretaris</p>
			</td>
		</tr>
	</table>
	<table style="width: 100%;" border="0">
		<tr>
			<td style="width: 60%;">
				<table style="width: 100%;">
					<!--grafik 1-->
					<tr>
						<td colspan="2" class="center br-bottom br-right">
							<p style="font-weight: bold;">Perbandingan Total Kecelakaan Kerja <?= ($tahun - 1) ?> Dan <?= $tahun ?></p>
						</td>
					</tr>
					<tr>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<span class="kotak" style="background-color: red; color: red;">aa</span>
										<label><?= ($tahun - 1) ?> = <?= $perbandingan1['tahunlalu'] ?></label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="kotak" style="background-color: blue; color: blue;">aa</span>
										<label><?= $tahun ?> = <?= $perbandingan1['tahunini'] ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<?= $perbandingan1['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<span class="kotak" style="background-color: purple; color: purple;">aa</span>
										<label>Pusat = <?= $perbandingan2['pst'] ?></label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="kotak" style="background-color: orange; color: orange;">aa</span>
										<label>Tuksono = <?= $perbandingan2['tks'] ?></label>
									</td>
								</tr>
								<tr>
									<td>
										<?= $perbandingan2['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--grafik 2-->
					<tr>
						<td colspan="2" class="center br-bottom br-right">
							<p style="font-weight: bold;"> Data Total Bagian Tubuh Yang Mengalami Kecelakaan Kerja Periode Januari – Desember <?= $tahun ?></p>
						</td>
					</tr>
					<tr>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<b>Total = <?= $bagian1['ttl'] ?></b>
									</td>
								</tr>
								<tr>
									<td>
										<?= $bagian1['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<span class="kotak" style="background-color: purple; color: purple;">aa</span>
										<label>Pusat = <?= $bagian2['pst'] ?></label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="kotak" style="background-color: orange; color: orange;">aa</span>
										<label>Tuksono = <?= $bagian2['tks'] ?></label>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;">
										<?= $bagian2['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--grafik 3-->
					<tr>
						<td colspan="2" class="center br-bottom br-right">
							<p style="font-weight: bold;">Kriteria Kecelakaan Kerja Periode Januari - Desember <?= $tahun ?></p>
						</td>
					</tr>
					<tr>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<b>Total = <?= $bsrl1['ttl'] ?></b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;">
										<?= $bsrl1['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<span class="kotak" style="background-color: purple; color: purple;">aa</span>
										<label>Pusat = <?= $bsrl2['pst'] ?></label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="kotak" style="background-color: orange; color: orange;">aa</span>
										<label>Tuksono = <?= $bsrl2['tks'] ?></label>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;">
										<?= $bsrl2['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--Grafik 4-->
					<tr>
						<td colspan="2" class="center br-bottom br-right">
							<p style="font-weight: bold;"> Kriteria Kecelakaan Berdasarkan Stop Six Periode Januari - Desember <?= $tahun ?></p>
						</td>
					</tr>
					<tr>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<b>Total = <?= $six1['ttl'] ?></b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;">
										<?= $six1['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
						<td style="width: 50%" class="br-bottom br-right">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<span class="kotak" style="background-color: purple; color: purple;">aa</span>
										<label>Pusat = <?= $six2['pst'] ?></label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="kotak" style="background-color: orange; color: orange;">aa</span>
										<label>Tuksono = <?= $six2['tks'] ?></label>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;">
										<?= $six2['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--Grafik 5-->
					<tr>
						<td colspan="2" class="center br-bottom br-right">
							<p style="font-weight: bold;">Hari Bebas Kecelakaan Kerja Bulan Januari – Desember <?= $tahun ?></p>
						</td>
					</tr>
					<tr>
						<td style="width: 100%" class="br-bottom br-right" colspan="2">
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: left;">
										<b>.</b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;">
										<?= $bebas['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td style="width: 1%;" class="br-right"></td>
			<td style="width: 39%;">
				<table style="width: 100%">
					<tr>
						<td class="br-bottom center">
							<b>Perhitungan Kecelakaan Berdasarkan Jenis Pekerjaan</b>
						</td>
					</tr>
					<tr>
						<td>
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<b>Total = <?= $jp['ttl'] ?></b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;" class="br-bottom">
										<?= $jp['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td class="br-bottom center">
							<b>Perhitungan Kecelakaan Berdasarkan Kesesuaian WI / COP</b>
						</td>
					</tr>
					<tr>
						<td>
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: center;">
										<b>Total = <?= $wicop['ttl'] ?></b>
									</td>
								</tr>
								<tr>
									<td class="br-bottom" style="text-align: center;">
										<?= $wicop['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="br-bottom center">
							<b>5 Unit Tertinggi Yang Mengalami Kecelakaan Kerja</b>
						</td>
					</tr>
					<tr>
						<td>
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: left;">
										<b>.</b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;" class="br-bottom">
										<?= $unit['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="br-bottom center">
							<b>Data Seksi Tertinggi Yang Mengalami Kecelakaan Di Pusata</b>
						</td>
					</tr>
					<tr>
						<td>
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: left;">
										<b>.</b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;" class="br-bottom">
										<?= $seksiP['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="br-bottom center">
							<b>Data Seksi Tertinggi Yang Mengalami Kecelakaan Di Tuksono</b>
						</td>
					</tr>
					<tr>
						<td>
							<table style="width: 100%">
								<tr>
									<td style="padding-bottom: 5px; padding-top: 5px;text-align: left;">
										<b>.</b>
									</td>
								</tr>
								<tr>
									<td style="text-align: center;" class="br-bottom">
										<?= $seksiT['chart'] ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<pagebreak>
	<div style="width: 100%; height: 100%; border: 1px solid black;">
		<table>
			<tr>
				<td rowspan="2" valign="top" class="table1">
					<table border="1">
						<tr>
							<td colspan="2" style="padding: 5px;">
								<b>Hari Bebas Kecelakaan Kerja Bulan <?= $tahun ?></b>
							</td>
						</tr>
						<?php foreach ($bebas['arr'] as $key => $value) : ?>
							<tr>
								<td style="padding-left: 5px;"><?= $key ?></td>
								<td class="center"><?= $value ?></td>
							</tr>
						<?php endforeach ?>
					</table>
				</td>
				<td valign="top">
					<table>
						<tr>
							<td class="table1" valign="top">
								<table border="1">
									<tr>
										<td colspan="4" style="padding: 5px;">
											<b>Bagian Tubuh</b>
										</td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="center" style="background-color: #12d8fa;">P</td>
										<td class="center" style="background-color: #12d8fa;">T</td>
									</tr>
									<?php foreach ($bagian1['arr'] as $key => $value) : ?>
										<tr>
											<td style="padding-left: 5px;"><?= $key ?></td>
											<td style="padding: 5px;" class="center"><?= $value ?></td>
											<td style="padding: 5px;" class="center"><?= $bagian2['arrP'][$key] ?></td>
											<td style="padding: 5px;" class="center"><?= $bagian2['arrT'][$key] ?></td>
										</tr>
									<?php endforeach ?>
								</table>
							</td>
							<td class="table1" valign="top">
								<table border="1">
									<tr>
										<td colspan="4" style="padding: 5px;">
											<b>Kriteria Kecelakaan</b>
										</td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="center" style="background-color: #12d8fa;">P</td>
										<td class="center" style="background-color: #12d8fa;">T</td>
									</tr>
									<?php foreach ($bsrl1['arr'] as $key => $value) : ?>
										<tr>
											<td style="padding-left: 5px;"><?= $key ?></td>
											<td style="padding: 5px;" class="center"><?= $value ?></td>
											<td style="padding: 5px;" class="center"><?= $bsrl2['arrP'][$key] ?></td>
											<td style="padding: 5px;" class="center"><?= $bsrl2['arrT'][$key] ?></td>
										</tr>
									<?php endforeach ?>
								</table>
							</td>
							<td class="table1" valign="top">
								<table border="1">
									<tr>
										<td colspan="4" style="padding: 5px;">
											<b>Kriteria Stop Six</b>
										</td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="center" style="background-color: #12d8fa;">P</td>
										<td class="center" style="background-color: #12d8fa;">T</td>
									</tr>
									<?php foreach ($six1['arr'] as $key => $value) : ?>
										<tr>
											<td style="padding-left: 5px;"><?= $key ?></td>
											<td style="padding: 5px;" class="center"><?= $value ?></td>
											<td style="padding: 5px;" class="center"><?= $six2['arrP'][$key] ?></td>
											<td style="padding: 5px;" class="center"><?= $six2['arrT'][$key] ?></td>
										</tr>
									<?php endforeach ?>
								</table>
							</td>
							<td class="table1" valign="top">
								<table border="1">
									<tr>
										<td colspan="2" style="padding: 5px;">
											<b>Jenis Pekerjaan</b>
										</td>
									</tr>
									<?php foreach ($jp['arr'] as $key => $value) : ?>
										<tr>
											<td style="padding-left: 5px;"><?= $key ?></td>
											<td style="padding: 5px;" class="center"><?= $value ?></td>
										</tr>
									<?php endforeach ?>
								</table>
							</td>
							<td class="table1" valign="top">
								<table border="1">
									<tr>
										<td colspan="2" style="padding: 5px;">
											<b>Prosedur</b>
										</td>
									</tr>
									<?php foreach ($wicop['arr'] as $key => $value) : ?>
										<tr>
											<td style="padding-left: 5px;"><?= $key ?></td>
											<td style="padding: 5px;" class="center"><?= $value ?></td>
										</tr>
									<?php endforeach ?>
								</table>
							</td>
							<td class="table1" valign="top">
								<table border="1">
									<tr>
										<td colspan="2" style="padding: 5px;">
											<b>Penggunaan APD</b>
										</td>
									</tr>
									<?php foreach ($apd['arr'] as $key => $value) : ?>
										<tr>
											<td style="padding-left: 5px;"><?= $key ?></td>
											<td style="padding: 5px;" class="center"><?= $value ?></td>
										</tr>
									<?php endforeach ?>
								</table>
							</td>
							<td class="table1" valign="top" style="padding-left: 30px; padding-right: 5px;">
								<table border="1" class="tbl-pad">
									<tr>
										<td colspan="2" style="background-color: grey;">Total Kecelakaan Kerja</td>
									</tr>
									<tr>
										<td>Pusat</td>
										<td><?= $perbandingan2['pst'] ?></td>
									</tr>
									<tr>
										<td>Tuksono</td>
										<td><?= $perbandingan2['tks'] ?></td>
									</tr>
									<tr>
										<td><?= $tahun - 1 ?></td>
										<td><?= $perbandingan1['tahunlalu'] ?></td>
									</tr>
									<tr>
										<td><?= $tahun ?></td>
										<td><?= $perbandingan1['tahunini'] ?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<table style="width: 100%" style="margin-top: 20px;">
						<tr>
							<td style="padding-left: 30px;" valign="top">
								<table border="1" class="tbl-pad">
									<tr>
										<td>Bulan</td>
										<td><?= $tahun - 1 ?></td>
										<td><?= $tahun ?></td>
									</tr>
									<?php foreach ($perbandingan1['arrini'] as $key => $value) : ?>
										<tr>
											<td><?= $key ?></td>
											<td><?= $perbandingan1['arrlalu'][$key] ?></td>
											<td><?= $value ?></td>
										</tr>
									<?php endforeach ?>
									<tr>
										<td>Total</td>
										<td><?= $perbandingan1['tahunlalu'] ?></td>
										<td><?= $perbandingan1['tahunini'] ?></td>
									</tr>
								</table>
							</td>
							<td style="padding-left: 30px;" valign="top">
								<table border="1" class="tbl-pad">
									<tr>
										<td>Bulan</td>
										<td>Pusat</td>
										<td>Tuksono</td>
									</tr>
									<?php foreach ($perbandingan2['arrP'] as $key => $value) : ?>
										<tr>
											<td><?= $key ?></td>
											<td><?= $value ?></td>
											<td><?= $perbandingan2['arrT'][$key] ?></td>
										</tr>
									<?php endforeach ?>
									<tr>
										<td>Total</td>
										<td><?= $perbandingan2['pst'] ?></td>
										<td><?= $perbandingan2['tks'] ?></td>
									</tr>
								</table>
							</td>
							<td style="padding-left: 30px;" valign="top">
								<table class="tbl-pad" border="1">
									<tr>
										<td colspan="4" style="background-color: grey;">Pusat</td>
										<td colspan="3" style="background-color: grey;">Tuksono</td>
									</tr>
									<tr>
										<td style="background-color: #12d8fa">Bulan</td>
										<td style="background-color: #12d8fa">Jumlah Pekerja</td>
										<td style="background-color: #12d8fa">Jumlah Laka</td>
										<td style="background-color: #12d8fa">%</td>
										<td style="background-color: orange;">Jumlah Pekerja</td>
										<td style="background-color: orange;">Jumlah Laka</td>
										<td style="background-color: orange;">%</td>
									</tr>
									<?php for ($i = 0; $i < 12; $i++) {
										$monthNum  = $i + 1;
										$monthName = date('M', mktime(0, 0, 0, $monthNum, 10)); // jan,dec,...
										if ($i == $laka['break'] && $tahun == date('Y')) break;
									?>
										<tr>
											<td><?= $monthName ?></td>
											<td><?= $laka['jmlp'][$i] ?></td>
											<td><?= $laka['lakap'][$i] ?></td>
											<td><?= $laka['jmlp'][$i] > 0 ? round($laka['lakap'][$i] / $laka['jmlp'][$i] * 100, 1) : '' ?> %</td>
											<td><?= $laka['jmlt'][$i] ?></td>
											<td><?= $laka['lakat'][$i] ?></td>
											<td><?= $laka['jmlt'][$i] > 0 ? round($laka['lakat'][$i] / $laka['jmlt'][$i] * 100, 1) : '' ?> %</td>
										</tr>
									<?php
									}
									?>
								</table>
							</td>
							<td style="padding-left: 30px;" valign="top">
								<?= $laka['chart'] ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>