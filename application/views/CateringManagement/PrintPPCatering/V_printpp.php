<?php foreach ($Printpp as $value): ?>
<table style="width:100%;">
	<thead>
		<tr>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 12%"><b>Kode Barang</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 5%"><b>Qty</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 7%"><b>Satuan</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 36%"><b>Nama Barang</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 10%"><b>Branch</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 10%"><b>Cost Center</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 17%"><b>NBD</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 10%"><b>Keterangan</b></td>
			<td style="border:1px solid black;font-size: 10px;text-align: center; width: 10%"><b>Supplier</b></td>
		</tr>
	</thead>
	<?php $count=0; ?>
		<?php foreach ($PrintppDetail as $key): ?>
			<?php $count++; ?>
				<tr>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo $key['pp_kode_barang'];?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo $key['pp_jumlah'];?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo $key['pp_satuan'];?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo str_replace("TANGGAL", "<br>TANGGAL",str_replace("DEPT", "<br>DEPT", $key['pp_nama_barang']));?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo $key['pp_branch'];?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo $key['pp_cost_center'];?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo date("d F Y", strtotime($key['pp_nbd']));?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo $key['pp_keterangan'];?></td>
					<td style="border:1px solid black;font-size: 12px;text-align: center;"><?php echo $key['pp_supplier'];?></td>
				</tr>
	<?php endforeach; ?>
	<?php if(($count%18) != 0) : ?>
		<?php for ($i=0; $i<(18 - ($count%18)); $i++) : ?>
				<tr>
					<td style="border:1px solid black;">&nbsp;<br>&nbsp;<br>&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
					<td style="border:1px solid black;">&nbsp;</td>
				</tr>
		<?php endfor; ?>
	<?php endif; ?>
</table>
<?php endforeach; ?>
