<table class="table table-head" style="padding-bottom: 8px; width: 100%">
	<tr>
		<td width="100%">
			<center>				
			<h2>LAPORAN HASIL RESOURCE OPNAME<br>
			CV. KARYA HIDUP SENTOSA</h2>
			</center>
		</td>

	</tr>
</table>
<table class="table table-head" style="padding-bottom: 8px; width: 100%;">
	<tr>
		<td width="20%" ><b>Nomor Dokumen</b></td>
		<td width="2%" >:</td>
		<td width="28%" ><?= ($dataFilter[0]['NO_DOCUMENT_RO']) ? $dataFilter[0]['NO_DOCUMENT_RO'] : '' ?></td>
		<td width="20%" ><b>Jenis IO</b></td>
		<td width="2%" >:</td>
		<td width="28%" ><?= ($dataFilter[0]['NO_DOCUMENT_RO']) ? $dataFilter[0]['JENIS_IO_RO'] : '' ?></td>
	</tr>
	<tr>
		<td><b>Tanggal Resource Opname</b></td>
		<td>:</td>
		<td><?= ($dataFilter[0]['CREATION_DATE']) ? $dataFilter[0]['CREATION_DATE'] : '' ?></td>
		<td><b>Petugas RO</b></td>
		<td>:</td>
		<td rowspan="4">
			<table>
				<?php
					for ($i=0; $i < 4; $i++) { ?>
						<tr>
							<td><?= $i+1; ?></td>
						</tr>
				<?php 	} ?>
			</table>
		</td>
	</tr>
	<tr>
		<td><b>Lokasi</b></td>
		<td>:</td>
		<td><?= ($dataFilter[0]['LOKASI_RO']) ? $dataFilter[0]['LOKASI_RO'] : '' ?></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><b>Lantai</b></td>
		<td>:</td>
		<td><?= ($dataFilter[0]['LANTAI_RO']) ? $dataFilter[0]['LANTAI_RO'] : '' ?></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><b>Ruang</b></td>
		<td>:</td>
		<td><?= ($dataFilter[0]['RUANG_RO']) ? $dataFilter[0]['RUANG_RO'] : '' ?></td>
		<td></td>
		<td></td>
	</tr>
</table>