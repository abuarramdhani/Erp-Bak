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
									<div class="col-lg-12 text-right">
										<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/tambah') ?>" class="btn btn-primary"><span class="fa fa-plus">&nbsp;Tambah</span></a>
									</div>
								</div>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-bordered table-hover" id="tbl-MPR-THR-index">
											<thead class="bg-primary">
												<tr>
													<th>No.</th>
													<th>Tanggal Idul Fitri</th>
													<th>Mengetahui</th>
													<th>Dibuat</th>
													<th>Tanggal Dibuat</th>
													<th>Tanggal Insert</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php if (isset($data) && !empty($data)) {
												$nomor = 1;
												foreach ($data as $dt) {
													?>
													<tr>
														<td><?php echo $nomor; ?></td>
														<td><?php echo $dt['tgl_idul_fitri']; ?></td>
														<td><?php echo $dt['mengetahui'].' - '.$dt['mengetahui_nama']; ?></td>
														<td><?php echo $dt['created_by'].' - '.$dt['created_by_nama']; ?></td>
														<td><?php echo date('d M Y',strtotime($dt['tgl_dibuat'])); ?></td>
														<td><?php echo date('d M Y H:i:s',strtotime($dt['created_timestamp'])); ?></td>
														<td>
															<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/export/'.$dt['id_thr']) ?>" class="btn btn-success"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</a>
															<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/cetak/'.$dt['id_thr']) ?>" class="btn btn-danger"><span class="fa fa-file-pdf-o"></span>&nbsp;PDF</a>
															<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/transfer/'.$dt['id_thr']) ?>" class="btn btn-warning"><span class="fa fa-file"></span>&nbsp;DBF</a>
															<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/lihat/'.$dt['id_thr']) ?>" class="btn btn-info"><span class="fa fa-file-o"></span>&nbsp;Lihat</a>
															<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/hapus/'.$dt['id_thr']) ?>" class="btn btn-danger"><span class="fa fa-trash"></span>&nbsp;Hapus</a>
														</td>
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