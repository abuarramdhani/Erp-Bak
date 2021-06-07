<table style="border: 2px solid black; border-collapse: collapse; width: 100%;margin-top:20px">
	<!-- <tr>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: left;vertical-align: top;padding-left: 7px;font-size: 12px;width: 30%" rowspan="5">Catatan Umum : </td>
		<td colspan="2" style="border: 2px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 24%; border-bottom: 1px solid black">Production Engineering</td>
		<td style="border: 2px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">PPIC</td>
		<td colspan="2" style="border: 2px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 46%; border-bottom: 1px solid black">Fabrikasi</td>

	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black">Prepared</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black;border-right: 2px solid black">Checked</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black;border-right: 2px solid black">Checked</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black">Checked</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;width: 14%;border-top: 1px solid black">Approved</td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">&nbsp;&nbsp;<br>&nbsp;&nbsp;<br>&nbsp;&nbsp;<br>&nbsp;&nbsp;</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>

	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 2px solid black"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br></td>

	</tr>
	<tr> -->
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Tgl Terjadwal</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Tgl Aktual</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Status</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Jam Mulai</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Jam Selesai</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Pelaksana</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px; border-bottom: 0px solid black">Instruksi Khusus K3 :</td>
	</tr>
	<tr>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px">&nbsp;&nbsp;<br><?= $datapdf['0']['SCHEDULE_DATE'] ?><br>&nbsp;&nbsp;</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['ACTUAL_DATE'] ?><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><i><?= $datapdf['0']['STATUS'] ?></i><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['JAM_MULAI'] ?><br><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['JAM_SELESAI'] ?><br><br></td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['PELAKSANA'] ?><br><br></td>
		<td style="border: 0px solid black;border-collapse: collapse; text-align: left;font-size: 12px">

			<span style="font-family:Calibri">&#9745;</span><label for="instruksi1">Baju kerja</label>

			<br />
			<span style="font-family:Calibri">&#9745;</span><label for="instruksi3"> Ear Plug</label>

			<br />
			<span style="font-family:Calibri">&#9745;</span><label for="instruksi5"> Masker Kain</label>

		</td>
		<td style="border: 0px solid black;border-collapse: collapse; text-align: left;font-size: 12px">
			<span style="font-family:Calibri">&#9745;</span><label for="instruksi2"> Sepatu Safety</label> <br />
			<span style="font-family:Calibri">&#9745;</span><label for="instruksi4"> Sarung Tangan Katun</label> <br />
			<span style="font-family:Calibri">&#9745;</span><label for="instruksi6"> Helm</label>
		</td>

	</tr>
	<tr>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Sparepart yang digunakan</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Spesifikasi / Part Number</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Jumlah</td>
		<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Satuan</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: left;font-size: 12px; border-bottom: 0px solid black">Catatan Revisi Dokumen :</td>

	</tr>
	<?php
if (sizeof($sparepart) == 0) {
?>
    <tr>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> - <br></td>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> - <br></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> - </td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"> - </td>
			<td></td>
		</tr>
<?php } else { ?>
    <?php
	$no = 1;

	for ($i = 0; $i < sizeof($sparepart); $i++) {
	?>
		<tr>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['SPAREPART'] ?><br></td>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['SPESIFIKASI'] ?><br></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['JUMLAH'] ?></td>
			<td style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $sparepart[$i]['SATUAN'] ?></td>
			<td></td>
		</tr>
	<?php } ?>
<?php } ?>
	<tr>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Staff Seksi Terkait</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black">Staff Maintenance</td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px; border-bottom: 1px solid black ;">Opt Maintenance</td>
		<td colspan="2" rowspan="3" style="border: 0px solid black;border-collapse: collapse; text-align: left;font-size: 12px;"><?= $header[0]['CATATAN_REVISI'] ?></td>
	</tr>
	<tr>

		<?php
		if ($datapdf['0']['APPROVED_DATE_2'] == null) {
		?>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br>
				<h3><i><b> </b></i></h3><br>
			</td>
		<?php } else { ?>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br>
				<h3><i><b> DISETUJUI </b></i></h3><br><?= $datapdf['0']['APPROVED_DATE_2'] ?>
			</td>
		<?php } ?>

		<!-- <td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><br><h3><i><b> DISETUJUI </b></i></h3><br><?= $datapdf['0']['APPROVED_DATE_2'] ?></td> -->
		<?php
		if ($datapdf['0']['APPROVED_DATE'] == null) {
		?>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><br>
				<h3><i><b> </b></i></h3><br>
			</td>
		<?php } else { ?>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><br>
				<h3><i><b> DICEK </b></i></h3><br><?= $datapdf['0']['APPROVED_DATE'] ?>
			</td>
		<?php } ?>

		<!-- <td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><br><h3><i><b> DICEK </b></i></h3><br><?= $datapdf['0']['APPROVED_DATE'] ?></td> -->

		<?php
		if ($datapdf['0']['CREATION_DATE'] == null) {
		?>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><br>
				<h3><i><b> </b></i></h3><br>
			</td>
		<?php } else { ?>
			<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><br>
				<h3><i><b> DILAPORKAN </b></i></h3><br><?= $datapdf['0']['CREATION_DATE'] ?>
			</td>
		<?php } ?>

		<!-- <td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><br><h3><i><b> DILAPORKAN </b></i></h3><br><?= $datapdf['0']['CREATION_DATE'] ?></td> -->

	</tr>
	<tr>
		<!-- <td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><?= $datapdf['0']['APPROVED_BY_2'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><?= $datapdf['0']['APPROVED_BY'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><?= $datapdf['0']['REQUEST_BY'] ?></td> -->

		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px"><b><?= $datapdf['0']['REQUEST_TO_2'] ?></b><br><?= $datapdf['0']['APPROVED_BY_2_NAME'][0]['nama'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><b><?= $datapdf['0']['REQUEST_TO'] ?></b><br><?= $datapdf['0']['APPROVED_BY_NAME'][0]['nama'] ?></td>
		<td colspan="2" style="border: 1px solid black;border-collapse: collapse; text-align: center;font-size: 12px;border-right: 1px solid black"><b><?= $datapdf['0']['REQUEST_BY'] ?></b><br><?= $datapdf['0']['REQUEST_BY_NAME'][0]['nama'] ?></td>

	</tr>
</table>
<!-- <p style="text-align: right;font-style: italic;margin-top: 2px;font-size: 8pt;margin-right: 7px">FRM-PDE-03-09 (rev00 - 21 Sept 2020)</p> -->