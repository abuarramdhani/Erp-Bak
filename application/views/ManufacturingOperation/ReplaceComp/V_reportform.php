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
	foreach ($rejectData as $head) {
	?>
		<table class="table table-bordered" style="border-bottom: 0px;">
			<tr>
				<td rowspan="3" style="padding: 1px; text-align: center; vertical-align: middle;">
					<img src="<?php echo base_url('assets/img/logo.png') ?>" class="img" style="max-width: 50px">
				</td>
				<td rowspan="3" style="padding: 3px; border-right: 0px;">
					<h3>CV. KARYA HIDUP SENTOSA</h3>
					Jl. Magelang No. 144, Yogyakarta
					<h2>PERMINTAAN PENGGANTIAN</h2>
					<h2>KOMPONEN & MATERIAL PICKLIST JOB/BATCH</h2>
					<h2>(REJECT MATERIAL)</h2>
				</td>
				<td rowspan="3" style="padding: 3px; text-align: center; vertical-align: middle; border-left: 0px;">
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
				<td width="250px" rowspan="2" colspan="4" style="padding: 3px; border-bottom: 0px;">
					<p>Produk / Assy Description :</p>
					<strong>
						<p><?php echo $head['SEGMENT1']; ?></p>
						<p><?php echo $head['DESCRIPTION']; ?></p>
					</strong>
				</td>
			</tr>
			<tr>
				<td style="padding: 3px; border-bottom: 0px; border-right: 0px;">Gudang</td>
				<td colspan="2" style="padding: 3px; border-bottom: 0px; border-left: 0px;">: <strong><?php echo $subinv; ?></strong></td>
			</tr>
		</table>
		<table class="table table-bordered">
			<tr>
				<td width="25px" class="text-center" rowspan="2" style="padding: 3px;">
					<strong>No.</strong>
				</td>
				<td width="110px" class="text-center" rowspan="2" style="padding: 3px;">
					<strong>Kode</strong>
				</td>
				<td width="228px" class="text-center" rowspan="2" style="padding: 3px;">
					<strong>Nama Barang</strong>
				</td>
				<td width="30px" class="text-center" rowspan="2" style="padding: 3px;">
					<strong>Uom</strong>
				</td>
				<td class="text-center" colspan="3" style="padding: 3px;">
					<strong>Qty</strong>
				</td>
				<td class="text-center" rowspan="2" style="padding: 3px;">
					<strong>Keterangan reject</strong>
				</td>
			</tr>
			<tr>
				<td width="35px" class="text-center" style="padding: 3px;"><strong>Picklist</strong></td>
				<td width="35px" class="text-center" style="padding: 3px;"><strong>Reject</strong></td>
				<td width="35px" class="text-center" style="padding: 3px;"><strong>Ganti</strong></td>
			</tr>
			<?php $no=1; foreach ($head['DATA_BODY'] as $ln) { ?>
				<tr>
					<td class="text-center" style="padding: 3px; vertical-align: top;">
						<?php echo $no++; ?>
					</td>
					<td style="padding: 3px; vertical-align: top;">
						<?php echo $ln['component_code']; ?>
					</td>
					<td style="padding: 3px; vertical-align: top;">
						<?php echo $ln['component_description']; ?>
					</td>
					<td class="text-center" style="padding: 3px; vertical-align: top;">
						<?php echo $ln['uom']; ?>
					</td>
					<td class="text-center" style="padding: 3px; vertical-align: top;">
						<?php echo $ln['picklist_quantity']; ?>
					</td>
					<td class="text-center" style="padding: 3px; vertical-align: top;">
						<?php echo $ln['return_quantity']; ?>
					</td>
					<td style="padding: 3px;"></td>
					<td style="padding: 3px; vertical-align: top;">
						<?php echo $ln['return_information']; ?>
					</td>
				</tr>
			<?php } ?>
		</table>
		<table class="table table-bordered" style="border-top: 0px;">
			<tr>
				<td style="padding: 3px; border-top: 0px; border-bottom: 0px;" class="text-center">
					Penerima<br>
					(Seksi)
				</td>
				<td style="padding: 3px; border-top: 0px; border-bottom: 0px;" class="text-center">
					Diterima :<br>
					Gudang
				</td>
				<td style="padding: 3px; border-top: 0px; border-bottom: 0px;" class="text-center">
					Mengetahui :<br>
					PPIC
				</td>
				<td style="padding: 3px; border-top: 0px; border-bottom: 0px;" class="text-center">
					Mengetahui :<br>
					QC
				</td>
				<td style="padding: 3px; border-top: 0px; border-bottom: 0px;" class="text-center">
					Mengetahui :<br>
					Kepala Seksi/Spv.
				</td>
				<td style="padding: 3px; border-top: 0px; border-bottom: 0px; vertical-align: top;" class="text-center">
					Diminta :
				</td>
			</tr>
			<tr>
				<td style="height: 60px;"></td>
				<td style="height: 60px;"></td>
				<td style="height: 60px;"></td>
				<td style="height: 60px;"></td>
				<td style="height: 60px;"></td>
				<td style="height: 60px;"></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>