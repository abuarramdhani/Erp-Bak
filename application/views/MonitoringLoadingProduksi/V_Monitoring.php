<style media="screen">
  td{
    padding-bottom: 20px !important;
  }
</style>

<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-right">
							<h3>
								<b>
								 <?php echo date("l, d F Y") ?>
								</b>
							</h3>
						</div>
						<!-- <div class="col-lg-1 "> -->
							<!-- <div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="Hitung/">
									<i aria-hidden="true" class="fa fa-refresh fa-2x"></i>
								</a>
							</div> -->
						<!-- </div> -->
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3><b><center>PERHITUNGAN LOADING PRODUKSI</center></b></h3>
							</div>
							<div class="box-body">


								<div class="row">
									<div class="col-md-2"></div>
                  <div class="col-md-8">
                    <br>
                      <table style="width:100%">
                        <tr>
                          <td style="width:20%"><b>Department Class</b> </td>
                          <td style="width:5%;">:</td>
                          <td style="width:75%">
														<select id="deptclassLP" name="deptclass" class="form-control select2 select-loadingproduksi" data-placeholder="Pilih Department Class">
															<option></option>
															<?php foreach ($dept as $key => $value): ?>
																<option value="<?php echo $value['SEKSI_CODE'] ?>"><?php echo $value['SEKSI'] ?></option>
															<?php endforeach; ?>
														</select>
														<input type="hidden" name="username" id="username" value="<?= $user?>">
                          </td>
                        </tr>
                        <tr>
                          <td><b>Plan</b> </td>
                          <td>:</td>
                          <td>
														<select name="plan" style="width:40%" class="form-control select2" data-placeholder="Pilih Plan">
															<option value="5">Plan 1</option>
															<option value="1">Plan 2</option>
															<option value="4">Plan 3</option>
														</select>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Jam</b> </td>
                          <td>:</td>
                          <td>
														<input type="number" name="jam" class="form-control" placeholder="Masukkan Jam">
                          </td>
                        </tr>
                      </table>
                  </div>
                  <div class="col-md-2"></div>
									<div class="col-md-12">
										<center><button class="btn btn-success mt-4" id="searchLP" onclick="getdataPL()" style="width:20%" disabled="disabled"><i class="fa fa-search"></i> Search </button></center>
									</div>
									<div class="col-md-12">
										<hr>
										<div class="area-table-lp"></div>
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
