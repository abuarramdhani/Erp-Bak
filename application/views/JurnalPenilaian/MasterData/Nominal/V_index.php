<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?php echo $Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-xs hidden-sm hidden-md">
								<a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="">
											<div class="form-group">
												<label class="control-label col-lg-2">Gol. Kerja</label>
												<div class="col-lg-2">
													<select class="select select2" data-placeholder="Gol. Kerja" name="txtgolKerja" style="width: 100%" required>
														<option></option>
														<?php 
															if (isset($gk) and !empty($gk)) {
																foreach ($gk as $key) {
																	echo '<option>'.$key['gol_kerja'].'</option>';
																}
															}
														 ?>
													</select>
												</div>
												<label class="control-label col-lg-2">Gol. Nilai</label>
												<div class="col-lg-2">
													<select class="select select2" data-placeholder="Gol. Nilai" name="txtgolNilai" style="width: 100%">
														<option></option>
														<?php 
															if (isset($gn) and !empty($gn)) {
																foreach ($gn as $key) {
																	echo '<option>'.$key['gol_nilai'].'</option>';
																}
															}
														 ?>
													</select>
												</div>
												<button type="submit" class="btn btn-primary">Proses</button>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="table-responsive">
											<table class="table table-striped table-hover table-bordered text-left">
												<thead class="bg-primary">
													<tr>
														<th>No</th>
														<th>Golongan Kerja</th>
														<th>Golongan Nilai</th>
														<th>Pengurang</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 	
														if (isset($nominal) and !empty($nominal)) {
															$no = 1;
															foreach ($nominal as $key) { ?>
																<tr>
																	<td><?php echo $no; ?></td>
																	<td><?php echo $key['gol_kerja'] ?></td>
																	<td><?php echo $key['gol_nilai'] ?></td>
																	<td><?php echo $key['nominal_kenaikan'] ?></td>
																	<td class="text-center">
																		<a href="<?php echo site_url('PenilaianKinerja/MasterNominal/Edit/'.$key['id_kenaikan']) ?>" class="fa fa-pencil-square-o fa-2x"></a>
																		<a href="<?php echo site_url('PenilaianKinerja/MasterNominal/Delete/'.$key['id_kenaikan']) ?>" class="fa fa-trash fa-2x" style="color: red" onclick="return confirm('Apakah Anda Yankin ingin menghapus data ini ?')"></a>
																	</td>
																</tr>
															<?php $no++; }
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
	</div>
</section>