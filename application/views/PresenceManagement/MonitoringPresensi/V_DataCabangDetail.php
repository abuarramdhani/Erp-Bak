<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?=$Title ?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a href="<?php echo site_url('PresenceManagement/CekData') ?>" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-12">
												<form class="form-horizontal">
													<div class="form-group">
														<label class="control-label col-lg-2">Nama Cabang :</label>
														<div class="col-lg-4">
															<input type="text" class="form-control" value="<?php foreach($Cabang as $key){
																echo $key['id_']." - ".$key['lokasi_kerja'];
															} ?>" disabled>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="table-responsive">
													<table class="datatable table table-bordered table-hover table-striped text-left" id="PresenceManagement-cekdata">
														<thead class="bg-primary">
															<tr>
																<th>No</th>
																<th>Noind</th>
																<th>Nama</th>
																<th>Noind Baru</th>
																<th>Kode Finger</th>
																<th>Password</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$angka = 1;
																if (isset($hasilbanding)) {
																	foreach ($hasilbanding as $key) { ?>
																			<tr>
																				<td><?php echo $angka ?></td>
																				<td><?php echo $key['noind'] ?></td>
																				<td><?php echo $key['nama'] ?></td>
																				<td><?php echo $key['noind_baru'] ?></td>
																				<td><?php echo $key['finger'] ?></td>
																				<td><?php echo $key['password'] ?></td>
																			</tr>
																	<?php $angka++;
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
			</div>
		</div>
	</div>
</section>