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
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('CateringManagement/Puasa/Pengurangan/Read') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-5">
													<input type="text" class="date form-control cmpuasadaterange" name="txtBulanTransferPuasa" id="txtBulanTransferPuasa" value="<?php echo Date('d F Y') ?>" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">No Induk</label>
												<div class="col-lg-2"style="margin-right: 0px;">
													<select class="select select2" name="txtNoindPenguranganPuasa" id="txtNoindPenguranganPuasa" style="width: 100%" required>
														<option></option>
														<?php foreach ($Pekerja as $val) { ?>
															<option value="<?php echo $val['noind'] ?>" data-kodesie="<?php echo $val['kodesie'] ?>" data-seksi="<?php echo $val['seksi'] ?>" data-nama='<?php echo $val['nama'] ?>'><?php echo $val['noind'] ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="col-lg-3">
													<input type="text" class="form-control" id="txtNamaTransferPuasa" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Kode Seksi</label>
												<div class="col-lg-5">
													<input type="text" class="form-control" id="txtKodesieTransferPuasa" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Nama Seksi</label>
												<div class="col-lg-5">
													<input type="text" class="form-control" id="txtSeksiTransferPuasa" disabled>
												</div>
											</div>
											<!-- <div class="form-group">
												<label class="control-label col-lg-4">Status</label>
												<div class="col-lg-5">
													<div class="col-lg-6">
														<input type="radio" name="radioStatusPuasa" value="1"> Puasa
													</div>
													<div class="col-lg-6">
														<input type="radio" name="radioStatusPuasa" value="0"> Tidak Puasa
													</div>
												</div>
											</div> -->
											<div class="form-group">
												<div class="col-lg-9 text-right">
													<button type="submit" class="btn btn-primary">Submit</button>
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
		</div>
	</div>
</section>