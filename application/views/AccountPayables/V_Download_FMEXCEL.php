<?php 
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=exceldata.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>

<table>
	<tr><th colspan="17"><h3><b>"FAKTUR MASUKAN"</b></h3></th></tr>
	<tr><td colspan="2">Diunduh pada : <?php echo date("d/m/Y")?></td></tr>
	<tr><td></td></tr>
</table>

<table>
	<tbody>
		<tr bgcolor="#87CEFA">
			<td align="center">FM</td>
			<td align="center">KODE JENIS TRANSAKSI</td>
			<td align="center">FG PENGGANTI</td>
			<td align="center">NOMOR FAKTUR</td>
			<td align="center">MASA PAJAK</td>
			<td align="center">TAHUN PAJAK</td>
			<td align="center">TANGGAL FAKTUR</td>
			<td align="center">NPWP</td>
			<td align="center">NAMA</td>
			<td align="center">ALAMAT LENGKAP</td>
			<td align="center">JUMLAH DPP</td>
			<td align="center">JUMLAH PPN</td>
			<td align="center">JUMLAH PPNBM</td>
			<td align="center">IS CREDIT ABLE</td>
			<td align="center">KETERANGAN</td>
			<td align="center">STATUS</td>
			<td align="center">NOMOR INVOICE</td>
		</tr>
		<?php
			if(!(empty($FilteredFaktur))){
			$no=0;
			foreach($FilteredFaktur as $FF) { $no++;
			$typ = substr($FF->FAKTUR_PAJAK, 0, 2);
			$alt = substr($FF->FAKTUR_PAJAK, 2, 1);
			$num = substr($FF->FAKTUR_PAJAK, 3);
		?>
		<tr>
			<td align="center"><?php echo $FF->FM?></td>
			<td align="center"><?php echo $typ?></td>
			<td align="center"><?php echo $alt?></td>
			<td align="center"><?php echo $num?></td>
			<td align="center"><?php echo $FF->MONTH?></td>
			<td align="center"><?php echo $FF->YEAR?></td>
			<td align="center"><?php echo $FF->FAKTUR_DATE?></td>
			<td align="center"><?php echo $FF->NPWP?></td>
			<td align="center"><?php echo $FF->NAME?></td>
			<td align="center"><?php echo $FF->ADDRESS?></td>
			<td align="center"><?php echo $FF->DPP?></td>
			<td align="center"><?php echo $FF->PPN?></td>
			<td align="center"><?php echo $FF->PPN_BM?></td>
			<td align="center"><?php echo $FF->IS_CREDITABLE_FLAG?></td>
			<td align="center"><?php echo $FF->DESCRIPTION?></td>
			<td align="center"><?php echo $FF->STATUS?></td>
			<td align="center"><?php echo $FF->INVOICE_NUM?></td>
		</tr>
		<?php }}?>
	</tbody>
</table>