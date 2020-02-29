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
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('MasterPekerja/Surat/SuratResign/update/'.$link_id) ?>">
											<div class="form-group">
												<label class="control-label col-lg-4">Pekerja</label>
												<label class="control-label col-lg-4" style="text-align: left"><?php echo $data->noind.' - '.$data->nama ?></label>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Resign</label>
												<div class="col-lg-4">
													<input type="text" name="SuratResignTanggalResign" class="form-control SuratResignTanggalResign" placeholder="Tanggal Resign" autocomplete="off" value="<?php echo date("Y-m-d",strtotime($data->tgl_resign)) ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Sebab Resign</label>
												<div class="col-lg-4">
													<input type="text" name="SuratResignSebabResign" class="form-control SuratResignSebabResign" placeholder="Sebab Resign" autocomplete="off" value="<?php echo $data->sebab ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Tanggal Surat Diterima HubKer</label>
												<div class="col-lg-4">
													<input type="text" name="SuratResignDiterimaHubker" class="form-control SuratResignDiterimaHubker" placeholder="Tanggal Surat Diterima Hubker" autocomplete="off" value="<?php echo date("Y-m-d",strtotime($data->tgl_diterima)) ?>">
												</div>
											</div>
											<div class="form-group">												
												<div class="col-lg-8 text-right">
													<button class="btn btn-primary" type="submit">Simpan</button>
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