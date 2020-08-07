<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h1><b><?=$Title ?></b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Daftar Mutasi Pekerja dari tanggal <?php echo strftime("%d %B %Y",strtotime($tanggal)) ?>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}

											.dataTables_info {
												float: left
											}
										</style>
										<table class="table table-striped table-hover table-bordered" id="tbl-CM-MutasiPekerja-Table">
											<thead>
												<tr>
													<th class="bg-primary">No.</th>
													<th class="bg-primary">No. Induk</th>
													<th class="bg-primary">Nama</th>
													<th class="bg-primary">Seksi Lama</th>
													<th class="bg-primary">Seksi Baru</th>
													<th class="bg-primary">Tanggal Berlaku</th>
													<th class="bg-primary">Tempat Makan Lama</th>
													<th class="bg-primary">Tempat Makan Saat ini</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($data) && !empty($data)) {
													$nomor = 1;
													foreach ($data as $key => $value) {
														?>
														<tr>
															<td style="text-align: center;"><?php echo $nomor; ?></td>
															<td style="text-align: center;"><?php echo $value['noind']; ?></td>
															<td><?php echo $value['nama']; ?></td>
															<td><?php echo $value['seksi_lama']." <b>(".$value['lokasilm'].")</b>"; ?></td>
															<td><?php echo $value['seksi_baru']." <b>(".$value['lokasibr'].")</b>"; ?></td>
															<td><?php echo $value['tglberlaku']; ?></td>
															<td><?php echo $value['tempat_makan1lm']; ?></td>
															<td><?php echo $value['tempat_makan']; ?></td>
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