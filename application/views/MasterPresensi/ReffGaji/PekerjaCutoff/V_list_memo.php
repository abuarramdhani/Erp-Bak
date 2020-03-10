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
						<div class="box box-solid box-primary">
							<div class="box-header with-border">
								<a href="<?php echo base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/memo') ?>" class="btn btn-success"><span class="fa fa-plus"></span>&nbsp;New Memo</a>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<table class="dataTable-pekerjaCutoff table table-bordered table-striped table-hover table-hovered">
											<thead class="bg-primary">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Periode</th>
													<th class="text-center">No. Surat</th>
													<th class="text-center">Pembuat</th>
													<th class="text-center">Waktu Buat</th>
													<th class="text-center">Staff</th>
													<th class="text-center">Non-Staff</th>
													<th class="text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													if (isset($data) and !empty($data)) {
														$nomor = 1;
														foreach ($data as $key) { 
															$id_encrypted = $this->encrypt->encode($key['id_memo']);
															$id_encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_encrypted)
															?>
															<tr>
																<td style="text-align: center;vertical-align: middle;"><?=$nomor; ?></td>
																<td style="text-align: center;vertical-align: middle;"><?php echo strftime("%B %Y",strtotime($key['periode'])) ?></td>
																<td style="text-align: center;vertical-align: middle;"><?php echo $key['nomor_surat'] ?></td>
																<td style="vertical-align: middle;"><?php echo $key['dibuat'] ?></td>
																<td style="vertical-align: middle;"><?php echo strftime("tanggal : %d %B %Y <br> pukul : %H:%M:%S ",strtotime($key['created_timestamp'])) ?></td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php if ($key['file_staff'] !== "-") { ?>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_staff'].'.dbf') ?>" class="btn btn-info">DBF</a>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_staff'].'.pdf') ?>" class="btn btn-danger">PDF</a>
																	<?php }else{
																		echo " - ";
																	} ?>
																</td>
																<td style="text-align: center;vertical-align: middle;">
																	<?php if ($key['file_nonstaff'] !== "-") { ?>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_nonstaff'].'.dbf') ?>" class="btn btn-info">DBF</a>
																		<a href="<?php echo site_url('assets/upload/TransferReffGaji/'.$key['file_nonstaff'].'.pdf') ?>" class="btn btn-danger">PDF</a>
																	<?php }else{
																		echo " - ";
																	} ?>
																</td>
																<td>
																	<a href="<?php echo site_url('MasterPresensi/ReffGaji/PekerjaCutoffMemo/PekerjaCutoffMemoDelete').'/'.$id_encrypted ?>"><span class="fa fa-trash" style="color: red" title="Hapus Data" onclick="return confirm('Apakah Anda yakin Ingin Menghapus Memo Ini ?')"></span></a>
																</td>
															</tr>
															<?php 
															$nomor++;
														}
													}
												?>
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