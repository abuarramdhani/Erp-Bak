<div class="table-responsive">
	<a target="_blank" href="<?php echo base_url('RekapTIMSPromosiPekerja/Overtime/ExportPdf/pdf_'.$export) ?>" class="btn btn-danger btn-lg fa fa-file-pdf-o fa-2">Export Pdf</a>
	<a target="_blank" href="<?php echo base_url('RekapTIMSPromosiPekerja/Overtime/ExportExcel/xls_'.$export) ?>" class="btn btn-success btn-lg fa fa-file-excel-o fa-2">Export Excel</a>
	<br><br>
	<table class="table table-striped table-bordered table-hover datatableovertime">
		<thead class="bg-primary">
			<tr>
				<th>No</th>
				<th>Periode</th>
				<th>Nama</th>
				<th>Seksi</th>
				<th>Total Jam kerja</th>
				<th>Total Hari kerja</th>
				<th>Overtime</th>
				<th>NET</th>
				<th>Rerata Net/Hari</th>
			</tr>
		</thead>
		<tbody>
		<?php $no=1; foreach ($table as $key) {
			?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php if ($detail == 0) {
					echo $periodeM;}
					else {
						echo ucfirst($key['periode']);
					} ?>
				</td>
				<td><?php echo $key['noind'].' - '.$key['nama']; ?></td>
				<td><?php echo $key['seksi']; ?></td>
				<td><?php echo number_format($key['jam_kerja'],'2',',','.') ?></td>
				<td><?php echo number_format($key['hari_kerja'],'0',',','.') ?></td>
				<td><?php echo number_format($key['overtime'],'2',',','.') ?></td>
				<td><?php echo number_format($key['net'],'2',',','.') ?></td>
				<td><?php echo number_format($key['rerata_net'],'2',',','.') ?></td>
			</tr>
			<?php $no++; } ?>
		</tbody>
	</table>
</div>