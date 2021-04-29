<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><?=$Title ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<div class="row">
									<div class="col-lg-12">
										<a target="_blank" href="<?php echo base_url('MasterPresensi/ReffGaji/THR/export/'.$id_thr) ?>" class="btn btn-success"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</a>
										<a target="_blank" href="<?php echo base_url('MasterPresensi/ReffGaji/THR/cetak/'.$id_thr) ?>" class="btn btn-danger"><span class="fa fa-file-pdf-o"></span>&nbsp;PDF</a>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" id="tbl-MPR-THR-lihat">
											<thead class="bg-primary">
												<tr>
													<th style="text-align: center;vertical-align: middle;">No.</th>
													<th style="text-align: center;vertical-align: middle;">No. Induk</th>
													<th style="text-align: center;vertical-align: middle;">Nama</th>
													<th style="text-align: center;vertical-align: middle;">Seksi</th>
													<th style="text-align: center;vertical-align: middle;">Asal OS</th>
													<th style="text-align: center;vertical-align: middle;">Diangkat</th>
													<th style="text-align: center;vertical-align: middle;">Masa Kerja</th>
													<th style="text-align: center;vertical-align: middle;">Bulan THR</th>
													<th style="text-align: center;vertical-align: middle;">Proporsi</th>
												</tr>
											</thead>
											<tbody>
											<?php if (isset($data) && !empty($data)) {
												$nomor = 1;
												foreach ($data as $dt) {
													?>
													<tr>
														<td style="text-align: center;"><?php echo $nomor; ?></td>
														<td style="text-align: center;"><?php echo $dt['noind']; ?></td>
														<td><?php echo $dt['nama']; ?></td>
														<td><?php echo $dt['seksi']; ?></td>
														<td><?php echo trim($dt['asal_outsourcing']); ?></td>
														<td style="text-align: center;"><?php echo date('d M Y',strtotime($dt['diangkat'])); ?></td>
														<td><?php echo $dt['masa_kerja']; ?></td>
														<td style="text-align: center;"><?php echo $dt['bulan_thr']; ?></td>
														<td style="text-align: center;"><?php echo $dt['proporsi']; ?></td>
													</tr>
													<?php
													$nomor++;
												}
											} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>