<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										Perhitungan Utilitas Mesin
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="Hitung/">
									<i aria-hidden="true" class="fa fa-refresh fa-2x"></i>
								</a>
							</div>
						</div>
					</div>
                </div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3><b><center>SELECT DATA PERHITUNGAN UTILITAS MESIN</center></b></h3>
							</div>
							<div class="box-body">
								<div class="col-md-12 text-right">
									<label style="font-size: 15px"><?php echo date("l, d F Y") ?></label>
								</div>
								<div class="form-group col-lg-12">
									<div class="col-md-4" style="text-align: right;">
										<label >Department Class :</label>
									</div>
									<div class="col-md-4">
										<select id="deptclass" name="deptclass" class="form-control select2 slcDeclas" data-placeholder="Pilih Department Class">
											<option></option>
										</select>
										<input type="hidden" name="username" id="username" value="<?= $user?>">
									</div>
								</div>
								<div class="form-group col-lg-12">
									<div class="col-md-4" style="text-align: right;">
										<label >Plan :</label>
									</div>
									<div class="col-md-4">
										<select id="plan" name="plan" class="form-control select2" data-placeholder="Pilih Plan">
											<option></option>
											<option value="5">Plan 1</option>
											<option value="1">Plan 2</option>
											<option value="4">Plan 3</option>
										</select>
									</div>
								</div>
							<div class="panel-body">
								<div class="col-md-12">
									<center><button class="btn btn-warning btn-lg" id="findPUM" onclick="getPUM(this)" disabled="disabled"><i class="fa fa-search"></i> Find </button></center>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" id="ResultPUM"></div>
				</div>
			</div>
		</div>
	</div>
</section>
