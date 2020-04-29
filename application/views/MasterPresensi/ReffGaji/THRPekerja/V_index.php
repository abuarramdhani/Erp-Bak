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
													<th>Jenis</th>
													<th>Mengetahui</th>
													<th>Dibuat</th>
													<th>Tanggal Dibuat</th>
													<th>Tanggal Insert</th>
													<th style="width: 200px;">Action</th>
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
														<td><?php echo $dt['jenis'] == 1 ? 'Reguler' : ($dt['jenis'] == 2 ? 'SP 3 (H, J, K, P, T)' : ($dt['jenis'] == 3 ? 'A & B Keluar Ramadhan' : 'Tidak Diketahui')); ?></td>
														<td><?php echo $dt['mengetahui'].' - '.$dt['mengetahui_nama']; ?></td>
														<td><?php echo $dt['created_by'].' - '.$dt['created_by_nama']; ?></td>
														<td><?php echo date('d M Y',strtotime($dt['tgl_dibuat'])); ?></td>
														<td><?php echo date('d M Y H:i:s',strtotime($dt['created_timestamp'])); ?></td>
														<td>
															<div class="row" style="margin-bottom: 10px;">
																<div class="col-lg-12">
																	<form target="_blank" class="form-horizontal" method="POST" action="<?php echo base_url('MasterPresensi/ReffGaji/THR/export/'.$dt['id_thr']) ?>">
																		<div class="form-group" style="width: 100%">
																			<div class="col-lg-8">
																				<select class="select2" name="slcKodeIndukE" style="width: 100%">
																					<option></option>
																					<option>A</option>
																					<option>B</option>
																					<option>H</option>
																					<option>J</option>
																					<option>K</option>
																					<option>P</option>
																					<option>T</option>
																				</select>
																			</div>
																			<div class="col-lg-4">
																				<button class="btn btn-success"><span class="fa fa-file-excel-o"></span>&nbsp;XLS</button>
																			</div>
																		</div>
																	</form>
																</div>
															</div>
															<div class="row" style="margin-bottom: 10px;">
																<div class="col-lg-12">
																	<form target="_blank" class="form-horizontal" method="POST" action="<?php echo base_url('MasterPresensi/ReffGaji/THR/cetak/'.$dt['id_thr']) ?>">
																		<div class="form-group" style="width: 100%">
																			<div class="col-lg-8">
																				<select class="select2" name="slcKodeIndukC" style="width: 100%">
																					<option></option>
																					<option>A</option>
																					<option>B</option>
																					<option>H</option>
																					<option>J</option>
																					<option>K</option>
																					<option>P</option>
																					<option>T</option>
																				</select>
																			</div>
																			<div class="col-lg-4">
																				<button class="btn btn-danger"><span class="fa fa-file-pdf-o"></span>&nbsp;PDF</button>
																			</div>
																		</div>
																	</form>
																</div>
															</div>
															<div class="row" style="margin-bottom: 10px;">
																<div class="col-lg-12">
																	<form target="_blank" class="form-horizontal" method="POST" action="<?php echo base_url('MasterPresensi/ReffGaji/THR/transfer/'.$dt['id_thr']) ?>">
																		<div class="form-group" style="width: 100%">
																			<div class="col-lg-8">
																				<select class="select2" name="slcKodeIndukT" style="width: 100%">
																					<option></option>
																					<option>A</option>
																					<option>B</option>
																					<option>H</option>
																					<option>J</option>
																					<option>K</option>
																					<option>P</option>
																					<option>T</option>
																				</select>
																			</div>
																			<div class="col-lg-4">
																				<button class="btn btn-warning"><span class="fa fa-file"></span>&nbsp;DBF</button>
																			</div>
																		</div>
																	</form>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-6 text-right">
																	<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/lihat/'.$dt['id_thr']) ?>" class="btn btn-info"><span class="fa fa-file-o"></span>&nbsp;Lihat</a>
																</div>
																<div class="col-lg-6 text-left">
																	<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/hapus/'.$dt['id_thr']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin ingin MENGHAPUS data ini ?')"><span class="fa fa-trash"></span>&nbsp;Hapus</a>
																</div>
															</div>
															<!-- 
																<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/export/'.$dt['id_thr']) ?>" class="btn btn-success"><span class="fa fa-file-excel-o"></span>&nbsp;Excel</a>
																<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/cetak/'.$dt['id_thr']) ?>" class="btn btn-danger"><span class="fa fa-file-pdf-o"></span>&nbsp;PDF</a>
																<a href="<?php echo base_url('MasterPresensi/ReffGaji/THR/transfer/'.$dt['id_thr']) ?>" class="btn btn-warning"><span class="fa fa-file"></span>&nbsp;DBF</a> 
															-->
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