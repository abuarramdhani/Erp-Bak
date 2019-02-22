<form method="post" action="<?php echo base_url('Monitoring/TrackingInvoice/btn_search') ?>">
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>Tracking Invoice</b></span>
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
												<div class="col-md-6">
													<table>
														<tr>
															<td><label>Nama Vendor</label></td>
															<td>
																<select id="nama_vendor"  name="nama_vendor" class="form-control select2" style="width: 100%">
																<option></option>
																<?php foreach ($getVendorName as $name) { ?>
																<option><?php echo $name['VENDOR_NAME'] ?></option>
																<?php } ?>
																</select>
															</td>
														</tr>
														<tr>
															<td><label>Nomor PO **</label></td>
															<td>
																<input type="text" class="form-control" name="po_number" id="po_number" style="margin: 5px" size="30" value="%">
															</td>
														</tr>
														<tr>
															<td><label>Keyword Lain</label></td>
															<td>
																<input type="text" class="form-control" name="any_keyword" id="any_keyword" style="margin: 5px" size="30" >
															</td>
														</tr>
													</table>
												</div>
												<div class="col-md-6">
													<table>
														<tr>
															<td><label>Nomor Invoice</label></td>
															<td>
																<input type="text" class="form-control" name="invoice_number" id="invoice_number" style="margin: 5px" size="30" >
															</td>
														</tr>
														<tr>
															<td><label>Tanggal Invoice</label></td>
															<td>
																<input type="text" class="form-control invoice_date" name="invoice_date" id="invoice_date" style="margin: 5px" size="30">
															</td>
														</tr>
													</table>
													<div class="pull-left">
														* Dalam Pengembangan<br>
														** Gunakan <strong>%</strong> untuk pencarian wildcard
													</div><div class="pull-right">
														<button type="button" class="btn btn-primary" id="btn_search_invoice">Search</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="loading_invoice">
									<table id="tabel_search_tracking_invoice"></table>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</form>