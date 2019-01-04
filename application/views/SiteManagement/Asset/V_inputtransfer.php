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
								<a href="<?php echo site_url('SiteManagement/TransferAsset') ?>" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header text-right"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="post" action="<?php echo site_url('SiteManagement/TransferAsset/InputTransfer') ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Tag Number</label>
												<div class="col-lg-4">
													<select class="tagTransfer" name="txtIdTagNumber" style="width: 100%"></select>
													<input type="hidden" name="txtTagNumberTransferAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">No. Blanko Assignment</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="No. Blanko Diterima" name="txtNoBlankoTransferAsset" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Nama Barang</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Nama Barang" name="txtNamaBarangTransferAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi Lama</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Seksi Lama" name="txtSeksiLamaTransferAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi Baru</label>
												<div class="col-lg-4">
													<select class="seksiTransfer" name="txtSeksiBaru" style="width: 100%"></select>
													<input type="hidden" name="txtSeksiBaruTransferAsset">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Requester Baru</label>
												<div class="col-lg-4">
													<select class="requesterBaru" name="txtRequesterBaru" style="width: 100%"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">tanggal Diterima</label>
												<div class="col-lg-4">
													<input type="text" class="form-control" placeholder="Tanggal Diterima" id="txtTanggalTransferDiterima" name="txtTanggalDiterimaTransferAsset">
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<a href="javascript:history.back(1)" class="btn btn-danger">Batal</a>
													<button class="btn btn-success">Simpan</button>
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