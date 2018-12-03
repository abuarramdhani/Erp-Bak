<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> <?= strtoupper($Title)?></b></h1>

							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('Warehouse');?>">
									<i class="icon-calendar icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">

					<div class="row">
						<div class="col-lg-12">
							<form action="<?php echo base_url('Warehouse/Transaksi/createLaporan1'); ?>" method="POST">
								<div class="col-lg-12">
									<div class="box box-primary box-solid">
										<div class="box-header with-border">Laporan Usable Out</div>
										<div class="box-body">
											<div class="panel-body">
												<div class="row">
													<div style="margin:12px;" class="form-group">
														<label for="txtComponentCodeHeader" class="control-label col-lg-4">Tanggal Awal</label>
														<div class="col-lg-6">
															<input class="form-control" type="text" name="tanggal_awal" required="" placeholder='Tanggal Awal' id="tanggalReportAwal">
														</div>
													</div>

													<div style="margin:12px;" class="form-group">
														<label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Tanggal Akhir</label>
														<div class="col-lg-6">
															<input class="form-control" type="text" name="tanggal_akhir" required="" placeholder='Tanggal Akhir' id="tanggalReportAkhir">
														</div>
													</div>

													<div style="margin:12px;" class="form-group">
														<label for="txtComponentDescriptionHeader" class="control-label col-lg-4">Kategori</label>
														<div class="col-lg-6">
															<select name="pinjam">
																<option value="PINJAM">PINJAM</option>
																<option value="KEMBALI">KEMBALI</option>
															</select>
														</div>
													</div>

													<div style="margin:12px;" class="form-group">
														<label for="txtComponentDescriptionHeader" class="control-label col-lg-4">No Induk</label>
														<div class="col-lg-6">
															<input class="form-control" placeholder="No Ind"  type="text" name="noind" >
														</div>
													</div>

												</div>

												<div class="col-lg-12">
													<br />
													<br />
													<div class="row">
														<div class="nav-tabs-custom">
															<ul class="nav nav-tabs">
															</ul>
															<div class="tab-content">
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="panel-footer">
												<div class="row text-right">
													<button type="submit" class="btn btn-primary btn-lg btn-rect">Generate</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>