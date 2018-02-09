<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.text-center {
			text-align: center;
		}
		.table {
			width: 100%;
			max-width: 100%;
		}
		.table-bordered, .table-bordered td {
			border: 1px solid #c3c3c3;
			border-collapse: collapse;
		}
		body {
			font-size: 10px;
		}
	</style>
</head>
<body>
	<?php
	foreach ($jobHeader as $head) {
	?>
		<table class="table table-bordered">
			<tr>
				<td colspan="2" rowspan="3" style="padding: 3px; text-align: center; vertical-align: middle;">
					<img src="<?php echo base_url('assets/img/logo.png') ?>" class="img" style="max-width: 60px">
				</td>
				<td rowspan="3" colspan="2" style="padding: 3px;">
					<strong><h5>CV. KARYA HIDUP SENTOSA</h5></strong>
					<small>Jl. Magelang no. 144, Yogyakarta</small>
					<strong>
						<h5>PERMINTAAN PENGGANTIAN</h5>
						<h5>KOMPONEN & MATERIAL PICKLIST JOB/BATCH</h5>
						<h5>(REJECT MATERIAL)</h5>
					</strong>
				</td>
				<td rowspan="3" colspan="2" style="padding: 3px; text-align: center; vertical-align: middle;">
					<img src="<?php echo base_url('assets/upload/ManufacturingOperation/temp/qrcode/'.$replacement_number.'.png') ?>" class="img" style="max-width: 65px">
				</td>
				<td style="padding: 3px;">Tanggal</td>
				<td style="padding: 3px;">: <strong><?php echo date('d-M-y'); ?></strong></td>
				<td style="padding: 3px;">No</td>
				<td style="padding: 3px;">: <strong><?php echo $replacement_number; ?></strong></td>
			</tr>
			<tr>
				<td style="padding: 3px;">Seksi</td>
				<td style="padding: 3px;">: <strong><?php echo $head['SEKSI']; ?></strong></td>
				<td style="padding: 3px;">No Job</td>
				<td style="padding: 3px;">: <strong><?php echo $head['WIP_ENTITY_NAME']; ?></strong></td>
			</tr>
			<tr>
				<td rowspan="2" colspan="4" style="padding: 3px;">
					<p>Produk / Assy Description :</p>
					<strong>
						<p><?php echo $head['SEGMENT1']; ?></p>
						<p><?php echo $head['DESCRIPTION']; ?></p>
					</strong>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding: 3px;">Gudang</td>
				<td colspan="4" style="padding: 3px;">: <strong><?php echo $subinv; ?></strong></td>
			</tr>
			<tr>
				<td class="text-center" rowspan="2" style="padding: 3px;"><strong>No.</strong></td>
				<td class="text-center" rowspan="2" colspan="2" style="padding: 3px;"><strong>Kode</strong></td>
				<td class="text-center" rowspan="2" colspan="2" style="padding: 3px;"><strong>Nama Barang</strong></td>
				<td class="text-center" rowspan="2" style="padding: 3px;"><strong>Satuan</strong></td>
				<td class="text-center" colspan="3" style="padding: 3px;"><strong>Qty</strong></td>
				<td class="text-center" rowspan="2" style="padding: 3px;"><strong>Keterangan reject</strong></td>
			</tr>
			<tr>
				<td class="text-center" style="padding: 3px;"><strong>Picklist</strong></td>
				<td class="text-center" style="padding: 3px;"><strong>Reject</strong></td>
				<td class="text-center" style="padding: 3px;"><strong>Ganti</strong></td>
			</tr>
			<?php $no=1; foreach ($jobLineReject as $ln) { ?>
				<tr>
					<td class="text-center" style="padding: 3px;"><?php echo $no++; ?></td>
					<td style="padding: 3px;" colspan="2"><?php echo $ln['component_code']; ?></td>
					<td style="padding: 3px;" colspan="2"><?php echo $ln['component_description']; ?></td>
					<td class="text-center" style="padding: 3px;"><?php echo $ln['uom']; ?></td>
					<td class="text-center" style="padding: 3px;"><?php echo $ln['picklist_quantity']; ?></td>
					<td class="text-center" style="padding: 3px;"><?php echo $ln['return_quantity']; ?></td>
					<td style="padding: 3px;"></td>
					<td style="padding: 3px;"><?php echo $ln['return_information']; ?></td>
				</tr>
			<?php } ?>
		</table>
		<table class="table table-bordered">
			<tr>
				<td style="padding: 3px;" class="text-center" colspan="2">
					<small>Penerima</small>
					<small>(Seksi)</small>
				</td>
				<td style="padding: 3px;" class="text-center">
					<small>Diterima :</small>
					<small>Gudang</small>
				</td>
				<td style="padding: 3px;" class="text-center" colspan="2">
					<small>Mengetahui :</small>
					<small>PPIC</small>
				</td>
				<td style="padding: 3px;" class="text-center" colspan="2">
					<small>Mengetahui :</small>
					<small>QC</small>
				</td>
				<td style="padding: 3px;" class="text-center">
					<small>Mengetahui :</small>
					<small>Kepala Seksi/Spv.</small>
				</td>
				<td style="padding: 3px;" class="text-center" colspan="2">
					<small>Diminta :</small>
				</td>
			</tr>
			<tr>
				<td style="height: 50px;" colspan="2"></td>
				<td style="height: 50px;"></td>
				<td style="height: 50px;" colspan="2"></td>
				<td style="height: 50px;" colspan="2"></td>
				<td style="height: 50px;"></td>
				<td style="height: 50px;" colspan="2"></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>