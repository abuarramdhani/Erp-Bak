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
								<a href="" class="btn btn-default btn-lg">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header">
								
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-3 text-center">
										<a href="<?php echo base_url('CateringManagement/Puasa/Setup/Download') ?>" class="btn btn-success">
											<span class="fa fa-file-excel-o"></span>
											<span class="fa fa-download"></span>
											&nbsp;Download Excel
										</a>
									</div>
									<div class="col-lg-3 text-center">
										<a href="<?php echo base_url('CateringManagement/Puasa/Setup/Upload') ?>" class="btn btn-success">
											<span class="fa fa-file-excel-o"></span>
											<span class="fa fa-upload"></span>
											&nbsp;Upload Excel
										</a>
									</div>
									<div class="col-lg-3 text-center">
										<a href="<?php echo base_url('CateringManagement/Puasa/Transfer') ?>" class="btn btn-primary">
											<span class="fa fa-gear"></span>
											&nbsp;proses Puasa
										</a>
									</div>
									<div class="col-lg-3 text-center">
										<a href="<?php echo base_url('CateringManagement/Puasa/Pengurangan') ?>" class="btn btn-primary">
											<span class="fa fa-gear"></span>
											&nbsp;Lihat hasil Proses Puasa
										</a>
									</div>
								</div>
								<?php if(isset($ket) && isset($noind)){ ?>
								<div class="row">
									<div class="col-lg-12 text-center">
										<h1 style="color: green">Status puasa <?php echo $noind ?> Berhasil Diupdate</h1>
									</div>
								</div>
								<?php } ?>
								<div class="row">
									<div class="col-lg-12 text-center">
										<h3>Muslim Ter Setting Tidak Puasa</h3>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-hover table-bordered" id="tblMuslimTidakPuasa">
											<thead class="bg-warning">
												<tr>
													<th>No</th>
													<th>No. Induk</th>
													<th>Nama</th>
													<th>Seksi</th>
													<th>Unit</th>
													<th>Bidang</th>
													<th>Departemen</th>
													<th>Agama</th>
													<th>Status Puasa</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($muslim) && !empty($muslim)) {
													$nomor = 1;
													foreach ($muslim as $dt) {
														?>
														<tr>
															<td><?php echo $nomor; ?></td>
															<td><?php echo $dt['noind']; ?></td>
															<td><?php echo $dt['nama']; ?></td>
															<td><?php echo $dt['seksi']; ?></td>
															<td><?php echo $dt['unit']; ?></td>
															<td><?php echo $dt['bidang']; ?></td>
															<td><?php echo $dt['dept']; ?></td>
															<td><?php echo $dt['agama']; ?></td>
															<td><?php echo $dt['puasa']; ?></td>
															<td>
																<a href="<?php echo base_url('CateringManagement/Puasa/Setup/Puasa?noind='.$dt['noind']) ?>" class="btn btn-primary">Set Puasa</a>
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
								<div class="row">
									<div class="col-lg-12 text-center">
										<h3>Non Muslim Ter Setting Puasa</h3>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table class="table table-striped table-hover table-bordered" id="tblNonMuslimPuasa">
											<thead class="bg-info">
												<tr>
													<th>No</th>
													<th>No. Induk</th>
													<th>Nama</th>
													<th>Seksi</th>
													<th>Unit</th>
													<th>Bidang</th>
													<th>Departemen</th>
													<th>Agama</th>
													<th>Status Puasa</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($nonmuslim) && !empty($nonmuslim)) {
													$nomor = 1;
													foreach ($nonmuslim as $dt) {
														?>
														<tr>
															<td><?php echo $nomor; ?></td>
															<td><?php echo $dt['noind']; ?></td>
															<td><?php echo $dt['nama']; ?></td>
															<td><?php echo $dt['seksi']; ?></td>
															<td><?php echo $dt['unit']; ?></td>
															<td><?php echo $dt['bidang']; ?></td>
															<td><?php echo $dt['dept']; ?></td>
															<td><?php echo $dt['agama']; ?></td>
															<td><?php echo $dt['puasa']; ?></td>
															<td>
																<a href="<?php echo base_url('CateringManagement/Puasa/Setup/TidakPuasa?noind='.$dt['noind']) ?>" class="btn btn-danger">Set Tidak Puasa</a>
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