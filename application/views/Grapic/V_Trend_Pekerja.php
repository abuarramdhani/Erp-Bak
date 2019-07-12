<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="col-lg-11">
					<div class="text-right">
						<h1><b>Trend Jumlah Pekerja</b></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11"></div>
						<div class="col-lg-1 "></div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<form method="post" action="<?php echo base_url('Sdm/Grafik/TrendJumlahPekerja'); ?>">
									<div class="panel-body">
										<div class="form-inline">
											<div class="form-group col-md-12">
												<div class="col-md-2">
													<label class="control-label">Pilih Tahun</label>
												</div>
												<div class="col-md-6">
													<select required="" name="select_tahun[]" style="width: 100%" class="form-control" id="sdm_select_tahun" multiple="multipe">
														<option></option>
														<?php for ($i=1953; $i < 2101; $i++) { ?>
														<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group col-md-12" style="margin-top: 20px;">
												<div class="col-md-2">
													<label class="control-label">Hitung Dengan PKL, Magang & TKPW</label>
												</div>
												<div class="col-md-1">
													<input type="checkbox" value="1" name="pkl">
												</div>
											</div>
										</div>
									</div>
									<div class="panel-footer">
										<div class="row">
											<button type="submit" class="btn btn-primary btn-lg" style="float: right;">Proses</button>
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
<script type="text/javascript">
	var proses = 'false';
</script>