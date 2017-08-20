<section class="content-header">
	<h1>
		PARAMETER KIRIM KOMPONEN
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">	
			<div class="box box-primary">
				<div class="table-responsive">
					<fieldset class="row2">
						<div class="box-body with-border">
							<form id="filter-rekap" method="post" action="<?php echo base_url($action)?>">
								<div class="form-group">
									<div class="row" style="margin: 10px ">
										<div class="col-md-2">
											<label class="control-label">Tanggal</label>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<div class="input-group">
													<input type="text" name="txtTanggal" id="txtTanggal" class="form-control" value="<?php echo date('d F Y') ?>" readonly></input>
												</div>
											</div>
										</div>
									</div>								
									<div class="row" style="margin: 10px ">
										<div class="col-md-2">
											<label class="control-label">SubInventory</label>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														From
													</div>
												<select name="txsAsalKomp" id="txsAsalKomp" class="form-control select2-KompSubInventory has-success">
													<option value=""></option>
												</select>
												</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														To
													</div>
												<select name="txsTujuanSub" id="txsTujuanSub" class="form-control select2-KompSubInventory">
													<option value=""></option>
												</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px ">
										<div class="col-md-2">
											<label class="control-label">Locator</label>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														From
													</div>
												<select name="txsAsalLocator" id="txsAsalLocator" class="form-control select2-KompAsalLocator">
													<option value=""></option>
												</select>
												</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														To
													</div>
												<select name="txsTujuanLocator" id="txsTujuanLocator" class="form-control select2-KompTujuanLocator">
													<option value=""></option>
												</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px ">
										<div class="col-md-2">
											<label class="control-label">Komponen</label>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														Kode
													</div>
												<select name="txsKodeKomp" id="txsKodeKomp" class="form-control select2-KodeKomponen">
													<option value=""></option>
												</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														Nama
													</div>
													<input type="text" class="form-control" id="txtNamaKomponen" name="txtNamaKomponen" placeholder="[Nama Komponen]" readonly>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px ">
										<div class="col-md-2">
											<label class="control-label">Filter</label>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														Sort
													</div>
												<select name="txsSort" id="txsSort" class="form-control select2-Sorting">
													<option value=""></option>
													<option value="1">Asal Komp. + Kode Komp.</option>
													<option value="2">Asal Komp. + Boleh Kirim + Kode Komp.</option>
													<option value="3">Subinv. + Kode Komp.</option>
												</select>
												</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-addon">
														Laporan
													</div>
												<select name="txsJenisLaporan" id="txsJenisLaporan" class="form-control select2-JenisLap">
													<option value=""></option>
													<option value="1">Komp. boleh kirim</option>
													<option value="2">Komp. tdk boleh kirim</option>
												</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row" style="margin: 10px;vertical-align: middle">
										<div class="col-md-8">
										</div>
										<div class="col-md-3">
										</div>
										<div class="col-md-1">
											<!-- <span id="submit-filter-komponen" class="btn btn-primary pull-right" style="vertical-align: middle">
												SEARCH
											</span>  -->
											<input type="submit" value="SEARCH" class="btn btn-primary pull-right btn-sm"></input>
										</div>
									</div>
								</div>
							</form>
						</div>
					</fieldset>
					<fieldset class="row3" style="display:none;">
						<div class="box-body with-border">
							<div class="col-md-12">
								<table class="table table-bordered table-horvered table-striped" id="table_kirim_komponen" style="width:100%;font-size:12px;">
										<thead>
											<tr>
												<th rowspan="2">No.</th>
												<th rowspan="2">Kode Komp.</th>
												<th rowspan="2">Nama Komp.</th>
												<th rowspan="2">On Hand</th>
												<th rowspan="2">Qty Max</th>
												<th rowspan="2">Boleh Kirim</th>
												<th rowspan="2">Boleh/Tidak</th>
												<th colspan="2" style="text-align:center;">Handling</th>
												<th rowspan="2">Asal Komp.</th>
												<th rowspan="2">Lokasi</th>
												<th rowspan="2">Gudang</th>
											</tr>
											<tr>
												<th>Qty</th>
												<th>Sarana</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
								</table>
							</div>
							<div class="row" style="margin: 10px;vertical-align: middle">
								<div class="col-md-8">
								</div>
								<div class="col-md-3">
								</div>
								<div class="col-md-1">
									<span id="destroy_datatable" class="btn btn-primary pull-right btn-xs" style="vertical-align: middle">
										BACK
									</span>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</section>