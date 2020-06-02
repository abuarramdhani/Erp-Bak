<div style="border-bottom: 1.4px solid black;border-left: 1.4px solid black;border-right: 1.3px solid black;background:white">
		<table style="width:100%;height: 320px;border-collapse: collapse !important;page-break-inside:avoid;">
			<tr>
				<td style="width:48%;padding:5px;">
						<br><br><br>
						<i style="font-size:11px;">*) Untuk melihat detail barang, cek web Monitoring Pengiriman Barang Internal KHS.
						<span style="color:blue;">http://produksi.quick.com/PengirimanBarangInternal</span></i style="font-size:10px;">
				</td>
				<td style="width:26%;padding:5px;font-size:12px;vertical-align: text-top">
					<center>
						<br><b>DIKIRIM OLEH :</b>
						<br>
						<br>
						<br>
						<br>
						<br>
						<?php echo $get['Header'][0]['NAMA_SUPIR']?>
						<!-- STEV -->
					</center>
				</td>
				<td style="width:26%;padding:5px;font-size:12px;vertical-align: text-top">
					<center>
						<br><b>DITERIMA OLEH :</b><br>
						<br>
						<br>
						<br>
						<br>
						GUDANG PENERIMAAN
					</center>
				</td>
			</tr>
		</table>
	</div>
	<table style="width: 100%;">
		<tr>
			<td style="font-size: 11px;width:83%;font-weight:bold">
				FRM-PPB-02-02
			</td>
			<td style="width:17%;font-size: 11px;">
				<?php  $get['Header'][0]['FLAG_CETAK'] == 'Y' ? $f = "<b style='color:red'>Sudah Pernah Dicetak</b>" : $f = ''; echo $f?>
			</td>
		</tr>
	</table>
<!-- <pagebreak> -->
