<form method="post" action="<?php echo base_url('TrackingLppb/btn_search') ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Tracking LPPB</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<div class="box box-primary box-solid">
									<div class="box-body">
										<div class="box-header with-border">
										Kriteria Pencarian
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="col-md-8">
													<table>
														<tr>
															<td><label>Nama Vendor</label></td>
															<td>
																<select id="nama_vendor"  name="nama_vendor" class="form-control select2" style="width: 100%">
																<option></option>
																<?php foreach ($vendor_name as $name) { ?>
																<option><?php echo $name['VENDOR_NAME'] ?></option>
																<?php } ?>
																</select>
															</td>
														</tr>
														<tr>
															<td><label>Nomor LPPB</label></td>
															<td>
																<input type="text" class="form-control" name="nomor_lppb" id="nomor_lppb" style="margin: 5px" size="30" value="%">
															</td>
														</tr>
														<tr>
															<td><label>Tanggal LPPB</label></td>
															<td>
																<input type="text" class="form-control dateFromAndTo" name="dateFrom" id="dateFrom" style="margin: 5px" size="30">
															</td>
															<td>&nbsp; &nbsp; s/d</td>
															<td>
																<input type="text" class="form-control dateFromAndTo" name="dateTo" id="dateTo" style="margin: 5px" size="30">
															</td>
														</tr>
													</table>
													<div class="col-md-3 pull-right">
														<button type="button" class="btn btn-primary" id="btn_search_lppb">Search</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="loading_lppb">
									<table id="tabel_search_tracking_lppb"></table>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>