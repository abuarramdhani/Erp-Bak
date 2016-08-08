<section class="content">
	<div class="inner" >
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<h4 class="pull-left">Rekap TIMS Kebutuhan Promosi Pekerja</h4>
		</div>
		<div class="box-body">
			<a class="btn btn-default pull-right" href="<?php echo base_url('RekapTIMSPromosiPekerja/#')?>">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EXPORT EXCEL
			</a>
				<table style="max-width: 90%" id="monthRekap" class="table table-striped table-bordered table-responsive table-hover">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<tr>
							<td rowspan="2" style="width:5%; text-align:center;">NO</td>
							<td rowspan="2" style="text-align:center;">NIK</td>
							<td rowspan="2" style="text-align:center;">NAMA</td>
							<td colspan="6" style="text-align:center;">REKAP</td>
						</tr>
						<tr>
							<td>T</td>
							<td>I</td>
							<td>M</td>
							<td>S</td>
							<td>IP</td>
							<td>SP</td>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach ($rekap as $rekap_data) { ?>
							<tr>
								<td style="text-align:center;"><?php echo $no++; ?></td>
								<td style="text-align:center;">
									<a href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $rekap_data['NIK']; ?>">
										<?php echo $rekap_data['noINd']; ?>
									</a>
								</td>
								<td>
									<a href="<?php echo base_url()?>RekapTIMSPromosiPekerja/RekapTIMS/employee/<?php echo $rekap_data['NIK']; ?>">
										<?php echo $rekap_data['nama']; ?>
									</a>
								</td>
								<td style="text-align:center;"><?php echo $rekap_data['FrekT']; ?></td>
								<td style="text-align:center;"><?php echo $rekap_data['FrekTs']; ?></td>
								<td style="text-align:center;"><?php echo $rekap_data['FrekIs']; ?></td>
								<td style="text-align:center;"><?php echo $rekap_data['FrekMs']; ?></td>
								<td style="text-align:center;"><?php echo $rekap_data['FrekSK']; ?></td>
								<td style="text-align:center;"><?php echo $rekap_data['FrekSKs']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>