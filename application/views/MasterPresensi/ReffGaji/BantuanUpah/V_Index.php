<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<h3><b><?=$Title ?></b></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12 text-right">
										<a class="btn btn-success" href="<?php echo base_url('MasterPresensi/ReffGaji/BantuanUpah/Proses') ?>">
											Proses Baru
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<style type="text/css">
											.dt-buttons {
												float: left;
											}
											.dataTables_filter {
												float: right;
											}
										</style>
										<table class="table table-striped table-bordered table-hover" id="tbl-MPR-BantuanUpah-Index">
											<thead>
												<tr>
													<th class="bg-primary text-center">No</th>
													<th class="bg-primary text-center">Tanggal Proses</th>
													<th class="bg-primary text-center">PIC</th>
													<th class="bg-primary text-center">Periode</th>
													<th class="bg-primary text-center">Status Hubungan Kerja</th>
													<th class="bg-primary text-center">Hasil Proses</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if (isset($record) && !empty($record)) {
													$nomor = 1;
													foreach ($record as $rec) {
														$id_encrypted = $this->encrypt->encode($rec['id']);
														$id_encrypted = str_replace(array('+', '/', '='), array('-', '_', '~'), $id_encrypted);
														?>
														<tr>
															<td class="text-center"><?php echo $nomor ?></td>
															<td class="text-center"><?php echo strftime("%d %B %Y <br> %X",strtotime($rec['created_at']))  ?></td>
															<td><?php echo $rec['created_by']." - ".$rec['nama'] ?></td>
															<td><?php echo strftime("%d %B %Y",strtotime($rec['periode_awal']))." s/d ".strftime("%d %B %Y",strtotime($rec['periode_akhir'])) ?></td>
															<td><?php echo $rec['status_hubungan_kerja'] ?></td>
															<td class="text-center">
																<a href="<?php echo base_url('MasterPresensi/ReffGaji/BantuanUpah/Detail/'.$id_encrypted) ?>" class="btn btn-info">Detail</a>
																<a target="_blank" href="<?php echo base_url('MasterPresensi/ReffGaji/BantuanUpah/Pdf/'.$id_encrypted) ?>" class="btn btn-danger">Pdf</a>
																<a target="_blank" href="<?php echo base_url('MasterPresensi/ReffGaji/BantuanUpah/Excel/'.$id_encrypted) ?>" class="btn btn-success">Excel</a>
																<button type="button" data-id="<?php echo $id_encrypted ?>" class="btn btn-danger btn-MPR-BantuanUpah-Hapus">Hapus</button>
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