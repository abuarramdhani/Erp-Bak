<section id="content">
	<div class="content">
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="box box-primary box-solid">
	        <div class="box-header with-border">
	          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"> </i> Monitoring Transaksi BPPCT</h4>
	        </div>
	        <div class="box-body" style="background:#f0f0f0 !important;">
	              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:10px;">
									<div class="row" style="margin-top:10px">
										<div class="col-md-12">
											<input type="hidden" name="" id="kondisi-tct" value="monitoring transaksi bppct">
											<div class="alert alert-info alert-dismissible fade in" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close" name="button">
													<span aria-hidden="true">
														<i class="fa fa-close"></i>
													</span>
												</button>
												<strong>Perhatian :</strong>
												<p style="padding-top:5px;padding-left:5px;">* Klik pada kolom tanggal untuk memilih tanggal</p>
												<p style="padding-left:5px;">* Klik 2 kali pada tanggal yang sama jika hanya memilih 1 tanggal</p>
												<p style="padding-left:5px;">* Kosongkan kolom No BPPBGT dan Transaction Type jika hanya mencari data berdasarkan rentang tanggal</p>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-9"></div>
										<div class="col-md-3">
											<b><span id="tanggal_server" style="font-size:16px">
											<?php //echo date("l, d-F-Y"); ?></span></b>
											<b><span id="jam_aktif" style="font-size:16px"><?php
											date_default_timezone_set("Asia/Jakarta") . '<br>';
											echo date("H:i:s");?></span></b>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
													<label for="">Select Date Range</label>
													<input type="text" class="form-control tanggal-TCT" style="width:100%" placeholder="Select Current Date" required="">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">No BPPBGT</label>
												<select class="form-control select2-tct" id="no_bppbgt" style="width:100%">
													<option value=""></option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<label for="">Seksi</label>
											<div class="form-group">
												<input type="text" class="form-control" id="seksi-tct" style="width:100%" readonly>
												<!-- <select class="form-control select2" id="seksi" style="width:100%" data-placeholder="Seksi">
													<option value=""></option>
													<?php //foreach ($get_seksi as $key => $gs): ?>
														<option value="<?php //echo $gs['SEKSI_PENGEBON'] ?>"><?php //echo $gs['SEKSI_PENGEBON'] ?></option>
													<?php //endforeach; ?>
												</select> -->
											</div>
									</div>
								</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Mesin</span></label>
												<input type="text" class="form-control" id="mesin-tct" style="width:100%" readonly>
												<!-- <select class="form-control select2" id="mesin" style="width:100%" data-placeholder="Mesin">
													<option value=""></option>
													<?php //foreach ($get_mesin as $key => $gm): ?>
														<option value="<?php //echo $gm['NO_MESIN'] ?>"><?php //echo $gm['NO_MESIN'] ?></option>
													<?php //endforeach; ?>
												</select> -->
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Transaction Type</label>
												<select class="form-control select2" id="trans_type" style="width:100%" data-placeholder="Transaction Type">
													<option value=""></option>
													<?php foreach ($get_transact_type as $key => $gtt): ?>
														<option value="<?php echo $gtt['TRANSACTION_TYPE_NAME'] ?>"><?php echo $gtt['TRANSACTION_TYPE_NAME'] ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											<label for="" style="color:transparent">Cari</label>
											<button type="button" title="Search Data" onclick="filter_tct()" style="font-size:15px" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"><strong> Search</strong></i></button>
										</div>
										<div class="col-md-10"></div>
									</div>
									<div class="row">
										<div class="col-md-12" style="margin-top:15px">
											<div class="area_tct">

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
