<!-- CONTENT -->
<div style="height: 335px">
	<table  class="isi" style="width:100%; height: 10px; font-size:10px;">
		<tr>
			<th>No</th>
			<th>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Qty</th>
			<th>Sat</th>
			<th>No. Seri</th>
			<th>Keterangan</th>
		</tr>
		<?php
		foreach ($datalist as $key => $data) {?>
			<tr>
				<td style="width:5%;"><?= ++$key?></td>
				<td style="width:20%;"><?= $data['KODE_BARANG']?></td>
				<td style="width:30%;text-align: left;"><?= $data['NAMA_BARANG']?></td>
				<td style="width:10%;"><?= $data['QTY_MINTA']?></td>
				<td style="width:5%;"><?= $data['UOM_CODE']?></td>
                <td style="width:10%;"></td>
                <td style="width:20%;"><?= $data['REFER']?></td>
			</tr>
		<?php }?>
	</table>
</div>