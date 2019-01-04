<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11 text-right">
							<h1><b><?=$Title ?></b></h1>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-sm hidden-xs hidden-md">
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
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="row">
									<div class="col-lg-12">
										<form class="form-horizontal" method="POST" action="<?php echo site_url('WasteManagement/RekapLimbah/Excel') ?>" target="_blank">
											<div class="form-group">
												<label class="control-label col-lg-4">Periode</label>
												<div class="col-lg-4">
													<input type="text" name="txtPeriodeRekap" id="txtPeriodeInfo" class="date form-control">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Jenis Limbah<sup style="color: red">*</sup></label>
												<div class="col-lg-4">
													<select class="select select2" name="slcJenisLimbahRekap[]" multiple="multiple" style="width: 100%" data-placeholder="Jenis Limbah">
														<option></option>
														<?php foreach ($limbah as $key) {
															echo "<option value='".$key['id_jenis_limbah']."'>".$key['kode_limbah']." - ".$key['jenis_limbah']."</option>";
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-lg-4">Seksi Asal Limbah<sup style="color: red">*</sup></label>
												<div class="col-lg-4">
													<select class="select select2" name="slcSeksiAsalLimbahRekap[]" multiple="multiple" style="width: 100%" data-placeholder="Seksi Asal Limbah">
														<option></option>
														<?php foreach ($seksi as $key) {
															echo "<option value='".$key['section_code']."'>".$key['section_name']."</option>";
														} ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-lg-4 col-lg-offset-4" style="font-size: 9pt"><sup style="color: red">*</sup><i>: kosongi untuk menampilkan semua limbah / seksi asal limbah</i></div>
											</div>
											<div class="form-group">
												<div class="col-lg-8 text-right">
													<button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
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