<table id="tabel_search_tracking_lppb" class="table table-striped table-bordered table-hover text-center dataTable">
	<thead style="vertical-align: middle;"> 
		<tr class="bg-primary">
			<td class="text-center">No</td>
			<td class="text-center">Nomor LPPB</td>
			<td class="text-center">Nama Vendor</td>
			<td class="text-center">Tanggal LPPB</td>
			<td class="text-center">Nomor PO</td>
			<td class="text-center">Gudang Input</td>
			<td class="text-center">Gudang Kirim</td>
			<td class="text-center">Akuntansi Terima</td>
			<td class="text-center" title="Kode Barang - Nama Barang - Jumlah" >Detail LPPB</td>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; if ($lppb) {
			foreach($lppb as $i) { ?>
		<tr>
			<td>
				<?php echo $no ?>
			</td> 
			<td><?php echo $i['LPPB_NUMBER']?></td>
			<td><?php echo $i['VENDOR_NAME']?></td>
			<td><?php echo $i['TANGGAL_LPPB']?></td>
			<td><?php echo $i['PO_NUMBER']?></td>
			<td><?php echo $i['GUDANG_INPUT']?></td>
			<td><?php echo $i['GUDANG_KIRIM']?></td>
			<td><?php echo $i['AKUNTANSI_TERIMA']?></td>
			<td><?php echo $i['KODE_BARANG'].'|'.$i['NAMA_BARANG']?></td>
		</tr>
		<?php $no++;}} ?>
	</tbody>
</table>