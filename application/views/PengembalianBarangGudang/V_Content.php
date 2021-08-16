<!-- CONTENT -->
<div style="height: 335px">
	<table  class="isi" style="width:100%; height: 10px;  ">
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">Kode Barang</th>
			<th rowspan="2">Nama Barang</th>
			<th rowspan="2">Sat.</th>
			<th colspan="2">Qty.</th>
			<th rowspan="2">No. Seri</th>
			<th colspan="2">LokasiGudang</th>
		</tr>
		<tr>
			<th>Qty.</th>
			<th>Act.</th>
			<th>Asal.</th>
			<th>Tujuan.</th>
		</tr>
		<?php
		foreach ($datalist as $key => $data) {?>
			<tr style="height: 10px;">
				<td style="width:5%;"><?= ++$key?></td>
				<td style="width:20%;"><?= $data['KODE_BARANG']?></td>
				<td style="width:30%;text-align: left;"><?= $data['NAMA_BARANG']?></td>
				<td style="width:5%;"><?= $data['UOM_CODE']?></td>
				<td style="width:10%;"><?= $data['QTY_MINTA']?></td>
				<td style="width:10%;"></td>
				<td style="width:5%;"></td>
				<td style="width:10%;"><?= $data['LOKASI_ASAL']?></td>
				<td style="width:10%;"><?= $data['LOKASI_TUJUAN']?></td>
			</tr>
		<?php }?>
	</table>
</div>