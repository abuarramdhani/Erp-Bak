<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?= $Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-xs hidden-md">
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
										<div class="table-responsive">
											<table class="table table-striped table-hover table-bordered">
												<thead class="bg-primary">
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">Cut Off</th>
														<th class="text-center">Periode Penggajian</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														if (isset($cutOff) and !empty($cutOff)) {
															$angka = 1;
															foreach ($cutOff as $key) { 
																$valLink = $this->encrypt->encode($key['rangetanggal']);
																$valLink = str_replace(array('+', '/', '='), array('-', '_', '~'), $valLink);
																?>
																<tr>
																	<td class="text-center"><?php echo $angka; ?></td>
																	<td class="text-center"><?php echo $key['awal']." - ".$key['akhir'] ?></td>
																	<td class="text-center"><?php echo $key['bulan']." ".$key['tahun'] ?></td>
																	<td class="text-center">
																		<a target="_blank" href="<?php echo site_url('HitungHlcm/HitungGaji/printProses/view/'.$valLink); ?>" class="fa fa-file-o fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Read Data'></a>
																		<a target="_blank" href="<?php echo site_url('HitungHlcm/HitungGaji/printProses/xls/'.$valLink); ?>" class="fa fa-file-excel-o fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Export Excel'></a>
																		<a target="_blank" href="<?php echo site_url('HitungHlcm/HitungGaji/printProses/pdf/'.$valLink); ?>" class="fa fa-file-pdf-o fa-2x" data-toggle='tooltip' data-placement='bottom' data-original-title='Export PDF'></a>
																	</td>
																</tr>
															<?php }
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